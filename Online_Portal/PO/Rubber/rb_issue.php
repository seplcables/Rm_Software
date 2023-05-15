<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Rubber Isuue</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	 <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <style type="text/css">
    	label{
			font-size: 16px;
			white-space: nowrap;
			font-weight: bold;
		}
		table{
			width: 100%;
		}
		#table th{
			border: 1px solid black;
			padding: 5px;
			background-color: #808080bf;
			color: white;
		}
		.container{
			background-color: #e8eef373;
			border-radius: 10px;
			box-shadow: 0px 7px 10px rgba(0, 0, 0, 0.1);
		}
		.col-lg-3,.col-lg-2{
			padding: 2px;
		}
		/*-----model css-----*/
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
		    max-width: 300px;
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
		#add_model{
			background-color: #ff000014;
		}
    </style>
</head>
<body>
	<div class="text-center bg-info py-1 text-white">
		<h4>Rubber Issue</h4>
	</div>
	<div class="container mt-3 p-2">
		<form id="setform">
			<div class="row mt-3">
				<div class="col-lg-4">
					<a href="../../dashboard.php" class="btn btn-warning fw-bold mx-2">Back</a>
					<button type="button" name="save" class="btn btn-success fw-bold" id="save">Save</button>
				</div>
			</div>
			<div class="row ms-2 mt-3">
				<div class="col-lg-3"><label class="my-1">Date</label><input type="date" name="date" id="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required></div>
				<div class="col-lg-3"><label class="my-1">Batch Code</label><input type="text" name="bcode" class="form-control" required></div>
				<div class="col-lg-3"><label class="my-1">Job Number</label><input type="text" name="jobno" class="form-control" required></div>
				<div class="col-lg-2"><label class="my-1">Number Of Batch</label><input type="text" id="numberVal" class="form-control" required></div>
			</div>
			<div class="row mx-3 my-4">
				<table id="table">
					<thead>
						<tr>
							<td colspan="5"></td>
							<td class="float-end m-1"><button type="button" class="btn btn-danger btn-sm fw-bold" id="add">ADD</button></td>
						</tr>
						<tr class="text-center">
							<th style="width:5%;">Sr</th>
							<th style="width:10%;">Rmta</th>
							<th style="width:35%;">Item</th>
							<th style="width:10%;">Rate</th>
							<th style="width:15%;">Weight</th>
							<th style="width:15%;">Total Weight</th>
							<th style="width:15%;">Amount</th>
						</tr>
					</thead>
					<tbody id="tbody">
						<tr>
							<td><input type="number" name="sr[]" value="1" class="form-control" readonly></td>
							<td><input type="text" name="rmta[]" class="form-control rmta" id="1rmta" onFocus="Search(this)" required></td>
							<td class="addItem"><input type="text" name="item[]" class="form-control item" required></td>
							<td><input type="text" name="rate[]" class="form-control rate" readonly></td>
							<td><input type="text" class="form-control inputWeight"></td>
							<td><input type="text" name="weight[]" class="form-control weight" readonly></td>
							<td><input type="text" name="amount[]" class="form-control amount" readonly></td>
						</tr>
					</tbody>
				</table>
			</div>
		</form>
	</div>

</body>
</html>
<script type="text/javascript">

	function Search(txtBoxRef) {
  		console.log('function call');
    	var f = true; //check if enter is detected
    	$(txtBoxRef).keypress(function (e) {
        	if (e.keyCode == '13' || e.which == '13') {
            	f = false;
        	}
    	});
    	$(txtBoxRef).autocomplete({
       		source: function( request, response ) {
   				$.ajax({
    				url: "getitem.php",
    				type: 'post',
				    dataType: "json",
				    data: {
     					rmta: request.term
    				},
    				success: function( data ) {
    					response( data );
    				}
   				});
  			},
  			select: function (event, ui) {
   				$(this).closest('tr').find('.rmta').val(ui.item.label);
  				return false;
 			},
  			change: function (event, ui)  //if not selected from Suggestion
      		{
          		if (ui.item == null){
            		$(this).val('');
            		$(this).focus();
          		}else{
          			var rmta1 = ui.item.label;
          			var $this = $(this);
          			$.ajax({
	    				url: "getitem.php",
	    				type: 'post',
					    data: { rmta1: rmta1 },
	    				success: function( data ) {
	    					$this.closest('tr').find('.addItem').html(data);
	    					/*console.log(data);*/
	    				}
	   				});
          		}
        	}
		});     
	}
/*--------------------------- save data ----------------------------*/
	$(document).on('click','#save',function(){
		$.ajax({
			url: 'add_group.php',
			type: 'post',
			data: $('#setform').serialize(),
			success:function(data){
				alert(data);
				location.reload();
			}
		});
	});

/*--------------------------- add row ----------------------------*/
	var abc = 1;
	$("#add").click(function(){
		var xyz = $('#'+abc+'rmta').val();
		if (xyz == "") {
		  alert('Please fill Current Information (कृपया पहले जानकारी भरें)');
		}
		else
		{
		abc++;
		var rowHtml = '<tr>';
		  rowHtml += '<td><input type="number" name="sr[]" value="'+abc+'" class="form-control" readonly></td>';
		  rowHtml += '<td><input type="text" name="rmta[]" class="form-control rmta" id="'+abc+'rmta" required onFocus="Search(this)"></td>';
		  rowHtml += '<td class="addItem"><input type="text" name="item[]" class="form-control item" required></td>';
		  rowHtml += '<td><input type="text" name="rate[]" class="form-control rate" readonly></td>';
		  rowHtml += '<td><input type="text" class="form-control inputWeight"></td>';
		  rowHtml += '<td><input type="text" name="weight[]" class="form-control weight" required></td>';
		  rowHtml += '<td><input type="text" name="amount[]" class="form-control amount" readonly></td>';
		  rowHtml += '<td><input type="button" class="btn btn-danger tr_remove" value="X"></td>';
		rowHtml += '</tr>';

		$('table').find('#tbody').append(rowHtml)
		}
	});

	$(document).on('click','.tr_remove',function(){
        $(this).closest('tr').remove();
    });

/*--------------------------- get rate ----------------------------*/
	$(document).on('change','.item',function(){
		var item = $(this).val();
		var rmt = $(this).closest('tr').find('.rmta').val();
		var $this = $(this);
		$.ajax({
			url: "getitem.php",
			type: 'post',
		    data: {item:item,rmt:rmt},
			success: function( data ) {
				$this.closest('tr').find('.rate').val(data);
			}
		});
	});

/*--------------------------- get calculation of rate and weight ----------------------------*/
	$(document).on('change','.weight',function(){
		var w = $(this).val();
		var r = $(this).closest('tr').find('.rate').val();

		let num = w*r;
		let n = num.toFixed(2);

		$(this).closest('tr').find('.amount').val(n);

	});

	$(document).on('change','.inputWeight',function(){
		var a = $(this).val();
		var b = $('#numberVal').val();
		var r = $(this).closest('tr').find('.rate').val();

		let mul = a*b;
		let num = mul*r;
		$(this).closest('tr').find('.weight').val(mul.toFixed(2));
		$(this).closest('tr').find('.amount').val(num.toFixed(2));
	});
</script>