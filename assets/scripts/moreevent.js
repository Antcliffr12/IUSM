jQuery(function() {
  var this_js_script = $('script[src*=event]');
  var istodayJS = this_js_script.attr('data-istoday');

  jQuery('nav li a').click(function(event){
       //remove all pre-existing active classes
       $('.active').removeClass('active');

       //add the active class to the link we clicked
       $(this).addClass('active');

       //Load the content
       //e.g.
       //load the page that the link was pointing to
       //$('#content').load($(this).find(a).attr('href'));

       event.preventDefault();
   });

});
