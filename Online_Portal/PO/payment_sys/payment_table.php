<?php
session_start();
if ($_SESSION['oid'] =='snehal' || $_SESSION['oid'] =='Rajnish' || $_SESSION['oid'] =='dipen' || $_SESSION['oid'] =='himanshu' || $_SESSION['oid'] =='Pratik' || $_SESSION['oid'] =='manish' || $_SESSION['oid'] =='rohan' || $_SESSION['oid'] =='janki' || $_SESSION['oid'] =='jigar') {
    ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Payment</title>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
		<!------------------------ BT-5 CSS -------------------------------------->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
		<!------------------------ BT-5 JS -------------------------------------->
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
		<script src="https://momentjs.com/downloads/moment.min.js"></script>
		<script src="https://cdn.datatables.net/plug-ins/1.10.13/sorting/datetime-moment.js"></script>
		<!-- jQuery UI -->
		
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />
		
		<style type="text/css" media="screen">
			@import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700);
		body{
		  /* background: -webkit-linear-gradient(left, #25c481, #25b7c4);
		  background: linear-gradient(to right, #25c481, #25b7c4); */
		  font-family: 'Roboto', sans-serif;
		  /* background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab); */
		  	background: linear-gradient(-45deg,#dfff62, #c99b6bcc, #c1b6f9, #23d5ab);
			animation: gradient 15s ease infinite;
			height: 100vh;
		}
		@keyframes gradient {
			0% {
				background-position: 0% 50%;
			}
			50% {
				background-position: 100% 50%;
			}
			100% {
				background-position: 0% 50%;
			}
		}

		#trow{
			background: -webkit-linear-gradient(left, #2a88a4, #1a3234d6);
			 background: linear-gradient(to right, #2a88a4, #14084c);
			color: white;
			font-weight: bold;
		}
		#trow th{
			text-align: center;
			padding: 8px 0px !important;		
		}
		.trow1  td{
			background-color: #2196f329;
			font-size: 14px;
			padding: 4px 0px !important;
		}
		.trow1  td input{
			background-color: #2196f300;
			font-size: 14px;
			padding: 8px 0px !important;
		}
		td.hlight {
			font-weight: bold;
			color: red;
		}
		.form-input , .form-label{
				font-family:Bahnschrift Condensed;
				font-size: 15px;
		}
		#pay,input[type="button"]{
				font-size: 14 px;
				font-family: cursive;
				font-weight: bold;
				width: 80px;	
			}
			.show_inv{
				color: black !important;
			}
			.history_head{
				font-size: 15px;
				font-family: sans-serif;
			}
			.history_head2{
				font-size: 14px;
				font-family: cursive;
			}
			.history_head3{
				font-size: 13px;
				font-family: cursive;
				padding-left: 4px;
			}
			input.largerCheckbox {
		    	transform : scale(1.7);
		    	margin-top: 10px;
		   }
		  #r1{
		  	box-shadow: 0 7px 25px rgba(0, 0, 0, 0.2);
		  	background-color: #808080a8;
		  	border-radius: 8px;
		  }
		 input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
		  -webkit-appearance: none;
		 	margin: 0;
		}
		</style>
	</head>
	<body>
		<form action="payment_db.php" method="post">
		<div class="row p-3 m-3" id="r1">
			<div class="row col-12 py-1">
				<div class="col-3 text-right">
					<a href="../../dashboard.php" class="btn btn-warning font-weight-bold m-2 px-4"><b>Back</b></a>
					<select id="serch_rep" class="btn btn-success m-1 px-2">
						<option value="all"><b>All</b> </option>
						<option value="lweek">Last Week</option>
						<option value="cweek">Current Week</option>
						<option value="nweek">Next Week</option>
					</select>
					<button type="submit" id="save" name="save" class="btn btn-primary font-weight-bold m-2 px-4"><b>Pay</b></button>
				</div>
				<div class="col-3 text-left">
					<!-- <a href="pymt_report.php" class="btn btn-info font-weight-bold btn-sm m-1">View Payment</a> -->
				</div>
				<div class="col-3 text-left">
					<!-- <button type="button" name="btn_jw" id="btn_jw" class="btn btn-primary font-weight-bold btn-sm m-1">Job Work</button> -->
				</div>
			</div>
			<div class="row py-3">
		      <div class="col-lg-2 col-md-4 col-sm-4">
		          <input type="text" name="total_amt" id="total" value="0" class="form-control">
		      </div>
		      <div class="col-lg-2 col-md-4 col-sm-4">
		          <input type="text" id="trans_id" name="trans_id" class="form-control" placeholder="Trans_id" required>
		      </div>
	        <div class="col-lg-2 col-md-4 col-sm-4">
	        	<select class="form-control" id="payment_mode" name="payment_mode" required>
	            <option  value="" disabled="true" selected="true">Payment Mode</option>    
	            <option value="Check">Check</option>
	            <option value="BOB_Next">BOB Next</option>
	            <option value="ICICI"> ICICI </option>
	            <option value="RTGS">RTGS</option>
	            <option value="NEFT">NEFT</option>
	            <option value="Credit_Card">Credit Card</option>
	            <option value="Cash">Cash</option>
	          </select>   
	        </div>
	        <div class="col-lg-2 col-md-4 col-sm-4">
	        <input type="date" id="payment_date" name="pay_date" value="<?php echo date('Y-m-d', time())?>" min="2021-01-01" max="2025-01-01" class="form-control" required>
	      </div> 
	      <div class="col-lg-4 col-md-4 col-sm-4" style="padding-right:35px;">
	    <textarea class="form-control" id="remark" name="remark" style="margin-left:20px;" placeholder="Enter Your Remark "rows="1"></textarea>
	  </div>
	</div>
	</div>
		<br>
		<?php if (isset($_SESSION['mess'])): ?>
		<div class="alert alert-primary font-weight-bold font-italic">
			<?php echo $_SESSION['mess']; ?>
		</div>
		<?php unset($_SESSION['mess']); ?>
		<?php endif; ?>
		<div class="table-responsive container-fluid m-1" id="order_table">
			<table class="table table-hover" id="employee_data">
				<thead>
					<tr class="" id="trow">
						<th>Bill Date</th>
						<th style="width: 40px;">Bill No</th>
						<th>Rmta</th>
						<th  style="width: 280px;">Party</th>
						<th>mat_ord_by</th>
						<th>Bill_Amt</th>
						<th style="width: 80px;">Bal_amt</th>
						<th style="width: 80px;">Due Date</th>
						<th style="width: 120px;">Aprv_By</th>
						<th>Paid Amt</th>
						<th>Ctrl</th>
						<th class="text-center"  style="width: 80px;">Control</th>
					</tr>
				</thead>
				<?php
                include('..\..\..\dbcon.php');
    $sql="SELECT a.sr_no,a.receive_at,a.invoice_no,a.invoice_date,b.party_name,a.mat_from_party,a.mat_ord_by,a.total_bill_amt,SUM(isnull(payment_amt,0)) as payAmt,a.payment_due,a.approve_by from inward_com a
					left outer join rm_party_master b on a.mat_from_party = b.pid
					left outer join payment_table c on a.sr_no = c.sr_no and a.receive_at = c.receive_at
					where a.bill_receive = 1 AND a.bill_send = 1 AND a.invoice_date > '2021-09-01'
					group by a.sr_no,a.receive_at,a.invoice_no,a.invoice_date,b.party_name,a.mat_from_party,a.mat_ord_by,a.total_bill_amt,a.payment_due,a.approve_by
					HAVING (total_bill_amt - SUM(isnull(payment_amt,0))) > 10
					ORDER BY payment_due asc";

    $run=sqlsrv_query($con, $sql);
    $params = array();
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $run1=sqlsrv_query($con, $sql, $params, $options);
    $row1=sqlsrv_num_rows($run1);
    if ($row1 > 0) {
        ?>
					<?php
                while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
                    $sqlin = "SELECT invoice_aprove from inward_com where sr_no = '".$row['sr_no']."' AND receive_at = '".$row['receive_at']."'";
                    $runin = sqlsrv_query($con, $sqlin);
                    $rowin = sqlsrv_fetch_array($runin, SQLSRV_FETCH_ASSOC); ?>
				<tr class="text-center font-italic trow1 ">
					<td data-search="<?php echo $row['invoice_date']->format('d-M-Y'); ?>"><input type="text" name="idate[]" value="<?php echo $row['invoice_date']->format('d-M-Y'); ?>" style="border: none;outline: none;box-shadow: none; text-align: center;" readonly></td>
					<td data-search="<?php echo $row['invoice_no']; ?>"><input type="text" name="ino[]" value="<?php echo $row['invoice_no']; ?>" style="border: none;outline: none;box-shadow: none; text-align: center;" readonly></td>
					<td data-search="<?php echo $row['sr_no']."_(".$row['receive_at'].")"; ?>"><input type="text" value="<?php echo $row['sr_no']."_(".$row['receive_at'].")"; ?>" style="border: none;outline: none;box-shadow: none; text-align: center;"><input type="hidden" name="sr_no[]" value="<?php echo $row['sr_no']; ?>"><input type="hidden" name="receive[]" value="<?php echo $row['receive_at']; ?>"></td>
					<td data-search="<?php echo $row['party_name']; ?>"><input type="text" value="<?php echo $row['party_name']; ?>" style="border: none;outline: none;box-shadow: none; text-align: center;"><input type="hidden" name="pname[]" value="<?php echo $row['mat_from_party']; ?>"></td>
					<td data-search="<?php echo $row['mat_ord_by']; ?>"><input type="text" name="matby[]" value="<?php echo $row['mat_ord_by']; ?>" style="border: none;outline: none;box-shadow: none; text-align: center;"></td>
					<td data-search="<?php echo $row['total_bill_amt']; ?>"><input type="text" name="total[]" value="<?php echo $row['total_bill_amt']; ?>" style="border: none;outline: none;box-shadow: none; text-align: center;" readonly></td>
					<td id="bill_amt_value" data-search="<?php echo $row['total_bill_amt']-$row['payAmt']; ?>"><input type="text" name="value[]" value="<?php echo $row['total_bill_amt']-$row['payAmt']; ?>" style="border: none;outline: none;box-shadow: none; text-align: center;" class="bal_amt" readonly></td>
					<td data-search="<?php echo $row['payment_due']->format('d-M-Y'); ?>"><input type="text" name="due[]" value="<?php echo $row['payment_due']->format('d-M-Y'); ?>" style="border: none;outline: none;box-shadow: none; text-align: center;"></td>
					<td class="px-5"><?php echo $row['approve_by']; ?></td>
					<td><input type="number" step="0.01" name="paid_amt[]" class="paid_amt form-control form-control-sm w-75" style="min-width: 110px;"></td>
					<td>
						<div class="dropdown">
					    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
					      control
					    </button>
					    <ul class="dropdown-menu">
					      <li><a class="dropdown-item"><input type="button" class="btn btn-warning show_data p-1" name="show" value="Track" id="<?php echo $row['sr_no'].$row['receive_at'] ?>" /></a></li>
					      <li><a class="dropdown-item"><input type="button" class="btn btn-info show_history p-1" name="show" value="History" id="<?php echo $row['sr_no'].$row['receive_at'] ?>"/></a></li>
					      <li><a class="dropdown-item"><input type="button" class="btn btn-primary show_inv p-1" name="show" value="Show" id="<?php echo $rowin['invoice_aprove']; ?>" /></a></li>
					    </ul>
					  </div>
					</td>
					<td><input type="checkbox" class="largerCheckbox" id="check_box"/><input type="hidden" name="check[]" class="check"></td>
				</tr>
				<?php
                } ?>
				<?php
    } else {
    } ?>
			</table>
		</div>
		<!-- Large modal -->
		<div class="modal fade bd-example-modal-lg" id="traceability_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header bg-info text-white">
						<h4 class="modal-title font-weight-bold font-italic">Purchase Traceability</h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						
					</div>
					<div class="modal-body" id="traceability_table">
						<!-- Dynamic Table from ajax load -->
					</div>
					
				</div>
			</div>
		</div>
				<!-- History modal -->
		<div class="modal fade bd-example-modal-lg" id="history_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header bg-info text-white">
						<h4 class="modal-title font-weight-bold font-italic">Purchase History</h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						
					</div>
					<div class="modal-body" id="history_table">
						<!-- Dynamic Table from ajax load -->
					</div>
					
				</div>
			</div>
		</div>
		</form>
