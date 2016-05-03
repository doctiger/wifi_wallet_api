<?php
//Send request
include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
    $data = json_decode($json);
 
    $uid = $data->userid;
    $fid  = $data->fid;
    $fname  = $data->names;
    $fpic  = $data->pics;

    $dfid = explode(',', $fid);
    $dname = explode(',', $fname);
    $dpic = explode(',', $fpic);

for($i=0;$i<count($dfid);$i++) {
	$sqlchk = mysql_query("Select count(*) from users where fid like '$dfid[$i]'");
	$r = mysql_fetch_array($sqlchk);
	$exists = $r['count(*)'];
	
	if($exists!=1)	
		mysql_query("Insert into users (fid,username,pic,pending,my_networks,num_friends,autoconnect,allowconnect) values ('$dfid[$i]','$dname[$i]','$dpic[$i]',1,0,0,1,1)");

	$sqlu = mysql_query("Select user_id from users where fid like '$dfid[$i]'");
	$row = mysql_fetch_array($sqlu);
	$ufid = $row['user_id'];
	
	$sqlf = mysql_query("Select count(*) from semi_friends where user_id1 in ('$uid','$ufid') and user_id2 in ('$uid','$ufid')");
	$r = mysql_fetch_array($sqlf);
	$exists1 = $r['count(*)'];
	
	$sqlf = mysql_query("Select count(*) from friends where user_id1 in ('$uid','$ufid') and user_id2 in ('$uid','$ufid')");
	$r = mysql_fetch_array($sqlf);
	$exists2 = $r['count(*)'];
		
    if($exists1!=1 && $exists2!=1) 
  		mysql_query("Insert into semi_friends values ('$uid','$ufid')");
    
}

mysql_close($con);
?>