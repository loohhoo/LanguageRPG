<?php

$debugMode = false;
require "sessionInfo.php";
require "databaseConnector.php";
require "password.php";


$username = $_POST['username'];
$password = $_POST['password'];

//throw syntax in variable for sql calls (easier in long run this way)
$sql = "SELECT userId, userPass FROM login WHERE username = '" . $username . "';";

$hash = false;
foreach($db->query($sql) as $row)
{
	//get hash and userid from sql results to then check em
	$hash = $row['userPass'];
	$userId = $row['userId'];
}
/*echo $hash;
echo $userId;
echo "..";
echo $sql;*/
if($hash && $userId)
{
	if(password_verify($password, $hash))
	{
		//set username to session data. 
		$_SESSION['username'] = $username;
		//set session start time for checking when user was logged in 
		$_SESSION['start'] = time();
		$_SESSION['expire'] = $_SESSION['start']+(30*60);
		$_SESSION['userId'] = $userId;
		$ISLOGGEDIN = true;

		//echo "works";
		echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$PATHWAY.'">';

	}
	else
	{
		//echo "wrong Pass";
		echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$PATHWAY.'login.php">';		
	}
}
else
{
	echo "that username does not exist";
}

?>
