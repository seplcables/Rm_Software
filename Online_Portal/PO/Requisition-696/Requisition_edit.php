<?php 
session_start();
include('..\..\..\dbcon.php');
$sql = "SELECT mat_require_dte,indentor,indentor_dpnt,remarks from Requisition_head
				where id = '".$_GET['id']."'";
				$run = sqlsrv_query($con,$sql);
   $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!------------------------ BT-5 JS -------------------------------------->
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<title>Requisition Edit</title>
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
		
		font-size: 12px;
		border-radius: 0px;
		}
		td
		{
		border: 1px solid #170891;
		font-size: 12px;
		}
		.btn
		{
		border-radius: 0px;
		
		}
		.form-control , .form-select
		{
		border-radius: 0px;
		font-size: 12px;
		
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
		.ui-autocomplete {
        max-height: 180px;
        overflow: auto;
        max-width: 400px;
        overflow-y: auto;
        font-size: 12px;
        text-overflow: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
        background-color: #9ed8fa;
        
        z-index: 2150000000 !important;
        
        }
		
		</style>
		
		</style>
	</head>
	<body>

		<div class="modal fade" id="createqty" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg ">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-info bg-gradient text-white">
                        
                        
                        <h3 class="h4 text-center">PRODUCT DETAILS</h3>
                        
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
	                    <div class="modal-body" id="t_body_create">
	                        
	                	</div>
	                    <div class="modal-footer">
	                        <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
	                        <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
	                    </div>
                    <!-- </form> -->
            	</div>
        	</div>
    	</div>

    	<div class="modal fade" id="createqty1" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg modallg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-info bg-gradient text-white">
                        <h3 class="h4 text-center">PRODUCT DETAILS</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
	                    <div class="modal-body">
	                        <div  id="t_body_create1">
	                        </div>
	                    	<div class="m-3"  align="right" style="font-weight:bold;">
	                    		Total Qnty => <span id="totalqty1"></span><br/>
	                    		Total Add Qnty => <span id="totaladdqnty1"></span>
	                    		<!--
	                    		<br/>
	                    		-------------------------------------------------------<br/>
	                    		Total Remaining Qnty => <span id="remainqnty"></span>-->

	                    	</div>
	                	</div>
	                    <div class="modal-footer">
	                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	                        <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button>
	                    </div>
                    <!-- </form> -->
            	</div>
        	</div>
    	</div>
		
		<div class="container-fluid">
			<form action="Requisition_edit_db.php" method="POST">
				<div class="card bg-faded mt-3">
					<div class="card-header bg-dark text-white">
						<div class="row justify-content-left mt-3">
							<div class="col-lg-3 col-md-3 col-sm-12">
								<a href="showRequisition.php" class="btn btn-danger">BACK</a>
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-12">
								<h3 class="h4 text-center">REQUISITION SLIP EDIT</h3>
							</div>
							
							
							<div class="col-lg-3 col-md-3 col-sm-12">
								<input type="hidden" name="temp_icode" id="tempicode" value=""><br/>
                            	<input type="hidden" name="temp_mc" id="tempmc" value=""><br/>
                                <input type="hidden" name="temp_dept" id="tempdept" value=""><br/>
                                <input type="hidden" name="temp_plant" id="tempplant" value=""><br/>
                                <input type="hidden" name="temp_emp" id="tempemp" value=""><br/>
                                <input type="hidden" name="temp_qnty" id="tempqnty" value="">
                                <input type="hidden" name="temp_req" id="tempreq" class="tempreq" value="">
								<input type="submit" name="save" class="float-end bg-primary text-white btn font-weight-bold" value="UPDATE">

							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row justify-content-center">
							<div class="col-lg-3 col-md-3 col-sm-3 mt-3">
								<div class="form-floating mb-3">
									<input type="text" class="form-control" value="<?php echo $row['mat_require_dte']->format('d-M-y'); ?>" name="req_date" placeholder="Date" required>
									<label for="floatingInput">Material Required Date</label>
								</div>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 mt-3">
								<div class="form-floating mb-3">
									<input type="text" class="form-control indentor" value="<?php echo $row['indentor']; ?>" name="indentor" id="floatingInput" onFocus="SearchIndentor(this)" required>
									<input type="hidden" name="dpnt" class="dpnt" value="<?php echo $row['indentor_dpnt']; ?>">
									<input type="hidden" name="iid" value="<?php echo $_GET['id']; ?>">
									<label for="floatingInput">Prepared By</label>
								</div>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 mt-3">
								<div class="form-floating mb-3">
									<textarea class="form-control" placeholder="Remark" name="remark" id="floatingTextarea"><?php echo $row['remarks']; ?></textarea>
									<label for="floatingTextarea">Remark</label>
								</div>
							</div>
								<div class="col-lg-3 col-md-3 col-sm-3 mt-3">
								<input type="button" id="newbtn" name="newbtn" class="float-end  bg-danger text-white btn mb-3" value="ADD" style="margin-right: 5px;">
							</div>

							</div>
							<div class="row justify-content-center">
								<div class="table-responsive">
									<table align="center" id="receive" style="text-align: center;width: 100%;">
											<thead>
											<tr>
												<th>
													SR.
												</th>
												<th></th>
												<th>Item Description</th>
												<th>Qnty</th>
												<th>Approx Cost</th>
												<th>Category</th>
												<th>State</th>
												<th>Type</th>
												<th>Old_Part_Status</th>
											</tr>
										</thead>
										<tbody id="receive">								
											       <?php 
														$sql1 = "SELECT a.id,a.iid,a.item_code,d.category,b.item,a.qnty,a.rate,a.mc,a.department,a.state,a.plant,a.type,a.old_part_status from Requisition_details a
															LEFT OUTER JOIN rm_item b on a.item_code = b.i_code
															LEFT OUTER JOIN rm_category d on d.c_code = b.c_code
															where a.iid = '".$_GET['id']."' AND reject is NULL";
															$run1 = sqlsrv_query($con,$sql1);
															$count = 0;
														while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
														{	
															$count++;	

															$sql2 = " SELECT ReqItemDetailIDP , MCNO, Department, Plant, Employee, Qnty from Requisition_item_details where ReqHeadID = '".$row1['iid']."' and Req_Item_code = '".$row1['item_code']."'";
															$run2=sqlsrv_query($con,$sql2);
															$row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
											 			?>
											<tr>

												<td name="sr" id="sr"><?php echo $count; ?>
													
												</td>
												<td>
													<button type="button" class="btn btn-warning createbtnqty" id="view<?php echo $count; ?>" data-id="<?php echo $row1['iid']."~".$row1['item_code']; ?>">View</button>
													
												</td>
												<td ><input type="text"  value="<?php echo $row1['item']; ?>" name="item_desc[]" onFocus="SearchItem(this)" class="form-control item" id="1Des" required><input type="hidden" value="<?php echo $row1['item_code']; ?>" name="i_code[]" class="i_code"><input type="hidden" name="new_row[]" value="<?php echo $row1['id']; ?>"></td>
												<td ><input type="number" step="0.01" value="<?php echo $row1['qnty']; ?>"  name="Qnty[]" class="form-control" id="Qnt" required></td>
												<td ><input type="number" step="0.01"  name="apx_cost[]" value="<?php echo $row1['rate']; ?>" class="form-control" id="apx_cost"></td>
												
												<td  >
													<input type="text" name="category[]" class="form-control category" value="<?php echo $row1['category']; ?>" id="category" readonly>
												</td>
												<td  >
													<select class="form-select" aria-label="Default select example" id="state" name="state[]">
														<option class="bg-dark text-white"><?php echo $row1['state']; ?></option>
														<option class="bg-dark text-white">Capital</option>
														<option class="bg-dark text-white">Consumable</option>
														<option class="bg-dark text-white">Raw Material</option>
													</select>
												</td>
												<td >
													<select  class="form-select type" aria-label="Default select example" id="type" name="status[]"  required>
														<option class="bg-dark text-white"><?php echo $row1['type']; ?></option>
														<option  class="bg-dark text-white">New</option>
														<option  class="bg-dark text-white">Replace</option>
														
													</select>
												</td>
												<td>
													<select  class="form-select hideit" aria-label="Default select example" id="old_part" name="old_part[]" >
														<option class="bg-dark text-white"><?php echo $row1['old_part_status']; ?></option>
														<option  class="bg-dark text-white">Repair</option>
														<option  class="bg-dark text-white">Stock</option>
														<option  class="bg-dark text-white">Scrap</option>
													</select>
												</td>
											</tr>
											<?php 
										}
											 ?>
											 <input type="hidden" value="<?php echo $count; ?>" id="total_row_count">
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
function SearchMc(txtBoxRef,thisid,depid,plantid) {
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
// var self = this;
// $(self).closest('tr').find('.mcno').val(ui.item.label);
// $(self).closest('tr').find('.dept').val(ui.item.dname);
// $(self).closest('tr').find('.plant').val(ui.item.plant);

$('#'+thisid).val(ui.item.label);
$('#'+depid).val(ui.item.dname);
$('#'+plantid).val(ui.item.plant);


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
//$(this).closest('tr').find('.dept').prop('readonly', true);

}


}
});
}
			// Department autocomplete box
