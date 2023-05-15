<?php
// Include the PDF class
require_once "../../../package/TCPDF-main/tcpdf.php";
						
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
    	// Connecting with database
						


    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('jw_challan');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Logo
						if (isset($_SESSION['jw'])) {
						$sid = $_SESSION['jw'];
					    }
					    else{
					    	$sid = $_GET['sid'];
					    }
						include('..\..\..\dbcon.php');
						$sql="SELECT * from jw_challan where id='$sid'";
						$run=sqlsrv_query($con,$sql);
						$row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
						
        // add a page
        $pdf->AddPage();
		// Sets the background color to light gray
		$image_file = '..\1.jpeg';
        $pdf->Image($image_file, 5, 5, 22, '', 'JPEG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $pdf->SetFont('times', 'B', 12);
        // Title

        $pdf->Cell(0, 5, 'JOB WORK CHALLAN', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->SetFont("helvetica", "U", 10);
		$pdf->SetY(10);
		$pdf->SetX(35);
        $pdf->writeHTML("[ For movement of Input or partially processed goods, capital Goods to the job worker Under Section 143 (1) of the CGST Act,2017 r.w.r 55 of the CGST Rules]", true, false, false, false, 'C');
        
        $pdf->SetY(18);
		$pdf->SetX(35);
		$pdf->SetFont("helvetica", "I", 10);
		$pdf->Cell(0, 20, 'Challan_No: - '.$row['id']);
		$pdf->SetX(150);
		$pdf->Cell(0, 20, 'Date: - '.$row['challan_date']->format('d-M-Y'));
		
		$pdf->SetX(5);
		$pdf->Cell(0, 25, '____________________________________________________________________________________________________');
	// consignor details
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetTextColor(230, 0, 115);
	$pdf->SetFont("times", "U", 14);
 	$pdf->SetX(10);
	$pdf->Cell(1, 36, "Consignor Details:-", 0, 0, "L", false);

	$output='<table border="" cellspacing="0">';
			$output .= '<tr>';
				$output .= '<th width="15%" align="right">Name :- </th>';
				$output .= '<td width="85%" align="left">Suyog Electricals Limited</td>';
			$output .= '</tr>';
			$output .= '<tr>';
				$output .= '<th width="15%" align="right">GST :- </th>';
				$output .= '<td width="85%" align="left">24AACCS9412R1ZV</td>';
			$output .= '</tr>';
		$output .= '<tr>';
			$output .= '<th width="15%" align="right">Address :- </th>';
			$output .= '<td width="85%" align="left">A2/2205, 2204,G.I.D.C, Halol-389 350,Dist. Panchmahal</td>';
		$output .= '</tr>';
    $output .= '</table>';
    $pdf->SetTextColor(0, 51, 102);
    $pdf->SetFont("times", "I", 12);						
    $pdf->SetY(40);
    $pdf->SetX(10);
    $pdf->writeHTML($output, true, false, false, false, 'C');
// consignee details
    $pdf->SetFillColor(255, 255, 255);
	$pdf->SetTextColor(230, 0, 115);
	$pdf->SetFont("times", "U", 14);
	$pdf->SetY(48);
 	$pdf->SetX(10);
	$pdf->Cell(1, 36, " Consignee Details:-", 0, 0, "L", false);

	$output1='<table border="" cellspacing="0">';
			$output1 .= '<tr>';
				$output1 .= '<th width="15%" align="right">Name :- </th>';
				$output1 .= '<td width="85%" align="left">'.$row['consignee_name'].'</td>';
			$output1 .= '</tr>';
			$output1 .= '<tr>';
				$output1 .= '<th width="15%" align="right">GST :- </th>';
				$output1 .= '<td width="85%" align="left">'.$row['consignee_gst'].'</td>';
			$output1 .= '</tr>';
		$output1 .= '<tr>';
			$output1 .= '<th width="15%" align="right">Address :- </th>';
			$output1 .= '<td width="85%" align="left">'.$row['consignee_add'].'</td>';
		$output1 .= '</tr>';
    $output1 .= '</table>';
    $pdf->SetTextColor(0, 51, 102);
    $pdf->SetFont("times", "I", 12);
    $pdf->SetY(70);						
    $pdf->SetX(10); 
        $pdf->writeHTML($output1, true, false, false, false, 'C');
    
    // entry table
     $pdf->SetFillColor(255, 255, 255);
	$pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont("times", "I", 12);
    $pdf->SetY(98);						
    $pdf->SetX(10); 
	$output2='<table border="0.2" cellspacing="0">';
			$output2 .= '<tr>';
				$output2 .= '<th width="5%" align="center">1.</th>';
				$output2 .= '<th width="50%" height="20px" align="right">Description Of Goods :-</th>';
				$output2 .= '<td width="45%" align="center"><strong>'.$row['goods_desc'].'</strong></td>';
			$output2 .= '</tr>';
			$output2 .= '<tr>';
				$output2 .= '<th width="5%" align="center">2.</th>';
				$output2 .= '<th width="50%" height="20px" align="right">Identification marks & number, if any :-</th>';
				$output2 .= '<td width="45%" align="center">'.$row['marks'].'</td>';
			$output2 .= '</tr>';
			$output2 .= '<tr>';
				$output2 .= '<th width="5%" align="center">3.</th>';
				$output2 .= '<th width="50%" height="20px" align="right">Quantity :-</th>';
				$output2 .= '<td width="45%" align="center">'.$row['qnty'].' '.$row['unit'].'</td>';
			$output2 .= '</tr>';
			$output2 .= '<tr>';
				$output2 .= '<th width="5%" align="center">4.</th>';
				$output2 .= '<th width="50%" height="20px" align="right">Basic Value :-</th>';
				$output2 .= '<td width="45%" align="center">'.$row['basic_val'].'</td>';
			$output2 .= '</tr>';
			$output2 .= '<tr>';
				$output2 .= '<th width="5%" align="center">5.</th>';
				$output2 .= '<th width="50%" height="20px" align="right">HSN Code :-</th>';
				$output2 .= '<td width="45%" align="center">'.$row['hsn_code'].'</td>';
			$output2 .= '</tr>';
			$output2 .= '<tr>';
				$output2 .= '<th width="5%" align="center">6.</th>';
				$output2 .= '<th width="50%" height="20px" align="right">Tax Amount :-</th>';
				$output2 .= '<td width="45%" align="center">'.$row['taxable_amt'].'</td>';
			$output2 .= '</tr>';
			$output2 .= '<tr>';
				$output2 .= '<th width="5%" align="center">7.</th>';
				$output2 .= '<th width="50%" height="20px" align="right">Mode of Transport Vehicle No :-</th>';
				$output2 .= '<td width="45%" align="center">'.$row['vehicle_no'].'</td>';
			$output2 .= '</tr>';
			$output2 .= '<tr>';
				$output2 .= '<th width="5%" align="center">8.</th>';
				$output2 .= '<th width="50%" height="20px" align="right">Nature of Processing Required to be done :-</th>';
				$output2 .= '<td width="45%" align="center">'.$row['nature_of_process'].'</td>';
			$output2 .= '</tr>';
			$output2 .= '<tr>';
				$output2 .= '<th width="5%" align="center">9.</th>';
				$output2 .= '<th width="50%" height="20px" align="right">Expected Duration of Processing :-</th>';
				$output2 .= '<td width="45%" align="center"><strong>'.$row['expected_receive_days'].'</strong></td>';
			$output2 .= '</tr>';
			$output2 .= '<tr>';
				$output2 .= '<th width="5%" align="center">10.</th>';
				$output2 .= '<th width="50%" height="20px" align="right">Total Value of Goods :-</th>';
				$output2 .= '<td width="45%" align="center"><strong>'.($row['basic_val']+$row['taxable_amt']).'</strong></td>';
			$output2 .= '</tr>';

			
    $output2 .= '</table>';
   
        $pdf->writeHTML($output2, true, false, false, false, 'C');

    $pdf->SetFont("times", "I", 12);
    $pdf->LN(2);						
    $pdf->SetX(10); 

    $output3='<table cellspacing="0">';
			$output3 .= '<tr>';
				$output3 .= '<th width="25%" align="left"><u>Place</u> :- Halol</th>';
				$output3 .= '<th width="30%" align="left"><u>Date :-</u></th>';
				$output3 .= '<td width="45%" align="left"><u><strong>Authorized Signature :-</strong></u></td>';
			$output3 .= '</tr>';
	$output3 .= '</table>';

	$pdf->writeHTML($output3, true, false, false, false, 'C');
		$pdf->SetFont("helvetica", "I", 10);
		$pdf->SetY(162);
	    $pdf->SetX(5);
		$pdf->Cell(0, 25, '____________________________________________________________________________________________________');

		//Job worker part
		$pdf->SetFont("times", "I", 12);
		$pdf->LN(20);						
        $pdf->SetX(10); 
	$output4='<table border="0.2" cellspacing="0">';
			$output4 .= '<tr>';
				$output4 .= '<th width="5%" align="center">1.</th>';
				$output4 .= '<th width="45%" align="center" height="35px">No. and date of Receipt in the account Book Maintain by the Job-Worker :-</th>';
				$output4 .= '<td width="50%" align="center"></td>';
			$output4 .= '</tr>';
			$output4 .= '<tr>';
				$output4 .= '<th width="5%" align="center">2.</th>';
				$output4 .= '<th width="45%" align="center" height="35px">Date and Time of Dispatch of Jonworked Goods :-</th>';
				$output4 .= '<td width="50%" align="center"></td>';
			$output4 .= '</tr>';
			$output4 .= '<tr>';
				$output4 .= '<th width="5%" align="center">3.</th>';
				$output4 .= '<th width="45%" align="center" height="35px">Quantity Dispatched :-</th>';
				$output4 .= '<td width="50%" align="center"></td>';
			$output4 .= '</tr>';
			$output4 .= '<tr>';
				$output4 .= '<th width="5%" align="center">4.</th>';
				$output4 .= '<th width="45%" align="center" height="35px">Mode Of Transport Vehicle No. :-</th>';
				$output4 .= '<td width="50%" align="center"></td>';
			$output4 .= '</tr>';
			$output4 .= '<tr>';
				$output4 .= '<th width="5%" align="center">5.</th>';
				$output4 .= '<th width="45%" align="center" height="35px">Quantity of waste materials returned to the Principal :-</th>';
				$output4 .= '<td width="50%" align="center"></td>';
			$output4 .= '</tr>';
			

			
    $output4 .= '</table>';
   
        $pdf->writeHTML($output4, true, false, false, false, 'C');

         $pdf->SetFont("times", "I,U", 12);
    $pdf->LN(2);						
    $pdf->SetX(10); 

    $output5='<table cellspacing="0">';
			$output5 .= '<tr>';
				$output5 .= '<th width="25%" align="left">Place :- </th>';
				$output5 .= '<th width="30%" align="left">Date :-</th>';
				$output5 .= '<td width="45%" align="left"><strong>Authorized Signature :-</strong></td>';
			$output5 .= '</tr>';
	$output5 .= '</table>';

	$pdf->writeHTML($output5, true, false, false, false, 'C');
		$pdf->SetFont("helvetica", "I", 10);
		$pdf->SetY(245);
	    $pdf->SetX(5);
		$pdf->Cell(0, 25, '____________________________________________________________________________________________________');		
//Close and output PDF document
$pdf->Output('PurchaseOrder.pdf', 'I');

?>