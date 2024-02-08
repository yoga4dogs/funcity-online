<?php

//admin page

function billsgarage() {

	global $database;
	global $player;
	global $self_link;
	
	$resultE = $database->query("SELECT * FROM `equipment` ORDER BY `slot`, `power` ASC");
	$equips = array();
	while($equip = $database->fetch($resultE)) {
		$equips[$equip['id']] = $equip;
	}
	$resultA = $database->query("SELECT * FROM `attacks` ORDER BY `type`, `power`");
	$attacks = array();
	while($attack = $database->fetch($resultA)) {
		$attacks[$attack['id']] = $attack;
	}
	
	$players = $database->query("SELECT * FROM `users`");
	$playerCount = array();
	while($players2 = $database->fetch($players)) {
		$playerCount[$players2['id']] = $players2;
	}
	
	//$newplayer = $database->query("SELECT * FROM `users` LIMIT 1 ORDER BY `id` DESC");
	$newplayer = $database->query("SELECT * FROM `users` ORDER BY `id` DESC LIMIT 1");
	$newplayername = array();
	while($newplayer2 = $database->fetch($newplayer)) {
		$newplayername[$newplayer2['login']] = $newplayer2;
	}
	
	//items
	$result2 = $database->query("SELECT * FROM `itemDB` ORDER BY `type`");
	$items = array();
	while($item = $database->fetch($result2)) {
		$items[$item['id']] = $item;
	}

	if($player->id == 23) {
		
		if(!empty($_POST['edit'])) {
			if($_POST['level'] > 0) {
				$player->level = $_POST['level'];
			}
			if($_POST['money'] > 0) {
				$player->money = $_POST['money'];
			}
			if($_POST['strength'] > 0) {
				$player->strength = $_POST['strength'];
			}
			if($_POST['dexterity'] > 0) {
				$player->dexterity = $_POST['dexterity'];
			}
			if($_POST['endurance'] > 0) {
				$player->endurance = $_POST['endurance'];
			}
			if($_POST['turns'] > 0) {
				$player->turns = $_POST['turns'];
			}
			if($_POST['drug_price'] > 0) {
				$player->drug_price = $_POST['drug_price'];
			}
			if($_POST['attack'] > 0) {
				$player->attacks[$_POST['attack']] = array();
			}
			if($_POST['equip'] > 0) {
				$player->equipment[$_POST['equip']] = array();
			}
			$player->update();
		}
		
		//links
		echo "<div style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><div style='width: 340px;'>";
		echo "<center><a href='./?page=create_attack'>attack</a> | <a href='./?page=create_equip'>equipment</a> | <a href='./?page=create_monster'>monster</a><br/><br />";
		
		//player count and newest player
		echo "<div style='translate: 360px -40px;'>NEWEST FRIEND
		<div style='width: 200px; height: 20px; background: #F4CDAB; box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>";
		echo count($playerCount);
		echo " - ";
		foreach($newplayername as $id => $newplayer2) {
			echo $newplayer2['login'];
		}
		echo "</div></div>";
		
		//char edit
		$label_width = 4;
		echo "<form action='$self_link' method='POST'><div style='translate: -20px -60px;'><h2>Edit Character</h2>
				<label style='width:{$label_width}em;'>Level:</label><input type='Number' name='level' /><br />
				<label style='width:{$label_width}em;'>Money:</label><input type='Number' name='money' /><br />
				<label style='width:{$label_width}em;'>STR:</label><input type='Number' name='strength' /><br />
				<label style='width:{$label_width}em;'>DEX:</label><input type='Number' name='dexterity' /><br />
				<label style='width:{$label_width}em;'>END:</label><input type='Number' name='endurance' /><br />
				<label style='width:{$label_width}em;'>Turns:</label><input type='Number' name='turns' /><br />
				<label style='width:{$label_width}em;'>DrugX:</label><input type='Number' name='drug_price' /><br />
				<label style='width:{$label_width}em;'>get atk:</label><input type='Number' name='attack' /><br />
				<label style='width:{$label_width}em;'>get eqp:</label><input type='Number' name='equip' /><br />
				<input type='submit' name='edit' value='Edit' /></div>
			</form></center>";
		echo "</div>";
		
		//dispaly item IDs
		echo "<div style='width: 380px; float: left; translate: 40px -40px; background: yellow; box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>";
		foreach($equips as $id => $equip) {
			echo "<label style='width:{$label_width}em;'>{$equips[$id]['id']}</label>{$equip['name']} ({$equip['slot']})<br/>";
		}
		echo "</div><div style='width: 380px; float: right; translate: 80px -600px; background: yellow; box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>";
		foreach($attacks as $id => $attack) {
			echo "<label style='width:{$label_width}em;'>{$attacks[$id]['id']}</label>{$attack['name']}: {$attack['power']} ({$attack['type']})<br/>";
		}
		//list all owned items
		echo "</div><div style='width: 380px; float: right; translate: 500px -1000px; background: yellow; box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>";
		foreach($items as $id => $item) {
			echo "<label style='width:{$label_width}em;'>{$item['id']}</label>{$item['name']}: {$item['type']}<br/>";
		}
		echo "</div></div>";
		
	} else {
		echo "<img src=''/><br/><h1>fuck You</h1>";
		echo $player->id;
	}

}