<?php
include('..\..\..\dbcon.php');
if (isset($_POST['issue_by'])) {

    $query = "SELECT DISTINCT name FROM emp_data WHERE name LIKE '%".$_POST["issue_by"]."%'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
        $sw = $row['name'];
                    
        $response[] = array("label"=>$sw);
    }

    echo json_encode($response);

    }
exit;
?>