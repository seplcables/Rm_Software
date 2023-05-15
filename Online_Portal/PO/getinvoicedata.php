<?php
	
    include('../../dbcon.php');
    $sql="SELECT * from inward_com";
	$run=sqlsrv_query($con,$sql);
	while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
	{
		$srno = $row['sr_no'];
		$rec_at = $row['receive_at'];
		$party = $row['mat_from_party'];
		$invoice = $row['invoice_no'];
		$bill = $row['total_bill_amt'];

		 $result = array("$srno", "$rec_at", "$party", "$invoice", "$bill");
	}

  $myJSON = json_encode($result);
	echo $myJSON;

?>
