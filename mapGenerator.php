<!DOCTYPE html>
<html>
  	<head>
	    <title>a form</title>
	    <script   src='https://code.jquery.com/jquery-3.1.0.js'   integrity='sha256-slogkvB1K3VOkzAI8QITxV3VzpOnkeNVsKvtkYLMjfk='   crossorigin='anonymous'></script>
	    <style>
	    #map-generator {
	    	display: none;
	    }
	    </style>
	    <script>
	    $(document).ready(function() {
	    	$("#new").click(function() {
	    		$("#map-generator").css("display", "block");
	    	});

	    });
	    </script>
	</head>
	<body>
		<h2>Start New Map</h2>
		Map name: <input type="text" id="map_name"><br />
		Size X: <input type="text" id="map_x"> Size Y: <input type="text" id="map_y"><br />
		<button id="new">start new</button>
		<div id="map-generator">
		<h2>Add Map Exit</h2>

		Exit X: <input type="text" id="exit_x"> Exit Y: <input type="text" id="exit_y"><br />Exit
		 name: <input type="text" id="exit_name"><br />

		<button id="add_exit">add exit</button>
		<h2>Add Map Entrance</h2>

		Entrance X: <input type="text" id="entrance_x"> Entrance Y: <input type="text" id="entrance_y"><br />From: <input type='text' id="map_from"><br />

		<button id="add_entrance">add entrance</button>

		<h2>Add Event</h2>
		Event X: <input type="text" id="event_x"> Event Y: <input type="text" id="event_y"><br />

		<button id="add_event">add event</button>

	</div>
	</body>
</html>