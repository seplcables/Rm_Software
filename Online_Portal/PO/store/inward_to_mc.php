<?php
	session_start();
	$uname = $_SESSION['oid'];
	    include('../../../dbcon.php');
    	
		$mrsno = $_POST['mrsno'];
		$date = $_POST['date'];
		$srno = $_POST['srno'];
		$mtype = $_POST['mtype'];
		$item = $_POST['i_code'];
		$subgrade = $_POST['s_code'];
		$maingrade = $_POST['m_code'];
		$category = $_POST['c_code'];
		$qty = $_POST['qty'];
		$unit = $_POST['unit'];
		$stock = $_POST['stock'];
		$mcno = $_POST['mcno'];
		$person = $_POST['person'];
		$dpnt = $_POST['dpnt'];
		$plant = $_POST['plant'];
		$issue_by = $_POST['issue_by'];
		$make = $_POST['make'];
		$cat = $_POST['cat'];	
		$old_part = $_POST['old_part'];
		
		
		$old_part_received = $_POST['old_part_received'];
		$remark = $_POST['remark'];
		$msg = $_POST['msg'];


		$query = "INSERT INTO rm_issue(mrs_no,issue_date,issue_to,item_name,sub_grade,main_grade,cat,qnty,unit,stock,mc_no,super_wizer,dpnt,plant_name,issued_by,make_in,issue_cat,old_part_status,old_part_received,remarks,username,issue_from,inward_iid,codee,codee_store) VALUES ('$mrsno','$date','$mtype','$item','$subgrade','$maingrade','$category','$qty','$unit','$stock','$mcno','$person','$dpnt','$plant','$issue_by','$make','$cat','$old_part','$old_part_received','$remark','$uname','direct','$srno','$msg','0')";
		$result = sqlsrv_query($con,$query);
		if($result == true)
		{
				?>
					<script>
							alert('Data Issued to M/c !!');
							window.open('inward.php','_self');
							
					</script>
				<?php	
            }
        else{
      		print_r(sqlsrv_errors());
            echo "ERROR!!";
        }	
	
?>