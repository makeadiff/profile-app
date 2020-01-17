<?php
require 'common.php';

$user_id = intval($_REQUEST['user_id']);
if(!$user_id) header("Location: index.php");

$data = array(
	'name'		=> $_REQUEST['name'],
	'email'		=> $_REQUEST['email'],
	'phone'		=> $_REQUEST['phone'],
	'address'	=> $_REQUEST['address'],
	'birthday'	=> $_REQUEST['dob'],
	'sex'		=> $_REQUEST['sex'],
	'job_status'=> $_REQUEST['job_status'],
	'edu_institution' 	=> $_REQUEST['edu_institution'],
	'company' 	=> $_REQUEST['company']
);

if(isset($_FILES['photo'])) {
	list($photo, $error) = upload('photo', $user_upload_folder, 'jpg,jpeg,png');
	if(!$error) $data['photo'] = $photo;
}

$affected = $sql->update('User', $data, "id=$user_id");

$body = <<<END
Hey $_REQUEST[name],

Your updated data has been saved to our database.

You can find your personalized MAD Cred at https://makeadiff.in/apps/profile/create_card.php?user_id=$user_id

If the information on your card is wrong, please feel free to update it at http://bit.ly/madcred to get your new MAD Cred.

Thank you for your cooperation :)

--
MAD Tech Team
http://makeadiff.in/
END;

sendEmail($_REQUEST['email'], 'Your MAD Cred', $body);

?>
<!DOCTYPE HTML>
<html>
<head>
<title>MAD Cred</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/style.css" />
<link type="text/css" rel="stylesheet" href="css/profile.css" />
<link type="text/css" rel="stylesheet" href="js/calendar/calendar.css" />
</head>
<body>

<div id="wrapper">
<h1>Thank You</h1>

<p>Your information has been saved to our database. Thanks for your cooperation. We have sent you an email with your MADCred.</p>
</div>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/calendar/calendar.js"></script>
<script type="text/javascript" src="js/profile.js"></script>
</body>
</html>

