<?php
include('..\..\..\dbcon.php');
if (isset($_POST['grade'])) {
    $ii = $_POST['grade'];
$query = "SELECT * FROM rm_item WHERE (m_code = 144 or m_code = 148 or m_code = 161 or m_code = 171) and item LIKE '%$ii%'";
$result = sqlsrv_query($con,$query);
while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
                    $item = $row["item"];
                    $i_code = $row['i_code'];
                    $s_code = $row['s_code'];
                    $m_code = $row['m_code'];
$query1="SELECT sub_grade FROM rm_s_grade where s_code='$s_code'";
$result1=sqlsrv_query($con,$query1);
$row1=sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC);
$sub_grade = $row1['sub_grade'];

$query2="SELECT main_grade FROM rm_m_grade where m_code='$m_code'";
$result2=sqlsrv_query($con,$query2);
$row2=sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);
$main_grade = $row2['main_grade'];
                    
$response[] = array("label"=>$item,"main_grade"=>$main_grade,"sub_grade"=>$sub_grade,"i_code"=>$i_code,"s_code"=>$s_code,"m_code"=>$m_code);
}
echo json_encode($response);
}
exit;
?>