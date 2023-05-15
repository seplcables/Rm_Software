<?php 
session_start();
date_default_timezone_set('Asia/Kolkata');
$current_date = date('dmY', time());
include('..\..\..\dbcon.php');
/*--------------------------------- code for save data -----------------------------------*/
if (isset($_POST['itemid'])) 
{

	$editrubberdate = $_POST['editrubberdate'];
	$editrubberbatchcode = $_POST['editrubberbatchcode'];
	$editrubberjobno = $_POST['editrubberjobno'];
	$editrubberamount = $_POST['editrubberamount'];
	$editrubbermainweight = $_POST['editrubbermainweight'];
	$editrsinkg = $_POST['editrsinkg'];

	$edititemrate = $_POST['edititemrate'];
	$edititemweight = $_POST['edititemweight'];

	$edititemamt = $_POST['edititemamt'];
	$itemid = $_POST['itemid'];

	$amount = array();
	
	foreach ($itemid as $key => $value) 
	{
		$amount[$key] = $edititemrate[$key] * $edititemweight[$key];

		$sql = "UPDATE rubber_issue set issue_date = '".$editrubberdate."', batch_code = '".$editrubberbatchcode."', job_no = '".$editrubberjobno."', rate = '".$edititemrate[$key]."', weight = '".$edititemweight[$key]."', amount = '".$amount[$key]."' where id = '".$itemid[$key]."'";


		//$sql = "INSERT INTO rubber_issue(issue_date,batch_code,job_no,rmta,item,rate,weight,amount,username) VALUES('$date','$bcode','$jobno','".$rmta[$key]."','".$item[$key]."','".$rate[$key]."','".$weight[$key]."','".$amount[$key]."','".$_SESSION['oid']."')";

		$run = sqlsrv_query($con,$sql);
	}
	if($run){
	?>
	<script type="text/javascript">
		alert("Data Update Successfully");
		window.location.href = "issue_report.php";
	</script>
	<?php 
	}
	else
	{
	?>
	<script type="text/javascript">
		alert("Error!Please try again");
		window.location.href = "issue_report.php";
	</script>
	<?php
		//print_r(sqlsrv_errors());

	}
}

?>