<?php
include('..\..\..\dbcon.php');
if (isset($_POST['item'])) {
    $ii = $_POST['item'];
$query = "SELECT * FROM rm_item WHERE item LIKE '%$ii%'";
$result = sqlsrv_query($con,$query);
while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
                 $item = $row["item"];
                 $c_code = $row['c_code'];
                 $m_code = $row['m_code'];
                 $s_code = $row['s_code'];

        $query1 = "SELECT * FROM rm_s_grade WHERE s_code = '$s_code'";
        $result1 = sqlsrv_query($con,$query1);
        $row1=sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC);
                    $s_grade = $row1["sub_grade"];
        $query2 = "SELECT * FROM rm_m_grade WHERE m_code = '$m_code'";
        $result2 = sqlsrv_query($con,$query2);
        $row2=sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);
                    $m_grade = $row2["main_grade"];
		$query3 = "SELECT * FROM rm_category WHERE c_code = '$c_code'";
        $result3 = sqlsrv_query($con,$query3);
        $row3=sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
                    $cat = $row3["category"];
            
                    

                    
$response[] = array("m_grade"=>$m_grade,"s_grade"=>$s_grade,"cat"=>$cat,"label"=>$item);
}
echo json_encode($response);
}
exit;
?>