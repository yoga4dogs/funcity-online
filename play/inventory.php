<?php 
//inventory.php

function inventory() {

	global $database;
	global $player;
	global $fish;
	global $inventory;
	global $self_link; 
	
	if($player->acc == 14) {
		$maxdrunk = 20;
	} else {
		$maxdrunk = 10;
	}
	
	//fish logic WIP
	$result3 = $database->query("SELECT * FROM `fishBucket` WHERE `id` = '{$player->id}'");
	$result4 = $database->query("SELECT * FROM `fish` ORDER BY `name`");
	$fish_inv = $result3->fetch_assoc();
	$fishes = array();
	while($fish = $database->fetch($result4)) {
		$fishes[$fish['id']] = $fish;
	}
	
	//use items
	if(!empty($_POST['use'])) {
		//use drink
		if ($_POST['item_type'] == 'drink') {
			if ($player->drunk < $maxdrunk) {
				$player->drunk += $_POST['item_effect'];
				if ($player->drunk > $maxdrunk) {
					$player->drunk = $maxdrunk;
				}
				//$database->query("UPDATE `inventory` SET `{$_POST['item_id']}` = `{$_POST['item_id']}` - 1 WHERE `id` = '{$player->id}'");
				$inventory->item[$_POST['item_id']]['qty'] -= 1;
				echo "<dialog open style='
				z-index: 10;
				transform: translate(0px, 150px);
				width: 220px;
				border: 0px;
				background-image: url(./images/tile4.jpg);
				background-size: 150%;
				background-position: center;
				box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
				font-family: MingLiU-ExtB, Microsoft Yi Baiti;
				'><div style='margin-top:-6px;'><center><p style='color:White';>
				{$_POST['item_usetext']}<br>
				(+ {$_POST['item_effect']} DRUNK)</p>
				<form method='dialog'>
					<button>CLOSE</button>
				</form></div>
				</dialog>";
			} else {
				echo "<dialog open style='
				z-index: 10;
				transform: translate(0px, 150px);
				width: 220px;
				border: 0px;
				background-image: url(./images/tile4.jpg);
				background-size: 150%;
				background-position: center;
				box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
				font-family: MingLiU-ExtB, Microsoft Yi Baiti;
				'><div style='margin-top:-6px;'><center><p style='color:White';>
				You are already too drunk.</p>
				<form method='dialog'>
					<button>CLOSE</button>
				</form></div>
				</dialog>";
			}
		}
		//use food
		if ($_POST['item_type'] == 'food') {
				if ($player->full + $_POST['item_effect'] <= 15) {
					$player->full += $_POST['item_effect'];
					$player->turns += $_POST['item_effect2'];
					//$database->query("UPDATE `inventory` SET `{$_POST['item_id']}` = `{$_POST['item_id']}` - 1 WHERE `id` = '{$player->id}'");
					$inventory->item[$_POST['item_id']]['qty'] -= 1;
					echo "<dialog open style='
					z-index: 10;
					transform: translate(0px, 150px);
					width: 220px;
					border: 0px;
					background-image: url(./images/tile4.jpg);
					background-size: 150%;
					background-position: center;
					box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
					font-family: MingLiU-ExtB, Microsoft Yi Baiti;
					'><div style='margin-top:-6px;'><center><p style='color:White';>
					{$_POST['item_usetext']}<br>
					(+ {$_POST['item_effect2']} TURNS)</p>
					<form method='dialog'>
						<button>CLOSE</button>
					</form></div>
					</dialog>";
				} else {
					echo "<dialog open style='
					z-index: 10;
					transform: translate(0px, 150px);
					width: 220px;
					border: 0px;
					background-image: url(./images/tile4.jpg);
					background-size: 150%;
					background-position: center;
					box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
					font-family: MingLiU-ExtB, Microsoft Yi Baiti;
					'><div style='margin-top:-6px;'><center><p style='color:White';>
					You are too full to eat that now.</p>
					<form method='dialog'>
						<button>CLOSE</button>
					</form></div>
					</dialog>";
				}
		}
		//use misc (includes fish)
		if ($_POST['item_type'] == 'misc' or $_POST['item_type'] == 'quest') {
			//fish bucket
			if($_POST['item_id'] == '22') {
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
				<b>FISH BUCKET</b>
				<table style='width:360px; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
				<tr>
					<th style='width:90%;'>&nbsp;</th>
					<th style='width:10%;'>&nbsp;</th>
				</tr>";
				foreach($fishes as $fish_id => $fish) {
					if($fish_inv[$fish_id] <= 0) {
						continue;
					}
					$tier_color = 'white';
					switch ($fish['tier']) {
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
					echo "<td><div style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;' title='{$fish['description']} (Tier: {$fish['tier']})'>
					<span style='background-color: {$tier_color};'>{$fish['name']} ({$fish_inv[$fish_id]})</span></div></td>
					<form action='./?page=inventory' method='POST'>";
					if($fish['combat'] == 1) {
						$type = "COMBAT";
						if($fish['combat_type'] == 'pet' or $fish['combat_type'] == 'none') {
							$type = "PET";
						}
						echo "<td align='center'>($type)</tr>";
					} else {
						echo "
						<td align='center'>
						<input type='hidden' name='fish_id' value='{$fish['id']}' />
						<input type='hidden' name='fish_name' value='{$fish['name']}' />
						<input type='hidden' name='fish_description' value='{$fish['description']}' />
						<input type='hidden' name='fish_value' value='{$fish['value']}' />
						<input type='hidden' name='fish_tier' value='{$fish['tier']}' />
						<input type='submit' name='fish_use' value='USE' /></form></tr>";
					}
				}
				echo "</table>
				<form method='dialog'>
					<br><button>CLOSE</button>
				</form>
				</center></div>
				</dialog>";
			}
		}
		$player->update();
		$inventory->update();
	}
	//use fish
	if(!empty($_POST['fish_use'])) {
		$fish_use_confusion_message = array("You grab two fish from the bucket and make them kiss lol",
		"You're not exactly sure what you're supposed to do with it, so you hit it against the table a few times before tossing it back into the bucket.", 
		"You put it in your mouth, but it tastes revolting so you spit it back into the bucket.",
		"You throw the fish out of your apartment window, but when you turn around its nestled safely back in the bucket.",
		"You stick your finger as deep into its mouth as possible before throwing up a little.",
		"You toss it back and forth in your hands a few times before shrugging and dropping it into the bucket."
		);
		
		$fish_choice = mt_rand(1, count($fish_use_confusion_message) - 1);
		
		echo "<dialog open style='
		z-index: 10;
		transform: translate(0px, 150px);
		width: 220px;
		border: 0px;
		background-image: url(./images/tile4.jpg);
		background-size: 150%;
		background-position: center;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
		font-family: MingLiU-ExtB, Microsoft Yi Baiti;
		'><div style='margin-top:-6px;'><center><p style='color:White';>
		{$fish_use_confusion_message[$fish_choice]}
		</p>
		<form method='dialog'>
			<button>CLOSE</button>
		</form></div>
		</dialog>";
	}
	
	require('statbox.php');
	
	echo "<center style='margin-top: -20px;'><h2 style='color:#054c00; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>TRASH HEAP</h2>";		
	
	echo "<div style='
	transform: translate(-180px, -10px);
	background-image: url(./images/skin.jpg);
	background-size: 320px 450px;
	width: 320px;
	height: 450px;
	overflow-x: hidden;
	overflow-y: auto;
	'>
	<center><table style='width:280px; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
	<tr>
		<th style='width:90%;'>&nbsp;</th>
		<th style='width:10%;'>&nbsp;</th>
	</tr>";
	//list all food
	echo "<tr><td><center><b>FOOD</b></center></td></tr>";
	for ($i = 1; $i < $inventory->num_items; $i++) {
		if($inventory->item[$i]['qty'] <= 0) {
			continue;
		}
		if($inventory->item[$i]['type'] != 'food') {
			continue;
		}
		//escape single quote
		$description = str_replace("'", "&#39;", $inventory->item[$i]['desc']);
		echo "<tr>";
		echo "<td><div style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;' title='{$description}'>{$inventory->item[$i]['name']} ({$inventory->item[$i]['qty']})</div></td>";
		//use button
		if ($inventory->item[$i]['usable'] == 1) {
			echo "<form action='./?page=inventory' method='POST'>";
			echo "<td align='center'>
			<input type='hidden' name='item_id' value='{$inventory->item[$i]['id']}' />
			<input type='hidden' name='item_name' value='{$inventory->item[$i]['name']}' />
			<input type='hidden' name='item_usetext' value='{$inventory->item[$i]['usetext']}' />
			<input type='hidden' name='item_type' value='{$inventory->item[$i]['type']}' />
			<input type='hidden' name='item_effect' value='{$inventory->item[$i]['effect1']}' />
			<input type='hidden' name='item_effect2' value='{$inventory->item[$i]['effect2']}' />
			<input type='submit' name='use' value='EAT' /></form>
			</td></tr>
			<tr><td></td></tr>";
		}
	}
	//list all drinks
	echo "<tr><td><center><b>DRINK</b></center></td></tr>";
	for ($i = 1; $i < $inventory->num_items; $i++) {
		if($inventory->item[$i]['qty'] <= 0) {
			continue;
		}
		if($inventory->item[$i]['type'] != 'drink') {
			continue;
		}
		//escape single quote
		$description = str_replace("'", "&#39;", $inventory->item[$i]['desc']);
		echo "<tr>";
		echo "<td><div style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;' title='{$description}'>{$inventory->item[$i]['name']} ({$inventory->item[$i]['qty']})</div></td>";
		//use button
		if ($inventory->item[$i]['usable'] == 1) {
			echo "<form action='?page=inventory' method='POST'>";
			echo "<td align='center'>
			<input type='hidden' name='item_id' value='{$inventory->item[$i]['id']}' />
			<input type='hidden' name='item_name' value='{$inventory->item[$i]['name']}' />
			<input type='hidden' name='item_usetext' value='{$inventory->item[$i]['usetext']}' />
			<input type='hidden' name='item_type' value='{$inventory->item[$i]['type']}' />
			<input type='hidden' name='item_effect' value='{$inventory->item[$i]['effect1']}' />
			<input type='submit' name='use' value='DRINK' /></form>
			</td></tr>
			<tr><td></td></tr>";
		}
	}
	echo "</table></center></div>";
	echo "<div style='
	transform: translate(180px, -460px);
	background-image: url(./images/skin.jpg);
	background-size: 320px 450px;
	background-attachment: fixed;
	width: 320px;
	height: 450px;
	overflow-x: hidden;
	overflow-y: auto;
	'>
	<center><table style='width:280px; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
	<tr>
		<th style='width:90%;'>&nbsp;</th>
		<th style='width:10%;'>&nbsp;</th>
	</tr>";
	
	//list all misc
	echo "<tr><td><center><b>MISC</b></center></td></tr>";
	for ($i = 1; $i < $inventory->num_items; $i++) {
		
		if($inventory->item[$i]['qty'] > 0) {
			if($inventory->item[$i]['type'] == 'misc' or $inventory->item[$i]['type'] == 'quest') {
		
				//escape single quote
				$description = str_replace("'", "&#39;", $inventory->item[$i]['desc']);
				echo "<tr>";
				echo "<td><div style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;' title='{$description}'>{$inventory->item[$i]['name']} ({$inventory->item[$i]['qty']})</td>";
				//use button
				if ($inventory->item[$i]['usable'] == 1) {
					echo "<form action='?page=inventory' method='POST'>";
					echo "<td align='center'>
					<input type='hidden' name='item_id' value='{$inventory->item[$i]['id']}' />
					<input type='hidden' name='item_name' value='{$inventory->item[$i]['name']}' />
					<input type='hidden' name='usetext' value='{$inventory->item[$i]['usetext']}' />
					<input type='hidden' name='item_type' value='{$inventory->item[$i]['type']}' />
					<input type='hidden' name='item_effect' value='{$inventory->item[$i]['effect1']}' />
					<input type='submit' name='use' value='USE' /></td>";
				}
				echo "</div>";
			}
		}
	}
	echo "</table></center></div>";

	
	echo "<center style='translate: 0 -437px;'><a href='./?page=apartment' style='color: white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>BACK</a><BR></center>";

}

