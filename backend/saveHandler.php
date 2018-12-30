<?php

require "databaseConnector.php";
require "sessionInfo.php";

if(isset($_GET['requestType']))
{
	$requestType = $_GET['requestType'];

	if($requestType == "getSaveData")
	{
		$saveData = getSaveData($sessionUserId, $db);
		echo json_encode($saveData);
	}
	if($requestType == "uploadSaveData")
	{
		if(isset($_GET['hp']) && isset($_GET['maxHp']) &&  isset($_GET['xp']) &&  isset($_GET['xpToNextLevel']) &&  isset($_GET['mp']) &&  isset($_GET['maxMp']) &&  isset($_GET['level']) &&  isset($_GET['money']) &&  isset($_GET['currentXPosition']) &&  isset($_GET['currentYPosition']) &&  isset($_GET['attackPoints']) &&  isset($_GET['defensePoints']))
		{
			$hp = $_GET['hp'];
			$maxHp = $_GET['maxHp'];
			$xp = $_GET['xp'];
			$xpToNextLevel = $_GET['xpToNextLevel'];
			$mp = $_GET['mp'];
			$maxMp = $_GET['maxMp'];
			$level = $_GET['level'];
			$money = $_GET['money'];
			$currentXPosition = $_GET['currentXPosition'];
			$currentYPosition = $_GET['currentYPosition'];
			$attackPoints = $_GET['attackPoints'];
			$defensePoints = $_GET['defensePoints'];
			$currentMap = $_GET['currentMap'];

			$uploadresult = uploadSaveData($sessionUserId, $db, $hp, $maxHp, $xp, $xpToNextLevel, $mp, $maxMp, $level, $money, $currentXPosition, $currentYPosition, $attackPoints, $defensePoints, $currentMap);
			echo $uploadresult;
		}
	}
	if($requestType == "getPlayerInventory")
	{
		$playerInventory = getPlayerInventory($sessionUserId, $db);
		echo json_encode($playerInventory);
	}
	if($requestType == "savePlayerInventory")
	{
		if(isset($_GET['itemArray'])&&isset($_GET['quantityArray']))
		{
			$itemIdArray = $_GET['itemIdArray'];
			$quantityArray = $_GET['quantityArray']
			$saveResult = savePlayerInventory($sessionUserId, $db, $itemIdArray, $quantityArray);
			echo $saveResult;
		}
	}
	
}
if(isset($_POST['requestType']))
{
	$requestType = $_POST['requestType'];

	if($requestType == "getSaveData")
	{
		$saveData = getSaveData($sessionUserId, $db);
		echo json_encode($saveData);
	}
	if($requestType == "uploadSaveData")
	{
		if(isset($_POST['hp']) && isset($_POST['maxHp']) && isset($_POST['xp']) && isset($_POST['xpToNextLevel']) && isset($_POST['mp']) && isset($_POST['maxMp']) && isset($_POST['level']) && isset($_POST['money']) && isset($_POST['currentXPosition']) && isset($_POST['currentYPosition']) && isset($_POST['attackPoints']) && isset($_POST['defensePoints']))
		{

			$hp = $_POST['hp'];
			$maxHp = $_POST['maxHp'];
			$xp = $_POST['xp'];
			$xpToNextLevel = $_POST['xpToNextLevel'];
			$mp = $_POST['mp'];
			$maxMp = $_POST['maxMp'];
			$level = $_POST['level'];
			$money = $_POST['money'];
			$currentXPosition = $_POST['currentXPosition'];
			$currentYPosition = $_POST['currentYPosition'];
			$attackPoints = $_POST['attackPoints'];
			$defensePoints = $_POST['defensePoints'];
			$currentMap = $_POST['currentMap']

			$uploadresult = uploadSaveData($sessionUserId, $db, $hp, $maxHp, $xp, $xpToNextLevel, $mp, $maxMp, $level, $money, $currentXPosition, $currentYPosition, $attackPoints, $defensePoints, $currentMap);
			echo $uploadresult;
		}
	}
	if($requestType == "getPlayerInventory")
	{
		$playerInventory = getPlayerInventory($sessionUserId, $db);
		echo json_encode($playerInventory);
	}
	if($requestType == "savePlayerInventory")
	{
		if(isset($_POST['itemArray'])&&isset($_POST['quantityArray']}))
		{
			$itemIdArray = $_POST['itemIdArray'];
			$quantityArray = $_POST['quantityArray']
			$saveResult = savePlayerInventory($sessionUserId, $db, $itemIdArray, $quantityArray);

			echo $saveResult;
		}
	}
}
function savePlayerInventory($sessionUserId, $db, $itemIdArray, $quantityArray)
{
	if($sessionUserId && $sessionUserId > 0)
	{
		//step one; delete all currently existing items in player inventory since they will change at save time... this is rather simple so... 
		$sql = $db->prepare("DELETE FROM inventoryReference WHERE userId = :userId");
		$sql->bindParam(":userId", $sessionUserId, PDO::PARAM_INT);
		$sql->execute();

		//afterwords we insert the new save data accordingly
		$sql = "INSERT INTO inventoryReference(userId, itemId) VALUES ";
		for($i=0; $i<count($itemIdArray); $i++)
		{
			$sql .= "(" . $sessionUserId . ", " . $itemIdArray[$i] . ", " . $quantityArray[$i] . ") ";
		}
		$executeSql = $db->prepare($sql);
		$executeSql->execute();

	}

}

