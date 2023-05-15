<?php
session_start();
if (!isset($_SESSION['oid'])) {
    $_SESSION['login'] = "Please Login First";
            header("location:../../login.php");
  }
  else {
/*include('../../dbcon.php');
if ($_GET) {
      $_SESSION['po_id']=$_GET['sid'];
      $sid= $_SESSION['po_id'];
    }
$sql="SELECT * FROM po_entry where id='$sid'";
$run=sqlsrv_query($con,$sql);
$row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);*/
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>add_data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css" media="screen">
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
::selection{
  background: #4158d0;
  color: #fff;
}

.wrapper  .field{
  height: 40px;
  width: 80%;
  margin-top: 15px;
  position: relative;
}
.wrapper  .field input{
  height: 100%;
  width: 70%;
  outline: none;
  font-size: 17px;
  padding-left: 20px;
  border: 1px solid blue;
  border-radius: 0px;
  transition: all 0.3s ease;
}
.wrapper  .field input:focus,
 .field input:valid{
  border-color: #4158d0;
}
.wrapper  .field label{
  position: absolute;
  top: 50%;
  left: 20px;
  color: #999999;
  font-weight: 400;
  font-size: 17px;
  pointer-events: none;
  transform: translateY(-50%);
  transition: all 0.3s ease;
}
 .field input:focus ~ label,
 .field input:read-only ~ label,
 .field input:valid ~ label{
  top: 0%;
  font-size: 16px;
  font: italic small-caps bold 15px Georgia, serif;
  color: #4158d0;
  background: #ffff80;
  transform: translateY(-50%);
}
 .content input{
  width: 15px;
  height: 15px;
  background: red;
}
 .content label{
  color: #262626;
  user-select: none;
  padding-left: 5px;
}


    body,input[type='text']{
      background-color: #ffff66;
    }
    input:read-only{
      color: #d24dff;
      font: italic small-caps bold 15px/30px Georgia, serif;
    }
    #tc_receipt,#freight_paid_by,#tc_status,#invoice_date,#receive_date,
    #received_at{
      background-color: #ffff66;
      height: 100%;
      width: 70%;
      outline: none;
      font-size: 17px;
      padding-left: 20px;
      border: 1px solid blue;
      border-radius: 0px;
      transition: all 0.3s ease;    
    }
    th{
      background-color: #a3c2c2;
   }
   #item_desc,#hsn_code,#project,#job,#remark1{
        background-color: #e6b3ff;
        padding: 8px;
        font-size: 18px;
   }
   #qnty,#disc_per,#disc_amt,#rate,#freight,#packaging,#insurance,#other_charge,
   #cgst_per,#sgst_per,#igst_per,#tcs_per{
        background-color: #b3e6ff;
        padding: 8px;
        font-size: 18px;
   }
   #srow{
          background-color: #1aff1a;
   }
   #trow{
          background-color: #ff66a3;
          border: 1px solid black;

   }
   .po_list {
          width: 95%;
          margin-left: 3%;
          margin-bottom: 4%;
          margin-top: 1%;
          background-color: #a3a375;
          text-align: left;
          padding: 30px;
          overflow: hidden;
          overflow-x: scroll;
          overflow-y: scroll;
        }
    #xrow{
        
        color: #660033;
        border: 1px solid black;
        font-size: 15px;
    }
    #po_list_table{
      background-color: #80ffff;
      color:  #ffff00;
      
    }
    #rr{
        background-color: #003366;
      color:  #ffffff;
    }
    #qq{
        background-color: #cc0066;
      color:  #ffffff;
    }       
    
  </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container">
        <a href="#" class="navbar-brand font-weight-bold">Add New PURCHASE</a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbaraid" aria-controls="navbaraid" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse" id="navbaraid">
        <ul class="navbar-nav ml-lg-auto">
            <li class="nav-item">
                <button type="button" class="nav-link btn btn-info mr-2" id="saveas">Save As New</button>
            </li>
            <li class="nav-item">
                <a href="purchase.php" class="nav-link btn btn-info mr-2">Search Po</a>
            </li>
            <li class="nav-item">
                <a href="showdata.php" class="nav-link btn btn-info mr-2">Po List</a>
            </li>
            <li class="nav-item">
                <a href="../dashboard.php" class="nav-link btn btn-info mr-2">Back</a>
            </li>

            
        </ul>
        </div>
        </div>
    </nav>
      <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-success font-weight-bold font-italic">
          <?php echo $_SESSION['message']; ?>
        </div>
      <?php endif; ?>
      <?php unset($_SESSION['message']); ?>
    <form action="inward_ind_to_db.php" method="post" id="sub_form">
      <div class="wrapper">
      <table align="center" class="m-5" style="width:100%">
    <tr>
      <td>
      <div class="field">
          <input type="text" class="" name="srno" value="" id="srno" required>
          <label>SR No.</label>
      </div>
    </td>
    <td>
      <div class="field">
          <input type="text" class="" name="party" value="" id="party" required>
          <label>Material Receive From Party</label>
        </div>
      </td>
      <td>  
        <div class="field">
          <input type="text" class="" name="sub_total" value="" id="sub_total" readonly>
          <label>Sub Total</label>
        </div>
      </td>  
  </tr>
  <tr>
      <td>
      <div class="field">
          <select name="received_at" class="" id="received_at" required>
              <option value="halol">Halol</option>
              <option value="baroda">Baroda</option>
          </select>
        </div>
    </td>
    <td>
      <div class="field">
          <input type="text" class="" name="bill_from_party" value="" id="bill_from_party" required>
          <label>Bill Receive From Party</label>
        </div>
      </td>
      <td>  
        <div class="field">
          <select name="freight_paid_by" class="" id="freight_paid_by">
              <option value="party">party</option>
              <option value="sepl">SEPL</option>
          </select>
        </div>

      </td>  
  </tr>
  <tr>
      <td>
      <div class="field">
          <input type="text" class="" name="receive_date" value="<?php echo date("d/m/Y", time()); ?>" id="receive_date" required>
          <label>Receive Date</label>
      </div>
    </td>
    <td>
      <div class="field">
          <input type="text" class="" name="po_gen_by" value="" id="po_gen_by" required>
          <label>Material Order By</label>
        </div>
      </td>
      <td>  
        <div class="field">
          <input type="text" class="" name="total_tax" value="" id="total_tax" readonly>
          <label>Total Tax</label>
        </div>
      </td>  
  </tr>
