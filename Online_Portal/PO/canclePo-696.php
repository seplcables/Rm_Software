<?php
include('..\..\dbcon.php');
if(isset($_POST['id']))
{
	$sql = "SELECT a.id,a.iid,a.qnty,a.unit,a.rate,b.item,a.basic_rate from po_entry_details a left outer join rm_item b on a.item_code = b.i_code where a.id NOT IN(select iid from inward_ind) and a.isCancle IS NULL and a.plant = '696' and a.iid = '".$_POST['id']."'";
	$run = sqlsrv_query($con,$sql);
	
	$output = '';

	$output .= '
		<div>
			<table border="1" class="text-center ml-3" style="width:95%; font-size:15px;" id="table1">
				<tr class="bg-secondary text-white">
					<th>Item</th>
					<th>Quantity</th>
					<th>Unit</th>
					<th>Rate</th>
					<th>Basic Rate</th>
					<th>Remark</th>
					<th><input type="checkbox" name="" class="largerCheckbox term" onclick="toggle(this);"></th>
				</tr>
				';
				while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
				{
				$output .= '
				<tr class="text-center font-italic">
					<td>'.$row['item'].'</td>
					<td>'.$row['qnty'].'</td>
					<td>'.$row['unit'].'</td>
					<td>'.$row['rate'].'</td>
					<td>'.$row['qnty']*$row['rate'].'</td>
					<td><input type="text" name="remark[]" class="remark w-100" autocomplete="off"></td>
					<td><input type="checkbox" name="idchk[]" id="idchk" class="largerCheckbox chkNote term" value="'.$row['id'].'"></td>
				</tr>
				';
				}
				$output .= '
			</table>
		</div>
	';

	echo $output;

}

?> 	
