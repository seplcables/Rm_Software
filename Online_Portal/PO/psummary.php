<?php 
session_start();
if (!isset($_SESSION['oid'])) {
$_SESSION['login'] = "Please Login First";
header("location:..\..\OnlinePortal_login.php");
$_SESSION['targetPage'] = 'Online_Portal/PO/psummary.php';
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
        <a href="../dashboard.php" class="btn btn-warning">HOME</a>
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
        include('..\..\dbcon.php');
        $sql = "SELECT a.id,e.main_grade,c.party_name,b.sr_no,b.invoice_no,b.invoice_date,b.receive_date,f.sub_grade,g.item,a.rec_qnty,a.pur_rate,a.taxable_amt,a.total_tax_amt,
        b.total_bill_amt,h.isAprv,h.fi,h.deduction,h.aRate,i.rate,a.plant FROM inward_ind a
        LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
        LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
        LEFT OUTER JOIN rm_m_grade e on e.m_code= a.p_main_grade
        LEFT OUTER JOIN rm_s_grade f on f.s_code= a.p_sub_grade
        LEFT OUTER JOIN rm_item g on g.i_code= a.p_item
        LEFT OUTER JOIN psummary h on h.purchaseId = a.id
        LEFT OUTER JOIN po_entry_details i on i.id = a.iid
        where p_main_grade=135 and receive_date >= '$current_month'
        order by receive_date asc";

        $run = sqlsrv_query($con,$sql);
        $cu_qnty = 0;
        $finalAmtSum = 0;
        while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
        {
           $finalRate = ($row['aRate'] == 0 || $row['aRate'] == NULL) ? $row['rate'] : $row['aRate'];
           $finalAmt = $finalRate*$row['rec_qnty']; 
          if ($row['isAprv']) {
               $x =  '<i class="fa fa-check-square checked_check" onclick="approve();" aria-hidden="true"></i>';
               $y = 'readonly';
             } else{ 
               $x =  '<input type="checkbox" value="'.$row['id'].'" class="largerCheckbox tdCheckbox" name="checkId[]">';
               $y = '';
            }

        ?>
        <tr class="text-center font-italic">   
          <td><?php echo $row['main_grade'];  ?></td>
          <td><?php echo $row['plant'];  ?></td>
          <td><?php echo $row['receive_date']->format('M-y');  ?></td>
          <td data-toggle="tooltip" title="<?php echo $row['party_name'];  ?>"><?php echo substr($row['party_name'],0,15);  ?></td>
          <td><?php echo $row['sr_no'];  ?></td>
          <td><?php echo $row['invoice_no'];  ?></td>
          <td><?php echo $row['invoice_date']->format('d-M-y');  ?></td>
          <td><?php echo $row['receive_date']->format('d-M-y');  ?></td>
          <td><?php echo $row['sub_grade'];  ?></td>
          <td><?php echo $row['item'];  ?></td>
          
          <td class="setFont"><?php echo $row['pur_rate'];  ?></td>
          <td class="setFont"><?php echo $row['taxable_amt'];  ?></td>
          <td class="setFont"><?php echo $row['total_tax_amt'];  ?></td>
          <td class="setFont"><?php echo $row['total_bill_amt'];  ?>
          <input type="hidden" value="<?php echo $row['fi'];  ?>" name="fi[]" class="inputInTable fi" <?php echo $y; ?>>
          <input type="hidden" value="<?php echo $row['deduction'];  ?>" name="deduction[]" class="inputInTable deduction" <?php echo $y; ?>>
        </td>
          <!-- <td></td>
          <td></td> -->
          <td><input type="number" value="<?php echo $finalRate;  ?>" step="0.01" name="aRate[]" class="inputInTable aRate" <?php echo $y; ?>></td>
          <td class="setFont text-danger"><?php echo $row['rec_qnty'];  ?></td>
          <td class="setFont text-danger"><?php echo $finalRate;  ?></td>
          <td class="setFont text-danger"><?php echo $finalAmt;  ?></td>
          <td>
            <?php echo $x; ?>
          </td>
        </tr>
        <?php
        $cu_qnty += $row['rec_qnty'];
        $finalAmtSum += (int)$finalAmt;
        }
        ?>
        <tr style="font-weight: bold; background-color: #ffff99;">
          <td align="center">Copper</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <!-- <td></td>
          <td></td> -->
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td align="center"><?php echo $cu_qnty;  ?></td>
          <td></td>
          <td align="center"><?php echo $finalAmtSum;  ?></td>
          <td></td>
          
        </tr>
     <!-- ALUMINIUM GRADE START HERE -->   
         <?php 
        $sql1 = "SELECT a.id,e.main_grade,c.party_name,b.sr_no,b.invoice_no,b.invoice_date,b.receive_date,f.sub_grade,g.item,a.rec_qnty,a.pur_rate,a.taxable_amt,a.total_tax_amt,
        b.total_bill_amt,h.isAprv,h.fi,h.deduction,h.aRate,i.rate,a.plant FROM inward_ind a
        LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
        LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
        LEFT OUTER JOIN rm_m_grade e on e.m_code= a.p_main_grade
        LEFT OUTER JOIN rm_s_grade f on f.s_code= a.p_sub_grade
        LEFT OUTER JOIN rm_item g on g.i_code= a.p_item
        LEFT OUTER JOIN psummary h on h.purchaseId = a.id
        LEFT OUTER JOIN po_entry_details i on i.id = a.iid
        where p_main_grade=130 and receive_date >= '$current_month'
        order by receive_date asc";
        $run1 = sqlsrv_query($con,$sql1);
        $alu_qnty = 0;
        $finalAmtSum1 = 0;
        while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
        {
           $finalRate = ($row1['aRate'] == 0 || $row1['aRate'] == NULL) ? $row1['rate'] : $row1['aRate'];
           $finalAmt = $finalRate*$row1['rec_qnty']; 
          if ($row1['isAprv']) {
               $x =  '<i class="fa fa-check-square checked_check" onclick="approve();" aria-hidden="true"></i>';
               $y = 'readonly';
             } else{ 
               $x =  '<input type="checkbox" value="'.$row1['id'].'" class="largerCheckbox tdCheckbox" name="checkId[]">';
               $y = '';
            }

        ?>
        <tr class="text-center font-italic">   
          <td><?php echo $row1['main_grade'];  ?></td>
          <td><?php echo $row1['plant'];  ?></td>
          <td><?php echo $row1['receive_date']->format('M-y');  ?></td>
          <td data-toggle="tooltip" title="<?php echo $row1['party_name'];  ?>"><?php echo substr($row1['party_name'],0,15);  ?></td>
          <td><?php echo $row1['sr_no'];  ?></td>
          <td><?php echo $row1['invoice_no'];  ?></td>
          <td><?php echo $row1['invoice_date']->format('d-M-y');  ?></td>
          <td><?php echo $row1['receive_date']->format('d-M-y');  ?></td>
          <td><?php echo $row1['sub_grade'];  ?></td>
          <td><?php echo $row1['item'];  ?></td>
          
          <td class="setFont"><?php echo $row1['pur_rate'];  ?></td>
          <td class="setFont"><?php echo $row1['taxable_amt'];  ?></td>
          <td class="setFont"><?php echo $row1['total_tax_amt'];  ?></td>
          <td class="setFont"><?php echo $row1['total_bill_amt'];  ?>
          <input type="hidden" value="<?php echo $row1['fi'];  ?>" name="fi[]" class="inputInTable fi" <?php echo $y; ?>>
          <input type="hidden" value="<?php echo $row1['deduction'];  ?>" name="deduction[]" class="inputInTable deduction" <?php echo $y; ?>>
        </td>
          <!-- <td></td>
          <td></td> -->
          <td><input type="number" value="<?php echo $finalRate;  ?>" step="0.01" name="aRate[]" class="inputInTable aRate" <?php echo $y; ?>></td>
          <td class="setFont text-danger"><?php echo $row1['rec_qnty'];  ?></td>
          <td class="setFont text-danger"><?php echo $finalRate;  ?></td>
          <td class="setFont text-danger"><?php echo $finalAmt;  ?></td>
          <td>
            <?php echo $x; ?>
          </td>
        </tr>
        <?php
        $alu_qnty += $row1['rec_qnty'];
        $finalAmtSum1 += (int)$finalAmt;
        }
        ?>
        <tr style="font-weight: bold; background-color: #ffff99;">
          <td align="center">Aluminium</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <!-- <td></td>
          <td></td> -->
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td align="center"><?php echo $alu_qnty;  ?></td>
          <td></td>
          <td align="center"><?php echo $finalAmtSum1;  ?></td>
          <td></td>
          
        </tr>  
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