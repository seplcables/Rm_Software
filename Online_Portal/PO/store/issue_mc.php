<?php
session_start();
	    include('../../../dbcon.php');
	    $id = $_GET['id'];
    	$qry="SELECT a.rec_qnty,b.receive_date,a.id,d.item,a.p_unit,e.sub_grade,f.main_grade,g.category,d.i_code,d.s_code,d.m_code,d.c_code FROM inward_ind a
                LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
                LEFT OUTER JOIN rm_item d on d.i_code= a.p_item
                LEFT OUTER JOIN rm_s_grade e on e.s_code= d.s_code
                LEFT OUTER JOIN rm_m_grade f on f.m_code= d.m_code
                LEFT OUTER JOIN rm_category g on g.c_code= d.c_code
                where a.id = '$id'";
    	$run=sqlsrv_query($con,$qry);
    	$row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
	
		// for common table
		    $sql1="SELECT SUM(qnty) as qnty_value FROM rm_issue where inward_iid='$id'";
        $run1=sqlsrv_query($con,$sql1);
        $row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
		    $rec_qnty= $row['rec_qnty']-$row1['qnty_value'];
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>mc_issue</title>
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
      </style>
       </head>
       <body>
             
            <form action="inward_to_mc.php" method="post">
<div class="card-body">
      <div class="container-fluid">
                  <div class="p-0 bg-secondary text-center text-warning">
                           <h2>Material Issue To Mc</h2>
                  </div>           
                       <?php if(isset($_SESSION['message'])): ?>
                       <div class="alert alert-danger font-weight-bold font-italic">
                       <?php echo $_SESSION['message']; ?>
                       </div>
                       <?php unset($_SESSION['message']); ?>
                       <?php endif; ?>
                        
                  <div class="row">
                        <div class="col-sm-1">
                              <label> MRS No.</label>
                              <input type="text" class="form-control" id="mrsno" name="mrsno">
                        </div>
                        <div class="col-sm-2">
                              <label> Date </label>
                              <input type="text" class="form-control" id="date" name="date" value="<?php echo $row["receive_date"]->format("d-M-Y"); ?>" required>
                        </div>
                        <div class="col-sm-1 mt-4">
                              <input type="hidden" class="form-control" id="srno" name="srno" value="<?php echo $row["id"]; ?>" readonly>
                        </div>      
                        <div class="col-sm-1 mt-4">      
                              <input type="hidden" class="form-control" id="total_qnty" name="total_qnty" value="<?php echo $rec_qnty; ?>" readonly>
                        </div> 
                        <div class="col-sm-1 mt-4">     
                              <input type="hidden" class="form-control" id="msg" name="msg" value="<?php echo $row["id"]; ?>" readonly>
                        </div>

                        <div class="col-sm-1 mt-4">     
                              <input type="hidden" class="form-control" id="i_code" name="i_code" value="<?php echo $row["i_code"]; ?>" readonly>
                        </div>
                        <div class="col-sm-1 mt-4">     
                              <input type="hidden" class="form-control" id="s_code" name="s_code" value="<?php echo $row["s_code"]; ?>" readonly>
                        </div>
                        <div class="col-sm-1 mt-4">     
                              <input type="hidden" class="form-control" id="m_code" name="m_code" value="<?php echo $row["m_code"]; ?>" readonly>
                        </div>
                        <div class="col-sm-1 mt-4">     
                              <input type="hidden" class="form-control" id="c_code" name="c_code" value="<?php echo $row["c_code"]; ?>" readonly>
                        </div>      
                  </div>
                  <div class="row mt-3">
                        <div class="col-sm-4">
                              <label>Select Material Issue To..</label>
                              <select class="form-control mtype" id="mtype" name="mtype" required>
                                    <option value="" disabled="true" selected="true">--Select Issue To--</option>
                                    <option value="itomc"> Issue to Machine </option>
                                    <option value="itope"> Issue to Person </option>
                                    <option value="itode"> Issue to Department </option>
                              </select>
                        </div>
                        <div class="btn-group pull-right mt-4" role="group">
                              <a href="inward.php" class="btn btn-danger font-weight-bold font-italic m-2">BACK</a>
                        </div>
                        <div class="btn-group pull-right mt-4 ml-2" role="group">
                              <button type="button" id="mc_button" class="btn btn-secondary font-weight-bold font-italic" data-toggle="modal" data-target="#myModal">MC Master</button>
                        </div>
                        
                        
                  </div>
                  <br />
                  <div class="table-responsive">
                        <table class="table" id="itemtable">
                              <thead class="thead-dark">
                                    <tr>
                                          
                                          <th>Item Name</th>
                                          <th>Sub Grade</th>
                                          <th>Main Grade</th>
                                          <th>Category</th>
                                          <th style="width:120px">Qty</th>
                                          <th style="width:150px">Unit</th>
                                          <th style="width:100px">Stock</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    <tr>
                                          <?php $srno = 1; ?>
                                          
                                          <td>
                                                <input type="text" class="form-control item" name="item" value="<?php echo $row["item"]; ?>" readonly>
                                          </td>
                                          <td><input type="text" class="form-control subgrade" name="subgrade" value="<?php echo $row["sub_grade"]; ?>" readonly></td>
                                          <td><input type="text" class="form-control maingrade" value="<?php echo $row["main_grade"]; ?>" name="maingrade" readonly></td>
                                          <td><input type="text" class="form-control category" value="<?php echo $row["category"]; ?>" name="category"  readonly></td>
                                          <td><input type="text" class="form-control qty" id="qty" value="<?php echo $rec_qnty; ?>" name="qty"></td>
                                          <td><input type="text" class="form-control unit" value="<?php echo $row["p_unit"]; ?>" name="unit" readonly=""></td>
                                          <td><input type="text" class="form-control stock" value="" name="stock" readonly></td>
                                    </tr>
                              </tbody>
                        </table>
                  </div>
       <div class="input-group mb-2 text-right w-50 aaaa bbbb">
          <label class="form-control badge-info font-weight-bold text-dark">MC_Number=></label>
          <input type="text" name="mcno" id="mcno" class="form-control border-info" placeholder="----">
      </div>
      <div class="input-group mb-2 text-right w-50 aaaa">
          <label class="form-control badge-info font-weight-bold text-dark">Person_Name=></label>
          <input type="text" name="person" id="person" class="form-control border-info" placeholder="----">
      </div>
      <div class="input-group mb-2 text-right w-50">
          <label class="form-control badge-info font-weight-bold text-dark">DepartMent=></label>
          <input type="text" name="dpnt" id="dpnt" class="form-control border-info" placeholder="----">
      </div>
      <div class="input-group mb-2 text-right w-50">
          <label class="form-control badge-info font-weight-bold text-dark">Plant_Name=></label>
          <input type="text" name="plant" id="plant" class="form-control border-info" placeholder="----">
      </div>
      <div class="input-group mb-2 text-right w-50">
          <label class="form-control badge-info font-weight-bold text-dark">Issued_By=></label>
          <input type="text" name="issue_by" id="issue_by" class="form-control border-info" placeholder="----">
      </div>
      <div class="input-group mb-2 text-right w-50">
          <label class="form-control badge-info font-weight-bold text-dark">Make=></label>
          <input type="text" name="make" id="make" class="form-control border-info" placeholder="----">
      </div>
      <div class="input-group mb-2 text-right w-50">
          <label class="form-control badge-info font-weight-bold text-dark">Issued Category Type=></label>
          <select class="form-control border-info" id="cat" name="cat" required>
            <option value="" disabled="true" selected="true">--Select Category--</option>
            <option value="new"> NEW </option>
            <option value="replace"> REPLACE </option>
          </select>
      </div>
      <div class="input-group mb-2 text-right w-50 oldps">
          <label class="form-control badge-info font-weight-bold text-dark">Old Part Status=></label>
          <select class="form-control border-info" id="old_part" name="old_part">
            <option value="no">--Select--</option>
            <option value="repair">REPAIR</option>
            <option value="scrap">SCRAP</option>
            <option value="stock"> STOCK </option>
          </select>
      </div>
         <div class="input-group mb-2 text-right w-50 oldps">
          <label class="form-control badge-info font-weight-bold text-dark">Old Part Received=></label>
          <select class="form-control border-info" id="old_part_received" name="old_part_received">
            <option value="no">NO</option>
            <option value="yes">YES</option>
          </select>
      </div>
      <div class="input-group mb-2 text-right w-50">
          <label class="form-control badge-info font-weight-bold text-dark border-info">Remark=></label>
          <input type="text" name="remark" class="form-control" id="remark" placeholder="----">
      </div>
      



                  <input type="submit" class="btn btn-dark btn-lg text-white font-weight-bold font-italic" style="width:200px" id="savebtn" value="Save" name="submit">
      
      </div>
