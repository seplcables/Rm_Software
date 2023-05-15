<?php
//filter.php
include('..\..\..\dbcon.php');
$output = '';
if(isset($_POST["fil"]))
{
$ii = $_POST['fil'];
$query = "SELECT distinct a.item as code,a.party,a.rmta,a.store_name,b.item FROM inward_rm a INNER JOIN rm_item b on a.item = b.i_code where b.item LIKE '%$ii%' or a.store_name LIKE '%$ii%' or a.rmta LIKE '%$ii%'";
}
$result = sqlsrv_query($con,$query);
$params = array();
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$run1=sqlsrv_query($con,$query,$params,$options);
$output .= '
<table class="table table-bordered table-striped table-sm" id="employee_data">
        <thead>
        <tr class="bg-dark text-white text-center font-italic">
                                    <th style="width:15%">Party</th>                                   
                                    <th style="width:20%">Grade</th>
                                    <th style="width:15%">Sub_grade</th>
                                    <th style="width:10%">Rmta</th>
                                    <th style="width:10%">Store</th>
                                    <th style="width:10%">Qnty</th>
                                    <th style="width:20%">Remark</th>
        </tr>
        </thead>
  ';
  if(sqlsrv_num_rows($run1) > 0)
  {
  while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
  {
    // This Coding is for not show Item which is empty or less than zero balance
          /*$query2="SELECT SUM(qnty) as inw_qnty FROM inward_store where item='".$row['i_code']."'";
          $result2=sqlsrv_query($con,$query2);
          $row2=sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);

          $query3="SELECT SUM(qnty) as qnty_value FROM rm_issue where item_name='".$row['i_code']."' and issue_from = 'store'";
          $result3=sqlsrv_query($con,$query3);
          $row3=sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
          $qnty= $row2["inw_qnty"]-$row3['qnty_value'];

              if ($qnty <= 0) {
                continue;
              }*/
              // xxxxxx_END_xxxxxx
                    $sql3="SELECT item,s_code,m_code FROM rm_item where i_code='".$row['code']."'";
                    $run3=sqlsrv_query($con,$sql3);
                    $row3=sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);

                    $sql4="SELECT sub_grade FROM rm_s_grade where s_code='".$row3['s_code']."'";
                    $run4=sqlsrv_query($con,$sql4);
                    $row4=sqlsrv_fetch_array($run4, SQLSRV_FETCH_ASSOC);

                    $sql5="SELECT party_name FROM rm_party_master where pid='".$row['party']."'";
                    $run5=sqlsrv_query($con,$sql5);
                    $row5=sqlsrv_fetch_array($run5, SQLSRV_FETCH_ASSOC);
 
  $output .= '
  <tr class="font-italic" id="t_body">

    <td>'. $row5['party_name'] .'</td>
    <td>'. $row3['item'] .'</td>
    <td>'. $row4['sub_grade'] .'</td>
    
    <td><input type="text" name="rmta[]" value="'. $row['rmta'] .'" class="border-0" readonly id="t_body"></td>
    <td><input type="text" name="store_name[]" value="'. $row['store_name'] .'" class="border-0" readonly id="t_body"></td>

    <td><input type="text" name="i_code[]" value="'. $row['code'] .'" class="form-control"></td>
    <td><input type="text" name="s_code[]" value="'. $row3['s_code'] .'" class="form-control"></td>
    <td><input type="text" name="m_code[]" value="'. $row3['m_code'] .'" class="form-control"></td>
    <td><input type="text" name="pid[]" value="'. $row['party'] .'" class="form-control"></td>
    <td><input type="number" name="qnty[]" value="" class="form-control" autocomplete="off"></td>
    <td><input type="text" name="remark[]" class="form-control" autocomplete="off"></td>
    
  </tr>
  ';
  }
  }
  else
  {
  $output .= '
  <tr>
    <td colspan="11">No Records Found</td>
  </tr>
  ';
  }
$output .= '</table>';
echo $output;
?>
<script type="text/javascript">
      $(document).ready(function(){
        $('#employee_data td:nth-child(6)').hide();
        $('#employee_data td:nth-child(7)').hide();
        $('#employee_data td:nth-child(8)').hide();
        $('#employee_data td:nth-child(9)').hide();
   });
    
    </script>     