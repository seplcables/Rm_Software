<?php
//filter.php
include('..\..\..\dbcon.php');
$output = '';
if(isset($_POST["from_date"]) && isset($_POST["to_date"]) && isset($_POST["pid"]))
{
$query = "
SELECT concat(sr_no,'-',receive_at) as sr,party,invoice_no,invoice_date,total_amt,Ac_Head,bill_amt,createdAt,
payment_amt,trans_id,remark
FROM payment_table
WHERE invoice_date BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' AND party = '".$_POST["pid"]."'
";
}
if(empty($_POST["from_date"]) && empty($_POST["to_date"]) && isset($_POST["pid"]))
{
$query = "
SELECT concat(sr_no,'-',receive_at) as sr,party,invoice_no,invoice_date,total_amt,Ac_Head,bill_amt,createdAt,
payment_amt,trans_id,remark
FROM payment_table
WHERE party = '".$_POST["pid"]."'
";
}
if(isset($_POST["from_date"]) && isset($_POST["to_date"]) && empty($_POST["pid"]))
{
$query = "
SELECT concat(sr_no,'-',receive_at) as sr,party,invoice_no,invoice_date,total_amt,Ac_Head,bill_amt,createdAt,
payment_amt,trans_id,remark
FROM payment_table
WHERE invoice_date BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'
";
}

$result = sqlsrv_query($con,$query);
$params = array();
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$run1=sqlsrv_query($con,$query,$params,$options);
$output .= '
<table class="table table-bordered table-striped table-sm">
  <tr class="head_part">
  <th>Sr_No</th>
  <th>party</th>
  <th>bill_no</th>
  <th>bill_date</th>
  <th>Total_pay_amt</th>
  <th>Bill_amt</th>
  <th>Pymt_Date</th>
  <th>Pymt_amt</th>
  <th>pndg_amt</th>
  <th>Trans_id</th>
  <th>remark</th>
  <th>A/c Head</th>

  </tr>
  ';
  if(sqlsrv_num_rows($run1) > 0)
  {
    $bal_amt = 0;
  while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
  {
            $sql2="SELECT party_name from rm_party_master where pid='".$row['party']."'";
            $run2=sqlsrv_query($con,$sql2);
            $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);

            $sql3="SELECT sum(payment_amt) as total_pay from payment_table where concat(sr_no,'-',receive_at)='".$row['sr']."'";
            $run3=sqlsrv_query($con,$sql3);
            $row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);

            $bal = $row["bill_amt"] - $row3["total_pay"];
            $bal_amt += $bal;
  $output .= '
  <tr>
    <td>'. $row["sr"] .'</td>
    <td>'. $row2["party_name"] .'</td>
    <td>'. $row["invoice_no"] .'</td>
    <td>'. $row["invoice_date"]->format('d.M.y') .'</td>
    <td>'. $row["total_amt"] .'</td>
    <td>'. $row["bill_amt"] .'</td>
    <td>'. $row["createdAt"]->format('d.M.y') .'</td>
    <td>'. $row["payment_amt"] .'</td>
    <td>'. $bal .'</td>
    <td>'. $row["trans_id"] .'</td>
    <td>'. $row["remark"] .'</td>
    <td>'. $row["Ac_Head"] .'</td>
  </tr>
  ';
  }
  $output .= '
      <tr>
            <td colspan="8" id="t_amt_head">Total Pending Amount =></td>
            <td colspan="4" id="t_amt_val">'. $bal_amt .'</td>
      </tr>
  ';
  }
  else
  {
  $output .= '
  <tr>
    <td colspan="12">No Records Found</td>
  </tr>
  ';
  }
$output .= '</table>';
echo $output;
?>
