<?php  
 //fetch.php 
 include('../../dbcon.php');  
 if(isset($_POST["id"]))  
 {  
      $query = "SELECT * from po_entry_details where id='".$_POST["id"]."'";  
      $result = sqlsrv_query($con, $query);  
      $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC); 
       
      echo json_encode($row);  
 }  
 ?>