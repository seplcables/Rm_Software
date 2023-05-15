<?php
session_start();
if ($_SESSION['oid'] =='snehal' || $_SESSION['oid'] =='Rajnish' || $_SESSION['oid'] =='jignesh' || $_SESSION['oid'] =='amey' || $_SESSION['oid'] =='rommel') 
{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>store_opening</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css" media="screen">
      
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
                $sql="SELECT DISTINCT opening_date FROM store_opening_date ORDER BY opening_date asc";
                $run=sqlsrv_query($con,$sql);
                while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
                
                ?>
                <option value="<?php echo $row['opening_date']->format('d-M-y');  ?>"><?php echo $row['opening_date']->format('d-M-y');  ?></option>
                <?php
                }
                ?>
            </select>  
      </div>
      <div class="col-md-3">
          <input type="text" name="filter" id="filter" class="form-control" placeholder="Search Box" />  
      </div>
      <div class="col-md-3">
          <input type="submit" form="opening_form" value="Save" name="save" class="btn btn-info ml-2" />  
      </div>
    </div>
    <br />
    <?php if(isset($_SESSION['mess'])): ?>
    <div class="alert alert-primary font-weight-bold font-italic">
      <?php echo $_SESSION['mess']; ?>
    </div>
    <?php unset($_SESSION['mess']); ?>
    <?php endif; ?>
    <form action="opening_table_to_db.php" method="post" id="opening_form">
    <div class="table-responsive ml-1" id="order_table">
      <table class="table table-bordered table-striped table-sm" id="employee_data">
        <thead>
        <tr class="bg-dark text-white text-center font-italic">
                                    <th style="width:20%">Item_name</th>                                   
                                    <th style="width:16%">sub_grade</th>
                                    <th style="width:12%">main_grae</th>
                                    <th style="width:12%">Category</th>
                                    <th style="width:5%">Unit</th>
                                    <th style="width:10%">Qnty</th>
                                    <th style="width:25%">Remark</th>
        </tr>
        </thead>
        <?php
        include('..\..\..\dbcon.php');
        $sql = "SELECT a.i_code, a.item, a.min_limit, a.max_limit,a.is_limit, b.s_code, b.sub_grade, c.m_code, c.main_grade, d.c_code, d.category
 FROM rm_item a join rm_s_grade b on a.s_code = b.s_code join rm_m_grade c on b.m_code = c.m_code  join rm_category d on c.c_code = d.c_code 
 WHERE i_code in(select item from inward_store) order by a.s_code asc";
        //$sql="SELECT * FROM rm_item WHERE i_code in(select item from inward_store) order by s_code asc";
        $run=sqlsrv_query($con,$sql);
        while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
            // This Coding is for not show Item which is empty or less than zero balance
          /*$query2="SELECT SUM(qnty) as inw_qnty FROM inward_store where item='".$row['i_code']."'";
          $result2=sqlsrv_query($con,$query2);
          $row2=sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);

          $query3="SELECT SUM(qnty) as qnty_value FROM rm_issue where item_name='".$row['i_code']."' and issue_from = 'store'";
          $result3=sqlsrv_query($con,$query3);
          $row3=sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
          $qnty= $row2["inw_qnty"]-$row3['qnty_value'];

              if ($qnty <= 0) {
                continue;
              }*/
              // xxxxxx_END_xxxxxx
                    // $sql4="SELECT sub_grade FROM rm_s_grade where s_code='".$row['s_code']."'";
                    // $run4=sqlsrv_query($con,$sql4);
                    // $row4=sqlsrv_fetch_array($run4, SQLSRV_FETCH_ASSOC);

                    // $sql5="SELECT main_grade FROM rm_m_grade where m_code='".$row['m_code']."'";
                    // $run5=sqlsrv_query($con,$sql5);
                    // $row5=sqlsrv_fetch_array($run5, SQLSRV_FETCH_ASSOC);

                    // $sql6="SELECT category FROM rm_category where c_code='".$row['c_code']."'";
                    // $run6=sqlsrv_query($con,$sql6);
                    // $row6=sqlsrv_fetch_array($run6, SQLSRV_FETCH_ASSOC);

                    $sql7="SELECT unit FROM inward_store where item='".$row['i_code']."'";
                    $run7=sqlsrv_query($con,$sql7);
                    $row7=sqlsrv_fetch_array($run7, SQLSRV_FETCH_ASSOC);
        ?>
        <tr class="font-italic" id="<?php echo $row['id']; ?>">
          <td><?php echo $row['item'] ?></td>
          <td><?php echo $row['sub_grade'] ?></td>
          <td><?php echo $row['main_grade'] ?></td>
          <td><?php echo $row['category'] ?></td>
          <td><input type="text" name="unit[]" value="<?php echo $row7['unit'] ?>" class="form-control"></td>
          <td><input type="text" name="i_code[]" value="<?php echo $row['i_code'] ?>" class="form-control"></td>
          <td><input type="text" name="s_code[]" value="<?php echo $row['s_code'] ?>" class="form-control"></td>
          <td><input type="text" name="m_code[]" value="<?php echo $row['m_code'] ?>" class="form-control"></td>
          <td><input type="text" name="c_code[]" value="<?php echo $row['c_code'] ?>" class="form-control"></td>
          <td><input type="text" name="qnty[]" value="" class="form-control" autocomplete="off"></td>
          <td><input type="text" name="remark[]" class="form-control" autocomplete="off"></td>

          
        </tr>
        <?php
        } 
        ?>
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
  }
  else{
    $_SESSION['utype'] = "You Are Not Authorized!!";
            header("location:..\..\dashboard.php");
  }
?>