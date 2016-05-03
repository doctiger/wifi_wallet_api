<?php
//Get Friendly Networks

include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
   $data = json_decode($json);
 
    $userid = $data->userid;
    $ssid   = $data->ssids;
	$table = "tem_" . $userid;

    mysql_query('SET CHARACTER SET utf8');
	$cr = mysql_query("Create temporary table $table (wid int(100) not null, ssid varchar(200) not null,password varchar(100) not null,sharedby int(100) not null,allowconnect int(1) not null,count int not null,username varchar(200) not null)");

	$sql1 = mysql_query("Select wid,ssid,password,sharedby from networks where ssid in ($ssid)");

while($row = mysql_fetch_array($sql1))
{
	$wid = $row['wid'];
	$ssid = $row['ssid'];
	$pwd = $row['password'];
	$sh = $row['sharedby'];
	$c = mysql_query("Select allowconnect,username from users where user_id like '$sh'");
	$r = mysql_fetch_array($c);
	$allow = $r['allowconnect'];
	$username = $r['username'];

	$c = mysql_query("Select count(*) from shared_networks where wid like '$wid' and user_id like '$userid'");
	$r = mysql_fetch_array($c);
	$count = $r['count(*)'];
	$cr=mysql_query("Insert into $table values ('$wid','$ssid','$pwd','$sh','$allow','$count','$username')");
}

	$sql1 = mysql_query("Select * from $table");
while($row = mysql_fetch_array($sql1))
{
	$output[] = $row;
}
mysql_query("DROP TABLE $table");
print(json_encode($output));
    	
mysql_close($con);
?>
