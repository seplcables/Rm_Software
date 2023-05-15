<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Search_Requisition</title>
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
        
        
        <!----------------------------------- jQuery UI ---------------------------->
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="requisitionJqry.js"></script>
        <link rel="stylesheet" href="requisitionStyle.css">
        <style type="text/css">
        
        </style>
        
    </head>
    <body class="container-fluid" >
        <h4 class="bg-warning" align="center">REQUISITION - 696 Plant</h4>
        
        <div class="card mt-3">
            <div class="card-header bg-primary">
                <a href="..\..\dashboard.php" class="btn float-end btn-danger bg-gradient  btn-sm">Back</a>
                <button type="button" class="btn  bg-gradient btn-warning btn-sm"  data-bs-toggle="modal" data-bs-target="#create"><i class="fa fa-plus float-sm"></i> Create New</button>
            </div>
            <div class="card-body">
                <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-success msg_show">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['message']); ?>
                <div class="table-responsive mt-1">                    
                    <table class="table table-bordered table-striped font" id="example" style="width:100%;">
                        <thead>
                            <tr id="trow">
                                <th>mrsNo</th>
                                <th>Date</th>
                                <th>Indentor</th>
                                <th>Department</th>
                                <th>Req_Date</th>
                                <th>Approver</th>
                                <th>Parties</th>
                                <th>Control</th>
                            </tr>
                        </thead>                        
                    </table>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        // Function of Control Button
        function getOptions(data, type, full) 
        {
        if (data.ma == 1) {
        var x = "btn-success";
        var y = "#";
        var z = "not_editable()";
        var aa = "not_editable";
        }
        else{
        var x = "btn-danger";
        var y = "Requisition_edit.php?id=" + data.head.id;
        var z = "btn-success";
        var aa = "";
        }
        if (data.rate == 'yes') {
        var a = "btn-success";
        }
        else{
        var a = "btn-danger";
        }
        if (data.ra == 1) {
        var b = "btn-success";
        var c = "";
        var d = "";
        var e = "raNot_editable()";
        }
        else{
        var b = "btn-danger";
        var c = "compare";
        var d = "rate_approve";
        var e = "";
        }
        var optionLink ='<div style="width:300px">';
            optionLink +=  "<a class=\"btn btn-sm "+aa+" border-0 "+z+" mrgn\" onclick="+z+" href="+y+">Edit</a>" ;
            optionLink += "<a class=\"btn btn-sm btn-success border-0\" href=\"pdfDataOfRequisition.php?sid=" + data.head.id + "\">maPdf</a> " ;
            optionLink +=  "<button type=\"button\" data-bs-toggle=\"tooltip\" title=\"Material Approve\" class=\"btn btn-sm border-0 "+x+" mrgn app\" id=" + data.head.id + ">MA</button>" ;
            optionLink +=  "<button type=\"button\" data-bs-toggle=\"tooltip\" title=\"Add Rate From Party\" class=\"btn btn-sm "+a+" border-0 mrgn "+c+"\" id=" + data.head.id + " onclick="+e+">AddRate</button>" ;
            optionLink +=  "<button type=\"button\" data-bs-toggle=\"tooltip\" title=\"Rate Approve\" class=\"btn btn-sm "+b+" border-0 mrgn "+d+"\" id=" + data.head.id + " onclick="+e+">RA</button>";
            optionLink += "<a class=\"btn btn-sm btn-success border-0\" href=\"rateapprovePDF.php?sid=" + data.head.id + "\">raPdf</a></div>";
            return optionLink == 0 ? '' : optionLink;
            
            }
            function getParty(data, type, full) 
            {
                optionLink =  "<span class=\"tooltip_text\" id=" + data.head.id + ">"+data.partyList.substring(0,50)+"<span class=\"text_hide\">"+data.partyList.substring(51,data.partyList.length)+"</span></span>";
                return optionLink == 0 ? '' : optionLink;
            }
            
            $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#example thead th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" class="text-center" placeholder="'+title+'" />' );
            });
            var table = $('#example').DataTable({
            "createdRow": function ( row, data, index ) {
            
            $('td', row).addClass('hlight');
            
            },
            "processing": true,
            "ordering": false,
            "dom": 'Bfrtip',
            
            "columns": 
            [
            { data: "head.id", width: "4%" },
            {
            data: "head.createdAt.date", width: "8%",
            type: "date",
            render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
            },
            { data: "head.indentor", width: "8%" },
            { data: "head.indentor_dpnt", width: "14%" },
            {
            data: "head.mat_require_dte.date", width: "8%",
            type: "date",
            render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
            },
            { data: "head.matApprove", width: "8%" },
            {   "mData": null, width: "20%",
            "bSortable": false,
            "mRender":  function(data, type, full) {
            return getParty(data, type, full);
            }
            },
            {   "mData": null, width: "20%",
            "bSortable": false,
            "mRender":  function(data, type, full) {
            return getOptions(data, type, full);
            }
            }
            ],
            "ajax": {
            url: 'serch_Requisition.php',
            "dataSrc" : ""
            },
            
            lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
            buttons: [
            'pageLength', 'excel', 'print'
            ],
            
            initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
            var that = this;
            
            $( 'input', this.header() ).on( 'keyup change clear', function () {
            if ( that.search() !== this.value ) {
            that
            .search( this.value )
            .draw();
            }
            } );
            } );
            }
            
            });
            });
            function notEditable()
            {
            alert("आप PURCHASE ENTRY  के बाद PO-EDIT नहीं कर सकते हैं");
            }
            </script>
            <!--------------------------------------------------Compare Modal ------------------------------>
            <div class="modal fade" id="compare" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen modal-dialog-scrollable ">
                    <div class="modal-content">
                        <div class="modal-header small bg-dark bg-gradient text-white">
                            <h5>Add Item-wise Rate</h5>
                            
                            <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="compare_data">
                            <!------- Dynamic Table from ajax load from database  ------->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary text-white font-weight-bold" data-bs-dismiss="modal">Close</button>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-----------------------------------------   Second Modal ----------------------------------------->
            <div class="modal fade small" id="Add_data" aria-labelledby="Add_data" aria-hidden="true" tabindex="-1">
                
                <!----------------- Scrollable modal --------------------------->
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn btn-sm btn-primary btn-outline-danger text-white border-0" id="rate_button">Add Row For New Rate</button>
                            
                            
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="party_form">
                            <input type="hidden" name="rateId" id="rateId">
                            <div class="modal-body" id="rate_modal">>
                                <!-- Load from jquery -->
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" name="save" class="btn btn-primary" id="partyRateBtn">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------------------------------------------Create New ------------------------------------------>
            <div class="modal fade" id="create" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen modal-dialog-scrollable ">
                    <div class="modal-content">
                        <div class="modal-header text-center bg-dark bg-gradient text-white">
                            
                            
                            <h3 class="h4 text-center">REQUISITION SLIP</h3>
                            
                            <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="compare_data">
                            <div class="container-fluid">
                                <form action="Requisition_slip_db.php" method="POST" id="submit_form">
                                    <div class="card bg-faded mt-3">
                                                                            
                                        <div class="card-body">                                           
                                            
                                            <div class="row justify-content-center">
                                                <div class="col-lg-3 col-md-3 col-sm-3 mt-3">
                                                    <div class="form-floating mb-3">
                                                        <input type="date" class="form-control" id="floatingInput" name="req_date" placeholder="Date" required>
                                                        <label for="floatingInput">requiredDate</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 mt-3">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control indentor" value="<?php echo $_SESSION['oid']; ?>" name="indentor" id="floatingInput" onFocus="SearchIndentor(this)" required>
                                                        <input type="hidden" name="dpnt" class="dpnt" value="<?php echo $_SESSION['dpnt']; ?>">
                                                        <label for="floatingInput">preparedBy</label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-2 col-sm-2 mt-3">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control indentor" name="matApprove" id="floatingInput" onFocus="SearchIndentor(this)">
                                                        <label for="floatingInput">approveddBy</label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-3 col-sm-3 mt-3">
                                                    <div class="form-floating mb-3">
                                                        <textarea class="form-control" placeholder="Remark" name="remark" id="floatingTextarea"></textarea>
                                                        <label for="floatingTextarea">Remark</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 col-md-1 col-sm-1 mt-3">
                                                    <input type="button" id="newbtn" name="newbtn" class="float-end bg-danger text-white btn btn-sm mt-3" value="ADD" style="margin-right: 5px;">
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="table-responsive">
                                                    <table  align="center" class="hover" id="receive" style="text-align: center;width: 100%;">
                                                        
                                                        <thead>
                                                            <tr>
                                                                <th>SR.</th>
                                                                <th>Item Description</th>
                                                                <th>Qnty</th>
                                                                <th>Unit</th>
                                                                <th>Approx Cost</th>
                                                                <th>M\C No.</th>
                                                                <th>Department</th>
                                                                <th>Plant</th>
                                                                <th>Category</th>
                                                                <th>State</th>
                                                                <th>Type</th>
                                                                <th class="">Old_Part_Status</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody class="td" id="t_body">
                                                            <tr>
                                                                <td class="td" id="sr">1</td>
                                                                <td class="td" style="width: 0%;"><input type="text" name="item_desc[]" onFocus="SearchItem(this)" class="form-control item" style="width:400px"  id="1Des" required><input type="hidden" name="i_code[]" class="i_code"></td>
                                                                <td class="td" style="width: 0%;"><input type="number" step="0.01" name="Qnty[]" class="form-control " style="width:100px" id="Qnt" required></td>
                                                                <td class="td" style="width: 0%;">
                                                                    <select class="form-control td" name="unit[]" id="unit" style="width:120px">
                                                                        <option disabled="true" selected="true" value="" class="bg-dark">--unit--</option>
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
                                                                    </select>
                                                                </td>
                                                                <td class="td" style="width: 0%;"><input type="number" step="0.01" name="apx_cost[]" class="form-control " style="width:150px" id="apx_cost"></td>
                                                                <td class="td" style="width: 0%;"><input type="text" name="mc[]" onFocus="SearchMc(this)" class="form-control mcno " style="width:150px" id="mc"></td>
                                                                <td class="td" style="width: 0%;"><input type="text" name="dept[]" onFocus="SearchDpnt(this)" class="form-control dept "  id="dept" style="width:160px" required></td>
                                                                <td class="td" style="width: 0%;"><input type="text" name="plant[]" class="form-control plant " style="width:100px" id="plant" value="696" readonly></td>
                                                                <td class="td" style="width: 0%;">
                                                                    <input type="text" name="category[]" class="form-control category " style="width:150px" id="category" readonly>
                                                                </td>
                                                                <td class="td" style="width: 0%;">
                                                                    <select class="form-select " style="width:200px" aria-label="Default select example" id="state" name="state[]" >
                                                                        <option disabled="" selected class="bg-primary text-white">-- Select --</option>
                                                                        <option class="bg-dark text-white">Capital</option>
                                                                        <option class="bg-dark text-white">Consumable</option>
                                                                        <option class="bg-dark text-white">Raw Material</option>
                                                                    </select>
                                                                </td>
                                                                <td class="td" style="width: 0%;">
                                                                    <select class="form-select type "  style="width:150px" aria-label="Default select example" id="type" name="status[]"  required>
                                                                        <option disabled="" selected class="bg-primary text-white">-- Select --</option>
                                                                        <option  class="bg-dark text-white">New</option>
                                                                        <option  class="bg-dark text-white">Replace</option>
                                                                        
                                                                    </select>
                                                                </td>
                                                                <td class="td" style="width: 0%;" class=""> <!-- Hide for extra place put here -->
                                                                <select class="form-select disabled select_hide"  style="width:150px" aria-label="Default select example" id="old_part" name="old_part[]" >
                                                                    <option  selected class="bg-primary text-white" value="">-- Select --</option>
                                                                    <option  class="bg-dark text-white hideit">Repair</option>
                                                                    <option  class="bg-dark text-white hideit">Stock</option>
                                                                    <option  class="bg-dark text-white hideit">Scrap</option>
                                                                </select>
                                                                
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="save" class="btn btn-primary" form="submit_form">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!--------------------------------------------- Approval Modal --------------------------------------->
        <div class="modal fade" id="app" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen modal-dialog-scrollable ">
                <div class="modal-content">
                    <div class="modal-header small bg-primary bg-gradient text-white">
                        <h5 class="text-uppercase">Item Approval</h5>
                        
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="approve_data">
                        <!------- Dynamic Table from ajax load from database  ------->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white btn-sm font-weight-bold" data-bs-dismiss="modal">Close</button>
                        <button type="button" name="save" class="btn btn-primary btn-sm" id="save_approve">Approve</button>
                        <button type="button" name="save" class="btn btn-danger btn-sm" id="maReject">Reject</button>
                        
                    </div>
                </div>
            </div>
        </div>
        <!--------------------------------------------- Rate Approval Modal --------------------------------------->
        <div class="modal fade" id="rate_approve" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen modal-dialog-scrollable ">
                <div class="modal-content">
                    <div class="modal-header small bg-secondary text-white">
                        <h5 class="text-uppercase">Rate Approval</h5>
                        
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="rateApprove_form">
                        <div class="modal-body" id="rateApprove_data">
                            <!------- Dynamic Table from ajax load from database  ------->
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white btn-sm font-weight-bold" data-bs-dismiss="modal">Close</button>
                        <button type="button" name="save" class="btn btn-primary btn-sm" id="lowRateApprove">Approve</button>
                        
                        
                    </div>
                </div>
            </div>
        </div>
        <!--------------------------------------------- Rate History Modal --------------------------------------->
        <div class="modal fade bd-example-modal-lg" id="rate_diff" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold">LAST 10 ITEM RATE HISTORY</h4>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="order_table">
                        <!-- Dynamic Table from ajax load -->
                    </div>
                    
                </div>
            </div>
        </div>
        <!--  Party List Modal  -->
        <div class="modal fade small" id="partyList_data" aria-labelledby="Add_data" aria-hidden="true" tabindex="-1">
            <!----------------- Scrollable modal --------------------------->
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> -->
                    <div class="modal-body" id="partyList_modal">
                        <!-- Load from jquery -->
                    </div>
                </div>
            </div>
        </div>
        
        <!--------------------------------------------- End Modal --------------------------------------->
    </div>
