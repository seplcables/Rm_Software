<?php 
include('..\..\dbcon.php');
if (isset($_POST['desc'])) {

    $query = "SELECT a.i_code,a.s_code,a.m_code,a.c_code,a.item as label,b.sub_grade,c.main_grade,d.category FROM rm_item a
       left outer join rm_s_grade b on a.s_code = b.s_code
       left outer join rm_m_grade c on a.m_code = c.m_code
       left outer join rm_category d on a.c_code = d.c_code
    WHERE a.item LIKE '%".$_POST["desc"]."%'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
        $i_code = $row["i_code"];
        $m_code = $row["m_code"];
        $s_code = $row["s_code"];
        $c_code = $row["c_code"];
        $response[] = $row;
    }

    echo json_encode($response);

  }



 ?>