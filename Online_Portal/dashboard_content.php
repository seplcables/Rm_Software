<?php session_start();
include('../dbcon.php'); ?>
<div id="grid">
<div class="shadow bg-white rounded">
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <?php
                $startdtnew = date("Y");
                $year = '2020';
                $y = 0;
                for($i=$year; $i <= $startdtnew; $i++)
                {
                   
                ?>
                <th class="bg-warning">
                    <?php echo $i."-".($i+1); ?>
                </th>
                <?php } ?>
        </thead>
        <tbody align="center">
            <tr>
            <?php
                for($i=$year; $i <= $startdtnew; $i++) 
                {  
                    $total = 0;
                    $sql1 = "SELECT DISTINCT * from rm_category where c_code IN (31,32,33,34,35,36,38,40) order by c_code ASC";
                    $run1=sqlsrv_query($con,$sql1);
                    while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
                    {
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));

                        $sql2 = "SELECT sum(a.taxable_amt) as pur_rate from inward_ind a, inward_com b, rm_category c, rm_m_grade d, rm_s_grade e, rm_item f where c.c_code = d.c_code and d.m_code = e.m_code  and a.sr_no = b.sr_no and a.receive_at = b.receive_at and a.p_item = f.i_code and c.c_code = d.c_code and c.c_code = e.c_code and c.c_code = f.c_code and d.m_code = e.m_code and d.m_code = f.m_code and e.s_code = f.s_code  
                            and b.receive_date between '".$start_date."' and '".$end_date."' and c.c_code = '".$row1['c_code']."'";
                        $run2=sqlsrv_query($con,$sql2);
                        $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC); 
                    
                        if($start_date == '2020-04-01' && $end_date == '2021-03-31')
                        {
                            $total += round($row2['pur_rate']);
                        }
                        else if($start_date == '2021-04-01' && $end_date == '2022-03-31')
                        {
                            $total += round($row2['pur_rate']);
                        }
                        else if($start_date == '2022-04-01' && $end_date == '2023-03-31')
                        {
                            $total += round($row2['pur_rate']);
                        } 
                    } 
                ?>
                <td width="5%" height="40px" class="rate<?php echo $i; ?>">&#x20B9; <?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total); ?></td>
                <?php
                 } ?>
            </tr>
            <tr>
                <td height="70px" width="15%" align="center" colspan="3" class="font-weight-bold h5">
                    Grand Total
                </td>
            </tr>
        </tbody>
   </table>
</div>
<div class="shadow bg-white rounded">
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <th class="bg-warning font-weight-bold h5" height="50px">
                Current Inventory (Store)
            </th>
        </thead>
        <tbody align="center">
            <tr>
                <td height="85px" width="15%" align="center" colspan="3" class="font-weight-bold h5">
                    <?php
                    $rate = 0;
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
                    
                        //rate
                        $querate="SELECT DISTINCT a.pur_rate from inward_ind a, inward_store b where   a.id = b.inward_ind_id and a.p_item = '$item' and b.item  = '$item' and b.receive_dte >='$dd' and a.p_unit = b.unit order by pur_rate DESC";
                        $resultrate=sqlsrv_query($con,$querate);
                        $rowrate=sqlsrv_fetch_array($resultrate, SQLSRV_FETCH_ASSOC);
                        
                        $rate += $rowrate['pur_rate'] * $qnty;

                        if ($qnty == 0) 
                        {
                            continue;
                        }
                    }
                    ?>
                    <button type="button" class="btn btn-light btn-lg btn-block font-weight-bold h4 createbtncurrstore" data-bs-toggle="modal" name="createbtncurrstore" id="createbtncurrstore">&#x20B9; <?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($rate)); ?></button>    

                    </td>
                </td>
            </tr>
        </tbody>
   </table>
