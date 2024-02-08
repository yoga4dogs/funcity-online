<?php

	global $database;
	global $player;
	global $inventory;
	global $fish;
	global $self_link; 
	
	//initiative
	//drunkeness penalty to init
	if($player->drunk >= 1){
		$player_init = ($player->dexterity * 0.75) * mt_rand(1,6) * $reset_mult;
		$opponent_init = $opponent->dexterity * mt_rand(1,6) * $reset_mult;
	} else {
		$player_init = $player->dexterity * mt_rand(1,6) * $reset_mult;
		$opponent_init = $opponent->dexterity * mt_rand(1,6) * $reset_mult;
	}
	//jeans init boost
	if($player->legs == 11) {
		$player_init *= 1.2;
	}
	
	if($_SESSION['monsterDebuff'] < 0.5) {
		$_SESSION['monsterDebuff'] = 1;
	}
	
	//portable hole
	if($attack['id'] == 22) {
		if($player->drunk >= $attack['purchase_cost']) {
			$player->drunk -= $attack['purchase_cost'];
			if($player->drunk < 0) {
				$player->drunk = 0;
			}
			//killfucker block
			if($opponent->id == 39) {
				$player->health = 0;
				
				$winner = 'opponent';
				
				$combat_display .= '<br />You throw a Portable Hole on the ground and disappear inside.<br />';
				
				$combat_display .= '<br />Killfucker quickly dives in after you, tearing your heart from your chest before the hole even has a chance to spit you out.<br />';
				
			} else {
				$player->turns += 1;
				
				$winner = 'none';
			
				$combat_display .= '<br />You throw a Portable Hole on the ground and disappear inside. It spits you out several feet to the left and five minutes back.';
			}
		} else {
			$combat_display .= "You aren't drunk enough to want to jump in there.<br />";
		}
	//psychic contraption
	} elseif ($attack['id'] == 21) {
		if($player->drunk >= $attack['purchase_cost']) {
			$player->drunk -= $attack['purchase_cost'];
			if($player->drunk < 0) {
				$player->drunk = 0;
			}
			$_SESSION['monsterDebuff'] *= 0.75;
			if($_SESSION['monsterDebuff'] < 0.5) {
				$_SESSION['monsterDebuff'] = 0.5;
			}
			$player->update();
			$opponent->update();
			$combat_display .= 'You ' . $attack['combat_text'] . '<br /><br />';
			$combat_display .= '' . $opponent->name . ' clutches their head in pain!<br /><br />';
			
		} else {
			$combat_display .= "You aren't drunk enough to fuck with the contraption!<br />";
		}
	//EVIL IDOL
	} elseif ($attack['id'] == 23) {
	
		if($player->drunk >= $attack['purchase_cost']) {
			$player->drunk -= $attack['purchase_cost'];
			if($player->drunk < 0) {
				$player->drunk = 0;
			}
			$idoldamage = round($opponent->health * 0.25);
			$opponent->health -= $idoldamage;
			$player->update();
			$opponent->update();
			$combat_display .= 'You ' . $attack['combat_text'] . '.<br /><br />';
			$combat_display .= '' . $opponent->name . ' takes ' . $idoldamage . ' damage.<br /><br />';
			
		} else {
			$combat_display .= "You aren't drunk enough to contemplate the idol.<br />";
		}
	} elseif($winner != none) {
		
		//combat cocktail
		if($player->head == 20) {
			$cocktailRoll = mt_rand(1,5);
			if($cocktailRoll == 1) {
				$player->drunk += 2;;
				if($player->acc == 14) {
					if($player->drunk > 20) {
						$player->drunk = 20;
					}
				} else {
					if($player->drunk > 10) {
						$player->drunk = 10;
					}
				}
				$drinkName = mt_rand(0,7);
				$drinkNames = array("a Rum & Coke", "a Sex on the Beach", "a Manhattan", "Vodka & Powerade", "a Mojito", "a Mai Tai", "a Zombie", "an Old Fashioned", "a Gin & Tonic", "a Vodka Soda", "a Bloody Mary", "a Long Island Iced Tea");
				$combat_display .= 'Your Combat Helmet jabs a needle into your spinal cord, inecting a potent combat cocktail... Mmm, ' .$drinkNames[$drinkName] . '!<br /><br />';
			}
		}
		if($player_init >= $opponent_init) {
			
			//calc player damage
			if($player->health > 0) {
				require('playerTurn.php');	
				
				//calc opponent damage
				//array_ran selects rand from passed array
				if($opponent->health > 0) {
					require('monsterTurn.php');
				}
			}
		} elseif ($player_init <= $opponent_init) {
			
			//calc opponent damage
			//array_ran selects rand from passed array
			if($opponent->health > 0) {
				require('monsterTurn.php');
			
				//calc player damage
				if($player->health > 0) {
					require('playerTurn.php');	
				}
			}
		}
	}
	