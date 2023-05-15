<?php
include('..\..\..\dbcon.php');
if (isset($_POST['party'])) {
$query = "SELECT distinct a.party,b.party_name
FROM payment_table a
LEFT OUTER JOIN rm_party_master b on a.party = b.pid where b.party_name LIKE '%".$_POST["party"]."%'";

$result = sqlsrv_query($con,$query);
while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
$party = $row['party_name'];
$pid = $row['party'];
$response[] = array("label"=>$row['party_name'],"pid"=>$pid);
}
echo json_encode($response);
	}
exit;
?>