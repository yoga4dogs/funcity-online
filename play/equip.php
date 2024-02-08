<?php

//weapon
$result = $database->query("SELECT * FROM `attacks` ORDER BY `id`");
$attacks = array();
while($attack = $database->fetch($result)) {
	$attacks[$attack['id']] = $attack;
}

if(!empty($_POST['equip'])) {
		$equip1 = $_POST['equip1'];
		$equip2 = $_POST['equip2'];
		
		$equip = array($equip1, $equip2);
		
		try {
				
			foreach($equip as $id) {
				$player->equip = $equip;
			}
			
			$player->update();
						
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	}

if(is_array($player->attacks)) {
	

	
	echo "<div style='margin-top:0px; translate: 0px 20px;'>
	<center><form action='$self_link' method='POST'>
		<select name = 'equip1'>";
	foreach($player->attacks as $id => $attack) {
		echo "<option value = '$id'";
			 if($player->equip[0] == $id) {
				 echo " selected";
			 }
			 echo ">";
			 if($attacks[$id]['type'] == magic) {
				 echo "";
			 }
			 echo "{$attacks[$id]['name']}";
			 if($attacks[$id]['type'] == magic) {
				 echo " ({$attacks[$id]['purchase_cost']} DP)</option>";
			 } else {
				echo ": {$attacks[$id]['power']}</option>";	
			 }				
	}
	if($inventory->item[22]['qty'] > 0) {
		echo "<option value = 'fish'";
		if($player->equip[0] == 'fish') {
			echo " selected";
		}
		echo ">Fish Bucket</option>";
	}
	echo "</select><br />";
	echo "<select name = 'equip2'>";
	foreach($player->attacks as $id => $attack) {
		echo "<option value = '$id'";
			 if($player->equip[1] == $id) {
				 echo " selected";
			 }
			 echo ">";
			 if($attacks[$id]['type'] == magic) {
				 echo "";
			 }
			 echo "{$attacks[$id]['name']}";
			 if($attacks[$id]['type'] == magic) {
				 echo " ({$attacks[$id]['purchase_cost']} DP)</option>";
			 } else {
				echo ": {$attacks[$id]['power']}</option>";	
			 }						
	}
	if($inventory->item[22]['qty'] > 0) {
		echo "<option value = 'fish'";
		if($player->equip[1] == 'fish') {
			echo " selected";
		}
		echo ">Fish Bucket</option>";
	}
	echo "</select>";

	echo "<br /><input type='submit' name='equip' value='>Change Weapons<' /></center>
	</form>
	</div></div></div>";
	if(!empty($_POST['equip'])) {
		header("Refresh:0");
	}
}

?>