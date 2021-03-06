@extends("layout")
@section("content")


<head>
    <title>Accumulated Hours Report | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Accumulated Hours</h1>

<div class='col-md-4'>
{{ Form::open(array('url' => 'report/accumulated', 'method' => 'get')) }}
<h3>Select an Employee</h3>
     {{ Form::select('employs_id', $employs_id, Input::get('employs_id'));}}<br><br>
</div>

<div class='col-md-4'>
<h3>Select a Month</h3>

     {{ Form::selectMonth('month', Input::get('month'));}}<br><br>
</div>

<div class='col-md-4'>
<h3>Select a Year</h3>

     {{ Form::selectYear('year', date('Y'), 1960)}}<br><br>
</div>

{{ Form::submit('Generate PDF', array('class' => 'btn btn-success')) }}

{{ Form::close() }}
<hr>
<?php


require('fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
        
        $month = Session::get('month_query', 'default');
        $year = Session::get('year_query', 'default');
        $employee = Session::get('emp_query', 'default'); 
        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        
    // Logo
    // Arial bold 15
    $this->SetFont('Arial','B',14);
	// Move to the right
    $this->Cell(60);
    // Title
    $this->Cell(40,10,'Accumulated Hours Report','C');
    // Line break
    $this->Ln(8);
    
    $this->SetFont('Arial','',14);
    
    $this->Cell(58);
    // Title
    $this->Cell(40,10,'For the month of ' . $monthName . ' ' . $year ,'C');

    
    $this->Ln();
}
                
