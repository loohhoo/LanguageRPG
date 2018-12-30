$(document).ready(function() {
	//implement later to block safari users and tell them to install the app
	// http://stackoverflow.com/questions/5899783/detect-safari-using-jquery

	//Load in graphics
	var currentMap = 'town';
	var inEvent = false;
	var mapW = 2;
	var mapH = 2;
	var flags=[];

	var Player = function() {
		this.name = 'Leah';
		this.hp = 20;
		this.maxHp = 20;
		this.exp = 0;
		this.expToNextLevel = 20;
		this.mp = 20;
		this.maxMp = 20;
		this.x = 0;
		this.y = 0;
		this.level = 1;
		this.attackP = 5;
		this.defenseP = 5;
		this.inventory = [];
		this.flags = [];
		this.money = 0;
	};

	Player.prototype.levelUp = function() {
		if(this.exp >= this.expToNextLevel) {
			this.level++;
			this.attackP++;
			this.defenseP++;
			this.maxHp+=5;
			this.hp = this.maxHp;
			this.maxMp+=5;
			this.mp = this.maxMp;
		}
	};

	Player.prototype.calcExpToNext = function() {
		this.expToNextLevel = Math.floor(this.level * 3/2);
	};

	// Player.prototype.attack = function(target) {
	// 	target.hp -= this.attackP;
	// };

	Player.prototype.setPosition = function(x, y) {
		this.x = x;
		this.y = y;
	};

	Player.prototype.add = function(name, type, amount) {
		this.inventory.push(new Item(name, type, amount));
	}

	Player.prototype.setFlag = function(name) {
		this.flags.push(name);
	}

	Player.prototype.unsetFlag = function(name) {
		for(var i = 0; i < this.flags.length; i++) {
			if(this.flags[i] == name) {
				this.flags.splice(i,1);
			}
		}
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

	Player.prototype.hasFlag = function(name) {
		var hasFlag = false;
		for(var i = 0; i < this.flags.length; i++) {
			if(this.flags[i] == name) {
				hasFlag = true;
			}
		}

		return hasFlag;
	}

	Player.prototype.use = function(name) {
		for(var i = 0; i < this.inventory.length; i++) {
			if(this.inventory[i].name == name) {
				if(this.inventory[i].type == "tome") {
					loadTome(this.inventory[i].name);
				}

				if(this.inventory[i].type == "notebook") {
					loadNotebook(this.inventory[i].name);
				}
			}
		}
	}

	Player.prototype.flashcards = function(deckName) {
		$("#flashcards").toggle();
		var flashcard = new Flashcard(deckName);
		flashcard.showChoices();
	}
	// Player.prototype.listItems = function(type) {
	// 	for(var i = 0; i < this.inventory.length; i++) {
	// 		if(this.inventory[i].type == type) {
	// 			if(type == "tome") {	
	// 				$("#output").append("<p>Tome: "+this.inventory[i].name+"</p>");
	// 			}
	// 		}

	// 		if(type == "") {
	// 			$("#output").append("<p>"+this.inventory[i].type+": "+this.inventory[i].name+"</p>");
	// 		}
	// 	}
	// }

	var Flashcard = function(deckName) {
		this.question = "";
		this.choice1 = "";
		this.choice2 = "";
		this.choice3 = "";
		this.answer = "";
		this.deckName = deckName;
	}

	Flashcard.prototype.showChoices = function() {

		var This = this;
		alert(this.deckName);
		$.post("backend/fetch.php", { tomeName: This.deckName })
			.done(function(data){
			var arrays = jQuery.parseJSON(data);
			english = arrays.english;
			spanish = arrays.spanish;


			var numQs = english.length;
			var randQ = Math.floor(Math.random() * numQs);
			// Time to manipulate the data
			This.question = english[randQ];
			This.answer = spanish[randQ];

			$("#flashcards .question").text(This.question);

			$("#flashcards .submit-answer").click(function(e) {
				e.stopImmediatePropagation();
		 		e.preventDefault();
				if($("#flashcards .answer").val() == This.answer) {
					alert("correct!");
					This.showChoices();
				}

				else {
					alert("wrong :(");
					This.showChoices();
				}

			});
      	});

			//This segment of code handles inserting accents from buttons
		$("#acc-a").click(function(e) {
			e.stopImmediatePropagation();
		 	e.preventDefault();
			$("#flashcards .answer").val($("#flashcards .answer").val() + "á");
			$("#flashcards .answer").focus();
		});
		$("#acc-e").click(function(e) {
			e.stopImmediatePropagation();
		 	e.preventDefault();
			$("#flashcards .answer").val($("#flashcards .answer").val() + "é");
			$("#flashcards .answer").focus();
		});
		$("#acc-i").click(function(e) {
			e.stopImmediatePropagation();
		 	e.preventDefault();
			$("#flashcards .answer").val($("#flashcards .answer").val() + "í");
			$("#flashcards .answer").focus();
		});
		$("#acc-o").click(function(e) {
			e.stopImmediatePropagation();
		 	e.preventDefault();
			$("#flashcards .answer").val($("#flashcards .answer").val() + "ó");
			$("#flashcards .answer").focus();
		});
		$("#acc-u").click(function(e) {
			e.stopImmediatePropagation();
		 	e.preventDefault();
			$("#flashcards .answer").val($("#flashcards .answer").val() + "ú");
			$("#flashcards .answer").focus();
		});
		$("#acc-uu").click(function(e) {
			e.stopImmediatePropagation();
		 	e.preventDefault();
			$("#flashcards .answer").val($("#flashcards .answer").val() + "ü");
			$("#flashcards .answer").focus();
		});
		$("#acc-n").click(function(e) {
			e.stopImmediatePropagation();
		 	e.preventDefault();
			$("#flashcards .answer").val($("#flashcards .answer").val() + "ñ");
			$("#flashcards .answer").focus();
		});


	}

	var Enemy = function() {
		var creatures = ["Red Slime", "Green Slime", "Blue Slime", "Yellow Slime", "Grey Slime"];
		this.creature = Math.ceil(Math.random() * 5);
		this.name = creatures[this.creature-1];
		this.level = Math.ceil(Math.random() * 5);
		this.attackP = Math.floor(this.level * 3/2);
		this.hp = 20;
		this.maxHp = 20;
		this.defenseP = 0;
		this.category = "mc"

		$("#enemy_name").html("Level "+this.level+" " +this.name);
		$("#battle_enemy_sprite").attr("src", "/languageRPG/images/enemy/enemy"+this.creature+".png");
	};

	Enemy.prototype.attack = function(Player) {
		if(this.category == "mc") {
			this.question = new MultipleChoice();
			this.question.showChoices(Player);
		}	
	};

	Enemy.prototype.die = function() {

	}

	Enemy.prototype.takeDamage = function() {
		this.hp -= player.attackP;
		$("#enemy_stats_health").html(this.hp);
		if(this.hp <= 0) {
			player.exp+= Math.ceil(this.level*3/2);
			leaveEvent();
			$("#battle-area").css("visibility","hidden");
		}

		else if (this.hp > 0) {
			this.attack(player);
		}		
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
			if(player.hp <= 0) {
				$("#output").append("<h2>You died.</h2>");
				enterMap('start','town');
			}
			enemy.attack(player);
			updateStats();
		}

	}

	MultipleChoice.prototype.showChoices = function(Player) {
		// Load in a question
		$.getJSON("/languageRPG/js/"+currentMap+".json", function(data) {
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
				if(enemy.hp <= 0) {
					$("#output").append("<p>You <span style='color: red;'>DEFEAT</span> enemy "+enemy.name+".</p>");
				}
				else {
					$("#output").append("<p>You <span style='color: red;'>ATTACK</span> enemy "+enemy.name+".</p>");
				}
				
			}

			else  {
				_this.clear(false);
				alert("wrong!");
			}

		});

	}

	var Item = function(name, type, amount) {
		this.name = name;
		this.type = type;		// weapon (amount = 1), spell, armor, tome
		this.amount = amount; 
	};

	var player = new Player();
	var enemy;
	//player.add("sword");
	//player.add("spell");
	// player.add("animals","tome", 1);
	// player.add("calendar","tome", 1);
	// player.add("family","tome", 1);
	// player.add("numbers","tome", 1);
	// player.add("verbs1","tome",1);
	// player.add("verbs2","tome",1);
	loadSaveData();
	getCommands();
	//loadNotebook("Present Verbs 1", true);
	

	function openInventory(inBattle) {
		
		if(inBattle == true && player.mp > 0) {
			//clear out the inventory in case there was a change
			$("#inventory-box").html("").css("display","block");

			$("#inventory-box").append("<button class='close-inventory'>close</button> <h2>Inventory</h2> ");
			//output the inventory
			for(var i = 0; i < player.inventory.length; i++) {

				$("#inventory-box").append("<div class='item'><img class='item-type "+player.inventory[i].type+"' src='/languageRPG/images/"+player.inventory[i].type+".png' /><br /><span class='item-name'>"+player.inventory[i].name+"</span></div>");

			}

			$(".item-type").click(function() {
				if($(this).hasClass('tome')) {
					
					if(player.mp > 0) {
						loadTome($(this).parent().find('.item-name').text(), inBattle);
						player.mp -= 5;
						updateStats();
					}

					else {
						$("#output").append("<p>You're out of MP!</p>");
					}
				}

				else if($(this).hasClass('notebook')) {
					
					if(player.mp > 0) {
						loadNotebook($(this).parent().find('.item-name').text(), inBattle);
						player.mp -= 5;
						updateStats();
					}

					else {
						$("#output").append("<p>You're out of MP!</p>");
					}
				}
			});
			//$("#inventory-box").toggle();

			$(".close-inventory").click(function() {
				$("#inventory-box").html("").css("display","none");
			});

		}

		if(inBattle == false) {
			//clear out the inventory in case there was a change
			$("#inventory-box").html("").css("display","block");

			$("#inventory-box").append("<h2>Inventory</h2> <button class='close-inventory'>close</button>");
			//output the inventory
			for(var i = 0; i < player.inventory.length; i++) {

				$("#inventory-box").append("<div class='item'><img class='item-type "+player.inventory[i].type+"' src='/languageRPG/images/"+player.inventory[i].type+".png' /><br /><span class='item-name'>"+player.inventory[i].name+"</span></div>");

			}

			$(".item-type").click(function() {
				if($(this).hasClass('tome')) {
					loadTome($(this).parent().find('.item-name').text(), inBattle);
				}

				else if($(this).hasClass('notebook')) {
					loadNotebook($(this).parent().find('.item-name').text(), inBattle);
				}
			});
			//$("#inventory-box").toggle();

			$(".close-inventory").click(function() {
				$("#inventory-box").css("display","none");
			});
		}



	}


	//Aight fam, this about to be a long function for getting commands :'D
	function getCommands() {
		$("#inventory").click(function() {
			openInventory(false);
		});

		$("button.go-north").click(function() {
			if(player.y > 0) {
				$("#output").append("<p>You <span style=\"color: red\">GO</span> north.</p>");
				player.y -= 1;

				if(inEvent == true) {
					inEvent = false;
				}
			}

			else {
				//$("#output").append("<p>You tried to go north, but hit a wall.</p>");
			}
			
			$("#position").html("<h2>"+currentMap.toUpperCase()+"</h2><p>Position: "+player.x+", "+player.y+"</p>");
			checkMap(player.x, player.y, currentMap);
			checkForEvents(currentMap);
			updateScroll();
		});

		$("button.go-east").click(function() {
			if(player.x < mapW) {
				$("#output").append("<p>You <span style=\"color: red\">GO</span> east.</p>");
				player.x += 1;

				if(inEvent == true) {
					inEvent = false;
				}
			}

			else {
				//$("#output").append("<p>You tried to go east, but hit a wall.</p>");
			}


			$("#position").html("<h2>"+currentMap.toUpperCase()+"</h2><p>Position: "+player.x+", "+player.y+"</p>");
			checkMap(player.x, player.y, currentMap);
			checkForEvents(currentMap);
			updateScroll();
		
		});

		$("button.go-south").click(function() {
			if(player.y < mapH) {
				$("#output").append("<p>You <span style=\"color: red\">GO</span> south.</p>");
				player.y += 1;

				if(inEvent == true) {
					inEvent = false;
				}
			}

			else {
				//$("#output").append("<p>You tried to go south, but hit a wall.</p>");
			}
			
			$("#position").html("<h2>"+currentMap.toUpperCase()+"</h2><p>Position: "+player.x+", "+player.y+"</p>");
			checkMap(player.x, player.y, currentMap);
			checkForEvents(currentMap);
			updateScroll();
		});

		$("button.go-west").click(function() {
			if(player.x > 0) {
				$("#output").append("<p>You <span style=\"color: red\">GO</span> west.</p>");
				player.x -= 1;

				if(inEvent == true) {
					inEvent = false;
				}
			}

			else {
				//$("#output").append("<p>You tried to go west, but hit a wall.</p>");
			}


			$("#position").html("<h2>"+currentMap.toUpperCase()+"</h2><p>Position: "+player.x+", "+player.y+"</p>");
			checkMap(player.x, player.y, currentMap);
			checkForEvents(currentMap);
			updateScroll();
		});
			

	}

	function haltCommands() {
		$(".go-north, .go-east, .go-south, .go-west, .leave, .take, .talk").unbind();
	}

	// function loadMap(mapName) {
	// 	var mapArray = []
	// 	$.ajax({
	// 		url: "/languageRPG/js/maps.xml"
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
		var isEvent = false;
		$.ajax({
			url: "/languageRPG/js/maps.xml"
		}).done(function(xml) {
			$(xml).find('map').each(function() {
				if($(this).find('title').text() == map) {
					$(this).find('events').find('event').each(function() {
						if($(this).attr('x') == player.x && $(this).attr('y') == player.y) {
							isEvent = true;
							return;
						}
					});
					$(this).find('exits').find('exit').each(function() {
						if($(this).attr('x') == player.x && $(this).attr('y') == player.y && isEvent == false) {
							
							var newMap = $(this).attr('title');
							var prevMap = currentMap;
							currentMap = newMap;
							enterMap(prevMap, currentMap, false);
							
						}
					});
				}
			});
		});
	}

	function setMapWH(title) {
		title = title;
		$.ajax({
			url: "/languageRPG/js/maps.xml"
		}).done(function(xml) {
			$(xml).find('map').each(function() {
				if($(this).find('title').text() == title) {
					mapW = parseInt($(this).find('dimensions').find('w').text());
					mapH = parseInt($(this).find('dimensions').find('h').text());
				}
			})
		});
	}

	function enterMap(prevMap, newMap, load) {

		$.ajax({
			url: "/languageRPG/js/maps.xml"
		}).done(function(xml) {
			$(xml).find('map').each(function() {
				if($(this).find('title').text() == newMap) {
					$(this).find('position').each(function() {
						if($(this).attr('from') == prevMap) {
							
							//alert(player.x +", "+player.y);

							//loadMap(newMap);

							if(load == false) {
								player.x = parseInt($(this).attr('x'));
								player.y = parseInt($(this).attr('y'));
							}

							setMapWH(newMap);
							$("#position").html("<h2>"+newMap.toUpperCase()+"</h2><p>Position: "+player.x+", "+player.y+"</p>");
							updateScroll();
							checkForEvents(currentMap);

							updateMap();
						} 
					});
				}
			});
		});
	}


	function loadNotebook(notebookName, inBattle) {
		$.post("backend/fetch.php", { requestType: "notebookHtml", notebookName: notebookName })
          .done(function(data){ 
          	notebookHtml = data; 
          	$("#tome").html("");
			$("#tome").append("<button class='close-tome'>close</button><br />"+data);
			$("#tome").css("display","block");
			$(".close-tome").click(function() {
				$("#tome").css("display","none");
			});
          });

	}

	function loadTome(tomeName, inBattle) {
		var theTome = '';
		var english = new Array();
		var spanish = new Array();
		theTome = tomeName;
      
        $.post("backend/fetch.php", { requestType: "tomeWords", tomeName: theTome })
          .done(function(data){
          var arrays = jQuery.parseJSON(data);
          english = arrays.english;
          spanish = arrays.spanish;
            
            

			$("#tome").html("");
			$("#tome").append("<h2>"+theTome.toUpperCase()+"</h2> <button id='start-flashcards' class='"+tomeName+"'>flashcards</button><button class='close-tome'>close</button>");
			
			if(inBattle == true) {
				$("#start-flashcards").css("display", "none");
			}

			else {
				$("#start-flashcards").css("display", "inline");
			}
			

			$("#start-flashcards").click(function() {
				player.flashcards($(this).attr("class"));
			});
			//$("#output").append("<p>You opened the "+theTome+" tome.</p>");
			for(var i = 0; i < english.length; i++) {
				$("#tome").css("display","block");

				$("#tome").append("<p><b>"+english[i]+"</b>: <span style='color: red;'>"+spanish[i]+"</span></p>");
			}

			$(".close-tome").click(function() {
				$("#tome").css("display","none");
			});
		});
	}	

	// function loadTome(tomeName) {
	// 	var theTome = '';
	// 	var english = new Array();
	// 	var spanish = new Array();
	// 	$.ajax("/languageRPG/js/"+tomeName+".xml").done(function(xml) {
	// 		$(xml).find("tome").each(function() {
	// 				$(this).find("word").each(function() {
	// 					//words.push();
	// 					theTome = $(this).parent().attr("name");
	// 					english.push($(this).find("english").text());
	// 					spanish.push($(this).find("spanish").text());
	// 				});
	// 		})

	// 		$("#tome").html("");
	// 		$("#tome").append("<h2>"+theTome.toUpperCase()+"</h2><button class='close-tome'>close</button>");

	// 		//$("#output").append("<p>You opened the "+theTome+" tome.</p>");
	// 		for(var i = 0; i < english.length; i++) {
	// 			$("#tome").css("display","block");

	// 			$("#tome").append("<p><b>"+english[i]+"</b>: <span style='color: red;'>"+spanish[i]+"</span></p>");
	// 		}

	// 		$(".close-tome").click(function() {
	// 			$("#tome").css("display","none");
	// 		});
	// 	});
	// }

	function checkForEvents(map) {
		$.ajax({
			url: "/languageRPG/js/maps.xml"
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

	
	function enterShop(shopName) {
  		var itemNameArray;
        var itemAmountArray;
        var itemTypeArray;
        var itemCostArray;
           
    	//load the shop's inventory by shop name.
       	$.post("loadShop.php", { shopName: shopName }).done(function(data) {
	        var arrays = jQuery.parseJSON(data);
	        itemNameArray = arrays.ItemName;
	        itemTypeArray = arrays.itemType;
	        itemCostArray = arrays.itemCost;
         
         	//loop through all the items a shop has
	        for(var i = 0; i < itemNameArray.length; i++) {
	        	$("#output").append("<p class='"+itemNameArray[i]+"'>"+itemTypeArray[i]+": "+itemNameArray[i]+"</p>");
	        	
	        	$("#"+itemNameArray[i]).click(function() {
	            	//if the player has enough money
            	if(player.money >= itemCostArray[i]) {
	               
	               	//if the item is a tome / notebook / weapon
	               	if(itemTypeArray[i] == "tome" || itemTypeArray[i] == "notebook" || itemTypeArray[i] == "weapon") {
	                	//if the player doesn't have it already
	                	if(!player.has(itemNameArray[i])) {
	               			player.add(itemNameArray[i], itemTypeArray[i], 1);
	               			player.money-=itemCostArray[i];
	                 		$("#output").append("<p>You bought "+itemNameArray[i].toUpperCase()+".</p>");
	               		}
	               	 //if the player does have it already
	               		else {
	                 		$("#output").append("<p>\"Don't you have this item already?\" the shopkeeper sternly asks.</p>");
	               		}
	                }
	               
	             //if the item is something else, then we don't care if the player already has it or not
	               else {
               			player.add(itemNameArray[i], itemTypeArray[i], 1);
               			player.money-=itemCostArray[i];
                 		$("#output").append("<p>You bought "+itemNameArray[i].toUpperCase()+".</p>");
	               }
	             }
	             //the player has no money and can't buy anything
	             else {
	               $("#output").append("<p>\"Come back when you have money,\" the shopkeeper gruffly says.</p>");
	             }
	             //return to the start of this interaction

				updateScroll();
	            updateStats();
	         	enterShop("bookstore");
	           });
	         }
    	});
	}

	function handleEvents(eventName) {
		inEvent = true;
		haltCommands();
		

		if(eventName == "town_1") {
			if(player.hasFlag("start_game") == false) {
				$("#output").append("<p>The wizard Mutas was once the greatest linguaphile in all of Loqueia. Besides the language in Loqueia, he often would travel to other lands to learn their languages as well. A true polyglot, he impressed all those dwelling in Loqueia, including the king.</p><p>One day a thought occurred to him. The real ruler of the land is language not the king. It keeps the people together and makes it possible to maintain civilization. At once he set upon the Loqueia Stone, the obelisk that gave the kingdom its language ages ago.</p><p>With a few whispered words he broke the obelisk into five stone shards and scattered them across the land, taking the people’s language. With the kingdom in a state of confusion Mutas could introduce his own language and rule over the Loqueians as - according to him - someone with his knowledge rightfully should.</p>");
			
				player.setFlag("start_game");
				updateScroll();
				leaveEvent();
				return;
			}

			else {
				leaveEvent();
				return;
			}
		}

		if(eventName == "town_2") {
			$("#people").append("<img src='http://rs1227.pbsrc.com/albums/ee425/scott_101-prince/white%20haired%20anime%20dudes/381396_large.jpg~c200' width='150'/>");
			$("#output").append("<p>You see a young man with white hair and green eyes.</p>");
			$("#output").append("<p>You can <span style=\"color: red\" class='command talk'>TALK</span>, or <span style=\"color: red\" class='command leave'>LEAVE</span>.</p>");


				$(".leave").click(function() {
					$("#people").html("<h2>people</h2>");
					$("#output").append("<p>Feeling socially awkward, you <span style=\"color: red\">LEAVE<span style=\"color: red\">.</p>");
					
					updateScroll();
					leaveEvent();
					return;
				});

				$(".talk").click(function() {

					updateScroll();
					leaveEvent();
					handleEvents("town_1_1");
				});

		}

		if(eventName == "town_1_1") {
			if(player.has("animals") == false) {
				$("#output").append("<p>You <span style=\"color: red\">TALK</span> to the man. He smiles at you. \"I have this weird tome I don't know what to do with. There are pictures of animals in it. Do you want it?\"</p>");
				$("#output").append("<p>You can <span style=\"color: red\" class='command take'>TAKE </span>it, or <span style=\"color: red\" class='command leave'>LEAVE</span>.</p>");
				
				$(".leave").click(function() {
					$("#people").html("<h2>people</h2>");
					$("#output").append("<p>Feeling socially awkward, you <span style=\"color: red\">LEAVE<span style=\"color: red\">.</p>");
					updateScroll();
					leaveEvent();
					return true;
				});

				$(".take").click(function() {
					player.add("animals", "tome", 1);
					updateScroll();
					leaveEvent();
					handleEvents("town_1_2");
				});
			}

			else if(player.has("animals") == true) {
				$("#output").append("<p>You <span style=\"color: red\">TALK</span> to the man. \"How is the tome?\" he asks you. \"I hope it is helping you somehow.\"");
				$("#output").append("<p>You can <span style=\"color: red\" class='command leave'>LEAVE</span>.</p>");
				$(".leave").click(function() {
					$("#people").html("<h2>people</h2>");
					$("#output").append("<p>Having little to say, you <span style=\"color: red\">LEAVE<span style=\"color: red\">.</p>");
					
					updateScroll();
					leaveEvent();
					return true;
				});
			}
		}

		if(eventName == "town_1_2") {
			$("#output").append("<p>You <span style=\"color: red\">TAKE</span> the tome. \"I hope it helps you somehow!\" he says.</p>");
			$("#output").append("<p>You can <span style=\"color: red\" class='command leave'>LEAVE</span>.</p>");
			$(".leave").click(function() {
				$("#people").html("<h2>people</h2>");
				$("#output").append("<p>You <span style=\"color: red\">LEAVE</span> with the <b>ANIMALS</b> tome.</p>");

				$("#output").append("<p>To use it, type \"use tome (NAME)\".</p>");
				updateScroll();
				leaveEvent();
				return true;
			});
		}

		if(eventName == "market_1") {
			if(player.has("marine") == false) {
				$("#output").append("<p>A woman with a young girl, probably 5 years old, looks at you. \"This book used to be full of pictures of sea creatures, I would read it to her every night. But now it is no use to me. With the monsters at the lake, this may be helpful for you! Here, take it.\"</p>");
				$("#output").append("<p>You <span style=\"color: red\" class='command take'>TAKE </span>it.</p>");
				player.add("marine","tome",1);
				leaveEvent();
				updateScroll();
				return true;
			}

			else if(player.has("marine") == true) {
				leaveEvent();
				updateScroll();
				return true;
			}
		}

		if(eventName == "market_bookstore") {
			$("#output").append("<p>You are engulfed in the smell of dusty tomes. Stacked around the shopkeeper are piles of ancient looking grimoires. From behind thick rimmed glasses, eyes as sharp as talons size you up. \"Looking for some light reading?\"</p>");

			$("#output").append("<p>You can <span style=\"color: red\" class='command talk'>TALK</span> or <span style=\"color: red\" class='command leave'>LEAVE</span>.</p>");
		   	$(".leave").click(function() {
						player.setPosition(4, 5);
						$("#output").append("<p>You <span style=\"color: red\" class='command leave'>LEAVE</span>.</p>");
						$("#position").html("<h2>"+currentMap.toUpperCase()+"</h2><p>Position: "+player.x+", "+player.y+"</p>");
						leaveEvent();
						return;
					});

			$(".talk").click(function() {
		      	enterShop("bookstore");
		    });

			updateScroll();
		}

		if(eventName == "market_potionshop") {
			$("#output").append("<p>A large cauldron spewing noxious fumes greets you as you enter the shop. Two women busily tend their brew, one stirs while the other throws odds and ends in at random. The one stirring glances your way. \"How can we be of assistance deary?\"</p>");

			$("#output").append("<p>You can <span style=\"color: red\" class='command talk'>TALK</span> or <span style=\"color: red\" class='command leave'>LEAVE</span>.</p>");
		   	$(".leave").click(function() {
						player.setPosition(2, 5);
						$("#output").append("<p>You <span style=\"color: red\" class='command leave'>LEAVE</span>.</p>");
						$("#position").html("<h2>"+currentMap.toUpperCase()+"</h2><p>Position: "+player.x+", "+player.y+"</p>");
						leaveEvent();
						return;
					});

			$(".talk").click(function() {
		      	enterShop("potionshop");
		    });

			updateScroll();
		}

		if(eventName == "market_weaponshop") {
			$("#output").append("<p>As you approach the shop, the ringing sound of a hammer hitting an anvil can be heard. As you approach the counter the blacksmith's assistant turns and greets you gruffly. \"What do you need?\"</p>");

			$("#output").append("<p>You can <span style=\"color: red\" class='command talk'>TALK</span> or <span style=\"color: red\" class='command leave'>LEAVE</span>.</p>");
		   	$(".leave").click(function() {
						player.setPosition(6, 5);
						$("#output").append("<p>You <span style=\"color: red\" class='command leave'>LEAVE</span>.</p>");
						$("#position").html("<h2>"+currentMap.toUpperCase()+"</h2><p>Position: "+player.x+", "+player.y+"</p>");
						leaveEvent();
						return;
					});

			$(".talk").click(function() {
		      	enterShop("weaponshop");
		    });


			updateScroll();
		}

		if(eventName == "market_potionstore") {
			//enterShop("potionstore");
		}

		if(eventName == "market_weaponstore") {
			//enterShop("weaponstore");
		}

		if(eventName == "woods_e" || eventName == "town_e") {
			$("#battle-area").css("visibility","visible");
			enemy = new Enemy();
			$("#enemy_stats_health").html(enemy.hp);
			$("#enemy_stats_maxhealth").html(enemy.maxHp);
			enemy.attack(player);
			$("#inventory").click(function() {
				openInventory(true);
			});
		}
	}

	function updateScroll() {
		$("#output").animate({ scrollTop: $(this).height() });
	}

	function leaveEvent() {
		haltCommands();
		updateStats();
		getCommands();
		updateScroll();
	}

	function loadSaveData() {
	//An ajax call goes here which loads from a PHP database the save information
		var save;
		$.post("backend/saveHandler.php", { requestType: "getSaveData"}) 
		.done(function(data) {
			var save = jQuery.parseJSON(data);
			currentMap = currentMap;
			enterMap('', currentMap, true);
			player.x = parseInt(save.currentXPosition);
			player.y = parseInt(save.currentYPosition);
			player.hp = parseInt(save.hp);
			player.maxHp = parseInt(save.maxHp);
			player.exp = parseInt(save.xp);
			player.expToNextLevel = parseInt(save.xpToNextLevel);
			player.name = "Leah"; //should be save.playerName or something
			player.level = parseInt(save.level);
			player.money = parseInt(save.money);
			player.attackP = parseInt(save.attackPoints);
			player.defenseP = parseInt(save.defensePoints);
			

			$.post("backend/saveHandler.php", {requestType: "getPlayerInventory"})
				.done(function(data) {
					var inventory = jQuery.parseJSON(data);
					for(var i = 0; i < inventory.length; i++) {
						player.add(inventory[i].itemName, inventory[i].itemType, inventory.quantity[i]);
					}
				});

			updateStats();
			checkMap(player.x, player.y, currentMap);

		});

	}

	function writeSaveData() {
		var save = [];

		save.level = "town";//currentMap;
		save.currentXPosition = 1;//player.x;
		save.currentYPosition = 1;//player.y;
		save.hp = 20;//player.hp;
		save.maxHp = 20;//player.maxHp;
		save.xp = 0;//player.exp;
		save.xpToNextLevel = 20;// player.expToNextLevel;
		//save.name = player.name;
		save.level = 1;//player.level;
		save.money = 0;//player.money;
		save.attackPoints = 5;//player.attackP;
		save.defensePoints = 5;//player.defenseP;

		// save+= "<game><hp>"+player.hp+"</hp><maxhp>"+player.maxHp+"</maxhp><mp>"+player.mp+"</mp><maxmp>"+player.maxMp+"</maxmp><exp>"+player.exp+"</exp><exptonextlevel>"+player.expToNextLevel+"</exptonextlevel><attackp>"+player.attackP+"</attackp><defensep>"+player.defenseP+"</defensep><name>"+player.name+"</name><level>"+player.level+"</level><map>"+currentMap+"</map><x>"+player.x+"</x><y>"+player.y+"</y><money>"+player.money+"</money><items>";

		// for(var i = 0; i < player.inventory.length; i++) {
		// 	save+="<item name='"+player.inventory[i].name+"' type='"+player.inventory[i].type+"' amount='"+player.inventory[i].amount+"'></item>";
		// }


		// save+="</items><flags>";

		// for(var i = 0; i < player.flags.length; i++) {
		// 	save+="<flag>"+player.flags[i]+"</flag>";
		// }

		// save+="</flags></game>";

		$.post("backend/saveHandler.php", { requestType: "uploadSaveData", hp: save.hp, maxHp: save.maxHp, 
			xp: save.xp, xpToNextLevel: save.xpToNextLevel, mp: save.mp, maxMp: save.maxMp, level: save.level,
			money: save.money, currentXPosition: save.currentXPosition, currentYPosition: save.currentYPosition,
			attackPoints: save.attackPoints, defensePoints: save.defensePoints, currentMap: currentMap})
		.done(function(data){
			$("#output").append("<p>Your game was successfully saved.</p>");
		});
	}

	$(window).bind('beforeunload', function(){
	    if(confirm()){
	        writeSaveData();
	    }
	    else{
	        return false;
	    }
	});

	function jQ_append(input, text){
	    var input_id = input;
	    $(input_id).val($(input_id).val() + text);
	}

	$("#save").click(function() {
		if(inEvent == false) {
			writeSaveData();
		}
	})

	$("#load").click(function() {
		if(inEvent == false) {
			loadSaveData();
		}
	});

	$("#clear").click(function() {
		$("#output").html("");
	})

	function updateStats() {
		if(player.exp >= player.expToNextLevel) {
			player.levelUp();
			player.exp = 0;
			player.expToNextLevel+=30;
		}
		$("#hp").html(player.hp);
		$("#maxhp").html(player.maxHp);
		$("#name").html(player.name);
		$("#mp").html(player.mp);
		$("#maxmp").html(player.maxMp);
		
		$("#level").html(player.level);
		$("#exp").html(player.exp);
		$("#maxexp").html(player.expToNextLevel);
		$("#money").html(player.money);
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

	function updateMap() {
		// $("#map").append("<table>");
		// for(var i = 0; i < mapH; i++) {
		// 	$("#map").append("<tr class='r"+i+"'>");
		// 	for(var j = 0; j < mapW; j++) {
		// 		$("#map").append("<tr class='c"+j+"'>&nbsp;</tr>");
		// 	}
		// 	$("#map").append("</tr>");
		// }
		// $("#map").append("</table>");
	}



	$("#stop-flashcards").click(function() {
		$("#flashcards").toggle();
	});

});

