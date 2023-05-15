<?php

if(isset($_GET['desc']))
{
include('..\..\dbcon.php');
$desc = $_GET['desc'];
if($desc!==""){
$sql = "SELECT *  FROM rm_item WHERE i_code='$desc'";
$run = sqlsrv_query($con,$sql);
$row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

$m_code = $row["m_code"];
$s_code = $row["s_code"];
                    $c_code = $row["c_code"];

$sql1 = "SELECT *  FROM rm_m_grade WHERE m_code='$m_code'";
$run1 = sqlsrv_query($con,$sql1);
$row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
$m_grade = $row1["main_grade"];

$sql2 = "SELECT *  FROM rm_s_grade WHERE s_code='$s_code'";
$run2 = sqlsrv_query($con,$sql2);
$row2=sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
$s_grade = $row2["sub_grade"];

$sql3 = "SELECT *  FROM rm_category WHERE c_code='$c_code'";
$run3 = sqlsrv_query($con,$sql3);
$row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);
$cat = $row3["category"];

}
	$result = array("$m_grade", "$s_grade", "$cat");
	$myJSON = json_encode($result);
	echo $myJSON;
}

?>