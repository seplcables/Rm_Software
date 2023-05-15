<?php
	session_start();
	$user = $_SESSION['oid'];
	date_default_timezone_set('Asia/Kolkata');
	$Current_time = date('m/d/Y h:i:s a', time());
	include('..\..\..\dbcon.php');

	$iid = $_POST['rateId'];
	// Repetition value
	$pid = $_POST['pid'];
	$rate = $_POST['rate'];

	foreach ($pid as $key => $value) {
		
		$sql = "INSERT INTO requisition_rate(party_id,rate,username,iid) VALUES('".$value."','".$rate[$key]."','$user','$iid')";
		$run = sqlsrv_query($con,$sql);
	}
	if ($run) {
		echo "Saved!!!";
	}


?>