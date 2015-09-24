@extends("layout")
@section("content")

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
		$this->SetFont('Arial','B',12);
    	// Move to the right
    	$this->Cell(82);
    	// Title
    	$this->Cell(20,10,'Branch List','C');

    	$this->Ln(8);

    	$this->Cell(60);
    	// Title
    	$this->Cell(20,10,'For the month of ' . date('F') . ' ' . date('Y'),'C');

    	$this->Ln(8);
	}

	function BasicTable($header, $branchess, $branches, $departments, $employ_joins)
	{
		$employ_joins = DB::table('branches')
			->join('departments', 'branches.id', '=', 'departments.branch_id')
			->join('employs', 'departments.id', '=', 'employs.department_id')
			->where('employs.status', '=', 'Active')
			->get();
    	$temp_branch = "";

    	foreach ($employ_joins as $employ_join) 
    	{
 			if($employ_join->branch_name != $temp_branch)
 			{
 				$this->Ln();
 				$this->SetFont('Arial','B',14);
 				$this->Cell(20,10,$employ_join->branch_name,'C');
 				$this->Ln();
 				foreach ($header as $col)
    			{	
    				if($col == 'E-mail')
    					$this->Cell(60,10,$col,1,0,'L');
    				else $this->Cell(40,10,$col,1,0,'L');
    			}
    			$this->Ln();
 				$temp_branch = $employ_join->branch_name;
 			}
 			$this->SetFont('Arial','',12);
    		$this->Cell(40,10,$employ_join->lname,1,0,'L');
    		$this->Cell(40,10,$employ_join->fname,1,0,'L');
    		$this->Cell(60,10,$employ_join->email,1,0,'L');
    		$this->Cell(40,10,$employ_join->phone,1,0,'L');
    		$this->Ln();
    	}
    	
    		
	}
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
$pdf = new PDF();
$header = array('Last Name', 'First Name', 'E-mail', 'Phone #');
$pdf->AliasNbPages();


$pdf->SetFont('Arial','',12);
$pdf->AddPage();
$pdf->BasicTable($header, $employs, $branchess, $branches, $departments);
$pdf->Output('branch.pdf');

?>
<iframe src="branch.pdf" title="downloads"  height= "450" width="100%"  frameborder="0" margin-left= "100px" target="Message"></iframe>

@stop