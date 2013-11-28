<?php
require('../../common.php');

$city_id = intval($_REQUEST['city_id']);


$people = $sql->getById("SELECT id, name,phone,profile_progress FROM User WHERE status='1' AND user_type='volunteer' AND city_id=$city_id ORDER BY profile_progress DESC");

if($people) {
print "<table>";
print"<th>Name</th><th>Phone</th><th>Progress %</th>";
foreach($people as $person) {
	print "<tr><td>$person[name]</td><td>$person[phone]</td><td>$person[profile_progress]</td></tr>";
}

print "</table>";

}

?> 
