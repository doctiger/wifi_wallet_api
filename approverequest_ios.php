<?php
//Accept Network Requests
include "connection.php";

	$json = file_get_contents('php://input');
 
    $data = json_decode($json);
 
    $userid1 = $data->userid1;
    $userid2 = $data->userid2;
    $wid = $data->wid;    

    $uid = explode(',', $userid2);
    $dwid = explode(',', $wid);

	for($i=0;$i<count($dwid);$i++) {
		mysql_query("Delete from request_networks where user_id2 like '$uid[$i]' and wid like '$dwid[$i]'");

		mysql_query("Insert into shared_networks values (null,'$uid[$i]','$dwid[$i]')");
	}		

	$sql1 = mysql_query("Select fid from users where userid in ($userid2)");
while($row = mysql_fetch_assoc($sql1))
{
	$output[] = $row;
}

print(json_encode($output));

mysql_close($con);
?>