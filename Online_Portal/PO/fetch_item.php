<?php
include('..\..\dbcon.php');

if (isset($_POST['desc'])) {

    $query = "SELECT * FROM rm_item WHERE item LIKE '%".$_POST["desc"]."%'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
        $i_code = $row["i_code"];
        $m_code = $row["m_code"];
        $s_code = $row["s_code"];
        $c_code = $row["c_code"];
        $response[] = array("label"=>$row['item'],"i_code"=>$i_code,"m_code"=>$m_code,"s_code"=>$s_code,"c_code"=>$c_code);
    }

    echo json_encode($response);
  }

exit;
    ?>