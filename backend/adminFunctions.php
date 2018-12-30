<?php
require "sessionInfo.php";
require "databaseConnector.php";

if(isset($_POST['requestType']))
{
	$requestType = $_POST['requestType'];

	switch($requestType)
	{
		case "submitWord":
			if(isset($_POST['tomeName']) && isset($_POST['english']) && isset($_POST['spanish']))
			{
				$tome = $_POST['tomeName'];
			    $englishWord = $_POST['english'];
  				$spanishWord = $_POST['spanish'];
  				$successFail = addWord($db, $englishWord, $spanishWord, $tome);
				echo $successFail;
			}
			else
			{
  				echo "you have to like upload data scrublord...";
			}
		break;

		case "showWordList":
			$wordListArray = fetchWordList($db);
			echo json_encode($wordListArray);
		break;

		case "deleteWord":
			if(isset($_POST['wordId']))
			{
				$wordId = $_POST['wordId'];
				$successFail = deleteWord($db, $wordId);
			}
			else
			{
				echo "no wordID specified you scrublord...";
			}
		break;

		case "fetchTomeWords":
			if(isset($_POST['tomeName']))
			{
				$tomeName = $_POST['tomeName'];
				$tomeWordsArray = fetchTomeWords($db, $tomeName);
				echo json_encode($tomeWordsArray);
			}
			else
			{
				echo "no tome selected";
			}
		break;

		case "modifyWord":
			if(isset($_POST['wordId']) && isset($_POST['spanish']) && isset($_POST['english']))
			{
				$wordId = $_POST['wordId'];
				$spanish = $_POST['spanish'];
				$english = $_POST['english'];
				$successFail = modifyWord($db, $wordId, $spanish, $english);
				echo $successFail;
			}
			else
			{
				echo "no wordId or NewWord specified";
			}
		break;

		case "addNotebook":
			if(isset($_POST['notebookName']) && isset($_POST['notebookHtml']))
			{
				$notebookName = $_POST['notebookName'];
				$notebookHtml = $_POST['notebookHtml'];
				$successFail = addNotebook($db, $notebookName, $notebookHtml);
				echo $successFail;
			}
			else
			{
				echo "no notebook name or notebookHtml";
			}
		break;

		case "showNotebooks":
			$notebookArray = showNotebook($db);
			echo json_encode($notebookArray);
		break;

		case "deleteNotebook":
			if(isset($_POST['notebookId']))
			{
				$notebookId = $_POST['notebookId'];
				$successFail = deleteNotebook($db, $notebookId);
				echo $successFail;
			}
			else
			{
				echo "no notebook Id ya derp";
			}
		break;

		case "editNotebookName":
			if(isset($_POST['notebookId']) && isset($_POST['newTitle']))
			{
				$notebookId = $_POST['notebookId'];
				$newTitle = $_POST['newTitle'];
				$successFail = editNotebookName($db, $notebookId, $newTitle);
				echo $successFail;
			}
			else
			{
				echo "no notebook id or newTitle given";
			}
		break;

		case "editNotebookHtml":
			if(isset($_POST['notebookId']) && isset($_POST['newHtml']))
			{
				$notebookId = $_POST['notebookId'];
				$newHtml = $_POST['newHtml'];
				$successFail = editNotebookHtml($db, $notebookId, $newHtml);
				echo $successFail;
			}
			else
			{
				echo "no notebook id or new html";
			}
		case "viewTomes":
			$tomesArray = viewTomes($db);
			echo json_encode($tomesArray);
		break;

		case "editTomeName":
			if(isset($_POST['tomeId']) && isset($_POST['newTomeName']))
			{

				$tomeId = $_POST['tomeId'];
				$newTomeName = $_POST['newTomeName'];
				$successFail = editTomeName($db, $tomeId, $newTomeName);
				echo $successFail;
			}
			else
			{
				echo "no tomeid or tomename";
			}
		break;
		case "deleteTome":
			if(isset($_POST['tomeId']))
			{
				$tomeId = $_POST['tomeId'];
				$successFail = deleteTome($db, $tomeId);
				echo $successFail;
			}
			else
			{
				echo "you deleted everything and nothing survived; many will look back upon this day with a historic feeling of regret, jk; you need to set the tomeid scrublord";
			}
		break;

		case "createTextbook":
			if(isset($_POST['textbookName']) && isset($_POST['textbookAuthor']) && isset($_POST['textbookVersion']))
			{
				$textbookName = $_POST['textbookName']; 
				$textbookAuthor = $_POST['textbookAuthor'];
				$textbookVersion = $_POST['textbookVersion'];
				$successFail = createTextbook($db, $textbookName, $textbookAuthor, $textbookVersion);
				echo $successFail;
			}
		case "viewTextbooks":
			$textbookArray = viewTextbooks($db);
			echo json_encode($textbookArray);
		break;

		case "editTextbookInfo";
		if(isset($_POST['textbookId']) && isset($_POST['textbookName']) && isset($_POST['textbookAuthor']) && isset($_POST['textbookVersion']))
		{
			$textbookId = $_POST['textbookId'];
			$textbookName = $_POST['textbookName'];
			$textbookAuthor = $_POST['textbookAuthor'];
			$textbookVersion = $_POST['textbookVersion'];
			$successFail = editTextbookInfo($db, $textbookId, $textbookName, $textbookAuthor, $textbookVersion);
			echo $successFail;
		}
		else
		{
			echo "not enough data provided";
		}
		break;

		case "addTomeToTextbook":
			if(isset($_POST['tomeId']) && isset($_POST['textbookId']))
			{
				$tomeId = $_POST['tomeId'];
				$textbookId = $_POST['textbookId'];
				$successFail = addTomeToTextbook($db, $tomeId, $textbookId);
				echo $successFail;
			}
			else
			{
				echo "no tome id or textbook id selected";
			}
		break;

		case "addNotebookToTextbook":
			if(isset($_POST['notebookId']) && isset($_POST['textbookId']))
			{
				$notebookId = $_POST['notebookId'];
				$textbookId = $_POST['textbookId'];
				$successFail = addNotebookToTextbook($db, $notebookId, $textbookId);
				echo $successFail;
			}
			else
			{
				echo "no notebook id or textbook id selected";
			}
		break;

		case "viewTextbookTomes":
			$returnArray = viewTextbookTomes($db);
			echo json_encode($returnArray);
		break;
		case "viewTextbookTomesByTextbookId":
			if(isset($_POST['textbookId']))
			{
				$textbookId = $_POST['textbookId'];
				$returnArray = viewTextbookTomesByTextbookId($db, $textbookId);
				echo json_encode($returnArray);
			}
			else
			{
				echo "no textbook id chosen";
			}
		break;

		case "viewTextbookNotebooks":
			$returnArray = viewTextbookNotebooks($db);
			echo json_encode($returnArray);
		break;
		case "viewTextbookNotebooksByTextbookId":
			if(isset($_POST['textbookId']))
			{
				$textbookId = $_POST['textbookId'];
				$returnArray = viewTextbookNotebooksByTextbookId($db, $textbookId);
				echo json_encode($returnArray);
			}
			else
			{
				echo "no textbook id chosen";
			}
		break;
		case "deleteTextbookNotebookRelation":
			if(isset($_POST['textbookId']) && isset($_POST['notebookId']))
			{
				$textbookId = $_POST['textbookId'];
				$notebookId = $_POST['notebookId'];
				$successFail = deleteTextbookNotebookRelation($db, $textbookId, $notebookId);
				echo $successFail;
			}
			else
			{
				echo "not enough Id's provided";
			}
		break;
		case "deleteTextbookTomeRelation":
			if(isset($_POST['textbookId']) && isset($_POST['tomeId']))
			{
				$textbookId = $_POST['textbookId'];
				$tomeId = $_POST['tomeId'];
				$successFail = deleteTextbookTomeRelation($db, $textbookId, $tomeId);
				echo $successFail;
			}
			else
			{
				echo "not enough ids provided";
			}
		break;
		case "sendMapData":
			if(isset($_POST['jsonArray']))
			{
     			$jsonArray = $_POST['jsonArray'];
     			//will return a map id of it all. 
  				$mapId = addMapFunction($db, $jsonArray['mapName']);
				addEvents($db, $jsonArray['xCoord'], $jsonArray['yCoord'], $jsonArray['eventType'], $jsonArray['eventName'], $mapId);
   			}
   			else
   			{
   				echo "no array passed";
   			}		
	}
}
else
{
	echo "you do not have permissions to modify this stuff";
}

