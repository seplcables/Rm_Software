<?php 
session_start();
require_once 'class.dbcon.php';
if (!isset($_SESSION['oid'])) {
$_SESSION['login'] = "Please Login First";
header("location:..\..\..\OnlinePortal_login.php");
$_SESSION['targetPage'] = 'Online_Portal/PO/Psummary/psummary.php';
}
else {
date_default_timezone_set('Asia/Kolkata');
$current_month = date('Y-m-01', time());
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purchase Summary</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.3.3/css/fixedColumns.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

   <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
   <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
   <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.bootstrap.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
   <script src="https://cdn.datatables.net/fixedcolumns/3.3.3/js/dataTables.fixedColumns.min.js"></script>
   <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
   
   
    
    <style type="text/css">
    /* Chrome, Safari, Edge, Opera */
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }
    #trow{
    background-color: #ccff99;
    
    }
    th{
    color: black;
    font-size: 12px;
    font-family:Sitka Text;
    text-align: center;
    }
    .largerCheckbox
        {
        width: 30px;
        height: 20px;
        margin-top: 10px;
        }
       th, td { white-space: nowrap; }
       td {
            font-size: 14px;
       }

       div.dataTables_wrapper {
        margin: 0 auto;
    }
    .inputInTable{
         width: 70px;

    }
    .setFont{

      font-family: "Bahnschrift SemiCondensed";
    }
    .checked_check{
        font-size: 1.9em;
        color: green;
        }
     input[type="number"]:read-only{
            background-color: #dee3e1;
            border: none;
            text-align: right;
            padding-right: 5px;
     }
     .text_hide{
         display: none;
     }
     .rowHighLigth{
       background-color: #d5134054 !important;
     }   
   


    </style>
  </head>
  <body>
    <div class="container" style="margin-top: 4px;">
     <div class="col-sm-4">
        <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
      </div>
      <div class="col-sm-4">
        <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
      </div>
      <div class="col-sm-1">
        <input type="button" name="filter" id="filter" value="Fetch" class="btn btn-info" />
      </div>
      <div class="col-sm-1">
        <a href="../../dashboard.php" class="btn btn-warning">HOME</a>
      </div>
      <div class="col-sm-1">
        <input type="button" name="filter" id="submitForm" value="SAVE" class="btn btn-primary" />
      </div>
      <div style="clear:both"></div>
      
    </div>
    <form id="psummary_form">
    <div class="table-responsive container-fluid" id="order_table">
      <table class="table table-bordered table-striped" id="raw_material" style="width:100%">
        <thead>
          <tr id="trow">
            <th>MAIN G.</th>
            <th>Plant</th>
            <th>Month</th>
            <th>PARTY</th>
            <th>RMTA</th>
            <th>BILL NO</th>
            <th>BILL DT.</th>
            <th>REC DT.</th>
            <th>SUB G.</th>
            <th>SIZE/GRADE</th>
            <th>B. RATE</th>
            <th>BASIC</th>
            <th>Tax Amt</th>
            <th>Bill Amt</th>
            <!-- <th>F & I</th>
            <th>Deduction</th> -->
            <th>PO RATE</th>
            <th>QTY</th>
            <th>RATE</th>
            <th>TOTAL AMT</th>
            <th>CKBX</th>
          </tr>
        </thead>
        <!-- COPPER PART -->
        <?php 
            $obj = new psummary();
           echo $obj->get_mGrade(135); // COPPER
           echo $obj->get_mGrade(168); // THERMO COPPER
           echo $obj->get_mGrade(130); // ALUMINIUM
           echo $obj->get_mGrade(164); // GI
           echo $obj->get_mGrade(161); // PVC,PVC TAPE
           echo $obj->get_mGrade(171); // XLPE
           echo $obj->get_mGrade(163); // XLPE
           echo $obj->get_mGrade(144); // JOB WORK PVC
           echo $obj->get_mGrade(148); // MASTER BATCH
           echo $obj->get_sGrade(167,745); // ALU FOIL TAPE
           echo $obj->get_sGrade(167,949); // MYLAR TAPE
           echo $obj->get_sGrade(167,917); // MICA TAPE
           echo $obj->get_sGrade(167,1089); // FIBER TAPE
           echo $obj->get_sGrade(167,1058); // WATER SWALLABLE TAPE
           echo $obj->get_sGrade(167,1055); // WATER BLOCKING TAPE
           echo $obj->get_sGrade(167,903); // MARKING TAPE
           echo $obj->get_sGrade(159,974); // RIP CORD
           echo $obj->get_sGrade(159,1034); // TIN INGOT
           echo $obj->get_sGrade(157,927); // MOITURE POWDER
           echo $obj->get_sGrade(157,783); // CHOCK POWDER
           echo $obj->get_sGrade(157,1010); // STEARIC ACID
           echo $obj->get_sGrade(163,933); // NYLON DORA
           echo $obj->get_sGrade(172,1072); // PTFE TAPE
           echo $obj->get_sGrade(172,1095); // POLYMIDE TAPE
           echo $obj->get_sGrade(155,1088); // HDPE SHEET
           echo $obj->get_sGrade(155,939); // PACKING PATTI


         ?>
        
        
      </table>
    </div>
    </form>
    <script type="text/javascript">
     
      $.datepicker.setDefaults({
      dateFormat: 'dd-M-yy'
      });
      $(function(){
      $("#from_date").datepicker();
      $("#to_date").datepicker();
      });
        $('#filter').click(function(){

          $('table').find('#t_body tr').remove();

        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if(from_date != '' && to_date != '')
        {
        $.ajax({
        url:"serch_psummary.php",
        method:"POST",
        data:{from_date:from_date, to_date:to_date},
        success:function(data)
        {
        $('#order_table').html(data);
        }
        });
        }
        else
        {
        alert("Please Select Both Date");
        }
        });
    </script>
    <script type="text/javascript">
      // define function to delete all table row

    $(document).ready(function() {
    
    var table = $('#raw_material').DataTable({
    "processing": true,
    "ordering": false,
    "scrollX":  true,
    "scrollY": '75vh',
    "dom": 'Bfrtip',
    
    "fixedColumns":   {
            "leftColumns": 0
            
        },

select: {
            /*style: 'multi',*/
            toggleable: false
        },
        
    
    lengthMenu: [
    [ -1, 10, 25, 50, ],
    [ 'Show all', '10 rows', '25 rows', '50 rows' ]
    ],
               buttons: [
               'colvis',
               'pageLength',
          {
              extend: 'excelHtml5',
              exportOptions: {
                  columns: ':visible'
              }
          },
          
      ],
     
    
    });
   }); 

         $('#submitForm').click(function(){
      if(confirm("Are you sure you want to SAVE this?"))
      {
               var id = [];
               var fi = [];
               var de = [];
               var rate = [];

            $(':checkbox:checked').each(function(i){
            id[i] = $(this).val();
            fi[i] = $(this).closest('tr').find('.fi').val();
            de[i] = $(this).closest('tr').find('.deduction').val();
            rate[i] = $(this).closest('tr').find('.aRate').val();

            });
            if(id.length === 0) //tell you if the array is empty
            {
            alert("Please Select atleast one checkbox");
            }
            else
            {
            $.ajax({
            url:'psummary_db.php',
            method:'POST',
            data:{id:id,fi:fi,de:de,rate:rate},
            success:function(msg)
            {
              alert(msg);
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
         function approve(){
         alert("यह पहले ही APPROVE हो चुका है!");
         }
  </script>
    
  </body>
</html>
<?php 
}
 ?>