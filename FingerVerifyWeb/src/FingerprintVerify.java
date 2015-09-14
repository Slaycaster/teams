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
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.awt.image.BufferedImage;
import javax.imageio.ImageIO;
import java.io.IOException;
import java.net.URI;
import java.net.URL;
import java.util.Date;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;

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
import java.awt.image.BufferedImage;
import java.io.*;
import java.net.URI;
import java.util.*;
import javax.imageio.ImageIO;
import javax.swing.ImageIcon;

public class FingerprintVerify extends javax.swing.JFrame {

    /**
     * Creates new form FingerprintVerify
     */
    static DPFPCapture capturer = DPFPGlobal.getCaptureFactory().createCapture();
    static DPFPEnrollment enroller = DPFPGlobal.getEnrollmentFactory().createEnrollment();
    static private DPFPVerification verificator = DPFPGlobal.getVerificationFactory().createVerification();
    static DPFPTemplate template = null;
    public static int user_id = 15; //Temporary user_id for dev purposes. PANG INSERT
    
    
    ResultSet rs = null;
    PreparedStatement pst = null;
    Connection conn = null;
    
    public FingerprintVerify() {
        initComponents();
        
                    capturer.addDataListener(new DPFPDataAdapter() {
                        public void dataAcquired(final DPFPDataEvent e) {
                            
                            process(e.getSample());
                        }
                    });
                    
                    //Check if the fingerprint scanner is connected/disconnected.
                    capturer.addReaderStatusListener(new DPFPReaderStatusAdapter() {
                        public void readerConnected (final DPFPReaderStatusEvent e) {
                            
                        }
                        public void readerDisconnected (final DPFPReaderStatusEvent e) {
                            status.setText("Biometrics scanner device disconnected");
                        }
                    });
                    startCapturing();
                    
    }
    
    protected Connection cn() 
    {
	try 
        { 
            Class.forName("com.mysql.jdbc.Driver");
            conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/teams_db", "root", "");
	} 
        catch(Exception e) 
        { 
            System.out.println(e); 
        }
	return conn;
    }
    
    protected void insert(int id)
    {
        PreparedStatement st;
        
        
        java.util.Date dt = new java.util.Date();

        java.text.SimpleDateFormat sdf = new java.text.SimpleDateFormat("hh:mm:ss");
        java.text.SimpleDateFormat sdf2 = new java.text.SimpleDateFormat("yyyy-MM-dd");

        String currentTime = sdf.format(dt);
        String currentDate = sdf2.format(dt);
        
       try
        {
            st = cn().prepareStatement("insert into punches(date, time, employee_id) values  (?, ?, ?)");
            st.setString(1, currentDate);
            st.setString(2, currentTime);
            st.setInt(3, id);
            st.executeUpdate();
            
        }
        catch (SQLException e)
        {
            System.out.println(e.getMessage());
        }
      
    }
    
    protected byte[] get()
    {
        ResultSet rs;
        PreparedStatement st;
        byte[] digital = null;
        try
        {
            st = cn().prepareStatement("SELECT * FROM employs WHERE id = 3");
            rs = st.executeQuery();
            if(rs.next())
                digital = rs.getBytes("fingerprint");
            else
                System.out.println("Record not available");
        }
        catch (Exception e)
        {
            System.out.println(e.getMessage());
        }
        System.out.println("Fingerprint successfully retrieved from database.");
        return digital;
    }
    
   
        
