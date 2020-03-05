<?php
/*  Template Name: Event In Page Template */

get_header();
get_template_part('partials/header-content');

include 'utilities.php';

$is_today = json_encode("nothing");

if (isset($_GET['isToday'])) {
    $is_today = json_encode($_GET['isToday']);
}


$utilities = new Utilities();
global $post;

?>
<section id="content">
<div class="featured-event">
  <div class="container">
    <?php
    $args = array(
    "post_type" => "featured_event",
    "post_status"      => "publish",
    'meta_key'       => 'rss_feed',
    'meta_value' => 'yes',

    );
    $featured_post = get_posts($args);
    ?>

    <div class="featured-event-content">
      <?php
      if ($featured_post) {
      ?>
      <div class="col-md-6 col-sm-0 custom-featured">
        <?php
        foreach($featured_post as $post) :
          setup_postdata( $post );
          echo get_the_post_thumbnail( $post->ID, 'iu-blog-large', array( 'class' => 'img-responsive' ) );

          $startDate = get_post_meta( $post->ID,'start_date',true);
          $location = get_post_meta( $post->ID,'location',true);
          $start_time = get_post_meta( $post->ID,'start_time',true);
          $end_time = get_post_meta( $post->ID,'end_time',true);

           $date = new DateTime($startDate);

           $origDate = $startDate;

           $week = DateTime::createFromFormat('m-d-Y', $origDate);
           $DayOfWeek =  $week->format('D');
           $the_date = $week->format('D M d');


         ?>
      </div>
      <div class="featured-event-half col-md-6 col-sm-12">
        <div class="featured-event-info">
          <div class="featured-event-title flex-vertical-spacing">
            <h2><?= the_title() ?></h2>
          </div>
          <div class="featured-event-date flex-vertical-spacing">
            <?= $the_date . ' ' . $start_time . '-' . $end_time; ?>
          </div>
          <div class="featured-event-info-paragraph flex-vertical-spacing">
            <?php

            $more = '... <a href="' . esc_url(get_permalink( get_page_by_title( 'More Event')  ) ). '?eventId='. get_the_ID() .'&date='.$startDate .'">More</a>';
            $content = get_the_content();
            $trimmed_content = mb_strimwidth( $content, 0, 500, $more );
            echo $trimmed_content;
            ?>
          </div>
          <div class="featured-event-location flex-vertical-spacing">
            <div class="featured-event-location-img"> </div>
            <h3>
              <a target="_blank" class="location_link" href="http://maps.google.com/?q=<?= $location ?> "> <?= $location ?> </a>
            </h3>
          </div>

        </div>
      </div>
      <?php
    endforeach;
      ?>
      <?php
    }else{
      ?>
      <div class="featured-event-half col-md-6 col-sm-0 featured-image"></div>
      <div class="featured-event-half col-md-6 col-sm-12">
        <div class="featured-event-info-options">
          <!-- featured Event Area -->

        </div>
      </div>

      <?php
    }
      ?>
    </div>
  </div>
</div>
</section>
<?php echo render_component('event-menu'); ?>

<div class="events-page-content">
<div class="container">
  <div class="events-content">
    <div class="events-content-sidebar col-md-3 col-sm-0 no-padding">

  			<div id="datepicker" class="calendar col-md-12 no-padding"></div>

      <div class="subscribe-to-blog">
        <h1 class="search-events-title">Search Events</h1>
      <div class="box">

        <div class="item">
            <h2>Location</h2>
            <div class="search-events-options">
                <?php echo $utilities->DropDownList('Location', 'locationSelector'); ?>
            </div>
        </div>

          <div class="item ">
            <h2>Audience</h2>
            <div class="search-events-options">
              <?php echo $utilities->Audience('Audience', 'eventTypeSelector'); ?>
            </div>
          </div>

          <div class="item ">
            <h2>Group</h2>
            <div class="search-events-options">
              <?php echo $utilities->DropDownList('Group', 'groupSelector'); ?>
            </div>
          </div>

      </div><!-- box -->
    </div><!-- subscribe to blog -->
  </div><!-- event sidebar -->
    <div class="col-md-9 no-padding">
      <!-- wheree events list -->
      <h1>Upcoming Events</h1>

    <div class="events-content-upcoming-events">

    </div><!-- event content upcoming events -->
		<div class="btn-wrap">

			<button type="button" id="btn-load-more" class="btn btn-secondary event_load">Load More</button>

		</div><!-- btn wrap -->
  </div><!-- / col md 9 -->


    </div><!-- events container -->
  </div><!-- container -->
