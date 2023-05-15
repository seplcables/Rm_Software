<?php
//delete.php
session_start();
$user = $_SESSION['oid'];
date_default_timezone_set('Asia/Kolkata');
$date = date('m/d/Y h:i:s a', time());
include('..\..\..\..\dbcon.php');

  $pa = $_POST["pa"];
  $ti = $_POST["ti"];
  $re = $_POST["re"];
  $pay = $pa;
  $ah = $_POST["ah"];
 foreach($_POST["id"] as $key => $id)
 {

          $sql="SELECT * FROM jw_return WHERE CONCAT(id,'jw') = '".$id."'";
          $run=sqlsrv_query($con,$sql);
          $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
          $i_date = $row['in_date']->format('d-M-y');

      $sql3="SELECT SUM(payment_amt) as payment_value FROM payment_table WHERE CONCAT(sr_no,receive_at) = '".$id."'";
        $run3=sqlsrv_query($con,$sql3);
        $row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);

          $total_pay = $row['total_bill_amt']-$row3['payment_value'];

          if ($pay >= $total_pay) {
          	$pay -= $total_pay;
          $query = "INSERT INTO payment_table(party,total_amt,payment_amt,trans_id,remark,sr_no,receive_at,username,createdAt,Ac_Head,invoice_no,invoice_date,bill_amt) VALUES ('".$row['pid']."','$pa','$total_pay','$ti','$re','".$row['id']."','jw','$user','$date','".$ah[$key]."','".$row['bill_no']."','$i_date','".$row['total_bill_amt']."')";
            $result = sqlsrv_query($con,$query);
           }
           else{
           	$query = "INSERT INTO payment_table(party,total_amt,payment_amt,trans_id,remark,sr_no,receive_at,username,createdAt,Ac_Head,invoice_no,invoice_date,bill_amt) VALUES ('".$row['pid']."','$pa','$pay','$ti','$re','".$row['id']."','jw','$user','$date','".$ah[$key]."','".$row['bill_no']."','$i_date','".$row['total_bill_amt']."')";
            $result = sqlsrv_query($con,$query);
           	break;
           }
 }
?>
