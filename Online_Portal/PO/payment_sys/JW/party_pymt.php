<?php
session_start();
if ($_SESSION['oid'] =='snehal' || $_SESSION['oid'] =='Rajnish' || $_SESSION['oid'] =='dipen' || $_SESSION['oid'] =='himanshu' || $_SESSION['oid'] =='Pratik')
{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Bill_Send</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css" media="screen">
      input.largerCheckbox {
    transform : scale(2);
    }
    #bill_amt_value{
      background-color: #cc99ff;
      color: #000099;
    }
    </style>
  </head>
  <body>
    <div class="row m-1">
      <div class="col-md-1">
          <a href="payment_table.php" class="btn btn-warning">Back</a>
      </div>
      <div class="col-md-3">
          <input type="text" id="total" value="0" class="form-control">
      </div>
      <div class="col-md-3">
          <input type="text" id="trans_id" class="form-control" placeholder="trans_id">
      </div>
      <div class="col-md-4">
          <input type="text" id="remark" class="form-control" placeholder="remark">
      </div>
      <div class="col-md-1">
          <button type="button" name="btn_save" id="btn_save" class="btn btn-info">Save</button>
      </div>
    </div>
    <?php if(isset($_SESSION['mess'])): ?>
    <div class="alert alert-primary font-weight-bold font-italic">
      <?php echo $_SESSION['mess']; ?>
    </div>
    <?php unset($_SESSION['mess']); ?>
    <?php endif; ?>
    <div class="table-responsive m-1">
      <table class="table table-bordered table-striped table-sm">
        <tr class="bg-dark text-white text-center font-italic">
          <th>Party</th>
          <th>Bill_No</th>
          <th>Bill_Date</th>
          <th>mat_ord_by</th>
          <th>Bill_Amt</th>
          <th>Bal_amt</th>
          <th>A/c Head</th>
          <th>Ctrl</th>
        </tr>
        <?php
        include('..\..\..\..\dbcon.php');
            $pid= $_GET['party'];


        $sql="SELECT * from jw_return where bill_receive ='received' AND bill_send ='sent' AND pid='$pid' ORDER BY id asc";
        $run=sqlsrv_query($con,$sql);
        $params = array();
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $run1=sqlsrv_query($con,$sql,$params,$options);
        $row1=sqlsrv_num_rows($run1);
        if ($row1 > 0) {

        while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
        $sql2="SELECT party_name from rm_party_master where pid='$pid'";
        $run2=sqlsrv_query($con,$sql2);
        $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);

        $sql3="SELECT SUM(payment_amt) as payment_value FROM payment_table where sr_no='".$row['id']."' AND receive_at='jw'";
        $run3=sqlsrv_query($con,$sql3);
        $row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);

        $bal_amt = floatval($row['total_bill_amt'])-floatval($row3['payment_value']);
          if ($bal_amt <= 0) {
                         continue;
                               }
        ?>
        <tr class="text-center font-italic" id="<?php echo $row["sr_no"].$row['receive_at']; ?>">

          <td><?php echo $row2['party_name'];  ?></td>
          <td><?php echo $row['bill_no']; ?></td>
          <td><?php echo $row['in_date']->format('d.M.Y');  ?></td>
          <td><?php echo "hello";  ?></td>
          <td><?php echo $row['total_bill_amt'];  ?></td>
          <td id="bill_amt_value" class="font-weight-bold"><?php echo $row['total_bill_amt']-$row3['payment_value'];  ?></td>
          <td>
            <select class="form-control" name="desc[]" id="desc">
              <option disabled="true" selected="true" value="" class="bg-dark">--select--</option>
              <?php
              $sqlx="SELECT DISTINCT ac_head FROM ac_head ORDER BY ac_head";
              $runx=sqlsrv_query($con,$sqlx);
              while ($rowx = sqlsrv_fetch_array($runx, SQLSRV_FETCH_ASSOC)) {

              ?>
              <option value="<?php echo $rowx['ac_head'];  ?>"><?php echo $rowx['ac_head'];  ?></option>
              <?php
              }
              ?>
            </select>
          </td>
          <td><input type="checkbox" name="sr_no[]" class="largerCheckbox" id="check_box" value="<?php echo $row["id"].'jw'; ?>" /></td>
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

    $('#btn_save').click(function(){
      var ti = $("#trans_id").val();
      if (ti == '') {
          alert('Pls Enter Transaction ID');
      }
      else{
    if(confirm("Are you sure you want to Pay this?"))
    {
    var id = [];
    var ah = [];
    var pa = $("#total").val();
    var re = $("#remark").val();
    $(':checkbox:checked').each(function(i){
    id[i] = $(this).val();
    ah[i] = $(this).closest('tr').find('#desc').val();

    });
    //remove blank value in array
    var ah_len = ah.filter(function (el) {
    return el != null && el != "";
     });

    if(id.length == 0 || id.length != ah_len.length) //tell you if the array is empty
    {
    alert('Checkbox and A/c Head Both Mandatory');
    }
    else
    {
    $.ajax({
    url:'payment_to_db.php',
    method:'POST',
    data:{id:id,ah:ah,pa:pa,ti:ti,re:re},
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
  }
    });
    // Add bill_amt value to textbox
    $(document).on('click', '#check_box', function(){
        var bill = $(this).closest('tr').find('#bill_amt_value').text();
        var tot = $("#total").val();
         if(this.checked)
      {
        var x = parseFloat(bill) + parseFloat(tot);
        $('#total').val((x).toFixed(2));
      }
      else{
        var x =  parseFloat(tot) - parseFloat(bill);
        $('#total').val((x).toFixed(2));
      }
      });
    });
    // ------End------
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
