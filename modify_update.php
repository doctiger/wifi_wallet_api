<?php
include "connection.php";
$sql = mysql_query("select fid from users");
while($result = mysql_fetch_array($sql))
{
 
  $b =  $result['fid'];
  $pic = "https://graph.facebook.com/$b/picture?type=large";
  echo $pic;
  echo "<br>";
  mysql_query("UPDATE `users` SET `pic`='$pic' WHERE fid = '$b'");
  
}

?>