<?php
include('..\..\..\dbcon.php');
if (isset($_POST['rmta'])) {
	$rmta = $_POST['rmta'];
	$qry = "SELECT * from inward_rm where rmta ='$rmta'";
	$params = array();
	$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
	$run=sqlsrv_query($con,$qry,$params,$options);
	$row=sqlsrv_num_rows($run);
	if ($row > 0) {
		echo 'This Rmta Exist so,Pls Change Rmta';
	}

	}
	?>