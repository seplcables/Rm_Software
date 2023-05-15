<?php 

if (isset($_POST['party'])) {
	include('..\..\..\dbcon.php');
    $query = "SELECT pid,party_name FROM rm_party_master WHERE party_name LIKE '%".$_POST["party"]."%'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
        $response[] = array("label"=>$row['party_name'],"pid"=>$row['pid']);
    }

    echo json_encode($response);

  }

exit;
 ?>