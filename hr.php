<?php

require '../common.php';

$cities = $sql->getById("SELECT id,name FROM City ORDER BY name");



?>

<!DOCTYPE HTML>
<html>
<head>
<title>Profile App</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/hr.css" />
<link type="text/css" rel="stylesheet" href="css/profile.css" />
<link type="text/css" rel="stylesheet" href="js/calendar/calendar.css" />
<link type="text/css" rel="stylesheet" href="css/jquery.percentageloader-0.1.css" />


<script type='text/javascript' > 
  var progress,loaders; 
</script>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/calendar/calendar.js"></script>
<script type="text/javascript" src="js/hr.js"></script>

<script type="text/javascript" src="js/jquery.percentageloader/src/jquery.percentageloader-0.1.js"></script>


	
</head>

<body>




<h1>HR Dashboard</h1>

<div id="wrapper">


<div id="progressbar">

<script type="text/javascript">

var loader = $("#progressbar").percentageLoader({
    width : 160, height : 160, progress : 0.0, value : ''});
	
</script>

</div>	

<h2 class="label">City</h2>

<div class="styled-select">
	<select id="city_id" name="city_id">

	<option value="0">Select...</option>
	<?php foreach($cities as $id=>$name) {?>
	<option value="<?php echo $id ?>"><?php echo $name ?></option>
	<?php } ?>

	</select>
</div>

<br /><br />

<div id="people_list" class="people_list">

</div>


</div>





</body>
</html>
