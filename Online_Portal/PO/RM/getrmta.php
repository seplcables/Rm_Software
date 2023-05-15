<?php
include('..\..\..\dbcon.php');
if (isset($_POST['rmta'])) 
{
    $ii = $_POST['rmta'];
    $ss = $_POST['store'];

    $sql="SELECT MAX(rm_opening_date) as last_date FROM store_opening_date";
    $runa=sqlsrv_query($con,$sql);
    $rowa = sqlsrv_fetch_array($runa, SQLSRV_FETCH_ASSOC);
    $dd = $rowa['last_date']->format('d-M-y');

$query = "SELECT distinct a.sr_no, a.p_item, b.m_code, b.i_code,  b.item  from inward_ind a left join rm_item b on a.p_item = b.i_code where  b.m_code IN ('148','161','163','171','174') and a.sr_no like '%$ii%'";
//$query = "SELECT distinct sr_no, p_item from inward_ind where sr_no like '%$ii%' order by sr_no asc";
//$query = "SELECT distinct item,rmta FROM inward_rm WHERE store_name = '$ss' and rmta LIKE '%$ii%'";
$result = sqlsrv_query($con,$query);
$params = array();
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$run=sqlsrv_query($con,$query,$params,$options);
if (sqlsrv_num_rows($run) > 0) {
while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
                    $i_code = $row["i_code"];
                    $rmta = $row['sr_no'];
                    $item = $row['item'];
//$queryx="SELECT item FROM rm_item where i_code='$i_code'";
// $queryx="SELECT item, m_code FROM rm_item where i_code='$i_code' and m_code IN ('148','161','163','171','174')";
// $resultx=sqlsrv_query($con,$queryx);
// $rowx=sqlsrv_fetch_array($resultx, SQLSRV_FETCH_ASSOC);
// if($rowx['m_code'] == '')
// {
//     continue;
// }
//$item = $rowx['item'];

// $query2="SELECT SUM(qnty) as inw_qnty FROM inward_rm where rmta='$rmta' and store_name = '$ss' and receive_dte >= '$dd'";
// $result2=sqlsrv_query($con,$query2);
// $row2=sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);

// $query3="SELECT SUM(issue_qnty) as issue_qty FROM pvc_issue where rmta='$rmta' and store_name = '$ss'  and issue_date > '$dd'";
// $result3=sqlsrv_query($con,$query3);
// $row3=sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);

// $qnty= $row2["inw_qnty"]-$row3['issue_qty'];
                    
$response[] = array("label"=>"(".$rmta.") ".$item,"grade"=>$item,"rmta"=>$rmta,"bal"=>0,"i_code"=>$i_code);
}
}
else{
	$response[] = array("label"=>'No Data Found');
}
echo json_encode($response);
}
exit;
?>