<?php
require '../common.php';

function isVerified($type, $user_id) {
	global $sql;
	$verification_status = json_decode($sql->getOne("SELECT verification_status FROM User WHERE id=$user_id"));
	
	return in_array($type, $verification_status);
}