</div>
</div>
<div id="grid">    
<div class="shadow bg-white rounded" >
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <?php
                $startdtnew = date("Y");
                $year = '2020';
                $y = 0;
                for($i=$year; $i <= $startdtnew; $i++)
                {
                   
                ?>
                <th class="bg-warning">
                    <?php echo $i."-".($i+1); ?>
                </th>
                <?php } ?>

        </thead>
        <tbody align="center">
            <tr>
            <?php
                $total2020 = 0;
                for($i=$year; $i <= $startdtnew; $i++) 
                {  
                    $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                    $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));

                    $sql2 = "SELECT sum(a.taxable_amt) as pur_rate from inward_ind a, inward_com b, rm_category c, rm_m_grade d, rm_s_grade e, rm_item f where c.c_code = d.c_code and d.m_code = e.m_code  and a.sr_no = b.sr_no and a.receive_at = b.receive_at and a.p_item = f.i_code and c.c_code = d.c_code and c.c_code = e.c_code and c.c_code = f.c_code and d.m_code = e.m_code and d.m_code = f.m_code and e.s_code = f.s_code  
                        and b.receive_date between '".$start_date."' and '".$end_date."' and c.c_code = '36'";

                    $run2=sqlsrv_query($con,$sql2);
                    $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC); ?>

                    <td width="5%" class="rateind<?php echo $i; ?>">&#x20B9; 
                        <?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($row2['pur_rate'])); ?></td>
            <?php  } ?>
            </tr>
            <tr>
                <?php 
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));
                    ?>
                <td class="font-weight-bold per<?php echo $i."_0"; ?>"></td>
                <?php } ?>
            </tr>
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                    <button type="button" class="btn btn-light btn-lg btn-block createbtn" data-bs-toggle="modal" name="createbtn" id="createbtn" data-id="2020-36">Civil Material</button>
                </td>
            </tr>
        </tbody>
   </table>
</div>

<div class="shadow bg-white rounded" >
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <?php
                for($i=$year; $i <= $startdtnew; $i++)
                {
                ?>
                <th class="bg-warning">
                    <?php echo $i."-".($i+1); ?>
                </th>
                <?php } ?>
        </thead>
        <tbody align="center">
            <tr>
            <?php
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));

                        $sql2 = "SELECT sum(a.taxable_amt) as pur_rate from inward_ind a, inward_com b, rm_category c, rm_m_grade d, rm_s_grade e, rm_item f where c.c_code = d.c_code and d.m_code = e.m_code  and a.sr_no = b.sr_no and a.receive_at = b.receive_at and a.p_item = f.i_code and c.c_code = d.c_code and c.c_code = e.c_code and c.c_code = f.c_code and d.m_code = e.m_code and d.m_code = f.m_code and e.s_code = f.s_code  
                            and b.receive_date between '".$start_date."' and '".$end_date."' and c.c_code = '38'";

                        $run2=sqlsrv_query($con,$sql2);
                        $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC); ?>

                        <td width="5%" class="rateind<?php echo $i; ?>">&#x20B9; <?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($row2['pur_rate'])); ?></td>
            <?php  } ?>
            <tr>
                <?php 
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));
                    ?>
                <td class="font-weight-bold per<?php echo $i."_1"; ?>"></td>
                <?php } ?>
            </tr>
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                    <button type="button" class="btn btn-light btn-lg btn-block createbtn" data-bs-toggle="modal" name="createbtn" id="createbtn" data-id="2020-38">Capital Item</button>
                </td>
            </tr>
        </tbody>
   </table>
</div>

<div class="shadow bg-white rounded" >
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <?php
                for($i=$year; $i <= $startdtnew; $i++)
                {
                ?>
                <th class="bg-warning">
                    <?php echo $i."-".($i+1); ?>
                </th>
                <?php } ?>
        </thead>
        <tbody align="center">
            <tr>
            <?php
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));

                        $sql2 = "SELECT sum(a.taxable_amt) as pur_rate from inward_ind a, inward_com b, rm_category c, rm_m_grade d, rm_s_grade e, rm_item f where c.c_code = d.c_code and d.m_code = e.m_code  and a.sr_no = b.sr_no and a.receive_at = b.receive_at and a.p_item = f.i_code and c.c_code = d.c_code and c.c_code = e.c_code and c.c_code = f.c_code and d.m_code = e.m_code and d.m_code = f.m_code and e.s_code = f.s_code  
                            and b.receive_date between '".$start_date."' and '".$end_date."' and c.c_code = '33'";

                        $run2=sqlsrv_query($con,$sql2);
                        $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC); ?>

                        <td width="5%"   class="rateind<?php echo $i; ?>">&#x20B9; <?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($row2['pur_rate'])); ?></td>
            <?php  } ?>
            <tr>
                <?php 
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));
                    ?>
                <td class="font-weight-bold per<?php echo $i."_2"; ?>"></td>
                <?php } ?>
            </tr>
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                    <button type="button" class="btn btn-light btn-lg btn-block createbtn" data-bs-toggle="modal" name="createbtn" id="createbtn" data-id="2020-33">Consumable</button>
                </td>
            </tr>
        </tbody>
   </table>
