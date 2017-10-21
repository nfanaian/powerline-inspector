<?php

/**
 * MAP VIEWER!
 */

/*
 * Initial Load (MOVE THIS TO MODEL YA'LL)
 */

?>

<input hidden id="filename" value="<?= $this->model->getFile(); ?>">

<meta name="description" content="Project Dragon - Map Viewer">

<!-- CSS -->

<?php // Checks for Mobile but I can do this with @media in CSS instead
require_once('resources/tools.php');
if (Tools::checkMobile()) { ?>

<?php }?>

<link href="/views/pages/utility/styles.css" rel="stylesheet" type="text/css">

<!-- Javascripts -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdPg8LC3599sor7juj6q6Tbgl_RcqbaK4&callback=loadMap" async defer></script>
<script type="text/javascript" src="/views/pages/utility/utility.js"></script>

<!-- Title -->
<!--<h3 id="header">Project Dragon Demo</h3>-->

<div class="row">

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
		<img id="utilityImage" src="<?= $this->model->getImage(); ?>">
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
		<div class="details">
			<div>
				<label for="latitude">
					<span class="text">Latitude</span>
					<span id="latitude"></span>
				</label>
			</div>
			<div>
				<label for="longitude">
					<span class="text">Longitude</span>
					<span id="longitude"></span>
				</label>
			</div>
		</div>
		<div class="updateRecord">
			<input id="button" class="btn" type="button" value="Update Record" onclick="updateMarker()">
		</div>
	</div>
</div>



<!-- TODO: USE THIS TO UPDATE <IMG TAG> on marker click->pictureChange( <marker name> )
		<p><input type="button" id="theButton" value="click me!" onclick="pictureChange()"></p>
		<p><input type="button" id="theButton" value="click me too!" onclick="pictureChange()"></p>


		<!--- Fullscreen image onClick()
		<div id="myModal" class="modal">
			<span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
			<img class="modal-content" id="utilityImage">
		</div>
		-->