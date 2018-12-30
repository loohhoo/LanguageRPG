<?php

require "databaseConnector.php";

if(isset($_GET['tomeName']))
{
	$tomeName = $_GET['tomeName'];
}
if(isset($_POST['tomeName']))
{
	$tomeName = $_POST['tomeName'];
}

if(isset($_GET['notebookName']))
{
	$notebookName = $_GET['notebookName'];
}
if(isset($_POST['notebookName']))
{
	$notebookName = $_POST['notebookName'];
}

if(isset($_POST['requestType'])) {
	$requestType = $_POST['requestType'];
}



switch($requestType) {
	case "tomeWords":
		$tomeWordsArray = fetchTomeWords($db, $tomeName);
		echo json_encode($tomeWordsArray);

	break;
	case "notebookHtml":
		$notebookHtml = fetchNotebookInfo($db, $notebookName);
		echo $notebookHtml;
	break;
}


function fetchTomeWords($db, $tomeName)
{
	$returnArray = array();
	$englishArray = array();
	$spanishArray = array();

	$sql = "SELECT a.wordId, a.english, a.spanish, b.tomeId, b.tomeName, c.id, c.tomeId, c.wordId FROM wordList a, tomeList b, tomeWordReference c WHERE a.wordId = c.wordId AND b.tomeId = c.tomeId AND b.tomeName = '".$tomeName."';";

	foreach($db->query($sql) as $row)
	{
		array_push($englishArray, $row['english']);
		array_push($spanishArray, $row['spanish']);
	}
	$returnArray['english'] = $englishArray;
	$returnArray['spanish'] = $spanishArray;
	return $returnArray;



}

function fetchNotebookInfo($db, $notebookName)
{
	//$returnArray = array();
	$notebookHtml = "";

	$sql = "SELECT * FROM notebook WHERE notebookName = '". $notebookName ."';";

	foreach($db->query($sql) as $row)
	{
		$notebookHtml = $row['notebookHtml'];
	}

	//$returnArray['english'] = $englishArray;
	return $notebookHtml;

}