</form>
<script  type="text/javascript">
	    /*------autocomplete textbox-----*/
  $( function() {
 // mc autocomplete box
 $( "#mcno" ).autocomplete({
  source: function( request, response ) {
   // Fetch data
   $.ajax({
    url: "getmc.php",
    type: 'post',
    dataType: "json",
    data: {
     mc: request.term
    },
    success: function( data ) {
     response( data );
    }
   });
  },
  select: function (event, ui) {
   // Set selection
   $('#mcno').val(ui.item.label);
   $('#person').val(ui.item.pname1);
   $('#dpnt').val(ui.item.dname);
   $('#plant').val(ui.item.pname2);
   
   return false;
  },
  change: function (event, ui)  //if not selected from Suggestion
      {
        
          if (ui.item == null)
          {
            $(this).val('');
            $(this).focus();
          }
          else{

        $('#person,#dpnt,#plant').prop('readonly', true);

          }
          
        

      }
 });

// Issue_By autocomplete box
 $( "#issue_by" ).autocomplete({
  source: function( request, response ) {
   // Fetch data
   $.ajax({
    url: "getissueby.php",
    type: 'post',
    dataType: "json",
    data: {
     issue_by: request.term
    },
    success: function( data ) {
     response( data );
    }
   });
  },
  select: function (event, ui) {
   // Set selection
   $('#issue_by').val(ui.item.label);
   
   return false;
  },
  change: function (event, ui)  //if not selected from Suggestion
      {
        
          if (ui.item == null)
          {
            $(this).val('');
            $(this).focus();
          }
          
          
        

      }
 });

// person autocomplete box
 $( "#person" ).autocomplete({
  source: function( request, response ) {
   // Fetch data
   $.ajax({
    url: "getperson.php",
    type: 'post',
    dataType: "json",
    data: {
     person: request.term
    },
    success: function( data ) {
     response( data );
    }
   });
  },
  select: function (event, ui) {
   // Set selection
   $('#person').val(ui.item.label);
   $('#dpnt').val(ui.item.dname);
   $('#plant').val(ui.item.pname);
   
   return false;
  },
  change: function (event, ui)  //if not selected from Suggestion
      {
        
          if (ui.item == null)
          {
            $(this).val('');
            $(this).focus();
          }
          else{

        $('#dpnt,#plant').prop('readonly', true);

          }
          
        

      }
 });

// department autocomplete box
 $( "#dpnt" ).autocomplete({
  source: function( request, response ) {
   // Fetch data
   $.ajax({
    url: "getdpnt.php",
    type: 'post',
    dataType: "json",
    data: {
     dpnt: request.term
    },
    success: function( data ) {
     response( data );
    }
   });
  },
  select: function (event, ui) {
   // Set selection
   $('#dpnt').val(ui.item.label);
   $('#plant').val(ui.item.pname);
   
   return false;
  },
  change: function (event, ui)  //if not selected from Suggestion
      {
        
          if (ui.item == null)
          {
            $(this).val('');
            $(this).focus();
          }
          
          
        

      }
 });

 });