function SearchDpnt(txtBoxRef,thisid,mcid,plantid) 
{
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
// var self = this;
// $(self).closest('tr').find('.dept').val(ui.item.label);
// $(self).closest('tr').find('.plant').val(ui.item.plant);

$('#'+mcid).val('');
$('#'+thisid).val(ui.item.label);
$('#'+plantid).val(ui.item.plant);


return false;
},
change: function (event, ui)  //if not selected from Suggestion
{

if (ui.item == null)
{
$(this).val('');
$(this).focus();
}

}


});
}



function SearchEmployee(txtBoxRef,thisid) 
{  

    console.log('function call');
    var f = true; //check if enter is detected
    $(txtBoxRef).keypress(function (e) 
    {
	    if (e.keyCode == '13' || e.which == '13')
	    {
	    	f = false;
	    }
    });
    $(txtBoxRef).autocomplete
    ({
	    source: function( request, response ) 
	    {
		    // Fetch data
		    $.ajax({
		    url: "../payment_sys/getUserlist.php",
		    type: 'post',
		    dataType: "json",
		    data: {
		    indentor: request.term
		    },
		    success: function( data ) 
		    {
		    	response( data );
		    	console.log(data);
	    	}
	    });
	    },
	    select: function (event, ui) 
	    {
	    	// Set selection
		    $(this).closest('div').find('#'+thisid).val(ui.item.label);


	       

		    //$(this).closest('div').find('.mcno').val(ui.item.dpnt);
		    //$('.dpnt').val(ui.item.dpnt);
		    return false;
	    },
	    change: function (event, ui)  //if not selected from Suggestion
	    {
		    if(f)
		    {
			    if (ui.item == null)
			    {
			    	$(this).val('');
			    	$(this).focus();
			    }
	    	}
	    }
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
$(self).closest('tr').find('.new_row').val("new");

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


	// add button coding
var abc = $("#total_row_count").val();
$("#newbtn").click(function()
{
	var xyz = $('#'+abc+'Des').val();
	if (xyz == "") {
	alert('Please fill Current Information (कृपया पहले जानकारी भरें)');
	}
	else
	{
	abc++;
	var rowHtml = '<tr>';
				rowHtml += '<td  name="sr" id="sr">'+abc+'</td>';
				rowHtml += '<td><button type="button" class="btn btn-warning createbtnqty1" value="'+abc+'Qnt" id="viewbtn'+abc+'">View</button></td>';
				//rowHtml += '<td></td>';
				rowHtml += '<td ><input type="text" name="item_desc[]" class="form-control item" onFocus="SearchItem(this)"  id="'+abc+'Des" required><input type="hidden" name="i_code[]" class="i_code" id="i_code1"><input type="hidden" name="new_row[]" class="new_row"></td>';
			rowHtml += '<td ><input type="number" step="0.01" name="Qnty[]" class="form-control"  id="'+abc+'Qnt" required></td>';
			rowHtml += '<td ><input type="number" step="0.01" name="apx_cost[]" class="form-control"  id="'+abc+'apx_cost"></td>';
				rowHtml += '<td><input type="text" name="category[]" class="form-control category"  id="'+abc+'category" readonly></td>';
				rowHtml += '<td ><select class="form-select" aria-label="Default select example" id="'+abc+'state" name="state[]" ><option></option><option class="bg-dark text-white">Capital</option><option class="bg-dark text-white">Consumable</option><option class="bg-dark text-white">Raw Material</option></select></td>';
				rowHtml += '<td ><select class="form-select type" aria-label="Default select example" id="type" name="status[]"  required><option></option><option  class="bg-dark text-white">New</option><option  class="bg-dark text-white">Replace</option></select></td>';
				rowHtml += '<td style="width:150px" ><select class="form-select hideit" aria-label="Default select example" id="'+abc+'old_part" name="old_part[]" ><option></option><option  class="bg-dark text-white">Repair</option><option  class="bg-dark text-white">Stock</option><option  class="bg-dark text-white">Scrap</option></select></td>';

	rowHtml += '</tr>';
	$('table').find('tbody').append(rowHtml)
	$('#'+abc+'old_part').hide();
	}
});

$(document).on('change','#type',function()
{
	var a = $(this).val();
		if (a == 'Replace') 
		{
			$(this).closest('tr').find(".hideit").show();
			$(".hidelable").show();
			//$(this).closest('tr').find("#upload3,#upload4").attr('required', true);
		}
	else {
			$(this).closest('tr').find(".hideit").hide();
			//$(this).closest('tr').find("#upload3,#upload4").attr('required', false);
		}
});


$(document).on('click','.createbtnqty',function()
{
    var x = $(this).attr('data-id');
    var str = x.split("~");

 	$.ajax({
    url: "../payment_sys/mrsmodaldata.php?status=2",
    type: 'post',
    data: {reqheadid:str[0],itemcode:str[1]},
    success: function( data ) 
    {
        $("#t_body_create").html(data);
        $("#createqty").modal('show');
    }
	});
});


$(document).on('click','.closebtn',function()
{
	var reqid = $(".tempreq").val();
	var id = '';
	$('.ReqItemDetailIDP').each(function()
    {
        id += $(this).closest('tr').find('.ReqItemDetailIDP').val();
        id += ',';
    });
	if(reqid == "")
	{
		var t = "";
	}
	else
	{
		var t = ',';
	}
	var temp = reqid+t+id;
	$("#tempreq").val(temp.slice(0,-1));


	$('.mcno').each(function()
	        {
	            mc += $(this).closest('tr').find('.mcno').val();
	            mc += ',';
	        });
	        $("#tempmc").val(mc.slice(0, -1));


	        $('.dept').each(function(i)
	        {
	            dept += $(this).closest('tr').find('.dept').val();
	            dept += ',';
	        });
	        $("#tempdept").val(dept.slice(0, -1));


	        
	        $('.plant').each(function(i)
	        {
	            plant += $(this).closest('tr').find('.plant').val();
	            plant += ',';
	        });
	        $("#tempplant").val(plant.slice(0,-1));

			
			
	        $('.indentorEmp').each(function(i)
	        {
	            tempemp += $(this).closest('tr').find('.indentorEmp').val();
	            tempemp += ',';
	        });
	        $("#tempemp").val(tempemp.slice(0,-1));

	        
		    $('.Qnty').each(function(i)
		    {
		        tempqnty += $(this).closest('tr').find('.Qnty').val();
		        tempqnty += ',';
		    });
		    $("#tempqnty").val(tempqnty.slice(0,-1));


		    $('.itemnew').each(function(i)
		    {
		        itemtemp += $(this).closest('tr').find('.itemnew').val();
		        itemtemp += ',';
		    });
		    $("#tempicode").val(itemtemp.slice(0,-1));

});




$(document).on('click','.createbtnqty1',function()
{
	var x = $(this).val();
	var qnty = $("#"+x).val();
	var item = $("#i_code1").val();
	
	$.ajax({
    url: "../payment_sys/mrsmodaldata.php?status=3",
    type: 'post',
    data: {qty:qnty},
    success: function( data ) 
    {
        $("#t_body_create1").html(data);
        $("#totalqty1").text(qnty);
        $('#totaladdqnty1').text(qnty);
        $("#createqty1").modal('show');
        $("#ItemNew1").val(item);
    }
});
});


var itemtemp = '';
var mc = '';		
var dept = '';
var plant = '';
var tempemp = ''; 
var tempqnty = '';       
function checkQnty()
{
	if(confirm('Do you really want to submit the form?'))
	{
		var id = 0;
		$('.Qnty').each(function(i)
		{
			id += parseFloat($(this).val());
		});
	}

	var mcvalid = $(".mcno").val();

	if(mcvalid == "")
	{
		alert("Please Enter Mcno/Dept/Plant");
		$('#createqty1').modal({backdrop: 'static', keyboard: false})  
	}
	else
	{
		var totalqty = $("#totalqty1").text();
		
		if(totalqty != id)
		{
			alert('Qnty must be equal as Total Qnty.')
			return false;
		}
		else
		{	

	        $('.mcno').each(function()
	        {
	            mc += $(this).closest('tr').find('.mcno').val();
	            mc += ',';
	        });
	        $("#tempmc").val(mc.slice(0, -1));


	        $('.dept').each(function(i)
	        {
	            dept += $(this).closest('tr').find('.dept').val();
	            dept += ',';
	        });
	        $("#tempdept").val(dept.slice(0, -1));


	        
	        $('.plant').each(function(i)
	        {
	            plant += $(this).closest('tr').find('.plant').val();
	            plant += ',';
	        });
	        $("#tempplant").val(plant.slice(0,-1));

			
			
	        $('.indentorEmp').each(function(i)
	        {
	            tempemp += $(this).closest('tr').find('.indentorEmp').val();
	            tempemp += ',';
	        });
	        $("#tempemp").val(tempemp.slice(0,-1));

	        
		    $('.Qnty').each(function(i)
		    {
		        tempqnty += $(this).closest('tr').find('.Qnty').val();
		        tempqnty += ',';
		    });
		    $("#tempqnty").val(tempqnty.slice(0,-1));


		    $('.itemnew').each(function(i)
		    {
		        itemtemp += $(this).closest('tr').find('.itemnew').val();
		        itemtemp += ',';
		    });
		    $("#tempicode").val(itemtemp.slice(0,-1));

		    

		    $('#createqty1').modal('hide');  

			return true;
		}
	}
}


var abc = 1;
$(document).on('click','.addrow',function()
{
	var xyz = $("#plant1").val();
	var Qnt = $('#totaladdqnty1').text();
	var totalqty = $("#totalqty1").text();
	var i = $('#ItemNew1').val();
	
	if (xyz == "") 
	{
	  	alert('Please fill Current Information.');
	}
	else if(Qnt > totalqty)
	{	
		alert("Qnty must be less than Total Qnty");
		$("#Qnt").val("");
	}
	else if(Qnt == totalqty)
	{
		$(".addrow").css("disable", true);
	}
	else if(Qnt != totalqty)
	{
		// for(var i = Qnt;i < totalqty; i++)
		// {
		abc++;
		mcid = 'mc'+abc;
		deptid = 'dept'+abc;
		plantid = 'plant'+abc;
		var rowHtml = '<tr>';
		  rowHtml += '<td><input type="text" name="srno[]" value="'+abc+'" class="form-control" readonly></td>';
		  rowHtml += '<td><input type="text" name="mc_new[]" class="form-control mcno" onFocus="SearchMc(this,this.id,deptid,plantid)" id="mc'+abc+'" required></td>';
		  rowHtml += '<td><input type="text" name="dept_new[]"  onFocus="SearchDpnt(this,this.id,mcid,plantid)" class="form-control dept" id="dept'+abc+'" required></td>';
		  rowHtml += '<td><input type="text" name="plant_new[]" class="form-control plant" id="plant'+abc+'" required></td>';
		  rowHtml += '<td><input type="text" name="matApprovee_new[]" id="matApprove'+abc+'" class="form-control indentorEmp" onFocus="SearchEmployee(this,this.id)"  required></td>';
		  rowHtml += '<td><input type="text" name="Qnty_new[]" class="form-control Qnty" style="width:80px" id="Qnt'+abc+'" required></td>';
		  rowHtml += '<td><input type="hidden" name="item_new[]" class="form-control itemnew" style="width:80px" id="ItemNew'+abc+'" required></td>';
		  rowHtml += '<td><input type="button" class="btn btn-danger tr_remove" value="X"></td>';
		rowHtml += '</tr>';

		$('table').find('.tbody').append(rowHtml);

		$('.itemnew').val(i);
	}
});

$(document).on('click','.tr_remove',function()
{
	var abc = 1;
    $(this).closest('tr').remove();
    
    var Qnt = 0;
	$('.Qnty').each(function(i)
	{
		Qnt += parseFloat($(this).val());
	});
	$('#totaladdqnty').text(Qnt);

});


$(document).on('change','.Qnty',function()
{
	var Qnt = 0;
	$('.Qnty').each(function(i)
	{
		Qnt += parseFloat($(this).val());
	});
	$('#totaladdqnty1').text(Qnt);
});
</script>