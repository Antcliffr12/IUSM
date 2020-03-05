(function($) {
	"use strict";

	// Avoid `console` errors in browsers that lack a console.
	var method;
	var noop = function () {};
	var methods = [
		'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
		'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
		'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
		'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
	];
	var length = methods.length;
	var console = (window.console = window.console || {});

	while (length--) {
		method = methods[length];

		// Only stub undefined methods.
		if (!console[method]) {
			console[method] = noop;
		}
	}

	// Site functionality will hang off of the 'app' namespace
	window.app = {
		action : {},
		components: {},
		config: {},
		cookie: {
			set: function(name,value,days) {
				if (days) {
					var date = new Date();
					date.setTime(date.getTime()+(days*24*60*60*1000));
					var expires = "; expires="+date.toGMTString();
				}
				else var expires = "";
				document.cookie = name+"="+value+expires+"; path=/";
			},
			get: function(name) {
				var nameEQ = name + "=";
				var ca = document.cookie.split(';');
				for(var i=0;i < ca.length;i++) {
					var c = ca[i];
					while (c.charAt(0)==' ') c = c.substring(1,c.length);
					if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
				}
				return null;
			},
			remove: function(name) {
				app.cookie.set(name,"",-1);
			}
		},
		debug: true,
		event: {
			onLayoutModeChanged: function(e, mode){
				$('html').attr('data-layout-mode', mode);
			}
		},
		flag: {
			// Checks to see if a given flag is set
			isActive: function(name) {
				var flags = $('html').attr('data-flags') || '';
				flags = (flags === '') ? [] : flags.split(' ');
				return (flags.indexOf(name) !== -1);
			},

			// Adds one or more flags (space-separated names) to the global attribute
			set: function(names) {
				var flags = $('html').attr('data-flags') || '';
				flags = (flags === '') ? [] : flags.split(' ');
				names.split(' ').forEach(function(name){
					if (flags.indexOf(name) === -1) {
						flags.push(name);
					}
				});
				$('html').attr('data-flags', flags.join(' '));
			},

			// Removes the specified flag(s) from the global attribute, if present
			clear: function(names) {
				var flags = $('html').attr('data-flags') || '';
				flags = (flags === '') ? [] : flags.split(' ');
				var removeList = names.split(' ');
				flags = flags.filter(function(name){
					return (removeList.indexOf(name) === -1);
				});
				$('html').attr('data-flags', flags.join(' '));
			},

			// Removes all flags from the global attribute
			clearAll: function() {
				$('html').attr('data-flags', '');
			}
		},
		log: function (msg) {
			if (app.debug) {
				console.log(msg);
			}
		},
		responsiveLayoutModes: {
			phone: {
				condition: 'screen and (max-width: 767px)',
				onMatched: function(){
					$(document).trigger('LAYOUT_MODE_CHANGED', ['phone']);
				}
			},
			tablet: {
				condition: 'screen and (min-width: 768px) and (max-width: 991px)',
				onMatched: function(){
					$(document).trigger('LAYOUT_MODE_CHANGED', ['tablet']);
				}
			},
			desktop: {
				condition: 'screen and (min-width: 992px)',
				onMatched: function(){
					$(document).trigger('LAYOUT_MODE_CHANGED', ['desktop']);
				}
			}
		}
	};

	// Default event handler bindings
	$(document).on('LAYOUT_MODE_CHANGED', app.event.onLayoutModeChanged);

}(jQuery));
