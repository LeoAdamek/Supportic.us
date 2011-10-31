$(function(){
	$('.tinymce').tinymce({
		script: 'https://supportic.us/js/tiny_mce/tiny_mce.js',
		theme: "advanced",
		skin:	"o2k7",
		plugins: "iespell,inlinepopus,insertdatetime,print,paste,directionality,fullscreen,visualchars",

		theme_advanced_buttons1: "bold,italic,strikethrough,|,fontsizeselect,fontselect",
		theme_advanced_buttons2: "cut,copy,paste,|,search,replace,|,bullist,|,numlist,|,outdent,indent,blockquote,|,undo,redo",
		theme_advanced_buttons3: "link,unlink,anchor,image,cleanup,help,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		
		theme_advanced_toolbar_location: "top",
		theme_advanced_toolbar_align: "left",
		theme_advanced_statusbar_location: "bottom",
		theme_advanced_resizing: true
	});
});
