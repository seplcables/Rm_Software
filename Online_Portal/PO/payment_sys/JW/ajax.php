<?php
include('..\..\..\..\dbcon.php');
date_default_timezone_set('Asia/Kolkata');
$sql = "SELECT a.receive_time,a.id,a.bill_no,a.total_bill_amt,a.memo_no,b.consignee_name  FROM jw_return a
inner join jw_challan b on a.iid = b.id where bill_receive='received'";
$run = sqlsrv_query($con,$sql);
$rows = array();
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
       $rows[] = $row;
}


  echo json_encode($rows);







?>
