<?php
session_start();
if ($_SESSION['oid'] =='snehal' || $_SESSION['oid'] =='Rajnish' || $_SESSION['oid'] =='Rashmik' || $_SESSION['oid'] =='Pratik')
{
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Bill_Receive</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

		<style type="text/css" media="screen">
			input.largerCheckbox {
		transform : scale(2);
		}
		#trow{
		background-color: yellow;
		text-align: center;
		}
		</style>
 </head>
	<body>
		<div class="container">
	<div class="container-fluid">
      <div class="col-xs-3 text-right">
          <a href="../../../dashboard.php" class="btn btn-warning btn-sm font-weight-bold m-1 w-25"><<< Back</a>
      </div>
      <div class="col-xs-3 text-left">
          <button type="button" name="btn_receive" id="btn_receive" class="btn btn-info btn-sm font-weight-bold m-1 w-25">Receive Bill</button>
      </div>
			<div class="col-xs-3 text-right">
          <a href="view_bill_in.php" class="btn btn-success btn-sm font-weight-bold m-1 w-25">View Receive Bill</a>
      </div>
			<div class="col-xs-3 text-left">
          <button type="button" name="btn_jw" id="btn_jw" class="btn btn-primary btn-sm font-weight-bold m-1 w-25">Regular</button>
      </div>
    </div>
		</div>
		<?php if(isset($_SESSION['mess'])): ?>
		<div class="alert alert-primary font-weight-bold font-italic">
			<?php echo $_SESSION['mess']; ?>
		</div>
		<?php unset($_SESSION['mess']); ?>
		<?php endif; ?>
		<div class="table-responsive m-1">
			<table class="table table-bordered table-striped table-sm" id="employee_data">
				<thead>
				<tr class="bg-dark text-white text-center font-italic" id="trow">
					<th>Send_Date</th>
					<th>Rmta</th>
					<th>Party</th>
					<th>Bill_No</th>
					<th>Bill_Date</th>
					<th>mat_ord_by</th>
					<th>Bill_amt</th>
					<th>memo_no</th>
					<th>Ctrl</th>
				</tr>
			</thead>
				<?php
				include('..\..\..\..\dbcon.php');

				$sql="SELECT a.send_time,a.id,b.consignee_name,a.bill_no,a.in_date,b.createdBy,a.total_bill_amt,a.memo_no from jw_return a
              left outer join jw_challan b on a.iid=b.id where a.bill_send = 'sent' and a.bill_receive is NULL ORDER BY id desc";
				$run=sqlsrv_query($con,$sql);
				$params = array();
				$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
				$run1=sqlsrv_query($con,$sql,$params,$options);
				$row1=sqlsrv_num_rows($run1);
				if ($row1 > 0) {
				?>
				<?php
				while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
				?>
				<tr class="text-center font-italic" id="<?php echo $row["id"]; ?>">
					<td><?php echo $row['send_time']->format('d.M.Y');  ?></td>
					<td><?php echo $row['id'];  ?></td>
					<td><?php echo $row['consignee_name'];  ?></td>
					<td><?php echo $row['bill_no'];  ?></td>
					<td><?php echo $row['in_date']->format('d.M.Y');  ?></td>
					<td><?php echo $row['createdBy'];  ?></td>
					<td><?php echo $row['total_bill_amt'];  ?></td>
					<td><?php echo $row['memo_no'];  ?></td>
					<td><input type="checkbox" name="sr_no[]" class="largerCheckbox" value="<?php echo $row["id"]; ?>" /></td>
				</tr>
				<?php
				}
				?>
				<?php
				}
				else{}

				?>
			</table>

		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#employee_data').DataTable({
					dom: 'lBfrtip',
   buttons: [
    'excel','print'
   ],
   "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
				});
		$('#btn_receive').click(function(){
		if(confirm("Are you sure you want to Receive this?"))
		{
		var id = [];

		$(':checkbox:checked').each(function(i){
		id[i] = $(this).val();
		});
		if(id.length === 0) //tell you if the array is empty
		{
		alert("Please Select atleast one checkbox");
		}
		else
		{
		$.ajax({
		url:'bill_in_to_db.php',
		method:'POST',
		data:{id:id},
		success:function()
		{
		for(var i=0; i<id.length; i++)
		{
			$('tr#'+id[i]+'').css('background-color', '#ccc');
			$('tr#'+id[i]+'').fadeOut('slow');
		}
	},
	complete:function()
	{
		location.reload(true);
	}

		});
		}

		}
		else
		{
		return false;
		}
		});
		$("#btn_jw").on("click",function(){
			window.open('../bill_in.php','_self');
		});

		});

		</script>
	</body>
</html>
<?php
	}
	else{
		$_SESSION['utype'] = "You Are Not Authorized!!";
            header("location:..\..\dashboard.php");
	}
?>
