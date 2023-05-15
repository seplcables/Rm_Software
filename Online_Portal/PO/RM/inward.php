<?php
session_start();
if ($_SESSION['oid'] =='snehal' || $_SESSION['oid'] =='Rajnish' || $_SESSION['oid'] =='amey' || $_SESSION['oid'] =='jitendra' || $_SESSION['oid'] =='harikishan' || $_SESSION['oid'] =='Nishant') {
    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Bill_Send</title>
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
    <div class="row ml-2">
          <a href="../../dashboard.php" class="btn btn-warning">Back</a>
    </div>
    <br />
    <?php if (isset($_SESSION['mess'])): ?>
    <div class="alert alert-primary font-weight-bold font-italic">
      <?php echo $_SESSION['mess']; ?>
    </div>
    <?php unset($_SESSION['mess']); ?>
    <?php endif; ?>
    <div class="table-responsive ml-1">
      <table class="table table-bordered table-striped table-sm" id="employee_data">
        <thead>
        <tr class="bg-dark text-white text-center font-italic">

                                    <th>Date</th>
                                    <th>store</th>
                                    <th>Item_name</th>
                                    <th>Qnty</th>
                                    <th>unit</th>
                                    <th>party</th>
                                    <th>order_by</th>
                                    <th>Invoice</th>
                                    <th>po_no</th>
                                    <th>sub_grade</th>
                                    <th>main_grae</th>
        </tr>
        </thead>
        <?php
        include('..\..\..\dbcon.php');
    $sqlaa="SELECT max(rm_opening_date) as ope_date from store_opening_date";
    $runaa=sqlsrv_query($con, $sqlaa);
    $rowaa=sqlsrv_fetch_array($runaa, SQLSRV_FETCH_ASSOC);
    $ope_date = $rowaa['ope_date']->format('Y-m-d');
    $sql="SELECT a.rec_qnty,b.receive_date,a.id,d.item,a.p_unit,c.party_name,b.mat_ord_by,b.invoice_no,a.p_po_no,e.sub_grade,f.main_grade,g.category    FROM inward_ind a
                LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
                LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
                LEFT OUTER JOIN rm_item d on d.i_code= a.p_item
                LEFT OUTER JOIN rm_s_grade e on e.s_code= d.s_code
                LEFT OUTER JOIN rm_m_grade f on f.m_code= d.m_code
                LEFT OUTER JOIN rm_category g on g.c_code= d.c_code
                where d.c_code = 30 and b.receive_at = 'halol' and b.receive_date >= '$ope_date' and a.id NOT in(select inward_ind_id from inward_rm)";

    $run=sqlsrv_query($con, $sql);
    $params = array();
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $runa=sqlsrv_query($con, $sql, $params, $options);
    $rowa=sqlsrv_num_rows($runa);
    if ($rowa > 0) {
        ?>
        <?php
        while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
            ?>
        <tr class="text-center font-italic" id="<?php echo $row['id']; ?>">

          <td><?php echo $row["receive_date"]->format("d-M-y"); ?></td>
          <td><a href="inward_set.php?id=<?php echo $row['id']; ?>" class="btn btn-info">click</a></td>
          <td><?php echo $row['item']; ?></td>
          <td><?php echo $row['rec_qnty']; ?></td>
          <td><?php echo $row['p_unit']; ?></td>
          <td><?php echo $row['party_name']; ?></td>
          <td><?php echo $row['mat_ord_by']; ?></td>
          <td><?php echo $row['invoice_no']; ?></td>
          <td><?php echo substr($row['p_po_no'], -4); ?></td>
          <td><?php echo $row['sub_grade']; ?></td>
          <td><?php echo $row['main_grade']; ?></td>



        </tr>
        <?php
        } ?>
        <?php
    } else {
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
