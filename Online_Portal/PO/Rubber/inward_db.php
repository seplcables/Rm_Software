<?php 
session_start();
include('..\..\..\dbcon.php');
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('m/d/Y h:i:s a', time());
if (isset($_POST['save'])) {
	$id = $_POST['id'];
	$rmta = $_POST['rmta'];
	$icode = $_POST['icode'];
	$qnty = $_POST['qnty'];
	$rate = $_POST['rate'];
	$rec_dte = $_POST['rec_dte'];

	foreach ($id as $key => $value) {
		$sql = "INSERT INTO rubber_inward(rmta,item,qnty,rate,inw_id,username,rce_date,createdAt,OI_type) VALUES('".$rmta[$key]."','".$icode[$key]."','".$qnty[$key]."','".$rate[$key]."','".$value."','".$_SESSION['oid']."','$rec_dte','$currentDate','inward')";
		$run = sqlsrv_query($con,$sql);
	}
	if($run){
		?>
		<script type="text/javascript">
			alert("Data Save Successfully");
			window.open('inward.php','_self');
		</script>
		<?php 
	}
	else{
		print_r(sqlsrv_errors());
	}
}

?>