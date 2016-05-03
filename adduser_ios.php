<?php
//Add User
include "connection.php";

$json = file_get_contents('php://input');
//$json = $_POST['HTTP_JSON'];
 	
 	
$data = json_decode($json); 
 	
$fid   =  $data->fid;  // $_REQUEST['fid'];
$name  =  $data->name; //$_REQUEST['name'];
$pic   =  $data->pic; //$_REQUEST['pic'];

$sql1 = mysql_query("Select count(*) from users where fid in ($fid)");
$r = mysql_fetch_array($sql1);
$exists = $r['count(*)'];
    
    
if($exists!=1)
    mysql_query("Insert into users (fid,username,pic,pending,my_networks,num_friends,autoconnect,allowconnect) values ('$fid','$name','$pic',0,0,0,1,1)");
else
    mysql_query("Update users set pending=0 where fid like '$fid'");

$sql = mysql_query("SELECT user_id,autoconnect,allowconnect FROM users WHERE fid like '$fid'");


while($row = mysql_fetch_assoc($sql))
{
    $output[] = $row;
    $id = $row['user_id'];
}
$sql2 = mysql_query("Select count(*) from `shared_networks` where user_id =$id and wid = 0");
$r = mysql_fetch_array($sql2);
$exists = $r['count(*)'];
if($exists ==0)
{
mysql_query("INSERT INTO `shared_networks`(`user_id`, `wid`) VALUES ($id,0)");
}

   
print(json_encode($output));	
mysql_close($con);
?>