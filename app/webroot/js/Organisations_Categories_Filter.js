
$(document).ready(function(){
	var currentTreeLevel = 0;
	$('select#OCId').change(function(){
		currentTreeLevel = 0;
		$.getJSON('https://supportic.us/Organisations/getSubCategories/'+$('select#OCId option:selected').val(), function(data){
			// Make tree-like select stuff
		});
	}).trigger('change');
});
