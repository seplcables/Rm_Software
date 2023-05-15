<?php
session_start();
include('..\..\dbcon.php');
if (isset($_GET['id'])) {
      $sid= $_GET['id'];
    }
    else{
      $sid= $_SESSION['add_item_po'];
    }
    $qrypur="SELECT count(*) as cnt from po_entry_details a
              INNER JOIN inward_ind b on a.id = b.iid
              where a.iid='$sid'";
    $runpur=sqlsrv_query($con,$qrypur);
    $rowpur=sqlsrv_fetch_array($runpur, SQLSRV_FETCH_ASSOC);


if ($rowpur['cnt'] > 0 && $_SESSION['oid'] != "Rajnish") {
      $_SESSION['utype'] = "आप PURCHASE ENTRY  के बाद PO-EDIT नहीं कर सकते हैं";
            header("location:..\dashboard.php");
}
else {
    $qry="SELECT *  FROM po_entry_head where id='$sid'";
    $run=sqlsrv_query($con,$qry);
    $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

    $pp = $row['party'];
    $qrya="SELECT *  FROM rm_party_master where pid='$pp'";
    $runa=sqlsrv_query($con,$qrya);
    $rowa=sqlsrv_fetch_array($runa, SQLSRV_FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>add_data</title>
   <!--  <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    jQuery UI 
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> -->
    

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


    <style type="text/css" media="screen">
    
    .d1 table th,tr,td {
     border: 1px solid black;
     padding: 3px;
    }
    .d1 th{
      background-color: #d4f3d4;
    }
    .d1 td{
      background-color: #f7f6ddd6;
    }
    #ttt{
      background-color: #000000;
      color: #ffff00;
      font-family: sans-serif;
      
    }
    #ttm{
      background-color: #ccccff;
      color: #003366;
      font-family: cursive;
    
    }
    ul {
      cursor: pointer;
      padding: unset;
      max-height: 250px;
      overflow: auto;
    }
    li {
      padding: 5px;
      background-color: #3399ff;
    }
    .dnd{
        background-color: #99ffd6;
        color: #0000b3;
        border: 0.5px solid black;
        font-size: 14px;
    }
    .add_data{
      border-radius: 35px;
    }
    #term{
      background-color: #ffffff;
    }
    .termheader {
      width: 99.3%;
      background-color: #F1F1F1;
      text-align: left;
      padding: 10px;
      border-radius: 7px;
    }
    .delheader {
      width: 99.3%;
      background-color: #F1F1F1;
      text-align: left;
      padding: 10px;
      border-radius: 7px;
    }
    #tbody input{
      border: none;
      box-shadow: none;
      outline: none;
      width: auto;
    }
    .d2{
      background-color: #F1F1F1;
      box-shadow:1px 5px 10px #8888887d;
      border-radius: 7px;
    }
    .row, .col-4 {
      margin: 4px 0px;
    }
    .table-bordered th{
      padding: 5px;
      background-color:#00bcd41f ;
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
    * html .ui-autocomplete {
      height: 100px;
    }
    .largerCheckbox
        {
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
          font-size: 16px;
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
          font-size: 16px;
        }
        #delivery_table input{
          border: none;
          box-shadow: none;
          outline: none;
        }
        #note input[type=text]{
           border: none;
          box-shadow: none;
          outline: none;
          width: 100%;
          padding-left: 5px;
          background-color:#f7f6ddd6;
        }
        #del_add input[type=text]{
           border: none;
          box-shadow: none;
          outline: none;
          width: 100%;
          padding-left: 5px;
          background-color:#f7f6ddd6;
        }
        /* .table-responsive{
            overflow-x:auto;
            overflow-y:auto;
            max-height:150px !important;
        }*/
        #id input, #id select{
          width: 50%;
        }
        #add_item input{
          width: 100%;
        }
        #add_item label{
          padding-top: 2px;
          font-size: 17px;
        }
        #table1{
          width: 99%;
          overflow-x: scroll;
        }
        #add_modal{
          background-color: #63ab9933;
        }
        .status,.type{
          border:0px !important;
          outline:0px !important;
        }
        span{
          color: red;
          font-size: 19px;
        }
    </style>
