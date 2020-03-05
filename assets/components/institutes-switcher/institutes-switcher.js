/**
 * Campus Switcher Dropdown
 * Allows the user to rapidly switch between campus sites
 */
(function($){
	"use strict";

	var plugin = {};
	plugin.el = $('#institutes-switcher'); // Set top-level component element scope

	if (plugin.el.length === 0) {
		return false;
	}

	plugin.onItemSelected = function(e, activeItem) {
		var root = $(this).val();
		var targetPath = location.pathname;

		// If the department has its own external site, just go there immediately without further processing
		if (root.indexOf('http') === 0) {
				location.href = root;
				return true;
		}

		//debugger;
		//location.href = targetPath.replace(/\/research\/centers-institutes\/([^\/]+)(\/.*)?$/g, '/research/centers-institutes/'+root+'$2');

		var url = $.post( targetPath.replace(/\/research\/centers-institutes\/([^\/]+)(\/.*)?$/g, '/research/centers-institutes/'+root+'$2'), function() {
			location.href = targetPath.replace(/\/research\/centers-institutes\/([^\/]+)(\/.*)?$/g, '/research/centers-institutes/'+root+'$2')
		})
	  .fail(function() {
			location.href = targetPath.replace(/\/research\/centers-institutes\/([^\/]+)(\/.*)?$/g, '/research/centers-institutes/'+root)
	  })


	};

	// Set initial state (especially useful when back button causes selection to persist)
	var activeItem = location.pathname.replace(/\/research\/centers-institutes\/([^\/]+)(\/.*)?$/g, '$1');

	plugin.el.find('select').val(activeItem);

		plugin.el.on('change', 'select', plugin.onItemSelected);



})(jQuery);
