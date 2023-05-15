<!DOCTYPE html>
<html>
  <head>
    <title>pymt_report</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!------------------------ BT-5 JS -------------------------------------->
   <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <!------------------------ BT-5 JS -------------------------------------->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<!----------------------- jQuery UI --------------------------->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">

      input[type=date]{
        background-color: #7ce3ce2e;
      }
    	th, td {white-space: normal;}

	.table
	{
		width: 100%;
		border-collapse: collapse;
	}
	.table td,.table th
	{
		padding: 5px 10px;
		border: 1px solid #ddd;
		text-align: center;
		font-size: 14px;
	}
	.table th
	{
		background-color: darkblue;
		color: white;
	}
</style>
</head>
<body>
<div class="mt-2 table-responsive div1 container-fluid">
      <div class="row">
        
        <div class="col-md-2">
          <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
        </div>
        <div class="col-md-2">
          <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
        </div>
        <div class="col-md-1 d-flex">
          <input type="button" name="filter" id="filter" value="Get All Data" class="btn btn-info px-4 text-white" />
          <a href="../../dashboard.php" class="btn btn-warning px-4 mx-3 text-white">Back</a>
        </div>
      </div>
	<br>
	
		<table class="table table-hover table-warning" id="exampleone">
			<thead id="thead">
				<tr class="head_part">
	              <th>Sr No</th>
	              <th>Party</th>
	              <th>Bill no</th>
	              <th>Bill date</th>
	              <th>Total pay amt</th>
	              <th>Bill amt</th>
	              <th>Pymt Date</th>
	              <th>Pymt amt</th>
	              <th>pndg_amt</th>
	              <th>Trans id</th>
	              <th>Remark</th>
	            </tr>
			</thead>
			<tbody>
			</tbody>
			
		</table>
	
</div>

<!-- jQuery UI -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
	$('#filter').click(function(){
		var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
	$("#exampleone").html('');
			$.ajax({
			type: "POST",
			url: "getPymtReport.php",
			data:{from_date:from_date, to_date:to_date},
			success: function (data) {
			$("#exampleone").html(data);
			},
			});
			});
	$("#from_date,#to_date").on("change",function(){
		$("#filter").val("Get Data");

	});

</script>
</body>
</html>