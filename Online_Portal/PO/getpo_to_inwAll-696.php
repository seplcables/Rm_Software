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
			where a.id not in(select iid from inward_ind) and b.po_date > '2021-06-01' and DATEDIFF(day, b.mat_req_date,GETDATE()) > 0 and isCancle is NULL order by a.iid desc";*/

//$sql = "SELECT distinct a.id, c.id as poid,format(a.po_date,'dd-MMM-yyyy') as poDate,b.party_name,a.po_gen_by,format(a.mat_req_date,'dd-MMM-yyyy') as reqDate,DATEDIFF(day, a.mat_req_date,GETDATE()) AS DateDiff from po_entry_head a left outer join rm_party_master b on b.pid = a.party left outer join po_entry_details c on c.iid = a.id where  a.po_date > '2021-06-01' and DATEDIFF(day, a.mat_req_date,GETDATE()) > 0 and c.id NOT IN(select iid from inward_ind) order by a.id desc";

//$sql = "SELECT distinct a.id, format(a.po_date,'dd-MMM-yyyy') as poDate, b.party_name,a.po_gen_by,format(a.mat_req_date,'yyyy-MM-dd') as reqDate, DATEDIFF(day, format(a.mat_req_date,'yyyy-MM-dd'),GETDATE()) AS DateDiff from po_entry_head a left outer join rm_party_master b on b.pid = a.party where  a.po_date > '2021-06-01' and DATEDIFF(day, format(a.mat_req_date,'yyyy-MM-dd'),GETDATE()) > 0 order by a.id desc";

$sql = "SELECT distinct a.id, format(a.po_date,'dd-MMM-yyyy') as poDate, b.party_name,a.po_gen_by,format(a.mat_req_date,'yyyy-MM-dd') as reqDate,
 DATEDIFF(day, format(a.mat_req_date,'yyyy-MM-dd'),GETDATE()) AS DateDiff from po_entry_head a left outer join rm_party_master b 
 on b.pid = a.party left outer join po_entry_details c on c.iid = a.id where  a.po_date > '2021-06-01' and DATEDIFF(day, format(a.mat_req_date,'yyyy-MM-dd'),GETDATE()) > 0 and c.isCancle IS NULL and c.id Not IN (SELECT iid from inward_ind) and plant = '696' order by a.id desc";
$run = sqlsrv_query($con,$sql);
$output = '';
$output .='
	<thead>
        <tr id="trow">
            <th>poNo</th>
            <th>poDate</th>
            <th>partyName</th>
            <th>poGenBy</th>
            <th>reqDate</th>
            <th>overDue</th>
            <th>Edit</th> 
        </tr>
    </thead>
    <tbody>
';
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
    // $sql1 = "SELECT COUNT(id) as count from po_entry_details where iid = '".$row['id']."' and (isCancle IS NULL AND id NOT IN(SELECT iid from inward_ind))";
    // $run1 = sqlsrv_query($con,$sql1);
    // $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
    // //echo $row['id']."-".$row1['count']."<br/>";

    // if ($row1['count'] == 0)
    // {
    //     continue;
    // }

	$output .='		
     <tr>
     		<td>'.$row['id'].'</td>
     		<td>'.$row['poDate'].'</td>
     		<td>'.$row['party_name'].'</td>
     		<td>'.$row['po_gen_by'].'</td>
     		<td>'.$row['reqDate'].'</td>
     		<td>'.$row['DateDiff'].'</td>
     		<td><button class="btn btn-sm btn-danger canclePo" id="'.$row['id'].'">Cancel</button></td>
     </tr>
	';
}
  echo ($output);

?>
<script type="text/javascript">

        $(document).ready(function() 
        {
        $('#example').DataTable( {
            "processing": true,
            "dom": 'Bfrtip',
            "destroy": true,
        
        "columns": [
     		null,
            null,
            null,
            null,
            null,
            null,
            null
        ],
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength', 'excel',
                {
                    text: 'HOME',"className": 'HOME',
                    action: function () { 
                        window.open("../dashboard.php","_self")
                    }
                },
                {
                    text: 'BACK',"className": 'Back',
                    action: function () { 
                        window.open("po_to_inward-696.php","_self")
                    }
                },
                
        ]
        
        } );
        });
</script>