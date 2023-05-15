<?php 

if (isset($_POST['indentor'])) {
	include('..\..\dbcon.php');
    $query = "SELECT * FROM online_portal_user WHERE name LIKE '%".$_POST["indentor"]."%'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
        $response[] = array("label"=>$row['name'],"dpnt"=>$row['department']);
    }

    echo json_encode($response);

  }

exit;
 ?>