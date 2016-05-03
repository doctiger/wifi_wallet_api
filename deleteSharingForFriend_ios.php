<?php
//Remove Friend
include "connection.php";

if( $_GET["uid"] || $_GET["wid"] )
  {

$userid =$_GET["uid"];
$wid    =  $_GET["wid"];  
$myuid  =  $_GET["fuid"];
mysql_query("Delete from shared_networks where user_id = '$userid' and wid = '$wid'");
mysql_query("UPDATE `fb_friend` SET `allow`=0 WHERE uid = '$myuid' and frnduid = '$userid'");
echo "data deleted";
     exit();
  }
else
{
echo "not deleted";
}
	
mysql_close($con);
?>
