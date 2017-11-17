<meta name="description" content="Project Dragon - Map Viewer">
<title>Project Dragon - Map Viewer</title>
<!-- CSS -->
<link href="/views/seniordesign/styles/styles.css" rel="stylesheet" type="text/css">

<!-- ** JAVASCRIPTS ** -->
<!-- JQuery -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Local JS files -->
<script type="text/javascript" src="/views/seniordesign/js/utils.js"></script>
<script type="text/javascript" src="/views/seniordesign/js/map/mapStyles.js"></script>
<script type="text/javascript" src="/views/seniordesign/js/map/filter.js"></script>
<script type="text/javascript" src="/views/seniordesign/js/map.js"></script>
<!-- Google Maps API Callback to my JS function -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdPg8LC3599sor7juj6q6Tbgl_RcqbaK4&callback=loadMap" async defer></script>


<!-- ** GOOGLE MAPS ** -->
<!-- Maps Filter -->
<nav id="filter-group" class="filter-group">
	<input type="checkbox" id="poi-Yellow" onclick="toggleYellow()" checked>
	<label for="poi-Yellow">Powerlines</label>
	<input type="checkbox" id="poi-Green" onclick="toggleGreen()" checked>
	<label for="poi-Green">Overgrowth</label>
	<input type="checkbox" id="poi-Red" onclick="toggleRed()" checked>
	<label for="poi-Red">Oversag</label>
</nav>
<!-- Google Maps Div -->
<div id="map" class="box left">
</div>

<!-- UTILITY IMAGE -->
<div class="box right">
	<img id="utilityImage" onclick="imageClick()" src="http://projectdragon.cf/resources/placeholder.png">
</div>

<!-- Info Box -->
<div class="info">
	<div class="info left">
		<div>
			<label for="powerline">
				<span class="text">Powerline</span>
				<input type="checkbox" name="powerline" id="powerline" value="1" onclick="enableButton()" disabled>
			</label>
		</div>
		<div>
			<label for="powerpole">
				<span class="text">Powerpole</span>
				<input type="checkbox" name="powerpole" id="powerpole" value="1" onclick="enableButton()" disabled>
			</label>
		</div>
	</div>
	<div class="info right">
		<div>
			<label for="overgrowth">
				<input type="checkbox" name="overgrowth" id="overgrowth" value="1" onclick="enableButton()" disabled>
				<span class="text">Overgrowth</span>
			</label>
		</div>
		<div>
			<label for="oversag">
				<input type="checkbox" name="oversag" id="oversag" value="1" onclick="enableButton()" disabled>
				<span class="text">Oversag</span>
			</label>
		</div>
	</div>
	<!-- Geo Coords -->
	<div class="info block">
		<label for="latitude">
			<span class="text">Latitude</span>
			<span id="latitude"></span>
		</label>
	</div>
	<div class="info block">
		<label for="longitude">
			<span class="text">Longitude</span>
			<span id="longitude"></span>
		</label>
	</div>

	<!-- Update Button -->
	<div class="info block">
		<input id="update-btn" class="btn" type="button" value="Update Record" onclick="updateMarker()" disabled>
	</div>

	<!-- Logout Button -->
	<div class="info block">
		<input id="logout-btn" class="btn" type="button" value="Logout" onclick="logout()">
	</div>
</div>

<!-- Full Screen  Image -->
<div id="myModal" class="modal">

	<!-- The Close Button -->
	<span class="close" onclick="closeClick()">&times;</span>

	<!-- Modal Content (The Image) -->
	<img class="modal-content" id="modalImage">
</div>