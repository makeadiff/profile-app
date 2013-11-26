<?php
require '../common.php';

$cities = $sql->getById("SELECT id,name FROM City ORDER BY name");
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Profile App</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/index.css" />
<link type="text/css" rel="stylesheet" href="css/landingpage_style.css" />
<body>



<div id="wrapper">	

<h1 class="top">Find Yourself</h1>

<h2 class="label">City</h2>

<div class="styled-select">
	<select id="city_id" name="city_id">

	<option value="0">Select...</option>
	<?php foreach($cities as $id=>$name) {?>
	<option value="<?php echo $id ?>"><?php echo $name ?></option>
	<?php } ?>

	</select>
</div>

<h2 class="label">Name</h2>

<input type="text" class="input" name="your_name" id="your_name" value="Name" disabled />
<input type="button" name="action" value="Search" id="search" class="button big" />

<br /><br /><br />

<div id="people_area" class="people_area"></div>
<br /><br />
</div>


<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/index.js"></script>

</body>
</html>
