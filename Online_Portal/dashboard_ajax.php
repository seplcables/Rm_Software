<?php
session_start();
include('../dbcon.php');
if(isset($_SESSION['oid'])) 
{
	if($_GET['status'] == 0)
	{
		$year = $_POST['year'];
		$stdm = "-04-01";
		$enddm = "-03-31";
		$c_code = $_POST['ccode'];

		$startdtnew = date("Y");


?>
<style type="text/css">
	.hidden
	{
		color: white;

	}
	th, td
	{	
		padding: 2px;
		text-align: center;
		border: 1px solid black;
	}

	
	.tags {
	  position: relative;
	  cursor: pointer;

	}

	.tags:hover:after 
	{
	  background: #eff1f2;
	  font-weight: bold;
	  border-radius: 5px;
	  top: 30px;
	  content: attr(gloss);
	  left: 1%;
	  padding: 5px;
	  position: absolute;
	  z-index: 98;
	  width: 100%;
	}
}

	
</style>
<table cellpadding="0" cellspacing="0" style="width:1400px;" id="civilitem">
    <thead>
	    <tr>
	    	<th>
	    		Category
	    	</th>
	    	<th>
	    		Main Grade
	    	</th>
	    	<th>
	    		Sub Grade
	    	</th>
	    	<?php
	    	for($i=$year; $i <= $startdtnew; $i++)
			{
	    	?>
	    	<th style="text-align: center;">
	    		<?php echo "Qnty - ".$i; ?>
	    	</th>
	    	<?php } ?>
	    	<?php
	    	for($i=$year; $i <= $startdtnew; $i++)
			{
	    	?>
	    	<th style="text-align: right;">
	    		<?php echo "Value - ".$i; ?>
	    	</th>
	    	<?php } ?>
	    </tr>
    </thead>
    <tbody>
    <?php 
    $prevval = '';
    $prevval1 = '';
    $sql1 = "SELECT DISTINCT a.c_code, a.category, b.m_code, b.main_grade, c.s_code, c.sub_grade  FROM rm_category a left join rm_m_grade b on a.c_code = b.c_code left join rm_s_grade c on b.m_code = c.m_code where a.c_code = '".$c_code."' order by a.c_code ASC ";
    $run1=sqlsrv_query($con,$sql1);
    while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
    {
    	$curval = $row1['category'];
    	$curval1 = $row1['main_grade'];
    	if($prevval == $curval)
    	{
    		$text = 'hidden';
    	}
    	else
    	{
    		$text = '';
    	}

    	if($prevval1 == $curval1)
    	{
    		$text1 = 'hidden';
    	}
    	else
    	{
    		$text1 = '';
    	}
    ?>
    <tr>
    	<td class="<?php echo $text; ?>">
    		<?php
				echo $row1['category'];
			?>
    	</td>
    	<td class="<?php echo $text1; ?>">
    		<?php
				echo $row1['main_grade'];
			?>
    	</td>
    	<td>
    		<?php
				echo $row1['sub_grade'];
			?>
    	</td>
    	<?php 
		for ($i=$year; $i <= $startdtnew; $i++) 
		{  
    		$start_date = date('Y-m-d',strtotime(($i).'-04-01'));
		    $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));

		    $sql2 = "SELECT sum(a.rec_qnty) as qnty from inward_ind a, inward_com b, rm_category c, rm_m_grade d, rm_s_grade e, rm_item f where a.sr_no = b.sr_no and a.receive_at = b.receive_at and a.p_item = f.i_code and c.c_code = d.c_code and c.c_code = e.c_code and c.c_code = f.c_code and	d.m_code = e.m_code and d.m_code = f.m_code and	e.s_code = f.s_code  and e.m_code = '".$row1['m_code']."' and e.s_code = '".$row1['s_code']."'  and b.receive_date between '".$start_date."' and '".$end_date."'";
			$run2=sqlsrv_query($con,$sql2);
            $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
    	?>
		<td style="text-align: center;" class="qntyin<?php echo $i; ?> createbtnitem" data-bs-toggle="modal" name="createbtnitem" id="createbtnitem" data-id="<?php echo $row1['s_code']."~".$start_date."~".$end_date."~".$row1['sub_grade']; ?>">
		<?php echo round($row2['qnty']); ?></td>
    	<?php 
    		} 
    		for ($i=$year; $i <= $startdtnew; $i++) 
    		{  
	    		$start_date = date('Y-m-d',strtotime(($i).'-04-01'));
			    $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));

			    $sql2 = "SELECT sum(a.taxable_amt) as pur_rate from inward_ind a, inward_com b, rm_category c, rm_m_grade d, rm_s_grade e, rm_item f where a.sr_no = b.sr_no and a.receive_at = b.receive_at and a.p_item = f.i_code and c.c_code = d.c_code and c.c_code = e.c_code and c.c_code = f.c_code and	d.m_code = e.m_code and d.m_code = f.m_code and	e.s_code = f.s_code  and e.m_code = '".$row1['m_code']."' and e.s_code = '".$row1['s_code']."'  and b.receive_date between '".$start_date."' and '".$end_date."'";
				$run2=sqlsrv_query($con,$sql2);
	            $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
    	?>
    	<td style="text-align: right;" class="ratein<?php echo $i; ?> createbtnitem" data-bs-toggle="modal" name="createbtnitem" id="createbtnitem" data-id="<?php echo $row1['s_code']."~".$start_date."~".$end_date."~".$row1['sub_grade']; ?>"><?php echo round($row2['pur_rate']); ?></td>
    	<?php } ?>
    </tr>
