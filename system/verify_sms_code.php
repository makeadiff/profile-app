<?php
$phone_code = $_REQUEST['phone_code'];
$phone = $_REQUEST['phone'];
$user_id = intval($_REQUEST['user_id']);

$code = substr(md5($user_id . "|" . $phone),0,5);

if($code == $phone_code) {
	print '{"success":"Valid Code", "error":false}';
} else {
	print '{"error":"Invalid Code", "success":false}';
}
