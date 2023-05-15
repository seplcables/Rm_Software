<?php
session_start();

include('..\..\dbcon.php');
if (isset($_POST['saveAsExit']) || isset($_POST['saveAsNew'])) {

    /*---inward com---*/
    $search_po = $_POST['search_po'];
    $poid = $_POST['poid'];
    $received_at = $_POST['received_at'];
    $srno = $_POST['srno'];
    $receive_date = $_POST['receive_date'];
    $p_days = $_POST['p_days'];
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
    $due_days = $_POST['due_days'];

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
    $job = $_POST['job'];
    $remark1 = $_POST['remark1'];
    $total_amt = $_POST['total_amt'];

    /*---inward changes---*/
    $field = $_POST['field'];
    $amount = $_POST['amount'];
    $gst2 = $_POST['gst2'];
    $t_value = $_POST['t_value'];

    // /*--------tc-------*/
    // $tc_uploaded = $_POST['flexRadioDefault'];

    /*--------tc-------*/
    $tc_uploaded = $_POST['flexRadioDefault'];
    $cat_nm = $_POST['cat_nm'];
    $username = $_SESSION['oid'];


    $img_sr= $srno.$received_at;
    $img = $_FILES['profileupload']['name'];//name is keyboard
      $imgExt = substr($img, strripos($img, '.')); // get file extention

      date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d h:i:s', time());

    //$img_sr_tc = "TC_".$srno."_".$received_at;

    if ($imgExt == '') {
        $imgname = 0;
        $Invoice_img_timestamp = '';
    } else {
        $Invoice_img_timestamp = $date;
        $imgname = $img_sr . $imgExt;
        move_uploaded_file($_FILES["profileupload"]["tmp_name"], "invoice_img/" . $imgname);
    }



    if ($received_at == 'baroda' || $received_at == 'D_baroda') {
        $bill_send = 1;
        $bill_receive = 1;
    } else {
        $bill_send = 0;
        $bill_receive = 0;
    }

    $sql = "INSERT into inward_com(sr_no,receive_at,receive_date,p_days,challan_no,invoice_date,invoice_no,gross_wt,mat_from_party,mat_ord_by,depnt,total_qnty,diff_qnty,freight_paid_by,total_tax,total_bill_amt,payment_due,invoice_img,bill_send,bill_receive,Invoice_img_timestamp)  VALUES('$srno','$received_at',CONVERT(date, '$receive_date', 105),'$p_days','$challan_no',CONVERT(date, '$invoice_date', 105),'$invoice_no','$weight','$pid','$po_gen_by','$department','$total_qnty','$diff_qnty','$freight_paid_by','$gst_total','$sub_total','$due_days','$imgname','$bill_send','$bill_receive','$Invoice_img_timestamp')";
    $run = sqlsrv_query($con, $sql);
    if ($run) {
        foreach ($i_code as $key => $value) {
            if ($qnty[$key] <= 0) {
                continue;
            }
            $sql1 = "INSERT into inward_ind(p_item,p_project,p_job,p_remark,p_pkg,p_unit,plant,order_qnty,order_rate,rec_qnty,pur_rate,taxable_amt,gst_per,gst_amt,tcs_amt,total_tax_amt,total_amt,sr_no,receive_at,iid,p_po_no) VALUES('".$value."','".$project[$key]."','".$job[$key]."','".$remark1[$key]."','".$pkg[$key]."','".$unit[$key]."','".$plant[$key]."','".$order_qnty[$key]."','".$order_rate[$key]."','".$qnty[$key]."','".$rate[$key]."','".$basic[$key]."','".$gst[$key]."','".$gst_amt[$key]."','".$tcs_amt[$key]."','','".$total_amt[$key]."','$srno','$received_at','".$iid[$key]."','$search_po')";
            $run1 = sqlsrv_query($con, $sql1);
        }

        if ($run1) {
            foreach ($field as $key => $value) {
                $sql2 = "INSERT into inward_charges(field,amount,gst,taxable_amt,sr_no,receive_at) VALUES('".$value."','".$amount[$key]."','".$gst2[$key]."','".$t_value[$key]."','$srno','$received_at')";
                $run2 = sqlsrv_query($con, $sql2);
            }
            if ($run2) {
                if ($cat_nm == 30) {
                    if ($tc_uploaded == "YES") {
                        $query = "INSERT INTO rm_tcreceipt_pdf(Name, SrNo, receive_at, uploadurl,username,  Status,TimeStamp) VALUES ('".$imgname."','".$srno."','".$received_at."','invoice','".$username."', '1','$date')";
                        $run3 = sqlsrv_query($con, $query);
                    } elseif ($tc_uploaded == "NO") {
                        $tcremarks = $_POST['tcremarks'];
                        $query = "INSERT INTO rm_tcreceipt_pdf(Remarks, SrNo, receive_at, uploadurl,username, Status,TimeStamp) VALUES ('".$tcremarks."','".$srno."','".$received_at."','invoice','".$username."', '1','$date')";
                        $run3 = sqlsrv_query($con, $query);
                    }
                }

                // if ($tc_uploaded == "YES") {
                //     $query = "INSERT INTO rm_tcreceipt_pdf(Name, SrNo, receive_at, uploadurl,  Status,TimeStamp) VALUES ('".$imgname."','".$srno."','".$received_at."','invoice', '1','$date')";
                //     $run3 = sqlsrv_query($con, $query);
                // } elseif ($tc_uploaded == "NO") {
                //     $tcremarks = $_POST['tcremarks'];
                //     $query = "INSERT INTO rm_tcreceipt_pdf(Remarks, SrNo, receive_at, uploadurl, Status,TimeStamp) VALUES ('".$tcremarks."','".$srno."','".$received_at."','invoice', '1','$date')";
                //     $run3 = sqlsrv_query($con, $query);
                // }

                $_SESSION['plant'] = $received_at;
                if ($_POST['saveAsExit'] == 'saveAsExit') {
                    ?>
				<script type="text/javascript">
					alert('Data Entered Successfully');
					window.open('showinvoice.php','_self');
				</script>
				<?php
                } else {
                    ?>
				<script type="text/javascript">
					alert('Data Entered Successfully');
					window.open('inward_field.php','_self');
				</script>
				<?php
                }
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