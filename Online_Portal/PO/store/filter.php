<?php
//filter.php
include('..\..\..\dbcon.php');
$output = '';
if(isset($_POST["fil"]))
{
$ii = $_POST['fil'];
$query = "SELECT * FROM rm_item WHERE item LIKE '%$ii%' and i_code in(select item from inward_store) order by s_code asc";
}
$result = sqlsrv_query($con,$query);
$params = array();
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$run1=sqlsrv_query($con,$query,$params,$options);
$output .= '
<table class="table table-bordered table-striped table-sm" id="employee_data">
  <thead>
    <tr class="bg-dark text-white text-center font-italic">
      <th style="width:20%">Item_name</th>
      <th style="width:16%">sub_grade</th>
      <th style="width:12%">main_grae</th>
      <th style="width:12%">Category</th>
      <th style="width:5%">Unit</th>
      <th style="width:10%">Qnty</th>
      <th style="width:25%">Remark</th>
    </tr>
  </thead>
  ';
  if(sqlsrv_num_rows($run1) > 0)
  {
  while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
  {
    // This Coding is for not show Item which is empty or less than zero balance
          $query2="SELECT SUM(qnty) as inw_qnty FROM inward_store where item='".$row['i_code']."'";
          $result2=sqlsrv_query($con,$query2);
          $row2=sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);

          $query3="SELECT SUM(qnty) as qnty_value FROM rm_issue where item_name='".$row['i_code']."' and issue_from = 'store'";
          $result3=sqlsrv_query($con,$query3);
          $row3=sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
          $qnty= $row2["inw_qnty"]-$row3['qnty_value'];

              if ($qnty <= 0) {
                continue;
              }
              // xxxxxx_END_xxxxxx
                    $sql4="SELECT sub_grade FROM rm_s_grade where s_code='".$row['s_code']."'";
                    $run4=sqlsrv_query($con,$sql4);
                    $row4=sqlsrv_fetch_array($run4, SQLSRV_FETCH_ASSOC);

                    $sql5="SELECT main_grade FROM rm_m_grade where m_code='".$row['m_code']."'";
                    $run5=sqlsrv_query($con,$sql5);
                    $row5=sqlsrv_fetch_array($run5, SQLSRV_FETCH_ASSOC);

                    $sql6="SELECT category FROM rm_category where c_code='".$row['c_code']."'";
                    $run6=sqlsrv_query($con,$sql6);
                    $row6=sqlsrv_fetch_array($run6, SQLSRV_FETCH_ASSOC);

                    $sql7="SELECT unit FROM inward_store where item='".$row['i_code']."'";
                    $run7=sqlsrv_query($con,$sql7);
                    $row7=sqlsrv_fetch_array($run7, SQLSRV_FETCH_ASSOC);
 
  $output .= '
  <tr class="font-italic">

    <td>'. $row['item'] .'</td>
    <td>'. $row4['sub_grade'] .'</td>
    <td>'. $row5['main_grade'] .'</td>
    <td>'. $row6['category'] .'</td>

    <td><input type="text" name="unit[]" value="'. $row7['unit'] .'" class="form-control"></td>
    <td><input type="text" name="i_code[]" value="'. $row['i_code'] .'" class="form-control"></td>
    <td><input type="text" name="s_code[]" value="'. $row['s_code'] .'" class="form-control"></td>
    <td><input type="text" name="m_code[]" value="'. $row['m_code'] .'" class="form-control"></td>
    <td><input type="text" name="c_code[]" value="'. $row['c_code'] .'" class="form-control"></td>
    <td><input type="text" name="qnty[]" value="" class="form-control" autocomplete="off"></td>
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