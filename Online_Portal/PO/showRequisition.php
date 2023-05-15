<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Search_Requisition</title>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <!------------------------ BT-5 CSS -------------------------------------->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <!------------------------ BT-5 JS -------------------------------------->
               <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
               <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

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
            ::-webkit-input-placeholder { /* Edge */
                    color: #b3b3cc;
                    font-style: italic;
                    /*font-size: 12px;*/
                    font-family: "Times New Roman", Times, serif;
                }
        #trow{
        background-color: #046bd1;
        text-align: center;
        }
        thead input {
        width: 100%;
        padding: 2px;
        box-sizing: border-box;
    }
    #not_edit{
        border: 1px solid #999999;
        background-color: #cccccc;
        color: #666666;
    }
   
        </style>
    </head>
    <body class="container-fluid">
       
        <div class="table-responsive mt-1">
            <a href="..\dashboard.php" class="btn btn-warning mb-1"><<< Back</a>
            <table class="table table-bordered table-striped table-sm" id="example" style="width:100%">
                <thead>
                    <tr id="trow">
                        <th>rNo</th>
                        <th>Date</th>
                         <th>Indentor</th>
                         <th>Department</th>
                         <th>Req_Date</th>
                         <th>Remarks</th>
                        <th>Control</th>
                        
                    </tr>
                </thead>
               
            </table>
        </div>
        <script type="text/javascript">
            // Function of Control Button
        function getOptions(data, type, full) {
        var optionLink ='';
        optionLink = "<a class=\"btn btn-sm btn-danger\" href=\"pdfDataOfRequisition.php?sid=" + data.id + "\">pdf</a> " ;
        if (data.isPurchaseEntry) {  
          optionLink +=  "<button type=\"button\" id=\"not_edit\" onclick=\"notEditable()\" class=\"btn btn-sm\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Not Editable\">Edit</button>"; 
          }
          else{
                optionLink +=  "<a class=\"btn btn-sm btn-primary\" href=\"Requisition_edit.php?id=" + data.id + "\">Edit</a> " ; 
          } 
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
        data: "createdAt.date", width: "10%",
        type: "date",
        render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
        },
        { data: "indentor", width: "10%" },
        { data: "indentor_dpnt", width: "15%" },
        {
        data: "mat_require_dte.date", width: "10%",
        type: "date",
        render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
        },
        { data: "remarks", width: "30%" },
        {   "mData": null, width: "20%",
                    "bSortable": false,
                    "mRender":  function(data, type, full) {
                        return getOptions(data, type, full);
                    }
                }
            ],
            "ajax": {
                url: 'serch_Requisition.php',
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
            function notEditable()
            {
                alert("आप PURCHASE ENTRY  के बाद PO-EDIT नहीं कर सकते हैं");
            }

        </script>
    </body>
</html>