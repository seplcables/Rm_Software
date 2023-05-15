<?php
session_start();
include('..\..\..\dbcon.php');
$id = $_GET['id'];
$sql = "SELECT * FROM rm_party_master where pid = '$id'";
$run = sqlsrv_query($con,$sql);
$row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

?>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>HR Use Only</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- jQuery UI -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<style type="text/css">
	#star_req{
		color: red;
	}
</style>
</head>
<body class="bg-info">
	<div class="container mt-5 bg-light" style="border-radius: 30px;
            box-shadow: 15px 15px 15px 15px;">
	<div>
	<br>
 	<h1 class="bg-info" style="color: white" align="center">PARTY EDIT</h1> 
 	<br>
 	   <form action="editparty_db.php" method="post">
 	   	

 	   	<div class="form-row mt-2">

         <div class="form-group col-12">
         <label class="font-italic">Party Name<span id="star_req"> **</span></label>
         <input type="text" value="<?php echo $row['party_name']; ?>" name="pname" id="pname" class="form-control" required>
         <input type="hidden" value="<?php echo $id; ?>" name="iid" id="iid" class="form-control">
         </div>   
       </div>
       <div class="form-row mt-2">

         <div class="form-group col-lg-5 col-md-5 col-sm-5">
         <label class="font-italic">Party Code<span id="star_req"> **</span></label>
         <input type="text" value="<?php echo $row['p_code']; ?>" name="pcode" id="pcode" class="form-control" required>
         </div>   
       </div>

       <div class="form-row mt-2">

         <div class="form-group col-lg-5 col-md-5 col-sm-5">
         <label class="font-italic">Place<span id="star_req"> **</span></label>
            <input type="text" name="place" value="<?php echo $row['place']; ?>" class="form-control" required>
       
         </div>
         <div class="col-2"></div>
         <div class="form-group col-lg-5 col-md-5 col-sm-5">
         <label class="font-italic">GSTIN</label>
            <input type="text" name="gstin" value="<?php echo $row['GSTIN']; ?>" class="form-control">
         </div>
       </div>
			 <div class="form-row mt-2">
					<div class="form-group col-lg-5 col-md-5 col-sm-5">
				 <label class="font-italic">Contact No<span id="star_req"> **</span></label>
				<input type="text" name="con_no" value="<?php echo $row['Contact_No']; ?>" class="form-control"  required>
				 </div>
				 <div class="col-2"></div>
				 <div class="form-group col-lg-5 col-md-5 col-sm-5">
				 <label class="font-italic">Contact Person<span id="star_req"> **</span></label>
						<input type="text" value="<?php echo $row['Contact_Person']; ?>" name="con_per" class="form-control"  required>
				 </div>
			 </div>
			 <div class="form-row mt-2">
					<div class="form-group col-12">
				 <label class="font-italic"> Address</label>
				 
				<input type="text" name="address" value="<?php echo $row['party_address']; ?>" class="form-control">
				 </div>
				 
			 </div>

			
			 
			<div class="form-row mt-2">
			 	<div class="form-group col-lg-5 col-md-5 col-sm-5">
			 		 <button id="submit" name="submit" class="button btn-info" style="width:350px;border-radius: 30px"><span>Sumbit</span></button>
			 			
			 		</button>
			 	</div>
			 </div>
		</form>
	</div>
</div>
</body>
</html>

