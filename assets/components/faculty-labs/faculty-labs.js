 jQuery('document').ready(function($){

    var authorsSearch = $('.faculty-labs-search'),
        selects = authorsSearch.find('select');

        $.each(selects, function(e){

            $(this).change(function(){

                if($(this).val() !== '0')
                    $(this).closest('form').submit();
            });
        });

        if($('.extras').length > 0)
          {
            var divHeightParent = $('.faculty-labs-search').height();
            var divHeightExtras = $('.extras').height();

            var combineHeight = divHeightParent + divHeightExtras;
            $('.faculty-labs-search').css('height', combineHeight+'px');
          }

          
         
        $("#searchTypes").submit(function() {
            if($("#research").val()=="") {
              $("#research").remove();    
            }
            if($("#subspecialty").val() == "") {
              $("#subspecialty").remove();
            }
        });
  
     
       

});
