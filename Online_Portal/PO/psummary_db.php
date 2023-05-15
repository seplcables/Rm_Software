<?php 

//delete.php
session_start();
$user = $_SESSION['oid'];
date_default_timezone_set('Asia/Kolkata');
$date = date('m/d/Y h:i:s a', time());
include('..\..\dbcon.php');
if(isset($_POST["id"]))
{
 foreach($_POST["id"] as $key => $value)
 {
  $query = "INSERT INTO psummary(purchaseId,fi,deduction,aRate,isAprv,username,createdAt) VALUES('".$value."','".$_POST["fi"][$key]."','".$_POST["de"][$key]."','".$_POST["rate"][$key]."','1','$user','$date')";
  $run = sqlsrv_query($con,$query);
 }
 if ($run) {
 	echo "SAVED SUCCESSFUL!!";
 }
 else{
 		print_r(sqlsrv_errors());
 }
}

 ?>