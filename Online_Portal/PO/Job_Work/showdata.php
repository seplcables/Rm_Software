<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Search_Jw</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
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
                        <th>Chln_No</th>
                        <th>Date</th>
                        <th>Consignee_Name</th>
                        <th>Goods_Desc</th>
                        <th>Qnty</th>
                        <th>Unit</th>
                        <th>Value</th>
                        <th>Vehicle_No</th>
                        <th>days</th>
                        <th>CreatedBy</th>
                        <th>Control</th>
                        
                    </tr>
                </thead>
               
            </table>
        </div>
        <script type="text/javascript">
            // Function of Control Button
            function getOptions(data, type, full) {
        var optionLink ='';
    optionLink = "<a class=\"btn btn-sm btn-success\" href=\"edit_jw.php?sid=" + data.id + "\">Edit</a> " ;
    optionLink += "<a class=\"btn btn-sm btn-danger\" href=\"pdfdata.php?sid=" + data.id + "\">pdf</a> " ;
    optionLink +=  "<a class=\"btn btn-sm btn-primary\" href=\"jw_return.php?sid=" + data.id + "\">return</a> " ;   
        return optionLink == 0 ? '' : optionLink;
    }
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
                { data: "id", width: "5%" },
        {
        data: "challan_date.date", width: "8%",
        type: "date",
        render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
        },
        { data: "consignee_name", width: "20%" },
        { data: "goods_desc", width: "12%" },
        { data: "qnty", width: "8%" },
        { data: "unit", width: "8%" },
        { data: "basic_val", width: "10%" },
        { data: "vehicle_no", width: "8%" },
        { data: "expected_receive_days", width: "5%" },
        { data: "createdBy", width: "6%" },
        {   "mData": null, width: "10%",
                    "bSortable": false,
                    "mRender":  function(data, type, full) {
                        return getOptions(data, type, full);
                    }
                }
            ],
            "ajax": {
                url: 'getdata.php',
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