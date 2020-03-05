<?php
/*
Template Name: Match Day Map
*/
?>

<!DOCTYPE html>
<html>
  <head>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
       html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>

  <body>

    <div id="map"></div>
    <script>


      var map;
      var markers = [];
      var geocoder;

      function initMap() {
        geocoder = new google.maps.Geocoder();

          map = new google.maps.Map(document.getElementById('map'), {
          zoom: 5,
          center: new google.maps.LatLng(38.5607867, -96.2006291),
          //mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var infoWindow = new google.maps.InfoWindow(); // only one info window open at a time

        // Change this depending on the name of your PHP or XML file
        downloadUrl('<?= site_url('markers xml')?>', function(data) {
            var xml = data.responseXML;
            // console.log(xml);

            var markers = xml.documentElement.getElementsByTagName('marker');
            // console.log(markers);
             Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('contactname');
              var address = markerElem.getAttribute('address');
              var program_name = markerElem.getAttribute('program_name');
              var specialty = markerElem.getAttribute('specialty');
              var transitionyear = markerElem.getAttribute('transitionyear');
            //
            //   var  address = "https://maps.googleapis.com/maps/api/geocode/json?address="+address;
            //   console.log(address);
            //   // test = 'http://maps.google.com/maps/api/geocode/xml?address='+address;
            //   // console.log(test);
              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));
            //
              var text = document.createElement('text');
              text.textContent = address
              infowincontent.appendChild(text);
              var icon = specialty || {};
            //
            //   var marker = new google.maps.Marker({
            //     map: map,
            //     position: address,
            //     label: icon.label
            //   });
            //   marker.addListener(marker, 'click', function() {
            //     infoWindow.setContent(infowincontent);
            //     infoWindow.open(map, marker);
            //   });
            var contentString = "Name: " + name + "<br /> " + "Specialty: " + specialty;

            var infowindow = new google.maps.InfoWindow({
               content: contentString
             });

            geocoder.geocode({'address': address}, function(results,status){
                if(status === 'OK'){
                  var marker = new google.maps.Marker({
                    map: map,
                    animation: google.maps.Animation.DROP,
                    position: results[0].geometry.location
                  });
                  marker.addListener('click', function() {
                    infowindow.open(map, marker);
                  });
                }
              });
             });







          });
        }





      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADNZPvb-tVltz1kN_zHYDK7L6xyIDbgAc&callback=initMap">
    </script>

  </body>
</html>
