function init() {
	
	$("#your_name").click(function() {					  
		var val = $(this).val();
		if(val == "Name") {
			$(this).val("");
		}
	});
	
	$("#your_name").blur(function() {
		if($(this).val() == "") $(this).val("Name");
	});
	
	$("#search").click(function() {
		var city_id = $("#city_id").val();
		var name = $("#your_name").val();
		
		$.ajax("system/get_names.php?city_id="+city_id+"&name="+name, {
			"success": function(data) {
				$("#people_area").html(data);
			},
			error: function() {
				alert("System Error: Can't get names. Please try later");
			}
		});
	});
}
$(init);