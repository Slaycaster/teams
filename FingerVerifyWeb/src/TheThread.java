/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author eXcelsior
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
import org.joda.time.LocalTime;
import org.joda.time.*;
import org.joda.time.format.*;

public class TheThread extends Thread
{
    Connection conn = null;
    
    public void run() {
        
        PreparedStatement pre1 = null; //get employee id's
        PreparedStatement pre2 = null; // check if employee is scheduled
        PreparedStatement pre3 = null; // check if timed in already
        PreparedStatement pre4 = null; // check time in exception
        PreparedStatement pre5 = null; // check if break punches required
        PreparedStatement pre6 = null; // check if break in already
        PreparedStatement pre7 = null; // check if there's a scheduled break
        PreparedStatement pre8 = null; // check break in policy
        PreparedStatement pre9 = null; // check if break out already
        PreparedStatement pre10 = null; // check break out policy
        PreparedStatement pre11 = null; // check if employee is already absent
        PreparedStatement pre12 = null; // check if time out already
        PreparedStatement pre13 = null; // check time out policy
        PreparedStatement pre14 = null; // check if holiday
        PreparedStatement pre15 = null; // check if on leave
        PreparedStatement pre16 = null; // check if on leave recorded already
        PreparedStatement pre17 = null; // check if there's an assigned policy
        PreparedStatement preins = null; //insert statement
        
        ResultSet res1 = null; //get employee id's
        ResultSet res2 = null; // check if employee is scheduled
        ResultSet res3 = null; // check if timed in already
        ResultSet res4 = null; // check time in exception
        ResultSet res5 = null; // check if break punches required
        ResultSet res6 = null; // check if break in already
        ResultSet res7 = null; // check if there's a scheduled break
        ResultSet res8 = null; // check break in policy
        ResultSet res9 = null; // check if break out already
        ResultSet res10 = null; // check break out policy
        ResultSet res11 = null; // check if employee is already absent
        ResultSet res12 = null; // check if time out already
        ResultSet res13 = null; // check time out policy
        ResultSet res14 = null; // check if holiday
        ResultSet res15 = null; // check if on leave
        ResultSet res16 = null; // check if on leave recorded already
        ResultSet res17 = null; // check if there's an assigned policy
        ResultSet resins = null; // insert statement
        
        int infinite = 0;
        
        try
        {
            while(infinite == 0)
            {
                LocalTime currenttime = LocalTime.now();
                if(currenttime.getSecondOfMinute() == 0)
                {
                    //minute passed
                    System.out.println("minute passed");
                    Calendar calendar = Calendar.getInstance();
                    int dayOfWeek = calendar.get(Calendar.DAY_OF_WEEK);
                    String currentdaytext = "";
                    String in ="";
                    String out ="";
                    SimpleDateFormat parser = new SimpleDateFormat("HH:mm:ss");
                    Date time = parser.parse("00:00:00");
                    LocalDate date = LocalDate.now();                    
                    DateTimeFormatter formatter = DateTimeFormat.forPattern("yyyy-MM-dd");
                    String currentdate = formatter.print(date); 
                    
                    
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
                    
                    pre1 = cn().prepareStatement("select id from employs"); //get all employee id's
                    res1 = pre1.executeQuery();
                    
                    while(res1.next())
                    {   
                        //check each employee if scheduled through id
                        pre2.setInt(1 , res1.getInt("id"));
                        res2 = pre2.executeQuery();
                        
                        if(res2.next())
                        {
                            
                            pre17= cn().prepareStatement("select id from policygroup_employees as pe where pe.employee_id = ?");
                            pre17.setInt(1, res1.getInt("id"));
                            res17 = pre17.executeQuery();
                            
                            if(res17.next())
                            {
                              //there's an assigned policy to the employee
                                
                             if (res2.getTime(in) != null || res2.getTime(in) != time && res2.getTime(out) != null || res2.getTime(out) != time )
                             {
                                 //scheduled
                                 
                                pre14 = cn().prepareStatement("select distinct e.lname, h.holiday_name, h.recurring, h.year, d.name, b.branch_name AS 'Employee Branch'\n" +
                                                                "from policygroup_employees as pe\n" +
                                                                "inner join employs as e on pe.employee_id = e.id\n" +
                                                                "inner join policy_group_holiday as pgh on pe.policygroup_id = pgh.policy_group_id\n" +
                                                                "inner join holiday_policies as h on pgh.holiday_id = h.id\n" +
                                                                "inner join branches_holidays as bh on pgh.holiday_id = bh.holiday_id\n" +
                                                                "inner join departments as d on e.department_id = d.id\n" +
                                                                "inner join branches as b on d.branch_id = b.id\n" +
                                                                "where pe.employee_id = ? and h.day_of_month = ? and h.month = ?");
                                pre14.setInt(1, res1.getInt("id"));
                                pre14.setInt(2, date.getDayOfMonth());
                                pre14.setString(3, date.toString("MMMM"));
                                res14 = pre14.executeQuery();
                                
                                pre3 = cn().prepareStatement("select punchstatus.id, time_in from punchstatus, punches where punchstatus.employee_id = ? AND punchstatus.date = ?");
                                pre3.setInt(1, res1.getInt("id"));
                                pre3.setString(2, currentdate);
                                res3 = pre3.executeQuery();
                                 
                                if(res14.next())
                                {   //Holiday on the current day
                                    if(res3.next())
                                    {
                                        
                                        //no action
                                        //may laman na
                                    }
                                    else
                                    {   //time_in empty
                                        if((res14.getString("h.recurring") == null) == false)
                                        {System.out.println("test");
                                            preins = cn().prepareStatement("insert into punchstatus(time_in , employee_id, date) values ('Holiday', ?, ?)");
                                            preins.setInt(1, res1.getInt("id"));
                                            preins.setString(2, currentdate);
                                            preins.executeUpdate();
                                        }
                                        else
                                        {   System.out.println("test");
                                            if((res14.getString("year") == null) == false)
                                            {
                                                if(res14.getString("year").equalsIgnoreCase(date.toString("yyyy")))
                                                {
                                                    preins = cn().prepareStatement("insert into punchstatus(time_in , employee_id, date) values ('Holiday', ?, ?)");
                                                    preins.setInt(1, res1.getInt("id"));
                                                    preins.setString(2, currentdate);
                                                    preins.executeUpdate();
                                                }
                                                else
                                                {
                                                
                                                    //no action
                                                }
                                            }
                                        }
                                        
                                    }
                                }
                                 
                                else
                                {   //hindi holiday
                                  
                                 if(res3.next())
                                 {
                                     //timed in alr+eady
                                    pre7 = cn().prepareStatement("select break_in, break_out from breaks where schedule_id =? AND day = ?");
                                    pre7.setInt(1, res2.getInt("schedules.id"));
                                    pre7.setString(2, currentdaytext);
                                    res7 = pre7.executeQuery();
                                    
                                    if(res7.next())
                                    {
                                        //there's a scheduled break
                                        pre5 = cn().prepareStatement("select require_break_punches from schedules ,empschedules where empschedules.employee_id = ? AND empschedules.schedule_id = schedules.id ");
                                        pre5.setInt(1, res1.getInt("id"));                                   
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
                                                    pre12 = cn().prepareStatement("select time_out from  punchstatus where id = ? AND time_out IS NOT NULL");
                                                    pre12.setInt(1, res3.getInt("punchstatus.id"));
                                                    res12 = pre12.executeQuery();
                                                    
                                                    if(res12.next())
                                                    {
                                                        //time out already / NO ACTION
                                                    }
                                                    else
                                                    {   
                                                        //no time out yet
                                                        pre13 = cn().prepareStatement("select grace, watch_window from assign_exceptions as ae, policygroup_employees as pe where ? = pe.employee_id AND pe.policygroup_id = ae.group_id AND ae.id = 1");
                                                        pre13.setInt(1, res1.getInt("id"));
                                                        res13 = pre13.executeQuery();
                                                        
                                                        if(res13.next())
                                                        {   
                                                            LocalTime scheduledtimeout = new LocalTime(res2.getTime(out));
                                                            LocalTime gracetimeout = new LocalTime(res13.getTime("grace"));
                                                            LocalTime watchwindowout = new LocalTime(res13.getTime("watch_window"));
                                                            LocalTime schedulegraceout = new LocalTime();
                                                            LocalTime schedulewatchwindowout = new LocalTime();
                                                            schedulegraceout = scheduledtimeout.plusHours(gracetimeout.getHourOfDay());
                                                            schedulegraceout = schedulegraceout.plusMinutes(gracetimeout.getMinuteOfHour());
                                                            schedulewatchwindowout = scheduledtimeout.plusHours(watchwindowout.getHourOfDay());
                                                            schedulewatchwindowout = scheduledtimeout.plusMinutes(watchwindowout.getMinuteOfHour());
                                                            
                                                            if(currenttime.isAfter(schedulewatchwindowout))
                                                            {   System.out.println("test");
                                                                //missing out punch
                                                                preins = cn().prepareStatement("update punchstatus set time_out = 'Missing Out Punch' where id = ?");
                                                                preins.setInt(1, res3.getInt("id"));
                                                                preins.executeUpdate();
                                                            }
                                                            else
                                                            {
                                                                //no action
                                                                
                                                            }
                                                        }
                                                        else
                                                        {
                                                            //no policy assigned for time out
                                                        }
                                                    }
                                                    
                                                }
                                                else
                                                {
                                                    // no break out yet
                                                    pre10 = cn().prepareStatement("select grace, watch_window from assign_exceptions as ae, policygroup_employees as pe where ? = pe.employee_id AND pe.policygroup_id = ae.group_id AND ae.id = 8 ");
                                                    pre10.setInt(1, res1.getInt("id"));
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
                                                        
                                                        if(currenttime.isAfter(breakoutwatchwindow))
                                                        {
                                                            preins = cn().prepareStatement("update punchstatus set break_out = 'missed break-out punch' where id = ?");
                                                            preins.setInt(1, res3.getInt("id"));
                                                            preins.executeUpdate();
                                                        }
                                                        
                                                    }
                                                    else
                                                    {
                                                        //no policy for break out
                                                    }
                                                }
                                                
                                            }
                                            else
                                            {
                                                //no break in yet
                                                pre8 = cn().prepareStatement("select grace, watch_window from assign_exceptions as ae, policygroup_employees as pe where ? = pe.employee_id AND pe.policygroup_id = ae.group_id AND ae.id = 8");
                                                pre8.setInt(1, res1.getInt("id"));
                                                res8 = pre8.executeQuery();
                                                
                                                if(res8.next())
                                                {
                                                    LocalTime scheduledbreak = new LocalTime(res7.getTime("break_in"));
                                                    LocalTime watchwindowinbreak = new LocalTime(res8.getTime("watch_window"));
                                                    LocalTime watchwindowbreak = new LocalTime();
                                                    watchwindowbreak = scheduledbreak.plusHours(watchwindowinbreak.getHourOfDay());
                                                    watchwindowbreak = watchwindowbreak.plusMinutes(watchwindowinbreak.getMinuteOfHour());
                                                    
                                                    if(currenttime.isAfter(watchwindowbreak))
                                                    {
                                                        //missed break
                                                        preins = cn().prepareStatement("update punchstatus set break_in = 'missed break', break_out = 'missed break' where id = ?");
                                                        preins.setInt(1, res3.getInt("punchstatus.id"));
                                                        preins.executeUpdate();
                                                    }
                                                    else
                                                    {
                                                        //no action
                                                    }
                                                }
                                                else
                                                {
                                                    //no break in policy
                                                }
                                            }
                                        }
                                        else
                                        {
                                            //break punches not required
                                            
                                            pre12 = cn().prepareStatement("select time_out from  punchstatus where id = ? AND time_out IS NOT NULL");
                                            pre12.setInt(1, res3.getInt("punchstatus.id"));
                                            res12 = pre12.executeQuery();
                                                    
                                            if(res12.next())
                                            {
                                                //time out already / NO ACTION
                                            }
                                            else
                                            {
                                                //no time out yet
                                                pre13 = cn().prepareStatement("select grace, watch_window from assign_exceptions as ae, policygroup_employees as pe where ? = pe.employee_id AND pe.policygroup_id = ae.group_id AND ae.id = 1");
                                                pre13.setInt(1, res1.getInt("id"));
                                                res13 = pre13.executeQuery();
                                                        
                                                if(res13.next())
                                                {
                                                    LocalTime scheduledtimeout = new LocalTime(res2.getTime(out));
                                                    LocalTime gracetimeout = new LocalTime(res13.getTime("grace"));
                                                    LocalTime watchwindowout = new LocalTime(res13.getTime("watch_window"));
                                                    LocalTime schedulegraceout = new LocalTime();
                                                    LocalTime schedulewatchwindowout = new LocalTime();
                                                    schedulegraceout = scheduledtimeout.plusHours(gracetimeout.getHourOfDay());
                                                    schedulegraceout = schedulegraceout.plusMinutes(gracetimeout.getMinuteOfHour());
                                                    schedulewatchwindowout = scheduledtimeout.plusHours(watchwindowout.getHourOfDay());
                                                    schedulewatchwindowout = scheduledtimeout.plusMinutes(watchwindowout.getMinuteOfHour());
                                                            
                                                    if(currenttime.isAfter(schedulewatchwindowout))
                                                    {
                                                                //missing out punch
                                                        preins = cn().prepareStatement("update punchstatus set time_out = 'Missing Out Punch' where id = ?");
                                                        preins.setInt(1, res3.getInt("id"));
                                                        preins.executeUpdate();
                                                    }
                                                    else
                                                    {
                                                        //no action
                                                    }
                                                }
                                                else
                                                {
                                                    //no policy assigned for time out
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        //no scheduled break
                                        
                                        pre12 = cn().prepareStatement("select time_out from  punchstatus where id = ? AND time_out IS NOT NULL");
                                        pre12.setInt(1, res3.getInt("punchstatus.id"));
                                        res12 = pre12.executeQuery();
                                                    
                                        if(res12.next())
                                        {
                                            //time out already / NO ACTION
                                        }
                                        else
                                        {
                                            //no time out yet
                                            pre13 = cn().prepareStatement("select grace, watch_window from assign_exceptions as ae, policygroup_employees as pe where ? = pe.employee_id AND pe.policygroup_id = ae.group_id AND ae.id = 1");
                                            pre13.setInt(1, res1.getInt("id"));
                                            res13 = pre13.executeQuery();
                                                        
                                            if(res13.next())
                                            {
                                                LocalTime scheduledtimeout = new LocalTime(res2.getTime(out));
                                                LocalTime gracetimeout = new LocalTime(res13.getTime("grace"));
                                                LocalTime watchwindowout = new LocalTime(res13.getTime("watch_window"));
                                                LocalTime schedulegraceout = new LocalTime();
                                                LocalTime schedulewatchwindowout = new LocalTime();
                                                schedulegraceout = scheduledtimeout.plusHours(gracetimeout.getHourOfDay());
                                                schedulegraceout = schedulegraceout.plusMinutes(gracetimeout.getMinuteOfHour());
                                                schedulewatchwindowout = scheduledtimeout.plusHours(watchwindowout.getHourOfDay());
                                                schedulewatchwindowout = scheduledtimeout.plusMinutes(watchwindowout.getMinuteOfHour());
                                                            
                                                if(currenttime.isAfter(schedulewatchwindowout))
                                                {
                                                    //missing out punch
                                                    preins = cn().prepareStatement("update punchstatus set time_out = 'Missing Out Punch' where id = ?");
                                                    preins.setInt(1, res3.getInt("id"));
                                                    preins.executeUpdate();
                                                }
                                                else
                                                {
                                                    //no action
                                                }
                                            }
                                            else
                                            {
                                                            //no policy assigned for time out
                                            }
                                        }
                                    }
                                 }
                                 else
                                 {
                                     //no time in yet
                                    pre4 = cn().prepareStatement("select grace, watch_window from assign_exceptions as ae, policygroup_employees as pe where ? = pe.employee_id AND pe.policygroup_id = ae.group_id AND ae.id = 13");
                                    pre4.setInt(1, res1.getInt("id"));
                                    res4 = pre4.executeQuery();
                                    
                                    pre15 = cn().prepareStatement("select start_date, end_date from leavesummaries where employee_id = ?");
                                    pre15.setInt(1, res1.getInt("id"));
                                    res15 = pre15.executeQuery();
                                    
                                    
                                    
                                    
                                    if(res15.next())
                                    {
                                         
                                        LocalDate startdate =  new LocalDate(res15.getDate("start_date"));
                                        LocalDate enddate =  new LocalDate(res15.getDate("end_date"));
                                        
                                        if(date.equals(startdate)||date.isAfter(startdate) && date.equals(enddate) || date.isBefore(enddate))
                                        {
                                            pre16 = cn().prepareStatement("select time_in from punchstatus where employee_id = ? AND date = ? AND time_in = 'On Leave'");
                                            pre16.setInt(1, res1.getInt("id"));
                                            pre16.setString(2, currentdate);
                                            res16 = pre16.executeQuery();
                                        System.out.println("test");
                                            if(res16.next())
                                            {
                                            //no action
                                            }
                                        
                                            else
                                            {
                                                preins = cn().prepareStatement("insert into punchstatus(time_in , employee_id, date) values ('On Leave', ?, ?)");
                                                preins.setInt(1, res1.getInt("id"));
                                                preins.setString(2, currentdate);
                                                preins.executeUpdate();
                                            }
                                        }
                                        
                                        else
                                        {
                                            pre11 = cn().prepareStatement("select time_in from punchstatus where employee_id = ? AND date = ? AND time_in = 'Absent'");
                                            pre11.setInt(1, res1.getInt("id"));
                                            pre11.setString(2, currentdate);
                                            res11 = pre11.executeQuery();
                                    
                                            if(res11.next())
                                            {
                                               //no action 
                                            }
                                            else
                                            {
                                                if(res4.next())
                                                {
                                                    LocalTime scheduledtime = new LocalTime(res2.getTime(in));
                                                    LocalTime gracetime = new LocalTime(res4.getTime("grace"));
                                                    LocalTime watchwindow = new LocalTime(res4.getTime("watch_window"));
                                                    LocalTime schedulegrace = new LocalTime();
                                                    LocalTime schedulewatchwindow = new LocalTime();
                                                    schedulegrace = scheduledtime.plusHours(gracetime.getHourOfDay());
                                                    schedulegrace = schedulegrace.plusMinutes(gracetime.getMinuteOfHour());
                                                    schedulewatchwindow = scheduledtime.plusHours(watchwindow.getHourOfDay());
                                                    schedulewatchwindow = scheduledtime.plusMinutes(watchwindow.getMinuteOfHour());
                                        
                                                    if(currenttime.isAfter(schedulewatchwindow))
                                                    {
                                                //absent
                                                        preins = cn().prepareStatement("insert into punchstatus(time_in , employee_id, date) values ('Absent', ?, ?)");
                                                        preins.setInt(1, res1.getInt("id"));
                                                        preins.setString(2, currentdate);
                                                        preins.executeUpdate();
                                                    }
                                                    else
                                                    {
                                                        //no action
                                                    }
                                                }
                                                else
                                                {
                                                    //no exception policy assigned
                                                }
                                            }
                                    
                                        }
                                    }
                                    
                                    else
                                    {
                                    pre11 = cn().prepareStatement("select time_in from punchstatus where employee_id = ? AND date = ? AND time_in = 'Absent'");
                                    pre11.setInt(1, res1.getInt("id"));
                                    pre11.setString(2, currentdate);
                                    res11 = pre11.executeQuery();
                                    
                                    if(res11.next())
                                    {
                                       //no action 
                                    }
                                    else
                                    {
                                        if(res4.next())
                                        {
                                            LocalTime scheduledtime = new LocalTime(res2.getTime(in));
                                            LocalTime gracetime = new LocalTime(res4.getTime("grace"));
                                            LocalTime watchwindow = new LocalTime(res4.getTime("watch_window"));
                                            LocalTime schedulegrace = new LocalTime();
                                            LocalTime schedulewatchwindow = new LocalTime();
                                            schedulegrace = scheduledtime.plusHours(gracetime.getHourOfDay());
                                            schedulegrace = schedulegrace.plusMinutes(gracetime.getMinuteOfHour());
                                            schedulewatchwindow = scheduledtime.plusHours(watchwindow.getHourOfDay());
                                            schedulewatchwindow = scheduledtime.plusMinutes(watchwindow.getMinuteOfHour());
                                        
                                            if(currenttime.isAfter(schedulewatchwindow))
                                            {
                                                //absent
                                                preins = cn().prepareStatement("insert into punchstatus(time_in , employee_id, date) values ('Absent', ?, ?)");
                                                preins.setInt(1, res1.getInt("id"));
                                                preins.setString(2, currentdate);
                                                preins.executeUpdate();
                                            }
                                            else
                                            {
                                                //no action
                                            }
                                        }
                                        else
                                        {
                                            //no exception policy assigned
                                        }
                                    }
                                    
                                    }// if date.equals
                                   
                                 }
                                 
                                }//res14.next
                             }
                             else
                             {
                                 //unscheduled
                             }
                            }//res17.next()
                            else
                            {
                                System.out.println("No policy assigned");
                            }
                            
                        }// if(res2.next())
                        else
                        {
                            //res2 empty
                        }
                    }//end while    
                }// end if(minute passed) condition        
                Thread.sleep(1000);  
                cn().close();
            }//end while infinite
        }//try
        catch(Exception e)
        {
          System.out.println(e);   
        }
        
        
        
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

    public static void main(String args[]) {
        (new TheThread()).start();
    }
}
