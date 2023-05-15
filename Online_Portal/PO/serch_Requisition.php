<?php
include('..\..\dbcon.php');
$sql = "SELECT * from Requisition_head order by id desc";
$run = sqlsrv_query($con,$sql);
$rows = array();
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
$rows[] = $row;
}
echo json_encode($rows);
?>