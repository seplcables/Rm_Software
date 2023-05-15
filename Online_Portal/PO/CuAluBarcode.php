<?php
session_start();
require('barcode128.php');
        $vis_code = $_SESSION['viscode'];
		$item = substr($_SESSION['itemBC'],0,18);
		$iid = $_GET['iid'];

	include('../../dbcon.php');
	$sql = "SELECT * FROM inwardCuAlu where ind_id = '$iid'";
	$run = sqlsrv_query($con,$sql);
	$pdf = new PDF_Code128('L','mm',array(60,40));
	while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
	{
			$pdf->AddPage();
			//A set
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(5,5);
			$pdf->Write(5,$vis_code);
			$pdf->SetXY(5,9);
			$pdf->Write(5,$item);
			$pdf->SetXY(5,13);
			$pdf->SetFont('Arial','B',12);
			$pdf->Write(5,$row['CoilNo'].'('.$row['CoilWt'].' kg)');
			$pdf->Code128(5,18,$row['CoilNo'],50,15);
	}
	

			$pdf->Output();
		



?>
