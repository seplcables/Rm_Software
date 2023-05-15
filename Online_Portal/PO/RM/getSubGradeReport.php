<?php

if (isset($_POST['dte'])) {
    $selectDate = $_POST['dte'];
    include('../../../dbcon.php');
    $rows = array();
    $sqldte = "SELECT distinct FORMAT(receive_dte,'dd-MMM-yyyy') as receive_dte from inward_rm where receive_dte > '$selectDate' and come_from = 'opening'";
    $rundte = sqlsrv_query($con, $sqldte);
    $rowdte = sqlsrv_fetch_array($rundte, SQLSRV_FETCH_ASSOC);

    if ($rowdte['receive_dte'] == "") {
        $sql = "SELECT s_code,sub_grade from rm_s_grade where m_code in(144,161,171) order by sub_grade asc";
        $run = sqlsrv_query($con, $sql);
        $sr = 0;
        while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
            $sr++;
            // opning
            $sql1 = "SELECT SUM(qnty) as opening from inward_rm where item in (SELECT i_code from rm_item where s_code = '".$row['s_code']."') and come_from = 'opening' and receive_dte = '".$selectDate."'";
            $run1 = sqlsrv_query($con, $sql1);
            $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
            // inward
            $sql2 = "SELECT sum(b.rec_qnty) as PurQnty,SUM(b.rec_qnty*b.pur_rate) as amt from inward_com a left outer join inward_ind b on a.sr_no = b.sr_no and a.receive_at = b.receive_at where a.receive_at = 'Halol' and b.p_item in (SELECT i_code from rm_item where s_code = '".$row['s_code']."') and a.receive_date > '".$selectDate."'";
            $run2 = sqlsrv_query($con, $sql2);
            $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);

            // prodConsume
            $sql4 = "SELECT sum(usedWt) as prodConsume from(SELECT SUM(PQty*b.perMtrWt) as usedWt from [TRADEZ].[dbo].OuterSth a join [backward_calc].[dbo].gradeWizeUse b on a.JOBNo = b.job where EDate >='".$selectDate."' and b.stage = 'outer' and subGrade = ".$row['s_code']." union all SELECT SUM(PQty*b.perMtrWt) as usedWt from [TRADEZ].[dbo].InnerSth a join [backward_calc].[dbo].gradeWizeUse b on a.JOBNo = b.job where EDate >='".$selectDate."' and b.stage = 'inner' and subGrade = ".$row['s_code']." union all SELECT SUM(fqty) as usedWt from (SELECT CASE WHEN b.SQMM < 10 and b.CorePair = 'C' and GID not like '%JR%'THEN PQty*c.perMtrWt ELSE PQty/(b.Core*d.nos)*c.perMtrWt END as fqty from [TRADEZ].[dbo].Ins a left outer join [TRADEZ].[dbo].OrdDetail b on a.JOBNo = b.JobNo join [backward_calc].[dbo].gradeWizeUse c on a.JOBNo = c.job join [backward_calc].[dbo].coreP d on b.CorePair = d.core where EDate >='".$selectDate."' and c.stage = 'insulation' and subGrade = ".$row['s_code'].") as tbl ) finalTbl";
            $run4 = sqlsrv_query($con, $sql4);
            $row4 = sqlsrv_fetch_array($run4, SQLSRV_FETCH_ASSOC);

            $rows[] = array("subGrade"=>$row['sub_grade'],"opening"=>$row1['opening'],"inward"=>$row2['PurQnty'],"closing"=>"","prod"=>$row4['prodConsume'],"actUse"=>'',"diff"=>'=B'.$sr.'+C'.$sr.'-F'.$sr.'');
        }
    } else {
        $sql = "SELECT s_code,sub_grade from rm_s_grade where m_code in(144,161,171) order by sub_grade asc";
        $run = sqlsrv_query($con, $sql);
        $sr = 0;
        while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
            $sr++;
            // opning
            $sql1 = "SELECT SUM(qnty) as opening from inward_rm where item in (SELECT i_code from rm_item where s_code = '".$row['s_code']."') and come_from = 'opening' and receive_dte = '".$selectDate."'";
            $run1 = sqlsrv_query($con, $sql1);
            $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
            // inward
            $sql2 = "SELECT sum(b.rec_qnty) as PurQnty,SUM(b.rec_qnty*b.pur_rate) as amt from inward_com a left outer join inward_ind b on a.sr_no = b.sr_no and a.receive_at = b.receive_at where a.receive_at = 'Halol' and b.p_item in (SELECT i_code from rm_item where s_code = '".$row['s_code']."') and a.receive_date > '".$selectDate."' and a.receive_date <= '".$rowdte['receive_dte']."'";
            $run2 = sqlsrv_query($con, $sql2);
            $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
            // Closing
            $sql3 = "SELECT SUM(qnty) as closing from inward_rm where item in (SELECT i_code from rm_item where s_code = '".$row['s_code']."') and come_from = 'opening' and receive_dte = '".$rowdte['receive_dte']."'";
            $run3 = sqlsrv_query($con, $sql3);
            $row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);
            // prodConsume
            $sql4 = "SELECT sum(usedWt) as prodConsume from(SELECT SUM(PQty*b.perMtrWt) as usedWt from [TRADEZ].[dbo].OuterSth a join [backward_calc].[dbo].gradeWizeUse b on a.JOBNo = b.job where EDate > '".$selectDate."' and EDate <= '".$rowdte['receive_dte']."' and b.stage = 'outer' and subGrade = ".$row['s_code']." union all SELECT SUM(PQty*b.perMtrWt) as usedWt from [TRADEZ].[dbo].InnerSth a join [backward_calc].[dbo].gradeWizeUse b on a.JOBNo = b.job where EDate > '".$selectDate."' and EDate <= '".$rowdte['receive_dte']."' and b.stage = 'inner' and subGrade = ".$row['s_code']." union all SELECT SUM(fqty) as usedWt from (SELECT CASE WHEN b.SQMM < 10 and b.CorePair = 'C' and GID not like '%JR%' and GID not like '%ML%'THEN PQty*c.perMtrWt ELSE PQty/(b.Core*d.nos)*c.perMtrWt END as fqty from [TRADEZ].[dbo].Ins a left outer join [TRADEZ].[dbo].OrdDetail b on a.JOBNo = b.JobNo join [backward_calc].[dbo].gradeWizeUse c on a.JOBNo = c.job join [backward_calc].[dbo].coreP d on b.CorePair = d.core where EDate > '".$selectDate."' and EDate <= '".$rowdte['receive_dte']."' and c.stage = 'insulation' and subGrade = ".$row['s_code'].") as tbl ) finalTbl";
            $run4 = sqlsrv_query($con, $sql4);
            $row4 = sqlsrv_fetch_array($run4, SQLSRV_FETCH_ASSOC);

            $rows[] = array("subGrade"=>$row['sub_grade'],"opening"=>$row1['opening'],"inward"=>$row2['PurQnty'],"closing"=>$row3['closing'],"prod"=>$row4['prodConsume'],"actUse"=>'=B'.$sr.'+C'.$sr.'-D'.$sr.'',"diff"=>'=E'.$sr.'-F'.$sr.'');
        }
    }
    echo json_encode($rows);
} else {
    echo json_encode("No date set");
}
