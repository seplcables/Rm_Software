<?php
	session_start();
	$uname = $_SESSION['oid'];
	$srno = $_GET['srno'];
	$plant = $_GET['plant'];
	if ($uname == 'mitra' || $uname == 'Rajnish') {
		include('../../dbcon.php');
		$query = "DELETE from inward_com where sr_no='$srno' and receive_at ='$plant'";
		$run = sqlsrv_query($con,$query);
		if($run == true)
		{
			$query1 = "DELETE from inward_ind where sr_no='$srno' and receive_at ='$plant'";
			$run1 = sqlsrv_query($con,$query1);
					if($run1 == true)
				    {
					$_SESSION['message'] = "Data Cleared Successfully";
						header("location:inward_field.php");
						unset($_SESSION['item_id']);
					}
		}
	}
		else{
			$_SESSION['mess'] = "!!!!_You Can't Delete this_!!!!";
						header("location:inward_field.php");
			
			}
	
?>