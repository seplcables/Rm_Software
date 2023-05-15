<?php
	session_start();
	$user = $_SESSION['oid'];
	date_default_timezone_set('Asia/Kolkata');
	$Current_time = date('m/d/Y h:i:s a', time());
	include('..\..\..\dbcon.php');

	// Repetition value
	$itemId = $_POST['itemId'];
	$rateId = $_POST['rateId'];
	$rateList = $_POST['rateList'];

	foreach ($itemId as $key => $value) {
		if ($rateId[$key] == '') {
			continue;
		}
		
		$sql = "UPDATE Requisition_details SET rateApprove = 1, rateApproveBy = '$user', rateApproveAt = '$Current_time', rateList = '".$rateList[$key]."', rateIID = '".$rateId[$key]."' where id = '".$value."'";
		$run = sqlsrv_query($con,$sql);
	}
	if ($run) {
		echo "Saved!!!";
	}


?>