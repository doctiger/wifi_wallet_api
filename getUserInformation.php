<?php
//Get Register User Information
include "connection.php";

	$userid = $_POST["uid"];
 
   
$sql1 = mysql_query("Select fid, username, pic from users where user_id like '$userid'");

while($row = mysql_fetch_assoc($sql1))
{
	$output[] = $row;
}

header('Content-Type: application/json');
print(json_encode($output));
    	
mysql_close($con);
?>