</div>

<div class="shadow bg-white rounded" >
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <?php
                for($i=$year; $i <= $startdtnew; $i++)
                {
                ?>
                <th class="bg-warning">
                    <?php echo $i."-".($i+1); ?>
                </th>
                <?php } ?>
        </thead>
        <tbody align="center">
            <tr>
            <?php
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));

                        $sql2 = "SELECT sum(a.taxable_amt) as pur_rate from inward_ind a, inward_com b, rm_category c, rm_m_grade d, rm_s_grade e, rm_item f where c.c_code = d.c_code and d.m_code = e.m_code  and a.sr_no = b.sr_no and a.receive_at = b.receive_at and a.p_item = f.i_code and c.c_code = d.c_code and c.c_code = e.c_code and c.c_code = f.c_code and d.m_code = e.m_code and d.m_code = f.m_code and e.s_code = f.s_code  
                            and b.receive_date between '".$start_date."' and '".$end_date."' and c.c_code = '32'";

                        $run2=sqlsrv_query($con,$sql2);
                        $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC); ?>

                        <td width="5%"   class="rateind<?php echo $i; ?>">&#x20B9; <?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($row2['pur_rate'])); ?></td>
            <?php  } ?>
            <tr>
                <?php 
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));
                    ?>
                <td class="font-weight-bold per<?php echo $i."_3"; ?>"></td>
                <?php } ?>
            </tr>
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                    <button type="button" class="btn btn-light btn-lg btn-block createbtn" data-bs-toggle="modal" name="createbtn" id="createbtn" data-id="2020-32">Electrical Material</button>
                </td>
            </tr>
        </tbody>
   </table>
</div>


<div class="shadow bg-white rounded" >
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <?php
                for($i=$year; $i <= $startdtnew; $i++)
                {
                ?>
                <th class="bg-warning">
                    <?php echo $i."-".($i+1); ?>
                </th>
                <?php } ?>
        </thead>
        <tbody align="center">
            <tr>
            <?php
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));

                        $sql2 = "SELECT sum(a.taxable_amt) as pur_rate from inward_ind a, inward_com b, rm_category c, rm_m_grade d, rm_s_grade e, rm_item f where c.c_code = d.c_code and d.m_code = e.m_code  and a.sr_no = b.sr_no and a.receive_at = b.receive_at and a.p_item = f.i_code and c.c_code = d.c_code and c.c_code = e.c_code and c.c_code = f.c_code and d.m_code = e.m_code and d.m_code = f.m_code and e.s_code = f.s_code  
                            and b.receive_date between '".$start_date."' and '".$end_date."' and c.c_code = '35'";

                        $run2=sqlsrv_query($con,$sql2);
                        $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC); ?>

                        <td width="5%"   class="rateind<?php echo $i; ?>">&#x20B9; <?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($row2['pur_rate'])); ?></td>
            <?php  } ?>
            <tr>
                <?php 
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));
                    ?>
                <td class="font-weight-bold per<?php echo $i."_4"; ?>"></td>
                <?php } ?>
            </tr>
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                    <button type="button" class="btn btn-light btn-lg btn-block createbtn" data-bs-toggle="modal" name="createbtn" id="createbtn" data-id="2020-35">General Material</button>
                </td>
            </tr>
        </tbody>
   </table>
</div>


<div class="shadow bg-white rounded" >
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <?php
                for($i=$year; $i <= $startdtnew; $i++)
                {
                ?>
                <th class="bg-warning">
                    <?php echo $i."-".($i+1); ?>
                </th>
                <?php } ?>
        </thead>
        <tbody align="center">
            <tr>
            <?php
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));

                        $sql2 = "SELECT sum(a.taxable_amt) as pur_rate from inward_ind a, inward_com b, rm_category c, rm_m_grade d, rm_s_grade e, rm_item f where c.c_code = d.c_code and d.m_code = e.m_code  and a.sr_no = b.sr_no and a.receive_at = b.receive_at and a.p_item = f.i_code and c.c_code = d.c_code and c.c_code = e.c_code and c.c_code = f.c_code and d.m_code = e.m_code and d.m_code = f.m_code and e.s_code = f.s_code  
                            and b.receive_date between '".$start_date."' and '".$end_date."' and c.c_code = '34'";
                        //echo $sql2;    
                        $run2=sqlsrv_query($con,$sql2);
                        $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC); ?>

                        <td width="5%"   class="rateind<?php echo $i; ?>">&#x20B9; <?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($row2['pur_rate'])); ?></td>
            <?php  } ?>
            <tr>
                <?php 
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));
                    ?>
                <td class="font-weight-bold per<?php echo $i."_5"; ?>"></td>
                <?php } ?>
            </tr>
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                    <button type="button" class="btn btn-light btn-lg btn-block createbtn" data-bs-toggle="modal" name="createbtn" id="createbtn" data-id="2020-34">Lab Items</button>
                </td>
            </tr>
        </tbody>
   </table>
