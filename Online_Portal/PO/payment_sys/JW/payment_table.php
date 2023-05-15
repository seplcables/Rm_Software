<?php
session_start();
if ($_SESSION['oid'] =='snehal' || $_SESSION['oid'] =='Rajnish' || $_SESSION['oid'] =='dipen' || $_SESSION['oid'] =='himanshu' || $_SESSION['oid'] =='Pratik')
{
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Payment</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<style type="text/css" media="screen">
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
      <div class="col-xs-6 text-left">
          <a href="../pymt_report.php" class="btn btn-info btn-sm font-weight-bold m-1 w-25">View Payment Details</a>
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
					<th>Bill_Date</th>
					<th>Bill_No</th>
					<th>Rmta</th>
					<th>Party</th>
					<th>Bill_Amt</th>
					<th>Bal_amt</th>
					<th>Pay</th>
				</tr>
			</thead>
				<?php
				include('..\..\..\..\dbcon.php');

				$sql="SELECT * from jw_return where bill_receive ='received' AND bill_send ='sent' ORDER BY id asc";
				$run=sqlsrv_query($con,$sql);
				$params = array();
				$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
				$run1=sqlsrv_query($con,$sql,$params,$options);
				$row1=sqlsrv_num_rows($run1);
				if ($row1 > 0) {
				?>
				<?php
				while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
				$sql2="SELECT consignee_name from jw_challan where id='".$row['iid']."'";
				$run2=sqlsrv_query($con,$sql2);
				$row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);

				$sql3="SELECT SUM(payment_amt) as payment_value FROM payment_table where sr_no='".$row['id']."'  and receive_at='jw'";
				$run3=sqlsrv_query($con,$sql3);
				$row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);
				$bal_amt = floatval($row['total_bill_amt'])-floatval($row3['payment_value']);
				  if ($bal_amt <= 0) {
                         continue;
                               }
				?>
				<tr class="text-center font-italic">
					<td><?php echo $row['in_date']->format('d.M.Y');  ?></td>
					<td><?php echo $row['bill_no'];  ?></td>
					<td><?php echo $row['id'];  ?></td>
					<td><?php echo $row2['consignee_name'];  ?></td>
					<td><?php echo $row['total_bill_amt'];  ?></td>
					<td><?php echo $row['total_bill_amt']-$row3['payment_value'];  ?></td>
					<td><a href="party_pymt.php?&party=<?php echo $row['pid']; ?>" class="btn btn-info font-weight-bold">Pay</a></td>
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
			$("#btn_jw").on("click",function(){
				window.open('../payment_table.php','_self');
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
