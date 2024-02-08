<?php

global $self_link;

$label_width = 3;

$level_mult = $player->level*$player->level*10;

$result1 = $database->query("SELECT * FROM `inventory` WHERE `id` = '{$player->id}'");
$inv = $result1->fetch_assoc();

echo "
	<div style='
		position: absolute;
		width: 240px;
		transform: translate(-280px, 0px);
		'><center><img width='160px' src='./images/users/" . $player->photo . ".jpg' /></center></div>
		
	<div style='
	width: 240px; 
	height: 240px; 
	margin-left: -280px;
	margin-top: 270px;
	float: left;
	background-image: url(./images/tile1.jpg);
	background-size: 240px 240px;
	font-family: MingLiU-ExtB, Microsoft Yi Baiti;
	
	box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
	
	<div style='
	padding: 10px;
	width: 160px;
	height: 150px;
	margin-left:auto;
	margin-right: auto;
	margin-top: -10px;'>
		<br />
		<b>{$player->login} ({$player->resets})</b><br />
		
		<label style='width:{$label_width}em;'>LVL:</label> {$player->level} ";
		if($player->level >= 50) {
			echo "(!!!)";
		} else {
			echo "(".number_format($player->exp).")";
		}
		echo "<br />
		
		<label style='width:{$label_width}em;'>HP:</label> {$player->health}/{$player->max_health}<br />
		<label style='width:{$label_width}em;'>DRUNK:</label> {$player->drunk}/";
		if($player->acc == 14) {
			echo "20";
		} else {
			echo "10";
		}
		echo " DP<br />
		<label style='width:{$label_width}em;'>FULL:</label> {$player->full}<br />	
		<label style='width:{$label_width}em;'>STR:</label> {$player->strength}<br />
		<label style='width:{$label_width}em;'>DEX:</label> {$player->dexterity}<br />
		<label style='width:{$label_width}em;'>END:</label> {$player->endurance}<br />
		<label style='width:{$label_width}em;'>FUN₵:</label> " . number_format($player->money) . "<br />";
		/**
		if($player->can_bag == 1) {
			echo "<label style='width:{$label_width}em;'>CANS:</label> {$inv['3']}<br />";
		}
		*/
		echo "<label style='width:{$label_width}em;'>TURNS:</label> {$player->turns}<br />";
		
		
	if($player->exp_spend >= $level_mult) {	
		if(!empty($_POST['str'])) {
			$player->exp_spend -= $level_mult;		
			$player->strength += 1;
			$player->level += 1;
		}	
		if(!empty($_POST['dex'])) {
			$player->exp_spend -= $level_mult;		
			$player->dexterity += 1;
			$player->level += 1;
		}	
		if(!empty($_POST['end'])) {
			$player->exp_spend -= $level_mult;		
			$player->endurance += 1;
			$player->level += 1;
		}
		
		$player->update();
	}
	
	echo "</div></div>";
	
if($player->exp_spend >= $level_mult) {	
	
	echo "<div style='
	position: absolute;
	float: top;
	margin-left: 250px;
	margin-top: 100px;
	width: 200px;
	height: 120px;
	background-image: url(./images/tile4.jpg);
	background-size: 200px 120px;
	box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
	z-index: 2;
	font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>";
	
	echo "<br/><div style='margin-top:5px; margin-top:-6px;'><center><h2 style='color:White';><marquee behavior='scroll' direction='left'>LEVEL UP! &emsp;&emsp;&emsp; GOOD JOB!</marquee></h2><br/><form action='$self_link' method='POST' style='margin-top:-40px;'>
			<input type='submit' name='str' value='STR' />
			<input type='submit' name='dex' value='DEX' />
			<input type='submit' name='end' value='END' />
			</form></center></div></div>";
}
		
		
	if(!empty($_POST['str']) || !empty($_POST['dex']) || !empty($_POST['end'])) {
		header("Refresh:0");
	}
		
	

		
?>