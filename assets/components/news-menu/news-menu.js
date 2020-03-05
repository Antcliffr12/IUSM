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



jQuery("#mobile-menu").click(function() {
    jQuery('.mobile-options').toggle();
   // (jQuery(this).text() === "☰") ? jQuery(this).text("close") : jQuery(this).text("☰");
   //(jQuery(this).text() === "☰") ? jQuery(this).text("close") : jQuery(this).text("☰");
});


jQuery(document).ready(function($) {
  //get ul class and find the subclass using find()
  var allPanels = jQuery('.mobile-options').find('li > p > div');
  //hide what we found using find()
  allPanels.hide();

  $('.mobile-options p').on("click", function(e){
      $(this).next('.dropdown-content').slideToggle('slow');
      $('em').addClass('submenu-shown');
      e.stopPropagation();
      e.preventDefault();
    });

    $('.dropdown-content p').on("click", function(e){
        $(this).next('ul').slideToggle('slow');
        e.stopPropagation();
        e.preventDefault();
      });




   jQuery(".main-item > p").append('<em class="submenu-toggle-parent submenu-collapsed"></em>');
   jQuery(".sub-menu > p").append('<em class="submenu-toggle submenu-collapsed child"></em>');

});
