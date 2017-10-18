<title>Utility Inspection</title>
<meta name="viewport" content="initial-scale=1.0">
<meta charset="utf-8">
<meta name="description" content="Project Dragon - Map Viewer">
<link href="/views/pages/utility/styles.css" rel="stylesheet" type="text/css">

<div id="headerHolder">
	<h3 id="header">Project Dragon Demo</h3>
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
<div id="box">

	<img id="myImg" src="/59677536cab28_119.jpg">
	<!-- <div id='infoBox'> ... </div> -->

	<form id= 'infoBox' action="">
		<label for="male">Powerline</label>
		<input type="checkbox" name="attribute" id="powerline" value="True" checked>
		<label for="female">Powerpole</label>
		<input type="checkbox" name="attribute" id="powerpole" value="True">
		<label for="other">Overgrowth</label>
		<input type="checkbox" name="gender" id="other" value="other">
		<label for="other">Oversag</label>
		<input type="checkbox" name="gender" id="other" value="other"><br><br>
		<label for="other">Latitude: </label>
		<label for="other">26.93588</label>
		<br><br>
		<label for="other">Longitude: </label>
		<label for="other">-80.08189</label>
		<br><br>

		<input type="submit" value="Submit">
	</form>

	<p><input type="button" id="theButton" value="click me!" onclick="pictureChange()"></p>
	<p><input type="button" id="theButton" value="click me too!" onclick="pictureChange()"></p>

	<!-- Trigger the Modal -->
	<!-- <img id="myImg" src="blackDragon.png" alt="Trolltunga, Norway" width="300" height="200"> -->

	<!-- The Modal -->
	<div id="myModal" class="modal">

		<!-- The Close Button -->
		<span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>

		<!-- Modal Content (The Image) -->
		<img class="modal-content" id="img01">

		<!-- Modal Caption (Image Text) -->
		<div id="caption"></div>
	</div>

</div>


<div id="map"></div>

<script src="/views/pages/utility/westcampus.js"></script>
<script src="/views/pages/utility/yellow.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script type="text/javascript" src="/views/pages/utility/utility.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdB8aLpUldzTnezuHqo8T0_YKSa2vIS-o&callback=initMap"
        async defer></script>