<?php $prevval = $curval; $prevval1 = $curval1; } ?>
</tbody>
<tbody>
	<tr class="font-weight-bold">
		<td></td>
		<td></td>
		<td style="text-align: right;" class="p-2">
			Total ==>
		</td>
		<?php
		for($i=$year; $i <= $startdtnew; $i++)
		{
    	?>
    	<td style="text-align: center;" id="totalqnty<?php echo $i; ?>">
    		
    	</td>
    	<?php } ?>
		<?php
    	for($i=$year; $i <= $startdtnew; $i++)
		{
    	?>
    	<td style="text-align: right;" id="totalrate<?php echo $i; ?>">
    		
    	</td>
	<?php } ?>
	</tr>
</tbody>
</table>

<?php
}
else if($_GET['status'] == 1)
{
	$scode = $_POST['s_code'];
	$sdate = $_POST['sdate'];
	$edate = $_POST['edate'];
	$subgrade = $_POST['subgrade'];
?>

<table cellpadding="0" cellspacing="0" style="width:1900px;" id="capitalitem">
	<!-- <tr align="left" class="bg-info">
    	<td colspan="16" class="font-weight-bold text-white h5 p-2">Sub Grade = <?php echo $subgrade; ?></td>
    </tr> -->
    <thead>
    <tr align="center">
    	<th></th>
    	<th>Sr No</th>
    	<th>Receive At</th>
    	<th>Receive Date</th>
    	<th>Party</th>
    	<th>Ord By</th>
    	<th>Item Description</th>
    	<th>Plant</th>
    	<th>Project</th>
    	<th>Job No</th>
    	<th>Remarks</th>
    	<th>PKG</th>
    	<th>Unit</th>
    	<th>Rate</th>
    	<th>Qnty</th>
    	<th>Basic Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php 
    $i = 0;
    $basictotal = 0;
    $totalqnty = 0;
    $sql1 = "SELECT b.sr_no, b.receive_at, a.p_po_no, b.receive_date, g.party_name, b.mat_ord_by, f.item, a.p_project,a.plant,a.p_job,a.p_remark,a.p_pkg,a.p_unit,a.rec_qnty,a.pur_rate,(a.rec_qnty*a.pur_rate) as basic_rate, e.sub_grade
    from inward_ind a, inward_com b, rm_category c, rm_m_grade d, rm_s_grade e, rm_item f, rm_party_master g where
   c.c_code = d.c_code and d.m_code = e.m_code and a.sr_no = b.sr_no and a.receive_at = b.receive_at and a.p_item = f.i_code and
    c.c_code = d.c_code and c.c_code = e.c_code and c.c_code = f.c_code and d.m_code = e.m_code and d.m_code = f.m_code and e.s_code = f.s_code and g.pid = b.mat_from_party and
	 b.receive_date between '$sdate' and '$edate' and e.s_code = '$scode'";
    $run1=sqlsrv_query($con,$sql1);
    while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
    {
    	$i++;
    ?>
    <tr>
    	<td class="font-weight-bold p-1"><?php echo $i; ?></td>
    	<td><?php echo $row1['sr_no']; ?></td>
    	<td><?php echo $row1['receive_at']; ?></td>
    	<td><?php echo $row1['receive_date']->format('d-m-Y'); ?></td>
    	<td><?php echo $row1['party_name']; ?></td>
    	<td><?php echo $row1['mat_ord_by']; ?></td>
    	<td><?php echo $row1['item']; ?></td>
    	<td><?php echo $row1['plant']; ?></td>
    	<td><?php echo $row1['p_project']; ?></td>
    	<td><?php echo $row1['p_job']; ?></td>
    	<td class="tags" gloss="<?php echo $row1['p_remark']; ?>">
    		<?php echo wordwrap(substr($row1['p_remark'],0,25)."..."); ?>
    	</td>
    	<td><?php echo $row1['p_pkg']; ?></td>
    	<td><?php echo $row1['p_unit']; ?></td>
    	<td><?php echo round($row1['pur_rate']); ?></td>
    	<td><?php $totalqnty += $row1['rec_qnty']; echo $row1['rec_qnty']; ?></td>
    	<td><?php $basictotal += $row1['basic_rate']; echo round($row1['basic_rate']); ?></td>
    	
    </tr>
    <?php  } ?>
    	
    </tbody>
    <tbody>
    	<tr>
    		<td style="text-align:right;" class="font-weight-bold" colspan="14">Total Qnty / Amount==></td>
	    	<td class="font-weight-bold"><?php echo $totalqnty; ?></td>
	    	<td class="font-weight-bold" align="center"><?php echo round($basictotal); ?></td>
	    </tr>
    </tbody>

</table>

	<?php
}
else if($_GET['status'] == 2)
{
?>
<table cellpadding="0" cellspacing="0" border="1" id="pendingpotable">
	<thead>
	<tr align="left">
    	<th></th>
    	<th>PONO</th>
    	<th>PO_Date</th>
    	<th>Party Name</th>
        <th>Po GenBy</th>
        <th>Req Date</th>
        <th>View</th> 
    </tr>
</thead>
    <?php 
    $i = 0;
    $sql1 = "SELECT distinct a.id, format(a.po_date,'dd-MMM-yyyy') as poDate, b.party_name,a.po_gen_by,format(a.mat_req_date,'yyyy-MM-dd') as reqDate, DATEDIFF(day, format(a.mat_req_date,'yyyy-MM-dd'),GETDATE()) AS DateDiff from po_entry_head a left outer join rm_party_master b on b.pid = a.party where  a.po_date > '2021-06-01' and DATEDIFF(day, format(a.mat_req_date,'yyyy-MM-dd'),GETDATE()) > 0 order by a.id desc";
    $run1=sqlsrv_query($con,$sql1);
    while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
    {
    	$i++;

    	// $sqll = "SELECT item from rm_item where i_code = '8100'";
    	// $runn = sqlsrv_query($con,$sqll);
    	// $row2 = sqlsrv_fetch_array($runn, SQLSRV_FETCH_ASSOC);

    	$sql2 = "SELECT COUNT(id) as count from po_entry_details where iid = '".$row1['id']."' and (isCancle IS NULL AND id NOT IN(SELECT iid from inward_ind))";

	    $run2 = sqlsrv_query($con,$sql2);
	    $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
	    //echo $row['id']."-".$row1['count']."<br/>";

	    if ($row2['count'] == 0)
	    {
	        continue;
	    }
    ?>
    <tr>
    	<td class="font-weight-bold p-1"><?php echo $i; ?></td>
    	<td><?php echo $row1['id']; ?></td>
    	<td><?php echo $row1['poDate']; ?></td>
    	<td><?php echo $row1['party_name']; ?></td>
    	<td><?php echo $row1['po_gen_by']; ?></td>
    	<td><?php echo $row1['reqDate']; ?></td>
    	<td><button class="btn btn-sm btn-info viewPo" id="<?php echo $row1['id']; ?>">View</button></td>
    </tr>
    <?php  } ?>
</table>
	<?php
	}
