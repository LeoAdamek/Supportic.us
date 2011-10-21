/*
 * Javascript for Forms
 */

$(document).ready(function(){
	// Form Tooltips
	$("form :input").tooltip({
		position: "bottom right",
		offset: [0,"i"],
		effect: "fade",
		opacity: 0.7
	});
});