</div><!-- events-page-content -->
<script>
(function($) {
  'use strict';

  $(function() {





var numberperload = 5;
var lastload = 0;
var eventList = null;

$('#datepicker').datepicker({
  dayNamesMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
  dateFormat: 'mm-dd-yy',
  showAnim: 'fold',
  firstDay: 7, // Start with Monday
  onSelect: function (date, inst) {
    $('.ui-state-default').removeClass('has-events');

    var selectedDay = date.substring(3,5);
    var listListBox = $('.ui-state-default');

    $.each(listListBox, function (idx, value){

      if(parseInt( $(listListBox[idx]).text())== selectedDay){

          $(listListBox[idx]).addClass('has-events');
          return false;

      }

    });

    //$('.ui-state-default').addClass('has-events');
    $('.events-content-upcoming-events').empty();

    eventList = callingXMLData($('#datepicker').datepicker().val(), false, 'none');


    var dateEvent = formatEventDate(date);
    var countEvents= 0;

    $.each(eventList , function(i, val) {

        var startDate = eventList[i]['start-date-time'].substring(0,10);

        if (   navigator.userAgent.search("Firefox")   || navigator.userAgent.search("Safari") ) {
          if(  dateEvent <= startDate ){
              countEvents++;
              ShowEvent(eventList[i])
          }
        }else{
          if(  new Date(dateEvent) <= new Date(startDate) ){
              countEvents++;
              ShowEvent(eventList[i])
          }
        }


        // if(  dateEvent.toString() === startDate ){
				// 		countEvents++;
				// 		ShowEvent(eventList[i])
        // }
    });

    if(countEvents==0){

     $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
     $('#btn-load-more').hide();

    }
		hideEvents();
    inst.inline = false;
  },
  onChangeMonthYear : function(year, month){
    $('.events-content-upcoming-events').empty();
    //eventList = callingXMLData(year+"-"+month+"-01", false);

    eventList = callingXMLData(ensureTwo(month)+"-01-"+year, false, 'none');


    $('#btn-load-more').hide();


  }

});
eventList = callingXMLData($('#datepicker').datepicker().val(), true, 'none');

ShowAllEvents();

var isToday = <?php echo $is_today; ?>;
if( isToday!="nothing"){

  if(isToday=="true"){
    todayDateEvent();
  }else{
    getWeekEvents();
  }

}

///

//PaintBlueDaysWithEvents(eventList);






var counter=0;
var justOne = false;
$.each(eventList, function(i, val,day) {


  //console.log($this.find('event'));

		//loops to find true in featured.
	if(eventList[i]['featured'] == 'true' ){
		//var featured = eventList[i]['start-date-time'];
    var featured = '03-07-2018 04:00 PM';

		//this gets first two strings of date, compares to start-date-time first two strings
		var featuredstart = featured.toString().substring(0,2);
		var featured_month = featured.toString().substring(0,2);
		//to print day of week month and time am/pm

    var newstartDate = fullDateAllBrowsers(eventList[i]['start-date-time']);
    //var newstartDate = 'Tue Mar 07 2018 04:00:00 GMT-0500 (Eastern Standard Time)';

		var dayString = newstartDate.toString().substring(0,21);
		var yearString = eventList[i]['start-date-time'].substring(6,10);
		var monthNumber = parseInt(eventList[i]['start-date-time'].substring(0,3))-1;
		var day = dayString.replace(yearString,'');
    var templateUrl = '<?= get_bloginfo("template_url"); ?>';

    var trys = eventList[i]['description'];
    var regExString = /(<([^>]+)>)/ig; //create reg ex and let it loop (g)
    // var image = eventList[i]['unique-id'];
    // console.log(image);
   // var image = eventList[i]['image-url-large'];
    var image = '<img src=' + templateUrl + '/assets/images/event-placeholder.png />'; 

    // if( typeof(image)  != "undefined" && Object.keys(image).length > 0){
    //   image = '<img src="'+ image +'" alt="'+ eventList[i]['summary'] +'" />';
    // }else{
    //   image = '<img src='+templateUrl+'/assets/images/event-placeholder.png alt="placeholder" />';
    // }

    trys = trys.replace(regExString, "") //find all tags and delete them.
		//if true compare month with start-date-time month print featured event.

		 if(featured_month == featuredstart)
		{
      counter++;

      var featuredImage = '<div class="featured-image">'+ image + '</div>';
      $('.featured-image').append(featuredImage);


			var featuredDiv = '<div class="slider"><div class="featured-event-title flex-vertical-spacing"><h2>'+eventList[i]['summary'] +'</h2></div>'+
			//'<div class="featured-event-date flex-vertical-spacing">'+
			//day +eventList[i]['start-date-time'].substring(16,19) + ' - ' + eventList[i]['end-date-time'].substring(10,17) + eventList[i]['end-date-time'].substring(16,19)+'</div>'+
      '<div class="featured-event-date flex-vertical-spacing" data-sdical='+ encodeURI(eventList[i]['start-date-time']) + ' data-edical='+ encodeURI(eventList[i]['end-date-time']) + ' > '+ day + eventList[i]['start-date-time'].substring(16,19) + ' - ' + eventList[i]['end-date-time'].substring(10,17) + eventList[i]['end-date-time'].substring(16,19) +' </div>'+
			'<div class="featured-event-info-paragraph flex-vertical-spacing">'+
			//eventList[i]['description'].text().trim() +
			//$(eventList[i]['description']).text().trim() +
       decodeURI(trys).substring(0,165) +' ...'+'<a  href="<?php echo esc_url( get_permalink( get_page_by_title( 'More Event' ) ) ); ?>?eventId='+eventList[i]['event-id']+'&date='+eventList[i]['start-end-date']+'"> MORE </a> '+


			'</div>'+'<div class="featured-event-location flex-vertical-spacing">'+
				'<div class="featured-event-location-img"></div>'+
				'<h3><a target="_blank" class="location_link" href="http://maps.google.com/?q='+eventList[i]['location']+' ">'+eventList[i]['location']+'</a></h3>'+
			'</div>';
			$('.featured-event-info-options').append(featuredDiv);
			//return false;
		}

    justOne = true;
	}
	if(counter==0)
		$('.featured-event-info-options').append("<h2>Sorry, No Events</h2>");

  if(justOne)
      return false;
});
//roll
$(".slider").first().addClass("sl-active");


$(".menu-item-18250").click(function(){ // event-today
  $('.btn-wrap ').show();
  todayDateEvent();
  hideButton();
});//end click on has date

//when user clikc on this week event
$(".menu-item-18251").click(function(){ //events-this-week
  $('.btn-wrap ').show();
  getWeekEvents();
  hideButton();
});



//when user click next/previous month to paint days with events
// $(document).on('click', '.ui-datepicker-next, .ui-datepicker-prev', function () {
//     PaintBlueDaysWithEvents(eventList);
//
// });

//when user click all events tab to see all events from today to the end of the year
$(".menu-item-18253").click(function(){ //.events-all
  ShowAllEvents();
});


function PaintBlueDaysWithEvents(eventList){

    var arrayDaysE = getEventsPerday(eventList);
    var listListBox = $('.ui-state-default');

    $.each(listListBox, function (idx, value){

      if($.inArray(parseInt( $(listListBox[idx]).text()), arrayDaysE) !== -1){

          $(listListBox[idx]).addClass('has-events');


      }

    });
}

function callingXMLData(date, isAllEvents, specificUrl){

    var XMLData = null,
                    d = dateAllBrowsers(date),
                    m = d.getMonth(),
                    y = d.getFullYear(),
                    sDate = (new Date(y,m,1).toISOString().slice(0,10)).toString(),
                    eDate = (new Date(y,m+1,0).toISOString().slice(0,10)).toString();

		if(isAllEvents){
			sDate = (new Date().toISOString().slice(0,10)).toString();
			eDate = (new Date(y,11,31).toISOString().slice(0,10)).toString();
		}



    $.ajax({

      url      : "<?php echo bloginfo('template_url')?>/page-templates/calendarProxyTest.php",
      data: { startDate: sDate, endDate:eDate, selectUrl: specificUrl},
      type: 'GET',
      async: false,
      dataType : 'json',
      success  : function (data) {
      XMLData = data;
      }
    });



    if(XMLData ===0){
      return  'no-data';
    }else{
      var isOneElement = false;
      //console.log(specificUrl);

      $.each(XMLData.event, function(index, val){

        if( index=='action'){
          isOneElement = true;
          return false;
        }

      });
      if(!isOneElement)
        return (XMLData.event)? XMLData.event : [];
      else{
        var eventArray = [];
        eventArray.push(XMLData.event)
        return  eventArray;
      }
    }

}



function unique(list) {
    var result = [];
    $.each(list, function(i, e) {
        if ($.inArray(e, result) == -1) result.push(e);
    });
    return result;
}

function getEventsPerday(list){

    var arrayDaysE = [];
    $.each(list, function (idx, value){
        var day = parseInt( list[idx]['start-date-time'].substring(3,5));
        arrayDaysE.push(day);
    });

    return unique(arrayDaysE);

}

function formatEventDate(date){
  //var dateTime = new Date(date);
  var dateTime = dateAllBrowsers(date);
	 return   ("0"+(dateTime.getMonth()+1)).slice(-2) + "-" +("0"+dateTime.getDate()).slice(-2) + "-" + dateTime.getFullYear();
}


// gets todays events
function todayDateEvent(){

  //remove class when on another event
  $('.ui-state-default').removeClass('has-events');
  //add class when clicked on Today
  $('.events-content-upcoming-events').empty();

  eventList = callingXMLData($('#datepicker').datepicker().val(), false, 'none');


  $('#datepicker').datepicker().datepicker('setDate',new Date());
  var dateEvent = $('#datepicker').datepicker().val();
  $('.ui-state-active').addClass('has-events');
  var countEvents= 0;
  $.each(eventList , function(i, val) {

      var startDate = eventList[i]['start-date-time'].substring(0,10);
      if(  dateEvent.toString() === startDate ){
          countEvents++;
          ShowEvent(eventList[i])
      }
  });
  if(countEvents==0){
   $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
   $('#btn-load-more').hide();

  }
  hideEvents();
}

function getWeekEvents(){
  $('.ui-state-default').removeClass('has-events');

  //remove class when on another event
  $('.ui-state-active').removeClass('has-events');
  //$('.ui-state-active').parent().parent().find('.ui-state-default').addClass('has-events');
  //highlight whole week
  var currentTR = $('.ui-state-active').closest('tr');
  currentTR.find('.ui-state-default').not(":eq(0)").addClass('has-events');

  var nextTR = currentTR.next();
  nextTR.find('.ui-state-default').first().addClass('has-events');

  $('.events-content-upcoming-events').empty();
  //var currretDate = new Date('2017-04-13'); //for testing purposes only we are printing the current date
  var currretDate = new Date();
  var countEvents = 0;
  var weekstart = currretDate.getDate() - currretDate.getDay() +1;

  var weekend = weekstart + 6;       // end day is the first day + 6
  $('#btn-load-more').show();

  var stringCurentDate = ensureTwo(currretDate.getMonth() + 1) + '-' + ensureTwo(currretDate.getDate()) + '-' +  currretDate.getFullYear();

  eventList = callingXMLData(stringCurentDate , false, 'none');

  for(var i=weekstart; i< weekstart + 7; i++){
     var dayOfWeek = ensureTwo(currretDate.getMonth()+1)+"-"+ ensureTwo(i)+"-"+currretDate.getFullYear();
     var eventDayW = formatEventDate(dayOfWeek);

     $.each(eventList , function(i, val) {
      countEvents = FindEvent(eventDayW,eventList[i],countEvents);

     });
  }

  if(countEvents==0){
   $('.events-content-upcoming-events').append("<h2>Sorry, No Events this week </h2>");
   $('#btn-load-more').hide();
 }

 hideEvents();
}

//function ShowEvent(eventObject, monthNumber, countEvents, day){
function ShowEvent(eventObject){

  var newstartDate = fullDateAllBrowsers(eventObject['start-date-time']);
	var dayString = newstartDate.toString().substring(0,21);
	var yearString = newstartDate.toString().substring(7,10);
	var monthShow = newstartDate.toString().substring(4,8);
	var day = dayString.toString(yearString,'');
  var description = eventObject['description'];


function htmlEncode(value){
  // Create a in-memory div, set its inner text (which jQuery automatically encodes)
  // Then grab the encoded contents back out. The div never exists on the page.
  return $('<div/>').text(value).html();
}

function htmlDecode(value){
  return $('<div/>').html(value).text();
}


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


                        '<div class="event-description">'+ htmlDecode(description.substring(0,300))
                           +'....'+ '<a id="read_more" href="<?php echo esc_url( get_permalink( get_page_by_title( 'More Event' ) ) ); ?>?eventId='+eventObject['event-id']+'&date='+eventObject['start-date-time'].substring(0,10)+'">MORE</a> '+
                         '</div>'

                        +'<div class="event-information">'+
                          '<div class="event-location">'+
                            '<div class="event-location-img"></div>'+
                            '<h3><a class="location_link" target="_blank" href="http://maps.google.com/?q='+eventObject['location']+' ">'+eventObject['location']+'</a></h3>'+
                              '</div>'+ //event location
                              '<div class="contact-email" style="display:none;">'+
                                eventObject['contact-email'] + '</div>'+
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

function FindEvent(dateEvent,eventObject,countEvents){

	//prints date string
	var date = eventObject['start-date-time'];
	//formats date to MM-DD-YYYY
	var startampm = eventObject['start-date-time'].substring(16,19);

	var startDate = eventObject['start-date-time'].substring(0,10);
	//formats date to Monday, Tuesday, etc
	var newstartDate = new Date(eventObject['start-date-time']);

	var dayString = newstartDate.toString().substring(0,21);
	var yearString = dateEvent.substring(6,10);
	var monthNumber =  parseInt(dateEvent.substring(0,3))-1;
	var day = dayString.replace(yearString,'');

	//formats date to get just time
	 var endtime = eventObject['end-date-time'].substring(10,17);
	 var endampm = eventObject['end-date-time'].substring(16,19);

		//get day that is clicked
		var days = eventObject['start-date-time'].substring(3,5);

		if(  dateEvent.toString() === startDate ){
				//ShowEvent(eventObject, monthNumber, countEvents, day )
				countEvents++;
				ShowEvent(eventObject )

	}
	return countEvents;
}


function ShowAllEvents(){

  $('.btn-wrap ').show();
  //remove class when event all is selected.
  $('.ui-state-default').removeClass('has-events');

  $('#btn-load-more').show();
	$('.events-content-upcoming-events').empty();
	eventList = callingXMLData($('#datepicker').datepicker().val(), true, 'none');
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



function getMonthName(position){

	 var month = new Array();
	 month[0] = "Jan";
	 month[1] = "Feb";
	 month[2] = "Mar";
	 month[3] = "Apr";
	 month[4] = "May";
	 month[5] = "June";
	 month[6] = "July";
	 month[7] = "Aug";
	 month[8] = "Sept";
	 month[9] = "Oct";
	 month[10] = "Nov";
	 month[11] = "Dec";
	 return month[position];
}

//$('#btn-load-more').hide();
//load more button

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
      contact_email = eventObject.find('.contact-email').text(),
			location = eventObject.find('.event-location').text(),
			subject = eventObject.find('.event-title').text(),
			description = eventObject.find('.event-description').text(),
			start_date = icalAllBrowsers(decodeURI( eventObject.find('.event-date').data('sdical'))),//formatDateTimeIcal(new Date( decodeURI( eventObject.find('.event-date').data('sdical')) )),
			end_date = icalAllBrowsers(decodeURI( eventObject.find('.event-date').data('edical'))),//formatDateTimeIcal(new Date( decodeURI( eventObject.find('.event-date').data('edical')) )),
			fileName = subject.substring(0,10),
			todayDate = formatDateTimeIcal(new Date());

      
		var icsMSG =	createIcalBody(todayDate,start_date, end_date,  description, location, subject, contact_email);

  var icsBody = "data:text/calendar;charset=utf8," + escape(icsMSG);
  var downloadLink = document.createElement("a");
  downloadLink.href = icsBody;
  downloadLink.download = fileName +".ics";

  document.body.appendChild(downloadLink);
  downloadLink.click();
  document.body.removeChild(downloadLink);
});

function	createIcalBody(todayDate,start_date, end_date,  description, location, subject, contact_email){
	return "BEGIN:VCALENDAR\nVERSION:2.0\nPRODID:-//Our Company//NONSGML v1.0//EN\n"+
		"BEGIN:VEVENT\nUID:"+contact_email +"\n"+
		"DTSTAMP:"+todayDate+"\nATTENDEE;CN=My Self ;RSVP=TRUE:MAILTO:"+contact_email + "\n"+
		"ORGANIZER;CN="+contact_email +":MAILTO::"+contact_email +"\n"+
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

function ensureTwo (value) {
	return (value < 10 ? '0' : '') + value;
}

function dateAllBrowsers(date){
    var momento = date.split('-'),
                    month = ensureTwo(parseInt(momento[0])-1);
    return  (new Date(momento[2],month,momento[1]));
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

    // if(meridiam=="PM"){
    //     //hours = (parseInt(arrayT[0])+16).toString();
    //     hours = (parseInt(arrayT[0])+12).toString();
    // }

    return   (new Date(date[2],parseInt(date[0])-1, parseInt(date[1]),hours,minutes, 0   ));

}


$('#locationSelector').change(function(){

  var selectedAudience = $('#eventTypeSelector :selected').val();

  $('.events-content-upcoming-events').empty();
  var selectedLocation = $(this).find(':selected').val().trim();
  var countEvents= 0;
  var getFullYear = new Date().getFullYear();
  eventList = callingXMLData('01-01-'+getFullYear, true, selectedLocation)

  if(selectedAudience==0){

      if(eventList!='no-data'){

            $.each(eventList, function(i, val){
                countEvents++;
              ShowEvent(eventList[i]);

            });
            if(countEvents==0){
             $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
             $('#btn-load-more').hide();

            }
            hideEvents();
      }else{
        $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
        $('#btn-load-more').hide();
      }
  }else{

    $.each(eventList, function(i, val){
        var categoryList = eventList[i]["categories"];
        //console.log(categoryList);
        if( typeof(categoryList)  !== "undefined" && Object.keys(categoryList["category"]).length > 0){
            //console.log(categoryList);

            $.each(categoryList["category"], function(j, valor){

              if(categoryList["category"][j] == selectedAudience){

                countEvents++;
                ShowEvent(eventList[i]);
              }
            });

        }
    });

    if(countEvents==0){
     $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
     $('#btn-load-more').hide();

    }
    hideEvents();

  }
});

$('#eventTypeSelector').change(function(){

  var selectedLocation = $('#locationSelector :selected').val();
  var xmlUrl = "none";
  if(selectedLocation!=0){
    xmlUrl = selectedLocation;
  }

  $('.events-content-upcoming-events').empty();

  var selectedEvent = $(this).find(':selected').val().trim();


  var countEvents = 0;
  var getFullYear = new Date().getFullYear();
  eventList = callingXMLData('01-01-'+getFullYear, true, xmlUrl,selectedEvent);

  if(eventList != 'no-data'){


    //Object.keys(eventList).length;
    $.each(eventList, function(i, val){

        if( typeof(eventList[i]["categories"])  !== "undefined" && Object.keys(eventList[i]["categories"]).length > 0){

            var arrayCategory = eventList[i]["categories"]["category"];

            if(arrayCategory[0].length>1){
              $.each(arrayCategory, function(j, valor){
                  if(valor.trim() == selectedEvent){
                      countEvents++;
                      ShowEvent(eventList[i]);
                  }
              });
            }else{
              if(arrayCategory == selectedEvent){
                  countEvents++;
                  ShowEvent(eventList[i]);
              }
            }

        }
    });

    if(countEvents==0){
     $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
     $('#btn-load-more').hide();

    }
    hideEvents();
  }else{
    // $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
    // $('#btn-load-more').hide();
  }


  // if(eventList!='no-data'){
  //
  //   $.each(eventList, function(i, val){
  //       countEvents++;
  //     ShowEvent(eventList[i]);
  //
  //   });
  //   if(countEvents==0){
  //    $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
  //    $('#btn-load-more').hide();
  //
  //   }
  //   hideEvents();
  // }else{
  //   $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
  //   $('#btn-load-more').hide();
  // }

});


$('#groupSelector').change(function(){

    $('.events-content-upcoming-events').empty();

    var selectedGroup = $(this).find(':selected').val().trim();
    var countEvents = 0;
    var getFullYear = new Date().getFullYear();
    eventList = callingXMLData('01-01-'+getFullYear, true, selectedGroup);

    if(eventList!='no-data'){

      $.each(eventList, function(i, val){
          countEvents++;
        ShowEvent(eventList[i]);

      });
      if(countEvents==0){
       $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
       $('#btn-load-more').hide();

      }
      hideEvents();
    }else{
      $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
      $('#btn-load-more').hide();
    }

});

//set values when another is selected

// $('#groupSelector').change(function(){
//   $('#locationSelector option').eq(0).prop('selected',true);
// });
//
// $('#groupSelector').change(function(){
//   $('#eventTypeSelector option').eq(0).prop('selected',true);
// });
//
// $('#groupSelector').change(function(){
//   $('#eventTypeSelector option').eq(0).prop('selected',true);
// });
//
// $('#locationSelector').change(function(){
//   $('#groupSelector option').eq(0).prop('selected',true);
// });
//
// $('#locationSelector').change(function(){
//   $('#eventTypeSelector option').eq(0).prop('selected',true);
// });
//
// $('#eventTypeSelector').change(function(){
//   $('#locationSelector option').eq(0).prop('selected',true);
// });
//
// $('#eventTypeSelector').change(function(){
//     $('#groupSelector option').eq(0).prop('selected',true);
// });



});
})(jQuery);// end of main function


</script>




<?php get_footer(); ?>
