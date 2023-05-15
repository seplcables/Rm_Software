<?php
include('..\..\dbcon.php');
$type = $_GET['type'];
switch ($type) {

case 'copper':
$sql = "SELECT e.main_grade,c.party_name,b.sr_no,b.invoice_no,b.invoice_date,b.receive_date,f.sub_grade,g.item,a.rec_qnty,a.pur_rate,a.taxable_amt,a.total_tax_amt,
a.total_amt FROM inward_ind a
LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
LEFT OUTER JOIN rm_m_grade e on e.m_code= a.p_main_grade
LEFT OUTER JOIN rm_s_grade f on f.s_code= a.p_sub_grade
LEFT OUTER JOIN rm_item g on g.i_code= a.p_item
where p_main_grade=135 and receive_date >= '2021-04-01'
order by receive_date asc";
$run = sqlsrv_query($con,$sql);
$rows = array();
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
       $rows[] = $row;
}
  echo json_encode($rows);

break;

case 'aluminium':
$sql = "SELECT e.main_grade,c.party_name,b.sr_no,b.invoice_no,b.invoice_date,b.receive_date,f.sub_grade,g.item,a.rec_qnty,a.pur_rate,a.taxable_amt,a.total_tax_amt,
a.total_amt FROM inward_ind a
LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
LEFT OUTER JOIN rm_m_grade e on e.m_code= a.p_main_grade
LEFT OUTER JOIN rm_s_grade f on f.s_code= a.p_sub_grade
LEFT OUTER JOIN rm_item g on g.i_code= a.p_item
where p_main_grade=130 and receive_date >= '2021-04-01'
order by receive_date asc";
$run = sqlsrv_query($con,$sql);
$rows = array();
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
       $rows[] = $row;
}
  echo json_encode($rows);

break;

case 'pvc':
$sql = "SELECT e.main_grade,c.party_name,b.sr_no,b.invoice_no,b.invoice_date,b.receive_date,f.sub_grade,g.item,a.rec_qnty,a.pur_rate,a.taxable_amt,a.total_tax_amt,
a.total_amt FROM inward_ind a
LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
LEFT OUTER JOIN rm_m_grade e on e.m_code= a.p_main_grade
LEFT OUTER JOIN rm_s_grade f on f.s_code= a.p_sub_grade
LEFT OUTER JOIN rm_item g on g.i_code= a.p_item
where (p_main_grade=161 or p_main_grade=171) and receive_date >= '2021-04-01'
order by receive_date asc";
$run = sqlsrv_query($con,$sql);
$rows = array();
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
       $rows[] = $row;
}
  echo json_encode($rows);

break;

case 'gi_wire':
$sql = "SELECT e.main_grade,c.party_name,b.sr_no,b.invoice_no,b.invoice_date,b.receive_date,f.sub_grade,g.item,a.rec_qnty,a.pur_rate,a.taxable_amt,a.total_tax_amt,
a.total_amt FROM inward_ind a
LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
LEFT OUTER JOIN rm_m_grade e on e.m_code= a.p_main_grade
LEFT OUTER JOIN rm_s_grade f on f.s_code= a.p_sub_grade
LEFT OUTER JOIN rm_item g on g.i_code= a.p_item
where p_main_grade=164 and receive_date >= '2021-04-01'
order by receive_date asc";
$run = sqlsrv_query($con,$sql);
$rows = array();
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
       $rows[] = $row;
}
  echo json_encode($rows);

break;



default:
break;
}













?>