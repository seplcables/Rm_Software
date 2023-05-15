<?php
$output = '  
<table align="center" class="table table-bordered table-striped table-sm" id="receive" style="text-align: center;">
  <thead class="bg-primary text-white">
    <tr>
      <th>SrNo</th>
      <th>Party Name</th>
    </tr>
  </thead>
  <tbody id="receive">
    ';
    
    include('../../../dbcon.php');
    $sql1 = "SELECT distinct party_name from Requisition_details a
			inner join Requisition_head b on a.iid=b.id
			inner join Requisition_rate c on c.iid=a.id
			inner join rm_party_master d on c.party_id=d.pid
			where b.id = '".$_POST['id']."'";
    $run1 = sqlsrv_query($con,$sql1);
    $count = 0;
    while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
    {
    $count++; 
    $output .= '
    <tr>
      <td name="sr" id="sr">'.$count.'</td>
      <td>'.$row1['party_name'].'</td>
    </tr>
    ';
    }
    
    $output .= '
  </tbody>
</table>

</div>
';
echo $output;
?>