<?php
$x = $_POST['x'];
?>
<table id="mytable" align="center" border="1" class="border-danger border-bottom-0" style="width:90%; margin-top:10px;" >
	<tr class="bg-primary text-white text-center">
		<th>Receive_date</th>
		<th>Sr_No</th>
		<th>Party</th>
		<th>Invoice_No</th>
		<th>Edit</th>
	</tr>
	<?php
	include('..\..\dbcon.php');
	$sql="SELECT * FROM inward_com where sr_no like '%$x%' or mat_from_party like '%$x%' or invoice_no like '%$x%'";
	$params = array();
	$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
	$ru=sqlsrv_query($con,$sql,$params,$options);
	$ro=sqlsrv_num_rows($ru);
	if($ro<1)
	{
	?>
	<tr class="text-center">
		<td colspan="5">No Data Found!!!</td>
	</tr>
	<?php
	}
	else {
	$run=sqlsrv_query($con,$sql);
	while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
	
	?>
	<tr class="text-center font-italic font-weight-bold trbody">
		
		<td><?php echo $row['receive_date']->format('d/m/Y');  ?></td>
		<td><?php echo $row['sr_no'];  ?></td>
		<td><?php echo $row['mat_from_party'];  ?></td>
		<td><?php echo $row['invoice_no'];  ?></td>
		<td><a href="purchase_entry_edit.php?id=<?php echo $row['sr_no']; ?>" class="btn btn-info"><i class="fa fa-edit"></i></a></td>
	</tr>
	<?php
	}
	}
	?>
</table>