<?php
session_start();
if (!isset($_SESSION['oid'])) {
$_SESSION['login'] = "Please Login First";
header("location:..\..\OnlinePortal_login.php");
}
else {
include('..\..\dbcon.php');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
	  
    <meta charset="UTF-8">
    <title>add_data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
		<!-- Bootstrap 5 CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		
		<!-- Bootstrap 5 JS -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>
<style>
	  ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
    color: #ffff00;
    }
    ::-moz-placeholder { /* Firefox 19+ */
    color: #ffff00;
    }
    :-ms-input-placeholder { /* IE 10+ */
    color: #ffff00;
    }
		body{
				font-family: Tahoma;
				font-weight:normal;
			}
			/* Chrome, Safari, Edge, Opera */
				input::-webkit-outer-spin-button,
				input::-webkit-inner-spin-button {
				-webkit-appearance: none;
				margin: 0;
				}
			th{
				font-family: Tahoma;
				font-weight:normal;
				font-size: 12px;
				text-align: center;
				text-transform:nowrap;
			}
			.font{
				font-family: Tahoma;
				font-weight:normal;
				font-size: 12px;
				
			text-transform:nowrap;
			}
			.btn-success{
				background-color:#0dc51b;
				border-color:#198754;
				color:black;
			}
			.table-responsive{
				overflow-x:auto;
				overflow-y:auto;
				max-height:205px;
			}
			.ui-autocomplete {
			max-height: 100px;
			overflow-y: auto;
			overflow-x: hidden;
			background-color: #46dffa;
			font-size: 12px;
			font-family: Tahoma;
			}
			* html .ui-autocomplete {
			height: 100px;
			}
			.btn btn-dark{
				color:white;
				text-width:bold;
			}
			 .largerCheckbox{
        width: 25px;
        height: 18px;
        margin-top: 10px;
        } 
        #note_tbody input[type=text],textarea{
        	border: none;
        	box-shadow: none;
        	outline: none;
        	width: 100%;
        	padding-left: 5px;
        	background-color: #e5eff9;
        }
        #note_tbody input[type=text]{
        	font-family: sans-serif;
        }
        #note_table input{
        	border: none;
        	box-shadow: none;
        	outline: none;
        }
        #delivery_tbody input[type=text]{
        	border: none;
        	box-shadow: none;
        	outline: none;
        	width: 100%;
        	padding-left: 5px;
        	background-color: #e5eff9;
        }
        #delivery_table input{
        	border: none;
        	box-shadow: none;
        	outline: none;
        }
        #cardBody table td{
        	padding: 2px;
        }
        /*----toggle switch css-----*/
        .switch {
				  position: relative;
				  display: inline-block;
				  width: 55px;
				  height: 30px;
				}
				.switch input { 
				  opacity: 0;
				  width: 0;
				  height: 0;
				}
				.slider {
				  position: absolute;
				  cursor: pointer;
				  top: 0;
				  left: 0;
				  right: 0;
				  bottom: 0;
				  background-color: #ccc;
				  -webkit-transition: .4s;
				  transition: .4s;
				}
				.slider:before {
				  position: absolute;
				  content: "";
				  height: 22px;
				  width: 22px;
				  left: 4px;
				  bottom: 4px;
				  background-color: white;
				  -webkit-transition: .4s;
				  transition: .4s;
				}
				input:checked + .slider {
				  background-color: red;
				}
				input:focus + .slider {
				  box-shadow: 0 0 1px red;
				}
				input:checked + .slider:before {
				  -webkit-transform: translateX(26px);
				  -ms-transform: translateX(26px);
				  transform: translateX(26px);
				}
				/* Rounded sliders */
				.slider.round {
				  border-radius: 34px;
				}
				.slider.round:before {
				  border-radius: 50%;
				}
		</style>
