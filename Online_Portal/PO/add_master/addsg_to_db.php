<?php
	session_start();
	if(isset($_POST['submit']))
	{
		include('..\..\..\dbcon.php');
		
		$sub_grade= $_POST['sub_grade'];
		$m_code= $_POST['m_code'];
		$c_code= $_POST['c_code'];

		$query = "INSERT INTO rm_s_grade(sub_grade,m_code,c_code) VALUES ('$sub_grade','$m_code','$c_code')";
		$run = sqlsrv_query($con,$query);
		if($run == true)
		{
			$_SESSION['mess'] = "sub_Grade Updated Successfully";
						header("location:sub_grade.php");
		}
		else{
			echo "Errorrr!!!";
			
		}
	}
	else{
		$_SESSION['mess'] = "Session Not Set";
            header("location:sub_grade.php");
	}
	
?>