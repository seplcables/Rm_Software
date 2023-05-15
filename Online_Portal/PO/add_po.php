<?php  
 //fetch.php 
 session_start();
 include('../../dbcon.php');  
 if(isset($_GET["po_id"]))  
 {
 $xx = $_GET["po_id"];  
$sql = "SELECT * from po_entry_details d inner join po_entry_head h on d.iid = h.id where d.id='$xx'";
$run = sqlsrv_query($con,$sql);
$row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

$pid = $row["party"];
$i_code = $row["item_code"];
$s_code = $row["sub_grade"];
$m_code = $row["main_grade"];
$c_code = $row["category"];
$po_gen_by = $row["po_gen_by"];
$dpnt = $row["depart_ment"];
$hsn_code = $row["hsn_code"];
$project = $row["project"];
$job = $row["job"];
$remark = $row["remark"];
$stock = $row["stock"];
$unit = $row["unit"];
$rate = $row["rate"];
$po_no = $row["po_no"];
$pkg = $row["pkg"];
$iid = $row["iid"];

$p_days = $row["p_days"];
$p_terms = $row["p_terms"];

$t_amt = $rate* $_GET["bal"];

$sql1 = "SELECT item from rm_item where i_code='$i_code'";
$run1 = sqlsrv_query($con,$sql1);
$row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
$item_desc = $row1['item'];

$sql2 = "SELECT sub_grade from rm_s_grade where s_code='$s_code'";
$run2 = sqlsrv_query($con,$sql2);
$row2=sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
$sub_grade = $row2['sub_grade'];

$sql3 = "SELECT main_grade from rm_m_grade where m_code='$m_code'";
$run3 = sqlsrv_query($con,$sql3);
$row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);
$main_grade = $row3['main_grade'];

$sql4 = "SELECT category from rm_category where c_code='$c_code'";
$run4 = sqlsrv_query($con,$sql4);
$row4=sqlsrv_fetch_array($run4, SQLSRV_FETCH_ASSOC);
$category = $row4['category'];

$sql5 = "SELECT party_name from rm_party_master where pid='$pid'";
$run5 = sqlsrv_query($con,$sql5);
$row5=sqlsrv_fetch_array($run5, SQLSRV_FETCH_ASSOC);
$party = $row5['party_name'];



    $result = array("$party", "$party", "$po_gen_by", "$item_desc", "$sub_grade", "$main_grade", "$category", "$dpnt", "$hsn_code", "$project", "$job", "$remark", "$stock", "$unit", "$rate", "$rate", "$po_no", "$pkg", "$i_code", "$s_code", "$m_code", "$c_code", "$pid", "$t_amt", "$p_days", "$p_terms","$iid");
	$myJSON = json_encode($result);
	echo $myJSON;
 }  
 ?>