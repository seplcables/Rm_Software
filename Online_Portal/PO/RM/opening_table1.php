<?php
session_start();
if ($_SESSION['oid'] =='snehal' || $_SESSION['oid'] =='Rajnish' || $_SESSION['oid'] =='amey' || $_SESSION['oid'] =='harikishan' || $_SESSION['oid'] =='Nishant') {
    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>pvc_opening</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css" media="screen">
      #t_body{
        background-color: #EEEAEA;
      }
    </style>
  </head>
  <body>
    <div class="row m-1">
      <div class="col-md-3">
          <a href="../../dashboard.php" class="btn btn-warning w-25">Back</a>  
      </div>
      <div class="col-md-3">
          <select class="form-control" name="ope_date" id="ope_date" form="opening_form" required>
                <option disabled="true" selected="true" value="" class="bg-dark">select opening date</option>
                <?php
                include('..\..\..\dbcon.php');
    $sqlx="SELECT DISTINCT rm_opening_date FROM store_opening_date where rm_opening_date is not null ORDER BY rm_opening_date asc";
    $runx=sqlsrv_query($con, $sqlx);
    while ($rowx = sqlsrv_fetch_array($runx, SQLSRV_FETCH_ASSOC)) {
        ?>
                <option value="<?php echo $rowx['rm_opening_date']->format('d-M-y'); ?>"><?php echo $rowx['rm_opening_date']->format('d-M-y'); ?></option>
                <?php
    } ?>
            </select>  
      </div>
      <div class="col-md-3">
          <input type="text" name="filter" id="filter" class="form-control" placeholder="Search Grade,Store,Rmta...." />  
      </div>
      <div class="col-md-3">
          <input type="submit" form="opening_form" value="Save" name="save" class="btn btn-info ml-2" />  
      </div>
    </div>
    <br />
    <?php if (isset($_SESSION['mess'])): ?>
    <div class="alert alert-primary font-weight-bold font-italic">
      <?php echo $_SESSION['mess']; ?>
    </div>
    <?php unset($_SESSION['mess']); ?>
    <?php endif; ?>
    <form action="opening_table_to_db.php" method="post" id="opening_form">
    <div class="table-responsive ml-1" id="order_table">
      <table class="table-bordered table-sm" id="employee_data">
        <thead>
        <tr class="bg-dark text-white text-center font-italic">
                                    <th style="width:15%">Party</th>                                   
                                    <th style="width:20%">Grade</th>
                                    <th style="width:15%">Sub_grade</th>
                                    <th style="width:10%">Rmta</th>
                                    <th style="width:10%">Store</th>
                                    <th style="width:10%">Qnty</th>
                                    <th style="width:20%">Remark</th>
        </tr>
        </thead>
        <?php
        include('..\..\..\dbcon.php');
    $sql="SELECT DISTINCT item,party,rmta,store_name FROM inward_rm order by rmta asc";
    $run=sqlsrv_query($con, $sql);
    while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
        $sql3="SELECT item,s_code,m_code FROM rm_item where i_code='".$row['item']."'";
        $run3=sqlsrv_query($con, $sql3);
        $row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);

        $sql4="SELECT sub_grade FROM rm_s_grade where s_code='".$row3['s_code']."'";
        $run4=sqlsrv_query($con, $sql4);
        $row4=sqlsrv_fetch_array($run4, SQLSRV_FETCH_ASSOC);

        $sql5="SELECT party_name FROM rm_party_master where pid='".$row['party']."'";
        $run5=sqlsrv_query($con, $sql5);
        $row5=sqlsrv_fetch_array($run5, SQLSRV_FETCH_ASSOC); ?>
        <tr class="font-italic" id="t_body">
          <td><?php echo $row5['party_name'] ?></td>
          <td><?php echo $row3['item'] ?></td>
          <td><?php echo $row4['sub_grade'] ?></td>

          <td><input type="text" name="rmta[]" value="<?php echo $row['rmta'] ?>" class="border-0" readonly id="t_body"></td>
          <td><input type="text" name="store_name[]" value="<?php echo $row['store_name'] ?>" class="border-0" readonly id="t_body"></td>

          <td><input type="text" name="i_code[]" value="<?php echo $row['item'] ?>" class="form-control"></td>
          <td><input type="text" name="s_code[]" value="<?php echo $row3['s_code'] ?>" class="form-control"></td>
          <td><input type="text" name="m_code[]" value="<?php echo $row3['m_code'] ?>" class="form-control"></td>
          <td><input type="text" name="pid[]" value="<?php echo $row['party'] ?>" class="form-control"></td>
          <td><input type="number" name="qnty[]" value="" class="form-control" autocomplete="off"></td>
          <td><input type="text" name="remark[]" class="form-control" autocomplete="off"></td>

          
        </tr>
        <?php
    } ?>
      </table>
    </div>
    </form>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#employee_data td:nth-child(6)').hide();
        $('#employee_data td:nth-child(7)').hide();
        $('#employee_data td:nth-child(8)').hide();
        $('#employee_data td:nth-child(9)').hide();
      
      $("#filter").focusout(function(){
          var fil = $('#filter').val();
          if(fil != '')
          {
          $.ajax({
          url:"filter.php",
          method:"POST",
          data:{fil:fil},
          success:function(data)
          {
          $('#order_table').html(data);
          }
          });
          }
          else
          {
          alert("Please Enter Searchable Text");
          }
          });

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