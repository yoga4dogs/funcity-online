<?php

//apartment

function apartment() {
	global $database;
	global $player;
	global $self_link; 
	
	$inv_count = $database->query("SELECT * FROM `inventory`");
	$inv_rows = $inv_count->fetch_assoc();
	$inv_row_count = count($inv_rows);
	$inv_row_count  -= 1;
	
	$fish_count = $database->query("SELECT * FROM `fishBucket`");
	$fish_rows = $fish_count->fetch_assoc();
	$fish_row_count = count($fish_rows);
	$fish_row_count  -= 1;
	
	$tv = $database->query("SELECT * FROM `tv` ORDER BY RAND() LIMIT 1");
	$video = $database->fetch($tv);
	
	
	//reset post
	if((!empty($_POST['check'])) && (!empty($_POST['reset']))) {
			
		$null = null;

		$player->level = 1;
		$player->exp = 0;
		$player->exp_spend = 0;
		$player->health = 100;
		$player->max_health = 100;
		$player->money = 0;
		$player->strength = 1;
		$player->dexterity = 1;
		$player->endurance = 1;
		$player->attacks = $null;
		$player->equip = $null;
		$player->equipment = $null;
		$player->incombat = 0;
		$player->round_damage = 0;
		$player->turns = 50;
		$player->full = 0;
		$player->drunk = 0;
		$player->drug_price = 1;
		$player->drugs_bought = 0;
		
		$player->target_bool = 0;
		$player->target_id = 0;
		$player->target_count = 0;
		$player->target_total = 0;
		
		$player->head = 0;
		$player->torso = 0;
		$player->legs = 0;
		$player->hands = 0;
		$player->feet = 0;
		$player->acc = 0;
		$player->sewer_quest = 0;
		$player->sewerkey = 0;
		$player->pod_fish = 0;
		
		$player->resets += 1;
		
		$player->update();
		
		//reset inventory
		try {
			$inventory_reset = ""; 
			for ($i = 2; $i <= $inv_row_count; $i++) {
				$inventory_reset .= "`{$i}` = '0', ";
			}
			$inventory_reset .= "`1` = '0'";
			$database->query("UPDATE `inventory` SET {$inventory_reset} WHERE `id` = '{$player->id}'");
		} catch (Exception $e) {
			print($i);
		}
		//reset fish
		try {
			$fish_reset = ""; 
			for ($x = 2; $x <= $fish_row_count; $x++) {
				$fish_reset .= "`{$x}` = '0', ";
			}
			$fish_reset .= "`1` = '0'";
			$database->query("UPDATE `fishBucket` SET {$fish_reset} WHERE `id` = '{$player->id}'");
		} catch (Exception $e) {
			print($i);
		}
		
		//reset pop-up
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
				You wake up the next morning with a splitting headache and no memory of the last {$player->turns_played} days.</p>
				<form method='dialog'>
					<button>CLOSE</button>
				</form></div>
				</dialog>";
	}
		
	require('statbox.php');
	
	echo "<center style='margin-top: -20px;'><h2 style='color:#054c00; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>YOUR APARTMENT</h2>";
	
	echo "<center><div style='
			width:400px;
			height:400px;
			margin-left:auto;
			margin-right:auto;
			margin-top:20px;
			background-size:cover;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
			<img style='width:400px; height:400px;' src='./images/apartment.jpg' title='THERE IS NO WAY YOURE SLEEPING ON THAT. YOUR SKIN STILL HASNT GROWN BACK FROM THE LAST TIME.'/><br />
			<div style='transform: translate(0px, 63px); font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=block' style='color: white;'>LEAVE</a></div>
			</div></center/>";
		
		//INVENTORY
		echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left:-540px;
		margin-top:-164px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<a href='./?page=inventory' title='INVENTORY'><img src='./images/trash.jpg' width='160px' style='border: 10px outset #474747;'/></a><br /><center><a href='./?page=inventory' title='INVENTORY' style='color:white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>TRASH HEAP</a></center></div>";
		
		//GEAR
		echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left:-540px;
		margin-top:-380px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<a href='./?page=profile' title='CHANGE EQUIPMENT'><img src='./images/closet.jpg' width='160px' style='border: 10px outset #474747;'/></a><br /><center><a href='./?page=profile' title='CHANGE EQUIPMENT' style='color:white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>GEAR</a></center></div>";
		
		
		//COMPUTER
		echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left: 500px;
		margin-top:-160px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<a href='./?page=wall' title='GO ONLINE'><img src='./images/pc.jpg' width='160px' style='border: 10px outset #474747;'/></a><br /><center><a href='./?page=wall' title='GO ONLINE' style='color:white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>PC</a></center></div>";
		
		//RADIO
		echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left:500px;
		margin-top:60px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<a href='./?page=radio' title='LISTEN TO SHORTWAVE RADIO'><img src='./images/radio.jpg' width='160px' style='border: 10px outset #474747;'/></a><br /><center><a href='./?page=radio' title='LISTEN TO SHORTWAVE RADIO' style='color:white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>SHORTWAVE RADIO</a></center></div>";
		
		/** TV
		echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left:500px;
		margin-top:60px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<a href='./?page=tv' title='WATCH TV'><img src='./images/tv.jpg' width='160px' style='border: 10px outset #474747;'/></a><br /><center><a href='./?page=tv' title='WATCH TV' style='color:white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>TV</a></center></div>";
		<a href='./?page=profile' title='CHANGE EQUIPMENT'><img src='./images/closet.jpg' width='160px' style='border: 10px outset #474747;'/></a><br /><center><a href='./?page=profile' title='CHANGE EQUIPMENT' style='color:white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>GEAR</a></center></div>";
		*/
		
		//reset
		if ($player->level >=50) {
			echo "<div style='
			width:130px;
			height:60px;
			float:top;
			transform: translate(0px, -60px);
			background-image: url(./images/tile3.jpg);
			background-size: 170px 100px;
			padding: 20px;
			'><center><b>BLACKOUT</b><form method='POST'>
			(Are You sure?)<input type='checkbox' name='check' value='checkox_value'><br>
			<input type='submit' name='reset' value='Drink To Forget' /></select></center></div>";
			
		}
}

?>