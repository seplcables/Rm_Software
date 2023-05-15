<?php
	session_start();
  $user = $_SESSION['oid'];
    date_default_timezone_set('Asia/Kolkata');
    $createdAt = date('m/d/Y h:i:s a', time());
            include('..\..\..\dbcon.php');
            if (isset($_POST['save'])) {
                $sql="SELECT MAX(id) as sr_no FROM jw_challan";
                $run=sqlsrv_query($con,$sql);
                $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
                $sr_no = $row['sr_no'] + 1;

              $date = $_POST['date'];
              $name = $_POST['name'];
              $gst = $_POST['gst'];
              $add = $_POST['add'];
              $name1 = $_POST['name1'];
							$pid = $_POST['pid'];
              $gst1 = $_POST['gst1'];
              $add1 = $_POST['add1'];

              $dog = $_POST['dog'];
              $identify = $_POST['identify'];
              $qnty = $_POST['qnty'];
              $unit = $_POST['unit'];
              $val = $_POST['val'];

              $hsn_code = $_POST['hsn_code'];
              $taxable_goods = $_POST['taxable_goods'];
              $vehicle_no = $_POST['vehicle_no'];
              $nature_of_processing = $_POST['nature_of_processing'];
              $duration_days = $_POST['duration_days'];
              $expected_receive_date = $_POST['expected_receive_date'];



              $query = "INSERT INTO jw_challan(id,challan_date,consignor_name,consignor_gst,consignor_add,consignee_name,consignee_gst,consignee_add,goods_desc,marks,qnty,unit,basic_val,hsn_code,taxable_amt,vehicle_no,nature_of_process,expected_receive_days,expected_receive_date,createdAt,createdBy,pid) VALUES ('$sr_no','$date','$name','$gst','$add','$name1','$gst1','$add1','$dog','$identify','$qnty','$unit','$val','$hsn_code','$taxable_goods','$vehicle_no','$nature_of_processing','$duration_days','$expected_receive_date','$createdAt','$user','$pid')";
                $run = sqlsrv_query($con,$query);
 if($run == true)
    {

                      $_SESSION['jw'] = $sr_no;
                      $_SESSION['message'] = 'Challan No:'.$sr_no.' Created Successfully';
                          header("location:adddata.php");


    }
          else{
                  print_r(sqlsrv_errors());
                  }




}
            ?>
