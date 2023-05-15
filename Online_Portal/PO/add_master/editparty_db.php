<?php
include('..\..\..\dbcon.php');
session_start();
$user = $_SESSION['oid'];
date_default_timezone_set('Asia/Kolkata');
$date = date('m/d/Y h:i:s a', time());
if (isset($_POST['submit'])) {
	$pname = $_POST['pname'];
	$iid = $_POST['iid'];
	$pcode = $_POST['pcode'];
	$place = $_POST['place'];
	$gstin = $_POST['gstin'];
	$con_no = $_POST['con_no'];
	$con_per = $_POST['con_per'];
	$address = $_POST['address'];

	$sql = "UPDATE rm_party_master set party_name = '$pname',place = '$place',party_address = '$address',p_code = '$pcode',GSTIN = '$gstin',updated_by = '$user',updatedAt = '$date',Contact_No = '$con_no',Contact_Person = '$con_per' where pid='$iid'";
	$run = sqlsrv_query($con,$sql);
	if ($run == true) {
		?>
   <script>
          alert('Updated SuccessFully!!');
          window.open('showparty.php','_self');
    </script>
    <?php
	}
	else{
		print_r(sqlsrv_errors());
	}

}

?>