<?php session_start();
if (!isset($_SESSION['pur_user'])) {
    $_SESSION['utype'] = "You Are Not Authorized!!";
    header("location:..\dashboard.php");
}
include('..\..\dbcon.php');
    $rmta = $_GET['srno'];
    $plant = $_GET['plant'];
    $sql="SELECT * from inward_com a left outer join rm_party_master b on b.pid = a.mat_from_party where sr_no='$rmta' AND receive_at='$plant'";
    $run=sqlsrv_query($con, $sql);
    $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);


    $sql1 = "SELECT *  from rm_tcreceipt_pdf where Status = '1' and SrNo = '".$rmta."' and receive_at = '".$plant."'";
    $run1 = sqlsrv_query($con, $sql1);
    $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);

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
	 	width: 35%;
	 }
	 h4{
	 	font-size: 28px;
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
	
</head>
<body>
	<div class="row b1">
		<div class="col-6">
			<h4 class="pt-1">PURCHASE EDIT</h4>
		</div>
		<div class="col-6">
             <!-- <a href="../dashboard.php" class="nav-link btn btn-info mr-2">Back</a> -->
			<button class="float-end btn btn-light px-4" id="back"><b>Back</b></button>
			<button class="float-end btn btn-light px-4" type="submit" id="save" name="save" form="form"><b>Save Edit</b></button>
		</div>	
	</div><br>
	<div class="container-fluid">
		<form action="purchase_entry_update-696.php?rmta=<?php echo $rmta.$plant ?>" id="form" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="col-lg-4">
					<table>
						<tr class="row mt-2"> 
							<td class="col-4"><label>Receive At :</label></td>
							<td class="col-8">
								<select name="received_at" class="p-1" id="received_at" >
	                                <option value="<?php echo $row['receive_at']; ?>"><?php echo $row['receive_at']; ?></option>
	                                <option value="696_plant">696</option>
	                                <option value="D_696_plant">D_696</option>
	                            </select>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Rmta :</label></td>
							<td class="col-8"><input type="number" name="srno" id="srno"  value="<?php echo $row['sr_no'] ?>"></td>
							<td class="col-8"><label id="sr_error"></label></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Receive Date :</label></td>
							<td class="col-8"><input type="text" name="receive_date" id="receive_date" placeholder="DD-MM-YYYY" value="<?php echo $row['receive_date']->format("d-m-Y"); ?>"></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Payment Days :</label></td>
							<td class="col-8"><input type="text" name="p_days" id="p_days" value="<?php echo $row['p_days'] ?>"><input type="hidden" class="" name="due_days" id="due_days" value="<?php echo $row['payment_due']->format("Y-m-d"); ?>" readonly></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Challan No :</label></td>
							<td class="col-8"><input type="text" name="challan_no" id="challan_no" value="<?php echo $row['challan_no'] ?>"></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Invoice Date :</label></td>
							<td class="col-8"><input type="text" name="invoice_date" id="invoice_date" placeholder="DD-MM-YYYY" value="<?php echo $row['invoice_date']->format("d-m-Y"); ?>"></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Invoice No. :</label></td>
							<td class="col-8"><input type="text" name="invoice_no" id="invoice_no" value="<?php echo $row['invoice_no'] ?>"></td>
						</tr>
					</table>
				</div>

				<div class="col-lg-4">
					<table>
						<tr class="row"> 
							<td class="col-4"><label>Party :</label></td>
							<td class="col-8"><input type="text" name="party" id="party" value="<?php echo $row['party_name'] ?>"><input type="hidden" name="pid" id="pid" value="<?php echo $row['mat_from_party'] ?>"></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Mat. Order By :</label></td>
							<td class="col-8"><input type="text" name="po_gen_by" id="po_gen_by" value="<?php echo $row['mat_ord_by'] ?>"></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Department :</label></td>
							<td class="col-8"><input type="text" name="department" id="department" value="<?php echo $row['depnt'] ?>"></td>
						</tr>
						<tr class="row">
							<!-- <td class="col-4"><label>Material Type :</label></td>
							<td class="col-8"><input type="text" name="mat_type" id="mat_type" ><input type="hidden" name="c_code" id="c_code"></td> -->
						</tr>
						<tr>
							<td class="pt-5"></td>
							<td class="pt-5"></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Weight :</label></td>
							<td class="col-8"><input type="number" step="0.01" name="weight" id="weight" value="<?php echo $row['gross_wt'] ?>"></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Total Qnty :</label></td>
							<td class="col-8"><input type="text" name="total_qnty" id="total_qnty" readonly value="<?php echo $row['total_qnty'] ?>"></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Diif. Qnty :</label></td>
							<td class="col-8"><input type="text" name="diff_qnty" id="diff_qnty" value="<?php echo $row['diff_qnty'] ?>"></td>
						</tr>
					</table>
				</div>	
				<div class="col-lg-3">
					<table>
						<tr class="row mt-2"> 
							<td class="col-4"><label style="font-size:16px;"><b>Bill Amount :</b></label></td>
							<td class="col-8"><input type="text" name="sub_total" id="sub_total" class="pb-1" value="<?php echo $row['total_bill_amt'] ?>"><input type="hidden" name="gst_total" class="gst_total" id="gst_total" value="<?php echo $row['total_tax'] ?>"></td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>Freight by :</label></td>
							<td class="col-8">
								<select name="freight_paid_by" class="p-1" id="freight_paid_by">
									 <option value="<?php echo $row['freight_paid_by'] ?>"><?php echo $row['freight_paid_by'] ?></option>
                                    <option value="party">PARTY</option>
                                    <option value="sepl">SEPL</option>
                                </select>
                            </td>
						</tr>
						<tr class="row">
							<td class="col-4"><label>TC Uploaded :</label></td>
							<td class="col-8">
									<?php
                                            // if($row1['Name'] != "" || $row1['Name'] != NULL)
                                            // {
                                            // 	echo "YES";
                                            // }
                                            // else if($row1['Name'] == "" || $row1['Name'] == NULL)
                                            // {
                                            // 	echo "NO";
                                            // }
                                    ?><br/>
								  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" <?php if ($row1['Name'] != "" || $row1['Name'] != null) {
                                        echo "checked";
                                    } ?> value="YES"  readonly>&nbsp;&nbsp;YES
                                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" <?php if ($row1['Name'] == "" || $row1['Name'] == null) {
                                        echo "checked";
                                    } ?>  value="NO" readonly>&nbsp;&nbsp;NO
                                  <input type="hidden" name="tcidp" id="tcidp" value="<?php echo $row1['TCReceiptIDP'] ?>">
                                  <input type="hidden" name="catg_nm_tc" id="catg_nm_tc" value="0">
                            </td>
						</tr>
						<tr class="row" id="tcremark" style="display:none;">
							<td class="col-4"><label>Remarks :</label></td>
							<td class="col-8">
								  <textarea cols="30" placeholder="Why tc receipt not uploaded?" rows="3" name="tcremarks" id="tcremarks"><?php echo $row1['Remarks']; ?></textarea>								
                            </td>
						</tr>
						
						<tr class="row">
							<td class="mt-4">
								<div class="upload-pi d-flex justify-content-center pb-4 pt-2">
				                  <div class="text-center">
				                    <img src="p1.png" class="img" style="width:130px; height: 130px; border: 1px solid black; border-radius: 7px;"><br> 
				                    <small class="form-text" id="file-upload-filename" style="font-size: 15px;">Upload Invoice</small>
				                    <input type="file"  class="form-control-file d-flex justify-content-center" accept=".pdf" name="profileupload" id="upload-profile">
				                    <input type="hidden" name="file_upload" value="<?php echo $row['invoice_img'] ?>">
                                    <br>
				                  </div>
				                </div>
							</td>
						</tr>

					</table>
				</div>
			</div>
			
			<br>
			<div class="row table-responsive">
				<table class="tab2">
					<tr>
						<th>No.</th>
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
	                            <option value="GST-5%">GST-5%</option>
	                            <option value="GST-12%">GST-12%</option>
	                            <option value="GST-18%">GST-18%</option>
	                            <option value="GST-28%">GST-28%</option>
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
						<?php
                            $no = 1;
                            $sql1="SELECT * from inward_ind a left outer join rm_item b on b.i_code = a.p_item where sr_no='$rmta' AND receive_at='$plant'";
                            $run1=sqlsrv_query($con, $sql1);
                            while ($row1=sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC)) {
                                ?>
						<tr>
							<td><?php echo $no ?></td>
							<td><input type="text" name="item_desc[]" id="item_desc" class="item_desc" onFocus="SearchItem(this)" autocomplete="off" value="<?php echo $row1['item'] ?>"><input type="hidden" name="i_code[]" id="i_code" class="i_code" value="<?php echo $row1['p_item'] ?>"><input type="hidden" name="iid[]" value="<?php echo $row1['id'] ?>"></td>
							<td><input type="text" name="pkg[]" id="pkg" style="width: 80px;" value="<?php echo $row1['p_pkg'] ?>"></td>
							<td><input type="number" step="0.01" name="qnty[]" id="1qnty" class="qnty" autocomplete="off" style="width: 80px;" value="<?php echo $row1['rec_qnty'] ?>"><input type="hidden" class="bqnty" name="order_qnty[]" value="<?php echo $row1['rec_qnty'] ?>"></td>
							<td>
								<select name="unit[]" id="unit" style="width: 80px;">
									<option  value="<?php echo $row1['p_unit'] ?>"><?php echo $row1['p_unit'] ?></option>
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
							<td><input type="number" step="0.01" name="rate[]" id="rate" class="rate" autocomplete="off" value="<?php echo $row1['pur_rate'] ?>"><input type="hidden" name="order_rate[]" value="<?php echo $row1['order_rate'] ?>"></td>
							<td><input type="text" name="basic[]" id="basic" class="basic" value="<?php echo $row1['taxable_amt'] ?>"></td>
							<td>
								<select name="plant[]" id="plant"  style="width: 90px;">
		                            <option value="<?php echo $row1['plant'] ?>"><?php echo $row1['plant'] ?></option>
		                        </select>
							</td>
							<td><!-- <input type="text" name="gst" id="gst" class="gst"> -->
								<select name="gst[]" id="gst" class="gst">
									<option  value="<?php echo $row1['gst_per'] ?>"><?php echo $row1['gst_per'] ?></option>
									<option value="GST-0%">GST-0%</option>
		                            <option value="GST-5%">GST-5%</option>
		                            <option value="GST-12%">GST-12%</option>
		                            <option value="GST-18%">GST-18%</option>
		                            <option value="GST-28%">GST-28%</option>
		                            <option value="IGST-5%">IGST-5%</option>
		                            <option value="IGST-12%">IGST-12%</option>
		                            <option value="IGST-18%">IGST-18%</option>
		                            <option value="IGST-28%">IGST-28%</option>
								</select><input type="hidden" class="cgst" id="cgst" value="0">
								<input type="hidden" class="sgst" id="sgst" value="0">
								<input type="hidden" class="igst" id="igst" value="0">
								<input type="hidden" name="gst_amt[]" class="gst_amt" id="gst_amt" value="<?php echo $row1['gst_amt'] ?>">
							</td>
							<td><input type="number" step="0.01" name="tcs_amt[]" id="tcs_amt" class="tcs_amt" autocomplete="off" value="<?php echo $row1['tcs_amt'] ?>"></td>
							<td><input type="text" name="project[]" id="project" value="<?php echo $row1['p_project'] ?>"></td>
							<td><input type="text" name="job[]" id="job" value="<?php echo $row1['p_job'] ?>"></td>
							<td><input type="text" name="remark1[]" id="remark1" value="<?php echo $row1['p_remark'] ?>"></td>
							<td><input type="text" name="total_amt[]" id="total_amt" class="total_amt" readonly value="<?php echo $row1['total_amt'] ?>"></td>
						</tr>
					<?php $no++;
                            } ?>
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
						<?php
                            $sql2="SELECT * from inward_charges where sr_no='$rmta' AND receive_at='$plant'";
                            $run2=sqlsrv_query($con, $sql2);
                            while ($row2=sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC)) {
                                ?>
						<tr>
							<td>
								<select name="field[]" id="field" class="field">
		                            <option value="<?php echo $row2['field'] ?>"><?php echo $row2['field'] ?></option>
		                            <option >Discount</option>
		                            <option >Freight</option>
		                            <option >Packaging</option>
		                            <option >Insurance</option>
		                            <option >Other Charge</option>
		                            <option >Freight Subsidy</option>
		                            <option >Credit Note</option>
		                        </select><input type="hidden" name="charge_id[]" value="<?php echo $row2['id'] ?>">
							</td>
							<td><input type="text" name="amount[]" id="1amount" class="amount" value="<?php echo $row2['amount'] ?>"></td>
							<td> 
								<select id="gst2" name="gst2[]" class="gst2">
									<option value="<?php echo $row2['gst'] ?>"><?php echo $row2['gst'] ?></option>
									<option value="GST-0%">GST-0%</option>
		                            <option value="GST-5%">GST-5%</option>
		                            <option value="GST-12%">GST-12%</option>
		                            <option value="GST-18%">GST-18%</option>
		                            <option value="GST-28%">GST-28%</option>
		                            <option value="IGST-5%">IGST-5%</option>
		                            <option value="IGST-12%">IGST-12%</option>
		                            <option value="IGST-18%">IGST-18%</option>
		                            <option value="IGST-28%">IGST-28%</option>
								</select><input type="hidden" class="gstvalue" id="gstvalue" value="0" value="<?php echo $row1['total_tax_amt'] ?>">
							</td>
							<td><input type="text" name="t_value[]" id="t_value" class="t_value" value="<?php echo $row2['taxable_amt'] ?>">
								<?php
                                    if ($row2['field'] == 'Discount' || $row2['field'] == 'Freight Subsidy' || $row2['field'] == 'Credit Note') {
                                        $sign = -$row2['taxable_amt'];
                                    } else {
                                        $sign = $row2['taxable_amt'];
                                    } ?>
								<input type="hidden" class="total_amt" value="<?php echo $sign ?>"></td>
						</tr>
						<?php
                            } ?>
					</tbody>
				</table>
			</div><br>
		</form>
	</div>

