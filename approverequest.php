<?php
//Accept Network Requests
include "connection.php";

	$json = $_SERVER['HTTP_JSON'];
 
    $data = json_decode($json);
 
    $userid1 = $data->userid1;
    $userid2 = $data->userid2;
    $wid = $data->wid;    

    $uid = explode(',', $userid2);
    $dwid = explode(',', $wid);

	for($i=0;$i<count($dwid);$i++) {
		mysql_query("Delete from request_networks where user_id2 like '$uid[$i]' and wid like '$dwid[$i]'");

                $c = mysql_query("Select count(*) from shared_networks where wid like '$dwid[$i]' and user_id like '$uid[$i]'");
	        $r = mysql_fetch_array($c);
	        $count = $r['count(*)'];

            if($count <1)
		mysql_query("Insert into shared_networks values (null,'$uid[$i]','$dwid[$i]')");
            else
                mysql_query("Update users set allowconnect = 1 where user_id like '$userid1'");
	}		

	$sql1 = mysql_query("Select fid from users where userid in ($userid2)");
while($row = mysql_fetch_assoc($sql1))
{
	$output[] = $row;
}

print(json_encode($output));

mysql_close($con);
?>