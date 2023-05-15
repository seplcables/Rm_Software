<?php
	session_start();
	include('..\..\..\dbcon.php');
	if(isset($_POST['submit']))
	{
		$main_grade= $_POST['main_grade'];
		$c_code= $_POST['c_code'];

		$query = "INSERT INTO rm_m_grade(main_grade,c_code) VALUES ('$main_grade','$c_code')";
		$run = sqlsrv_query($con,$query);
		if($run == true)
		{
			$_SESSION['mess'] = "main_Grade Updated Successfully";
						header("location:main_grade.php");
		}
		else{
			echo "Errorrr!!!";
			
		}
	}
	else{
		$_SESSION['mess'] = "Session Not Set";
            header("location:main_grade.php");
	}
	
?>