<?php
include('..\..\..\dbcon.php');
if (isset($_POST['mc'])) {

    $query = "SELECT * FROM mc_master WHERE mc LIKE '%".$_POST["mc"]."%'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
        $pname = $row['superwizer'];
        $dpnt = $row['dpnt'];
        $plant = $row['plant'];
        $response[] = array("label"=>$row['mc'],"pname1"=>$pname,"dname"=>$dpnt,"pname2"=>$plant);
    }

    echo json_encode($response);

    }
exit;
?>