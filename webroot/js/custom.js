$(document).ready(function () {
	//close action for notifications
	$(".close").click(function () {
		$(this)
			.parent()
			.fadeTo(400, 0, function () {
				$(this).slideUp(400);
			});
		return false;
	});

	// Navigation is handled by navigation-modern.js.
});
