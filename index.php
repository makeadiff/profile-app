<?php
require './common.php';

if(empty($_SESSION['user_id'])) {
	$url_parts = parse_url($config['site_url']);
	$domain = $url_parts['scheme'] . '://' . $url_parts['host'];
	$madapp_url = "https://makeadiff.in/madapp/";
	if(strpos($config['site_home'], 'localhost') !== false) $madapp_url = "http://localhost/Projects/Madapp/";

	header("Location: " . $madapp_url . "index.php/auth/login/" . base64_encode($domain . $config['PHP_SELF']));
	exit;
}

$user_id = $_SESSION['user_id'];
$current_user = $sql->from('User')->find($user_id);
header("Location: profile.php?user_id=$user_id"); // If FB login starts working, change it to fb.php
