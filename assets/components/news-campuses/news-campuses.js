/**
 * Interactive campuses overview widget
 */
(function($){
	"use strict";


	var plugin = {};
	plugin.el = $('#news-campuses');

	if (plugin.el.length === 0) {
		return false;
	}

	plugin.selectCampus = function(name) {
		plugin.el.attr('data-selectedcampus', name);
		plugin.el.find('[data-campus]').removeClass('active').filter(function(){
			return ($(this).attr('data-campus') === name);
		}).addClass('active');

	};

	plugin.el.find('.campus-links a').each(function(){
		var aTag = $(this);
		aTag.attr('data-campus', aTag.text());
	}).eq(0).addClass('active');

	plugin.el.find('.campus-links a').each(function(){
		var campus = $(this).text();
		$(this).hover(function() {
				plugin.selectCampus(campus);
		});

	});

	// Initialize with default selection
	plugin.selectCampus(plugin.el.data('selectedcampus'));

})(jQuery);
