<?php
session_start();
if (!isset($_SESSION['iid'])) {
    $_SESSION['login'] = "Please Login First";
            header("location:../OnlinePortal_login.php");
  }
  else {
include('..\dbcon.php');
$iid= $_SESSION['iid'];
$sql="SELECT * FROM online_portal_user where id='$iid'";
$run=sqlsrv_query($con,$sql);
$row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>add_data</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
		<link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body class="bg-dark">
		<div class="p-0 bg-light text-center text-dark">
			<h2>Change Password</h2>
		</div>
		<?php if(isset($_SESSION['login'])): ?>
                <div class="alert alert-danger font-weight-bold font-italic">
                    <?php echo $_SESSION['login']; ?>
                </div>
                <?php unset($_SESSION['login']); ?>
    <?php endif; ?>
		<div class="container mt-2">
			<div class="row">
				<div class="col-lg-6">
					<a href="dashboard.php" class="btn btn-warning font-weight-bold w-25 mb-2">Back</a>
				</div>
				
			</div>
			<form action="change_password_to_db.php?id=<?php echo $iid; ?>" method="post">
			<div class="input-group mb-2 text-right">
	       	<label class="form-control badge-dark font-weight-bold text-warning w-25">Name=></label>
      		<input type="text" name="name" class="form-control date w-75 bg-dark text-white font-weight-bold font-italic" id="name" readonly value="<?php echo $row['name']; ?>">
    		</div>
    		<div class="input-group mb-2 text-right">
	       	<label class="form-control badge-dark font-weight-bold text-warning w-25">Old Password=></label>
      		<input type="text" name="old_pass" class="form-control date w-75 bg-dark text-white font-weight-bold font-italic" id="name" readonly value="<?php echo $row['password']; ?>">
    		</div>
    		<div class="input-group mb-2 text-right">
	       	<label class="form-control badge-dark font-weight-bold text-warning w-25">New Password=></label>
      		<input type="text" name="new_pass" class="form-control date w-75 bg-dark text-white font-weight-bold font-italic" id="new_pass" value="" required autocomplete="off">
    		</div>

			
    <div class="form-group">
				<input type="submit" name="submit" value="Save" class="btn btn-success font-weight-bold w-25">
	</div>

</form>
		</div>
		<script type="text/javascript">
        $(document).ready(function () {
        $("#new_pass").focus();
        });
        </script>
	</body>
</html>
<?php
}
?>