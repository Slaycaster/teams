/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Denimar
 */

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import javax.swing.*;
import java.sql.*;
import java.awt.image.BufferedImage;
import javax.imageio.ImageIO;
import java.io.IOException;
import java.net.URI;
 import java.net.URL;
import net.proteanit.sql.DbUtils;

import com.digitalpersona.onetouch.*;
import com.digitalpersona.onetouch.capture.DPFPCapture;
import com.digitalpersona.onetouch.capture.DPFPCapturePriority;
import com.digitalpersona.onetouch.capture.event.DPFPDataAdapter;
import com.digitalpersona.onetouch.capture.event.DPFPDataEvent;
import com.digitalpersona.onetouch.capture.event.DPFPDataListener;
import com.digitalpersona.onetouch.capture.event.DPFPReaderStatusAdapter;
import com.digitalpersona.onetouch.capture.event.DPFPReaderStatusEvent;
import com.digitalpersona.onetouch.processing.DPFPEnrollment;
import com.digitalpersona.onetouch.processing.DPFPFeatureExtraction;
import com.digitalpersona.onetouch.processing.DPFPImageQualityException;
import com.digitalpersona.onetouch.readers.DPFPReaderDescription;
import com.digitalpersona.onetouch.readers.DPFPReadersCollection;
import com.digitalpersona.onetouch.verification.DPFPVerification;
import com.digitalpersona.onetouch.verification.DPFPVerificationResult;
import java.applet.*;
import java.awt.*;
import java.awt.event.*;
import java.io.*;
import java.util.*;
import javax.swing.ImageIcon;

public class FingerprintEnroll extends javax.swing.JFrame{

    /**
     * Creates new form FingerprintEnroll
     */
    DPFPCapture capturer = DPFPGlobal.getCaptureFactory().createCapture();
    DPFPEnrollment enroller = DPFPGlobal.getEnrollmentFactory().createEnrollment();
    DPFPTemplate template = null;
    
    ResultSet rs = null;
    PreparedStatement pst = null;
    Connection conn = null;
    int registerUpdate = 0;
    int startcap = 0;
    String user_id ="";
    
    public FingerprintEnroll() {
        initComponents();

                    capturer.addDataListener(new DPFPDataAdapter() {
                        public void dataAcquired(final DPFPDataEvent e) {
                            log.append("The fingerprint sample was captured.\n");
                            prompt.setText("Scan the same fingerprint again.");
                            process(e.getSample());
                        }
                    });
                    
                    //Check if the fingerprint scanner is connected/disconnected.
                    capturer.addReaderStatusListener(new DPFPReaderStatusAdapter() {
                        public void readerConnected (final DPFPReaderStatusEvent e) {
                            log.append("Fingerprint connected.\n");
                        }
                        public void readerDisconnected (final DPFPReaderStatusEvent e) {
                            prompt.setText("Fingerprint disconnected.\n");
                        }
                    });
                  cn();  
    }
    
    protected Connection cn() 
    {
	try 
        { 
            Class.forName("com.mysql.jdbc.Driver");
            conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/teams_db", "root", "");
            FillTable();
	} 
        catch(Exception e) 
        { 
            System.out.println(e); 
        }
	return conn;
    }
    
    private void FillTable()
    {
        try
        {
            String sql = "";
            if(registerUpdate == 0)
            {
                sql = "select e.employee_number, e.lname, e.fname , d.name, b.branch_name, e.picture_path from employs AS e, departments as d, branches as b WHERE e.department_id = d.id AND d.branch_id = b.id AND fingerprint IS NULL";
            } 
            else
            {
                sql = "select e.employee_number, e.lname, e.fname , d.name, b.branch_name, e.picture_path from employs AS e, departments as d, branches as b WHERE e.department_id = d.id AND d.branch_id = b.id AND fingerprint IS NOT NULL";
            }
            pst = conn.prepareStatement(sql);
            rs = pst.executeQuery();
            employees.setModel(DbUtils.resultSetToTableModel(rs));
            
            employees.getColumnModel().getColumn(5).setMinWidth(0);
            employees.getColumnModel().getColumn(5).setMaxWidth(0);
        }
        catch(Exception e)
        {
            System.out.println(e.getMessage());
        }
        
    }
    
