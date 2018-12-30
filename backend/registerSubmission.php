<?php

require "sessionInfo.php";
require "databaseConnector.php";
require "password.php";


//set of recieved values from user 
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$save = "<game>
	<name></name>
	<hp>20</hp>
	<x>0</x>
	<y>0</y>
	<map>start</map>
</game>";

$hash = password_hash($password, PASSWORD_BCRYPT);

$atSplit = explode("@", $email);

//list of illegal email characters
$illegalChars= ' "(),:;<>[\]';
$illegalArray = str_split($illegalChars);
$pos=in_array($email, $illegalArray);

//checks to make sure its' a valid email address, also verifies post has needed submission stuff
if(count($atSplit) == 2 && $pos ===false && $password != '' && $username != '' && $email != '' && password_verify($password, $hash))
{
	try
	{
		$sql = $db->prepare("INSERT INTO login(username, userEmail, userPass) VALUES(:uname, :umail, :upass);");
		
		$sql->bindparam(":uname", $username);
		$sql->bindparam(":umail", $email);
		$sql->bindparam(":upass", $hash);
		
		$sql->execute();
		return $sql;
		echo "it werks";
		if($debugMode == false)
		{
			echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$PATHWAY.'">';
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
		echo "sql problems be like...";
		if($debugMode == false)
		{
			echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$PATHWAY.'">';
		}
	}
}
else 
{
	//tells user why their email isn't valid by checking it against conditions such as is blank, has illegal characters, or has too few or too many @ signs...
	if($email == '')
	{
		echo "please insert email";
	}
	if($username=='')
	{
		echo "please insert a username";
	}
	if($password =='')
	{
		echo "you cannot have a blank password";
	}
	if($pos != false)
	{
		echo "your email is illegal";
	}
	if(count($atSplit) !=2)
	{
		echo "looks like you either have too few or too many @'s there buddy";
	}
	else
	{
		//echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$PATHWAY.'">';
	}
}

include "footer.php";
?>
