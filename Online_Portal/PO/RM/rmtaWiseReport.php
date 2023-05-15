<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>rmtaWizeReport</title>
    <script src="https://jspreadsheet.com/v7/jspreadsheet.js"></script>
    <script src="https://jsuites.net/v4/jsuites.js"></script>
    <link rel="stylesheet" href="https://jspreadsheet.com/v7/jspreadsheet.css" type="text/css" />
    <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <style type="text/css">
      tbody td[data-x = "2"]{
        font-weight: bold;
        color: grey;
      }
      tbody td[data-x = "10"]{
        background-color: #ffff99;
      }
      hr{
        margin: 0.5rem 0 1rem 0;
      }
      tfoot>tr>td {
            position: sticky;
            bottom: 0;
            font-weight: bold;
            background-color: #afefc9fc !important;
            color: #000000;
/*            color: #391cd9;*/
            font-family: 'Comic Sans MS';
        } 
    </style>
</head>
<body class="p-2 bg-light">
    <div class="row">
      <div class="col">
         <h3 class="mb-0">Stock Mismatch Rmta-Wize</h3>
      </div>
      <div class="col-auto d-flex">
        <select id="selectDate" class="form-control" style="width:350px;">
          <option disabled selected>-- Select Opening Date --</option>
          <?php
          include('../../../dbcon.php');
            $sql = "SELECT distinct receive_dte from inward_rm where ISNUMERIC(rmta) = 1 and come_from = 'opening' and receive_dte > '2022-10-30' order by receive_dte asc";
            $run = sqlsrv_query($con, $sql);
            while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $row['receive_dte']->format('Y-m-d'); ?>"><?php echo $row['receive_dte']->format('d-M-Y') ?></option>
              <?php
            }
           ?>
        </select>
        <button type="button" class="btn btn-primary mx-2" style="white-space: nowrap;" id="fetchRec">Get Data</button>
        <a href="../../dashboard.php" class="btn btn-warning">Back</a>
      </div>
    </div><hr>
    <div id="spreadsheet"></div>
</body>
</html>

<script type="text/javascript">

  var SUM_QTY = function(instance, colId1) {
        
        var total = 0;
        for (var j = 0; j < instance.options.data.length; j++) {
            if (Number(instance.records[j][colId1-1].element.innerHTML)) {
                total += Number(instance.records[j][colId1-1].element.innerHTML);
            }
        }
        return total;
    }


            $(document).ready(function(){
              $(document).on("click","#fetchRec",function(){
                var dte = $("#selectDate").val();
            $.ajax({
                type: "POST",
                url: "getRmtaWizeReport.php",
                data:{dte:dte},
                dataType: "json",
                    success: function (response) {
                      // console.log(response);
                    table = jspreadsheet(document.getElementById('spreadsheet'), {
                //minDimensions: [20,10],
                json:response,
                tableOverflow: true,
                tableWidth: '100%',
                allowManualInsertRow: false,
                allowManualInsertColumn: false,
                tableHeight: '550px',
                freezeColumns: 3,
                columnDrag: false,
                // includeHeadersOnDownload: true,
                // forceUpdateOnPaste: true,
                // loadingSpin: true,
                // search: true,
                // pagination: 10,
                // paginationOptions: [10,50,100],
                license: 'MTExNjBlNmIwMDIwNmUyMzQ1MjlmYmRkYWJmYzNjZWY2MTA2MWNkZjJmY2ZmNTViYWY0NjM1N2Q0YzYwMjQ1OTZjOThkZTJmNWQxMGUwODA5ZGMxMzNkZGQ5YmVhMDhiZGI1ZTA2ZTQ4ZTdjMjYwMGRlZTBiMDE3MzZmOTliNTUsZXlKdVlXMWxJam9pVTI1bGFHRnNJRkJoZEdWc0lpd2laR0YwWlNJNk1UWTROakE1TWpRd01Dd2laRzl0WVdsdUlqcGJJakV3TXk0MU15NDNNaTR4T0RnaUxDSXlOeTQxTkM0eE56SXVOakFpTENJeE9USXVNVFk0TGpFdU1qRTFJaXdpTVRreUxqRTJPQzR3TGpJME5TSXNJakU1TWk0eE5qZ3VNUzR5TkRJaUxDSXhPVEl1TVRZNExqRXVNVEl5SWl3aWJHOWpZV3hvYjNOMElsMHNJbkJzWVc0aU9pSTFJaXdpYzJOdmNHVWlPbHNpZGpjaUxDSjJPQ0pkZlE9PQ==',
                columns: [
                { type: 'text', title: 'Item Name',name: 'item', width:'320',wordWrap:true },
                { type: 'text' , title: 'Party_Name',name: 'party_name', width:'350',align:'left',wordWrap:true},
                { type: 'text', title: 'Rmta',name: 'rmta', width:'100' },
                { type: 'text', title: 'Pur.Date',name: 'recDate', width:'100' },
                { type: 'text', title: 'Rate',name: 'rate', width:'90' },
                { type: 'text', title: 'Days',name: 'diffDays', width:'80' },

                { type: 'text', title: 'Opening',name: 'qnty', width:'100' },
                { type: 'text', title: 'closing',name: 'closing', width:response[0]['ext'][0] },
                { type: 'text', title: 'ActualUse',name: 'actUse', width:response[0]['ext'][0] },
                { type: 'text', title: 'issueQnty',name: 'issueQnty', width:'100' },
                { type: 'text', title: response[0]['ext'][1],name: 'diff', width:'90' },
                { type: 'text', title: 'Int.Amt',name: 'int',mask:'0', width:'80' },
                ],
                footers: [['Total =>','','','','','','=SUM_QTY(TABLE(), 7)']],

                // columnSorting:false,
                });

                   },
              error:function(response){
                console.log(response);
              }     
                   
                 });   
              });   
        });
</script>
