<?php

require "backend/sessionInfo.php";

?>
<!DOCTYPE html>
<html>
	<head>
		<script   src='https://code.jquery.com/jquery-3.1.0.js'   integrity='sha256-slogkvB1K3VOkzAI8QITxV3VzpOnkeNVsKvtkYLMjfk='   crossorigin='anonymous'></script>
		<?PHP if($ISLOGGEDIN == true) echo "<script src='js/scripts2.js'></script>"; ?>
		<link rel="stylesheet" type="text/css" href="/languageRPG/css/styles.css" />
		<meta charset="UTF-8">
	</head>
	<body>
		<?php 
		if($ISLOGGEDIN == true) 
		{
		echo "
		<div id='game'>
			<div id='player-stats'>
				<h2>Stats</h2>
				<img src='/languageRPG/images/portrait.png' width='113' height='128'/>
				<p>Name: <span id='name'>Leah</span></p>
				<p>Level: <span id='level'>1</span></p>
				<p>HP: <span id='hp'></span> / <span id='maxhp'></span> | MP: <span id='mp'></span> / <span id='maxmp'></span></p>
				<p>EXP: <span id='exp'></span> / <span id='maxexp'></span> | $:  <span id='money'></span></p>
				<div id='position'></div>
				<h2>Commands</h2>
				<button id='inventory'>inventory</button>
				<button id='clear' style='margin-left: 20px'>clear</button>
				<br />
				<button class='go-north'>North</button><br />
				<button class='go-west'>West</button><button class='go-east'>East</button><br />
				<button class='go-south'>South</button>
				<h2>Game State</h2>
				<button id='new-game'>new</button>
				<button id='save'>Save</button>
				<button id='load'>Load</button><br />
			</div>

			<div id='graphics'>
				<img id='map' style='float: left' src='/languageRPG/images/town.png' />
				<div id='battle-area'>
					<div id='question'>
						<div class='left'>
							<img id='battle_enemy_sprite' src=''/>
						</div>
						<div class='right'>
							<span id='enemy_name'></span>
							<span id='enemy_class'></span>
							<div class='enemy-health-meter'>
								<div class='bar'>
									<div id='enemy_health_stats'>
										<span>HP</span>
										<span id='enemy_stats_health'>0</span>
										<span> / </span>
										<span id='enemy_stats_maxhealth'>0</span>
									</div>
								</div>
							</div>
						</div>
					</div>
						<div id='choices'>
						<span id='the_question'></span><br />
						<button id='choice1'></button>
						<button id='choice2'></button>
						<button id='choice3'></button>
						</div>
				</div>
				<div id='tome'></div>
				<div id='inventory-box'></div>
				<div id='flashcards'>
				<p id=\"accents\"><button id=\"acc-a\">á</button><button id=\"acc-e\">é</button><button id=\"acc-i\">í</button><button id=\"acc-o\">ó</button><button id=\"acc-u\">ú</button><button id=\"acc-uu\">ü</button><button id=\"acc-n\">ñ</button></p>
						<span class='question'></span><br />
						<input type='text' class='answer' />
						<button class='submit-answer'>submit</button>
					<button id='stop-flashcards'>done</button>
				</div>
			</div>


				<div id='output'></div>
			<div id='people'>
				<h2>people</h2>
				<div id='people-info'>

				</div>
			</div>

			<p style='clear: both;'></p>
			";
		}


		else {
			echo "<div id='container'>
			<h1>LanguageRPG</h1>
			<p>Welcome to LanguageRPG - the semi text-based RPG where you get to learn a language!</p>
			<button><a href='login.php'>Login</a></button> <button><a href='register.php'>Register</a></button>
		</div>";
		}	

		?>
		</div>
	</body>
</html>