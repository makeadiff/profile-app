<?php

require 'common.php';

$people = $sql->getById("SELECT id, name, phone, verification_status FROM User WHERE status='1' AND user_type='volunteer'");

$counter = 0;

if($people) {

	foreach($people as $person) {
	
		
		
		if( (strpos($person['verification_status'] , "email") == false ) && (strpos($person['verification_status'] , "sms") == false ) && ($person['phone']) && ($person['id']>13208)){
		
			$counter++;
			
			$whole_name = explode(" ",$person['name']);
		
			//To display second word of center name if it exists
			
			if(!isset($whole_name[1]))
				$name = $whole_name[0];
			else if(strlen($whole_name[0])<=1)
				$name = $whole_name[0] . " " . $whole_name[1];
			else
				$name = $whole_name[0];
			
			$message = "Dear $name, this is to remind you that you haven't registered for MAD Cred yet. Register now to get your own personalized MAD business card at : www.bit.ly/madcred";
			$success = sendSms($person['phone'], $message);
			//$success = true;
			
			if($success)
				$info = "Done";
			else
				$info = "Failed";
				
			echo "$person[id] $name $person[phone] $info<br>";
		}
		
	}
	
	echo "Total : $counter";

	

}






function sendSms($number, $message) {
	$gupshup_account = array('username'=>'2000030788','password'=>'6BeNqpFy6');
	$gupshup_param = array(
		'method'	=>	'sendMessage',
		'v'			=>	'1.1',
		'msg_type'	=>	'TEXT',
		'auth_scheme'=>	'PLAIN',
		'mask'		=>	'MAD',
		'userid'	=>	$gupshup_account['username'],
		'password'	=>	$gupshup_account['password']
	);
	
	$url = str_replace('&amp;', '&', getLink('http://enterprise.smsgupshup.com/GatewayAPI/rest?', 
						$gupshup_param + array('msg'=>$message, 'send_to'=>$number)));
	
	//print "Sending Text to $number: $message\n";
	
	// Comment the line below to disable Messageing
	$data = load($url);
	return true;
}	

?>