function addMapFunction($db, $mapName)
{
  $sql = $db->prepare("SELECT mapId FROM mapList WHERE mapName = :mapName");
  $sql->bindParam(":mapName", $mapName, PDO::PARAM_STR);
  $sql->execute();
  $mapId = $sql->fetchColumn();
  if($mapId < 1)
  {
    $sql = $db->prepere("INSERT INTO mapId (mapName) VALUES(:mapName)");
    $sql->bindParam(":mapName", $mapName, PDO::PARAM_STR);
    $sql->execute();
    
    $sql = $db->prepare("SELECT mapId FROM mapList WHERE mapName = :mapName");
  	$sql->bindParam(":mapName", $mapName, PDO::PARAM_STR);
  	$sql->execute();
 		$mapId = $sql->fetchColumn();
  }
  return $mapId;
}

function addEvents($db, $xCoord, $yCoord, $eventType, $eventName, $mapId)
{
  
  $sql = "INSERT INTO mapCoordinates (xCoord, yCoord, eventType, eventName, mapId) VALUES ";
  
  for($i = 0; $i<count(xCoord); $i++)
  {
    $sql .= "(" . $xCoord[$i] . ", " . $yCoord[$i] . ", " . $eventType[i] . ", " . $eventName[i] . ", " . $mapId . ")";
  }
  $executeSql = $db->prepare($sql);
  $executeSql->execute();
}


