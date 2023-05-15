<?php
$x = $_POST['x'];
?>
<table align="center" border="1" style="width:80%; margin-top:10px;" >
<tr class="bg-primary text-white text-center">
<th>Date</th>
<th>Po_No</th>
<th>Party</th>
<th>Item_Description</th>
<th>PKG</th>
<th>Qnty</th>
<th>PDF</th>
<th>Inward</th>
</tr>
						<?php
						include('..\..\dbcon.php');
						$sql="SELECT * from po_entry where po_no like '%$x%' or party like '%$x%'";
						$params = array();
						$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
						$ru=sqlsrv_query($con,$sql,$params,$options);
						$ro=sqlsrv_num_rows($ru);
						if($ro<1)
						{
							?>
								<tr class="text-center">
									<td colspan="8">No Data Found!!!</td>
								</tr>
								<?php
						}
						else {
						$run=sqlsrv_query($con,$sql);
						$row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
						?>
	<tr class="text-center font-italic font-weight-bold trbody">
			<td><?php echo $row['po_date']->format('d-M-Y');  ?></td>
			<td><?php echo $row['po_no'];  ?></td>
			<td><?php echo $row['party'];  ?></td>
			<td><?php echo $row['item_desc'];  ?></td>
			<td><?php echo $row['pkg'];  ?></td>
			<td><?php echo $row['qnty'];  ?></td>
			<td><a href="pdfdata.php?sid=<?php echo $row['po_no']; ?>" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a></td>
			<td><a href="inward_field.php?sid=<?php echo $row['id']; ?>" class="btn btn-info"><i class="fa fa-download"></i></a></td>
			
	</tr>					
						<?php
						while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
						
						?>
	<tr class="text-center font-italic font-weight-bold trbody">
			<td><?php echo $row['po_date']->format('d-M-Y');  ?></td>
			<td><?php echo $row['po_no'];  ?></td>
			<td><?php echo $row['party'];  ?></td>
			<td><?php echo $row['item_desc'];  ?></td>
			<td><?php echo $row['pkg'];  ?></td>
			<td><?php echo $row['qnty'];  ?></td>
			<td><a href="pdfdata.php?sid=<?php echo $row['po_no']; ?>" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a></td>
			<td><a href="inward_field.php?sid=<?php echo $row['id']; ?>" class="btn btn-info"><i class="fa fa-download"></i></a></td>
			
	</tr>
						<?php
						}
					}
						?>
</table>