<?php
//user list to request access
include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
    $data = json_decode($json);
 
    $userid = $data->userid;
	$wid = $data->wid;
    
     $sql = mysql_query("Select count(*) from shared_networks where user_id like '$userid' and wid like '$wid'");
     $r= mysql_fetch_assoc($sql);
     $c = $r['count(*)'];

if($c==1) {
$sql1 = mysql_query("Select user_id,username,pic from users where user_id like (Select sharedby from networks where wid like '$wid')");
}
else {
$sql1 = mysql_query("Select user_id,username,pic from users where user_id in (Select user_id from shared_networks where user_id not like '$userid' and wid like '$wid' UNION ALL Select sharedby from networks where wid like '$wid' and sharedby not like '$userid') order by username");
}
while($row = mysql_fetch_assoc($sql1))
{
	$output[] = $row;
}

print(json_encode($output));

mysql_close($con);
?>