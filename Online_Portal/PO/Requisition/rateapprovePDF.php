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
        include('../../../dbcon.php');
        $sid = $_GET['sid'];
        $sql = "SELECT id,indentor,mat_require_dte,createdAt from Requisition_head where id = '$sid'";
        $run=sqlsrv_query($con, $sql);
        $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

        $this->SetFont('times', 'B', 15);
        $this->Cell(0, 5, 'RATE APPROVAL', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont("helvetica", "A", 10);
        $this->SetX(10);
        $this->Cell(0, 15, 'Indentor: -' .$row['indentor']);
        $this->SetX(232);
        $this->Cell(0, 15, 'MRS No.: -' .$row['id']);
        $this->Ln(2);
        $this->SetX(10);
        $this->Cell(0, 25, 'Date: - ' .$row['createdAt']->format('d-M-y'));
        $this->SetX(232);
        $this->Cell(0, 25, 'Material Required Date : -' .$row['mat_require_dte']->format('d-M-y'));
        $this->Ln(3);
        $this->SetX(5);
        $this->Cell(0, 25, '___________________________________________________________________________________________________________________________________________________');
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-8);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        //$this->Cell(0, 10, '**This Is Computer Generated Slip Signature Is Not Required**', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        // Page number
        $this->Cell(0, 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
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

        // add a page
        $pdf->AddPage();
        // Set font

        $totalAmt = 0;
             $output='<table cellspacing="0" cellpadding="3" border="0.1" style="border-color:gray;">';

             $output .= '<tr style="background-color: #c5d3c9; font-size: 10px;font-family: times;">';
                $output .= '<th style="width:30px;">Sr</th>';
                $output .= '<th style="width:210px;">ITEM DESCRIPTION</th>';
                $output .= '<th style="width:100px;">CATEGORY</th>';
                $output .= '<th style="width:50px;">QNTY</th>';
                $output .= '<th style="width:50px;">RATE</th>';
                $output .= '<th style="width:80px;">DPNT (MC)</th>';
                $output .= '<th style="width:45px;">TYPE</th>';
                $output .= '<th>OPS</th>';

                $output .= '<th style="width:70px;">LP DATE</th>';
                $output .= '<th style="width:60px;">LP RATE</th>';
                $output .= '<th style="width:50px;">LP QNTY</th>';

            $output .= '</tr>';
                                    include('../../../dbcon.php');
                                    $sid = $_GET['sid'];
                                    $sql1 = "SELECT b.item,e.createdAt,d.category,a.qnty,a.department,a.mc,a.type,a.old_part_status,a.item_code,a.id from Requisition_details a
                                        LEFT OUTER JOIN rm_item b on a.item_code = b.i_code
                                        LEFT OUTER JOIN rm_category d on d.c_code = b.c_code
                                        LEFT OUTER JOIN Requisition_head e on e.id = a.iid
                                        where a.iid = '$sid' AND reject is NULL";
                                    $run1 = sqlsrv_query($con, $sql1);
                                    $count = 0;
                                    while ($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC)) {
                                        $count++;
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
                                        $sql3 = "SELECT b.party_name,a.rate,a.id FROM requisition_rate a 
                                         LEFT OUTER JOIN rm_party_master b on b.pid = a.party_id
                                         where a.iid = '".$row1['id']."' order by a.rate asc";
                                        $lowPriceRun = sqlsrv_query($con, $sql3);
                                        $lowPrice = sqlsrv_fetch_array($lowPriceRun, SQLSRV_FETCH_ASSOC);

                                        $output .= '
                                
                                <tr class="text-center" style="font-family: helvetica;">
                                <td>'.$count.'</td>
                                <td align="left">'.$row1['item'].'</td>
                                <td align="left">'.$row1['category'].'</td>
                                <td>'.$row1['qnty'].'</td>
                                <td></td>
                                
                                <td align="left">'.$row1['department'].' ('.$row1['mc'].')'.'</td>
                                <td>'.$row1['type'].'</td>
                                <td>'.$row1['old_part_status'].'</td>
                                <td>'.$inv_dte.'</td>
                                <td>'.$row2['pur_rate'].'</td>
                                <td>'.$row2['rec_qnty'].'</td>
                                
                            </tr>


';
                                        $run3 = sqlsrv_query($con, $sql3);
                                        $x = 0;
                                        while ($row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC)) {
                                            $x++;
                                            $rbtn = ($x == 1) ? "background-color: #e1e8e3; color: brown; font-size: 10px;" : "";

                                            $output .= '
                                <tr style="'.$rbtn.'">
                                <td></td>
                                <td colspan="2" align="left">'.$row3['party_name'].'</td>
                                <td></td>
                                <td class="">'.$row3['rate'].'</td>
                                <td class=" text-center">'.$row3['rate']*$row1['qnty'].'</td>
                                <td class="text-center">L'.$x.'</td>
                                <td colspan="4"></td>
                                </tr>
        ';
                                        }
                                    }


$output .= '</table>';



// set font
$pdf->SetFont('times', 'A', 10);
$pdf->ln(5);
$pdf->SetX(5);
$pdf->writeHTML($output, true, false, false, false, 'C');

//Close and output PDF document
$pdf->Output('RateApproval.pdf', 'I');