</div>

<div class="shadow bg-white rounded" >
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <?php
                for($i=$year; $i <= $startdtnew; $i++)
                {
                ?>
                <th class="bg-warning">
                    <?php echo $i."-".($i+1); ?>
                </th>
                <?php } ?>
        </thead>
        <tbody align="center">
            <tr>
            <?php
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));

                        $sql2 = "SELECT sum(a.taxable_amt) as pur_rate from inward_ind a, inward_com b, rm_category c, rm_m_grade d, rm_s_grade e, rm_item f where c.c_code = d.c_code and d.m_code = e.m_code  and a.sr_no = b.sr_no and a.receive_at = b.receive_at and a.p_item = f.i_code and c.c_code = d.c_code and c.c_code = e.c_code and c.c_code = f.c_code and d.m_code = e.m_code and d.m_code = f.m_code and e.s_code = f.s_code  
                            and b.receive_date between '".$start_date."' and '".$end_date."' and c.c_code = '31'";

                        $run2=sqlsrv_query($con,$sql2);
                        $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC); ?>

                        <td width="5%"   class="rateind<?php echo $i; ?>">&#x20B9; <?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($row2['pur_rate'])); ?></td>
            <?php  } ?>
            <tr>
                <?php 
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));
                    ?>
                <td class="font-weight-bold per<?php echo $i."_6"; ?>"></td>
                <?php } ?>
            </tr>
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                    <button type="button" class="btn btn-light btn-lg btn-block createbtn" data-bs-toggle="modal" name="createbtn" id="createbtn" data-id="2020-31">Mechanical Material</button>
                </td>
            </tr>
        </tbody>
   </table>
</div>


<div class="shadow bg-white rounded" >
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <?php
                for($i=$year; $i <= $startdtnew; $i++)
                {
                ?>
                <th class="bg-warning">
                    <?php echo $i."-".($i+1); ?>
                </th>
                <?php } ?>
        </thead>
        <tbody align="center">
            <tr>
            <?php
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));

                        $sql2 = "SELECT sum(a.taxable_amt) as pur_rate from inward_ind a, inward_com b, rm_category c, rm_m_grade d, rm_s_grade e, rm_item f where c.c_code = d.c_code and d.m_code = e.m_code  and a.sr_no = b.sr_no and a.receive_at = b.receive_at and a.p_item = f.i_code and c.c_code = d.c_code and c.c_code = e.c_code and c.c_code = f.c_code and d.m_code = e.m_code and d.m_code = f.m_code and e.s_code = f.s_code  
                            and b.receive_date between '".$start_date."' and '".$end_date."' and c.c_code = '40'";

                        $run2=sqlsrv_query($con,$sql2);
                        $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC); ?>

                        <td width="5%"   class="rateind<?php echo $i; ?>">&#x20B9; <?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($row2['pur_rate'])); ?></td>
            <?php  } ?>
            <tr>
                <?php 
                    for($i=$year; $i <= $startdtnew; $i++) 
                    {  
                        $start_date = date('Y-m-d',strtotime(($i).'-04-01'));
                        $end_date = date('Y-m-d',strtotime(($i+1).'-03-31'));
                    ?>
                <td class="font-weight-bold per<?php echo $i."_7"; ?>"></td>
                <?php } ?>
            </tr>
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                    <button type="button" class="btn btn-light btn-lg btn-block createbtn" data-bs-toggle="modal" name="createbtn" id="createbtn" data-id="2020-40">Service/Labor/Repairing/Job work</button>
                </td>
            </tr>
        </tbody>
   </table>
</div>

<div class="shadow bg-white rounded" >
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <th class="bg-info h5 text-white">
                   Pending PO
            </th>
        </thead>
        <tbody align="center">
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                    <?php
                    $sql = "SELECT distinct a.id from po_entry_head a left outer join 
