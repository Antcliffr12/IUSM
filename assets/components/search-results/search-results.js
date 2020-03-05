
jQuery('document').ready(function($){

    var authorsSearch = $('#search-results-search-bar'),
        selects = authorsSearch.find('select');

    $.each(selects, function(e){
        $(this).change(function(){
            $(this).closest('form').submit();
        });
    });

    

});