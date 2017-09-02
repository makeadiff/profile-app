<?php
require 'common.php';
require 'php-graph-sdk/src/Facebook/autoload.php';
if(!session_id()) session_start();

$user_id = intval($_REQUEST['user_id']);
if(!$user_id) header("Location: index.php");

$fb = new \Facebook\Facebook([
  'app_id' => '1387327704844983',
  'app_secret' => '3763c02d60d5401f7c905115836617f3',
  'default_graph_version' => 'v2.10',
  //'default_access_token' => '{access-token}', // optional
]);
$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // There was an error communicating with Graph
  echo $e->getMessage();
  exit;
}

// FB Authenticated.
if (isset($accessToken)) {
  // Save FB ID to database.
  $sql->update("User", array('facebook_id'=>$fb_user), "id=$user_id");
  header("Location: profile.php?user_id=$user_id"); exit;
  
} else {

  $permissions = ['email']; // optional
  $callback = 'http://makeadiff.in/apps/profile/fb.php?user_id=' . $user_id;
  $loginUrl = $helper->getLoginUrl($callback, $permissions);
}

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
<h1>Facebook Connect</h1>

<!--  <div id='problem_feedback'><a href="hrapp.html" onclick="javascript:void window.open('hrapp.html','1385835292407','width=800,height=250,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;"></a></div>
-->

<form action="profile.php" id="profile-form">
<?php if (!empty($fb_user)) { ?>
Logged into FB
<?php } else { ?>
<p style = "text-align:center;font-size:130%;font-weight:bold;"><a href="<?php echo $loginUrl; ?>">Login with Facebook</a></p>
<?php } ?>
<p class="help" style = "text-align:center;">Connect your FB account to access your MAD account using your FB login and recieve critical update on your FB account. We have a strict no spam policy.</p>

<p style = "text-align:right;font-size:90%;"><a href="profile.php?user_id=<?php echo $user_id ?>">Skip this step</a></p>
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
