<?php

//uptown area

global $self_link;
global $player;
global $inventory;

//process monster choice
	if(empty($_SESSION['monster_id']) && !empty($_POST['fight1'])) {
		if($player->turns <= 0) {
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
					font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
					
					<br/><center><div style='margin-top:20px; width:140px;'><center>
					You're too tired to go there.
					</center></div></div>";
		} else {
			$monster_id = (int)$_POST['monster_id1'];		
			try {
				$monster = new Monster($monster_id, $database);
				$_SESSION['monster_id'] = $monster_id;
				$player->lastadv = 1;
				$player->update();
			} catch (Exception $e) {
			}
		}
	} elseif(empty($_SESSION['monster_id']) && !empty($_POST['fight2'])) {
		
		if($player->turns <= 0) {
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
					font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
					
					<br/><center><div style='margin-top:20px; width:140px;'><center>
					You're too tired to go there.
					</center></div></div>";
		} else {
			if($player->level < 5) {
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
					font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
					
					<br/><center><div style='margin-top:20px; width:140px;'><center>
					You need to be level 5 to explore there.
					</center></div></div>";
			} else {
				$monster_id = (int)$_POST['monster_id2'];
				try {
					$monster = new Monster($monster_id, $database);
					$_SESSION['monster_id'] = $monster_id;
					$player->lastadv = 2;
					$player->update();
				} catch (Exception $e) {
				}
			}
		}

	} elseif(empty($_SESSION['monster_id']) && !empty($_POST['fight3'])) {
		if($player->turns <= 0) {
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
					font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
					
					<br/><center><div style='margin-top:20px; width:140px;'><center>
					You're too tired to go there.
					</center></div></div>";
		} else {
			if($player->level < 12) {
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
					font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
					
					<br/><center><div style='margin-top:20px; width:140px;'><center>
					You need to be level 12 to explore there.
					</center></div></div>";
			} else {
				$monster_id = (int)$_POST['monster_id3'];
				try {
					$monster = new Monster($monster_id, $database);
					$_SESSION['monster_id'] = $monster_id;
					$player->lastadv = 3;
					$player->update();
				} catch (Exception $e) {
				}
			}
		}
	} elseif(empty($_SESSION['monster_id']) && !empty($_POST['fight4'])) {
		if($player->turns <= 0) {
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
					font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
					
					<br/><center><div style='margin-top:20px; width:140px;'><center>
					You're too tired to go there.
					</center></div></div>";
		} else {
			if($player->level < 25) {
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
					font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
					
					<br/><center><div style='margin-top:20px; width:140px;'><center>
					You need to be level 25 to explore there.
					</center></div></div>";			} else {
				$monster_id = (int)$_POST['monster_id4'];
				try {
					$monster = new Monster($monster_id, $database);
					$_SESSION['monster_id'] = $monster_id;
					$player->lastadv = 4;
					$player->update();
				} catch (Exception $e) {
					
				}
			}
		}
	} elseif(empty($_SESSION['monster_id']) && !empty($_POST['fight5'])) {
		if($player->turns <= 0) {
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
					font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
					
					<br/><center><div style='margin-top:20px; width:140px;'><center>
					You're too tired to go there.
					</center></div></div>";
		} else {
			if($player->level < 40) {
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
					font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
					
					<br/><center><div style='margin-top:20px; width:140px;'><center>
					You need to be level 40 to explore there.
					</center></div></div>";		
			} else {
				$monster_id = (int)$_POST['monster_id5'];
				try {
					$monster = new Monster($monster_id, $database);
					$_SESSION['monster_id'] = $monster_id;
					$player->lastadv = 5;
					$player->update();
				} catch (Exception $e) {
					
				}
			}
		}

	} elseif(empty($_SESSION['monster_id']) && !empty($_POST['fight6'])) {
		if($player->turns <= 0) {
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
					font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
					
					<br/><center><div style='margin-top:20px; width:140px;'><center>
					You're too tired to go there.
					</center></div></div>";
		} else {
			if($player->sewer_quest == 1) {
				echo "<dialog open style='
						position: absolute;
						float: top;
						margin-left: 200px;
						margin-top: 100px;
						width: 300px;
						height: 208px;
						border: 0px;
						background-image: url(./images/tile4.jpg);
						background-size: 340px 240px;
						box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
						z-index: 2;
						font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
						
						<br/><center><div style='margin-top:12px; width:260px;'><center>
						A large, half-naked man stands in pool of what looks to be blood, blocking the door.<br><br>''That fat fuck bartender send you?''<br><br>
						<form action='$self_link' method='POST'>
						<input type='submit' name='sewer_abattoir1' value='(Hand Over Briefcase)' />
						</form>
						</center></div></dialog>";
				
			} elseif($player->level < 500) {
				echo "<dialog open style='
					position: absolute;
					float: top;
					margin-left: 200px;
					margin-top: 100px;
					width: 300px;
					height: 208px;
					border: 0px;
					background-image: url(./images/tile4.jpg);
					background-size: 340px 240px;
					box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
					z-index: 2;
					font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
					
					<br/><center><div style='margin-top:12px; width:260px;'><center>
					A large, half-naked man stands in pool of what looks to be blood, blocking the door.<br><br>''If you ain't got business here, Fuck Off.''<br><br>
					<form method='dialog'>
						<button>CLOSE</button>
					</form>
					</center></div></dialog>";
			} else {
				$monster_id = (int)$_POST['monster_id2'];
				try {
					$monster = new Monster($monster_id, $database);
					$_SESSION['monster_id'] = $monster_id;
					$player->lastadv = 6;
					$player->update();
				} catch (Exception $e) {
					
				}
			}
		
		}

	}
	if(!empty($_POST['sewer_abattoir1'])) {
		echo "<dialog open style='
		position: absolute;
		float: top;
		margin-left: 200px;
		margin-top: 100px;
		width: 300px;
		height: 280px;
		border: 0px;
		background-image: url(./images/tile4.jpg);
		background-size: 340px 320px;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
		z-index: 2;
		font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
		<br/><center><div style='margin-top:12px; width:260px;'><center>
		He checks the briefcase nervously before producing an antique datasette bearing the words \"PANZER DRAGOON SAGA\".<br><br>''Tell him we're even, but not to come around here for a while. People are still real sore about what he did to that last waitress.''<br><br>
		<form action='$self_link' method='POST'>
		<input type='submit' name='sewer_abattoir2' value='(Take Datasette)' />
		</form>
		</center></div></dialog>";
	} elseif(!empty($_POST['sewer_abattoir2'])) {
		echo "<dialog open style='
		position: absolute;
		float: top;
		margin-left: 200px;
		margin-top: 100px;
		width: 300px;
		height: 90px;
		border: 0px;
		background-image: url(./images/tile4.jpg);
		background-size: 340px 124px;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
		z-index: 2;
		font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>";
		$description = str_replace("'", "&#39;", $inventory->item[25]['desc']);
		echo "<br/><center><div style='margin-top:12px; width:260px;'><center>
		(You got <span title='{$description}'><b>{$inventory->item[25]['name']}</b>!)</span>
		<form method='dialog'>
			<button>(LEAVE)</button>
		</form>
		</center></div></dialog>";
		$player->sewer_quest = 3;
		$inventory->item[24]['qty'] = 0;
		$inventory->item[25]['qty'] = 1;
		$player->update();
		$inventory->update();
	}
	
?>