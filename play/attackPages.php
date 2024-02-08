<?php

//attackPages.php
//functions for creating and editing attacks

function create_attack() {
	global $database;
	global $player;
	global $self_link;
	
	if($player->id == 23) {
	
		if(!empty($_POST['create_attack'])) {
			
			try {

				$name = $database->clean($_POST['name']);
				$combat_text = $database->clean($_POST['combat_text']);
				$type = $database->clean($_POST['type']);
				$power = (int)$database->clean($_POST['power']);
				$purchase_cost = (int)$database->clean($_POST['purchase_cost']);
				
				if(!$combat_text) {
					throw new Exception("Invalid text");
				}
				
				if($type != 'melee' && $type != 'ranged') {
					throw new Exception("Invalid type");
				}
				
				if($power < 0) {
					throw new Exception("Invalid power");
				}
				if($purchase_cost < 0) {
					throw new Exception("Invalid HP");
				}
				
				//insert new attack into db
				$database->query("INSERT INTO `attacks` (`name`, `combat_text`, `type`, `power`, `purchase_cost`) VALUES ('$name', '$combat_text', '$type', '$power', '$purchase_cost')");
				if($database->affected_rows() > 0 ) {
					echo "attack created.";
				}
				
			} catch (Exception $e) {
				echo $e->getMessage();
			}
				
			
		}
		
		//Display form
		$label_width = 4;
		echo "<div id='login' style='margin-top:10%'>
			<h1> Create Attack</h1>
			<form action='?page=create_attack' method='POST'>
				<label style='width:{$label_width}em;'>Name:</label><input type='Text' name='name' /><br />
				<label style='width:{$label_width}em;'>Text:</label><input type='Text' name='combat_text' /><br />
				<label style='width:{$label_width}em;'>Type:</label>
								<select name='type'>
									<option value='melee'>Melee</option>
									<option value='ranged'>Ranged</option>
									<option value='ranged'>Magic</option>
								</select><br />
				<label style='width:{$label_width}em;'>Power:</label><input type='Number' name='power' /><br />
				<label style='width:{$label_width}em;'>Cost:</label><input type='Number' name='purchase_cost' /><br />
				<center><input type='submit' name='create_attack' value='Create' /></center />
			</form>
		</div>";


		if(!empty($_POST['create_part'])) {
			
			try {
				
				$part = $database->clean($_POST['part']);

					if(!$part) {
					throw new Exception("Invalid text");
				}
				
				//insert new attack into db
				$database->query("INSERT INTO `bodyparts` (`part`) VALUES ('$part')");
				if($database->affected_rows() > 0 ) {
					echo "part created.";
				}
			
			} catch (Exception $e) {
				echo $e->getMessage();
			}	

		}	
		
		//Display form
		echo "<div id='login' style='margin-top:220px;'>
			<form action='?page=create_attack' method='POST'>			
				<label style='width:{$label_width}em;'>BodyPart</label><input type='Text' name='part' /><br />
				<center><input type='submit' name='create_part' value='Create' /></center />
			</form>
		</div>";
	
	} else {
		echo "nope";
	}

}

function edit_attack() {
	
	
}

