<?php
	session_start();
            include('..\..\dbcon.php');
            if (isset($_POST['save'])) { 

           /*------------------- for po_entry_head-----------------*/
              $podate = $_POST['podate'];
              $pono = $_POST['pono'];
              $pogen = $_POST['pogen'];
              /*$dpmnt = $_POST['dpmnt'];*/
              $req_by  = $_POST['matReqBy'];
              $party = $_POST['pid'];
               $req_date = $_POST['req_date'];
                $p_days = $_POST['p_days'];
              $p_term = $_POST['p_term'];
              $adv_type = $_POST['advance'];
              $adv_amt = $_POST['advance_amt'];
              $pcode = $_POST['pcode'];
              $sid = $_POST['srno'];
              $user = $_SESSION['oid'];

              /*------------------- for po_entry_details-----------------*/
              $i_code = $_POST['i_code'];
              $s_code = $_POST['s_code'];
              $m_code = $_POST['m_code'];
              $c_code = $_POST['c_code'];
              $qnty = $_POST['qnty'];
              $unit = $_POST['unit'];
              $rate = $_POST['rate'];
              $basic_rate = $_POST['basic_rate'];
              $hsn_code = $_POST['hsn_code'];
              $project= str_replace("'", "`", $_POST['project']);
              $sub_project= str_replace("'", "`", $_POST['sub_project']);
              $job= str_replace("'", "`", $_POST['job']);
              $remark= str_replace("'", "`", $_POST['remark']);
              $use_by = $_POST['useby'];
              $mcno = $_POST['mcno'];
              $person = $_POST['person'];
              $dpnt = $_POST['dpnt'];
              $plant = $_POST['plant'];
              $type = $_POST['type'];
              $status = $_POST['status'];
              /*$req_id = $_POST['req_id'];
              $requisition_id = $_POST['requisition_id'];*/
              $iid = $_POST['iid'];

              /*------------------- for Terms-----------------*/ 
              $title= str_replace("'", "`", $_POST['title']);
              $desc= str_replace("'", "`", $_POST['desc']);

              /*------------------- for Delivery Address-----------------*/ 
              $loc = $_POST['loc'];
        	$addr = $_POST['addr'];
              
              $sql = "UPDATE po_entry_head SET po_date = '$podate',po_no='$pono',po_gen_by = '$pogen',party = '$party',mat_req_date='$req_date',p_days='$p_days',p_terms='$p_term',mat_req_by = '$req_by',adv_type = '$adv_type',adv_amt = '$adv_amt',username='$user' WHERE id = '$sid'";
                $run = sqlsrv_query($con,$sql);
             if($run == true)
                {
                    foreach ($i_code as $key => $value) {
                    $sql1 = "UPDATE po_entry_details SET item_code = '".$value."',main_grade = '".$m_code[$key]."',sub_grade = '".$s_code[$key]."',category = '".$c_code[$key]."',qnty = '".$qnty[$key]."',unit = '".$unit[$key]."',rate = '".$rate[$key]."',basic_rate = '".$basic_rate[$key]."',hsn_code ='".$hsn_code[$key]."',project = '".$project[$key]."', sub_project = '".$sub_project[$key]."',job = '".$job[$key]."',remark='".$remark[$key]."',matUsedBy ='".$use_by[$key]."',mcno = '".$mcno[$key]."',superviser = '".$person[$key]."',department = '".$dpnt[$key]."',plant='".$plant[$key]."',type='".$type[$key]."',old_status='".$status[$key]."',updated_by='$user' WHERE id = '".$iid[$key]."'";
                     $run1 = sqlsrv_query($con,$sql1);
                 }                                        
              if($run1 == true)
                {
                     $sql2 = "DELETE FROM po_terms where po_id = '$sid'";
			            $run2 = sqlsrv_query($con,$sql2);
			            if($run2 == true){
			                foreach ($title as $key => $value) {
			                    $sql3 = "INSERT INTO po_terms(po_id,title,descriptions) VALUES ('$sid','".$value."','".$desc[$key]."')";
			                    $run3 = sqlsrv_query($con,$sql3);
			                }
			                if($run3 == true)
			                {
			                   $sql4 = "DELETE FROM po_delivery where po_id = '$sid'";
					            $run4 = sqlsrv_query($con,$sql4);
					            if($run4 == true){
					                foreach ($loc as $key => $value) {
					                    $sql5 = "INSERT INTO po_delivery(po_id,location,location_address) VALUES ('$sid','".$value."','".$addr[$key]."')";
					                    $run5 = sqlsrv_query($con,$sql5);
					                }
					            if($run5 == true){
					                     $_SESSION['add_item_po'] = $sid;
					                    $_SESSION['message'] = 'Updated Successfully';
					                    header("location:po_entry_edit.php");
					                }
					            }
			                }
			            }

                 }

                 else{
                  echo "Details missing";
                   print_r(sqlsrv_errors());
                }
                  

}
else{
          echo "Head is missing";
          print_r(sqlsrv_errors());
        }

    }    

 ?>