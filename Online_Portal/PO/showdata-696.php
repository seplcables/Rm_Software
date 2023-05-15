<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Search_Po</title>
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
    .HOME{
        background-color: #ffcc00 !important;
    }
     .po_entry{
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
        <h3 class="bg-primary" align="center">PO SEARCH - 696</h3>
        <br />
        <div class="table-responsive ml-1 container-fluid">
            <table class="table table-bordered table-striped table-sm" id="example" style="width:100%">
                <thead>
                    <tr id="trow">
                        <th>Po_Id</th>
                        <th>Date</th>
                         <th>Party</th>
                         <th>Po_Gen_By</th>
                         <th>Department</th>
                         <th>PO Value</th>
                        <th>Control</th>
                        
                    </tr>
                </thead>
               
            </table>
        </div>
        <script type="text/javascript">
            // Function of Control Button
        function getOptions(data, type, full)
        {
            var optionLink ='';
            optionLink = "<a class=\"btn btn-sm btn-danger\" href=\"pdfdata-696.php?sid=" + data.id + "\">pdf</a> " ;
            if (data.isPurchaseEntry) {  
              optionLink +=  "<button type=\"button\" id=\"not_edit\" onclick=\"notEditable()\" class=\"btn btn-sm\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Not Editable\">Edit</button>"; 
              }
              else{
                    optionLink +=  "<a class=\"btn btn-sm btn-primary\" href=\"po_entry_edit-696.php?id=" + data.id + "\">Edit</a> " ; 
              } 
            optionLink += "<a class=\"btn btn-sm btn-info\" href=\"pdfdata-landscape-696.php?sid=" + data.id + "\">New pdf</a> " ;
            return optionLink == 0 ? '' : optionLink;        
        }
            $(document).ready(function() {
                // Setup - add a text input to each footer cell
        $('#example thead th').each( function () 
        {
            var title = $(this).text();
            $(this).html( '<input type="text" class="" placeholder="'+title+'" />' );
        });
        var table = $('#example').DataTable(
        {  
            

            "processing": true,
            "ordering": false,
            "dom": 'Bfrtip',
             
            "columns": [
                { data: "id", width: "6%" },
                {
                    data: "po_date.date", width: "15%",
                    type: "date",
                    render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
                },
                { data: "party_name", width: "30%" },
                { data: "po_gen_by", width: "20%" },
                { data: "depart_ment", width: "10%" },
                { data: "po_value", width: "10%" },
                { "mData": null, width: "15%",
                    "bSortable": false,
                    "mRender":  function(data, type, full) 
                    {
                        return getOptions(data, type, full);
                    }
                }
            ],
            "ajax": {
                url: 'serch_po-696.php',
                "dataSrc" : ""
            },
              
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
                text: 'PO ENTRY',"className": 'po_entry',
                action: function () { 
                  window.open("adddata-696.php","_self");  
               }
             },
             {
                text: 'VIEW ALL',"className": 'view_all',
                action: function () { 
                    $("#example").html('<tr class="processrow"><td colspan="6">processing.....</td></tr>');
                  $.ajax({
                            url: "serch_poAll-696.php",
                            success: function (data) {
                                $("#example").html(data);
                            }
                            });  
               }
             }
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