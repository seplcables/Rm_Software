<?php
//filter.php
if(isset($_POST["i_code"]))  
 {
$output = '';

$output .= '
    <table border="1" class="text-center ml-3 table table-striped table-sm" style="width:95%">
                <thead>
                <tr class="forRequisitionHead">
                  <th>SrNo</th>
                  <th>Rec. Date</th>
                  <th>Party Name</th>
                  <th>Qnty</th>
                  <th>Rate</th>
                </tr>
                </thead>
  ';
        include('..\..\..\dbcon.php');
        $sql = "SELECT top 10 b.receive_date,a.rec_qnty,a.pur_rate,c.party_name FROM inward_ind a
        LEFT OUTER JOIN inward_com b on a.sr_no = b.sr_no AND a.receive_at = b.receive_at
        LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party WHERE a.p_item = '".$_POST["i_code"]."' ORDER BY receive_date desc";
        $params = array();
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $run = sqlsrv_query($con,$sql);
        $runcount = sqlsrv_query($con,$sql,$params,$options);
        $count=sqlsrv_num_rows($runcount);
        if($count<1)
         {
          $output .= '

    <tr class="text-center font-italic forRequisitionBody">
          <td class="font-weight-bold" colspan="5">NO RECORDS FOUNDS</td>
    </tr>
  ';
         }
         else{ 
        $srno = 0;
        while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
        {
          $srno++;


  $output .= '

    <tr class="text-center font-italic forRequisitionBody">
          <td class="font-weight-bold">'.$srno.'</td>  
          <td>'.$row['receive_date']->format('d-M-y').'</td>
          <td>'.$row['party_name'].'</td>
          <td>'.$row['rec_qnty'].'</td>
          <td>'.$row['pur_rate'].'</td>
    </tr>
  ';
   }
  }
$output .= '</table>';
echo $output;
}
?>