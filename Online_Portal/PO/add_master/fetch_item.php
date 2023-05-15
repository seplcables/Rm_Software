<?php
include('..\..\..\dbcon.php');

if($_GET['status'] == 0)
{
	if(isset($_POST['catg']))
	{
		$category = $_POST['catg'];
		
		$sql3 = "SELECT category from  rm_category where category like '%$category%'";
		$run3 = sqlsrv_query($con,$sql3);
		while($row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC))
		{
			$response[] = array("label"=>$row3['category']);
		}
		 echo json_encode($response);
	}
}
else if($_GET['status'] == 1)
{
	if(isset($_POST['mgrade']))
	{
		$mgrade = $_POST['mgrade'];
		
		$sql3 = "SELECT main_grade from  rm_m_grade where main_grade like '%$mgrade%'";
		$run3 = sqlsrv_query($con,$sql3);
		while($row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC))
		{
			$response[] = array("label"=>$row3['main_grade']);
		}
		 echo json_encode($response);
	}
}
else if($_GET['status'] == 2)
{
	if(isset($_POST['sgrade']))
	{
		$sgrade = $_POST['sgrade'];
		
		$sql3 = "SELECT sub_grade from  rm_s_grade where sub_grade like '%$sgrade%'";
		$run3 = sqlsrv_query($con,$sql3);
		while($row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC))
		{
			$response[] = array("label"=>$row3['sub_grade']);
		}
		echo json_encode($response);
	}
}
else if($_GET['status'] == 3)
{
	if(isset($_POST['item']))
	{
		$item = $_POST['item'];
		
		$sql3 = "SELECT item from  rm_item where item like '%$item%'";
		$run3 = sqlsrv_query($con,$sql3);
		while($row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC))
		{
			$response[] = array("label"=>$row3['item']);
		}
		echo json_encode($response);
	}
}
?>