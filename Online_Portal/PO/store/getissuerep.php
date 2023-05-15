<?php

include('..\..\..\dbcon.php');
date_default_timezone_set('Asia/Kolkata');
$sql = "SELECT a.id,a.item_name,a.issue_date,e.category,d.main_grade,c.sub_grade,b.item,a.issue_to,a.mc_no,a.dpnt,a.plant_name,a.super_wizer,a.issued_by,a.qnty,a.unit,a.issue_cat,
a.old_part_status,a.remarks FROM rm_issue a LEFT OUTER JOIN rm_item b on a.item_name = b.i_code LEFT OUTER JOIN rm_s_grade c on b.s_code = c.s_code
LEFT OUTER JOIN rm_m_grade d on b.m_code = d.m_code LEFT OUTER JOIN rm_category e on b.c_code = e.c_code";
$run = sqlsrv_query($con, $sql);
while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
    $sql1 = "SELECT top 1 pur_rate as rate from inward_ind where p_item = '".$row['item_name']."' order by id desc";
    $run1 = sqlsrv_query($con, $sql1);
    $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
    $rte = round($row1['rate'], 2);

    $rows[] = array("data"=>$row,"rte"=>$rte);
}


  echo json_encode($rows);
