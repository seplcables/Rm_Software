<?php
include('../../../dbcon.php');
$sql = "SELECT * from Requisition_head order by id desc";
$run = sqlsrv_query($con,$sql);
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
$sql1 = "SELECT reject from Requisition_details where iid = '".$row['id']."' and reject is NULL";
$params = array();
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$run1=sqlsrv_query($con,$sql1,$params,$options);
$row1=sqlsrv_num_rows($run1);
if ($row1 < 1) {
	continue;
}
$sql2 = "SELECT req_aprv from Requisition_details where iid = '".$row['id']."' order by req_aprv desc";
$run2 = sqlsrv_query($con,$sql2);
$row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);

$sql3 = "SELECT rateApprove from Requisition_details where iid = '".$row['id']."' order by req_aprv desc";
$run3 = sqlsrv_query($con,$sql3);
$row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);

$sql4 = "SELECT b.rate from Requisition_details a
left outer join requisition_rate b on a.id=b.iid
where a.iid= '".$row['id']."' and reject is null and party_id is null";
$run4 = sqlsrv_query($con,$sql4,$params,$options);
$row4 = sqlsrv_num_rows($run4);
if ($row4 < 1) {
	$rate = "yes";
}
else{
	$rate = "no";
}

$sql5 = "SELECT distinct party_name from Requisition_details a
			inner join Requisition_head b on a.iid=b.id
			inner join Requisition_rate c on c.iid=a.id
			inner join rm_party_master d on c.party_id=d.pid
			where b.id = '".$row['id']."'";
$run5 = sqlsrv_query($con,$sql5);
$partyList = '';
while($row5 = sqlsrv_fetch_array($run5, SQLSRV_FETCH_ASSOC))
{
	
	$partyList .= $row5['party_name'].', ';
}

$rows[] = array("head"=>$row,"ma"=>$row2['req_aprv'],"ra"=>$row3['rateApprove'],"rate"=>$rate,"partyList"=>$partyList);
}
echo json_encode($rows);
?>