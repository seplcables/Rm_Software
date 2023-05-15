<?php
	session_start();
	$user = $_SESSION['oid'];
    date_default_timezone_set('Asia/Kolkata');
    $createdAt = date('m/d/Y h:i:s a', time());
	if (isset($_POST['submit']))
		
	{
		include('../../../dbcon.php');
	
		// for common table
		$store= $_POST['store'];
		$date= $_POST['date'];
		$stage= $_POST['stage'];
		$mc= $_POST['mc'];
		$mix_use= $_POST['mix_use'];
		$mix_return= $_POST['mix_return'];
		$scrap= $_POST['scrap'];
		$comment= $_POST['comment'];

		// for individual table
		$job= $_POST['job'];
		$rmta= $_POST['rmta'];
		$grade= $_POST['grade'];
		$bal= $_POST['bal'];
		$qnty= $_POST['qnty'];
		$unit= $_POST['unit'];
		$i_code= $_POST['i_code'];
		
		
         
			foreach ($rmta as $key => $value) {
              $query1 = "INSERT INTO pvc_issue(store_name,issue_date,stage,jobno,rmta,grade_code,grade,bal,issue_qnty,unit,mc_no,mix_used,mix_return,scrap,remark,username,createdAt) VALUES ('$store','$date','$stage','".$job[$key]."','".$value."','".$i_code[$key]."','".$grade[$key]."','".$bal[$key]."','".$qnty[$key]."','".$unit[$key]."','$mc','$mix_use','$mix_return','$scrap','$comment','$user','$createdAt')";
              $run1 = sqlsrv_query($con,$query1);
              if($run1 == true)
            {       
                    
                    $_SESSION['message'] =' Data Inserted Successfully';
                          header("location:rm_issue.php");
            }
        else{
      		print_r(sqlsrv_errors());
            echo "ERROR!!";
        }
              /*if (--$count <= 1) {
                  break;
              }*/
            }
		}
		
	
?>