<?php
//Get Friend Requests
include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
    $data = json_decode($json);
 
    $userid = $data->userid;

$sql1 = mysql_query("Select username,ssid from request_networks where user_id1 like '$userid' and pushed like '0' Order by id desc Limit 1");

while($row = mysql_fetch_assoc($sql1))
{
	$output[] = $row;
	mysql_query("Update request_networks set pushed=1 where user_id1 like '$userid' Order by id desc Limit 1");
}

print(json_encode($output));
    	
mysql_close($con);
?>