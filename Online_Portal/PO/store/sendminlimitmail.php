<?php

error_reporting(E_ALL ^ E_WARNING);
include('C:\xampp\htdocs\rm_software\dbcon.php');
require 'C:\XAMPP\htdocs\rm_software\Online_Portal\PO\store\package\phpmailer\class.phpmailer.php';
require 'C:\XAMPP\htdocs\rm_software\Online_Portal\PO\store\package\vendor\autoload.php';

use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Html;

$date = date('Y-M-d');
  $htmlString = '
    <table>
      <thead>
        <tr>
            <th>Main_grade</th>
            <th>Sub_grade</th>
            <th>Item</th>
            <th>Min_limit</th>
            <th>Live_stock</th>
            <th>Difference</th>
            <th>LP Date</th>
            <th>LP Rate</th>
            <th>LP Qnty</th>
        </tr>
      </thead>
    <tbody>
    ';
    $srno = 2;
    $sql="SELECT MAX(opening_date) as last_date FROM store_opening_date";
$run=sqlsrv_query($con, $sql);
$row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
$ope_dte = $row['last_date']->format('d-M-y');

$sql1 = "SELECT * from rm_item where is_limit = 'yes'";
$run1 = sqlsrv_query($con, $sql1);
while ($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC)) {
    $i_code = $row1['i_code'];
    $item = $row1['item'];
    $s_code = $row1['s_code'];
    $m_code = $row1['m_code'];
    $c_code = $row1['c_code'];
    $min_limit = $row1['min_limit'];
    $max_limit = $row1['max_limit'];


    $sql2="SELECT SUM(qnty) as inw_qnty FROM inward_store where item='$i_code' and receive_dte >='$ope_dte'";
    $run2=sqlsrv_query($con, $sql2);
    $row2=sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);

    $sql3="SELECT SUM(qnty) as qnty_value FROM rm_issue where item_name='$i_code' and issue_from = 'store' and issue_date >='$ope_dte'";
    $run3=sqlsrv_query($con, $sql3);
    $row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);

    $qnty= $row2["inw_qnty"]-$row3['qnty_value'];

    $query5="SELECT sub_grade FROM rm_s_grade where s_code='$s_code'";
    $result5=sqlsrv_query($con, $query5);
    $row5=sqlsrv_fetch_array($result5, SQLSRV_FETCH_ASSOC);
    $aaa = $row5['sub_grade'];
    $query6="SELECT main_grade FROM rm_m_grade where m_code='$m_code'";
    $result6=sqlsrv_query($con, $query6);
    $row6=sqlsrv_fetch_array($result6, SQLSRV_FETCH_ASSOC);
    $bbb = $row6['main_grade'];
    $query7="SELECT category FROM rm_category where c_code='$c_code'";
    $result7=sqlsrv_query($con, $query7);
    $row7=sqlsrv_fetch_array($result7, SQLSRV_FETCH_ASSOC);
    $ccc = $row7['category'];
    $diff = floatval($qnty) - floatval($min_limit);

    $sqldt = "SELECT invoice_date,pur_rate,rec_qnty from inward_ind a
         LEFT OUTER JOIN inward_com b on a.sr_no = b.sr_no and a.receive_at = a.receive_at
         where p_item = '".$i_code."' order by invoice_date desc";
    $rundt=sqlsrv_query($con, $sqldt);
    $rowdt=sqlsrv_fetch_array($rundt, SQLSRV_FETCH_ASSOC);

    if ($rowdt['invoice_date'] == '') {
        $inv_dte = '';
    } else {
        $inv_dte = $rowdt['invoice_date']->format('d-M-Y');
    }

    if (floatval($qnty) > floatval($min_limit)) {
        continue;
    }

    $htmlString .= '
        <tr>
            <td>'.$bbb.'</td>
            <td>'.$aaa.'</td>
            <td>'.$row1['item'].'</td>
            <td>'.$row1['min_limit'].'</td>
            <td>'.$qnty.'</td>
            <td>'.$diff.'</td>
            <td>'.$inv_dte.'</td>
            <td>'.$rowdt['pur_rate'].'</td>
            <td>'.$rowdt['rec_qnty'].'</td>
        </tr>
    ';
    $srno++;
}
  $htmlString .= '</tbody> </table>';

