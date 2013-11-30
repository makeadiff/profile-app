<?php
$phone_code = $_REQUEST['phone_code'];
$phone = $_REQUEST['phone'];
$user_id = intval($_REQUEST['user_id']);

$code = substr(md5($user_id . "|" . $phone),0,5);

if($code == $phone_code) {
	if(!isVerified('sms', $user_id)) {
		$verification_status = json_decode($sql->getOne("SELECT verification_status FROM User WHERE id=$user_id"));
		array_push($verification_status, 'sms');
		
		$sql->update('User', array('verification_status' => json_encode($verification_status)), "id=$user_id");
	}
	print '{"success":"Valid Code", "error":false}';
} else {
	print '{"error":"Invalid Code", "success":false}';
}