function deleteTextbookTomeRelation($db, $textbookId, $tomeId)
{
	$sql=$db->prepare("DELETE FROM tomeTextbookReference WHERE textbookID = :textbookId AND tomeId = :tomeId");
	$sql->bindParam(":textbookId", $textbookId, PDO::PARAM_INT);
	$sql->bindParam(":tomeId", $tomeId, PDO::PARAM_INT);
	$sql->execute();
	return "success";

}

function deleteTextbookNotebookRelation($db, $textbookId, $notebookId)
{
	$sql=$db->prepare("DELETE FROM notebookTextbookReference WHERE textbookId = :textbookId AND notebookId = :notebookId");
	$sql->bindParam(":textbookId", $textbookId, PDO::PARAM_INT);
	$sql->bindParam(":notebookId", $notebookId, PDO::PARAM_INT);
	$sql->execute();
	return "success";
}


function viewTextbookNotebooksByTextbookId($db, $textbookId)
{
	$returnArray = array();
	$notebookNameArray = array();
	$notebookHtmlArray = array();
	$textbookNameArray = array();
	$textbookAuthorArray = array();
	$textbookVersionArray = array();

	$sql = "SELECT a.id, a.notebookName, a.notebookHtml, b.id, b.textbookId, b.notebookId, c.textbookId, c.textbookName, c.textbookAuthor, c.textbookVersion FROM notebook a, notebookTextbookReference b, textbookList c WHERE a.id = b.notebookId AND c.textbookId = b.textbookId AND c.textbookId = '" . $textbookId . "';";
	foreach($db->query($sql) as $row)
	{

		array_push($notebookNameArray, $row['notebookName']);
		array_push($notebookHtmlArray, $row['notebookHtml']);
		array_push($textbookNameArray, $row['textbookName']);
		array_push($textbookAuthorArray, $row['textbookAuthor']);
		array_push($textbookVersionArray, $row['textbookVersion']);
	}
	$returnArray['notebookName'] = $notebookNameArray;
	$returnArray['notebookHtml'] = $notebookHtmlArray;
	$returnArray['textbookName'] = $textbookNameArray;
	$returnArray['textbookAuthorArray'] = $textbookAuthorArray;
	$returnArray['textbookVersionArray'] = $textbookVersionArray;
	return $returnArray;

}
function viewTextbookNotebooks($db)
{
	$returnArray = array();
	$notebookNameArray = array();
	$notebookHtmlArray = array();
	$textbookNameArray = array();
	$textbookAuthorArray = array();
	$textbookVersionArray = array();

	$sql = "SELECT a.id, a.notebookName, a.notebookHtml, b.id, b.textbookId, b.notebookId, c.textbookId, c.textbookName, c.textbookAuthor, c.textbookVersion FROM notebook a, notebookTextbookReference b, textbookList c WHERE a.id = b.notebookId AND c.textbookId = b.textbookId;";

	foreach($db->query($sql) as $row)
	{

		array_push($notebookNameArray, $row['notebookName']);
		array_push($notebookHtmlArray, $row['notebookHtml']);
		array_push($textbookNameArray, $row['textbookName']);
		array_push($textbookAuthorArray, $row['textbookAuthor']);
		array_push($textbookVersionArray, $row['textbookVersion']);
	}
	$returnArray['notebookName'] = $notebookNameArray;
	$returnArray['notebookHtml'] = $notebookHtmlArray;
	$returnArray['textbookName'] = $textbookNameArray;
	$returnArray['textbookAuthorArray'] = $textbookAuthorArray;
	$returnArray['textbookVersionArray'] = $textbookVersionArray;
	return $returnArray;

}
function viewTextbookTomesByTextbookId($db, $textbookId)
{
	$returnArray = array();
	$tomeNameArray = array();
	$textbookNameArray = array();
	$textbookAuthorArray = array();
	$textbookVersionArray = array();
	$sql = "select a.id, a.textbookId, a.tomeId, b.tomeId, b.tomeName, c.textbookId, c.textbookName, c.textbookAuthor, c.textbookVersion FROM tomeTextbookReference a, tomeList b, textbookList c WHERE a.tomeId = b.tomeId AND a.textbookId = c.textbookId AND a.textbookId = '" . $textbookId . "';";
	foreach($db->query($sql) as $row)
	{
		array_push($tomeNameArray, $row['tomeName']);
		array_push($textbookNameArray, $row['textbookName']);
		array_push($textbookAuthorArray, $row['textbookAuthor']);
		array_push($textbookVersionArray, $row['textbookVersion']);
	}
	$returnArray['tomeName'] = $tomeNameArray;
	$returnArray['textbookName'] = $textbookNameArray;
	$returnArray['textbookAuthorArray'] = $textbookAuthorArray;
	$returnArray['textbookVersionArray'] = $textbookVersionArray;
	return $returnArray;
}

