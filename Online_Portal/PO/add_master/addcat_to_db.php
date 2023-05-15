<?php
	session_start();
	if(isset($_POST['submit']))
	{
		include('..\..\..\dbcon.php');
		
		$cat= $_POST['cat'];
		$query = "INSERT INTO rm_category(category) VALUES ('$cat')";
		$run = sqlsrv_query($con,$query);
		if($run == true)
		{
			$_SESSION['mess'] = "category Updated Successfully";
						header("location:category.php");
		}
		else{
			echo "Errorrr!!!";
			
		}
	}
	else{
		$_SESSION['mess'] = "Session Not Set";
            header("location:category.php");
	}
	
?>