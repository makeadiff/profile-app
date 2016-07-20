<?php
require './common.php';
if(empty($_SESSION['user_id'])) {
	$url_parts = parse_url($config['site_url']);
	$domain = $url_parts['scheme'] . '://' . $url_parts['host'];
	$madapp_url = "http://makeadiff.in/madapp/";
	if(strpos($config['site_home'], 'localhost') !== false) $madapp_url = "http://localhost/Projects/Madapp/";

	header("Location: " . $madapp_url . "index.php/auth/login/" . base64_encode($domain . $config['PHP_SELF']));
	exit;
}

$user_id = $_SESSION['user_id'];
$current_user = $sql->from('User')->find($user_id);
header("Location: fb.php?user_id=$user_id");
exit;


////////////// Everything below this is old. WILL NOT BE CALLED


$cities = $sql->getById("SELECT id,name FROM City WHERE type='actual' ORDER BY name");
?><!DOCTYPE HTML>
<html>
<head>
<title>MAD Cred</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/index.css" />
<link type="text/css" rel="stylesheet" href="css/landingpage_style.css" />
<body>

<div id="wrapper">	
<!--
<div id='problem_feedback'><a href="hrapp.html" onclick="javascript:void window.open('hrapp.html','1385835292407','width=800,height=250,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;"></a></div>
-->

<h1 class="top">Find Yourself</h1>
<h2 class="label">City</h2>

<div class="styled-select">
	<select id="city_id" name="city_id">
	<option value="0">Any</option>
	<?php foreach($cities as $id=>$name) {?>
	<option value="<?php echo $id ?>"><?php echo $name ?></option>
	<?php } ?>
	</select>
</div>

<h2 class="label">Name</h2>

<input type="text" class="input" name="your_name" id="your_name" value="Name" />
<input type="button" name="action" value="Search" id="search" class="button big" />

<br /><br /><br />

<div id="people_area" class="people_area"></div>
<br /><br />
</div>


<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/index.js"></script>

</body>
</html>
