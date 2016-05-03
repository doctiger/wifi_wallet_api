<?php
//Get Shared Networks
include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
    $data = json_decode($json);
 
    $userid = $data->userid;
    $table = "temp_" . $userid;

 mysql_query('SET CHARACTER SET utf8');
	$cr = mysql_query("Create temporary table $table (wid int(100) not null, ssid varchar(1000) not null,password varchar(200) not null,self int(100) not null,dtype int not null)");

	$c = mysql_query("Select count(*) from networks where sharedby like '$userid'");
	$r = mysql_fetch_array($c);
	$count = $r['count(*)'];

if($count!=0)
	mysql_query("Insert into $table values (0,'My Networks','',0,0)");

$sql1 = mysql_query("Select wid,ssid,password from networks where sharedby like '$userid'");
    while($row = mysql_fetch_array($sql1))
{
	$wid = $row['wid'];
	$ssid = $row['ssid'];
	$pwd = $row['password'];
	mysql_query("Insert into $table values ('$wid','$ssid','$pwd',1,1)");
}

	$c = mysql_query("Select count(*) from shared_networks where user_id like '$userid'");
	$r = mysql_fetch_array($c);
	$count = $r['count(*)'];

if($count!=0)
	mysql_query("Insert into $table values (0,'My Friends\' Shared Networks','',0,0)");

$sql1 = mysql_query("Select wid,ssid,password from networks where wid in (Select wid from shared_networks where user_id like '$userid')");
    while($row = mysql_fetch_array($sql1))
{
	$wid = $row['wid'];
	$ssid = $row['ssid'];
	$pwd = $row['password'];
	mysql_query("Insert into $table values ('$wid','$ssid','$pwd',2,1)");
}

$sql1 = mysql_query("Select * from $table");
    while($row = mysql_fetch_array($sql1))
{
	$output[] = $row;
}

print(json_encode($output));
    	
mysql_close($con);
?>
