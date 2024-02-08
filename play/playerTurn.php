<?php

global $database;
global $player;
global $inventory;
global $fish;
global $self_link; 

$reset_mult = ($player->resets/10) + 1;


if($attack['type'] == 'magic') {
	$drunk_roll = mt_rand(1,20);
	if($drunk_roll == 1) {
		$ow = round($player->health * 0.2);
		$combat_display .= 'You drunkenly try to attack your opponent but end up stumbling head first into a nearby wall for <b style="color: red;">'.$ow.'</b> damage!';
		$player->health -= $ow;
	} 
} elseif ($fishBucket_choice > 0) {
	//fish bucket
	//echo "something happens ({$fishBucket_choice})<br>";
	//echo "{$fish->fish[$fishBucket_choice]['combat_type']} {$fish->fish[$fishBucket_choice]['combat_value']}";
	$fish_text = str_replace("%player%", $player->login, $fish->fish[$fishBucket_choice]['combat_text']);
	$fish_text = str_replace("%monster%", $opponent->name, $fish_text);
	$fish_type = $fish->fish[$fishBucket_choice]['combat_type'];
	if($fishBucket_choice == 34) {
		$types = array("dmg", "debuff", "none");
		//$combat_display .= $types[1];
		$fish_type = $types[mt_rand(0, 2)];
	}
	$combat_display .= "<img src='./images/fish/{$fishBucket_choice}.jpg' width='60px'/><br>";
	if($fish_type == 'dmg') {
		//$player_damage = $fish->fish[$fishBucket_choice]['combat_value'] ;
		$player_damage = (($fish->fish[$fishBucket_choice]['combat_value']) * 2) - ($opponent->level * 1 * $_SESSION['monsterDebuff']) * $reset_mult;
		$player_damage += (mt_rand(0,4)/2-1) * ($player_damage * 0.1);
		$player_damage = round($player_damage, 0);
		if($player_damage < 0) {
			$player_damage = 1;
		}
		$opponent->health -= $player_damage;
		if($fishBucket_choice != 34) {
			$fish->fish[$fishBucket_choice]['qty'] -= 1;
			$fish->update();
		}
		$combat_display .= "{$fish_text} for <b>{$player_damage}</b> damage!";
	} elseif($fish_type == 'poison') {
		$player_damage = (($fish->fish[$fishBucket_choice]['combat_value']) * 2) - ($opponent->level * 1 * $_SESSION['monsterDebuff']) * $reset_mult;
		$player_damage += (mt_rand(0,4)/2-1) * ($player_damage * 0.1);
		$player_damage = round($player_damage, 0);
		if($player_damage < 0) {
			$player_damage = 1;
		}
		$opponent->health -= $player_damage;
		$_SESSION['monsterPoison'] = $fish->fish[$fishBucket_choice]['combat_value'];
		$_SESSION['monsterPoisonNew'] = 1;
		if($fishBucket_choice != 34) {
			$fish->fish[$fishBucket_choice]['qty'] -= 1;
			$fish->update();
		}
		$combat_display .= "{$fish_text} for <b>{$player_damage}</b> damage!";
	} elseif($fish_type == 'radiation') {
		$player_damage = (($fish->fish[$fishBucket_choice]['combat_value']) * 2) - ($opponent->level * 1 * $_SESSION['monsterDebuff']) * $reset_mult;
		$player_damage += (mt_rand(0,4)/2-1) * ($player_damage * 0.1);
		$player_damage = round($player_damage, 0);
		if($player_damage < 0) {
			$player_damage = 1;
		}
		$_SESSION['monsterDebuff'] *= 0.85;
		$opponent->health -= $player_damage;
		$_SESSION['monsterRadiation'] = $player_damage;
		$_SESSION['monsterRadiationNew'] = 1;
		if($fishBucket_choice != 34) {
			$fish->fish[$fishBucket_choice]['qty'] -= 1;
			$fish->update();
		}
		$combat_display .= "{$fish_text} for <b>{$player_damage}</b> damage!";
	} elseif($fish_type == 'heal') {
		$player->health += $fish->fish[$fishBucket_choice]['combat_value'];
		if($player->health > 100) {
			$player->health = 100;
		}
		$player->update();
		if($fishBucket_choice != 34) {
			$fish->fish[$fishBucket_choice]['qty'] -= 1;
			$fish->update();
		} else {
			$fish_text = "Mr. Frog let's you take a puff off his cigar";
		}
		$combat_display .= "{$fish_text}.";
	} elseif($fish_type == 'buff') {
		$_SESSION['playerBuff'] = $fish->fish[$fishBucket_choice]['combat_value'];
		if($fishBucket_choice != 34) {
			$fish->fish[$fishBucket_choice]['qty'] -= 1;
			$fish->update();
		} else {
			$fish_text = "Mr. Frog let's you take a puff off his cigar";
		}
		$combat_display .= "{$fish_text}.";
	} elseif($fish_type == 'debuff') {
		$player_damage = (($fish->fish[$fishBucket_choice]['combat_value']) * 2) - ($opponent->level * 1 * $_SESSION['monsterDebuff']) * $reset_mult;
		$player_damage += (mt_rand(0,4)/2-1) * ($player_damage * 0.1);
		$player_damage = round($player_damage, 0);
		$_SESSION['monsterDebuff'] *= 0.75;
		$opponent->health -= $player_damage;
		if($fishBucket_choice != 34) {
			$fish->fish[$fishBucket_choice]['qty'] -= 1;
			$fish->update();
		} else {
			$fish_text = "Mr. Frog blows his cigar smoke in your opponent's face before kicking them in the shin as hard as he can";
		}
		$combat_display .= "{$fish_text} for <b>{$player_damage}</b> damage!";
	} elseif($fish_type == 'stun') {
		if($fishBucket_choice != 34) {
			$fish->fish[$fishBucket_choice]['qty'] -= 1;
			$fish->update();
		} else {
			//$fish_text = "Mr. Frog blows his cigar smoke in your opponent's face before kicking them in the shin as hard as he can";
		}
		if($fish->fish[$fishBucket_choice]['combat_value'] > 0) {
			$player_damage = (($fish->fish[$fishBucket_choice]['combat_value']) * 2) - ($opponent->level * 1 * $_SESSION['monsterDebuff']) * $reset_mult;
			$player_damage += (mt_rand(0,4)/2-1) * ($player_damage * 0.1);
			$player_damage = round($player_damage, 0);
			if($player_damage < 0) {
				$player_damage = 1;
			}
			$opponent->health -= $player_damage;
			$_SESSION['monsterStun'] = 1;
			$combat_display .= "{$fish_text} for <b>{$player_damage}</b> damage!";
		} else {
			$_SESSION['monsterStun'] = mt_rand(2,3);
			$combat_display .= "{$fish_text}.";
		}
	} elseif($fish_type == 'none') {
		if($fishBucket_choice == 34) {
			$combat_display .= "{$fish->fish[$fishBucket_choice]['name']} croaks at your opponent, meancingly.";
		} else {
			$combat_display .= "{$fish->fish[$fishBucket_choice]['combat_text']}.";
		}
	}
} else {
	$base_damage = mt_rand(5,15);
	
	if($attack['type'] == 'melee') {
		$miss_roll = 0;
		$player_damage = (($player->strength * 2) * 1.1) - ($opponent->level * 1 * $_SESSION['monsterDebuff']) + $attack['power'] * $reset_mult;
		if($player->hands == 17) {
			$player_damage *= 1.1;
		}
		
		
	} else if($attack['type'] == 'ranged') {
		$miss_roll = mt_rand(1,18);
		$player_damage = ($player->dexterity * 2) - ($opponent->level * 1 * $_SESSION['monsterDebuff']) + $attack['power'] * $reset_mult;
	}
	$player_damage += $base_damage;
	
	//random damage mod
	$player_damage += (mt_rand(0,4)/2-1) * ($player_damage * 0.1);
	
	$player_damage = round($player_damage, 0);
	
	//apply damage
	
	if ($miss_roll == 1) {
		$combat_display .= 'Your shot whizzes past your opponent, completely missing them!<br />';
	} else {
		if($player_damage < 0) {
			$player_damage = 1;
		}
		$opponent->health -= $player_damage;
		if($player->feet == 13) {
			if(mt_rand(1,3) == 3) {
				$opponent->health -= $opponent->max_health * 0.1;
				$combat_display .= 'Your opponent catches a near-fatal whiff of your Rotting Sneakers for <b>' . $opponent->max_health * 0.1 . '</b> damage!<br />';
			}
		}
		$attack_text = str_replace("'", "&#39;", $attack['combat_text']);

		if($attack['id'] == 24) {
			$combat_display .= 'You ' . $attack_text . ' <b>' . $player_damage . '</b> damage ain\'t bad either...';
		} elseif($attack['id'] == 25) {
			$combat_display .= '"Dodge this." You ' . $attack_text . ' for <b>' . $player_damage . '</b> damage!';
		}else {
			$combat_display .= 'You ' . $attack_text . ' for <b>' . $player_damage . '</b> damage!';
		}
	}
}
if($_SESSION['monsterPoison'] > 0) {
	if($_SESSION['monsterPoisonNew'] == 0) {
	//echo "FUCK";
	$_SESSION['monsterPoison'] *= 0.75;
	$_SESSION['monsterPoison'] += (mt_rand(0,4)/2-1) * ($_SESSION['monsterPoison'] * 0.1);
	$_SESSION['monsterPoison'] = round($_SESSION['monsterPoison'], 0);
	$opponent->health -= $_SESSION['monsterPoison'];
	$combat_display .= " (+<b color='green'>{$_SESSION['monsterPoison']}</b> POIS)";
	} else {
		$_SESSION['monsterPoisonNew'] = 0;
	}
}
if($_SESSION['monsterRadiation'] > 0) {
	if($_SESSION['monsterRadiationNew'] == 0) {
		//echo "FUCK";
		$_SESSION['monsterRadiation'] *= 0.5;
		$_SESSION['monsterRadiation'] += (mt_rand(0,4)/2-1) * ($_SESSION['monsterRadiation'] * 0.1);
		$_SESSION['monsterRadiation'] = round($_SESSION['monsterRadiation'], 0);
		$opponent->health -= $_SESSION['monsterRadiation'];
		$combat_display .= " (+<b color='green'>{$_SESSION['monsterRadiation']}</b> RAD)";
	} else {
		$_SESSION['monsterRadiationNew'] = 0;
	}
}
$combat_display .= "<br />";
