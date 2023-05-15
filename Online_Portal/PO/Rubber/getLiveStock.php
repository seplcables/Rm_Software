<?php 
if (isset($_POST['id'])) {
$icode = $_POST['id'];
$output = '';
include('..\..\..\dbcon.php');
        $sql= "SELECT rmta,FORMAT(rce_date,'dd-MMM-y') as recDate,qnty,OI_type from rubber_inward where item = '$icode' and Status = 1 union all 
  SELECT rmta, FORMAT(issue_date,'dd-MMM-y') as recDate, weight , 'issue' as OI_type from rubber_issue a  where item = '$icode' and issue_date >= '2022-08-31'   order by OI_type desc";
        $run=sqlsrv_query($con,$sql);

$output .= '
<div class="table-responsive">
  <table class="table table-bordered table-striped table-sm text-center">
    <tr class="bg-dark text-white text-center font-italic">
      <th>Date</th>
      <th>Rmta</th>
      <th>Qnty</th>
      <th>Note</th>
      </tr>
    ';
    while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
    {
    $output .= '
        <tr class="font-italic">
            <td>'. $row['recDate'] .'</td>
            <td>'. $row['rmta'] .'</td>
            <td>'. $row['qnty'] .'</td>
            <td>'. $row['OI_type'] .'</td>
        </tr>    
    ';
    }
  $output .= "</table></div>";
  echo $output;
}
?>