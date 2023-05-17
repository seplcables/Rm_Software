<?php session_start();
if (!isset($_SESSION['pur_user'])) {
    $_SESSION['utype'] = "You Are Not Authorized!!";
    header("location:..\dashboard.php");
}
     include('../../dbcon.php');
     if (isset($_SESSION['plant'])) {
         $plant = $_SESSION['plant'];
     } else {
         $plant = $_SESSION['from'];
     }
        $sql="SELECT MAX(sr_no) as sr_value1 FROM inward_com where receive_at='$plant'";
        $run=sqlsrv_query($con, $sql);
        $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
        $srno = $row['sr_value1'] + 1;

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Purchase Form</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	 <!-- jQuery Input mask -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
	 <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


	 <style type="text/css">
	 body{
	 		background-color: #ffff0030;
	 }
	 #search_po{
	 	width: 43%;
	 }
	  h4{
	 	font-size: 25px;
	 	color: blue;
	 	font-family: sans-serif;
	 }
	 .b1{
	 	background-color: #ffa778a1;
	 	padding: 7px;
	 }
	 .b1 input{
	 	width: 20%;
	 	padding: 4px;
	 	margin: 5px 10px;
	 }
	 .b1 button{
	 	padding: 4px 10px;
	 	margin: 5px 5px;
	 }
	 .container-fluid{
	 	padding-left: 40px;
	 }
	 	table{
	 		width: 95%;
	 	}
	 	input,select{
	 		width: 100%;
	 		margin: 2px;
	 		font-size: 14px;
	 	}
	 	.col-lg-3,.col-lg-4{
	 		box-shadow: 0 7px 25px rgba(0, 0, 0, 0.2);
	 		padding: 17px 10px;
	 		margin: 7px;
	 		border-radius: 10px;
	 		background-color: white;
	 	}
	 	td label{
	 		float: right !important;
	 		font-size: 14px;
	 	}
	 	.col-5,.col-4{
	 		padding-right: 0px !important;
	 	} 
	 	.row{
	 		margin: 0 !important;
	 	}

	 	.tab1{
	 		width: 36%;
	 		border: 1px solid black;
	 		margin-left: 0.5%;
	 		background-color: white;
	 	}
	 	.tab1 tr th{
	 		border: 1px solid black;
	 		padding: 4px;
	 		background-color: #747373;
	 		color: white;
	 		white-space: nowrap;
	 	}
	 	.tab1 tr td{
	 		border: 1px solid black;
	 		padding: 4px;
	 	}
	 	.tab1 input, .tab1 select{
	 		border: none;
	 		box-shadow: none;
	 		outline: none;
	 		width: 100%;
	 	}
	 	.tab2{
	 		width: 93%;
	 		border: 1px solid black;
	 		margin-left: 0.5%;
	 		background-color: white;
	 	}
	 	.tab2 tr th{
	 		border: 1px solid black;
	 		padding: 4px 6px;
	 		background-color: #747373;
	 		color: white;
	 		white-space: nowrap;
	 	}
	 	.tab2 tr td{
	 		border: 1px solid black;
	 		padding: 4px;
	 	}
	 	.tab2 input, .tab2 select{
	 		border: none;
	 		box-shadow: none;
	 		outline: none;
	 		width: 100%;
	 		font-size: 12px;
	 	}
	 	input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
		  -webkit-appearance: none;
		 	margin: 0;
		}
		#sr_error{
			color: red;
			font-weight: 500;
		}
	 /*--Input box style--*/
	 	.inputfile {
			width: 0.1px;
			height: 0.1px;
			opacity: 0;
			overflow: hidden;
			position: absolute;
			z-index: -1;
		}
		.inputfile + label {
		    font-size: 1.25em;
		    font-weight: 500;
		    color: white;
		    background-color: red;
		    display: inline-block;
		    margin-left: 25%;
		    border-radius: 5px;
		    padding-top: 2px;
		    padding-bottom: 2px;
		}
		.inputfile + label:hover {
		    background-color: green;
		}
		.inputfile + label {
			cursor: pointer; /* "hand" cursor */
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

        .upload-pi{
	        position: relative;
	        margin-left: auto;
	        margin-right: auto;
	        width: 10%;
	      }
	      .upload-pi:hover{
	        filter: drop-shadow(1px 1px 22px #7584bb);
	      }
	      #upload-profile{
	        position: absolute;
	        top: 10px;
	        z-index: 10;
	        width: 150px !important;
	        margin-top: 0px;
	       opacity: 0;
	      }
	      #upload-profile::webkit-file-upload-button{
	        visibility: hidden;
	      }
	      #upload-profile::before{
	        content: '';
	        display: inline-block;
	        width: 150px !important;
	        height: 150px !important;
	        cursor: pointer;
	        border-radius: 50%;
	      }
	      #sub_total{
	      	font-size: 15px;
	      	font-weight: 650;
	      	color: blue;
	      }

	 	@media only screen (max-width: 950px){
	 		.col-lg-3,.col-lg-2{
		 		padding: 20px 5px;
		 		margin: 0;
		 		border-radius: 10px;
	 		}
	 		
	 	}

	 </style>
	 <script type="text/javascript">
	 	$(document).on('change','#flexRadioDefault1',function() 
	    {
	        //$('#tcupload').show();
	        $('#tcremark').hide();
	    });
	    $(document).on('change','#flexRadioDefault2',function()
	    {
	       $('#tcremark').show(); 
	       //$('#tcupload').hide(); 
	    });

	 </script>
