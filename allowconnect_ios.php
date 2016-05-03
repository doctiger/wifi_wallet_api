<?php
//allow connect
include "connection.php";

    $json = file_get_contents('php://input'); 
 	
    $data = json_decode($json); 
 
    $userid1 = $data->userid1;
    $value   = $data->value;


mysql_query("Update users set allowconnect=$value where user_id like '$userid1'");

mysql_close($con);
?>
