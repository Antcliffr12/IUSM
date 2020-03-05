<?php 

require_once TEMPLATEPATH . '/assets/components/events-dropdown/events-dropdown.class.php';

$eventFeed = isset($main_rss_events) ? $main_rss_events : 'No Events Selected';

$campusFeed =isset($campus_rss_events) ? $campus_rss_events : 'No Events Selected';

$departmentFeed = isset($department_rss_events) ? $department_rss_events : 'No Events Selected';

$other_events = isset($other_events) ? $other_events : 'No Events Selected';



$eventCount = isset($event_rss_feed_number) ? $event_rss_feed_number : 5;
//edit

if($eventFeed){
  $url = 'https://events.iu.edu/live/json/events/group_id/'.$eventFeed.'';
}elseif($campusFeed){
  $url = 'https://events.iu.edu/live/json/events/category_id/'.$campusFeed.'/group_id/9/tag_id/';
}elseif($departmentFeed){
  $url = 'https://events.iu.edu/live/json/events/group_id/9/tag_id/'.$departmentFeed.'';
}
elseif($other_events){
    $url = 'https://events.iu.edu/live/json/events/category_id/13/group_id/9/tag_id/'.$other_events.'/';
}else{
  $url = 'Something is wrong with Feed';
}

$data = new EventDropdownFeed();

// $EventFeed = !empty($url) ? $data::GetEvents($url) : 'Something is wrong with Feed';
$eventData = !is_null($url) ? $data::GetEvents($url, date("Y-m-d")) : '';
?>

<h2>Upcoming Events</h2>
<div class="events">
<input type="text" id="datepickerLocation" placeholder="Please Select Date"/>
<input type="button" value="Clear dates" class="btn" id="reset-date">

  <div class="row">
    <div class="col-md-12 column_1" style="margin-top:35px;">
      <div class="events-content-upcoming-events"></div>
        <div class="btn-wrap">
          <button type="button" id="btn-load-more" class="btn btn-secondary event_load">Load More</button>
        </div><!-- btn wrap -->
    </div>
  </div>
