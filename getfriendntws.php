<?php
//Get Friendly Networks
include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
   $data = json_decode($json);
 
    $userid = $data->userid;
    $ssid = $data->ssids;
	$table = "temp_" . $userid;

    mysql_query('SET CHARACTER SET utf8');
	$cr = mysql_query("Create temporary table $table (wid int(100) not null, ssid varchar(100) not null,password varchar(100) not null,sharedby int(100) not null,self int(100) not null,count int not null,allowconnect int not null)");

	$sql1 = mysql_query("Select ssid,wid,password,sharedby,self from networks where ssid in ($ssid) and sharedby like '$userid' UNION Select distinct ssid,wid,password,sharedby,self from networks where ssid in ($ssid) and ssid not like '' and ssid not in (Select ssid from networks where ssid in ($ssid) and sharedby like '$userid')");

while($row = mysql_fetch_array($sql1))
{
	$wid = $row['wid'];
	$ssid = $row['ssid'];
	$pwd = $row['password'];
	$sh = $row['sharedby'];
	$sl = $row['self'];
	$c = mysql_query("Select count(*) from shared_networks where wid like '$wid' and user_id like '$userid'");
	$r = mysql_fetch_array($c);
	$count = $r['count(*)'];
        $c = mysql_query("Select allowconnect from users where user_id like '$sh'");
	$r = mysql_fetch_array($c);
	$allow = $r['allowconnect'];
	$cr=mysql_query("Insert into $table values ('$wid','$ssid','$pwd','$sh','$sl','$count','$allow')");
}

	$sql1 = mysql_query("Select * from $table Order by ssid");
while($row = mysql_fetch_array($sql1))
{
	$output[] = $row;
}
mysql_query("DROP TABLE $table");
print(json_encode($output));
mysql_close($con);
?>