else if($_GET['status'] == 3)
{
?>

<table cellpadding="0" cellspacing="0" border="1" id="qtymissmatch">
	<thead>
	<tr align="left">
    	<th></th>
    	<th>PONO</th>
    	<th>PO_Date</th>
    	<th>Party Name</th>
    	<th>Po GenBy</th>
        <th>Item</th>
        <th>Order Qnty</th>
        <th>Purchase Qnty</th>
        <th>Qnty Diff</th>
    </tr>
</thead>
    <?php 
    $i = 0;
    $sql1 = "SELECT a.id,a.po_date,c.party_name,a.po_gen_by,d.item,b.qnty,(SELECT sum(rec_qnty) from inward_ind where iid = b.id) as pur_qnty
 from po_entry_head a left outer join po_entry_details b on a.id = b.iid left outer join rm_party_master c on a.party = c.pid
left outer join rm_item d on b.item_code = d.i_code left outer join rm_category e on d.c_code = e.c_code
where b.qnty < (SELECT sum(rec_qnty) from inward_ind where iid = b.id) and a.po_date > '2021-06-01' and e.c_code <> 30 order by a.id DESC";

    $run1=sqlsrv_query($con,$sql1);
    while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
    {
    	$i++;

    	$bal = abs($row1['qnty'] - $row1['pur_qnty']);	
		if ($bal == 0) 
		{
			continue;
		}

		// if($row1['pur_qnty'] > $row1['qnty'])
  //   	{
  //   		continue;
  //   	}
    ?>
    <tr>
    	<td class="font-weight-bold p-1"><?php echo $i; ?></td>
    	<td><?php echo $row1['id']; ?></td>
    	<td><?php echo $row1['po_date']->format('d-M-Y'); ?></td>
    	<td><?php echo $row1['party_name']; ?></td>
    	<td><?php echo $row1['po_gen_by']; ?></td>
    	<td><?php echo $row1['item']; ?></td>
    	<td><?php echo $row1['qnty']; ?></td>
    	<td><?php echo $row1['pur_qnty']; ?></td>
    	<td><?php echo abs($row1['qnty'] - $row1['pur_qnty']); ?></td>
    </tr>
    <?php  } ?>
</table>
	<?php
	}
