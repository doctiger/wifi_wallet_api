<?php
//allow connect
include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
    $data = json_decode($json);
 
    $userid1 = $data->userid1;
    $value = $data->value;


mysql_query("Update users set allowconnect=$value where user_id like '$userid1'");

mysql_close($con);
?>
