 <?php
include('../../../dbcon.php');
$sql = "SELECT distinct party_name from inward_com a join inward_ind b on a.sr_no = b.sr_no and a.receive_at = b.receive_at
join rm_item c on b.p_item = c.i_code
join rm_party_master d on d.pid = a.mat_from_party
where m_code in(144,148,161,163,171,174,178)";
$run = sqlsrv_query($con, $sql);
$rows = array();
while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
    $rows[] = $row['party_name'];
}
  echo json_encode($rows);
  ?>