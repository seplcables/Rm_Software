<?php
include('..\..\..\dbcon.php');

date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d h:i:s', time());


if($_GET['status'] == 0)
{
	$projectnm= $_POST['projectnm'];
	$user = $_POST['user'];

	$query = "INSERT INTO rm_project_master(ProjectName,Username,Status,TimeStamp) VALUES ('$projectnm','$user','1','$date')";
	$run = sqlsrv_query($con,$query);
	if($run)
	{
		echo "Project added successfully";
	}
	else
	{
		echo "!Error,Please try again";
	}
}
else if($_GET['status'] == 1)
{
	$projectnm= $_POST['projectnmu'];
	$id = $_POST['id'];

	$query = "UPDATE rm_project_master set ProjectName = '$projectnm' where ProjectIDP = '$id'";
	$run = sqlsrv_query($con,$query);
	if($run)
	{
		echo "Project updated successfully ";
	}
	else
	{
		echo "!Error,Please try again";
	}
}	
else if($_GET['status'] == 2)
{
	$id = $_POST['id'];

	$query = "UPDATE rm_project_master set Status = 0 where ProjectIDP = '$id'";
	$run = sqlsrv_query($con,$query);
	if($run)
	{
		echo "Project removed Successfully";
	}
	else
	{
		echo "!Error,Please try again";
	}
}	
?>