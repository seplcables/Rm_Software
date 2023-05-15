<?php
include('..\..\dbcon.php');
if (isset($_POST['id'])) {
   $id = $_POST['id'];
   $qry = "SELECT * from rm_master where item_description like '%$id%'";
   $params = array();
   $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
   $run=sqlsrv_query($con,$qry,$params,$options);
   $row=sqlsrv_num_rows($run);
   $output="<ul class='list-unstyled'>";
      if ($row > 0) {
         while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
            $output .= "<li>".$row['item_description']."</li>";
            
         }
      }
      else {
         $output = "No Record Found";  
      }
      $output .= "</ul>";
      echo $output;
   }
   ?>