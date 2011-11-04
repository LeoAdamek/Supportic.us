$(document).ready(function(){
	$('#searchToggle').click(function(){
		$('#searchform').fadeToggle();
	});

	$('#OrganisationName').autocomplete({
		source: function(req, add){
			$.getJSON("https://supportic.us/organisations/search/", req, function(data){
				add(data);
			});
		}
	});
});