</head>
<body>
	<div class="row b1">
		<div class="col-5">
			<input type="text" name="search_po" id="search_po" placeholder="Search Po" class="form-control" form="form">
			<input type="hidden" name="poid" id="poid" form="form">
			<!-- <h4 class="text-white mt-1">ADD NEW PURCHASE</h4> -->
		</div>
		<div class="col-3">
			<h4 class="pt-1 text-center">PURCHASE ENTRY</h4>
		</div>
		<div class="col-4">
             <!-- <a href="../dashboard.php" class="nav-link btn btn-info mr-2">Back</a> -->
			<button class="float-end btn btn-light px-4" id="back"><b>Back</b></button>
			<button class="float-end btn btn-light px-4" id="save" name="saveAsNew" value="saveAsNew" form="form"><b>Save As New</b></button>
			<button class="float-end btn btn-light px-4" id="save" value="saveAsExit" name="saveAsExit" form="form"><b>Save As Exit</b></button>
		</div>	
	</div><br>
	<div class="container-fluid">
		<form action="Purchase_db.php" id="form" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="col-lg-4">
					<table>
						<tr class="row mt-2"> 
							<td class="col-4"><label>Receive At :</label></td>
							<td class="col-8">
								<select name="received_at" class="p-1" id="received_at" required>
	                                <option value="<?php echo $plant ?>"><?php echo $plant ?></option>
	                                <option value="Halol">Halol</option>
	                                <option value="D_Halol">D_Halol</option>
	                                <option value="Job_Halol">Job_Halol</option>
	                                <option value="696_plant">696</option>
	                                <option value="D_696_plant">D_696</option>
	                                <option value="baroda">Baroda</option>
	                                <option value="D_baroda">D_Baroda</option>
	                            </select>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Rmta :</label></td>
							<td class="col-8"><input type="number" name="srno" id="srno" required value="<?php echo $srno; ?>"></td>
							<td class="col-8"><label id="sr_error"></label></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Receive Date :</label></td>
							<td class="col-8"><input type="text" name="receive_date" id="receive_date" placeholder="DD-MM-YYYY" required></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Payment Days :</label></td>
							<td class="col-8"><input type="number" name="p_days" id="p_days" required><input type="hidden" class="" name="due_days" id="due_days" readonly></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Challan No :</label></td>
							<td class="col-8"><input type="text" name="challan_no" id="challan_no"></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Invoice Date :</label></td>
							<td class="col-8"><input type="text" name="invoice_date" id="invoice_date" placeholder="DD-MM-YYYY" required></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Invoice No. :</label></td>
							<td class="col-8"><input type="text" name="invoice_no" id="invoice_no" required></td>
						</tr>
					</table>
				</div>

				<div class="col-lg-4">
					<table>
						<tr class="row"> 
							<td class="col-4"><label>Party :</label></td>
							<td class="col-8"><input type="text" name="party" id="party" required><input type="hidden" name="pid" id="pid" required></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Mat. Order By :</label></td>
							<td class="col-8"><input type="text" name="po_gen_by" id="po_gen_by" required></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Department :</label></td>
							<td class="col-8"><input type="text" name="department" id="department"></td>
						</tr>
						<tr class="row">
							<!-- <td class="col-4"><label>Material Type :</label></td>
							<td class="col-8"><input type="text" name="mat_type" id="mat_type" required><input type="hidden" name="c_code" id="c_code"></td> -->
						</tr>
						<tr>
							<td class="pt-5"></td>
							<td class="pt-5"></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Weight :</label></td>
							<td class="col-8"><input type="number" step="0.01" name="weight" id="weight"></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Total Qnty :</label></td>
							<td class="col-8"><input type="text" name="total_qnty" id="total_qnty" readonly></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Diif. Qnty :</label></td>
							<td class="col-8"><input type="text" name="diff_qnty" id="diff_qnty"></td>
						</tr>
					</table>
				</div>	
				<div class="col-lg-3">
					<table>
						<tr class="row mt-2"> 
							<td class="col-4"><label style="font-size:16px;"><b>Bill Amount :</b></label></td>
							<td class="col-8"><input type="text" name="sub_total" id="sub_total" class="pb-1" required><input type="hidden" name="gst_total" class="gst_total" id="gst_total"></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Freight by :</label></td>
							<td class="col-8">
								<select name="freight_paid_by" class="p-1" id="freight_paid_by">
                                    <option value="party">PARTY</option>
                                    <option value="sepl">SEPL</option>
                                </select>
                            </td>
						</tr>
						<!-- <tr class="row">
							<td class="col-4"><label>TC Uploaded :</label></td>
							<td class="col-8">
								  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked value="YES">&nbsp;&nbsp;YES
                                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="NO">&nbsp;&nbsp;NO
                            </td>
						</tr>
						<tr class="row" id="tcremark" style="display:none;">
							<td class="col-4"><label>Remarks :</label></td>
							<td class="col-8">
								  <textarea cols="32" name="tcremarks" id="tcremarks"></textarea>
                            </td>
						</tr> -->

						<tr class="row">
							<td class="col-4"><label>TC Uploaded :</label></td>
							<td class="col-8">
								  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="YES">&nbsp;&nbsp;YES
                                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="NO">&nbsp;&nbsp;NO
                                  <input type="hidden" name="cat_nm" id="cat_nm" value="0">
                            </td>
						</tr>
						<tr class="row" id="tcremark" style="display:none;">
							<td class="col-4"><label>Remarks :</label></td>
							<td class="col-8">
								  <textarea cols="32" name="tcremarks" id="tcremarks"></textarea>
                            </td>
						</tr>

						<tr class="row">
							<td class="mt-4">
								<div class="upload-pi d-flex justify-content-center pb-2 pt-2">
				                  <div class="text-center">
				                    <img src="p1.png" class="img" style="width:120px; height: 120px; border: 1px solid black; border-radius: 7px;"><br> 
				                    <small class="form-text" id="file-upload-filename" style="font-size: 15px;">Upload Invoice</small>
				                    <input type="file"  class="form-control-file d-flex justify-content-center" accept=".pdf" name="profileupload" id="upload-profile">
                                    <br>
				                  </div>
				                </div>
							</td>
						</tr>

					</table>
				</div>
			</div>
			<!-- <button id="btn1" type="button" class="buttonInactive btn btn-danger btn-sm m-2"><b>+</b></button> -->
			<button class="btn btn-danger btn-sm m-2 px-3" type="button" id="add" name="add">ADD</button>
			<br>
			<div class="row table-responsive">
				<table class="tab2">
					<tr>
						<th>Sr</th>
						<th style="width:310px;">Item Name</th>
						<th>Pkg</th>
						<th>Qnty</th>
						<th>Unit</th>
						<th>Rate</th>
						<th>Basic</th>
						<th>Plant</th>
						<th>
							<select id="gst1" class="gst1" style="width: 80px;">
								<option selected="true" value="GST-0%">GST</option>
								<option value="GST-0%">GST-0%</option>
								<option value="GST-3%">GST-3%</option>
	                            <option value="GST-5%">GST-5%</option>
	                            <option value="GST-12%">GST-12%</option>
	                            <option value="GST-18%">GST-18%</option>
	                            <option value="GST-28%">GST-28%</option>
	                            <option value="IGST-3%">IGST-3%</option>
	                            <option value="IGST-5%">IGST-5%</option>
	                            <option value="IGST-12%">IGST-12%</option>
	                            <option value="IGST-18%">IGST-18%</option>
	                            <option value="IGST-28%">IGST-28%</option>
							</select>
						</th>
						<th>TCS Amt</th>
						<th>Project</th>
						<th>Job</th>
						<th>Remark</th>
						<th>Total Amt</th>
					</tr>
					<tbody id="t_body">
						<tr>
							<td>1</td>
							<td><input type="text" name="item_desc[]" id="item_desc" class="item_desc" onFocus="SearchItem(this)" autocomplete="off" required><input type="hidden" name="i_code[]" id="i_code" class="i_code"><input type="hidden" name="iid[]" value="0"></td>
							<td><input type="number" name="pkg[]" id="pkg" style="width: 80px;" required class="pkg"></td>
							<td><input type="number" step="0.01" name="qnty[]" id="1qnty" class="qnty" autocomplete="off" style="width: 80px;" required><input type="hidden" name="order_qnty[]" value="0"></td>
							<td>
								<select name="unit[]" id="unit" style="width: 80px;" required>
									<option disabled="true" selected="true" value="">Select</option>
		                            <option>Box</option>
		                            <option>Mtr</option>
		                            <option>cylnr</option>
		                            <option>Feet</option>
		                            <option>Gram</option>
		                            <option>Kg</option>
		                            <option>Liter</option>
		                            <option>Nos</option>
		                            <option>Pair</option>
		                            <option>Pkt</option>
		                            <option>Roll</option>
		                            <option>Set</option>
		                            <option>Sq.Ft</option>
		                            <option>Sqmm</option>
		                            <option>Ton</option>
		                            <option>Uom</option>
		                            <option>Bag</option>
		                            <option>Book</option>
		                            <option>R.ft</option>
		                            <option>Sq.Mtr</option>
		                            <option>hours</option>
	                        	</select>
							</td>
							<td><input type="number" step="0.01" name="rate[]" id="rate" class="rate"  autocomplete="off" required><input type="hidden" name="order_rate[]" value="0"></td>
							<td><input type="text" name="basic[]" id="basic" class="basic"></td>
							<td>
								<select name="plant[]" id="plant" required style="width: 90px;">
		                            <option value="">Select</option>
		                            <option value="1701">1701</option>
		                            <option value="2205">2205</option>
		                            <option value="696">696</option>
		                            <option value="jarod">jarod</option>
		                            <option value="baroda">baroda</option>
		                        </select>
							</td>
							<td><!-- <input type="text" name="gst" id="gst" class="gst"> -->
								<select name="gst[]" id="gst" class="gst" required>
									<option value="GST-0%">GST-0%</option>
									<option value="GST-3%">GST-3%</option>
		                            <option value="GST-5%">GST-5%</option>
		                            <option value="GST-12%">GST-12%</option>
		                            <option value="GST-18%">GST-18%</option>
		                            <option value="GST-28%">GST-28%</option>
		                            <option value="IGST-3%">IGST-3%</option>
		                            <option value="IGST-5%">IGST-5%</option>
		                            <option value="IGST-12%">IGST-12%</option>
		                            <option value="IGST-18%">IGST-18%</option>
		                            <option value="IGST-28%">IGST-28%</option>
								</select><input type="hidden" class="cgst" id="cgst" value="0">
								<input type="hidden" class="sgst" id="sgst" value="0">
								<input type="hidden" class="igst" id="igst" value="0">
								<input type="hidden" name="gst_amt[]" class="gst_amt" id="gst_amt" value="0">
							</td>
							<td><input type="number" step="0.01" name="tcs_amt[]" id="tcs_amt" class="tcs_amt"  autocomplete="off"></td>
							<td><input type="text" name="project[]" id="project"></td>
							<td><input type="text" name="job[]" id="job"></td>
							<td><input type="text" name="remark1[]" id="remark1"></td>
							<td><input type="text" name="total_amt[]" id="total_amt" value="0" class="total_amt" readonly></td>
						</tr>
					</tbody>
				</table>
			</div><br>
			<button class="btn btn-danger btn-sm m-2 px-3" type="button" id="add1" name="add1">ADD</button><br>
			<div class="row">
				<table class="tab1" id="tr1">
					<tr>
						<th>Field</th>
						<th style="width:150px;">Amount</th>
						<th style="width:150px;">GST%</th>
						<th style="width:150px;">Taxable Amt</th>
					</tr>
					<tbody id="t_body1">
						<tr>
							<td>
								<select name="field[]" id="field" class="field">
		                            <option >Select</option>
		                            <option >Discount</option>
		                            <option >Freight</option>
		                            <option >Packaging</option>
		                            <option >Insurance</option>
		                            <option >Other Charge</option>
		                            <option >Freight Subsidy</option>
		                            <option >Credit Note</option>
		                        </select>
							</td>
							<td><input type="text" name="amount[]" id="1amount" class="amount"></td>
							<td> 
								<select id="gst2" name="gst2[]" class="gst2">
									<option selected="true" value="GST-0%">GST-0%</option>
		                            <option value="GST-3%">GST-3%</option>
		                            <option value="GST-5%">GST-5%</option>
		                            <option value="GST-12%">GST-12%</option>
		                            <option value="GST-18%">GST-18%</option>
		                            <option value="GST-28%">GST-28%</option>
		                            <option value="IGST-3%">IGST-3%</option>
		                            <option value="IGST-5%">IGST-5%</option>
		                            <option value="IGST-12%">IGST-12%</option>
		                            <option value="IGST-18%">IGST-18%</option>
		                            <option value="IGST-28%">IGST-28%</option>
								</select><input type="hidden" class="gstvalue" id="gstvalue" value="0">
							</td>
							<td><input type="text" name="t_value[]" id="t_value" class="t_value"><input type="hidden" class="total_amt" value="0"></td>
						</tr>
					</tbody>
				</table>
			</div><br>
		</form>
	</div>

