<?php
include('../dbcon.php');
if(isset($_POST['id']))
{
?>

<table cellpadding="0" cellspacing="0" border="1" width="100%">
    <tr class="bg-secondary text-white">
        <th>Item</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Rate</th>
        <th>Basic Rate</th>
    </tr>
    <?php
    $sql = "SELECT a.id,a.iid,a.qnty,a.unit,a.rate,b.item,a.basic_rate from po_entry_details a left outer join rm_item b on a.item_code = b.i_code where a.id NOT IN(select iid from inward_ind) and a.isCancle IS NULL and a.iid = '".$_POST['id']."'";

    //$sql = "SELECT a.id,a.qnty,a.unit,a.rate,b.item,a.basic_rate from po_entry_details a left outer join rm_item b on a.item_code = b.i_code where isCancle is NULL and a.iid = '".$_POST['id']."'";
$run = sqlsrv_query($con,$sql);

    while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
    {
        ?>
    <tr class="text-center font-italic">
        <td><?php echo $row['item']; ?></td>
        <td><?php echo $row['qnty']; ?></td>
        <td><?php echo $row['unit']; ?></td>
        <td><?php echo $row['rate']; ?></td>
        <td><?php echo $row['qnty']*$row['rate']; ?></td>
    </tr>
<?php } ?>
</table>
<?php 
}       
?>  
