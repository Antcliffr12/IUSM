(function($){
    "use strict";


    var siteBar = $('#site-bar'),
        mainNav = siteBar.find('.main-menu'),
        topNav = siteBar.find('#top-nav nav > ul');

    // Copy specified items to top menu as needed
    (mainNav.attr('data-copytotop') || '').split(',').forEach(function(label){
        mainNav.find('.menu-item[data-label="'+label+'"]:first').clone().appendTo(topNav);
    });

    // Hide any menu items designated in the exclusion list
    (mainNav.attr('data-exclude') || '').split(',').forEach(function(label){
        topNav.find('.menu-item[data-label="'+label+'"]').removeClass('desktop-hide');
    });

    $.ajax({
        url: iu_vars.rest_api_root + 'iusm/v1/route/mega-menu',
        dataType: 'json',
        method : 'GET',
        success : function(data, textStatus, jqXHR){
            var siteBarContainer = $('#site-bar').find('.container');
            if(textStatus === 'success'){
                siteBarContainer.append(data.about);
                siteBarContainer.append(data.give);
				siteBarContainer.append(data.news);
                siteBarContainer.append(data.education);
                siteBarContainer.append(data.departments);
                siteBarContainer.append(data.research);
                siteBarContainer.append(data.campus);
                siteBarContainer.append(data.expertise);
            }
        },
        cache: false
    }).fail(function(){
        console.log('Error: Mega-menu ajax call failed to fire correctly.');
    }).always(function(){

        /**
         * Provides behavior for a dual-mode navigation menu
         */
        var plugin = {
            el: siteBar,
            html: $('html'),
            main: $('#main-content'),
            footer: $('footer'),
            shrink: 'shrink',
            currentDepth: 0,
            mobileMode: false,

            // Flags/Constants
            FLAG_SITEBAR_MOBILE_MODE: 'SITEBAR_MOBILE_MODE',
            FLAG_MOBILE_MENU_ACTIVE: 'MOBILE_MENU_ACTIVE',
            FLAG_MEGAMENU_ACTIVE: 'MEGAMENU_ACTIVE',
            FLAG_SEARCH_BAR_ACTIVE: 'SEARCH_BAR_ACTIVE',
            CLASS_SUBMENU_ACTIVE: 'submenu-shown'
        };

        if (plugin.el.length === 0) {
            return false;
        }

        // Element references
        plugin.searchBarEl = $('#search-bar');
        plugin.navEl = plugin.el.find('.main-menu');
        plugin.topNavEl = plugin.el.find('#top-nav nav > ul');
        plugin.btnToggleSearchBar = $('.btn-toggle-search-bar');
        plugin.btnToggleMobileMenu = $('.btn-toggle-mobile-menu');


        // Show the mobile menu
        plugin.show = function() {
            app.flag.set(plugin.FLAG_MOBILE_MENU_ACTIVE);
            plugin.main.hide();
            plugin.footer.hide();
            plugin.el.css({
                'overflow-x':'hidden',
                'overflow-y':'scroll'
            });
        };

        // Hide the mobile menu and reset to default state
        plugin.hide = function() {
            app.flag.clear(plugin.FLAG_MOBILE_MENU_ACTIVE);
            plugin.navEl.find('li').removeClass(plugin.CLASS_SUBMENU_ACTIVE);
            plugin.main.show();
            plugin.footer.show();
        };

        // Handle main mobile menu toggle button behavior
        plugin.onToggleClicked = function(e) {
            if (app.flag.isActive(plugin.FLAG_MOBILE_MENU_ACTIVE)) {
                plugin.hide();
            } else {
                plugin.show();
            }
        };

        // Handle submenu toggle behavior
        plugin.onSubmenuToggleClicked = function(e) {
            $(this).parent().toggleClass(plugin.CLASS_SUBMENU_ACTIVE);
        };

        plugin.onLayoutModeChanged = function(e, mode) {
            if (/phone|tablet/.test(mode)) {
                plugin.hideSearchBar();
                app.flag.set(plugin.FLAG_SITEBAR_MOBILE_MODE);
            } else {
                // Avoid getting stuck with the overlay if we go out of mobile mode
                plugin.hide();
                app.flag.clear(plugin.FLAG_SITEBAR_MOBILE_MODE);
            }
        };

        plugin.showSearchBar = function() {


            // plugin.searchBarEl.animate({top: '0px'}, 300, function(){
            //     plugin.searchBarEl.find('input[type="text"]').focus();
            // });

            app.flag.set(plugin.FLAG_SEARCH_BAR_ACTIVE);
            plugin.el.addClass('search-bar-animate');
            plugin.el.addClass('add-box-shadow');
            plugin.searchBarEl.addClass('search-bar-active');
            plugin.searchBarEl.find('input[type="text"]').focus();

            plugin.btnToggleSearchBar.attr('title', 'Close Search').html('Close Search');
        };

        plugin.hideSearchBar = function() {
            // plugin.searchBarEl.animate({top: '-60px'}, 300, function(){
            //     plugin.searchBarEl.find('input[type="text"]').val('').blur();
            //     app.flag.clear(plugin.FLAG_SEARCH_BAR_ACTIVE);
            // });

            plugin.el.removeClass('search-bar-animate');
            plugin.el.removeClass('add-box-shadow');
            plugin.searchBarEl.removeClass('search-bar-active');
            app.flag.clear(plugin.FLAG_SEARCH_BAR_ACTIVE);
            plugin.btnToggleSearchBar.attr('title', 'Search').html('Search');
        };

        // Handle search bar toggle behavior
        plugin.onSearchBarToggleClicked = function(e) {
            e.preventDefault();
            var _t = $(this);
            if (app.flag.isActive(plugin.FLAG_SEARCH_BAR_ACTIVE)) {
                plugin.hideSearchBar();
            } else {
                plugin.showSearchBar();
            }
        };

        plugin.onMenuItemHovered = function(e) {
            var el = $(this);
            if (app.flag.isActive(plugin.FLAG_MEGAMENU_ACTIVE)) {
                plugin.hideMegaMenuPanels();
            }
            if (el.hasClass('has-megamenu')) {
                el.addClass('megamenu-hover');
                var mm = plugin.el.find('.megamenu-panel[data-target="'+el.attr('data-label')+'"]');
                if (mm.length) {
                    app.flag.set(plugin.FLAG_MEGAMENU_ACTIVE);
                    mm.show(250);
                }
            }
        };

        plugin.onMobileSearch = function(e) {
            $('#s').val($('#mobile-s').val());
            $('#searchsubmit').click();
        };

        plugin.onSubMenuItemHovered = function(e) {
            if (app.flag.isActive(plugin.FLAG_SITEBAR_MOBILE_MODE)) {
                return; // Skip processing if we're on mobile mode since submenu display is handled differently.
            }

            // Snap the submenu to the left or right side of the parent menu item depending on available space
            var vWidth = $(window).width();
            var li = $(this);
            var submenu = li.find('> .sub-menu');
            if (vWidth < li.offset().left + li.width() + submenu.width()) {
                li.removeClass('submenu-snap-right').addClass('submenu-snap-left');
            } else {
                li.removeClass('submenu-snap-left').addClass('submenu-snap-right');
            }
        };

        plugin.hideMegaMenuPanels = function(){
            plugin.megaMenuPanels.hide();
            plugin.el.find('.megamenu-hover').removeClass('megamenu-hover');
            app.flag.clear(plugin.FLAG_MEGAMENU_ACTIVE);
        };

        // Wire up events
        plugin.el.on('click', '.btn-toggle-search-bar', plugin.onSearchBarToggleClicked);
        plugin.el.on('click', '.btn-toggle-mobile-menu', plugin.onToggleClicked);
        plugin.el.on('click', '.submenu-toggle', plugin.onSubmenuToggleClicked);
        plugin.el.on('click', '#mobile-searchsubmit', plugin.onMobileSearch);


        plugin.el.on('mouseover', 'nav li', plugin.onMenuItemHovered);
        plugin.el.on('mouseover', '.sub-menu > li', plugin.onSubMenuItemHovered);
        $(document).on('LAYOUT_MODE_CHANGED', plugin.onLayoutModeChanged);
        $(document).on('click.megamenu', function(e){
            if ($(e.target).closest('.megamenu-panel').length === 0) {
                plugin.hideMegaMenuPanels();
            }
        });
        $(window).on('resize', plugin.onWindowResize);

        // Generate submenu toggles if not present
        if (plugin.navEl.find('.submenu-toggle').length === 0) {
            plugin.navEl.find('ul > li').each(function(){
                var li = $(this);
                if (li.find('> ul').length > 0) {
                    li.append('<em class="submenu-toggle submenu-collapsed"></em>');
                }
            });
        }

        // Wire up any mega menus present
        plugin.megaMenuPanels = $('.megamenu-panel');
        plugin.megaMenuPanels.each(function(){
            var mm = $(this);
            var target = plugin.el.find('li[data-label="'+mm.attr('data-target')+'"]');
           

            if (target.length ) {
                target.addClass('has-megamenu');
            }


            if (mm.hasClass('multi-tier')) {
                mm.find('.mm-tier li').on('mouseover', function(e){
                    var li = $(this);
                    li.parent().find('.hovered').removeClass('hovered');
                    li.addClass('hovered');
                    
                    var grabCentersParent = $("li.parent").closest('.mm-tier').next().next('.mm-tier'); 
                    grabCentersParent.find('.parent-active').removeClass('parent-active');
                    grabCentersParent.find('[data-parent="'+li.attr('data-parent')+'"]').addClass('parent-active');



                    var targetTier = li.closest('.mm-tier').next('.mm-tier');
                    targetTier.find('.active').removeClass('active');
                    targetTier.next('.mm-tier').find('.active').removeClass('active');
                    targetTier.find('[data-label="'+li.attr('data-label')+'"]').addClass('active');
                });
            }
        });

        app.components.SiteBar = plugin;

        // possible fix to submenu thing opening megamenu

        $('.sub-menu .has-megamenu').removeClass('has-megamenu');

    });

})(jQuery);

