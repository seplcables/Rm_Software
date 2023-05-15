<?php
	session_start();
	date_default_timezone_set('Asia/Kolkata');
    $createdAt = date('m/d/Y h:i:s a', time());
	if (isset($_POST['submit']))
		
	{
		include('../../../dbcon.php');
	
		// for common table
		$date= $_POST['date'];
		$store= $_POST['store'];
		$qnty= $_POST['qnty'];
		$remark= $_POST['remark'];

		$po= $_POST['po'];
		$iid= $_POST['iid'];
		$invoice_no= $_POST['invoice_no'];
		$unit= $_POST['unit'];
		$mat_ord_by= $_POST['mat_ord_by'];
		$i_code= $_POST['i_code'];
		$pid= $_POST['pid'];
		$user= $_SESSION['oid'];
		$rmta= $_POST['rmta'];
		
         
			foreach ($qnty as $key => $value) {
              $query = "INSERT INTO inward_rm(receive_dte,store_name,item,qnty,unit,party,mat_ord_by,invoice_no,po_no,come_from,remark,username,createdAt,inward_ind_id,rmta) VALUES ('$date','".$store[$key]."','$i_code','".$value."','$unit','$pid','$mat_ord_by','$invoice_no','$po','direct','".$remark[$key]."','$user','$createdAt','$iid','$rmta')";
              $run = sqlsrv_query($con,$query);
              if($run == true)
            {       
                    
                    ?>
					<script>
					alert('Data Saved !!');
					window.open('inward.php','_self');

					</script>
					<?php

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