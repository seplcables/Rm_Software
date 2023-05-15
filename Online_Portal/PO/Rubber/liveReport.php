<?php include('..\..\..\dbcon.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Live Report</title>
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
			font-size: 17px;
		}
		.HOME{
        	background-color: #ffcc00 !important;
    	}
        .item:hover{
        cursor: pointer;
        background-color: #e7d9d991 !important;
    }
	</style>
</head>
<body>
	<div class="container-fluid my-4">
		<div class="table-responsive container-fluid">
			<table class="table table-bordered table-striped" id="example" style="width:100%">
				<thead>
					<tr>
						<th>ITEM</th>
						<th>SUB_GRADE</th>
						<th>INWARD QTY</th>
						<th>ISSUE QTY</th>
						<th>BALANCE</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					
					$sql = "SELECT a.item as icode,b.item,c.sub_grade,sum(qnty) as inwQty from rubber_inward a left outer join rm_item b on a.item = b.i_code left outer join rm_s_grade c on b.s_code = c.s_code where a.Status = 1 group by a.item,b.item,c.sub_grade"; 
					$run = sqlsrv_query($con,$sql);
						while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)){ 
								$sql2 = "SELECT SUM(weight) as issQty from rubber_issue where item = '".$row['icode']."'";
								$run2 = sqlsrv_query($con,$sql2);
								$row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);

								$bal = $row['inwQty'] - $row2['issQty'];	
								if ($bal <=0) {
									continue;
								}

					?>
					<tr>
						<td><?php echo $row['item']; ?></td>
						<td><?php echo $row['sub_grade']; ?></td>
						<td><?php echo $row['inwQty']; ?></td>
						<td><?php echo $row2['issQty']; ?></td>
						<td><?php echo round($bal,2); ?></td>
						<td align="center"><button class="btn btn-warning item" id="<?php echo $row['icode']; ?>">View</button></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
		$(document).ready(function(){
		      var table = $('#example').DataTable({
		    	"processing": true,
				 dom: 'Bfrtip',
				 ordering: true,
            
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


            function fetchData(id)
            {
            var fetch_data = '';
            $.ajax({
            url:"getLiveStock.php",
            method:"POST",
            async: false,
            data:{id:id},
            success:function(data)
            {
            fetch_data = data;
            }
            });   
            return fetch_data;
            }
         $(document).on("click",".item",function(){
             var id = $(this).attr('id');
             $(".modal-body").html(fetchData(id));
             $("#showIssue").modal('show');
         });   
});
    
</script>

<!-- Modal -->
<div class="modal fade" id="showIssue" tabindex="-1" aria-labelledby="showIssueLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="showIssueLabel">IssueList</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      </div>
    </div>
  </div>
</div>