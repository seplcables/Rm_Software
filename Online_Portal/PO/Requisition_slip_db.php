<?php
	session_start();
		if (isset($_POST['save']))
	{
		include('../../dbcon.php');
		$sql="SELECT MAX(id) as requisition_no FROM Requisition_head";
		$run=sqlsrv_query($con,$sql);
		$row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
		$requisition_no = $row['requisition_no'] + 1;
				date_default_timezone_set('Asia/Kolkata');
		$current_dte = date('m/d/Y h:i:s a', time());
		
	
		// for common table
		$req_date= $_POST['req_date'];
		$indentor= $_POST['indentor'];
		$dpnt= $_POST['dpnt'];
		$remark= $_POST['remark'];
		$user= $_SESSION['oid'];
		
		// for individual table
		$i_code= $_POST['i_code'];
		$Qnty= $_POST['Qnty'];
		$apx_cost= $_POST['apx_cost'];
		$mc= $_POST['mc'];
		$dept= $_POST['dept'];
		$plant= $_POST['plant'];
		$state= $_POST['state'];
		$status= $_POST['status'];
		$old_part= $_POST['old_part'];
		
		
$query = "INSERT INTO Requisition_head(id,mat_require_dte,indentor,remarks,username,createdAt,updated_by,updatedAt,indentor_dpnt) VALUES ('$requisition_no','$req_date','$indentor','$remark','$user','$current_dte','$user','$current_dte','$dpnt')";
$run = sqlsrv_query($con,$query);
if($run)
{

foreach ($i_code as $key => $value) {
$query3 = "INSERT INTO Requisition_details(item_code,qnty,rate,mc,department,plant,state,type,old_part_status,iid) VALUES ('".$value."','".$Qnty[$key]."','".$apx_cost[$key]."','".$mc[$key]."','".$dept[$key]."','".$plant[$key]."','".$state[$key]."','".$status[$key]."','".$old_part[$key]."','$requisition_no')";
$run3 = sqlsrv_query($con,$query3);
}
if($run3)
{
$_SESSION['req_id'] = $requisition_no;
$_SESSION['message'] = 'Requisition No:' .$requisition_no.' Created Successfully';
header("location:Requisition_slip.php");
}
else{
echo "Details part Missing";
}


		}
		else{
print_r(sqlsrv_errors());
}
}
	
?>