</div>
<script type="text/javascript">
jQuery('document').ready(function($){

var numberperload = 5;
var lastload = 0;
var eventArray = null;
eventArray = <?php echo json_encode( $eventData ); ?>;

ShowAllEvents();
ClearEvents();

function ShowAllEvents(){
  //shows and removes events after 5
  $('.btn-wrap').show();
  $('#btn-load-more').show();
  //clear children
  $('.events-content-upcoming-events').empty();
  var countEvents = 0;
  $.each(eventArray, function(i, val){
    ShowEvent(eventArray[i]);
      countEvents++;
  });

  if(countEvents==0){
      $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
      $('#btn-load-more').hide();
   }

    hideEvents();

    hideButton();




}

function ClearEvents(){
  $('#reset-date').on('click', function(){
    $('#datepickerLocation').datepicker('setDate', null);
       ShowAllEvents();
    });
}

$('#datepickerLocation').datepicker({
  dayNamesMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
    dateFormat: 'yy-mm-dd',
    
    //showAnim: 'fold',
    firstDay: 7, // Start with Monday
    onSelect: function (date, inst) {
      $('.btn-wrap').show();
      $('#btn-load-more').show();
      $('.events-content-upcoming-events').empty();
      var countEvents = 0;

      $.each(eventArray, function(i, val){
        var startDate = eventArray[i]['date_utc'].substring(0,10);

        if(date == startDate){     
          countEvents++;
          ShowEvent(eventArray[i]);    
          console.log(countEvents);
      
        }
      });

      if(countEvents==0){
               $('.events-content-upcoming-events').append("<h2 style='margin-top:25px;'>Sorry, No Events</h2>");
               $('#btn-load-more').hide();
             }

             hideEvents();

             hideButton();

      inst.inline = false;

    }
});

function ShowEvent(eventObject){


  
  var startDate = eventObject['date'];
  var title = eventObject['title'];
  var description = eventObject['description'];

  var testing = eventObject['date_utc'];
  var d = new Date(testing);
   d.setMinutes( d.getHours() - 5 );


 //console.log((d.getMonth() + 1) + '/' + d.getDate() + '/' +  d.getFullYear());

  //console.log(d.getFullYear() + '-' + (d.getMonth() + 1) + '-' +  d.getDate() );

  


  var dateTime = eventObject['date_time'];
  var fullDate = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' +  d.getDate();

  var date = new Date(fullDate);
  var timeFrame = eventObject['date_time'];
  var monthName = eventObject['date'].substring(0,3);
  var day = d.getDate();
  var getYear = new Date(eventObject['date_utc']);

   var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
  // var dayOfWeek = date;
//  var dayOfWeek = date;

//+ weekday[dayOfWeek.getDay()] +

  //console.log(dayOfWeek);
  var eventTime = eventObject['date_time'];


  if (navigator.userAgent.indexOf("Chrome") !== -1){
    var d = new Date(fullDate);
    var n = weekday[d.getDay()];
  }
  else{
    var d = new Date(fullDate);
    var n = weekday[d.getDay() + 1];
  }



  var yyyy = date.getFullYear();

  var eventDiv = '<div class="upcoming-event">'+
                    '<div class="upcoming-event-padding">'+
                      '<div class="date-block-area col-md-1 no-padding">'+
                              '<div class="date-block">'+
                                '<div class="date-block-content">'+
                                   '<div class="date-block-month">'+monthName +'</div>'+
         														'<div class="date-block-day">'+fullDate.substring(7,10)+'</div>'+
                              '</div>'+//dateblock content 
                            '</div>'+//date-block 
                      '</div>'+//col 1 block               
                      '<div class="upcoming-event-info col-md-10">'+
                      '<div class="event-date" data-startical=\''+ eventObject['date_utc'] + '\' data-endical=\''+eventObject['date2_utc'] + '\'>'+ n + ' ' + monthName + ' ' + day + ' ' + getYear.getFullYear() + ' ' + eventTime + '</div>'+
                      '<div class="event-title"><h2><a target="_blank" href="<?php echo esc_url( get_permalink( get_page_by_title( 'More Event' ) ) ); ?>?eventId='+eventObject['id']+'">'+title+'</a></h2></div>'+
                        '<div class="event-description">'+ ((description) ? description : ' ') + '</div>'+
                     
                      '<div class="event-information">'+
                        '<div class="event-location">'+
                          '<div class="event-location-img"></div>'+
                          '<h3><a class="location_link" target="_blank" href="http://maps.google.com/?q='+eventObject['location']+' ">' + eventObject['location']+ ' ' + ((eventObject['custom_room_number']) ? eventObject['custom_room_number'] : ' ') + '</a></h3>'+

                        '</div>'+ //event location 
                        '</div>'+ // upcoming events
                      '</div>'+//event info 
                    '</div>' + //event padding
                  '</div>'//upcoming event
                  $('.events-content-upcoming-events').append(eventDiv);
                  

}//showEvent

$( "#btn-load-more" ).click(function() {
      var categorylist = $('.upcoming-event');

      var upToLoad = lastload + numberperload;

      for (var i = lastload; i < upToLoad; i++) {
          $(categorylist[i]).show();
          hideButton();
        }
      lastload = upToLoad;
  });//end load more click

  function hideButton(){
           if ( $('.upcoming-event').length == $('.upcoming-event:visible').length) {
               $('.btn-wrap ').hide();
           }
         }

         function hideEvents(){
         	var categorylist = $('.upcoming-event');
         	var totallicat = categorylist.length;

         	if(totallicat > numberperload){
         		lastload = numberperload;
         		for (var i = numberperload; i < totallicat; i++) {
         				$(categorylist[i]).hide();
         		}
         	}



         }//end hide events

});
</script>
