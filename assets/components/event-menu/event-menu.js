jQuery('document').ready(function($){
    var cont = $('.blog-menu');
    var nav = cont.find('nav');
    var subItem = nav.find('a:contains("Subscribe")');
    if(subItem.length > 0){
        subItem.click(function(e){
            e.preventDefault();
            $('.subscriptionItems').show();
        });
        $('.subClose').click(function(){
            $(this).parent().parent().parent().hide();
        });
    }

  

});

