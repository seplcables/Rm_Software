<?php
//filter.php
if(isset($_POST["x"]))  
 {
    date_default_timezone_set('Asia/Kolkata');
    $current_date = date('Y-m-d', time());
    include('..\..\..\dbcon.php');
        $sql="SELECT c.po_date,c.mat_req_date,a.receive_date,a.send_time,a.receive_time,a.approve_time,a.payment_due,a.approve_by,a.sr_no,a.receive_at,a.invoice_no,e.createdAt,d.party_name,a.total_bill_amt,a.invoice_date,a.mat_ord_by,a.send_by,a.receive_by,e.username FROM inward_com a
        LEFT OUTER JOIN inward_ind e on e.sr_no = a.sr_no and e.receive_at = a.receive_at
               LEFT OUTER JOIN po_entry_details b on e.iid= b.id
               LEFT OUTER JOIN po_entry_head c on c.id= b.iid
               LEFT OUTER JOIN rm_party_master d on d.pid= c.party
               where concat(a.sr_no,a.receive_at) = '".$_POST["x"]."'";
         $run=sqlsrv_query($con,$sql);
         $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

         $diff1 = date_diff(date_create($row['receive_date']->format('Y-m-d')), date_create($row['mat_req_date']->format('Y-m-d')))->format('%a').' '.'Days';
         if ($row['mat_req_date']->format('Y-m-d') > $row['receive_date']->format('Y-m-d')) {
          $diff1 = '-'.date_diff(date_create($row['receive_date']->format('Y-m-d')), date_create($row['mat_req_date']->format('Y-m-d')))->format('%a').' '.'Days';
        }
         $diff2 = date_diff(date_create($row['receive_date']->format('Y-m-d')), date_create($row['invoice_date']->format('Y-m-d')))->format('%a').' '.'Days';
         $diff3 = date_diff(date_create($row['receive_date']->format('Y-m-d')), date_create($row['createdAt']->format('Y-m-d')))->format('%a').' '.'Days';
         $diff4 = date_diff(date_create($row['receive_date']->format('Y-m-d')), date_create($row['send_time']->format('Y-m-d')))->format('%a').' '.'Days';
         $diff5 = date_diff(date_create($row['receive_time']->format('Y-m-d')), date_create($row['send_time']->format('Y-m-d')))->format('%a').' '.'Days';
         
          if ($row['approve_time']->format('Y-m-d') > $row['payment_due']->format('Y-m-d')) {
            $diff6 = '-'.date_diff(date_create($row['approve_time']->format('Y-m-d')), date_create($row['payment_due']->format('Y-m-d')))->format('%a').' '.'Days';
          }
          else{
              $diff6 = 'No Delay';
          }
         if ($row['approve_by'] == 'pending') {
           $apprv_dte = 'pending';
           $diff = 'null';
           $diff6 = date_diff(date_create(date('Y-m-d', time())), date_create($row['payment_due']->format('Y-m-d')))->format('%a').' '.'Days';
           $diff7 = 'null';
         }
         else{
         $apprv_dte = $row['approve_time']->format('d-M-Y h:i a');
         $diff = date_diff(date_create($row['approve_time']->format('Y-m-d')), date_create($row['createdAt']->format('Y-m-d')))->format('%a').' '.'Days';
         $diff7 = date_diff(date_create(date('Y-m-d', time())), date_create($row['approve_time']->format('Y-m-d')))->format('%a');
         
        }
$output = '';

$output .= '
      <div class="card">
        <div class="card-header">
          <div class="row justify-content-center">

            <div class="col-lg-8 col-md-12 col-sm-12">
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width:115px">Party Name</span>
                <input type="text" class="form-control" name="party_name" value="'.$row['party_name'].'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
              </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12">
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width:115px">RMTA No.</span>
                <input type="text" class="form-control" value="'.$row['sr_no'].'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
              </div>
            </div>
          </div>

          <div class="row justify-content-center mt-3">
            <div class="col-lg-6 col-md-12 col-sm-12">
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Invoice Number</span>
                <input type="text" class="form-control" value="'.$row['invoice_no'].'"  aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
              </div>
            </div>
            
            <div class="col-lg-6 col-md-12 col-sm-12">
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" style="width:115px">Invoice Value</span>
                <input type="text" class="form-control" value="'.$row['total_bill_amt'].'" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
              </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row justify-content-center" style="">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="table-responsive-sm">
                <table align="center" width="500px" class="table table-striped table-sm" >
                  <tr>
                    <td><div class="form-label">PO Date :</div> <div class="form-input text-primary">'.$row['po_date']->format('d-M-Y').'</div></td>
                    <td></td>
                    <td><div class="form-label">By :</div> <div class="form-input">'.$row['mat_ord_by'].'</div></td>
                  </tr>
                  <tr>
                    <td ><div class="form-label">Material Req.Date As per PO :</div> <div class="form-input text-primary">'.$row['mat_req_date']->format('d-M-Y').'</div></td>
                    <td></td>
                    <td><div class="form-label">By :</div> <div class="form-input">'.$row['mat_ord_by'].' </div></td>
                  </tr>
                  <tr>
                    <td><div class="form-label">Received Date :</div> <div class="form-input text-primary">'.$row['receive_date']->format('d-M-Y').'</div></td>
                    <td><div class="form-label text-danger">Diff:</div> <div class="form-input mr-2 text-danger"> '.$diff1.'</div></td>
                    <td><div class="form-label">By :</div> <div class="form-input"> '.$row['username'].'  </div></td>
                  </tr>
                  <tr>
                    <td><div class="form-label">Invoice Date:</div> <div class="form-input text-primary">'.$row['invoice_date']->format('d-M-Y').'</div></td>
                    <td><div class="form-label text-danger">Diff:</div> <div class="form-input mr-2 text-danger"> '.$diff2.'</div></td>
                    <td><div class="form-label">By :</div> <div class="form-input mr-2">Party</div></td>
                  </tr>
                  <tr>
                    <td><div class="form-label">Purchase Entry Date :</div> <div class="form-input text-primary">'.$row['createdAt']->format('d-M-Y h:i a').'</div></td>
                    <td><div class="form-label text-danger">Diff:</div> <div class="form-input text-danger">'.$diff3.'</div></td>
                    <td><div class="form-label">By:</div> <div class="form-input "> '.$row['username'].'</div></td>
                  </tr>
                  <tr>
                    <td><div class="form-label">Bill Out Date :</div> <div class="form-input text-primary">'.$row['send_time']->format('d-M-Y h:i a').'</div></td>
                    <td><div class="form-label text-danger">Diff :</div> <div class="form-input text-danger">'.$diff4.'</div></td>
                    <td><div class="form-label">By:</div> <div class="form-input">'.$row['send_by'].'</div></td>
                  </tr>
                  <tr>
                    <td><div class="form-label">Bill In Date :</div> <div class="form-input text-primary"> '.$row['receive_time']->format('d-M-Y h:i a').'</div></td>
                    <td><div class="form-label text-danger">Diff:</div> <div class="form-input text-danger">'.$diff5.'</div></td>
                    <td><div class="form-label">By:</div> <div class="form-input"> Rashmik  </div></td>
                  </tr>
                  <tr>
                    <td><div class="form-label">Approve Date :</div> <div class="form-input text-primary"> '.$apprv_dte.'</div></td>
                    <td><div class="form-label text-danger">Diff:</div> <div class="form-input text-danger"> '.$diff.'</div></td>
                    <td><div class="form-label">By :</div> <div class="form-input">  '.$row['approve_by'].'</div></td>
                  </tr>
                  <tr>
                    <td><div class="form-label">Payment Due Date :</div> <div class="form-input text-primary"> '.$row['payment_due']->format('d-M-Y h:i a').'</div></td>
                    <td> <div class="form-label text-danger">Payment/Approval delay:</div> <div class="form-input text-danger">'.$diff7.'/'.$diff6.'</div></td>
                    <td></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    
  
';
echo $output;
}
?>