<?php
//Remove Friend
include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
    $data = json_decode($json);
 
    $userid1 = $data->userid1;
    $userid2 = $data->userid2;
    $wid = $data->wid;

mysql_query("Delete from shared_networks where user_id like '$userid2' and wid like '$wid'");

mysql_close($con);
?>