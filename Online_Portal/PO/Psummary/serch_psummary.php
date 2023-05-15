<?php 
session_start();
require_once 'class.dbcon.php';
$fdate = $_POST['from_date'];
$tdate = $_POST['to_date'];
$obj = new psummary();
$output = '';

$output .= '
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
        </thead>'.
            
           $obj->search_mGrade(135,$fdate,$tdate).
           $obj->search_mGrade(168,$fdate,$tdate).
           $obj->search_mGrade(130,$fdate,$tdate).
           $obj->search_mGrade(164,$fdate,$tdate).
           $obj->search_mGrade(161,$fdate,$tdate).
           $obj->search_mGrade(171,$fdate,$tdate).
           $obj->search_mGrade(144,$fdate,$tdate).
           $obj->search_mGrade(148,$fdate,$tdate).
           $obj->search_sGrade(167,745,$fdate,$tdate).
           $obj->search_sGrade(167,949,$fdate,$tdate).
           $obj->search_sGrade(167,917,$fdate,$tdate).
           $obj->search_sGrade(167,1089,$fdate,$tdate).
           $obj->search_sGrade(167,1058,$fdate,$tdate).
           $obj->search_sGrade(167,903,$fdate,$tdate).
           $obj->search_sGrade(159,974,$fdate,$tdate).
           $obj->search_sGrade(159,1034,$fdate,$tdate).
           $obj->search_sGrade(157,927,$fdate,$tdate).
           $obj->search_sGrade(157,783,$fdate,$tdate).
           $obj->search_sGrade(157,1010,$fdate,$tdate).
           $obj->search_sGrade(163,933,$fdate,$tdate).
           $obj->search_sGrade(172,1072,$fdate,$tdate).
           $obj->search_sGrade(172,1095,$fdate,$tdate).
           $obj->search_sGrade(155,1088,$fdate,$tdate).
           $obj->search_sGrade(155,939,$fdate,$tdate).

        '
           

           
      </table>


';

echo $output;

 ?>
 <script type="text/javascript">
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

 </script>