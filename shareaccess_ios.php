<?php
//share access
include "connection.php";

	$json = file_get_contents('php://input');
 
    $data = json_decode($json);
 
    $uid    = $data->userid;
    $fid    = $data->fid;
    $fname  = $data->names;
    $fpic   = $data->pics;
    $wid    = $data->wid;

    $dfid  = explode(',', $fid);
    $dname = explode(',', $fname);
    $dpic  = explode(',', $fpic);

for($i=0;$i<count($dfid);$i++) {
	$sqlchk = mysql_query("Select count(*) from users where fid like '$dfid[$i]'");
	$r = mysql_fetch_array($sqlchk);
	$exists = $r['count(*)'];
	
	if($exists!=1)	
		mysql_query("Insert into users (fid,username,pic,pending,my_networks,num_friends,autoconnect,allowconnect) values ('$dfid[$i]','$dname[$i]','$dpic[$i]',1,0,0,1,1)");

	$sqlu = mysql_query("Select user_id from users where fid like '$dfid[$i]'");
	$row = mysql_fetch_array($sqlu);
	$ufid = $row['user_id'];
	
	$sqlf = mysql_query("Select count(*) from shared_networks where user_id like '$ufid' and wid like '$wid'");
	$r = mysql_fetch_array($sqlf);
	$exists2 = $r['count(*)'];
        
       mysql_query("Insert into friends values ($uid,$ufid)"); 
		
    if($exists2<1) 
  		mysql_query("Insert into shared_networks values (null,'$ufid','$wid')");
    
}

mysql_close($con);
?>
