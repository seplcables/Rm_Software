<?php
//delete.php
session_start();
$user = $_SESSION['oid'];
date_default_timezone_set('Asia/Kolkata');
$date = date('m/d/Y h:i:s a', time());
include('..\..\..\dbcon.php');

 foreach($_POST["id"] as $id)
 {
          $sql="SELECT inward_com.invoice_no,inward_com.mat_from_party,inward_com.receive_date,inward_com.mat_ord_by,inward_ind.p_po_no,inward_ind.p_item,inward_ind.rec_qnty,inward_ind.p_unit,inward_ind.id from inward_ind left outer join inward_com on(inward_com.sr_no=inward_ind.sr_no) where inward_ind.id = '$id'";
          $run = sqlsrv_query($con,$sql);
          $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
                  $sql1="SELECT SUM(qnty) as qnty_value FROM rm_issue where inward_iid='$id'";
                  $run1=sqlsrv_query($con,$sql1);
                  $row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
                  $rec_qnty= $row['rec_qnty']-$row1['qnty_value'];
        
      
    $receive_dte = $row["receive_date"]->format("d/M/Y");
    $inward_ind_id = $id;
    $item = $row['p_item'];
    $qnty = $rec_qnty;
    $unit = $row['p_unit'];
    $party = $row['mat_from_party'];
    $mat_ord_by = $row['mat_ord_by'];
    $invoice_no = $row['invoice_no'];
    $po_no = $row['p_po_no'];
    $query = "INSERT INTO inward_store(receive_dte,inward_ind_id,item,qnty,unit,party,mat_ord_by,invoice_no,po_no,username,createdAt,come_from) VALUES ('$receive_dte','$inward_ind_id','$item','$qnty','$unit','$party','$mat_ord_by','$invoice_no','$po_no','$user','$date','inward')";
    $result = sqlsrv_query($con,$query); 
 }
?>