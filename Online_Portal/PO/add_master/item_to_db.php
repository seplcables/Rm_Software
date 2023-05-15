<?php
	session_start();
	if(isset($_POST['submit']))
	{
		include('..\..\..\dbcon.php');
		
		$item = str_replace("'", "`", $_POST['item']);
		$m_code= $_POST['m_code'];
		$c_code= $_POST['c_code'];
		$s_code= $_POST['s_code'];

		$query = "INSERT INTO rm_item(item,s_code,m_code,c_code) VALUES ('$item','$s_code','$m_code','$c_code')";
		$run = sqlsrv_query($con,$query);
		if($run == true)
		{
			$_SESSION['mess'] = "Item Updated Successfully";
						header("location:item.php");
		}
		else{
			print_r(sqlsrv_errors());
			
		}
	}
	else{
		$_SESSION['mess'] = "Session Not Set";
            header("location:item.php");
	}
	
?>