<script type="text/javascript">
    $(document).on('click','#back',function(){
        window.open('../dashboard.php','_self');
    });
    
   	$('#receive_date,#invoice_date').inputmask('datetime', {
            mask: "1-2-y",
            alias: "dd-mm-yyyy",
            placeholder: "DD-MM-YYYY",
            separator: '-'
        });
     var rst = 1;
	  $("#add").click(function(){
		  var abc = $('#'+rst+'qnty').val();
			if (abc == "") {
		  		alert('Please fill Current Information (कृपया पहले जानकारी भरें)');
			}
		  	else
		  	{
		 	 rst++;
		 	 var gst = $('#gst1').val();
		 	 var arr = gst.split("-");
		 	 if (arr[0] == 'GST') {
		 	 	 var a = parseFloat(arr[1])/2;
		 	 	 var c = 0;
		 	 }else{
		 	 	 var c = parseFloat(arr[1]);
		 	 	 var a = 0;
		 	 }
		 	
	  			var rowHtm5 = '<tr>';
	    			rowHtm5 += '<td>'+rst+'</td>';
				    rowHtm5 += '<td><input type="text" name="item_desc[]" id="'+rst+'item_desc" class="item_desc" onFocus="SearchItem(this)" autocomplete="off"><input type="hidden" name="i_code[]" id="i_code" class="i_code"><input type="hidden" name="iid[]" value="0"></td>';
				    rowHtm5 += '<td><input type="number" name="pkg[]" id="'+rst+'pkg" class="pkg"></td>';
				    rowHtm5 += '<td><input type="number" step="0.01" name="qnty[]" id="'+rst+'qnty" class="qnty"  autocomplete="off"><input type="hidden" name="order_qnty[]" value="0"></td>';
				    rowHtm5 += '<td><select name="unit[]" id="'+rst+'unit" style="width: 90px;"><option value="">select</option><option>Box</option><option>Mtr</option><option>cylnr</option><option>Feet</option><option>Gram</option><option>Kg</option><option>Liter</option><option>Nos</option><option>Pair</option><option>Pkt</option><option>Roll</option><option>Set</option><option>Sq.Ft</option><option>Sqmm</option><option>Ton</option><option>Uom</option><option>Bag</option><option>Book</option><option>R.ft</option><option>Sq.Mtr</option><option>hours</option></select></td>';
				    rowHtm5 += '<td><input type="number" step="0.01" name="rate[]" id="'+rst+'rate" class="rate" autocomplete="off"><input type="hidden" name="order_rate[]" value="0"></td>';
				    rowHtm5 += '<td><input type="text" name="basic[]" id="'+rst+'basic" class="basic"></td>';
				    rowHtm5 += '<td><select name="plant[]" id="'+rst+'plant" required style="width: 90px;"><option value="">Select</option><option value="1701">1701</option><option value="2205">2205</option><option value="696">696</option><option value="jarod">jarod</option><option value="baroda">baroda</option></select></td>';

				    rowHtm5 += '<td><select name="gst[]" id="'+rst+'gst" class="gst"><option  value="'+gst+'">'+gst+'</option><option value="GST-0%">GST-0%</option><option value="GST-3%">GST-3%</option><option value="GST-5%">GST-5%</option><option value="GST-12%">GST-12%</option><option value="GST-18%">GST-18%</option><option value="GST-28%">GST-28%</option><option value="IGST-3%">IGST-3%</option><option value="IGST-5%">IGST-5%</option><option value="IGST-12%">IGST-12%</option><option value="IGST-18%">IGST-18%</option><option value="IGST-28%">IGST-28%</option></select><input type="hidden" class="cgst" id="cgst" value="'+a+'"><input type="hidden" class="sgst" id="sgst" value="'+a+'"><input type="hidden" class="igst" id="igst" value="'+c+'"><input type="hidden" name="gst_amt[]" class="gst_amt" id="gst_amt" value="0"></td>';
				    /*rowHtm5 += '<td><input type="text" name="gst" id="'+rst+'gst" class="gst" value="'+gst+'"></td>';*/

				     rowHtm5 += '<td><input type="number" step="0.01" name="tcs_amt[]" id="'+rst+'tcs_amt" class="tcs_amt" autocomplete="off"></td>';
				    rowHtm5 += '<td><input type="text" name="project[]" id="'+rst+'project"></td>';
				    rowHtm5 += '<td><input type="text" name="job[]" id="'+rst+'job"></td>';
				    rowHtm5 += '<td><input type="text" name="remark1[]" id="'+rst+'remark1"></td>';
				    rowHtm5 += '<td><input type="text" name="total_amt[]" id="'+rst+'total_amt" class="total_amt" value="0" readonly></td>';
	    		rowHtm5 += '</tr>';

	    $('table').find('#t_body').append(rowHtm5)
	    }
 	 });

	  var pqr = 1;
	  $("#add1").click(function(){
		  var abc = $('#'+pqr+'amount').val();
			if (abc == "") {
		  		alert('Please fill Current Information (कृपया पहले जानकारी भरें)');
			}
		  	else
		  	{
		 	 pqr++;
	  		var gst = $('#gst1').val();
	  		var arr = gst.split("-");
	  			var rowHtm5 = '<tr>';
	    			rowHtm5 += '<td><select name="field[]" class="field" id="'+pqr+'field" required><option >Select</option><option >Discount</option><option >Freight</option><option >Packaging</option><option >Insurance</option><option >Other Charge</option><option >Freight Subsidy</option><option >Credit Note</option></td>';
				    rowHtm5 += '<td><input type="text" name="amount[]" id="'+pqr+'amount" class="amount"></td>';

				    rowHtm5 += '<td><select id="'+pqr+'gst2" name="gst2[]" class="gst2"><option  value="'+gst+'">'+gst+'</option><option value="GST-0%">GST-0%</option><option value="GST-3%">GST-3%</option><option value="GST-5%">GST-5%</option><option value="GST-12%">GST-12%</option><option value="GST-18%">GST-18%</option><option value="GST-28%">GST-28%</option><option value="IGST-3%">IGST-3%</option><option value="IGST-5%">IGST-5%</option><option value="IGST-12%">IGST-12%</option><option value="IGST-18%">IGST-18%</option><option value="IGST-28%">IGST-28%</option></select><input type="hidden" class="gstvalue" value="'+parseFloat(arr[1])+'"></td>';
				    rowHtm5 += '<td><input type="text" name="t_value[]" id="'+pqr+'t_value" class="t_value"><input type="hidden" class="total_amt" value="0"></td>';
				    
	    		rowHtm5 += '</tr>';

	    $('table').find('#t_body1').append(rowHtm5)
	    }
 	 });


	  $(document).on('change','#gst1',function(){
	  	var x = $(this).val();
	  	var arr = x.split("-");
	  	        $('#gst2').val(x);
	  	        $('#gstvalue').val(parseFloat(arr[1]));
	  	$('.gst').each(function(){
	  		$(this).val(x);
	  		var ar = parseFloat(arr[1]);
	  		if (arr[0] == 'GST'){
	  			$(this).closest('tr').find('.igst').val(0);
	  			$(this).closest('tr').find('.cgst').val(ar/2);
	  			$(this).closest('tr').find('.sgst').val(ar/2);

	  		}else{
	  			$(this).closest('tr').find('.cgst').val(0);
	  			$(this).closest('tr').find('.sgst').val(0);
	  			$(this).closest('tr').find('.igst').val(ar);
	  		}
	  			var s = ($(this).closest('tr').find('.qnty').val() == '') ? 0 : $(this).closest('tr').find('.qnty').val();
				var p = ($(this).closest('tr').find('.rate').val() == '') ? 0 : $(this).closest('tr').find('.rate').val();
				var r = ($(this).closest('tr').find('.tcs_amt').val() == '') ? 0 : $(this).closest('tr').find('.tcs_amt').val();
				var total = (p*s)*(1+ar*0.01)+ parseFloat(r); 
					$(this).closest('tr').find(".total_amt").val((total).toFixed(2));

					var gst_amt = (p*s)*(ar*0.01)+ parseFloat(r); 
					$(this).closest('tr').find(".gst_amt").val((gst_amt).toFixed(2));

					var f = 0;
			$('.total_amt').each(function(){
				f += parseFloat($(this).val());
				$('#sub_total').val((f).toFixed(2));
			});
			var q = 0;
			$('.qnty').each(function(){
				q += parseFloat($(this).val());
				$('#total_qnty').val((q).toFixed(1));
			});
			var g = 0;
			$('.gst_amt').each(function(){
				g += parseFloat($(this).val());
				$('#gst_total').val((g).toFixed(1));
			});
	  	});
	  });

	  $(document).on('change','.gst2,.amount',function(){
	  	 var x = $(this).closest('tr').find('.gst2').val();
	  	  var m = $(this).closest('tr').find('.field').val();
	  	  //alert(m);

	  	 var arr = x.split("-");
	  	 var e = parseFloat(arr[1]);
	  	 $(this).closest('tr').find('.gstvalue').val(e);
	  	 var s = ($(this).closest('tr').find('.amount').val() == '') ? 0 : $(this).closest('tr').find('.amount').val();
	  	 var sum = s*(1+e*0.01);
	  	  if (m == 'Discount' || m == 'Freight Subsidy' || m == 'Credit Note') {
	  	 	var minus = -s*(1+e*0.01);
	  	 }else{
	  	 	var minus = s*(1+e*0.01);
	  	 }
	  	 $(this).closest('tr').find(".t_value").val((sum).toFixed(2));
	  	  $(this).closest('tr').find(".total_amt").val((minus).toFixed(2));
	  	  var f = 0;
			$('.total_amt').each(function(){
				f += parseFloat($(this).val());
				$('#sub_total').val((f).toFixed(2));
			});
	  });


	/*  Imaage upload code*/
	  $(document).ready(function(e){
	  	jQuery("#item_desc").toolTip();
    let $uploadfile = $('.upload-pi input[type="file"]');

    $uploadfile.change(function(){
      readURL(this);
    });

    function readURL(input){
      if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e){
          $(".upload-pi .img").attr('src',e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    });

	  /*  Show upload pdf name code*/
	var input = document.getElementById( 'upload-profile' );
  var infoArea = document.getElementById( 'file-upload-filename' );

  input.addEventListener( 'change', showFileName );

  function showFileName( event ) {
    
    // the change event gives us the input it occurred in 
    var input = event.srcElement;
    
    // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
    var fileName = input.files[0].name;
    
    // use fileName however fits your app best, i.e. add it into a div
    infoArea.textContent = fileName;
  }

	$( function() {
	  	// party autocomplete box
	  		$( "#party" ).autocomplete({
	  		source: function( request, response ) {
	  		// Fetch data
	  			$.ajax({
					  url: "fetch1.php",
					  type: 'post',
					  dataType: "json",
					  data: {
					  party: request.term,
					  isreq:'no'
	  			},
	  			success: function( data ) {
	  			response( data );
	  		}
	 		 });
	  	},
	  		select: function (event, ui) {
	  			// Set selection
					  $('#party').val(ui.item.label);
					  $('#pid').val(ui.item.pid);
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

	  	// pogen autocomplete box
	$( "#po_gen_by" ).autocomplete({
	  source: function( request, response ) {
	  // Fetch data
	  $.ajax({
			url: "fetch1.php",
			type: 'post',
			dataType: "json",
			data: {
			pogen: request.term
		},
			success: function( data ) {
				response( data );
				}
			});
		},
		select: function (event, ui) {
			$(this).val(ui.item.label);
			$('#department').val(ui.item.dpmnt);
				return false;
			},
			change: function (event, ui)
			{
				if (ui.item == null){
					$(this).val('');
					$(this).focus();
				}
			}
		});
		 $( "#search_po" ).autocomplete({
		  source: function( request, response ) {
		   // Fetch data
		   $.ajax({
		    url: "posearch.php",
		    type: 'post',
		    dataType: "json",
		    data: {
		     po: request.term
		    },
		    success: function( data ) 
		    {
		     response( data );
		    }
		   });
		  },
		  select: function (event, ui) {
		   // Set selection
		   $('#search_po').val(ui.item.label);
		   $('#poid').val(ui.item.poid); // display the selected text
		    $('#party').val(ui.item.party);
		    $('#po_gen_by').val(ui.item.genby);
		    $('#department').val(ui.item.dept);
		    $('#p_days').val(ui.item.pdays);
		    $('#pid').val(ui.item.pcode);
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
		
	});
	   //ITEM seach
      function SearchItem(txtBoxRef) {
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
		    url: "fetch_item.php",
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
		   var self = this;
		   $(self).closest('tr').find('.item_desc').val(ui.item.label);
		   $(self).closest('tr').find('.i_code').val(ui.item.i_code);
		 
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

	$(document).on('change','#search_po',function(){

		$("#add").hide();
		var po = $('#poid').val();

			 $.ajax({
            url:"po_getdata.php",
            method:"POST",
            data:{po:po},
            success:function(data)
             {
        		$('#t_body').html(data);
        		$('.c_code').each(function()
				{	
					if($(this).val() == 30)
					{
						f = parseFloat($(this).val());					
					}
				});
				if(f == 30)
				{
					$('#tcremark').hide(); 
					$('input[id="flexRadioDefault1"]').prop('checked', true);
					$('#cat_nm').val(f);
				}
				else
				{
					$('#tcremark').hide();
					$('input[id="flexRadioDefault2"]').prop('checked', true);
				}
               
            }
        });
		

	}); 

	$(document).on('change','.qnty,.rate,.tcs_amt,.pkg',function(){
		var s = ($(this).closest('tr').find('.qnty').val() == '') ? 0 : $(this).closest('tr').find('.qnty').val();
		var p = ($(this).closest('tr').find('.rate').val() == '') ? 0 : $(this).closest('tr').find('.rate').val();
		var r = ($(this).closest('tr').find('.tcs_amt').val() == '') ? 0 : $(this).closest('tr').find('.tcs_amt').val();
		var cc = ($(this).closest('tr').find('.cgst').val() == '') ? 0 : $(this).closest('tr').find('.cgst').val();
		var ss = ($(this).closest('tr').find('.sgst').val() == '') ? 0 : $(this).closest('tr').find('.sgst').val();
		var ii = ($(this).closest('tr').find('.igst').val() == '') ? 0 : $(this).closest('tr').find('.igst').val();
		var t =  parseFloat(cc) + parseFloat(ss)  + parseFloat(ii)  ;
		var total = (p*s)*(1+t*0.01)+ parseFloat(r);
		if (s <= 0) {
			$(this).closest('tr').find(".pkg,.plant").attr('required', false);
		}else{
			$(this).closest('tr').find(".pkg,.plant").attr('required', true);
		}

		 
		
		var gst_amt = (p*s)*(t*0.01)+ parseFloat(r); 
		$(this).closest('tr').find(".gst_amt").val((gst_amt).toFixed(2));

		$(this).closest('tr').find(".basic").val((p*s).toFixed(2));
		$(this).closest('tr').find(".total_amt").val((total).toFixed(2));
		
		var f = 0;
		$('.total_amt').each(function(){
			f += parseFloat($(this).val());
			$('#sub_total').val((f).toFixed(2));
		});
		var q = 0;
		$('.qnty').each(function(){
			q += parseFloat($(this).val());
			$('#total_qnty').val((q).toFixed(1));
		});
		var g = 0;
		$('.gst_amt').each(function(){
			g += parseFloat($(this).val());
			$('#gst_total').val((g).toFixed(1));
		});
	});
	// check purchase value not greater than balance qnty
	$(document).on('change','.qnty',function(){
		var qnty = $(this).val();
		var bqnty = $(this).closest('tr').find('.balanceqnty').val();
		var c_code = $(this).closest('tr').find('.c_code').val();
		if (parseFloat(qnty) > parseFloat(bqnty) && c_code !=30) {
			alert("Qnty must be less or equal than Balance Qnty");
			$(this).val('');
			$(this).focus();
		}
	});

	
	 $(document).on('change','.gst',function(){
	  	var x = $(this).val();
	  	var arr = x.split("-");
	  		var ar = parseFloat(arr[1]);
	  		if (arr[0] == 'GST'){
	  			$(this).closest('tr').find('.igst').val(0);
	  			$(this).closest('tr').find('.cgst').val(ar/2);
	  			$(this).closest('tr').find('.sgst').val(ar/2);

	  		}else{
	  			$(this).closest('tr').find('.cgst').val(0);
	  			$(this).closest('tr').find('.sgst').val(0);
	  			$(this).closest('tr').find('.igst').val(ar);
	  		}
	  		var s = ($(this).closest('tr').find('.qnty').val() == '') ? 0 : $(this).closest('tr').find('.qnty').val();
				var p = ($(this).closest('tr').find('.rate').val() == '') ? 0 : $(this).closest('tr').find('.rate').val();
				var r = ($(this).closest('tr').find('.tcs_amt').val() == '') ? 0 : $(this).closest('tr').find('.tcs_amt').val();
				var total = (p*s)*(1+ar*0.01)+ parseFloat(r); 
						$(this).closest('tr').find(".total_amt").val((total).toFixed(2));	

				var gst_amt = (p*s)*(ar*0.01)+ parseFloat(r); 
					$(this).closest('tr').find(".gst_amt").val((gst_amt).toFixed(2));		

						var f = 0;
				$('.total_amt').each(function(){
					f += parseFloat($(this).val());
					$('#sub_total').val((f).toFixed(2));
				});
	  });

	 $("#weight").keyup(function(){
        var weight = $(this).val();
        var total_qnty = $("#total_qnty").val();
        var a = weight - total_qnty;
        $("#diff_qnty").val(a);
        });

	  function isDate2(txtDate){

         var currVal = txtDate;
        if(currVal == '')
        return true;        
        
        var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
        var dtArray = currVal.match(rxDatePattern); // is format OK?
        
        if (dtArray == null)
        return false;
        
        //Checks for mm/dd/yyyy format.
        dtDay= dtArray[1];
        dtMonth = dtArray[3];
        dtYear = dtArray[5];

            var dd2 = dtMonth + '-' + dtDay + '-' + dtYear;
            var date1 = new Date(dd2);
            var date2 = new Date();
            var diffTime = Math.round(date2 - date1);
            var diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24));
            
            
        
        if (diffDays > 6)
        return "not_before";
        else if (diffDays < 0)
        return "not_advance";
        
        return true;
    }

    $('#receive_date').on('focusout', function(){
        var txtVal =  $(this).val();
       if(isDate2(txtVal) == 'not_before')
        {
            alert('आप केवल 5 दिन पहले तक ही बिल एंट्री कर सकते हैं');
            $(this).val('');
            $(this).focus();   
        }
        else if(isDate2(txtVal) == 'not_advance')
        {
            alert('आप भविष्य में बिल एंट्री नहीं कर सकते');
            /*आगे का*/
            $(this).val('');
            $(this).focus();   
        }

    });
        
       $('#invoice_no').change(function() {
	        var days = $('#p_days').val();
	        var i_date = $('#receive_date').val();
	        
	        var date = new Date(i_date.split("-").reverse().join("/"));

	        date.setDate(date.getDate() + (+days));
	        var dd = date.getDate();
	        var mm = date.getMonth() + 1;
	        var y = date.getFullYear();
	     
	        var someFormattedDate = y + '-' + mm + '-' + dd;
	        $('#due_days').val(someFormattedDate);
        });

       $("#srno").blur(function(){
            var srno = $(this).val();
            var plant = $("#received_at").val();

            $.ajax({
            url:"srno.php",
            method:"POST",
            data:{srno:srno,receiveAt:plant},
            dataType:"text",
            success:function(data){
            	var x = data.length;
			            if (x>1) {
			            $("#sr_error").html(data);
			            $("#srno").focus();
		                }else{
		                	$("#sr_error").html('');
		                }
             
            }
            });
        });

       $(document).on('change','#received_at',function(){
       	 var t = $(this).val();
       	 $.ajax({
            url:"srno.php",
            method:"POST",
            data:{plant:t},
	            success:function(data){
	            	$("#srno").val(data);
            	}
            });
       });

       $(document).on('click','#save',function(){
       		if(!confirm('Are You Sure!!')){
       			return false;
       		}
       });

       $( "#projecti" ).autocomplete
	  ({
	    source: function( request, response ) {
	      
	    // Fetch data
	      $.ajax({
	            url: "fetchProject.php?status=1",
	            type: 'post',
	            dataType: "json",
	            data: {
	            project: request.term,
	            
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
	        $('#projecti').val(ui.item.label);
	        return false;
	      },
	    change: function (event, ui)  //if not selected from Suggestion
	    {
	        // if (ui.item == null)
	        // {
	        //   $(this).val('');
	        //   $(this).focus();
	        // }
	      }
	      //end project
	});
    </script>
</body>
</html>
