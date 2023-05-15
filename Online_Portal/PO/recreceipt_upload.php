<?php
session_start();

include('..\..\dbcon.php');


date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d h:i:s a', time());

if($_POST['reason'] == 0) //tc-upload
{
  $rmtaid = explode("~",$_POST['id']);

  $img1 = $_FILES['myfiledoc']['name'];//name is keyboard
  $imgExt1 = substr($img1, strripos($img1, '.')); // get file extention

  $img_sr= "TC_".$rmtaid[0]."_".$rmtaid[1];
  $filname= $img_sr.$imgExt1;

    //$query = "INSERT INTO rm_tcreceipt_pdf(Name,SrNo, receive_at, item_code,Status,TimeStamp) VALUES ('".$filname."','".$rmtaid[0]."','".$rmtaid[1]."', '".$rmtaid[3]."','1','$date')";
    $query = "INSERT INTO rm_tcreceipt_pdf(Name, SrNo, receive_at, uploadurl, Status,TimeStamp) VALUES ('".$filname."','".$rmtaid[0]."','".$rmtaid[1]."','tc', '1','$date')";      
    $run = sqlsrv_query($con,$query);
    if($run)
    {
      
      $img = $_FILES['myfiledoc']['name'];//name is keyboard
      $imgExt = substr($img, strripos($img, '.')); // get file extention

      date_default_timezone_set('Asia/Kolkata');
      $date = date('Y-m-d h:i:s', time());

      if($imgExt == '') 
      {
        $imgname = 0;
        $Invoice_img_timestamp = '';
        header("Location:tcreceipt_report.php");
      }
      else{
        $Invoice_img_timestamp = $date;
        $imgname = $img_sr . $imgExt;
        move_uploaded_file($_FILES["myfiledoc"]["tmp_name"], "tcreceipt/" . $imgname);
        //move_uploaded_file($_FILES["myfiledoc"]["tmp_name"], "invoice_img/" . $imgname);
       ?>
          <script type="text/javascript">
            alert('TC Uploaded Successfully');
            window.open('tcreceipt_report.php','_self');
          </script>
        <?php
      }  
  }
  else
  {
      ?>
        <script type="text/javascript">
          alert('something went wrong');
          window.open('tcreceipt_report.php','_self');
        </script>
      <?php
  }
}
else if($_POST['reason'] == 1) //remarks
{
    $rmtaid = explode("~",$_POST['idr']);
    $tcremarks = $_POST['tcremarks'];

    //$query = "INSERT INTO rm_tcreceipt_pdf(Remarks,SrNo, receive_at, item_code,Status,TimeStamp) VALUES ('".$tcremarks."','".$rmtaid[0]."','".$rmtaid[1]."', '".$rmtaid[3]."','1','$date')";
    $query = "INSERT INTO rm_tcreceipt_pdf(Remarks,SrNo, receive_at, uploadurl, Status,TimeStamp) VALUES ('".$tcremarks."','".$rmtaid[0]."','".$rmtaid[1]."','tc', '1','$date')";
    $run = sqlsrv_query($con,$query);
    if($run)
    {
       ?>
          <script type="text/javascript">
            alert('Remarks added Successfully');
            window.open('tcreceipt_report.php','_self');
          </script>
        <?php
      }  
  
  else
  {
      ?>
        <script type="text/javascript">
          alert('something went wrong');
          window.open('tcreceipt_report.php','_self');
        </script>
      <?php
  }
}

?>