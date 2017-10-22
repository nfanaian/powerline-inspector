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
<script type="text/javascript" src="/views/pages/utility/utility.js"></script>

<!-- Title -->
<!--<h3 id="header">Project Dragon Demo</h3>-->


	<!-- Google Maps -->
<div id="map"></div>

<!-- TODO: Future feature
<div id="headerHolder">
	<nav id="filter-group" class="filter-group">
		<input type="checkbox" id="poi-Green">
		<label for="poi-Green">Green</label>
		<input type="checkbox" id="poi-Yellow">
		<label for="poi-Yellow">Yellow</label>
		<input type="checkbox" id="poi-Red">
		<label for="poi-Red">red</label>
		<input type="checkbox" id="poi-dontKnow">
		<label for="poi-dontKnow">Dont know yet</label>
	</nav>
</div>
-->

<!-- Update Marker -->
<div id="box">
	<!--
		TODO: add a PHP echo to 'src=', upon initial load PHP can take care of first image
		TODO: AJAX can take care of image updates,

	 -->
	<img id="utilityImage" src="http://via.placeholder.com/600x500?text=Click+a+Marker">
</div>

<!-- AJAX action="api/marker/updatemarker/" -->
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
	<div class="block">
		<input id="button" class="btn" type="button" value="Update Record" onclick="updateMarker()">
	</div>
</div>


<!-- TODO: Modal
		<!--- Fullscreen image onClick()
		<div id="myModal" class="modal">
			<span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
			<img class="modal-content" id="utilityImage">
		</div>
		-->