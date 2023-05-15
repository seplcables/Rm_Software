
<?php
session_start();
include('..\..\..\dbcon.php');
/*$sql = "SELECT mat_require_dte,indentor,indentor_dpnt,remarks from Requisition_head
where id = '".$_GET['id']."'";
$run = sqlsrv_query($con,$sql);
$row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
*/
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
    <title>Approval</title>
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
    background-color: ;
    
    }
    tr
    {
    
    font-size: 12px;
    border-radius: 0px;
    }
   /* td
    {
    border: 1px solid #170891;
    font-size: 12px;
    }*/
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
    .largerCheckbox
    {
      width: 30px;
      height: 20px;
      margin-top: 5px;
    }
    
    </style>
    
  </head>
  <body>
    
    <div class="container-fluid">
      <form action="Requisition_edit_db.php" method="POST">
        <div class="card bg-faded mt-3">
          
          <div class="card-body">
            <div class="row justify-content-center">
             
                <div class="table-responsive  m-1">
                  <table align="center" class="table table-bordered table-striped table-sm" id="receive" style="text-align: center;">
                    
                    <tr style="background-color: #999999;color: white;">
                      <th>
                        SR.
                      </th>
                      <th>Item Description</th>
                      <th>Qnty</th>
                      <th>Approx Cost</th>
                      <th>M\C No.</th>
                      <th>Department</th>
                      <th>Plant</th>
                      <th>Category</th>
                      <th>State</th>
                      <th>Type</th>
                      <th>Old_Part_Status</th>
                      <th>Approval</th>
                    </tr>
                  </thead>
                  <tbody id="receive">
                    <?php
                    $sql1 = "SELECT a.id,a.iid,a.item_code,d.category,b.item,a.qnty,a.rate,a.mc,a.department,a.state,a.plant,a.type,a.old_part_status from Requisition_details a
                    LEFT OUTER JOIN rm_item b on a.item_code = b.i_code
                    LEFT OUTER JOIN rm_category d on d.c_code = b.c_code
                    where a.iid = 5";
                    $run1 = sqlsrv_query($con,$sql1);
                    $count = 0;
                    while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
                    {
                    $count++;
                    ?>
                    <tr>
                      <td name="sr" id="sr"><?php echo $count; ?></td>
                      <td><?php echo $row1['item']; ?></td>
                      <td><?php echo $row1['qnty']; ?></td>
                      <td><?php echo $row1['rate']; ?></td>
                      <td><?php echo $row1['mc']; ?></td>
                      <td><?php echo $row1['department']; ?></td>
                      <td><?php echo $row1['plant']; ?></td>
                      <td><?php echo $row1['category']; ?></td>
                      <td><?php echo $row1['state']; ?></td>
                      <td><?php echo $row1['type']; ?></td>
                      <td><?php echo $row1['old_part_status']; ?></td>
                      <td style="width:50px">
                        <input type="checkbox" style="width:50px" class="largerCheckbox" name="">
                      </td>
                      
                    </tr>
                    <?php
                    }
                    ?>
                    <input type="hidden" value="<?php /*echo $count;*/ ?>" id="total_row_count">
                  </tbody>
                </table>
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
function SearchMc(txtBoxRef) {
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
var self = this;
$(self).closest('tr').find('.mcno').val(ui.item.label);
$(self).closest('tr').find('.dept').val(ui.item.dname);
$(self).closest('tr').find('.plant').val(ui.item.plant);
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
$(this).closest('tr').find('.dept').prop('readonly', true);
}
}
});
}
// Department autocomplete box
function SearchDpnt(txtBoxRef) {
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
var self = this;
$(self).closest('tr').find('.dept').val(ui.item.label);
$(self).closest('tr').find('.plant').val(ui.item.plant);
return false;
},
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
$("#newbtn").click(function(){
var xyz = $('#'+abc+'Des').val();
if (xyz == "") {
alert('Please fill Current Information (कृपया पहले जानकारी भरें)');
}
else
{
abc++;
var rowHtml = '<tr>';
rowHtml += '<td  name="sr" id="sr">'+abc+'</td>';
rowHtml += '<td ><input type="text" name="item_desc[]" class="form-control item" onFocus="SearchItem(this)"  id="'+abc+'Des" required><input type="hidden" name="i_code[]" class="i_code"><input type="hidden" name="new_row[]" class="new_row"></td>';
rowHtml += '<td ><input type="number" step="0.01" name="Qnty[]" class="form-control"  id="'+abc+'Qnt" required></td>';
rowHtml += '<td ><input type="number" step="0.01" name="apx_cost[]" class="form-control"  id="'+abc+'apx_cost"></td>';
rowHtml +='<td ><input type="text" onFocus="SearchMc(this)" name="mc[]" class="form-control mcno"  id="'+abc+'mc"></td>';
rowHtml += '<td ><input type="text" name="dept[]" onFocus="SearchDpnt(this)" class="form-control dept"  id="'+abc+'dept" required></td>';
rowHtml += '<td ><input type="text" name="plant[]" class="form-control plant"  id="'+abc+'plant" readonly></td>';
rowHtml += '<td><input type="text" name="category[]" class="form-control category"  id="'+abc+'category" readonly></td>';
rowHtml += '<td ><select class="form-select" aria-label="Default select example" id="'+abc+'state" name="state[]" ><option></option><option class="bg-dark text-white">Capital</option><option class="bg-dark text-white">Consumable</option><option class="bg-dark text-white">Raw Material</option></select></td>';
rowHtml += '<td ><select class="form-select type" aria-label="Default select example" id="type" name="status[]"  required><option></option><option  class="bg-dark text-white">New</option><option  class="bg-dark text-white">Replace</option></select></td>';
rowHtml += '<td ><select class="form-select hideit" aria-label="Default select example" id="'+abc+'old_part" name="old_part[]" ><option></option><option  class="bg-dark text-white">Repair</option><option  class="bg-dark text-white">Stock</option><option  class="bg-dark text-white">Scrap</option></select></td>';
rowHtml += '</tr>';
$('table').find('tbody').append(rowHtml)
$('#'+abc+'old_part').hide();
}
});
$(document).on('change','#type',function(){
var a = $(this).val();
if (a == 'Replace') {
$(this).closest('tr').find(".hideit").show();
$(".hidelable").show();
//$(this).closest('tr').find("#upload3,#upload4").attr('required', true);
}
else {
$(this).closest('tr').find(".hideit").hide();
//$(this).closest('tr').find("#upload3,#upload4").attr('required', false);
}
});
</script>