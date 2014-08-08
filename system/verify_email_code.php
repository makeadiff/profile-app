<?php
require_once '../common.php';

$email_code = $_REQUEST['email_code'];
$email = $_REQUEST['email'];
$user_id = intval($_REQUEST['user_id']);

$code = substr(md5($user_id . '|' . $email),0,5);

if($code == $email_code) {
	if(!isVerified('email', $user_id)) {
		$verification_status = json_decode($sql->getOne("SELECT verification_status FROM User WHERE id=$user_id"));
		if(!$verification_status) $verification_status = array();
		array_push($verification_status, 'email');
		
		$sql->update('User', array('verification_status' => json_encode($verification_status)), "id=$user_id");
	}
	print '{"success":"Valid Code", "error":false}';
} else {
	print '{"error":"Invalid Code", "success":false}';
}
