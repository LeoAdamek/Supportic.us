/*
 * Javascript for Forms
 */

$(document).ready(function(){
	// Form Tooltips
	$("form :input").tooltip({
		position: "center bottom",
		offset: [-2,10],
		effect: "fade",
		opacity: 0.7
	});
});
