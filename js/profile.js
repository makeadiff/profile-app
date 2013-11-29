var container = {};
		container['nameSet'] = 0;
		container['emailSet'] = 0;
		container['phoneSet'] = 0;
		container['addressSet'] = 0;
		container['dobSet'] = 0;
		container['sexSet'] = 0;
		container['job_statusSet'] = 0;
		container['edu_institutionSet'] = 0;
		container['companySet'] = 0;
		container['progress'] = 0;



function init() {	

	
	
		
	
	
	
	if(document.getElementById("dob")) calendar.set("dob");
	
	$(".code").click(function() {
		var val = $(this).val();
		if(val == "Verificaiton Code") {
			$(this).val("");
		}
	});
	
	$(".code").blur(function() {
		if($(this).val() == "") $(this).val("Verificaiton Code");
	});
	
	
	$("#name").change(checkContent);
	$("#email").change(checkContent);
	$("#phone").change(checkContent);
	$("#address").change(checkContent);
	$("#dob").change(checkContent);
	$("#sex_f").change(checkContent);
	$("#sex_m").change(checkContent);
	$("#job_status_student").change(checkContent);
	$("#job_status_working").change(checkContent);
	$("#job_status_other").change(checkContent);
	$("#edu_institution").change(checkContent);
	$("#company").change(checkContent);
	
	checkContent("name");
	checkContent("address");
	checkContent("dob");
	checkContent("sex_f");
	checkContent("sex_m");
	checkContent("job_status_working");
	checkContent("job_status_student");
	checkContent("job_status_other");
	checkContent("edu_institution");
	checkContent("company");
	
	$("#send_email_code").click(function() {
		$.ajax("system/send_verification_email.php?email="+$("#email").val()+"&email="+$("#email").val()+"&user_id="+$("#user_id").val(), {
			success: function(data) {
				if(data.success) alert("Email sent. Please check your inbox. If you don't find the email, check the spam folder as well");
				else alert("System error. Please try again later");
			},
			"dataType": "json"
		});
	});
	
	$("#verify_email_code").click(function() {
		$.ajax("system/verify_email_code.php?email_code="+$("#email_code").val()+"&email="+$("#email").val()+"&user_id="+$("#user_id").val(), {
			success: function(data) {
				if(data.success) {
					alert("Code Verified");
					tick("#email_valid");
					$("#email_code_verified").val($("#email").val());
				}
				else alert("Invalid code. Make sure that the code you entered is exactly the same as what you got.");
			},
			"dataType": "json"
		});
	});
	
	
	$("#send_phone_code").click(function() {
		$.ajax("system/send_verification_sms.php?phone="+$("#phone").val()+"&phone="+$("#phone").val()+"&user_id="+$("#user_id").val(), {
			success: function(data) {
				if(data.success) alert("SMS sent. Please check your SMS inbox");
				else alert("System error. Please try again later");
			},
			"dataType": "json"
		});
	});
	
	$("#verify_phone_code").click(function() {
		$.ajax("system/verify_sms_code.php?phone_code="+$("#phone_code").val()+"&phone="+$("#phone").val()+"&user_id="+$("#user_id").val(), {
			success: function(data) {
				if(data.success) {
					alert("Code Verified");
					tick("#phone_valid");
					$("#phone_code_verified").val($("#phone").val());
				}
				else alert("Invalid code. Make sure that the code you entered is exactly the same as what you got.");
			},
			"dataType": "json"
		});
	});
	
	$("#profile-form").submit(function(e) {
		var error = false;
		if(!checkContent("name")) {
			alert("Enter your name");
			$("#name").focus();
			error = true;
		}
		else if(!$("#email_code_verified").val()) {
			alert("Please verify your email adress");
			$("#email").focus();
			error = true;
		}
		else if(!$("#phone_code_verified").val()) {
			alert("Please verify your phone number");
			$("#phone").focus();
			error = true;
		}
		else if(!checkContent("address")) {
			alert("Enter your address");
			$("#address").focus();
			error = true;
		}
		else if(!checkContent("dob")) {
			alert("Enter your date of birth");
			$("#dob").focus();
			error = true;
		}
		
		if(error) {
			e.preventDefault();
			return false;
		}

	});
}

function checkContent(id) {
	if(typeof id == "string") {
		var ele = $("#"+id);
	} else {
		var id = this.id;
		var ele = $(this);
	}
	
	
	
	if(id =="email" || id == "phone") {
		if(ele.val() != $("#"+id+"_code_verified").val()) {
			untick("#"+id+"_valid");
			$("#"+id+"_code_verified").val("")
			return false;
		}
	} else {
		if(!ele.val()) {
			untick("#"+id+"_valid");
			return false;
		}
		else {
		
		if(id.startsWith("sex"))
			id = "sex";
		if(id.startsWith("job"))
			id = "job_status";
		
		tick("#"+id+"_valid");
		//alert(id);
		container[id+"Set"] = 10;
		
		}
		
	}
	
	progress = 	(container['nameSet']+container['emailSet']+container['phoneSet']+container['addressSet']+container['dobSet'] +container['sexSet']+container['job_statusSet']+container['edu_institutionSet']+container['companySet']+10)/100;
	//alert(progress);
	loader.setProgress(progress);
	document.getElementById("progress").value = progress;
	return true;
}

function tick(id) {
	$(id).attr("src", "images/valid.png");
}
function untick(id) {
	$(id).attr("src", "images/invalid.png");
}

$(init);

