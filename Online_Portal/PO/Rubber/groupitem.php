<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Item</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	 <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


	<style type="text/css">
		body{
			background-color: #ff000014;
		}
		label{
			font-size: 17px;
		}
		table{
			width: 100%;
			/*margin: 20px 50px;*/
		}
		th{
			border: 1px solid black;
			padding: 5px;
			background-color: #808080bf;
			color: white;
		}
		.ui-autocomplete {
		    font-family: serif !important;
		    font-size: 15px !important;
		    max-height: 150px;
            overflow-y: auto;
        /* prevent horizontal scrollbar */
            overflow-x: hidden;
            background-color: #66d9ff !important;
            border-radius: 10px;
            z-index: 2150000000 !important;
        }   
        thead input{
        	border: none;
        	outline: none;
        	box-shadow: none;
        	background-color: transparent;
        }
        input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
		  -webkit-appearance: none;
		  margin: 0;
		}
		#error{
			color: red;
			font-size: 14px;
		}
	</style>
</head>
<body>
	<div class="container my-3">
		<form action="add_group.php" method="post" id="form">
		<div class="row mx-4">
			<div class="col-lg-2">
				<label class="mx-3 my-1 fw-bold">Group Name :</label>
			</div>
			<div class="col-lg-4">
				<input type="text" name="group" id="group" class="form-control" placeholder="Enter Group Name" required>
				<label id="error"></label>
			</div>
			<div class="col-lg-6">
				<button type="submit" class="btn btn-success text-white fw-bold px-3" name="submit">Save</button>
			</div>
		</div>
		<div class="m-3">
			<table class="">
				<thead>
					<tr>
						<td colspan="2"></td>
						<td><input type="text" id="total" name="total" class="text-center fw-bold"></td>
						<td class="float-end m-1"><button class="btn btn-danger fw-bold" id="add">ADD</button></td>
					</tr>
					<tr class="text-center">
						<th style="width:10%;">Sr No.</th>
						<th style="width:40%;">Item</th>
						<th style="width:20%;">Percentage%</th>
						<th style="width:30%;">Remark</th>
					</tr>
				</thead>
				<tbody id="t_body">
					<tr>
						<td><input type="number" value="1" class="form-control"></td>
						<td><input type="text" name="item[]" class="form-control item" id="1item" onFocus="Search(this)"><input type="hidden" name="icode[]" class="icode"></td>
						<td><input type="number" step="0.01" name="pers[]" class="form-control pers" required></td>
						<td><input type="text" name="remark[]" class="form-control"></td>
					</tr>
				</tbody>
			</table>
		</div>
		</form>
	</div>
</body>
</html>
<script type="text/javascript">
	var abc = 1;
	$("#add").click(function(){
		var xyz = $('#'+abc+'item').val();
		if (xyz == "") {
		  alert('Please fill Current Information (कृपया पहले जानकारी भरें)');
		}
		else
		{
		abc++;
		var rowHtml = '<tr>';
		  rowHtml += '<td><input type="number" value="'+abc+'" class="form-control"></td>';
		  rowHtml += '<td><input type="text" name="item[]" class="form-control item" id="'+abc+'1item" onFocus="Search(this)"><input type="hidden" name="icode[]" class="icode"></td>';
		  rowHtml += '<td><input type="number" step="0.01" name="pers[]" class="form-control pers" required></td>';
		  rowHtml += '<td><input type="text" name="remark[]" class="form-control"></td>';
		  rowHtml += '<td><input type="button" class="btn btn-danger tr_remove" value="X"></td>';
		rowHtml += '</tr>';

		$('table').find('#t_body').append(rowHtml)
		}
	});

  function Search(txtBoxRef) {
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
    url: "getitem.php",
    type: 'post',
    dataType: "json",
    data: {
     desc: request.term
    },
    success: function( data ) {
     response( data );
    }
   });
  },
  select: function (event, ui) {
   $(this).closest('tr').find('.item').val(ui.item.label);
  	$(this).closest('tr').find('.icode').val(ui.item.i_code);
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

	$(document).on('click','.tr_remove',function(){
          $(this).closest('tr').remove();
        });

	$(document).on('focusout','.pers',function(){
		var p = 0;
		$('.pers').each(function(){
			p += parseFloat(($(this).val() == '') ? 0 : $(this).val());
			$('#total').val((p).toFixed(2));
			if(p>100){
				alert("Per% can't grater then 100%");
				 $(this).val('');
            	 $(this).focus();
			}
		});

	});

	$('#form').submit(function(){
		var a = $('#total').val();
		if (a < 100) {
			alert("Per % Must be equal to 100");
			return false;
		}
	});

	$("#group").blur(function(){
            var group = $(this).val();

            $.ajax({
            url:"getitem.php",
            method:"POST",
            data:{group:group},
            dataType:"text",
            success:function(data){
            	var x = data.length;
		            if (x>1) {
		            $("#error").html(data);
		            $("#group").focus();
	                }else{
	                	$("#error").html('');
	                }
             
            }
            });
        });
	/*$( function() {
		$( ".item" ).autocomplete({
		  source: function( request, response ) {
		  // Fetch data
		  $.ajax({
		  url: "getitem.php",
		  type: 'post',
		  dataType: "json",
		  data: {
		  desc: request.term
		  },
		  success: function( data ) {
		  response( data );
		  }
		  });
		  },
		  select: function (event, ui) {
		  // Set selection
		  $(this).closest('tr').find('.item').val(ui.item.label);
		  $(this).closest('tr').find('.icode').val(ui.item.i_code);
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
	});*/

	 
</script>