rm_party_master b on b.pid = a.party left join po_entry_details c on c.iid = a.id where  a.po_date > '2021-06-01' 
and DATEDIFF(day, format(a.mat_req_date,'yyyy-MM-dd'),GETDATE()) > 0 and c.id NOT IN(SELECT iid from inward_ind) and c.isCancle IS NULL order by a.id desc";
                    $stmt = sqlsrv_query( $con, $sql , array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));  
                    $row_count1 = sqlsrv_num_rows( $stmt );  
                    $run = sqlsrv_query($con,$sql);
                    $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
                    ?>
                    <button type="button" class="btn btn-light btn-lg btn-block font-weight-bold h5 createbtnpo" data-bs-toggle="modal" name="createbtnpo" id="createbtnpo"><?php echo $row_count1; ?></button>
                </td>
            </tr>
        </tbody>
   </table>
</div>
<div class="shadow bg-white rounded" >
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <th class="bg-info h5 text-white">
                   Pending PO (Advance)
            </th>
        </thead>
        <tbody align="center">
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                    <?php
                    $sql = "SELECT distinct a.id, a.adv_amt from po_entry_head a left outer join 
rm_party_master b on b.pid = a.party left join po_entry_details c on c.iid = a.id where  a.po_date > '2021-06-01' 
and DATEDIFF(day, format(a.mat_req_date,'yyyy-MM-dd'),GETDATE()) > 0 and c.id NOT IN(SELECT iid from inward_ind) and c.isCancle IS NULL
and a.adv_amt IS NOT NULL and a.adv_amt <> 0 order by a.id desc";
                    $stmt = sqlsrv_query( $con, $sql , array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));  
                    $row_count1 = sqlsrv_num_rows( $stmt );  
                    $run = sqlsrv_query($con,$sql);
                    $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
                    ?>
                    <button type="button" class="btn btn-light btn-lg btn-block font-weight-bold h5 createbtnpoadvamt" data-bs-toggle="modal" name="createbtnpoadvamt" id="createbtnpoadvamt"><?php echo $row_count1; ?></button>
                </td>
            </tr>
        </tbody>
   </table>
</div>
<div class="shadow bg-white rounded">
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <th class="bg-info h5 text-white">
                Qty Mismatch PO
            </th>
        </thead>
        <tbody align="center">
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                    <?php
                    $sql = "SELECT a.id,a.po_date,c.party_name,a.po_gen_by,d.item,b.qnty,(SELECT sum(rec_qnty) from inward_ind where iid = b.id) as pur_qnty from po_entry_head a left outer join po_entry_details b on a.id = b.iid left outer join rm_party_master c on a.party = c.pid left outer join rm_item d on b.item_code = d.i_code left outer join rm_category e on d.c_code = e.c_code where b.qnty < (SELECT sum(rec_qnty) from inward_ind where iid = b.id) and a.po_date > '2021-06-01' and e.c_code <> 30";

                    $stmt = sqlsrv_query( $con, $sql , array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));  
                    $row_count = sqlsrv_num_rows( $stmt );  
                    $run = sqlsrv_query($con,$sql);
                    $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

                    
                    ?>
                    <button type="button" class="btn btn-light btn-lg btn-block font-weight-bold h5 createbtnqtymissmatch" data-bs-toggle="modal" name="createbtnqtymissmatch" id="createbtnqtymissmatch"><?php echo $row_count; ?></button>
                </td>
            </tr>
        </tbody>
   </table>
</div>
<div class="shadow bg-white rounded">
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <th class="bg-info h5 text-white">
                Rate/Value Mismatch PO
            </th>
        </thead>
        <tbody align="center">
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                <?php
                    $sql = "SELECT a.id,a.po_date,c.party_name,a.po_gen_by,d.item,b.rate,(SELECT avg(pur_rate) from inward_ind where iid = b.id) as pur_rate
from po_entry_head a left outer join po_entry_details b on a.id = b.iid left outer join rm_party_master c on a.party = c.pid
left outer join rm_item d on b.item_code = d.i_code left outer join rm_category e on d.c_code = e.c_code where b.rate < (SELECT sum(pur_rate) from inward_ind where iid = b.id) and a.po_date > '2021-06-01' and e.c_code <> 30";
                    $stmt = sqlsrv_query( $con, $sql , array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));  
                    $row_count = sqlsrv_num_rows( $stmt );  
                    $run = sqlsrv_query($con,$sql);
                    $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
                    
                ?>
                    <button type="button" class="btn btn-light btn-lg btn-block font-weight-bold h5 createbtnratemissmatch" data-bs-toggle="modal" name="createbtnratemissmatch" id="createbtnratemissmatch"><?php echo $row_count; ?></button>
                </td>
            </tr>
        </tbody>
   </table>
