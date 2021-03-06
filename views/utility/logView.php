<link href="/views/utility/styles/tableStyle.css" rel="stylesheet" type="text/css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script src="/views/utility/methods/login.js"></script>
<script src="/views/utility/methods/table.js"></script>
<img class="source-image" src="/views/utility/images/PowerLinesBackgroundColor.jpg" alt=""/>

<div id="page">
	<div class="table-responsive-vertical shadow-z-1">
		<div id= 'infoBox'>
			<input class='css-checkbox' type="checkbox" name="powerline" id="powerlineFilter" value="False" >
			<label for='powerlineFilter' class='css-label' style="margin-top: 8px;">Powerline?</label>
			<br>
			<input class='css-checkbox' type="checkbox" name="powerpole" id="powerpoleFilter" value="False">
			<label for='powerpoleFilter' class='css-label'>Powerpole?</label>
			<br>
			<input class='css-checkbox' type="checkbox" name="overgrowth" id="overgrowthFilter" value="False">
			<label for='overgrowthFilter' class='css-label'>Overgrowth?</label>
			<br>
			<input class='css-checkbox' type="checkbox" name="oversag" id="oversagFilter" value="False">
			<label for='oversagFilter' class='css-label'>Oversag?</label>

			<br>
			<input class='css-checkbox' type="checkbox" name="hasDate" id="hasDateFilter" value="False">
			<label for='hasDateFilter' class='css-label' id="dateLabel" >Date:</label>
			<textarea class="commentArea" id="dateText" rows="1" columns="1" placeholder="yyyy-mm-dd"></textarea>
			<br>
			<button class="button" id="button" type="button" onclick="filterMarkers()" style="margin-top:8px;">Filter Selection</button>
			<br>
		</div><!--End of infoBox -->

		<div id="pageControls">
			<button class="button" id="prevButton" type="button" onclick="prevPage()">Prev Page</button>
			<label class='' id="numberLabel" >Number of Markers Found:<label  class='' id="numberFound"></label></label>

			<button class="button" id="nextButton" type="button" onclick="nextPage()">Next Page</button>
		</div>


		<table id="table" class="table table-bordered table-hover table-striped table-condensed table-mc-light-blue">

		</table>

		<div id="pageControls">
			<button class="button" id="prevButton" type="button" onclick="prevPage()">Prev Page</button>
			<button class="button" id="nextButton" type="button" onclick="nextPage()">Next Page</button>
		</div>
	</div>
</div>
<!-- The Modal -->
<div id="myModal" class="modal">

	<!-- The Close Button -->
	<span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>

	<!-- Modal Content (The Image) -->
	<img class="modal-content" id="img01">

	<!-- Modal Caption (Image Text) -->
	<div id="caption"></div>
</div><!--End of Modal -->