// ref: https://codepen.io/tomdurkin/pen/nvAjd///https://codepen.io/tomdurkin/pen/nvAjd///https://codepen.io/tomdurkin/pen/nvAjd/

(function($){
    "use strict";
    $(function() {

        var body = document.body,
            html = document.documentElement,
            docHeight = function() {
                return {
                    'scrollHeight' : Math.max(body.scrollHeight, body.offsetHeight,
                        html.clientHeight, html.scrollHeight, html.offsetHeight),
                    'clientHeight' : html.clientHeight
                }
            },
            siteBar = $('#site-bar'),
            mainContent = $('#main-content'),
            shrinkHeader = function(docHeight){
                var lastScrollTop = 0;
                $(window).on("scroll", function(){
                    var st = $(this).scrollTop();
                    if(st < (docHeight.scrollHeight - (docHeight.clientHeight * 1.5))) {
                        if (st > 100 && st > lastScrollTop) {
                            siteBar.addClass("shrink");
                            mainContent.addClass('shrink');
                        } else {
                            siteBar.removeClass("shrink");
                            mainContent.removeClass('shrink');
                        }
                    }
                    lastScrollTop = st;
                });
            };

            shrinkHeader(docHeight());
            $(window).resize(function(){
                shrinkHeader(docHeight());
            });

    })
})(jQuery);