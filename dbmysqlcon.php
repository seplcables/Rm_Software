<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "in_out";

// Create connection
$mysqlconn = mysqli_connect($servername, $username, $password,$dbname);
// Check connection
if (!$mysqlconn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>