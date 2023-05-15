<?php 
session_start();
$user = $_SESSION['oid'];
date_default_timezone_set('Asia/Kolkata');
$date = date('m/d/Y h:i:s a', time());
include('..\..\..\dbcon.php');


if($_GET['status'] == 0)
{
	/* common feild */
	
	$poheadid = $_POST['value'];

	foreach ($poheadid as $key => $value) 
	{
		if ($poheadid[$key] == '') 
		{
	        continue;
	    }
	    $update = "UPDATE po_entry_head set advance_status = 1 where id = '".$poheadid[$key]."'";

		$run = sqlsrv_query($con,$update);
	}
	if ($run) 
	{
		?>
		<script type="text/javascript">
			alert("Data Updated Successfully");
			window.open("advancePayment.php","_self");
		</script>
		<?php
	}
	else{
		 print_r(sqlsrv_errors());
	}
	
}

?>