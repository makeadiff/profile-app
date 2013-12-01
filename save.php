<?php
require '../common.php';

$user_id = intval($_REQUEST['user_id']);
if(!$user_id) header("Location: index.php");

$progress = $_REQUEST['progress'] * 100;


$affected = $sql->update('User', array(
	'name'	=> $_REQUEST['name'],
	'email'	=> $_REQUEST['email'],
	'phone'	=> $_REQUEST['phone'],
	'address'	=> $_REQUEST['address'],
	'birthday'	=> $_REQUEST['dob'],
	'sex'	=> $_REQUEST['sex'],
	'job_status' => $_REQUEST['job_status'],
	'edu_institution' => $_REQUEST['edu_institution'],
	'company' => $_REQUEST['company'],
	'profile_progress' => $progress,
), "id=$user_id");

$body = <<<END
Hey $_REQUEST[name],

Your updated data has been saved to our database.

You can find your ID at http://makeadiff.in/apps/profile/create_card.php?user_id=$user_id

Thank you for your cooperation :-)

--
MAD Tech Team
http://makeadiff.in/
END;

email($_REQUEST['email'], 'Profile Verification Complete', $body);

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Profile App</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/style.css" />
<link type="text/css" rel="stylesheet" href="css/profile.css" />
<link type="text/css" rel="stylesheet" href="js/calendar/calendar.css" />
</head>
<body>

<div id="wrapper">
<h1>Thank You</h1>

<p>Your information has been saved to our database. Thanks for your cooperation.</p>
</div>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/calendar/calendar.js"></script>
<script type="text/javascript" src="js/profile.js"></script>
</body>
</html>

