<?php
include('..\..\..\dbcon.php');
		
$ii = $_POST['item'];
$response = array();		
$query = "SELECT i_code,item,min_limit,max_limit,is_limit FROM rm_item WHERE item LIKE '%$ii%'";
$result = sqlsrv_query($con,$query);
while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
                    
                    
$response[] = array("label"=>$row['item'],"min"=>$row['min_limit'],"max"=>$row['max_limit'],"i_code"=>$row['i_code']);
}
echo json_encode($response);

exit;
?>