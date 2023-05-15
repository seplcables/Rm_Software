<?php

include('..\..\..\dbcon.php');

        $sqla="SELECT MAX(opening_date) as last_date FROM store_opening_date";
        $runa=sqlsrv_query($con, $sqla);
        $rowa = sqlsrv_fetch_array($runa, SQLSRV_FETCH_ASSOC);
        $dd = $rowa['last_date']->format('d-M-y');

if (isset($_POST['item'])) {
    $ii = $_POST['item'];
    $query = "SELECT * FROM rm_item WHERE item LIKE '%$ii%' and i_code in(select item from inward_store)";
    $result = sqlsrv_query($con, $query);
    while ($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $item = $row["item"];
        $i_code = $row["i_code"];
        $s_code = $row["s_code"];
        $m_code = $row["m_code"];
        $c_code = $row["c_code"];
        $queryx="SELECT sub_grade FROM rm_s_grade where s_code='$s_code'";
        $resultx=sqlsrv_query($con, $queryx);
        $rowx=sqlsrv_fetch_array($resultx, SQLSRV_FETCH_ASSOC);
        $s_grade = $rowx['sub_grade'];

        $queryy="SELECT main_grade FROM rm_m_grade where m_code='$m_code'";
        $resulty=sqlsrv_query($con, $queryy);
        $rowy=sqlsrv_fetch_array($resulty, SQLSRV_FETCH_ASSOC);
        $m_grade = $rowy['main_grade'];

        $queryz="SELECT category FROM rm_category where c_code='$c_code'";
        $resultz=sqlsrv_query($con, $queryz);
        $rowz=sqlsrv_fetch_array($resultz, SQLSRV_FETCH_ASSOC);
        $cat = $rowz['category'];

        $query2="SELECT SUM(qnty) as inw_qnty FROM inward_store where item='$i_code' and receive_dte >='$dd'";
        $result2=sqlsrv_query($con, $query2);
        $row2=sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);

        $query3="SELECT SUM(qnty) as qnty_value FROM rm_issue where item_name='$i_code' and issue_from = 'store' and issue_date >='$dd'";
        $result3=sqlsrv_query($con, $query3);
        $row3=sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
        $qnty= $row2["inw_qnty"]-$row3['qnty_value'];


        $query4="SELECT item, inward_ind_id, po_no FROM inward_store where item='$i_code'";
        $result4=sqlsrv_query($con, $query4);
        $row4=sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC);

        $query5="SELECT iid FROM inward_ind where id='".$row4['inward_ind_id']."' and p_item = '".$row4['item']."' and p_po_no = '".$row4['po_no']."'";
        $result5=sqlsrv_query($con, $query5);
        $row5=sqlsrv_fetch_array($result5, SQLSRV_FETCH_ASSOC);

        $query6="SELECT make_by, model_no FROM po_entry_details where id='".$row5['iid']."'";
        $result6=sqlsrv_query($con, $query6);
        $row6=sqlsrv_fetch_array($result6, SQLSRV_FETCH_ASSOC);


        $response[] = array("m_grade"=>$m_grade,"s_grade"=>$s_grade,"cat"=>$cat,"qnty"=>$qnty,"label"=>$item,"i_code"=>$i_code,"s_code"=>$s_code,"m_code"=>$m_code,"c_code"=>$c_code,"make_by"=>$row6['make_by'],"model_no"=>$row6['model_no']);
    }
    echo json_encode($response);
}
exit;
