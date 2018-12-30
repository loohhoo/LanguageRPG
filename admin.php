<!DOCTYPE html>
<html>
  <head>
    <title>a form</title>
    <script   src='https://code.jquery.com/jquery-3.1.0.js'   integrity='sha256-slogkvB1K3VOkzAI8QITxV3VzpOnkeNVsKvtkYLMjfk='   crossorigin='anonymous'></script>
    <style>
    input {
      line-height: 24px;
      margin-bottom: 10px;
    }

    textarea {
      width: 200px;
      height: 200px;
    }
    </style>
  </head>
  <body>

    <div style='float: left; width: 40%;'>
 		tomeName: <input type="text" name="tomeName" id="tomeName"><br />
    wordId / tomeId: <input type="text" name="wordid" id="wordid"><br />
  	english: <input type="text" name="english" id="english"><br />
  	spanish: <input type="text" name="spanish" id="spanish"><br />
  	<button id="submitWord">submit Word</button>
    <button id="editWord">edit word</button>
    <button id="deleteWord">delete word</button>
    <button id="showWordList">show all words</button>
    <br />
    <button id="fetchTomeWords">open tome</button>
    <button id="editTomeName">edit tome name</button>
    <button id="deleteTome">delete tome</button>
    <button id="showTomeList">show all tomes</button>
    <br />
    <br />
    notebook id: <input type="text" name="id" id="nb-id"><br />
    notebook Name: <input type="text" name="notebookName" id="notebookName"><br />
    notebook Html: <textarea name="notebookHtml" id="notebookHtml"></textarea><br />
    <button id="submitNotebook">submit notebook</button>
    <button id="editNotebook">edit notebook</button>
    <button id="deleteNotebook">delete notebook</button>
    <button id="showNotebooks">show notebooks</button>
    <br />
    <br />

    textbook id: <input type="text" name="tb-id" id="tb-id"><br />
    textbook Name: <input type="text" name="textbookName" id="textbookName"><br />
    textbook Author: <input type="text" name="textbookAuthor" id="textbookAuthor"><br />
    textbook Version: <input type="text" name="textbookVersion" id="textbookVersion"><br />
    tome id: <input type="text" name="tome-id" id="tome-id"><br />
    notebook id: <input type="text" name="tome-id" id="tb-nb-id"><br />
    <button id="createTextbook">create textbook</button><button id="addTomeToTextbook">add tome by id#</button><button id="addNotebookToTextbook">add notebook by id#</button><br />
    <button id="showTextbooks">show textbook</button><button id="showTextbookTomes">show textbook tomes</button><button id="showTextbookNotebooks">show textbook notebooks</button>
  </div>
    <div id="output" style='float: right; width: 40%'>

    </div>

		<script>

    $("#createTextbook").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "createTextbook", textbookName: $("#textbookName").val(), textbookAuthor: $("#textbookAuthor").val(), textbookVersion: $("#textbookVersion").val()}).done(function() {
  
        console.log("successfully submitted textbook");

      });
    });

    $("#addTomeToTextbook").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "addTomeToTextbook", tomeId: $("#tome-id").val(), textbookId: $("#tb-id").val()}).done(function() {
       
        console.log("successfully added tome to textbook");

      });
    });

    $("#addNotebookToTextbook").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "addNotebookToTextbook", notebookId: $("#tb-nb-id").val(), textbookId: $("#tb-id").val()}).done(function() {
       
        console.log("successfully added notebook to textbook");

      });
    });

    $("#showTextbooks").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "viewTextbooks" }).done(function(data){
        
        var arrays = jQuery.parseJSON(data);
        var textbooks = arrays.textbookName;
        var id = arrays.textbookId;

        $("#output").empty();
        for(var i =0; i< textbooks.length; i++)
        {
          $("#output").append("<div class='tomeList'><b>" + id[i] +": "+ textbooks[i] + "</b></div>");
        }

      });
    });

    $("#showTextbookTomes").click(function() {
      if($("#tb-id").val()) {
        $.post("backend/adminFunctions.php", {requestType: "viewTextbookTomesByTextbookId", textbookId: $("#tb-id").val()}).done(function(data){
          
          var arrays = jQuery.parseJSON(data);
          var textbooks = arrays.textbookName;
          var authors = arrays.textbookAuthor;
          var versions = arrays.textbookVersion;
          var tomes = arrays.tomeName;

          $("#output").empty();
          for(var i =0; i< tomes.length; i++)
          {
             $("#output").append("<div class='tomeList'><b>" + textbooks[i] + "</b>: "+ tomes[i] + "</div>"); }

        });    
      }

      else {
        $.post("backend/adminFunctions.php", {requestType: "viewTextbookTomes"}).done(function(data){
          
          var arrays = jQuery.parseJSON(data);
          var textbooks = arrays.textbookName;
          var authors = arrays.textbookAuthor;
          var versions = arrays.textbookVersion;
          var tomes = arrays.tomeName;

          $("#output").empty();
          for(var i =0; i< tomes.length; i++)
          {
            $("#output").append("<div class='tomeList'><b>" + textbooks[i] + "</b>: "+ tomes[i] + "</div>");
          }

        });    
      }
    });

    $("#showTextbookNotebooks").click(function() {
      if(!$("#tb-id").val()) {
        $.post("backend/adminFunctions.php", {requestType: "viewTextbookNotebooksByTextbookId", textbookId: $("#tb-id").val()}).done(function(data){
          
          var arrays = jQuery.parseJSON(data);
          var textbooks = arrays.textbookName;
          var authors = arrays.textbookAuthorArray;
          var versions = arrays.textbookVersionArray;
          var notebooks = arrays.notebookName;

          $("#output").empty();
          for(var i =0; i< notebooks.length; i++)
          {
            $("#output").append("<div class='tomeList'><b>" + textbooks[i] +": "+ notebooks[i] + "</b></div>");
          }

        });    
      }

    });

		$("#submitWord").click(function() {
			$.post("backend/adminFunctions.php", {requestType: "submitWord", tomeName: $("#tomeName").val(), english: $("#english").val(), spanish: $("#spanish").val()}).done(function() {
				
        $("#output").append("<p>Added english: "+$("#english").val()+", spanish: "+$("#spanish").val());
        $("#english, #spanish").val("");
				$("#english").focus();
				console.log("successfully submitted word");

			});
		});

    $("#showTomeList").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "viewTomes" }).done(function(data){
        
        var arrays = jQuery.parseJSON(data);
        var tomes = arrays.tomeName;
        var id = arrays.tomeId;

        $("#output").empty();
        for(var i =0; i< tomes.length; i++)
        {
          $("#output").append("<div class='tomeList'><b>" + id[i] +": "+ tomes[i] + "</b></div>");
        }

      });
    });

    $("#deleteTome").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "deleteTome", tomeId: $("#wordid").val()}).done(function(){
        console.log("Successfully deleted tome");

      });
    });

    $("#editTomeName").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "editTomeName", tomeId: $("#wordid").val(), newTomeName: $("#tomeName").val()}).done(function(){
        console.log("Successfully edited word");

      });
    });

    $("#editWord").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "modifyWord", spanish: $("#spanish").val(), english: $("#english").val(), wordId: $("#wordid").val()}).done(function(){
        console.log("Successfully edited word");

      });
    });

    $("#deleteWord").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "deleteWord", wordId: $("#wordid").val()}).done(function(){
        console.log("Successfully deleted word");

      });
    });

    $("#submitNotebook").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "addNotebook", notebookName: $("#notebookName").val(), notebookHtml: $("#notebookHtml").val()}).done(function(){
        console.log("Successfully submitted notebook");

      });
    });

    $("#editNotebook").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "editNotebookName", newTitle: $("#notebookName").val(), notebookId: $("#nb-id").val()}).done(function(){
        console.log("Successfully edited notebook name");

      });

      $.post("backend/adminFunctions.php", {requestType: "editNotebookHtml", newHtml: $("#notebookHtml").val(), notebookId: $("#nb-id").val()}).done(function(){
        console.log("Successfully edited notebook name");

      });
    });

    $("#deleteNotebook").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "deleteNotebook", notebookId: $("#nb-id").val()}).done(function() { 
        console.log("Successfully deleted notebook.");
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
          $("#output").append("<div class='notebookList'><b>" + id[i] + "</b><b>" + notebookName[i] + "</b>: " + notebookHtml[i] + "</div>");
        }
      })
    });

    $("#showWordList").click(function() {
      $.post("backend/adminFunctions.php", {requestType: "showWordList"}).done(function(data){
          var arrays = jQuery.parseJSON(data);
          wordId = arrays.wordId;
          spanish = arrays.spanish;
          english = arrays.english;
          //tomeName = arrays.tomeName;

          //empty output div
          $("#output").empty();

          for(var i =0; i < english.length; i++)
          {
            $("#output").append("<div class='wordList' id = 'word:" + wordId[i] + "'><b>"+ wordId[i] + "</b>: <b>" + spanish[i] + "</b>, <b>" + english[i] + "</b></div>");
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
                  $("#output").append("<div class='wordList' id = 'word:" + wordId[i] + "'><b>"+ wordId[i] + "</b>: <b>" + spanish[i] + "</b>, <b>" + english[i] + "</b></div>");
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