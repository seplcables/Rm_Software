<?php
	session_start();
	if(isset($_POST['submit']))
	{
		$id = $_GET['id'];
		$new_pass= $_POST['new_pass'];
		include('../dbcon.php');
		$qry="SELECT * FROM online_portal_user WHERE password='$new_pass'";
		$params = array();
		$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
		$run=sqlsrv_query($con,$qry,$params,$options);
		$row=sqlsrv_num_rows($run);
		if($row<1)
		{
			$query1 = "UPDATE online_portal_user SET password = '$new_pass' WHERE id = '$id'";
			$run1 = sqlsrv_query($con,$query1);
			unset($_SESSION['oid']);
			$_SESSION['login'] = "PassWord Changed SuccessFully!!";
						header("location:../OnlinePortal_login.php");
		
		}
		else {
			$_SESSION['login'] = "....The PassWord Already Exist....";
						header("location:change_password.php");
		}
	}
	
?>