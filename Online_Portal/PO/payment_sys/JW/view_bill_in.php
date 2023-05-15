<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <title>add_data</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
           <script src="https://momentjs.com/downloads/moment.min.js"></script>
           <script src="https://cdn.datatables.net/plug-ins/1.10.13/sorting/datetime-moment.js"></script>
</head>
<body>
    <div class="row">
          <a href="bill_in.php" class="btn btn-warning">Back</a>
    </div>
    <br />
    <div class="table-responsive ml-1">
      <table class="table table-bordered table-striped table-sm" id="example" style="width:100%">
        <thead>
            <tr>
                <th>Receive Date</th>
                <th>Rmta</th>
                <th>Party</th>
                <th>Bill_no</th>
                <th>Bill_amt</th>
                <th>Memo_no</th>
            </tr>
        </thead>
    </table>
</div>

 <script type="text/javascript">
 	$(document).ready(function() {
    $('#example').DataTable( {
        "ajax": {
        		"url" : "ajax.php",
        		"dataSrc" : ""
        },

        "columns": [
            {
            data: "receive_time.date", width: "10%",
            type: "date",
            render: function (data, type, row) { return data ? moment(data).format('DD.MMM.YY') : ''; }
            },
            { data: "id", width: "10%" },
            { data: "consignee_name", width: "25%" },
            { data: "bill_no", width: "5%" },
            { data: "total_bill_amt", width: "10%" },
            { data: "memo_no", width: "10%" }
        ]
    } );
});

 </script>

 </body>
</html>
