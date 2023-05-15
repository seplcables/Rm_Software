<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Inward view</title>
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
$item = $_GET['id'];
{
$output = '';
include('..\..\..\dbcon.php');
        
$query = "SELECT receive_dte,qnty,unit,invoice_no,party FROM inward_store where item='$item' and come_from = 'inward' and receive_dte >='2021-03-31'";
$result = sqlsrv_query($con,$query);
$output .= '
<div class="table-responsive">
  <table class="table table-bordered table-striped table-sm  m-2">
    <tr class="bg-dark text-white text-center font-italic">
      <th>Date</th>
      <th>Qnty</th>
      <th>Unit</th>
      <th>Bill_No</th>
      <th>Rate</th>
	    <th>Party</th>
      </tr>
    ';
    $tqnty = 0;
    while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
    {
		$party = $row['party'];
		$sql="SELECT party_name FROM rm_party_master where pid='$party'";
    $run=sqlsrv_query($con,$sql);
		$rowa = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
    $tqnty += floatval($row['qnty']);

    $sql1 = "SELECT top 1 a.pur_rate FROM inward_ind a inner join inward_com b on b.sr_no = a.sr_no and b.receive_at = a.receive_at  where p_item = '$item' order by b.receive_date DESC";                                
    $run1 = sqlsrv_query($con,$sql1);
    $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);

    $output .= '
        <tr class="font-italic">
            <td>'. $row['receive_dte']->format('d.M.y') .'</td>
            <td>'. $row['qnty'] .'</td>
            <td>'. $row['unit'] .'</td>
            <td>'. $row['invoice_no'] .'</td>
            <td>'. $row1['pur_rate'] .'</td>
			      <td>'. $rowa['party_name'] .'</td>
        </tr>    
    ';
    }
    
    $output .= '
        <tr style="background:MediumSpringGreen;">
            <td colspan="5" align="right">Total Opening=></td>
            <td align="center">'. $tqnty .'</td>
        </tr>    
    ';
    
    $iqnty = 0;
    
  $output .= "</table></div>";
  echo $output;
  }
  ?>
     </div>
     </body>
     </html>   

