<?php

// attackShop.php

function attackShop() { 
	
	global $database;
	global $player;
	global $self_link;
	
	require('statbox.php');
	
	echo "<center style='margin-top: -20px;'><h2 style='color:#054c00; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>DAVE'S DISCOUNT WEAPONRY</h2>
	<img src='./images/pawn2.jpg' height='220px' height='200px'></center><br>";
	
//fetch attack data
	$result = $database->query("SELECT * FROM `attacks` ORDER BY `purchase_cost`");
	$attacks = array();
	while($attack = $database->fetch($result)) {
		$attacks[$attack['id']] = $attack;
	}
	if(!empty($_POST['buy'])) {
		$attack_id = (int)$_POST['attack_id'];
		
		try {
			if(!isset($attacks[$attack_id])) {
				throw new Exception("Invalid attack.");
			}
			if(isset($player->attacks[$attack_id])) {
				throw new Exception("<center>You already have this.</center>");
			}
			if($player->money < $attacks[$attack_id]['purchase_cost']) {
				throw new Exception("Insufficient funds.");
			}
			
			//purchase
			$player->money -= $attacks[$attack_id]['purchase_cost'];
			$player->attacks[$attack_id] = array();
			$player->update();
			
			//auto equip if nothing equipped
			if(!isset($player->equip)) {
				$equip = array($attack_id, $attack_id);
				
				try {
						
					foreach($equip as $id) {
						$player->equip = $equip;
					}
					
					$player->update();
								
				} catch(Exception $e) {
					echo $e->getMessage();
				}
			}
			
			echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''Thank you. Please come again.''</center>";
			
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	} else {
		//default text
		echo"<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>There is a <a href='./?page=recycle' style='color: white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>STRANGE MACHINE</a> in the corner of the shop...</center>";
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
			<th style='width:50%;'>Name</th>
			<th style='width:20%;'>Type</th>
			<th style='width:25%;'>Price</th>
			<th style='width:10%;'>&nbsp;</th>
		</tr>";
		foreach($attacks as $id => $attack) {
			if(isset($player->attacks[$id])) {
				continue;
			} elseif($attack['pawn'] != '1') {
				continue;
			} 
			
			echo "<tr align='center'>
				<td>{$attack['name']}</td>
				<td>" . ucwords($attack['type']) . "</td>
				<td>" . number_format($attack['purchase_cost']) . " ₵</td>
				<td>
					<form action='$self_link' method='POST'>
						<input type='hidden' name='attack_id' value='{$attack['id']}' />
						<input type='submit' name='buy' value='Buy' style='translate:10px 5px;'/>
					</form>
				</td>
				</tr>";
		}
		
		echo "</table></div><br>
		<center style='margin-top:-10px;'><a href='./?page=block' style='color: white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>LEAVE</a></center>";

}