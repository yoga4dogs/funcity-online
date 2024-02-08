<?php

//equipPages.php
//functions for creating and editing equips

function create_equip() {
	global $database;
	global $player;
	global $self_link;
	
	if($player->id == 23) {
	
		if(!empty($_POST['create_equip'])) {
			
			try {

				$name = $database->clean($_POST['name']);
				$slot = $database->clean($_POST['slot']);
				$power = 0;
				$stat = $database->clean($_POST['stat']);
				$purchase_cost = (int)$database->clean($_POST['purchase_cost']);
				
				if(!$name) {
					throw new Exception("Invalid name");
				}
				
				if(!$stat) {
					throw new Exception("Invalid desc");
				}
				
				if($power < 0) {
					throw new Exception("Invalid power");
				}
				if($purchase_cost < 0) {
					throw new Exception("Invalid cost");
				}
				
				//insert new equip into db
				$database->query("INSERT INTO `equipment` (`name`, `slot`, `power`, `stat`, `purchase_cost`) VALUES ('$name', '$slot', '$power', '$stat', '$purchase_cost')");
				if($database->affected_rows() > 0 ) {
					echo "equip created.";
				}
				
			} catch (Exception $e) {
				echo $e->getMessage();
			}
				
			
		}
		
		//Display form
		$label_width = 4;
		echo "<div id='login' style='margin-top:10%'>
		<h1>Create Equipment</h1>
			<form action='?page=create_equip' method='POST'>
				<label style='width:{$label_width}em;'>Name:</label><input type='Text' name='name' /><br />
				<label style='width:{$label_width}em;'>Slot:</label><input type='Text' name='slot' /><br />";
				//<label style='width:{$label_width}em;'>Power:</label><input type='Text' name='power' /><br />
				echo "<label style='width:{$label_width}em;'>Desc:</label><input type='Text' name='stat' /><br />
				<label style='width:{$label_width}em;'>Cost:</label><input type='Number' name='purchase_cost' /><br />
				<center><input type='submit' name='create_equip' value='Create' /></center />
			</form>
		</div>";
	
	} else {
		echo "nope";
	}

}

function edit_equip() {
	
	
}