    protected void insert(String id, byte[] digital)
    {
        PreparedStatement st;
        try
        {
            st = cn().prepareStatement("UPDATE employs SET fingerprint=? WHERE employee_number=?");
            st.setBytes(1, digital);
            st.setString(2, id);
            st.executeUpdate();
            log.append("Succesfully inserted to database!");
        }
        catch (SQLException e)
        {
            System.out.println(e.getMessage());
        }
    }
        
    protected void process (DPFPSample sample)
    {
        //Draw fingerprint sample image.
        drawPicture(convertSampleToBitmap(sample));
        
        // Process the sample and create a feature set for the enrollment purpose.
	DPFPFeatureSet features = extractFeatures(sample, DPFPDataPurpose.DATA_PURPOSE_ENROLLMENT);
        
        if (features != null)
            try
            {
                log.append("The fingerprint feature set was created.\n");
                enroller.addFeatures(features);
            }
            catch (DPFPImageQualityException ex) { }
            finally
            {
                updateStatus();
                
                //Check if template has been created.
                switch(enroller.getTemplateStatus())
                {
                    case TEMPLATE_STATUS_READY: //report success and stop capturing
                        stopCapturing();
                        log.append("Fingerprint enrollment FINISHED.\n");
                        status.setText("");
                        template = enroller.getTemplate();
                        byte [] b = template.serialize(); //Serialize fingerprint to save it to database
                        insert(user_id, b);
                        break;
                    case TEMPLATE_STATUS_FAILED: //report failure and restart capturing
                        enroller.clear();
                        stopCapturing();
                        updateStatus();
                        log.setText("The fingerprint template is not valid. Repeat fingerprint enrollment.");
                        startCapturing();
                        break;
                }
            }
    }
    
    public void drawPicture(Image image) 
    {
	picture.setIcon(new ImageIcon(
		image.getScaledInstance(picture.getWidth(), picture.getHeight(), Image.SCALE_DEFAULT)));
    }
    
    public void drawPicture2(String pic_path) 
    {
        try{       
        
        BufferedImage image = ImageIO.read(URI.create("http://localhost/teams/public/"+pic_path).toURL());
        
	employeepic.setIcon(new ImageIcon(
		image.getScaledInstance(employeepic.getWidth(), employeepic.getHeight(), Image.SCALE_DEFAULT)));
        }
        catch(Exception e)
        {
            System.out.println(e.getMessage());
        }
    }
    
    
    
    
    protected Image convertSampleToBitmap(DPFPSample sample) {
	return DPFPGlobal.getSampleConversionFactory().createImage(sample);
    }
    
    protected DPFPFeatureSet extractFeatures(DPFPSample sample, DPFPDataPurpose purpose)
    {
	DPFPFeatureExtraction extractor = DPFPGlobal.getFeatureExtractionFactory().createFeatureExtraction();
	try {
		return extractor.createFeatureSet(sample, purpose);
	} catch (DPFPImageQualityException e) {
		return null;
	}
    }
    
    protected void startCapturing()
    {
            capturer.startCapture();
            log.append("Using the fingerprint reader, scan your fingerprint.\n");       
    }
    
    protected void stopCapturing()
    {
        capturer.stopCapture();
        startcap=0;
    }
    
    protected void updateStatus()
    {
        // Show number of samples needed.
        status.setText(String.format("Fingerprint samples needed: %1$s", enroller.getFeaturesNeeded()));
    }


    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jScrollPane3 = new javax.swing.JScrollPane();
        jTable1 = new javax.swing.JTable();
        jLabel1 = new javax.swing.JLabel();
        picture = new javax.swing.JLabel();
        status = new javax.swing.JTextField();
        prompt = new javax.swing.JTextField();
        jScrollPane1 = new javax.swing.JScrollPane();
        log = new javax.swing.JTextArea();
        register = new javax.swing.JButton();
        update = new javax.swing.JButton();
        employeepic = new javax.swing.JLabel();
        jScrollPane4 = new javax.swing.JScrollPane();
        employees = new javax.swing.JTable();
        emp_name = new javax.swing.JLabel();
        bio_stat = new javax.swing.JLabel();
        capture_btn = new javax.swing.JButton();

