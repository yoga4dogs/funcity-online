<?php

//areana for area select and fighting monsters

function arena() {
	global $database;
	global $player;
	global $inventory;
	global $fish;
	global $self_link; 
	
	$current_page =  $_SERVER["REQUEST_URI"];
	
	$result = $database->query("SELECT * FROM `equipment` ORDER BY `purchase_cost`");
	$equips = array();
	while($equip = $database->fetch($result)) {
		$equips[$equip['id']] = $equip;
	}
	$result2 = $database->query("SELECT * FROM `attacks` ORDER BY `purchase_cost`");
	$attacks = array();
	while($attack = $database->fetch($result2)) {
		$attacks[$attack['id']] = $attack;
	}
	
	if(empty($player->equip)) {
		//no weapon or dead message
		echo "<div style='
			width: 600px; 
			height: 100px; 
			margin-left: auto;
			margin-right: auto;
			margin-top: 60px;
			background-image: url(./images/skin.jpg);
			background-size: 600px 600px;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'><br /><center><h4>You should buy a weapon at the <a href='?page=weaponShop'>PAWN SHOP</a> or equip one on your <a href='?page=profile'>PROFILE</a> first.</h4></center></div>";
	} elseif ($player->health <= 0) {
		$player->incombat = 0;
		echo "<div style='
			width: 600px; 
			height: 100px; 
			margin-left: auto;
			margin-right: auto;
			margin-top: 60px;
			background-image: url(./images/skin.jpg);
			background-size: 600px 600px;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'><br /><center><h4>You are <a href='?page=bar'>DEAD</a>.</h4></center></div>";
	} else {
		//proceed
		require('monster.php');
		
		require('mapchoice.php');
		
		
		//statbox
		if($player->incombat != 1) {
			require('statbox.php');
		}
		
		
		//fight opponent
		if(isset($_SESSION['monster_id'])) {
			
			if(!isset($monster)) {
				$monster= new Monster($_SESSION['monster_id'], $database);
			}
			
			$winner = battle($player, $monster);
			
			//item drop set
			$resultinv2 = $database->query("SELECT * FROM `itemDB` WHERE `id` = '{$monster->item_drop}'");
			$item = $resultinv2->fetch_assoc();	
		
			if($winner) {
				
				$player->turns -= 1;
				//$player->drunk -= 1;
				if($player->turns <= 0) {
					$player->turns = 0;
				}
				if($player->drunk <= 0) {
					$player->drunk = 0;
				}
				$player->turns_played +=1;
					
				$_SESSION['monsterDebuff'] = 1;
				$player->incombat = 0;
				$player->round_damage += $opponent_damage;
				
				if($winner == 'player') {
					
					//money and xp formulas
					$money_gain = round((($monster->level * $monster->level) * (($monster->level / 2) / $player->level*  2)) * 1.33, 0) + 5;
					$exp_gain = round((($monster->level) * (($monster->level * (4 / 3)) / ($player->level / 2))), 0) + 5;
					
					//smart
					if($player->acc == 7) {
						$exp_gain *= 1.2;
					}
					if($_SESSION['playerBuff'] == 1) {
						$exp_gain *= 2;
					}
					
					//sandals flip
					if($player->feet == 18) {
						$money_gain *= 1.1;
						$money_gain = round($money_gain, 0);
					}
					$player->money += $money_gain;
					
					if($player->acc == 9) {
						$can_roll = mt_rand(1,4);
						if($can_roll == 1) {
							$inventory->item[3]['qty'] += 1;
							$inventory->update();
							//$database->query("UPDATE `inventory` SET `3` = `3` + 1 WHERE `id` = '{$player->id}'");
						}
					}
					
					$player->exp += $exp_gain;
					$player->exp_spend += $exp_gain;
					
					$beer_mult = 0.5;
					if($player->head == 3) {
						$player->health += (round($player->round_damage * $beer_mult));
					}
					if($player->health >=100) {
						$player->health = 100;
					}
					
					//item drop roll
					$hole_roll = mt_rand(1, 1000);
					if($hole_roll == 1) {
						if(!isset($player->attacks[22])) {
							$player->attacks[22] = array();
							$hole_get = 1;
						}
					} elseif($monster->item_drop > 0 ){
						if($monster->item_drop_type == 'e') {
							if(!isset($player->equipment[$monster->item_drop])) {
								$item_roll = mt_rand(1, 1);
								if($item_roll == 1) {
									$get = 1;
									$player->equipment[$monster->item_drop] = array();
								}
							}
						}
						if($monster->item_drop_type == 'i') {
								$item_roll = mt_rand(1, $monster->item_drop_rate);
								if($item_roll == 1) {
									$get = 1;
									$inventory->item[$monster->item_drop]['qty'] += 1;
									$inventory->update();
									//$database->query("UPDATE `inventory` SET `{$monster->item_drop}` = `{$monster->item_drop}` + 1 WHERE `id` = '{$player->id}'");
								}
						}
						if($monster->item_drop_type == 'a') {
								$item_roll = mt_rand(1, $monster->item_drop_rate);
								if($item_roll == 1) {
									if(!isset($player->attacks[$monster->item_drop])) {
										$get = 1;
										$player->attacks[$monster->item_drop] = array();
										$player->update();
									}
								}
						}
					}
					
					if($monster->id == 26) {
						$player->robocop_count +=1;
					}
					if($monster->id == 39) {
						$player->killfucker_count +=1;
					}
					
					echo "<div style='
						position: absolute; 
						width: 540px; 
						padding: 20px;
						margin-top: 350px; 
						margin-left: 50px;
						translate: 0px 50px;
						background-image: url(./images/skin.jpg);
						background-size: 600px 600px;
						box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
							<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti; translate: 0px -20px;'><h2 style='
								color:White; 
								font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
								You win!</h2>
								You find <b>{$money_gain} FUNCOINS</b>. ";
								if($player->acc == 7) {
									echo "You learn more from that battle than usual... ";
								}	elseif ($_SESSION['playerBuff'] == 1) {
									echo "You learn way more from that battle than usual thanks to the Catfish with an IQ of 180... ";
								}
								echo "You gain <b>" . number_format($exp_gain). " XP</b>!";
								echo "<br />";
								if($can_roll == 1) {
									echo "<br />You pick up an empty can and toss it in your Garbage Bag.<br/>";
								}
								//item drops
								if($hole_get == 1) {
									echo "<br />You find a <b>Portable Hole</b>!<br/>";
								} elseif($item_roll == 1) {
									if($monster->item_drop_type == 'e') {
										if ($get == 1) {
										echo "<br />You find <span title='{$equips[$monster->item_drop]['stat']} (DR: {$equips[$monster->item_drop]['power']})'><b>".$equips[$monster->item_drop]['name'].".</b></span><br/>";
										}
									} elseif($monster->item_drop_type == 'i') {
										if ($get == 1) {
											//come back
											$description = str_replace("'", "&#39;", $inventory->item[$monster->item_drop]['desc']);
										echo "<br />You find <span title='{$description}'><b>{$inventory->item[$monster->item_drop]['name']}</b>.</span><br/>";
										}
									} elseif($monster->item_drop_type == 'a') {
										if ($get == 1) {
											echo "<br />You find <span><b>".$attacks[$monster->item_drop]['name'].".</b></span><br/>";
										}
									}
								}
					if($player->head == 3 && $player->round_damage > 0) {
						echo "You take a drink from your beer helmet and recover <b>" . (round($player->round_damage * $beer_mult)) . " HP</b>! (<i>{$player->health}/{$player->max_health}</i>)<br/>";
					}
					//bounty hunter check
					if($monster->id == $player->target_id) {
						$player->target_count -= 1;
						if($player->target_count == 0) {
							echo "You hear the faint buzz of radio static before it abruptly cuts off...<br />";
						} elseif($player->target_count > 0) {
							echo "You hear the faint buzz of radio static...<br />";
						}
					}
					if($player->acc == 19) {
						$time_roll = mt_rand(1,10);
						if($time_roll == 1) {
							$player->health -= 5;
							if($player->health <= 0) {
								$player->health = 1;
							}
							$player->turns += 1;
							echo "<br />Your Broken Time Funnel lets out a few short beeps before letting loose a fountain of sparks, shocking you for <b>5 damage</b> and sending you several minutes back in time!<br />";
						}
					}
					if($player->head == 21) {
						if(date('md') == 1031) {
							$candy_roll = mt_rand(1,2);
						} else {
							$candy_roll = mt_rand(1,20);
						}
						$type_roll = mt_rand(1,9);
						$candy_type = array("a small pile of candy corn", "a couple Tootsie Rolls", "an entire Toblerone", "a whole candy apple", "half of a Snickers", "a pair of wax lips", "a Chicago-style hotdog", "a cherry Dum Dum");
						if($candy_roll == 1) {
							echo "You start to gag and cough uncontrollably before vomiting up ";
							if ($type_roll == 9) {
								echo "<b>5,000 FUNCOINS</b>!";
								$player->money += 5000;
							} else {
								echo "{$candy_type[$type_roll]}! Tasty! (+<i>10 HP</i>)";
								$player->health += 10;
								if($player->health > 100) {
									$player->health == 100;
								}
							}
							echo "</br>";
						}
					}
					echo "</center>";
					echo "</div>";
				} elseif($winner == 'opponent') {
					$player->money -= $monster->level * 4;
					if($player->money <= 0) {
						$player->money = 0;
					}

				}

				$player->incombat = 0;
				$player->round_damage = 0;
				$player->update();			
				unset($_SESSION['monster_id']);
				unset($_SESSION['monster_health']);	
				unset($_SESSION['monsterPoison']);
				unset($_SESSION['monsterRadiation']);
				unset($_SESSION['monsterDebuff']);
				unset($_SESSION['monsterStun']);
				unset($_SESSION['playerBuff']);
				
			}
		
		} else {
		//display select form
			if(strcmp($current_page,'/?page=uptown')==0) {
				require('uptowndisplay.php');
			} elseif (strcmp($current_page,'/?page=downtown')==0) {
				require('downtowndisplay.php');
			} else {
				require('uptowndisplay.php');
			}
			
		}
	}
}

