<?php

include('..\..\dbcon.php');
date_default_timezone_set('Asia/Kolkata');
$lastDate = date('Y-m-d', strtotime('-60 days'));

$sql = "SELECT id,po_date,po_gen_by,party_name,depart_ment,po_value from po_entry_head a
LEFT OUTER JOIN rm_party_master b on a.party = b.pid where p_terms != 'cancle' and po_date >= '$lastDate' order by id desc";
$run = sqlsrv_query($con, $sql);
$rows = array();
while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
    // $sql1 = "SELECT count(id) as isPurchaseEntry from inward_ind where p_po_no like '%".$row['id']."%'";
    // $run1 = sqlsrv_query($con, $sql1);
    // $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
    // // array_push($row, "isPurchaseEntry", $row1['isPurchaseEntry']);
    // $rows[] = array('id' =>$row['id'] ,'po_date' =>$row['po_date'] ,'po_gen_by' =>$row['po_gen_by'] ,'party_name' =>$row['party_name'] ,'depart_ment' =>$row['depart_ment'],'po_value'=>round($row['po_value']) ,'isPurchaseEntry' =>$row1['isPurchaseEntry']);
    // ;
    $rows[] = $row;
}
echo json_encode($rows);
