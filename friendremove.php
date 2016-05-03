<?php
//Remove Friend
include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
    $data = json_decode($json);
 
    $userid1 = $data->userid1;
    $userid2 = $data->userid2;

$s=mysql_query("Delete from friends where user_id1 in ('$userid1','$userid2') and user_id2 in ('$userid1','$userid2')");
mysql_query("Update users set num_friends= num_friends-1 where user_id in ('$userid1','$userid2') ");

// remove shared networks
		$sqlf = mysql_query("Select wid from networks where sharedby like '$userid1'");
		while($r = mysql_fetch_array($sqlf)) {
			$wid = $r['wid'];
    		mysql_query("Delete from shared_networks where user_id like '$userid2' and wid like '$wid'");
		}
    		
    	$sqlf = mysql_query("Select wid from networks where sharedby like '$userid2'");
		while($r = mysql_fetch_array($sqlf)) {
			$wid = $r['wid'];
    		mysql_query("Delete from shared_networks where user_id like '$userid1' and wid like '$wid'");
		}

mysql_close($con);
?>