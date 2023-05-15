<?php  
 //fetch.php
 include('../../dbcon.php');  
 if(isset($_GET["po_id"]))  
 {  
 	$po_id = $_GET["po_id"];
 	$srno = $_GET["srno"];
    $sql = "SELECT * from inward_ind where iid='$po_id' AND sr_no='$srno'";
    $run = sqlsrv_query($con,$sql);
    $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

$i_code = $row["p_item"];
$sql1 = "SELECT item from rm_item where i_code='$i_code'";
$run1 = sqlsrv_query($con,$sql1);
$row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
$item_desc = $row1['item'];


$s_code = $row["p_sub_grade"];
$sql2 = "SELECT sub_grade from rm_s_grade where s_code='$s_code'";
$run2 = sqlsrv_query($con,$sql2);
$row2=sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
$sub_grade = $row2['sub_grade'];

$m_code = $row["p_main_grade"];
$sql3 = "SELECT main_grade from rm_m_grade where m_code='$m_code'";
$run3 = sqlsrv_query($con,$sql3);
$row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);
$main_grade = $row3['main_grade'];

$hsn_code = $row["p_hsn_code"];
$project = $row["p_project"];
$job = $row["p_job"];
$remark = $row["p_remark"];
$stock = $row["p_stock"];
$unit = $row["p_unit"];
$qnty = $row["rec_qnty"];
$rate = $row["pur_rate"];
$pkg = $row["p_pkg"];
$plant = $row["plant"];

$disc_per = $row["disc_per"];
$disc_amt = $row["disc_amt"];
$packaging = $row["packaging"];
$insurance = $row["insurance"];
$freight = $row["freight"];
$other_charge = $row["other_charge"];
$taxable_amt = $row["taxable_amt"];

$cgst_per = $row["cgst_per"];
$cgst_amt = $row["cgst_amt"];
$sgst_per = $row["sgst_per"];
$sgst_amt = $row["sgst_amt"];
$igst_per = $row["igst_per"];
$igst_amt = $row["igst_amt"];
$tcs_per = $row["tcs_per"];
$tcs_amt = $row["tcs_amt"];
$total_tax_amt = $row["total_tax_amt"];
$total_amt = $row["total_amt"];








    $result = array("$srno", "$item_desc", "$sub_grade", "$main_grade", "$hsn_code", "$project", "$job", "$remark", "$stock", "$unit", "$qnty", "$rate", "$pkg", "$plant", "$disc_per", "$disc_amt", "$packaging", "$insurance", "$freight", "$other_charge", "$taxable_amt", "$cgst_per", "$cgst_amt", "$sgst_per", "$sgst_amt", "$igst_per", "$igst_amt", "$tcs_per", "$tcs_amt", "$total_tax_amt", "$total_amt", "$i_code", "$s_code", "$m_code");
	$myJSON = json_encode($result);
	echo $myJSON;

 }  
 ?>