<?php

//select.php
$srno = $_POST['srno'];
$connect = new PDO('sqlsrv:Server=192.168.0.245;Database=RM_software', 'sa', 'suyog@123');

$query = "SELECT title,descriptions FROM po_terms where po_id='$srno' union select title,descriptions from note order by descriptions desc";

$statement = $connect->prepare($query);

if($statement->execute())
{
 while($row = $statement->fetch(PDO::FETCH_ASSOC))
 {
  $data[] = $row;
 }

 echo json_encode($data);
}

?>