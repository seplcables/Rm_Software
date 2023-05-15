<?php

if (isset($_POST['dte'])) {
    $selectDate = $_POST['dte'];
    include('../../../dbcon.php');
    $rows = array();
    $sql = "SELECT distinct FORMAT(receive_dte,'dd-MMM-yyyy') as receive_dte from inward_rm where receive_dte > '$selectDate' and come_from = 'opening'";
    $run = sqlsrv_query($con, $sql);
    $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

    if ($row['receive_dte'] == "") {
        $sql1 = "SELECT item,party_name,rmta,sum(qnty) as qnty from (select b.item,c.party_name,rmta,qnty from inward_rm a left outer join rm_item b on a.item = b.i_code left outer join rm_party_master c on a.party = c.pid where ISNUMERIC(rmta) = 1 and a.receive_dte = '$selectDate' and come_from = 'opening'union All select c.item,d.party_name,b.sr_no,b.rec_qnty from inward_com a left outer join inward_ind b on a.sr_no = b.sr_no and a.receive_at = b.receive_at left outer join rm_item c on b.p_item = c.i_code left outer join rm_party_master d on a.mat_from_party = d.pid where c.m_code in(161,171,148,163,174) and a.receive_date >= '".$selectDate."') as tbl group by item,party_name,rmta order by item";
        $run1 = sqlsrv_query($con, $sql1);
        $sr = 0;
        while ($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC)) {
            $sr++;
            $sql3 = "SELECT SUM(issue_qnty) as issueQnty from pvc_issue where ISNUMERIC(rmta) = 1 and rmta = '".$row1['rmta']."' and issue_date >= '".$selectDate."'";
            $run3 = sqlsrv_query($con, $sql3);
            $row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);

            $sql4 = "SELECT FORMAT(a.receive_date,'dd-MMM-yy') as receive_date,b.pur_rate,DATEDIFF(DAY,a.receive_date , GETDATE()) as diff from inward_com a left outer join inward_ind b on a.sr_no = b.sr_no and a.receive_at = b.receive_at where a.sr_no = '".$row1['rmta']."'";
            $run4 = sqlsrv_query($con, $sql4);
            $row4 = sqlsrv_fetch_array($run4, SQLSRV_FETCH_ASSOC);

            $rows[] = array("item"=>$row1['item'],"party_name"=>$row1['party_name'],"rmta"=>$row1['rmta'],"qnty"=>$row1['qnty'],"closing"=>'',"actUse"=>'',"issueQnty"=>$row3['issueQnty'],"diff"=>'=G'.$sr.'-J'.$sr.'',"ext"=>array(1,'liveStock'),"recDate"=>$row4['receive_date'],"rate"=>$row4['pur_rate'],"diffDays"=>$row4['diff'],"int"=>'=IF(K'.$sr.'>0,E'.$sr.'*F'.$sr.'*K'.$sr.'*0.12/365,0)');
        }
    } else {
        $sql1 = "SELECT item,party_name,rmta,sum(qnty) as qnty from (select b.item,c.party_name,rmta,qnty from inward_rm a left outer join rm_item b on a.item = b.i_code left outer join rm_party_master c on a.party = c.pid where ISNUMERIC(rmta) = 1 and a.receive_dte = '$selectDate' and come_from = 'opening'union All select c.item,d.party_name,b.sr_no,b.rec_qnty from inward_com a left outer join inward_ind b on a.sr_no = b.sr_no and a.receive_at = b.receive_at left outer join rm_item c on b.p_item = c.i_code left outer join rm_party_master d on a.mat_from_party = d.pid where c.m_code in(161,171,148,163,174) and a.receive_date between '".$selectDate."' and '".$row['receive_dte']."') as tbl group by item,party_name,rmta order by item";
        $run1 = sqlsrv_query($con, $sql1);
        $sr = 0;
        while ($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC)) {
            $sr++;
            $sql2 = "SELECT SUM(qnty) as closing from inward_rm where ISNUMERIC(rmta) = 1 and rmta = '".$row1['rmta']."' and come_from = 'opening' and receive_dte = '".$row['receive_dte']."'";
            // echo $sql2;
            // exit();
            $run2 = sqlsrv_query($con, $sql2);
            $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);

            $sql3 = "SELECT SUM(issue_qnty) as issueQnty from pvc_issue where ISNUMERIC(rmta) = 1 and rmta = '".$row1['rmta']."' and issue_date between '".$selectDate."' and '".$row['receive_dte']."'";
            $run3 = sqlsrv_query($con, $sql3);
            $row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);

            $sql4 = "SELECT FORMAT(a.receive_date,'dd-MMM-yy') as receive_date,b.pur_rate,DATEDIFF(DAY,a.receive_date , '".$row['receive_dte']."') as diff from inward_com a left outer join inward_ind b on a.sr_no = b.sr_no and a.receive_at = b.receive_at where a.sr_no = '".$row1['rmta']."'";
            $run4 = sqlsrv_query($con, $sql4);
            $row4 = sqlsrv_fetch_array($run4, SQLSRV_FETCH_ASSOC);

            $rows[] = array("item"=>$row1['item'],"party_name"=>$row1['party_name'],"rmta"=>$row1['rmta'],"qnty"=>$row1['qnty'],"closing"=>$row2['closing'],"actUse"=>'=G'.$sr.'-H'.$sr.'',"issueQnty"=>$row3['issueQnty'],"diff"=>'=J'.$sr.'-I'.$sr.'',"ext"=>array(100,'Diff'),"recDate"=>$row4['receive_date'],"rate"=>$row4['pur_rate'],"diffDays"=>$row4['diff'],"int"=>'=E'.$sr.'*H'.$sr.'*F'.$sr.'*0.12/365');
        }
    }
    echo json_encode($rows);
} else {
    echo json_encode("No date set");
}
