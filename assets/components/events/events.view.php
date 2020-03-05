<?php
require_once TEMPLATEPATH . '/assets/components/events/events.class.php';

$eventFeed = isset($event_rss_feed) ? $event_rss_feed : null;
// $eventCount = isset($event_rss_feed_number) ? $event_rss_feed_number : 5;

$data = new EventFeed();



$eventData = !is_null($eventFeed) ? $data::GetFeed($eventFeed, date("Y-m-d")) : '';
 ?>



  <h2>Upcoming Events</h2>
<div class="events" data-component="f">
  <input type="text" id="datepickerLocation" placeholder="Please Select Date"/>
  <input type="button" value="Clear dates" class="btn" id="reset-date">

    <div class="row">
      <div class="col-md-12 column_1" style="margin-top:35px;">
        <div class="events-content-upcoming-events"> </div>
          <div class="btn-wrap">
            <button type="button" id="btn-load-more" class="btn btn-secondary event_load">Load More</button>
          </div><!-- btn wrap -->
      </div>
    </div>
</div>
<script>
(function($){
    'use strict';

  $(function() {


  var numberperload = 5;
  var lastload = 0;
  var eventList = null;

eventList = <?php echo json_encode($eventData,  JSON_HEX_QUOT | JSON_HEX_TAG |JSON_HEX_AMP | JSON_HEX_APOS | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_FORCE_OBJECT | JSON_PRESERVE_ZERO_FRACTION | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR); ?>;



ShowAllEvents();
ClearEvents();
function ShowAllEvents(){
  //shows and removes events after 5
  $('.btn-wrap ').show();
  $('#btn-load-more').show();
  //clears children
$('.events-content-upcoming-events').empty();
	var countEvents=0;
$.each(eventList , function(i, val) {
    ShowEvent(eventList[i]);
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
    dateFormat: 'mm-dd-yy',
    //showAnim: 'fold',
    firstDay: 7, // Start with Monday
    onSelect: function (date, inst) {
       $('.btn-wrap ').show();
       $('#btn-load-more').show();
	     $('.events-content-upcoming-events').empty();


      var dateEvent = formatEventDate(date);
      var countEvents = 0;

      $.each(eventList , function(i, val) {
          var startDate = eventList[i]['start-date-time'].substring(0,10);

          if(  dateEvent == startDate ){
              countEvents++;
  						ShowEvent(eventList[i]);


          }


      });



      if(countEvents==0){
        $('.events-content-upcoming-events').append("<h2 style='margin-top:25px;'>Sorry, No Events</h2>");
        $('#btn-load-more').hide();
      }

      hideEvents();

      hideButton();

      inst.inline = false;
    },
    onChangeMonthYear : function(year, month){


    }

  });

  function ShowEvent(eventObject){

    var newstartDate = fullDateAllBrowsers(eventObject['start-date-time']);
  	var dayString = newstartDate.toString().substring(0,21);
  	var yearString = newstartDate.toString().substring(7,10);
  	var monthShow = newstartDate.toString().substring(4,8);
  	var day = dayString.toString(yearString,'');

  	var eventDiv ='<div class="upcoming-event">'+
  									'<div class="upcoming-event-padding">'+
  											'<div class="date-block-area col-md-1 no-padding">'+
  												'<div class="date-block">'+
  													'<div class="date-block-content">'+
  														'<div class="date-block-month">'+ monthShow +'</div>'+
  														'<div class="date-block-day">'+eventObject['start-date-time'].substring(3,5)+'</div>'+
  													'</div>'+
  												'</div>'+
  											'</div>'+
  											'<div class="upcoming-event-info col-sm-10 col-md-11 no-padding">'+
  												'<div class="event-date" data-sdical='+ encodeURI(eventObject['start-date-time']) + ' data-edical='+ encodeURI(eventObject['end-date-time']) + ' > '+ day + eventObject['start-date-time'].substring(16,19) + ' - ' + eventObject['end-date-time'].substring(10,17) + eventObject['end-date-time'].substring(16,19) +' </div>'+
  												'<div class="event-title"><h2>'+ ((eventObject['summary']) ? eventObject['summary'] : 'No Title')+'</h2></div>'+
  												'<div class="event-description">'+ eventObject['description'].substring(0,300)
                              +'...'+'<a href="<?php echo esc_url( get_permalink( get_page_by_title( 'More Event' ) ) ); ?>?eventId='+eventObject['event-id']+'">MORE</a> '+
                          '</div>'+
                          '<div class="event-information">'+
                            '<div class="event-location">'+
                              '<div class="event-location-img"></div>'+
                              '<h3><a class="location_link" target="_blank" href="http://maps.google.com/?q='+eventObject['location']+' ">'+eventObject['location']+'</a></h3>'+
                                '</div>'+ //event location
                                  '<div class="event-button">'+
                                    '<a href="#" id="btnIcal">'+
                                      '<h5>Add to Calendar</h5>'+
                                    '</a>'+
                                  '</div>'+//event button
  											  '</div>'+ //event-information div
                         '</div>' +
  										 '</div>'+
  									 '</div>'+
  								 '</div><!-- end div -->';
  	$('.events-content-upcoming-events').append(eventDiv);

  }


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


  $(document).on('click', '#btnIcal', function () {
  		var $this = $(this);

  		var eventObject = $this.parent().parent().parent().parent(),
  			location = eventObject.find('.event-location').text(),
  			subject = eventObject.find('.event-title').text(),
  			description = eventObject.find('.event-description').text(),
  			start_date = icalAllBrowsers(decodeURI( eventObject.find('.event-date').data('sdical'))),//formatDateTimeIcal(new Date( decodeURI( eventObject.find('.event-date').data('sdical')) )),
  			end_date = icalAllBrowsers(decodeURI( eventObject.find('.event-date').data('edical'))),//formatDateTimeIcal(new Date( decodeURI( eventObject.find('.event-date').data('edical')) )),
  			fileName = subject.substring(0,10),
  			todayDate = formatDateTimeIcal(new Date());


  		var icsMSG =	createIcalBody(todayDate,start_date, end_date,  description, location, subject);

    var icsBody = "data:text/calendar;charset=utf8," + escape(icsMSG);
    var downloadLink = document.createElement("a");
    downloadLink.href = icsBody;
    downloadLink.download = fileName +".ics";

    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
  });

  function	createIcalBody(todayDate,start_date, end_date,  description, location, subject){
  	return icsMSG = "BEGIN:VCALENDAR\nVERSION:2.0\nPRODID:-//Our Company//NONSGML v1.0//EN\n"+
  		"BEGIN:VEVENT\nUID:ryanantc@iu.edu\n"+
  		"DTSTAMP:"+todayDate+"\nATTENDEE;CN=My Self ;RSVP=TRUE:MAILTO:ryanantc@iu.com\n"+
  		"ORGANIZER;CN=ryanntc@iu.edu:MAILTO::ryanantc@iu.edu\n"+
  		"DTSTART:" + start_date +"\n"+
  		"DTEND:" + end_date +"\n"+
  		"DESCRIPTION:" + description +"\n"+
  		"LOCATION:" + location + "\n"+
  		"SUMMARY:" + subject + "\n"+
  		"END:VEVENT\n"+
  		"END:VCALENDAR";
  }


  function formatDateTimeIcal(dateTime) {
  	return	('' + dateTime.getUTCFullYear() + ensureTwo(dateTime.getUTCMonth() + 1) +
  			ensureTwo(dateTime.getUTCDate()) + 'T' + ensureTwo(dateTime.getUTCHours()) +
  			ensureTwo(dateTime.getUTCMinutes()) + ensureTwo(dateTime.getUTCSeconds()) + 'Z');
  }

  function icalAllBrowsers(dateTime){

      var momento = dateTime.split(' '),
                      date = momento[0].split('-'),
                      time =  momento[1],
                      meridiam = momento[2],
                      arrayT = time.split(':'),
                      hours = (ensureTwo(parseInt(arrayT[0])+4)).toString(),
                      minutes = arrayT[1];

      if(meridiam=="PM"){
                      hours = (parseInt(arrayT[0])+16).toString();
      }

      return   ('' + date[2] + date[0] +date[1] + 'T' + hours + minutes + '00Z');

  }

  function fullDateAllBrowsers(dateTime){

      var momento = dateTime.split(' '),
                      date = momento[0].split('-'),
                      time =  momento[1],
                      meridiam = momento[2],
                      arrayT = time.split(':'),
                      //hours = (ensureTwo(parseInt(arrayT[0])+4)).toString(),
                      hours = (ensureTwo(parseInt(arrayT[0]))).toString(),
                      minutes = arrayT[1];

      return   (new Date(date[2],parseInt(date[0])-1, parseInt(date[1]),hours,minutes, 0   ));

  }

  function formatEventDate(date){
    //var dateTime = new Date(date);
    var dateTime = dateAllBrowsers(date);
  	 return   ("0"+(dateTime.getMonth()+1)).slice(-2) + "-" +("0"+dateTime.getDate()).slice(-2) + "-" + dateTime.getFullYear();
  }
  function ensureTwo (value) {
  	return (value < 10 ? '0' : '') + value;
  }

  function dateAllBrowsers(date){
      var momento = date.split('-'),
                      month = ensureTwo(parseInt(momento[0])-1);
      return  (new Date(momento[2],month,momento[1]));
  }



  });
})(jQuery); //end of main function
</script>
