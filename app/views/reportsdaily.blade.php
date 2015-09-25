@extends("layout_employee")
@section("content")
<br><br><br>
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
        
        $empnames = DB::table('employs')
            ->where('id', '=', $id)
            ->get();
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
    $this->Cell(75);
    // Title
    foreach($empnames as $empname)
    {
        $this->Cell(20,10,$empname->lname .', '. $empname->fname,'C');    
    }
    $this->Ln(4);

    $this->SetFont('Arial','',15);
    // Move to the right
    $this->Cell(62);
    // Title
    $this->Cell(20,10,'________________________','C');

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
    $this->Cell(20,10,'For the month of ' . date('F') . ' ' . date('Y'),'C');

    $this->Ln(8);

    $this->SetFont('Arial','',15);
    // Move to the right
    $this->Cell(45);
    // Title
    $this->Cell(20,10,'Regular Day/s _______ Saturday/s _______','C');

    $this->Ln(12);

    $this->SetFont('Arial','',15);
    // Move to the right
    $this->Cell(55);
    // Title
    $this->Cell(20,10,'Official Hours of arrival and departure','C');
}
                
function BasicTable($header)
    {
        $id = Session::get('empid', 'default');
        $empnames = DB::table('employs')
            ->where('employee_number', '=', $id)->get();
        $temp_name = "";

        foreach ($empnames as $empname) 
        {
            if($empname->lname != $temp_name)
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
$header = array('Day', 'A.M.', 'P.M', 'Undertime');
$pdf->AliasNbPages();

$pdf->SetFont('Arial','',12);
$pdf->AddPage();
$pdf->BasicTable($header);

$pdf->Output('reports/dtr.pdf');
?>

<iframe src="../reports/dtr.pdf" title="downloads"  height= "450" width="100%"  frameborder="0" margin-left= "100px" target="Message"></iframe>


@stop