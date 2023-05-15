<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!------------------------ BT-5 JS -------------------------------------->
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<title>Requisition Slip</title>
		<!------------------------ BT-5 CSS -------------------------------------->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- jQuery UI -->
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<style type="text/css">
			table th,tr, {
		border: 1px solid #170891;
		}
		th{
		background-color: #170891;
		color: #ffffff;
		}
		tr
		{
		
		font-size: 15px;
		border-radius: 0px;
		}
		td
		{
		border: 1px solid #170891;
		}
		.btn
		{
		border-radius: 0px;
		
		}
		.form-control , .form-select
		{
		border-radius: 0px;
		
		}
		ul {
		cursor: pointer;
		padding: unset;
		max-height: 250px;
		overflow: auto;

		}
		li {
		padding: 3px;
		background-color: #edebe4;

		}
		.msg_show{
			font-weight: bolder;
			font-style: italic;
			padding: 5px 20px;
			margin-top: 8px;
			color: #08732d;
		}
		
		</style>
	</head>
	<body>
		<div class="container-fluid">
			<form action="Requisition_slip_db.php" method="POST">
				<div class="card bg-faded mt-3">
					<div class="card-header bg-dark text-white">
						<div class="row justify-content-left mt-3">
							<div class="col-lg-3 col-md-3 col-sm-12">
								<a href="../dashboard.php" class="btn btn-danger">BACK</a>
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-12">
								<h3 class="h4 text-center">Requisition Slip</h3>
							</div>
							
							
							<div class="col-lg-3 col-md-3 col-sm-12">
								<input type="submit" name="save" class="float-end bg-primary text-white btn" value="SAVE">
							</div>
						</div>
					</div>
					<?php if(isset($_SESSION['message'])): ?>
					<div class="alert alert-success msg_show">
						<?php echo $_SESSION['message']; ?>
					</div>
					<?php endif; ?>
					<?php unset($_SESSION['message']); ?>
					<div class="card-body">
						<div class="row justify-content-center">
							<div class="col-lg-4 col-md-4 col-sm-12 mt-3">
								<div class="form-floating mb-3">
									<input type="date" class="form-control" id="floatingInput" name="req_date" placeholder="Date" required>
									<label for="floatingInput">Material Required Date</label>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 mt-3">
								<div class="form-floating mb-3">
									<input type="text" class="form-control indentor" value="<?php echo $_SESSION['oid']; ?>" name="indentor" id="floatingInput" onFocus="SearchIndentor(this)" required>
									<input type="hidden" name="dpnt" class="dpnt" value="<?php echo $_SESSION['dpnt']; ?>">
									<label for="floatingInput">Prepared By</label>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 mt-3">
								<div class="form-floating mb-3">
									<textarea class="form-control" placeholder="Remark" name="remark" id="floatingTextarea"></textarea>
									<label for="floatingTextarea">Remark</label>
								</div>
							</div>
						</div>
						<div class="row justify-content-center">
							<div class="table-responsive">
								<table align="center" width="100%" id="receive" style="text-align: center;">
									<thead>
										<tr>
											<th>
												
												SR.
											</th>
											<th>Item Description</th>
											<th>Qnty</th>
											<th>Approx Cost</th>
											<th>M\C No.</th>
											<th>Department</th>
											<th>Plant</th>
											<th>Category</th>
											<th>State</th>
											<th>Type</th>
											<th class="hidelable">Old_Part_Status</th>
											<th></th>
										</tr>
									</thead>
									<tbody id="receive">
										<tr>
											<td style="width:1px" name="sr" id="sr">1</td>
											<td style="width:2px" ><input type="text" name="item_desc[]" onFocus="SearchItem(this)" class="form-control item" style="width:340PX;" id="1Des" required><input type="hidden" name="i_code[]" class="i_code"></td>
											<td style="width:1px"><input type="number" step="0.01" name="Qnty[]" class="form-control" style="width:100PX;" id="Qnt" required></td>
											<td style="width:1px"><input type="number" step="0.01" name="apx_cost[]" class="form-control" style="width:100PX;" id="apx_cost"></td>
											<td style="width:1px"><input type="text" name="mc[]" onFocus="SearchMc(this)" class="form-control mcno" style="width:100PX;" id="mc"></td>
											<td style="width:1px"><input type="text" name="dept[]" onFocus="SearchDpnt(this)" class="form-control dept" style="width:150PX;" id="dept" required></td>
											<td style="width:1px"><input type="text" name="plant[]" class="form-control plant" style="width:100PX;" id="plant" readonly></td>
											<td style="width:1px">
												<input type="text" name="category[]" class="form-control category" style="width:200PX;" id="category" readonly>
											</td>
											<td style="width:1px">
												<select class="form-select" aria-label="Default select example" id="state" name="state[]" style="width:200PX;">
													<option disabled="" selected class="bg-primary text-white">-- Select --</option>
													<option class="bg-dark text-white">Capital</option>
													<option class="bg-dark text-white">Consumable</option>
													<option class="bg-dark text-white">Raw Material</option>
												</select>
											</td>
											<td style="width:1px">
												<select class="form-select type" aria-label="Default select example" id="type" name="status[]" style="width:200PX;" required>
													<option disabled="" selected class="bg-primary text-white">-- Select --</option>
													<option  class="bg-dark text-white">New</option>
													<option  class="bg-dark text-white">Replace</option>
													
												</select>
											</td>
											<td style="width:1px">
												<select class="form-select hideit" aria-label="Default select example" id="old_part" name="old_part[]" style="width:200PX;">
													<option disabled="" selected class="bg-primary text-white">-- Select --</option>
													<option  class="bg-dark text-white">Repair</option>
													<option  class="bg-dark text-white">Stock</option>
													<option  class="bg-dark text-white">Scrap</option>
												</select>
												
											</td>
											<td style="border-bottom: dotted;border-top: none;border-right: none;border-left: none; ">
												<button type="button" id="newbtn" name="newbtn" class="btn btn-sm btn-danger font-weight-bold text-white"style="width:100%" >ADD</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					
				</div>
				
			</form>
		</div>
	</body>
