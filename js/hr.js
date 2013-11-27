function init() {

	
	$("#city_id").change(function() {
		if(this.value != "0") {
			$("#your_name").prop("disabled", false);
		} else {
			$("#your_name").prop("disabled", true);
			
		}
	});
	
	
	$("#search").click(function() {
		var city_id = $("#city_id").val();
		
		
		$.ajax("system/get_names_list.php?city_id="+city_id, {
			"success": function(data) {
				$("#people_area").html(data);
			},
			error: function() {
				alert("System Error: Can't get names. Please try later");
			}
			
			
		});
	});
	
}

