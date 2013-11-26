<?php

$email_code = $_REQUEST['email_code'];
$user_id = intval($_REQUEST['user_id']);

$code = substr(sha1($user_id),0,5);

if($code == $email_code) {
	print '{"success":"Valid Code", "error":false}';
} else {
	print '{"error":"Invalid Code", "success":false}';
}
