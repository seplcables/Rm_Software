<?php
include('..\..\dbcon.php');
if (isset($_POST['item'])) {
    $ii = $_POST['item'];
$query = "SELECT * FROM rm_item WHERE item LIKE '%$ii%'";
$result = sqlsrv_query($con,$query);
while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
                    $item = $row["item"];
                    $i_code = $row["i_code"];        
                    $s_code = $row["s_code"];
                    $m_code = $row["m_code"];
                    $c_code = $row["c_code"];
$queryx="SELECT sub_grade FROM rm_s_grade where s_code='$s_code'";
$resultx=sqlsrv_query($con,$queryx);
$rowx=sqlsrv_fetch_array($resultx, SQLSRV_FETCH_ASSOC);
$s_grade = $rowx['sub_grade'];

$queryy="SELECT main_grade FROM rm_m_grade where m_code='$m_code'";
$resulty=sqlsrv_query($con,$queryy);
$rowy=sqlsrv_fetch_array($resulty, SQLSRV_FETCH_ASSOC);
$m_grade = $rowy['main_grade'];

$queryz="SELECT category FROM rm_category where c_code='$c_code'";
$resultz=sqlsrv_query($con,$queryz);
$rowz=sqlsrv_fetch_array($resultz, SQLSRV_FETCH_ASSOC);
$cat = $rowz['category'];
                    
$response[] = array("m_grade"=>$m_grade,"s_grade"=>$s_grade,"cat"=>$cat,"label"=>$item,"i_code"=>$i_code,"s_code"=>$s_code,"m_code"=>$m_code,"c_code"=>$c_code);
}
echo json_encode($response);
}
exit;
?>