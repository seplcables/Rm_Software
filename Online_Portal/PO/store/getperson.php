<?php
include('..\..\..\dbcon.php');
if (isset($_POST['person'])) {

    $query = "SELECT DISTINCT superwizer FROM mc_master WHERE superwizer LIKE '%".$_POST["person"]."%'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
        $sw = $row['superwizer'];
                    $sql1 = "SELECT * FROM mc_master WHERE superwizer='$sw'";
                    $run1 = sqlsrv_query($con,$sql1);
                    $row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
        $dpnt = $row1['dpnt'];
        $plant = $row1['plant'];
        $response[] = array("label"=>$sw,"dname"=>$dpnt,"pname"=>$plant);
    }

    echo json_encode($response);

    }
exit;
?>