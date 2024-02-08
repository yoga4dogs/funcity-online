<?php

	global $database;
	global $player;
	global $fish;
	global $inventory;
	global $self_link;
	
	$size = 50;
	
	echo "<style>
		
		.zoom {
			float: left;
			z-index:3;
		}
		.zoom:hover {
			transform: scale(3);
		}
		</style>";
	
	echo "<div style='width: {$size}px; translate: 320px 28px;'>";
	echo "<div style='width: {$size}px; height: {$size}px; border: 10px outset #474747; box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>";
	if($player->head > 0) {
		echo "<img class='zoom' src='./images/equips/{$player->head}.jpg' width='{$size}px' title='{$equips[$player->head]['stat']} (DR: {$equips[$player->head]['power']})'/>";
	} else {
		echo "<img src='./images/equips/0.jpg' width='{$size}px'/>";
	}
	echo "</div>
	<div style='width: {$size}px; height: 5px;'></div>
	<div style='width: {$size}px; height: {$size}px; border: 10px outset #474747; box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>";
	if($player->torso > 0) {
		echo "<img class='zoom' src='./images/equips/{$player->torso}.jpg' width='{$size}px' title='{$equips[$player->torso]['stat']} (DR: {$equips[$player->torso]['power']})'/>";
	} else {
		echo "<img src='./images/equips/0.jpg' width='{$size}px'/>";
	}
	echo "</div>
	<div style='width: {$size}px; height: 5px;'></div>
	<div style='width: {$size}px; height: {$size}px; border: 10px outset #474747; box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>";
	if($player->legs > 0) {
		echo "<img class='zoom' src='./images/equips/{$player->legs}.jpg' width='{$size}px' title='{$equips[$player->legs]['stat']} (DR: {$equips[$player->legs]['power']})'/>";
	} else {
		echo "<img src='./images/equips/0.jpg' width='{$size}px'/>";
	}
	echo "</div>
	<div style='width: {$size}px; height: 5px;'></div>
	<div style='width: {$size}px; height: {$size}px; border: 10px outset #474747; box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>";
	if($player->hands > 0) {	
		echo "<img class='zoom' src='./images/equips/{$player->hands}.jpg' width='{$size}px' title='{$equips[$player->hands]['stat']} (DR: {$equips[$player->hands]['power']})'/>";
	} else {
		echo "<img src='./images/equips/0.jpg' width='{$size}px'/>";
	}
	echo "</div>
	<div style='width: {$size}px; height: 5px;'></div>
	<div style='width: {$size}px; height: {$size}px; border: 10px outset #474747; box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>";
	if($player->feet > 0) {	
		echo "<img class='zoom' src='./images/equips/{$player->feet}.jpg' width='{$size}px' title='{$equips[$player->feet]['stat']} (DR: {$equips[$player->feet]['power']})'/>";
	} else {
		echo "<img src='./images/equips/0.jpg' width='{$size}px'/>";
	}
	echo "</div>
	<div style='width: {$size}px; height: 5px;'></div>
	<div style='width: {$size}px; height: {$size}px; border: 10px outset #474747; box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>";
	if($player->acc > 0) {	
		echo "<img class='zoom' src='./images/equips/{$player->acc}.jpg' width='{$size}px' title='{$equips[$player->acc]['stat']}";
		if($player->acc = 22 and $player->pod_fish > 0) {
			echo " (INSTALLED: {$fish->fish[$player->pod_fish]['name']})";
		}
		echo "'/>";
	} else {
		echo "<img src='./images/equips/0.jpg' width='{$size}px'/>";
	}
	echo "</div>";
	echo "</div>";
