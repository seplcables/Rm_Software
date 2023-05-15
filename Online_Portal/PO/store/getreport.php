<?php
include('..\..\..\dbcon.php');
		$query="SELECT MAX(opening_date) as last_date FROM store_opening_date";
		$result=sqlsrv_query($con,$query);
		$rowa = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
			$dd = $rowa['last_date']->format('d-M-y');

$sql = "SELECT DISTINCT a.item as icode,e.category,d.main_grade,c.sub_grade,b.item,a.unit FROM inward_store a
LEFT OUTER JOIN rm_item b on a.item = b.i_code
LEFT OUTER JOIN rm_s_grade c on b.s_code = c.s_code
LEFT OUTER JOIN rm_m_grade d on c.m_code = d.m_code
LEFT OUTER JOIN rm_category e on d.c_code = e.c_code
where receive_dte >='$dd'";
$run = sqlsrv_query($con,$sql);
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
	$item = $row['icode'];
	    $query2="SELECT SUM(qnty) as inw_qnty FROM inward_store where item='$item' and receive_dte >='$dd'";
        $result2=sqlsrv_query($con,$query2);
        $row2=sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);	
		
        $query3="SELECT SUM(qnty) as qnty_value FROM rm_issue where item_name='$item' and issue_from = 'store' and issue_date >='$dd'";
        $result3=sqlsrv_query($con,$query3);
        $row3=sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
        $qnty= $row2["inw_qnty"]-$row3['qnty_value'];


$rows[] = array("data"=>$row,"qnty"=>$qnty);

}
echo json_encode($rows);
?>