<?php
//Get Trade Details
include "connection.php";

$username = $_POST["username"];  
$password = $_POST["password"]; 

$sql1 = mysql_query("Select * from `TettaRegistration` where (email = '$username' and password = '$password')");

while($row = mysql_fetch_assoc($sql1))
{
	$output[] = $row;
}

header('Content-Type: application/json');

print(json_encode($output));
    	
mysql_close($con);

?>
