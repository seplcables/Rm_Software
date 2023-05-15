<?php
session_start();
        include('../../../dbcon.php');
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Rm_issue</title>
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
             
            <form action="rm_issue_to_db.php" method="post">
<div class="card-body">
      <div class="container-fluid">
                  <div class="p-0 bg-secondary text-center text-warning">
                           <h2>Material Issue</h2>
                  </div>           
                       <?php if (isset($_SESSION['message'])): ?>
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
                              <input type="text" class="form-control" id="date" name="date" value="<?php echo date('d-M-y', time()); ?>" required>
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
                              <input type="button" class="btn btn-success" value="Add Row" id="add_row">
                        </div>
                        <div class="btn-group pull-right mt-4 ml-2" role="group">
                              <a href="..\..\dashboard.php" class="btn btn-danger font-weight-bold font-italic m-2">BACK</a>
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
                                          <th style="width:80px">Sr</th>
                                          <th style="width:300px">Item Name</th>
                                          <th style="width:250px">Sub Grade</th>
                                          <th style="width:220px">Main Grade</th>
                                          <th style="width:220px">Category</th>
                                          <th style="width:150px">Qty</th>
                                          <th style="width:150px">Unit</th>
                                          <th style="width:150px">Stock</th>
                                          <th style="width:150px">Make</th>
                                          <th style="width:150px">Model</th>
                                          
                                    </tr>
                              </thead>
                              <tbody>
                                    <tr>
                                          <?php $srno = 1; ?>
                                          <td><label class="form-control srno" readonly><?php echo $srno; ?></label></td>
                                          <td>
                                                <input type="text" class="form-control item" name="item[]" onFocus="SearchItem(this)" required>
                                          </td>
                                          <td><input type="text" class="form-control subgrade" name="subgrade[]" readonly></td>
                                          <td><input type="text" class="form-control maingrade" name="maingrade[]" readonly></td>
                                          <td><input type="text" class="form-control category" name="category[]"  readonly></td>
                                          <td><input type="text" class="form-control qty" name="qty[]" id="1qty" required></td>
                                          <td>
                                                <select class="form-control unit" style="height:39px" name="unit[]" required>
                                                      <option value="">Select</option>
                                                      <option>Bag </option>
                                                      <option>Book </option>
                                                      <option>Cu.Mtr </option>
                                                      <option>Cylinder </option>
                                                      <option>Feet </option>
                                                      <option>Gram </option>
                                                      <option>Kg </option>
                                                      <option>Liter </option>
                                                      <option>Meter </option>
                                                      <option>Nos </option>
                                                      <option>Pair </option>
                                                      <option>Pkt </option>
                                                      <option>Roll </option>
                                                      <option>Set </option>
                                                      <option>Sq.Ft </option>
                                                      <option>Sq.MM </option>
                                                      <option>Ton </option>
                                                      <option>Tractor/Truck </option>
                                                </select>
                                          </td>
                                          <td><input type="text" class="form-control stock" name="stock[]" id="1stock" readonly></td>
                                          <td><input type="text" class="form-control make" name="make[]" id="make" readonly></td>
                                          <td><input type="text" class="form-control model" name="model[]" id="model" readonly></td>
                                        
                                          <td><input type="hidden" class="form-control i_code" name="i_code[]" readonly></td>
                                          <td><input type="hidden" class="form-control s_code" name="s_code[]" readonly></td>
                                          <td><input type="hidden" class="form-control m_code" name="m_code[]" readonly></td>
                                          <td><input type="hidden" class="form-control c_code" name="c_code[]" readonly></td>
                                        
                                          
                                          
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
      <div class="d-flex mb-2 text-right w-50">
          <label class="form-control badge-info font-weight-bold text-dark" style="width:50%;">Project=></label>
          <input type="text" name="project" id="project" class="form-control border-info projecttemp" placeholder="----" style="width:45%;">
          <button class="btn btn-danger projectsave" type="button" id="projectsave" name="projectsave" style="height: 38px;border: none;width:5%;" ><i class="fa fa-plus float-sm"></i></button>
      </div>
      <div class="input-group mb-2 text-right w-50">
          <label class="form-control badge-info font-weight-bold text-dark">Sub_Project=></label>
          <input type="text" name="sub_project" id="sub_project" class="form-control border-info" placeholder="----">
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
            <option value="" disabled="true" selected="true">--Select--</option>
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




      <script type="text/javascript">
            
      //Date picker
     $("#date").click(function(){
        $(this).prop('type', 'date');

  });

       var abc = 1;
       // Start add row process     
      $(document).on('click', '#add_row', function () {
        var xyz = $('#'+abc+'qty').val();
        if (xyz == '') {
          alert('pls fill Current row');
        }
        else{
        abc++;

        var rowLength = $('table').find('tbody tr').length;
        var rowHtml = '<tr row-id="' + (rowLength + 1) + '">';
            
        rowHtml += '<td><div class=""> <input type="text" class="form-control srno" value="' + (rowLength+1) + '" readonly></td>';
        rowHtml += '<td><input type="text" class="form-control item" name="item[]" onFocus="SearchItem(this)" required></td>';
            rowHtml += '<td> <input type="text" class="form-control subgrade"  name="subgrade[]" readonly></td>';
        rowHtml += '<td><input type="text" class="form-control maingrade " name="maingrade[]" placeholder="" value="" readonly></td>';
            rowHtml += '<td><input type="text" class="form-control category " name="category[]" placeholder="" value="" readonly></td>';
            rowHtml += '<td><input type="text" class="form-control qty" name="qty[]" id="'+abc+'qty" required></td>';
            rowHtml += '<td><select class="form-control unit" name="unit[]" required style="height:39px"><option value="">Select</option> <option>Bag </option> <option>Book </option> <option>Cu.Mtr </option> <option>Cylinder </option> <option>Feet </option> <option>Gram </option><option>Kg </option><option>Liter </option><option>Meter </option><option>Nos </option><option>Pair </option><option>Pkt </option><option>Roll </option><option>Set </option><option>Sq.Ft </option><option>Sq.MM </option><option>Ton </option><option>Tractor/Truck </option></select></td>';
            rowHtml += '<td><input type="text" class="form-control stock" name="stock[]" id="'+abc+'stock" placeholder="" value="" readonly></td>';
          rowHtml += '<td><input type="hidden" class="form-control i_code" name="i_code[]" readonly></td>';
          rowHtml += '<td><input type="hidden" class="form-control s_code" name="s_code[]" readonly></td>';
          rowHtml += '<td><input type="hidden" class="form-control m_code" name="m_code[]" readonly></td>';
          rowHtml += '<td><input type="hidden" class="form-control c_code" name="c_code[]" readonly></td>';  
            
            
                              
            
        //rowHtml += ' <td> <a class="d_td_save btn btn-primary mrg-rg">Save</a><a class="d_td_save_all btn btn-primary mrg-rg hide">Save All</a> <a class="d_td_delete btn btn-danger">Delete</a> </td></tr>';
        $('table').find('tbody').append(rowHtml);
        
}
    });

      // End add row process

      //ITEM seach
      function SearchItem(txtBoxRef) {
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
    url: "getitem.php",
    type: 'post',
    dataType: "json",
    data: {
     item: request.term
    },
    success: function( data ) {
     response( data );
    }
   });
  },
  select: function (event, ui) {
   // Set selection
   var self = this;
   $(self).closest('tr').find('.item').val(ui.item.label);
   $(self).closest('tr').find('.subgrade').val(ui.item.m_grade);
   $(self).closest('tr').find('.maingrade').val(ui.item.s_grade);
   $(self).closest('tr').find('.category').val(ui.item.cat);
   $(self).closest('tr').find('.stock').val(ui.item.qnty);
   $(self).closest('tr').find('.i_code').val(ui.item.i_code);
   $(self).closest('tr').find('.s_code').val(ui.item.s_code);
   $(self).closest('tr').find('.m_code').val(ui.item.m_code);
   $(self).closest('tr').find('.c_code').val(ui.item.c_code);
   $(self).closest('tr').find('.make').val(ui.item.make_by);
    $(self).closest('tr').find('.model').val(ui.item.model_no);

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

  });
 

 
  //project 
  $( "#project" ).autocomplete
  ({
    source: function( request, response ) {
            
        // Fetch data
            $.ajax({
                      url: "../fetchProject.php?status=1",
                      type: 'post',
                      dataType: "json",
                      data: {
                      project: request.term,
                      
                    },
                    success: function( data ) {
                        response( data );
                        console.log(data);
                }
         });
        },
        select: function (event, ui) {
            // Set selection
              $('#project').val(ui.item.label);
              return false;
            },
        change: function (event, ui)  //if not selected from Suggestion
    {
        // if (ui.item == null)
        // {
        //   $(this).val('');
        //   $(this).focus();
        // }
      }
      //end project
});


  //save project
    $(document).on('click','#projectsave',function()
    {
      var projectname = $(".projecttemp").val(); 
      if(projectname == "")
      {
        alert('Enter Project name');
        $("#project").focus();
        return false;
      }
      else
      {
        $.ajax({
              url: "../fetchProject.php?status=2",
              method:"POST",
              data:{projectname:projectname},
              success:function(data)
              {
                alert(data);
                //alert('Project Added Successfully');
                //$('#rate_diff').modal('show');
              }
        });
      }
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