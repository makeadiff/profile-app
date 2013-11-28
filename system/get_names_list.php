<?php
require('../../common.php');

$city_id = intval($_REQUEST['city_id']);

$city_progress = 0;
$counter = 0;
$people = $sql->getById("SELECT id, name,phone,profile_progress FROM User WHERE status='1' AND user_type='volunteer' AND city_id=$city_id ORDER BY profile_progress DESC");

if($people) {
print "<table>";
print"<th>Name</th><th>Phone</th><th>Progress %</th>";
foreach($people as $person) {
	print "<tr><td>$person[name]</td><td>$person[phone]</td><td>$person[profile_progress]</td></tr>";
	$counter++;
	$city_progress = $city_progress + $person['profile_progress']; 
}

$city_progress = $city_progress/$counter;

print "</table>";

print "<script type='text/javascript' > loader.setProgress($city_progress); </script>";

}

?> 