</html>
<script type="text/javascript">
	      //ITEM Indentor
      function SearchIndentor(txtBoxRef) {
      console.log('function call');
        var f = true; //check if enter is detected
        $(txtBoxRef).keypress(function (e) {
            if (e.keyCode == '13' || e.which == '13')
            {
                f = false;
            }
        });
        $(txtBoxRef).autocomplete({
            
   source: function( request, response ) {
   // Fetch data
   $.ajax({
    url: "getindentor.php",
    type: 'post',
    dataType: "json",
    data: {
     indentor: request.term
    },
    success: function( data ) {
     response( data );
    }
   });
  },
  select: function (event, ui) {
   // Set selection
   $('.indentor').val(ui.item.label);
   $('.dpnt').val(ui.item.dpnt);

   return false;
  },
  change: function (event, ui)  //if not selected from Suggestion
      {
        if (f)
        {
          if (ui.item == null)
          {
            $(this).val('');
            $(this).focus();
          }
          /*else{
                  $(this).closest('tr').find('.qty').focus();
          }*/
        }

      }

         });
      
}
			// mc autocomplete box
function SearchMc(txtBoxRef) {
//console.log('function call');
var f = true; //check if enter is detected
$(txtBoxRef).keypress(function (e) {
if (e.keyCode == '13' || e.which == '13')
{
f = false;
}
});
$(txtBoxRef).autocomplete({
source: function( request, response ) {
// Fetch data
$.ajax({
url: "reqGetMc.php",
type: 'post',
dataType: "json",
data: {
mc: request.term
},
success: function( data ) {
response( data );
}
});
},
select: function (event, ui) {
// Set selection
var self = this;
$(self).closest('tr').find('.mcno').val(ui.item.label);
$(self).closest('tr').find('.dept').val(ui.item.dname);
$(self).closest('tr').find('.plant').val(ui.item.plant);


return false;
},
change: function (event, ui)  //if not selected from Suggestion
{

if (ui.item == null)
{
$(this).val('');
$(this).focus();
}
else{
$(this).closest('tr').find('.dept').prop('readonly', true);

}


}
});
}
			// Department autocomplete box
function SearchDpnt(txtBoxRef) {
//console.log('function call');
var f = true; //check if enter is detected
$(txtBoxRef).keypress(function (e) {
if (e.keyCode == '13' || e.which == '13')
{
f = false;
}
});
$(txtBoxRef).autocomplete({
source: function( request, response ) {
// Fetch data
$.ajax({
url: "reqGetDpnt.php",
type: 'post',
dataType: "json",
data: {
dpnt: request.term
},
success: function( data ) {
response( data );
}
});
},
select: function (event, ui) {
// Set selection
var self = this;
$(self).closest('tr').find('.dept').val(ui.item.label);
$(self).closest('tr').find('.plant').val(ui.item.plant);


return false;
},

});
}
	//ITEM seach
