<?php

require '../common.php';

$cities = $sql->getById("SELECT id,name FROM City ORDER BY name");



?>

<!DOCTYPE HTML>
<html>
<head>
<title>MAD Cred</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/national.css" />
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

<h1>National Dashboard</h1>

<div id="wrapper">


<div id="multiple-loader-container">

<?php

foreach($cities as $city_id=>$name){

	
	
	echo "
		<div id = 'loader$city_id' class = 'city_loader'>
			<h2 class = 'label'>$name</h2>
			<script type = 'text/javascript'> 
				var loader$city_id = $('#loader$city_id').percentageLoader({width : 160, height : 160, progress : 0.0, value : ''});
			</script>
		</div>";
		
	
	$counter = 0;
	$verified = 0;
	$percentage = 0;
	
	$people = $sql->getById("SELECT id, name, verification_status FROM User WHERE status='1' AND user_type='volunteer' AND city_id=$city_id");

	if($people) {

		foreach($people as $person) {
			$counter++;
			
			if( (strpos($person['verification_status'] , "email") !== false ) && (strpos($person['verification_status'] , "sms") !== false ) )
				$verified++;
		}
		
		$percentage = $verified/$counter;

		

		echo "<script type='text/javascript' > loader$city_id.setProgress($percentage); </script>";	
	
		}	
	}
	
?>
	
</div>	
	

</div>

</body>
</html>
