<?php

session_start();
include('../../../dbcon.php');
$user = (isset($_SESSION['oid'])) ? $_SESSION['oid'] : 'user';
$isreturn = $_GET['isreturn'];
if($isreturn == "yes")
{
    $run = true;
    foreach ($_POST['barcode_id'] as $key => $value) 
    {
        if ($value == '') {
            continue;
        }
        $inId = explode("/", $value);

        $sql = "UPDATE barcode_pvcIssue set isReturn = 1 where barcode_no = '".$value."' and isReturn = 0";
        $run = sqlsrv_query($con, $sql);
    }
    if ($run) 
    {
        echo "Updated Successfully";
    } else {
        // echo $sql;
        print_r(sqlsrv_errors());
    }

}
else if($isreturn == "no")
{
    $run = true;
    foreach ($_POST['barcode_id'] as $key => $value) 
    {
        if ($value == '') {
            continue;
        }
        $inId = explode("/", $value);
        $sql = "INSERT INTO barcode_pvcIssue(inward_id,barcode_no,issue_date,mc,issue_qnty,username) VALUES('".$inId[0]."','".$value."','".$_GET['dt']."','".$_GET['mc']."',25,'".$user."')";
        $run = sqlsrv_query($con, $sql);
    }
    if ($run) 
    {
        echo "Saved Successfully";
    } else {
        // echo $sql;
        print_r(sqlsrv_errors());
    }
}

