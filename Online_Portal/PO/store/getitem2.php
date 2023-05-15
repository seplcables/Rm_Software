<?php
include('..\..\..\dbcon.php');
if (isset($_POST['item'])) {
	$ii = $_POST["item"];

    $query = "SELECT * FROM rm_item WHERE item LIKE '%$ii%' and c_code != 30 and c_code != 37";
    				
					
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
    	            $i_code = $row["i_code"];
    	            $m_code = $row["m_code"];
					$s_code = $row["s_code"];
					$c_code = $row["c_code"];

					$sql1 = "SELECT *  FROM rm_m_grade WHERE m_code='$m_code'";
					$run1 = sqlsrv_query($con,$sql1);
					$row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
					$m_grade = $row1["main_grade"];

					$sql2 = "SELECT *  FROM rm_s_grade WHERE s_code='$s_code'";
					$run2 = sqlsrv_query($con,$sql2);
					$row2=sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
					$s_grade = $row2["sub_grade"];

					$sql3 = "SELECT *  FROM rm_category WHERE c_code='$c_code'";
					$run3 = sqlsrv_query($con,$sql3);
					$row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);
					$cat = $row3["category"];
        $response[] = array("label"=>$row['item'],"m_grade"=>$m_grade,"s_grade"=>$m_grade,"cat"=>$cat,"i_code"=>$i_code,"s_code"=>$s_code,"m_code"=>$m_code,"c_code"=>$c_code);
    }

    echo json_encode($response);

  }
exit;
	?>