<tr>
      <td>
      <div class="field">
          <input type="text" class="" name="receive_month" value="" id="receive_month" readonly>
          <label>Receive Month</label>
      </div>
    </td>
    <td>
      <div class="field">
          <input type="text" class="" name="department" value="" id="department" required>
          <label>Department</label>
        </div>
      </td>
      <td>  
        <div class="field">
          <input type="text" class="" name="discount" value="" id="discount" readonly>
          <label>Disco./Freight/Others (-)</label>
        </div>
      </td>  
  </tr>
<tr>
      <td>
      <div class="field">
          <input type="text" class="" name="challan_no" value="" id="challan_no" required>
          <label>Challan No</label>
      </div>
    </td>
    <td>
      <div class="field">
          <input type="text" class="" name="remark" value="" id="remark">
          <label>Remark</label>
        </div>
      </td>
      <td>  
        <div class="field">
          <input type="text" class="" name="freight_subsidy" value="" id="freight_subsidy" required>
          <label>Freight Subsidy</label>
        </div>
      </td>  
  </tr>
<tr>
      <td>
      <div class="field">
          <input type="text" class="" name="invoice_date" value="<?php echo date("d/m/Y", time()); ?>" id="invoice_date" required>
          <label>Invoice Date</label>
      </div>
    </td>
    <td>
      <div class="field">
          <input type="text" class="" name="mat_type" value="" id="mat_type" required>
          <label>Material Type</label>
        </div>
      </td>
      <td>  
        <div class="field">
          <input type="text" class="" name="freight_without_gst" id="freight_without_gst" required>
          <label>Freight without GST</label>
        </div>
      </td>  
  </tr>
