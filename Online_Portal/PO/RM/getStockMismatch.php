<?php
//filter.php
include('..\..\..\dbcon.php');
$ope_date = $_POST['ope_date'];
$closing_date = $_POST['closing_date'];
$output = '';

$query = "SELECT distinct a.item as icode,a.store_name,a.rmta, b.item,c.sub_grade from inward_rm a
LEFT OUTER JOIN rm_item b on a.item = b.i_code
LEFT OUTER JOIN rm_s_grade c on a.sub_grade = c.s_code
WHERE receive_dte BETWEEN '$ope_date' AND '$closing_date' order by sub_grade desc";
$result = sqlsrv_query($con,$query);
$params = array();
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$run1=sqlsrv_query($con,$query,$params,$options);
$output .= '
<table class="table table-bordered table-striped table-sm" id="employee_data">
        <tr class="bg-dark text-white text-center font-italic">
         <th width="16%">Sub_Grade</th>
          <th width="24%">Grade</th>
          <th width="12%">Store</th>
          <th width="8%">Rmta</th>
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
      $rmta = $row['rmta'];
      $store = $row['store_name'];

      $sqla="SELECT sum(qnty) as opening FROM inward_rm where rmta='$rmta' and store_name='$store' and receive_dte>='$ope_date' and receive_dte<'$closing_date' and come_from = 'opening'";
      $runa=sqlsrv_query($con,$sqla);
      $rowa=sqlsrv_fetch_array($runa, SQLSRV_FETCH_ASSOC);

      $sqlb="SELECT sum(qnty) as inward FROM inward_rm where rmta='$rmta' and store_name='$store' and receive_dte>'$ope_date' and receive_dte<='$closing_date' and come_from = 'direct'";
      $runb=sqlsrv_query($con,$sqlb);
      $rowb=sqlsrv_fetch_array($runb, SQLSRV_FETCH_ASSOC);

      $sqlc="SELECT sum(issue_qnty) as issue FROM pvc_issue where rmta='$rmta' and store_name='$store' and issue_date>'$ope_date' and issue_date<='$closing_date'";
      $runc=sqlsrv_query($con,$sqlc);
      $rowc=sqlsrv_fetch_array($runc, SQLSRV_FETCH_ASSOC);

      $sqld="SELECT sum(qnty) as closing FROM inward_rm where rmta='$rmta' and store_name='$store' and come_from = 'opening' and receive_dte ='$closing_date'";
      $rund=sqlsrv_query($con,$sqld);
      $rowd=sqlsrv_fetch_array($rund, SQLSRV_FETCH_ASSOC);

      $diff = $rowd["closing"] - ($rowa["opening"] + $rowb["inward"] - $rowc["issue"]);

  $output .= '
  <tr>
    <td>'. $row['sub_grade'] .'</td>
    <td>'. $row["item"] .'</td>
    <td>'. $row["store_name"] .'</td>
    <td>'. $row["rmta"] .'</td>
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