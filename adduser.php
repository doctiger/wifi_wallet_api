<?php
//Add User
include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
    $data = json_decode($json);
 
    $fid = $data->fid;
    $name  = $data->name;
    $pic  = $data->pic;

$sql1 = mysql_query("Select count(*) from users where fid in ($fid)");
$r = mysql_fetch_array($sql1);
$exists = $r['count(*)'];
    
    if($exists!=1)
    	mysql_query("Insert into users (fid,username,pic,pending,my_networks,num_friends,autoconnect,allowconnect) values ('$fid','$name','$pic',0,0,0,1,1)");
    else
    	mysql_query("Update users set pending=0 where fid like '$fid'");

$sql = mysql_query("SELECT user_id,autoconnect,allowconnect FROM users WHERE fid like '$fid'");

while($row = mysql_fetch_assoc($sql))
      {
  	$output[] = $row;
  }

print(json_encode($output));
    	
mysql_close($con);
?>