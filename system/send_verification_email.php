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

