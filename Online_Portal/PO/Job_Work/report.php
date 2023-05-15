<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Report_Jw</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />


        <script src="https://momentjs.com/downloads/moment.min.js"></script>
        <script src="https://cdn.datatables.net/plug-ins/1.10.13/sorting/datetime-moment.js"></script>

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
        background-color: #ffb3ff;
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
            <a href="..\..\dashboard.php" class="btn btn-warning"><<< Back</a>
        </div>
        <br />
        <div class="table-responsive ml-1">
            <table class="table table-bordered table-striped table-sm" id="example" style="width:100%">
                <thead>
                    <tr id="trow">
                        <th>Ch_No</th>
                        <th>Date</th>
                        <th>Consignee_Name</th>
                        <th>Goods_Desc</th>
                        <th>Qnty</th>
                        <th>Unit</th>
                        <th>Due_qty</th>
                        <th>Status</th>
                        <th>In_date</th>
                        <th>In_qnty</th>
                        <th>Rate</th>
                        <th>basic</th>
                        <th>tax.amt</th>
                        <th>cgst/igst</th>
                        <th>cg/ig amt</th>
                        <th>Total_Bill_Amt</th>

                        
                        
                    </tr>
                </thead>
               
            </table>
        </div>
        <script type="text/javascript">
        
        $(document).ready(function() {       
                // Setup - add a text input to each footer cell
    $('#example thead th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="" placeholder="'+title+'" />' );
    });
           var table = $('#example').DataTable({  
            

            "processing": true,
            "ordering": false,
            "dom": 'Bfrtip',
             
            "columns": [
                { data: "data.ch_no", width: "4%" },
        {
        data: "data.challan_date.date", width: "6%",
        type: "date",
        render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
        },
        { data: "data.consignee_name", width: "15%" },
        { data: "data.goods_desc", width: "10%" },
        { data: "data.qnty", width: "6%" },
        { data: "data.unit", width: "4%" },
        { data: "due_qnty", width: "5%" },
        { data: "sts", width: "5%" },
        {
        data: "data.in_date.date", width: "6%",
        type: "date",
        render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
        },
        { data: "data.in_qnty", width: "6%" },
        { data: "data.rate", width: "6%" },        
        { data: "data.basic_value", width: "5%" },
        { data: "data.total_tax_amt", width: "5%" },
        { data: "data.gst_per", width: "4%" },
        { data: "data.gst_amt", width: "5%" },
        { data: "data.total_bill_amt", width: "8%" }
        
        
            ],
            "ajax": {
                url: 'getrep.php',
                "dataSrc" : ""
            },
              
             lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength', 'excel', 'print'
        ],
         
            initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.header() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

        }


        });



           

});

    
        </script>
    </body>
</html>