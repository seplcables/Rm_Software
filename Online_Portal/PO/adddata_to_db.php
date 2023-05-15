<?php

    session_start();
            include('..\..\dbcon.php');
            if (isset($_POST['save'])) {
                $sql="SELECT MAX(id) as po_value FROM po_entry_head";
                $run=sqlsrv_query($con, $sql);
                $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
                $podigit = $row['po_value'] + 1;

                $podate = $_POST['podate'];
                $pono = $_POST['pono'].$podigit;
                $pogen = $_POST['pogen'];
                $dpmnt = $_POST['dpmnt'];
                $party = $_POST['pid'];
                $req_date = $_POST['req_date'];
                $p_days = $_POST['p_days'];
                $p_term = $_POST['p_term'];
                $req_by  = $_POST['matReqBy'];
                $adv_type = $_POST['advance'];
                $adv_amt = $_POST['advance_amt'];
                $user = $_SESSION['oid'];
                $po_value = $_POST['po_value'];

                $i_code = $_POST['i_code'];
                $s_code = $_POST['s_code'];
                $m_code = $_POST['m_code'];
                $c_code = $_POST['c_code'];
                $MakeBy = $_POST['MakeBy'];
                $ModelNo = $_POST['ModelNo'];
                $hsn_code = $_POST['hsn_code'];
                $project= str_replace("'", "`", $_POST['project']);
                $sub_project= str_replace("'", "`", $_POST['sub_project']);
                $job= str_replace("'", "`", $_POST['job']);
                $remark= str_replace("'", "`", $_POST['remark']);
                $qnty = $_POST['qnty'];
                $unit = $_POST['unit'];
                $rate = $_POST['rate'];
                $basic_rate = $_POST['basic_rate'];
                $use_by = $_POST['use_by'];
                $mcno = $_POST['mcno'];
                $person = $_POST['person'];
                $dpnt = $_POST['dpnt'];
                $plant = $_POST['plant'];
                $type = $_POST['type'];
                $old_part = $_POST['old_part'];
                $req_id = $_POST['req_id'];
                $requisition_id = $_POST['requisition_id'];
                // Terms
                $title= str_replace("'", "`", $_POST['title']);
                $desc= str_replace("'", "`", $_POST['desc']);
                // Delivery Address
                $loc= str_replace("'", "`", $_POST['loc']);
                $addr= str_replace("'", "`", $_POST['addr']);

                $query = "INSERT INTO po_entry_head(id,po_date,po_no,po_gen_by,party,mat_req_date,depart_ment,p_days,p_terms,username,isPurchaseEntry,mat_req_by,adv_type,adv_amt,po_value) VALUES ('$podigit','$podate','$pono','$pogen','$party','$req_date','$dpmnt','$p_days','$p_term','$user',0,'$req_by','$adv_type','$adv_amt','$po_value')";
                $run = sqlsrv_query($con, $query);
                if ($run == true) {
                    foreach ($i_code as $key => $value) {
                        $query1 = "INSERT INTO po_entry_details(item_code,make_by,model_no,hsn_code,project,sub_project,job,remark,stock,category,main_grade,sub_grade,qnty,unit,rate,basic_rate,iid,matUsedBy,mcno,superviser,department,plant,type,old_status,requisition_id,req_iid) VALUES ('".$value."','".$MakeBy[$key]."','".$ModelNo[$key]."','".$hsn_code[$key]."','".$project[$key]."','".$sub_project[$key]."','".$job[$key]."','".$remark[$key]."','".$stock[$key]."','".$c_code[$key]."','".$m_code[$key]."','".$s_code[$key]."','".$qnty[$key]."','".$unit[$key]."','".$rate[$key]."','".$basic_rate[$key]."','$podigit','".$use_by[$key]."','".$mcno[$key]."','".$person[$key]."','".$dpnt[$key]."','".$plant[$key]."','".$type[$key]."','".$old_part[$key]."','".$requisition_id[$key]."','".$req_id[$key]."')";
                        $run1 = sqlsrv_query($con, $query1);
                    }
                    if ($run1 == true) {
                        foreach ($title as $key1 => $value1) {
                            $query2 = "INSERT INTO po_terms(po_id,title,descriptions) VALUES ('$podigit','".$value1."','".$desc[$key1]."')";
                            $run2 = sqlsrv_query($con, $query2);
                        }
                        if ($run2 == true) {
                            foreach ($loc as $key2 => $value2) {
                                $query3 = "INSERT INTO po_delivery(po_id,location,location_address) VALUES ('$podigit','".$value2."','".$addr[$key2]."')";
                                $run3 = sqlsrv_query($con, $query3);
                            }
                            if ($run3 == true) {
                                $_SESSION['pono_entry'] = $podigit;
                                $_SESSION['message'] = 'Po No:'.$podigit.' Created Successfully';
                                header("location:adddata.php");
                            } else {
                                echo "Delivery Address Missing";
                                print_r(sqlsrv_errors());
                            }
                        } else {
                            echo "Terms & Condition Missing";
                            print_r(sqlsrv_errors());
                        }
                    } else {
                        echo "Details missing";
                        print_r(sqlsrv_errors());
                    }
                } else {
                    echo "Head is missing";
                    print_r(sqlsrv_errors());
                }
            }
