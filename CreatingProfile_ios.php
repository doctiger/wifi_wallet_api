<?php
//Creating Profile
include "connection.php";

	$json = file_get_contents('php://input');
 
    $data = json_decode($json);
    

$oldssid = $data->myssid;
$oldpassword = $data->mypassword;

$my_file = 'Profile.mobileconfig';
$handle = fopen($my_file, 'w','r','a') or die('Cannot open file:  '.$my_file); //implicitly creates file

$my_file = 'Profile.mobileconfig';
$handle = fopen($my_file, 'w','r','a') or die('Cannot open file:  '.$my_file);
$data = '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
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
			<string>mypassword</string>
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
			<string>7896F8B3-27A4-486E-89CE-9D6B1708B533</string>
			<key>PayloadVersion</key>
			<integer>1</integer>
			<key>ProxyType</key>
			<string>None</string>
			<key>SSID_STR</key>
			<string>myssid</string>
		</dict>
	</array>
	<key>PayloadDescription</key>
	<string>Profile description.</string>
	<key>PayloadDisplayName</key>
	<string>Profile</string>
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
</plist>
';
fwrite($handle, $data);

//read the entire string
$str=file_get_contents('Profile.mobileconfig');

//replace something in the file string - this is a VERY simple example

$str=str_replace("myssid", "$$oldssid",$str);
$str=str_replace("mypassword", "$oldpassword",$str);

file_put_contents('Profile', $str);

fclose($handle);
?>