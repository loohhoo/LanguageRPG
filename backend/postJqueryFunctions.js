$.post("saveHandler.php", { requestType: "getSaveData"}) 
		.done(function(data) {
			alert("here be the: " + data);
		});
$.post("saveHandler.php", { requestType: "uploadSaveData", saveData: saveDataVariable })
	.done(function(data){
		alert(data);
	});