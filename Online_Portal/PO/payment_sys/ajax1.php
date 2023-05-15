<?php
include('..\..\..\dbcon.php');
date_default_timezone_set('Asia/Kolkata');
$sql = "SELECT CONCAT(a.sr_no,'_',a.receive_at) as rmta,a.approve_time,a.receive_time,a.invoice_no,a.total_bill_amt,a.approve_by,b.party_name  FROM inward_com a
inner join rm_party_master b on a.mat_from_party = b.pid where bill_approve= 1";
$run = sqlsrv_query($con,$sql);
$rows = array();
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
       $rows[] = $row;
}


  echo json_encode($rows);







?>
