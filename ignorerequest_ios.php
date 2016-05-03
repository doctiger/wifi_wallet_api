<?php
//Ignore Network Request
include "connection.php";

	$json = file_get_contents('php://input');
 
    $data = json_decode($json);
 
    $userid1 = $data->userid1;
    $userid2 = $data->userid2;
    $wid = $data->wid;    

    $uid = explode(',', $userid2);
    $dwid = explode(',', $wid);

	for($i=0;$i<count($dwid);$i++) 
	mysql_query("Delete from request_networks where user_id1 like '$userid1' and user_id2 like '$uid[$i]' and wid like '$dwid[$i]'");


mysql_close($con);
?>
