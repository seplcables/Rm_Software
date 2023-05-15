<?php include('..\..\..\dbcon.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Issue Report</title>
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
		#example td{
			padding: 3px 8px;
		}
		.HOME{
        	background-color: #ffcc00 !important;
    	}
    	#table1{
    		width: 100%;
    	}
    	/*#table1 th,#table1 td{
          border: 1px solid black;
          padding: 2px 8px;
      }*/
      #table1 th{
      	font-size: 16px;
      }
      #table1 input{
          border: none;
          box-shadow: none;
          outline: none;
          text-align: center;
      }
      .modal-body{
      	max-height: 500px;
      	overflow-y: auto;
      }
	</style>
</head>
<body>
	<div class="font-weight-bold bg-secondary p-1 text-white" align="center" style="font-size: 22px;">
      ISSUE REPORT
    </div>
    <br/>
	<div class="container-fluid my-4">
		<div class="table-responsive container-fluid">
			<table class="table table-bordered table-striped" id="example" style="width:100%">
				<thead>
					<tr>
						<th style="width: 5%;">Sr</th>
						<th style="width: 10%;">Date</th>
						<th style="width: 30%;">Batch Code</th>
						<th style="width: 15%;">Job No</th>
						<th style="width: 10%;">Rate</th>
						<th style="width: 10%;">Weight</th>
						<th style="width: 10%;">Rs/Kg</th>
						<th style="width: 10%;">Show</th>
					</tr>
				</thead>
				<tbody>
					<?php
                        $srno = 1;
                        $sql = "SELECT issue_date,job_no,batch_code, SUM(amount) as rate,SUM(weight) as weight from rubber_issue group by batch_code,issue_date,job_no order by issue_date desc";
                        $run = sqlsrv_query($con, $sql);
                        while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
                            ?>
					<tr>
						<td><?php echo $srno; ?></td>
						<td><?php echo $row['issue_date']->format("d-M-Y"); ?></td>
						<td><?php echo $row['batch_code']; ?></td>
						<td><?php echo $row['job_no']; ?></td>
						<td><?php echo $row['rate']; ?></td>
						<td><?php echo $row['weight']; ?></td>
						<td><?php echo round($row['rate']/$row['weight'], 2) ?></td>
						<td><button type="button" class="btn btn-info btn-sm fw-bold openModal" id="<?php echo $row['batch_code']; ?>">Show</button><button type="button" class="btn btn-danger btn-sm delete ms-1" id="<?php echo $row['batch_code']; ?>">Delete</button>
						<button type="button" class="btn btn-success btn-sm edit ms-1" id="<?php echo $row['batch_code']; ?>">Edit</button>
						</td>
					</tr>
				<?php $srno++;
                        } ?>
				</tbody>
			</table>
		</div>
	</div>

	<!-----------------------------------------   Edit Modal ----------------------------------------->
     <div class="modal fade small" id="Modalshow" aria-labelledby="Modalshow" aria-hidden="true" tabindex="-1">
            
        <!----------------- Scrollable modal --------------------------->
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Show</h5>
                   <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="edit_modal">
                   
                </div>
                <div class="modal-footer"></div>
            </div> 
        </div>
    </div>
    <!----------------------------------------- End Modal ----------------------------------------->

    <!-----------------------------------------   Edit Modal ----------------------------------------->
     <div class="modal fade small" id="Modalshow1" aria-labelledby="Modalshow1" aria-hidden="true" tabindex="-1">
            
        <!----------------- Scrollable modal --------------------------->
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            	<form action="edit_group.php" method="post">
                <div class="modal-header">
                    <h5>Edit</h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="edit_modal1">
                   
                </div>
                <div class="modal-footer"></div>
            	</form>
            </div> 
        </div>
    </div>
    <!----------------------------------------- End Modal ----------------------------------------->
</body>
</html>
<script type="text/javascript">
		$(document).ready(function(){
		      var table = $('#example').DataTable({
		    	"processing": true,
				 dom: 'Bfrtip',
				 // "order": [[ 1, "desc" ]],
            
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

/*--------------------- code for show data ----------------------*/
	$(document).on('click','.openModal',function(){
		var batch = $(this).attr('id');
		$.ajax({
          	url:"getdata.php",
          	method:"POST",
          	data:{batch:batch},
          	success:function(data) {
            	$('#edit_modal').html(data);
            	$('#Modalshow').modal('show');
          	}
      	});
	});

/*--------------------- code for delete data ----------------------*/
	$(document).on('click','.delete',function(){
		var batch = $(this).attr('id');
		if (confirm('Are You Sure!')) {
			$.ajax({
	          	url:"add_group.php",
	          	method:"POST",
	          	data:{batch:batch},
	          	success:function(data) {
	            	alert(data);
	            	location.reload();
	          	}
	      	});
		}else{
			return false;
		}
	});
/*--------------------- code for show data ----------------------*/
	$(document).on('click','.edit',function(){
		var id = $(this).attr('id');
		$.ajax({
          	url:"editdata.php",
          	method:"POST",
          	data:{editdata:id},
          	success:function(data) {
            	$('#edit_modal1').html(data);
            	$('#Modalshow1').modal('show');
          	}
      	});
	});
/*---------------------------end---------------------------------*/

$(document).on('change','.edititemrate,.edititemweight',function()
 {

        var edititemrate = $(this).closest('tr').find('.edititemrate').val();
        var edititemweight = $(this).closest('tr').find('.edititemweight').val();
        
        var temp = parseFloat(edititemrate) * parseFloat(edititemweight);
        $(this).closest('tr').find('.edititemamt').val((temp).toFixed(2));

        var id = 0;
        $('.edititemamt').each(function()
        {
          id += parseFloat($(this).val() == '' ? 0 : $(this).val());
        	$('.editrubberamount').val((id).toFixed(2));
        });

        var id1 = 0;
        $('.edititemweight').each(function()
        {
          id1 += parseFloat($(this).val() == '' ? 0 : $(this).val());
        	$('.editrubbermainweight').val((id1).toFixed(2));
        });

        var editrubberamounttemp = $(".editrubberamount").val();
        var editrubbermainweighttemp = $(".editrubbermainweight").val();

        var temp1 = (parseFloat(editrubberamounttemp)/parseFloat(editrubbermainweighttemp)).toFixed(2);

        $(".editrsinkg").val(temp1);

       
    });
</script>
