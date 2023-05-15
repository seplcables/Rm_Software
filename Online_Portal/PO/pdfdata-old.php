<?php
// Include the PDF class
require_once "fpdf182/fpdf.php";
 
 // Connecting with database
						include('..\..\dbcon.php');
						$sql="SELECT * from po_entry";
						$run=sqlsrv_query($con,$sql);
						$row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
// Create instance of PDF class
$pdf = new FPDF('P','mm','A4');
 
// Add 1 page in your PDF
$pdf->AddPage();

// Place image on top left with 100px width
$pdf->Image("1.jpeg", 5, 5, 30);
 
// Set Arial Bold font with size 22px
$pdf->SetFont("Arial", "B", 22);
 
// Give margin from left
$pdf->SetX(70); 
// Write text "Invoice" with 0 width & height (it will still be visible)
$pdf->Cell(0, 5, "PURCHASE ORDER");
// Move the cursor to next line
$pdf->Ln();
// po no
$pdf->SetFont("Arial", "U", 12);
$pdf->SetX(40);
$pdf->Cell(0, 25, "SEL/F/PUR/03");
$pdf->SetX(150);
$pdf->Cell(0, 25, 'Po. No.: - '.$row['po_no']);
$pdf->Ln(7);
$pdf->SetX(40);
$pdf->SetFont("Arial", "I", 10);
$pdf->Cell(0, 25, "GSTIN: 24AACCS9412R1ZV");
$pdf->SetX(150);
$pdf->Cell(0, 25, 'Date: - '.$row['po_date']->format('d-M-Y'));
$pdf->Ln(7);
$pdf->SetX(150);
$pdf->Cell(0, 25, 'Last Delivery Date: - ');
$pdf->Ln(5);
$pdf->SetX(5);
$pdf->Cell(0, 25, '_____________________________________________________________________________________________________');
// Sets the background color to light gray
$pdf->SetFillColor(209, 207, 207);
 
 $pdf->SetFont("Arial", "B", 10);
// Give margin from TOP
 $pdf->SetY(60);
 $pdf->SetX(5);
// Cell
$pdf->Cell(10, 10, "Sr", 1, 0, "C", true); 
$pdf->Cell(45, 10, "Item_Description", 1, 0, "C", true);
$pdf->Cell(20, 10, "project", 1, 0, "C", true);
$pdf->Cell(25, 10, "Job", 1, 0, "C", true);
$pdf->Cell(40, 10, "remaks", 1, 0, "C", true);
$pdf->Cell(10, 10, "qnty", 1, 0, "C", true);
$pdf->Cell(15, 10, "Rate", 1, 0, "C", true);
$pdf->Cell(15, 10, "Unit", 1, 0, "C", true);
$pdf->Cell(20, 10, "Basic_Val", 1, 0, "C", true);
$pdf->Ln();

// Setting the font to Arial normal with size 16px
$pdf->SetFont("Arial", "", 10);
 
						
 $x = 1;
 $pdf->SetX(5);
    $pdf->Cell(10, 8, 1 , 1);
    $pdf->Cell(45, 8, $row['item_desc'], 1);
    $pdf->Cell(20, 8, $row['project'], 1);
    $pdf->Cell(25, 8, $row['job'], 1);
    $pdf->Cell(40, 8, $row['remark'], 1);
    $pdf->Cell(10, 8, $row['qnty'], 1);
    $pdf->Cell(15, 8, $row['rate'], 1);
    $pdf->Cell(15, 8, $row['unit'], 1);
    $pdf->Cell(20, 8, $row['basic_value'], 1);
 
    // Moving cursor to next row
    $pdf->Ln();
// Iterate through each record
while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
	$x++;
	$pdf->SetX(5);
    // Create cells with 50px width, 10px height and 1px border
    $pdf->Cell(10, 8, $x , 1);
    $pdf->Cell(45, 8, $row['item_desc'], 1);
    $pdf->Cell(20, 8, $row['project'], 1);
    $pdf->Cell(25, 8, $row['job'], 1);
    $pdf->Cell(40, 8, $row['remark'], 1);
    $pdf->Cell(10, 8, $row['qnty'], 1);
    $pdf->Cell(15, 8, $row['rate'], 1);
    $pdf->Cell(15, 8, $row['unit'], 1);
    $pdf->Cell(20, 8, $row['basic_value'], 1);
 
    // Moving cursor to next row
    $pdf->Ln();
}

 
// Render the PDF in your browser
$pdf->output();


?>