<tr>
      <td>
      <div class="field">
          <input type="text" class="" name="invoice_no" value="" id="invoice_no" required>
          <label>Invoice Number</label>
      </div>
    </td>
    <td>
      <div class="field">
          <select name="tc_receipt" class="" id="tc_receipt">
              <option value="no">NO</option>
              <option value="yes">YES</option>
          </select>
        </div>

      </td>
      <td>  
        <div class="field">
          <input type="text" class="" name="total_bill_amt" value="" id="total_bill_amt" readonly>
          <label>Total Bill Amount</label>
        </div>
      </td>  
  </tr>
<tr>
      <td>
      <div class="field">
          <input type="text" class="" name="weight" value="" id="weight" required>
          <label>Gross Weight (Way Bridge)</label>
      </div>
    </td>
    <td>
      <div class="field">
          <select name="tc_status" class="" id="tc_status">
              <option value="pending">PENDING</option>
              <option value="completed">COMPLETED</option>
          </select>
        </div>

      </td>
      <td>  
        <div class="field">
          <input type="text" class="" name="diff_qnty" value="" id="diff_qnty" readonly>
          <label>Diff. Qty</label>
        </div>
      </td>  
  </tr>
  <tr>
      <td>
          <input type="hidden" name="ord_qnty" value="" id="ord_qnty" readonly>
      </td>
    <td>
      <div class="field">
          <input type="text" class="" name="total_qnty" value="" id="total_qnty" readonly>
          <label>Total Qnty</label>
        </div>

      </td>
      <td>  
        <input type="hidden" name="iid" value="" id="iid" readonly>
      </td>  
  </tr>
  <tr>
    <td><input type="hidden" name="ord_rate" value="" id="ord_rate" readonly></td>
    <td><input type="hidden" name="bal" value="" id="bal" readonly></td>
    <td><input type="hidden" name="bal_status" value="" id="bal_status" readonly></td>
  </tr>


