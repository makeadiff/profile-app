<?php
require './common.php';

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
<div id='problem_feedback'><a href="hrapp.html" onclick="javascript:void window.open('hrapp.html','1385835292407','width=800,height=250,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;"></a></div>

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
