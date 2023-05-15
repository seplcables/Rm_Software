<?php
	session_start();
  $user = $_SESSION['oid'];
    date_default_timezone_set('Asia/Kolkata');
    $createdAt = date('m/d/Y h:i:s a', time());
            include('..\..\..\dbcon.php');
            if (isset($_POST['save'])) {

              $challan_no = $_POST['challan_no'];
              $in_date = $_POST['in_date'];
              $party_challan = $_POST['party_challan'];
              $bill_no = $_POST['bill_no'];
              $in_qnty = $_POST['in_qnty'];
              $rate = $_POST['rate'];
              $basic_value = $_POST['basic_value'];

              $freight_taxable = $_POST['freight_taxable'];
              $total_tax_amt = $_POST['total_tax_amt'];
              $cgst_per = $_POST['cgst_per'];
              $cgst_amt = $_POST['cgst_amt'];
              $sgst_amt = $_POST['sgst_amt'];

              $igst_per = $_POST['igst_per'];
              $igst_amt = $_POST['igst_amt'];
              $freight_no_tax = $_POST['freight_no_tax'];
              $other_charge = $_POST['other_charge'];
              $total_bill_amt = $_POST['total_bill_amt'];
              $remark = $_POST['remark'];
							$pid = $_POST['pid'];



              $query = "INSERT INTO jw_return(in_date,party_challan,bill_no,in_qnty,rate,basic_value,fr_taxable,total_tax_amt,cgst_sgst_per,cgst_amt,sgst_amt,igst_per,igst_amt,fr_no_tax,other_charge,total_bill_amt,remark,iid,user_name,createdAt,pid) VALUES ('$in_date','$party_challan','$bill_no','$in_qnty','$rate','$basic_value','$freight_taxable','$total_tax_amt','$cgst_per','$cgst_amt','$sgst_amt','$igst_per','$igst_amt','$freight_no_tax','$other_charge','$total_bill_amt','$remark','$challan_no','$user','$createdAt','$pid')";
                $run = sqlsrv_query($con,$query);
 if($run == true)
    {
      ?>
                    <script>
                          alert('Saved SucessFully !!!!');
                          window.open('showdata.php','_self');
                   </script>
      <?php


    }
          else{
                  print_r(sqlsrv_errors());
                  }




}
            ?>
