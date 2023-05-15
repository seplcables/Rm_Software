<?php
//filter.php
if (isset($_POST['x'])) {
 $val = $_POST['x'];
include('..\..\..\dbcon.php');
date_default_timezone_set('Asia/Kolkata');
if ($val == 'lweek') {
  $from_date = date("Y-m-d", strtotime("-15 day"));
  $to_date = date("Y-m-d", strtotime("-7 day"));
} else if ($val == 'cweek'){
  $from_date = date("Y-m-d", strtotime("-7 day"));
  $to_date = date("Y-m-d", strtotime("0 day"));
}
else{
    $from_date = date("Y-m-d", strtotime("0 day"));
    $to_date = date("Y-m-d", strtotime("7 day"));
}



$output = '';

$output .= '
    <table class="table" id="employee_data">
        <thead>
        <tr class="text-white text-center font-italic" id="trow" style="background-color: #54b4c7;">
          <th>Bill Date</th>
          <th>Bill No</th>
          <th>Rmta</th>
          <th>Party</th>
          <th>mat_ord_by</th>
          <th>Bill_Amt</th>
          <th>Bal_amt</th>
          <th>Due Date</th>
          <th>Aprv_By</th>
          <th>Paid Amt</th>
          <th>Ctrl</th>
          <th class="text-center">Control</th>
        </tr>
      </thead>
  ';
        if ($_POST["x"] == 'all') {
            $sql="SELECT * from inward_com where bill_receive = 1 AND bill_send = 1 AND invoice_date > '2021-12-01'";
          }
          else{
            $sql="SELECT * from inward_com where bill_receive = 1 AND bill_send = 1 AND invoice_date > '2021-12-01' AND payment_due BETWEEN '$from_date' AND '$to_date'";
          }
        $run=sqlsrv_query($con,$sql);
        $totalPendingAmt = 0;
        while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
        {

        $sql2="SELECT * from rm_party_master where pid='".$row['mat_from_party']."'";
        $run2=sqlsrv_query($con,$sql2);
        $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);

        $sql3="SELECT SUM(payment_amt) as payment_value FROM payment_table where sr_no='".$row['sr_no']."'  and receive_at='".$row['receive_at']."'";
        $run3=sqlsrv_query($con,$sql3);
        $row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);
        $bal_amt = floatval($row['total_bill_amt'])-floatval($row3['payment_value']);
          if ($bal_amt <= 10) {
               continue;
            }

$val = $row['total_bill_amt'] - $row3['payment_value'];
$totalPendingAmt += $val;
  $output .= '

  <tr class="text-center font-italic trow1">
          <td><input type="text" name="idate[]" value="'. $row['invoice_date']->format('d-M-Y').'" style="border: none;outline: none;box-shadow: none; text-align: center;"></td>
          <td><input type="text" name="ino[]" value="'. $row['invoice_no'].'" style="border: none;outline: none;box-shadow: none; text-align: center;"></td>
          <td><input type="text" value="'.$row['sr_no']."_(".$row['receive_at'].")".'" style="border: none;outline: none;box-shadow: none; text-align: center;"><input type="hidden" name="sr_no[]" value="'. $row['sr_no'].'"><input type="hidden" name="receive[]" value="'. $row['receive_at'].'"></td>
          <td><input type="text" value="'. $row2['party_name'].'" style="border: none;outline: none;box-shadow: none; text-align: center;"><input type="hidden" name="pname[]" value="'. $row['mat_from_party'].'"></td>
          <td><input type="text" name="matby[]" value="'. $row['mat_ord_by'].'" style="border: none;outline: none;box-shadow: none; text-align: center;"></td>
          <td><input type="text" name="total[]" value="'. $row['total_bill_amt'].'" style="border: none;outline: none;box-shadow: none; text-align: center;"></td>
          <td id="bill_amt_value"><input type="text" name="value[]" value="'.$val.'" style="border: none;outline: none;box-shadow: none; text-align: center;" class="bal_amt"></td>
          <td><input type="text" name="due[]" value="'. $row['payment_due']->format('d-M-Y').'" style="border: none;outline: none;box-shadow: none; text-align: center;"></td>
          <td><input type="text" name="aprv[]" value="'. $row['approve_by'].'" style="border: none;outline: none;box-shadow: none; text-align: center;"></td>
          <td><input type="number" step="0.01" name="paid_amt[]" class="paid_amt form-control w-75"></td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                control
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item"><input type="button" class="btn btn-warning show_data p-1" name="show" value="Track" id="'. $row['sr_no'].$row['receive_at'] .'" /></a></li>
                <li><a class="dropdown-item"><input type="button" class="btn btn-info show_history p-1" name="show" value="History" id="'. $row['sr_no'].$row['receive_at'] .'"/></a></li>
                <li><a class="dropdown-item"><input type="button" class="btn btn-primary show_inv p-1" name="show" value="Show" id="'. $row['invoice_img'].'" /></a></li>
              </ul>
            </div>
          </td>
          <td><input type="checkbox" class="largerCheckbox" id="check_box"/><input type="hidden" name="check[]" class="check"></td>
        </tr>
  ';
  }
 $output .= '</table>
<div class="btn btn-dark row float-end m-2">TOTAL PENDING AMOUNT : <b class="tamt text-warning"> </b>
<span class="tamtWord"> </span>
</div>
 ';
echo $output;
}
?> 
<script type="text/javascript">
    $(document).ready(function(){
      $('#employee_data').DataTable({
        "createdRow": function ( row, data, index ) {
                      if ( data[8] == 'pending' ) {
                          $('td', row).eq(8).addClass('hlight');
                      }
                  },
        "processing": true,
         "order": [[ 7, "asc" ]],
        dom: 'lBfrtip',
 buttons: [
  'excel','print'
 ],
 "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
      });

    });
$(".tamt").text(toIndianCurrency(<?php echo $totalPendingAmt; ?>));
$(".tamtWord").text(wordify(<?php echo (int)$totalPendingAmt; ?>));
</script>
  