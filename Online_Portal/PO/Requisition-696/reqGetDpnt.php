<?php
include('..\..\..\dbcon.php');
if (isset($_POST['dpnt'])) {

    $query = "SELECT DISTINCT dpnt FROM mc_master WHERE dpnt LIKE '%".$_POST["dpnt"]."%' and plant = '696'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
        $sw = $row['dpnt'];
                    $sql1 = "SELECT plant FROM mc_master WHERE dpnt='$sw'";
                    $run1 = sqlsrv_query($con,$sql1);
                    $row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
        $plant = $row1['plant'];
        $response[] = array("label"=>$sw,"plant"=>$plant);
    }

    echo json_encode($response);

    }
exit;
?>