</div>
<div class="shadow bg-white rounded">
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <th class="bg-info h5 text-white">
                Late Delivery PO 
            </th>
        </thead>
        <tbody align="center">
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                <?php
                 $sql = "SELECT DISTINCT c.id, c.po_gen_by, c.mat_req_date, b.receive_date, format(c.mat_req_date,'dd-MMM-yyyy') as reqDate, format(b.receive_date,'dd-MMM-yyyy') as rec_Date, d.party_name from inward_ind a left join inward_com b on a.sr_no = b.sr_no and a.receive_at = b.receive_at
left join po_entry_head c on a.p_po_no = c.po_no left outer join rm_party_master d  on d.pid = c.party and d.pid = b.mat_from_party where  b.receive_date > c.mat_req_date and c.mat_req_date > '2015-01-01' and c.mat_req_date IS NOT NULL";

                    $stmt = sqlsrv_query( $con, $sql , array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));  
                    $row_count = sqlsrv_num_rows( $stmt );  
                    $run = sqlsrv_query($con,$sql);
                    $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
                    
                ?>
                    <button type="button" class="btn btn-light btn-lg btn-block font-weight-bold h5 createbtnlatedpo" data-bs-toggle="modal" name="createbtnlatedpo" id="createbtnlatedpo"><?php echo round($row_count); ?></button>
                </td>
            </tr>
        </tbody>
   </table>
</div>
<div class="shadow bg-white rounded">
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <th class="bg-info h5 text-white">
                Pending Approvals
            </th>
        </thead>
        <tbody align="center">
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                <?php
                    $sql = "SELECT count(sr_no) as PendingAppCount from inward_com where bill_send = 1 AND bill_receive= 1 AND bill_approve = 0";
                    $run = sqlsrv_query($con,$sql);
                    $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
                ?>
                    <button type="button" class="btn btn-light btn-lg btn-block font-weight-bold h5 createbtnpendingaprv" data-bs-toggle="modal" name="createbtnpendingaprv" id="createbtnpendingaprv"><?php echo round($row['PendingAppCount']); ?></button>
                </td>
            </tr>
        </tbody>
   </table>
</div>
<div class="shadow bg-white rounded">
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <th class="bg-info h5 text-white">
                Pending MRS
            </th>
        </thead>
        <tbody align="center">
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                <?php
                $count = 0;
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
                                $count++;
                            }
                    // $stmt = sqlsrv_query( $con, $sql , array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));  
                    // $row_count = sqlsrv_num_rows( $stmt );  
                    // $run = sqlsrv_query($con,$sql);
                    // $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
                ?>
                    <button type="button" class="btn btn-light btn-lg btn-block font-weight-bold h5 createbtnpendingamrs" data-bs-toggle="modal" name="createbtnpendingamrs" id="createbtnpendingamrs"><?php echo $count; ?></button>
                </td>
            </tr>
        </tbody>
   </table>
</div>
<div class="shadow bg-white rounded">
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <th class="bg-info h5 text-white">
                 -ve Stock Items
            </th>
        </thead>
        <tbody align="center">
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                <?php

                $totalqnty = 0;
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

                    
                        if ($qnty == 0) 
                        {
                            continue;
                        }
                        if($qnty < 0) 
                        {
                            $totalqnty++;
                        }
                    }
                ?>
                    <button type="button" class="btn btn-light btn-lg btn-block font-weight-bold h5 createbtnstock" data-bs-toggle="modal" name="createbtnstock" id="createbtnstock"><?php echo $totalqnty; ?></button>
                </td>
            </tr>
        </tbody>
   </table>
