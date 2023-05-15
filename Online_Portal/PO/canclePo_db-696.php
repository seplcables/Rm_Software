<?php
session_start();
include('..\..\dbcon.php');

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$remark = $_POST['remark'];
	
	foreach ($id as $key => $value)
	{
		$sql = "UPDATE po_entry_details SET isCancle = 1, cancleReason = '".$remark[$key]."', cancleBy = '".$_SESSION['oid']."' WHERE id = '".$value."'";
		$run = sqlsrv_query($con,$sql);
	}
		

	if ($run) {
		echo 'PO Cancled Successfully';
	}
	else{
		print_r(sqlsrv_errors());
	}
}



 ?>