

jQuery('document').ready(function($){

    var authorsSearch = $('.authors-search'),
        selects = authorsSearch.find('select');

        $.each(selects, function(e){
            $(this).change(function(){

                if($(this).val() !== '0')
                    $(this).closest('form').submit();
            });
        });

});