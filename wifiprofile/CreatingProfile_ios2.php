<?php 
include "connection.php";

$json = file_get_contents('php://input');
 
    $data   = json_decode($json);
    $myfile = $data->myfilename;
    $myUUID = $data->myuuid;
    $mySSID = $data->ssid;
    $myPASSWORD = $data->password;
    $fname = $data->filename;


$filename = $myfile; //the name of our file.
$content2 = '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">';
$content = "$content2
<dict>
	<key>PayloadContent</key>
	<array>
		<dict>
			<key>AutoJoin</key>
			<true/>
			<key>EncryptionType</key>
			<string>WPA</string>
			<key>HIDDEN_NETWORK</key>
			<false/>
			<key>Password</key>
			<string>$myPASSWORD</string>
			<key>PayloadDescription</key>
			<string>Configures wireless connectivity settings.</string>
			<key>PayloadDisplayName</key>
			<string>Wi-Fi Wallet</string>
			<key>PayloadIdentifier</key>
			<string>com.apple.wifi.managed.wifi1</string>
			<key>PayloadOrganization</key>
			<string>Wi-Fi Wallet</string>
			<key>PayloadType</key>
			<string>com.apple.wifi.managed</string>
			<key>PayloadUUID</key>
			<string>$myUUID</string>
			<key>PayloadVersion</key>
			<integer>1</integer>
			<key>ProxyType</key>
			<string>None</string>
			<key>SSID_STR</key>
			<string>$mySSID</string>
		</dict>
	</array>
	<key>PayloadDescription</key>
	<string>Profile description.</string>
	<key>PayloadDisplayName</key>
	<string>$fname Profile</string>
	<key>PayloadIdentifier</key>
	<string>com.apple.wifi.managed</string>
	<key>PayloadOrganization</key>
	<string>Wi-Fi Wallet</string>
	<key>PayloadRemovalDisallowed</key>
	<false/>
	<key>PayloadType</key>
	<string>Configuration</string>
	<key>PayloadUUID</key>
	<string>FA81DB0E-4457-4A7B-BA72-00DEF0E56781</string>
	<key>PayloadVersion</key>
	<integer>1</integer>
</dict>
</plist>";


 //what we will be writing to our file.
$strlength = strlen($content); //gets the length of our $content string.
$create = fopen($filename, "w"); //uses fopen to create our file.
$write = fwrite($create, $content, $strlength); //writes our string to our file.
$close = fclose($create); //closes our file
echo("File Created, Click <a href='$filename'> Here </a> to view it.");
?>