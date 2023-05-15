<?php

session_start();
$user = $_SESSION['oid'];
date_default_timezone_set('Asia/Kolkata');
$createdAt = date('m/d/Y h:i:s a', time());
include('..\..\..\dbcon.php');
if (isset($_POST['arr'])) {
    foreach ($_POST['arr'] as $row) {
        $query = "INSERT INTO inward_rm(receive_dte,store_name,item,qnty,unit,party,come_from,remark,username,createdAt,rmta,inward_ind_id) VALUES ('".$row['dte']."','".$row['storeName']."','".$row['icode']."','".$row['qnty']."','kg','".$row['pid']."','opening','".$row['remark']."','$user','$createdAt','".$row['rmta']."',0)";
        $result = sqlsrv_query($con, $query);
    }

    if ($result) {
        echo "Data Saved Successfully!!!!";
    } else {
        print_r(sqlsrv_errors());
    }
}
