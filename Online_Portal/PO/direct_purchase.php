
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>add_data</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- jQuery Input mask -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
        <style type="text/css" media="screen">
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
        ::selection{
        }
        .wrapper  .field{
        height: 40px;
        width: 85%;
        margin-top: 15px;
        position: relative;
        }
        .wrapper  .field input{
        height: 85%;
        width: 100%;
        outline: none;
        font-size: 17px;
        padding-left: 20px;
        border: 1px solid blue;
        border-radius: 0px;
        transition: all 0.3s ease;
        }
        .wrapper  .field input:focus,
        .field input:valid{
        border-color: #4158d0;
        }
        .wrapper  .field label{
        position: absolute;
        top: 50%;
        left: 20px;
        color: #999999;
        font-weight: 400;
        font-size: 16px;
        pointer-events: none;
        transform: translateY(-60%);
        transition: all 0.3s ease;
        }
        .field input:focus ~ label,
        .field input:valid ~ label{
        top: 0%;
        font-size: 15px;
        color: #0033cc;
        background: #f2f2f2;
        transform: translateY(-60%);
        }
        .field select:focus ~ label,
        .field select:valid ~ label{
        top: 0%;
        font-size: 15px;
        color: #0033cc;
        background: #f2f2f2;
        transform: translateY(-60%);
        }
        .content input{
        width: 15px;
        height: 15px;
        background: red;
        }
        .content label{
        color: #262626;
        user-select: none;
        padding-left: 5px;
        }
        body,input[type='text']{
        background-color: #f2f2f2;
        }
        input:read-only{
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bold;
        }
        #tc_receipt,#freight_paid_by,#tc_status,#invoice_date,#receive_date,
        #received_at{
        background-color: #f2f2f2;
        height: 85%;
        width: 100%;
        outline: none;
        font-size: 17px;
        padding-left: 20px;
        border: 1px solid blue;
        border-radius: 0px;
        transition: all 0.3s ease;
        }
        th{
        background-color: #a3c2c2;
        }
        #item_desc,#hsn_code,#project,#job,#remark1{
        background-color: #e6b3ff;
        padding: 5px;
        font-size: 15px;
        }
        #qnty,#disc_per,#disc_amt,#rate,#freight,#packaging,#insurance,#other_charge,
        #cgst_per,#sgst_per,#igst_per,#tcs_per{
        background-color: #b3e6ff;
        font-size: 12px;
        padding: 3px;
        border-radius: 0px;
        border: 1px dotted #000000;
        }
        #tax_amt,#cgst_amt,#sgst_amt,#igst_amt,#tcs_amt,#total_tax_amt,#total_amt{
        background-color: #e6e6ff;
        font-size: 12px;
        padding: 3px;
        border-radius: 0px;
        border: 1px dotted #000000;
        }
        #srow{
        background-color: #1aff1a;
        }
        #trow{
        background-color: #ffb3ff;
        border: 0.5px solid black;
        font-size: 12px;
        }
        .po_list {
        width: 95%;
        margin-left: 3%;
        margin-bottom: 4%;
        margin-top: 1%;
        background-color: #a3a375;
        text-align: left;
        padding: 30px;
        max-height: 250px;
        overflow: hidden;
        overflow-x: scroll;
        overflow-y: scroll;
        }
        .img_file {
        width: 200px;
        background-color: #ff66ff;
        text-align: left;
        padding: 10px;
        overflow: hidden;
        }
        .po_search{
        width: 200px;
        background-color: #b3b3cc;
        text-align: center;
        padding: 15px;
        overflow: hidden;
        margin: 1px;
        }
        .img_head{
            color: #000000;
            text-decoration: underline;
        }
        #xrow{
        
        color: #660033;
        border: 1px solid black;
        font-size: 15px;
        }
        #po_list_table{
        background-color: #80ffff;
        color:  #ffff00;
        
        }
        #rr{
        background-color: #003366;
        color:  #ffffff;
        }
        #qq{
        background-color: #cc0066;
        color:  #ffffff;
        }
        
        
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <div class="container">
                <a href="#" class="navbar-brand font-weight-bold">DIRECT PURCHASE</a>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbaraid" aria-controls="navbaraid" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbaraid">
                    <ul class="navbar-nav ml-lg-auto">
                        <li class="nav-item">
                            <button type="button" class="nav-link btn btn-info mr-2" id="saveas">Save As New</button>
                        </li>
                        <li class="nav-item">
                            <a href="showinvoice.php" class="nav-link btn btn-info mr-2">Search_RMTA</a>
                        </li>
                        <li class="nav-item">
                            <a href="../dashboard.php" class="nav-link btn btn-info mr-2">Back</a>
                        </li>
                        <li class="nav-item">
                            <a href="../logout.php" class="nav-link btn btn-info mr-2">LogOut</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </nav>

        <form action="inward_ind_to_db.php" method="post" id="sub_form">
            <div class="wrapper">
               

                <table align="center" class="ml-5 mb-3 mt-3" style="width:95%">
                    <tr>
                        <td style="width:30%">
                            <div class="field">
                                <select name="received_at" class="" tabindex="2" id="received_at" required>
                                    <option value=""></option>
                                    <option value="halol">halol</option>
                                    <option value="696_plant">696</option>
                                    <option value="baroda">Baroda</option>
                                </select>
                                <label>Receive_at</label>
                            </div>
                        </td>
                        <td style="width:35%">
                            <div class="field">
                                <input type="text" class="" name="party" tabindex="9" value="" id="party" required>
                                <label>Material Receive From Party</label>
                            </div>
                        </td>
                        <td style="width:25%">
                            <div class="field">
                                <input type="text" class="" name="sub_total" value="" id="sub_total" readonly>
                                <label>Bill Amount</label>
                            </div>
                        </td>

                        <td rowspan="3">
                            <div class="img_file">
                                <h5 class="img_head">Upload_Invoice</h5>
                                <!-- Trigger the modal with a button -->
                                <button type="button" class="btn btn-primary font-weight-bold font-italic" data-toggle="modal" data-target="#myModal">Click Here</button>
                            </div>
                        </td>
                       
                    </tr>
                    <tr>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="srno" value="" tabindex="1" id="srno" required>
                                <label>Rmta No.</label>
                            </div>
                            <div id="sr_error"></div>
                        </td>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="bill_from_party" tabindex="10" value="" id="bill_from_party" required>
                                <label>Bill Receive From Party</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <select name="freight_paid_by" tabindex="17" class="" id="freight_paid_by">
                                    <option value=""></option>
                                    <option value="sepl">SEPL</option>
                                </select>
                                <label>Freight_Piad_By</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="receive_date" tabindex="3" value="" id="receive_date" required>
                                <label>Receive Date</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="po_gen_by" value="" tabindex="11" id="po_gen_by" required>
                                <label>Material Order By</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="total_tax" value="" id="total_tax" readonly>
                                <label>Total Tax</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="field">
                                <input type="text" class="text-danger font-weight-bold" name="p_days" tabindex="4" value="" id="p_days" required>
                                <label>Payment Days</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="department" value="" tabindex="12" id="department">
                                <label>Department</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="discount" value="" id="discount" readonly>
                                <label>Discount</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="challan_no" tabindex="5" value="" id="challan_no">
                                <label>Challan No</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="remark" value="" tabindex="13" id="remark">
                                <label>Remark</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="freight_subsidy" tabindex="18" value="" id="freight_subsidy">
                                <label>Freight Subsidy</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="invoice_date" tabindex="6" value="" id="invoice_date" required>
                                <label>Invoice Date</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="mat_type" value="" tabindex="14" id="mat_type" required>
                                <label>Material Type</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="credit_note" tabindex="18" value="" id="credit_note">
                                <label>Credit Note</label>
                            </div>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="invoice_no" value="" tabindex="7" id="invoice_no" required>
                                <label>Invoice Number</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <select name="tc_receipt" class="" tabindex="15" id="tc_receipt">
                                    <option value=""></option>
                                    <option value="yes">YES</option>
                                </select>
                                <label>Tc_Receipt</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="freight_without_gst" tabindex="19" value="" id="freight_without_gst">
                                <label>Freight without GST</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="weight" value="" tabindex="8" id="weight">
                                <label>Weight (Way Bridge)</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <select name="tc_status" class="" tabindex="16" id="tc_status">
                                    <option value=""></option>
                                    <option value="completed">COMPLETED</option>
                                </select>
                                <label>Tc_Status</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="total_bill_amt" value="" id="total_bill_amt" readonly>
                                <label>Total Payable Amount</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="due_days" value="" id="due_days" readonly>
                                <label>Payment Due Date</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="total_qnty" value="" id="total_qnty" readonly>
                                <label>Total Qnty</label>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <input type="text" class="" name="diff_qnty" value="" id="diff_qnty" readonly>
                                <label>Diff. Qty</label>
                            </div>
                        </td>
                    </tr>
                   
                </table>
            </div>
            <table class="ml-5" align="center" style="width:95%">
                <tr>
                    <th class="text-center">Item_Description</th>
                    <th class="text-center">HSN_Code</th>
                    <th class="text-center">project</th>
                    <th class="text-center">Job</th>
                    <th class="text-center">Remark</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Main_grade</th>
                    <th class="text-center">Sub_Grade</th>
                    
                </tr>
                <tr>
                    <td style="width:25%"><input type="text" class="form-control" name="item_desc" id="item_desc"></td>
                    <td style="width:5%"><input type="text" class="form-control" name="hsn_code" id="hsn_code"></td>
                    <td style="width:10%"><input type="text" class="form-control" name="project" id="project"></td>
                    <td style="width:10%"><input type="text" class="form-control" name="job" id="job"></td>
                    <td style="width:10%"><input type="text" class="form-control" name="remark1" id="remark1"></td>
                    <td style="width:5%"><input type="text" class="form-control" name="stock" id="stock" readonly></td>
                    <td style="width:15%"><input type="text" class="form-control" name="m_grade" id="m_grade" readonly></td>
                    <td style="width:15%"><input type="text" class="form-control" name="s_grade" id="s_grade" readonly></td>
                    
                </tr>
            </table>
            <table class="ml-5 mt-2" align="center" style="width:45%">
                <tr>
                    <th class="text-center" id="srow">PKG</th>
                    <th class="text-center" id="srow">Calculation</th>
                    <th class="text-center" id="srow">Unit</th>
                    <th class="text-center" id="srow">Plant</th>
                </tr>
                <tr>
                    <td style="width:5%"><input type="number" step="0.1" tabindex="37" class="form-control bg-white" name="pkg" id="pkg" required></td>
                    <td style="width:10%">
                        <select name="calc" class="form-control" id="calc">
                            <option value="auto">Auto</option>
                            <option value="manual">Manual</option>
                        </select>
                    </td>
                    <td style="width:10%">
                        <select name="unit" class="form-control" tabindex="38" id="unit">
                            <option value="">select</option>
                            <?php
                            include('..\..\dbcon.php');
                            $sql="SELECT unit_name FROM unit ORDER BY unit_name";
                            $run=sqlsrv_query($con,$sql);
                            $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
                            ?>
                            <option value="<?php echo $row['unit_name'];  ?>"><?php echo $row['unit_name'];  ?></option>
                            <?php
                            while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
                            
                            ?>
                            <option value="<?php echo $row['unit_name'];  ?>"><?php echo $row['unit_name'];  ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td style="width:20%">
                        <select name="plant" class="form-control" tabindex="39" id="plant" required>
                            <option value="">Select</option>
                            <option value="1701">1701</option>
                            <option value="2205">2205</option>
                            <option value="696">696</option>
                            <option value="jarod">jarod</option>
                            <option value="baroda">baroda</option>
                        </select>
                    </td>
                </tr>
            </table>
            <table class="ml-5 mt-2 mb-1" align="center" style="width:95%">
                <tr>
                    <th class="text-center" id="trow">Qty</th>
                    <th class="text-center" id="trow">Rate</th>
                    <th class="text-center" id="trow">Disc(%)</th>
                    <th class="text-center" id="trow">Disc(amt)</th>
                    <th class="text-center" id="trow">Freight(+)</th>
                    <th class="text-center" id="trow">Packaging   (+)</th>
                    <th class="text-center" id="trow">Insurance  (+)</th>
                    <th class="text-center" id="trow">Other charge  (+)</th>
                    <th class="text-center" id="trow">Taxable amt</th>
                    <th class="text-center" id="trow">CGST(%)</th>
                    <th class="text-center" id="trow">CGST(amt)</th>
                    <th class="text-center" id="trow">SGST(%)</th>
                    <th class="text-center" id="trow">SGST(amt)</th>
                    <th class="text-center" id="trow">IGST(%)</th>
                    <th class="text-center" id="trow">IGST(amt)</th>
                    <th class="text-center" id="trow">TCS(%)</th>
                    <th class="text-center" id="trow">TCS(amt)</th>
                    <th class="text-center" id="trow">Total_tax_amt</th>
                    <th class="text-center" id="trow">Total Amt</th>
                    
                </tr>
                <tr>
                    <td style="width:6%"><input type="text" tabindex="40" class="form-control" name="qnty" id="qnty"></td>
                    <td style="width:6%"><input type="text" tabindex="41" class="form-control" name="rate" id="rate"></td>
                    <td style="width:3%"><input type="text" tabindex="42" class="form-control" name="disc_per" id="disc_per"></td>
                    <td style="width:4%"><input type="text" tabindex="43" class="form-control" name="disc_amt" id="disc_amt"></td>
                    <td style="width:4%"><input type="text" tabindex="44" class="form-control" name="freight" id="freight"></td>
                    <td style="width:4%"><input type="text" tabindex="45" class="form-control" name="packaging" id="packaging"></td>
                    <td style="width:4%"><input type="text" tabindex="46" class="form-control" name="insurance" id="insurance"></td>
                    <td style="width:4%"><input type="text" tabindex="47" class="form-control" name="other_charge" id="other_charge"></td>
                    <td><input type="text" class="form-control" name="tax_amt" id="tax_amt" readonly></td>
                    <td style="width:3%"><input type="text" tabindex="48" class="form-control" name="cgst_per" id="cgst_per"></td>
                    <td style="width:6%"><input type="text" class="form-control" name="cgst_amt" id="cgst_amt" readonly></td>
                    <td style="width:3%"><input type="text" class="form-control" name="sgst_per" id="sgst_per" readonly></td>
                    <td style="width:6%"><input type="text" class="form-control" name="sgst_amt" id="sgst_amt" readonly></td>
                    <td style="width:3%"><input type="text" tabindex="49" class="form-control" name="igst_per" id="igst_per"></td>
                    <td style="width:6%"><input type="text" class="form-control" name="igst_amt" id="igst_amt" readonly></td>
                    <td style="width:4%"><input type="text" tabindex="50" class="form-control" name="tcs_per" id="tcs_per"></td>
                    <td style="width:6%"><input type="text" tabindex="51" class="form-control" name="tcs_amt" id="tcs_amt"></td>
                    <td><input type="text" class="form-control" name="total_tax_amt" id="total_tax_amt" readonly></td>
                    <td><input type="text" class="form-control" name="total_amt" id="total_amt" readonly></td>
                    
                </tr>
            </table>
            <input type="submit" name="submit" tabindex="52" class="mb-1 ml-5 btn btn-dark w-25 font-weight-bold font-italic m-1" id="update" value="UPDATE">
            
        </form>
    </body>
</html>
