<?php
include('..\..\..\dbcon.php');
$ope_date = $_GET['ope_date'];

	$sql = "SELECT top 1 * from store_opening_date where opening_date>'$ope_date' order by opening_date asc";
$run = sqlsrv_query($con,$sql);
$row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

 $date = $row["opening_date"]->format('d-M-y');

	$result = array("$date");
	$myJSON = json_encode($result);
	echo $myJSON;

?>