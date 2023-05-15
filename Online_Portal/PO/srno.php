<?php
include('..\..\dbcon.php');
if (isset($_POST['srno'])) {
	$srno = $_POST['srno'];
	$plant = $_POST['receiveAt'];
	$qry = "SELECT * from inward_com where sr_no = '$srno' and receive_at='$plant'";
	$params = array();
	$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
	$run=sqlsrv_query($con,$qry,$params,$options);
	$row=sqlsrv_num_rows($run);
	if ($row > 0) {
		echo 'The RMTA Already Exists!';
	}

	}

	if (isset($_POST['plant'])) {	
		 $sql="SELECT MAX(sr_no) as sr_value1 FROM inward_com where receive_at='".$_POST['plant']."'";
        $run=sqlsrv_query($con,$sql);
        $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
        $srno = $row['sr_value1'] + 1;
        echo $srno;
	}
	?>