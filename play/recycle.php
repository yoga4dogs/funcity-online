<?php

//recycle cans

function recycle() {

	global $database;
	global $player;
	global $self_link;
	
	$superjackmult = 50;
	$jackmult = 20;
	$winmultpair = 3;
	$winmultsplit = 5;
	
	$bulk_mult = 1;
	
	$result1 = $database->query("SELECT * FROM `inventory` WHERE `id` = '{$player->id}'");
	$inv = $result1->fetch_assoc();		
	
	if(empty($_POST['small'])) {
		$wheel1 = 0;
		$wheel2 = 0;
		$wheel3 = 0;
	}	
		
	if(!empty($_POST['small']) || !empty($_POST['medium']) || !empty($_POST['large'])) {
		
		if($inv['3'] < 1) {
			
		} else {
		
			if(!empty($_POST['small'])) {
				$stake = 1;
				$bulk_mult = 1;
			}
			if(!empty($_POST['medium'])) {
				$stake = 5;
				$bulk_mult = 1.5;
			}
			if(!empty($_POST['large'])) {
				$stake = 25;
				$bulk_mult = 2;
			}
			
			if($inv['3'] >= $stake) {
				$wheel1 = mt_rand(1,10);
				$wheel2 = mt_rand(1,10);
				$wheel3 = mt_rand(1,10);
				
				$database->query("UPDATE `inventory` SET `3` = `3` - {$stake} WHERE `id` = '{$player->id}'");

			}
		}
	}
	
	
	if($wheel1 != 0) {
		$stake *= 100 * $bulk_mult;
		if($wheel1 == $wheel2 && $wheel1 == $wheel3 && $wheel1 == 7) {
			$player->money += $stake * $superjackmult;
		} elseif($wheel1 == $wheel2 && $wheel1 == $wheel3) {
			$player->money += $stake * $jackmult;
		} elseif($wheel1 == $wheel2 || $wheel2 == $wheel3) {
			$player->money += $stake * $winmultpair;
		} elseif($wheel1 == $wheel3) {
			$player->money += $stake * $winmultsplit;
		}
		$player->update();
	}
	
	require('statbox.php');
		
	echo "<center style='margin-top: -20px;'><h2 style='color:#054c00; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>FUNCITY RECYCLING</h2>";

	echo "<center><div style='
	width: 700px; 
	height: 400px; 
	margin-left: auto;
	margin-right: auto;
	margin-top: 20px;
	margin-bottom: 140px;
	float: bottom;
	background-image: url(./images/slots1.jpg);
	background-size: 700px;
	font-family: MingLiU-ExtB, Microsoft Yi Baiti;
	
	box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'></div></center>";
	
	echo "<div style='
		width:200px;
		height:200px;
		float:top;
		margin-left:-160px;
		margin-top:-380px;
		transform: translate(-160px, -60px);
		background-image: url(./images/slots/{$wheel1}.jpg);
		background-size: cover;";
		if($wheel1 != 0) {
		echo "box-shadow: 20px 20px 15px rgba(0,16,0,0.5);";
		}
		echo "'></div>";
	echo "<div style='
		width:200px;
		height:200px;
		float:top;
		margin-left:00px;
		margin-top:-180px;
		transform: translate(0px, -80px);
		background-image: url(./images/slots/{$wheel2}.jpg);
		background-size: cover;";
		if($wheel1 != 0) {
			echo "box-shadow: 20px 20px 15px rgba(0,16,0,0.5);";
		}
		echo "'></div>";
	echo "<div style='
		width:200px;
		height:200px;
		float:top;
		margin-left:200px;
		margin-top:-140px;
		transform: translate(140px, -140px);
		background-image: url(./images/slots/{$wheel3}.jpg);
		background-size: cover;";
		if($wheel1 != 0) {
			echo "box-shadow: 20px 20px 15px rgba(0,16,0,0.5);";
		}
		echo "'></div><br /><br /><br />";
	
	echo "<form action='?page=recycle' method='POST'>";
				
	if($inv['3'] < 1) {
		echo "<div style='
			height: 180px;'></div>";
	} else {
		
		echo "<div style='
			width:120px;
			height:60px;
			float:top;
			transform: translate(-280px, -60px);
			background-image: url(./images/tile4.jpg);
			background-size: 120px 60px;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
			font-family: MingLiU-ExtB, Microsoft Yi Baiti;
			color:White;
			'></input>
			<center>
			<h3 style='transform: translate(0px, 19px);'>CANS: {$inv['3']}</h3>
			</center>
			</div>";

		echo "<div style='
			width:120px;
			height:60px;
			float:top;
			transform: translate(-140px, -120px);
			background-image: url(./images/tile3.jpg);
			background-size: 120px 60px;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
			'></input>
			<center>
			<input style='margin-top: 18px;' type='submit' name='small' value='INSERT 1 CAN'/>
			</center>
			</div>";
		
		echo "<div style='
			width:120px;
			height:60px;
			float:top;
			transform: translate(0px, -180px);
			background-image: url(./images/tile3.jpg);
			background-size: 120px 60px;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
			'><br />
			<center>
			<input style='margin-top: 0px;' type='submit' name='medium' value='INSERT 5 CANS'/>
			</center>
			</div>";
			
		echo "<div style='
			width:120px;
			height:60px;
			float:top;
			transform: translate(140px, -240px);
			background-image: url(./images/tile3.jpg);
			background-size: 120px 60px;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
			'><br />
			<center>
			<input style='margin-top: 0px;' type='submit' name='large' value='INSERT 25 CANS'/>
			</center>
			</div>";
	}


	if($wheel1 != 0) {
		if($wheel1 == $wheel2 && $wheel1 == $wheel3 && $wheel1 = 7) {
			echo "<div style='
				position: absolute;
				float: top;
				margin-left: 150px;
				margin-top: -400px;
				width: 400px;
				height: 40px;
				z-index: 2;
				font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
				<br/>
				<div style='margin-top:5px;'><center><h1 style='color:White';>
					<marquee behavior='scroll' direction='left'>YOU WIN " . $stake * $superjackmult . " FUNCOINS!!!!</marquee>
				</div>
			</div>";
		} elseif($wheel1 == $wheel2 && $wheel1 == $wheel3) {
			echo "<div style='
				position: absolute;
				float: top;
				margin-left: 150px;
				margin-top: -400px;
				width: 400px;
				height: 40px;
				z-index: 2;
				font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
				<br/>
				<div style='margin-top:5px;'><center><h1 style='color:White';>
					<marquee behavior='scroll' direction='left'>YOU WIN " . $stake * $jackmult . " FUNCOINS!!!</marquee>
				</div>
			</div>";
		} elseif($wheel1 == $wheel2 || $wheel2 == $wheel3) {
			echo "<div style='
				position: absolute;
				float: top;
				margin-left: 150px;
				margin-top: -400px;
				width: 400px;
				height: 40px;
				z-index: 2;
				font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
				<br/>
				<div style='margin-top:5px;'><center><h1 style='color:White';>
					<marquee behavior='scroll' direction='left'>YOU WIN " . $stake * $winmultpair . " FUNCOINS!</marquee>
				</div>
			</div>";
		} elseif($wheel1 == $wheel3) {
			echo "<div style='
				position: absolute;
				float: top;
				margin-left: 150px;
				margin-top: -400px;
				width: 400px;
				height: 40px;
				z-index: 2;
				font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
				<br/>
				<div style='margin-top:5px;'><center><h1 style='color:White';>
					<marquee behavior='scroll' direction='left'>YOU WIN " . $stake * $winmultsplit . " FUNCOINS!!</marquee>
				</div>
			</div>";
		}
	}
	
	echo "<br /><center style='margin-top: -233px; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=weaponshop' style='color: white; margin'>BACK</a></center>";	
	
}