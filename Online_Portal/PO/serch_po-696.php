<?php
include('..\..\dbcon.php');
date_default_timezone_set('Asia/Kolkata');
$lastDate = date('Y-m-d', strtotime('-60 days'));

$sql = "SELECT distinct a.id,a.po_date,a.po_gen_by,b.party_name,a.depart_ment,a.isPurchaseEntry,a.po_value from po_entry_head a
LEFT OUTER JOIN rm_party_master b on a.party = b.pid left outer join po_entry_details c on c.iid = a.id where  p_terms != 'cancle' and po_date >= '$lastDate' and c.plant ='696' order by id desc";
$run = sqlsrv_query($con,$sql);
$rows = array();
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{


/*$qrypur="SELECT count(*) as cnt from po_entry_details a
INNER JOIN inward_ind b on a.id = b.iid
where a.iid='".$row['id']."'";
$runpur=sqlsrv_query($con,$qrypur);
$rowpur=sqlsrv_fetch_array($runpur, SQLSRV_FETCH_ASSOC);
$rows[] = array("data"=>$row,"pur"=>$rowpur['cnt']);*/
$rows[] = $row;

}
echo json_encode($rows);
?>