function getPlayerInventory($sessionUserId, $db)
{
	if($sessionUserId && $sessionUserId > 0)
	{
		$inventoryArray = array();
		$itemIdArray = array();
		$itemNameArray = array();
		$quantityArray = array();
		$sql = "SELECT a.itemId, a.itemName, b.userId, b.itemId, b.quantity FROM itemList a, inventoryReference b WHERE a.itemId = b.itemId AND b.userId = '" . $sessionUserId . "';";
		
		foreach($db->query($sql) as $row)
		{
			array_push($itemIdArray, $row['itemId']);
			array_push($itemNameArray, $row['itemName']);
			array_push($quantityArray, $row['quantity']);
		}
		$inventoryArray['itemId'] = $itemIdArray;
		$inventoryArray['itemName'] = $itemNameArray;
		$inventoryArray['quantity'] = $quantityArray
		return $inventoryArray;
	}
}

function getSaveData($sessionUserId, $db)
{
	if($sessionUserId && $sessionUserId > 0)
	{
		$saveDataArray = array();
		$userIdArray = array();
		$hpArray = array();
		$maxHpArray = array();
		$xpArray = array();
		$xpToNextLevelArray = array();
		$mpArray = array();
		$maxMpArray = array();
		$levelArray = array();
		$moneyArray = array();
		$currentXPositionArray = array();
		$currentYPositionArray = array();
		$attackPointsArray = array();
		$defensePointsArray = array();
		$currentMapArray = array();


		$sql = "SELECT * FROM saveData WHERE userId = '" . $sessionUserId . "';";
		foreach($db->query($sql) as $row)
		{
			array_push($userIdArray, $row['userId']);
			array_push($hpArray, $row['hp']);
			array_push($maxHpArray, $row['maxHp']);
			array_push($xpArray, $row['xp']);
			array_push($xpToNextLevelArray, $row['xpToNextLevel']);
			array_push($mpArray, $row['mp']);
			array_push($maxMpArray, $row['maxMp']);
			array_push($levelArray, $row['level']);
			array_push($moneyArray, $row['money']);
			array_push($currentXPositionArray, $row['currentXPosition']);
			array_push($currentYPositionArray, $row['currentYPosition']);
			array_push($attackPointsArray, $row['attackPoints']);
			array_push($defensePointsArray, $row['defensePoints']);
			array_push($currentMapArray, $row['currentMap'])
		}
		$saveDataArray['userId'] = $userIdArray;
		$saveDataArray['hp'] = $hpArray;
		$saveDataArray['maxHp'] = $maxHpArray;
		$saveDataArray['xp'] = $xpArray;
		$saveDataArray['xpToNextLevel'] = $xpToNextLevelArray;
		$saveDataArray['mp'] = $mpArray;
		$saveDataArray['maxMp'] = $maxMpArray;
		$saveDataArray['level'] = $levelArray;
		$saveDataArray['money'] = $moneyArray;
		$saveDataArray['currentXPosition'] = $currentXPositionArray;
		$saveDataArray['currentYPosition'] = $currentYPositionArray;
		$saveDataArray['attackPoints'] = $attackPointsArray;
		$saveDataArray['defensePoints'] = $defensePointsArray;	
		$saveDataArray['currentMap'] = $currentMapArray;	
		return $saveDataArray;
	}
	else
	{
		//return "you must be logged in to fetch save data";

	}
}

