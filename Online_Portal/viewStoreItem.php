<?php
include('../dbcon.php');
if(isset($_POST['id']))
{
?>

<table cellpadding="0" cellspacing="0" border="1" width="100%">
    <tr class="bg-secondary text-white">
        <th>Date</th>
      <th>Qnty</th>
      <th>Unit</th>
      <th>Note</th>
    </tr>
    <?php
    $item = $_POST['id'];
    $sql="SELECT MAX(opening_date) as last_date FROM store_opening_date";
        $run=sqlsrv_query($con,$sql);
        $rowa = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
        $dd = $rowa['last_date']->format('d-M-y');

$query = "SELECT receive_dte,qnty,unit,come_from FROM inward_store WHERE receive_dte >= '$dd' and item = '".$item."'";
$result = sqlsrv_query($con,$query);
$query1 = "SELECT issue_date,qnty,unit,dpnt FROM rm_issue WHERE issue_date >= '$dd' and issue_from = 'store' and item_name = '".$item."'";
$result1 = sqlsrv_query($con,$query1);

   $tqnty = 0;
    while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
    {
      $tqnty += floatval($row['qnty']);
        ?>
    <tr class="font-italic text-center">
        <td><?php echo $row['receive_dte']->format('d.M.y'); ?></td>
        <td><?php echo $row['qnty']; ?></td>
        <td><?php echo $row['unit']; ?></td>
        <td><?php echo $row['come_from']; ?></td>
    </tr>
      
<?php } ?>
    <tr style="background:MediumSpringGreen;">
        <td colspan="3" align="right">Total Opening=></td>
        <td align="center"><?php echo $tqnty; ?></td>
    </tr> 
<?php

$iqnty = 0;
    while($row1 = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC))
    { 
        $iqnty += floatval($row1['qnty']);
    ?>
    <tr class="font-italic text-center">
        <td><?php echo $row1['issue_date']->format('d.M.y'); ?></td>
        <td><?php echo $row1['qnty']; ?></td>
        <td><?php echo $row1['unit']; ?></td>
        <td><?php echo $row1['dpnt']; ?></td>
    </tr>
    
    <?php } ?>
    <tr style="background:yellow;">
        <td colspan="3" align="right">Total Issue=></td>
        <td align="center"><?php echo $iqnty; ?></td>
    </tr> 
</table>
<?php 
}       
?>  
