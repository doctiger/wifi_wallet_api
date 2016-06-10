<?php
$con = mysql_connect("localhost","wifiwall","Asdf1234");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("wifiwall_wifiwalletapp", $con);
?>
