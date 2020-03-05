(function($) {
	"use strict";

	// Wire up and immediately execute any applicable media query triggers
	for (var l in app.responsiveLayoutModes) {
		if (app.responsiveLayoutModes.hasOwnProperty(l)) {
			var layout = app.responsiveLayoutModes[l];
			enquire.register(layout.condition, layout.onMatched);
		}
	}

}(jQuery));
