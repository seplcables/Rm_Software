<?php
session_start();

include('..\..\dbcon.php');

date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d h:i:s a', time());
$time = date('h_i', time());

if($_POST['reasonu'] == 0) //tc-upload
{

    $rmtaid = explode("~",$_POST['idu']);
    
    $img1 = $_FILES['myfiledocu']['name'];//name is keyboard
    $imgExt1 = substr($img1, strripos($img1, '.')); // get file extention
    
    $img_sr= "TC_".$rmtaid[0]."_".$rmtaid[1]."_".$time;
    $filname= $img_sr.$imgExt1;

    $query = "UPDATE rm_tcreceipt_pdf set Name = '".$filname."' , uploadurl = 'tc', UpdateTimeStamp = '".$date."' where TCReceiptIDP = '".$rmtaid[3]."'";

      $run = sqlsrv_query($con,$query);
      
      if($run)
      {
        
        $img = $_FILES['myfiledocu']['name'];//name is keyboard
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
          move_uploaded_file($_FILES["myfiledocu"]["tmp_name"], "tcreceipt/" . $imgname);
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
else if($_POST['reasonu'] == 1) //remarks
{
  $rmtaid = explode("~",$_POST['idur']);
  $tcremarksu = $_POST['tcremarksu'];

  
    $query = "UPDATE rm_tcreceipt_pdf set Remarks = '".$tcremarksu."', uploadurl = 'tc', UpdateTimeStamp = '".$date."' where TCReceiptIDP = '".$rmtaid[3]."'";
    $run = sqlsrv_query($con,$query);
    if($run)
    {
      ?>
          <script type="text/javascript">
            alert('Remarks Updated Successfully');
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