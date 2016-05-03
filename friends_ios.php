<?php
//Get Friends and friend requests
include "connection.php";

	$userid = $_POST["fid"];
 
   
 
    
	$table = "frd_" . $userid;

    mysql_query('SET CHARACTER SET utf8');
	$cr = mysql_query("Create temporary table $table (user_id int(100) not null, username varchar(300) not null,pic varchar(100) not null,my_networks int(100) not null,num_friends int(100) not null,dtype int not null)");

	$frq=mysql_query("Select count(*) from users where user_id in (Select user_id1 from semi_friends where user_id2 like '$userid')");
	$r = mysql_fetch_array($frq);
	$count = $r['count(*)'];
	
	if($count!=0) {
		mysql_query("Insert into $table values ('$count','Friend Requests','',0,0,0)");
		$sql1 = mysql_query("Select user_id,username,pic,my_networks,num_friends from users where user_id in (Select user_id1 from semi_friends where user_id2 like '$userid')");
		
		while($row = mysql_fetch_assoc($sql1))
			mysql_query("Insert into $table values ('$row[user_id]','$row[username]','$row[pic]','$row[my_networks]','$row[num_friends]',1)");

	}

$frq=mysql_query("Select count(*) from users where user_id in (Select user_id2 from friends where user_id1 like '$userid' UNION ALL Select user_id1 from friends where user_id2 like '$userid')");
	$r = mysql_fetch_array($frq);
	$count = $r['count(*)'];
	
	if($count!=0) {
		mysql_query("Insert into $table values ('$count','Friends','',0,0,0)");
		$sql1 = mysql_query("Select user_id,username,pic from users where user_id in (Select user_id2 from friends where user_id1 like '$userid' UNION ALL Select user_id1 from friends where user_id2 like '$userid') order by username");

		while($row = mysql_fetch_assoc($sql1))
			mysql_query("Insert into $table values ('$row[user_id]','$row[username]','$row[pic]',0,0,2)");

	}

$sql1 = mysql_query("Select * from $table");
while($row = mysql_fetch_assoc($sql1))
{
	$output[] = $row;
}
mysql_query("DROP TABLE $table");
print(json_encode($output));
    	
mysql_close($con);
?>