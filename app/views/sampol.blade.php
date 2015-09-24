@extends("layout")
@section("content")

<?php
require('fpdf.php');

class PDF extends FPDF
{

// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}
// Page header
function Header()
{
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
    $this->Cell(20,10,'Insert name here','C');

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
    $this->Cell(20,10,'For the month of ______ 20____','C');

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

    $this->Ln(8);

    $this->SetFont('Arial','',15);
    // Move to the right
    $this->Cell(9);

 
                

}
function BasicTable($header, $data)
{
    // Header
    foreach($header as $col)
        $this->Cell(43.8,7,$col,1);
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        $this->Cell(9);
        foreach($row as $col)
            $this->Cell(25,6,$col,1);
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
$header = array('Day', 'A.M.', 'P.M.', 'Undertime');
$pdf->AliasNbPages();

$data = $pdf->LoadData('number.txt');
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->BasicTable($header,$data);
$pdf->Output('akwe.pdf');
?>
<iframe src="akwe.pdf" title="downloads"  height= "450" width="100%"  frameborder="0" margin-left= "100px" target="Message"></iframe>
<div>

</div>


@stop