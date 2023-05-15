<?php
//delete.php
session_start();
$user = $_SESSION['oid'];
date_default_timezone_set('Asia/Kolkata');
$date = date('m/d/Y h:i:s a', time());
include('..\..\..\..\dbcon.php');

if(isset($_POST["id"]))
{
	$mo = $_POST["mo"];
 foreach($_POST["id"] as $id)
 {
  $query = "UPDATE jw_return set bill_send='sent',send_by='$user',send_time='$date',memo_no='$mo' WHERE id = '".$id."'";
  sqlsrv_query($con,$query);
 }
}
?>
