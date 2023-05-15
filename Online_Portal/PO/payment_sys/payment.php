<?php
include('..\..\..\dbcon.php');
$sr_no= $_GET['sr_no'];
$party= $_GET['party'];
$sql="SELECT * FROM inward_com WHERE CONCAT(sr_no,receive_at) = '$sr_no'";
$run=sqlsrv_query($con,$sql);
$row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
    $sql3="SELECT SUM(payment_amt) as payment_value FROM rm_payment where sr_no='".$row['sr_no']."'  and receive_at='".$row['receive_at']."'";
	$run3=sqlsrv_query($con,$sql3);
	$row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>payment_form</title>
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<style type="text/css" media="screen">
		body {
		margin: 0;
		padding: 0;
		background-color: #17a2b8;
		height: 100vh;
		}
		#login .container #login-row #login-column #login-box {
		margin-top: 60px;
		max-width: 900px;
		height: 600px;
		background-color: #EAEAEA;
		}
		#login .container #login-row #login-column #login-box #login-form {
		padding: 20px;
		}
		#login .container #login-row #login-column #login-box #login-form #register-link {
		margin-top: -85px;
		}
		</style>
	</head>
	<body>
		<div id="login">
			
			<div class="container">
				<div id="login-row" class="row justify-content-center align-items-center">
					<div id="login-column" class="col-md-6">
						<div id="login-box" class="col-md-12">
							<form id="login-form" class="form" action="payment_to_db.php" method="post">
								<h4 class="text-center text-info"><?php echo "Payment To_".$party."_Against invoice_".$row['invoice_no']; ?></h4>
								<br>
								<input type="hidden" name="sr_no" id="sr_no" value="<?php echo $row['sr_no']; ?>" class="form-control" readonly>
								<input type="hidden" name="receive_at" id="receive_at" value="<?php echo $row['receive_at']; ?>" class="form-control" readonly>
								<input type="hidden" name="pid" id="pid" value="<?php echo $row['mat_from_party']; ?>" class="form-control" readonly>
								
								<div class="form-group">
									<label for="test" class="text-info">Payment Due:</label><br>
									<input type="text" name="p_date" id="p_date" value="<?php echo $row['payment_due']->format('d-M-Y'); ?>" class="form-control" readonly>
								</div>
								<div class="form-group">
									<label for="test" class="text-info">Balance Amt:</label><br>
									<input type="text" name="bal_amt" id="bal_amt" value="<?php echo $row['total_bill_amt']-$row3['payment_value']; ?>" class="form-control" readonly>
								</div>
								<div class="form-group">
									<label for="test" class="text-info">Payment Amt:</label><br>
									<input type="number" name="p_amt" step="0.01" id="p_amt" value="" class="form-control" required>
								</div>
								<div class="form-group">
									<label for="test" class="text-info">Transaction ID:</label><br>
									<input type="text" name="trans_id" id="trans_id" value="" class="form-control" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label for="test" class="text-info">Remark:</label><br>
									<input type="text" name="remark" id="remark" value="" class="form-control" autocomplete="off">
								</div>
								<div class="form-group">
									<input type="submit" name="save" class="btn btn-info btn-md w-25 font-weight-bold" value="Save">
									<a href="payment_table.php" class="btn btn-info btn-md">Back</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			$(document).ready(function(){
				$('#p_amt').change(function(){
                var p_amt = $(this).val();
                var balance = $("#bal_amt").val();
                var abc = parseFloat(p_amt) - parseFloat(balance);
                if (abc > 0) {
                	alert("we are paying " + abc + "/- rupees more than the balance!!!");
                }

               });
			});	
		</script>

	</body>
</html>