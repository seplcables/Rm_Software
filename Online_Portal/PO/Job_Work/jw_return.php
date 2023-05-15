           <?php
              session_start();
                include('../../../dbcon.php');
                $cl_no = $_GET['sid'];
                $sql="SELECT * FROM jw_challan where id ='$cl_no'";
                $run=sqlsrv_query($con, $sql);
                $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

                $sql1="SELECT sum(in_qnty) as return_qnty FROM jw_return where iid ='$cl_no'";
                $run1=sqlsrv_query($con, $sql1);
                $row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);

                $bal_qnty = $row['qnty'] - $row1['return_qnty'];
            ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Return JW</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <style type="text/css" media="screen">
    #in_details{
    background-color: #b3fff0;
    }
    #out_details{
    background-color: #b3d9ff;
    }
      .container-fluid{
        background-color: #ffffff;
      }
      body{
        background-color: #e6fffa;
      }
    </style>
  </head>
  <body class="">
    <div class="bg-dark text-center text-white">
      <h4><i>JOB WORK RETURN</i></h4>
    </div>
      <div class="container-fluid container mt-2">
      <form action="return_to_db.php" method="post" id="jw_challan">
        <label class="col-12" id="out_details"><u><span class="font-weight-bold font-italic text-danger">JOB WORK OUT DETAILS</span></u>
          <div class="form-row mt-4">
          <div class="form-group col-lg-2 col-md-3 col-sm-6">
            <label for="" class="font-italic">Challan No :-</label>
            <input type="text" name="challan_no" class="form-control" value="<?php echo $cl_no; ?>" readonly>
          </div>
          <div class="form-group col-lg-2 col-md-3 col-sm-6">
            <label for="" class="font-italic">Out Date :-</label>
            <input type="text" class="form-control" value="<?php echo $row['challan_date']->format('d-M-y'); ?>" readonly>
          </div>
          <div class="form-group col-lg-4 col-md-6 col-sm-6">
            <label for="" class="font-italic">Party :-</label>
            <input type="text" class="form-control" value="<?php echo $row['consignee_name']; ?>" readonly>
          </div>
          <div class="form-group col-lg-4 col-md-6 col-sm-6">
            <label for="" class="font-italic">Item Desc :-</label>
            <input type="text" class="form-control" value="<?php echo $row['goods_desc']; ?>" readonly>
          </div>
          <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="" class="font-italic">Bal Qnty :-</label>
            <input type="text" class="form-control" id="bal_qnty" value="<?php echo $bal_qnty; ?>" readonly>
          </div>
          <div class="form-group col-lg-3 col-md-2 col-sm-6">
            <label for="" class="font-italic">Unit :-</label>
            <input type="text" class="form-control" value="<?php echo $row['unit']; ?>" readonly>
            <input type="hidden" name="pid" class="form-control" value="<?php echo $row['pid']; ?>" readonly>
          </div>


      </div>
    </label>

        <label class="col-12" id="in_details"><u><span class="font-weight-bold font-italic text-danger">JOB WORK IN DETAILS</span></u>
          <div class="form-row mt-4">
          <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="in_date" class="font-italic">In Date :-</label>
            <input type="text" class="form-control" name="in_date" value="<?php echo date("d-M-y", time()); ?>" tabindex="1" id="in_date" required>
          </div>
          <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="party_challan" class="font-italic">Party Challan :-</label>
            <input type="text" class="form-control" id="party_challan" tabindex="2" name="party_challan">
          </div>
          <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="bill_no" class="font-italic">Bill No :-</label>
            <input type="text" class="form-control" id="bill_no" tabindex="3" name="bill_no" required>
          </div>
          <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="in_qnty" class="font-italic">In Qnty :-</label>
            <input type="number" step="0.001" class="form-control" id="in_qnty" tabindex="4" name="in_qnty" required>
          </div>
          <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="rate" class="font-italic">Rate :-</label>
            <input type="number" step="0.01" class="form-control" name="rate" id="rate" tabindex="5" required>
          </div>
          <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="basic_value" class="font-italic">Basic Value :-</label>
            <input type="text" class="form-control" id="basic_value" name="basic_value" readonly>
          </div>
          <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="freight_taxable" class="font-italic">Freight Taxable :-</label>
            <input type="number" class="form-control" id="freight_taxable" tabindex="6" name="freight_taxable">
          </div>
          <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="total_tax_amt" class="font-italic">Total Taxable Amt :-</label>
            <input type="text" class="form-control" id="total_tax_amt" name="total_tax_amt" readonly>
          </div>
          <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="cgst_per" class="font-italic">CGST/SGST Per% :-</label>
            <input type="text" class="form-control" name="cgst_per" id="cgst_per" tabindex="7">
          </div>
          <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="cgst_amt" class="font-italic">CGST Amt :-</label>
            <input type="text" class="form-control" id="cgst_amt" name="cgst_amt" readonly>
          </div>
          <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="sgst_amt" class="font-italic">SGST Amt :-</label>
            <input type="text" class="form-control" id="sgst_amt" name="sgst_amt" readonly>
          </div>
          <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="igst_per" class="font-italic">IGST per% :-</label>
            <input type="text" class="form-control" id="igst_per" tabindex="8" name="igst_per">
          </div>
          <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="igst_amt" class="font-italic">IGST Amt :-</label>
            <input type="text" class="form-control" id="igst_amt" name="igst_amt" readonly>
          </div>
           <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="freight_no_tax" class="font-italic">Freight No Tax :-</label>
            <input type="number" step="0.01" class="form-control" id="freight_no_tax" tabindex="9" name="freight_no_tax">
          </div>
           <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="other_charge" class="font-italic">Other Charge :-</label>
            <input type="number" step="0.01" class="form-control" id="other_charge" tabindex="10" name="other_charge">
          </div>
           <div class="form-group col-lg-3 col-md-4 col-sm-6">
            <label for="total_bill_amt" class="font-italic">Total Bill Amt :-</label>
            <input type="text" class="form-control" id="total_bill_amt" name="total_bill_amt" readonly>
          </div>
          <div class="form-group col-lg-12 col-md-12 col-sm-12">
            <label for="remark" class="font-italic">Remark :-</label>
            <input type="text" class="form-control" id="remark" tabindex="11" name="remark">
          </div>
      </div>
    </label>

      <input type="submit" name="save" class="btn btn-info w-25 font-weight-bold font-italic mb-5" tabindex="12" id="save" value="SAVE DATA">
  </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var bal_qnty = $("#bal_qnty").val();
      if (bal_qnty <= 0) {
                          alert('Return Qnty Completed');
                          window.open('showdata.php','_self');
      }

        $("#in_date").click(function(){
            $(this).prop('type', 'date');
            });

            $("#rate, #in_qnty, #freight_taxable").keyup(function(){
                 var rte = $("#rate").val();
                 var qnty = $("#in_qnty").val();
                 var ft = $("#freight_taxable").val();
                 if (ft == '') {
                  ft = 0;
                 }
                 else{
                  var ft = $("#freight_taxable").val();
                 }

                 $("#basic_value").val((rte*qnty).toFixed(2));
                 $("#total_tax_amt").val((rte*qnty + parseFloat(ft)).toFixed(2));
              });
                $("#rate, #in_qnty, #freight_taxable, #cgst_per").keyup(function(){
                 var total_tax_amt = $("#total_tax_amt").val();
                 var cgst_per = $("#cgst_per").val();
                 $("#cgst_amt").val((total_tax_amt*cgst_per*0.01).toFixed(2));
                 $("#sgst_amt").val((total_tax_amt*cgst_per*0.01).toFixed(2));
               });
              $("#rate, #in_qnty, #freight_taxable, #igst_per").keyup(function(){
                 var total_tax_amt = $("#total_tax_amt").val();
                 var igst_per = $("#igst_per").val();
                 $("#igst_amt").val((total_tax_amt*igst_per*0.01).toFixed(2));
               });

              $("#rate, #in_qnty, #freight_taxable, #igst_per, #cgst_per, #freight_no_tax, #other_charge").keyup(function(){
                 var total_tax_amt = $("#total_tax_amt").val();
                 var igst_amt = $("#igst_amt").val();
                 var cgst_amt = $("#cgst_amt").val();
                 var fnt = $("#freight_no_tax").val();
                 var other_charge = $("#other_charge").val();
                 if (fnt == '') {
                  fnt = 0;
                 }
                 else{
                  var fnt = $("#freight_no_tax").val();
                 }
                 if (other_charge == '') {
                  other_charge = 0;
                 }
                 else{
                  var other_charge = $("#other_charge").val();
                 }
                 $("#total_bill_amt").val((parseFloat(total_tax_amt)+parseFloat(igst_amt)+parseFloat(cgst_amt)*2+parseFloat(fnt)+parseFloat(other_charge)).toFixed(2));
               });
});
</script>
</body>
</html>
