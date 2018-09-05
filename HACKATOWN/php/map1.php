<?php
/**
 * Created by PhpStorm.
 * User: MagicHack
 * Date: 2018-01-20
 * Time: 20:23
 */

require_once ('config.php');

require_once ('checkConnection.php');

if(!$_SESSION['isConnected']){
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/main.css">

    <title>Parking - HackaTown2K18</title>

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
	    #box {
        position:fixed;
		    top: 25%;
		    left: 35%;
	      z-index: 2;
	      background-color: white;
		    width : 400px;
		    border-radius: 25px;
      }

  	  #black {
        position:fixed;
  	    z-index: 1;
  	    background-color: black;
  		  width : 100%;
  		  height: 100%;
  		  opacity: 0.5;
        }

    </style>

  <script type="text/JavaScript">



  </script>

	<script>        
    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
      }
    }

		function showPosition(position) {
            putMarker (position.coords.latitude, position.coords.longitude);
        }
	</script>
    <script type="text/JavaScript">
        let map;
      function fadeAway() {
          if(document.getElementById('inputGroupSelect01').value == 0) {
              document.getElementById('adress').style.display = "flex";
              document.getElementById('time').style.display = "flex";
          }
          if(document.getElementById('inputGroupSelect01').value == 1) {
              document.getElementById('adress').style.display = "none";
              document.getElementById('time').style.display = "none";
              getLocation();
              document.getElementById('black').style.display = "none";
              document.getElementById('box').style.display = "none";

          }
          if(document.getElementById('inputGroupSelect01').value == 2) {
              document.getElementById('adress').style.display = "flex";
              document.getElementById('time').style.display = "none";
          }
          if(document.getElementById('inputGroupSelect01').value == 3) {
              document.getElementById('adress').style.display = "flex";
              document.getElementById('time').style.display = "flex";
          }
      }

      function coordonates() {
        console.log('test0');
        document.getElementById('black').style.display = "none";
        document.getElementById('box').style.display = "none";
        let location_voulu = document.getElementById('adress_text');
        let geocoder =  new google.maps.Geocoder();
        geocoder.geocode( { 'address': location_voulu.value}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          let lat_position = results[0].geometry.location.lat();
          let lng_position = results[0].geometry.location.lng();
          putMarker(lat_position, lng_position);
          console.log('test1');
          xhttp = new XMLHttpRequest;
          xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            let nPark = 0;
            let data = JSON.parse(this.responseText);
            console.log(data);
            console.log(data.latitude.length);
            let i = 0;
            while(i < data.latitude.length){
              console.log(nPark);
              let pLoc = {lat: parseFloat(data.latitude[i]), lng: parseFloat(data.longitude[i])};
              let marker = new google.maps.Marker({
              position: pLoc,
              map: map,
              title: toString(nPark)
            });
            marker.setMap(map);
            nPark++;
            i++;
          }
        }
        };
        xhttp.open("GET", "getParkings.php?lat="+lat_position+'&lon='+lng_position, true);
        xhttp.send();
        } else {
          alert("Something got wrong " + status);
        }
        });
      }

      function putMarker(lat_position, lng_position) {
          console.log('marker');
          var myLatLng = {lat: lat_position, lng: lng_position};

		      map = new google.maps.Map(document.getElementById('map'), {
          center: myLatLng,
          zoom: 17
          });

          let marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'current position'
          });
       }

    </script>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

  </head>
  <body >

    <nav id="nav" class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="index.php">Parking</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
              <?php
              echo '<span class="nav-link">Welcome, ' . $_SESSION['username'] . '</span>';
              ?>


          </li>
            <li>
                <a class="nav-link" href="disconnect.php">Disconnect<span class="sr-only">(current)</span></a>
            </li>
        </ul>
      </div>
    </nav>


    <center>
	  <div id="black" > </div>

<div id="box" class="container-fluid">

	<br>
	<div class="input-group mb-3">
		<div class="input-group-prepend">
		<label class="input-group-text" for="inputGroupSelect01">Options</label>
		</div>
		<select onchange="fadeAway();" class="custom-select" id="inputGroupSelect01">
		  <option value="0" selected>What are you looking for ?</option>
		  <option value="1">Parking around me !</option>
		  <option value="2">Leaving now ?</option>
		  <option value="3">Plan your parking ?</option>
		</select>
	</div>
	<br>

	<div id="adress" class="input-group mb-3">
		<input id ="adress_text" type="text"  class="form-control" placeholder="Adress" aria-label="Adress" aria-describedby="basic-addon1">
	</div>
	<br>
	<div id="time" class="input-group mb-3">
	   <input type="text" class="form-control" placeholder="Heure de départ" aria-label="Password" aria-describedby="basic-addon1">
	</div>
	<a href="#"><button onclick="coordonates();" type="button" class="btn btn-success">Go !</button></a><br><br>

</div>

</center>

    <div id="map"></div>
    <script>
      let map;
      function initMap() {
          map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 45.5088400, lng: -73.5878100},
          zoom: 11
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2R9je_hQH1cHCcW36mVUFM6zFfbHhNsI&callback=initMap"
    async defer></script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>