(function($, w, d){
	"use strict";

	var plugin = {
		ACTIVE: false,
		KEY_TOGGLE: 16, // SHIFT
		STYLESHEET_URL: $('#component-inspector-script').attr('src').replace('.js', '.css'),
		currentComponent: null,
		uiTemplate:
		'<div id="component-inspector">' +
		'<h2>Component Inspector<span>(SHIFT to toggle on/off)</span></h2>' +
		'<div><label>Current Component:</label> <span class="current">N/A</span></div>' +
		'<div><label>Parent Component:</label> <span class="parent">N/A</span></div>' +
		'</div>',
		posX: ($(window).width() / 2) - 200,
		posY: ($(window).height() / 2) - 60
	};

	plugin.throttle=function(e,f,j,i){var h,d=0,c=undefined;if(typeof f!=="boolean"){i=j;j=f;f=c}function g(){var o=this,m=+new Date()-d,n=arguments;function l(){d=+new Date();j.apply(o,n)}function k(){h=c}if(i&&!h){l()}h&&clearTimeout(h);if(i===c&&m>e){l()}else{if(f!==true){h=setTimeout(i?k:l,i===c?e-m:e)}}}if($.guid){g.guid=j.guid=j.guid||$.guid++}return g};

	plugin.log = function(msg) {
		if (w.console) {
			console.log(msg);
		}
	};

	plugin.onComponentEntered = function(e) {
		var el = $(this);
	};

	plugin.onMouseMoved = function(e) {
		plugin.posX = e.clientX + 10;
		plugin.posY = e.clientY + 10;

		if (plugin.posX + 400 > $(w).width()) {
			plugin.posX -= 420;
		}
		plugin.currentComponent = $(d.elementFromPoint(e.clientX, e.clientY)).closest('[data-component]');
		if (plugin.ACTIVE) {
			plugin.render();
		}
	};

	plugin.onKeyDown = function(e) {
		if (e.which == plugin.KEY_TOGGLE) {
			if (plugin.ACTIVE) {
				plugin.deactivate();
			} else {
				plugin.activate();
			}
		}
	};

	plugin.activate = function(){
		plugin.ACTIVE = true;
		$('body').addClass('component-inspector-active');
		plugin.log('Component Inspector is ACTIVE');
		plugin.render();
	};

	plugin.deactivate = function(){
		plugin.ACTIVE = false;
		$('body').removeClass('component-inspector-active');
		plugin.currentComponent = null;
		plugin.log('Component Inspector is INACTIVE');
	};

	plugin.render = function() {
		plugin.el.css({left: plugin.posX, top: plugin.posY });
		if (plugin.currentComponent === null || plugin.currentComponent.length === 0) {
			plugin.el.find('.current, .parent').html('N/A');
			return;
		}
		plugin.el.find('.current').html(plugin.currentComponent.data('component'));
		var parent = plugin.currentComponent.parent().closest('[data-component]');
		if (parent.length === 0) {
			plugin.el.find('.parent').html('N/A');
		} else {
			plugin.el.find('.parent').html(parent.data('component'));
		}
	};

	$('#component-inspector, #component-inspector-styles').remove();
	$('head').append('<link rel="stylesheet" type="text/css" href="'+plugin.STYLESHEET_URL+'">');
	$('body').append(plugin.uiTemplate);
	plugin.el = $('#component-inspector');

	// Set default event handlers
	$(d).off('.COMPONENT_INSPECTOR');
	$(d).on('keydown.COMPONENT_INSPECTOR', plugin.onKeyDown);
	$(d).on('mousemove.COMPONENT_INSPECTOR', plugin.throttle(50, plugin.onMouseMoved));

	plugin.log('Component Inspector Loaded!');
	plugin.activate();

	w.IUInspector = plugin;

})(jQuery, window, document);
