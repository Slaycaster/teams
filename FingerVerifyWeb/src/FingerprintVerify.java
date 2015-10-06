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
import org.joda.time.*;
import org.joda.time.format.*;
import java.util.Timer;

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
    public static int confirmation = 0;
    public static int confirmationchecker = 0;
    Timer timer = new Timer();
    
    
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
        PreparedStatement st; //insert punches
        PreparedStatement pre2 = null; //checksched
        PreparedStatement pre3 = null; //check if timed in
        PreparedStatement pre4 = null; // check policy if late
        PreparedStatement pre5 = null; // check if break config
        PreparedStatement pre6 = null; // check if break in already
        PreparedStatement pre7 = null; // check scheduled break
        PreparedStatement pre8 = null; // check break in policy
        PreparedStatement pre9 = null; // check if break out already
        PreparedStatement pre10 = null; // check break out policy
        PreparedStatement pre11 = null; // check if time out already
        PreparedStatement pre12 = null; // check time out policy
        PreparedStatement pre13 = null; // check if there's an assigned policy
        PreparedStatement pre14 = null; // check if absent already
        PreparedStatement preins = null; // insert punchstatus
        
        ResultSet rs = null; //insert punches
        ResultSet res2 = null; //checksched
        ResultSet res3 = null; //check if timed in
        ResultSet res4 = null; // check policy if late
        ResultSet res5 = null; // check if break config
        ResultSet res6 = null; // check if break in already
        ResultSet res7 = null; // check scheduled break
        ResultSet res8 = null; // check break in policy
        ResultSet res9 = null; // check if break out already
        ResultSet res10 = null; //check break out policy
        ResultSet res11 = null; //check if time out already
        ResultSet res12 = null; //check time out policy
        ResultSet res13 = null; //check if there's an assigned policy
        ResultSet res14 = null; // check if absent already
        ResultSet resins = null; // insert punchstatus
        
        String in = ""; //get in for the current day
        String out = ""; //get out for the current day
        
        timer.cancel();
        
        int punch_id = 0;
        
        Calendar calendar = Calendar.getInstance();
        int dayOfWeek = calendar.get(Calendar.DAY_OF_WEEK);
        String currentdaytext = "";
        LocalTime currenttime = LocalTime.now();
        
        
        java.util.Date dt = new java.util.Date();

        java.text.SimpleDateFormat sdf = new java.text.SimpleDateFormat("hh:mm:ss");
        java.text.SimpleDateFormat sdf2 = new java.text.SimpleDateFormat("yyyy-MM-dd");
        java.text.SimpleDateFormat sdf3 = new java.text.SimpleDateFormat("hh:mm:ss a");

        String currentTime = sdf.format(dt);
        String currentDate = sdf2.format(dt);
        String timenow = sdf3.format(dt);
        
        
        try
        {
            st = cn().prepareStatement("insert into punches(date, time, employee_id) values  (?, ?, ?)");
            st.setString(1, currentDate);
            st.setString(2, currentTime);
            st.setInt(3, id);
            st.executeUpdate();
            st = cn().prepareStatement("select id from punches where date = ? AND time = ? AND employee_id = ? ");
            st.setString(1, currentDate);
            st.setString(2, currentTime);
            st.setInt(3, id);
            rs = st.executeQuery();
            
            
            
            if(rs.next())
            {
                punch_id = rs.getInt("id");
                
            
            
                    if(dayOfWeek == 1)
                    {
                        pre2 = cn().prepareStatement("select schedules.id, sun_timein , sun_timeout from schedules, empschedules where schedules.id = empschedules.schedule_id AND empschedules.employee_id = ?");
                        in = "sun_timein";
                        out= "sun_timeout";
                        currentdaytext = "Sunday";
                    }
                    else if(dayOfWeek == 2)
                    {
                        pre2 = cn().prepareStatement("select schedules.id, m_timein , m_timeout from schedules, empschedules where schedules.id = empschedules.schedule_id AND empschedules.employee_id = ?");
                        in = "m_timein";
                        out= "m_timeout";
                        currentdaytext = "Monday";
                    }
                    else if(dayOfWeek == 3)
                    {
                        pre2 = cn().prepareStatement("select schedules.id, t_timein , t_timeout from schedules, empschedules where schedules.id = empschedules.schedule_id AND empschedules.employee_id = ?");
                        in = "t_timein";
                        out= "t_timeout";
                        currentdaytext = "Tuesday";
                    }
                    else if(dayOfWeek == 4)
                    {
                        pre2 = cn().prepareStatement("select schedules.id, w_timein , w_timeout from schedules, empschedules where schedules.id = empschedules.schedule_id AND empschedules.employee_id = ?");
                        in = "w_timein";
                        out= "w_timeout";
                        currentdaytext = "Wednesday";
                    }
                    else if(dayOfWeek == 5)
                    {
                        pre2 = cn().prepareStatement("select schedules.id, th_timein , th_timeout from schedules, empschedules where schedules.id = empschedules.schedule_id AND empschedules.employee_id = ?");
                        in = "th_timein";
                        out= "th_timeout";
                        currentdaytext = "Thursday";
                    }
                    else if(dayOfWeek == 6)
                    {
                        pre2 = cn().prepareStatement("select schedules.id, f_timein , f_timeout from schedules, empschedules where schedules.id = empschedules.schedule_id AND empschedules.employee_id = ?");
                        in = "f_timein";
                        out= "f_timeout";
                        currentdaytext = "Friday";
                    }
                    else if(dayOfWeek == 7)
                    {
                        pre2 = cn().prepareStatement("select schedules.id, sat_timein , sat_timeout from schedules, empschedules where schedules.id = empschedules.schedule_id AND empschedules.employee_id = ?");
                        in = "sat_timein";
                        out= "sat_timeout";
                        currentdaytext = "Saturday";
                    }
                    pre2.setInt(1, id);        
                    res2 = pre2.executeQuery();
                    SimpleDateFormat parser = new SimpleDateFormat("HH:mm:ss");
                    Date time = parser.parse("00:00:00");
                    LocalDate date = LocalDate.now();
                    DateTimeFormatter formatter = DateTimeFormat.forPattern("yyyy-MM-dd");
                    String currentdate = formatter.print(date);
                    
                    
                    /*
                    if(res2.next())
                    {
                        String test = res2.getTime(in).toString();
                        String test2 = res2.getTime(out).toString();
                        System.out.println(test);
                        System.out.println(test2);
                    }  */   
                    
                    if(res2.next())
                    {
                        pre12= cn().prepareStatement("select id from policygroup_employees as pe where pe.employee_id = ?");
                        pre12.setInt(1, id);
                        res12 = pre12.executeQuery();
                            
                        if(res12.next())
                        { //theres an assigned policy
                            
                        if (res2.getTime(in) != null && (res2.getTime(in).equals(time) != true) && res2.getTime(out) != null && (res2.getTime(out).equals(time)!= true))
                        {   //scheduled
                            System.out.println("test");
                            pre3 = cn().prepareStatement("select punchstatus.id, time_in from punchstatus, punches where punchstatus.employee_id = ? AND  punchstatus.date = ?");
                            pre3.setInt(1, id);
                            pre3.setString(2, currentdate);
                            res3 = pre3.executeQuery();
                            
                            
                            if(res3.next())
                            {   
                                    //time in not empty
                                if("On-time".equalsIgnoreCase(res3.getString("time_in")) || "Late".equalsIgnoreCase(res3.getString("time_in")) ||  "Early".equalsIgnoreCase(res3.getString("time_in")) )
                                {   
                                    pre7 = cn().prepareStatement("select break_in, break_out from breaks where schedule_id =? AND day = ?");
                                    pre7.setInt(1, res2.getInt("schedules.id"));
                                    pre7.setString(2, currentdaytext);
                                    res7 = pre7.executeQuery();
                                    
                                    if(res7.next())
                                    {   
                                        //there's a break scheduled
                                        pre5 = cn().prepareStatement("select require_break_punches from schedules ,empschedules where empschedules.employee_id = ? AND empschedules.schedule_id = schedules.id ");
                                        pre5.setInt(1, id);                                   
                                        res5 = pre5.executeQuery();
                                        
                                        if(res5.next())
                                        {   
                                            //break punches required
                                            pre6 = cn().prepareStatement("select break_in from punchstatus where id = ? AND break_in IS NOT NULL");
                                            pre6.setInt(1, res3.getInt("punchstatus.id"));
                                            res6 = pre6.executeQuery(); 
                                            
                                            if(res6.next())
                                            {   
                                                //break in already
                                                pre9 = cn().prepareStatement("select break_out from punchstatus where id = ? AND break_out IS NOT NULL");
                                                pre9.setInt(1, res3.getInt("punchstatus.id"));
                                                res9 = pre9.executeQuery();
                                                
                                                if(res9.next())
                                                {
                                                    //break out already
                                                    pre11= cn().prepareStatement("select time_out from punchstatus where id = ? AND time_out IS NOT NULL");
                                                    pre11.setInt(1, res3.getInt("punchstatus.id"));
                                                    res11 = pre11.executeQuery();
                                                    
                                                    if(res11.next())
                                                    {
                                                        
                                                        //time-out already
                                                        //shift ended
                                                        lbl_punchstatus.setText("UNSCHEDULED / SHIFT ENDED");
                                                        lbl_time.setText(timenow);
                                                        
                                                    }
                                                    else
                                                    {   
                                                        //no time-out yet
                                                        pre12 = cn().prepareStatement("select grace, watch_window from assign_exceptions as ae, policygroup_employees as pe where ? = pe.employee_id AND pe.policygroup_id = ae.group_id AND ae.id = 14");
                                                        pre12.setInt(1, id);
                                                        res12 = pre12.executeQuery();
                                                        
                                                        if(res12.next())
                                                        {   
                                                            LocalTime scheduledtimeout = new LocalTime(res2.getTime(out));
                                                            LocalTime timeoutingrace = new LocalTime(res12.getTime("grace"));
                                                            LocalTime timeoutinwatchwindow = new LocalTime(res12.getTime("watch_window"));
                                                            LocalTime timeoutgrace = new LocalTime();
                                                            LocalTime timeoutwatchwindow = new LocalTime();
                                                            LocalTime timeoutgrace2 = new LocalTime();
                                                            timeoutwatchwindow = scheduledtimeout.plusHours(timeoutinwatchwindow.getHourOfDay());
                                                            timeoutwatchwindow = timeoutwatchwindow.plusMinutes(timeoutinwatchwindow.getMinuteOfHour());
                                                            timeoutgrace = scheduledtimeout.minusHours(timeoutingrace.getHourOfDay());
                                                            timeoutgrace = timeoutgrace.minusMinutes(timeoutingrace.getMinuteOfHour());
                                                            timeoutgrace2 = scheduledtimeout.plusHours(timeoutingrace.getHourOfDay());
                                                            timeoutgrace2 = timeoutgrace2.plusMinutes(timeoutingrace.getMinuteOfHour());
                                                            
                                                            if(currenttime.isBefore(timeoutgrace))
                                                            {
                                                                // early out
                                                                if(confirmation == 1 && confirmationchecker == id)
                                                                {
                                                                    preins = cn().prepareStatement("update punchstatus set time_out = 'early out', time_out_punch_id = ? where id = ?");
                                                                    preins.setInt(1, punch_id);
                                                                    preins.setInt(2, res3.getInt("id"));
                                                                    preins.executeUpdate();
                                                                    lbl_punchstatus.setText("Early OUT");
                                                                    lbl_time.setText(timenow);
                                                                    confirmation = 0; 
                                                                }
                                                                else
                                                                {
                                                                    lbl_punchstatus.setText("WARNING THIS WILL BE RECORDED AS AN EARLY-OUT");
                                                                    lbl_time.setText(timenow);
                                                                    confirmation = 1;
                                                                    confirmationchecker = id;
                                                                    timer = new Timer();
                                                                    timer.schedule(new TimerTask()
                                                                    {
                                                                        public void run() 
                                                                        {               
                                                                            confirmation = 0;
                                                                            confirmationchecker = 0;
                                                                            lbl_punchstatus.setText("");
                                                                            lbl_time.setText("");
                                                                            status.setText("Scan your finger to the Biometrics device to Time-in");
                                                                        }
                                                                    }, 15*1000);
                                                                }
                                                      
                                                            }
                                                            else if(currenttime.isAfter(timeoutgrace) && currenttime.isBefore(timeoutgrace2))
                                                            {
                                                                //on time out
                                                                preins = cn().prepareStatement("update punchstatus set time_out = 'On-time out', time_out_punch_id = ? where id = ?");
                                                                preins.setInt(1, punch_id);
                                                                preins.setInt(2, res3.getInt("id"));
                                                                preins.executeUpdate();
                                                                lbl_punchstatus.setText("On-time OUT");
                                                                lbl_time.setText(timenow);
                                                            }
                                                            else if(currenttime.isAfter(timeoutgrace2))
                                                            {
                                                                // late out
                                                                preins = cn().prepareStatement("update punchstatus set time_out = 'Late Out', time_out_punch_id = ? where id = ?");
                                                                preins.setInt(1, punch_id);
                                                                preins.setInt(2, res3.getInt("id"));
                                                                preins.executeUpdate();
                                                                lbl_punchstatus.setText("Late OUT");
                                                                lbl_time.setText(timenow);
                                                            }
                                                        }
                                                        else
                                                        {
                                                            //no policy for time-out
                                                            
                                                        }
                                                    }
                                                }
                                                else
                                                {   
                                                    //no break out yet
                                                    pre10 = cn().prepareStatement("select grace, watch_window from assign_exceptions as ae, policygroup_employees as pe where ? = pe.employee_id AND pe.policygroup_id = ae.group_id AND ae.id = 8 ");
                                                    pre10.setInt(1, id);
                                                    res10 = pre10.executeQuery();
                                                    
                                                    if(res10.next())
                                                    {   
                                                        LocalTime scheduledbreakout = new LocalTime(res7.getTime("break_out"));
                                                        LocalTime breakoutingrace = new LocalTime(res10.getTime("grace"));
                                                        LocalTime breakoutinwatchwindow = new LocalTime(res10.getTime("watch_window"));
                                                        LocalTime breakoutgrace = new LocalTime();
                                                        LocalTime breakoutwatchwindow = new LocalTime();
                                                        breakoutwatchwindow = scheduledbreakout.plusHours(breakoutinwatchwindow.getHourOfDay());
                                                        breakoutwatchwindow = breakoutwatchwindow.plusMinutes(breakoutinwatchwindow.getMinuteOfHour());
                                                        breakoutgrace = scheduledbreakout.plusHours(breakoutingrace.getHourOfDay());
                                                        breakoutgrace = breakoutgrace.plusMinutes(breakoutingrace.getMinuteOfHour());
                                                        
                                                        
                                                        if(currenttime.isAfter(breakoutgrace) && currenttime.isBefore(breakoutwatchwindow))
                                                        {     
                                                            preins = cn().prepareStatement("update punchstatus set break_out = 'long break', break_out_punch_id = ? where id = ?");
                                                            preins.setInt(1, punch_id);
                                                            preins.setInt(2, res3.getInt("id"));
                                                            preins.executeUpdate();
                                                            lbl_punchstatus.setText("Long Break");
                                                            lbl_time.setText(timenow);
                                                            
                                                        }
                                                        else if(currenttime.isBefore(breakoutgrace))
                                                        {   
                                                            preins = cn().prepareStatement("update punchstatus set break_out = 'On-time breakout', break_out_punch_id = ? where id = ?");
                                                            preins.setInt(1, punch_id);
                                                            preins.setInt(2, res3.getInt("id"));
                                                            preins.executeUpdate();
                                                            lbl_punchstatus.setText("On-time Break Out");
                                                            lbl_time.setText(timenow);
                                                        }
                                                    }
                                                    else
                                                    {
                                                        //no exception policy for break out
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                //no break in yet
                                                pre8 = cn().prepareStatement("select grace, watch_window from assign_exceptions as ae, policygroup_employees as pe where ? = pe.employee_id AND pe.policygroup_id = ae.group_id AND ae.id = 7");
                                                pre8.setInt(1, id);
                                                res8 = pre8.executeQuery();
                                                
                                                if(res8.next())
                                                {
                                                    LocalTime scheduledbreak = new LocalTime(res7.getTime("break_in"));
                                                    LocalTime breakingrace = new LocalTime(res8.getTime("grace"));
                                                    LocalTime breakgrace = new LocalTime();
                                                    breakgrace = scheduledbreak.minusHours(breakingrace.getHourOfDay());
                                                    breakgrace = breakgrace.minusMinutes(breakingrace.getMinuteOfHour());
                                                    //LocalTime currenttime = LocalTime.now();
                                                    if(currenttime.isBefore(breakgrace))
                                                    {
                                                        
                                                        if(confirmation == 1 && confirmationchecker == id)
                                                        {
                                                            preins = cn().prepareStatement("update punchstatus set break_in = 'early break', break_in_punch_id = ? where id = ?");
                                                            preins.setInt(1, punch_id);
                                                            preins.setInt(2, res3.getInt("id"));
                                                            preins.executeUpdate();
                                                            lbl_punchstatus.setText("Early Break");
                                                            lbl_time.setText(timenow);
                                                            confirmation = 0;
                                                        }
                                                        else
                                                        {
                                                            lbl_punchstatus.setText("Warning! this will be recorded as an EARLY-BREAK, Punch-in again to confirm");
                                                            lbl_time.setText(timenow);
                                                            confirmation = 1;
                                                            confirmationchecker = id;
                                                            timer = new Timer();
                                                            timer.schedule(new TimerTask()
                                                            {
                                                                public void run() 
                                                                {               
                                                                    confirmation = 0;
                                                                    confirmationchecker = 0;
                                                                    lbl_punchstatus.setText("");
                                                                    lbl_time.setText("");
                                                                    status.setText("Scan your finger to the Biometrics device to Time-in");
                                                                }
                                                            }, 15*1000);
                                                        }
                                                    }
                                                    else if(currenttime.isAfter(breakgrace))
                                                    {
                                                        preins = cn().prepareStatement("update punchstatus set break_in = 'On-time break', break_in_punch_id = ? where id = ?");
                                                        preins.setInt(1, punch_id);
                                                        preins.setInt(2, res3.getInt("id"));
                                                        preins.executeUpdate();
                                                        lbl_punchstatus.setText("On-time Break");
                                                        lbl_time.setText(timenow);
                                                    }  
                                                }
                                                else
                                                {
                                                    //no exception policy assigned
                                                }
                                            }
                                        }
                                        else
                                        {
                                            
                                            //break punches not required
                                            //no time-out yet
                                            
                                            pre11= cn().prepareStatement("select time_out from punchstatus where id = ? AND time_out IS NOT NULL");
                                            pre11.setInt(1, res3.getInt("punchstatus.id"));
                                            res11 = pre11.executeQuery();
                                                    
                                            if(res11.next())
                                            {
                                                        
                                                //time-out already
                                                //shift ended
                                                lbl_punchstatus.setText("UNSCHEDULED / SHIFT ENDED");
                                                        
                                            }
                                            else
                                            {
                                                //no time out yet
                                                pre12 = cn().prepareStatement("select grace, watch_window from assign_exceptions as ae, policygroup_employees as pe where ? = pe.employee_id AND pe.policygroup_id = ae.group_id AND ae.id = 14");
                                                pre12.setInt(1, id);
                                                res12 = pre12.executeQuery();
                                                        
                                                if(res12.next())
                                                {   
                                                    LocalTime scheduledtimeout = new LocalTime(res2.getTime(out));
                                                    LocalTime timeoutingrace = new LocalTime(res12.getTime("grace"));
                                                    LocalTime timeoutinwatchwindow = new LocalTime(res12.getTime("watch_window"));
                                                    LocalTime timeoutgrace = new LocalTime();
                                                    LocalTime timeoutwatchwindow = new LocalTime();
                                                    LocalTime timeoutgrace2 = new LocalTime();
                                                    timeoutwatchwindow = scheduledtimeout.plusHours(timeoutinwatchwindow.getHourOfDay());
                                                    timeoutwatchwindow = timeoutwatchwindow.plusMinutes(timeoutinwatchwindow.getMinuteOfHour());
                                                    timeoutgrace = scheduledtimeout.minusHours(timeoutingrace.getHourOfDay());
                                                    timeoutgrace = timeoutgrace.minusMinutes(timeoutingrace.getMinuteOfHour());
                                                    timeoutgrace2 = scheduledtimeout.plusHours(timeoutingrace.getHourOfDay());
                                                    timeoutgrace2 = timeoutgrace2.plusMinutes(timeoutingrace.getMinuteOfHour());
                                                            
                                                    if(currenttime.isBefore(timeoutgrace))
                                                    {
                                                    // early out
                                                        if(confirmation == 1 && confirmation == id)
                                                        {
                                                            preins = cn().prepareStatement("update punchstatus set time_out = 'early out', time_out_punch_id = ? where id = ?");
                                                            preins.setInt(1, punch_id);
                                                            preins.setInt(2, res3.getInt("id"));
                                                            preins.executeUpdate();
                                                            lbl_punchstatus.setText("Early OUT");
                                                            lbl_time.setText(timenow);
                                                            confirmation = 0;
                                                        }
                                                        else
                                                        {
                                                            lbl_punchstatus.setText("Warning! This will be recorded as an EARLY-OUT, PUNCH-IN again to confirm");
                                                            lbl_time.setText(timenow);
                                                            confirmation = 1;
                                                            confirmationchecker = id;
                                                            timer = new Timer();
                                                            timer.schedule(new TimerTask()
                                                            {
                                                                public void run() 
                                                                {               
                                                                    confirmation = 0;
                                                                    confirmationchecker = 0;
                                                                    lbl_punchstatus.setText("");
                                                                    lbl_time.setText("");
                                                                    status.setText("Scan your finger to the Biometrics device to Time-in");
                                                                }
                                                            }, 15*1000);
                                                        }
                                                    
                                                    }
                                                    else if(currenttime.isAfter(timeoutgrace) && currenttime.isBefore(timeoutgrace2))
                                                    {
                                                                //on time out
                                                        preins = cn().prepareStatement("update punchstatus set time_out = 'On-time out', time_out_punch_id = ? where id = ?");
                                                        preins.setInt(1, punch_id);
                                                        preins.setInt(2, res3.getInt("id"));
                                                        preins.executeUpdate();
                                                        lbl_punchstatus.setText("On-time OUT");
                                                        lbl_time.setText(timenow);
                                                    }
                                                    else if(currenttime.isAfter(timeoutgrace2))
                                                    {
                                                            // late out
                                                        preins = cn().prepareStatement("update punchstatus set time_out = 'Late Out', time_out_punch_id = ? where id = ?");
                                                        preins.setInt(1, punch_id);
                                                        preins.setInt(2, res3.getInt("id"));
                                                        preins.executeUpdate();
                                                        lbl_punchstatus.setText("Late OUT");
                                                        lbl_time.setText(timenow);
                                                    }
                                                }
                                                else
                                                {
                                                    //no policy for time-out
                                                            
                                                }
                                            } // end else
                                        } //end else 
                                    }//res7  
                                    else
                                    { 
                                    //no break scheduled
                                        pre11= cn().prepareStatement("select time_out from punchstatus where id = ? AND time_out IS NOT NULL");
                                        pre11.setInt(1, res3.getInt("punchstatus.id"));
                                        res11 = pre11.executeQuery();
                                        System.out.println("test");            
                                        if(res11.next())
                                        {
                                                        
                                            //time-out already
                                            //shift ended
                                            lbl_punchstatus.setText("UNSCHEDULED/ SHIFT ENDED");
                                                        
                                        }
                                        else
                                        {
                                            pre12 = cn().prepareStatement("select grace, watch_window from assign_exceptions as ae, policygroup_employees as pe where ? = pe.employee_id AND pe.policygroup_id = ae.group_id AND ae.id = 14");
                                            pre12.setInt(1, id);
                                            res12 = pre12.executeQuery();
                                                        
                                            if(res12.next())
                                            {   
                                                LocalTime scheduledtimeout = new LocalTime(res2.getTime(out));
                                                LocalTime timeoutingrace = new LocalTime(res12.getTime("grace"));
                                                LocalTime timeoutinwatchwindow = new LocalTime(res12.getTime("watch_window"));
                                                LocalTime timeoutgrace = new LocalTime();
                                                LocalTime timeoutwatchwindow = new LocalTime();
                                                LocalTime timeoutgrace2 = new LocalTime();
                                                timeoutwatchwindow = scheduledtimeout.plusHours(timeoutinwatchwindow.getHourOfDay());
                                                timeoutwatchwindow = timeoutwatchwindow.plusMinutes(timeoutinwatchwindow.getMinuteOfHour());
                                                timeoutgrace = scheduledtimeout.minusHours(timeoutingrace.getHourOfDay());
                                                timeoutgrace = timeoutgrace.minusMinutes(timeoutingrace.getMinuteOfHour());
                                                timeoutgrace2 = scheduledtimeout.plusHours(timeoutingrace.getHourOfDay());
                                                timeoutgrace2 = timeoutgrace2.plusMinutes(timeoutingrace.getMinuteOfHour());
                                                            
                                                if(currenttime.isBefore(timeoutgrace))
                                                {
                                                // early out
                                                    if(confirmation == 1 && confirmationchecker == id)
                                                    {
                                                        preins = cn().prepareStatement("update punchstatus set time_out = 'early out', time_out_punch_id = ? where id = ?");
                                                        preins.setInt(1, punch_id);
                                                        preins.setInt(2, res3.getInt("id"));
                                                        preins.executeUpdate();
                                                        lbl_punchstatus.setText("Early OUT");
                                                        lbl_time.setText(timenow);
                                                        confirmation = 0;
                                                    }
                                                    else
                                                    {
                                                        lbl_punchstatus.setText("Warning this will be recorded as an EARLY-OUT, PUNCH-IN again to confirm");
                                                        lbl_time.setText(timenow);
                                                        confirmation = 1;
                                                        confirmationchecker = id;
                                                        timer = new Timer();
                                                        timer.schedule(new TimerTask()
                                                        {
                                                            public void run() 
                                                            {               
                                                                confirmation = 0;
                                                                confirmationchecker = 0;
                                                                lbl_punchstatus.setText("");
                                                                lbl_time.setText("");
                                                                status.setText("Scan your finger to the Biometrics device to Time-in");
                                                                
                                                                
                                                            }
                                                        }, 15*1000);
                                                  
                                                    }
                                                      
                                                }
                                                else if(currenttime.isAfter(timeoutgrace) && currenttime.isBefore(timeoutgrace2))
                                                {
                                                                //on time out
                                                    preins = cn().prepareStatement("update punchstatus set time_out = 'On-time out', time_out_punch_id = ? where id = ?");
                                                    preins.setInt(1, punch_id);
                                                    preins.setInt(2, res3.getInt("id"));
                                                    preins.executeUpdate();
                                                    lbl_punchstatus.setText("On-time OUT");
                                                    lbl_time.setText(timenow);
                                                }
                                                else if(currenttime.isAfter(timeoutgrace2))
                                                {
                                                           // late out
                                                    preins = cn().prepareStatement("update punchstatus set time_out = 'Late Out', time_out_punch_id = ? where id = ?");
                                                    preins.setInt(1, punch_id);
                                                    preins.setInt(2, res3.getInt("id"));
                                                    preins.executeUpdate();
                                                    lbl_punchstatus.setText("Late OUT");
                                                    lbl_time.setText(timenow);
                                                }
                                            }
                                            else
                                            {
                                                //no policy for time-out
                                                            
                                            }
                                        }
                                    }
                                }
                                else if("Absent".equalsIgnoreCase(res3.getString("time_in")))
                                {   System.out.println("test");
                                    lbl_punchstatus.setText("Absent already");
                                    lbl_time.setText(timenow);
                                }
                                else if("On Leave".equalsIgnoreCase(res3.getString("time_in")))
                                {
                                    lbl_punchstatus.setText("Leave Currently Scheduled");
                                    lbl_time.setText(timenow);
                                }
                                else if("Holiday".equalsIgnoreCase(res3.getString("time_in")))
                                {
                                    lbl_punchstatus.setText("Holiday");
                                    lbl_time.setText(timenow);
                                }
                                
                            }
                            else
                                {
                                    //no time in yet
                                    
                                    
                                    pre4 = cn().prepareStatement("select grace, watch_window from assign_exceptions as ae, policygroup_employees as pe where ? = pe.employee_id AND pe.policygroup_id = ae.group_id AND ae.id = 13");
                                    pre4.setInt(1, id);
                                    res4 = pre4.executeQuery();
                                    
                                    if(res4.next())
                                    {   
                                        LocalTime scheduledtime = new LocalTime(res2.getTime(in));
                                        LocalTime gracetime = new LocalTime(res4.getTime("grace"));
                                        LocalTime watchwindow = new LocalTime(res4.getTime("watch_window"));
                                        LocalTime schedulegrace = new LocalTime();
                                        LocalTime schedulegrace2 = new LocalTime();
                                        schedulegrace = scheduledtime.plusHours(gracetime.getHourOfDay());
                                        schedulegrace = schedulegrace.plusMinutes(gracetime.getMinuteOfHour());
                                        schedulegrace2 = scheduledtime.minusHours(watchwindow.getHourOfDay());
                                        schedulegrace2 = scheduledtime.minusMinutes(watchwindow.getMinuteOfHour());
                                        //LocalTime currenttime = LocalTime.now();
                            
                                        if(currenttime.isAfter(schedulegrace))
                                        {
                                            preins = cn().prepareStatement("insert into punchstatus(time_in, time_in_punch_id , employee_id, date) values ('Late', ?, ?, ?)");
                                            preins.setInt(1, punch_id);
                                            preins.setInt(2, id);
                                            preins.setString(3, currentdate);
                                            preins.executeUpdate();
                                            lbl_punchstatus.setText("Late IN");
                                            lbl_time.setText(timenow);
                                        }
                                        else if(currenttime.isBefore(schedulegrace) && currenttime.isAfter(scheduledtime))
                                        {
                                            preins = cn().prepareStatement("insert into punchstatus(time_in, time_in_punch_id , employee_id, date) values ('On-time', ?, ?, ?)");
                                            preins.setInt(1, punch_id);
                                            preins.setInt(2, id);
                                            preins.setString(3, currentdate);
                                            preins.executeUpdate();
                                            lbl_punchstatus.setText("On-time IN");
                                            lbl_time.setText(timenow);
                                        }
                                        else if(currenttime.isBefore(scheduledtime) && currenttime.isAfter(schedulegrace2))
                                        {
                                            preins = cn().prepareStatement("insert into punchstatus(time_in, time_in_punch_id , employee_id, date) values ('Early', ?, ?, ?)");
                                            preins.setInt(1, punch_id);
                                            preins.setInt(2, id);
                                            preins.setString(3, currentdate);
                                            preins.executeUpdate();
                                            lbl_punchstatus.setText("Early IN");
                                            lbl_time.setText(timenow);
                                            
                                        }
                                        else
                                        {
                                            //unscheduled /shift not started yet
                                             lbl_punchstatus.setText("UNSCHEDULED");
                                             lbl_time.setText(timenow);
                                        }
                                    }//res4
                                    else
                                    {
                                        //policy not assigned
                                    }
                                }//else
                        }//schedcheck
                        else
                        {
                            lbl_punchstatus.setText("UNSCHEDULED");
                            lbl_time.setText(timenow);
                        }
                        }
                        else
                        {
                            //no policy assigned on employee
                            lbl_punchstatus.setText("No Assigned Policy on Employee");
                        }
                    }//res2
                    else
                    {
                        lbl_punchstatus.setText("UNSCHEDULED");
                        lbl_time.setText(timenow);
                    }
            }//rs.next
            
        }
        catch (Exception e)
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
        picture.setVisible(true);
    }
    
    public void drawPicture2(String pic_path) 
    {
        try{       
        
        BufferedImage image = ImageIO.read(URI.create("http://localhost/teams/public/"+pic_path).toURL());
        
	employeepic.setIcon(new ImageIcon(
		image.getScaledInstance(employeepic.getWidth(), employeepic.getHeight(), Image.SCALE_DEFAULT)));
        
        employeepic.setVisible(true);
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
        lbl_punchstatus = new javax.swing.JLabel();
        lbl_time = new javax.swing.JLabel();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        status.setFont(new java.awt.Font("Segoe UI Light", 1, 18)); // NOI18N
        status.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        status.setText("Scan your finger to the Biometrics Device to Time-In");

        emp_name.setFont(new java.awt.Font("Segoe UI Light", 1, 24)); // NOI18N
        emp_name.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);

        lbl_punchstatus.setFont(new java.awt.Font("Arial", 0, 18)); // NOI18N
        lbl_punchstatus.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);

        lbl_time.setFont(new java.awt.Font("Segoe UI Semibold", 0, 24)); // NOI18N
        lbl_time.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, layout.createSequentialGroup()
                .addContainerGap(60, Short.MAX_VALUE)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(status, javax.swing.GroupLayout.PREFERRED_SIZE, 470, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(emp_name, javax.swing.GroupLayout.PREFERRED_SIZE, 457, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addGap(70, 70, 70))
            .addGroup(layout.createSequentialGroup()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addGap(183, 183, 183)
                        .addComponent(employeepic, javax.swing.GroupLayout.PREFERRED_SIZE, 195, javax.swing.GroupLayout.PREFERRED_SIZE))
                    .addGroup(layout.createSequentialGroup()
                        .addGap(248, 248, 248)
                        .addComponent(picture, javax.swing.GroupLayout.PREFERRED_SIZE, 53, javax.swing.GroupLayout.PREFERRED_SIZE)))
                .addContainerGap(222, Short.MAX_VALUE))
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, layout.createSequentialGroup()
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                .addComponent(lbl_punchstatus, javax.swing.GroupLayout.PREFERRED_SIZE, 539, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
            .addGroup(layout.createSequentialGroup()
                .addGap(99, 99, 99)
                .addComponent(lbl_time, javax.swing.GroupLayout.PREFERRED_SIZE, 379, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
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
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(lbl_punchstatus, javax.swing.GroupLayout.PREFERRED_SIZE, 43, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(lbl_time, javax.swing.GroupLayout.DEFAULT_SIZE, 50, Short.MAX_VALUE)
                .addGap(5, 5, 5))
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
            public void run() 
            {
                new FingerprintVerify().setVisible(true);
            }
            
        });
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JLabel emp_name;
    private javax.swing.JLabel employeepic;
    private javax.swing.JLabel lbl_punchstatus;
    private javax.swing.JLabel lbl_time;
    private javax.swing.JLabel picture;
    private javax.swing.JLabel status;
    // End of variables declaration//GEN-END:variables
}