</div>
<div class="shadow bg-white rounded">
   <table cellpadding="0" cellspacing="0" border="1">
        <thead align="center">
            <th class="bg-info h5 text-white">
                Pending Inward
            </th>
        </thead>
        <tbody align="center">
            <tr>
                <td height="50px" width="15%" align="center" colspan="3" class="font-weight-bold">
                <?php
                include('../dbmysqlcon.php');

                    $sql = "SELECT count(cm.id) as inwardpendingcount from challan_master cm,challan_detail cd where cm.id = cd.id and cm.returnable = 'Returnable'";
                    $result = mysqli_query($mysqlconn,$sql);
                    $row = mysqli_fetch_assoc($result);
                ?>
                    <button type="button" class="btn btn-light btn-lg btn-block font-weight-bold h5 createbtninwardpending" data-bs-toggle="modal" name="createbtninwardpending" id="createbtninwardpending"><?php echo $row['inwardpendingcount']; ?></button>
                </td>
            </tr>
        </tbody>
   </table>
</div>
<script type="text/javascript">
		$('.createbtn').on('click',function()
        {
           var val = $(this).attr('data-id');
           var str = val.split("-");

           $.ajax({
                url: "dashboard_ajax.php?status=0",
                type: 'post',
                data: {year:str[0],ccode:str[1]},
                success: function(data) 
                {
                    $('#create').modal('show');
                    $("#t_body_create").html(data);
                },
               
            });
        });

        
        $('.createbtncurrstore').on('click',function()
        {
            $('#t_body_createstore').html('<div id="loader"></div>');
            $('#createstore').modal('show');        
           $.ajax({
                url: "dashboard_ajax.php?status=11",
                type: 'post',
                success: function(data) 
                {
                    $("#t_body_createstore").html(data);
                },
               
            });
        });


        $('.createbtnpo').on('click',function()
        {
            $('#t_body_createpo').html('<div id="loader"></div>');
            $('#creatependingpo').modal('show');        
           $.ajax({
                url: "dashboard_ajax.php?status=2",
                type: 'post',
                success: function(data) 
                {
                    $("#t_body_createpo").html(data);
                },
               
            });
        });


        $('.createbtnpoadvamt').on('click',function()
        {
            $('#t_body_createpoadv').html('<div id="loader"></div>');
            $('#creatependingpoadv').modal('show');        
           $.ajax({
                url: "dashboard_ajax.php?status=9",
                type: 'post',
                success: function(data) 
                {
                    $("#t_body_createpoadv").html(data);
                },
               
            });
        });

        $('.createbtnqtymissmatch').on('click',function()
        {
           $('#t_body_createqtymissmatch').html('<div id="loader"></div>');
           $('#createqtymissmatch').modal('show');
           $.ajax
           ({
                url: "dashboard_ajax.php?status=3",
                type: 'post',
                success: function(data) 
                {
                    $("#t_body_createqtymissmatch").html(data);
                },
            });
        });


        $('.createbtnratemissmatch').on('click',function()
        {
            $('#t_body_createratemissmatch').html('<div id="loader"></div>');
           $('#createratemissmatch').modal('show');
           $.ajax({
                url: "dashboard_ajax.php?status=4",
                type: 'post',
                success: function(data) 
                {
                    $("#t_body_createratemissmatch").html(data);
                },
               
            });
        });


        $('.createbtnlatedpo').on('click',function()
        {
            $('#t_body_createlatedelpo').html('<div id="loader"></div>');
           $('#createlatedelPO').modal('show');
           $.ajax({
                url: "dashboard_ajax.php?status=5",
                type: 'post',
                success: function(data) 
                {
                    $("#t_body_createlatedelpo").html(data);
                },
               
            });
        });

        $('.createbtnpendingaprv').on('click',function()
        {
            $('#t_body_createpenapv').html('<div id="loader"></div>');
           $('#createpenapproval').modal('show');
           $.ajax({
                url: "dashboard_ajax.php?status=6",
                type: 'post',
                success: function(data) 
                {
                    $("#t_body_createpenapv").html(data);
                },
               
            });
        });


        $('.createbtnpendingamrs').on('click',function()
        {
             $('#t_body_createpenmrs').html('<div id="loader"></div>');
           $('#createpenmrs').modal('show');
           $.ajax({
                url: "dashboard_ajax.php?status=7",
                type: 'post',
                success: function(data) 
                {
                    $("#t_body_createpenmrs").html(data);
                },
               
            });
        });


        $('.createbtnstock').on('click',function()
        {
             $('#t_body_createnegetivestock').html('<div id="loader"></div>');
           $('#createnegetivestock').modal('show');
           $.ajax({
                url: "dashboard_ajax.php?status=8",
                type: 'post',
                success: function(data) 
                {
                   $("#t_body_createnegetivestock").html(data);
                },
            });
        });


        $('.createbtninwardpending').on('click',function()
        {
            $('#t_body_createinwardpending').html('<div id="loader"></div>');
           $('#createbtninwardmodal').modal('show');
           $.ajax({
                url: "dashboard_ajax.php?status=10",
                type: 'post',
                success: function(data) 
                {
                   $("#t_body_createinwardpending").html(data);
                },
               
            });
        });


        $(document).on('click', '.viewPo', function()
         {
            var id = $(this).attr("id"); 
            $('#pono').text(id); 
             $.ajax({
                url:"viewPendingPoItem.php",
                method:"POST",
                data:{id:id},
                success:function(data)
                {
                    $('#creatependingpoitem').modal('show');
                    $('#t_body_createpoitem').html(data);
                }
                });
          });


        $(document).on('click', '.viewPoAdv', function()
         {
            var id = $(this).attr("id"); 
            $('#ponoadv').text(id); 
             $.ajax({
                url:"viewPendingPoItemAdv.php",
                method:"POST",
                data:{id:id},
                success:function(data)
                {
                    $('#creatependingpoitemadv').modal('show');
                    $('#t_body_createpoitemAdv').html(data);
                }
                });
          });




        $(document).on('click', '.viewPoStore', function()
         {
            var id = $(this).attr("id"); 
            $('#itemno').text(id); 
             $.ajax({
                url:"viewStoreItem.php",
                method:"POST",
                data:{id:id},
                success:function(data)
                {
                    $('#createstoreitem').modal('show');
                    $('#t_body_createstoreitem').html(data);
                    
                }
                });
          });


