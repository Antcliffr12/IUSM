/**
 * Custom script for component
 */
(function($){

	var plugin = {};
	plugin.el = $('.recent-posts'); // Set top-level component element scope
	plugin.sliderContainer = plugin.el.find('.recent-posts-slider');
	plugin.categories = plugin.el.find('.categories');

	if (plugin.el.length === 0) {
		return false;
	}

	// Sets a border on a single Category link for tablet and below.
	plugin.setCategoryBottomBorder = function() {
		$.each(plugin.categories, function () {
			$categoryCount = $(this).find('ul').first().data('count');
			if ($categoryCount === 1) {
				var vWidth = $(window).width();
				var firstLink = $(this).find('ul').first().find('a');
				(function setBorder() {
					if (vWidth < 992) {
						if (firstLink.hasClass('bottom-border') == false) {
							firstLink.addClass('bottom-border');
						}
					} else {
						firstLink.removeClass('bottom-border');
					}
				})();
			}
		});
	};
    $.each(plugin.sliderContainer, function(){
        var image = $(this).find('.image'), postContent = $(this).find('.post-content');
        image.slick({
            arrows : true,
            dots : false,
            speed : 500,
            fade : true,
            asNavFor : '.post-content',
            focusOnSelect : true,
            adaptiveHeight: true
        });

        postContent.slick({
            arrows : false,
            dots : false,
            speed : 500,
            fade : true
        });

        // Fix ARIA references
        postContent.find('.slick-slide').each(function(){
            $(this).removeAttr('aria-describedby');
        });

        $.each(image.find('.slick-slide'), function(key, value){
            $(this).attr('aria-describedby', 'recent-posts0' + key);
            postContent.find('.slick-slide')[key].children[1].id = $(this).attr('aria-describedby');
        });






    });

    $(window).on('resize', plugin.setCategoryBottomBorder);



})(jQuery);
