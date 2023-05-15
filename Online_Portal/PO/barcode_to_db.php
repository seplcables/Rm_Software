<?php
require('barcode128.php');
        $vis_code = $_POST['vis_code'];

		
		$item = substr($_POST['item'],0,18);
		$iid = $_POST['iid'];
		$BC_printno = $_POST['BC_printno'];
		$loopcount = $_POST['printFrom'];
		$total_prints = $_POST['printTo'];
		$to = max($total_prints,$BC_printno);
		

	include('../../dbcon.php');
	$query = "UPDATE inward_ind SET BC_printno = '$to' WHERE id = '$iid'";
		$run = sqlsrv_query($con,$query);
		if($run == true)
		{
			$pdf = new PDF_Code128('L','mm',array(60,40));
			//$pdf=new PDF_Code128();


			for ($x = $loopcount; $x <= $total_prints; $x++) {
			  
			$pdf->AddPage();
			//A set
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(5,5);
			$pdf->Write(5,$vis_code);
			$pdf->SetXY(5,9);
			$pdf->Write(5,$item);
			$pdf->SetXY(5,13);
			$pdf->SetFont('Arial','B',12);
			$pdf->Write(5,$iid.'/'.$x);
			$pdf->Code128(5,18,$iid.'/'.$x,50,15);

			}

			$pdf->Output();
		}
		else{
			
			echo "ERROR!!!";
			print_r(sqlsrv_errors());
		}



?>
