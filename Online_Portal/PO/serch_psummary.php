<?php
//filter.php
include('..\..\dbcon.php');
$from_date = $_POST["from_date"];
$to_date = $_POST["to_date"];
$output = '';

$output .= '
    <table class="table table-bordered table-striped table-sm" id="raw_material" style="width:100%">
        <thead>
          <tr id="trow">
            <th>MAIN G.</th>
            <th>Month</th>
            <th>PARTY</th>
            <th>RMTA</th>
            <th>BILL NO</th>
            <th>BILL DT.</th>
            <th>REC DT.</th>
            <th>SUB G.</th>
            <th>SIZE/GRADE</th>
            <th>QNTY</th>
            <th>RATE</th>
            <th>BASIC</th>
            <th>Tax Amt</th>
            <th>Bill Amt</th>
          </tr>
        </thead>
  ';
       // COPPER PART
        include('..\..\dbcon.php');
        $sql = "SELECT e.main_grade,c.party_name,b.sr_no,b.invoice_no,b.invoice_date,b.receive_date,f.sub_grade,g.item,a.rec_qnty,a.pur_rate,a.taxable_amt,a.total_tax_amt,
        a.total_amt FROM inward_ind a
        LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
        LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
        LEFT OUTER JOIN rm_m_grade e on e.m_code= a.p_main_grade
        LEFT OUTER JOIN rm_s_grade f on f.s_code= a.p_sub_grade
        LEFT OUTER JOIN rm_item g on g.i_code= a.p_item
        where p_main_grade=135 and receive_date >= '$from_date' and receive_date <= '$to_date'
        order by receive_date asc";
        $run = sqlsrv_query($con,$sql);
        $cu_qnty = 0;
        while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
        {


  $output .= '

    <tr class="text-center font-italic">   
          <td>'.$row['main_grade'].'</td>
          <td>'.$row['receive_date']->format('M-y').'</td>
          <td>'.$row['party_name'].'</td>
          <td>'.$row['sr_no'].'</td>
          <td>'.$row['invoice_no'].'</td>
          <td>'.$row['invoice_date']->format('d-M-y').'</td>
          <td>'.$row['receive_date']->format('d-M-y').'</td>
          <td>'.$row['sub_grade'].'</td>
          <td>'.$row['item'].'</td>
          <td>'.$row['rec_qnty'].'</td>
          <td>'.$row['pur_rate'].'</td>
          <td>'.$row['taxable_amt'].'</td>
          <td>'.$row['total_tax_amt'].'</td>
          <td>'.$row['total_amt'].'</td>
    </tr>
  ';
   $cu_qnty += $row['rec_qnty'];
  }
  $output .= '
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
          <td align="center">'.$cu_qnty.'</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
  ';

  // ALUMINIUM PART
        $sql1 = "SELECT e.main_grade,c.party_name,b.sr_no,b.invoice_no,b.invoice_date,b.receive_date,f.sub_grade,g.item,a.rec_qnty,a.pur_rate,a.taxable_amt,a.total_tax_amt,
        a.total_amt FROM inward_ind a
        LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
        LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
        LEFT OUTER JOIN rm_m_grade e on e.m_code= a.p_main_grade
        LEFT OUTER JOIN rm_s_grade f on f.s_code= a.p_sub_grade
        LEFT OUTER JOIN rm_item g on g.i_code= a.p_item
        where p_main_grade=130 and receive_date >= '$from_date' and receive_date <= '$to_date'
        order by receive_date asc";
        $run1 = sqlsrv_query($con,$sql1);
        $alu_qnty = 0;
        while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
        {


  $output .= '

    <tr class="text-center font-italic">   
          <td>'.$row1['main_grade'].'</td>
          <td>'.$row1['receive_date']->format('M-y').'</td>
          <td>'.$row1['party_name'].'</td>
          <td>'.$row1['sr_no'].'</td>
          <td>'.$row1['invoice_no'].'</td>
          <td>'.$row1['invoice_date']->format('d-M-y').'</td>
          <td>'.$row1['receive_date']->format('d-M-y').'</td>
          <td>'.$row1['sub_grade'].'</td>
          <td>'.$row1['item'].'</td>
          <td>'.$row1['rec_qnty'].'</td>
          <td>'.$row1['pur_rate'].'</td>
          <td>'.$row1['taxable_amt'].'</td>
          <td>'.$row1['total_tax_amt'].'</td>
          <td>'.$row1['total_amt'].'</td>
    </tr>
  ';
   $alu_qnty += $row1['rec_qnty'];
  }
  $output .= '
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
          <td align="center">'.$alu_qnty.'</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
  ';

  // PVC PART
        $sql2 = "SELECT e.main_grade,c.party_name,b.sr_no,b.invoice_no,b.invoice_date,b.receive_date,f.sub_grade,g.item,a.rec_qnty,a.pur_rate,a.taxable_amt,a.total_tax_amt,
        a.total_amt FROM inward_ind a
        LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
        LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
        LEFT OUTER JOIN rm_m_grade e on e.m_code= a.p_main_grade
        LEFT OUTER JOIN rm_s_grade f on f.s_code= a.p_sub_grade
        LEFT OUTER JOIN rm_item g on g.i_code= a.p_item
        where (p_main_grade=161 or p_main_grade=171) and receive_date >= '$from_date' and receive_date <= '$to_date'
        order by receive_date asc";
        $run2 = sqlsrv_query($con,$sql2);
        $pvc_qnty = 0;
        while($row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC))
        {


  $output .= '

    <tr class="text-center font-italic">   
          <td>'.$row2['main_grade'].'</td>
          <td>'.$row2['receive_date']->format('M-y').'</td>
          <td>'.$row2['party_name'].'</td>
          <td>'.$row2['sr_no'].'</td>
          <td>'.$row2['invoice_no'].'</td>
          <td>'.$row2['invoice_date']->format('d-M-y').'</td>
          <td>'.$row2['receive_date']->format('d-M-y').'</td>
          <td>'.$row2['sub_grade'].'</td>
          <td>'.$row2['item'].'</td>
          <td>'.$row2['rec_qnty'].'</td>
          <td>'.$row2['pur_rate'].'</td>
          <td>'.$row2['taxable_amt'].'</td>
          <td>'.$row2['total_tax_amt'].'</td>
          <td>'.$row2['total_amt'].'</td>
    </tr>
  ';
   $pvc_qnty += $row2['rec_qnty'];
  }
  $output .= '
      <tr style="font-weight: bold; background-color: #ffff99;">
          <td align="center">PVC Compound</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td align="center">'.$pvc_qnty.'</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
  ';

  // GI PART
        $sql3 = "SELECT e.main_grade,c.party_name,b.sr_no,b.invoice_no,b.invoice_date,b.receive_date,f.sub_grade,g.item,a.rec_qnty,a.pur_rate,a.taxable_amt,a.total_tax_amt,
        a.total_amt FROM inward_ind a
        LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
        LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
        LEFT OUTER JOIN rm_m_grade e on e.m_code= a.p_main_grade
        LEFT OUTER JOIN rm_s_grade f on f.s_code= a.p_sub_grade
        LEFT OUTER JOIN rm_item g on g.i_code= a.p_item
        where p_main_grade=164 and receive_date >= '$from_date' and receive_date <= '$to_date'
        order by receive_date asc";
        $run3 = sqlsrv_query($con,$sql3);
        $gi_qnty = 0;
        while($row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC))
        {


  $output .= '

    <tr class="text-center font-italic">   
          <td>'.$row3['main_grade'].'</td>
          <td>'.$row3['receive_date']->format('M-y').'</td>
          <td>'.$row3['party_name'].'</td>
          <td>'.$row3['sr_no'].'</td>
          <td>'.$row3['invoice_no'].'</td>
          <td>'.$row3['invoice_date']->format('d-M-y').'</td>
          <td>'.$row3['receive_date']->format('d-M-y').'</td>
          <td>'.$row3['sub_grade'].'</td>
          <td>'.$row3['item'].'</td>
          <td>'.$row3['rec_qnty'].'</td>
          <td>'.$row3['pur_rate'].'</td>
          <td>'.$row3['taxable_amt'].'</td>
          <td>'.$row3['total_tax_amt'].'</td>
          <td>'.$row3['total_amt'].'</td>
    </tr>
  ';
   $gi_qnty += $row3['rec_qnty'];
  }
  $output .= '
      <tr style="font-weight: bold; background-color: #ffff99;">
          <td align="center">SS/GI (Wire/Strip)</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td align="center">'.$gi_qnty.'</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
  ';

$output .= '</table>';
echo $output;
?>
<script type="text/javascript">
      // define function to delete all table row

    $(document).ready(function() {
    
    var table = $('#raw_material').DataTable({
    "processing": true,
    "ordering": false,
    "dom": 'Bfrtip',
    
    lengthMenu: [
    [ -1, 10, 25, 50, ],
    [ 'Show all', '10 rows', '25 rows', '50 rows' ]
    ],
    buttons: [
    'pageLength', 'excel', 'print'
    ],
    
    });

    

   }); 
  </script>