<?php
session_start();
include('..\..\dbcon.php');
date_default_timezone_set('Asia/Kolkata');

    /*$sql = "SELECT a.id,a.iid,format(b.po_date,'dd-MMM-yyyy') as poDate,e.party_name,b.po_gen_by,
    c.item,d.main_grade,a.unit,a.qnty,format(b.mat_req_date,'dd-MMM-yyyy') as reqDate,DATEDIFF(day, b.mat_req_date,GETDATE()) AS DateDiff from po_entry_details a
			left outer join po_entry_head b on a.iid = b.id
			left outer join rm_item c on a.item_code = c.i_code
			left outer join rm_m_grade d on c.m_code = d.m_code
			left outer join rm_party_master e on b.party = e.pid
			where a.id not in(select iid from inward_ind) and b.po_date > '2021-06-01' and DATEDIFF(day, b.mat_req_date,GETDATE()) > 0 
			and isCancle is NULL AND b.po_gen_by = '".$_SESSION['oid']."' order by a.iid desc";*/
		$rows = [];	

		$sql = "SELECT distinct a.id, format(a.po_date,'dd-MMM-yyyy') as poDate, b.party_name,a.po_gen_by,format(a.mat_req_date,'dd-MMM-yyyy') as reqDate,DATEDIFF(day, a.mat_req_date,GETDATE()) AS DateDiff from po_entry_head a left outer join rm_party_master b on b.pid = a.party where  a.po_date > '2021-06-01' and DATEDIFF(day, a.mat_req_date,GETDATE()) > 0 AND a.po_gen_by = '".$_SESSION['oid']."' order by a.id desc";
		$run = sqlsrv_query($con,$sql);
		while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
		{
			$sql1 = "SELECT COUNT(iid) as count from po_entry_details where iid = '".$row['id']."' and (isCancle IS NULL AND id NOT IN(SELECT iid from inward_ind))";
			$run1 = sqlsrv_query($con,$sql1);
			$row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
			//echo $row['id']."-".$row1['count']."<br/>";

			if ($row1['count'] == 0)
			{
				continue;
			}
		   $rows[] = $row;
		}

  echo json_encode($rows);




?>