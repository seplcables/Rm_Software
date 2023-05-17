<?php

session_start();
include('..\..\dbcon.php');
if (isset($_POST['save'])) {
    date_default_timezone_set('Asia/Kolkata');
    $pdftime = date('dmYHi', time());
    $rmta = $_GET['rmta'];
    /*---inward com---*/
    $received_at = $_POST['received_at'];
    $srno = $_POST['srno'];
    $receive_date = $_POST['receive_date'];
    $p_days = $_POST['p_days'];
    $due_days = $_POST['due_days'];
    $challan_no = $_POST['challan_no'];
    $invoice_date = $_POST['invoice_date'];
    $invoice_no = $_POST['invoice_no'];
    $party = $_POST['party'];
    $pid = $_POST['pid'];
    $po_gen_by = $_POST['po_gen_by'];
    $department = $_POST['department'];
    $weight = $_POST['weight'];
    $total_qnty = $_POST['total_qnty'];
    $diff_qnty = $weight - $total_qnty;
    $sub_total = $_POST['sub_total'];
    $gst_total = $_POST['gst_total'];
    $freight_paid_by = $_POST['freight_paid_by'];


    /*---inward ind---*/
    $item_desc = $_POST['item_desc'];
    $i_code = $_POST['i_code'];
    $iid = $_POST['iid'];
    $pkg = $_POST['pkg'];
    $qnty = $_POST['qnty'];
    $order_qnty = $_POST['order_qnty'];
    $unit = $_POST['unit'];
    $rate = $_POST['rate'];
    $order_rate = $_POST['order_rate'];
    $basic = $_POST['basic'];
    $plant = $_POST['plant'];
    $gst = $_POST['gst'];
    $gst_amt = $_POST['gst_amt'];
    $tcs_amt = $_POST['tcs_amt'];
    $project = $_POST['project'];
    $sub_project = $_POST['sub_project'];
    $job = $_POST['job'];
    $remark1 = $_POST['remark1'];
    $total_amt = $_POST['total_amt'];

    /*---inward changes---*/
    $field = $_POST['field'];
    $amount = $_POST['amount'];
    $gst2 = $_POST['gst2'];
    $t_value = $_POST['t_value'];
    $charge_id = $_POST['charge_id'];


    $tc_uploaded = $_POST['flexRadioDefault'];
    $tcidp = $_POST['tcidp'];
    $catg_nm_tc = $_POST['catg_nm_tc'];
    $username = $_SESSION['oid'];


    $img_sr= $srno.$received_at.$pdftime;
    $file_upload = $_POST['file_upload'];
    $img = $_FILES['profileupload']['name'];//name is keyboard
      $imgExt = substr($img, strripos($img, '.')); // get file extention

      date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d h:i:s', time());

    if ($imgExt == '') {
        $Invoice_img_timestamp = '';
        $imgname = $file_upload;
    } else {
        $Invoice_img_timestamp = $date;
        $imgname = $img_sr . $imgExt;
        move_uploaded_file($_FILES["profileupload"]["tmp_name"], "invoice_img/" . $imgname);
    }


    $sql = "UPDATE inward_com SET sr_no = '$srno',receive_at = '$received_at',receive_date = CONVERT(date, '$receive_date', 105),p_days = '$p_days',challan_no = '$challan_no',invoice_date = CONVERT(date, '$invoice_date', 105),invoice_no = '$invoice_no',gross_wt = '$weight',mat_from_party = '$pid',mat_ord_by = '$po_gen_by',depnt = '$department',total_qnty = '$total_qnty',diff_qnty = '$diff_qnty',freight_paid_by = '$freight_paid_by',total_tax = '$gst_total',total_bill_amt = '$sub_total',payment_due = '$due_days',invoice_img = '$imgname', Invoice_img_timestamp = '$Invoice_img_timestamp' where concat(sr_no,receive_at) = '$rmta'";
    $run = sqlsrv_query($con, $sql);

    if ($run) {
        foreach ($i_code as $key => $value) {
            $sql1 = "UPDATE inward_ind SET sr_no = '$srno',receive_at = '$received_at',p_item = '".$value."',p_project = '".$project[$key]."',p_job = '".$job[$key]."',p_remark = '".$remark1[$key]."',p_pkg = '".$pkg[$key]."',p_unit = '".$unit[$key]."',plant = '".$plant[$key]."',order_qnty = '".$order_qnty[$key]."',order_rate = '".$order_rate[$key]."',rec_qnty = '".$qnty[$key]."',pur_rate = '".$rate[$key]."',taxable_amt = '".$basic[$key]."',gst_per = '".$gst[$key]."',gst_amt = '".$gst_amt[$key]."',tcs_amt = '".$tcs_amt[$key]."',total_amt = '".$total_amt[$key]."' where id = '".$iid[$key]."'";
            $run1 = sqlsrv_query($con, $sql1);
        }
        if ($run1) {
            foreach ($field as $key => $value) {
                if ($charge_id[$key] == 'new') {
                    $sql2 = "INSERT into inward_charges(field,amount,gst,taxable_amt,sr_no,receive_at) VALUES('".$value."','".$amount[$key]."','".$gst2[$key]."','".$t_value[$key]."','$srno','$received_at')";
                } else {
                    $sql2 = "UPDATE inward_charges SET sr_no = '$srno',receive_at = '$received_at',field = '".$value."',amount = '".$amount[$key]."',gst = '".$gst2[$key]."',taxable_amt = '".$t_value[$key]."' WHERE id = '".$charge_id[$key]."'";
                }
                $run2 = sqlsrv_query($con, $sql2);
            }
            if ($run2) {
                if ($catg_nm_tc == 30) {
                    if ($tc_uploaded == "YES") {
                        $query = "UPDATE rm_tcreceipt_pdf set Name = '".$imgname."', uploadurl = 'invoice', username='".$username."', UpdateTimeStamp = '".$date."' where TCReceiptIDP = '".$tcidp."'";

                        $run = sqlsrv_query($con, $query);
                    } elseif ($tc_uploaded == "NO") {
                        $tcremarks = $_POST['tcremarks'];
                        $query = "UPDATE rm_tcreceipt_pdf set Remarks = '".$tcremarks."',  uploadurl = 'invoice', username='".$username."', UpdateTimeStamp = '".$date."' where TCReceiptIDP = '".$tcidp."'";
                        $run = sqlsrv_query($con, $query);
                    }
                }
                // else if($tc_uploaded == "NO")
                    // {
                    // 	$tcremarks = $_POST['tcremarks'];
                    // 	$query = "UPDATE rm_tcreceipt_pdf set Remarks = '".$tcremarks."',  uploadurl = 'invoice', UpdateTimeStamp = '".$date."' where TCReceiptIDP = '".$tcidp."'";
                    // 	$run = sqlsrv_query($con,$query);
                    // }

                    ?>
					<script type="text/javascript">
						alert('Data Entered Successfully');
						window.open('showinvoice.php','_self');
					</script>
				<?php
            } else {
                echo "something went wrong in inward_charges";
                print_r(sqlsrv_errors());
            }
        } else {
            echo "something went wrong in inward_ind";
            print_r(sqlsrv_errors());
        }
    } else {
        echo "something went wrong in inward_com";
        print_r(sqlsrv_errors());
    }
}

?>