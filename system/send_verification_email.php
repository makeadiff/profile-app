<?php
require_once '../common.php';

$email = $_REQUEST['email'];
$user_id = intval($_REQUEST['user_id']);

$code = substr(md5($user_id . '|' . $email),0,5);

$message = <<<END
Hi,

Please copy-paste this code into the Email Verification Code field to verify your email address: $code

Thank You

MAD Tech Team
END;

$success = email($email, "MADApp Verification Code", $message);

if($success) {
	print '{"success":"Sent verification email", "error":false}';
} else {
	print '{"success":false, "error":"Email not sent"}';
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