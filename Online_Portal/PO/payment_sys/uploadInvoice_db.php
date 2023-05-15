<?php
//delete.php
session_start();
$user = $_SESSION['oid'];
date_default_timezone_set('Asia/Kolkata');
$date = date('m/d/Y h:i:s a', time());
$pdftime = date('dmYHi', time());
include('..\..\..\dbcon.php');

if(isset($_POST["value"]))
{
 foreach($_POST["value"] as $key => $value)
 {
    if ($value == '') {
        continue;
    }

      $NAName = $_FILES["upload"]["name"][$key];
      $NAExt = substr($NAName, strripos($NAName, '.')); // get file extention
      $upload = $value. $pdftime . $NAExt;
      move_uploaded_file($_FILES["upload"]["tmp_name"][$key], "Invoice/" . $upload);

  $query = "UPDATE inward_com set invUploaded_by='$user',invUpload_time='$date',invoice_aprove = '".$upload."' WHERE CONCAT(sr_no,receive_at) = '".$value."'";
  $run = sqlsrv_query($con,$query);
 }
 if ($run) {
     echo "Uploaded SuccessFully!!!! ";
 }
 else{
        print_r(sqlsrv_errors());
 }
}
?>
