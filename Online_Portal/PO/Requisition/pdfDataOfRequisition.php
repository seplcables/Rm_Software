<?php

// Include the PDF class
require_once "../../../package/TCPDF-main/tcpdf.php";
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{
    //Page header
    public function Header()
    {
        // Connecting with database
        include('..\..\..\dbcon.php');
        $sql="SELECT * from Requisition_head where id = '".$_GET['sid']."'";
        $run=sqlsrv_query($con, $sql);
        $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

        $this->SetFont('times', 'B', 15);
        $this->Cell(0, 5, 'REQUISITION SLIP', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont("helvetica", "I", 10);
        $this->SetX(10);
        $this->Cell(0, 22, 'Indentor: - '.$row['indentor']);
        $this->SetX(235);
        $this->Cell(0, 22, 'Slip. No.: - '.$_GET['sid']);
        $this->Ln(5);
        $this->SetX(10);
        $this->Cell(0, 25, 'Date: - '.$row['createdAt']->format('d-M-Y'));
        $this->SetX(235);
        $this->Cell(0, 25, 'Material Required Date:-'.$row['mat_require_dte']->format('d-M-Y'));
        $this->Ln(3);
        $this->SetX(5);
        $this->Cell(0, 25, '__________________________________________________________________________________________________________________________________________________');
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'b', 8);
        $this->Cell(0, 10, '**This Is Computer Generated Slip Signature Is Not Required**', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        // Page number
        /*$this->Cell(0, 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');*/
    }
}

// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('RequisitionSlip');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

// Logo

                          include('..\..\..\dbcon.php');
                          $sid = $_GET['sid'];
                          $sql1="SELECT a.aprvBy,a.iid,e.createdAt,a.item_code,b.item,d.category,a.qnty,a.rate,a.qnty*a.rate as basic,a.mc,a.department,a.type,a.old_part_status,c.indentor,c.mat_require_dte,c.remarks,c.createdAt from Requisition_details a
                              LEFT OUTER JOIN rm_item b on a.item_code = b.i_code
                              LEFT OUTER JOIN Requisition_head c on c.id = a.iid
                              LEFT OUTER JOIN rm_category d on d.c_code = b.c_code
                              LEFT OUTER JOIN Requisition_head e on e.id = a.iid
                              where a.iid = '$sid' AND reject is NULL";
                          $run1=sqlsrv_query($con, $sql1);


        // add a page
        $pdf->AddPage();
        // Set font
        $count = 0;
        $totalAmt = 0;
       $output='<table border="0.1" cellspacing="0">';
            $output .= '<tr>';
                $output .= '<th bgcolor="#b85114" color="#ffffff" width="20" align="center">Sr No</th>';
                $output .= '<th bgcolor="#b85114" color="#ffffff" width="130" align="center">Item_Description</th>';
                $output .= '<th bgcolor="#b85114" color="#ffffff" width="90" align="center">Category</th>';
                $output .= '<th bgcolor="#b85114" color="#ffffff" width="50" align="center">Qnty</th>';
                $output .= '<th bgcolor="#b85114" color="#ffffff" width="50" align="center">aprx.Rate</th>';
                $output .= '<th bgcolor="#b85114" color="#ffffff" width="60" align="center">Basic_Val</th>';
                $output .= '<th bgcolor="#b85114" color="#ffffff" width="80" align="center">Dpnt(mc)</th>';
                $output .= '<th bgcolor="#b85114" color="#ffffff" width="75" align="center">Type</th>';
                $output .= '<th bgcolor="#b85114" color="#ffffff" width="60" align="center">oldPartStatus</th>';
                $output .= '<th bgcolor="#ffffcc" width="40" align="center">Stock</th>';
                $output .= '<th bgcolor="#ffffcc" width="60" align="center">LP_Date</th>';
                $output .= '<th bgcolor="#ffffcc" width="50" align="center">LP_Rate</th>';
                $output .= '<th bgcolor="#ffffcc" width="50" align="center">LP_Qnty</th>';
            $output .= '</tr>';
            while ($row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC)) {
                $sql2 = "SELECT invoice_date,pur_rate,rec_qnty from inward_ind a
                         LEFT OUTER JOIN inward_com b on a.sr_no = b.sr_no and a.receive_at = a.receive_at
                         where p_item = '".$row1['item_code']."' and invoice_date < '".$row1['createdAt']->format('Y-m-d')."' order by invoice_date desc";
                $run2=sqlsrv_query($con, $sql2);
                $row2=sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
                if ($row2['invoice_date'] == '') {
                    $inv_dte = '';
                } else {
                    $inv_dte = $row2['invoice_date']->format('d-M-Y');
                }
                $count++;
                $totalAmt = $totalAmt + $row1['basic'];
                $output .= '<tr>';
                $output .= '<td width="20" align="center">'.$count.'</td>';
                $output .= '<td width="130" align="center">'.$row1['item'].'</td>';
                $output .= '<td width="90" align="center">'.$row1['category'].'</td>';
                $output .= '<td width="50" align="center">'.$row1['qnty'].'</td>';
                $output .= '<td width="50" align="center">'.$row1['rate'].'</td>';
                $output .= '<td width="60" align="center">'.$row1['basic'].'</td>';
                $output .= '<td width="80" align="center">'.$row1['department'].'('.$row1['mc'].')'.'</td>';
                $output .= '<td width="75" align="center">'.$row1['type'].'</td>';
                $output .= '<td width="60" align="center">'.$row1['old_part_status'].'</td>';
                $output .= '<td width="40" align="center"></td>';
                $output .= '<td width="60" align="center">'.$inv_dte.'</td>';
                $output .= '<td width="50" align="center">'.$row2['pur_rate'].'</td>';
                $output .= '<td width="50" align="center">'.$row2['rec_qnty'].'</td>';
                $output .= '</tr>';

                $aprvBy = $row1['aprvBy'];
            }

    $output .= '<tr color="#0000ff">';
    $output .= '<td colspan="10" align="right"><b>TOTAL AMT =>___ </b></td>';
    $output .= '<td colspan="3"><b>'.$totalAmt.'</b></td>';
    $output .= '</tr>';

$output .= '</table>';

$pdf->SetFont("times", "I", 10);
$pdf->SetY(35);
$pdf->SetX(5);
$pdf->writeHTML($output, true, false, false, false, 'C');

// set font
$pdf->SetFont('times', 'A', 12);
$pdf->ln(2);
$pdf->SetX(220);
$pdf->Cell(0, 22, 'Approved By :- '.$aprvBy);

//Close and output PDF document
$pdf->Output('RequisitionSlip.pdf', 'I');
