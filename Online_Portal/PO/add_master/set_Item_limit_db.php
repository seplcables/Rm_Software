<?php
session_start();
include('..\..\..\dbcon.php');
if($_GET['status'] == 0)
{	
	$item_name= $_POST['i_code'];
	$min_limit= $_POST['min_limit'];
	$max_limit= $_POST['max_limit'];
	$is_limit= $_POST['is_limit'];

	$run = '';

	foreach($item_name as $key=>$value)
	{
		if(($min_limit[$key] == '') && ($max_limit[$key] == ''))
		{
			continue;
		}

		$query = "UPDATE rm_item set  min_limit = '".$min_limit[$key]."', max_limit = '".$max_limit[$key]."', is_limit = '".$is_limit[$key]."' where i_code = '".$item_name[$key]."'";
		$run = sqlsrv_query($con,$query);
	}
	if(!$run)
	{
		echo "Kindly enter min & max limit both.";
	}
	else
	{	
		echo "Updated Successfully.";
	}
}	
?>