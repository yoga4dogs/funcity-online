<?php

// equipShop.php

function equipShop() { 
	
	global $database;
	global $player;
	global $self_link;
	
	require('statbox.php');
	
	echo "<center style='margin-top: -20px;'><h2 style='color:#054c00; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>PLATO'S ALLEGORY OF HIS CLOSET</h2>
	<img src='./images/clothes1.jpg' height='220px' height='200px'></center><br>";

//fetch equip data
	$result = $database->query("SELECT * FROM `equipment` ORDER BY `purchase_cost`");
	$equips = array();
	while($equip = $database->fetch($result)) {
		$equips[$equip['id']] = $equip;
	}
	if(!empty($_POST['buy'])) {
		$equip_id = (int)$_POST['equip_id'];
		
		try {
			if(!isset($equips[$equip_id])) {
				throw new Exception("Invalid equip.");
			}
			if(isset($player->equipment[$equip_id])) {
				throw new Exception("<center>You already have this.</center>");
			}
			if($player->money < $equips[$equip_id]['purchase_cost']) {
				throw new Exception("Insufficient funds.");
			}
			
			//purchase
			//print_r($equip_id);
			$player->money -= $equips[$equip_id]['purchase_cost'];
			$player->equipment[$equip_id] = array();
			$player->update();
			
			echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''Thank you. Please come again.''</center>";
			
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	} else {
		//default text
		echo"<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''Welcome to my website.''</center>";
	}

	//display form
	echo "<div style='
		width: 500px;
		height: 180px;
		background-image: url(./images/skin.jpg);
		background-size: 500px 360px;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
		padding: 3px;
		margin-left: auto;
		margin-right: auto;
		margin-top: 10px;
		overflow-x: hidden;
		overflow-y: auto;
		display: flex;'>
		<table class='center' style='width:400px; transform: translate(8%, 0%); font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
		<tr>
			<th style='width:15%;'>&nbsp;</th>
			<th style='width:50%;'>Name</th>
			<th style='width:5%;'>Slot</th>
			
			<th style='width:25%;'>Price</th>
			<th style='width:15%;'>&nbsp;</th>
		</tr>";
		foreach($equips as $id => $equip) {
			
			if(isset($player->equipment[$id])) {
				continue;
			}
			if($equip['purchase_cost'] == 0) {
				continue;
			}
			
			if($equip['slot'] != 'acc') {
				$dr = "(DR: {$equip['power']})";
			} else {
				$dr = "";
			}
			
			echo "<tr align='center'>
				<td><img style='border:4px solid #654321' src='./images/equips/{$equip['id']}.jpg' width='60px' title='{$equip['stat']} {$dr}'/></td>
				<td><span title='{$equip['stat']} {$dr}'>{$equip['name']}</span></td>
				<td><span title='{$equip['stat']} {$dr}'>" . ucwords($equip['slot']) . "</span></td>
				<td>" . number_format($equip['purchase_cost']) . " ₵</td>
				<td>
					<form action='$self_link' method='POST'>
						<input type='hidden' name='equip_id' value='{$equip['id']}' />
						<input type='submit' name='buy' value='Buy' style='translate:10px 5px;'/>
					</form>
				</td>
				</tr>";
		}
		
		echo "</table></div><br>
		<center style='margin-top:-10px;'><a href='./?page=block' style='color: white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>LEAVE</a></center>";

}