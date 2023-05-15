<?php
	session_start();
	date_default_timezone_set('Asia/Kolkata');
    $createdAt = date('m/d/Y h:i:s a', time());
	    include('../../../dbcon.php');
    	
	    $date = $_POST['date'];
		$store = $_POST['store'];
		$pid = $_POST['pid'];
		$unit = 'kg';
		$uname = $_SESSION['oid'];

		$rmta = $_POST['rmta'];
		$i_code = $_POST['i_code'];
		$qnty = $_POST['qnty'];
		$remark = $_POST['remark'];
		

		foreach ($i_code as $key => $value) {
		$query = "INSERT INTO inward_rm(receive_dte,store_name,item,qnty,unit,party,come_from,remark,username,createdAt,rmta,inward_ind_id) VALUES ('$date','$store','".$value."','".$qnty[$key]."','kg','$pid','opening','".$remark[$key]."','$uname','$createdAt','".$rmta[$key]."','0')";
		$result = sqlsrv_query($con,$query);
		if($result == true)
		{
				?>
					<script>
							alert('Data Saved !!');
							window.open('opening.php','_self');
							
					</script>
				<?php	
            }
        else{
      
            echo "ERROR!!";
             print_r(sqlsrv_errors());
        }
       } 	
	
?>