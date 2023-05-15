<?php
include('..\..\dbcon.php');
if (isset($_POST['po'])) {

    $query = "SELECT id,po_no,p_days,party,party_name,po_gen_by,depart_ment FROM po_entry_head a
    left outer join rm_party_master b on b.pid = a.party WHERE po_no LIKE '%".trim($_POST["po"])."%'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
    	$poid = $row['id'];
        $response[] = array("label"=>$row['po_no'],"poid"=>$poid,"pdays"=>$row['p_days'],"party"=>$row['party_name'],"pcode"=>$row['party'],"genby"=>$row['po_gen_by'],"dept"=>$row['depart_ment']);
    }

    echo json_encode($response);

	}
?>
