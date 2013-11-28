<?php
require('../../common.php');

$city_id = intval($_REQUEST['city_id']);

echo "Blah";

$people = $sql->getById("SELECT id, name,phone,profile_progress FROM User WHERE status='1' AND user_type='volunteer' AND city_id=$city_id");

if($people) {
print "<table>";
foreach($people as $person) {
	print "<tr><td>$person->name</td><td>$person->phone</td><td>$person->profile_progress</td></tr>";
}

print "</table>";

}

?> 
