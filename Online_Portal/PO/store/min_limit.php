<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Min_Qnty_Limit</title>
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
        #trow{
        background-color: #ffb3ff;
        text-align: center;
        }
        </style>
    </head>
    <body>
        <div class="container-fluid">
        <div class="row container-fluid">
            <a href="..\..\dashboard.php" class="btn btn-warning"><<< Back</a>
            <a href="max_limit.php" class="btn btn-primary">Max Ord Qnty</a>
        </div>
        <br />
        <div class="table-responsive ml-1">
            <table class="table table-bordered table-striped table-sm" id="example" style="width:100%">
                <thead>
                    <tr id="trow">
                        <th>Category</th>
                        <th>Main_Grade</th>
                        <th>Sub_Grade</th>
                        <th>Item</th>
                        <th>min_limit</th>
                        <th>Live_stk</th>
                        <th>Diff</th>
                        
                    </tr>
                </thead>
            </table>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
        $('#example').DataTable( {
            "processing": true,
            "dom": 'Bfrtip',
        "ajax": {
                "url" : "get_minLimit.php",
                "dataSrc" : ""
        },

        "columns": [
        { data: "cat", width: "12%" },
        { data: "m_grade", width: "18%" },
        { data: "s_grade", width: "18%" },
        { data: "data.item", width: "30%" },
        { data: "data.min_limit", width: "8%" },
        { data: "qty", width: "8%" },
        { data: "diff", width: "6%" },
        
        ],
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength', 'excel', 'print'
        ]
        } );
        });
        </script>
    </div>
    </body>
</html>
