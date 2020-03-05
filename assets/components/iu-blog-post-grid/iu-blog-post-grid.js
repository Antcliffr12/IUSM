/**
 * Custom script for component
 */
(function($){

	var plugin = {};
	plugin.el = $('.iu-blog-post-grid'); // Set top-level component element scope
	plugin.load = plugin.el.find('.load-more');
	plugin.ajaxLoader = plugin.el.find('.ajax-loader');
	plugin.content = plugin.el.find('.loaded-content');
	plugin.counter = plugin.el.find('.count');


	if (plugin.el.length === 0) {
		return false;
	}

	$.each(plugin.load, function(){

		var url = iu_vars.iu_ajax_url;
		var nounce = iu_vars.iu_nounce;


		var loader = $(this);

		loader.on('click', function(){

			$(this).hide();
			plugin.ajaxLoader.css('display', 'table');

			var input = {
				count: plugin.counter.html(),
				nounce : nounce,
				action : 'iu_blog_posts_return'
			};

			$.ajax({
				method : "POST",
				url : url,
				data : input,
				beforeSend: function(){
					//loaderImage.show();
				},
				success : function(results, textStatus, jqXHR) {
					var data = JSON.parse(results);
					var postItems = data.post_items;

					var contClass = 'postCont-' + data.count;
					var output = '<div class="'+ contClass +'">';
						$.each(postItems, function(){
							var _this = $(this);
							var permalink = _this[0].permalink,
								postThumbnail = _this[0].postThumbnail,
								title = _this[0].title,
								removeRightMargin = _this[0].removeRightMargin;

							var removeMargin = removeRightMargin === true ? ' style="margin-right:0;"' : '';

							output += '<div class="grid-item"'+ removeMargin + '>';
							output += '<div class="image">';
							output += '<a href="'+ permalink +'"><img src="'+ postThumbnail +'" /></a>';
							output += '</div>';
							output += '<h1 class="title"><a href="'+ permalink +'">'+ title +'</a></h1>';
							output += '</div>';
						});
					output += '</div>';

					plugin.content.append(output);
					var thePosts = plugin.content.find('.' + contClass);
						thePosts.hide().fadeIn('slow');


					contClass = '';
					var count = data.count;
					plugin.counter.html(count);


					plugin.ajaxLoader.hide();


					if(data.empty){
						plugin.load.hide();
					}else{
						plugin.load.show();
					}


				},
				error : function(){
					plugin.ajaxLoader.hide();
					plugin.load.show();
				}
			});



		});

	});

})(jQuery);
