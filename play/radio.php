<?php

function radio() {
	global $database;
	global $player;
	global $self_link;

	$result = $database->query("SELECT * FROM `equipment` ORDER BY `purchase_cost`");
	$equips = array();
	while($equip = $database->fetch($result)) {
		$equips[$equip['id']] = $equip;
	}	
	
	$numbers = array();
	for($i=0;$i<12;$i++) {
		$numbers[$i] = mt_rand(0, 99);
	}
	$numbers['1'] = '...';
	$numbers['2'] = '...';
	$numbers['3'] = 'zzt';
	$numbers['4'] = 'shh';
	
	require('statbox.php');
	
	echo "<center style='margin-top: -20px;'><h2 style='color:#054c00; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>WKFC - FUNCITY RADIO</h2>
	
	<img src='./images/radio2.jpg' height='260px''></center><br><br>";
	
	echo "<div style='
			padding: 10px; 
			width: 440px;
			height: 140px;
			position: absolute;
			transform: translate(125px,-20px);
			background-image: url(./images/skin.jpg);
			background-size: 600px 600px;
			font-family: MingLiU-ExtB, Microsoft Yi Baiti;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>";
	echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti; margin-top:20px;'>''... {$numbers[mt_rand(0,11)]} - {$numbers[mt_rand(0,11)]} - {$numbers[mt_rand(0,11)]} - {$numbers[mt_rand(0,11)]} - {$numbers[mt_rand(0,11)]} - {$numbers[mt_rand(0,11)]} - {$numbers[mt_rand(0,11)]} - {$numbers[mt_rand(0,11)]} ...<br /><br />";
	
	//select target location
	if($player->level < 5) {
		$location = 1;
	} elseif($player->level < 15 && $player->level >= 5) {
		$location = mt_rand(1,2);
	} elseif($player->level < 25 && $player->level >= 15) {
		$location = mt_rand(2,3);
	} elseif($player->level < 40 && $player->level >= 25) {
		$location = mt_rand(3,4);
	} elseif($player->level >= 40) {
		$location = mt_rand(4,5);
	}
	
	//check quest status
	//complete and reward
	if($player->level >= 5) {
		if($player->target_bool == 1 && $player->target_count <= 0) {
			$player->target_bool = 0;
			$player->target_total += 1;
			echo "... good... job... ";
			if($player->target_total % 10 == 0) {
				if(!isset($player->equipment[14])) {
					$player->equipment[14] = array();
					echo "(You got a <span title='" .$equips[14]['stat']. "'><b>BIOMECHANICAL LIVER</span></b>)<br /><br />";
				} else {
				$exp_gain = (round((mt_rand(80,120)/100) * ($player->level/2), 0) * ($player->level * 20));
				echo "(+ {$exp_gain} XP)<br /><br />";
				}
			} else {
				$exp_gain = (round((mt_rand(80,120)/100) * ($player->level/2), 0) * ($player->level * 20));
				echo "(+ {$exp_gain} XP)<br /><br />";
			}
			$player->exp += $exp_gain;
			$player->exp_spend += $exp_gain;
			$player->update();
		//progress update
		} elseif($player->target_bool == 1 && $player->target_count > 0) {
			$monster = $database->query("SELECT `id`, `name`, `plural` FROM `monsters` WHERE `id`={$player->target_id}");
			$target = $database->fetch($monster);
			echo "... kill... {$player->target_count}... ";
			if($player->target_count == 1) {
				echo $target['name'];
			} elseif($player->target_count > 1) {
				echo $target['plural'];
			}
			echo "...<br /><br />";	//assign task
		} elseif($player->target_bool == 0) {
			$monster = $database->query("SELECT `id`, `name`, `plural` FROM `monsters` WHERE `loc`={$location} ORDER BY RAND()");
			$target = $database->fetch($monster);	
			$target_count = round((mt_rand(80,120)/100) * ($player->level/4), 0);
			$player->target_bool = 1;
			$player->target_id = $target['id'];
			$player->target_count = $target_count;
			$player->update();
			echo "... kill... {$target_count}... ";
			if($target_count == 1) {
				echo $target['name'];
			} elseif($target_count > 1) {
				echo $target['plural'];
			}
			echo "...<br /><br />";
		}
	} else {
		echo "(unlocks at level 5)<br /><br />";
	}
	
	echo "... {$numbers[mt_rand(0,11)]} - {$numbers[mt_rand(0,11)]} - {$numbers[mt_rand(0,11)]} - {$numbers[mt_rand(0,11)]} - {$numbers[mt_rand(0,11)]} - {$numbers[mt_rand(0,11)]} - {$numbers[mt_rand(0,11)]} - {$numbers[mt_rand(0,11)]} ...''<br /><br />";
	
	
	
	echo "<div style='transform: translate(0px, 40px);'><center><a href='./?page=apartment' style='color: white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>BACK</a></center></div>";
	
}