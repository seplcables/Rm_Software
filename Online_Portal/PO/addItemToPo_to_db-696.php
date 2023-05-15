<?php
	session_start();
	date_default_timezone_set('Asia/Kolkata');
    $createdAt = date('m/d/Y h:i:s a', time());
	if (isset($_POST['submit']))
		
	{
		include('../../dbcon.php');
	
		$poid= $_POST['poid'];
		$i_code= $_POST['i_code'];
		$s_code= $_POST['s_code'];
		$m_code= $_POST['m_code'];
		$c_code= $_POST['c_code'];
		$qnty= $_POST['qnty'];
		$unit= $_POST['unit'];
		$rate= $_POST['rate'];
		$basic_rate= $_POST['basic_rate'];
		$project= str_replace("'", "`", $_POST['project']);
		$job= str_replace("'", "`", $_POST['job']);
		$remark= str_replace("'", "`", $_POST['remark']);
		$useby = $_POST['useby'];
		$mcno = $_POST['mcno'];
		$person = $_POST['person'];
		$dpnt = $_POST['dpnt'];
		$plant = $_POST['plant'];
		$type = $_POST['type'];
		$status = $_POST['status'];
		$user = $_SESSION['oid'];

	
        $query = "INSERT INTO po_entry_details(item_code,project,job,remark,category,main_grade,sub_grade,qnty,unit,rate,basic_rate,matUsedBy,mcno,superviser,department,plant,type,old_status,iid,updated_by,createdAt) VALUES ('$i_code','$project','$job','$remark','$c_code','$m_code','$s_code','$qnty','$unit','$rate','$basic_rate','$useby','$mcno','$person','$dpnt','$plant','$type','$status','$poid','$user','$createdAt')";
              $run = sqlsrv_query($con,$query);
              if($run == true)
            {       
                    
                    $_SESSION['add_item_po'] = $poid;
                      $_SESSION['message'] = 'Successfully Add Item To Po Number:'.$poid;
                          header("location:po_entry_edit.php");

            }
        else{
      		print_r(sqlsrv_errors());
            echo "ERROR!!";
        }
              /*if (--$count <= 1) {
                  break;
              }*/
		}
		
	
?>