<?php
include('..\..\..\dbcon.php');
$sql = "SELECT pid,party_name,place,Contact_No,Contact_Person,party_address from rm_party_master";
$run = sqlsrv_query($con,$sql);
$rows = array();
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
	 
       $rows[] = $row;
}


  echo json_encode($rows);







?>