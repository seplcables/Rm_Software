<?php
include('..\..\..\dbcon.php');
if (isset($_POST['party'])) {
	$ii = $_POST['party'];
$query = "SELECT pid,party_name,party_address,gstin FROM rm_party_master WHERE party_name LIKE '%$ii%'";
$result = sqlsrv_query($con,$query);
while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
                    $party = $row["party_name"];
                    $add_ress = $row["party_address"];
                    $gstno = $row["gstin"];
										$pid = $row["pid"];

$response[] = array("label"=>$party,"gst"=>$gstno,"add"=>$add_ress,"pid"=>$pid);
}
echo json_encode($response);
}
exit;
?>
