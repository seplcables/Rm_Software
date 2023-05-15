<?php
include('..\..\..\dbcon.php');
        $sqla="SELECT MAX(opening_date) as last_date FROM store_opening_date";
        $runa=sqlsrv_query($con,$sqla);
        $rowa = sqlsrv_fetch_array($runa, SQLSRV_FETCH_ASSOC);
        $dd = $rowa['last_date']->format('d-M-y');

$sql = "SELECT DISTINCT a.item as icode,e.category,d.main_grade,c.sub_grade,b.item FROM inward_store a
LEFT OUTER JOIN rm_item b on a.item = b.i_code
LEFT OUTER JOIN rm_s_grade c on b.s_code = c.s_code
LEFT OUTER JOIN rm_m_grade d on c.m_code = d.m_code
LEFT OUTER JOIN rm_category e on d.c_code = e.c_code";
$run = sqlsrv_query($con,$sql);
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
	$item = $row['icode'];
	$query2="SELECT sum(rec_qnty) as inw_qnty FROM inward_ind a
                         LEFT OUTER JOIN inward_com b on a.sr_no = b.sr_no
                         where p_item = '$item' and receive_date>='2021-01-01'";
        $result2=sqlsrv_query($con,$query2);
        $row2=sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);	
		
        $query3="SELECT SUM(qnty) as qnty_value FROM rm_issue where item_name='$item' and issue_from = 'store' and issue_date >='2021-01-01'";
        $result3=sqlsrv_query($con,$query3);
        $row3=sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
        
        $query4="SELECT SUM(qnty) as inw_qnty FROM inward_store where item='$item' and receive_dte >='$dd'";
        $result4=sqlsrv_query($con,$query4);
        $row4=sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC); 
                
        $query5="SELECT SUM(qnty) as qnty_value FROM rm_issue where item_name='$item' and issue_from = 'store' and issue_date >='$dd'";
        $result5=sqlsrv_query($con,$query5);
        $row5=sqlsrv_fetch_array($result5, SQLSRV_FETCH_ASSOC);
        
        $qnty= $row4["inw_qnty"]-$row5['qnty_value'];
        $diff = $row2["inw_qnty"]-$row3['qnty_value'] - $qnty;


$rows[] = array("data"=>$row,"tqnty"=>$row2,"iqnty"=>$row3,"qnty"=>$qnty,"diff"=>$diff);

}
echo json_encode($rows);
?>