<?php
//Add fb friends to wifi wallet
include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
    $data = json_decode($json);
 
    $uid = $data->userid;
    $fid  = $data->fid;

    $dfid = explode(',', $fid);

for($i=0;$i<count($dfid);$i++) {

	$sqlu = mysql_query("Select user_id from users where fid like '$dfid[$i]'");
	$row = mysql_fetch_array($sqlu);
	$ufid = $row['user_id'];
	
	$sqlf = mysql_query("Select count(*) from friends where user_id1 in ('$uid','$ufid') and user_id2 in ('$uid','$ufid')");
	$r = mysql_fetch_array($sqlf);
	$exists1 = $r['count(*)'];
	
	$sqlf = mysql_query("Select count(*) from friends where user_id1 in ('$uid','$ufid') and user_id2 in ('$uid','$ufid')");
	$r = mysql_fetch_array($sqlf);
	$exists2 = $r['count(*)'];

  if($ufid!=0)		
    if($exists1!=1 && $exists2!=1) 
  		mysql_query("Insert into friends values ('$uid','$ufid')");
    
//share networks
		$sqlf = mysql_query("Select wid from networks where sharedby like '$uid' and self=0");
		while($r = mysql_fetch_array($sqlf)) {
		$wid = $r['wid'];
		$sqlc = mysql_query("Select count(*) from shared_networks where user_id like '$ufid' and wid like '$wid'");
		$row1 = mysql_fetch_array($sqlc);
		$exists1 = $row1['count(*)'];
		if($exists1<1)
	    		mysql_query("Insert into shared_networks values (null,'$ufid','$wid')");
		}
    		
	    	$sqlf = mysql_query("Select wid from networks where sharedby like '$ufid' and self=0");
		while($r = mysql_fetch_array($sqlf)) {
		$wid = $r['wid'];
		$sqlc = mysql_query("Select count(*) from shared_networks where user_id like '$uid' and wid like '$wid'");
		$row1 = mysql_fetch_array($sqlc);
		$exists1 = $row1['count(*)'];
		if($exists1<1)
	    		mysql_query("Insert into shared_networks values (null,'$uid','$wid')");
		}
}

mysql_close($con);
?>