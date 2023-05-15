<?php
include('..\..\..\dbcon.php');
if (isset($_POST['party'])) {
    $ii = $_POST['party'];
$query = "SELECT party_name,pid FROM rm_party_master WHERE party_name LIKE '%$ii%'";
$result = sqlsrv_query($con,$query);
while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
                    $party = $row["party_name"];
                    $pid = $row['pid'];
                    
$response[] = array("label"=>$party,"pid"=>$pid);
}
echo json_encode($response);
}
exit;
?>