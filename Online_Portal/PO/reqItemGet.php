<?php
include('..\..\dbcon.php');

if (isset($_POST['item'])) {
    $ii = $_POST['item'];
$query = "SELECT * FROM rm_item WHERE item LIKE '%$ii%' and c_code != 30 and c_code != 37";
$result = sqlsrv_query($con,$query);
while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
                    $item = $row["item"];
                    $c_code = $row["c_code"];
                    $i_code = $row["i_code"];

$queryz="SELECT category FROM rm_category where c_code='$c_code'";
$resultz=sqlsrv_query($con,$queryz);
$rowz=sqlsrv_fetch_array($resultz, SQLSRV_FETCH_ASSOC);
$cat = $rowz['category'];

                    
$response[] = array("label"=>$item,"cat"=>$cat,"i_code"=>$i_code);
}
echo json_encode($response);
}
exit;
?>