else if($_GET['status'] == 4)
{
?>

<table cellpadding="0" cellspacing="0" border="1" id="ratemissmatch">
	<thead>
		<tr align="left">
	    	<th></th>
	    	<th>PONO</th>
	    	<th>PO_Date</th>
	    	<th>Party Name</th>
	        <th>Po GenBy</th>
	        <th>Order_Rate</th>
	        <th>Purchase Rate</th>
	        <th>Rate Diff</th>
	    </tr>
    </thead>
    <?php 
    $i = 0;
    $sql1 = "SELECT a.id,a.po_date,c.party_name,a.po_gen_by,d.item,b.rate,(SELECT avg(pur_rate) from inward_ind where iid = b.id) as pur_rate
 from po_entry_head a left outer join po_entry_details b on a.id = b.iid left outer join rm_party_master c on a.party = c.pid
left outer join rm_item d on b.item_code = d.i_code left outer join rm_category e on d.c_code = e.c_code where b.rate < (SELECT sum(pur_rate) from inward_ind where iid = b.id) and a.po_date > '2021-06-01' and e.c_code <> 30 order by a.id DESC";
    $run1=sqlsrv_query($con,$sql1);
    while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
    {
    	$i++;
    	$bal = round(abs($row1['rate'] - $row1['pur_rate']));
    	if($bal == 0)
    	{
    		continue;
    	}
    ?>
    <tr>
    	<td class="font-weight-bold p-1"><?php echo $i; ?></td>
    	<td><?php echo $row1['id']; ?></td>
    	<td><?php echo $row1['po_date']->format('d-M-y'); ?></td>
    	<td><?php echo $row1['party_name']; ?></td>
    	<td><?php echo $row1['po_gen_by']; ?></td>
    	<td><?php echo $row1['rate']; ?></td>
    	<td><?php echo $row1['pur_rate'];  ?></td>
    	<td><?php echo round(abs($row1['rate'] - $row1['pur_rate'])); ?></td>
    </tr>
    <?php  } ?>
</table>
	<?php
	}
else if($_GET['status'] == 5)
{
?>

<table cellpadding="0" cellspacing="0" border="1" id="latedeliverypo">
	<thead>
	<tr align="left">
    	<th></th>
    	<th>PONO</th>
    	<th>Party Name</th>
        <th>Po GenBy</th>
        <th>Item</th>
        <th>Req_Date</th>
        <th>Rec_Date</th>
        <th>Date Diff(in Days)</th>
    </tr>
</thead>
    <?php 
    $i = 0;
    $sql1 = "SELECT DISTINCT c.id, c.po_gen_by, c.mat_req_date, b.receive_date, format(c.mat_req_date,'dd-MMM-yyyy') as reqDate, format(b.receive_date,'dd-MMM-yyyy') as rec_Date, d.party_name, a.p_po_no from inward_ind a left join inward_com b on a.sr_no = b.sr_no and a.receive_at = b.receive_at left join po_entry_head c on a.p_po_no = c.po_no left outer join rm_party_master d  on d.pid = c.party and d.pid = b.mat_from_party where  b.receive_date > c.mat_req_date and c.mat_req_date > '2015-01-01' and c.mat_req_date IS NOT NULL";
    $run1=sqlsrv_query($con,$sql1);
    while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
    {
    	$i++;
    	if($row1['mat_req_date'] == '')
    	{
    		continue;
    	}

    	$query4="SELECT c.item from po_entry_head a left join po_entry_details b on a.id = b.iid left join rm_item c on c.i_code = b.item_code where a.po_no = '".$row1['p_po_no']."'";
        $result4=sqlsrv_query($con,$query4);
        $row4=sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC);
    ?>
    <tr>
    	<td class="font-weight-bold p-1"><?php echo $i; ?></td>
    	<td><?php echo $row1['id']; ?></td>
    	<td><?php echo $row1['party_name']; ?></td>
    	<td><?php echo $row1['po_gen_by']; ?></td>
    	<td><?php echo $row4['item']; ?></td>
    	<td><?php echo $row1['reqDate']; ?></td>
    	<td><?php echo $row1['rec_Date']; ?></td>
    	<td><?php $diff = date_diff($row1['mat_req_date'],$row1['receive_date']); echo $diff->format("%a days"); ?></td>
    </tr>
    <?php  } ?>
</table>
	<?php
	}	