<body>
	<div class="container-fluid mt-2">
		<form action="adddata_to_db_696.php" method="POST" id="setform">
			<div class="card-title text-white bg-dark text-center">
				<div class="row justify-content-lg-center p-1" style="background-color:#0d6efd;!important">
					<div class="col-lg-4 col-md-12 col-sm-12">
						<!-- <button type="button" class="btn btn-light shadow-lg float-start" style="width:100px;border-radius:2">Back</button> -->
						<a href="..\dashboard.php" class="btn btn-warning shadow-lg float-start" style="width:80px;border-radius:2">BACK</a>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12 mt-2">
						<h6 class="h5">:::: PURCHASE ORDER ::::</h6>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12">
						<button class="btn btn-warning shadow-lg float-end" type="submit" name="save" style="width:100px;border-radius:2">Save Data</button>
					</div>
				</div>
			</div>
			<?php if(isset($_SESSION['message'])): ?>
      <div class="alert alert-danger font-weight-bold font-italic close">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close float-end" aria-label="Close" id="close"></button>
      </div>
      <?php endif; ?>
      <?php unset($_SESSION['message']); ?>
			<!--===================== First Part ==========================-->
			<div class="row justify-content-lg-center font">
				<div class="col-lg-4 col-md-12 col-sm-12 mt-2">
					<div class="card shadow-lg" style="height:100%">
						<div class="card-body">
								
							<!--===== Start =======-->
							<div style="background-color:#0d6efd; color:white;" class="row py-2">
								<!-- <label for="fname" style="padding-left:4px;" >From MRS No.</label>
								<input type="text" id="fname" name="fname" style="background-color:yellow;">
								<button type="button" class="btn btn-dark"  >Get Data</button> -->
								<div class="col-6">
									<label style="font-size:17px;" class="px-2">Is From Requisition</label>
								</div>
								<div class="col-6">
									<label class="switch float-end">
								  <input type="checkbox" id="toggle_checkbox" value="yes">
								  <span class="slider round"></span>
									</label>
								</div>   
								 <input type="hidden" name="isReq" id="isReq">
							</div>
							<br>
							<!-- <button type="button" class="btn btn-primary" style="color:white;text-width:bold;margin-left: 15%;" >GET DATA</button> -->
							<div class="row row-cols-lg-auto g-3 align-items-center font">
									
								<div class="col-lg-4 col-md-12 col-sm-12">
									<label class="col-form-label-sm font">PoDate</label>
									<input type="date" data-date-format="" class="form-control form-control-sm font" name="podate" id="podate" value="<?php echo date("Y-m-d"); ?>">
								</div>
								<div class="col-lg-8 col-md-12 col-sm-12">
									<label class="col-form-label-sm font">PoGenerate By</label>
									<input type="text" class="form-control form-control-sm  font" value="<?php echo $_SESSION['oid'] ?>" name="pogen" id="pogen">
									<input type="hidden" name="dpmnt" id="dpmnt">
								</div>
							</div><br>
							<!--============= Exit =============-->
							<div class="row row-cols-lg-auto g-3 align-items-center font">
								<div class="col-lg-4 col-md-12 col-sm-12">
									<label class="col-form-label-sm font">ReqDate</label>
									<input type="text" class="form-control form-control-sm font" name="req_date" id="req_date" autocomplete="off" required>
								</div>
								<div class="col-lg-8 col-md-12 col-sm-12">
									<label class="col-form-label-sm font">MaterialReq By</label>
									<input type="text" class="form-control  form-control-sm font" name="matReqBy" id="matReqBy" autocomplete="off" required>
								</div>
							</div>
							<!--============= Exit =============-->
							<div class="row row-cols-lg-auto g-3 align-items-center mt-1 font">
								<div class="col-lg-12 col-md-12 col-sm-12">	
									<label class="col-form-label-sm font">Party</label>
									<div class="input-group mb-3">
										<input type="text" class="form-control form-control-sm font" id="party" aria-describedby="party" name="party" >
										<!-- Hidden input -->
										<input type="hidden" id="pcode">
										<input type="hidden" id="pid" name="pid" required>
										<input type="hidden" id="addcode">
										<input type="hidden" name="pono" id="pono">
											
										<button class="btn btn-danger" type="button" data-bs-toggle="modal" id="party" data-bs-target="#myModal" style="border: none;"><i class="fa fa-plus float-sm"></i></button>
									</div>
								</div>
							</div>

							<!--============= Exit =============-->
							<div class="row row-cols-lg-auto g-3 align-items-center font">
								<div class="col-lg-6 col-md-12 col-sm-12 col-auto">
									<label class="col-form-label-sm font">Payment Terms</label>
									<div class="input-group input-group-sm col-auto font">
										<input type="number" class="form-control form-control-sm font" name="p_days" id="p_days" placeholder="Days" required>
										<select class="form-select form-select-sm font" id="p_term" name="p_term">
											<option selected value="from_receive_date" class="bg-dark text-white font">From receive date</option>
                  		<option value="from_invoice_date" class="bg-dark text-white font">From invoice date</option>
										</select>
									</div>
								</div>
								<div class="col-lg-6 col-md-12 col-sm-12 col-auto">
									<label class="col-form-label-sm font">Advance</label>
									<div class="input-group input-group-sm font">
										<select class="form-select form-select-sm font" id="advance" name="advance" >
											<option selected class="bg-dark text-white font">No</option>
											<option  class="bg-dark text-white font">Yes</option>
										</select>
										<input type="number" id="advance_amt" name="advance_amt" class="form-control form-control-sm font" placeholder="Amount" readonly>
											
									</div>
								</div>
							</div>
								<!--============= Exit =============-->
						</div>
					</div>
				</div>	
				<div class="col-lg-8 col-md-12 col-sm-12 mt-2">
					<div class="card shadow-lg">
						<div class="card-body" id="cardBody">
							<div class="table-responsive">
								<table class="table-bordered table font">
									<tr style="background-color: slategrey; color: white;">
										<th class="col-form-label-sm font" style="width: 40%;">ITEM<span class="text-warning"> *</span></th>
										<th class="col-form-label-sm font" style="width: 15%;">QNT<span class="text-warning"> *</span></th>
										<th class="col-form-label-sm  font" style="width: 15%;">UNIT<span class="text-warning"> *</span></th>
										<th class="col-form-label-sm  font" style="width: 15%;">BASIC RATE<span class="text-warning"> *</span></th>
										<th class="col-form-label-sm  font" style="width: 15%;">BASIC VALUE</th>
									</tr>
									<tr>
										<td><input type="text" class="form-control form-control-sm font" id="item_desc" name="item_desc"></td>
										<td><input type="number" class="form-control form-control-sm font" id="qnty" name=""></td>
										<td>
											<select class="form-control form-control-sm font" name="unit" id="unit">
									       <option disabled="true" selected="true" value="" class="bg-dark">--unit--</option>
									          <?php
									          $sql="SELECT DISTINCT unit_name FROM unit ORDER BY unit_name";
									          $run=sqlsrv_query($con,$sql);
									          while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
														?>
									          <option value="<?php echo $row['unit_name'];  ?>"><?php echo $row['unit_name'];  ?></option>
									            <?php
									              }
									             ?>
									         </select>
										</td>
										<td ><input type="number" id="rate" step="0.01" class="form-control form-control-sm font" name=""></td>
										<td><input type="text" id="basic_rate" class="form-control form-control-sm font" name="" readonly></td>
									</tr>
								</table>
							</div>
								<div class="table-responsive">
									<table class="table-bordered table">
										<tr style="background-color: slategrey; color: white;">
											<th class="col-form-label-sm  font" style="width: 15%;">ModelNo</th>
											<th class="col-form-label-sm  font" style="width: 10%;">Make</th>
											<th class="col-form-label-sm  font" style="width: 15%;">HSN</th>
											<th class="col-form-label-sm  font" style="width: 20%;">PROJECT</th>
											<th class="col-form-label-sm  font" style="width: 20%;">JOB</th>
											<th class="col-form-label-sm  font" style="width: 35%;">REMARK</th>
										</tr>
										<tr>
											<td><input type="text" class="form-control form-control-sm font" name="ModelNo" id="ModelNo" ></td>
											<td><input type="text" class="form-control form-control-sm font" name="MakeBy" id="MakeBy" readonly></td>
											<td><input type="text" class="form-control form-control-sm font" name="hsn_code" id="hsn_code" ></td>
											<td class="d-flex">
												<input type="text" class="form-control form-control-sm font projecttemp" style="height: 10px;" name="project" id="project">
												<!-- <button class="btn btn-danger projectsave" type="button" id="projectsave" name="projectsave" style="height: 30px;border: none;" ><i class="fa fa-plus float-sm"></i>
												</button> -->
											</td>
											<td><input type="text" class="form-control form-control-sm font" name="job" id="job"></td>
											<td><input type="text" class="form-control form-control-sm font" name="remark" id="remark"></td>
										</tr>
									</table>
								</div>
								<div class="table-responsive">
									<table class="table-bordered table font">
										<tr style="background-color: slategrey; color: white;">
											<th class="col-form-label-sm font" style="width: 25%;">STOCK</th>
											<th class="col-form-label-sm font" style="width: 25%;">MATERIAL TYPE</th>
											<th class="col-form-label-sm font" style="width: 25%;">MAIN GRADE</th>
											<th class="col-form-label-sm font" style="width: 25%;">SUB GRADE</th>
											
										</tr>
										<tr>
											<td><input type="text" class="form-control form-control-sm font"  name="" readonly></td>
											<td><input type="text"class="form-control form-control-sm font" id="mat" name="" readonly></td>
											<td><input type="text" class="form-control form-control-sm font" id="m_grade" name="" readonly></td>
											<td><input type="text" class="form-control form-control-sm font" id="s_grade" name="" readonly>
												<!-- Hidden input -->
												<input type="hidden" name="" id="i_code">
									            <input type="hidden" name="" id="s_code">
									            <input type="hidden" name="" id="m_code">
									            <input type="hidden" name="" id="c_code">
										     </td>	
									  </tr>
								  </table>
							  </div>
							<div class="table-responsive">
								<table class="table-bordered table">
									<tr style="background-color: slategrey; color: white;" >
										<th class="col-form-label-sm font" style="width: 11%;">MATERIAL USE BY</th>
										<th class="col-form-label-sm font" style="width: 12%;">M/C NO.</th>
										<th class="col-form-label-sm font" style="width: 20%;">NAME</th>
										<th class="col-form-label-sm font" style="width: 20%;">DEPARTMENT</th>
										<th class="col-form-label-sm font" style="width: 11%;">PLANT</th>
										<th class="col-form-label-sm font" style="width: 11%;">TYPE</th>
										<th class="col-form-label-sm font" style="width: 15%;">OLD PART STATUS</th>
									</tr>
									<tr>
										<td>
											<select class="form-select form-select-sm font" id="use_by">
												<option disabled="" selected class="bg-primary text-white font">-- Select --</option>
												<option class="bg-dark text-white font">Person</option>
												<option class="bg-dark text-white font">Machine</option>
												<option class="bg-dark text-white font">Department</option>
												<option class="bg-dark text-white font">Stock</option>
											</select>
										</td>
										<td><input type="text" class="form-control form-control-sm font" name="" id="mcno"></td>
										<td><input type="text" class="form-control form-control-sm font" name="" id="person"></td>
										<td><input type="text" class="form-control form-control-sm font" name="" id="dpnt"></td>
										<td><input type="text" class="form-control form-control-sm font" name="" value="696" id="plant"></td>
										<td>
											<select class="form-select form-select-sm font" aria-label="Default select example" id="type" name="status[]">
												<option disabled="" selected class="bg-primary text-white">-- Select --</option>
												<option  class="bg-dark text-white">New</option>
												<option  class="bg-dark text-white">Replace</option>
											</select>
										</td>
										<td>
											<select class="form-select form-select-sm font" aria-label="Default select example" id="old_part" name="old_part[]" >
												<option disabled="" selected class="bg-primary text-white">-- Select --</option>
												<option  class="bg-dark text-white hideit">Repair</option>
												<option  class="bg-dark text-white hideit">Stock</option>
												<option  class="bg-dark text-white hideit">Scrap</option>
											</select>
										</td>
									</tr>
								</table>
								<div>
									<button type="button" class="btn btn-primary btn-sm float-end px-4 py-1 mx-2 add" style="text-width:bold; font-size:17px;" id="add">ADD</button>
							<?php
						      if (isset($_SESSION['pono_entry'])) {
						      ?>
						      <a href="pdfdata-696.php?sid=<?php echo $_SESSION['pono_entry']; ?>" class="btn btn-warning btn-sm float-end px-5 py-1" id="print" style="font-size:17px;">Print</a>
						      <?php
						      }
						      ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row justify-content-lg-center">
				<div class="col-lg-4 col-md-12 col-sm-12 ">
					<div class="card shadow-lg" style="margin-top: 10px;">
						
						<!--Terms and condition Modal -->

    <!-----------------------------------------   Terms and condition Modal ----------------------------------------->
    <div class="modal fade small" id="note_modal" aria-labelledby="note_modal" aria-hidden="true" tabindex="-1">
            
        <!----------------- Scrollable modal --------------------------->
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header font-weight-bold">
                  	<h4>Term & Conditions</h4>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="note_modal">
                	<div id="note">
										<table class="table-bordered" style="width:100%" id="notemodal_table">
											<thead>
												<tr class="bg-warning">
													<th style="font-size: 15px;"><input type="checkbox" name="" class="largerCheckbox term" onclick="toggle(this);"></th>
													<th style="font-size: 16px;"><b>Title</b></th>
													<th style="font-size: 16px;"><b>Description</b></th>
												</tr>
											</thead>
											<tbody id="note_tbody">
												<?php 
													$query = "SELECT * FROM note";
												  $run = sqlsrv_query($con,$query);
												  while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)){
												  	?>
												        <tr style="background-color:#e5eff9">
												            <td width="5%" class="text-center"><input type="checkbox" class="largerCheckbox chkNote term" name="" ></td>
												            <td width="15%"><input type="text" class="noteTitle" name="" value="<?php echo $row['title'] ?>"></td>
												            <td width="80%"><textarea class="noteDescription"><?php echo $row['Descriptions'] ?></textarea></td>
												        </tr>
												 	<?php  } ?>
											</tbody>
										</table>
									</div>
                </div>
         	    <div class="modal-footer">
                    <button type="button" name="save" class="btn btn-primary btn-md px-4" id="send_note" >ADD</button>
                </div>
            </div>
        </div>
    </div>
					
						<!-- Selection Of Transporters -->
						
						<div class="card shadow-lg">
							
							<div class="card-header bg-primary text-white">
								Terms & Conditions
								<input type="hidden" name="termsid" id="termsid">
								<!-- Button trigger modal --><!--  model draft upon button trigger -->
								<button type="button" class="btn btn-dark btn-sm float-end" data-bs-toggle="modal" data-bs-target="#note_modal" id="term_show" style="width:100px;height:38px;">
								Terms
								</button>
								<!-- <button type="button"  class="btn float-end btn-light" role="button" data-bs-toggle="collapse show" data-bs-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
								<i class="fa fa-minus-square" aria-hidden="true"></i>
								</button> -->
							</div>
							<!-- /.card-header -->
							<div class="card-body p-0 " id="collapseExample">
								<div class="table-responsive" >
									<table class="table m-0 nowrap table-sm table-bordered" id="note_table">
										<thead>
											<tr>
												<th style="font-size: 15px;">Title</th>
												<th style="font-size: 15px;">Description</th>
											</tr>
										</thead>
										<tbody>
												<!-- dynamic load data -->
										</tbody>
									</table>
								</div>
							</div>
							<!--Trasnporters selection End-->
						</div>	
					</div>

					 <!-----------------------------------------  delivery Modal ----------------------------------------->
    		<div class="modal fade small" id="delivery_modal" aria-labelledby="delivery_modal" aria-hidden="true" tabindex="-1">
            
        <!----------------- Scrollable modal --------------------------->
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header font-weight-bold">
                  	<h4>Delivery Address</h4>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="delivery_modal">
                	<div id="delivery">
										<table class="table-bordered" style="width:100%">
											<thead>
												<tr class="bg-warning">
													<th style="font-size: 15px;"><!-- <input type="checkbox" name="" class="largerCheckbox del" onclick="toggle1(this);"> --></th>
													<th style="font-size: 16px;"><b>Location</b></th>
													<th style="font-size: 16px;"><b>Location Address</b></th>
												</tr>
											</thead>
											<tbody id="delivery_tbody">
												<?php 
													$query1 = "SELECT * FROM delivery_location";
												   $run1 = sqlsrv_query($con,$query1);
												  while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC)){
												  	?>
												        <tr style="background-color:#e5eff9">
												            <td width="5%" class="text-center"><input type="checkbox" class="largerCheckbox checkNote"></td>
												            <td width="15%"><input type="text" class="location" value="<?php echo $row1['location']; ?>"></td>
												            <td width="80%"><textarea class="location_addr"><?php echo $row1['location_address']; ?></textarea></td>
												        </tr>
												 	<?php  } ?>
											</tbody>
										</table>
									</div>
                </div>
         	    	<div class="modal-footer">
                    <button type="button" name="save" class="btn btn-primary btn-md px-4" id="send_delivery" >ADD</button>
                </div>
            	</div>
        		</div>
    			</div>
						<!-- Selection Of Transporters -->
						
						<!-- Delievery Address -->
					<div class="card mt-3 shadow-lg">
						<div class="card shadow-lg">
							<div class="card-header  bg-primary text-white">Delievery Address
								<input type="hidden" name="delid" id="delid">
								<!-- Button trigger modal -->
								<button type="button" class="btn btn-dark btn-sm float-end" data-bs-toggle="modal" data-bs-target="#delivery_modal" style="width:100px;height:38px;">Address
								</button>	
							</div>

							<!-- /.card-header -->
							<div class="card-body p-0" id="collapseExample1">
								<div class="table-responsive">
									<table class="table m-0 nowrap table-sm table-bordered" id="delivery_table">
										<thead>
											<tr>
												<th style="font-size: 15px;">Location</th>
												<th style="font-size: 15px;">Location Address</th>	
											</tr>
										</thead>
										<tbody>
											<!-- <td><input type="text" class="form-control form-control-sm" name="" style="width:150px;height:50px"></td>
											<td><textarea  class="form-control form-control-sm" name="" style="width:400px"></textarea></td> -->
										</tbody>
									</table>
								</div>
							</div>
							<!--Delievery Address End -->
							<!--Trasnporters selection End-->
						</div>	
					</div>
				</div>
				
				<div class="col-lg-8 col-md-12 col-sm-12 mt-2">
					<div class="card shadow-lg">
						<div class="card-body">
							<div class="table-responsive">
								<table class=" table-bordered" id="table_field">
									<tr class="font" style="background-color: slategrey; color: white;">
										<th >SR</th>
										<th>ITEM</th>
										<th>QTY</th>
										<th>UNIT</th>
										<th>RATE</th>
										<th>BASIC VALUE</th>
										<th>Make</th>
										<th>ModelNo</th>
										<th>HSN</th>
										<th>PROJECT</th>
										<th>JOB</th>
										<th>REMARK</th>
										<th>MATERIAL USE BY</th>
										<th>M/C NO.</th>
										<th>PERSONNAME</th>
										<th>DEPARTMENT</th>
										<th>PLANT</th>
										<th>TYPE</th>
										<th>OLD STATUS</th>
										
									</tr>
									<tbody id="t_body">
										
									</tbody>
									<tfoot>
							      <tr style="background-color:pink;">
							        <td colspan="5" style="text-align:right; color:blue;"><b>PO VALUE</b></td>
							        <td colspan="15" id="po_total" style="color:blue; font-weight:bold;"></td>
							        <input type="hidden" name="po_value" id="po_value">
							      </tr>              
							  </tfoot>  
								</table>
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>


			<div class="modal fade bd-example-modal-lg" id="rate_diff" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title font-weight-bold">LAST 10 ITEM RATE HISTORY</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="order_table">
              <!-- Dynamic Table from ajax load -->
            </div>
            
          </div>
        </div>
      </div>

      <!---------------------------------Add Party Modal ----------------------------->
									<div class="modal fade" id="myModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
										<div class="modal-dialog">
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title font-weight-bold" id="exampleModalLabel">Add Party Master</h4>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
													
												<div class="modal-body">
													<form action="party_master.php" method="post">
														<input type="text" name="party_name" placeholder="Party Name(required**)" class="form-control font-weight-bold font" id="party_name" required>
															
														<input type="text" name="place" placeholder="Place (optional)" class="form-control font-weight-bold mt-1 font" id="place">
															
														<input type="text" name="party_address" placeholder="Address (optional)" class="form-control font-weight-bold mt-1 font" id="party_address">
														<input type="text" name="p_code" placeholder="Party Code" class="form-control font-weight-bold mt-1 font" id="p_code" required>
															
														<input type="text" name="GSTIN" placeholder="GSTIN (optional)" class="form-control font-weight-bold mt-1 font" id="GSTIN">
															
														<input type="text" name="con_no" placeholder="Contact No" class="form-control font-weight-bold mt-1 font" id="con_no">
															
														<input type="text" name="con_per" placeholder="Contact Person" class="form-control font-weight-bold mt-1 font" id="con_per">
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
															<button type="submit" name="p_master" id="p_master" value="submit" class="btn btn-primary btn-sm">Save</button>	
														</div>
													</form>
												</div>
													
											</div>
										</div>
									</div>



								<div class="modal fade" id="myModalproject" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
										<div class="modal-dialog">
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title font-weight-bold" id="exampleModalLabel">Add Project Master</h4>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
													
												<div class="modal-body">
													<form action="party_master.php" method="post">
														<input type="text" name="party_name" placeholder="Party Name(required**)" class="form-control font-weight-bold font" id="party_name" required>
															
														<input type="text" name="place" placeholder="Place (optional)" class="form-control font-weight-bold mt-1 font" id="place">
															
														<input type="text" name="party_address" placeholder="Address (optional)" class="form-control font-weight-bold mt-1 font" id="party_address">
														<input type="text" name="p_code" placeholder="Party Code" class="form-control font-weight-bold mt-1 font" id="p_code" required>
															
														<input type="text" name="GSTIN" placeholder="GSTIN (optional)" class="form-control font-weight-bold mt-1 font" id="GSTIN">
															
														<input type="text" name="con_no" placeholder="Contact No" class="form-control font-weight-bold mt-1 font" id="con_no">
															
														<input type="text" name="con_per" placeholder="Contact Person" class="form-control font-weight-bold mt-1 font" id="con_per">
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
															<button type="submit" name="p_master" id="p_master" value="submit" class="btn btn-primary btn-sm">Save</button>	
														</div>
													</form>
												</div>
													
											</div>
										</div>
									</div>
