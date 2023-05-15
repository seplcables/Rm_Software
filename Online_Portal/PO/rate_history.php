<?php  
 //fetch.php 
 session_start(); 
 if(isset($_POST["iitem"]))  
 {  
      $_SESSION['item_n'] = $_POST["iitem"];

 }  
 ?>