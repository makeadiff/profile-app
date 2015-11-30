<?php
require_once '../common.php';

$city_id = i($QUERY, 'city_id', 0);
$name = i($QUERY, 'name', '');
$city_check = '';
if($city_id) $city_check = "AND city_id=$city_id";

$people = $sql->getById("SELECT id, name FROM User WHERE status='1' AND user_type='volunteer' $city_check AND name LIKE '%$name%'");

if($people) {
	print "<ul id='people-list'>";
	foreach($people as $id=>$name) {
		print "<li><a href='fb.php?user_id=$id'>$name</a></li>\n";
	}
	print "</ul>";
} else {
	print "User not found.";
}