</head>
<body>
  <div class="d-flex p-2 bg-secondary">
       <h3 class="col-3 text-white">Purchase Order</h3>
       <div class="col-9">
         <a href="showdata-696.php" class="btn btn-light btn-md float-end mx-1">BACK</a>
         <input type="submit" name="save" class="btn btn-light float-end mx-1" id="save" value="SAVE DATA" form="setform"> 
         <input type="submit" name="add" class="btn btn-light float-end mx-1" id="add" value="ADD ITEM" data-bs-toggle="modal" data-bs-target="#add_modal" > 
       </div>
  </div><br>
    <div>
      <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-danger font-weight-bold font-italic">
        <?php echo $_SESSION['message']; ?>
      </div>
      <?php endif; ?>
      <?php unset($_SESSION['message']); ?>

      <form action="update_poentry-696.php" method="post" id="setform"> 
        <div class="row ml-4">
          <div class="col-lg-4 d2 p-3">
            <div class="row">
              <div class="col-4">
                <label>PO Date</label>
              </div>
              <div class="col-8">
                 <input type="text" class="form-control text-center" name="podate" id="podate" value="<?php echo $row['po_date']->format('d/M/Y'); ?>"> 
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>PO No.</label>
              </div>
              <div class="col-8">
                <input type="text" name="pono" class="form-control text-center" id="pono" value="<?php echo $row['po_no']; ?>" readonly>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>PO Generated By</label>
              </div>
              <div class="col-8">
                <input type="text" name="pogen" class="form-control text-center" value="<?php echo $row['po_gen_by']; ?>" id="pogen">
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>MaterialReq By</label>
              </div>
              <div class="col-8">
                <input type="text" name="matReqBy" class="form-control text-center" value="<?php echo $row['mat_req_by']; ?>" id="matReqBy" readonly>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>Party</label>
              </div>
              <div class="col-8">
                <input type="text" name="party" class="form-control text-center" value="<?php echo $rowa['party_name']; ?>" id="party" required>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>Material Required Date</label>
              </div>
              <div class="col-8">
                <input type="text" name="req_date" placeholder="Material Req Date" class="form-control text-center" value="<?php echo $row['mat_req_date']->format('d/M/Y'); ?>" id="req_date">
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>Payment Terms</label>
              </div>
              <div class="col-8 d-flex" id="id">
                <input type="number" name="p_days" placeholder="days" class="form-control text-center" id="p_days" value="<?php echo $row['p_days']; ?>" required>
                <select name="p_term" class="form-control align-middle text-center" id="p_term">
                  <option value="<?php echo $row['p_terms']; ?>"><?php echo $row['p_terms']; ?></option>
                  <option value="from_receive_date">From receive date</option>
                  <option value="from_invoice_date">From invoice date</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>Advance</label>
              </div>
              <div class="col-8 d-flex" id="id">
                <select class="form-control align-middle text-center" id="advance" name="advance">
                    <option value="<?php echo $row['adv_type']; ?>"><?php echo $row['adv_type']; ?></option>
                    <option selected class="bg-dark text-white font" value="No">No</option>
                    <option  class="bg-dark text-white font" value="Yes">Yes</option>
                </select>
                <input type="number" name="advance_amt" class="form-control text-center" id="advance_amt" value="<?php echo $row['adv_amt']; ?>">
              </div>
            </div>
            <input type="hidden" id="pcode" name="pcode">
            <input type="hidden" id="pid" name="pid" value="<?php echo $row['party']; ?>">
            <input type="hidden" name="srno" id="srno" value="<?php echo $sid; ?>">
          </div>

          <div class="col-lg-8">
            <div class="row">
              <!-- Add Terms & Condition -->
              <div class="ml-2 termheader">
                <div class="row d-flex">
                  <div class="col-10">
                    <h4 class="mb-1">Terms & Conditions</h4>
                    <input type="hidden" name="termsid" id="termsid">
                  </div>
                  <div class="col-2">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#note_modal" id="term_show" class="btn btn-info font-weight-bold float-end" style="width:100px;height:38px;">Add Note</button>
                  </div>
                </div>
                <div class="table-responsiv d1" id="d1">
                  <table style="width:100%; margin-top:10px;" border="1" align="center" id="termtbl">
                    <thead>
                      <th width="20%">Title</th>
                      <th width="78%">Descriptions</th>
                    </thead>
                    <tbody id="note">
                      <?php 
                          $sql11 = "SELECT * FROM po_terms where po_id='$sid'";
                          $run11 = sqlsrv_query($con,$sql11);
                          while($row11 = sqlsrv_fetch_array($run11, SQLSRV_FETCH_ASSOC))
                          {
                            ?>
                            <tr>
                              <td><input type="text" style="background-color:#f7f6ddd6;" name="title[]" value="<?php echo $row11['title']; ?>"></td>
                              <td><input type="text" style="background-color:#f7f6ddd6;" name="desc[]" value="<?php echo $row11['descriptions']; ?>"></td>
                            </tr>
                          <?php
                          }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="row">
              <!-- End Terms & Condition -->
              <!-- Start Delivery Address -->
              <div class="ml-2 mt-2 delheader">
                  <div class="row d-flex">
                    <div class="col-10">
                      <h4 class="mb-1">Delievery Address</h4>
                      <input type="hidden" name="delid" id="delid">
                    </div>
                    <div class="col-2">
                      <button type="button" id="adddel" class="btn btn-info font-weight-bold float-end" data-bs-toggle="modal" data-bs-target="#delivery_modal" >Add Location</button>
                    </div>
                  </div>
                  <div class="table-responsive d1" id="d1">
                    <table style="width:100%; margin-top:10px;" border="1" align="center" id="deltbl">
                      <thead>
                        
                        <th width="20%">Location</th>
                        <th width="78%">Location Address</th>
                      </thead>
                    <tbody id="del_add">
                      <?php 
                        $sql12 = "SELECT * FROM po_delivery where po_id='$sid'";
                        $run12 = sqlsrv_query($con,$sql12);
                        while($row12 = sqlsrv_fetch_array($run12, SQLSRV_FETCH_ASSOC))
                        {
                        ?>
                          <tr>
                            <td><input type="text" style="background-color:#f7f6ddd6;" name="loc[]" value="<?php echo $row12['location']; ?>"></td>
                            <td><input type="text" style="background-color:#f7f6ddd6;" name="addr[]" value="<?php echo $row12['location_address']; ?>"></td>  
                          </tr>
                          <?php
                              }
                           ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
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
                  <div id="note_div">
                    <table class="table-bordered" style="width:100%" id="notemodal_table">
                      <thead>
                        <tr class="bg-warning">
                          <th style="font-size: 15px;"><input type="checkbox" name="" class="largerCheckbox term" onclick="toggle(this);"></th>
                          <th style="font-size: 18px;"><b>Title</b></th>
                          <th style="font-size: 18px;"><b>Description</b></th>
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
                          <th style="font-size: 18px;"><b>Location</b></th>
                          <th style="font-size: 18px;"><b>Location Address</b></th>
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
                                    <td width="15%"><input type="text" class="location" value="<?php echo $row1['location']; ?>" readonly></td>
                                    <td width="80%"><textarea class="location_addr" readonly><?php echo $row1['location_address']; ?></textarea></td>
                                </tr>
                          <?php  } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="save" class="btn btn-primary btn-md px-4" id="send_delivery">ADD</button>
                </div>
              </div>
            </div>
          </div>
        <br>
        <div class="row" id="table1">
          <table class="table-bordered table-responsive m-1" style="width:99%">
            <thead>
              <tr>
                <th class="text-center">Item Description*</th>
                <th class="text-center">Qnty*</th>
                <th class="text-center">Unit*</th>
                <th class="text-center">Rate*</th>
                <th class="text-center">Basic_value</th>
                <th class="text-center">HSN</th>
                <th class="text-center">Project</th>
                <th class="text-center">Job</th>
                <th class="text-center">Remark</th>
                <th class="text-center">Use BY</th>
                <th class="text-center">M/C NO.</th>
                <th class="text-center">Persone Name</th>
                <th class="text-center">Department</th>
                <th class="text-center">Plant</th>
                <th class="text-center">Type</th>
                <th class="text-center">Old Status</th>
              </tr>

            </thead>
            <tbody id="tbody">
               <?php
                     $qry3="SELECT * from po_entry_details where iid='$sid'";
                     $run3=sqlsrv_query($con,$qry3);
                     $count = 0;
                      while ($row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC)) {
                      $icode = $row3['item_code'];
                      $qry4="SELECT * from rm_item where i_code='$icode'";
                     $run4=sqlsrv_query($con,$qry4);
                      $row4 = sqlsrv_fetch_array($run4, SQLSRV_FETCH_ASSOC);
                 ?>
              <tr>
                <td>
                  <input type="text" name="item_desc[]" class="item_desc" value="<?php echo $row4['item']; ?>"><input type="hidden" name="i_code[]" class="i_code" value="<?php echo $row3['item_code']; ?>"><input type="hidden" name="s_code[]" class="s_code" value="<?php echo $row3['sub_grade']; ?>"><input type="hidden" name="m_code[]" class="m_code" value="<?php echo $row3['main_grade']; ?>"><input type="hidden" name="c_code[]" class="c_code" value="<?php echo $row3['category']; ?>"><input type="hidden" name="iid[]" value="<?php echo $row3['id']; ?>"></td>
                <td><input type="text" name="qnty[]" class=" qnty" value="<?php echo $row3['qnty']; ?>"></td>
                <td><!-- <input type="text" name="unit[]" value=""> -->
                    <select class="form-control form-control-sm font" name="unit[]" style="width:160px">
                      <option value="<?php echo $row3['unit'];  ?>" class="bg-dark"><?php echo $row3['unit'];?></option>
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
                <td><input type="text" name="rate[]" class="rate" value="<?php echo $row3['rate'];  ?>"></td>
                <td><input type="text" name="basic_rate[]" class="basic_rate" value="<?php echo $row3['basic_rate'];  ?>"></td>
                <td><input type="text" name="hsn_code[]" value="<?php echo $row3['hsn_code'];  ?>"></td>
                <td><input type="text" name="project[]" value="<?php echo $row3['project'];  ?>"></td>
                <td><input type="text" name="job[]" value="<?php echo $row3['job'];  ?>"></td>
                <td><input type="text" name="remark[]" value="<?php echo $row3['remark'];  ?>"></td>
                <td><input type="text" name="useby[]" class="useby" value="<?php echo $row3['matUsedBy'];  ?>"></td>
                <td><input type="text" name="mcno[]" class="mcno" value="<?php echo $row3['mcno'];  ?>"></td>
                <td><input type="text" name="person[]" class="person" value="<?php echo $row3['superviser'];?>"></td>
                <td><input type="text" name="dpnt[]" class="dpnt" value="<?php echo $row3['department'];  ?>"></td>
                <td><input type="text" name="plant[]" class="plant" value="<?php echo $row3['plant'];  ?>"></td>

                <td>
                    <select class="type" aria-label="Default select example" name="type[]">
                        <option value="<?php echo $row3['type']; ?>"><?php echo $row3['type']; ?></option>
                        <option  class="bg-dark text-white" value="New">New</option>
                        <option  class="bg-dark text-white" value="Replace">Replace</option>
                    </select>
                </td>

                <td>
                    <select name="status[]"   style="width:120px" class="status">
                      <option value="<?php echo $row3['old_status']; ?>"><?php echo $row3['old_status']; ?></option>
                      <option  class="bg-dark text-white hideit" value="Repair">Repair</option>
                      <option  class="bg-dark text-white hideit" value="Stock">Stock</option>
                      <option  class="bg-dark text-white hideit" value="Scrap">Scrap</option>
                    </select>
                </td>
              </tr>
              <?php  $count++; } ?>
            </tbody>
          </table>
        </div>
      </form>
    </div>

      <!-----------------------------------------  ADD Item Modal ----------------------------------------->
        <div class="modal fade small" id="add_modal" aria-labelledby="add_modal" aria-hidden="true" tabindex="-1">
            
        <!----------------- Scrollable modal --------------------------->
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header font-weight-bold">
                    <h4>ADD ITEM</h4>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="add_modal">
                  <div id="add_item">
                    <form action="addItemToPo_to_db-696.php" method="POST" id="form">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="row">
                            <div class="col-lg-4"><label>Item Description<span>*</span></label></div>
                            <div class="col-lg-8"><input type="text" name="item_desc" class="form-control" id="item_desc" required><input type="hidden" name="i_code" id="i_code"><input type="hidden" name="s_code" id="s_code"><input type="hidden" name="m_code" id="m_code"><input type="hidden" name="c_code" id="c_code"><input type="hidden" name="poid" value="<?php echo $sid; ?>" id="poid"></div>
                             
                          </div>
                          <div class="row">
                            <div class="col-lg-4"><label>Qnty<span>*</span></label></div>
                            <div class="col-lg-8"><input type="text" name="qnty" class="form-control" id="qnty" required></div>
                          </div>
                          <div class="row">
                            <div class="col-lg-4"><label>Unit<span>*</span></label></div>
                            <div class="col-lg-8"><input type="text" name="unit" class="form-control" required></div>
                          </div>
                          <div class="row">
                            <div class="col-lg-4"><label>Rate<span>*</span></label></div>
                            <div class="col-lg-8"><input type="text" name="rate" class="form-control" id="rate" required></div>
                          </div>
                          <div class="row">
                            <div class="col-lg-4"><label>Basic value</label></div>
                            <div class="col-lg-8"><input type="text" name="basic_rate" class="form-control" id="basic_rate" readonly></div>
                          </div>
                          <div class="row">
                            <div class="col-lg-4"><label>HSN</label></div>
                            <div class="col-lg-8"><input type="text" name="hsn_code" class="form-control" id="hsn_code"></div>
                          </div>
                          <div class="row">
                            <div class="col-lg-4"><label>Project</label></div>
                            <div class="col-lg-8"><input type="text" name="project" class="form-control" id="project"></div>
                          </div>
                          <div class="row">
                             <div class="col-lg-4"><label>Job</label></div>
                              <div class="col-lg-8"><input type="text" name="job" class="form-control" id="job"></div>
                          </div>
                          <div class="row"></div>
                        </div>

                        <div class="col-lg-6">
                          <div class="row">
                            <div class="col-lg-4"><label>Remark</label></div>
                            <div class="col-lg-8"><input type="text" name="remark" class="form-control" id="remark"></div>
                          </div>
                          <div class="row">
                            <div class="col-lg-4"><label>Use BY</label></div>
                            <div class="col-lg-8"><input type="text" name="useby" class="form-control" id="useby"></div>
                          </div>
                          <div class="row">
                            <div class="col-lg-4"><label>M/C NO.</label></div>
                            <div class="col-lg-8"><input type="text" name="mcno" class="form-control" id="mcno"></div>
                          </div>
                          <div class="row">
                            <div class="col-lg-4"><label>Persone Name</label></div>
                            <div class="col-lg-8"><input type="text" name="person" class="form-control" id="person"></div>
                          </div>
                          <div class="row">
                             <div class="col-lg-4"><label>Department</label></div>
                              <div class="col-lg-8"><input type="text" name="dpnt" class="form-control" id="dpnt"></div>
                          </div>
                           <div class="row">
                            <div class="col-lg-4"><label>Plant</label></div>
                            <div class="col-lg-8"><input type="text" name="plant" class="form-control" id="plant"></div>
                          </div>
                          <div class="row">
                            <div class="col-lg-4"><label>Type</label></div>
                            <div class="col-lg-8" id="sel">
                                <select class="form-control" name="type" id="type">
                                    <option disabled="" selected class="bg-primary text-white">-- Select --</option>
                                    <option  class="bg-dark text-white" value="New">New</option>
                                    <option  class="bg-dark text-white" value="Replace">Replace</option>
                                </select>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-4"><label>Old Status</label></div>
                            <div class="col-lg-8" id="sel">
                              <select name="status" class="form-control" id="status">
                                <option disabled="" selected class="bg-primary text-white">-- Select --</option>
                                <option  class="bg-dark text-white hideit" value="Repair">Repair</option>
                                <option  class="bg-dark text-white hideit" value="Stock">Stock</option>
                                <option  class="bg-dark text-white hideit" value="Scrap">Scrap</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>  
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn btn-primary btn-md px-4" form="form">ADD</button>
                </div>
              </div>
            </div>
          </div>
      

  <script type="text/javascript">
  $( function() {
  // party autocomplete box
  $( "#party" ).autocomplete({
    source: function( request, response ) {
    // Fetch data
      $.ajax({
        url: "fetch2.php",
        type: 'post',
        dataType: "json",
        data: {
        party: request.term
      },
      success: function( data ) {
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
              var pono = $('#srno').val();
              var date = new Date(podate);
              var mm = date.toLocaleString("default", { month: "short" });
              var yy = date.getFullYear();
              var po = yy+"/"+mm+"/"+pcode+"/"+pono;
              $('#pono').val(po);
          }
        }
  });

  // pogen autocomplete box
  $( "#pogen" ).autocomplete({
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
  // Set selection
  $('#pogen').val(ui.item.label);
  $('#dpnt').val(ui.item.dpnt); // display the selected text
  return false;
  }
  });
  // description autocomplete box
  $( ".item_desc" ).autocomplete({
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
  $(this).closest('tr').find('.item_desc').val(ui.item.label);
  $(this).closest('tr').find('.i_code').val(ui.item.i_code);
  $(this).closest('tr').find('.s_code').val(ui.item.s_code);
  $(this).closest('tr').find('.m_code').val(ui.item.m_code);
  $(this).closest('tr').find('.c_code').val(ui.item.c_code);
  return false;
  },
  change: function (event, ui)  //if not selected from Suggestion
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

  });

  });

  $(document).ready(function(){
  // for Update Item
          $('.save_data').click(function(event) {
            var item_desc=$("#item_desc").val();
            if (item_desc == '') {
              alert('pls add Item First');
            }
            else{
              $.ajax({
                type: "POST",
                url: "update_po_to_db.php",
                data:$('#setform').serialize(),
                success: function (msg) {

                   alert(msg);
                }
            });
            }


        });
/// end Update Item
  /*$('#rate,#qnty').change(function(){*/
    $(document).on('change','.rate,.qnty',function(){
    var rate = $(this).closest('tr').find(".qnty").val();
    var qnty = $(this).closest('tr').find(".rate").val();
    var a = rate*qnty;
    $(this).closest('tr').find(".basic_rate").val((a).toFixed(2));
    });
    //End Add part Coding

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
    $("#termtbl td").remove();
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
            rowHTML += '<td><input type="text" name="title[]" value="'+title[i]+'" style=" font-size:14px;" readonly></td>';
            rowHTML += '<td><input type="text" name="desc[]" value="'+desc[i]+'" style=" font-size:14px;" readonly></td>';
            rowHTML += '</tr>';
           
            $('#termtbl').find('tbody').append(rowHTML);
            rowHTML = '';
            }
          $('#note_modal').modal('hide'); 
    
    } 
});

