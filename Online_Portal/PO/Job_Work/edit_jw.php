<?php
  session_start();
    include('../../../dbcon.php');
    $id = $_GET['sid'];
    $sql="SELECT * FROM jw_challan where id = '$id'";
    $run=sqlsrv_query($con,$sql);
    $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
    $sr_no = $row['id'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Create JW</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- jQuery Input mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    <style type="text/css" media="screen">
    #Consignor
    {
      background-color: #d9b3ff;
    }
    #Consignee
    {
      background-color: #80bfff;
    }
    ul {
        cursor: pointer;
        padding: unset;
        max-height: 250px;
        overflow: auto;
      }
      li {
        padding: 5px;
        background-color: #3399ff;
      }
      .container{
        background-color: #b3fff0;
      }
      body{
        background-color: #e2e4e8;
      }
    </style>
  </head>
  <body>
    <div class="bg-dark text-center text-white">
      <h4>UPDATE - JOB WORK CHALLAN</h4>
    </div>

      <div class="row">
        <div class="col-lg-6">
          <a href="../../dashboard.php" class="btn btn-info mx-3">Dashboard</a>
          <a href="showdata.php" class="btn btn-warning mx-1"><<< Back</a>
          <?php
      if (isset($_SESSION['jw'])) {
      ?>
      <a href="pdfdata.php?sid=<?php echo $_SESSION['jw']; ?>" class="btn btn-danger btn-sm font-weight-bold m-1 w-25">Print >>></a>
      <?php
      }
      ?>
        </div>

      </div>
      <?php if(isset($_SESSION['message'])): ?>
      <div class="alert alert-danger font-weight-bold font-italic">
        <?php echo $_SESSION['message']; ?>
      </div>
      <?php endif; ?>
      <?php unset($_SESSION['message']); ?>
      <div class="container mt-2">
      <form action="edit_jw_to_db.php" method="post" id="jw_challan">
        <div class="form-row">
          <div class="form-group col-6">
            <label for="date" class="font-weight-bold font-italic">Challan Create Date :-</label>
            <input type="text" class="form-control" value="<?php echo $row['challan_date']->format('d-M-y'); ?>" name="date" id="date" readonly>
          </div>
          <div class="form-group col-2"></div>
          <div class="form-group col-4">
            <label for="sr_no" class="font-weight-bold font-italic">Sr_No :-</label>
            <input type="text" class="form-control" value="<?php echo $row['id']; ?>" id="sr_no" name="sr_no" readonly>
          </div>
        </div>
        <!-- grouping pannel -->
        <label class="col-12" id="Consignor"><span class="font-weight-bold font-italic text-danger">Consignor Details</span>
        <div class="form-row  mt-3">
          <div class="form-group col-md-8">
            <label for="name" class="">Name :-</label>
            <input type="text" class="form-control font-italic" value="<?php echo $row['consignor_name']; ?>" name="name" id="name" readonly>
          </div>
          <div class="form-group col-md-4">
            <label for="gst" class="">GST No :-</label>
            <input type="text" value="24AACCS9412R1ZV" class="form-control font-italic font-weight-bold" name="gst" id="gst" readonly>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="add" class="">Address :-</label>
            <input type="text" value="A2/2205, 2204,G.I.D.C, Halol-389 350,Dist. Panchmahal" class="form-control" name="add" id="add" readonly>
          </div>

        </div>
      </label>
      <!-- xxxx End xxxx -->
      <!-- grouping pannel -->
      <label class="col-12" id="Consignee"><span class="font-weight-bold font-italic text-danger">Consignee Details</span>
      <div class="form-row  mt-3">
        <div class="form-group col-md-8">
          <label for="name1" class="">Name :-</label>
          <input type="text" value="<?php echo $row['consignee_name']; ?>" class="form-control font-italic" tabindex="1" name="name1" id="name1" onFocus="SearchParty(this)" required>
          <input type="hidden" value="<?php echo $row['pid']; ?>" class="form-control font-italic" name="pid" id="pid">
        </div>
        <div class="form-group col-md-4">
          <label for="gst1" class="">GST No :-</label>
          <input type="text" class="form-control font-italic font-weight-bold" value="<?php echo $row['consignee_gst']; ?>" name="gst1" id="gst1" readonly>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="add1" class="">Address :-</label>
          <input type="text" class="form-control" value="<?php echo $row['consignee_add']; ?>" name="add1" id="add1" readonly>
        </div>

      </div>
    </label>
    <!-- xxxx End xxxx -->
    <div class="form-row">
          <div class="form-group col-md-6">
            <label for="dog" class="font-weight-bold font-italic">Description Of Goods :-</label>
            <input type="text" class="form-control" name="dog" id="dog" tabindex="2" onFocus="SearchGoods(this)" value="<?php echo $row['goods_desc']; ?>" required>
          </div>
          <div class="form-group col-md-6">
            <label for="identify" class="font-weight-bold font-italic">Identification marks & number, if any :-</label>
            <input type="text" class="form-control" value="<?php echo $row['marks']; ?>" id="identify" tabindex="3" name="identify">
          </div>
        </div>
      <div class="form-row">
          <div class="form-group col-8">
            <label for="qnty" class="font-weight-bold font-italic">Quantity :-</label>
            <input type="number" step="0.01" class="form-control" tabindex="4" name="qnty" id="qnty" autocomplete="off" value="<?php echo $row['qnty']; ?>" required>
          </div>
          <div class="form-group col-4">
            <label for="Unit" class="font-weight-bold font-italic">Unit :-</label>
            <select class="form-control store" style="height:39px" tabindex="5" name="unit" required>
                      <option value="<?php echo $row['unit']; ?>"><?php echo $row['unit']; ?></option>
                      <option value="kg">KG</option>
                      <option value="nos">Nos</option>
                      <option value="ton">Ton</option>
                      <option value="gram">Gram</option>
                      <option value="mtr">Mtr</option>

                    </select>
          </div>
      </div>
      <div class="form-row">
          <div class="form-group col-8">
            <label for="val" class="font-weight-bold font-italic">Value :-</label>
            <input type="text" class="form-control" name="val" value="<?php echo $row['basic_val']; ?>" autocomplete="off" tabindex="6" id="val" required>
          </div>
          <div class="form-group col-4">
            <label for="hsc_code" class="font-weight-bold font-italic">HSN Code :-</label>
            <input type="text" class="form-control" id="hsn_code" value="<?php echo $row['hsn_code']; ?>" name="hsn_code" readonly>
          </div>
      </div>
      <div class="form-row">
          <div class="form-group col-md-6">
            <label for="taxable_goods" class="font-weight-bold font-italic">Taxable Value of Goods :-</label>
            <input type="text" class="form-control" value="<?php echo $row['taxable_amt']; ?>" name="taxable_goods" id="taxable_goods" readonly>
          </div>
          <div class="form-group col-md-6">
            <label for="vehicle_no" class="font-weight-bold font-italic">Mode of Transport Vehicle No.  :-</label>
            <input type="text" class="form-control" id="vehicle_no" value="<?php echo $row['vehicle_no']; ?>"  tabindex="7" name="vehicle_no" placeholder="XX-00-XX-0000" required>
          </div>
      </div>
      <div class="form-row">
          <div class="form-group col-md-6">
            <label for="nature_of processing" class="font-weight-bold font-italic">Nature of Processing Required to be done :-</label>
            <input type="text" class="form-control" name="nature_of_processing" id="nature_of_processing" value="<?php echo $row['nature_of_process']; ?>"  readonly>
          </div>
          <div class="form-group col-md-6">
            <label for="duration_days" class="font-weight-bold font-italic">Expected Duration of Processing  :-</label>
            <input type="number" class="form-control" id="duration_days" tabindex="8" name="duration_days" value="<?php echo $row['expected_receive_days']; ?>" required>
            <input type="hidden" class="form-control" id="expected_receive_date" name="expected_receive_date" value="<?php echo $row['expected_receive_date']->format('d-M-y'); ?>">
          </div>
      </div>
      <input type="submit" name="save" class="btn btn-info w-25 font-weight-bold font-italic mb-5" tabindex="10" id="save" value="UPDATE">
  </form>
</div>
<script type="text/javascript">
//Party Search
function SearchParty(txtBoxRef) {
console.log('function call');
var f = true; //check if enter is detected
$(txtBoxRef).keypress(function (e) {
if (e.keyCode == '13' || e.which == '13')
{
f = false;
}
});
$(txtBoxRef).autocomplete({

source: function( request, response ) {
// Fetch data
$.ajax({
url: "getparty.php",
type: 'post',
dataType: "json",
data: {
party: request.term
},
success: function( data ) {
response( data );
}
});
},
select: function (event, ui) {
// Set selection
$('#name1').val(ui.item.label);
$('#gst1').val(ui.item.gst);
$('#add1').val(ui.item.add);
$('#pid').val(ui.item.pid);

return false;
},
change: function (event, ui)  //if not selected from Suggestion
{
if (f)
{
if (ui.item == null)
{
$(this).val('');
$(this).focus();
}
/*else{
$(this).closest('tr').find('.qty').focus();
}*/
}
}
});

}
//Party Search
function SearchGoods(txtBoxRef) {
console.log('function call');
var f = true; //check if enter is detected
$(txtBoxRef).keypress(function (e) {
if (e.keyCode == '13' || e.which == '13')
{
f = false;
}
});
$(txtBoxRef).autocomplete({

source: function( request, response ) {
// Fetch data
$.ajax({
url: "getgood.php",
type: 'post',
dataType: "json",
data: {
good: request.term
},
success: function( data ) {
response( data );
}
});
},
select: function (event, ui) {
// Set selection
$('#dog').val(ui.item.label);
$('#hsn_code').val(ui.item.hsn);
$('#nature_of_processing').val(ui.item.nop);

return false;
},
change: function (event, ui)  //if not selected from Suggestion
{
if (f)
{
if (ui.item == null)
{
$(this).val('');
$(this).focus();
}
/*else{
$(this).closest('tr').find('.qty').focus();
}*/
}
}
});

}
$(document).ready(function(){
  $('#vehicle_no').inputmask({"mask": "[AA]-99-[AA]-9999"});
  $("#name1").focus();
$("#date").click(function(){
    $(this).prop('type', 'date');
    });

$('#duration_days').change(function() {
        var days = $(this).val();
        var challan_date = $("#date").val();

        var date = new Date(challan_date);
        date.setDate(date.getDate() + (+days));
        var dd = date.getDate();
        var mm = date.getMonth() + 1;
        var y = date.getFullYear();
        var someFormattedDate = y + '-' + mm + '-' + dd;
        $('#expected_receive_date').val(someFormattedDate);
        });

  $('#val').change(function() {
        var tval = $(this).val();
        var x = parseFloat(tval)*0.18;

        $('#taxable_goods').val(x);

     });

});
</script>
</body>
</html>
