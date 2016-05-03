<?php
//Get Network Details from SSID
include "connection.php";

	$ssid = $_POST["ssid"];
 
   
$sql1 = mysql_query("Select wid, ssid, sharedby from networks where ssid like '$ssid'");

while($row = mysql_fetch_assoc($sql1))
{
	$output[] = $row;
}

header('Content-Type: application/json');
print(json_encode($output));
    	
mysql_close($con);
?>