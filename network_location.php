<?php
//Network Location
include "connection.php";


if( $_GET["uid"] || $_GET["networkname"] || $_GET["longitude"]  )
  {

$uid           = $_REQUEST['uid'];
$networkname   = $_REQUEST['networkname'];
$longitude     = $_REQUEST['longitude'];
$latitude      = $_REQUEST['latitude'];
$location      = $_REQUEST['location'];

mysql_query("INSERT INTO `network_location`( `uid`, `network`, `longitude`, `latitude`, `location`) VALUES ('$uid','$networkname','$longitude','$latitude','$location')");
// echo "Location Updated";
echo json_encode(array('result' => "Location Updated");
} else {
	echo json_encode(array('result' => "Request Error");
}

mysql_close($con);
?>