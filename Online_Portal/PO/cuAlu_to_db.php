<?php 
session_start();
$user = $_SESSION['oid'];
date_default_timezone_set('Asia/Kolkata');
$date = date('m/d/Y h:i:s a', time());
include('..\..\dbcon.php');
if (isset($_POST['submit'])) {
	$vis_code = $_POST['vis_code'];
	$iid = $_POST['iid'];
	$item = $_POST['item'];
	
	// Array variable

	 $cn = $_POST['cn'];
	 $cl = $_POST['cl'];	
     $coilno = $_POST['coilno'];
     $coilWt = $_POST['coilWt'];
      $cwt = $_POST['cwt'];
     
     foreach ($cn as $key => $value) {
     	if ($cwt[$key] == '') {
     	$sql = "INSERT INTO inwardCuAlu(cn,cl,CoilNo,CoilWt,ind_id,username,createdAt) VALUES('".$value."','".$cl[$key]."','".$coilno[$key]."','".$coilWt[$key]."','$iid','$user','$date')";
     }
     else{
     		$sql = "UPDATE inwardCuAlu set CoilWt = '".$coilWt[$key]."' WHERE CoilNo = '".$coilno[$key]."'";	
     }
     	$run = sqlsrv_query($con,$sql);

     }
     if ($run) {
     	$_SESSION['viscode'] = $vis_code;
     	$_SESSION['itemBC'] = $item;
     	header("location:CuAluBarcode.php?iid=".$iid);
        echo "string";
     }
     else{
     		print_r(sqlsrv_errors());
     }


}


 ?>