function viewTextbookTomes($db)
{

	$returnArray = array();
	$tomeNameArray = array();
	$textbookNameArray = array();
	$textbookAuthorArray = array();
	$textbookVersionArray = array();
	$sql = "select a.id, a.textbookId, a.tomeId, b.tomeId, b.tomeName, c.textbookId, c.textbookName, c.textbookAuthor, c.textbookVersion FROM tomeTextbookReference a, tomeList b, textbookList c WHERE a.tomeId = b.tomeId AND a.textbookId = c.textbookId;";
	foreach($db->query($sql) as $row)
	{
		array_push($tomeNameArray, $row['tomeName']);
		array_push($textbookNameArray, $row['textbookName']);
		array_push($textbookAuthorArray, $row['textbookAuthor']);
		array_push($textbookVersionArray, $row['textbookVersion']);
	}
	$returnArray['tomeName'] = $tomeNameArray;
	$returnArray['textbookName'] = $textbookNameArray;
	$returnArray['textbookAuthorArray'] = $textbookAuthorArray;
	$returnArray['textbookVersionArray'] = $textbookVersionArray;
	return $returnArray;
}

function addTomeToTextbook($db, $tomeId, $textbookId)
{
	$sql = $db->prepare("INSERT INTO tomeTextbookReference (tomeId, textbookId) VALUES (:tomeId, :textbookId)");
	$sql->bindParam(":tomeId", $tomeId, PDO::PARAM_INT);
	$sql->bindParam(":textbookId", $textbookId, PDO::PARAM_INT);
	$sql->execute();
	return "success";
}
function addNotebookToTextbook($db, $notebookId, $textbookId)
{
	$sql = $db->prepare("INSERT INTO notebookTextbookReference (notebookId, textbookId) VALUES (:notebookId, :textbookId)");
	$sql->bindParam(":notebookId", $notebookId, PDO::PARAM_INT);
	$sql->bindParam(":textbookId", $textbookId, PDO::PARAM_INT);
	$sql->execute();
	return "success";

}
function editTextbookInfo($db, $textbookId, $textbookName, $textbookAuthor, $textbookVersion)
{
	$sql = $db->prepare("UPDATE textbookList SET textbookName = :textbookName, textbookAuthor = :textbookAuthor, textbookVersion = :textbookVersion WHERE textbookId = :textbookId");
	$sql->bindParam(":textbookName", $textbookName, PDO::PARAM_STR);
	$sql->bindParam(":textbookAuthor", $textbookAuthor, PDO::PARAM_STR);
	$sql->bindParam(":textbookVersion", $textbookVersion, PDO::PARAM_STR);
	$sql->bindParam(":textbookId", $textbookId, PDO::PARAM_INT);
	$sql->execute();
	return "success";
}

