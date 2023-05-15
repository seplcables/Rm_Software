<?php
session_start();
$user = $_SESSION['oid'];
date_default_timezone_set('Asia/Kolkata');
$createdAt = date('m/d/Y h:i:s a', time());
include('..\..\..\dbcon.php');
if (isset($_POST['save']))
{

$ope_date = $_POST['ope_date'];	
$qnty = $_POST['qnty'];
$remark = $_POST['remark'];
$i_code = $_POST['i_code'];
$pid = $_POST['pid'];
$rmta = $_POST['rmta'];
$store_name = $_POST['store_name'];
$ind_id = 0;



foreach ($qnty as $key => $value) {
		$query = "INSERT INTO inward_rm(receive_dte,store_name,item,qnty,unit,party,come_from,remark,username,createdAt,rmta,inward_ind_id) VALUES ('$ope_date','".$store_name[$key]."','".$i_code[$key]."','".$value."','kg','".$pid[$key]."','opening','".$remark[$key]."','$user','$createdAt','".$rmta[$key]."','$ind_id')";
		$result = sqlsrv_query($con,$query);
		
			}
			 $_SESSION['mess'] =' Data Inserted Successfully';
                          header("location:opening_table.php");
}
?>