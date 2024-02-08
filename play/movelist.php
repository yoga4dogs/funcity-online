<?php

global $database;
global $player;
global $fish;
global $inventory;
global $self_link; 

$label_width = 3.5;

if(!empty($_POST['equipment'])) {
	$player->head = $_POST['head'];
	$player->torso = $_POST['torso'];
	$player->legs = $_POST['legs'];
	$player->hands = $_POST['hands'];
	$player->feet = $_POST['feet'];
	$player->acc = $_POST['acc'];
	//print_r($player->torso);
	if($player->acc == 14) {
		$max_drunk = 20;
	} else {
		$max_drunk = 10;
	}
	if($player->drunk > $max_drunk) {
		$player->drunk = $max_drunk;
	}
	$player->update();
}
//install fish in aquarium pod 
if(!empty($_POST['fish_use'])) {
	//echo "{$fish->fish[$_POST['fish_id']]['name']} [INSTALLED]";
	$fish->fish[$_POST['fish_id']]['qty'] -= 1;
	if($player->pod_fish != 0) {
			$fish->fish[$player->pod_fish]['qty'] += 1;
	}
	$player->pod_fish = $_POST['fish_id'];
	$fish->update();
	$player->update();
}

if($player->acc == 22) {
	$top = 100;
} else {
	$top = 30;
}
$div_height = 310 + $top;
$margin_top = 90 - ($top / 2);
	
//fish bucket
if(!empty($_POST['change_fish'])) {
	echo "<dialog open style='
	z-index: 10;
	transform: translate(0px, 80px);
	width: 440px;
	height: 300px;
	border: 0px;
	background-image: url(./images/skin.jpg);
	background-size: 150%;
	background-position: center;
	box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
	font-family: MingLiU-ExtB, Microsoft Yi Baiti;
	overflow-y: auto;
	border: 8px solid green;'>
	<div style='margin-top:-6px;'>
	<center>
	<b>INSERT FISH:</b>
	<table style='width:360px; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
	<tr>
		<th style='width:90%;'>&nbsp;</th>
		<th style='width:10%;'>&nbsp;</th>
	</tr>";
	for ($i = 1; $i < $fish->num_fish - 4; $i++) {
							//print_r($fish->num_fish);
							if($fish->fish[$i]['qty'] == 0) {
								continue;
							}
							$tier_color = 'white';
							switch ($fish->fish[$i]['tier']) {
								case 1:
									$tier_color = 'none';
									break;
								case 2:
									$tier_color = 'lightgreen';
									break;
								case 3:
									$tier_color = 'lightblue';
									break;
								case 4:
									$tier_color = 'pink';
									break;
								case 5:
									$tier_color = 'gold';
									break;	
								case 6:
									$tier_color = 'red';
									break;	
							}
							echo "<td><div style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;' title='{$fish->fish[$i]['desc']} (Tier: {$fish->fish[$i]['tier']})'>
							<span style='background-color: {$tier_color};'>{$fish->fish[$i]['name']} ({$fish->fish[$i]['qty']})</span></div></td>
							<form action='$self_link' method='POST'>
							<td align='center'>
							<input type='hidden' name='fish_id' value='{$fish->fish[$i]['id']}' />
							<input type='hidden' name='fish_name' value='{$fish->fish[$i]['name']}' />
							<input type='hidden' name='fish_description' value='{$fish->fish[$i]['description']}' />
							<input type='hidden' name='fish_value' value='{$fish->fish[$i]['value']}' />
							<input type='hidden' name='fish_tier' value='{$fish->fish[$i]['tier']}' />
							<input type='submit' name='fish_use' value='INSERT' /></form></tr>";
							$x += 1;
							
						}
						if($x == 0) {
							echo "<option value = 'none' title='You don't have any fish.'>Empty</option>";
						}

	echo "</table>
	<form method='dialog'>
		<br><button>CLOSE</button>
	</form>
	</center></div>
	</dialog>";
}

