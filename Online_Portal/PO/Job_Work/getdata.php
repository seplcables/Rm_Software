<?php
include('..\..\..\dbcon.php');
$sql = "SELECT id,challan_date,consignee_name,goods_desc,qnty,unit,basic_val,vehicle_no,expected_receive_days,createdBy from jw_challan";
$run = sqlsrv_query($con,$sql);
$rows = array();
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
       $rows[] = $row;
}


  echo json_encode($rows);







?>