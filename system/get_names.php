<?php
require_once '../common.php';

$city_id = intval($_REQUEST['city_id']);
$name = $QUERY['name'];

$people = $sql->getById("SELECT id, name FROM User WHERE status='1' AND user_type='volunteer' AND city_id=$city_id AND name LIKE '%$name%'");

if($people) {
print "<ul>";
foreach($people as $id=>$name) {
	print "<li><p style='text-shadow:2px 2px #666;font-size:130%;'><a style='color:#ffffff;' href='fb.php?user_id=$id'>$name</a></p></li>\n";
}
} else {
	print "User not found.";
}