function battle($player, $opponent) {
	
	global $database;
	global $player;
	global $inventory;
	global $fish;
	global $self_link;
		
	//fetch attack data
	$result = $database->query("SELECT * FROM `attacks`");
	$attacks = array();
	
	while($attack = $database->fetch($result)) {
		$attacks[$attack['id']] = $attack;
	}
	
	//fetch bodypart data
	$result_part = $database->query("SELECT * FROM `bodyparts` ORDER BY RAND() LIMIT 1");
	$parts = array();
	
	while($part = $database->fetch($result_part)) {
		$parts[$part['name']] = $part;
	}	

	$part_hit = $parts['']['part'];

	$winner = false;
	$combat_display = '';
	
	if(!empty($_POST['run'])) {
		
		//echo "FUCK";
		$player_init = $player->dexterity * mt_rand(1,6);
		if($player->legs == 11) {
			$player_init *= 1.5;
		}
		$opponent_init = $opponent->dexterity * mt_rand(1,6);
		
		if($player_init >= $opponent_init) {
			$winner = 'none';
			
			if($player->legs == 11) {
				$combat_display .= '<br />You quickly flee to safety in your <b> Chitinous Jeans</b>.';
			} else {
				$combat_display .= '<br />You flee to safety.';
			}
		} else {
			$monster_attack = $opponent->attacks[array_rand($opponent->attacks)];

			$opponent_damage = $monster_attack['power'] * .8;
			if($monster_attack['type'] == 'melee') {
				$opponent_damage *= 2 * $opponent->strength;
			}
			else if($monster_attack['type'] == 'ranged') {
				$opponent_damage *= 2 * $opponent->dexterity * .9;
			}

			$opponent_damage = round($opponent_damage / (2 + $player->endurance/2), 0);

			if($player->hello_kitty == 1) {
				$opponent_damage = round($opponent_damage * 0.75, 0);
			}

			//apply damage
			$player->round_damage += $opponent_damage;
			$player->health -= $opponent_damage;
			if($player->health <= 0) {
				$player->health = 0;
			}
			$combat_display .= '<br />You try to run but ' . $opponent->name . ' blocks your path!<br /><br />' . $opponent->name . ' ' . $monster_attack['combat_text1'] . ' ' . $part_hit . ' ' . $monster_attack['combat_text2'] . ' for <b>' . $opponent_damage . '</b> damage!<br /><br />';

			if($player->health <= 0) {
				$player->health = 0;
				$winner = 'opponent';
				$player->round_damage += $opponent_damage;
				$combat_display .= "
					<div style='
					floating: top;
					position: absolute; 
					width: 540px; 
					padding: 20px;
					translate: -80px 0px;
					background-image: url(./images/skin.jpg);
					background-size: 600px 600px;
					box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'><center>
					<h2 style='
						color:red;
						translate: 0px -20px;
						font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
						YOU DIED</h2>
					<h3 style='
						translate: 0px -20px;
						font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
						{$opponent->name} wins!</h2>
					<div style='translate: 0px -20px;'>They rumage through your pockets and take <b>" . $opponent->level * 4 . "</b> FUNCOINS!<br><br>
					<a href='?page=bar' style='color: white;'>SLEEP IT OFF</a>, loser.</div></center></div><br/>";
					
					
			}
		}
		
	} elseif(!empty($_POST['attack'])) {
		$attack_id = (int)$_POST['attack_id'];
		$fishBucket_choice = $_POST['fishBucket'];
		
		//echo "attack_id: {$attack_id}<br>";
		//echo "fB_choice: {$fishBucket_choice}<br>";
		//print_r("FUCK");
		
		
		try {
			
			if(!isset($attacks[$attack_id]) and !isset($_POST['fishBucket'])) {
				throw new Exception("Invalid attack.");
				//print_r($_POST['attack']);
				//print_r($attack_id);
			}
			
			if(!isset($player->attacks[$attack_id]) and !isset($_POST['fishBucket'])) {
				throw new Exception("Invalid attack.");
				//print_r($_POST['attack']);
				//print_r($attack_id);
			}

			$attack = $attacks[$attack_id];
			
			//run turn
			require('combat.php');
			
									
			//check winner
			if($opponent->health <= 0) {
				$opponent->health = 0;
				$winner = 'player';
				$player->round_damage += $opponent_damage;
			}
			else if($player->health <= 0) {
				$player->health = 0;
				$winner = 'opponent';
				$player->round_damage += $opponent_damage;
				$combat_display .= "
					<div style='
					floating: top;
					position: absolute; 
					width: 540px; 
					padding: 20px;
					translate: -80px 0px;
					background-image: url(./images/skin.jpg);
					background-size: 600px 600px;
					box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'><center>
					<h2 style='
						color:red;
						translate: 0px -20px;
						font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
						YOU DIED</h2>
					<h3 style='
						translate: 0px -20px;
						font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
						{$opponent->name} wins!</h2>
					<div style='translate: 0px -20px;'>They rumage through your pockets and take <b>" . $opponent->level * 4 . "</b> FUNCOINS!<br><br>
					<a href='?page=bar' style='color: white;'>SLEEP IT OFF</a>, loser.</div></center></div><br/>";
			}
			
			//update data
			$player->update();
			$opponent->update();
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	} else {
		//echo "FUCK2";
	}
	
	//statbox
	require('statbox.php');
	
	//echo '<center>welcum 2 battle:)</center>';
	
	//display
	$player->incombat = 1;
	$player->update();
	echo "<div style='
		float: right;
		margin-top: 10px;
		margin-right: -140px;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<img src='./images/monsters/{$opponent->id}.jpg' width='240px' height='240px' /></div>";
	
	echo"<table class='centerDiv' style='width:460px;'>
		<tr>
			<th style='width:125%;' colspan='4'><h1 style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>$opponent->name</h1></th>
		</tr>
		<tr>
			<td style='width:66%; translate: 0px -10px;'><center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><i>$opponent->description</i></center></td>
		</tr><br>";
			
		//attack text
		if($combat_display) {
			echo "<tr style='translate: 0px 20px;'>
				<td class='center' colspan='4' style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>{$combat_display}</td>
			</tr>";
		}
			
		//move prompt		
		if(empty($winner)) {
			echo "<tr><td class='center' colspan='4'>";
			if(is_array($player->equip)) {
				echo "<br />
				<center><div style='
					height: 80px;
					width: 66%;
					padding: 20px;
					translate: 0px 10px;
					position: static;
					background-image: url(./images/skin.jpg);
					background-size: 600px 600px;
					box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'><center>";
				foreach($player->equip as $id) {
					if($attacks[$id]['type'] == 'magic') {
						echo "<form action='$self_link' method='POST'>
						<input type='hidden' name='attack_id' value='{$id}' />
						<input type='submit' name='attack' value='{$attacks[$id]['name']} - {$attacks[$id]['purchase_cost']} DP' />
						</form>";
					} elseif($id == 'fish') {
						//FISH BUCKET
						//doesnt do anything yet
						if(empty($fish)){
							print_r("fish empty");
						}
						echo "Select Fish:<br>
						<form action='$self_link' method='POST'>
						<select name = 'fishBucket' title='Select a fish.'>";
						$x = 0;
						
						for ($i = 1; $i < $fish->num_fish - 4; $i++) {
							print_r($fish->num_fish);
							if($fish->fish[$i]['qty'] == 0) {
								continue;
							}
							if($fish->fish[$i]['combat'] == 0) {
								continue;
							}
							$x += 1;
							echo "<option value = '{$fish->fish[$i]['id']}' title='{$fish->fish[$i]['desc']}'";
							if($i == $fishBucket_choice) {
								echo " selected";
							}
							echo ">{$fish->fish[$i]['name']} ({$fish->fish[$i]['qty']})</option>";
						}
						if($x == 0) {
							echo "<option value = 'none' title='You don't have any fish.'>Empty</option>";
						}
						echo "</select>
						<input type='submit' name='attack' value='->' /></form>";
					} else {
						echo "<form action='$self_link' method='POST'>
						<input type='hidden' name='attack_id' value='{$id}' />
						<input type='submit' name='attack' value='{$attacks[$id]['name']}' />
						</form>";
					}
				}
				echo "</center></div>";
			} else {
				unset($_SESSION['monster_id']);
				unset($_SESSION['monster_health']);
				//unset($_SESSION['monsterPoison']);
				//unset($_SESSION['monsterDebuff']);
			}
			echo "</td></tr>";
		}
		
		echo "</table>";
		
		echo "<div style='
			float: right;
			height: 120px;
			width: 120px;
			translate: 180px 360px;
			background-image: url(./images/skin.jpg);
			background-size: 240px 240px;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
		';><center style='translate: 0px 50px;'>";
		if($winner) {
			
			if($player->lastadv <= 4) {
				
				//rare monster check
				$roll = mt_rand(1,200);
				if($player->level >= 60 && $roll >= 195) {
					$result1 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
					$result2 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
					$result3 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
					$result4 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
				} elseif($player->level >= 45 && $roll >= 199) {
					$result1 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
					$result2 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
					$result3 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
					$result4 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
				} else if($player->level >= 25 && $roll <= 1) {
					$result1 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
					$result2 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
					$result3 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
					$result4 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
				} else {
					$result1 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=1 ORDER BY RAND()");
					$result2 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=2 ORDER BY RAND()");
					$result3 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=3 ORDER BY RAND()");
					$result4 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=4 ORDER BY RAND()");
				}
				
				if($player->lastadv == 1) {
					$monster = $database->fetch($result1);
				}
				if($player->lastadv == 2) {
					$monster = $database->fetch($result2);
				}
				if($player->lastadv == 3) {
					$monster = $database->fetch($result3);
				}
				if($player->lastadv == 4) {
					$monster = $database->fetch($result4);
				}
			
			} elseif ($player->lastadv >= 5) {
				
				//rare monster check
				$roll = mt_rand(1,200);
				if($player->level >= 60 && $roll >= 195) {
					$result1 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
					$result2 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
					$result3 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
					$result4 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
				} elseif($player->level >= 45 && $roll >= 199) {
					$result1 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
					$result2 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
					$result3 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
					$result4 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
				} else if($player->level >= 30 && $roll <= 1) {
					$result1 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
					$result2 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
					$result3 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
					$result4 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
				} else {
					$result1 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=5 ORDER BY RAND()");
					$result2 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=6 ORDER BY RAND()");
					$result3 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=7 ORDER BY RAND()");
					$result4 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=8 ORDER BY RAND()");
				}
					
				if($player->lastadv == 5) {
					$monster = $database->fetch($result1);
				}
				if($player->lastadv == 6) {
					$monster = $database->fetch($result2);
				}
				if($player->lastadv == 7) {
					$monster = $database->fetch($result3);
				}
				if($player->lastadv == 8) {
					$monster = $database->fetch($result4);
				}
				
			}
			
			/**drunk per turn
			$player->drunk -= 1;
			if($player->drunk <= 0) {
				$player->drunk = 0;
			}
			*/
			if($player->lastadv == 1 || $player->lastadv == 2 || $player->lastadv == 3) {
				echo "<form action='./?page=uptown' method='POST'>";	
			} elseif($player->lastadv == 4 || $player->lastadv == 5) {
				echo "<form action='./?page=downtown' method='POST'>";	
			}			
			if($player->health > 0) {
				echo "<input type='hidden' name='monster_id{$player->lastadv}' value='{$monster['id']}' /><input type='submit' name='fight{$player->lastadv}' value='Again' style='translate: 0px -20px;'/><br />";
			}
			echo "<input type=submit name='fight' value='Back' />";
		} else {
			echo "<form action='$self_link' method='POST'><input type='submit' name='run' value='Run' />";
		}
		echo "</form>
		</div>";
		return $winner;
		
}
	