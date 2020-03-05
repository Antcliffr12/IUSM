<?php 
/*  Template Name: Events New */
get_header();
get_template_part('partials/header-content');
include 'utilities.php';
$utilities = new Utilities();
global $post;
?>
<?php echo render_component('featured-event'); ?>

<?php echo render_component('event-menu'); ?>

<div class="events-page-content">
<div class="container">
  <div class="events-content">
    <div class="events-content-sidebar col-md-3 col-sm-0 no-padding">

  			<div id="datepicker" class="calendar col-md-12 no-padding"></div>

      <div class="subscribe-to-blog">
        <h2 class="search-events-title">Search Events</h2>
      <div class="box">

        <div class="item">
            <h2>Location</h2>
            <div class="search-events-options">
                <div id="location_dropdown">
                  <select>
                      <option value="0">Select</option>
                      <option value="12">Bloomington</option>
                      <option value="39">Evansville</option>
                      <option value="33">Fort Wayne</option>
                      <option value="17">Northwest Gary</option>
                      <option value="13">Indianapolis</option>
                      <option value="40">Muncie</option>
                      <option value="18">South Bend</option>
                      <option value="41">Terre Haute</option>
                      <option value="42">West Lafayette</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="item">
            <h2>Audience</h2>
            <div class="search-events-options">
                <div id="audience_dropdown">
                  <select>
                      <option value="0">Select</option>
                      <option value="Alumni">Alumni</option>
                      <option value="Donors">Donors</option>
                      <option value="Faculty">Faculty</option>
                      <option value="Families">Families</option>
                      <option value="Residents and fellows">Residents and fellows</option>
                      <option value="Staff">Staff</option>
                      <option value="Students">Students</option>
                      <option value="The public">The public</option>
                    </select>
                </div>
            </div>
        </div>
      

        <div class="item ">
            <h2>Department</h2>
            <div class="search-events-options">
                <div id="department_dropdown">
                  <select>
                    <option value="0">Select</option>
                    <option value="55">Anatomy and Cell Biology</option>
                    <option value="56">Anesthesia</option>
                    <option value="57">Biochemistry and Molecular Biology</option>
                    <option value="58">Biostatistics</option>
                    <option value="59">Cellular and Integrative Physiology</option>
                    <option value="61">Dermatology</option>
                    <option value="62">Emergency Medicine</option>
                    <option value="72">Family Medicine</option>
                    <option value="299">Internal Medicine</option>
                    <option value="73">Medical and Molecular Genetics</option>
                    <option value="74">Microbiology and Immunology</option>
                    <option value="75">Neurological Surgery</option>
                    <option value="76">Neurology</option>
                    <option value="77">Obstetrics and Gynecology</option>
                    <option value="79">Ophthalmology</option>
                    <option value="80">Orthopaedic Surgery</option>
                    <option value="81">Otolaryngology</option>
                    <option value="82">Pathology and Laboratory Medicine</option>
                    <option value="42">Pediatrics</option>
                    <option value="83">Pharmacology and Toxicology</option>
                    <option value="84">Physical Medicine and Rehabilitation</option>
                    <option value="85">Psychiatry</option>
                    <option value="300">Radiation Oncology</option>
                    <option value="86">Radiology and Imagain Sciences</option>
                    <option value="41">Surgery</option>
                    <option value="87">Urology</option>
                  </select>
                </div>
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

      function keySearch(){
        console.log('test');
      }

      var numberperload = 5;
      var lastload = 0;
      var eventList = null;

        $( "#datepicker" ).datepicker({
            dayNamesMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            dateFormat: 'yy-mm-dd',
            showAnim: 'fold',
            firstDay: 7,
            onSelect: function(date, inst){
              $('.ui-state-default').removeClass('has-events');
              $('.btn-wrap').show();
              $('#btn-load-more').show();
              $('.events-content-upcoming-events').empty();
              
                var selectedDay = date.substring(8,10);
                var dateObject = $('.ui-state-default');

                $.each(dateObject, function (idx, value){

                    if(parseInt( $(dateObject[idx]).text())== selectedDay){
                        $(dateObject[idx]).addClass('has-events');
                        return false;
                    }

                });

                eventList = callingJSONData($('#datepicker').datepicker().val());

                var countEvents= 0;

              
               
                $.each(eventList, function(i, val){
                    var startDate = eventList[i]['date_utc'].substring(0,10);
                    //console.log(startDate + "----------" + date);
                    if(startDate === date){
                         countEvents++;
                        showEvent(eventList[i]);
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

        showAllEvents();

        function showAllEvents(){

          $('.btn-wrap').show();
          $('.ui-state-default').removeClass('has-events');
          $('#btn-load-more').show();
          $('.events-content-upcoming-events').empty();
          eventList = callingJSONData($('#datepicker').datepicker().val());
          var countEvents = 0;
          $.each(eventList, function(i, val){
            showEvent(eventList[i]);
            countEvents++;
          });
          
          if(countEvents==0){
            $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
            $('#btn-load-more').hide();
          }
          hideEvents();
          hideButton();

        }

        featuredEvents();

        function featuredEvents(){
          //image 
          var templateUrl = '<?= get_bloginfo("template_url"); ?>';
          var image = '<img src=' + templateUrl + '/assets/images/event-placeholder.png />'; 
          var featuredImage = '<div class="featured-image">'+ image + '</div>';
          $('.featured-image').append(featuredImage);
          //content 
          var title = eventList[0]['title'];

          var monthName = eventList[0]['date'].substring(0,3);
          var day = eventList[0]['date_utc'].substring(8,10);
          var getYear = new Date(eventList[0]['date_utc']);

          var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
          var dayOfWeek = new Date(eventList[0]['date_utc'].substring(0,10));
          var eventTime = eventList[0]['date_time'];

          var description = eventList[0]['description'];

          if(description == null){
            description = '';
          }

          var featuredDiv = '<div class="featured-event-title flex-vertical-spacing"><h2>'+ title +'</h2></div>'+
          '<div class="featured-event-date flex-vertical-spacing" data-startical=\''+ eventList[0]['date_utc'] + '\' data-endical=\''+eventList[0]['date2_utc'] + '\'>'+ weekday[dayOfWeek.getDay() + 1] + ' ' + monthName + ' ' + day + ' ' + getYear.getFullYear() + ' ' + eventTime + '</div>'+
          '<div class="featured-event-info-paragraph flex-vertical-spacing">'+
            description
          +'</div>'+

          '<div class="location-wrapper">'+
          '<div class="featured-event-location-img"></div>'+
          '<h3><a target="_blank" class="location_link" href="http://maps.google.com/?q='+eventList[0]['location']+' ">'+eventList[0]['location']+'</a></h3>'+
          '</div>';
          $('.featured-event-info-options').append(featuredDiv);

        }


        function showEvent(eventObject){
            var title = eventObject['title'];
            var description = eventObject['description'];
            var timeFrame = eventObject['date_time'];
            var monthName = eventObject['date'].substring(0,3);
            var day = eventObject['date_utc'].substring(8,10);
            var getYear = new Date(eventObject['date_utc']);
            var roomNumber = eventObject['custom_room_number'];
            var dayOfWeek = new Date(eventObject['date_utc'].substring(0,10));
            var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

            
            function getDayOfWeek() {
             

              var yest = eventObject['date'];
              var Years = new Date(eventObject['date_utc']);
              var d = new Date(Years);

              var n = d.getDay()
              return n;
            }
       

            var eventTime = eventObject['date_time'];
            //change format
            function htmlDecode(value){
             return $('<div/>').html(value).text();
            }


            var eventDiv = '<div class="upcoming-event">'+
                                '<div class="upcoming-event-padding">'+
                                     '<div class="date-block-area col-md-1 no-padding">'+
                                        '<div class="date-block">'+
                                        '<div class="date-block-content">'+
                                            '<div class="date-block-month">'+monthName+'</div>'+
                                            '<div class="date-block-day">'+day+'</div>'+
                                        '</div>'+
                                     '</div><!-- dateblock -->'+
                                '</div><!-- block area -->'+
                                '<div class="upcoming-event-info col-sm-10 col-md-11 no-padding">'+
                                    '<div class="event-date" data-startical=\''+ eventObject['date_utc'] + '\' data-endical=\''+eventObject['date2_utc'] + '\'>'+ weekday[getDayOfWeek()] + ' ' + monthName + ' ' + day + ' ' + getYear.getFullYear() + ' ' + eventTime + '</div>'+
                                    '<div class="event-title"><h2><a target="_blank" href="<?php echo esc_url( get_permalink( get_page_by_title( 'More Event' ) ) ); ?>?eventId='+eventObject['id']+'">'+title+'</a></h2></div>'+

                                        '<div class="event-description">'+ htmlDecode(description)+
                                        '</div>'+

                                    '<div class="event-information">'+
                                         '<div class="event-location">'+
                                            '<div class="event-location-img"></div>'+
                                            '<h3><a class="location_link" target="_blank" href="http://maps.google.com/?q='+eventObject['location']+ ' ' + eventObject['custom_room_number']+'">'+eventObject['location']+ ' ' + ((eventObject['custom_room_number']) ? eventObject['custom_room_number'] : ' ')+'</a></h3>'+
                                         '</div> <!-- event location-->'+
                                            '<div class="contact-email" style="display:none;">'+
                                                eventObject['contact_info'] + '</div>'+
                                                '<div class="event-button">'+
                                                '<a href="#" id="btnIcal" data-id='+ eventObject['id'] +'>'+
                                                    '<h5>Add to Calendar</h5>'+
                                                '</a>'+
                                            '</div>'+//event button
                                      '</div>'
                                +'</div><!-- upcoming-event -->'+

                               '</div>'+
                            '</div><!-- end div -->';
                                 
                                 $('.events-content-upcoming-events').append(eventDiv);

            
        }//showEevent

        //add to calendar button
        $(document).on('click', '#btnIcal', function () {
          var id = $(this).data('id');
         var $this = $(this);
         var eventObject = $this.parent().parent().parent().parent(),         
          contact_email = eventObject.find('.contact-email').text(),
          location = eventObject.find('.event-location').text(),
          title = eventObject.find('.event-title').text(),
          description = eventObject.find('.event-description').text(),
          dateStart = decodeURI(eventObject.find('.event-date').data('startical')),
          dateEnd = eventObject.find('.event-date').data('endical'),         
          fileName = title.substring(0,10),
          todayDate = formatDateTimeIcal(new Date());
          var startDate = dateStart.substring(0,10).split('-').join('');
          var startTime = dateStart.substring(11, 16);
          var endDate = dateEnd.substring(0,10).split('-').join('');
          var endTime = dateEnd.substring(11, 16);

          var arrayStartT = startTime.split(':');
          var Starthours = (ensureTwo(parseInt(arrayStartT[0]))).toString();
          var Startminutes = arrayStartT[1];

          var arrayEndT = endTime.split(':');
          var Endhours = (ensureTwo(parseInt(arrayEndT[0]))).toString();
          var Endminutes = arrayEndT[1];
          
          var startDate = startDate + 'T' + Starthours + Startminutes + '00Z';
          var endDate = endDate + 'T' + Endhours + Endminutes + '00Z';
          console.log(endDate);
          

          var icsMSG =	createIcalBody(id,todayDate,startDate, endDate, description, location, title, contact_email);
          console.log(icsMSG);
          var icsBody = "data:text/calendar;charset=utf8," + escape(icsMSG);
          var downloadLink = document.createElement("a");
          downloadLink.href = icsBody;
          downloadLink.download = "IUSMEVENT.ics";
          document.body.appendChild(downloadLink);
          downloadLink.click();
          document.body.removeChild(downloadLink);

        });

        function	createIcalBody(id,todayDate,startDate, endDate, description, location, title, contact_email){
          return "BEGIN:VCALENDAR\nVERSION:2.0\nPRODID:-//Our Company//NONSGML v1.0//EN\n"+
          "BEGIN:VEVENT\nUID:"+id +"\n"+
          "DTSTAMP:"+todayDate+"\nATTENDEE;CN=My Self ;RSVP=TRUE:MAILTO:"+contact_email + "\n"+
          "ORGANIZER;CN="+contact_email +":MAILTO::"+contact_email +"\n"+
          "DTSTART:" + startDate +"\n"+
          "DTEND:" + endDate +"\n"+
          "DESCRIPTION:" + description +"\n"+
          "LOCATION:" + location + "\n"+
          "SUMMARY:" + title + "\n"+
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

   

    function callingJSONData(){
          var jsonData = null;
          $.ajax({
              type: 'GET',
              url: "<?php echo bloginfo('template_url')?>/page-templates/calendarProxy.php",
              data: { id: "id"},
              dataType : 'json',
              async: false,
              success : function(data){
                  jsonData = data;
              }               
          });       
          return (jsonData) ? jsonData : [];  
      }//callingJSONData

      //Today Button
      $(".menu-item-18250").click(function(){ 
        $('.btn-wrap ').show();
        todayEvents();
        hideButton();
      });

      //Week Button 
      $(".menu-item-18251").click(function(){ //events-this-week
        $('.btn-wrap ').show();
        weekEvents();
        hideButton();
      });

      //All Events button
      $(".menu-item-18253").click(function(){ //.events-all
        showAllEvents();
      });


      //Today Function
      function todayEvents(){

          //remove class when on another event
        $('.ui-state-default').removeClass('has-events');
        //add class when clicked on Today
        $('.events-content-upcoming-events').empty();   

        var countEvents = 0;
        $.each(eventList, function(i, val){
          $('#datepicker').datepicker().datepicker('setDate',new Date());
          var todayDate = $('#datepicker').datepicker().val();
          $('.ui-state-active').addClass('has-events');
          var startDate = eventList[i]['date_utc'].substring(0,10);
          
          if(todayDate == startDate){
              countEvents++;
              showEvent(eventList[i]);
          }          
        });
        if(countEvents==0){
            $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
            $('#btn-load-more').hide();
          }
          hideEvents();


      }

      //Week Function
      function weekEvents(date){
        $('.ui-state-default').removeClass('has-events');

        //remove class when on another event
        $('.ui-state-active').removeClass('has-events');

        var currentTR = $('.ui-state-active').closest('tr');
        currentTR.find('.ui-state-default').not(":eq(0)").addClass('has-events'); 
        var nextTR = currentTR.next();
        nextTR.find('.ui-state-default').first().addClass('has-events');
        $('.events-content-upcoming-events').empty();
       
       var currentDate = new Date();
       var countEvents = 0;
       var weekstart = currentDate.getDate() - currentDate.getDay() +1;
       var currentMonth = currentDate.getMonth() + 1;
       if(currentMonth < 10){
         currentMonth = '0' + currentMonth;
       }
       var weekend = weekstart + 6;
       $('#btn-load-more').show();

       var StringCurrentDate = currentDate.getFullYear() + '-' + currentMonth + '-' + currentDate.getDate();

        eventList = callingJSONData(StringCurrentDate);

        for(var i = weekstart; i < weekstart + 7; i++){
          var dayOfWeek = currentDate.getFullYear() + '-' + currentMonth + '-' + i;
          var eventDayW = dayOfWeek;
          console.log(eventDayW);
          $.each(eventList, function(i, val){
            var startDate = eventList[i]['date_utc'].substring(0,10);

            if(eventDayW == startDate){
              countEvents++;
               showEvent(eventList[i]);
            }       

          });

        }//end for 

        if(countEvents==0){
          $('.events-content-upcoming-events').append("<h2>Sorry, No Events this week </h2>");
          $('#btn-load-more').hide();
        }
        hideEvents();
      } 


      //Event Live Search
      $('#eventSearch').keyup(function(){
        var input = $('#eventSearch').val().trim();
        var expression = new RegExp(input, "i");     
        $('.ui-state-default').removeClass('has-events');  
         $('.events-content-upcoming-events').empty();    
         var countEvents = 0;     
          $.each(eventList, function(i, val){
            $.each(val.tags, function(j, v){
             
              if(val.description && val.title && val.date && v !== null){
                if(val.title.search(expression) != -1 ||  v.search(expression) != -1 || val.date.search(expression) != -1 || val.description.search(expression) != -1  ){
                  showEvent(eventList[i]);
                  countEvents++;
                }
              }
            });
          });

          if(countEvents==0){
            $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
            $('#btn-load-more').hide();
          }
          hideEvents();
          hideButton();

          if(input == ''){
            showAllEvents();
          }      

      });
      //Location Dropdown
      $('#location_dropdown').change(function(){
          var selectedLocation = $(this).find('option:selected');
          var locationValue = selectedLocation.val().trim();
          var urlLocation = 'https://events.iu.edu/live/json/events/category_id/'+locationValue+'/group_id/9/tag_id/';
          $('.ui-state-default').removeClass('has-events');  
          $('.events-content-upcoming-events').empty();     
         $.getJSON(urlLocation, function(data){
          var countEvents = 0;
          $.each(data, function(i, val){
            showEvent(data[i]);
            countEvents++;
          });

          if(countEvents==0){
            $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
            $('#btn-load-more').hide();
          }
           hideEvents();
           hideButton();          
         });

         if(locationValue == 0){
           showAllEvents();
         }
      });

      //audience_dropdown
      $('#audience_dropdown').change(function(){
          var selectedAudience = $(this).find('option:selected');
          var audienceValue = selectedAudience.val().trim();
          $('.ui-state-default').removeClass('has-events');  
          $('.events-content-upcoming-events').empty();     
          var countEvents = 0;
          $.each(eventList, function(i, val){
            var search_categories = eventList[i]['search_categories'];
            if(search_categories !== null){
              //search_categories.split('|');
              $.each(search_categories.split('|'), function(j, value){
                  if(value.trim() == audienceValue){
                      countEvents++;
                      showEvent(eventList[i]);
                  }
              });


            }           
          });

          if(countEvents==0){
            $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
            $('#btn-load-more').hide();
          }
           hideEvents();
           hideButton(); 

         if(audienceValue == 0){
           showAllEvents();
         }
          
      });
      

    //Department Dropdown
      $('#department_dropdown').change(function(){
          var selectedDepartment = $(this).find('option:selected');
          var departmentValue = selectedDepartment.val().trim();
          var urlDepartment = 'https://events.iu.edu/live/json/events/group_id/9/tag_id/'+departmentValue+'';
          $('.ui-state-default').removeClass('has-events');  
          $('.events-content-upcoming-events').empty();     
         $.getJSON(urlDepartment, function(data){
          var countEvents = 0;
          $.each(data, function(i, val){
            showEvent(data[i]);
            countEvents++;
          });

          if(countEvents==0){
            $('.events-content-upcoming-events').append("<h2>Sorry, No Events</h2>");
            $('#btn-load-more').hide();
          }
           hideEvents();
           hideButton();          
         });

         if(departmentValue == 0){
           showAllEvents();
         }
      });
     
    });
})(jQuery);// end of main function
</script>
<?php 





wp_footer();