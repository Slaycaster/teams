@extends("layout")
@section("content")


<head>
    <title>Daily Time Record | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Daily Time Records</h1>

<div class='col-md-4'>
{{ Form::open(array('url' => 'report/dtr', 'method' => 'get')) }}
<h3>Select an Employee</h3>
     {{ Form::select('employs_id', $employs_id, Input::get('employs_id'));}}<br><br>
</div>

<div class='col-md-4'>
<h3>Select a Month</h3>

     {{ Form::selectMonth('month', Input::get('month'));}}<br><br>
</div>

<div class='col-md-4'>
<h3>Select a Year</h3>

     {{ Form::selectYear('year', 2015, 1960)}}<br><br>
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
        $lname = Session::get('emp_lname', 'default');
        $fname = Session::get('emp_fname', 'default');
        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        
    // Logo
    // Arial bold 15
    $this->SetFont('Arial','B',10);
	// Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(20,10,'Daily Time Record','C');
    // Line break
    $this->Ln();
    $this->SetFont('Arial','',10);
    // Move to the right
    $this->Cell(55);
    // Title
    $this->Cell(20,10,$lname .', '. $fname,'C');    
    
    $this->Ln(2);

    $this->SetFont('Arial','',15);
    // Move to the right
    $this->Cell(52);
    // Title
    $this->Cell(20,10,'_______________________________','C');

    $this->Ln(5);

    $this->SetFont('Arial','',10);
    // Move to the right
    $this->Cell(90);
    // Title
    $this->Cell(20,10,'Name','C');

    $this->Ln(8);

    $this->SetFont('Arial','',11);
    // Move to the right
    $this->Cell(65);
    // Title
    $this->Cell(20,10,'For the month of ' . $monthName . ' ' . $year ,'C');

    $this->Ln(4);
    // Move to the right
    $this->Cell(61);
    // Title
    $this->Cell(20,10,'Official Hours of Arrival and Departure','C');
    $this->Ln();
}
                
