<?php
session_start();
include('../../../dbcon.php');
                $sql="SELECT MAX(rm_opening_date) as ope_date FROM store_opening_date";
                $run=sqlsrv_query($con,$sql);
                $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
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
    
    <form action="opening_to_db.php" method="post" id="store_save">
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
            <div class="col-xs-3 ml-1">
                <input type="text" class="form-control border-info" value="<?php echo $row['ope_date']->format('d-M-y'); ?>" id="date" name="date" readonly>
             </div> 
            <div class="col-xs-3 ml-1">
                  <select class="form-control store border-info" style="height:39px" name="store" id="store" required>
                      <option value="">Select_store</option>
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
              <input type="button" class="btn btn-success" value="Add Row" id="add_row">
            </div>
            <div class="col-xs-3 ml-1">
              <a href="../../dashboard.php" class="btn btn-danger font-weight-bold font-italic">BACK</a>
            </div>
          </div>
         <div class="row mt-2 ml-2 w-75">
            <input type="text" name="party" id="party" onFocus="SearchParty(this)" class="form-control border-info w-50" placeholder="...Enter Party....">
            <input type="hidden" name="pid" id="pid" class="form-control w-25" readonly>
          </div>

          <br />
            <table class="table table-bordered table-striped table-sm" id="employee_data" style="width: 100%;">
              <thead>
                <tr class="bg-dark text-white text-center font-italic">
                  <th style="width:5%">SrNo</th>
                  <th style="width:15%">Rmta</th>
                  <th style="width:20%">Grade</th>
                  <th style="width:15%">sub_grade</th>
                  <th style="width:15%">main_grade</th>
                  <th style="width:10%">Qnty</th>
                  <th style="width:20%">remark</th>
                  
                </tr>
              </thead>
              <tbody>
                <tr>
                   <?php $srno = 1; ?>
                      <td><label class="form-control srno" readonly><?php echo $srno; ?></label></td>
                  <td><input type="text" class="form-control rmta" name="rmta[]" id="rmta" required></td>
                  <td><input type="text" class="form-control grade" name="grade[]" id="grade" onFocus="SearchGrade(this)" required></td>
                  <td><input type="text" class="form-control sub_grade" name="sub_grade[]" id="sub_grade" readonly></td>
                  <td><input type="text" class="form-control main_grade" name="main_grade[]" id="main_grade" readonly></td>
                  <td><input type="number" class="form-control qnty" name="qnty[]" id="1qnty" autocomplete="off" required></td>
                  <td><input type="text" class="form-control remark" name="remark[]" id="remark"></td>
                  <td><input type="hidden" class="form-control i_code" name="i_code[]" id="i_code" readonly></td>
                  <td><input type="hidden" class="form-control s_code" name="s_code[]" id="s_code" readonly></td>
                  <td><input type="hidden" class="form-control m_code" name="m_code[]" id="m_code" readonly></td>
                </tr>
              </tbody>
            </table>
          
          
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
        rowHtml += '<td><input type="text" class="form-control rmta" name="rmta[]" id="rmta" required></td>';
        rowHtml += '<td><input type="text" class="form-control grade" name="grade[]" id="grade" onFocus="SearchGrade(this)" required></td>';
        rowHtml += '<td><input type="text" class="form-control sub_grade" name="sub_grade[]" id="sub_grade" readonly></td>';
        rowHtml += '<td><input type="text" class="form-control main_grade" name="main_grade[]" id="main_grade" readonly></td>';
        rowHtml += '<td><input type="text" class="form-control qnty" name="qnty[]" id="'+abc+'qnty" autocomplete="off" required></td>';
        rowHtml += '<td><input type="text" class="form-control remark" name="remark[]" id="remark"></td>';

      rowHtml += '<td><input type="hidden" class="form-control i_code" name="i_code[]" id="i_code" readonly></td>';
      rowHtml += '<td><input type="hidden" class="form-control s_code" name="s_code[]" id="s_code" readonly></td>';
      rowHtml += '<td><input type="hidden" class="form-control m_code" name="m_code[]" id="m_code" readonly></td>';

        $('table').find('tbody').append(rowHtml);
        
        }
        });

        //Grade seach
      function SearchGrade(txtBoxRef) {
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
    url: "getgrade.php",
    type: 'post',
    dataType: "json",
    data: {
     grade: request.term
    },
    success: function( data ) {
     response( data );
    }
   });
  },
  select: function (event, ui) {
   // Set selection
   var self = this;
   $(self).closest('tr').find('.grade').val(ui.item.label);
   $(self).closest('tr').find('.sub_grade').val(ui.item.sub_grade);
   $(self).closest('tr').find('.main_grade').val(ui.item.main_grade);
   $(self).closest('tr').find('.i_code').val(ui.item.i_code);
   $(self).closest('tr').find('.s_code').val(ui.item.s_code);
   $(self).closest('tr').find('.m_code').val(ui.item.m_code);

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
 
 //Grade seach
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
   $('#party').val(ui.item.label);
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

        </script>
      </body>
    </html>