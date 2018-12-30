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
    notebook Name: <input type="text" name="notebookName" id="notebookName">
    notebook Html: <input type="text" name="notebookHtml" id="notebookHtml">
  	<button id="submitWord">submit Word</button>
    <button id="submitNotebook">submit notebook</button>

    <button id="showWordList">get word list</button>
    <button id="fetchTomeWords">fetch Tome Words</button>
    <button id="showNotebooks">Show Notebooks</button>

    <div id="output">

    </div>

		<script>
		$("#submitWord").click(function() {
			$.post("backend/adminFunctions.php", {requestType: "submitWord", tomeName: $("#tomeName").val(), english: $("#english").val(), spanish: $("#spanish").val()}).done(function() {
				
        $("#output").append("<p>Added english: "+$("#english").val()+", spanish: "+$("#spanish").val());
        $("#english, #spanish").val("");
				$("#english").focus();
				console.log("successfully submitted word");

			});
		});

    $("#submitNotebook").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "addNotebook", notebookName: $("#notebookName").val(), notebookHtml: $("#notebookHtml").val()}).done(function(){
        console.log("Successfully submitted notebook");

      });
    });

    $("#showNotebooks").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "showNotebooks"}).done(function(data){
        var arrays = jQuery.parseJSON(data);
        id = arrays.id;
        notebookName = arrays.notebookName;
        notebookHtml = arrays.notebookHtml;

        $("#output").empty();
        for(var i =0; i< id.length; i++)
        {
          $("#output").append("<div class='notebookList' id='notebook:" + id[i] + "'><b>" + id[i] + "</b><b>" + notebookName[i] + "</b><b>" + notebookHtml + "</b></div>");
        }
      })
    })

    $("#showWordList").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "showWordList"}).done(function(data){
          var arrays = jQuery.parseJSON(data);
          wordId = arrays.wordId;
          spanish = arrays.spanish;
          english = arrays.english;

          //empty output div
          $("#output").empty();

          for(var i =0; i < english.length; i++)
          {
            $("#output").append("<div class='wordList' id = 'word:" + wordId[i] + "'><b>"+ wordId[i] + "</b><b>" + spanish[i] + "</b><b>" + english[i] + "</b></div>");
          }
      });
    });

    $("#fetchTomeWords").click(function(){
      $.post("backend/adminFunctions.php", {requestType: "fetchTomeWords", tomeName: $("#tomeName").val()})
            .done(function(data){
              var arrays = jQuery.parseJSON(data);
               wordId = arrays.wordId;
               spanish = arrays.spanish;
               english = arrays.english;

                $("#output").empty();

                for(var i =0; i < english.length; i++)
                {
                  $("#output").append("<div class='wordList' id = 'word:" + wordId[i] + "'><b>"+ wordId[i] + "</b><b>" + spanish[i] + "</b><b>" + english[i] + "</b></div>");
                }


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