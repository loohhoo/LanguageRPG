$(document).ready(function() {
	//Load in graphics
	var currentMap = 'start';
	var inEvent = false;
	var mapW = 0;
	var mapH = 0;
	var flags=[];
	//loadMap("start");

	var Player = function() {
		this.name = '';
		this.hp = 20;
		this.maxHp = 20;
		this.exp = 0;
		this.expToNextLevel = 0;
		this.x = 0;
		this.y = 0;
		this.level = 1;
		this.attackP = 5;
		this.defenseP = 5;
		this.inventory = [];
	};

	Player.prototype.levelUp = function() {
		if(this.exp >= this.expToNextLevel) {
			this.level++;
		}
	}

	Player.prototype.calcExpToNext = function() {
		this.expToNextLevel = Math.floor(this.level * 3/2);
	}

	Player.prototype.attack = function(target) {
		target.hp -= this.attackP;
	};

	Player.prototype.setPosition = function(x, y) {
		this.x = x;
		this.y = y;
	};

	Player.prototype.add = function(name, type) {
		this.inventory.push(new Item(name, type));
	}

	Player.prototype.del = function(name) {
		for(var i = 0; i < this.inventory.length; i++) {
			if(this.inventory[i].name == name) {
				this.inventory.splice(i,1);
			}
		}
	}

	Player.prototype.has = function(name) {
		var hasItem = false;
		for(var i = 0; i < this.inventory.length; i++) {
			if(this.inventory[i].name == name) {
				hasItem = true;
			}
		}

		return hasItem;
	}

	Player.prototype.use = function(name) {
		for(var i = 0; i < this.inventory.length; i++) {
			if(this.inventory[i].name == name) {
				if(this.inventory[i].type == "tome") {
					loadTome(this.inventory[i].name);
				}
			}

		}
	}

	Player.prototype.flashcards = function(tomeName) {
		$("#flashcards").toggle();
		var flashcard = new Flashcard();
		flashcard.showChoices();
	}

	Player.prototype.listItems = function(type) {
		for(var i = 0; i < this.inventory.length; i++) {
			if(this.inventory[i].type == type) {
				if(type == "tome") {	
					$("#output").append("<p>Tome: "+this.inventory[i].name+"</p>");
				}
			}

			if(type == "") {
				$("#output").append("<p>"+this.inventory[i].type+": "+this.inventory[i].name+"</p>");
			}
		}
	}

	var Enemy = function() {
		var classes = ["Scribe", "Orator", "Mage", "Prophet"];
		var creatures = ["Red Slime", "Green Slime", "Blue Slime", "Yellow Slime", "Grey Slime"];
		this.creature = Math.ceil(Math.random() * 5);
		this.name = creatures[this.creature-1];
		this.cl = classes[Math.floor(Math.random() * 3)];
		this.level = Math.ceil(Math.random() * 5);
		this.attackP = this.level * 3;
		this.hp = 20;
		this.maxHp = 20;
		this.defenseP = 0;
		this.category = "mc"

		$("#enemy_name").html("Level "+this.level+" " +this.name);
		$("#enemy_class").html(this.cl);
		$("#battle_enemy_sprite").attr("src", "/apps/japanese/languageRPG/images/enemy/enemy"+this.creature+".png");
	};

	Enemy.prototype.attack = function(Player) {
		$("#battle-area").css("visibility","visible");
		haltCommands();
		if(this.category == "mc") {
			this.question = new MultipleChoice();
			this.question.showChoices(Player);
		}	
	};

	Enemy.prototype.die = function() {

	}

	Enemy.prototype.takeDamage = function() {
		this.hp -= 5;
		$("#enemy_stats_health").html(this.hp);
		if(this.hp <= 0) {
			alert("You killed it!");
			leaveEvent();
			$("#battle-area").css("visibility","hidden");
		}

		else if (this.hp > 0) {
			this.attack(player);
		}		
	}

	var Flashcard = function() {
		this.question = "";
		this.choice1 = "";
		this.choice2 = "";
		this.choice3 = "";
		this.answer = "";
	}

	Flashcard.prototype.showChoices = function(tomeName) {
		// Load in a question
		$.getJSON("/apps/japanese/languageRPG/js/"+currentMap+".json", function(data) {
			var numQs = data.question.length;
			var randQ = Math.floor(Math.random() * numQs);
			// Time to manipulate the data
			this.question = data.question[randQ].question;
			this.choice1 = data.question[randQ].choice1;
			this.choice2 = data.question[randQ].choice2;
			this.choice3 = data.question[randQ].choice3;
			this.answer = data.question[randQ].answer;
			Answer = this.answer;
			$("#flashcards .question").html(this.question);
			$("#flashcards .choice1").html(this.choice1);
			$("#flashcards .choice2").html(this.choice2);
			$("#flashcards .choice3").html(this.choice3);
			$("#flashcards .choice1").attr("value",this.choice1);
			$("#flashcards .choice2").attr("value",this.choice2);
			$("#flashcards .choice3").attr("value",this.choice3);
		});

		$("#flashcards .choice1, #flashcards .choice2, #flashcards .choice3").on("click", function(e) {
			e.stopImmediatePropagation();
	    	e.preventDefault();
			if($(this).attr("value") == Answer)
			{
				alert("correct!");
				showChoices();
				
			}

			else  {
				alert("wrong!");
				showChoices();
			}

		});

	}

	/*** Class for multiple choice questions ***/
	function MultipleChoice() {
		this.question = "";
		this.choice1 = "";
		this.choice2 = "";
		this.choice3 = "";
		this.answer = "";
	}



	MultipleChoice.prototype.clear = function(correct) {
		$("#choice1, #choice2, #choice3").attr("value", "");
		$("#choice1, #choice2, #choice3, #the_question").html("");
		if(correct == true) {
			enemy.takeDamage();
		}

		else if (correct == false) {
			player.hp-=enemy.attackP;
		}

	}

	MultipleChoice.prototype.showChoices = function(Player) {
		// Load in a question
		$.getJSON("/apps/japanese/languageRPG/js/"+currentMap+".json", function(data) {
			var numQs = data.question.length;
			var randQ = Math.floor(Math.random() * numQs);
			// Time to manipulate the data
			this.question = data.question[randQ].question;
			this.choice1 = data.question[randQ].choice1;
			this.choice2 = data.question[randQ].choice2;
			this.choice3 = data.question[randQ].choice3;
			this.answer = data.question[randQ].answer;
			Answer = this.answer;
			$("#the_question").html(this.question);
			$("#choice1").html(this.choice1);
			$("#choice2").html(this.choice2);
			$("#choice3").html(this.choice3);
			$("#choice1").attr("value",this.choice1);
			$("#choice2").attr("value",this.choice2);
			$("#choice3").attr("value",this.choice3);
		});

		var _this = this;

		/** TODO: look into D20 modern for "your attack missed" mechanic **/

		$("#choice1, #choice2, #choice3").on("click", function(e) {
			e.stopImmediatePropagation();
	    	e.preventDefault();
			if($(this).attr("value") == Answer)
			{
				//_this refers to the enemy
				//this refers to #choice1
				_this.clear(true);
				alert("correct!");
				
			}

			else  {
				_this.clear(false);
				alert("wrong!");
			}
			
			if(enemy.hp > 0) {
				enemy.attack();
			}

		});

	}

	var Item = function(name, type) {
		this.name = name;
		this.type = type;		// weapon (amount = 1), spell, armor, tome
		this.amount; 
	};

	var player = new Player();
	var enemy;
	//player.add("sword");
	//player.add("spell");
	player.setPosition(0, 2);
	checkForEvents(currentMap);
	player.add("verbs1","tome");
	player.add("verbs2","tome");
	getCommands();

	//Aight fam, this about to be a long function for getting commands :'D
	function getCommands() {

		$("#submit-command").click(function() {
			if($("#output p").length > 10) {
				$("#output p").first().remove();
			}

			var command = $("#command").val().split(" ");
			var method = command[0];
			if(method == "list") {
				var argument = command[1];
				player.listItems(argument);
			}

			else if(method == "close") {
					var argument = command[1];
					if(argument == "tome") {
						$("#tome").css("display","none");
						$("#output").append("<p>You closed the tome.</p>");
					}

					else {
						$("#output").append("<p>You can't close that.</p>");
					}
			}

			//METHOD: USE
			else if(method == "use") {	

				var item = command[1];
				var argument = command[2];
				var target = command[3];

				if(item == "tome") {
					loadTome(argument);
				}

				else if(item == "spell") {
					if(argument == "lightning") {
						if(target == "enemy") {
							if(enemy.hp == 0) {
								$("#output").append("<p>There is no enemy.</p>");
							}
							else {
								if(player.has("lightning")) {
									player.attack(enemy);
									$("#output").append("<p>Used "+argument+" on enemy! Enemy HP: "+enemy.hp+"</p>");
									if(enemy.hp <= 0) {
										enemy.die();
									}
								}

								else if(!player.has("lightning")) {
									$("#output").append("<p>You don't have that spell.</p>");
								}
							}
						}
						
					}
				}

				else if(item == "sword") {
					if(argument == "enemy") {
						if(enemy.hp == 0) {
							$("#output").append("<p>There is no enemy.</p>");
						}
						else {
							if(player.has("sword")) {
								player.attack(enemy);
								$("#output").append("<p>Used "+item+" on enemy! Enemy HP: "+enemy.hp+"</p>");
								if(enemy.hp <= 0) {
									enemy.die();
								}
							}

							else if(!player.has("sword")) {
								$("#output").append("<p>You don't have that weapon.</p>");
							}
						}
						
					}
				}

				// else if(argument == "sword") {
				// 	if(target == "enemy") {
				// 		player.attack(enemy);
				// 		$("#output").append("<p>Used "+argument+" on enemy! Enemy HP: "+enemy.hp+"</p>");
				// 	}
				// }
			
			}

			else if(method == "go") {
					var argument = command[1];
					if(argument == "north") {
						if(player.y > 0) {
							$("#output").append("<p>You <span style=\"color: red\">GO</span> north.</p>");
							player.y -= 1;
						}

						else {
							//$("#output").append("<p>You tried to go north, but hit a wall.</p>");
						}
					}

					if(argument == "east") {
						if(player.x < mapW) {
							$("#output").append("<p>You <span style=\"color: red\">GO</span> east.</p>");
							player.x += 1;
						}

						else {
							//$("#output").append("<p>You tried to go east, but hit a wall.</p>");
						}
					}

					if(argument == "south") {
						if(player.y < mapH) {
							$("#output").append("<p>You <span style=\"color: red\">GO</span> south.</p>");
							player.y += 1;
						}

						else {
							//$("#output").append("<p>You tried to go south, but hit a wall.</p>");
						}
					}

					if(argument == "west") {
						if(player.x > 0) {
							$("#output").append("<p>You <span style=\"color: red\">GO</span> west.</p>");
							player.x -= 1;
						}

						else {
							//$("#output").append("<p>You tried to go west, but hit a wall.</p>");
						}
					}
					checkMap(player.x, player.y, currentMap);
					checkForEvents(currentMap);
					$("#output").append("<p>Position: "+player.x+", "+player.y+"</p>");
			}

			updateScroll();
		});
	}

	function haltCommands() {
		$("#submit-command").unbind();
	}

	// function loadMap(mapName) {
	// 	var mapArray = []
	// 	$.ajax({
	// 		url: "/apps/japanese/languageRPG/js/maps.xml"
	// 	}).done(function(xml) {
	// 		$(xml).find('map').each(function() {
	// 			mapArray.push($(this).find('title').text());
	// 		})
			
	// 		for(var i = 0; i < mapArray.length; i++) {
	// 			if(mapArray[i] == mapName) {
	// 				$("#output").append("<h2>Start: "+mapName+"</h2>");
	// 			}
	// 		}
	// 	});
	// }

	function checkMap(x, y, map) {
		$.ajax({
			url: "/apps/japanese/languageRPG/js/maps.xml"
		}).done(function(xml) {
			$(xml).find('map').each(function() {
				if($(this).find('title').text() == map) {
					$(this).find('exits').find('exit').each(function() {
						if($(this).attr('x') == player.x && $(this).attr('y') == player.y) {
							
							var newMap = $(this).attr('title');
							// $("#output").append("<p>You can ENTER "+newMap+" here.</p>");
							// $("#submit-command").click(function() {
								var command = $("#command").val().split(" ");
								var method = command[0];
								// if(method == "enter") {
									var prevMap = currentMap;
									currentMap = newMap;
									enterMap(prevMap, newMap);
								// }

								// else {
								// 	$("#submit-command").unbind();
								// 	return;
								// 	getCommands();
								// }
							//});
							
						}
					});
				}
			});
		});
	}

	function setMapWH(title) {
		title = title;
		$.ajax({
			url: "/apps/japanese/languageRPG/js/maps.xml"
		}).done(function(xml) {
			$(xml).find('map').each(function() {
				if($(this).find('title').text() == title) {
					mapW = parseInt($(this).find('dimensions').find('w').text());
					mapH = parseInt($(this).find('dimensions').find('h').text());
				}
			})
		});
	}

	function enterMap(prevMap, newMap) {
		$.ajax({
			url: "/apps/japanese/languageRPG/js/maps.xml"
		}).done(function(xml) {
			$(xml).find('map').each(function() {
				if($(this).find('title').text() == newMap) {
					$(this).find('position').each(function() {
						if($(this).attr('from') == prevMap) {
							player.x = parseInt($(this).attr('x'));
							player.y = parseInt($(this).attr('y'));
							//alert(player.x +", "+player.y);

							//loadMap(newMap);
							setMapWH(newMap);
							$("#output").append("<p>Now entering: "+newMap+"</p>");
							checkForEvents(currentMap);
						} 
					});
				}
			});
		});
	}

	function getHp(player) {
		$("#hp").text(player.hp);
	}

	function loadTome(tomeName) {
		var theTome = '';
		var english = new Array();
		var spanish = new Array();
		$.ajax("/apps/japanese/languageRPG/js/"+tomeName+".xml").done(function(xml) {
			$(xml).find("tome").each(function() {
					$(this).find("word").each(function() {
						//words.push();
						theTome = $(this).parent().attr("name");
						english.push($(this).find("english").text());
						spanish.push($(this).find("spanish").text());
					});
			})

			$("#tome").html("");
			$("#tome").append("<h2>"+theTome.toUpperCase()+"</h2> <button id='start-flashcards'>flashcards</button>");

			$("#output").append("<p>You opened the "+theTome+" tome.</p>");
			for(var i = 0; i < english.length; i++) {
				$("#tome").css("display","block");

				$("#tome").append("<p><b>"+english[i]+"</b>: <span style='color: red;'>"+spanish[i]+"</span></p>");
			}
		});
	}

	function checkForEvents(map) {
		$.ajax({
			url: "/apps/japanese/languageRPG/js/maps.xml"
		}).done(function(xml) {
			//Find all of our maps
			$(xml).find('map').each(function() {
				//If we find the map we want
				if($(this).find('title').text() == map) {
					//and if the map has events
					if($(this).find('events').length > 0) {
						//loop through its events
						$(this).find('event').each(function() {
							//match the x and y position
							if($(this).attr("x") == player.x && $(this).attr("y") == player.y) {
								handleEvents($(this).attr("title"));
							}
						});
					}
				}
			});
		});
	}

	function handleEvents(eventName) {
		inEvent = true;
		haltCommands();
		if($("#output p").length > 10) {
			$("#output p").first().remove();
		}
		if(eventName == "start_1") {
			$("#output").append("<p>You wake up in a bed, unsure of your surroundings. You have a pounding headache, and it appears to be just before dawn. Something feels off.</p>");
			$("#output").append("<p>You can <span style='color: red'>GO NORTH</span>.</p>");

			$("#submit-command").click(function() {
				var command = $("#command").val().split(" ");
				var method = command[0];
				var argument = command[1];
				if(method == "go") {
					if(argument == "north") {
						if(player.y > 0) {
							player.y -= 1;
							$("#output").append("<p>You <span style=\"color: red\">GO<span style=\"color: red\"> north.</p>");
							leaveEvent();
							handleEvents("start_2");
							return;
						}
					}
				}

				else {
					$("#output").append("<p>You can't do that right now.</p>");
				}

				updateScroll();
			});

		}

		if(eventName == "start_2") {
			$("#output").append("<p>In the living room, your mom is holding a book. She appears to be confused about it.</p>");
			$("#output").append("<p>You can <span style='color: red'>TALK</span> to her, or <span style='color: red'>LEAVE</span>.</p>");

			$("#submit-command").click(function() {
				var command = $("#command").val().split(" ");
				var method = command[0];
				if(method == "leave") {
					$("#output").append("<p>You <span style=\"color: red\">LEAVE</span>. Your room is to the south, and the front door is to the north. You can only <span style=\"color: red\">GO</span> north.</p>");
					setFlag("start_done");
					leaveEvent();
					return;
				}

				else if(method == "talk") {
					$("#output").append("<p>\"What's the matter, mom?\" you ask. You are surprised at the words that come out of your mouth. This is not the language you have been speaking your entire life.</p><p>\"That's what's the matter,\" your mom replies. \"We seem to have forgotten our native tongue.\"</p>")

					leaveEvent();
					handleEvents("start_3");
					return;
					
				}

				else {
					$("#output").append("<p>You can't do that right now.</p>");
				}

				updateScroll();
			});
		}

		if(eventName == "start_3") {
			$("#output").append("<p>\"What was our native language?\" You ask.</p>");
			$("#output").append("<p>\"Spanish,\" your mom replies. \"I just don't understand how this could have happened. Maybe the townsfolk have an idea.\" She sighs, pilfering through a book. It is written in a language you can no longer understand.</p>");
			

			setFlag("start_done");
			prevMap = currentMap;
			currentMap = 'town';
			enterMap(prevMap, currentMap);

			$("#output").append("<p>You are now outside of your house. Your house is straight north, the lake is to the south, and the market is to the east. You can <span style='color: red'>GO</span> north, east, south, or west. </p>");

			player.setPosition(2,2);
			leaveEvent();
			return;
		}

		if(eventName == "start_4") {
			if(checkFlag("start_done")) {
				leaveEvent();
				$("#output").append("<p>There's nothing to do here. You leave the house and head back out to the town. You realize that you should talk to the townsfolk.</p>");
				prevMap = currentMap;
				currentMap = 'town';
				enterMap(prevMap, currentMap);
			}
		}

		if(eventName == "town_1") {
			$("#people").append("<img src='http://rs1227.pbsrc.com/albums/ee425/scott_101-prince/white%20haired%20anime%20dudes/381396_large.jpg~c200' width='150'/>");
			$("#output").append("<p>You see a young man with white hair and green eyes.</p>");
			$("#output").append("<p>You can <span style=\"color: red\">TALK</span>, or <span style=\"color: red\">LEAVE</span>.</p>");
			$("#submit-command").click(function() {
				var command = $("#command").val().split(" ");
				var method = command[0];
				if(method == "leave") {
					$("#output").append("<p>Feeling socially awkward, you <span style=\"color: red\">LEAVE<span style=\"color: red\">.</p>");
					leaveEvent();
					return;
				}

				else if(method == "talk") {
					leaveEvent();
					handleEvents("town_1_1");
				}

				else {
					$("#output").append("<p>You can't do that right now.</p>");
				}

				updateScroll();
			});
		}

		if(eventName == "town_1_1") {
			if(player.has("animals") == false) {
				$("#output").append("<p>You <span style=\"color: red\">TALK</span> to the man. He smiles at you. \"I have this weird tome I don't know what to do with. There are pictures of animals in it. Do you want it?\"</p>");
				$("#output").append("<p>You can <span style=\"color: red\">TAKE </span>it, or <span style=\"color: red\">LEAVE</span>.</p>");
				$("#submit-command").click(function() {
					var command = $("#command").val().split(" ");
					var method = command[0];
					if(method == "leave") {
						$("#people").html("<h2>people</h2>");
						$("#output").append("<p>Feeling socially awkward, you <span style=\"color: red\">LEAVE<span style=\"color: red\">.</p>");
						leaveEvent();
						return true;
					}

					else if(method == "take") {
						player.add("animals", "tome");
						leaveEvent();
						handleEvents("town_1_2");
					}

					else {
						$("#output").append("<p>You can't do that right now.</p>");
					}

					updateScroll();
				});
			}

			else if(player.has("animals") == true) {
				$("#output").append("<p>You <span style=\"color: red\">TALK</span> to the man. \"How is the tome?\" he asks you. \"I hope it is helping you somehow.\"");
				$("#output").append("<p>You can <span style=\"color: red\">LEAVE</span>.</p>");
				$("#submit-command").click(function() {
					var command = $("#command").val().split(" ");
					var method = command[0];
					if(method == "leave") {
						$("#people").html("<h2>people</h2>");
						$("#output").append("<p>Having nothing much to say, you <span style=\"color: red\">LEAVE<span style=\"color: red\">.</p>");
						leaveEvent();
						return true;
					}

					else {
						$("#output").append("<p>You can't do that right now.</p>");
					}

					updateScroll();
				});
			}
		}

		if(eventName == "town_1_2") {
			$("#output").append("<p>You <span style=\"color: red\">TAKE</span> the tome. \"I hope it helps you somehow!\" he says.</p>");
			$("#output").append("<p>You can <span style=\"color: red\">LEAVE</span>.</p>");
			$("#submit-command").click(function() {
				var command = $("#command").val().split(" ");
				var method = command[0];
				if(method == "leave") {
					$("#people").html("<h2>people</h2>");
					$("#output").append("<p>You <span style=\"color: red\">LEAVE</span> with the <b>ANIMALS</b> tome.</p>");

					$("#output").append("<p>To use it, type \"use tome (NAME)\".</p>");
					leaveEvent();
					return true;
				}

				else {
					$("#output").append("<p>You can't do that right now.</p>");
				}

				updateScroll();
			});
		}

		if(eventName == "woods_e" || eventName == "town_e") {

		$("#battle-area").css("visibility","visible");
			enemy = new Enemy();
			enemy.attack(player);
		}
	}

	function updateScroll() {
		$("#output").animate({ scrollTop: $(this).height() });
	}

	function leaveEvent() {
		inEvent = false;
		haltCommands();
		getCommands();
	}

	function loadSaveData() {
	//An ajax call goes here which loads from a PHP database the save information
		leaveEvent();
		var save = $("#load").val();
		var xml = $.parseXML(save);
		prevMap = currentMap;
		currentMap = $(xml).find('map').text();
		enterMap(prevMap, currentMap);
		player.x = parseInt($(xml).find('x').text());
		player.y = parseInt($(xml).find('y').text());
		player.hp = parseInt($(xml).find('hp').text());
		player.name = $(xml).find('name').text();
		$(xml).find('item').each(function() {
			player.add($(this).attr("name"), $(this).attr("type"));
		});

		updateStats();
	}

	function writeSaveData() {
		$("textarea").val("<game><hp>"+player.hp+"</hp><name>"+player.name+"</name><map>"+currentMap+"</map><x>"+player.x+"</x><y>"+player.y+"</y><items>");

		for(var i = 0; i < player.inventory.length; i++) {
			jQ_append("textarea","<item name='"+player.inventory[i].name+"' type='"+player.inventory[i].type+"'></item>")
		}

		jQ_append("textarea","</items></game>");
	}

	function jQ_append(input, text){
	    var input_id = input;
	    $(input_id).val($(input_id).val() + text);
	}

	$("#save").click(function() {
		if(inEvent == false) {
			$('textarea').css("display","block");
			writeSaveData();
		}
	})

	$("#load-button").click(function() {
		if(inEvent == false) {
			loadSaveData();
			$(this).toggle();
			$("#load, #show-load").toggle();
		}
	});

	$("#show-load").click(function() {
		$("#load, #load-button").toggle();
		$(this).toggle();
	})

	function updateStats() {
		$("#hp").html(player.hp);
		$("#name").html(player.name);
	}

	function setFlag(flagName) {
		flags.push(flagName);
	}

	function checkFlag(flagName) {
		for(var i = 0; i < flags.length; i++) {
			if(flags[i] = flagName) {
				return true;
			}
		}
	}

	$("#command").focus(function() {
		$(this).val("");
	});

	$("#submit-command").click(function() {
		$("#command").text().focus();
	});

});

