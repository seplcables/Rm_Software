<?php 
session_start();
$user = $_SESSION['oid'];
date_default_timezone_set('Asia/Kolkata');
$date = date('m/d/Y h:i:s a', time());
include('..\..\..\dbcon.php');

if(isset($_POST['save'])){
	/* common feild */
	$pay_date = $_POST['pay_date'];
	$total_amt = $_POST['total_amt'];
	$Trans_id = $_POST['trans_id'];
	$payment_mode = $_POST['payment_mode'];
	$remark = $_POST['remark'];

	/*	repeat feild */
	$idate = $_POST['idate'];
	$ino = $_POST['ino'];
	$pname = $_POST['pname'];
	$matby = $_POST['matby'];
	$total = $_POST['total'];
	$value = $_POST['value'];
	$due = $_POST['due'];
	//$aprv = $_POST['aprv'];
	$paid_amt = $_POST['paid_amt'];
	$srno = $_POST['sr_no'];
	$receive_at = $_POST['receive'];
	$check = $_POST['check'];

	foreach ($idate as $key => $value) {
		if ($check[$key] == '') {
	        continue;
	    }
		$sql = "INSERT INTO payment_table(pay_date,party,bill_amt,payment_amt,trans_id,pay_mode,remark,sr_no,receive_at,username,createdAt,invoice_no,invoice_date,total_amt) VALUES('$pay_date','".$pname[$key]."','".$total[$key]."','".$paid_amt[$key]."','$Trans_id','$payment_mode','$remark','".$srno[$key]."','".$receive_at[$key]."','$user','$date','".$ino[$key]."','".$value."','$total_amt')";
			$run = sqlsrv_query($con,$sql);
	}
	if ($run) {
		?>
		<script type="text/javascript">
			alert("Data Entered Successfully");
			window.open("payment_table.php","_self");
		</script>
		<?php
	}
	else{
		 print_r(sqlsrv_errors());
	}
	
}

?>