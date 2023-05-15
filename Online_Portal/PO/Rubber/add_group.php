<?php 
session_start();
date_default_timezone_set('Asia/Kolkata');
$current_date = date('dmY', time());
include('..\..\..\dbcon.php');
/*--------------------------------- code for save data -----------------------------------*/
if (isset($_POST['jobno'])) {

	
	$date = $_POST['date'];
	$bcode = $_POST['bcode'];
	$jobno = $_POST['jobno'];

	$sr = $_POST['sr'];
	$rmta = $_POST['rmta'];
	$item = $_POST['item'];
	$rate = $_POST['rate'];
	$weight = $_POST['weight'];
	$amount = $_POST['amount'];

	foreach ($sr as $key => $value) {
		$sql = "INSERT INTO rubber_issue(issue_date,batch_code,job_no,rmta,item,rate,weight,amount,username) VALUES('$date','$bcode','$jobno','".$rmta[$key]."','".$item[$key]."','".$rate[$key]."','".$weight[$key]."','".$amount[$key]."','".$_SESSION['oid']."')";

		$run = sqlsrv_query($con,$sql);
	}
	if($run){
		echo 'Data Save Successfully';
	}
	else{
		print_r(sqlsrv_errors());
	}
}


/*--------------------------------- code for delete -----------------------------------*/
if (isset($_POST['batch'])) {
	
	$sql1 = "DELETE FROM rubber_issue where batch_code = '".$_POST['batch']."'";
	$run1 = sqlsrv_query($con,$sql1);

	if ($run1) {
		echo 'Deleted Successfully';
	}else{
		print_r(sqlsrv_errors());
	}
}
?>