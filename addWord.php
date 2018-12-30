

<!DOCTYPE html>
<html>
  <head>
    <title>a form</title>
    <script   src='https://code.jquery.com/jquery-3.1.0.js'   integrity='sha256-slogkvB1K3VOkzAI8QITxV3VzpOnkeNVsKvtkYLMjfk='   crossorigin='anonymous'></script>

  </head>
  <body>


 		tomeName: <input type="text" name="tomeName" id="tomeName">
  	english: <input type="text" name="english" id="english">
  	spanish: <input type="text" name="spanish" id="spanish">
  	<button id="submit">submit</button>

    <button id="fetch">get entries</button>

    <div id="output">

    </div>

		<script>
		$("#submit").click(function() {
			$.post("backend/submitWord.php", {tomeName: $("#tomeName").val(), english: $("#english").val(), spanish: $("#spanish").val()}).done(function() {
				
        $("#output").append("<p>Added english: "+$("#english").val()+", spanish: "+$("#spanish").val());
        $("#english, #spanish").val("");
				$("#english").focus();
				console.log("success");

			});
		});

    $("#fetch").click(function() {
      var theTome = $("#tomeName").val();
      var english = new Array();
      var spanish = new Array();
        
          $.post("backend/fetch.php", { tomeName: theTome })
            .done(function(data){
            var arrays = jQuery.parseJSON(data);
            english = arrays.english;
            spanish = arrays.spanish;
              

        $("#output").html("");
        $("#output").append("<h2>"+theTome.toUpperCase()+"</h2>");

        //$("#output").append("<p>You opened the "+theTome+" tome.</p>");
        for(var i = 0; i < english.length; i++) {
          $("#output").append("<p><b>"+english[i]+"</b>: <span style='color: red;'>"+spanish[i]+"</span></p>");
        }

      });
    });
    	</script>
  </body>
</html>