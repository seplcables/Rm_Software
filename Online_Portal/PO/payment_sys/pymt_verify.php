<?php include('..\..\..\dbcon.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Payment Verification</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
		.table th{
			background-color: #607d8b7d !important;
		}
		.table td{
			padding: 3px 8px;
		}
    	.table{
    		width: 100%;
    	}
	</style>
</head>
<body>
	<div class="container-fluid mt-3">
		<table class="table table-bordered table-striped" id="example">
			<thead>
				<tr>
					<th>Rmta</th>
					<th>Party</th>
					<th>Invoice Date</th>
					<th>Invoice No</th>
					<th>Total Bill Amt</th>
					<th>Po No</th>
					<th>Po Date</th>
					<th>Po Value</th>
					<th>Adv Amt</th>
					<th>Pymt Approve By</th>
					<th>Material Approve By</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$sql = "SELECT CONCAT(a.sr_no,'_',a.receive_at) as rmta,a.sr_no,b.party_name,a.invoice_date,a.invoice_no,a.total_bill_amt,a.approve_by from inward_com a left outer join rm_party_master b on a.mat_from_party = b.pid where invoice_date > '2022-01-01' order by invoice_date asc";
					$run = sqlsrv_query($con,$sql);
					while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)){
						$sql1 = "SELECT top 1 po_no,format(po_date, 'dd-MMM-yy') as po_date,po_value,adv_amt from po_entry_head a join inward_ind b on a.po_no = b.p_po_no where b.sr_no = '".$row['sr_no']."' and b.receive_at = 'halol'";
						$run1 = sqlsrv_query($con,$sql1);
						$row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
				?>
				<tr>
					<td><?php echo $row['rmta']; ?></td>
					<td><?php echo $row['party_name']; ?></td>
					<td><?php echo $row['invoice_date']->format('d-m-Y'); ?></td>
					<td><?php echo $row['invoice_no']; ?></td>
					<td><?php echo $row['total_bill_amt']; ?></td>
					<td><?php echo $row1['po_no']; ?></td>
					<td><?php echo $row1['po_date']; ?></td>
					<td><?php echo $row1['po_value']; ?></td>
					<td><?php echo $row1['adv_amt']; ?></td>
					<td><?php echo $row['approve_by']; ?></td>
					<td></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		      var table = $('#example').DataTable({
		    	"processing": true,
				 dom: 'Bfrtip',
				 ordering: false,
            
		 	lengthMenu: [
            	[ 10, 25, 50, -1 ],
            	[ '10 rows', '25 rows', '50 rows', 'Show all' ]
        	],
			 buttons: [
		 		'pageLength', 'excel',
		 		// Customize button datatable
		 		{
                text: 'HOME',"className": 'HOME',

                action: function () { 
                  window.open("../../dashboard.php","_self");  
               }
             },
        	]
    	});
    	
 	 });
</script>