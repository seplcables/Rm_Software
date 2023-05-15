 <?php
include('../../../dbcon.php');
$sql = "SELECT distinct a.sr_no,b.item from inward_ind a join rm_item b on a.p_item = b.i_code
where m_code in(144,148,161,163,171,174,178)";
$run = sqlsrv_query($con, $sql);
$rows = array();
while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
    $rows[] = $row['sr_no'].'-'.trim($row['item']);
}
  echo json_encode($rows);
  ?>