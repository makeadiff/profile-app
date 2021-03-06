<?php
require 'common.php';

$user_id = intval($_SESSION['user_id']);
if(!$user_id) header("Location: index.php");

$user_data = $sql->getAssoc("SELECT id,name, email, phone, sex, photo, address, birthday, bio, job_status, edu_institution, company, facebook_id,verification_status FROM User WHERE id=$user_id");
$user_data['cpp'] = $sql->getOne("SELECT value FROM UserData WHERE user_id=$user_id AND name='child_protection_policy_signed'");

$verification_status = json_decode($user_data['verification_status']);
if(!$verification_status) $verification_status = array();
?><!DOCTYPE HTML>
<html>
<head>
<title>MAD Cred</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/style.css" />
<link type="text/css" rel="stylesheet" href="css/profile.css" />
<link type="text/css" rel="stylesheet" href="js/calendar/calendar.css" />
<link type="text/css" rel="stylesheet" href="css/jquery.percentageloader-0.1.css" />
<script type='text/javascript' > 
var loader; 
var verification_status = <?php echo json_encode($verification_status); ?>;
</script>
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
// loader = $("#progressbar").percentageLoader({ width : 160, height : 160, progress : 0.0, value : ''});
</script>
</div>	

<!--<div id='problem_feedback'><a href="hrapp.html" onclick="javascript:void window.open('hrapp.html','1385835292407','width=800,height=250,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;"></a></div>
-->

<?php if(!$user_data['cpp']) { ?>
<p class="bold">You have not signed the <a href="http://makeadiff.in/policy/child_protection_policy/">Child Protection Policy</a> yet. Please read and agree to that before you apply for a MAD Cred</p>
<?php } ?>

<form action="save.php" id="profile-form" method="post" enctype="multipart/form-data">
<table id="structure">
<tr><td class="fields"><label for="name">Name</label><br /><input class="must input" type="text" name="name" id="name" value="<?php  echo ucfirst($user_data['name']); ?>" /></td>
<td class="status-area"><img src="images/invalid.png" id="name_valid" class="status" /></td>
<td class="help-area"><p class="help">Enter your full name. No initials please!</p></td></tr>

<tr><td><label for="email">Email</label><br />
<input class="must input" type="text" name="email" id="email" value="<?php echo $user_data['email'] ?>" /><br />
<input type="button" class="button verification" value="Send&#13;&#10;Verificaiton Code" name="action" id="send_email_code" />
<input type="text" placeholder="Verification Code" name="email_code" id="email_code" class="code" /><!-- 1e339 -->
<input type="hidden" value="" name="email_code_verified" id="email_code_verified" />
<input type="button" class="button" value="Verify Code" name="action" id="verify_email_code" /></td>
<td><img src="images/<?php if(in_array('email', $verification_status)) echo 'valid'; else echo 'invalid'; ?>.png" id="email_valid" class="status" /></td>
<td><p class="help">Enter your email address and click the "Send Verification code" buttion. This will send a code to your email inbox. Copy-paste that code into the input field to verify your email address.</p></td></tr>

<tr><td><label for="phone">Phone</label><br />
<input class="must input" type="text" name="phone" id="phone" value="<?php echo $user_data['phone'] ?>" />
</td><td><img src="images/<?php if(in_array('sms', $verification_status)) echo 'valid'; else echo 'invalid'; ?>.png" id="phone_valid" class="status" /></td>
</tr>
<!-- <input type="button" class="button verification" value="Send&#13;&#10;Verificaiton Code" id="send_phone_code" />
<input type="text" placeholder="Verification Code" name="phone_code" id="phone_code" class="code" />
<input type="hidden" value="" name="phone_code_verified" id="phone_code_verified" />
<input type="button" class="button" value="Verify Code" name="action" id="verify_phone_code" /></td>
<td><p class="help">Enter your phone number and click the "Send Verification code" buttion. This will send a code as SMS. Enter that code into the input field to verify your phone number.</p></td></tr> -->

<tr><td>
<label>Sex</label><br />
<input type="radio" name="sex" value="f" id="sex_f" <?php  if($user_data['sex'] == 'f') echo "checked='checked'"; ?>/> <label for="sex_f">Female</label><br />
<input type="radio" name="sex" value="m" id="sex_m" <?php  if($user_data['sex'] == 'm') echo "checked='checked'"; ?> /> <label for="sex_m">Male</label><br />
<input type="radio" name="sex" value="o" id="sex_o" <?php  if($user_data['sex'] == 'o') echo "checked='checked'"; ?> /> <label for="sex_o">Other</label>
</td>
<td><img src="images/valid.png" id="sex_valid" class="status" /></td>
<td></td></tr>