    protected void process (DPFPSample sample)
    {
        //Draw fingerprint sample image.
        drawPicture(convertSampleToBitmap(sample));
        // Process the sample and create a feature set for the verification purpose.
	DPFPFeatureSet features = extractFeatures(sample, DPFPDataPurpose.DATA_PURPOSE_VERIFICATION); 
        DPFPTemplate temp2 = DPFPGlobal.getTemplateFactory().createTemplate();
        byte[] b = null;
        int id = 0;
        String name = "";
        String pic_path = "";
        PreparedStatement pre = null;
        ResultSet res = null;
        
        Calendar calendar = Calendar.getInstance();
        int dayOfWeek = calendar.get(Calendar.DAY_OF_WEEK);
        
        
        
        if (features != null)
        {
            try
            {
                pre = cn().prepareStatement("select * from employs");
                res = pre.executeQuery();
                
                
                while(res.next())
                {
                    if(res.getBytes("fingerprint")!= null)
                    {
                        b = res.getBytes("fingerprint");
                        temp2.deserialize(b);
                        //Compare the feature set with the template got from database
                        DPFPVerificationResult result = verificator.verify(features, temp2);
                        updateStatus(result.getFalseAcceptRate());
                        if (result.isVerified())
                        {
                            id = res.getInt("id");
                            name = res.getString("lname") + ", " + res.getString("fname") +"\n";
                            pic_path = res.getString("picture_path");
                       
                        }   
                    } 
                }
                if(id != 0)
                {
                    status.setText("Employee Identified!");
                    emp_name.setText(name);
                    drawPicture2(pic_path);
                    insert(id);
                    
                    System.out.println(dayOfWeek);
                    
                }
                if(id == 0)
                {
                    status.setText("Unidentified Biometrics info");
                }
            }
            catch(Exception e)
            {
               System.out.println(e.getMessage());
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
    }
    
    protected void stopCapturing()
    {
        capturer.stopCapture();
    }
    
    protected void updateStatus(int FAR)
    {
        // Show number of samples needed.
    }

    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        status = new javax.swing.JLabel();
        picture = new javax.swing.JLabel();
        employeepic = new javax.swing.JLabel();
        emp_name = new javax.swing.JLabel();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        status.setFont(new java.awt.Font("Segoe UI Light", 1, 18)); // NOI18N
        status.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        status.setText("Scan your finger to the Biometrics Device to Time-In");

        emp_name.setFont(new java.awt.Font("Segoe UI Light", 1, 24)); // NOI18N
        emp_name.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addGap(183, 183, 183)
                        .addComponent(employeepic, javax.swing.GroupLayout.PREFERRED_SIZE, 195, javax.swing.GroupLayout.PREFERRED_SIZE))
                    .addGroup(layout.createSequentialGroup()
                        .addGap(248, 248, 248)
                        .addComponent(picture, javax.swing.GroupLayout.PREFERRED_SIZE, 53, javax.swing.GroupLayout.PREFERRED_SIZE)))
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, layout.createSequentialGroup()
                .addContainerGap(60, Short.MAX_VALUE)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(status, javax.swing.GroupLayout.PREFERRED_SIZE, 470, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(emp_name, javax.swing.GroupLayout.PREFERRED_SIZE, 457, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addGap(70, 70, 70))
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGap(16, 16, 16)
                .addComponent(status, javax.swing.GroupLayout.PREFERRED_SIZE, 50, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addComponent(employeepic, javax.swing.GroupLayout.PREFERRED_SIZE, 190, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(11, 11, 11)
                .addComponent(picture, javax.swing.GroupLayout.PREFERRED_SIZE, 51, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(emp_name, javax.swing.GroupLayout.PREFERRED_SIZE, 40, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap(42, Short.MAX_VALUE))
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

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
            java.util.logging.Logger.getLogger(FingerprintVerify.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (InstantiationException ex) {
            java.util.logging.Logger.getLogger(FingerprintVerify.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            java.util.logging.Logger.getLogger(FingerprintVerify.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (javax.swing.UnsupportedLookAndFeelException ex) {
            java.util.logging.Logger.getLogger(FingerprintVerify.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
        //</editor-fold>

        /* Create and display the form */
        java.awt.EventQueue.invokeLater(new Runnable() {
            public void run() {
                new FingerprintVerify().setVisible(true);
            }
        });
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JLabel emp_name;
    private javax.swing.JLabel employeepic;
    private javax.swing.JLabel picture;
    private javax.swing.JLabel status;
    // End of variables declaration//GEN-END:variables
}
