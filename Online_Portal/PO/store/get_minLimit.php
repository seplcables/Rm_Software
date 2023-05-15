<?php
include('..\..\..\dbcon.php');
        $sql="SELECT MAX(opening_date) as last_date FROM store_opening_date";
        $run=sqlsrv_query($con,$sql);
        $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
        $ope_dte = $row['last_date']->format('d-M-y');

$sql1 = "SELECT * from rm_item where is_limit = 'yes'";
$run1 = sqlsrv_query($con,$sql1);
while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
{
	$i_code = $row1['i_code'];
    $item = $row1['item'];
    $s_code = $row1['s_code'];
    $m_code = $row1['m_code'];
    $c_code = $row1['c_code'];
    $min_limit = $row1['min_limit'];
    $max_limit = $row1['max_limit'];
    

        $sql2="SELECT SUM(qnty) as inw_qnty FROM inward_store where item='$i_code' and receive_dte >='$ope_dte'";
        $run2=sqlsrv_query($con,$sql2);
        $row2=sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);

        $sql3="SELECT SUM(qnty) as qnty_value FROM rm_issue where item_name='$i_code' and issue_from = 'store' and issue_date >='$ope_dte'";
        $run3=sqlsrv_query($con,$sql3);
        $row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);

        $qnty= $row2["inw_qnty"]-$row3['qnty_value'];
        
        $query5="SELECT sub_grade FROM rm_s_grade where s_code='$s_code'";
        $result5=sqlsrv_query($con,$query5);
        $row5=sqlsrv_fetch_array($result5, SQLSRV_FETCH_ASSOC);
        $aaa = $row5['sub_grade'];
        $query6="SELECT main_grade FROM rm_m_grade where m_code='$m_code'";
        $result6=sqlsrv_query($con,$query6);
        $row6=sqlsrv_fetch_array($result6, SQLSRV_FETCH_ASSOC);
        $bbb = $row6['main_grade'];
        $query7="SELECT category FROM rm_category where c_code='$c_code'";
        $result7=sqlsrv_query($con,$query7);
        $row7=sqlsrv_fetch_array($result7, SQLSRV_FETCH_ASSOC);
        $ccc = $row7['category'];
        $diff = floatval($qnty) - floatval($min_limit);
        if (floatval($qnty) > floatval($min_limit)) {
        	continue;
        }
        

        $rows[] = array("data"=>$row1,"qty"=>$qnty,"s_grade"=>$aaa,"m_grade"=>$bbb,"cat"=>$ccc,"diff"=>$diff);

}


  echo json_encode($rows);







?>
