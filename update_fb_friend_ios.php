<?php

include "connection.php";

    $json = file_get_contents('php://input'); 
 	
    $data = json_decode($json); 
 
    $userid =  $data->userid;
    
    $fuid   =  $data->fuid;


mysql_query("UPDATE `fb_friend` SET `allow`=0 WHERE uid = '$userid' and frnduid = '$fuid'");
echo "Table Updated";

mysql_close($con);
?>
