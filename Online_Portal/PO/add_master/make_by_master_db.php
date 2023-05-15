<?php
include('..\..\..\dbcon.php');

if($_GET['status'] == 0)
{
	$make_by= $_POST['makeby'];

	$query = "INSERT INTO rm_makeby_master(Make_by) VALUES ('$make_by')";
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
	$make_by= $_POST['makebyu'];
	$id = $_POST['id'];

	$query = "UPDATE rm_makeby_master set Make_by = '$make_by' where MakebyIDP = '$id'";
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

	$query = "UPDATE rm_makeby_master set Status = 0 where MakebyIDP = '$id'";
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