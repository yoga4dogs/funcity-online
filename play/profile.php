<?php 

//profile.php



function profile() {

	global $database;
	global $player;
	global $self_link; 
	
	//number of profile photos/character portraits
	$number_photos = 36;
	
	
	//character image
	
	echo "<div style='
	position: absolute;
	height: 400px;
	width: 225px;
	left: 460px;
	top: 160px;
	background-image: url(./images/users/" . $player->photo . ".jpg);
	background-repeat: no-repeat;
	background-size: 225px 400px;
	font-family: MingLiU-ExtB, Microsoft Yi Baiti;
	border: 10px outset #474747;
	box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'><center><form action='$self_link' method='POST'>
		<div class='centerDiv' style='position:absolute; bottom:-15px;'><input type='submit' name='down' value='<' /><input type='submit' name='empty' value='" . $player->photo . "' /><input type='submit' name='up' value='>' />
		</select></div><br />
	</div>";
	
	require('statbox.php');
	
	require('movelist.php');
	
	require('equip.php');
	
	require('equipIcons.php');

	echo "<br>
		<center style='translate: 0 50px;'><a href='./?page=apartment' style='color: white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>BACK</a><BR></center>";
	
	if(!empty($_POST['down'])) {
		
		$player->photo -= 1;
		if($player->photo < 1) {
			$player->photo = $number_photos;
		}
		$player->update();
		header("Refresh:0");
		
	}	
	if(!empty($_POST['up'])) {
		
		//SET IMAGES RANGE
		$player->photo += 1;
		if($player->photo > $number_photos) {
			$player->photo = 1;
		}
		$player->update();
		header("Refresh:0");
		
	}
	


}

