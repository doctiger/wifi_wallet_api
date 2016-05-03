<?php
//Get Friend Requests
include "connection.php";

	$userid = $_POST["fid"];
 
   
$sql1 = mysql_query("Select user_id2,username,pic,wid,ssid from request_networks where user_id1 like '$userid'");

while($row = mysql_fetch_assoc($sql1))
{
	$output[] = $row;
}

header('Content-Type: application/json');
print(json_encode($output));
    	
mysql_close($con);
?>