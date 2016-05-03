<?php
//Reject Friend Fequest
include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
    $data = json_decode($json);
 
    $userid1 = $data->userid1;
    $userid2 = $data->userid2;

mysql_query("Delete from semi_friends where user_id1 like '$userid2' and user_id2 like '$userid1'");

mysql_close($con);
?>