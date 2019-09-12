<?php
require './common.php';
accessControl([]);

$user_id = $_SESSION['user_id'];
$current_user = $sql->from('User')->find($user_id);
header("Location: profile.php"); // If FB login starts working, change it to fb.php - 
