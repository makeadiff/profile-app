<?php
require_once '../common.php';

$phone = $_REQUEST['phone'];
$user_id = intval($_REQUEST['user_id']);

$code = substr(md5($user_id . '|' . $phone),0,5);

$message = "Your mobile verification code for MAD Cred is: $code";
$success = sendSms($phone, $message);


if($success) {
	print '{"success":"Sent verification SMS", "error":false}';
} else {
	print '{"success":false, "error":"SMS not sent"}';
}




function sendSms($number, $message) {
	$gupshup_account = array('username'=>'2000030788','password'=>'6BeNqpFy6');
	$gupshup_param = array(
		'method'	=>	'sendMessage',
		'v'			=>	'1.1',
		'msg_type'	=>	'TEXT',
		'auth_scheme'=>	'PLAIN',
		'mask'		=>	'MAD',
		'userid'	=>	$gupshup_account['username'],
		'password'	=>	$gupshup_account['password']
	);
	
	$url = str_replace('&amp;', '&', getLink('http://enterprise.smsgupshup.com/GatewayAPI/rest?', 
						$gupshup_param + array('msg'=>$message, 'send_to'=>$number)));
	
	//print "Sending Text to $number: $message\n";
	
	// Comment the line below to disable Messageing
	$data = load($url);
	return true;
}
