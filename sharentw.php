<?php
//Share network with friends
include "connection.php";

    $json = $_SERVER['HTTP_JSON'];
    $data = json_decode($json);
 
    $uid = $data->userid;
    $ssid  = $data->ssid;
    $pwd  = $data->pwd;
    $ip  = $data->ip;

if($ssid!='')
    mysql_query("Insert into networks (ssid,password,ip_addr,sharedby,self) values ('$ssid','$pwd','$ip','$uid',0)");
	$qwe = mysql_query("Update users set my_networks= my_networks+1 where user_id like '$uid'");

    $sqlf = mysql_query("Select wid from networks where ip_addr like '$ip' and sharedby like '$uid'");
		$r = mysql_fetch_array($sqlf);
		$wid = $r['wid'];
    
$sql2 = mysql_query("Select user_id from users where user_id in (Select user_id1 from friends where user_id2 like '$uid' UNION ALL Select user_id2 from friends where user_id1 like '$uid')");

while($row = mysql_fetch_array($sql2))
      {
  		$userid = $row['user_id'];
           if(($userid!=0)&&($wid!=0))
  		mysql_query("Insert into shared_networks values (null,'$userid','$wid')");
  }

mysql_close($con);
?>