function viewTextbooks($db)
{
	$returnArray = array();
	$textbookIdArray = array();
	$textbookNameArray = array();
	$textbookAuthorArray = array();
	$textbookVersionArray = array();

	$sql = "SELECT * FROM textbookList";
	foreach($db->query($sql) as $row)
	{
		array_push($textbookIdArray, $row['textbookId']);
		array_push($textbookNameArray, $row['textbookName']);
		array_push($textbookAuthorArray, $row['textbookAuthor']);
		array_push($textbookVersionArray, $row['textbookVersion']);
	}
	$returnArray['textbookId'] = $textbookIdArray;
	$returnArray['textbookName'] = $textbookNameArray;
	$returnArray['textbookAuthor'] = $textbookAuthorArray;
	$returnArray['textbookVersion'] = $textbookVersionArray;
	return $returnArray;
}

function createTextbook($db, $textbookName, $textbookAuthor, $textbookVersion)
{
	$sql = $db->prepare("INSERT INTO textbookList (textbookName, textbookAuthor, textbookVersion) VALUES(:textbookName, :textbookAuthor, :textbookVersion)");
	$sql->bindParam(":textbookName", $textbookName, PDO::PARAM_STR);
	$sql->bindParam(":textbookAuthor", $textbookAuthor, PDO::PARAM_STR);
	$sql->bindParam(":textbookVersion", $textbookVersion, PDO::PARAM_STR);
	$sql->execute();
	return "success";
}
function deleteTome($db, $tomeId)
{
	$sql = $db->prepare("DELETE FROM tomeList WHERE tomeId = :tomeId");
	$sql->bindParam(":tomeId", $tomeId, PDO::PARAM_INT);
	$sql->execute();
	return "success";
}

function editTomeName($db, $tomeId, $newTomeName)
{
	$sql = $db->prepare("UPDATE tomeList SET tomeName = :tomeName WHERE tomeId = :tomeId");
	$sql->bindParam(":tomeName", $newTomeName, PDO::PARAM_STR);
	$sql->bindParam(":tomeId", $tomeId, PDO::PARAM_INT);
	$sql->execute();
	return "success";
}

