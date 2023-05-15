<?php
// Include the PDF class
require_once "../../package/TCPDF-main/tcpdf.php";
						
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
        $this->Cell(0, 10, '**This Is Computer Generated PO Signature Is Not Required**', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        // Page number
        /*$this->Cell(0, 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');*/
    }
}

// create new PDF document
$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('PurchaseOrder');
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
						if (isset($_SESSION['pono_entry'])) {
						$sid = $_SESSION['pono_entry'];
					    }
					    else{
					    	$sid = $_GET['sid'];
					    }
						include('..\..\dbcon.php');
						$sql="SELECT * from po_entry_head where id='$sid'";
						$run=sqlsrv_query($con,$sql);
						$row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
						$xx = $row['party'];
						$sqla="SELECT party_name from rm_party_master where pid='$xx'";
						$runa=sqlsrv_query($con,$sqla);
						$rowa=sqlsrv_fetch_array($runa, SQLSRV_FETCH_ASSOC);

						$sql1="SELECT sum(basic_rate) as basic from po_entry_details where iid='$sid'";
						$run1=sqlsrv_query($con,$sql1);
						$row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
						$total_basic_value = $row1['basic'];
        // add a page
        $pdf->AddPage();
		// Sets the background color to light gray
		$image_file = '1.jpeg';
        $pdf->Image($image_file, 5, 5, 22, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $pdf->SetFont('times', 'B', 15);
        // Title

        $pdf->Cell(0, 5, 'PURCHASE ORDER', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->SetFont("helvetica", "U", 10);
		$pdf->SetX(35);
		$pdf->Cell(0, 20, "SEL/F/PUR/03");
		$pdf->SetFont("helvetica", "I", 8);
        $pdf->SetX(150);
        $pdf->Cell(0, 25, 'Po. No.: - '.$row['po_no']);
        $pdf->Ln(7);
		$pdf->SetX(35);
		$pdf->SetFont("helvetica", "I", 10);
		$pdf->Cell(0, 20, "GSTIN: 24AACCS9412R1ZV");
		$pdf->SetX(150);
		$pdf->Cell(0, 25, 'Date: - '.$row['po_date']->format('d-M-Y'));
		$pdf->Ln(7);
		$pdf->SetX(150);
		$pdf->Cell(0, 25, 'Last Delivery Date:-'.$row['mat_req_date']->format('d-M-Y'));
		$pdf->Ln(1);
		$pdf->SetX(10);
		$pdf->Cell(0, 25, '____________________________________________________________________________________________________');				
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY(35);
		$pdf->SetFont("helvetica", "B", 12);
		$pdf->Cell(25, 10, "TO,", 0, 0, "L", true);
		$pdf->Ln(7);
		$pdf->SetFont("helvetica", "", 10);
		$pdf->Cell(25, 10, 'M/s:'.$rowa['party_name'], 0, 0, "L", true);
		$pdf->Ln(7);
		$pdf->SetFont("helvetica", "B", 10);
		$pdf->Cell(25, 10, "Dear Sir/Madam,", 0, 0, "L", true);
		$pdf->Ln(7);
		$pdf->SetFont("helvetica", "I", 10);
		$pdf->Cell(25, 10, "We are pleased to place an order for following.", 0, 0, "L", true);
// set font	
$pdf->SetFont('times', 'BI', 12);

							
						$sql="SELECT * from po_entry_details where iid='$sid'";
						$run=sqlsrv_query($con,$sql);
						$count = 0;
						


$output='<table border="0.2" cellspacing="0">';
			$output .= '<tr bgcolor="#cccccc">';
				$output .= '<th width="20" align="center">Sr No</th>';
				$output .= '<th width="60" align="center">Item_Description</th>';
				$output .= '<th width="60" align="center">project</th>';
				$output .= '<th width="60" align="center">sub_project</th>';
				$output .= '<th width="80" align="center">Job</th>';
				$output .= '<th width="100" align="center">remaks</th>';
				$output .= '<th width="50" align="center">qnty</th>';
				$output .= '<th width="50" align="center">Rate</th>';
				$output .= '<th width="40" align="center">Unit</th>';
				$output .= '<th width="50" align="center">Basic_Val</th>';
			$output .= '</tr>';
			while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
				$count++;
				$xx = $row['item_code'];
				$sql1="SELECT * from rm_item where i_code='$xx'";
				$run1=sqlsrv_query($con,$sql1);
				$row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);

				$sql2="SELECT sum(basic_rate) as basic from po_entry_details where iid='$sid'";
				$run2=sqlsrv_query($con,$sql2);
				$row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);

			$output .= '<tr>';
			    $output .= '<td width="20" align="center">'.$count.'</td>';
				$output .= '<td width="60" align="center">'.$row1["item"].'</td>';
				$output .= '<td width="60" align="center">'.$row["project"].'</td>';
				$output .= '<td width="60" align="center">'.$row["sub_project"].'</td>';
				$output .= '<td width="80" align="center">'.$row["job"].'</td>';
				$output .= '<td width="100" align="center">'.$row["remark"].'</td>';
				$output .= '<td width="50" align="center">'.$row["qnty"].'</td>';
				$output .= '<td width="50" align="center">'.$row["rate"].'</td>';
				$output .= '<td width="40" align="center">'.$row["unit"].'</td>';
				$output .= '<td width="50" align="center">'.$row["basic_rate"].'</td>';
			$output .= '</tr>';

    }

    $output .= '<tr color="#0000ff">';
    $output .= '<td colspan="8" align="right"><b>TOTAL =>___ </b></td>';
    $output .= '<td colspan="2"><b>'.$row2["basic"].'</b></td>';
    $output .= '</tr>';

