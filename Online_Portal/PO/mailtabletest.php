<?php

include('../../dbcon.php');
include('../../package/pdf.php');
require '../../package/phpmailer/class.phpmailer.php';
  
	$sql = "SELECT top 15 a.iid,format(b.po_date,'dd-MMM-yy') as poDate,e.party_name,b.po_gen_by,
    c.item,d.main_grade,a.unit,a.qnty,format(b.mat_req_date,'dd-MMM-yy') as reqDate,DATEDIFF(day, b.mat_req_date,GETDATE()) AS DateDiff from po_entry_details a
			left outer join po_entry_head b on a.iid = b.id
			left outer join rm_item c on a.item_code = c.i_code
			left outer join rm_m_grade d on c.m_code = d.m_code
			left outer join rm_party_master e on b.party = e.pid
			where a.id not in(select iid from inward_ind) and b.po_date > '2021-06-01' and DATEDIFF(day, b.mat_req_date,GETDATE()) > 0 and isCancle is NULL and b.po_gen_by = 'parita'
            order by b.po_gen_by asc";
    $run = sqlsrv_query($con,$sql);
      
	$output = '
	<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  padding:10px;
  font-size:10px;	

}

#customers td, #customers th {
  border: 2px solid #efc1c9;
  padding: 6px;
  text-align: center;
  font-size:12px;
}


#customers tr:nth-child(even){background-color: #D6EEEE;}


tr:hover {background-color: #04aaaa;}
#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: center;
  background-color: #04aaaa;
  color: white;
}

</style>

<table style="width: 100%; padding:10px;">
<tr>
<th style="text-align:left;font-size:18px;">Pending List </th>
<th style="text-align:right;font-size:18px;">'. date("d-M-y") .'</th>
</tr>


		<table id="customers">

			<tr>
				        <th style="width:20px;">PO_No</th>
                        <th style="width:60px;">PO_DATE</th>
                        <th>PARTY NAME</th>
                        <th style="width:70px;">PO_GEN_BY</th>
                        <th>ITEM</th>
                        <th style="width:60px;">UNIT</th>
                        <th style="width:70px;">QNTY</th>
                        <th style="width:70px;">REQ_DATE</th>
                        <th style="width:20px;">OVER_DUE</th>
			</tr>
	';
	while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
	{
		$output .= '
			<tr>
				<td>'.$row["iid"].'</td>
				<td>'.$row["poDate"].'</td>
				<td>'.$row["party_name"].'</td>
				<td>'.$row["po_gen_by"].'</td>
				<td>'.$row["item"].'</td>
				<td>'.$row["unit"].'</td>
				<td>'.$row["qnty"].'</td>
				<td>'.$row["reqDate"].'</td>
				<td>'.$row["DateDiff"].'</td>
				
			</tr>
		';
	}
	$output .= '
		</table>
	';

	echo $output;

?>






