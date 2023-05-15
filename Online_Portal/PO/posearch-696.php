<?php
include('..\..\dbcon.php');
if (isset($_POST['po'])) {

//     $query = "SELECT distinct a.id,a.po_date,a.po_gen_by,b.party_name,a.depart_ment,a.isPurchaseEntry,a.po_value from po_entry_head a
// LEFT OUTER JOIN rm_party_master b on a.party = b.pid left outer join po_entry_details c on c.iid = a.id left join inward_ind d on d.iid = c.id where  p_terms != 'cancle' and po_date >= '$lastDate' and d.receive_at ='696_plant' order by id desc";

    $query = "SELECT a.id,a.po_no,a.p_days,a.party,b.party_name,a.po_gen_by,a.depart_ment FROM po_entry_head a
    left outer join rm_party_master b on b.pid = a.party left outer join po_entry_details c on c.iid = a.id WHERE po_no LIKE '%".trim($_POST["po"])."%' AND c.plant ='696'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
    	$poid = $row['id'];
        $response[] = array("label"=>$row['po_no'],"poid"=>$poid,"pdays"=>$row['p_days'],"party"=>$row['party_name'],"pcode"=>$row['party'],"genby"=>$row['po_gen_by'],"dept"=>$row['depart_ment']);
    }

    echo json_encode($response);

	}
?>