function uploadSaveData($sessionUserId, $db, $hp, $maxHp, $xp, $xpToNextLevel, $mp, $maxMp, $level, $money, $currentXPosition, $currentYPosition, $attackPoints, $defensePoints, $currentMap)
{
	if($sessionUserId && $sessionUserId > 0)
	{

		$sql = $db->prepare("SELECT userId FROM saveData WHERE userId = :userId");
		$sql->bindParam(":userId", $sessionUserId, PDO::PARAM_INT);
		$sql->execute();
		$userId = $sql->fetchColumn();


		if($userId)
		{
			$sql = $db->prepare("UPDATE saveData SET hp = :hp, maxHp = :maxHp, xp = :xp, xpToNextLevel = :xpToNextLevel, mp = :mp, maxMp = :maxMp, level = :level, money = :money, currentXPosition = :currentXPosition, currentYPosition = :currentYPosition, attackPoints = :attackPoints, defensePoints = :defensePoints, currentMap = :currentMap WHERE userId = :userId");
			$sql->bindParam(":hp", $hp, PDO::PARAM_INT);
			$sql->bindParam(":maxHp", $maxHp, PDO::PARAM_INT);
			$sql->bindParam(":xp", $xp, PDO::PARAM_INT);
			$sql->bindParam(":xpToNextLevel", $xpToNextLevel, PDO::PARAM_INT);
			$sql->bindParam(":mp", $mp, PDO::PARAM_INT);
			$sql->bindParam(":maxMp", $maxMp, PDO::PARAM_INT);
			$sql->bindParam(":level", $level, PDO::PARAM_INT);
			$sql->bindParam(":money", $money, PDO::PARAM_INT);
			$sql->bindParam(":currentXPosition", $currentXPosition, PDO::PARAM_INT);
			$sql->bindParam(":currentYPosition", $currentYPosition, PDO::PARAM_INT);
			$sql->bindParam(":attackPoints", $attackPoints, PDO::PARAM_INT);
			$sql->bindParam(":defensePoints", $defensePoints, PDO::PARAM_INT);
			$sql->bindParam(":userId", $sessionUserId, PDO::PARAM_INT);
			$sql->bindParam(":currentMap", $currentMap, PDO::PARAM_STR);
			$sql->execute();
			return "updated save file";

			
		}
		else
		{
			$sql = $db->prepare("INSERT INTO saveData(userId, hp, maxHp, xp, xpToNextLevel, mp, maxMp, level, money, currentXPosition, currentYPosition, attackPoints, defensePoints, currentMap) VALUES (:userId, :xp, :xpToNextLevel, :mp, :maxMp, :level, :money, :currentXPosition, :currentYPosition, :attackPoints, :defensePoints, :currentMap)");
			$sql->bindParam(":hp", $hp, PDO::PARAM_INT);
			$sql->bindParam(":maxHp", $maxHp, PDO::PARAM_INT);
			$sql->bindParam(":xp", $xp, PDO::PARAM_INT);
			$sql->bindParam(":xpToNextLevel", $xpToNextLevel, PDO::PARAM_INT);
			$sql->bindParam(":mp", $mp, PDO::PARAM_INT);
			$sql->bindParam(":maxMp", $maxMp, PDO::PARAM_INT);
			$sql->bindParam(":level", $level, PDO::PARAM_INT);
			$sql->bindParam(":money", $money, PDO::PARAM_INT);
			$sql->bindParam(":currentXPosition", $currentXPosition, PDO::PARAM_INT);
			$sql->bindParam(":currentYPosition", $currentYPosition, PDO::PARAM_INT);
			$sql->bindParam(":attackPoints", $attackPoints, PDO::PARAM_INT);
			$sql->bindParam(":defensePoints", $defensePoints, PDO::PARAM_INT);
			$sql->bindParam(":userId", $sessionUserId, PDO::PARAM_INT);			
			$sql->bindParam(":currentMap", $currentMap, PDO::PARAM_STR);

			$sql->execute();
			return "created save file";
		}

	}
	else
	{
		//return "you must be logged in to save data";
	}
}