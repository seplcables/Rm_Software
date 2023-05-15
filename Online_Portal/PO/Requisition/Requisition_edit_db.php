<?php
	session_start();
		if (isset($_POST['save']))
	{
		include('../../../dbcon.php');
		date_default_timezone_set('Asia/Kolkata');
		$current_dte = date('m/d/Y h:i:s a', time());
		
		$iid= $_POST['iid'];
		// for common table
		$req_date= $_POST['req_date'];
		$indentor= $_POST['indentor'];
		$dpnt= $_POST['dpnt'];
		$remark= $_POST['remark'];
		$user= $_SESSION['oid'];
		
		// for individual table
		$i_code= $_POST['i_code'];
		$new_row= $_POST['new_row'];
		$Qnty= $_POST['Qnty'];
		$apx_cost= $_POST['apx_cost'];
		$mc= $_POST['mc'];
		$dept= $_POST['dept'];
		$plant= $_POST['plant'];
		$state= $_POST['state'];
		$status= $_POST['status'];
		$old_part= $_POST['old_part'];
		
		
	$query = "UPDATE Requisition_head set mat_require_dte = '$req_date', indentor = '$indentor',remarks = '$remark',updated_by = '$user',updatedAt = '$current_dte' WHERE id = '$iid'";
$run = sqlsrv_query($con,$query);
if($run)
{

foreach ($new_row as $key => $value) {
if ($value != 'new') {
$query3 = "UPDATE Requisition_details SET item_code = '".$i_code[$key]."', qnty = '".$Qnty[$key]."', rate = '".$apx_cost[$key]."', mc = '".$mc[$key]."', department = '".$dept[$key]."', plant = '".$plant[$key]."', state = '".$state[$key]."', type = '".$status[$key]."', old_part_status = '".$old_part[$key]."' WHERE id = '".$value."'";
}
else{
$query3 = "INSERT INTO Requisition_details(item_code,qnty,rate,mc,department,plant,state,type,old_part_status,iid) VALUES ('".$i_code[$key]."','".$Qnty[$key]."','".$apx_cost[$key]."','".$mc[$key]."','".$dept[$key]."','".$plant[$key]."','".$state[$key]."','".$status[$key]."','".$old_part[$key]."','$iid')";
}
$run3 = sqlsrv_query($con,$query3);
}
if($run3)
{
?>
<script type="text/javascript">
alert("Updated Successfully");
window.open('showRequisition.php','_self');
</script>
<?php
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