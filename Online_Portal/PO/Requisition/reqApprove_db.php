<?php
//delete.php
session_start();
$user = $_SESSION['oid'];
date_default_timezone_set('Asia/Kolkata');
$date = date('m/d/Y h:i:s a', time());
include('..\..\..\dbcon.php');

if(isset($_POST["id"]))
{
	
 foreach($_POST["id"] as $id)
 {
  $query = "UPDATE Requisition_details set req_aprv= 1,aprvBy='$user',aprvAt='$date' WHERE id = '".$id."'";
  sqlsrv_query($con,$query);
 }
}
?>