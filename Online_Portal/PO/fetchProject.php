<?php
session_start();
include('..\..\dbcon.php');
	
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d h:i:s a', time());

if($_GET['status'] == 1)
{
	if(isset($_POST['project']))
	{
		$project = $_POST['project'];

		$sql3 = "SELECT ProjectName  FROM rm_project_master WHERE ProjectName LIKE '%".$project."%' and Status = 1";
		$run3 = sqlsrv_query($con,$sql3);
		while($row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC))
		{
			$response[] = array("label"=>$row3['ProjectName']);
		}
		echo json_encode($response);
	}
}
else if($_GET['status'] == 2)
{
	$pname = $_POST['projectname'];

	$sql3 = "SELECT ProjectName  FROM rm_project_master WHERE ProjectName = '".$pname."'";
	$run3 = sqlsrv_query($con,$sql3);
	$row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);

	if($row3['ProjectName'] == $pname)
	{
		echo "This Project name is already exits";
	}
	else
	{

		$insert = "INSERT INTO rm_project_master(ProjectName, Username, Status, TimeStamp) values('".$pname."','".$_SESSION['oid']."','1','$date')"; 

	        //echo $insert;  
	    $run = sqlsrv_query($con,$insert);
	    if(!$run)
	    {
	      echo sqlsrv_errors();
	    }
	    else
	    {
	      echo "Data Updated Succesfuly";
	    }
	  }
}
?>