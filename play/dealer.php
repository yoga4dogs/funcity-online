<?php

//dealer

function dealer() {
	global $database;
	global $player;
	global $self_link; 
	
	$bought = 0;
	$mult = 200;
	$price = $player->drug_price;
	$price *= $mult;
	
	$result = $database->query("SELECT * FROM `attacks` ORDER BY `purchase_cost`");
	$attacks = array();
	while($attack = $database->fetch($result)) {
		$attacks[$attack['id']] = $attack;
	}
	$result1 = $database->query("SELECT * FROM `inventory` WHERE `id` = '{$player->id}'");
	$inv = $result1->fetch_assoc();	
	
	//tre to update turn logic
	if(!empty($_POST['buy'])) {
		if($player->money >= $price) {
			$player->money -= $price;
			$player->turns += 5;
			$player->drug_price *= 2;
			$player->drugs_bought += 1;
			$bought = 1;
			$player->update();
		}
	} elseif(!empty($_POST['buy_contraption'])) {
		if($inv['3'] >= 25) {
			$database->query("UPDATE `inventory` SET `3` = `3` - 25 WHERE `id` = '{$player->id}'");
			$bought = 1;
			$player->attacks[21] = array();
			$player->update();
			
		}
	}
	
	require('statbox.php');
	
	echo "<center style='margin-top: -20px;'><h4 style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''...''</h4>";
	
			if(!empty($_POST['buy']) && $bought == 1) {
				echo "<img style='height:240px;' src='./images/worms.jpg' title='...'/>";
			} elseif(!empty($_POST['buy_contraption']) && $bought == 1) {
				echo "<img style='height:240px;' src='./images/dealer2.jpg' title='...'/>";
			} else {
				echo "<img style='height:240px;' src='./images/dealer2.jpg' title='...'/>";
			}
			
		//tree to update dialog logic
		echo "<div style='
			padding: 10px; 
			width: 400px;
			height: 140px;
			position: absolute;
			transform: translate(145px, 20px);
			background-image: url(./images/skin.jpg);
			background-size: 600px 600px;
			font-family: MingLiU-ExtB, Microsoft Yi Baiti;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>";		
		if(!empty($_POST['buy'])) {
			if($bought == 1) {
				echo "<div style='transform: translate(0px, 20px);'>
					He hands you a small glass jar containing a single black worm. You unscrew the jar and hold the rim up to your eye. The worm immediately burrows itself deep into your tear duct. FUCK! You feel amazing! (<i>+ 5 TURNS</i>)
					</div>";
			} else {
				echo "<div style='transform: translate(0px, 60px);'>
					''Come back when you've got the coins.''
					</div>";
			} 
		} elseif(!empty($_POST['buy_contraption'])) {
			if($bought == 1) {
				echo "<div style='transform: translate(0px, 30px);'>
					''You're been a good customer man, you like to get fucked up a lot. Me too. Take this. And, uh, make sure you're fucked up when you turn it on.''<br />(Got <i>PSYCHIC CONTRAPTION</i>)
					</div>";
			} else {
				echo "<div style='transform: translate(0px, 50px);'>
					''Come back when you've got the cans.''
					</div>";
			}
		} else {
			echo "<div style='transform: translate(0px, 60px);'>
				''...''
				</div>";
		}

	echo "</div>
		<center style='transform: translate(0px, 195px);'>
		<form action='?page=dealer' method='POST'>";
		if($player->drugs_bought >= 10) {
			if(!isset($player->attacks[21])) {
				echo "<input type='submit' name='buy_contraption' value='... (25 CANS)' />";
			}
		}			
		echo "<input type='submit' name='buy' value='... (" . $player->drug_price * $mult . " FUN₵)' /><br />
		<div style='transform: translate(0px, 10px);'><a href='./?page=alleys' style='color: white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;''>LEAVE</a></div>";
		
	$player->update();

}

?>