</table>
</div>
<table class="ml-5" align="center" style="width:95%">
            <tr>
               <th class="text-center">Item_Description</th>
               <th class="text-center">HSN_Code</th>
               <th class="text-center">project</th>
               <th class="text-center">Job</th>
               <th class="text-center">Remark</th>
               <th class="text-center">Stock</th>
               <th class="text-center">Main_grade</th>
               <th class="text-center">Sub_Grade</th>
               
            </tr>
            <tr>
               <td style="width:25%"><input type="text" class="form-control" name="item_desc" id="item_desc"></td>
               <td style="width:5%"><input type="text" class="form-control" name="hsn_code" id="hsn_code"></td>
               <td style="width:10%"><input type="text" class="form-control" name="project" id="project"></td>
               <td style="width:10%"><input type="text" class="form-control" name="job" id="job"></td>
               <td style="width:10%"><input type="text" class="form-control" name="remark1" id="remark1"></td>
               <td style="width:5%"><input type="text" class="form-control" name="stock" id="stock" readonly></td>
               <td style="width:15%"><input type="text" class="form-control" name="m_grade" id="m_grade" readonly></td>
               <td style="width:15%"><input type="text" class="form-control" name="s_grade" id="s_grade" readonly></td>

               
            </tr>
      </table>
  <table class="ml-5 mt-3" align="center" style="width:45%">
            <tr>
               <th class="text-center" id="srow">PKG</th>
               <th class="text-center" id="srow">Calculation</th>
               <th class="text-center" id="srow">Unit</th>
               <th class="text-center" id="srow">Plant</th>
            </tr>
            <tr>
               <td style="width:5%"><input type="text" class="form-control bg-white" name="pkg" id="pkg"></td>
               <td style="width:10%">
                <select name="calc" class="form-control" id="calc">
                        <option value="auto">Auto</option>
                        <option value="manual">Manual</option>
                </select>
               </td>
               <td style="width:10%">
        <select name="unit" class="form-control" id="unit">
          <option value="">select</option>
                        <?php
                        include('..\..\dbcon.php');
            $sql="SELECT unit_name FROM unit ORDER BY unit_name";
            $run=sqlsrv_query($con,$sql);
            $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
            ?>
            <option value="<?php echo $row['unit_name'];  ?>"><?php echo $row['unit_name'];  ?></option>
            <?php
            while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
            
            ?>
            <option value="<?php echo $row['unit_name'];  ?>"><?php echo $row['unit_name'];  ?></option>
            <?php
            }
            ?>
        </select>
               </td>
              <td style="width:20%">
                <select name="plant" class="form-control" id="plant">
                        <option value="">Select</option>
                        <option value="1701">1701</option>
                        <option value="2106">2106</option>
                        <option value="2204">2204</option>
                        <option value="2205">2205</option>
                        <option value="696">696</option>
                        <option value="jarod">jarod</option>
                        <option value="baroda">baroda</option>
                </select>
              </td>
            </tr>
      </table>

  <table class="ml-5 mt-4 mb-3" align="center" style="width:95%">
            <tr>
               <th class="text-center" id="trow">Qty</th>
               <th class="text-center" id="trow">Rate</th>
               <th class="text-center" id="trow">Disc(%)</th>
               <th class="text-center" id="trow">Disc(amt)</th>
               <th class="text-center" id="trow">Freight(+)</th>
               <th class="text-center" id="trow">Packaging   (+)</th>
               <th class="text-center" id="trow">Insurance  (+)</th>
               <th class="text-center" id="trow">Other charge  (+)</th>
               <th class="text-center" id="trow">Taxable amt</th>
               <th class="text-center" id="trow">CGST(%)</th>
               <th class="text-center" id="trow">CGST(amt)</th>
               <th class="text-center" id="trow">SGST(%)</th>
               <th class="text-center" id="trow">SGST(amt)</th>
               <th class="text-center" id="trow">IGST(%)</th>
               <th class="text-center" id="trow">IGST(amt)</th>
               <th class="text-center" id="trow">TCS(%)</th>
               <th class="text-center" id="trow">TCS(amt)</th>
               <th class="text-center" id="trow">Total_tax_amt</th>
               <th class="text-center" id="trow">Total Amt</th>

               
            </tr>
            <tr>
               <td style="width:5%"><input type="text" class="form-control" name="qnty" id="qnty"></td>
               <td style="width:5%"><input type="text" class="form-control" name="rate" id="rate"></td>
               <td style="width:3%"><input type="text" class="form-control" name="disc_per" id="disc_per"></td>
               <td style="width:5%"><input type="text" class="form-control" name="disc_amt" id="disc_amt"></td>
               <td style="width:5%"><input type="text" class="form-control" name="freight" id="freight"></td>
               <td style="width:5%"><input type="text" class="form-control" name="packaging" id="packaging"></td>
               <td style="width:5%"><input type="text" class="form-control" name="insurance" id="insurance"></td>
               <td style="width:5%"><input type="text" class="form-control" name="other_charge" id="other_charge"></td>
               <td style="width:7%"><input type="text" class="form-control" name="tax_amt" id="tax_amt" readonly></td>
               <td style="width:3%"><input type="text" class="form-control" name="cgst_per" id="cgst_per"></td>
               <td style="width:5%"><input type="text" class="form-control" name="cgst_amt" id="cgst_amt" readonly></td>
               <td style="width:3%"><input type="text" class="form-control" name="sgst_per" id="sgst_per" readonly></td>
               <td style="width:5%"><input type="text" class="form-control" name="sgst_amt" id="sgst_amt" readonly></td>
               <td style="width:3%"><input type="text" class="form-control" name="igst_per" id="igst_per"></td>
               <td style="width:5%"><input type="text" class="form-control" name="igst_amt" id="igst_amt" readonly></td>
               <td style="width:3%"><input type="text" class="form-control" name="tcs_per" id="tcs_per"></td>
               <td style="width:5%"><input type="text" class="form-control" name="tcs_amt" id="tcs_amt" readonly></td>
               <td style="width:8%"><input type="text" class="form-control" name="total_tax_amt" id="total_tax_amt" readonly></td>
               <td style="width:10%"><input type="text" class="form-control" name="total_amt" id="total_amt" readonly></td>
               
            </tr>
      </table>
      <input type="submit" name="submit" class="mb-5 ml-5 btn btn-dark w-25 font-weight-bold font-italic m-2" id="update" value="UPDATE">    
          
