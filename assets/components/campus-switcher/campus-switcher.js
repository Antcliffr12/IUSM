/**
 * Campus Switcher Dropdown
 * Allows the user to rapidly switch between campus sites
 */
(function($){
	"use strict";

	var plugin = {};
	plugin.el = $('#campus-switcher'); // Set top-level component element scope

	if (plugin.el.length === 0) {
		return false;
	}

	plugin.onItemSelected = function(e) {
		var root = $(this).val();
		var targetPath = location.pathname;

		// If the department has its own external site, just go there immediately without further processing
		if (root.indexOf('http') === 0) {
			location.href = root;
			return true;
		}

		// location.href = targetPath.replace(/\/education\/campuses\/([^\/]+)(\/.*)?$/g, '/education/campuses/'+root+'$2');


		$.post( targetPath.replace(/\/campuses\/([^\/]+)(\/.*)?$/g, '/campuses/'+root+'$2'), function() {
			location.href = targetPath.replace(/\/campuses\/([^\/]+)(\/.*)?$/g, '/campuses/'+root+'$2')
		})
	  .fail(function() {
		location.href = targetPath.replace(/\/campuses\/([^\/]+)(\/.*)?$/g, '/campuses/'+root)
	  })

	};

	// Set initial state (especially useful when back button causes selection to persist)
	var activeItem = location.pathname.replace(/\/campuses\/([^\/]+)(\/.*)?$/g, '$1');
	plugin.el.find('select').val(activeItem);

	plugin.el.on('change', 'select', plugin.onItemSelected);

})(jQuery);
