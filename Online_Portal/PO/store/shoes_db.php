<?php
session_start(); 
include('dbcon.php');
if(isset($_POST['id'])){

	$sql = "UPDATE Shoes_Issue SET issueBy = '".$_SESSION['oid']."',issue_date = '".date('Y-m-d')."' Where id = '".$_POST['id']."'";
	$run = sqlsrv_query($conhr,$sql);
	
	if ($run) {
		echo 'Issue Successfully';
	}else{
		print_r(sqlsrv_errors());
	}
}
?>