$(document).ready(function(){
    $(".oldps").hide();
    $(document).on('change','#cat',function(){
      var x=$(this).val();
      if (x=='replace') {
      $(".oldps").show();
    }
    else{
      $(".oldps").hide();
    }
    }); 
    $(document).on('change','#mtype',function(){
      var y=$(this).val();
      if (y=='itode') {
      $(".aaaa").hide();
    }
    else if (y=='itope') {
      $(".bbbb").hide();
    }
    else{
      $(".aaaa").show();
    }
    });

      $("#qty").focusout(function(){
         var qty=$(this).val();
         var total_qnty = $('#total_qnty').val();
         var srno = $('#srno').val();
         if (parseFloat(qty) >= parseFloat(total_qnty)) {
          $('#msg').val(srno);
         }
         else{
          $('#msg').val(0);
         }
      });

  });
 
      </script>
      <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-dark text-warning">
        <h4 class="modal-title font-weight-bold font-italic">Add Mc Master</h4>
        <button type="button" class="close text-warning" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body bg-dark text-white">
        <form action="mc_master.php" method="post">

        <input type="text" name="Mc_name" placeholder="Mc_name(optional)" class="form-control font-weight-bold" id="Mc_name">
        <input type="text" name="dpnt" placeholder="Department(required**)" class="form-control font-weight-bold mt-1" id="dpnt" required>
        <input type="text" name="superwizer" placeholder="SuperWizer(required**)" class="form-control font-weight-bold mt-1" id="superwizer" required>
        <input type="text" name="plant" placeholder="plant(required**)" class="form-control font-weight-bold mt-1" id="plant" required>
        

        <div class="modal-footer">
        <input type="submit" name="mc_master" id="mc_master" value="submit" class="btn btn-primary font-weight-bold w-25">
    </div>
      </form>
      </div>
      </div>
  </div>
</div>
</body>
</html>