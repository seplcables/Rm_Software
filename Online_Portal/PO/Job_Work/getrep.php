<?php
include('..\..\..\dbcon.php');
$sql = "SELECT a.id as ch_no,a.challan_date,a.consignee_name,a.goods_desc,a.qnty,a.unit,b.id,b.in_date,b.in_qnty,b.rate,b.basic_value,(cgst_sgst_per + igst_per) as gst_per,(cgst_amt+ sgst_amt + igst_amt) as gst_amt,total_tax_amt,total_bill_amt
FROM jw_challan a
LEFT OUTER JOIN jw_return b on a.id = b.iid";
$run = sqlsrv_query($con,$sql);
$rows = array();
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
	  $sqla="SELECT sum(in_qnty) as due FROM jw_return where iid='".$row['ch_no']."'";
      $runa=sqlsrv_query($con,$sqla);
      $rowa=sqlsrv_fetch_array($runa, SQLSRV_FETCH_ASSOC);
      $qnty = $row['qnty'] - $rowa['due'];

	if ($qnty <= 0) {
		$status = 'Done';
	}
	else{
		$status = 'pend.';
	 }
       $rows[] = array("data"=>$row,"due_qnty"=>$qnty,"sts"=>$status);
}


  echo json_encode($rows);







?>