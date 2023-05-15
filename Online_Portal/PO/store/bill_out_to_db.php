<?php
//delete.php
session_start();
$user = $_SESSION['oid'];
date_default_timezone_set('Asia/Kolkata');
$date = date('m/d/Y h:i:s a', time());
include('..\..\..\dbcon.php');

if(isset($_POST["id"]))
{
	$mo = $_POST["mo"];
     foreach($_POST["id"] as $id)
     {
      $query = "UPDATE inward_com set  bill_out_store = 1 , bill_out_store_memono = '".$mo."' WHERE CONCAT(sr_no,receive_at) = '".$id."'";
      
      sqlsrv_query($con,$query);
     }
}
?>