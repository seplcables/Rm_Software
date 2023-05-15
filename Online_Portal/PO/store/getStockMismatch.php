<?php
//filter.php
include('..\..\..\dbcon.php');
$ope_date = $_POST['ope_date'];
$closing_date = $_POST['closing_date'];
$output = '';

$query = "SELECT distinct a.item as icode, b.item,c.sub_grade,d.main_grade,e.category from inward_store a
LEFT OUTER JOIN rm_item b on a.item = b.i_code
LEFT OUTER JOIN rm_s_grade c on b.s_code = c.s_code
LEFT OUTER JOIN rm_m_grade d on b.m_code = d.m_code
LEFT OUTER JOIN rm_category e on b.c_code = e.c_code 
WHERE receive_dte BETWEEN '$ope_date' AND '$closing_date'";
$result = sqlsrv_query($con,$query);
$params = array();
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$run1=sqlsrv_query($con,$query,$params,$options);
$output .= '
<table class="table table-bordered table-striped table-sm" id="employee_data">
        <tr class="bg-dark text-white text-center font-italic">
         <th width="10%">Category</th>
          <th width="14%">Main_Grade</th>
          <th width="16%">Sub_Grade</th>
          <th width="20%">Item</th>
          <th width="8%">ope(A)</th>
          <th width="8%">Inw(B)</th>
          <th width="8%">Iss(C)</th>
          <th width="8%">Clo(D)</th>
          <th width="8%">D-(A+B-C)</th>
        </tr>
  ';
  if(sqlsrv_num_rows($run1) > 0)
  {
  while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
  {
      $item = $row['icode'];

      $sqla="SELECT sum(qnty) as opening FROM inward_store where item='$item' and receive_dte>='$ope_date' and receive_dte<'$closing_date' and come_from = 'opening'";
      $runa=sqlsrv_query($con,$sqla);
      $rowa=sqlsrv_fetch_array($runa, SQLSRV_FETCH_ASSOC);

      $sqlb="SELECT sum(qnty) as inward FROM inward_store where item='$item' and receive_dte>'$ope_date' and receive_dte<='$closing_date' and come_from = 'inward'";
      $runb=sqlsrv_query($con,$sqlb);
      $rowb=sqlsrv_fetch_array($runb, SQLSRV_FETCH_ASSOC);

      $sqlc="SELECT sum(qnty) as issue FROM rm_issue where item_name='$item' and issue_date>'$ope_date' and issue_date<='$closing_date' and issue_from = 'store'";
      $runc=sqlsrv_query($con,$sqlc);
      $rowc=sqlsrv_fetch_array($runc, SQLSRV_FETCH_ASSOC);

      $sqld="SELECT sum(qnty) as closing FROM inward_store where item='$item' and come_from = 'opening' and receive_dte ='$closing_date'";
      $rund=sqlsrv_query($con,$sqld);
      $rowd=sqlsrv_fetch_array($rund, SQLSRV_FETCH_ASSOC);

      $diff = $rowd["closing"] - ($rowa["opening"] + $rowb["inward"] - $rowc["issue"]);

  $output .= '
  <tr>
    <td>'. $row['category'] .'</td>
    <td>'. $row['main_grade'] .'</td>
    <td>'. $row['sub_grade'] .'</td>
    <td>'. $row["item"] .'</td>
    <td>'. $rowa["opening"] .'</td>
    <td>'. $rowb["inward"] .'</td>
    <td>'. $rowc["issue"] .'</td>
    <td>'. $rowd["closing"] .'</td>
    <td>'. $diff .'</td>

  </tr>
  ';
  }
  }
  else
  {
  $output .= '
  <tr>
    <td colspan="8">No Records Found</td>
  </tr>
  ';
  }
$output .= '</table>';
echo $output;
?>