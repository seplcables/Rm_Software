<?php
	include('..\..\..\dbcon.php');
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
		/*.r1 input{
			width: 100%;
		}
		table{
			width: 100%;
		}
		table th{
			text-align: center;
			font-size: 17px;
			font-family: Bahnschrift Condensed;
		}
		tbody td{
			padding: 3px 3px 3px 6px !important;
		}
		.show_inv{
			padding: 2px 6px;
		}*/
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row m-3 r1">
			<div class="col-lg-3"><input class="form-control" type="'text" name="from" placeholder="From Date"></div>
			<div class="col-lg-3"><input class="form-control" type="'text" name="to" placeholder="To Date"></div>
			<div class="col-lg-6"><a href="../../dashboard.php" class="btn btn-warning px-3 mx-2 float-end text-secondary"><b>Back</b></a><button class="btn btn-warning px-3 mx-2 float-end text-secondary"><b>Filter</b></button></div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered" id="example">
				<thead>
					<tr style="background-color: #00bcd4; color: white;">
						<th>Pay Date</th>
						<th>Trans Id</th>
						<th>Pay Mode</th>
						<th>RMTA</th>
						<th>Party</th>
						<th>Invoice No</th>
						<th>Invoice Date</th>
						<th>Pay Amount</th>
						<th>Control</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$query = "SELECT pay_date,trans_id,pay_mode, concat(sr_no,'-',receive_at) as rmta,b.party_name,invoice_no,invoice_date,payment_amt
						FROM payment_table a left outer join rm_party_master b on b.pid = a.party";
						$run = sqlsrv_query($con,$query);
			          $bal_amt = 0;
			          while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
			          {
			           /* $sql1="SELECT sum(payment_amt) as total_pay from payment_table where concat(sr_no,'-',receive_at)='".$row['rmta']."'";
			            $run1=sqlsrv_query($con,$sql1);
			            $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);

			            $bal = $row["bill_amt"] - $row1["total_pay"];
			            $bal_amt += $bal;*/
			          ?>
					<tr style="background-color: #9e9e9e1f;">
						<td><?php echo $row["pay_date"]->format('d.M.y'); ?></td>
						<td><?php echo $row["trans_id"]; ?></td>
						<td><?php echo $row["pay_mode"]; ?></td>
						<td><?php echo $row["rmta"]; ?></td>
						<td><?php echo $row["party_name"]; ?></td>
						<td><?php echo $row["invoice_no"]; ?></td>
						<td><?php echo $row["invoice_date"]->format('d.M.y'); ?></td>
						<td><?php echo $row["payment_amt"]; ?></td>
						<td class="text-center"><input type="button" name="show_inv" class="btn btn-success show_inv" value="Show Inv"></td>
					</tr>
					<?php
			          }
			         ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
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
 			  		$( 'input', this.header() ).on( 'keyup change clear', function (){
               		  if( that.search() !== this.value ) {
                    	 that
                     	 .search( this.value )
                     	 .draw();
                   		}
                	});
            	});
         	}
      	});          
	});
     
</script>