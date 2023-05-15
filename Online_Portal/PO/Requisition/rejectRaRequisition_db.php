<?php
	session_start();
	if (isset($_POST['id'])) {
	$user = $_SESSION['oid'];
	date_default_timezone_set('Asia/Kolkata');
	$Current_time = date('m/d/Y h:i:s a', time());
	include('..\..\..\dbcon.php');

	$sql = "UPDATE Requisition_details SET reject = 1, rejectedBy = '$user', rejectedAt = '$Current_time' WHERE id = '".$_POST['id']."'";
	$run = sqlsrv_query($con,$sql);
	if ($run) {
		echo "REJECTED SUCCESSFULLY !!!";
	}
	else{
		echo "SOME ERROR FOUND ???";
	}


}
exit;

?>