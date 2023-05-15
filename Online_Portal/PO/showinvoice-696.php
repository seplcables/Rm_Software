<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Show_Invoice</title>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js"></script>

        <script src="https://momentjs.com/downloads/moment.min.js"></script>
        <script src="https://cdn.datatables.net/plug-ins/1.10.13/sorting/datetime-moment.js"></script>
        <!-- jQuery UI -->
    
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


        <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />
        <style type="text/css">
            
        #trow{
        border-style: double;
     border-color: red;   
     background-color: #f0d6a3;    
    color: black;
    font-size: 12px;
    font-family:Sitka Text;
    text-align: center;
        }
        #not_edit{
        border: 1px solid #999999;
        background-color: #cccccc;
        color: #666666;
        margin-top: 4px;
    }
    .show_inv{
             margin-top: 4px;
    }
    .HOME{
        background-color: #ffcc00 !important;
    }
     .purchase_entry{
        background-color: #00ff80 !important;
    }
     .view_all{
        background-color: #0066ff !important;
        color: white !important;
    }
    .processrow{
        font-weight: bold;
        background-color: #bfc7c1;
        border-color: red;
        text-align: center;
    }
        
        </style>
    </head>
    <body>
        <h5 class="bg-warning" align="center">SEARCH PURCHASE DETAILS</h5>
        <div class="row ml-4">

            <input type="hidden" name="usser" id="usser" value="<?=!isset($_SESSION['pur_user']) ? "noo" : "yees"?>" />
            </div>
        <br />
        <div class="table-responsive ml-1 container-fluid">
            <table class="table table-bordered table-striped table-sm display" id="example" style="width:100%">
                <thead id="t_head">
                    <tr id="trow">
                        <th>Receive_date</th>
                        <th>Rmta</th>
                         <th>plant</th>
                         <th>Party</th>
                         <th>Invoice_Date</th>
                         <th>Invoice_No</th>
                        <th>Total_Bill_Amt</th>
                        <th>Invoice PDF TimeStamp</th>
                        <th>Cntrl</th>
                    </tr>
                </thead>
               
            </table>
        </div>
            <script type="text/javascript">

        function getOptions(data, type, full) {
        var optionLink ='';
        var x = $("#usser").val();
      if (x == 'yees') { 
        if ((data.bill_receive && data.receive_at != 'baroda') || data.bill_approve) {

            optionLink +=  "<button type=\"button\" id=\"not_edit\" onclick=\"notEditable()\" class=\"btn btn-sm not_edit\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Not Editable\">Edit</button>";
       }
      else{   
    optionLink = "<a class=\"btn btn-sm btn-primary\" href=\"purchase_entry_edit-696.php?srno=" + data.sr_no + "&plant=" + data.receive_at + "\">Edit</a> " ;
    
    }
}
    optionLink += "<input type=\"button\" class=\"btn btn-sm btn-warning show_data\" name=\"show\" value=\"Show\" id=" + data.sr_no + data.receive_at + " />";
        if (data.invoice_img != null && data.invoice_img != 0) {
        optionLink += " <input type=\"button\" class=\"btn btn-sm btn-success show_inv\" name=\"inv\" value=\"See Invoice\" id=" + data.invoice_img + " />";
       }
       else{
                optionLink += " <button type=\"button\" id=\"not_edit\" onclick=\"notupload()\" class=\"btn btn-sm not_edit\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Not Upload\">Not Upload</button>";
       }
        return optionLink == 0 ? '' : optionLink;
 }
 
$(document).ready(function() {
    var table = $('#example').DataTable( {
            dom: 'Bfrtip',
            lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
           buttons: [
            'pageLength', 'excel',
                         {
                text: 'HOME',"className": 'HOME',
                action: function () { 
                  window.open("../dashboard.php","_self");  
               }
             },
             {
                text: 'PURCHASE ENTRY',"className": 'purchase_entry',
                action: function () { 
                  window.open("inward_field-696.php","_self");  
               }
             },
             {
                text: 'VIEW ALL',"className": 'view_all',
                action: function () { 
                    $("#example").html('<tr class="processrow"><td colspan="7">processing.....</td></tr>');
                  $.ajax({
                            url: "serch_purchaseAll-696.php",
                            success: function (data) {
                                $("#example").html(data);
                            }
                            });  
               }
             }

           ],

            "ajax": {
                url: 'serch_purchase-696.php',
                "dataSrc" : ""
            },

        "columns": [
            {
            data: "receive_date.date",
            type: "date",
            render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
            },
            { "data": "sr_no" },
            { "data": "receive_at" },
            { "data": "party_name" },
            {
            data: "invoice_date.date",
            type: "date",
            render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
            },
            { "data": "invoice_no" },
            { "data": "total_bill_amt" },
            {
            data: "Invoice_img_timestamp.date",
            type: "date",
            render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY h:m:s') : ''; }
            },
            {   "mData": null,
                    "bSortable": false,
                    "mRender":  function(data, type, full) {
                        return getOptions(data, type, full);
                    }
                }

        ],
        "order": [[0, 'desc']]
    });
     
$(document).on('click', '.show_data', function(){
           var rmta = $(this).attr("id");  
           
           $.ajax({
                url:"fetchPurchaseOnModal.php",
                method:"POST",
                data:{rmta:rmta},
                success:function(data)
                {
                $('#order_table').html(data);
                $('#item_modal').modal('show');
                }
                });
       });
});

      function notEditable()
            {
                alert("बिल भेजने के बाद आप PURCHASE में बदलाव नहीं कर सकते हैं");
            }
            function notupload()
            {
                alert("This Invoice is Not Uploaded");
            }


            $(document).on('click', '.show_inv', function()
            {
             var x = $(this).attr("id"); 
             
            newwindow=window.open('invoice_img/'+x,'_blank','height=500,width=500,left=300,top=50');
            if (window.focus) {newwindow.focus()}
            return false;
            });
    </script>

 <div class="modal fade bd-example-modal-lg" id="item_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title font-weight-bold font-italic">Item List</h4>
              <button type="button" class="close font-weight-bold" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="order_table">
              <!-- Dynamic Table from ajax load -->

            </div>
            
          </div>
        </div>
      </div>


    </body>
</html>