<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>pvc_live_rep.</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  


    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <style type="text/css">
    #trow{
    background-color: #ffb3ff;
    text-align: center;
    }
    </style>
  </head>
  <body>
    <div class="table-responsive ml-1">
      <?php
$rmta = $_GET['id'];
{
$output = '';
include('..\..\..\dbcon.php');
        $sql="SELECT MAX(rm_opening_date) as last_date FROM store_opening_date";
        $run=sqlsrv_query($con, $sql);
        $rowa = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
        $dd = $rowa['last_date']->format('d-M-y');

$query = "SELECT receive_dte,qnty,come_from,store_name FROM inward_rm WHERE receive_dte >= '$dd' and rmta = '".$rmta."'";
$result = sqlsrv_query($con, $query);
$query1 = "SELECT issue_date,issue_qnty,mc_no,stage,store_name FROM pvc_issue WHERE issue_date > '$dd' and rmta = '".$rmta."'";
$result1 = sqlsrv_query($con, $query1);
$output .= '
<div class="table-responsive">
  <table class="table table-bordered table-striped table-sm  m-2">
    <tr class="bg-dark text-white text-center font-italic">
      <th>Date</th>
      <th>Store</th>
      <th>Qnty</th>
      <th>Note</th>
      </tr>
    ';
    $tqnty = 0;
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $tqnty += floatval($row['qnty']);
        $output .= '
        <tr class="font-italic">
            <td>'. $row['receive_dte']->format('d.M.y') .'</td>
            <td>'. $row['store_name'] .'</td>
            <td>'. $row['qnty'] .'</td>
            <td>'. $row['come_from'] .'</td>
        </tr>    
    ';
    }
     $output .= '
        <tr style="background:MediumSpringGreen;">
            <td colspan="3" align="right">Total Opening=></td>
            <td align="center">'. $tqnty .'</td>
        </tr>    
    ';

    $iqnty = 0;
    while ($row1 = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)) {
        $iqnty += floatval($row1['issue_qnty']);
        $output .= '
        <tr class="font-italic">
            <td>'. $row1['issue_date']->format('d.M.y') .'</td>
            <td>'. $row1['store_name'] .'</td>
            <td>'. $row1['issue_qnty'] .'</td>
            <td>'. $row1['stage'] ."(". $row1['mc_no']. ')</td>
        </tr>';
    }
     $output .= '
        <tr style="background:yellow;">
            <td colspan="3" align="right">Total Issue=></td>
            <td align="center">'. $iqnty .'</td>
        </tr>    
    ';
  $output .= "</table></div>";
  echo $output;
  }
  ?>
     </div>
     </body>
     </html>   

