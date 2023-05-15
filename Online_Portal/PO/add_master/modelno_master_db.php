<?php
include('..\..\..\dbcon.php');

if($_GET['status'] == 0)
{
	$make_by= $_POST['make_by'];
	$modelno= $_POST['modelno'];

	$query = "INSERT INTO rm_model_master(MakebyIDP,ModelName) VALUES ('$make_by','$modelno')";
	$run = sqlsrv_query($con,$query);
	if($run)
	{
		echo "Successfully added";
	}
	else
	{
		echo "Errorrr!!!";
	}
}
else if($_GET['status'] == 1)
{
	$make_by= $_POST['make_byu'];
	$modelno= $_POST['modelnou'];
	$id = $_POST['id'];

	$query = "UPDATE rm_model_master set MakebyIDP = '$make_by', ModelName = '$modelno' where ModelIDP = '$id'";
	$run = sqlsrv_query($con,$query);
	if($run)
	{
		echo "Successfully updated";
	}
	else
	{
		echo "Errorrr!!!";
	}
}	
else if($_GET['status'] == 2)
{
	$id = $_POST['id'];

	$query = "UPDATE rm_model_master set Status = 0 where ModelIDP = '$id'";
	$run = sqlsrv_query($con,$query);
	if($run)
	{
		echo "Successfully Deleted";
	}
	else
	{
		echo "Errorrr!!!";
	}
}	
?>