$(function(){

	var options = {
		empty_value: 'null',
		indexed: true,
		on_each_change: 'getSubCategories',
		lazy_load: 'getSubCategories',
		choose: function(level){
			return 'Choose Category Level '+level;
		},
		
	};

	var displayParents = function(){
		var labels = [];
		$(this).siblings('select')
			.find(':selected')
				.each(function(){ labels.push($(this).text()); });
	}
	
	$.getJSON('getSubCategories', function(tree){
		$('input#OCId').optionTree(tree,options).change(displayParents);
	});

});
