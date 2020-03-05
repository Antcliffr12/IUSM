/**
 * Custom script for component
 */
(function($){

	var plugin = {};
	plugin.el = $('.fullwidth-video'); // Set top-level component element scope
	plugin.ratio = plugin.el.find('.embed').data('ratio');

	if (plugin.el.length === 0) {
		return false;
	}

	// Makes a video iframe responsive.
	$.each(plugin.el, function(){
		var iframe = $(this).find('iframe');
		var ratio = plugin.ratio == '43' ? '4:3' : '9:16';
		if(iframe.length !== 0){
			var calculateRatio = function(){
				var width = iframe.width();
				var setRatio = function(setWidth){
					iframe.each(function(){
						var e = $(this);
						e.css('height', setWidth);
					});
				};
				var threeFourths = (width * 3)/4;
				var nineSixteenths = (width * 9)/16;
				var theRatio = ratio == "9:16" ? nineSixteenths : threeFourths;
				setRatio(theRatio);
			};
			calculateRatio();
			$(window).resize(function(){calculateRatio()});
		}
	});

})(jQuery);
