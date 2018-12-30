<?php

require "backend/sessionInfo.php";

?>

<!DOCTYPE html>
<html>
	<head>
		<script   src="https://code.jquery.com/jquery-3.1.0.js"   integrity="sha256-slogkvB1K3VOkzAI8QITxV3VzpOnkeNVsKvtkYLMjfk="   crossorigin="anonymous"></script>
		<?PHP if($ISLOGGEDIN == true) echo "<script src='js/scripts2.js'></script>"; ?>
		<link rel="stylesheet" type="text/css" href="/languageRPG/css/styles.css" />
		<style type="text/css">

.login-box {
	width: 900px;
	margin: 0 auto;
	background-color: black;
	border: 1px dashed white;
}

#container {
width: 500px;
margin: 120px auto;
text-align: center;
}

input {
	margin-bottom: 10px;
}

#login-box {
	width: 500;
	margin: 0 auto;
	background-color: black;
	border: 1px dashed white;
}
		</style>
	</head>
	<body>
		<div id='container'>
			<h1>LanguageRPG</h1>
			<div id='login-box'>
				<form id='upload' action='backend/registerSubmission.php' method='POST' enctype=''><br />
				<label>Username  : <input type='text' name='username'/></label><br />
				<label>Password  : <input type='password' name='password'/></label><br />
				<label>Password  : <input type='password' name='verify'/></label><br />
				<label>Email Add.: <input type='text' name='email'/></label><br />
				<br />
				<button type='submit' form='upload'>Register</button>
				</form>
			</div>
		</div>
	</body>	
</html>