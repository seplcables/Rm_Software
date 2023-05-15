<?php
session_start();
$user = $_SESSION['oid'];
include('../../../dbcon.php');
$sql = "SELECT id,indentor,mat_require_dte,createdAt from Requisition_head where id = '".$_POST['id']."'";
$run = sqlsrv_query($con,$sql);
$row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

$output = '
<div class="container-fluid ">
    <form action="" method="POST">
        <div class="card " id="rate">
            <div class="card-header text-uppercase text-white bg-primary bg-gradient shadow-lg border-warning border-5" id="rate">
                <div class="row justify-content-center" style="font-family: Engravers MT;">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <font class="text-uppercase text-white bg-primary h6">Indentor: '.$row['indentor'].'</font>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12"></div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <font class="text-uppercase text-white bg-primary h6">MRS. No: '.$row['id'].'</font>
                    </div>
                </div>
                <div class="row justify-content-center mt-2"  style="font-family: Engravers MT;">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <font class="text-uppercase text-white bg-primary h6">Date: '.$row['createdAt']->format('d-M-Y').'</font>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12"></div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <font class="text-uppercase text-white bg-primary h6">Material Required Date: '.$row['mat_require_dte']->format('d-M-Y').'</font>
                    </div>
                </div>
            </div>
            ';
            $output .= '
            
            <div class="card-body">
                <div class="row justify-content-center">
                    
                    <div class="table-responsive ">

                        <table align="center" width="100%" class="table table-bordered table-sm" id="rate" cellspacing="0">
                            
                            <thead>
                                <tr class=" text-center" style="font-size: 14px; font-weight: bold; font-family: Arial Black;">
                                    <th class="bg-primary text-white">Sr No</th>
                                    <th class="bg-primary text-white">Item_Description</th>
                                    <th class="bg-primary text-white">Category</th>
                                    <th class="bg-primary text-white">Qnty</th>
                                    <th class="bg-primary text-white">Rate</th>
                                    <th class="bg-primary text-white">BasicVal</th>
                                    <th class="bg-primary text-white">Dpnt(mc)</th>
                                    <th class="bg-primary text-white">Type</th>
                                    <th class="bg-primary text-white">OldPartStatus</th>
                                    <th class="bg-primary text-white">Control</th>
                                    <th class="bg-primary text-white">LP_Date </th>
                                    <th class="bg-primary text-white">LP_Rate</th>
                                    <th class="bg-primary text-white">LP_Qnty</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                ';
                                    $sql1 = "SELECT b.item,d.category,a.qnty,a.department,a.mc,a.type,a.old_part_status,a.item_code,a.id from Requisition_details a
                                        LEFT OUTER JOIN rm_item b on a.item_code = b.i_code
                                        LEFT OUTER JOIN rm_category d on d.c_code = b.c_code
                                        where a.iid = '".$_POST['id']."' AND reject is NULL";
                                    $run1 = sqlsrv_query($con,$sql1);
                                    $count = 0;
                                    while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
                                    {    
                                        $count++;
                                        $sql2 = "SELECT invoice_date,pur_rate,rec_qnty from inward_ind a
                                                 LEFT OUTER JOIN inward_com b on a.sr_no = b.sr_no and a.receive_at = a.receive_at
                                                 where p_item = '".$row1['item_code']."' order by invoice_date desc";
                                        $run2=sqlsrv_query($con,$sql2);
                                        $row2=sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
                                        if ($row2['invoice_date'] == '') {
                                            $inv_dte = '';
                                        }
                                        else{
                                            $inv_dte = $row2['invoice_date']->format('d-M-Y');
                                        }
                                $sql3 = "SELECT b.party_name,a.rate,a.id FROM requisition_rate a 
                                         LEFT OUTER JOIN rm_party_master b on b.pid = a.party_id
                                         where a.iid = '".$row1['id']."' order by a.rate asc";
                                $lowPriceRun = sqlsrv_query($con,$sql3);
                                $lowPrice = sqlsrv_fetch_array($lowPriceRun, SQLSRV_FETCH_ASSOC);
                                        
$output .= '
                                
                                <tr class="text-center" style="font-size: 15px; font-family: Segoe UI Semibold;">
                                <td>'.$count.'</td>
                                <td>'.$row1['item'].'</td>
                                <td>'.$row1['category'].'</td>
                                <td>'.$row1['qnty'].'</td>
                                <td></td>
                                <td></td>
                                <td>'.$row1['department'].'('.$row1['mc'].')'.'</td>
                                <td>'.$row1['type'].'</td>
                                <td>'.$row1['old_part_status'].'</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm mt-1 rateHistory" id="'.$row1['item_code'].'">ItemHistory</button>
                                    <button type="button" class="btn btn-warning btn-sm mt-1 raReject" id="'.$row1['id'].'">Reject</button>
                                    <input type="hidden" name="itemId[]" class="itemId" value="'.$row1['id'].'">
                                    <input type="hidden" name="rateId[]" value="'.$lowPrice['id'].'" class="rateId'.$row1['id'].'">
                                    <input type="hidden" name="rateList[]" value="L1" class="rateList'.$row1['id'].'">
                                </td>
                                <td>'.$inv_dte.'</td>
                                <td>'.$row2['pur_rate'].'</td>
                                <td>'.$row2['rec_qnty'].'</td>
                                
                            </tr>


';
                                $run3 = sqlsrv_query($con,$sql3);
                                $x = 0;
                                while($row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC))
                                 {  
                                 $x++;
                                 $rbtn = ($x == 1) ? "checked" : "";
                                 
$output .= '
                                <tr class=" font-weight-bold text-center font'.$x.'" style="font-size: 14px; ">
                                <td></td>
                                <td colspan="2" class="">'.$row3['party_name'].'</td>
                                <td></td>
                                <td class="">'.$row3['rate'].'</td>
                                <td class=" text-center">'.$row3['rate']*$row1['qnty'].'</td>
                                <td class="text-center lll" style="font-family: times, serif;">L'.$x.'</td>
                                <td class=" text-center"><input type="radio" name="lowRateParty'.$count.'[]" class="clickRadio" value="'.$row3['id'].'" style="width: 30px; height: 20PX;" '.$rbtn.'>
                                <input type="hidden" class="radioId" value="'.$row1['id'].'">
                                </td>
                                <td colspan="5"></td>
                                </tr>
        ';  
                                }
                                                       

                            }

                                $output .= '
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
            ';
            $output .= '
        </div>
    </form>
</div>
';
echo $output;
?>