$output .= '</table>';

$pdf->SetFont("times", "I", 10);						
$pdf->SetY(70);
$pdf->SetX(5);
$pdf->writeHTML($output, true, false, false, false, 'C');
//Terms & Condition part
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(250, 25, 25);
$pdf->SetFont("helvetica", "U", 16);
 $pdf->SetX(10);
$pdf->Cell(8, 10, "Terms & Conditions:", 0, 0, "L", true);
$pdf->Ln(14);

                        $sql3="SELECT * from po_terms where po_id='$sid'";
						$run3=sqlsrv_query($con,$sql3);
						$ab = 0;
	$output1='<table border="0.2">';					
	while ($row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC)) {
				$ab++;
			$output1 .= '<tr color="#000000">';
			    $output1 .= '<td width="20" align="center"><b>'.$ab.'</b></td>';
				$output1 .= '<td width="105" align="center"><b><i>'.$row3["title"].'</b></i></td>';
				$output1 .= '<td width="445" align="center">'.$row3["descriptions"].'</td>';
			$output1 .= '</tr>';

    }

    
$output1 .= '</table>';					
$pdf->SetX(5);
$pdf->SetFont("times", "", 10);
$pdf->writeHTML($output1, true, false, false, false, 'C');		
// Delivery location part
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(250, 25, 25);
$pdf->SetFont("helvetica", "U", 16);
 $pdf->SetX(10);
$pdf->Cell(8, 10, "Delivery & Installation at:-", 0, 0, "L", true);
$pdf->Ln(14);

                        $sql4="SELECT * from po_delivery where po_id='$sid'";
						$run4=sqlsrv_query($con,$sql4);
						$xy = 0;
	$output2='<table border="0.2">';					
	while ($row4 = sqlsrv_fetch_array($run4, SQLSRV_FETCH_ASSOC)) {
				$xy++;
			$output2 .= '<tr color="#000000">';
			    $output2 .= '<td width="20" align="center"><b>'.$xy.'</b></td>';
				$output2 .= '<td width="105" align="center"><b><i>'.$row4["location"].'</b></i></td>';
				$output2 .= '<td width="445" align="center">'.$row4["location_address"].'</td>';
			$output2 .= '</tr>';

    }

    
$output2 .= '</table>';	
//footer
	$sql5="SELECT po_gen_by from po_entry_head where id='$sid'";
	$run5=sqlsrv_query($con,$sql5);
	$row5 = sqlsrv_fetch_array($run5, SQLSRV_FETCH_ASSOC);			
$pdf->SetX(5);
$pdf->SetFont("times", "", 10);
$pdf->writeHTML($output2, true, false, false, false, 'C');
$pdf->Ln();
$pdf->SetTextColor(0, 0, 0);
$pdf->SetX(15);
$pdf->SetFont("helvetica", "B", 10);
$pdf->Cell(25, 10, "Thanking You,", 0, 0, "L", true);
$pdf->Ln();
$pdf->SetFont("helvetica", "", 10);
$pdf->Cell(25, 10, "Your Faithfully,", 0, 0, "L", true);
$pdf->Ln(7);
$pdf->SetFont("helvetica", "", 10);
$pdf->Cell(25, 10, "For SUYOG ELECTRICALS LTD", 0, 0, "L", true);
$pdf->Ln(7);
$pdf->SetFont("helvetica", "B", 12);
$pdf->Cell(25, 10, $row5['po_gen_by'], 0, 0, "L", true);
//Close and output PDF document
$pdf->Output('PurchaseOrder.pdf', 'I');

?>