<?php
require_once dirname(dirname(__FILE__)) . '/common.php';

function isVerified($type, $user_id) {
	global $sql;
	$verification_status = json_decode($sql->getOne("SELECT verification_status FROM User WHERE id=$user_id"));
	if(!$verification_status) $verification_status = array();
	return in_array($type, $verification_status);
}


function email($to, $subject, $body, $from = '') {
	//return true; //:DEBUG:
	require("Mail.php");
	if(!$from) $from = "MADApp <madapp@makeadiff.in>";
	
	// SMTP info here!
	$host = "smtp.gmail.com";
	$username = "madapp@makeadiff.in";
	$password = "Th3C0ll3ct|v3";
	
	$headers = array ('From' => $from,
		'To' => $to,
		'Subject' => $subject);
	$smtp = Mail::factory('smtp',
		array ('host' => $host,
			'auth' => true,
			'username' => $username,
			'password' => $password));
	
	$mail = $smtp->send($to, $headers, $body);
	
	if (PEAR::isError($mail)) {
		echo("<p>" . $mail->getMessage() . "</p>");
		return false;
	}
	
	return true;
}