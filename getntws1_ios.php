<?php
//Get Shared Networks
include "connection.php";

    	$userid = 10;//$_POST["fid"];
    	
    	$table = "temp_" . $userid;

 	mysql_query('SET CHARACTER SET utf8');
	$cr = mysql_query("Create temporary table $table (wid int(100) not null, ssid varchar(1000) not null,password varchar(200) not null,self int(100) not null,dtype int not null,is_my_network BOOLEAN NOT NULL)");

	$c = mysql_query("Select count(*) from networks where sharedby like '$userid'");
	$r = mysql_fetch_array($c);
	$count = $r['count(*)'];

if($count!=0)
	mysql_query("Insert into $table values (0,'My Networks','',0,0,1)");

$sql1 = mysql_query("Select wid,ssid,password from networks where sharedby like '$userid'");
    while($row = mysql_fetch_array($sql1))
{
	$wid = $row['wid'];
	$ssid = $row['ssid'];
	$pwd = $row['password'];
	mysql_query("Insert into $table values ('$wid','$ssid','$pwd',1,1,1)");
}

	$c = mysql_query("Select count(*) from shared_networks where user_id like '$userid'");
	$r = mysql_fetch_array($c);
	$count = $r['count(*)'];

if($count!=0)
	 mysql_query("Insert into $table values (0,'My Friends\' Shared Networks','',0,0,0)");

$sql1 = mysql_query("Select wid,ssid,password from networks where wid in (Select wid from shared_networks where user_id like '$userid')");
    while($row = mysql_fetch_array($sql1))
{
	$wid = $row['wid'];
	$ssid = $row['ssid'];
	$pwd = $row['password'];
   
   $checkmysql = mysql_query("select sharedby from networks where wid= '$wid'");
   $d = mysql_fetch_array($checkmysql);
   $uid1 = $d['sharedby'];
     
   $checksql = mysql_query("select allowconnect from users where user_id= '$uid1'");
   $a = mysql_fetch_array($checksql);
   $b = $a['allowconnect'];
   
	mysql_query("Insert into $table values ('$wid','$ssid','$pwd',2,'$b',0)");
}

$sql1 = mysql_query("Select * from $table where is_my_network=1");
    while($row = mysql_fetch_assoc($sql1))
     {
     //echo "<pre>";print_r($row);	
             $output[] = $row;
     }

 //header('Content-Type: application/json');
   //echo json_encode($output);

$query=mysql_query("Select * from $table where is_my_network=0");
      while($fndata = mysql_fetch_assoc($query))
         {
            //echo "<pre>";print_r($fndata );	
               $foutput[] = $fndata ;
        } 
             //echo json_encode($foutput);


$rdata = "{}";
$json = json_decode($rdata );

$json->MyNetwork = $output;

$json->MyFriendsNetwork = $foutput;

header('Content-Type: application/json');
echo json_encode($json);

mysql_close($con);
?>