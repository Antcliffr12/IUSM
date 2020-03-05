/**
 * Custom script for component
 */
(function($){

    var plugin = {};
    plugin.el = $('.events-upcoming'); // Set top-level component element scope
    plugin.load = plugin.el.find('.load-more');
    plugin.ajaxLoader = plugin.el.find('.ajax-loader');
    plugin.content = plugin.el.find('.loaded-content');
    plugin.counter = plugin.el.find('.count');

    if (plugin.el.length === 0) {
        return false;
    }
    // show the load more link if available.
    plugin.load.show();

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
                action : 'iu_upcoming_events_return'
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
                    // console.log(data);
                    var contClass = 'postCont-' + data.count;
                    var output = '';
                    $.each(postItems, function(){
                        var _this = $(this);
                        var id = _this[0].id,
                            title = _this[0].title,
                            content = _this[0].content,
                            location = _this[0].location,
                            url = _this[0].url,
                            start_date = _this[0].start_date,
                            end_date = _this[0].end_date,
                            contact_email = _this[0].contact_email,
                            calendar_id = _this[0].calendar_id;

                        output += '<div class="item" data-id="'+id+'" data-count="'+data.count+'">';
                        output += '<div class="date_square"></div>';
                        output += '<div class="content">';
                        output += '<span class="date">' + start_date + '</span>';
                        output += '<h2>' + title + '</h2>';
                        output += '<p class="description">' + content + '</p>';
                        output += '<div class="lower">';
                        output += '<div class="location">' + location + '</div>';
                        output += '<a href="' + url + '">I\'m Going</a>';
                        output += '</div>';
                        output += '</div>';
                        output += '<hr />';
                        output += '</div>';
                    });

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
