/**
 * Department Switcher Dropdown
 * Allows the user to navigate to the equivalent parallel page in other department sections
 */
(function($){
	"use strict";

	var plugin = {};
	plugin.el = $('#department-switcher'); // Set top-level component element scope

	if (plugin.el.length === 0) {
		return false;
	}

	plugin.onDepartmentSelected = function(e) {
		var root = $(this).val();
		var targetPath = location.pathname;

		// If the department has its own external site, just go there immediately without further processing
		if (root.indexOf('http') === 0) {
			location.href = root;
			return true;
		}

		// Individual faculty members don't exist in other sections so bump one level up to the listing page
		if (/\/faculty\/[0-9]+(\/.*)?$/.test(targetPath)) {
			targetPath = targetPath.replace(/\/faculty\/[0-9]+(\/.*)?$/, '/faculty');
		}
		// location.href = targetPath.replace(/\/departments\/([^\/]+)(\/.*)?$/g, '/departments/'+root+'$2');


		$.post( targetPath.replace(/\/departments\/([^\/]+)(\/.*)?$/g, '/departments/'+root+'$2'), function() {
			location.href = targetPath.replace(/\/departments\/([^\/]+)(\/.*)?$/g, '/departments/'+root+'$2');
		})
	  .fail(function() {
			location.href = targetPath.replace(/\/departments\/([^\/]+)(\/.*)?$/g, '/departments/'+root);
	  })

	};

	// Set initial state (especially useful when back button causes selection to persist)
	var activeItem = location.pathname.replace(/\/departments\/([^\/]+)(\/.*)?$/g, '$1');
	plugin.el.find('select').val(activeItem);

	plugin.el.on('change', 'select', plugin.onDepartmentSelected);

})(jQuery);
