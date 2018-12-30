<?php 
require "databaseConnector.php";
//later hack something together to make it possible for only leah
require "sessionInfo.php";
//as a side note; the files may be named something different 

//$db = the database connector attached via pdo, sessionData has the login check stuffs. 
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
   	$returnText = "word already in word List "; 
  }
  $tomeListSuccess = addToTomeList($db, $wordId, $tome);
  $returnText =  $returnText.$tomeListSuccess;
  
  return $returnText;
}
function addToTomeList($db, $wordId, $tome)
{
  
  $tomeId = tomeCreate($db, $tome);
  
  $sql = $db->prepare("SELECT id FROM tomeWordReference WHERE tomeId = :tomeId AND wordId = :wordId");
  $sql->bindParam(":tomeId", $tomeId, PDO::PARAM_INT);
  $sql->bindParam(":wordId", $wordId, PDO::PARAM_INT);
  $sql->execute();
  $tomeWordReferenceId = $sql->fetchColumn();
  
  if(!$tomeWordReferenceId)
  {
    $sql = $db->prepare("INSERT INTO tomeWordReference (tomeId, wordId) VALUES (:tomeId, :wordId)");
    $sql->bindParam(":tomeId", $tomeId, PDO::PARAM_INT);
  	$sql->bindParam(":wordId", $wordId, PDO::PARAM_INT);
  	$sql->execute();
  	return " word added";
  }
  else
  {
   	return " fail"; 
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