</form>  
<!-- PO list table below the form -->
<div class="po_list">
  <table id="po_list_table" border="1" class="border-danger border-bottom-0 bg-dark text-center">
            <tr>
               <th class="text-center" id="xrow">Action</th>
               <th class="text-center" id="xrow">SrNo</th>
               <th class="text-center" id="xrow">..Item_Description..</th>
               <th class="text-center" id="xrow">HSN CODE</th>
               <th class="text-center" id="xrow">..Plant..</th>
               <th class="text-center" id="xrow">..Project..</th>
               <th class="text-center" id="xrow">..Job_No..</th>
               <th class="text-center" id="xrow">..Remark..</th>
               <th class="text-center" id="xrow">..Material_Main_Grade..</th>
               <th class="text-center" id="xrow">..Material_Sub_Grade..</th>
               <th class="text-center" id="xrow">.PKG.</th>
               <th class="text-center" id="xrow">..Qty..</th>
               <th class="text-center" id="xrow">.Unit.</th>
               <th class="text-center" id="xrow">.Rate.</th>
               <th class="text-center" id="xrow">DIsc (%)</th>
               <th class="text-center" id="xrow">DIsc Amt</th>
               <th class="text-center" id="xrow">..Freight..</th>
               <th class="text-center" id="xrow">..Packing..</th>
               <th class="text-center" id="xrow">..Insurance..</th>
               <th class="text-center" id="xrow">..Other..</th>
               <th class="text-center" id="xrow">Taxable Amt</th>
               <th class="text-center" id="xrow">CGST (%)</th>
               <th class="text-center" id="xrow">CGST Amt</th>
               <th class="text-center" id="xrow">SGST (%)</th>
               <th class="text-center" id="xrow">SGST Amt</th>
               <th class="text-center" id="xrow">IGST (%)</th>
               <th class="text-center" id="xrow">IGST Amt</th>
               <th class="text-center" id="xrow">TCS (%)</th>
               <th class="text-center" id="xrow">TCS Amt</th>
               <th class="text-center" id="xrow">Tax Amt</th>
               <th class="text-center" id="xrow">Total Amt</th>
               <th class="text-center" id="xrow">IID</th>

               
            </tr>
            <?php
            $po=$_SESSION['po'];
            include('..\..\dbcon.php');
            $sql="SELECT * from po_entry where po_no='$po'";
            $run=sqlsrv_query($con,$sql);
            $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
            $x = 1;
            ?>
  <tr>
      <td><a class="btn btn-primary btn-sm edit_data">Edit</a></td>
      <td><?php echo $x  ?></td>
      <td><?php echo $row['item_desc'];  ?></td>
      <td><?php echo $row['hsn_code'];  ?></td>
      <td></td>
      <td><?php echo $row['project'];  ?></td>
      <td><?php echo $row['job'];  ?></td>
      <td><?php echo $row['remark'];  ?></td>
      <td><?php echo $row['main_grade'];  ?></td>
      <td><?php echo $row['sub_grade'];  ?></td>
      <td><?php echo $row['pkg'];  ?></td>
      <td id="qq"><?php echo $row['qnty'];  ?></td>
      <td><?php echo $row['unit'];  ?></td>
      <td id="rr"><?php echo $row['rate'];  ?></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td id="iiid"><?php echo $row['id'];  ?></td>
  </tr>
  

            <?php
            while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
              $x++;
            ?>
  <tr>
      <tr>
      <td><a class="btn btn-primary btn-sm edit_data">Edit</a></td>
      <td><?php echo $x  ?></td>
      <td><?php echo $row['item_desc'];  ?></td>
      <td><?php echo $row['hsn_code'];  ?></td>
      <td></td>
      <td><?php echo $row['project'];  ?></td>
      <td><?php echo $row['job'];  ?></td>
      <td><?php echo $row['remark'];  ?></td>
      <td><?php echo $row['main_grade'];  ?></td>
      <td><?php echo $row['sub_grade'];  ?></td>
      <td><?php echo $row['pkg'];  ?></td>
      <td id="qq"><?php echo $row['qnty'];  ?></td>
      <td><?php echo $row['unit'];  ?></td>
      <td id="rr"><?php echo $row['rate'];  ?></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td id="iiid"><?php echo $row['id'];  ?></td>
  </tr>
      
  </tr>
            <?php
            }
            ?>
            
  </table>          
