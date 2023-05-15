<?php
include('../../../dbcon.php');
if (isset($_POST['mc'])) {

    $query = "SELECT * FROM mc_master WHERE mc LIKE '%".$_POST["mc"]."%' and plant = '696'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
        $dpnt = $row['dpnt'];
        $plant = $row['plant'];
        $response[] = array("label"=>$row['mc'],"dname"=>$dpnt,"plant"=>$plant);
    }

    echo json_encode($response);

    }
exit;
?>