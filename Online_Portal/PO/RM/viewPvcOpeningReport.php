<?php
session_start();
include('..\..\..\dbcon.php');

if ($_SESSION['oid'] =='snehal' || $_SESSION['oid'] =='Rajnish' || $_SESSION['oid'] =='amey' || $_SESSION['oid'] =='harikishan' || $_SESSION['oid'] =='Nishant') {
    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>PVC Opening Report</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <style type="text/css" media="screen">
      input.largerCheckbox {
    transform : scale(2);
    }
    </style>
  </head>
  <body>
      <div class="font-weight-bold bg-primary p-1 text-white" align="center" style="font-size: 22px;">
         PVC Opening Report
      </div>
      <br/>
    <div class="row" style="padding-left:2%;">
        <div class="col-md-1">
            <a href="../../dashboard.php" class="btn btn-warning">HOME</a>            
            <a href="opening_table.php" class="btn btn-primary">Back</a>
        </div>
        <div class="col-md-3">
          <form id="srchdtfrm" action="viewPvcOpeningReport.php" method="get">
            Select Month : <input type="month" name="srchdtt" id="srchdtt" class="srchdt" required>&nbsp;&nbsp;&nbsp;
            <button type="submit" class="btn btn-info">Submit</button>
          </form>
        </div>
        <div class="col-md-2" align="center">
          <?php
          if (isset($_GET['srchdtt'])) {
              $srchdtt = $_GET['srchdtt'];
              $monthold = explode("-", $srchdtt);
              $month_name = date("F", mktime(0, 0, 0, $monthold[1], 10));
              echo '<span class="col-md-12 " style="font-size:20px; font-weight: bold;padding-top:5px;background-color: yellow;">'.$month_name."-".$monthold[0].'</span>';
          } ?>
        </div>
       
    </div>

    <br/>
    <div class="table-responsive" style="padding:1%;">
      <table class="table table-bordered table-striped table-sm" id="employee_data">
        <thead>
        <tr class="bg-dark text-white text-center font-italic">
              <th>Date</th>
              <th>store</th>
              <th>Item_name</th>
              <th>Qnty</th>
              <th>unit</th>
              <th>party</th>
              <th>rmta</th>
        </tr>
        </thead>
        <?php
        if (isset($_GET['srchdtt'])) {
            $srchdtt = $_GET['srchdtt'];
            $month = explode("-", $srchdtt);

            $sql="SELECT id, format(a.receive_dte,'d-M-y') as receive_dte, a.store_name, b.item, a.qnty, a.unit, c.party_name, a.rmta from inward_rm a right join rm_item b on a.item = b.i_code right join rm_party_master c on c.pid = a.party where a.come_from = 'opening' and format(a.receive_dte,'yyyy-MM') = '$srchdtt' order by a.receive_dte DESC";
            $run=sqlsrv_query($con, $sql); ?>
        <?php
        while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
            ?>
        <tr class="text-center font-italic" id="<?php echo $row['id']; ?>">
            <td><?php echo $row["receive_dte"]; ?></td>
            <td><?php echo $row["store_name"]; ?></td>
            <td><?php echo $row['item']; ?></td>
            <td><?php echo $row['qnty']; ?></td>
            <td><?php echo $row['unit']; ?></td>
            <td><?php echo $row['party_name']; ?></td>
            <td><?php echo $row['rmta']; ?></td>
        </tr>
        <?php
        }
        } ?>
      </table>

    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#employee_data').DataTable();

    });

    </script>
  </body>
</html>
<?php
} else {
            $_SESSION['utype'] = "You Are Not Authorized!!";
            header("location:..\..\dashboard.php");
        }
?>
