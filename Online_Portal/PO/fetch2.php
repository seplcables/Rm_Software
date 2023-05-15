<?php
include('..\..\dbcon.php');

if (isset($_POST['party'])) {

    $query = "SELECT * FROM rm_party_master WHERE party_name LIKE '%".$_POST["party"]."%'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
        $pcode = $row['p_code'];
        $pid = $row['pid'];

        $response[] = array("label"=>$row['party_name'],"pcode"=>$pcode,"pid"=>$pid);
    }

    echo json_encode($response);
  }

exit;
    ?>