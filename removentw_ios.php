<?php
//Remove network
include "connection.php";

		
    $json = file_get_contents('php://input');    
   
     $data = json_decode($json);
 
    $uid = $data->userid;
    $ssid  = $data->ssid;
    $pwd  = $data->pwd;


    $sqlf = mysql_query("Select wid from networks where ssid like '$ssid' and password like '$pwd' and sharedby like '$uid'");
		$r = mysql_fetch_array($sqlf);
		$wid = $r['wid'];
    
mysql_query("Delete from shared_networks where wid like '$wid'");


    mysql_query("Delete from networks where ssid like '$ssid' and password like '$pwd' and sharedby like '$uid'");
	mysql_query("Update users set my_networks= my_networks-1 where user_id like '$uid'");

mysql_close($con);
?>