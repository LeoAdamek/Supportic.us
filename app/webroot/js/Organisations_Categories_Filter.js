
$(document).ready(function(){
	$('select#OCId').change(function(){
		$.getJSON('https://supportic.us/Organisations/getSubCategories/'+$('select#OCId option:selected').val(), function(data){
			json_datar = data;
		});
	}).trigger('change');
});
