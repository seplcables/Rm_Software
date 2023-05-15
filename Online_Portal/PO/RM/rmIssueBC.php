<?php session_start();
if (!isset($_SESSION['oid'])) 
{
$_SESSION['login'] = "Please Login First";
header("location:..\..\..\OnlinePortal_login.php");
}
else
{
if (isset($_SESSION['str'])) {
$str = $_SESSION['str'];
$mcn = $_SESSION['mcn'];
}
else{
$str = "";
$mcn = "";
}
?>
<script type="text/javascript">
<?php if(isset($_SESSION['duplicateBC'])): ?>
  alert('यह बारकोड पहले ही स्कैन किया जा चुका है');
<?php endif; ?>
<?php unset($_SESSION['duplicateBC']); ?>

</script>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>pvc issue</title>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<!-- ===== BOX ICONS ===== -->
		<link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
		<!-- ===== CSS ===== -->
		
		<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
		<style type="text/css">
				
		<style>
		.box{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%,-50%);
		width: 420px;
		background: #fff;
		padding: 40px;
		box-sizing: border-box;
		border: 1px solid rgba(0, 0, 0, .1);
		box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
		}
		.box h3
		{
		margin: 0 0 40px;
		padding: 0;
		color: #cc0066;
		text-transform: uppercase;
		font-family: cursive;
		font-weight: bold;
		}
		.box input
		{
		padding: 10px 0;
		margin-bottom: 30px;
		}
		.box select
		{
		padding: 10px 0;
		margin-bottom: 30px;
		}
		.box input,
		.box select{
		width: 100%;
		box-sizing: border-box;
		box-shadow: none;
		outline: none;
		border: none;
		border-bottom: 2px solid #999;
		}
		.box button[type="button"]
		{
		border-bottom: none;
		cursor: pointer;
		background: #f7497d;
		color: #fff;
		margin-bottom: 0;
		text-transform: uppercase;
		
		}
		.box button[type="submit"]
		{
		border-bottom: none;
		cursor: pointer;
		background: #555555;
		color: #ffffff;
		margin-bottom: 0;
		text-transform: uppercase;
		width: 100%;
		}
		.box form div
		{
		position: relative;
		}
		.box form div label
		{
		position: absolute;
		top: 10px;
		left: 0;
		color: #999;
		transition: .5s;
		pointer-events: none;
		}
		.box input:focus ~ label,
		.box input:valid ~ label,
		.box input:read-only ~ label
		{
		top: -12px;
		left: 0;
		color: #f7497d;
		font-size: 12px;
		font-weight: bold;
		}
		.box select:focus ~ label,
		.box select:valid ~ label
		{
		top: -15px;
		left: 0;
		color: #f7497d;
		font-size: 12px;
		font-weight: bold;
		}
		.box input:focus,
		.box input:valid,
		.box select:focus,
		.box select:valid
		{
		border-bottom: 2px solid #f7497d;
		}
		#setform {
		max-height: 620px;
		overflow: hidden;
		overflow-y: scroll;
		}
		.req{
		font-family: serif;
		font-weight: bold;
		}
		.alert
		{
		max-width:420px;
		margin:0 auto;
		margin-top:50px;
		}
		</style>
	</head>
	<body class="container">
		<div class="box mt-2">
			<!-- Alert message -->
			<div class="alert alert-danger" id="success-alert">
				<button type="button" class="close" data-dismiss="alert">x</button>
				<strong>Saved!</strong> Successfully
			</div>
			<!-- Alert message -->
			<h3>PVC ISSUE  <button type="button" class="btn btn-outline-dark text-dark font-weight-bold float-right" id="return">RETURN</button></h3>
			<form action="rmIssueBC_db.php" method="POST" id="setform">
				<div class="mt-3">
					<select class="store" name="store" id="store" required>
						<option value="<?php echo $str; ?>"><?php echo $str; ?></option>
						<option value="gupta_ji">Gupta ji</option>
						<option value="ramesh">ramesh</option>
						<option value="chirag">chirag</option>
						<option value="dinesh">dinesh</option>
						<option value="2106">2106</option>
						<option value="dummy">Dummy</option>
						<option value="new_dana">New_dana</option>
						
					</select>
					<label>STORE **</label>
				</div>
				<div>
					<input type="text" class="" value="<?php echo $mcn; ?>" id="mc" name="mc" required autocomplete="off">
					<label>MC **</label>
				</div>
				<div>
					<input type="text" class="" id="barcode_id" name="barcode_id" required autocomplete="off">
					<input type="hidden" name="iid" id="iid">
					<input type="hidden" name="bid" id="bid">
					<label>BARCODE ID ***</label>
				</div>
				<div>
					<input type="text" class="" placeholder="RMTA" id="rmta" readonly>
					
				</div>
				<div>
					<input type="text" class="" placeholder="GRADE" id="grade" readonly>
					
				</div>
				<button type="submit" name="save" class="btn font-weight-bold" id="submit">Save</button>
				
				
			</form>
		</div>
	</body>
</html>
<script type="text/javascript">
				/*$(":input").keypress(function(event){
			if (event.which == '10' || event.which == '13') {
			event.preventDefault();
			}
			});*/
$(document).ready(function(){
	
	var bc = $("#mc").val();
	if (bc != '') {
		$("#barcode_id").focus();
		}
	$("#success-alert").hide();
$("#barcode_id").on("change",function(){
var id = $(this).val();
var arr = id.split('/');
$('#iid').val(arr[0]);
$('#bid').val(arr[1]);
		$.ajax({
url:"getBarcodeData.php",
method:"POST",
data:{iid:arr[0],id:id},
dataType:"json",
success:function(data)
{
$('#rmta').val(data.sr_no);
$('#grade').val(data.item);
}
});
});
<?php if(isset($_SESSION['bcmess'])): ?>
$("#success-alert").fadeTo(300, 500).slideUp(500, function() {
$("#success-alert").slideUp(500);
});
<?php endif; ?>
<?php unset($_SESSION['bcmess']); ?>
/*$("#setform").submit(function(){
var rmta = $('#rmta').val();
var grade = $('#grade').val();
if (rmta == '' || grade == '') {
$("#barcode_id").val('');
$("#barcode_id").focus();
alert('DUPLICATE BARCODE FOUND');
return false
}
});*/

$("#return").on("click", function(){
window.open('rmReturnBC.php','_self');

});

});
</script>
<?php 
}
 ?>