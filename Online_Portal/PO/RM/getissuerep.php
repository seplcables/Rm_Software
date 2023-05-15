<?php
include('..\..\..\dbcon.php');
$sql = "SELECT issue_date,store_name,stage,jobno,rmta,grade,issue_qnty,mc_no,mix_used,mix_return,scrap from pvc_issue";
$run = sqlsrv_query($con,$sql);
$rows = array();
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
       $rows[] = $row;
}


  echo json_encode($rows);







?>