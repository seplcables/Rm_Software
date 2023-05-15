<?php
include('..\..\dbcon.php');
$name = $_GET['name'];
if($name!==""){
	$sql = "SELECT *  FROM online_portal_user WHERE name='$name'";
$run = sqlsrv_query($con,$sql);
$row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
$dpnt = $row["department"];

$sql1 = "SELECT *  FROM online_portal_user WHERE name='$name
'";
$run1 = sqlsrv_query($con,$sql1);
$row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
$dpnt1 = $row1["department"];

}
	if (is_null($dpnt)) {
		$result = array("$dpnt1");
	}
	else{
		$result = array("$dpnt");
	}
	
	$myJSON = json_encode($result);
	echo $myJSON;







?>