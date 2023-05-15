<?php
session_start();
        include('../../../dbcon.php');
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>stock_opening</title>
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
             
            <form action="opening_to_db.php" method="post">
<div class="card-body">
      <div class="container-fluid">
                  <div class="p-0 bg-secondary text-center text-warning">
                           <h2>Stock Opening</h2>
                  </div>           
                       <?php if(isset($_SESSION['message'])): ?>
                       <div class="alert alert-danger font-weight-bold font-italic">
                       <?php echo $_SESSION['message']; ?>
                       </div>
                       <?php unset($_SESSION['message']); ?>
                       <?php endif; ?>
                        
                  
                  <div class="row mt-3">
                        <div class="col-sm-4">
                              <label> Date </label>
                              <select class="form-control" name="ope_date" id="ope_date" form="opening_form" required>
                
                <?php
                include('..\..\..\dbcon.php');
                $sql="SELECT DISTINCT opening_date FROM store_opening_date ORDER BY opening_date desc";
                $run=sqlsrv_query($con,$sql);
                while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
                
                ?>
                <option value="<?php echo $row['opening_date']->format('d-M-y');  ?>"><?php echo $row['opening_date']->format('d-M-y');  ?></option>
                <?php
                }
                ?>
            </select>
                        </div>
                        <div class="btn-group pull-right mt-4" role="group">
                              <input type="button" class="btn btn-success" value="Add Row" id="add_row">
                        </div>
                        <div class="btn-group pull-right mt-4 ml-2" role="group">
                              <!-- <a href="..\..\dashboard.php" accesskey="b"></a> -->
                              <a href="..\..\dashboard.php" accesskey="b" class="btn btn-danger font-weight-bold font-italic m-2">BACK</a>
                        </div>
                       
                        
                  </div>
                  <br />
                  <div class="table-responsive">
                        <table class="table" id="itemtable">
                              <thead class="thead-dark">
                                    <tr>
                                          <th style="width:60px">Sr</th>
                                          <th>Item Name</th>
                                          <th>Sub Grade</th>
                                          <th>Main Grade</th>
                                          <th>Category</th>
                                          <th style="width:120px">Qty</th>
                                          <th style="width:150px">Unit</th>
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
                                          <td><input type="hidden" class="form-control i_code" name="i_code[]" readonly></td>
                                          <td><input type="hidden" class="form-control s_code" name="s_code[]" readonly></td>
                                          <td><input type="hidden" class="form-control m_code" name="m_code[]" readonly></td>
                                          <td><input type="hidden" class="form-control c_code" name="c_code[]" readonly></td>
                                         
                                          
                                    </tr>
                              </tbody>
                        </table>
                  </div>
      



                  <input type="submit" class="btn btn-warning btn-lg font-weight-bold font-italic" style="width:200px" id="savebtn" value="Save" name="submit">
      
      </div>
</form>




      <script type="text/javascript">
            
      //Date picker
     
       var abc = 1;
       // Start add row process     
      $(document).on('click', '#add_row', function () {
        $(".unit")
        var xyz = $('#'+abc+'qty').val();
        if (xyz == '') {
          alert('pls fill Current row');
        }
        else{
        abc++;

        var rowLength = $('table').find('tbody tr').length;
        var rowHtml = '<tr row-id="' + (rowLength + 1) + '">';
            
        rowHtml += '<td><div class=""> <input type="text" class="form-control srno" value="' + (rowLength+1) + '" readonly></td>';
        rowHtml += '<td><input type="text" class="form-control item" name="item[]" onFocus="SearchItem(this)"   required></td>';
            rowHtml += '<td> <input type="text" class="form-control subgrade"  name="subgrade[]" readonly></td>';
        rowHtml += '<td><input type="text" class="form-control maingrade " name="maingrade[]" placeholder="" value="" readonly></td>';
            rowHtml += '<td><input type="text" class="form-control category " name="category[]" placeholder="" value="" readonly></td>';
            rowHtml += '<td><input type="text" class="form-control qty" name="qty[]" id="'+abc+'qty" placeholder="" required></td>';
            rowHtml += '<td><select class="form-control unit" name="unit[]" required style="height:39px"><option value="">Select</option> <option>Bag </option> <option>Book </option> <option>Cu.Mtr </option> <option>Cylinder </option> <option>Feet </option> <option>Gram </option><option>Kg </option><option>Liter </option><option>Meter </option><option>Nos </option><option>Pair </option><option>Pkt </option><option>Roll </option><option>Set </option><option>Sq.Ft </option><option>Sq.MM </option><option>Ton </option><option>Tractor/Truck </option></select></td>';
            rowHtml += '<td><input type="text" class="form-control i_code" name="i_code[]" readonly></td>';
            rowHtml += '<td><input type="text" class="form-control s_code" name="s_code[]" readonly></td>';
            rowHtml += '<td><input type="text" class="form-control m_code" name="m_code[]" readonly></td>';
            rowHtml += '<td><input type="text" class="form-control c_code" name="c_code[]" readonly></td>';
            
            
            
            
                              
            
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
    url: "getitem2.php",
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
   $(self).closest('tr').find('.i_code').val(ui.item.i_code);
   $(self).closest('tr').find('.s_code').val(ui.item.s_code);
   $(self).closest('tr').find('.m_code').val(ui.item.m_code);
   $(self).closest('tr').find('.c_code').val(ui.item.c_code);

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