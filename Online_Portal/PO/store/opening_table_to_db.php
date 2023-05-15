<?php
session_start();
$user = $_SESSION['oid'];
date_default_timezone_set('Asia/Kolkata');
$date = date('m/d/Y h:i:s a', time());
include('..\..\..\dbcon.php');
if (isset($_POST['save']))
{
$qnty = $_POST['qnty'];
$remark = $_POST['remark'];
$i_code = $_POST['i_code'];
$s_code = $_POST['s_code'];
$m_code = $_POST['m_code'];
$c_code = $_POST['c_code'];
$unit = $_POST['unit'];
$ope_date = $_POST['ope_date'];

foreach ($qnty as $key => $value) {
if ($value == '') {
continue;
}
$query = "INSERT INTO inward_store(receive_dte,inward_ind_id,item,qnty,unit,username,come_from,createdAt,remark) VALUES ('$ope_date','0','".$i_code[$key]."','".$value."','".$unit[$key]."','$user','opening','$date','".$remark[$key]."')";
$result = sqlsrv_query($con,$query);
if($result == true)
{
?>
<script>
alert('Data Saved !!');
window.open('opening_table.php','_self');

</script>
<?php
}
else{

print_r(sqlsrv_errors());
}
}

}
?>