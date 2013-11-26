<?php

require '../common.php';

$user_id = intval($_REQUEST['user_id']);
if(!$user_id) header("Location: index.php");

$user_data = $sql->getAssoc("SELECT name, email, phone, sex, photo, address, birthday, bio, job_status, edu_institution, company FROM User WHERE id=$user_id");


?>

<!DOCTYPE HTML>
<html>
<head>
<title>Profile App</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/style.css" />
<link type="text/css" rel="stylesheet" href="css/profile.css" />
<link type="text/css" rel="stylesheet" href="js/calendar/calendar.css" />
<link type="text/css" rel="stylesheet" href="js/jquery.percentageloader/src/jquery.percentageloader-0.1.css" />

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/calendar/calendar.js"></script>
<script type="text/javascript" src="js/profile.js"></script>

<script type="text/javascript" src="js/jquery.percentageloader/src/jquery.percentageloader-0.1.js"></script>


	
</head>

<body>






<div id="wrapper">
<h1>Complete your profile</h1>

<div id="progressbar">

<script type="text/javascript">

$("#progressbar").percentageLoader({
    width : 150, height : 150, progress : 0.5, value : ''});
</script>

</div>	

<form action="save.php" id="profile-form">
<table id="structure">
<tr><td class="fields"><label for="name">Name</label><br /><input class="must input" type="text" name="name" id="name" value="<?php  echo ucfirst($user_data['name']); ?>" /></td>
<td class="status-area"><img src="images/invalid.png" id="name_valid" class="status" /></td>
<td class="help-area"><p class="help">Enter your full name. No initials please! Eg: Gloria Sumita Benny</p></td></tr>

<tr><td><label for="email">Email</label><br />
<input class="must input" type="text" name="email" id="email" value="<?php echo $user_data['email'] ?>" /><br />
<input type="button" class="button" value="Send&#13;&#10;Verificaiton Code" name="action" id="send_email_code" />
<input type="text" value="Verificaiton Code" name="email_code" id="email_code" class="code" /><!-- 1e339 -->
<input type="hidden" value="" name="email_code_verified" id="email_code_verified" />
<input type="button" class="button" value="Verify Code" name="action" id="verify_email_code" /></td>
<td><img src="images/invalid.png" id="email_valid" class="status" /></td>
<td><p class="help">Enter your email address and click the "Send Verificaiton code" buttion. This will send a code to your email inbox. Copy-paste that code into the input field to verify your email address.</p></td></tr>

<tr><td><label for="phone">Phone</label><br />
<input class="must input" type="text" name="phone" id="phone" value="<?php echo $user_data['phone'] ?>" /><br />
<input type="button" class="button" value="Send&#13;&#10;Verificaiton Code" id="send_phone_code" />
<input type="text" value="Verificaiton Code" name="phone_code" id="phone_code" class="code" /><!-- d58be -->
<input type="hidden" value="" name="phone_code_verified" id="phone_code_verified" />
<input type="button" class="button" value="Verify Code" name="action" id="verify_phone_code" /></td>
<td><img src="images/invalid.png" id="phone_valid" class="status" /></td>
<td><p class="help">Enter your phone number and click the "Send Verificaiton code" buttion. This will send a code as SMS. Enter that code into the input field to verify your phone number.</p></td></tr>

<tr><td>
<label>Sex</label><br />
<input type="radio" name="sex" value="f" id="sex_f" <?php  if($user_data['sex'] == 'f') echo "checked='checked'"; ?>/> <label for="sex_f">F</label>
<input type="radio" name="sex" value="m" id="sex_m" <?php  if($user_data['sex'] == 'm') echo "checked='checked'"; ?> /> <label for="sex_m">M</label>
</td>
<td><img src="images/valid.png" id="sex_valid" class="status" /></td>
<td></td></tr>

<tr><td>
<label>Professional Status</label><br />
<input type="radio" name="job_status" value="student" id="job_status_student" /> <label for="job_status_student">Student</label>
<input type="radio" name="job_status" value="working" id="job_status_working" /> <label for="job_status_working">Working</label>
<input type="radio" name="job_status" value="other" id="job_status_other" /> <label for="job_status_other">Other</label>
</td>
<td><img src="images/valid.png" id="job_status_valid" class="status" /></td>
<td></td></tr>

<tr><td class="fields"><label for="edu_institution">Educational Institution</label><br /><input class="must input" type="text" name="edu_institution" id="edu_institution" /></td>
<td class="status-area"><img src="images/invalid.png" id="edu_institution_valid" class="status" /></td>
<td class="help-area"><p class="help">Educational Institution you are studying in/have studied in</p></td></tr>

<tr><td class="fields"><label for="company">Company</label><br /><input class="must input" type="text" name="company" id="company" /></td>
<td class="status-area"><img src="images/invalid.png" id="company_valid" class="status" /></td>
<td class="help-area"><p class="help">If working, company you are working at</p></td></tr>

<tr><td>
<label for="address">Address</label>
<textarea name="address" id="address" rows="5" cols="46"><?php  echo $user_data['address']; ?></textarea>
</td>
<td><img src="images/invalid.png" id="address_valid" class="status" /></td>
<td></td></tr>

<tr><td>
<label for="dob">Date of Birth</label>
<input type="text" name="dob" vaule="" id="dob" class="input" value="<?php  echo $user_data['birthday']; ?>" />
</td>
<td><img src="images/invalid.png" id="dob_valid" class="status" /></td>
<td class="help-area"><p class="help">That's it! Finish --></p></td></tr>
</table>
<input type="submit" name="action" class="button big" value="Finish" />
<input type="hidden" name="user_id" id="user_id" value="<?php  echo $user_id ?>" />

</form>
</div>





</body>
</html>