else if($_GET['status'] == 6)
{
	
?>

<table  cellpadding="0" cellspacing="0" border="1" id="employee_data">
	<thead>
		<tr id="trow">
			<th>Receive Date</th>
			<th>Rmta</th>
			<th>Party</th>
			<th>Bill No.</th>
			<th>Bill Date</th>
			<th>mat_ord_by</th>
			<th>Bill amt</th>
		</tr>
	</thead>
<?php
		$sql="SELECT DISTINCT  a.sr_no, a.receive_at, a.send_time, c.party_name, a.invoice_no, a.invoice_date,  a.mat_ord_by, a.total_bill_amt  FROM inward_com  a LEFT OUTER JOIN inward_ind b on a.sr_no = b.sr_no and a.receive_at = b.receive_at left join rm_party_master c on c.pid = a.mat_from_party  where a.bill_approve = 0 and a.bill_send = 1 and a.bill_receive = 1 order by a.send_time DESC";
		$run=sqlsrv_query($con,$sql);
		while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) 
		{
		?>
		<tr class="text-center">
			<td><?php echo $row['send_time']->format('d.M.Y');  ?></td>
			<td><?php echo $row['sr_no']."_(".$row['receive_at'].")";  ?></td>
			<td><?php echo $row['party_name'];  ?></td>
			<td><?php echo $row['invoice_no'];  ?></td>
			<td><?php echo $row['invoice_date']->format('d.M.Y');  ?></td>
			<td><?php echo $row['mat_ord_by'];  ?></td>
			<td><?php echo (float)$row['total_bill_amt'];  ?></td>
		</tr>
		<?php
		}
		?>
	</table>
	<?php
	}		
else if($_GET['status'] == 7)
{
	
?>

<table  cellpadding="0" cellspacing="0" border="1" id="employee_data">
	<thead>
		<tr id="trow">
			<th>Receive Date</th>
			<th>Rmta</th>
			<th>Party</th>
			<th>Bill No.</th>
			<th>Bill Date</th>
			<th>mat_ord_by</th>
			<th>Bill amt</th>
		</tr>
	</thead>
<?php
		$sql="SELECT DISTINCT  a.sr_no, a.receive_at, a.send_time, c.party_name, a.invoice_no, a.invoice_date,  a.mat_ord_by, a.total_bill_amt, b.p_po_no
  FROM inward_com  a LEFT OUTER JOIN inward_ind b on a.sr_no = b.sr_no and a.receive_at = b.receive_at left join rm_party_master c on c.pid = a.mat_from_party 
 where a.bill_approve = 0 and a.bill_send = 1 and a.bill_receive = 1  order by a.send_time DESC";
		$run=sqlsrv_query($con,$sql);
		while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) 
		{
			$sql3="SELECT b.iid as poentryidp  FROM inward_com  a LEFT OUTER JOIN inward_ind b on a.sr_no = b.sr_no and a.receive_at = b.receive_at  where  a.bill_approve = 0 and a.bill_send = 1 and a.bill_receive = 1 and a.sr_no = '".$row['sr_no']."'";
			$run3=sqlsrv_query($con,$sql3);
			$row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);

			//echo $row3['inward_srno']."<br/>";

			$sql4 = "SELECT requisition_id, req_iid from po_entry_details where id = '".$row3['poentryidp']."'";
			$run4=sqlsrv_query($con,$sql4);
			$row4 = sqlsrv_fetch_array($run4, SQLSRV_FETCH_ASSOC);
			//echo $row4['requisition_id'];
			if(($row4['req_iid'] != "") || ($row4['req_iid'] != NULL) && ($row4['requisition_id'] != "") || ($row4['requisition_id'] != NULL))
			{
				continue;
			}
		?>
		<tr class="text-center">
			<td><?php echo $row['send_time']->format('d.M.Y');  ?></td>
			<td><?php echo $row['sr_no']."_(".$row['receive_at'].")";  ?></td>
			<td><?php echo $row['party_name'];  ?></td>
			<td><?php echo $row['invoice_no'];  ?></td>
			<td><?php echo $row['invoice_date']->format('d.M.Y');  ?></td>
			<td><?php echo $row['mat_ord_by'];  ?></td>
			<td><?php echo (float)$row['total_bill_amt'];  ?></td>
		</tr>
		<?php
		}
		?>
	</table>
	<?php
	}	