$(document).ready(function() 
        {
            var str = $('.rate2020').text();
            var rate2020_old = str.substring(1);
            var rate2020 = rate2020_old.replace(/,/g , '');

            var rateind2020 = [];
            var rateind2020_old = [];
            var text = [];
            j = 0;

            $('.rateind2020').each(function(i)
            {
                text[i] = $(this).text();
                if(text[i] == 0)
                {
                    rateind2020[i] = text[i];
                }
                else
                {
                    rateind2020_old[i] = text[i].substring(1);
                    rateind2020[i] = rateind2020_old[i].replace(/,/g , '');
                }
                $('.per2020_'+j).text(rateind2020[j]);
            });
            var length2020 = rateind2020.length;
            while(length2020 > 0)
            {
                var cal = (parseInt(rateind2020[j]) / parseInt(rate2020)) * 100;
                $('.per2020_'+j).text(cal.toFixed(2)+" %");
                length2020--;
                j++;
            }
            /*===================*/

            var str = $('.rate2021').text();
            var rate2021_old = str.substring(1);
            var rate2021 = rate2021_old.replace(/,/g , '');

            var rateind2021 = [];
            var rateind2021_old = [];
            var text1 = [];
            j = 0;

            $('.rateind2021').each(function(i)
            {
                text1[i] = $(this).text();
                if(text1[i] == 0)
                {
                    rateind2021[i] = text1[i];
                }
                else
                {
                    rateind2021_old[i] = text1[i].substring(1);
                    rateind2021[i] = rateind2021_old[i].replace(/,/g , '');
                }
                $('.per2021_'+j).text(rateind2021[j]);
            });
            var length2021 = rateind2021.length;
            while(length2021 > 0)
            {
                var cal = (parseInt(rateind2021[j]) / parseInt(rate2021)) * 100;
                $('.per2021_'+j).text(cal.toFixed(2)+" %");
                length2021--;
                j++;
            }
            /*===================*/
            var str = $('.rate2022').text();
            var rate2022_old = str.substring(1);
            var rate2022 = rate2022_old.replace(/,/g , '');

            var rateind2022 = [];
            var rateind2022_old = [];
            var text2 = [];
            j = 0;

            $('.rateind2022').each(function(i)
            {
                text2[i] = $(this).text();
                if(text2[i] == 0)
                {
                    rateind2022[i] = text2[i];
                }
                else
                {
                    rateind2022_old[i] = text2[i].substring(1);
                    rateind2022[i] = rateind2022_old[i].replace(/,/g , '');
                }
                
                $('.per2022_'+j).text(rateind2022[j]);
            });
            var length2022 = rateind2022.length;
            while(length2022 > 0)
            {
                var cal = (parseInt(rateind2022[j]) / parseInt(rate2022)) * 100;
                $('.per2022_'+j).text(cal.toFixed(2)+" %");
                length2022--;
                j++;
            }   
        });
        
</script>