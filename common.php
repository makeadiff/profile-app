<?php
require_once dirname(dirname(__FILE__)) . '/common.php';

function isVerified($type, $user_id) {
	global $sql;
	$verification_status = json_decode($sql->getOne("SELECT verification_status FROM User WHERE id=$user_id"));
	if(!$verification_status) $verification_status = array();
	return in_array($type, $verification_status);
}