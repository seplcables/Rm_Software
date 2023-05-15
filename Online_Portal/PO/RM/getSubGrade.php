<?php


include('../../../dbcon.php');
$grade = $_POST['grade'];
$rmta = $_POST['rmta'];

$sql = "SELECT d.party_name,d.pid,c.i_code,e.sub_grade from inward_com a left outer join inward_ind b on a.sr_no = b.sr_no and a.receive_at = b.receive_at
left outer join rm_item c on b.p_item = c.i_code
left outer join rm_party_master d on d.pid = a.mat_from_party
left outer join rm_s_grade e on e.s_code = c.s_code
where a.sr_no = '$rmta' and c.item like '%".$grade."%'";

$run = sqlsrv_query($con, $sql);
$row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
  echo json_encode(array('i_code' =>$row['i_code'],'party_name' =>$row['party_name'],'sub_grade' =>$row['sub_grade'],"pid"=>$row['pid']));
