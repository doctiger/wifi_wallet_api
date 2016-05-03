<?php
//Accept Friend Requests
include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
    $data = json_decode($json);
 
    $userid1 = $data->userid1;
    $userid2 = $data->userid2;

$sql1 = mysql_query("Delete from semi_friends where user_id1 like '$userid2' and user_id2 like '$userid1'");

mysql_query("Insert into friends values ('$userid2','$userid1')");
mysql_query("Update users set num_friends= num_friends+1 where user_id in ('$userid1','$userid2') ");
		
mysql_close($con);
?>