</div>
<!-- END PO list table below the form -->
<script type="text/javascript">
   $(document).ready(function(){
  $("#receive_date").click(function(){
        $(this).prop('type', 'date');

  });
  $("#invoice_date").click(function(){
        $(this).prop('type', 'date');

  });
  $("#qnty").focusout(function(){
    var receive_qnty = $(this).val();
    var ord_rate = parseFloat($("#ord_rate").val());
    var ord_qnty = parseFloat($("#ord_qnty").val());
    var pend_qnty = ord_qnty - receive_qnty;
    if (pend_qnty > 0) {
      sta = 'pending';
    }
    else {
      sta = 'complete';
    }
    /*$("#rate").val(ord_rate);*/
    $("#bal").val(pend_qnty);
    $("#bal_status").val(sta);

   }); 
$("#rate").focusout(function(){
  var receive_rate = $(this).val();
  var receive_qnty = parseFloat($("#qnty").val());
  var ord_rate = parseFloat($("#ord_rate").val());
  var diff_rate = receive_rate - ord_rate;
  if (diff_rate == 0) {
    $("#tax_amt").val(receive_rate*receive_qnty);
    $("#total_amt").val(receive_rate*receive_qnty);

  }
  else {
    alert("we have to set modal with last 10 rate of the item");
    $("#tax_amt").val(receive_rate*receive_qnty);
    $("#total_amt").val(receive_rate*receive_qnty);
  }

 }); 
$("#disc_per").keyup(function(){
var disc_per = $(this).val();
var qnty = $("#qnty").val();
var rate = $("#rate").val();

var a = qnty*rate*disc_per/100;
$("#disc_amt").val((a).toFixed(2));
$("#tax_amt").val((qnty*rate-a).toFixed(2));
$("#total_amt").val((qnty*rate-a).toFixed(2));

});
$("#disc_amt").keyup(function(){
var disc_amt = $(this).val();
var qnty = $("#qnty").val();
var rate = $("#rate").val();

$("#tax_amt").val(qnty*rate-disc_amt);
$("#total_amt").val(qnty*rate-disc_amt);

}); 

$("#freight").keyup(function(){
var freight = $(this).val();
var n = freight.length;
if (n > 0) {
  var disc_amt = $("#disc_amt").val();
  var qnty = $("#qnty").val();
  var rate = $("#rate").val();
  var a = qnty*rate-disc_amt+parseFloat(freight);
  $("#tax_amt").val(a);
  $("#total_amt").val(a);
}

 });
$("#packaging").keyup(function(){
var packaging = $(this).val();
var n = packaging.length;
if (n > 0) {
  var qnty = $("#qnty").val();
  var rate = $("#rate").val();
  var disc_amt = $("#disc_amt").val();
  var freight = $("#freight").val();
  var a = qnty*rate-disc_amt+parseFloat(freight)+parseFloat(packaging);
  $("#tax_amt").val(a);
  $("#total_amt").val(a);
}

 });
$("#insurance").keyup(function(){
var insurance = $(this).val();
var n = insurance.length;
if (n > 0) {
  var qnty = $("#qnty").val();
  var rate = $("#rate").val();
  var disc_amt = $("#disc_amt").val();
  var freight = $("#freight").val();
  var packaging = $("#packaging").val();
  var a = qnty*rate-disc_amt+parseFloat(freight)+parseFloat(packaging)+parseFloat(insurance);
  $("#tax_amt").val(a);
  $("#total_amt").val(a);
}

 });
$("#other_charge").keyup(function(){
var other_charge = $(this).val();
var n = other_charge.length;
if (n > 0) {
  var qnty = $("#qnty").val();
  var rate = $("#rate").val();
  var disc_amt = $("#disc_amt").val();
  var freight = $("#freight").val();
  var packaging = $("#packaging").val();
  var insurance = $("#insurance").val();
  var a = qnty*rate-disc_amt+parseFloat(freight)+parseFloat(packaging)+parseFloat(insurance)+parseFloat(other_charge);
  $("#tax_amt").val(a);
  $("#total_amt").val(a);
}

 });

$("#cgst_per").keyup(function(){
var cgst_per = $(this).val();
var tax_amt = $("#tax_amt").val();
var amt = tax_amt*cgst_per/100;
var total = amt*2 + parseFloat(tax_amt);
$("#cgst_amt").val((amt).toFixed(2));
$("#sgst_per").val(cgst_per);
$("#sgst_amt").val((amt).toFixed(2));
$("#total_amt").val((total).toFixed(2));
$("#total_tax_amt").val((amt*2).toFixed(2));

if (cgst_per.length > 0) {
  $("#igst_per").prop('readonly',true);
}
else{
  $("#igst_per").prop('readonly',false);
}
});

$("#igst_per").keyup(function(){
var igst_per = $(this).val();
var cgst_amt = $("#cgst_amt").val();
var tax_amt = $("#tax_amt").val();
var amt = tax_amt*igst_per/100;
var total = amt + parseFloat(tax_amt);
if (cgst_amt > 0) {

}
else{
$("#igst_amt").val((amt).toFixed(2));
$("#total_amt").val((total).toFixed(2));
$("#total_tax_amt").val((amt).toFixed(2));
}
});

$("#tcs_per").keyup(function(){
var tcs_per = $(this).val();
var tax_amt = $("#tax_amt").val();
var cgst_amt = $("#cgst_amt").val();
var igst_amt = $("#igst_amt").val();
if (cgst_amt > 0) {
  var b = cgst_amt*2;
}
else{
    var b = igst_amt;
}

var amt = tax_amt*tcs_per/100;
var total_tax_amt = parseFloat(b) + parseFloat(amt);
var total = parseFloat(amt) + parseFloat(b) + parseFloat(tax_amt);

$("#tcs_amt").val((amt).toFixed(2));
$("#total_tax_amt").val((total_tax_amt).toFixed(2));
$("#total_amt").val((total).toFixed(2));
});

// for final save as
$('#saveas').click(function(event) {

        var fs = $('#freight_subsidy').val(); 
        var fpb   = $('#freight_paid_by').val();
        $.ajax({
                type: "POST",
                url: "inwardc_to_db.php",
                data:"fs="+fs+"&fpb="+fpb,
                success: function (msg) {

                   alert(msg);
                }
            });

    });
/// end the part final save as

$("#srno").focusout(function(){
var srno = $('#srno').val();
$.ajax({
                type: "POST",
                url: "srno.php",
                data:"srno="+srno,
                success: function (msg) {

                  
                }
            });

});

$(document).on('click', '.edit_data', function(){  
           var po_id = $(this).closest('tr').find('#iiid').text();  
           $.ajax({  
                url:"edit_po.php",  
                method:"POST",  
                data:{po_id:po_id},  
                dataType:"json",  
                success:function(data){  
                     $('#party').val(data.party);
                     $('#bill_from_party').val(data.party);  
                     $('#po_gen_by').val(data.po_gen_by);
                     $('#department').val(data.depart_ment);
                     $('#mat_type').val(data.material_type);
                     $('#item_desc').val(data.item_desc);
                     $('#hsn_code').val(data.hsn_code);
                     $('#project').val(data.project);
                     $('#job').val(data.job);
                     $('#remark1').val(data.remark);
                     $('#stock').val(data.stock);
                     $('#m_grade').val(data.main_grade);
                     $('#s_grade').val(data.sub_grade);
                     $('#unit').val(data.unit);
                     $('#qnty').val(data.qnty);
                     $('#rate').val(data.rate);
                     $('#ord_qnty').val(data.qnty);
                     $('#ord_rate').val(data.rate);
                     $('#iid').val(data.id);

                       
                }  
           });
          
      });

  });   

</script>

  </body>
</html>
<?php
}
?>