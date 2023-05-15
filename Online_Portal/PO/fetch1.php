<?php
include('..\..\dbcon.php');
if (isset($_POST['party'])) {
    $isreq = $_POST['isreq'];
    if ($isreq == 'yes') {
       $query = "SELECT distinct b.pid, b.party_name, b.p_code from requisition_rate a 
            left outer join rm_party_master b on a.party_id = b.pid
            left outer join Requisition_details c on c.rateIID = a.id
            WHERE party_name LIKE '%".$_POST["party"]."%' and a.iid not in(SELECT req_iid from po_entry_details where req_iid > 0)
            and a.id in (SELECT rateIID from Requisition_details where rateIID is not NULL )";
    }else{
        $query = "SELECT * FROM rm_party_master WHERE party_name LIKE '%".$_POST["party"]."%'";
    }
    $params = array();
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $run=sqlsrv_query($con,$query,$params,$options);
    $count=sqlsrv_num_rows($run);
    if($count<1){
       $response[] = array("label"=>"No Record Found"); 
    }else{
        $result = sqlsrv_query($con,$query);
            while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
                $pcode = $row['p_code'];
                $pid = $row['pid'];
                $response[] = array("label"=>$row['party_name'],"pcode"=>$pcode,"pid"=>$pid);
             }
    }
    
    echo json_encode($response);

	}
if (isset($_POST['pogen'])) {

    $query = "SELECT Emp_Name,name,department FROM online_portal_user WHERE name LIKE '%".$_POST["pogen"]."%'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
        $response[] = array("label"=>$row['Emp_Name'],"name"=>$row['name'],"dpmnt"=>$row['department']);
    }
    echo json_encode($response);

  }

  /*if (isset($_POST['ctype'])) {

    $query = "SELECT * FROM rm_category WHERE category LIKE '%".$_POST["ctype"]."%'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
        $response[] = array("label"=>$row['category'],"c_code"=>$row['c_code']);
    }
    echo json_encode($response);

  }*/

exit;
	?>