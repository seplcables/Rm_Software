/*Show Add Rate means Compare Modal*/
        $(document).on('click', '.compare', function(){
        var id = $(this).attr("id");
        $.ajax({
        url:"getcompare.php",
        method:"POST",
        data:{id:id},
        success:function(data)
        {
        $('#compare_data').html(data);
        $('#compare').modal('show');
        }
        });
        });
        // Rate Approve Modal
        $(document).on('click', '.rate_approve', function(){
        var id = $(this).attr("id");
        $('#rateApprove').val(id);
        $.ajax({
        url:"getRateApprove.php",
        method:"POST",
        data:{id:id},
        success:function(data)
        {
        $('#rateApprove_data').html(data);
        $('#rate_approve').modal('show');
        }
        });
        });
        $(document).on('click', '.clickRadio', function(){
          var x = $(this).val();
          var y = $(this).closest('td').find('.radioId').val();
          var z = $(this).closest('tr').find('.lll').text();
          $('.rateId'+y).val(x);
          $('.rateList'+y).val(z);
         });   
        // Rate History Show Modal

        $(document).on('click', '.rateHistory', function(){
        var i_code = $(this).attr("id");
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

        /*Party Rate Small Pop-up Modal*/
        $(document).on('click', '.button1', function(){
        var id = $(this).attr("id");
        $('#rateId').val(id);
        
            $.ajax({
        url:"getrate.php",
        method:"POST",
        data:{id:id},
        success:function(data)
        {
        $('#rate_modal').html(data);
        $('#Add_data').modal('show');
        }
        });
        
        });
        /*Show Requisition Approval Modal*/
        $(document).on('click', '.app', function(){
        var id = $(this).attr("id");
        $.ajax({
        url:"getapprove.php",
        method:"POST",
        data:{id:id},
        success:function(data)
        {
        $('#approve_data').html(data);
        $('#app').modal('show');
        }
        });
        });
        
        /*Reject Button Modal*/
        $(document).on('click', '.maReject', function(){
        var id = $(this).attr("id");
        $.ajax({
        url:"rejectMaRequisition_db.php",
        method:"POST",
        data:{id:id},
        success:function(data)
        {
            alert(data);
        }
        });
        });
        /*Reject Button in Rate Approve*/
        $(document).on('click', '.raReject', function(){
        var id = $(this).attr("id");
        $.ajax({
        url:"rejectRaRequisition_db.php",
        method:"POST",
        data:{id:id},
        success:function(data)
        {
            alert(data);
            $('#rate_approve').modal('hide');
        }
        });
        });
        /*Tooltip show Modal*/
        $(document).on('click', '.tooltip_text', function(){
        var id = $(this).attr("id");         
        $.ajax({
        url:"getPartyList.php",
        method:"POST",
        data:{id:id},
        success:function(data)
        {
        $('#partyList_modal').html(data);
        $('#partyList_data').modal('show');
        }
        });

        });



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
$(this).closest('div').find('.indentor').val(ui.item.label);
$(this).closest('div').find('.dpnt').val(ui.item.dpnt);
//$('.dpnt').val(ui.item.dpnt);
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
//Search Party
function SearchParty(txtBoxRef) {
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
$.ajax({
url: "getparty.php",
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
var self = this;
$(self).closest('div').find('.party_name').val(ui.item.label);
$(self).closest('div').find('.pid').val(ui.item.pid);
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

/*select All*/
function toggle(source) {
var checkboxes = document.querySelectorAll('input[type="checkbox"]');
for (var i = 0; i < checkboxes.length; i++) {
if (checkboxes[i] != source)
checkboxes[i].checked = source.checked;
}
}