</body>
</html>
<?php
  }
  ?>
<script type="text/javascript">
	$( function() {
  $( "#req_date" ).datepicker();
  $( "#req_date" ).datepicker( "option", "dateFormat", "d-M-y" );
  });
	$( function() 
	{
  	// party autocomplete box
  		$( "#party" ).autocomplete({
  		source: function( request, response ) 
  		{
	  			var y = $('#isReq').val();
	  			// Fetch data
	  			$.ajax({
					  url: "fetch1.php",
					  type: 'post',
					  dataType: "json",
					  data: {
					  party: request.term,
					  isreq: y
	  			},
	  			success: function( data ) 
	  			{
	  				response( data );
	  			}
 		 			});
  		},
  		select: function (event, ui) {
  			// Set selection
				  $('#party').val(ui.item.label);
				  $('#pcode').val(ui.item.pcode);
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
          else{
             var pcode = $("#pcode").val();
             var podate = $('#podate').val();
             var date = new Date(podate);
             var mm = date.toLocaleString("default", { month: "short" });
             var yy = date.getFullYear();
             var po = yy+"/"+mm+"/"+pcode+"/";
             $('#pono').val(po);
          }
        }
});



        //project 
  $( "#project" ).autocomplete
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
		select: function (event, ui) {
			// Set selection
			  $('#project').val(ui.item.label);
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

// pogen autocomplete box
$( "#pogen,#matReqBy" ).autocomplete({
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
		$(this).val(ui.item.name);
		$('#dpmnt').val(ui.item.dpmnt);
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

  $( "#item_desc" ).autocomplete({
  		source: function( request, response ) {
  		// Fetch data
 			 $.ajax({
			  url: "getpoitem.php",
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
		  $('#item_desc').val(ui.item.label);
		  $('#i_code').val(ui.item.i_code);
		  $('#s_code').val(ui.item.s_code);
		  $('#m_code').val(ui.item.m_code);
		  $('#c_code').val(ui.item.c_code);

		  $('#mat').val(ui.item.category);
		  $('#m_grade').val(ui.item.main_grade);
		  $('#s_grade').val(ui.item.sub_grade);
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


  // make by autocomplete box
  		$( "#ModelNo" ).autocomplete(
  		{
  				source: function( request, response ) 
		  		{
						// Fetch data
						$.ajax(
						{
							  url: "fetch_modelno.php?status=1",
							  type: 'post',
							  dataType: "json",
							  data: {make: request.term},
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
						  $('#ModelNo').val(ui.item.label);
						  $('#MakeBy').val(ui.item.Make_by);
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


	//save project
	$(document).on('click','#projectsave',function()
	{
	  var projectname = $(".projecttemp").val(); 
	  if(projectname == "")
	  {
	  	alert('Enter Project name');
	  	$("#project").focus();
	  	return false;
	  }
	  else
	  {
	    $.ajax({
		      url: "fetchProject.php?status=2",
		      method:"POST",
		      data:{projectname:projectname},
		      success:function(data)
		      {
		      	alert(data);
		      	//alert('Project Added Successfully');
		       	//$('#rate_diff').modal('show');
		      }
	    });
	  }
});
	
	//end

    $('#rate,#qnty').change(function(){
	    var rate = $("#rate").val();
	    var qnty = $("#qnty").val();
	    var a = rate*qnty;
	    $("#basic_rate").val((a).toFixed(2));
    });	
	
	// Rate Diffrent modal
     $("#rate").focusout(function(){
           var i_code = $("#i_code").val(); 
           /*alert(i_code);*/ 
           $.ajax({
                url:"rateHistoryModal.php",
                method:"POST",
                data:{i_code:i_code},
                success:function(data)
                {
                $('#order_table').html(data);
                 $('#rate_diff').modal('show');
                }
                });
       });

  /*------autocomplete textbox-----*/
  $( function() 
  {
 		// mc autocomplete box
 		$( "#mcno" ).autocomplete(
 		{
	  		source: function( request, response ) {
	  		 // Fetch data
	   		$.ajax({
			    url: "store/getmc-696.php",
			    type: 'post',
			    dataType: "json",
			    data: {
			     mc: request.term
	   	 },
	    	success: function( data ) 
	    	{
	     		response( data );
	    	}
	   	});
	  },
	  select: function (event, ui) 
	  {
	  	// Set selection
			$('#mcno').val(ui.item.label);
			$('#person').val(ui.item.pname1);
			$('#dpnt').val(ui.item.dname);
			//$('#plant').val(ui.item.pname2);
			return false;
   },
   change: function (event, ui)  //if not selected from Suggestion
   {
        if (ui.item == null)
        {
          $(this).val('');
          $(this).focus();
        }
        else
        {
      		$('#person,#dpnt,#plant').prop('readonly', true);
        }    
    }
 });

// person autocomplete box
 $( "#person" ).autocomplete({
	  source: function( request, response ) {
	   // Fetch data
	   $.ajax({
		    url: "store/getperson-696.php",
		    type: 'post',
		    dataType: "json",
		    data: {
		     person: request.term
	    },
	    success: function( data ) {
	     response( data );
	    }
  	});
  },
  select: function (event, ui) {
	   // Set selection
	   $('#person').val(ui.item.label);
	   $('#dpnt').val(ui.item.dname);
	   //$('#plant').val(ui.item.pname);
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
					$('#dpnt,#plant').prop('readonly', true);
         }
      }
 });

// department autocomplete box
 $( "#dpnt" ).autocomplete({
	  source: function( request, response ) {
	   // Fetch data
	   $.ajax({
		    url: "store/getdpnt-696.php",
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
   $('#dpnt').val(ui.item.label);
   //$('#plant').val(ui.item.pname);
   
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

/*--for hide and show of old part status--*/
  $(document).on('change','#type',function(){
		var a = $(this).val();
		if (a == 'Replace') {
			$(this).closest('tr').find(".hideit").show();
		}
		else {
			$(this).closest('tr').find(".hideit").hide();
		}
});


  // payment days validation
    $("#p_days").focusout(function(){
	    var p_days = $('#p_days').val();
	    if (p_days < 0 || p_days > 90) {    
	        $(this).focus();
	        $(this).val('');
	        alert('Payment Days must be between 1 and 90');
	     } 
    });

    $(document).on('change','#advance',function(){
    		var x = $(this).val();
    		if (x == 'Yes') {
    			$('#advance_amt').prop('readonly', false);
    		}else{
    			$('#advance_amt').prop('readonly', true);
    			$('#advance_amt').val('');
    		}    		
    	});

var count = 0;
   // after add button press function
  $(document).on('click','#add',function(){
  var item_desc = $('#item_desc').val();
  var qnty = $('#qnty').val();
  var unit = $('#unit').val();
  var rate = $('#rate').val();
  if (item_desc == '' || qnty == '' || unit == '' || rate == '') {
  alert('Please fill in all the required fields (indicated by *)');
  }
  else{
  $('#addcode').val('okk');
 /* $("#data_head").show();*/
  count++;
  var html = '';
  html += '<tr>';
    html += '<td><input type="text" class="form-control" id="'+count+'srno" value="'+count+'" readonly style="width:50px"><input type="hidden" name="req_id[]" id="'+count+'req_id" value="0"></td>';
    html += '<td><input type="text" class="form-control item" value="" name="item_desc[]" id="'+count+'item_desc" readonly style="width:400px"><input type="hidden" id="'+count+'i_code" name="i_code[]"><input type="hidden" id="'+count+'s_code" name="s_code[]"><input type="hidden" id="'+count+'m_code" name="m_code[]"><input type="hidden" id="'+count+'c_code" name="c_code[]"></td>';
    html += '<td><input type="text" class="form-control text-center" name="qnty[]" id="'+count+'qnty" readonly style="width:100px"></td>';
    html += '<td><input type="text" class="form-control text-center" name="unit[]" id="'+count+'unit" readonly style="width:120px"></td>';
    html += '<td><input type="text" class="form-control text-center" name="rate[]" id="'+count+'rate" readonly style="width:120px"></td>';
    html += '<td><input type="text" class="form-control text-center basic_rate" name="basic_rate[]" id="'+count+'basic_rate" readonly style="width:120px"></td>';
    html += '<td><input type="text" class="form-control text-center" name="MakeBy[]" id="'+count+'MakeBy" readonly style="width:150px"></td>';
    html += '<td><input type="text" class="form-control text-center" name="ModelNo[]" id="'+count+'ModelNo" readonly style="width:150px"></td>';
    html += '<td><input type="text" class="form-control text-center" name="hsn_code[]" id="'+count+'hsn_code" readonly style="width:150px"></td>';
    html += '<td><input type="text" class="form-control text-center" name="project[]" id="'+count+'project" readonly style="width:150px"></td>';
    html += '<td><input type="text" class="form-control text-center" name="job[]" id="'+count+'job" readonly style="width:120px"></td>';
    html += '<td><input type="text" class="form-control text-center" name="remark[]" id="'+count+'remark" readonly style="width:160px"></td>';
		html += '<td><input type="text" class="form-control" name="use_by[]" id="'+count+'use_by" readonly style="width:160px"></td>';
    html += '<td><input type="text" class="form-control text-center" name="mcno[]" id="'+count+'mcno" readonly style="width:120px"></td>';
    html += '<td><input type="text" name="person[]" class="form-control person" id="'+count+'person" readonly style="width:160px"></td>';
    html += '<td><input type="text" class="form-control dpnt" name="dpnt[]" id="'+count+'dpnt" readonly style="width:160px"></td>';
    html += '<td><input type="text" class="form-control plant" name="plant[]" id="'+count+'plant" readonly style="width:120px"></td>';
    html += '<td><input type="text" class="form-control text-center" name="type[]" id="'+count+'type" readonly style="width:140px"></td>';
    html += '<td><input type="text" class="form-control text-center" name="old_part[]" id="'+count+'old_part" readonly style="width:130px"></td>';
    
    html += '<td style="width:2%"><button type="button" id="edit" class="btn btn-info font-weight-bold text-danger">X</button></td>';
   html += '</tr>';

    $('#t_body').append(html);
    var item = $('#item_desc').val();
    $('#'+count+'item_desc').val(item);
    $('#item_desc').val('');
    var i_code = $('#i_code').val();
    $('#'+count+'i_code').val(i_code);
    $('#i_code').val('');
    var s_code = $('#s_code').val();
    $('#'+count+'s_code').val(s_code);
    $('#s_code').val('');
    var m_code = $('#m_code').val();
    $('#'+count+'m_code').val(m_code);
    $('#m_code').val('');
    var c_code = $('#c_code').val();
    $('#'+count+'c_code').val(c_code);
    $('#c_code').val('');

    var qnty = $('#qnty').val();
    $('#'+count+'qnty').val(qnty);
    $('#qnty').val('');
    var unit = $('#unit').val();
    $('#'+count+'unit').val(unit);
    $('#unit').val('');
    var basic_rate = $('#rate').val();
    $('#'+count+'rate').val(basic_rate);
    $('#rate').val('');
    var basic_value = $('#basic_rate').val();
    $('#'+count+'basic_rate').val(basic_value);
    $('#basic_rate').val('');

    var MakeBy = $('#MakeBy').val();
    $('#'+count+'MakeBy').val(MakeBy);
    $('#MakeBy').val('');
    var ModelNo = $('#ModelNo').val();
    $('#'+count+'ModelNo').val(ModelNo);
    $('#ModelNo').val('');

    var hsn_code = $('#hsn_code').val();
    $('#'+count+'hsn_code').val(hsn_code);
    $('#hsn_code').val('');
    var project = $('#project').val();
    $('#'+count+'project').val(project);
    $('#project').val('');
    var job = $('#job').val();
    $('#'+count+'job').val(job);
    $('#job').val('');
    var remark = $('#remark').val();
    $('#'+count+'remark').val(remark);
    $('#remark').val('');
    var use_by = $('#use_by').val();
    $('#'+count+'use_by').val(use_by);
    $('#use_by').val('');
    var mc_no = $('#mcno').val();
    $('#'+count+'mcno').val(mc_no);
    $('#mcno').val('');
    var personname = $('#person').val();
    $('#'+count+'person').val(personname);
    $('#person').val('');
    var department = $('#dpnt').val();
    $('#'+count+'dpnt').val(department);
    $('#dpnt').val('');
    var plant = $('#plant').val();
    $('#'+count+'plant').val(plant);
    $('#plant').val('');
    var type = $('#type').val();
    $('#'+count+'type').val(type);
    $('#type').val('');
     var old_status = $('#old_part').val();
    $('#'+count+'old_part').val(old_status);
    $('#old_part').val('');

   /* $('#mat').val('');
    $('#m_grade').val('');
    $('#s_grade').val('');*/
    	var b = 0;
				$(".basic_rate").each(function()
				{
					 b += parseFloat($(this).val());
					$("#po_total").text(b);
					$("#po_value").val(b);
				});
    	}
   });
    /*========================================================*/
 	 $(document).on('click','#edit',function(){
    	if(confirm('क्या आप वाकई इस ROW को हटाना चाहते हैं !!')){
    		$(this).closest('tr').remove();
    		
	    	var b = 0;
	    	alert(b);
				$(".basic_rate").each(function()
				{
					b += parseFloat($(this).val());
				});
				$("#po_total").text(b);
				$("#po_value").val(b);
				return false;
    	}
    });


 	 $("#setform").submit(function(){
	    var addcode = $('#addcode').val();
	    var termsid = $('#termsid').val();
	    var delid = $('#delid').val();
	    
	    if (addcode == ''){
		    alert('Please Add minimum one Item Press ADD Button');
		    return false
	    }
	    else if (termsid == ''){
	      alert('Please Add Terms & Conditions');
	    	return false
	    }
	    else if (delid == ''){
	      alert('Please Add Delevery Location');
	    	return false
	    }
    });

 	 /*select All*/
function toggle(source) {
var checkboxes = document.querySelectorAll('.term');
for (var i = 0; i < checkboxes.length; i++) {
if (checkboxes[i] != source)
checkboxes[i].checked = source.checked;
}
//alert(checkboxes.length);
}


/*Load modal data*/
$('#send_note').click(function(){
    //alert('modal close');
    $("#note_table td").remove();
    var id = [];
    var title = [];
    var desc = [];
    $('.chkNote:checked').each(function(i){

			id[i] = $(this).val();
			title[i] = $(this).closest('tr').find('.noteTitle').val();
			desc[i] = $(this).closest('tr').find('.noteDescription').val();
		});
	if(id.length === 0) //tell you if the array is empty
		{
			$('#termsid').val('');
		alert("Please Select atleast one checkbox");
		}
		else
		{
			$('#termsid').val('t1');
			rowHTML = '';
					  for(var i=0; i<id.length; i++)
						{
							rowHTML += '<tr>';
            rowHTML += '<td><input type="text" name="title[]" value="'+title[i]+'" style="width:150px; font-size:14px" readonly></td>';
            rowHTML += '<td><input type="text" name="desc[]" value="'+desc[i]+'" style="width:400px; font-size:14px" readonly></td>';
            rowHTML += '</tr>';
           
            $('#note_table').find('tbody').append(rowHTML);
            rowHTML = '';
						}
					$('#note_modal').modal('hide');	
		
		}	
});

/*Load delivery modal data*/
$('#send_delivery').click(function(){
    //alert('modal close');
    $("#delivery_table td").remove();
    var id = [];
    var title1 = [];
    var desc1 = [];
    $('.checkNote:checked').each(function(i){
			id[i] = $(this).val();
			title1[i] = $(this).closest('tr').find('.location').val();
			desc1[i] = $(this).closest('tr').find('.location_addr').val();
		});
		if(id.length === 0) //tell you if the array is empty
		{
			$('#delid').val('');
			alert("Either memo_no Empty OR checkbox");
			console.log(title1[i]);
		 }
		else
		{
			$('#delid').val('d1');
			rowHTML = '';
					  for(var i=0; i<id.length; i++)
						{
							rowHTML += '<tr>';
            rowHTML += '<td><input type="text" name="loc[]" value="'+title1[i]+'" style="width:150px; font-size:14px" readonly></td>';
            rowHTML += '<td><input type="text" name="addr[]" value="'+desc1[i]+'" style="width:400px; font-size:14px" readonly></td>';
            rowHTML += '</tr>';
           
            $('#delivery_table').find('tbody').append(rowHTML);
            rowHTML = '';
						}
					$('#delivery_modal').modal('hide');	
		
		}	
});

/*toggle button js*/	
$(document).on('click','#toggle_checkbox', function(){
		var yes = $(this).val();
		if(this.checked){
			$('#isReq').val(yes);
		}
		else{
			$('#isReq').val('');
		}
	});

$(document).on('change','#party',function(){
	var z = $('#isReq').val();
	var p = $('#pid').val();
	if (z == 'yes'){
		$.ajax({
        url:"getfrom_requisition.php",
        method:"POST",
        data:{p:p},
        success:function(data)
        {
	        $('#t_body').html(data);
	        $('#addcode').val('okk');
        },
        complete:function(){
        	var a = 0;
					$(".basic_rate").each(function(){
						 a += parseFloat($(this).val());
						$("#po_total").text(a);
						$("#po_value").val(a);
					});
        }
      });
	}
});

$(document).on('change','.po_qnty',function(){
		var x = $(this).val();
		var r = $(this).closest('tr').find('.po_rate').val();
					$(this).closest('tr').find('.basic_rate').val(x*r);
		var y = $(this).closest('tr').find('.r_qnty').val();
		var z = $(this).closest('tr').find('.req_id2').val();
		if (x > y) {
			alert('PO quantity must be less than Requisition quantity');
			$(this).val('');
			$(this).focus();
			
		}
		else if (y > x) {
			$(this).closest('tr').find('.req_id').val('0');
		}
		else{
				$(this).closest('tr').find('.req_id').val(z);
		}
		var a = 0;
			$(".basic_rate").each(function(){
				 a += parseFloat($(this).val());
				$("#po_total").text(a);
				$("#po_value").val(a);
			});
});

$(document).on('click','#close',function(){
		location.reload(true);
});

$('#rate_diff').on('hidden.bs.modal', function () {
  $('#hsn_code').focus();

});
</script>