<script type="text/javascript">
    $(document).on('click','#back',function(){
        window.open('showinvoice-696.php','_self');
    });
    
   	$('#receive_date,#invoice_date').inputmask('datetime', {
            mask: "1-2-y",
            alias: "dd-mm-yyyy",
            placeholder: "DD-MM-YYYY",
            separator: '-'
        });

    var pqr = 2;
	  $("#add1").click(function(){
		  var abc = $('#'+pqr+'amount').val();
			if (abc == "") 
			{
		  		alert('Please fill Current Information (कृपया पहले जानकारी भरें)');
			}
		  	else
		  	{
		 	 pqr++;
	  		var gst = $('#gst1').val();
	  		var arr = gst.split("-");
	  			var rowHtm5 = '<tr>';
	    			rowHtm5 += '<td><select name="field[]" class="field" id="'+pqr+'field" required><option >Discount</option><option >Freight</option><option >Packaging</option><option >Insurance</option><option >Other Charge</option><option >Freight Subsidy</option><option >Credit Note</option><input type="hidden" name="charge_id[]" value="new"></td>';
				    rowHtm5 += '<td><input type="text" name="amount[]" id="'+pqr+'amount" class="amount"></td>';

				    rowHtm5 += '<td><select id="'+pqr+'gst2" name="gst2[]" class="gst2"><option  value="'+gst+'">'+gst+'</option><option value="GST-5%">GST-5%</option><option value="GST-12%">GST-12%</option><option value="GST-18%">GST-18%</option><option value="GST-28%">GST-28%</option><option value="IGST-5%">IGST-5%</option><option value="IGST-12%">IGST-12%</option><option value="IGST-18%">IGST-18%</option><option value="IGST-28%">IGST-28%</option></select><input type="hidden" class="gstvalue" value="'+parseFloat(arr[1])+'"></td>';
				    rowHtm5 += '<td><input type="text" name="t_value[]" id="'+pqr+'t_value" class="t_value"><input type="hidden" class="total_amt"></td>';
				    
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
	  $(document).ready(function(e)
	  {

	  	var radioval = $('input[name=flexRadioDefault]:checked').val();
	  	var f = 0;
	  	$('.catg_nm').each(function()
		{	
			if($(this).val() == 30)
			{
				f = parseFloat($(this).val());					
			}
		});
		if(f == 30 && radioval == "YES")
		{
			$('#catg_nm_tc').val(f);
		}
		else if(f == 30 && radioval == "NO")
		{
			$('#catg_nm_tc').val(f);
			$('#tcremark').show();
		}

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

	$(document).on('change','.qnty,.rate,.tcs_amt',function(){
		var s = ($(this).closest('tr').find('.qnty').val() == '') ? 0 : $(this).closest('tr').find('.qnty').val();
		var p = ($(this).closest('tr').find('.rate').val() == '') ? 0 : $(this).closest('tr').find('.rate').val();
		var r = ($(this).closest('tr').find('.tcs_amt').val() == '') ? 0 : $(this).closest('tr').find('.tcs_amt').val();
		var cc = ($(this).closest('tr').find('.cgst').val() == '') ? 0 : $(this).closest('tr').find('.cgst').val();
		var ss = ($(this).closest('tr').find('.sgst').val() == '') ? 0 : $(this).closest('tr').find('.sgst').val();
		var ii = ($(this).closest('tr').find('.igst').val() == '') ? 0 : $(this).closest('tr').find('.igst').val();
		var t =  parseFloat(cc) + parseFloat(ss)  + parseFloat(ii)  ;
		var total = (p*s)*(1+t*0.01)+ parseFloat(r); 
		
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

    $('#receive_date').on('change', function(){
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
        
       $('#invoice_no,#p_days').change(function() {
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
            }
            else{
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

       // check purchase value not greater than balance qnty
	$(document).on('change','.qnty',function(){
		var qnty = $(this).val();
		var bqnty = $(this).closest('tr').find('.bqnty').val();
		//if (parseFloat(qnty) > parseFloat(bqnty) || parseFloat(qnty) == 0) {
		if (false) { // as per mitra ji remove validation 22.07.2022
			alert("Qnty must be less or equal than Entry Qnty");
			$(this).val('');
			$(this).focus();
		}
	});

	$(document).on('change','#flexRadioDefault1',function() 
	    {
	    	var f = 0;
		  	$('.catg_nm').each(function()
			{	
				if($(this).val() == 30)
				{
					f = parseFloat($(this).val());					
				}
			});
			if(f == 30)
			{
				$('#catg_nm_tc').val(f);
			}
	        //$('#tcupload').show();
	        $('#tcremark').hide();
	    });
	    
	    $(document).on('change','#flexRadioDefault2',function()
	    {
	       $('#tcremark').show(); 
	       //$('#tcupload').hide(); 
	    });
    </script>
</body>
</html>
