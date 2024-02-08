<?php

global $database;
global $player;
global $self_link; 

$resultEquip = $database->query("SELECT * FROM `equipment` WHERE `id` = '{$monster->item_drop}'");
$equipment = $resultEquip->fetch_assoc();	

$resultEquip = $database->query("SELECT * FROM `equipment` ORDER BY `name`");
$equipment1 = array();
while($equipment = $database->fetch($resultEquip)) {
	$equipment1[$equipment['id']] = $equipment;
}

//killfucker miss more
if($opponent->id == 39) {
	$opponent_miss_roll = mt_rand(1,5);
} else {
	$opponent_miss_roll = mt_rand(1,20);
}
if($_SESSION['monsterStun'] > 0) {
	$combat_display .= '<br />' . $opponent->name . ' is unable to attack!</br>';
	$_SESSION['monsterStun'] -= 1;
} elseif($opponent_miss_roll == 1) {
	$combat_display .= '<br />' . $opponent->name . ' slips on a stray banana peel and struggles to stand back up!</br>';
} else {
	$monster_attack = $opponent->attacks[array_rand($opponent->attacks)];
		
	$opponent_damage = round(($opponent->level * 0.75 - $player->endurance) + ($monster_attack['power'] * (mt_rand(1,5) / 100 + 1)), 0);
	if($opponent_damage < 3) {
		$opponent_damage = mt_rand(1,5);
	}
	
	//$opponent_damage = round($opponent_damage / (5 + $player->endurance/2), 0);
	
	$damageReductionDiv = 4;
	//damage reduction
	$opponent_damage -= round($opponent_damage * ((($equipment1[$player->head]['power'] + $equipment1[$player->torso]['power'] + $equipment1[$player->legs]['power'] + $equipment1[$player->hands]['power'] + $equipment1[$player->feet]['power']) / $damageReductionDiv) / 100), 0);
	
	
	
	//apply damage
	$player->round_damage += $opponent_damage;
	$player->health -= $opponent_damage;
	if($player->health <= 0) {
		$player->health = 0;
	}
	if($monster_attack['power'] == 1000) {
		$combat_display .= '<br />' . $opponent->name . ' ' . $monster_attack['combat_text1'] . ' for <b>' . $opponent_damage . '</b> damage! (<i>' . $player->health . '/' . $player->max_health . '</i>)<br /><br />';
	} else {
		$combat_display .= '<br />' . $opponent->name . ' ' . $monster_attack['combat_text1'] . ' ' . $part_hit . ' ' . $monster_attack['combat_text2'] . ' for <b>' . $opponent_damage . '</b> damage! (<i>' . $player->health . '/' . $player->max_health . '</i>)<br /><br />';
	}

}