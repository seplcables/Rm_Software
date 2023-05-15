<?php
session_start();
include('..\..\dbcon.php');
	
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d h:i:s a', time());

if($_GET['status'] == 1)
{
	if(isset($_POST['make']))
	{
		$make = $_POST['make'];
		
		$sql3 = "SELECT a.ModelIDP, a.ModelName, b.MakebyIDP, b.Make_by from  rm_model_master a join rm_makeby_master b on a.MakebyIDP = b.MakebyIDP where a.ModelName like '%$make%'";
		$run3 = sqlsrv_query($con,$sql3);
		while($row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC))
		{
			$response[] = array("label"=>$row3['ModelName'],"Make_by"=>$row3['Make_by']);
		}
		 echo json_encode($response);
	}
}
?>