function SearchItem(txtBoxRef) {
//console.log('function call');
var f = true; //check if enter is detected
$(txtBoxRef).keypress(function (e) {
if (e.keyCode == '13' || e.which == '13')
{
f = false;
}
});
$(txtBoxRef).autocomplete({

source: function( request, response ) {
// Fetch data
$.ajax({
url: "reqItemGet.php",
type: 'post',
dataType: "json",
data: {
item: request.term
},
success: function( data ) {
response( data );
}
});
},
select: function (event, ui) {
// Set selection
var self = this;
$(self).closest('tr').find('.item').val(ui.item.label);
$(self).closest('tr').find('.i_code').val(ui.item.i_code);
$(self).closest('tr').find('.category').val(ui.item.cat);

return false;
},
change: function (event, ui)  //if not selected from Suggestion
{
if (f)
{
if (ui.item == null)
{
$(this).val('');
$(this).focus();
}
/*else{
$(this).closest('tr').find('.qty').focus();
}*/
}
}
});

}
	$(document).ready(function(){
		$(".hideit,.hidelable").hide();
		});
	// add button coding
var abc = 1;
$("#newbtn").click(function(){
var xyz = $('#'+abc+'Des').val();
if (xyz == "") {
alert('Please fill Current Information (कृपया पहले जानकारी भरें)');
}
else
{
abc++;
var rowHtml = '<tr>';
								rowHtml += '<td style="width:1px" name="sr" id="sr">'+abc+'</td>';
								rowHtml += '<td style="width:2px" ><input type="text" name="item_desc[]" class="form-control item" onFocus="SearchItem(this)" style="width:340PX;" id="'+abc+'Des" required><input type="hidden" name="i_code[]" class="i_code"></td>';
							rowHtml += '<td style="width:1px"><input type="number" step="0.01" name="Qnty[]" class="form-control" style="width:100PX;" id="'+abc+'Qnt" required></td>';
							rowHtml += '<td style="width:1px"><input type="number" step="0.01" name="apx_cost[]" class="form-control" style="width:100PX;" id="'+abc+'apx_cost"></td>';
								rowHtml +='<td style="width:1px"><input type="text" onFocus="SearchMc(this)" name="mc[]" class="form-control mcno" style="width:100PX;" id="'+abc+'mc"></td>';
								rowHtml += '<td style="width:1px"><input type="text" name="dept[]" onFocus="SearchDpnt(this)" class="form-control dept" style="width:150PX;" id="'+abc+'dept" required></td>';
								rowHtml += '<td style="width:1px"><input type="text" name="plant[]" class="form-control plant" style="width:100PX;" id="'+abc+'plant" readonly></td>';
								rowHtml += '<td><input type="text" name="category[]" class="form-control category" style="width:200PX;" id="'+abc+'category" readonly></td>';
								rowHtml += '<td style="width:1px"><select class="form-select" aria-label="Default select example" id="'+abc+'state" name="state[]" style="width:200PX;"><option disabled="" selected class="bg-primary text-white">-- Select --</option><option class="bg-dark text-white">Capital</option><option class="bg-dark text-white">Consumable</option><option class="bg-dark text-white">Raw Material</option></select></td>';
								rowHtml += '<td style="width:1px"><select class="form-select type" aria-label="Default select example" id="type" name="status[]" style="width:200PX;" required><option disabled="" selected class="bg-primary text-white">-- Select --</option><option  class="bg-dark text-white">New</option><option  class="bg-dark text-white">Replace</option></select></td>';
								rowHtml += '<td style="width:1px"><select class="form-select hideit" aria-label="Default select example" id="'+abc+'old_part" name="old_part[]" style="width:200PX;"><option disabled="" selected class="bg-primary text-white">-- Select --</option><option  class="bg-dark text-white">Repair</option><option  class="bg-dark text-white">Stock</option><option  class="bg-dark text-white">Scrap</option></select></td>';
rowHtml += '</tr>';
$('table').find('tbody').append(rowHtml)
$('#'+abc+'old_part').hide();
}
});
$(document).on('change','#type',function(){
				var a = $(this).val();
					if (a == 'Replace') {
						$(this).closest('tr').find(".hideit").show();
						$(".hidelable").show();
						//$(this).closest('tr').find("#upload3,#upload4").attr('required', true);
					}
				else {
						$(this).closest('tr').find(".hideit").hide();
						//$(this).closest('tr').find("#upload3,#upload4").attr('required', false);
					}
			});
</script>