$reader = new Html();
$spreadsheet = $reader->loadFromString($htmlString);
// set font bold
$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
// set column auto width as per data
foreach (range('A', 'I') as $letra) {
    $spreadsheet->getActiveSheet()->getColumnDimension($letra)->setAutoSize(true);
}
// $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(17);
// $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(50);
// $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
// $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(50);
// $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(50);

// set all type of  font
$styleArray = array(
    'font'  => array(
        'bold'  => false,
        'size'  => 11,
        'name'  => 'Calibri'
    ));
$spreadsheet->getActiveSheet()->getStyle('A2:I'.$srno)->applyFromArray($styleArray);
// $spreadsheet->getActiveSheet()->getStyle('A2:M'.$srno)->getFont()->setSize(11);
// filter all worksheet
$spreadsheet->getActiveSheet()->setAutoFilter('A:I');

$spreadsheet ->getActiveSheet() ->getStyle('A1:I1') ->getFill() ->setFillType(Fill::FILL_SOLID) ->getStartColor() ->setARGB('9bf542');
// Note : You can use color code instead of Color::COLOR_GREEN
$spreadsheet->getActiveSheet()->getStyle('A:I')->getAlignment()->setHorizontal('center');
// for allBoarder border
$spreadsheet ->getActiveSheet() ->getStyle('A1:I'.$srno)->getBorders()->getAllborders()->setBorderStyle('hair');
// border with color
//$spreadsheet ->getActiveSheet() ->getStyle('A1:B5')->getBorders()->getAllborders()->setBorderStyle('dashDot')->setColor(new Color('FFFF0000'));
$spreadsheet->getActiveSheet()->getStyle("G:G")->getNumberFormat()->setFormatCode("DD-MMM-YYYY");
// freeze pane
$spreadsheet->getActiveSheet()->freezePane('A2');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$file_name = 'Minimum_ord_qty.xlsx';
$writer->save($file_name);

  //echo $htmlString;
  //mail part

  $mail = new PHPMailer();
  $mail->IsSMTP();                   //Sets Mailer to send message using SMTP
  $mail->Host = 'nifty.interactivedns.com';                  //Sets the SMTP hosts of your Email hosting, this for Godaddy
  $mail->Port = 465;                    //Sets the default SMTP server port
  $mail->SMTPAuth = true;                 //Sets SMTP authentication. Utilizes the Username and Password variables
  $mail->Username = 'alert@seplcables.com';       //Sets SMTP username
  $mail->Password = 'Sabudana#696';               //Sets SMTP Password
  $mail->SMTPSecure = 'ssl';                //Sets connection prefix. Options are "", "ssl" or "tls"
  $mail->From = 'alert@seplcables.com';       //Sets the From email address for the message
  $mail->FromName = 'RM Software';            //Sets the From name of the message
  $mail->AddAddress('prod3@seplcables.com');  //Adds a "To" address
  $mail->WordWrap = 52;               //Sets word wrapping on the body of the message to a given number of characters
  $mail->IsHTML(true);                //Sets message type to HTML
  $mail->CharSet = 'UTF-8';
  $mail->AddAttachment($file_name);             //Adds an attachment from a path on the filesystem
  $mail->Subject = 'Store - Minimum order Qnty.';       //Sets the Subject of the message
  $mail->Body = 'Note : All Minimum order qnty details of RM software Store.'; //An HTML or plain text message body
  if ($mail->Send()) {                //Send an Email. Return true on success or false on error
    echo '<label class="text-success">Mail has been send successfully...</label>';
  }
  unlink($file_name);                              //Delete pdf file after send mail
