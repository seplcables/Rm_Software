<?php include('..\..\..\dbcon.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Rubber Inward</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
			font-size: 17px;
		}
		#table1 th,#table1 td{
            border: 1px solid black;
        }
        #table1 th{
        	font-size: 16px;
        }
        #table1 input{
            border: none;
            box-shadow: none;
            outline: none;
            text-align: center;
        }
        #item{
        	width: 40% !important;
        }
        .HOME{
        	background-color: #ffcc00 !important;
    	}
    	.modal-lg{
    		max-width: 1000px;
    	}
	</style>
</head>
<body>
	<div class="container-fluid my-4">
		<div class="table-responsive container-fluid">
			<table class="table table-bordered table-striped" id="example" style="width:100%">
				<thead>
					<tr>
						<th>Receive Date</th>
						<th>Rmta</th>
						<th>Plant</th>
						<th>Party</th>
						<th>Invoice Date</th>
						<th>Invoice No.</th>
						<th>Total Amount</th>
						<th>Control</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$sql = "SELECT distinct a.receive_date,a.sr_no,a.receive_at,b.party_name,a.invoice_date,a.invoice_no,a.total_bill_amt FROM inward_com a LEFT OUTER JOIN rm_party_master b on b.pid= a.mat_from_party inner join inward_ind c on c.sr_no = a.sr_no inner join rm_item d on d.i_code = c.p_item WHERE receive_date >= '2022-03-14' and m_code = '174' and c.id not in(select inw_id from rubber_inward)";
						$run = sqlsrv_query($con,$sql);
						while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
						{
					?>
					<tr>
						<td class="rec_dte"><?php echo $row['receive_date']->format("d-M-y"); ?></td>
						<td><?php echo $row['sr_no']; ?></td>
						<td><?php echo $row['receive_at']; ?></td>
						<td><?php echo $row['party_name']; ?></td>
						<td><?php echo $row['invoice_date']->format("d-M-y"); ?></td>
						<td><?php echo $row['invoice_no']; ?></td>
						<td><?php echo $row['total_bill_amt']; ?></td>
						<td><button type="button" class="btn btn-info text-white fw-bold px-2 py-1 showData" id="<?php echo $row['sr_no']; ?>">Show</button></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

	 <!-----------------------------------------   Edit Modal ----------------------------------------->
     <div class="modal fade small" id="edit_data" aria-labelledby="edit_data" aria-hidden="true" tabindex="-1">
            
        <!----------------- Scrollable modal --------------------------->
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header font-weight-bold bg-faded">
                    <h4>Add</h4>
                   <button type="button" class="btn-bs-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body" id="edit_modal">
                    <div id="edit">
                    	<input type="hidden" name="rec_dte" id="rec_dte" form="form">
                       <form action="inward_db.php" id="form" method="post">
                       	
                       </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="save" class="btn btn-primary btn-md px-4" id="save" form="form">Save</button>
                </div>
            </div>
        </div>
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
		 		'pageLength','excel',
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

	 $(document).on('click','.showData', function(){
            var id = $(this).attr("id"); 
            var rec_dte = $(this).closest('tr').find('.rec_dte').text();
            $("#rec_dte").val(rec_dte);
             $.ajax({
                url:"getdata.php",
                method:"POST",
                data:{id:id},
                success:function(data)
                {
	                $('#form').html(data);
	                $('#edit_data').modal('show');
                }
            });
        });
</script>