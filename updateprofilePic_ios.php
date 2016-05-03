<?php
include "connection.php";


if( $_GET["fid"] || $_GET["pic"] )
  {

$fid =$_GET["fid"];
$pic =$_GET["pic"];
mysql_query("UPDATE `users` SET `pic`='$pic' WHERE fid = '$fid'");
echo "pic updated";
     exit();
  }
else
{
echo "pic not updated";
}
?>