<?php
	session_start();
	if (isset($_POST['submit']))
		
	{
		include('../../../dbcon.php');
	
		// for common table
		$mrsno= $_POST['mrsno'];
		$date= $_POST['date'];
		$mtype= $_POST['mtype'];
		$mcno= $_POST['mcno'];
		$person= $_POST['person'];
		$dpnt= $_POST['dpnt'];
		$plant= $_POST['plant'];
		$issue_by= $_POST['issue_by'];
		$make= $_POST['make'];
		$cat= $_POST['cat'];
		$old_part= $_POST['old_part'];
		$old_part_received= $_POST['old_part_received'];
		$remark= $_POST['remark'];
		$user= $_SESSION['oid'];
		
		// for individual table
		$item= $_POST['item'];
		$subgrade= $_POST['subgrade'];
		$maingrade= $_POST['maingrade'];
		$category= $_POST['category'];
		$qty= $_POST['qty'];
		$unit= $_POST['unit'];
		$stock= $_POST['stock'];
		$iid= $_POST['iid'];
		
		
         
			foreach ($item as $key => $value) {
              $query1 = "INSERT INTO rm_issue_old(mrs_no,issue_date,issue_to,item_name,sub_grade,main_grade,cat,qnty,unit,stock,mc_no,super_wizer,dpnt,plant_name,issued_by,make_in,issue_cat,old_part_status,old_part_received,remarks,username,issue_from,inward_iid,codee,codee_store) VALUES ('$mrsno','$date','$mtype','".$value."','".$subgrade[$key]."','".$maingrade[$key]."','".$category[$key]."','".$qty[$key]."','".$unit[$key]."','".$stock[$key]."','$mcno','$person','$dpnt','$plant','$issue_by','$make','$cat','$old_part','$old_part_received','$remark','$user','store','".$iid[$key]."','0','')";
              $run1 = sqlsrv_query($con,$query1);
              if($run1 == true)
            {       
                    
                    $_SESSION['message'] =' Data Inserted Successfully';
                          header("location:rm_issue_old.php");
            }
        else{
      
            echo "ERROR!!";
        }
              /*if (--$count <= 1) {
                  break;
              }*/
            }
		}
		
	
?>