        jTable1.setModel(new javax.swing.table.DefaultTableModel(
            new Object [][] {
                {null, null, null, null},
                {null, null, null, null},
                {null, null, null, null},
                {null, null, null, null}
            },
            new String [] {
                "Title 1", "Title 2", "Title 3", "Title 4"
            }
        ));
        jScrollPane3.setViewportView(jTable1);

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        jLabel1.setText("Scan your fingerprint to continue.");

        status.setEditable(false);
        status.setText("status");

        prompt.setEditable(false);
        prompt.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                promptActionPerformed(evt);
            }
        });

        log.setEditable(false);
        log.setColumns(20);
        log.setRows(5);
        jScrollPane1.setViewportView(log);

        register.setText("Register");
        register.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                registerActionPerformed(evt);
            }
        });

        update.setText("Update");
        update.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                updateActionPerformed(evt);
            }
        });

        employees.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent evt) {
                employeesMouseClicked(evt);
            }
        });
        jScrollPane4.setViewportView(employees);

        capture_btn.setText("START CAPTURING");
        capture_btn.setEnabled(false);
        capture_btn.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent evt) {
                capture_btnMouseClicked(evt);
            }
        });

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING)
                            .addComponent(prompt, javax.swing.GroupLayout.Alignment.LEADING)
                            .addComponent(status, javax.swing.GroupLayout.Alignment.LEADING)
                            .addGroup(javax.swing.GroupLayout.Alignment.LEADING, layout.createSequentialGroup()
                                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING, false)
                                    .addComponent(picture, javax.swing.GroupLayout.Alignment.LEADING, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                                    .addComponent(jLabel1, javax.swing.GroupLayout.Alignment.LEADING, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                                .addGap(0, 0, Short.MAX_VALUE)))
                        .addGap(18, 18, 18))
                    .addGroup(layout.createSequentialGroup()
                        .addGap(8, 8, 8)
                        .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addComponent(emp_name, javax.swing.GroupLayout.PREFERRED_SIZE, 182, javax.swing.GroupLayout.PREFERRED_SIZE)
                            .addComponent(employeepic, javax.swing.GroupLayout.PREFERRED_SIZE, 155, javax.swing.GroupLayout.PREFERRED_SIZE)
                            .addComponent(bio_stat, javax.swing.GroupLayout.PREFERRED_SIZE, 190, javax.swing.GroupLayout.PREFERRED_SIZE))
                        .addGap(33, 33, 33)))
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addComponent(capture_btn, javax.swing.GroupLayout.PREFERRED_SIZE, 126, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addGap(168, 168, 168)
                        .addComponent(register)
                        .addGap(18, 18, 18)
                        .addComponent(update))
                    .addComponent(jScrollPane4, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(jScrollPane1, javax.swing.GroupLayout.PREFERRED_SIZE, 449, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addContainerGap())
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(employeepic, javax.swing.GroupLayout.PREFERRED_SIZE, 175, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(jScrollPane4, javax.swing.GroupLayout.Alignment.TRAILING, javax.swing.GroupLayout.PREFERRED_SIZE, 175, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                        .addComponent(register)
                        .addComponent(update)
                        .addComponent(capture_btn, javax.swing.GroupLayout.PREFERRED_SIZE, 40, javax.swing.GroupLayout.PREFERRED_SIZE))
                    .addComponent(emp_name, javax.swing.GroupLayout.PREFERRED_SIZE, 26, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(bio_stat, javax.swing.GroupLayout.PREFERRED_SIZE, 20, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(18, 18, 18)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addComponent(prompt, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                        .addComponent(jLabel1, javax.swing.GroupLayout.PREFERRED_SIZE, 9, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                        .addComponent(picture, javax.swing.GroupLayout.PREFERRED_SIZE, 150, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                        .addComponent(status, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
                    .addComponent(jScrollPane1, javax.swing.GroupLayout.PREFERRED_SIZE, 238, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addContainerGap())
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    private void promptActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_promptActionPerformed
        // TODO add your handling code here:
    }//GEN-LAST:event_promptActionPerformed

    private void registerActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_registerActionPerformed
        
        // TODO add your handling code here:
        registerUpdate = 0;
        cn();
       
    }//GEN-LAST:event_registerActionPerformed

    private void updateActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_updateActionPerformed
        // TODO add your handling code here:
        registerUpdate = 1;
        cn();
    }//GEN-LAST:event_updateActionPerformed

    private void employeesMouseClicked(java.awt.event.MouseEvent evt) {//GEN-FIRST:event_employeesMouseClicked
        // TODO add your handling code here:
        
        capture_btn.setEnabled(true);
        try 
        {
            int row = employees.getSelectedRow();
            
            user_id = (employees.getModel().getValueAt(row, 0).toString());
            String lname = (employees.getModel().getValueAt(row, 1).toString());
            String fname = (employees.getModel().getValueAt(row, 2).toString());
            String department = (employees.getModel().getValueAt(row, 3).toString());
            String branch = (employees.getModel().getValueAt(row, 4).toString());
            String pic_path = (employees.getModel().getValueAt(row, 5).toString());
            
            emp_name.setText("Employee Name: "+lname+", "+fname);
            
            if(registerUpdate == 0)
            {
                 bio_stat.setText("Biometrics Info: Not Registered");
            }
            else
            {
                bio_stat.setText("Biometrics Info: Registered");
            }
            
            drawPicture2(pic_path);
            
        } 
        catch (Exception e) 
        {
            System.out.println(e.getMessage());
        }
    }//GEN-LAST:event_employeesMouseClicked

    private void capture_btnMouseClicked(java.awt.event.MouseEvent evt) {//GEN-FIRST:event_capture_btnMouseClicked
        // TODO add your handling code here:
        startCapturing();
    }//GEN-LAST:event_capture_btnMouseClicked

    /**
     * @param args the command line arguments
     */
    public static void main(String args[]) {
        /* Set the Nimbus look and feel */
        //<editor-fold defaultstate="collapsed" desc=" Look and feel setting code (optional) ">
        /* If Nimbus (introduced in Java SE 6) is not available, stay with the default look and feel.
         * For details see http://download.oracle.com/javase/tutorial/uiswing/lookandfeel/plaf.html 
         */
        try {
            for (javax.swing.UIManager.LookAndFeelInfo info : javax.swing.UIManager.getInstalledLookAndFeels()) {
                if ("Nimbus".equals(info.getName())) {
                    javax.swing.UIManager.setLookAndFeel(info.getClassName());
                    break;
                }
            }
        } catch (ClassNotFoundException ex) {
            java.util.logging.Logger.getLogger(FingerprintEnroll.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (InstantiationException ex) {
            java.util.logging.Logger.getLogger(FingerprintEnroll.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            java.util.logging.Logger.getLogger(FingerprintEnroll.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (javax.swing.UnsupportedLookAndFeelException ex) {
            java.util.logging.Logger.getLogger(FingerprintEnroll.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
        //</editor-fold>

        /* Create and display the form */
        java.awt.EventQueue.invokeLater(new Runnable() {
           
            public void run() {
                new FingerprintEnroll().setVisible(true);
            }
        });
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JLabel bio_stat;
    private javax.swing.JButton capture_btn;
    private javax.swing.JLabel emp_name;
    private javax.swing.JLabel employeepic;
    private javax.swing.JTable employees;
    private javax.swing.JLabel jLabel1;
    private javax.swing.JScrollPane jScrollPane1;
    private javax.swing.JScrollPane jScrollPane3;
    private javax.swing.JScrollPane jScrollPane4;
    private javax.swing.JTable jTable1;
    private javax.swing.JTextArea log;
    private javax.swing.JLabel picture;
    private javax.swing.JTextField prompt;
    private javax.swing.JButton register;
    private javax.swing.JTextField status;
    private javax.swing.JButton update;
    // End of variables declaration//GEN-END:variables
}