<script type="text/javascript">
	$(document).ready(function(){
		// Weekly Report Start
		$("#serch_rep").on("change",function(){
			var x = $(this).val();
			$.ajax({
				url:"get_ptable.php",
				method:"POST",
				data:{x:x},
				success:function(data)
				{
				$('#order_table').html(data);
			}
		});
		});

		$('#employee_data').DataTable({
			"createdRow": function ( row, data, index ) {
				if ( data[8] == 'pending' ) {
					$('td', row).eq(8).addClass('hlight');
				}
			},
			"processing": true,
			"order": [[ 7, "asc" ]],
				dom: 'lBfrtip',
			buttons: [
			{extend:'excel',exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],  
                            format: {
                            body: function ( data, row, column, node ) {
                            //check if type is input using jquery
                            return $(data).is("input") ?
                            $(data).val():
                            data;
                            }
                            }
                            }},
			],
			"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
		});
			$("#btn_jw").on("click",function(){
				window.open('JW/payment_table.php','_self');
			});
			// Traceability Modal
			$(document).on('click', '.show_data', function(){
				var x = $(this).attr("id");
				$.ajax({
				url:"traceOnModal.php",
				method:"POST",
				data:{x:x},
				success:function(data)
				{
					$('#traceability_table').html(data);
					$('#traceability_modal').modal('show');
				}
			});
		});
			// History Modal
	$(document).on('click', '.show_history', function(){
		var x = $(this).attr("id");
			$.ajax({
				url:"historyOnModal.php",
				method:"POST",
				data:{x:x},
				success:function(data)
				{
					$('#history_table').html(data);
					$('#history_modal').modal('show');
				}
			});
		});
				
	});
		$(document).on('click', '.show_inv', function(){
		var x = $(this).attr("id");
		if (x != null && x != 0) {
		newwindow=window.open('../payment_sys/invoice/'+x,'_blank','height=500,width=500,left=300,top=50');
		if (window.focus) {newwindow.focus()}
		return false;
		}
		else{
			alert("यह बिल अभी अपलोड नहीं हुआ है");
		}
		//alert(x);
		});

		
        // convert to currency
         const toIndianCurrency = (num) => {
         const curr = num.toLocaleString('en-IN', {
            style: 'currency',
            currency: 'INR'
         });
          return curr;
          };

  // Convert from currency to currency in word

  const wordify = (num) => {
   const single = ["Zero", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine"];
   const double = ["Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"];
   const tens = ["", "Ten", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
   const formatTenth = (digit, prev) => {
      return 0 == digit ? "" : " " + (1 == digit ? double[prev] : tens[digit])
   };
   const formatOther = (digit, next, denom) => {
      return (0 != digit && 1 != next ? " " + single[digit] : "") + (0 != next || digit > 0 ? " " + denom : "")
   };
   let res = "";
   let index = 0;
   let digit = 0;
   let next = 0;
   let words = [];
   if (num += "", isNaN(parseInt(num))){
      res = "";
   }
   else if (parseInt(num) > 0 && num.length <= 10) {
      for (index = num.length - 1; index >= 0; index--) switch (digit = num[index] - 0, next = index > 0 ? num[index - 1] - 0 : 0, num.length - index - 1) {
         case 0:
            words.push(formatOther(digit, next, ""));
         break;
         case 1:
            words.push(formatTenth(digit, num[index + 1]));
            break;
         case 2:
            words.push(0 != digit ? " " + single[digit] + " Hundred" + (0 != num[index + 1] && 0 != num[index + 2] ? " and" : "") : "");
            break;
         case 3:
            words.push(formatOther(digit, next, "Thousand"));
            break;
         case 4:
            words.push(formatTenth(digit, num[index + 1]));
            break;
         case 5:
            words.push(formatOther(digit, next, "Lakh"));
            break;
         case 6:
            words.push(formatTenth(digit, num[index + 1]));
            break;
         case 7:
            words.push(formatOther(digit, next, "Crore"));
            break;
         case 8:
            words.push(formatTenth(digit, num[index + 1]));
            break;
         case 9:
            words.push(0 != digit ? " " + single[digit] + " Hundred" + (0 != num[index + 1] || 0 != num[index + 2] ? " and" : " Crore") : "")
      };
      res = words.reverse().join("")
   } else res = "";
   return res
};
			
	function popitup(url) {
		newwindow=window.open(url,'_blank');
		if (window.focus) {newwindow.focus()}
		return false;
	}

	// Add bill_amt value to textbox
	 $(document).ready(function(){
	 	
	    $(document).on('click', '#check_box', function(){
	        var bill = ($(this).closest('tr').find('.bal_amt').val() == '') ? 0 : $(this).closest('tr').find('.bal_amt').val();
	        var paid = ($(this).closest('tr').find('.paid_amt').val() == '') ? 0 : $(this).closest('tr').find('.paid_amt').val();
	        var tot = $("#total").val();
	         if(this.checked)
	      	{
	      		 $(this).closest('tr').find('.check').val('yes');
		      	if (paid > 0 ) {
		      		bill = paid;
		      	}
		        	else{
		        		var x = parseFloat(bill) + parseFloat(tot);
		        		$('#total').val((x).toFixed(2));
		        	}
		    	   $(this).closest('tr').find('.paid_amt').val(bill);
	      	}
	      	else{
		      	$(this).closest('tr').find('.check').val('');
		      	if (paid > 0 ) {
		      		bill = paid;
		      	}
		        	var x =  parseFloat(tot) - parseFloat(bill);
		        	$('#total').val((x).toFixed(2));
		         $(this).closest('tr').find('.paid_amt').val('');
	     		}
	     });

	    $('#save').click(function(){
			if(confirm("Are you sure you want to Send this?")){
				var id = [];
				$(':checkbox:checked').each(function(i){
					id[i] = $(this).val();
				});
				if(id.length === 0) //tell you if the array is empty
				{
					alert("Please Select atleast one checkbox");
					return false;
				}
			}
			else{
				return false;
			}
		});
    });
    // ------End------

    $(document).on('focusout','.paid_amt',function(){
    	var a = $(this).val();
    	var b = $(this).closest('tr').find('.bal_amt').val();
    	if(parseFloat(a) > parseFloat(b)){
    		alert('It should be less than balance amount');
    		$(this).val('');
    		$(this).focus();
    	}
    		var q = 0;
			$('.paid_amt').each(function(){
				var a = ($(this).val() == '') ? 0 : $(this).val();
				q += parseFloat(a);
				$('#total').val((q).toFixed(2));
			});
    });
	</script>
</body>
</html>
<?php
} else {
        $_SESSION['utype'] = "You Are Not Authorized!!";
        header("location:..\..\dashboard.php");
    }
?>