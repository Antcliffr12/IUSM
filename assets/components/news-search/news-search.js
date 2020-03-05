

jQuery('document').ready(function($){

    var authorsSearch = $('#search-news'),
        selects = authorsSearch.find('select');

        $.each(selects, function(e){
            $(this).change(function(){

                if($(this).val() !== '0')
                    $(this).closest('form').submit();
            });
        });

});
