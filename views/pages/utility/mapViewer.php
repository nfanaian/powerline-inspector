<?php

/**
 * MAP VIEWER!
 */

/* For later maybe?
 * Checks for Mobile but I can do this with @media in CSS instead
require_once('resources/tools.php');
if (Tools::checkMobile()) { } */

?>

<meta name="description" content="Project Dragon - Map Viewer">

<!-- CSS -->
<link href="/views/pages/utility/styles.css" rel="stylesheet" type="text/css">

<!-- Javascripts -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdPg8LC3599sor7juj6q6Tbgl_RcqbaK4&callback=loadMap" async defer></script>
<script type="text/javascript" src="/views/pages/utility/methods/utils.js"></script>
<script type="text/javascript" src="/views/pages/utility/methods/map.js"></script>

<!-- Google Maps -->
<div id="map">
</div>

<!-- UTILITY IMAGE -->
<div id="box">
	<img id="utilityImage" onclick="imageClick()" src="http://via.placeholder.com/600x500?text=Click+a+Marker">
</div>

<!-- Info Box -->
<div id="info">
	<div class="left">
		<div>
			<label for="powerline">
				<span class="text">Powerline</span>
				<input type="checkbox" name="powerline" id="powerline" value="1" onclick="enableButton()">
			</label>
		</div>
		<div>
			<label for="powerpole">
				<span class="text">Powerpole</span>
				<input type="checkbox" name="powerpole" id="powerpole" value="1" onclick="enableButton()">
			</label>
		</div>
	</div>
	<div class="right">
		<div>
			<label for="overgrowth">
				<input type="checkbox" name="overgrowth" id="overgrowth" value="1" onclick="enableButton()">
				<span class="text">Overgrowth</span>
			</label>
		</div>
		<div>
			<label for="oversag">
				<input type="checkbox" name="oversag" id="oversag" value="1" onclick="enableButton()">
				<span class="text">Oversag</span>
			</label>
		</div>
	</div>
	<!-- Geo Coords -->
	<div class="block">
		<label for="latitude">
			<span class="text">Latitude</span>
			<span id="latitude"></span>
		</label>
	</div>
	<div class="block">
		<label for="longitude">
			<span class="text">Longitude</span>
			<span id="longitude"></span>
		</label>
	</div>

	<!-- Update Button -->
	<div class="block">
		<input id="update-btn" class="btn" type="button" value="Update Record" onclick="updateMarker()">
	</div>

	<!-- Logout Button -->
	<div class="block logout">
		<input id="logout-btn" class="btn logout" type="button" value="Logout" onclick="logout()">
	</div>
</div>

<!-- Full Screen  Image -->
<div id="myModal" class="modal">

	<!-- The Close Button -->
	<span class="close" onclick="closeClick()">&times;</span>

	<!-- Modal Content (The Image) -->
	<img class="modal-content" id="modalImage">
</div>