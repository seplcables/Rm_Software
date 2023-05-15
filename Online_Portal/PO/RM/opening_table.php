<?php
session_start();
if ($_SESSION['oid'] =='snehal' || $_SESSION['oid'] =='Rajnish' || $_SESSION['oid'] =='amey' || $_SESSION['oid'] =='harikishan' || $_SESSION['oid'] =='Nishant') {
    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>pvc_opening</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://jspreadsheet.com/v9/jspreadsheet.js"></script>
    <script src="https://jsuites.net/v4/jsuites.js"></script>
    <link rel="stylesheet" href="https://jspreadsheet.com/v9/jspreadsheet.css" type="text/css" />
    <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons" />
    <style type="text/css" media="screen">
    #spreadsheet tr:nth-child(even) td{
    background-color: #edf3ff;
    }
    tbody td:nth-child(11){
    background-color: #ffff99 !important;
    font-weight: bold;
    }
    tbody td{
    font-size: 13px;
    }
    </style>
  </head>
  <body>
    <div class="row m-1">
      <div class="col-md-3">
        <a href="../../dashboard.php" class="btn btn-warning w-25">Back</a>
        <a href="viewPvcOpeningReport.php" class="btn btn-success w-25">View Report</a>
      </div>
      <div class="col-md-3">
        <input type="date" name="openingDate" id="openingDate" class="form-control">
      </div>
      <div class="col-md-3">
        <input type="button" value="Save" name="savetable" id="savetable" class="btn btn-info ml-2" />
      </div>
    </div>
    <br />
    <div class="container-fluid" id="spreadsheet"></div>
    
    <script type="text/javascript">
    jspreadsheet.setLicense('MTdjOTViNDBjMzkyYWM1MjY2MDdhMzdiZWJmNDI3YWY0OTU3Nzk0ZDZmMTA4ZjRmZjk2ZTdiZmE2ZTlkYmIyNGM4NmM5YjZlMjVjZTg2ZGM5NDNlYmNiZWM4Y2UwZWZjZmFkNTk2YmY0NzlhN2U4N2RhMTI2YjJkMmYwZWFjODgsZXlKdVlXMWxJam9pVTI1bGFHRnNJRkJoZEdWc0lpd2laR0YwWlNJNk1UWTVPRFV6TkRBd01Dd2laRzl0WVdsdUlqcGJJakV3TXk0MU15NDNNaTR4T0RnaUxDSXlOeTQxTkM0eE56SXVOakFpTENJeE9USXVNVFk0TGpFdU1qRTFJaXdpTVRreUxqRTJPQzR3TGpJME5TSXNJakU1TWk0eE5qZ3VNUzR5TkRJaUxDSXhPVEl1TVRZNExqRXVNVEl5SWl3aWJHOWpZV3hvYjNOMElsMHNJbkJzWVc0aU9pSTFJaXdpYzJOdmNHVWlPbHNpZGpjaUxDSjJPQ0lzSW5ZNUlsMTk=');
    var w = $(window).width();
    let gradeChanged = function(instance, cell, x, y, value) {
    if (x == 2) {
    let j = parseInt(y) + 1;
    var arr = value.split('-');
    var grade = arr[1];
    var rmta = arr[0];
    $.ajax({
    type: "POST",
    url: "getSubGrade.php",
    data:{grade:grade,rmta:rmta},
    dataType: "json",
    success: function (val) {
    table[0].setValue('A'+j,val.party_name);
    table[0].setValue('B'+j,val.sub_grade);
    table[0].setValue('D'+j,val.i_code);
    table[0].setValue('E'+j,rmta);
    table[0].setValue('F'+j,val.pid);
    table[0].setValue('J'+j,'=H'+j+'*25+I'+j);
    }
    });
    }
    }
    // Spreadsheet start here
    var data = [['','','','']];
    table = jspreadsheet(document.getElementById('spreadsheet'), {
    worksheets: [{
    data:data,
    // tableOverflow: true,
    tableWidth: w*0.99+'px',
    // allowManualInsertRow: false,
    allowManualInsertColumn: false,
    //tableHeight: '60%',
    freezeColumns: 3,
    columnDrag: false,
    // tableHeight: '550px',
    //search: true,
    //pagination: 20,
    //paginationOptions: [20,50,100],
    columns: [
    { type: 'dropdown', title: 'party_name', width:'220px', url:'getRmtaforExcel.php', autocomplete:true },
    { type: 'text', title: 'Sub_Grade', width:'200px' },
    { type: 'dropdown', title: 'Rmta-ItemName', width:'340px', url:'getItemforExcel.php', autocomplete:true },
    { type: 'hidden' , title: 'icode', width:'70px' },
    { type: 'hidden' , title: 'rmta', width:'70px' },
    { type: 'hidden' , title: 'pid', width:'70px' },
    { type: 'autocomplete' , title: 'StoreName', width:'110px', source:['gupta_ji','ramesh','mc76','dinesh','2106','dummy','new_dana'] },
    { type: 'text' , title: 'NoOfBags', width:'90px' },
    { type: 'text' , title: 'Kgs', width:'90px' },
    { type: 'text' , title: 'TotalKgs', width:'110px' },
    { type: 'text' , title: 'Remarks', width:'300px' },
    ],
    }],
    onchange: gradeChanged,
    columnSorting:false,
    });
    $(document).on("click","#savetable",function(){
    var dte = $("#openingDate").val();
    tbl = table[0].getData(false,true);
    let arr = [];
    tbl.forEach((e,i) =>{
    if (e[3] != "" && e[6] != "" && e[9] != 0) {
    arr.push({
    'pid': e[5],
    'rmta': e[4],
    'icode': e[3],
    'storeName': e[6],
    'qnty': e[9],
    'remark': e[10],
    'dte': dte
    });
    }
    });
    if (dte == '' || arr.length == 0) {
    alert("Something missing like Date,StoreName,TotalKgs...");
    }else{
    if (confirm("Are You Sure???")) {
    $.ajax({
    type: "POST",
    url: "opening_table_to_db.php",
    data:{arr:arr},
    success: function (data) {
    alert(data);
    },
    complete:function(){
    location.reload();
    },
    error:function(data){
    console.log(data);
    }
    });
    }
    }
    
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