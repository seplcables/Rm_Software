<?php

//select.php

$connect = new PDO('sqlsrv:Server=192.168.0.245;Database=RM_software', 'sa', 'suyog@123');

$query = "SELECT * FROM delivery_location";

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