else if($_GET['status'] == 8)
{
	
?>

<table  cellpadding="0" cellspacing="0" border="1" id="negetivestockdata">
        <thead>
          <tr id="trow">
            <th id="trow">Item_name</th>
            <th id="trow">sub_grade</th>
            <th id="trow">main_grae</th>
            <th id="trow">Category</th>
            <th id="trow">Qnty</th>
          </tr>
        </thead>
        <?php
        $sql="SELECT MAX(opening_date) as last_date FROM store_opening_date";
        $run=sqlsrv_query($con,$sql);
        $rowa = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
        $dd = $rowa['last_date']->format('d-M-y');
        
        $query = "SELECT DISTINCT item FROM inward_store where receive_dte >='$dd'";
        $result = sqlsrv_query($con,$query);
        while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
        {
        	$item = $row["item"];
        
        
        $query2="SELECT SUM(qnty) as inw_qnty FROM inward_store where item='$item' and receive_dte >='$dd'";
        $result2=sqlsrv_query($con,$query2);
        $row2=sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);
        
        
        $query3="SELECT SUM(qnty) as qnty_value FROM rm_issue where item_name='$item' and issue_from = 'store' and issue_date >='$dd'";
        $result3=sqlsrv_query($con,$query3);
        $row3=sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
        $qnty= $row2["inw_qnty"]-$row3['qnty_value'];
        
        
        $query4="SELECT * FROM rm_item where i_code='$item'";
        $result4=sqlsrv_query($con,$query4);
        $row4=sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC);
        $s_grade = $row4['s_code'];
        $m_grade = $row4['m_code'];
        $cat = $row4['c_code'];

        $query5="SELECT sub_grade FROM rm_s_grade where s_code='$s_grade'";
        $result5=sqlsrv_query($con,$query5);
        $row5=sqlsrv_fetch_array($result5, SQLSRV_FETCH_ASSOC);

        $query6="SELECT main_grade FROM rm_m_grade where m_code='$m_grade'";
        $result6=sqlsrv_query($con,$query6);
        $row6=sqlsrv_fetch_array($result6, SQLSRV_FETCH_ASSOC);

        $query7="SELECT category FROM rm_category where c_code='$cat'";
        $result7=sqlsrv_query($con,$query7);
        $row7=sqlsrv_fetch_array($result7, SQLSRV_FETCH_ASSOC);
        if ($qnty == 0) 
        {
            continue;
        }
        if($qnty < 0) {
        ?>
        <tr class="text-center">
          <td><?php echo $item."-".$row4['item'];  ?></td>
          <td><?php echo $row5['sub_grade'];  ?></td>
          <td><?php echo $row6['main_grade'];  ?></td>
          <td><?php echo $row7['category'];  ?></td>
          <td><?php echo $qnty;  ?></td>
        </tr>
        <?php
        } }
        ?>
        
      </table>
	<?php
}
else if($_GET['status'] == 9)
{
?>
			
<table cellpadding="0" cellspacing="0" border="1" id="pendingpotableadv">
	<thead>
	<tr align="left">
    	<th></th>
    	<th>PONO</th>
    	<th>PO_Date</th>
    	<th>Party Name</th>
        <th>Po GenBy</th>
        <th>Req Date</th>
        <th>Adv Amount</th>
        <th>View</th> 
    </tr>
</thead>
    <?php 
    $i = 0;
    $sql1 = "SELECT distinct a.id, a.adv_amt, format(a.po_date,'dd-MMM-yyyy') as poDate, b.party_name,a.po_gen_by,format(a.mat_req_date,'yyyy-MM-dd') as reqDate, DATEDIFF(day, format(a.mat_req_date,'yyyy-MM-dd'),GETDATE()) AS DateDiff from po_entry_head a left outer join rm_party_master b on b.pid = a.party where  a.po_date > '2021-06-01' and DATEDIFF(day, format(a.mat_req_date,'yyyy-MM-dd'),GETDATE()) > 0 and  a.adv_amt IS NOT NULL and a.adv_amt <> 0 order by a.id desc";
    $run1=sqlsrv_query($con,$sql1);
    while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
    {
    	$i++;

    	// $sqll = "SELECT item from rm_item where i_code = '8100'";
    	// $runn = sqlsrv_query($con,$sqll);
    	// $row2 = sqlsrv_fetch_array($runn, SQLSRV_FETCH_ASSOC);

    	$sql2 = "SELECT COUNT(id) as count from po_entry_details where iid = '".$row1['id']."' and (isCancle IS NULL AND id NOT IN(SELECT iid from inward_ind))";

	    $run2 = sqlsrv_query($con,$sql2);
	    $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
	    //echo $row['id']."-".$row1['count']."<br/>";

	    if ($row2['count'] == 0)
	    {
	        continue;
	    }
    ?>
    <tr>
    	<td class="font-weight-bold p-1"><?php echo $i; ?></td>
    	<td><?php echo $row1['id']; ?></td>
    	<td><?php echo $row1['poDate']; ?></td>
    	<td><?php echo $row1['party_name']; ?></td>
    	<td><?php echo $row1['po_gen_by']; ?></td>
    	<td><?php echo $row1['reqDate']; ?></td>
    	<td><?php echo $row1['adv_amt']; ?></td>
    	<td><button class="btn btn-sm btn-info viewPoAdv" id="<?php echo $row1['id']; ?>">View PO</button></td>
    </tr>
    <?php  } ?>
</table>                

<?php
}	
else if($_GET['status'] == 10)
{
	include('../dbmysqlcon.php');
	$i = 0;
?>
<table  cellpadding="0" cellspacing="0" border="1" id="pendinginward">
        <thead>
          <tr id="trow">
          	<th>Sr no</th>
            <th>Outward NO</th>
            <th>Out Date</th>
            <th>From Location</th>
            <th>Issue To</th>
            <th>Returnable</th>
            <th>Serial</th>
            <th>Desciption</th>
            <th>Issue Qty</th>
            <th>Ret Qty</th>
            <th>Balance</th>
            <th>Value</th>
          </tr>
        </thead>
        <?php
        $sql = "SELECT cm.challanno, cm.cdate, cm.placesupply,cm.tolocation as Issue_To,cm.returnable, cd.serial, cd.description, cd.qty, cd.rate,(select sum(rqty) from inward_detail, inward_master where inward_master.id = inward_detail.id and inward_master.outward_no = cm.challanno) as Rqty,(cd.qty - (select sum(rqty) from inward_detail, inward_master where inward_master.id = inward_detail.id and inward_master.outward_no = cm.challanno))as SubRqty from challan_master cm,challan_detail cd where cm.id = cd.id and cm.returnable = 'Returnable'";
        $result = mysqli_query($mysqlconn,$sql);
        while($row = mysqli_fetch_assoc($result))
        {
        	$i++;

        	if($row['SubRqty'] > 0)
        	{
        		continue;
        	}
        
        ?>
        <tr class="text-center">
          <td width="5%"><?php echo $i; ?></td>
          <td width="10%"><?php echo $row['challanno'];  ?></td>
          <td width="7%"><?php $myDateTime = DateTime::createFromFormat('Y-m-d', $row['cdate']);
$formattedweddingdate = $myDateTime->format('d-M-Y'); echo $formattedweddingdate; ?></td>
          <td width="5%"><?php echo $row['placesupply'];  ?></td>
          <td width="10%"><?php echo $row['Issue_To'];  ?></td>
          <td width="7%"><?php echo $row['returnable'];  ?></td>
          <td width="5%"><?php echo $row['serial'];  ?></td>
          <td width="10%"><?php echo $row['description'];  ?></td>
          <td width="5%"><?php echo $row['qty']; ?></td>
          <td width="5%"><?php echo $row['Rqty']; ?></td>
          <td width="5%"><?php echo $row['qty']-$row['Rqty'];  ?></td>
          <td width="5%"><?php echo $row['rate'];  ?></td>
        </tr>
        <?php
        } 
        ?>
        
      </table>
<?php

}
else if($_GET['status'] == 11)
{
?>
<table cellpadding="0" cellspacing="0" border="1" id="pendingpotable">
	<thead>
		<tr align="left">
			<th id="trow">LP Date</th>
	        <th id="trow">Item_name</th>
	        <th id="trow">sub_grade</th>
	        <th id="trow">Difference</th>
	        <th id="trow">Pur Rate</th>
	        <th id="trow">Qnty</th>
	        <th id="trow">Total val</th>
	        <th id="trow">Intrest Rate</th>
	        <th id="trow">Show</th>
	    </tr>
	</thead>
    <?php 
    $totalval = 0;
    $sql="SELECT MAX(opening_date) as last_date FROM store_opening_date";
        $run=sqlsrv_query($con,$sql);
        $rowa = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
        $dd = $rowa['last_date']->format('d-M-y');
        
        $query = "SELECT DISTINCT item FROM inward_store where receive_dte >='$dd'";
        $result = sqlsrv_query($con,$query);
        while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
        {
          
        $item = $row["item"];
       
       	
        //qnty
        $query2="SELECT SUM(qnty) as inw_qnty FROM inward_store where item='$item' and receive_dte >='$dd'";
        $result2=sqlsrv_query($con,$query2);
        $row2=sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);
        
        $query3="SELECT SUM(qnty) as qnty_value FROM rm_issue where item_name='$item' and issue_from = 'store' and issue_date >='$dd'";
        $result3=sqlsrv_query($con,$query3);
        $row3=sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
        $qnty= $row2["inw_qnty"]-$row3['qnty_value'];
        
        $query4="SELECT * FROM rm_item where i_code='$item'";
        $result4=sqlsrv_query($con,$query4);
        $row4=sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC);
        $s_grade = $row4['s_code'];
        $m_grade = $row4['m_code'];
        $cat = $row4['c_code'];
        $query5="SELECT sub_grade FROM rm_s_grade where s_code='$s_grade'";
        $result5=sqlsrv_query($con,$query5);
        $row5=sqlsrv_fetch_array($result5, SQLSRV_FETCH_ASSOC);
        $query6="SELECT main_grade FROM rm_m_grade where m_code='$m_grade'";
        $result6=sqlsrv_query($con,$query6);
        $row6=sqlsrv_fetch_array($result6, SQLSRV_FETCH_ASSOC);

        $query7="SELECT category FROM rm_category where c_code='$cat'";
        $result7=sqlsrv_query($con,$query7);
        $row7=sqlsrv_fetch_array($result7, SQLSRV_FETCH_ASSOC);

		//find date & rate
       	//here , purrate taken as per lp date but it may differ from original rate
        $qrydt="SELECT top 1 DATEDIFF(day,format(b.receive_date,'yyyy-MM-dd'),format(GETDATE(),'yyyy-MM-dd')) as Diffday, format(b.receive_date,'dd-MM-yyyy') as LPdate, a.pur_rate, a.rec_qnty  FROM inward_ind a inner join inward_com b on b.sr_no = a.sr_no and b.receive_at = a.receive_at  inner join rm_item c on a.p_item = c.i_code inner join rm_s_grade d on c.s_code = d.s_code inner join rm_m_grade e on c.m_code = e.m_code and e.m_code  = d.m_code inner join rm_category f on c.c_code = f.c_code and f.c_code = d.c_code and f.c_code = e.c_code and  a.p_item = '$item' and d.s_code = '$s_grade' and e.m_code = '$m_grade' and f.c_code = '$cat' order by b.receive_date desc";
        $resdt=sqlsrv_query($con,$qrydt);
        $rowdt=sqlsrv_fetch_array($resdt, SQLSRV_FETCH_ASSOC);

        $totalval = $rowdt['pur_rate'] * $qnty;

        if(($qnty == 0) || ($row4['item'] == "") || ($row4['item'] == NULL)) 
        {
            continue;
        }
        $diff = ($totalval * 10 * $rowdt['Diffday'])/36500;
    ?>
    <tr class="text-center font-italic">
      <td width="100px"><?php echo $rowdt['LPdate']; ?></td>
      <td><?php echo $row4['item']; ?></td>
      <td><?php echo $row5['sub_grade']; ?></td>
      <td><?php echo $rowdt['Diffday']; ?></td>
      <td><?php echo $rowdt['pur_rate']; ?></td>
      <td><?php echo $qnty; ?></td>
      <td><?php echo $totalval; ?></td>
      <td><?php echo round($diff); ?></td>
      <td><button class="btn btn-sm btn-info viewPoStore" id="<?php echo $item; ?>">View</button></td>
    </tr>
    <?php  } ?>
