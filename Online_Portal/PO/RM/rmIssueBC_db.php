<?php
	session_start();
	$user = $_SESSION['oid'];
    date_default_timezone_set('Asia/Kolkata');
    $createdAt = date('m/d/Y h:i:s a', time());
	if (isset($_POST['save']))
		
	{
		include('../../../dbcon.php');
	
		// for common table
		$store= $_POST['store'];
		$mc= $_POST['mc'];
		$iid= $_POST['iid'];
		$bid= $_POST['bid'];
				
		$qry="SELECT * from barcode_pvcIssue where isReturn is NULL AND CONCAT(inward_id,'/',barcode_no) = '".$_POST["barcode_id"]."'";
		$params = array();
		$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
		$result=sqlsrv_query($con,$qry,$params,$options);
		$count=sqlsrv_num_rows($result);
		if($count>=1)
		{

			
			$_SESSION['duplicateBC'] ='duplicateBC';
                          header("location:rmIssueBC.php");
		}

		else{
		
         
              $query1 = "INSERT INTO barcode_pvcIssue(inward_id,barcode_no,store,mc,issue_qnty,username,createdAt) VALUES ('$iid','$bid','$store','$mc',25,'$user','$createdAt')";
              $run1 = sqlsrv_query($con,$query1);
              if($run1 == true)
            {       
                    $_SESSION['str'] = $store;
                    $_SESSION['mcn'] = $mc;
                    $_SESSION['bcmess'] =' Data Inserted Successfully';
                          header("location:rmIssueBC.php");
            }
        else{
      		print_r(sqlsrv_errors());
            echo "ERROR!!";
        }

    }

	}
		
	
?>