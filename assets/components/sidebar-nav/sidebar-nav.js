(function($){
	"use strict";
	$(document).ready(function(){

			var plugin = {};
			plugin.el = $('#sidebar-nav'); // Set top-level component element scope
			
			if (plugin.el.length === 0) return false;
		
			plugin.el.top = plugin.el.offset().top;
			plugin.el.loadWidth = plugin.el.width();
			plugin.el.loadHeight = plugin.el.innerHeight();
			plugin.el.sticky = false;
			plugin.siteBar = $('#site-bar');
			plugin.siteBar.loadHeight = plugin.siteBar.height();
			plugin.footer = $('#section-footer');
			plugin.MENU_PARENT = '';

			$('.menu-toggle').on('click',function(){
			    var root = plugin.el;
                if(root.hasClass('collapse-mobile')){
                    root.removeClass('collapse-mobile');
                }else{
                    root.addClass('collapse-mobile');
                }
            });


        plugin.setMobileClass = function(){
            if (window.innerWidth < 992) {
                if(plugin.el.hasClass('sidebar-mobile-view') === false)
                    plugin.el.addClass('sidebar-mobile-view');
            }else{
                if(plugin.el.hasClass('sidebar-mobile-view') === true)
                    plugin.el.removeClass('sidebar-mobile-view');
            }
        };

        plugin.setMobileClass();
        window.addEventListener("resize", plugin.setMobileClass, false);

			if(($(window).height() * 3) < $('#content').height()) {
                // Sticky Sidebar
                var initStickySidebar = function () {
                    if ($('#region-main .bg-iu-crimson').length === 0 && $(window).width() > 991) {
                        plugin.el.top = plugin.el.offset().top;
                        plugin.el.css('top', 0);
                        $(window).scroll(function () {
                            if (plugin.siteBar.hasClass('shrink') && window.scrollY > plugin.el.top) {
                                plugin.setStickySideBarCss();
                                plugin.el.find('nav > ul').css({'width': plugin.el.loadWidth + 'px'});
                            }


                            if (!plugin.siteBar.hasClass('shrink') && plugin.el.sticky) {
                                plugin.el.css({'top': (plugin.siteBar.height() + 40) + 'px',});
                            }

                            if (window.scrollY + window.innerHeight > plugin.footer.offset().top && (plugin.el.offset().top + plugin.el.loadHeight + 81) > plugin.footer.offset().top) {
                                plugin.el.closest('.row').css('position', 'relative');
                                plugin.el.sticky = false;
                                if (plugin.el.css('top') && plugin.el.css('position')) {
                                    plugin.el.attr('style', '');
                                }
                                plugin.el.css({
                                    'position': 'absolute',
                                    'width': plugin.el.loadWidth,
                                    'height': plugin.el.loadHeight,
                                    'overflow': 'hidden',
                                    'bottom': 0,
                                });

                                plugin.el.find('nav').css({'overflow': 'hidden'});
                            }

                            if (window.scrollY + window.innerHeight < (plugin.footer.offset().top) && plugin.el.css('position') == 'absolute' && (window.innerWidth < 992)) {
                                plugin.el.find('nav').attr('style', "");
                                plugin.setStickySideBarCss();
                            }

                            if (!plugin.siteBar.hasClass('shrink') && (window.scrollY < (plugin.el.top - plugin.siteBar.loadHeight))) {
                                plugin.unsetStickySidebarCss();
                                plugin.el.css('top', 0);
                            }

                        });

                        plugin.setStickySideBarCss = function () {
                            if (window.innerWidth < 992) {
                                plugin.el.sticky = true;
                                plugin.el.css({
                                    'position': 'fixed',
                                    'top': (plugin.siteBar.height() + 40) + 'px',
                                    'width': plugin.el.loadWidth,
                                    'height': 'calc( 100% - ' + (plugin.siteBar.height() + 80) + 'px)',
                                    'overflow': 'hidden',
                                    'transition': '.5s top',
                                });
                            }
                        }

                        plugin.unsetStickySidebarCss = function () {
                            plugin.el.sticky = false;
                            plugin.el.attr('style', "");
                        }

                        window.addEventListener("resize", function () {
                            if (window.innerWidth > 992) {
                                if (plugin.el.css('position') === 'fixed') {
                                    plugin.unsetStickySidebarCss();
                                }
                            }
                        }, false);


                    }
                }


                //window.setTimeout(initStickySidebar, 500);
            }

	});

})(jQuery);
