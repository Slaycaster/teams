@extends("layout_employee")
@section("content")
<br><br><br>

<head>
    <title>Reports | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Reports Daily Time Records </h1>



<div class='col-md-6'>
    {{ Form::open(array('url' => 'employee/dailytimerecord', 'method' => 'get')) }}

<h3>Select a Month</h3>
     {{ Form::selectMonth('month', Input::get('month'));}}<br><br>
</div>

<div class='col-md-6'>
<h3>Select a Year</h3>

     {{ Form::selectYear('year', date('Y'), 1960 , Input::get('year'))}}<br><br>
</div>

{{ Form::submit('Generate PDF', array('class' => 'btn btn-success')) }}
{{ Form::close() }}


<?php

require('fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    if (Session::has('empid')) 
    {   

        $id = Session::get('empid', 'default');
        $month = Session::get('month_query', 'default');
        $year = Session::get('year_query', 'default');
        $empnames = DB::table('employs')
            ->where('id', '=', $id)
            ->get();
        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        
    }
        
    // Logo
    
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(45);
    // Title
    $this->Cell(20,10,'Time And Attendance Monitoring System','C');

    $this->Ln(8);
	// Move to the right
    $this->Cell(75);
    // Title
    $this->Cell(20,10,'Daily Time Record','C');
    // Line break
    $this->Ln(8);
    // Move to the right
    $this->Cell(65);
    // Title
    foreach($empnames as $empname)
    {
        $this->Cell(40,10,$empname->lname .', '. $empname->fname,'C');    
    }
    $this->Ln(4);

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

    $this->SetFont('Arial','',15);
    // Move to the right
    $this->Cell(60);
    // Title
    $this->Cell(20,10,'For the month of ' . $monthName . ' ' . $year,'C');

    $this->Ln(8);

    $this->SetFont('Arial','',15);
    // Move to the right
    

    $this->SetFont('Arial','',15);
    // Move to the right
    $this->Cell(55);
    // Title
    $this->Cell(20,10,'Official Hours of Arrival and Departure','C');
    $this->Ln();
}
                
function BasicTable($header)
    {
                
        if (Session::has('empid')) 
            {
                $id = Session::get('empid', 'default');
                $month = Session::get('month_query', 'default');
                $year = Session::get('year_query', 'default');
                $get_year = Session::get('year_query', 'default');
                $empnames = DB::table('employs')
                    ->where('id', '=', $id)
                    ->get();
            
                $time_in = DB::table('punches')
                    ->join('punchstatus', 'punches.id', '=', 'punchstatus.time_in_punch_id')
                    ->where('punches.employee_id', '=', $id)
                    ->get();
               

                $time_out = DB::table('punches')
                    ->join('punchstatus', 'punches.id', '=', 'punchstatus.time_out_punch_id')
                    ->where('punches.employee_id', '=', $id)
                    ->get();
                
                 $punch_day = DB::table('punchstatus')
                    ->select(DB::raw('DAY(date) as day, id'))
                    ->where('punchstatus.employee_id', '=', $id)
                    ->where('punchstatus.time_in', 'NOT like', 'Absent%')
                    ->where( DB::raw('MONTH(punchstatus.date)'), '=', $month)
                    ->where( DB::raw('YEAR(punchstatus.date)'), '=', $get_year)
                    ->lists('day', 'id');
            }
        
            
                $this->Cell(20);
                foreach ($header as $col)
                {   
                        $this->Cell(30,10,$col,1,0,'L');
                }
                $this->Ln();
                $this->SetFont('Arial','',12);
                
                
                foreach ($time_in as $time_ins) 
                   { 
                                    
                        foreach ($time_out as $time_outs) 
                        foreach ($punch_day as $punch_days) 
                        {
                            $this->Cell(20);
                            if ($punch_days != null)
                            {
                                $this->Cell(30,10,$punch_days,1,0,'L');
                            }
                            else
                            {
                                $this->Cell(30,10,'NULL',1,0,'L');
                            }
                            if ($time_ins->time != null)
                            {
                                $this->Cell(30,10,$time_ins->time,1,0,'L');
                                
                            }
                            else
                            {
                                $this->Cell(30,10,'NULL',1,0,'L');
                            }
                            if ($time_ins->time_in != null)
                            {
                                $this->Cell(30,10,$time_ins->time_in,1,0,'L');
                            }
                            else
                            {
                                $this->Cell(30,10,'NULL',1,0,'L');
                            }
                            if ($time_outs->time != null)
                            {             
                                $this->Cell(30,10,$time_outs->time,1,0,'L');
                            }
                            else
                            {
                                $this->Cell(30,10,'NULL',1,0,'L');
                            }
                            if ($time_outs->time_out != null)
                            {             
                                $this->Cell(30,10,$time_outs->time_out,1,0,'L');       
                            }
                            else
                            {
                                $this->Cell(30,10,'NULL',1,0,'L');
                            }
                            $this->Ln();
                      }
                    }
    }



// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

}
// Instanciation of inherited class
$pdf = new PDF();
$header = array('Day', 'Arrival', 'Status', 'Departure', 'Status');
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',12);
$pdf->AddPage();
$pdf->BasicTable($header);
$pdf->Output('reports/dtr.pdf');
?>

<br><br><iframe src="../reports/dtr.pdf" title="downloads"  height= "450" width="100%"  frameborder="0" margin-left= "100px" target="Message"></iframe>

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