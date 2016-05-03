<?php
$con = mysql_connect("localhost","rkrieg","Asdf1234");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("wifiwalletapp", $con);
?>
