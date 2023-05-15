<?php
//filter.php
if(isset($_POST["rmta"]))
{
$output = '';
$output .= '
<table border="1" class="text-center ml-3" style="width:95%">
  <thead>
    <tr class="bg-secondary">
      <th>SrNo</th>
      <th>Item Name</th>
      <th>PKG</th>
      <th>Qnty</th>
      <th>Print</th>
    </tr>
  </thead>
  ';
  // COPPER PART
  include('..\..\dbcon.php');
  $sql1 = "SELECT id from inward_ind WHERE CONCAT(sr_no,receive_at) = '".$_POST["rmta"]."'";
  $run1 = sqlsrv_query($con,$sql1);
  $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
  if ($row1['id'] < 18992) { 
    $output .= '
  <tr class="text-center font-italic">
    <td colspan="5">यह पुराना RMTA है</td>
  </tr>
  ';
  }
  else{
  $sql = "SELECT a.id,b.item,b.m_code,a.p_pkg,a.rec_qnty,a.BC_printno FROM inward_ind a
  LEFT OUTER JOIN rm_item b on a.p_item = b.i_code WHERE CONCAT(sr_no,receive_at) = '".$_POST["rmta"]."'";
  $run = sqlsrv_query($con,$sql);
  $srno = 0;
  while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
  {
  $srno++;
  $output .= '
  <tr class="text-center font-italic">
    <td class="font-weight-bold">'.$srno.'</td>
    <td>'.$row['item'].'</td>
    <td>'.$row['p_pkg'].'</td>
    <td>'.$row['rec_qnty'].'</td>
    ';
    if ($row['m_code'] == 130 || $row['m_code'] == 135) {
      $output .= '
        <td><a href="cuAlu.php?id='.$row['id'].'" target="_blank" class="btn btn-success btn-sm view_data">SetBarcode</a></td>
      </tr>
       ';
    }
    else {
    if ($row['BC_printno'] >= $row['p_pkg']) {
    $output .= '
    <td><a href="barcode.php?id='.$row['id'].'" target="_blank" class="btn btn-secondary btn-sm view_data">printDone</a></td>
  </tr>
  ';
  }
  else{
  $output .= '
  <td><a href="barcode.php?id='.$row['id'].'" target="_blank" class="btn btn-success btn-sm view_data">SetBarcode</a></td>
</tr>
';
}
}
}
}
$output .= '</table>';
echo $output;
}
?>