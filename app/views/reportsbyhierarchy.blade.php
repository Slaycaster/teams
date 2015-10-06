@extends("layout")
@section("content")

<head>
    <title>Hierarchy List Report | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Hierarchy List Report</h1>
<div class = "row">
    <div class='col-md-3'>
    {{ Form::open(array('url' => 'report/hierarchy', 'method' => 'get')) }}

    <h3>Select a Month</h3>
         {{ Form::selectMonth('month', Input::get('month'));}}<br><br>
    </div>

    <div class='col-md-3'>
    <h3>Select a Year</h3>

         {{ Form::selectYear('year', date('Y'), 1960 , Input::get('year'))}}<br><br>
    </div>

    <div class ='col-md-3'>
        <br><br>
        {{ Form::submit('Generate PDF', array('class' => 'btn btn-success')) }}
        {{ Form::close() }}
    </div>
</div>

<hr>
<?php


require('fpdf.php');

$branchess = null;
$branches = null;
$employs = null;
$departments = null;

class PDF extends FPDF
{
	function Header()
	{
        $month = Session::get('month_query', 'default');
        $year = Session::get('year_query', 'default');
        $monthName = date("F", mktime(0, 0, 0, $month, 10));

		$this->SetFont('Arial','B',12);
    	// Move to the right
    	$this->Cell(82);
    	// Title
    	$this->Cell(20,10,'Hierarchy List','C');

    	$this->Ln(8);

    	$this->Cell(76);
    	// Title
    	$this->Cell(20,10,'As of ' . $monthName. ' ' . $year,'C');

    	$this->Ln(8);
	}

	function BasicTable($header, $hierarchies, $hierarchy_subordinates, $level_id, $employ_joins)
	{
        $month = Session::get('month_query', 'default');
        $year = Session::get('year_query', 'default');

        $start_date = $year.'-'.$month.'-01';
        $end_date = $year.'-'.$month.'-31';

        //Para sa supervisor
        $supervisors = DB::table('hierarchies')
            ->join('employs', 'hierarchies.supervisor_id', '=', 'employs.id')
            ->join('levels', 'employs.level_id', '=', 'levels.id')
            ->whereBetween('hierarchies.created_at', array($start_date, $end_date))
            ->get();

        //Para sa subordinates
        $subordinates = DB::table('hierarchy_subordinates')
            ->join('hierarchies', 'hierarchy_subordinates.hierarchy_id', '=', 'hierarchies.id')
            ->join('employs', 'hierarchy_subordinates.employee_id', '=', 'employs.id')
            ->get();


        foreach ($supervisors as $supervisor)
        {
            $this->Ln();
            $this->SetFont('Arial','B',14);
            $this->Cell(20,10,$supervisor->hierarchy_name,'C');
            $this->Ln();
            $this->SetFont('Arial','',12);
            $this->Cell(20,10,'Supervisor: '. $supervisor->lname .', '.$supervisor->fname,'C');
            $this->Ln();
            $this->Cell(20,10,'Subordinates:','C');
            $this->Ln();
            $this->SetFont('Arial','B',12);
            foreach ($header as $col)
            {   
                if($col == 'E-mail')
                    $this->Cell(60,10,$col,1,0,'L');
                else $this->Cell(40,10,$col,1,0,'L');
            }
            $this->Ln();
            $this->SetFont('Arial','',12);
            foreach($subordinates as $subordinate)
            {
                if ($supervisor->hierarchy_name == $subordinate->hierarchy_name)
                {
                    $this->Cell(40,10,$subordinate->lname,1,0,'L');
                    $this->Cell(40,10,$subordinate->fname,1,0,'L');
                    $this->Cell(60,10,$subordinate->email,1,0,'L');
                    $this->Cell(40,10,$subordinate->phone,1,0,'L');
                    $this->Ln();
                }
                
            }
        }
        
    		
	}
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
$pdf = new PDF();
$header = array('Last Name', 'First Name', 'E-mail', 'Phone #');
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',12);
$pdf->AddPage();
$pdf->BasicTable($header, $employs, $branchess, $branches, $departments);
$pdf->Output('reports/hierarchy.pdf');

?>
<iframe src="../reports/hierarchy.pdf" title="downloads"  height= "450" width="100%"  frameborder="0" margin-left= "100px" target="Message"></iframe>

@stop