</table>
<?php
}
}
?>
<style type="text/css">
	@keyframes spinner {
  to {transform: rotate(360deg);}
}
 
.spinner:before {
  content: '';
  box-sizing: border-box;
  position: absolute;
  top: 50%;
  left: 50%;
  width: 20px;
  height: 20px;
  margin-top: -10px;
  margin-left: -10px;
  border-radius: 50%;
  border: 2px solid #ccc;
  border-top-color: #333;
  animation: spinner .6s linear infinite;
}
</style>
<script type="text/javascript">
	$(document).ready(function() 
	{
		 $('#pendingpotable,#qtymissmatch,#ratemissmatch,#latedeliverypo,#employee_data,#negetivestockdata,#pendingpotableadv,#pendinginward').DataTable( {
            "processing": true,
            "dom": 'Bfrtip',
            "destroy": true,
             deferLoading: 57,
        	
        	    lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],
         } );

         $('#civilitem,#capitalitem').DataTable( {
        	"processing": true,
            "dom": 'Bfrtip',
            "destroy": true,
             deferLoading: 57,
        	
        	    lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],
         });

        var totalqnty2020  = 0;
        $('.qntyin2020').each(function(i)
        {
            totalqnty2020 += parseInt($(this).text());
        });

        $("#totalqnty2020").text(totalqnty2020);

        var totalqnty2021  = 0;
        $('.qntyin2021').each(function(i)
        {
            totalqnty2021 += parseInt($(this).text());
        });

        $("#totalqnty2021").text(totalqnty2021);

        var totalqnty2022  = 0;
        $('.qntyin2022').each(function(i)
        {
            totalqnty2022 += parseInt($(this).text());
        });

        $("#totalqnty2022").text(totalqnty2022);

        //--------rate--------------//
        var totalrate2020  = 0;
        $('.ratein2020').each(function(i)
        {
            totalrate2020 += parseInt($(this).text());
        });
        $("#totalrate2020").text(totalrate2020);

        var totalrate2021  = 0;
        $('.ratein2021').each(function(i)
        {
            totalrate2021 += parseInt($(this).text());
        });
        $("#totalrate2021").text(totalrate2021);

        var totalrate2022  = 0;
        $('.ratein2022').each(function(i)
        {
            totalrate2022 += parseInt($(this).text());
        });
        $("#totalrate2022").text(totalrate2022);
        


    });

 	$('.createbtnitem').on('click',function()
    {
        var val = $(this).attr('data-id');
        var str = val.split("~");

        $.ajax(
        {
            url: "dashboard_ajax.php?status=1",
            type: 'post',
            data: {s_code:str[0],sdate:str[1],edate:str[2],subgrade:str[3]},
            success: function(data) 
            {
                $('#createitem').modal('show');
                $("#t_body_createitem").html(data);
            },
        });
        
        
    });

    




</script>