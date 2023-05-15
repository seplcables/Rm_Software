<?php
include('..\..\..\dbcon.php');
if(isset($_POST['id'])){
	$sql = "SELECT a.id,b.item,a.pur_rate,a.rec_qnty,b.i_code,a.sr_no FROM inward_ind a
  LEFT OUTER JOIN rm_item b on a.p_item = b.i_code where b.m_code = '174' and a.sr_no = '".$_POST['id']."'";
  	$params = array();
	$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
	$run1 =sqlsrv_query($con,$sql,$params,$options);
	$row1 =sqlsrv_num_rows($run1);

	$output = '';
	$output .= '
		<div>
			<table border="1" class="text-center ml-3" font-size:15px;" id="table1">
				<tr class="bg-secondary text-white">
					<th style="width:10%;">Sr no</th>
					<th style="width:15%;">Rmta</th>
					<th style="width:45%;">Item</th>
					<th style="width:15%;">Quantity</th>
					<th style="width:15%;">Rate</th> 
				</tr>
				';
				$srno = 1;
				$run =sqlsrv_query($con,$sql);
				while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)){
					if($row1<2){
						$rmta = $row['sr_no'];
					}else{
						$rmta = $row['sr_no'].'/'.$srno;
					}
				$output .= '
				<tr class="text-center font-italic">
					<td>'.$srno.'<input type="hidden" name="id[]" value="'.$row['id'].'"></td>
					<td><input type="text" name="rmta[]" value="'.$rmta.'"></td>
					<td>'.$row['item'].'<input type="hidden" name="icode[]" value="'.$row['i_code'].'"></td>
					<td><input type="text" name="qnty[]" value="'.$row['rec_qnty'].'"></td>
					<td><input type="text" name="rate[]" value="'.$row['pur_rate'].'"></td>
				</tr>
				';
				$srno++; }
				$output .= '
			</table>
		</div>
	';

	echo $output;

}


/*------------------------------ show modal of issue_report page ------------------------------*/
if (isset($_POST['batch'])) {
	
	$sql = "SELECT a.issue_date,a.batch_code,a.job_no,a.rmta,a.rate,a.weight,a.amount,b.item FROM rubber_issue a left outer join rm_item b on a.item = b.i_code where a.batch_code = '".$_POST['batch']."'";
	$run =sqlsrv_query($con,$sql);
	$row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
	$output = '';
	$output .= '
		<div>
			<table class="table table-bordered table-sm" font-size:16px;">
				<tr>
					<td style="width:10%;"><b>Date</b></td>
					<td style="width:20%;">'.$row['issue_date']->format('d-M-Y').'</td>
					<td style="width:10%;"><b>Batch Code</b></td>
					<td style="width:30%;">'.$row['batch_code'].'</td>
					<td style="width:10%;"><b>Job No</b></td>
					<td style="width:20%;">'.$row['job_no'].'</td>
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
				$sql1 = "SELECT a.issue_date,a.batch_code,a.job_no,a.rmta,a.rate,a.weight,a.amount,b.item FROM rubber_issue a left outer join rm_item b on a.item = b.i_code where a.batch_code = '".$_POST['batch']."'";
				$run1 =sqlsrv_query($con,$sql1);
				while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC)){
					
				$output .= '
				<tr class="font-italic">
					<td>'.$srno.'</td>
					<td>'.$row1['rmta'].'</td>
					<td>'.$row1['item'].'</td>
					<td>'.$row1['rate'].'</td>
					<td>'.$row1['weight'].'</td>
					<td>'.$row1['amount'].'</td>
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
