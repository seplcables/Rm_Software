<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Purchase_Report</title>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />

    <style type="text/css">
        ::-webkit-input-placeholder { /* Edge */
                color: #b3b3cc;
                font-style: italic;
                /*font-size: 12px;*/
                font-family: "Times New Roman", Times, serif;
            }
    #trow{
    border-style: double;
 border-color: red;   
 background-color: #f0d6a3;    
color: black;
font-size: 12px;
font-family:Sitka Text;
text-align: center;
    }
    thead input {
    width: 100%;
    padding: 2px;
    box-sizing: border-box;
}

   
        </style>
</head>
<body>
    <div class="row">
            <a href="..\dashboard.php" class="btn btn-warning"><<< Back</a>
            <a href="report-old.php" class="btn btn-primary">Load All Data</a>
        </div>
        <br />
        <div class="table-responsive ml-1">
            <table class="table table-bordered table-striped table-sm display nowrap" id="example" style="width:200%">
                <thead id="t_head">
                    <tr id="trow">
                        <th>Sr.No</th>
                        <th>Receive_at</th>
                         <th>Po_No</th>
                         <th>Receive_dte</th>
                         <th>I_no</th>
                        <th>I_date</th>
                        <th>Party</th>
                        <th>Ord_By</th>
                         <th>Category</th>
                         <th>Main_grade</th>
                         <th>Sub_Grdae</th>
                        <th>Item Description</th>
                        <th>plant</th>
                        <th>Project</th>
                        <th>Job No</th>
                         <th>Remarks</th>
                         <th>PKG</th>
                         <th>Unit</th>
                        <th>Qnty</th>
                        <th>Rate</th>
                        <th>Basic_amt</th>
                        <th>GST Type</th>
                        <th>GST Amt</th>
                        <th>Total_bill_amt</th>
                        <th>Payable_Amt</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr id="trow">
                        <th>Sr.No</th>
                        <th>Receive_at</th>
                         <th>Po_No</th>
                         <th>Receive_dte</th>
                         <th>I_no</th>
                        <th>I_date</th>
                        <th>Party</th>
                        <th>Ord_By</th>
                         <th>Category</th>
                         <th>Main_grade</th>
                         <th>Sub_Grdae</th>
                        <th>Item Description</th>
                        <th>plant</th>
                        <th>Project</th>
                        <th>Job No</th>
                         <th>Remarks</th>
                         <th>PKG</th>
                         <th>Unit</th>
                        <th>Qnty</th>
                        <th>Rate</th>
                        <th>Basic_amt</th>
                        <th>GST Type</th>
                        <th>GST Amt</th>
                        <th>Total_bill_amt</th>
                        <th>Payable_Amt</th>
                    </tr>
                </tfoot>
               
            </table>
        </div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function () {
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="" placeholder="'+title+'" />' );
    });
               var table = $('#example').DataTable({  
            
            processing: true,
            serverSide: true,
            "order": [[ 0, "desc" ]],
            "dom": 'Bfrtip',
            ajax: 'getreport.php',
              
             lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength','excel',
            {
                 extend: 'excel',
                 text: 'Excel All',
                "action": newexportaction
            },
        ],
         
            initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

        }


        });

            function newexportaction(e, dt, button, config) {
             var self = this;
             var oldStart = dt.settings()[0]._iDisplayStart;
             dt.one('preXhr', function (e, s, data) {
                 // Just this once, load all data from the server...
                 data.start = 0;
                 data.length = 2147483647;
                 dt.one('preDraw', function (e, settings) 
                 {
                     // Call the original action function
                    if (button[0].className.indexOf('buttons-excel') >= 0) 
                     {
                            $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                    } 
                     dt.one('preXhr', function (e, s, data) {
                         settings._iDisplayStart = oldStart;
                         data.start = oldStart;
                     });
                     // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                     setTimeout(dt.ajax.reload, 0);
                     // Prevent rendering of the full data to the DOM
                     return false;
                 });
             });
             // Requery the server with the new one-time export settings
             dt.ajax.reload();
         }
});
</script>