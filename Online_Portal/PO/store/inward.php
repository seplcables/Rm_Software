<?php
session_start();
if ($_SESSION['oid'] =='snehal' || $_SESSION['oid'] =='Rajnish' || $_SESSION['oid'] =='suresh' || $_SESSION['oid'] =='rommel')
{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>store_inward</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <style type="text/css" media="screen">
      input.largerCheckbox {
    transform : scale(2);
    }
    .bg-info
    {
      margin: 0px !important;
    }
    </style>
  </head>
  <body>
    <h3 class="bg-info text-dark" align="center">Inward Material</h3><br/>

    <div class="row ml-2">
          <a href="../../dashboard.php" class="btn btn-warning">Back</a>
          <button type="button" name="btn_save" id="btn_save" class="btn btn-info ml-2">Save To Store</button>
    </div>
    <br />
    <?php if(isset($_SESSION['mess'])): ?>
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
            <th>issue</th>
            <th>Item_name</th>
            <th>bal</th>
            <th>unit</th>
            <th>party</th>
            <th>order_by</th>
            <th>Invoice</th>
            <th>po_no</th>
            <th>sub_grade</th>
            <th>main_grae</th>
            <th>Category</th>
        </tr>
        </thead>
        <?php
        include('..\..\..\dbcon.php');
                $sqlaa="SELECT max(opening_date) as ope_date from store_opening_date";
                $runaa=sqlsrv_query($con,$sqlaa);
                $rowaa=sqlsrv_fetch_array($runaa, SQLSRV_FETCH_ASSOC);
                $ope_date = $rowaa['ope_date']->format('Y-m-d');
                $sql = "SELECT a.rec_qnty,  b.receive_date,  a.id,  d.item,  a.p_unit,  c.party_name,  b.mat_ord_by,  b.invoice_no,  a.p_po_no,  e.sub_grade,  f.main_grade,  g.category FROM   inward_ind a  LEFT OUTER JOIN inward_com b ON a.sr_no = b.sr_no AND a.receive_at = b.receive_at  LEFT OUTER JOIN rm_party_master c ON c.pid = b.mat_from_party  LEFT OUTER JOIN rm_item d ON d.i_code = a.p_item  LEFT OUTER JOIN rm_s_grade e ON e.s_code = d.s_code  LEFT OUTER JOIN rm_m_grade f ON f.m_code = d.m_code  LEFT OUTER JOIN rm_category g ON g.c_code = d.c_code  LEFT OUTER JOIN inward_store si ON si.inward_ind_id = a.id  LEFT OUTER JOIN rm_issue ri ON ri.codee = a.id WHERE  b.receive_at = 'halol'  AND b.receive_date >= '$ope_date'  AND si.inward_ind_id IS NULL  AND ri.codee IS NULL  AND d.c_code NOT IN (30, 37)";
                
                /*$sql="SELECT a.rec_qnty,b.receive_date,a.id,d.item,a.p_unit,c.party_name,b.mat_ord_by,b.invoice_no,a.p_po_no,e.sub_grade,f.main_grade,g.category    FROM inward_ind a
                LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
                LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
                LEFT OUTER JOIN rm_item d on d.i_code= a.p_item
                LEFT OUTER JOIN rm_s_grade e on e.s_code= d.s_code
                LEFT OUTER JOIN rm_m_grade f on f.m_code= d.m_code
                LEFT OUTER JOIN rm_category g on g.c_code= d.c_code
                where d.c_code != 30 and d.c_code != 37 and b.receive_at = 'halol' and b.receive_date >= '$ope_date' and a.id NOT in(select inward_ind_id from inward_store) and a.id NOT in(select codee from rm_issue)";*/
              $run=sqlsrv_query($con,$sql);
              $params = array();
              $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
              $runa=sqlsrv_query($con,$sql,$params,$options);
              $rowa=sqlsrv_num_rows($runa);
        if ($rowa > 0) {
        ?>
        <?php
        while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
        $id = $row['id'];
                            $sql1="SELECT SUM(qnty) as qnty_value FROM rm_issue where inward_iid='$id'";
                            $run1=sqlsrv_query($con,$sql1);
                            $row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
                            $rec_qnty= $row['rec_qnty']-$row1['qnty_value'];

        ?>
        <tr class="text-center font-italic" id="<?php echo $row['id']; ?>">

          <td><?php echo $row["receive_date"]->format("d.M.y");  ?></td>
          <td><input type="checkbox" name="id[]" class="largerCheckbox" id="check_box" value="<?php echo $row['id']; ?>" /></td>
          <td><a href="issue_mc.php?id=<?php echo $row['id']; ?>" class="btn btn-info">clk</a></td>
          <td><?php echo $row['item'];  ?></td>
          <td><?php echo $rec_qnty;  ?></td>
          <td><?php echo $row['p_unit'];  ?></td>
          <td><?php echo $row['party_name'];  ?></td>
          <td><?php echo $row['mat_ord_by'];  ?></td>
          <td><?php echo $row['invoice_no'];  ?></td>
          <td><?php echo substr($row['p_po_no'], -4);  ?></td>
          <td><?php echo $row['id'];  ?></td>
          <td><?php echo $row['main_grade'];  ?></td>
          <td><?php echo $row['category'];  ?></td>



        </tr>
        <?php
        }
        ?>
        <?php
        }
        else{}

        ?>
      </table>

    </div>
    <script type="text/javascript">
      $(document).ready(function(){
            $('#employee_data').DataTable();
    $('#btn_save').click(function(){
    if(confirm("Are you sure you want to save To Store?"))
    {
    var id = [];

    $(':checkbox:checked').each(function(i){
    id[i] = $(this).val();
    });

    alert(id);
    if(id.length === 0) //tell you if the array is empty
    {
    alert("Please Select atleast one checkbox");
    }
    else
    {
    $.ajax({
    url:'store_db.php',
    method:'POST',
    data:{id:id},
    success:function()
    {
    for(var i=0; i<id.length; i++)
    {
      $('tr#'+id[i]+'').css('background-color', '#ccc');
      $('tr#'+id[i]+'').fadeOut('slow');
    }
  },
  complete:function()
  {
    location.reload(true);
  }

    });
    }

    }
    else
    {
    return false;
    }
    });


    });

    </script>
  </body>
</html>
<?php
  }
  else{
    $_SESSION['utype'] = "You Are Not Authorized!!";
            header("location:..\..\dashboard.php");
  }
?>
