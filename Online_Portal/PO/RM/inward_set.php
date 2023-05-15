<?php
session_start();
include('../../../dbcon.php');
$id = $_GET['id'];
$qry="SELECT inward_com.invoice_no,inward_com.mat_from_party,inward_com.receive_date,inward_com.mat_ord_by,inward_ind.p_po_no,inward_ind.p_item,inward_ind.rec_qnty,inward_ind.p_unit,inward_ind.id,inward_ind.sr_no from inward_ind left outer join inward_com on(inward_ind.sr_no=inward_com.sr_no) where inward_ind.id = '$id'";
$run=sqlsrv_query($con,$qry);
$row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

// for common table
$sql2="SELECT item FROM rm_item where i_code='".$row["p_item"]."'";
$run2=sqlsrv_query($con,$sql2);
$row2=sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);

$sql6="SELECT party_name FROM rm_party_master where pid='".$row["mat_from_party"]."'";
$run6=sqlsrv_query($con,$sql6);
$row6=sqlsrv_fetch_array($run6, SQLSRV_FETCH_ASSOC);
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Rm_inward</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  </head>
  <body>
    
    <form action="inward_to_db.php" method="post" id="store_save">
      <div class="card-body">
        <div class="container-fluid">
          <div class="p-0 bg-secondary text-center text-warning">
            <h3>Raw Material Inward</h3>
          </div>
          <?php if(isset($_SESSION['message'])): ?>
          <div class="alert alert-danger font-weight-bold font-italic">
            <?php echo $_SESSION['message']; ?>
          </div>
          <?php unset($_SESSION['message']); ?>
          <?php endif; ?>
          
          <div class="row mt-2 ml-1">
            <div class="col-xs-3">
              <input type="text" class="form-control" id="date" name="date" value="<?php echo $row['receive_date']->format('d-M-y'); ?>">
            </div>
            <div class="col-xs-3 ml-1">
              <input type="text" class="form-control" id="rmta" name="rmta" value="<?php echo $row['sr_no']."/1"; ?>">
            </div>
            <div class="col-xs-3 ml-1">
              <input type="button" class="btn btn-success" value="Add Row" id="add_row">
            </div>
            <div class="col-xs-3 ml-1">
              <a href="inward.php" class="btn btn-danger font-weight-bold font-italic">BACK</a>
            </div>
          </div>
          <br />
            <table class="table table-bordered table-striped table-sm" id="employee_data" style="width: 80%;">
              <thead>
                <tr class="bg-dark text-white text-center font-italic">
                  <th style="width:5%">SrNo</th>
                  <th style="width:25%">Store_Name</th>
                  <th style="width:20%">Qnty</th>
                  <th style="width:30%">Remark</th>
                  
                </tr>
              </thead>
              <tbody>
                <tr>
                   <?php $srno = 1; ?>
                      <td><label class="form-control srno" readonly><?php echo $srno; ?></label></td>
                  <td>
                    <select class="form-control store" style="height:39px" name="store[]" required>
                      <option value="">Select</option>
                      <option value="gupta_ji">Gupta ji</option>
                      <option value="ramesh">ramesh</option>
                      <option value="chirag">chirag</option>
                      <option value="dinesh">dinesh</option>
                      
                    </select>
                  </td>
                  <td><input type="number" class="form-control qnty" name="qnty[]" onChange="GetQnty(this.value)" id="1qnty" required></td>
                  <td><input type="text" class="form-control remark" name="remark[]" id="remark"></td>
                </tr>
              </tbody>
            </table>
          <div class="input-group mb-2 text-right w-50">
            <label class="form-control badge-info font-weight-bold text-dark">Total_Qnty=></label>
            <input type="text" name="t_qnty" id="t_qnty" value="<?php echo $row['rec_qnty']; ?>" class="form-control border-info" readonly>
            <input type="hidden" name="sum_qnty" id="sum_qnty" value="0" class="form-control border-info" readonly>
          </div>
          <div class="input-group mb-2 text-right w-50">
            <label class="form-control badge-info font-weight-bold text-dark">Po_No=></label>
            <input type="text" name="po_no" id="po_no" value="<?php echo $row['p_po_no']; ?>" class="form-control border-info" readonly>
            <input type="hidden" class="form-control" value="<?php echo substr($row['p_po_no'], -4); ?>" id="po" name="po" readonly>
          </div>
          <div class="input-group mb-2 text-right w-50">
            <label class="form-control badge-info font-weight-bold text-dark">Invoice_no=></label>
            <input type="text" name="invoice_no" id="invoice_no" value="<?php echo $row['invoice_no']; ?>" class="form-control border-info" readonly>
            <input type="hidden" name="unit" id="unit" value="<?php echo $row['p_unit']; ?>" class="form-control border-info" readonly>
          </div>
          <div class="input-group mb-2 text-right w-50">
            <label class="form-control badge-info font-weight-bold text-dark">Mat_Ord_By=></label>
            <input type="text" name="mat_ord_by" id="mat_ord_by" value="<?php echo $row['mat_ord_by']; ?>" class="form-control border-info" readonly>
            <input type="hidden" class="form-control" value="<?php echo $row['id']; ?>" id="iid" name="iid" readonly>
          </div>
          <div class="input-group mb-2 text-right w-50">
            <label class="form-control badge-info font-weight-bold text-dark">Item=></label>
            <input type="text" name="item" id="item" value="<?php echo $row2['item']; ?>" class="form-control border-info" readonly>
            <input type="hidden" name="i_code" id="i_code" value="<?php echo $row['p_item']; ?>" class="form-control border-info" readonly>
          </div>
          <div class="input-group mb-2 text-right w-50">
            <label class="form-control badge-info font-weight-bold text-dark">Party=></label>
            <input type="text" name="party" id="party" value="<?php echo $row6['party_name']; ?>" class="form-control border-info" readonly>
            <input type="hidden" name="pid" id="pid" value="<?php echo $row['mat_from_party']; ?>" class="form-control border-info" readonly>
          </div>
        
          
          <input type="submit" class="btn btn-dark btn-lg text-white font-weight-bold font-italic" style="width:200px" id="savebtn" value="Save" name="submit">
          
        </div>
      </form>
      <script type="text/javascript">
      
      var abc = 1;
      // Start add row process
      $(document).on('click', '#add_row', function () {
      var xyz = $('#'+abc+'qnty').val();
      if (xyz == '') {
      alert('Pls Fill Current Row!!');
      }
      else{
      abc++;
      var rowLength = $('table').find('tbody tr').length;
      var rowHtml = '<tr row-id="' + (rowLength + 1) + '">';
        
        rowHtml += '<td><label class="form-control srno" readonly>'+abc+'</label></td>';
        rowHtml += '<td><select class="form-control store" style="height:39px" name="store[]" required><option value="">Select</option><option value="gupta_ji">Gupta ji</option><option value="ramesh">ramesh</option><option value="chirag">chirag</option><option value="dinesh">dinesh</option></select></td>';
        rowHtml += '<td><input type="number" class="form-control qnty" name="qnty[]" onChange="GetQnty(this.value)" id="'+abc+'qnty" required></td>';
        rowHtml += '<td><input type="text" class="form-control remark" name="remark[]" id="remark"></td>';      
        
        //rowHtml += ' <td> <a class="d_td_save btn btn-primary mrg-rg">Save</a><a class="d_td_save_all btn btn-primary mrg-rg hide">Save All</a> <a class="d_td_delete btn btn-danger">Delete</a> </td></tr>';
        $('table').find('tbody').append(rowHtml);
        
        }
        });
      function GetQnty(str){
        var sum_qnty = $("#sum_qnty").val();
        $("#sum_qnty").val(parseFloat(str) + parseFloat(sum_qnty));
      }  
    $(document).ready(function(){
      $("#rmta").focus();
       $("#store_save").submit(function(){
            var s_qnty = $('#sum_qnty').val();
            var t_qnty = $('#t_qnty').val();

            if (s_qnty < t_qnty) {
            alert('Difference Found so,Please Check Qnty');
            return false
          }
         
    });

       $("#rmta").blur(function(){
        var rmta = $(this).val();
        $.ajax({
        url:"rmta.php",
        method:"POST",
        data:{rmta:rmta},
        dataType:"text",
        success:function(data){
        var x = data.length;
        if (x>1) {
        alert(data);
        $("#rmta").focus();
        }
        }
        });
        });
  });     

        // End add row process
        
        
        </script>
      </body>
    </html>