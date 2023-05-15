<?php
//filter.php
if(isset($_POST["x"]))
{
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d', time());
include('..\..\..\dbcon.php');
$sql="SELECT id,p_item,p_unit,item,pur_rate,pur_rate*rec_qnty as value,order_qnty,rec_qnty,order_qnty-rec_qnty as balance FROM inward_ind a
LEFT OUTER JOIN rm_item b on a.p_item= b.i_code
where concat(sr_no,receive_at) = '".$_POST["x"]."'";
$run=sqlsrv_query($con,$sql);
$output = '';
$output .= '
<div class="container-fluid">
  <div class="table-responsive">
    <table align="center" width="100%" class="table table-bordered">
      <thead>
        <tr  style="background: #aafa9e;">
          <th class="history_head">Sr</th>
          <th class="history_head">Item</th>
          <th class="history_head">Rate</th>
          <th class="history_head">Unit</th>
          <th class="history_head">Diff.</th>
          <th class="history_head">Value</th>
          <th class="history_head">Diff_Total</th>
          <th class="history_head">PO_Qty</th>
          <th class="history_head">Rec_Qty</th>
          <th class="history_head">Balance</th>
        </tr>
      </thead>
      ';
      $count = 0;
      $grandtotaldiff = 0;
      while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
      {
        $i_code = $row['p_item'];
        $id = $row['id'];

      $sqldiff = "SELECT min(pur_rate) as min_value FROM inward_ind WHERE id in(SELECT top 5 id from inward_ind a 
                  LEFT OUTER JOIN inward_com b on a.sr_no = b.sr_no AND a.receive_at = b.receive_at
                  where p_item = '$i_code' AND id < '$id'  order by invoice_date desc)";
      $rundiff = sqlsrv_query($con,$sqldiff);
      $rowdiff = sqlsrv_fetch_array($rundiff, SQLSRV_FETCH_ASSOC);
      if ($rowdiff['min_value'] == NULL || $rowdiff['min_value'] == 0) {
        $diff = 0;
        $totaldiff = 0;
      }
      else{
      $diff = $row['pur_rate'] - $rowdiff['min_value'];
      $totaldiff = $diff*$row['rec_qnty'];
       }
      if ($diff > 0) {
       $col = "text-danger";
      }
      else{
        $col = "";
      }
      $grandtotaldiff += $totaldiff;
      $count++;
      $output .= '
      <tr  style="background:#f3ff99;" class="'.$col.'">
        <th class="history_head2">'.$count.'</th>
        <th class="history_head2">'.$row['item'].'</th>
        <th class="history_head2">'.$row['pur_rate'].'</th>
        <th class="history_head2">'.$row['p_unit'].'</th>
        <th class="history_head2">'.$diff.' </th>
        <th class="history_head2">'.$row['value'].'</th>
        <th class="history_head2">'.$totaldiff.' </th>
        <th class="history_head2">'.$row['order_qnty'].'</th>
        <th class="history_head2">'.$row['rec_qnty'].'</th>
        <th class="history_head2">'.$row['balance'].'</th>
      </tr>
      ';
      $sql1 = "SELECT top 5 b.invoice_date,a.rec_qnty,a.pur_rate,c.party_name,a.p_unit FROM inward_ind a
      LEFT OUTER JOIN inward_com b on a.sr_no = b.sr_no AND a.receive_at = b.receive_at
      LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party WHERE a.p_item = '$i_code' AND a.id < '$id' ORDER BY invoice_date desc";
      $run1 = sqlsrv_query($con,$sql1);
      while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
      {
        
      $output .= '
      <tr class="text-center font-italic">
        <td class="history_head3">'.$row1['invoice_date']->format('d-M-y').'</td>
        <td class="history_head3">'.$row1['party_name'].'</td>
        <td class="history_head3">'.$row1['pur_rate'].'</td>
        <td class="history_head3">'.$row1['p_unit'].'</td>
        <td class="history_head3"></td>
        <td class="history_head3"></td>
        <td class="history_head3"></td>
        <td class="history_head3"></td>
        <td class="history_head3">'.$row1['rec_qnty'].'</td>
        <td class="history_head3"></td>
      </tr>
      ';
      }
      }
      $output .= '
            <tr>
              <td colspan="10" class="text-primary h6 px-3 py-2">
                  Total Diff of Rmta <span class="text-dark">'.$_POST["x"].'</span> Is : '.$grandtotaldiff.' /-
              </td>
            </tr>
    </table>
     
  </div>
</div>
';

echo $output;
}
?>