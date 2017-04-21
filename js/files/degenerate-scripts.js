jQuery(function($) {
	
	// Show/hide menu
	$(".fa-bars").click(function() {
		if ($("#menu").hasClass("active")) {
			$("#menu").slideUp(500).removeClass("active");
		} else {
			$("#menu").slideDown(500).addClass("active");
		}
	});
	
	// Show and hide search form
	$("#search-button .fa-search").click(function() {
		if ($("#search").hasClass("active")) {
			$("#search").removeClass("active").animate({opacity: 0.0}, 300, function() {
				$(this).slideUp(500);
			});
		} else {
			$("#search").addClass("active").slideDown(500, function() {
				$(this).animate({opacity: 1.0}, 300);
			});
		}
	});
	
	// Submit search form on maginifying glass tap
	$("#searchform .fa-search").click(function() {
		$("#searchform").submit();
	});
	
	
});