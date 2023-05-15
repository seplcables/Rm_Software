<?php
	session_start();
	$uname = $_SESSION['oid'];
	    include('../../../dbcon.php');
    	
	    $date = $_POST['date'];
		$item = $_POST['i_code'];
		$s_grade = $_POST['s_code'];
		$m_grade = $_POST['m_code'];
		$cat = $_POST['c_code'];
		$qnty = $_POST['qty'];
		$unit = $_POST['unit'];
		

		foreach ($item as $key => $value) {
		$query = "INSERT INTO inward_store(receive_dte,inward_ind_id,item,qnty,unit,username,come_from) VALUES ('$date','0','".$value."','".$qnty[$key]."','".$unit[$key]."','$uname','opening')";
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