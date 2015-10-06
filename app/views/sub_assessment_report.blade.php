@extends("layout_employee")
@section("content")


<head>
    <title>Punctuality Assessment Report - Subordinates | Time and Electronic Attendance Monitoring System</title>
</head>
<br><br><br>
<h1>Punctuality Assessment - Subordinates</h1>

<div class='col-md-4'>
{{ Form::open(array('url' => 'employee/reports/assessment_sub', 'method' => 'get')) }}
<h3>Select an Employee</h3>
     {{ Form::select('employs_id', $user, Input::get('employs_id'));}}<br><br>
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
    $this->SetFont('Arial','B',10);
	// Move to the right
    $this->Cell(68);
    // Title
    $this->Cell(20,10,'Punctuality Assessment Report','C');
    // Line break
    $this->Ln(8);
    
    $this->SetFont('Arial','',10);
    
    $this->Cell(70);
    // Title
    $this->Cell(20,10,'For the month of ' . $monthName . ' ' . $year ,'C');

    
    $this->Ln();
}
                
function BasicTable($header)
    {
                //$emp_id = Session::get('emp_query', 'default'); 
                $month = Session::get('month_query', 'default');
                $year = Session::get('year_query', 'default');
                $lname = Session::get('sub_emp_lname', 'default');
                $fname = Session::get('sub_emp_fname', 'default');
                $get_year = Session::get('year_query', 'default');
                $datefrom = $year.'/'.$month.'/01';
                $dateto = $year.'/'.$month.'/31'; 
                
                $id = Session::get('subid', 'default');
                $datenow = new DateTime("now", new DateTimeZone("Asia/Singapore"));
                //$now = Input::get('datefrom');
            
                $ontime=DB::table('punchstatus')
                    ->select('time_in')
                    ->whereBetween('punchstatus.date', array($datefrom , $dateto))
                    ->where('time_in','=','On-Time')
                    ->where('employee_id','=',$id)
                    ->count();
                $late=DB::table('punchstatus')
                    ->select('time_in')
                    ->whereBetween('punchstatus.date', array($datefrom , $dateto))
                    ->where('time_in','=','Late')
                    ->where('employee_id','=',$id)
                    ->count();
                $earlyout = DB::table('punchstatus')
                    ->select('time_out')
                    ->whereBetween('punchstatus.date', array($datefrom , $dateto))
                    ->where('time_out','=','Early out')
                    ->where('employee_id','=',$id)
                    ->count();
                $absent=DB::table('punchstatus')
                    ->select('time_in')
                    ->whereBetween('punchstatus.date', array($datefrom , $dateto))
                    ->where('time_in','=','Absent')
                    ->where('employee_id','=',$id)
                    ->count();
                $earlybreak = DB::table('punchstatus')
                    ->select('break_in')
                    ->whereBetween('punchstatus.date', array($datefrom , $dateto))
                    ->where('break_in','=','Early break')
                    ->where('employee_id','=',$id)
                    ->count();
                $longbreak = DB::table('punchstatus')
                    ->select('break_out')
                    ->whereBetween('punchstatus.date', array($datefrom , $dateto))
                    ->where('break_out','=','Long break')
                    ->where('employee_id','=',$id)
                    ->count();
                $schedules = DB::table('empschedules')
                    ->join('schedules', 'empschedules.schedule_id', '=', 'schedules.id')
                    ->select('schedules.sun_timein', 'schedules.sun_timeout', 'schedules.m_timein', 'schedules.m_timeout', 'schedules.t_timein', 'schedules.t_timeout', 'schedules.w_timein', 'schedules.w_timeout', 'schedules.th_timein', 'schedules.th_timeout', 'schedules.f_timein', 'schedules.f_timeout', 'schedules.sat_timein', 'schedules.sat_timeout')
                    ->where('empschedules.employee_id', '=', $id)
                    ->get();

                $workingdays = 0;
                foreach ($schedules as $schedule)
                {
                    if ( !(($schedule->sun_timein == '00:00:00') && ($schedule->sun_timeout == '00:00:00'))) {
                        $workingdays = $workingdays + 1;
                    }
                    if ( !(($schedule->m_timein == '00:00:00') && ($schedule->m_timeout == '00:00:00'))) {
                        $workingdays = $workingdays + 1;
                    }
                    if ( !(($schedule->t_timein == '00:00:00') && ($schedule->t_timeout == '00:00:00'))) {
                        $workingdays = $workingdays + 1;
                    }
                    if ( !(($schedule->w_timein == '00:00:00') && ($schedule->w_timeout == '00:00:00'))) {
                        $workingdays = $workingdays + 1;
                    }
                    if ( !(($schedule->th_timein == '00:00:00') && ($schedule->th_timeout == '00:00:00'))) {
                        $workingdays = $workingdays + 1;
                    }
                    if ( !(($schedule->f_timein == '00:00:00') && ($schedule->f_timeout == '00:00:00'))) {
                        $workingdays = $workingdays + 1;
                    }
                    if ( !(($schedule->sat_timein == '00:00:00') && ($schedule->sat_timeout == '00:00:00'))) {
                        $workingdays = $workingdays + 1;
                    }
                    if ( !(($schedule->sun_timein == '00:00:00') && ($schedule->sun_timeout == '00:00:00'))) {
                        $workingdays = $workingdays + 1;
                    }
                }

                $this->Ln();
                $this->Cell(55);
                $this->SetFont('Arial','B',10);
                $this->Cell(20,10,'Employee: ','C');    
                $this->SetFont('Arial','',10);
                $this->Cell(20,10,$lname .', '. $fname,'C');    
                $this->Ln();
                $this->Cell(55);
                foreach ($header as $col)
                {
                        if($col == '')   
                            $this->Cell(40,5,$col,1,0,'L');
                        else if ($col == 'Day/s')
                            $this->Cell(20,5,$col,1,0,'C');
                        else if ($col == 'Percentage')
                            $this->Cell(20,5,$col,1,0,'C');
                }
                
                $this->Ln();
                $this->Cell(55);
                if ($ontime != 0)
                    $ontime_percentage = ($ontime/($workingdays*4))*100;
                else
                    $ontime_percentage = 0;
                $this->Cell(40,5,'On-time',1,0,'L');
                $this->Cell(20,5,$ontime,1,0,'C');
                $this->Cell(20,5,round($ontime_percentage, 2).'%',1,0,'C');
                $this->Ln();
                $this->Cell(55);
                if ($workingdays != 0)
                    $late_percentage = ($late/($workingdays*4))*100;
                else
                    $late_percentage = 0;
                $this->Cell(40,5,'Late',1,0,'L');
                $this->Cell(20,5,$late,1,0,'C');
                $this->Cell(20,5,round($late_percentage, 2).'%',1,0,'C');
                $this->Ln();
                $this->Cell(55);
                if ($absent != 0)
                    $absent_percentage = ($absent/($workingdays*4))*100;
                else
                    $absent_percentage = 0;
                $this->Cell(40,5,'Absent',1,0,'L');
                $this->Cell(20,5,$absent,1,0,'C');
                $this->Cell(20,5,round($absent_percentage, 2).'%',1,0,'C');
                $this->Ln();
                $this->Cell(55);
                if ($earlyout != 0)
                    $earlyout_percentage = ($earlyout/($workingdays*4))*100;
                else
                    $earlyout_percentage = 0;
                $this->Cell(40,5,'Undertime/Early-out',1,0,'L');
                $this->Cell(20,5,$earlyout,1,0,'C');
                $this->Cell(20,5,round($earlyout_percentage, 2).'%',1,0,'C');
                $this->Ln();
                $this->Ln();
                $this->Cell(55);
                $this->SetFont('Arial','B',10);
                $this->Cell(27,10,'Working Days: ','C');    
                $this->SetFont('Arial','',10);
                $this->Cell(20,10,($workingdays*4).' days','C');    
                $this->Ln();
                $this->Cell(55);
                $this->SetFont('Arial','B',10);
                $this->Cell(37,10,'Overall Assessment: ','C');    
                $this->SetFont('Arial','',10);
                $this->Cell(20,10,round($ontime_percentage+$late_percentage+$absent_percentage+$earlyout_percentage, 2).'%','C');
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
$employee = Session::get('subid', 'default'); 
$lname = Session::get('sub_emp_lname', 'default');
$fname = Session::get('sub_emp_fname', 'default');

$pdf = new PDF();
$header = array('', 'Day/s', 'Percentage');
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',9);
$pdf->AddPage();
$pdf->BasicTable($header);
$dynamic_name = $employee.$lname.$fname;
$filename='reports/'.$dynamic_name.'_assessment.pdf';
$pdf->Output($filename);

?>

<br><br><iframe src="../../reports/<?=$dynamic_name?>_assessment.pdf" title="downloads"  height= "450" width="100%"  frameborder="0" margin-left= "100px" target="Message"></iframe>

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