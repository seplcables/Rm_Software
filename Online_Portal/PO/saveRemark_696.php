<?php
include('..\..\dbcon.php');

date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d h:i:s a', time());


if(isset($_POST['inwardid']))
{
    $inwardid = $_POST['inwardid'];
    $remark1 = $_POST['remark1'];
    $remark2 = $_POST['remark2'];

    foreach($inwardid as $key=>$value)
    {
      if($inwardid[$key] == '')
      {
        continue;
      }

      $sql = "SELECT count(Inwrd_ind_IDP) as id  FROM rm_remarks_696 where Inwrd_ind_IDP = '".$inwardid[$key]."'";
      $query = sqlsrv_query($con,$sql);
      $row = sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC);

      if($row['id'] > 0)
      {
         
        $update = "UPDATE rm_remarks_696 SET Remarks1 = '".$remark1[$key]."', Remarks2 = '".$remark2[$key]."', TimeStamp = '".$date."' where Inwrd_ind_IDP = '".$inwardid[$key]."'";
        $run = sqlsrv_query($con,$update); 
      }
      else if($row['id'] == 0)
      {
        $insert = "INSERT INTO rm_remarks_696(PlantName, Remarks1, Remarks2, Inwrd_ind_IDP, Status, TimeStamp) values('696','".$remark1[$key]."','".$remark2[$key]."','".$inwardid[$key]."','1','$date')"; 

        //echo $insert;  
        $run = sqlsrv_query($con,$insert);
        
      }
     
    }
    if(!$run)
    {
      echo sqlsrv_errors();
    }
    else
    {
      echo "Data Updated Succesfuly";
    }

}
?>