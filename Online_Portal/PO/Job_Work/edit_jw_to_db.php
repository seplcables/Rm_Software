<?php
	  session_start();
    $user = $_SESSION['oid'];
    date_default_timezone_set('Asia/Kolkata');
    $createdAt = date('m/d/Y h:i:s a', time());
    include('..\..\..\dbcon.php');
    if (isset($_POST['save'])) 
    {
        $id = $_POST['sr_no'];
        
        $date = $_POST['date'];
        $name1 = $_POST['name1'];
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
        $pid = $_POST['pid'];

        $query = "UPDATE jw_challan set challan_date = '$date', consignee_name = '$name1', consignee_gst = '$gst1', consignee_add = '$add1', goods_desc = '$dog', marks = '$identify', qnty = '$qnty', unit = '$unit', basic_val = '$val', hsn_code = '$hsn_code', taxable_amt = '$taxable_goods', vehicle_no = '$vehicle_no', nature_of_process = '$nature_of_processing', expected_receive_days = '$duration_days', expected_receive_date = '$expected_receive_date', createdAt = '$createdAt', createdBy = '$user', pid = '$pid' where id = '$id'";
        echo $query."<br/>";

        $run = sqlsrv_query($con,$query);
        if($run == true)
        {
          $_SESSION['jw'] = $sr_no;
          $_SESSION['message'] = 'Challan No:'.$sr_no.' Updated Successfully';
          header("location:edit_jw.php?sid=".$id);
        }
        else
        {
          print_r(sqlsrv_errors());
        }
    }
?>
