<?php
include('..\..\dbcon.php');
date_default_timezone_set('Asia/Kolkata');
$lastDate = date('Y-m-d', strtotime('-30 days'));

$sql = "SELECT a.receive_date,a.sr_no,a.receive_at,c.party_name,a.invoice_date,a.invoice_no,cast(a.total_bill_amt as float) as total_bill_amt,a.bill_receive,a.invoice_img,a.bill_approve, a.Invoice_img_timestamp FROM inward_com a
LEFT OUTER JOIN rm_party_master c on c.pid= a.mat_from_party WHERE receive_date >= '$lastDate' and (a.receive_at = '696_plant' OR a.receive_at = 'D_696_plant')";
$run = sqlsrv_query($con,$sql);
$rows = array();
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
 
       $rows[] = $row;
}


  echo json_encode($rows);







?>