echo "<div style='
	position: absolute;
	width: 280px; 
	height: {$div_height}px; 
	margin-left: 10px;
	margin-top: {$margin_top}px;
	background-image: url(./images/tile1.jpg);
	background-size: 280px {$div_height}px;
	box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
	font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
	
	<div style='
	padding: 10px;
	width: 240px;
	height: 140px;
	margin-left:auto;
	margin-right: auto;
	margin-top: 25px;'>

	<center><strong>EQUIPPED:</strong></center>";
		//equipment
		$result = $database->query("SELECT * FROM `equipment` ORDER BY `purchase_cost`");
		$equips = array();
		while($equip = $database->fetch($result)) {
			$equips[$equip['id']] = $equip;
		}
				
		echo "<div style='translate: 5px 10px;'>";
		echo"<form action='$self_link' method='POST'>";
		
		//head
		echo "<label style='width:{$label_width}em;'>Head:</label>";
		echo "<select name = 'head' title='{$equips[$player->head]['stat']} (DR: {$equips[$player->head]['power']})'>";
		echo "<option value = '0'>None</option>";
		foreach($equips as $id => $equip) {
			if(!isset($player->equipment[$id])) {
				continue;
			}
			if($equip['slot'] == 'head') {
			 echo "<option value = '$id'";
			 if($player->head == $equip['id']) {
				 echo " selected";
			 }
			 echo " title='{$equips[$id]['stat']} (DR: {$equips[$id]['power']})'>{$equips[$id]['name']}</option>";
			}
		}
		echo "</select><br />";

		//torso
		echo "<label style='width:{$label_width}em;'>Torso:</label>";
		echo "<select name = 'torso' title='{$equips[$player->torso]['stat']} (DR: {$equips[$player->torso]['power']})'>";
		echo "<option value = '0'>None</option>";
		foreach($equips as $id => $equip) {
			if(!isset($player->equipment[$id])) {
				continue;
			}
			if($equip['slot'] == 'torso') {
			 echo "<option value = '$id'";
			 if($player->torso == $equip['id']) {
				 echo " selected";
			 }
			 echo " title='{$equips[$id]['stat']} (DR: {$equips[$id]['power']})'>{$equip['name']}</option>";
			}
		}
		echo "</select><br />";
		
		//legs
		echo "<label style='width:{$label_width}em;'>Legs:</label>";
		echo "<select name = 'legs' title='{$equips[$player->legs]['stat']} (DR: {$equips[$player->legs]['power']})'>";
		echo "<option value = '0'>None</option>";
		foreach($equips as $id => $equip) {
			if(!isset($player->equipment[$id])) {
				continue;
			}
			if($equip['slot'] == 'legs') {
			 echo "<option value = '$id'";
			 if($player->legs == $equip['id']) {
				 echo " selected";
			 }
			 echo " title='{$equips[$id]['stat']} (DR: {$equips[$id]['power']})'>{$equip['name']}</option>";
			}
		}
		echo "</select><br />";
		
		//Hands
		echo "<label style='width:{$label_width}em;'>Hands:</label>";
		echo "<select name = 'hands' title='{$equips[$player->hands]['stat']} (DR: {$equips[$player->hands]['power']})'>";
		echo "<option value = '0'>None</option>";
		foreach($equips as $id => $equip) {
			if(!isset($player->equipment[$id])) {
				continue;
			}
			if($equip['slot'] == 'hands') {
			 echo "<option value = '$id'";
			 if($player->hands == $equip['id']) {
				 echo " selected";
			 }
			 echo " title='{$equips[$id]['stat']} (DR: {$equips[$id]['power']})'>{$equip['name']}</option>";
			}
		}
		echo "</select><br />";
		
		//feet
		echo "<label style='width:{$label_width}em;'>Feet:</label>";
		echo "<select name = 'feet' title='{$equips[$player->feet]['stat']} (DR: {$equips[$player->feet]['power']})'>";
		echo "<option value = '0'>None</option>";
		foreach($equips as $id => $equip) {
			if(!isset($player->equipment[$id])) {
				continue;
			}
			if($equip['slot'] == 'feet') {
			 echo "<option value = '$id'";
			 if($player->feet == $equip['id']) {
				 echo " selected";
			 }
			 echo " title='{$equips[$id]['stat']} (DR: {$equips[$id]['power']})'>{$equip['name']}</option>";
			}
		}
		echo "</select><br />";
		
		//acc
		echo "<label style='width:{$label_width}em;'>ACC:</label>";
		echo "<select name = 'acc' title='{$equips[$player->acc]['stat']}";
		 if($player->acc == 22 and $player->pod_fish > 0) {
			 echo " (INSTALLED: {$fish->fish[$player->pod_fish]['name']})";
		 }
		 echo "'>";
		echo "<option value = '0'>None</option>";
		foreach($equips as $id => $equip) {
			if(!isset($player->equipment[$id])) {
				continue;
			}
			if($equip['slot'] == 'acc') {
			 echo "<option value = '$id'";
			 if($player->acc == $equip['id']) {
				 echo " selected";
			 }
			 echo " title='{$equips[$id]['stat']}";
			 if($player->acc == 22 and $player->pod_fish > 0) {
				 echo " (INSTALLED: {$fish->fish[$player->pod_fish]['name']})";
			 }
			 echo "'>{$equip['name']}</option>";
			}
		}
		echo "</select>";
		if($player->acc == 22) {
			echo "<br><center>
			<b>{$fish->fish[$player->pod_fish]['name']}</b>:<br>
			[+{$fish->fish[$player->pod_fish]['equip_value']} {$fish->fish[$player->pod_fish]['equip_effect']}]<br>
			<input type='submit' name='change_fish' value='(Change Fish)' />
			</center>";
		}
		echo "<br />
		<center><input type='submit' name='equipment' value='>Change Equipment<' /></form></center>";
		
		echo "</center></div>";