function viewTomes($db)
{
	$returnArray = array();
	$tomeIdArray = array();
	$tomeNameArray = array();

	$sql = "SELECT * FROM tomeList;";
	foreach($db->query($sql) as $row)
	{
		array_push($tomeIdArray, $row['tomeId']);
		array_push($tomeNameArray, $row['tomeName']);
	}
	$returnArray['tomeId'] = $tomeIdArray;
	$returnArray['tomeName'] = $tomeNameArray;
	return $returnArray;
}
function editNotebookHtml($db, $notebookId, $newHtml)
{
	$sql = $db->prepare("UPDATE notebook SET notebookHtml = :notebookHtml WHERE id = :id");
	$sql->bindParam(":notebookHtml", $newHtml, PDO::PARAM_LOB);
	$sql->bindParam(":id", $notebookId, PDO::PARAM_INT);
	$sql->execute();

}
function editNotebookName($db, $notebookId, $newTitle)
{
	$sql = $db->prepare("UPDATE notebook SET notebookName = :notebookName WHERE id = :id");
	$sql->bindParam(":notebookName", $newTitle, PDO::PARAM_STR);
	$sql->bindParam(":id", $notebookId, PDO::PARAM_INT);
	$sql->execute();
	return "success";
}

function deleteNotebook($db, $notebookId)
{
	$sql= $db->prepare("DELETE FROM notebook WHERE id=:id");
	$sql->bindParam(":id", $notebookId, PDO::PARAM_INT);
	$sql->execute();
	return "success";
}

function showNotebook($db)
{
	$returnArray = array();
	$idArray = array();
	$notebookNameArray = array();
	$notebookHtmlArray = array();

	$sql = "SELECT * FROM notebook";
	foreach($db->query($sql) as $row)
	{
		array_push($idArray, $row['id']);
		array_push($notebookNameArray, $row['notebookName']);
		array_push($notebookHtmlArray, $row['notebookHtml']);
	}

	$returnArray['id'] = $idArray;
	$returnArray['notebookName'] = $notebookNameArray;
	$returnArray['notebookHtml'] = $notebookHtmlArray;
	return $returnArray;
}

function addNotebook($db, $notebookName, $notebookHtml)
{
	$sql = $db->prepare("INSERT INTO notebook (notebookName, notebookHtml) VALUES (:notebookName, :notebookHtml)");
	$sql->bindParam(":notebookName", $notebookName, PDO::PARAM_STR);
	$sql->bindParam(":notebookHtml", $notebookHtml, PDO::PARAM_STR);
	$sql->execute();
	return "success";

}

function modifyWord($db, $wordId, $spanish, $english)
{
	$sql = $db->prepare("UPDATE wordList SET spanish = :spanish, english = :english WHERE wordId = :wordId");
	$sql->bindParam(":spanish", $spanish, PDO::PARAM_STR);
	$sql->bindParam(":english", $english, PDO::PARAM_STR);
	$sql->bindparam(":wordId", $wordId, PDO::PARAM_INT);
	$sql->execute();
	return "success";
}

function deleteWord($db, $wordId)
{
	$sql = $db->prepare("DELETE FROM tomeWordReference WHERE wordId = :wordId");
	$sql->bindParam(":wordId", $wordId, PDO::PARAM_INT);
	$sql->execute();

	$sql = $db->prepare("DELETE FROM wordList WHERE wordId = :wordId");
	$sql->bindParam(":wordId", $wordId, PDO::PARAM_INT);
	$sql->execute();
	return "success";
}

function fetchWordList($db)
{
	$returnArray = array();
	$wordIdArray = array();
	$spanishArray = array();
	$englishArray = array();

	$sql = "SELECT * FROM wordList";
	foreach($db->query($sql) as $row)
	{
		array_push($wordIdArray, $row['wordId']);
		array_push($spanishArray, $row['spanish']);
		array_push($englishArray, $row['english']);
	}
	$returnArray['wordId'] = $wordIdArray;
	$returnArray['spanish'] = $spanishArray;
	$returnArray['english'] = $englishArray;
	return $returnArray;
}


