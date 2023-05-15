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

		$temp_iconde = $_POST['temp_icode'];
		$temp_mc = $_POST['temp_mc'];
		$temp_dept = $_POST['temp_dept'];
		$temp_plant = $_POST['temp_plant'];
		$temp_emp = $_POST['temp_emp'];
		$temp_qnty = $_POST['temp_qnty'];
		$temp_req = $_POST['temp_req'];

		$mccount = count(explode(',',$temp_mc));

		$reqid = $_POST['reqid'];
		
		
	$query = "UPDATE Requisition_head set mat_require_dte = '$req_date', indentor = '$indentor',remarks = '$remark',updated_by = '$user',updatedAt = '$current_dte' WHERE id = '$iid'";
$run = sqlsrv_query($con,$query);
if($run)
{

foreach ($new_row as $key => $value) {
if ($value != 'new') 
{
	$query3 = "UPDATE Requisition_details SET item_code = '".$i_code[$key]."', qnty = '".$Qnty[$key]."', rate = '".$apx_cost[$key]."', mc = '".$mc[$key]."', department = '".$dept[$key]."', plant = '".$plant[$key]."', state = '".$state[$key]."', type = '".$status[$key]."', old_part_status = '".$old_part[$key]."' WHERE id = '".$value."'";

}
else
{
	$query3 = "INSERT INTO Requisition_details(item_code,qnty,rate,mc,department,plant,state,type,old_part_status,iid) VALUES ('".$i_code[$key]."','".$Qnty[$key]."','".$apx_cost[$key]."','".$mc[$key]."','".$dept[$key]."','".$plant[$key]."','".$state[$key]."','".$status[$key]."','".$old_part[$key]."','$iid')";
					
}
$run3 = sqlsrv_query($con,$query3);
}

if($run3)
{
	if($value != 'new') 
	{
		$i = 0;
		while($mccount > 0)
		{
			$itemexp = explode(',',$temp_iconde);
			$mcexp = explode(',',$temp_mc);
			$deptexp = explode(',',$temp_dept);
			$plantexp = explode(',',$temp_plant);
			$empexp = explode(',',$temp_emp);
			$qntyexp = explode(',',$temp_qnty);
			$tempreq = explode(',',$temp_req);
			
			$query4 = "UPDATE Requisition_item_details set Req_Item_code = '".$itemexp[$i]."', MCNO = '".$mcexp[$i]."', Department = '".$deptexp[$i]."', Plant = '".$plantexp[$i]."', Employee = '".$empexp[$i]."', Qnty = '".$qntyexp[$i]."' where ReqItemDetailIDP = '".$tempreq[$i]."'";

			$run4 = sqlsrv_query($con,$query4);
			$mccount--;
			$i++;
		}

	}
	else
	{	
		$i = 0;
		while($mccount > 0)
		{
			$itemexp = explode(',',$temp_iconde);
			$mcexp = explode(',',$temp_mc);
			$deptexp = explode(',',$temp_dept);
			$plantexp = explode(',',$temp_plant);
			$empexp = explode(',',$temp_emp);
			$qntyexp = explode(',',$temp_qnty);
			
			$query4 = "INSERT INTO Requisition_item_details(ReqHeadID,Req_Item_code,RequisitionNo,MCNO,Department,Plant,Employee,Qnty,Status,TimeStamp) VALUES ($requisition_no,'".$itemexp[$i]."','".$requisition_no."','".$mcexp[$i]."','".$deptexp[$i]."','".$plantexp[$i]."','".$empexp[$i]."','".$qntyexp[$i]."','1','$current_dte')";

			$run4 = sqlsrv_query($con,$query4);
			$mccount--;
			$i++;
		}
	}

	if(!$run4)
	{
		print_r(sqlsrv_errors());
	}
	else
	{
		?>
		<script type="text/javascript">
		alert("Updated Successfully");
		window.open('showRequisition.php','_self');
		</script>
		<?php
	}
}
else
{
	echo "Details part Missing";
}

		}
		else{
print_r(sqlsrv_errors());
}
}
	
?>