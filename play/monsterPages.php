<?php

//monsterPages.php
//functions for creating and editing monsters

function create_monster() {
	global $database;
	global $player;
	global $self_link;
	
	if($player->id != 23) {
		echo "nope";
	} else {
	
	if(!empty($_POST['create_monster'])) {
		
		try {

			$name = $database->clean($_POST['name']);
			$plural = $database->clean($_POST['plural']);
			$description = $database->clean($_POST['description']);
			$level = (int)$database->clean($_POST['level']);
			$loc = (int)$database->clean($_POST['loc']);
			$max_health = (int)$database->clean($_POST['max_health']);
			$strength = (int)$database->clean($_POST['strength']);
			$dexterity = (int)$database->clean($_POST['dexterity']);
			$endurance = (int)$database->clean($_POST['endurance']);
			$item_drop = (int)$database->clean($_POST['item_drop']);
			$item_drop_rate = (int)$database->clean($_POST['item_drop_rate']);
			
			if($level < 1) {
				throw new Exception("Invalid level");
			}
			
			if($loc < 1) {
				throw new Exception("Invalid loc");
			}
			if($max_health < 1) {
				throw new Exception("Invalid HP");
			}
			if($strength < 1) {
				throw new Exception("Invalid STR");
			}
			if($dexterity < 1) {
				throw new Exception("Invalid DEX");
			}
			if($endurance < 1) {
				throw new Exception("Invalid END");
			}
			
			$attacks = array();
			
			foreach($_POST['attacks'] as $id => $attack) {
			
				if(!is_int($id)) {
					throw new Exception("Invalid ID");
				}
				
				$attacks[$id]['combat_text1'] = $database->clean($attack['combat_text1']);
				if(!$attacks[$id]['combat_text1']) {
					throw new Exception("Invalid text 1");
				}
				$attacks[$id]['combat_text2'] = $database->clean($attack['combat_text2']);
								
				$attacks[$id]['type'] = $database->clean($attack['type']);
				if($attacks[$id]['type'] != 'melee' && $attacks[$id]['type'] != 'ranged') {
					throw new Exception("Invalid type");
				}
				
				
				$attacks[$id]['power'] = (int)$attack['power'];
				if($attacks[$id]['power'] < 0) {
					throw new Exception("Invalid power");
				}
			}
			
			//insert new monster into db
			$attacks = json_encode($attacks);
			$database->query("INSERT INTO `monsters` (`name`, `plural`, `description`, `level`, `loc`, `max_health`, `strength`, `dexterity`, `endurance`, `attacks`) VALUES ('$name', '$plural', '$description', '$level', '$loc', '$max_health', '$strength', '$dexterity', '$endurance', '$attacks')");
			if($database->affected_rows() > 0 ) {
				echo "Monster created.";
			}
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
			
		
	}
	
	//Display form
	$label_width = 4;
	echo "<div id='login' style='margin-top:10%'>
		<form action='?page=create_monster' method='POST'>
			<label style='width:{$label_width}em;'>NAME:</label><input type='Text' name='name' /><br />
			<label style='width:{$label_width}em;'>PLURAL:</label><input type='Text' plural='plural' /><br />
			<label style='width:{$label_width}em;'>DESC:</label><input type='Text' name='description' /><br />
			<label style='width:{$label_width}em;'>LVL:</label><input type='number' name='level' /><br />
			<label style='width:{$label_width}em;'>LOC:</label><input type='number' name='loc' /><br />
			<label style='width:{$label_width}em;'>HP:</label><input type='number' name='max_health' /><br />
			<label style='width:{$label_width}em;'>STR:</label><input type='number' name='strength' /><br />
			<label style='width:{$label_width}em;'>DEX:</label><input type='number' name='dexterity' /><br />
			<label style='width:{$label_width}em;'>END:</label><input type='number' name='endurance' /><br />
			<br />
			<label style='width:{$label_width}em;'>ATTACKS:</label><br />";
					for($i = 1; $i <= 2; $i++) {
						echo "<label style='width:{$label_width}em;'>attack b4</label>
							<input type='text' name='attacks[$i][combat_text1]' /> <br />
						<label style='width:{$label_width}em;'>after part</label>	
							<input type='text' name='attacks[$i][combat_text2]' /> <br />
						<label style='width:{$label_width}em;'>Type:</label>
							<select name='attacks[$i][type]'>
								<option value='melee'>Melee</option>
								<option value='ranged'>Ranged</option>
							</select><br />
						<label style='width:{$label_width}em;'>Power:</label>
						<input type='number' name='attacks[$i][power]' /><br />
						<br />";
					}
			echo "<label style='width:{$label_width}em;'>Drop:</label><input type='number' name='item_drop' /><br />
				<label style='width:{$label_width}em;'>Rate/Roll:</label><input type='number' name='item_drop_rate' /><br />
				<center><input type='submit' name='create_monster' value='Create' /></center />
		</form>
	</div>";
	
	
	}
	
}

function edit_monster() {
	
	
}