<tr><td>
<label>Professional Status</label><br />
<input type="radio" name="job_status" value="student" id="job_status_student" <?php  if($user_data['job_status'] == 'student') echo "checked='checked'"; ?> /> <label for="job_status_student">Student</label><br />
<input type="radio" name="job_status" value="working" id="job_status_working" <?php  if($user_data['job_status'] == 'working') echo "checked='checked'"; ?>/> <label for="job_status_working">Working</label><br />
<input type="radio" name="job_status" value="other" id="job_status_other" <?php  if($user_data['sex'] == 'other') echo "checked='checked'"; ?>/> <label for="job_status_other">Other</label>
</td>
<td><img src="images/valid.png" id="job_status_valid" class="status" /></td>
<td></td></tr>

<tr><td class="fields"><label for="edu_institution">Educational Institution</label><br />
	<input class="must input" type="text" name="edu_institution" id="edu_institution" value="<?php echo $user_data['edu_institution'];?>" /></td>
<td class="status-area"><img src="images/invalid.png" id="edu_institution_valid" class="status" /></td>
<td class="help-area"><p class="help">Educational Institution you are studying in/have studied in</p></td></tr>

<tr><td class="fields"><label for="company">Company</label><br /><input class="must input" type="text" name="company" id="company" value="<?php echo $user_data['company'];?>"/></td>
<td class="status-area"><img src="images/invalid.png" id="company_valid" class="status" /></td>
<td class="help-area"><p class="help">If working, company you are working at</p></td></tr>

<tr><td>
<label for="address">Address</label>
<textarea name="address" id="address" rows="5" cols="46"><?php  echo $user_data['address']; ?></textarea>
</td>
<td><img src="images/invalid.png" id="address_valid" class="status" /></td>
<td></td></tr>

<tr><td>
<label for="photo">Photo</label>
<input name="photo" id="photo" type="file" /><br />
<?php if($user_data['photo']) { ?><img src="<?php echo $user_upload_folder . $user_data['photo'] ?>" width="200" /><?php } ?>
<p class="bold">Things to keep in mind when selecting a photo...
	<ul>
		<li class="bold">Image format: JPEG</li>
		<li class="bold">File Size: Less than 300 KB</li>
		<li class="bold">Face should be properly visible</li>
		<li class="bold">Vertical Image(Portrait)</li>
		<li class="bold">Think of this as your passport photo</li>
	</ul>
</p>
</td>
<td><img src="images/<?php if(!$user_data['photo']) echo 'in'; ?>valid.png" id="photo_invalid" class="status" /></td>
<td></td></tr>

<tr><td>
<label for="dob">Date of Birth</label>
<input type="text" name="dob" vaule="" id="dob" class="input" value="<?php  echo $user_data['birthday']; ?>" />
</td>
<td><img src="images/invalid.png" id="dob_valid" class="status" /></td>
<td class="help-area"><p class="help">Complete all fields to get 100% completion. That's it! You are done :)</p></td></tr>
<tr>
    <td>
    <input type="checkbox" name="coc"><span class="bold">I agree to the <a href="https://drive.google.com/file/d/0B81nBK1_ulQvdmxubXVRak5ud2c/view" 
    	onclick="javascript:void window.open('https://drive.google.com/file/d/0B81nBK1_ulQvdmxubXVRak5ud2c/view','1385835292407','width=800,height=250,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;">MAD Code of Conduct</a></span><br />
    <?php if(!$user_data['cpp']) { ?><p>You have not signed the <a href="http://makeadiff.in/policy/child_protection_policy/">Child Protection Policy</a> yet. Please read and agree 
    	to that before you apply for a MAD Cred</p><?php } ?>

    </td>
</tr>
</table>

<br /><br />
<input type="submit" name="action" class="button big" value="Finish" onclick="if(!this.form.coc.checked){alert('You must agree to the MAD Code of Conduct before submitting');return false;}"/>
<input type="hidden" name="user_id" id="user_id" value="<?php  echo $user_id; ?>" />
<input type="hidden" name="facebook_id" id="facebook_id" value="<?php  echo $user_data['facebook_id']; ?>" />
<input type="hidden" name="progress" id="progress" /> <!--Progress set from profile.js-->
<input type="hidden" name="cpp" id="cpp" value="<?php echo $user_data['cpp'] ?>" /> <!--Progress set from profile.js-->
</form>
</div>

</body>
</html>