function BasicTable($header)
    {
                $emp_id = Session::get('emp_query', 'default'); 
                $month = Session::get('month_query', 'default');
                $year = Session::get('year_query', 'default');
                $get_year = Session::get('year_query', 'default');
                $start_date = $year.'/'.$month.'/01';
                $end_date = $year.'/'.$month.'/31'; 
                
            
                $time_ins = DB::table('punches')
                    ->join('punchstatus', 'punches.id', '=', 'punchstatus.time_in_punch_id')
                    ->where('punches.employee_id', '=', $emp_id)
                    //->where('punchstatus.time_in', 'NOT like', 'Absent%')
                    ->get();
                $break_ins = DB::table('punches')
                    ->join('punchstatus', 'punches.id', '=', 'punchstatus.break_in_punch_id')
                    ->where('punches.employee_id', '=', $emp_id)
                    //->where('punchstatus.time_in', 'NOT like', 'Absent%')
                    ->get();

                $time_outs = DB::table('punches')
                    ->join('punchstatus', 'punches.id', '=', 'punchstatus.time_out_punch_id')
                    ->where('punches.employee_id', '=', $emp_id)
                    //->where('punchstatus.time_in', 'NOT like', 'Absent%')
                    ->get();
                $break_outs = DB::table('punches')
                    ->join('punchstatus', 'punches.id', '=', 'punchstatus.break_out_punch_id')
                    ->where('punches.employee_id', '=', $emp_id)
                    //->where('punchstatus.time_in', 'NOT like', 'Absent%')
                    ->get();

                $schedules = DB::table('empschedules')
                    ->join('schedules', 'empschedules.schedule_id', '=', 'schedules.id')
                    ->select('schedules.sun_timeout', 'schedules.m_timeout', 'schedules.t_timeout', 'schedules.w_timeout', 'schedules.th_timeout', 'schedules.f_timeout', 'schedules.sat_timeout')
                    ->where('empschedules.employee_id', '=', $emp_id)
                    ->get();
                    
                $this->Cell(30);
                foreach ($header as $col)
                {
                        if($col == 'Day')   
                            $this->Cell(10,5,$col,1,0,'L');
                        else if ($col == 'A.M.')
                            $this->Cell(40,5,$col,1,0,'C');
                        else if ($col == 'P.M.')
                            $this->Cell(40,5,$col,1,0,'C');
                        else if ($col == 'Undertime')
                            $this->Cell(40,5,$col,1,0,'C');                               
                }
                $this->Ln();
                $this->Cell(30);
                $this->Cell(10,5,'',1,0,'L');
                $this->Cell(20,5,'Arrival',1,0,'C');
                $this->Cell(20,5,'Departure',1,0,'C');
                $this->Cell(20,5,'Arrival',1,0,'C');
                $this->Cell(20,5,'Departure',1,0,'C');
                $this->Cell(20,5,'Hours',1,0,'C');
                $this->Cell(20,5,'Minutes',1,0,'C');
                $this->Ln();

                
                for($date = 1; $date <= 31; $date++)
                {

                    $curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));
                    $format_day = strtotime($curr_date);
                    $day_name = date('l', $format_day);
        
                    $this->Cell(30);
                    $this->SetFont('Arial','',9); 
                    $this->Cell(10,5,$date,1,0,'L');
                    $hasTimeIn = false;
                    $hasBreakIn = false;
                    $hasTimeOut = false;
                    $hasBreakOut = false;
                    $hasUnderTime = false;
                    $time_out_cmp = '';
                    
                    $this->SetFont('Arial','B',9);
                    /*TIME-IN*/
                    foreach($time_ins as $time_in)
                    {   
                        if($curr_date == $time_in->date)
                        {
                            $this->Cell(20,5,$time_in->time,1,0,'L'); //time-in    
                            $hasTimeIn = true;
                            foreach($break_ins as $break_in)
                            {
                                if($curr_date == $break_in->date)
                                {
                                    $this->Cell(20,5,$break_in->time,1,0,'L'); //time-in status
                                    $hasBreakIn = true;        
                                }
                            }
                        }
                    }
                    if($hasTimeIn == false)
                    {
                        $this->Cell(20,5,' ',1,0,'L'); //time-in    
                    }
                    if($hasBreakIn == false)
                    {
                        $this->Cell(20,5,' ',1,0,'L');   
                    }

                    /*TIME-OUT
                        Medyo naiba logic dito, kasi dito break-out muna bago time-out ((:
                    */
                    $count = 0;
                    foreach($break_outs as $break_out)
                    {
                        if($curr_date == $break_out->date)
                        {
                            $this->Cell(20,5,$break_out->time,1,0,'L');
                            $hasBreakOut = true;
                        }
                    }
                    if($hasBreakOut == false)
                    {
                        $this->Cell(20,5,' ',1,0,'L');   
                    }
                    foreach($time_outs as $time_out)
                        {   
                            if($curr_date == $time_out->date)
                            {
                                $this->Cell(20,5,$time_out->time,1,0,'L'); //time-out
                                $hasTimeOut = true;
                                //dd(date('h:i:s A', strtotime($time_out->time)));  
                                $time_out_cmp = date('h:i:s A', strtotime($time_out->time)+43200);
                                foreach($schedules as $schedule)
                                {
                                    switch ($day_name) {
                                        case 'Sunday':
                                            $sched_timeout = date('h:i:s A', strtotime($schedule->sun_timeout));
                                            break;
                                        case 'Monday':
                                            $sched_timeout = date('h:i:s A', strtotime($schedule->m_timeout));
                                            break;
                                        case 'Tuesday':
                                            $sched_timeout = date('h:i:s A', strtotime($schedule->t_timeout));
                                            break;
                                        case 'Wednesday':
                                            $sched_timeout = date('h:i:s A', strtotime($schedule->w_timeout));
                                            break;
                                        case 'Thursday':
                                            $sched_timeout = date('h:i:s A', strtotime($schedule->th_timeout));
                                            break;
                                        case 'Friday':
                                            $sched_timeout = date('h:i:s A', strtotime($schedule->f_timeout));
                                            break;
                                        case 'Saturday':
                                            $sched_timeout = date('h:i:s A', strtotime($schedule->sat_timeout));
                                            break;
                                        default:
                                        break;
                                    }
                                    $timeout = strtotime($sched_timeout);
                                    $punchout = strtotime($time_out_cmp);
                                    $under = $timeout - $punchout;
                                    if($under > 60)
                                    {
                                        $under_hours = floor(($under/60)/60);
                                        $under_minutes = ($under/60)%60;
                                        $hasUnderTime = true;    
                                    }
                                }
                              
                            }
                            
                        }

                    if($hasTimeOut == false)
                    {
                        $this->Cell(20,5,' ',1,0,'L'); //time-out
                    }

                    if($hasUnderTime)
                    {
                        $this->Cell(20,5,$under_hours,1,0,'C');
                        $this->Cell(20,5,$under_minutes,1,0,'C');
                    }
                    else
                    {
                        $this->Cell(20,5,'',1,0,'L');
                        $this->Cell(20,5,'',1,0,'L');
                    }
                                         
                    $this->Ln();
                }
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
$header = array('Day', 'A.M.', 'P.M.', 'Undertime');
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',9);
$pdf->AddPage();
$pdf->BasicTable($header);
$dynamic_name = $employee.$lname.$fname;
$filename='reports/'.$dynamic_name.'dtr.pdf';
$pdf->Output($filename);

?>

<iframe src="../reports/<?=$dynamic_name?>dtr.pdf" title="downloads"  height= "450" width="100%"  frameborder="0" margin-left= "100px" target="Message"></iframe>

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