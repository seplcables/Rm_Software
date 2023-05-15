<?php

include('..\..\..\dbcon.php');
if (isset($_POST["iid"])) {
    $sql = "SELECT a.sr_no,b.item FROM inward_ind a
LEFT OUTER JOIN rm_item b on a.p_item = b.i_code WHERE a.id = '".$_POST["iid"]."'";
    $run = sqlsrv_query($con, $sql);
    $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

    $rows[] = $row;
    echo json_encode($row);
}

if (isset($_POST["bc"])) {
    $sql = "SELECT COUNT(id) as cnt from barcode_pvcIssue WHERE barcode_no = '".$_POST["bc"]."'";
    $run = sqlsrv_query($con, $sql);
    $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

    echo json_encode(array('cnt'=>$row['cnt']));
}