function BasicTable($header)
    {
                //$emp_id = Session::get('emp_query', 'default'); 
                $month = Session::get('month_query', 'default');
                $year = Session::get('year_query', 'default');
                $lname = Session::get('emp_lname', 'default');
                $fname = Session::get('emp_fname', 'default');
                $get_year = Session::get('year_query', 'default');
                $datefrom = $year.'/'.$month.'/01';
                $dateto = $year.'/'.$month.'/31'; 
                
                $id = Session::get('emp_query', 'default');
                $datenow = new DateTime("now", new DateTimeZone("Asia/Singapore"));
                //$now = Input::get('datefrom');
        
            $acchrs = 0;
            $total = 0;
            $overtime = 0;
            $hrs = 0;
            $othrs = 0;
            $year = date('Y');
            $date = date('d');
            $month = date('m');
            $totalminutes = 0;
            $overtimemin =0;
            $curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));
            $format_day = strtotime($curr_date);
            $day_name = date('l', $format_day);
            //$datefrom = Input::get('datefrom');
            //$dateto = Input::get('dateto');
            //$now = $datefrom;
            //$to = "to";
            //$id = Session::get('empid', 'default');
            //$name = Session::get('empname', 'default');
            //$email = Session::get('empemail', 'default');
            //$level = Session::get('emplevel', 'default');
            //$supervisor = DB::table('hierarchies')->select('supervisor_id')->get();
            $ifot = DB::table('overtime_subordinates')
            ->select('overtime_id')
            ->where('employee_id','=',$id)
            ->lists('overtime_id');
            if($ifot != null)
            {
                $allowedothr = DB::table('overtime_policies')
                ->where('id','=',$ifot)
                ->get();
            }
            $ifsched = DB::table('empschedules')
            ->select('schedule_id')
            ->where('employee_id','=',$id)
            ->lists('schedule_id');
            if($ifsched != null)
            {
                if($day_name == 'Monday')
                {   
                    $schedto = DB::table('schedules')
                    ->select('m_timeout')
                    ->where('id','=',$ifsched)
                    ->get();
                    $break= DB::table('schedules')
                    ->join('breaks','schedules.id','=','breaks.schedule_id')
                    ->select('breaks.break_in','breaks.break_out')
                    ->where('day','=','Monday')
                    ->get();
                    $ifreqbreak = DB::table('schedules')
                    ->select('require_break_punches')
                    ->where('id','=',$ifsched)
                    ->get();
                
                }
                if($day_name == 'Tuesday')
                {   
                    $schedto = DB::table('schedules')
                    ->select('t_timeout')
                    ->where('id','=',$ifsched)
                    ->get();
                    $break= DB::table('schedules')
                    ->join('breaks','schedules.id','=','breaks.schedule_id')
                    ->select('breaks.break_in','breaks.break_out')
                    ->where('day','=','Tuesday')
                    ->get();
                    $ifreqbreak = DB::table('schedules')
                    ->select('require_break_punches')
                    ->where('id','=',$ifsched)
                    ->get();
                }
                if($day_name == 'Wednesday')
                {   
                    $schedto = DB::table('schedules')
                    ->select('w_timeout')
                    ->where('id','=',$ifsched)
                    ->get();
                    $break= DB::table('schedules')
                    ->join('breaks','schedules.id','=','breaks.schedule_id')
                    ->select('breaks.break_in','breaks.break_out')
                    ->where('day','=','Wednesday')
                    ->get();
                    $ifreqbreak = DB::table('schedules')
                    ->select('require_break_punches')
                    ->where('id','=',$ifsched)
                    ->get();
                }
                if($day_name == 'Thursday')
                {   
                    $schedto = DB::table('schedules')
                    ->select('th_timeout')
                    ->where('id','=',$ifsched)
                    ->get();
                    $break= DB::table('schedules')
                    ->join('breaks','schedules.id','=','breaks.schedule_id')
                    ->select('breaks.break_in','breaks.break_out')
                    ->where('day','=','Thursday')
                    ->get();
                    $ifreqbreak = DB::table('schedules')
                    ->select('require_break_punches')
                    ->where('id','=',$ifsched)
                    ->get();
                }
                if($day_name == 'Friday')
                {   
                    $schedto = DB::table('schedules')
                    ->select('f_timeout')
                    ->where('id','=',$ifsched)
                    ->lists('f_timeout');
                    $break= DB::table('schedules')
                    ->join('breaks','schedules.id','=','breaks.schedule_id')
                    ->select('breaks.break_in','breaks.break_out')
                    ->where('day','=','Friday')
                    ->get();
                    $ifreqbreak = DB::table('schedules')
                    ->select('require_break_punches')
                    ->where('id','=',$ifsched)
                    ->get();
                    
                    
                }
                if($day_name == 'Saturday')
                {   
                    $schedto = DB::table('schedules')
                    ->select('sat_timeout')
                    ->where('id','=',$ifsched)
                    ->get();
                    $break= DB::table('schedules')
                    ->join('breaks','schedules.id','=','breaks.schedule_id')
                    ->select('breaks.break_in','breaks.break_out')
                    ->where('day','=','Saturday')
                    ->get();
                    $ifreqbreak = DB::table('schedules')
                    ->select('require_break_punches')
                    ->where('id','=',$ifsched)
                    ->get();
                }
                if($day_name == 'Sunday')
                {   
                    $schedto = DB::table('schedules')
                    ->select('sun_timeout')
                    ->where('id','=',$ifsched)
                    ->get();
                    $break= DB::table('schedules')
                    ->join('breaks','schedules.id','=','breaks.schedule_id')
                    ->select('breaks.break_in','breaks.break_out')
                    ->where('day','=','Sunday')
                    ->get();
                    $ifreqbreak = DB::table('schedules')
                    ->select('require_break_punches')
                    ->where('id','=',$ifsched)
                    ->get();
                }
            
            }
            $punchin = DB::table('punchstatus')
            ->select('time_in_punch_id')
            ->whereBetween('punchstatus.date', array($datefrom , $dateto))
            ->where('employee_id','=',$id)
            ->lists('time_in_punch_id');
            $punchout =DB::table('punchstatus')
            ->select('time_out_punch_id')
            ->whereBetween('punchstatus.date', array($datefrom, $dateto))
            ->where('employee_id','=',$id)
            ->lists('time_out_punch_id');
            $breakin =DB::table('punchstatus')
            ->select('break_in_punch_id')
            ->where('employee_id','=',$id)
            ->whereBetween('punchstatus.date', array($datefrom, $dateto))
            ->lists('break_in_punch_id');

            $breakout =DB::table('punchstatus')
            ->select('break_out_punch_id')
            ->where('employee_id','=',$id)
            ->whereBetween('punchstatus.date', array($datefrom, $dateto))
            ->lists('break_out_punch_id');
            if($punchin != null && $punchout != null)
            {
                $timein = DB::table('punches')
                ->whereIn('id',$punchin)
                ->get();
                
                $timeout = DB::table('punches')
                ->whereIn('id',$punchout)
                ->get();

                $inbreak = DB::table('punches')
                ->select('time')
                ->where('id','=',$breakin)
                ->get();

                $outbreak = DB::table('punches')
                ->select('time')
                ->where('id','=',$breakout)
                ->get();
                
                foreach($timeout as $time_out)
                {
                    foreach($timein as $time_in)
                    {
                        foreach($schedto as $sched)
                        {

                            $timeout = $time_out->time +12;
                            if($timeout > $sched)
                            {
                                $breakminutes = 0;
                                foreach($break as $breaks)
                                {
                                    if($ifreqbreak == 'No')
                                    {
                                        
                                    //split break in in hours and minutes
                                        $separatedData = explode(':', $breaks->break_in);
                                        $minutesInHours    = $separatedData[0] * 60;
                                        $minutesInDecimals = $separatedData[1];
                                        $breakinMinutes = $minutesInHours + $minutesInDecimals;

                                        $separatedData = explode(':', $breaks->break_out);
                                        $minutesInHours    = $separatedData[0] * 60;
                                        $minutesInDecimals = $separatedData[1];
                                        $breakoutMinutes = $minutesInHours + $minutesInDecimals;
                                        $breakminutes = $breakoutMinutes - $breakinMinutes;
                                    }
                                    else
                                    {

                                        if($inbreak != null && $outbreak != null)
                                        { 
                                            foreach($inbreak as $inbreaks)
                                            {
                                                $separatedData = explode(':', $inbreaks->time);
                                                $minutesInHours    = $separatedData[0] * 60;
                                                $minutesInDecimals = $separatedData[1];
                                                $breakinMinutes = $minutesInHours + $minutesInDecimals;
                                            }
                                            
                                            foreach($outbreak as $outbreaks)
                                            {
                                                $separatedData = explode(':', $outbreaks->time);
                                                $minutesInHours    = ($separatedData[0] +12) * 60;
                                                $minutesInDecimals = $separatedData[1];
                                                $breakoutMinutes = $minutesInHours + $minutesInDecimals;
                                                
                                            }
                                            
                                            $breakminutes = $breakoutMinutes - $breakinMinutes;

                                        }
                                        else
                                        {
                                            $separatedData = explode(':', $breaks->break_in);
                                            $minutesInHours    = $separatedData[0] * 60;
                                            $minutesInDecimals = $separatedData[1];
                                            $breakinMinutes = $minutesInHours + $minutesInDecimals;

                                            $separatedData = explode(':', $breaks->break_out);
                                            $minutesInHours    = $separatedData[0] * 60;
                                            $minutesInDecimals = $separatedData[1];
                                            $breakoutMinutes = $minutesInHours + $minutesInDecimals;
                                            $breakminutes = $breakoutMinutes - $breakinMinutes;

                                        }
                                    }
                            
                                }

                                if($ifot != null)
                                {
                                    foreach($allowedothr as $hr)
                                    {
                                        foreach($schedto as $schedout)
                                        {
                                            $allowed = $hr->Allowed_number_of_hours*60;
                                            $activeafter = $hr->active_after*60;
                                            $separatedData = explode(':', $schedout);
                                            $minutesInHours    = ($separatedData[0]) * 60;
                                            $minutesInDecimals = $separatedData[1];
                                            $totalMinutes1 = $minutesInHours + $minutesInDecimals;
                                            $span = ($totalMinutes1 + $allowed) + $activeafter;
                                            //$span = ($schedout + $hr->Allowed_number_of_hours) + $hr->active_after;
                                            $hours = floor($span / 60);
                                            $decimalMinutes = $span - floor($span/60) * 60;
                                            $spanhr = sprintf("%d:%02.0f", $hours, $decimalMinutes);
                                        //$span = ($schedout->m_timeout + $hr->Allowed_number_of_hours) + $hr->active_after;
                                            
                                            //if($time_out->time > $span)
                                            //{
                                            //  $overtime = ($span - $schedout->m_timeout) - $hr->active_after;
                                            //}
                                            if($timeout > $spanhr)
                                            {
                                                $overtimemin = ($span - $totalMinutes1) - $activeafter;
                                                $hours = floor($overtimemin / 60);
                                                $decimalMinutes = $overtimemin - floor($overtimemin/60) * 60;
                
                                                $overtimeMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
                                                
                                                //$overtime = ($span - $schedout) - $hr->active_after;
                                            }
                                            else
                                            {   // Split time out in hours and minutes.
                                                $separatedData = explode(':', $time_out->time);
                                                $minutesInHours    = ($separatedData[0] +12 ) * 60;
                                                $minutesInDecimals = $separatedData[1];
                                                $totalMinutes2 = $minutesInHours + $minutesInDecimals;
                                                
                                                $separatedData = explode(':', $schedout);
                                                $minutesInHours    = ($separatedData[0]) * 60;
                                                $minutesInDecimals = $separatedData[1];
                                                $totalMinutes1 = $minutesInHours + $minutesInDecimals;
                                            
                                                $activeafter = $hr->active_after*60;
                                                $overtimemin = ($totalMinutes2 - $totalMinutes1) - $activeafter;

                                                $hours = floor($overtimemin / 60);
                                                $decimalMinutes = $overtimemin - floor($overtimemin/60) * 60;
                                                
                                                $overtimeMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
                                                

                                                //$overtime = ($time_out->time - $schedout->m_timeout) - $hr->active_after;
                                            }
                                            $separatedData = explode(':', $sched);


                                            $minutesInHours    = $separatedData[0] * 60;
                                            $minutesInDecimals = $separatedData[1];

                                            $totalMinutes = $minutesInHours + $minutesInDecimals;
                                    
                                            // Split time out in hours and minutes.
                                            $separatedData = explode(':', $time_in->time);

                                            $minutesInHours    = ($separatedData[0] +12 ) * 60;
                                            $minutesInDecimals = $separatedData[1];
        
                                            $totalMinutes2 = $minutesInHours + $minutesInDecimals;
                                    
                                            //convert minutes to hours:minutes
                                            $mulated = $totalMinutes - $totalMinutes2;
                                            
                                            $mulated = $mulated + 720;
                                            $mulated = $mulated - $breakminutes;
                                            $hours = floor($mulated / 60);
                                            $decimalMinutes = $mulated - floor($mulated/60) * 60;
                                            
                                            $hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);

                                            $acchrs = $hoursMinutes;
                                            $total = $mulated + $overtime;
                                            $hours = floor($total / 60);
                                            $decimalMinutes = $total - floor($total/60) * 60;
                                            
                                            $totalMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
                                            //$total = $totalMinutes;

                                            //$acchrs = $schedout->m_timeout - $time_in->time;
                                
                                            //if($acchrs < 0 )
                                            //{
                                            //  $acchrs = $acchrs + 12;
                                            //}
                                        }
                                    }
                                }
                                else
                                {
                                    $separatedData = explode(':', $sched);


                                    $minutesInHours    = $separatedData[0] * 60;
                                    $minutesInDecimals = $separatedData[1];

                                    $totalMinutes = $minutesInHours + $minutesInDecimals;
                                    
                                    // Split time out in hours and minutes.
                                    $separatedData = explode(':', $time_in->time);

                                    $minutesInHours    = ($separatedData[0] +12 ) * 60;
                                    $minutesInDecimals = $separatedData[1];

                                    $totalMinutes2 = $minutesInHours + $minutesInDecimals;
                                    
                                    //convert minutes to hours:minutes
                                    $mulated = $totalMinutes - $totalMinutes2;
                                    
                                    $mulated = $mulated + 720;
                                    $mulated = $mulated - $breakminutes;
                                    $hours = floor($mulated / 60);
                                    $decimalMinutes = $mulated - floor($mulated/60) * 60;
                                    
                                    $hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);

                                    $acchrs = $hoursMinutes;
                                    $total = $hoursMinutes;
                                    //foreach($schedto as $schedout)
                                    //{
                                    //  $acchrs = $schedout->m_timeout - $time_in->time;
                                    //  if($acchrs < 0 )
                                    //  {
                                    //      $acchrs = $acchrs + 12;
                            
                                        //}
                                
                                    //}
                                }
                            }
                            else
                            {
                                $breakminutes = 0;
                                foreach($break as $breaks)
                                {
                                    if($ifreqbreak == 'No')
                                    {
                                        
                                    //split break in in hours and minutes
                                        $separatedData = explode(':', $breaks->break_in);
                                        $minutesInHours    = $separatedData[0] * 60;
                                        $minutesInDecimals = $separatedData[1];
                                        $breakinMinutes = $minutesInHours + $minutesInDecimals;

                                        $separatedData = explode(':', $breaks->break_out);
                                        $minutesInHours    = $separatedData[0] * 60;
                                        $minutesInDecimals = $separatedData[1];
                                        $breakoutMinutes = $minutesInHours + $minutesInDecimals;
                                        $breakminutes = $breakoutMinutes - $breakinMinutes;
                                    }
                                    else
                                    {

                                        if($inbreak != null && $outbreak != null)
                                        { 
                                            foreach($inbreak as $inbreaks)
                                            {
                                                $separatedData = explode(':', $inbreaks->time);
                                                $minutesInHours    = $separatedData[0] * 60;
                                                $minutesInDecimals = $separatedData[1];
                                                $breakinMinutes = $minutesInHours + $minutesInDecimals;
                                            }
                                            
                                            foreach($outbreak as $outbreaks)
                                            {
                                                $separatedData = explode(':', $outbreaks->time);
                                                $minutesInHours    = ($separatedData[0] +12) * 60;
                                                $minutesInDecimals = $separatedData[1];
                                                $breakoutMinutes = $minutesInHours + $minutesInDecimals;
                                                
                                            }
                                            
                                            $breakminutes = $breakoutMinutes - $breakinMinutes;

                                        }
                                        else
                                        {
                                            $separatedData = explode(':', $breaks->break_in);
                                            $minutesInHours    = $separatedData[0] * 60;
                                            $minutesInDecimals = $separatedData[1];
                                            $breakinMinutes = $minutesInHours + $minutesInDecimals;

                                            $separatedData = explode(':', $breaks->break_out);
                                            $minutesInHours    = $separatedData[0] * 60;
                                            $minutesInDecimals = $separatedData[1];
                                            $breakoutMinutes = $minutesInHours + $minutesInDecimals;
                                            $breakminutes = $breakoutMinutes - $breakinMinutes;

                                        }
                                    }
                            
                                }
                                $separatedData = explode(':', $time_in->time);
                                $minutesInHours    = $separatedData[0] * 60;
                                $minutesInDecimals = $separatedData[1];
                                $totalMinutes = $minutesInHours + $minutesInDecimals;

                            // Split time out in hours and minutes.
                                $separatedData = explode(':', $time_out->time);
                                $minutesInHours    = $separatedData[0] * 60;
                                $minutesInDecimals = $separatedData[1];
                                $totalMinutes2 = $minutesInHours + $minutesInDecimals;
                            
                            //convert minutes to hours:minutes
                                $mulated = $totalMinutes2 - $totalMinutes;
                                $mulated = ($mulated + 720)-$breakminutes;
                                $overtimemin = 0;
                                //$hours = floor($mulated / 60);
                                //$decimalMinutes = $mulated - floor($mulated/60) * 60;
                                
                                //$hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
                                //$acchrs = $hoursMinutes ;
                                //$total = $hoursMinutes;
                                
                                //$acchrs = $time_out->time - $time_in->time;
                                //if($acchrs < 0 )
                                //{
                                //  $acchrs = $acchrs + 12; 
                                //}                         
                            }
                        }
                    }

                    $othrs = $othrs + $overtimemin;
                    $hrs = $hrs + $mulated;
                    $totalminutes = $totalminutes + $mulated + $overtimemin;

                    $hours = floor($totalminutes / 60);
                    $decimalMinutes = $totalminutes - floor($totalminutes/60) * 60;
                    $hoursMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
                    $total = $hoursMinutes; 

                                    
                }

                $hours = floor($hrs / 60);
                $decimalMinutes = $hrs - floor($hrs/60) * 60;
                $acchrsMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
                $acchrs = $acchrsMinutes;
                
                $hours = floor($othrs / 60);
                $decimalMinutes = $othrs - floor($othrs/60) * 60;
                $otMinutes = sprintf("%d:%02.0f", $hours, $decimalMinutes);
                $overtime = $otMinutes;
                
            }

            //dd($acchrs.' '.$overtime.' '.$total);

                $this->Ln();
                $this->Cell(40);
                $this->SetFont('Arial','B',14);
                $this->Cell(30,10,'Employee: ','C');    
                $this->SetFont('Arial','',14);
                $this->Cell(40,10,$lname .', '. $fname,'C');    
                $this->Ln();
                $this->Ln();
                $this->Cell(40);
                foreach ($header as $col)
                {
                        if($col == 'Accumulated')   
                            $this->Cell(60,10,$col,1,0,'L');
                        else if ($col == 'Time')
                            $this->Cell(60,10,$col,1,0,'C');
                }
                
                $this->Ln();
                $this->Cell(40);
                $this->Cell(60,10,'Regular',1,0,'L');
                $this->SetFont('Arial','B',14);
                $this->Cell(60,10,$acchrs.' hours/minutes',1,0,'C');
                $this->SetFont('Arial','',14);
                $this->Ln();
                $this->Cell(40);
                $this->Cell(60,10,'Overtime',1,0,'L');
                $this->SetFont('Arial','B',14);
                $this->Cell(60,10,$overtime.' hours/minutes',1,0,'C');
                $this->Ln();
                $this->Cell(40);
                $this->SetFont('Arial','',14);
                $this->Cell(60,10,'TOTAL: ','C');    
                $this->SetFont('Arial','B',14);
                $this->Cell(6);
                $this->Cell(60,10,$total.' hours/minutes','C');    
    }



// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number + Logo
    $this->Image('img/teams_pahalang.png',159,283.5,16,7);
    $this->Cell(0,10,'|    Page '.$this->PageNo().' of {nb}',0,0,'R');
}

}
// Instanciation of inherited class
$employee = Session::get('emp_query', 'default'); 
$lname = Session::get('emp_lname', 'default');
$fname = Session::get('emp_fname', 'default');
        
$pdf = new PDF();
$header = array('Accumulated', 'Time');
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',9);
$pdf->AddPage();
$pdf->BasicTable($header);
$dynamic_name = $employee.$lname.$fname;
$filename='reports/'.$dynamic_name.'_accumulatedhrs.pdf';
$pdf->Output($filename);

?>

<br><iframe src="../reports/<?=$dynamic_name?>_accumulatedhrs.pdf" title="downloads"  height= "450" width="100%"  frameborder="0" margin-left= "100px" target="Message"></iframe>

<script type="text/javascript">
    $(function(){
    $(".dropdown").hover(            
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            },
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            });
    });
    
</script>

@stop