/*Load delivery modal data*/
$('#send_delivery').click(function(){
   //alert('modal close');
    $("#deltbl td").remove();
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
            rowHTML += '<td><input type="text" name="loc[]" value="'+title1[i]+'" style=" font-size:14px" readonly></td>';
            rowHTML += '<td><input type="text" name="addr[]" value="'+desc1[i]+'" style=" font-size:14px" readonly></td>';
            rowHTML += '</tr>';
           
            $('#deltbl').find('tbody').append(rowHTML);
            rowHTML = '';
            }
          $('#delivery_modal').modal('hide'); 
    
    }
});

  /*------autocomplete textbox-----*/
  $( function() {
 // mc autocomplete box
      $( ".mcno" ).autocomplete({
      source: function( request, response ) {
       // Fetch data
      $.ajax({
        url: "store/getmc-696.php",
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
     $(this).closest('tr').find('.mcno').val(ui.item.label);
     $(this).closest('tr').find('.person').val(ui.item.pname1);
     $(this).closest('tr').find('.dpnt').val(ui.item.dname);
     $(this).closest('tr').find('.plant').val(ui.item.pname2);
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

// person autocomplete box
 $( ".person" ).autocomplete({
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
     $(this).closest('tr').find('.person').val(ui.item.label);
     $(this).closest('tr').find('.dpnt').val(ui.item.dname);
     $(this).closest('tr').find('.plant').val(ui.item.pname);
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

// department autocomplete box
 $( ".dpnt" ).autocomplete({
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
   $(this).closest('tr').find('.dpnt').val(ui.item.label);
   $(this).closest('tr').find('.plant').val(ui.item.pname);
   
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
  $(document).on('change','.type',function(){
    var a = $(this).val();
    if (a == 'Replace') {
      $(this).closest('tr').find(".hideit").show();
    }
    else {
      $(this).closest('tr').find(".hideit").hide();
    }
});

  // pogen autocomplete box
  $( ".useby" ).autocomplete({
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
      // Set selection
      $(this).closest('tr').find('.useby').val(ui.item.label);
      return false;
    }
  });
      
   /*---------------------------------------------ADD Item Model Query--------------------------------*/
  // description autocomplete box
  $( "#item_desc" ).autocomplete({
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
  $('#item_desc').val(ui.item.label);
  $('#i_code').val(ui.item.i_code);
  $('#s_code').val(ui.item.s_code);
  $('#m_code').val(ui.item.m_code);
  $('#c_code').val(ui.item.c_code);
  return false;
  },
  change: function (event, ui)  //if not selected from Suggestion
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
  });

$('#rate,#qnty').change(function(){
    var rate = $("#qnty").val();
    var qnty = $("#rate").val();
    var a = rate*qnty;
    $("#basic_rate").val((a).toFixed(2));
    });

   /*------autocomplete textbox-----*/
  $( function() {
 // mc autocomplete box
      $( "#mcno" ).autocomplete({
      source: function( request, response ) {
       // Fetch data
      $.ajax({
        url: "store/getmc-696.php",
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
     $('#mcno').val(ui.item.label);
     $('#person').val(ui.item.pname1);
     $('#dpnt').val(ui.item.dname);
     $('#plant').val(ui.item.pname2);
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
     $('#plant').val(ui.item.pname);
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
   $('#plant').val(ui.item.pname);
   
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

  // pogen autocomplete box
  $( "#useby" ).autocomplete({
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
      // Set selection
      $('#useby').val(ui.item.label);
      return false;
    }
  });

  /*--for hide and show of old part status--*/
  $(document).on('change','#type',function(){
    var a = $(this).val();
    if (a == 'Replace') {
      $(".hideit").show();
    }
    else {
      $(".hideit").hide();
    }
});

  $(document).on('click','#save',function()
  {
    if(!confirm('Are You Sure ??'))
    {
      return false;
    }
  });
    </script>    
</body>
</html>
  <?php
  }
  ?>