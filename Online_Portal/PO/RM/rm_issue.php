<?php
session_start();
include('../../../dbcon.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>pvc_issue</title>
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
    
    <form action="rm_issue_to_db.php" method="post" id="store_save">
      <div class="card-body">
        <div class="container-fluid">
          <div class="p-0 bg-secondary text-center text-warning">
            <h3>Pvc Issue Form</h3>
          </div>
          <?php if(isset($_SESSION['message'])): ?>
          <div class="alert alert-danger font-weight-bold font-italic">
            <?php echo $_SESSION['message']; ?>
          </div>
          <?php unset($_SESSION['message']); ?>
          <?php endif; ?>
          
          <div class="row mt-2 ml-1">
            <div class="col-xs-3">
              <select class="form-control store" name="store" id="store" required>
                      <option value="">Select</option>
                      <option value="gupta_ji">Gupta ji</option>
                      <option value="ramesh">ramesh</option>
                      <option value="chirag">chirag</option>
                      <option value="dinesh">dinesh</option>
					            <option value="2106">2106</option>
                      <option value="dummy">Dummy</option>
                      <option value="new_dana">New_dana</option>
                      
                    </select>
            </div>
            <div class="col-xs-3 ml-1">
                <input type="date" class="form-control" id="date" name="date" required>
             </div> 
            <div class="col-xs-3 ml-1">
                   <select class="form-control stage" style="height:39px" name="stage" required>
                      <option value="">Select_Stage</option>
                      <option value="insulation">Insulation</option>
                      <option value="inner">Inner</option>
                      <option value="outer">Outer</option>
                      
                    </select>
            </div>
            <div class="col-xs-3 ml-1">
              <input type="button" class="btn btn-success" value="Add Row" id="add_row">
            </div>
            <div class="col-xs-3 ml-1">
              <a href="../../dashboard.php" class="btn btn-danger font-weight-bold font-italic">BACK</a>
            </div>
          </div>
          <br />
            <table class="table table-bordered table-striped table-sm" id="employee_data" style="width: 100%;">
              <thead>
                <tr class="bg-dark text-white text-center font-italic">
                  <th style="width:5%">SrNo</th>
                  <th style="width:25%">JobNo</th>
                  <th style="width:12%">Rmta</th>
                  <th style="width:25%">Grade</th>
                  <th style="width:12%">Bal</th>
                  <th style="width:12%">Qnty</th>
                  <th style="width:10%">Unit</th>
                  
                </tr>
              </thead>
              <tbody>
                <tr>
                   <?php $srno = 1; ?>
                      <td><label class="form-control srno" readonly><?php echo $srno; ?></label></td>
                  <td><input type="text" class="form-control job" name="job[]" id="job"></td>
                  <td><input type="text" class="form-control rmta" name="rmta[]" id="rmta" onFocus="SearchRmta(this)" required></td>
                  <td><input type="text" class="form-control grade" name="grade[]" id="grade" readonly></td>
                  <td><input type="text" class="form-control bal" name="bal[]" id="bal" readonly></td>
                  <td><input type="text" class="form-control qnty" name="qnty[]" id="1qnty" autocomplete="off" required></td>
                  <td>
                    <select class="form-control unit[]" name="unit[]">
                      <option value="kg">Kg</option>
                      <option value="bag">Bag</option>
                    </select>
                  </td>
                  <td><input type="hidden" class="form-control i_code" name="i_code[]" id="i_code" readonly></td>
                </tr>
              </tbody>
            </table>
          <div class="input-group mb-2 text-right w-50">
            <label class="form-control badge-info font-weight-bold text-dark">MC_No=></label>
            <input type="number" name="mc" id="mc" value="" class="form-control border-info">
          </div>
          <div class="input-group mb-2 text-right w-50">
            <label class="form-control badge-info font-weight-bold text-dark">Mix_Used=></label>
            <input type="number" name="mix_use" id="mix_use" value="" class="form-control border-info">
          </div>
          <div class="input-group mb-2 text-right w-50">
            <label class="form-control badge-info font-weight-bold text-dark">Mix_Return=></label>
            <input type="number" name="mix_return" id="mix_return" value="" class="form-control border-info">
          </div>
          <div class="input-group mb-2 text-right w-50">
            <label class="form-control badge-info font-weight-bold text-dark">Scrap=></label>
            <input type="number" name="scrap" id="scrap" step="0.1" class="form-control border-info">
          </div>
          <div class="input-group mb-2 text-right w-50">
            <label class="form-control badge-info font-weight-bold text-dark">Comment=></label>
            <input type="text" name="comment" id="comment" value="" class="form-control border-info">
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
        rowHtml += '<td><input type="text" class="form-control job" name="job[]" id="job"></td>';
        rowHtml += '<td><input type="text" class="form-control rmta" name="rmta[]" id="rmta" onFocus="SearchRmta(this)" required></td>';
        rowHtml += '<td><input type="text" class="form-control grade" name="grade[]" id="grade" readonly></td>';
        rowHtml += '<td><input type="text" class="form-control bal" name="bal[]" id="bal" readonly></td>';
        rowHtml += '<td><input type="text" class="form-control qnty" name="qnty[]" id="'+abc+'qnty" autocomplete="off" required></td>';
        rowHtml += '<td><select class="form-control unit[]" name="unit[]"><option value="kg">Kg</option><option value="bag">Bag</option></select></td>';
        rowHtml += '<td><input type="hidden" class="form-control i_code" name="i_code[]" id="i_code" readonly></td>';

        $('table').find('tbody').append(rowHtml);
        
        }
        });

              //RMTA seach
      function SearchRmta(txtBoxRef) {

        var store = $('#store').val();

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
    url: "getrmta.php",
    type: 'post',
    dataType: "json",
    data: {
     rmta: request.term,store: store
    },
    success: function( data ) 
    {
 
     response( data );
    }
   });
  },
  select: function (event, ui) {
   // Set selection
   var self = this;
   $(self).closest('tr').find('.rmta').val(ui.item.rmta);
   $(self).closest('tr').find('.grade').val(ui.item.grade);
   $(self).closest('tr').find('.bal').val(ui.item.bal);
   $(self).closest('tr').find('.i_code').val(ui.item.i_code);

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
      // $("#store").focus();

      // $("#store").blur(function(){
      //   var store = $(this).val();
      //   if (store == '') {
      //     alert('Pls select store first')
      //     $("#store").focus();
      //   }
      //  }); 
     }); 
        
        </script>
      </body>
    </html>