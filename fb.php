<?php
require 'common.php';
require 'facebook-php-sdk/src/facebook.php';

$user_id = intval($_REQUEST['user_id']);
if(!$user_id) header("Location: index.php");

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '1387327704844983',
  'secret' => '3763c02d60d5401f7c905115836617f3',
));

// Get User ID
$fb_user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($fb_user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $fb_user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($fb_user) {
  $logoutUrl = $facebook->getLogoutUrl();
  
  // Save FB ID to database.
  $sql->update("User", array('facebook_id'=>$fb_user), "id=$user_id");
  header("Location: profile.php?user_id=$user_id");
  
} else {
  $loginUrl = $facebook->getLoginUrl();
}

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
<h1>Complete your profile</h1>

<form action="profile.php" id="profile-form">
<?php if (!empty($fb_user)) { ?>Logged into FB<?php } else { ?>
<a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
<?php } ?>
<p class="help">Connect your FB account to access your MAD account using your FB login and recieve critical update on your FB account. We have a strict no spam policy.</p>

<p><a href="profile.php?user_id=<?php echo $user_id ?>">Skip this step</a></p>
<!--<input type="submit" name="action" value="Continue to Final Step" class="big button" />-->

<br /><br />
<input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
</form>
</div>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/calendar/calendar.js"></script>
<script type="text/javascript" src="js/profile.js"></script>
</body>
</html>

