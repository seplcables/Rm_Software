<?php 
$serverName = "192.168.1.163";
$connectionInfo = array("Database"=>"HR","UID"=>"sa","PWD"=>"12345","CharacterSet" => "UTF-8");
$conhr =sqlsrv_connect($serverName,$connectionInfo);

if($conhr) {
	/*echo "connection established.<br />";*/
	
}else{
	echo "connection could not be established.<br />";
	die(print_r( sqlsrv_errors(), true));
	
}
?>