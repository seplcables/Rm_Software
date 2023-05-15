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
        
$query = "SELECT issue_date,qnty,unit,dpnt FROM rm_issue where item_name='$item' and issue_from = 'store' and issue_date >='2021-03-31'";
$result = sqlsrv_query($con,$query);
$output .= '
<div class="table-responsive">
  <table class="table table-bordered table-striped table-sm  m-2">
    <tr class="bg-dark text-white text-center font-italic">
      <th>Date</th>
      <th>Qnty</th>
      <th>Unit</th>
      <th>Dpnt</th>
      </tr>
    ';
    $tqnty = 0;
    while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
    {
      $tqnty += floatval($row['qnty']);
    $output .= '
        <tr class="font-italic">
            <td>'. $row['issue_date']->format('d.M.y') .'</td>
            <td>'. $row['qnty'] .'</td>
            <td>'. $row['unit'] .'</td>
            <td>'. $row['dpnt'] .'</td>
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
    
  $output .= "</table></div>";
  echo $output;
  }
  ?>
     </div>
     </body>
     </html>   

