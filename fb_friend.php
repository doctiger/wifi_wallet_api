<?php
//share access
include "connection.php";
	
    $uid      = $_REQUEST['userid'];//$data->userid;
    $fid      = $_REQUEST['fid'];
   // $allow  = $_REQUEST['allow'];
   
    $dfid  = explode(',',$fid);
   
 	
for($i=0;$i<count($dfid);$i++) {

       $sqlchk = mysql_query("Select user_id from users where fid like '$dfid[$i]'");
	$row = mysql_fetch_array($sqlchk);
        $ufid = $row['user_id'];
       $var_count= 0;
       $sql2 = mysql_query("Select frnduid from fb_friend where uid = $uid and frnduid = '$ufid' "); 
       while($result=mysql_fetch_array($sql2))
        {
           $var_count++;
        }
        if($var_count == 0)
             { 
              mysql_query("INSERT INTO `fb_friend`(`uid`, `frnduid`, `allow`) VALUES ('$uid','$ufid',1)");
             } 

}

   $mysql = mysql_query("Select frnduid from fb_friend where uid= '$uid' and allow = 1");
   while($result1=mysql_fetch_array($mysql))
   { 
        $uufid = $result1['frnduid'];
        echo "<br>";
        echo $uufid;
        
        $sql3 = mysql_query("Select count(*) from `friends` where `user_id1`= '$uid' and `user_id2`= '$uufid'");
        $r = mysql_fetch_array($sql3);
        $exists = $r['count(*)'];
        if($exists ==0)
           {
            mysql_query("INSERT INTO `friends`(`user_id1`, `user_id2`) VALUES ('$uid','$uufid')");
           }
       
        $sql4  =  mysql_query("Select wid from networks where sharedby like '$uid'");
       
        while($result=mysql_fetch_array($sql4))
        {
           $wid = $result['wid'];
           $sql5 = mysql_query("Select count(*) from `shared_networks` where `user_id`= '$uufid' and `wid`= '$wid'");
           
           $row = mysql_fetch_array($sql5);
           $exists2 = $row['count(*)'];
           if($exists2 ==0)
           {
            mysql_query("INSERT INTO `shared_networks`(`user_id`, `wid`) VALUES ('$uufid','$wid')");
           }
           
        }
   
   }
   

echo "Done update";
mysql_close($con);
?>