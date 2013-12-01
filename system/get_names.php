<?php
require_once '../common.php';

$city_id = intval($_REQUEST['city_id']);
$name = $QUERY['name'];

$people = $sql->getById("SELECT id, name FROM User WHERE status='1' AND user_type='volunteer' AND city_id=$city_id AND name LIKE '%$name%'");

if($people) {
print "<ul>";
foreach($people as $id=>$name) {
	print "<li><a href='fb.php?user_id=$id'>$name</a></li>\n";
}
} else {
	print "User not found.";
}