</div>
</body>
</html>
<script type="text/javascript">
// Ready function
$(document).ready(function(){
$(".hideit").hide();
// Add rate save Ajax
$('#partyRateBtn').click(function(event) {
var x = $(".party_name").val();
var y = $(".partyRate").val();
if (x == '' || y == '') {
alert("PARTY AND RATE REQUIRED **")
} else{
$.ajax({
type: "POST",
url: "partyRate_db.php",
data:$('#party_form').serialize(),
success: function (msg) {
$("#Add_data").modal("hide");
alert(msg);
},
complete:function()
{
//location.reload(true);
}
});
}
});
// Rate Approve Ajax
$('#lowRateApprove').click(function(event) {
$.ajax({
type: "POST",
url: "rateApprove_db.php",
data:$('#rateApprove_form').serialize(),
success: function (msg) {
$("#rate_approve").modal("hide");
alert(msg);
},
complete:function()
{
//location.reload(true);
}
});
});
});
// add button coding
var abc = 1;
$("#newbtn").click(function(){
var xyz = $('#'+abc+'Des').val();
if (xyz == '') {
alert('Please fill Current Information (कृपया पहले जानकारी भरें)');
}
else
{
abc++;
var rowHtml = '<tr>';
rowHtml += '<td class="td" name="sr" id="sr">'+abc+'</td>';
rowHtml += '<td class="td"><input type="text" name="item_desc[]" class="form-control item" onFocus="SearchItem(this)"  id="'+abc+'Des" required><input type="hidden" name="i_code[]" class="i_code"></td>';
rowHtml += '<td class="td"><input type="number" step="0.01" name="Qnty[]" class="form-control"  id="'+abc+'Qnt" required></td>';
rowHtml += '<td><select class="form-control td" name="unit[]" id="unit" style="width:100px"><option disabled="true" selected="true" value="" class="bg-dark">--unit--</option><option>Box</option><option>Mtr</option><option>cylnr</option><option>Feet</option><option>Gram</option><option>Kg</option><option>Liter</option><option>Nos</option><option>Pair</option><option>Pkt</option><option>Roll</option><option>Set</option><option>Sq.Ft</option><option>Sqmm</option><option>Ton</option><option>Uom</option><option>Bag</option><option>Book</option><option>R.ft</option><option>Sq.Mtr</option></select></td>';
rowHtml += '<td class="td"><input type="number" step="0.01" name="apx_cost[]" class="form-control"  id="'+abc+'apx_cost"></td>';
rowHtml +='<td class="td"><input type="text" onFocus="SearchMc(this)" name="mc[]" class="form-control mcno"  id="'+abc+'mc"></td>';
rowHtml += '<td class="td"><input type="text" name="dept[]" onFocus="SearchDpnt(this)" class="form-control dept"  id="'+abc+'dept" required></td>';
rowHtml += '<td class="td"><input type="text" name="plant[]" class="form-control plant"  id="'+abc+'plant" readonly></td>';
rowHtml += '<td class="td"><input type="text" name="category[]" class="form-control category"  id="'+abc+'category" readonly></td>';
rowHtml += '<td class="td"><select class="form-select" aria-label="Default select example" id="'+abc+'state" name="state[]" ><option disabled="" selected class="bg-primary text-white">-- Select --</option><option class="bg-dark text-white">Capital</option><option class="bg-dark text-white">Consumable</option><option class="bg-dark text-white">Raw Material</option></select></td>';
rowHtml += '<td class="td"><select class="form-select type" aria-label="Default select example" id="type" name="status[]"  required><option disabled="" selected class="bg-primary text-white">-- Select --</option><option  class="bg-dark text-white">New</option><option  class="bg-dark text-white">Replace</option></select></td>';
rowHtml += '<td class="td"><select class="form-select disabled select_hide"  style="width:150px" aria-label="Default select example" id="'+abc+'old_part" name="old_part[]" ><option  selected class="bg-primary text-white" value="">-- Select --</option><option  class="bg-dark text-white hideit">Repair</option><option  class="bg-dark text-white hideit">Stock</option><option  class="bg-dark text-white hideit">Scrap</option></select></td>';
rowHtml += '</tr>';
$('#t_body').append(rowHtml);
$(".hideit").hide();
}
});
// Add Rate Button
var def = 1;
$("#rate_button").click(function(){
var xyz = $('#'+def+'party_name').val();
if (xyz == "") {
alert('Please fill Current Information (कृपया पहले जानकारी भरें)');
}
else
{
def++;
var rowHtml = '';
rowHtml += '<div class="row justify-content-center p-2 xxxx">';
rowHtml += '<div class="col-lg-8 col-md-8 col-sm-12 ">';
rowHtml += '<input type="text" name="party_name" id="'+def+'party_name" onFocus="SearchParty(this)" placeholder="Enter Here" class="form-control party_name">';
rowHtml += '<input type="hidden" name="pid[]" id="pid" class="pid">';
rowHtml += '</div>';
rowHtml += '<div class="col-lg-4 col-md-4 col-sm-12">';
rowHtml += '<input type="number" name="rate[]" placeholder="Enter Here" class="form-control partyRate">';
rowHtml += '</div>';
rowHtml += '</div>';
$('#rate_modal').append(rowHtml)
}
});
$(document).on('change','#type',function(){
var a = $(this).val();
if (a == 'Replace') {
$(this).closest('tr').find(".hideit").show();
//$(this).closest('tr').find("#upload3,#upload4").attr('required', true);
}
else {
$(this).closest('tr').find(".hideit").hide();
//$(this).closest('tr').find(".select_hide").val('-- Select --');
//$(this).closest('tr').find("#upload3,#upload4").attr('required', false);
}
});
/*Save Approve data*/
$('#save_approve').click(function(){
if(confirm("Are you sure you want to Approve this?"))
{
var id = [];
$('.tdCheckbox:checked').each(function(i){
id[i] = $(this).val();
});
if(id.length === 0) //tell you if the array is empty
{
alert("Select at least one checkbox");
}
else
{
$.ajax({
url:'reqApprove_db.php',
method:'POST',
data:{id:id},
success:function()
{
for(var i=0; i<id.length; i++)
{
$('tr#'+id[i]+'').css('background-color', '#ccc');
$('tr#'+id[i]+'').fadeOut('slow');
}
},
complete:function()
{
location.reload(true);
}
});
}
}
else
{
return false;
}
});
/*Save Reject data*/
$('#maReject').click(function(){
if(confirm("Are you sure you want to Reject this?"))
{
var id = [];
$('.tdCheckbox:checked').each(function(i){
id[i] = $(this).val();
});
if(id.length === 0) //tell you if the array is empty
{
alert("Select at least one checkbox");
}
else
{
$.ajax({
url:'rejectMaRequisition_db.php',
method:'POST',
data:{id:id},
success:function()
{
for(var i=0; i<id.length; i++)
{
$('tr#'+id[i]+'').css('background-color', '#ccc');
$('tr#'+id[i]+'').fadeOut('slow');
}
},
complete:function()
{
location.reload(true);
}
});
}
}
else
{
return false;
}
});
function not_editable(){
alert("MATERIAL APPROVE होने के बाद आप EDIT नहीं कर सकते!");
}
function raNot_editable(){
alert("RATE APPROVE होने के बाद आप EDIT नहीं कर सकते!");
}
function not_approve(){
alert("यह अभी तक APPROVE नहीं हुआ है!");
}
function approve(){
alert("यह पहले ही APPROVE हो चुका है!");
}
function rateGiven(){
alert("RATE पहले ही दी जा चुकी है!");
}
function rejectDisable(){
alert("APPROVE होने के बाद आप REJECT नहीं कर सकते!");
}
</script>