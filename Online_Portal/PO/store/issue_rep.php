<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Issue_Rep</title>
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
        <div class="row">
            <a href="..\..\dashboard.php" class="btn btn-warning"><<< Back</a>
        </div>
        <br />
        <div class="table-responsive ml-1">
            <table class="table table-bordered table-striped table-sm" id="example" style="width:100%">
                <thead>
                    <tr id="trow">
                        <th>Iss_Date</th>
                        <th>Category</th>
                        <th>Main_Grade</th>
                        <th>Sub_Grade</th>
                        <th>Item</th>
                        <th>issue_to</th>
                        <th>McNo</th>
                        <th>Dpnt</th>
                        <th>Plant</th>
                        <th>superwizer</th>
                        <th>Issued_by</th>
                        <th>Qnty</th>
                        <th>Rate</th>
                        <th>Unit</th>
						<th>Ise_cat</th>
                        <th>OPS</th>
                        <th>Remarks</th>
						<th>Del</th>
                    </tr>
                </thead>
            </table>
        </div>
        <script type="text/javascript">
		 function getOptions(data, type, full) {
        var optionLink ='';
    optionLink = "<a class=\"btn btn-xs btn-danger\" href=\"deleteissue.php?sid=" + data.data.id + "\" onclick=\"return confirm('Are you sure you want to Delete?')\">Delete</a> " ;   
        return optionLink == 0 ? '' : optionLink;
    }
	
            $(document).ready(function() {
        $('#example').DataTable( {
            "processing": true,
            "order": [[ 0, "desc" ]],
            "dom": 'Bfrtip',
        "ajax": {
                "url" : "getissuerep.php",
                "dataSrc" : ""
        },

        "columns": [
        {
        data: "data.issue_date.date", width: "6%",
        type: "date",
        render: function (data, type, row) { return data ? moment(data).format('DD.MMM.YY') : ''; }
        },
        { data: "data.category", width: "8%" },
        { data: "data.main_grade", width: "8%" },
        { data: "data.sub_grade", width: "8%" },
        { data: "data.item", width: "12%" },
        { data: "data.issue_to", width: "4%" },
        { data: "data.mc_no", width: "4%" },
        { data: "data.dpnt", width: "6%" },
        { data: "data.plant_name", width: "5%" },
        { data: "data.super_wizer", width: "6%" },
        { data: "data.issued_by", width: "6%" },
        { data: "data.qnty", width: "5%" },
        { data: "rte", width: "5%" },
        { data: "data.unit", width: "4%" },
		{ data: "data.issue_cat", width: "4%" },
        { data: "data.old_part_status", width: "3%" },
        { data: "data.remarks", width: "13%" },
		{   "mData": null, width: "3%",
                    "bSortable": false,
                    "mRender":  function(data, type, full) {
                        return getOptions(data, type, full);
                    }
                },
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
    </body>
</html>
