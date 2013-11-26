<?php
$email_code = $_REQUEST['email_code'];
$email = $_REQUEST['email'];
$user_id = intval($_REQUEST['user_id']);

$code = substr(md5($user_id . '|' . $email),0,5);

if($code == $email_code) {
	print '{"success":"Valid Code", "error":false}';
} else {
	print '{"error":"Invalid Code", "success":false}';
}
