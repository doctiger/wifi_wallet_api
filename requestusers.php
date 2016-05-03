<?php
//Request users who have access to this wid
include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
    $data = json_decode($json);
 
    $uid = $data->userid;
	$wid = $data->wid;
	$ssid = $data->ssid;
	$fid = $data->fid;

	$userid = explode(',', $fid);
    
	for($i=0;$i<count($userid);$i++) {


		$sql1 = mysql_query("Select username,pic from users where user_id like '$uid'");
		$row = mysql_fetch_array($sql1);
		$username = $row['username'];
		$pic = $row['pic'];

		$sqlchk = mysql_query("Select count(*) from request_networks where user_id1 like '$userid[$i]' and user_id2 like '$uid' and wid like '$wid'");
		$r = mysql_fetch_array($sqlchk);
		$exists = $r['count(*)'];

		if($exists==0)
	  		mysql_query("Insert into request_networks values (null,'$userid[$i]','$uid','$username','$pic','$wid','$ssid',0)");

	}




mysql_close($con);
?>