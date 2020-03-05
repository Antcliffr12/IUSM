(function($){
	"use strict";

	var plugin = {};
	plugin.el = $('#mep-flowchart');
	plugin.tooltip = plugin.el.find('.info');

	if (plugin.el.length === 0) {
		return false;
	}

	plugin.onItemOver = function(e) {
		var el = $(this);
		plugin.el.addClass('tooltip-active');
		var title = el.attr('data-title') || false;
		if (title) {
			plugin.tooltip.find('.title').removeClass('hidden').html(title);
		} else {
			plugin.tooltip.find('.title').addClass('hidden');
		}
		plugin.tooltip.find('.content').html(el.attr('data-tooltip'));
		var posX = (el.offset().left - plugin.el.offset().left);
		var posY = (el.offset().top - plugin.el.offset().top) + el[0].getBoundingClientRect().height + 10;
		var maxRight = plugin.el.offset().left + plugin.el.width();
		var maxBottom = plugin.el.offset().top + plugin.el.height();
		var overshootX = (posX + 280) - maxRight;
		var overshootY = (posY + plugin.tooltip.height()) - (maxBottom - plugin.el.offset().top);
		if (overshootX > 0) {
			posX -= overshootX;
		}
		if (overshootY > 0) {
			posY = (el.offset().top - plugin.el.offset().top) - plugin.tooltip.height() - 10;
		}
		plugin.tooltip.css({
			left: posX,
			top: posY
		});
	};

	plugin.onItemOut = function(e) {
		var el = $(this);
		plugin.el.removeClass('tooltip-active');
		plugin.tooltip.find('.title').empty();
		plugin.tooltip.find('.content').empty();
	};

	plugin.onItemClicked = function(e) {
		location.href = $(this).attr('data-url');
	}

	plugin.el.on('mouseenter', '[data-tooltip]', plugin.onItemOver);
	plugin.el.on('mouseleave', '[data-tooltip]', plugin.onItemOut);
	plugin.el.on('click', '[data-url]', plugin.onItemClicked);

})(jQuery);
