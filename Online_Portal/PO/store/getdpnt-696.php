<?php
include('..\..\..\dbcon.php');
if (isset($_POST['dpnt'])) {

    $query = "SELECT DISTINCT dpnt, plant FROM mc_master WHERE dpnt LIKE '%".$_POST["dpnt"]."%' and plant = '696'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
        $sw = $row['dpnt'];
        $plant = $row['plant'];
        $response[] = array("label"=>$sw,"pname"=>$plant);
    }
    echo json_encode($response);
    }
exit;
?>