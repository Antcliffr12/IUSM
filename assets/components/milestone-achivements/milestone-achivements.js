(function($){
	"use strict";
	
	var plugin = {};
	plugin.el = $('#milestone-achivements');

	if (plugin.el.length === 0) {
		return false;
	}
	
	plugin.onItemClicked = function(e) {
		location.href = $(this).attr('data-url');
	}

	plugin.el.on('click', '[data-url]', plugin.onItemClicked);

})(jQuery);
