<?php
include('..\..\..\dbcon.php');
if (isset($_POST['good'])) {
	$ii = $_POST['good'];
$query = "SELECT * FROM jw_scrap_type WHERE type_of_report LIKE '%$ii%'";
$result = sqlsrv_query($con,$query);
while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
                    $scrap_type = $row["type_of_report"];
                    $hsn = $row["hsn_code"];        
                    $nop = $row["nature_of_PR"];
                    
$response[] = array("label"=>$scrap_type,"hsn"=>$hsn,"nop"=>$nop);
}
echo json_encode($response);
}
exit;
?>