function fetchTomeWords($db, $tomeName)
{
	$returnArray = array();
	$englishArray = array();
	$spanishArray = array();
	$wordIdArray = array();

	$sql = "SELECT a.wordId, a.english, a.spanish, b.tomeId, b.tomeName, c.id, c.tomeId, c.wordId FROM wordList a, tomeList b, tomeWordReference c WHERE a.wordId = c.wordId AND b.tomeId = c.tomeId AND b.tomeName = '".$tomeName."';";

	foreach($db->query($sql) as $row)
	{
		array_push($wordIdArray, $row['wordId']);
		array_push($englishArray, $row['english']);
		array_push($spanishArray, $row['spanish']);
	}
	$returnArray['english'] = $englishArray;
	$returnArray['spanish'] = $spanishArray;
	$returnArray['wordId'] = $wordIdArray;
	return $returnArray;
}

function addWord($db, $englishWord, $spanishWord, $tome)
{

  $sql = $db->prepare("SELECT wordId FROM wordList WHERE english = :english AND spanish = :spanish");
  $sql->bindParam(":english", $englishWord, PDO::PARAM_STR);
  $sql->bindParam(":spanish", $spanishWord, PDO::PARAM_STR);
	$sql->execute();
  $wordId = $sql->fetchColumn();
  
  if(!$wordId)
  {
    $sql = $db->prepare("INSERT INTO wordList(english, spanish) VALUES (:english, :spanish)");
  	$sql->bindParam(":english", $englishWord, PDO::PARAM_STR);
  	$sql->bindParam(":spanish", $spanishWord, PDO::PARAM_STR);
  	$sql->execute();
    
    $sql = $db->prepare("SELECT wordId FROM wordList WHERE english = :english AND spanish = :spanish");
  	$sql->bindParam(":english", $englishWord, PDO::PARAM_STR);
  	$sql->bindParam(":spanish", $spanishWord, PDO::PARAM_STR);
		$sql->execute();
  	$wordId = $sql->fetchColumn();  
    $returnText = "word added to word list ";
  }
  else
  {
   	$returnText = "word already in wordList "; 
  }
  $tomeListSuccess = addToTomeList($db, $wordId, $tome);
  $returnText += $tomeListSuccess;
  
  return $returnText;
}

function addToTomeList($db, $wordId, $tome)
{
  
  $tomeId = tomeCreate($db, $tome);
  
  $sql = $db->prepare("SELECT id FROM tomeWordReference WHERE tomeId = :tomeId AND wordId = :wordId");
  $sql->bindParam(":tomeId", $tomeId, PDO::PARAM_INT);
  $sql->bindParam(":wordId", $wordId, PDO::PARAM_INT);
  $sql->execute();
  $id = $sql->fetchColumn();
  
  if(!$id)
  {
    $sql = $db->prepare("INSERT INTO tomeWordReference (tomeId, wordId) VALUES (:tomeId, :wordId)");
    $sql->bindParam(":tomeId", $tomeId, PDO::PARAM_INT);
  	$sql->bindParam(":wordId", $wordId, PDO::PARAM_INT);
  	$sql->execute();
  	return "word added";
  }
  else
  {
   	return "fail"; 
  }
}

function tomeCreate($db, $tome)
{
  $sql = $db->prepare("SELECT tomeId from tomeList WHERE tomeName = :tomeName");
  $sql->bindParam(":tomeName", $tome, PDO::PARAM_STR);
  $sql->execute();
  $tomeId = $sql->fetchColumn();
	if(!$tomeId)
  {
   $sql = $db->prepare("INSERT INTO tomeList (tomeName) VALUES (:tomeName)");
   $sql->bindParam("tomeName", $tome, PDO::PARAM_STR);
   $sql->execute();
  
   $sql = $db->prepare("SELECT tomeId from tomeList WHERE tomeName = :tomeName");
   $sql->bindParam(":tomeName", $tome, PDO::PARAM_STR);
   $sql->execute();
   $tomeId = $sql->fetchColumn();  
  }
  return $tomeId;
}


?>