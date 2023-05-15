<?php
include('..\..\..\dbcon.php');

/*-----------------edit modal data load---------------------------*/

if (isset($_POST['editdata'])) {
	
	$sql2 = "SELECT issue_date,job_no,batch_code, SUM(amount) as rate,SUM(weight) as weight from rubber_issue where batch_code = '".$_POST['editdata']."' group by batch_code,issue_date,job_no";
	$run2 = sqlsrv_query($con,$sql2);
	$row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC); 


	$sql = "SELECT a.issue_date,a.batch_code,a.job_no,a.rmta,a.rate,a.weight,a.amount,b.item FROM rubber_issue a left outer join rm_item b on a.item = b.i_code where a.batch_code = '".$_POST['editdata']."'";
	$run =sqlsrv_query($con,$sql);
	$row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
	$output = '';
	$output .= '
		<div>
			<table class="table table-sm" font-size:16px;">
				<tr>
					<td style="width:70%;font-size:18px;" colspan="3"><b>Edit Rubber</b></td>
					<td align="right"><button type="submit" class="btn btn-primary">Update</button></td>
				</tr>
				<tr>
					<td style="width:10%;border-right:1px solid #d7d5d5;border-left:1px solid #d7d5d5;"><b>Datetest</b></td>
					<td style="width:10%;border-right:1px solid #d7d5d5;border-left:1px solid #d7d5d5;">
						<input type="date" name="editrubberdate" value="'.$row2['issue_date']->format('Y-m-d').'" style="width:300px;"/>
					</td>
					<td style="width:10%;border-right:1px solid #d7d5d5;border-left:1px solid #d7d5d5;"><b>Batch Code</b></td>
					<td style="width:30%;border-right:1px solid #d7d5d5;border-left:1px solid #d7d5d5;">
						<input type="text" name="editrubberbatchcode" value="'.$row2['batch_code'].'"  style="width:300px;"/>
					</td>
				</tr>
				<tr>
					<td style="width:10%;border-right:1px solid #d7d5d5;border-left:1px solid #d7d5d5;"><b>Job No</b></td>
					<td style="width:20%;border-right:1px solid #d7d5d5;border-left:1px solid #d7d5d5;">
						<input type="text" name="editrubberjobno" value="'.$row2['job_no'].'" style="width:300px;"/>
					</td>
					<td style="width:10%;border-right:1px solid #d7d5d5;border-left:1px solid #d7d5d5;"><b>Rate</b></td>
					<td style="width:20%;border-right:1px solid #d7d5d5;border-left:1px solid #d7d5d5;">
						<input type="text" name="editrubberamount" class="editrubberamount" value="'.$row2['rate'].'" style="width:300px;background-color:#f5f0f0;" readonly/>
					</td>
				</tr>
				<tr>
					<td style="width:10%;border-right:1px solid #d7d5d5;border-left:1px solid #d7d5d5;"><b>Weight</b></td>
					<td style="width:20%;border-right:1px solid #d7d5d5;border-left:1px solid #d7d5d5;">
						<input type="text" name="editrubbermainweight" class="editrubbermainweight" value="'.$row2['weight'].'"/ style="width:300px;background-color:#f5f0f0;" readonly/>
					</td>
					<td style="width:10%;border-right:1px solid #d7d5d5;border-left:1px solid #d7d5d5;"><b>Rs/Kg</b></td>
					<td style="width:20%;border-right:1px solid #d7d5d5;border-left:1px solid #d7d5d5;">
						<input type="text" name="editrsinkg" class="editrsinkg" value="'.round($row2['rate']/$row2['weight'],2).'" style="width:300px;background-color:#f5f0f0;" readonly/>
					</td>
				</tr>
			</table>
			
			<table class="table table-bordered table-sm" class="ml-3" font-size:15px;" id="table1">
				<tr class="bg-secondary text-center text-white">
					<th>Sr no</th>
					<th>Rmta</th>
					<th>Item</th>
					<th>Rate</th>
					<th>Weight</th>
					<th>Amount</th>
				</tr>
				';
				$srno = 1;
				$sql1 = "SELECT a.id,a.issue_date,a.batch_code,a.job_no,a.rmta,a.rate,a.weight,a.amount,b.item FROM rubber_issue a left outer join rm_item b on a.item = b.i_code where a.batch_code = '".$_POST['editdata']."'";
				//echo $sql1;
				$run1 =sqlsrv_query($con,$sql1);
				while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC)){
					
				$output .= '
				<tr class="font-italic">
					<td>'.$srno.'</td>
					<td>'.$row1['rmta'].'</td>
					<td>'.$row1['item'].'</td>
					<td align="center"><input type="text" name="edititemrate[]" class="edititemrate" value="'.$row1['rate'].'" style="border:1px solid #d7d5d5;"/></td>
					<td align="center"><input type="text" name="edititemweight[]" class="edititemweight" value="'.$row1['weight'].'" style="border:1px solid #d7d5d5;"/></td>
					<td align="center">
						<input type="text" name="edititemamt" class="edititemamt" value="'.$row1['amount'].'" style="background-color:#d7d7d7;" readonly/>
						<input type="hidden" name="itemid[]" value="'.$row1['id'].'" />
					</td>
				</tr>
				';
				$srno++; }
				$output .= '
			</table>
		</div>
	';

	echo $output;
}

?> 	
