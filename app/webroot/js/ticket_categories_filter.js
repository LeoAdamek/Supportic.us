$(function(){

	var options = {
		empty_value: 'null',
		indexed: true,
		on_each_change: '../getSubCategories',
		lazy_load: '../getSubCategories',
		choose: 'Choose A Category...',
		org_id: org_id
		
	};

	var displayParents = function(){
		var labels = [];
		$(this).siblings('select')
			.find(':selected')
				.each(function(){ labels.push($(this).text()); });
	}
	
	$.getJSON('../getSubCategories/'+org_id, function(tree){
		$('input#categoryId').optionTree(tree,options).change(displayParents);
	});

});
