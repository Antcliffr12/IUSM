jQuery(document).ready(function($) {

        var wrapper = $('.stc-subscribe-wrapper');
        var input = wrapper.find('.form-group input');

        if(input.length > 0){

            $.each(input, function(){
               $(this).attr('value', '');
               $(this).attr('placeholder', 'Email Address');
            });

        }

        /** Set default category selection on hidden checkbox elements within a third party plugin **/
        var cont = $('*[data-category]'); // Set in the primary container for data on respective pages. Not always in same spot.
        var subscribeToBlog = $('.subscribe-to-blog');
        var categoryBoxes = subscribeToBlog.find('.stc-categories .checkbox');
        if(cont.length > 0 ){
            var theCategory = cont.data('category');
            if(typeof theCategory != "undefined") {
                $.each(categoryBoxes, function () {
                    var label = $(this).find('label');
                    var cat = $.trim(label.text());
                    if(cat == theCategory){
                        label.find('input').prop('checked', 'checked');
                    }
                });
            }
        }else{
            // Select the All option of no category is present for the user.
            $.each(subscribeToBlog.find('.stc-categories'), function () {
                $(this).find('.checkbox').first().find('label input').prop('checked', 'checked');
            });
        }

});
