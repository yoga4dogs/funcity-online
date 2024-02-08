<?php

//healing shop

function healingShop() {
	global $database;
	global $player;
	global $inventory;
	global $self_link;
	
	$healed = 0;
	
	//tree for db update, dialog below, done to make statbox update with heals
	if($player->incombat != 1) {
		if(!empty($_POST['bathroom'])) {
			if($player->health < 100) {
				if($player->turns >= 1) {
					$player->turns -= 1;
					$player->drunk = 0;
					$player->health = 100;
					$healed = 1;
				}
			} elseif($player->drunk > 0) {
				$player->turns -= 1;
				$player->drunk = 0;
				$healed = 2;
			}
			$player->update();
		} elseif(!empty($_POST['liquor'])) {
			if($player->acc == 14) {
				if($player->drunk < 20) {
					if($player->money >= 1000) {
						$player->money -= 1000;
						$player->drunk += 10;
						if($player->drunk > 20) {
							$player->drunk = 20;
						}
						$healed = 2;
						$player->update();
					}
				}
			} else {
				if($player->drunk == 0){
					if($player->money >= 1000) {
						$player->money -= 1000;
						$player->drunk += 10;
						$healed = 2;
						$player->update();
					}			
				}
			}
		} elseif(!empty($_POST['small'])) {
			if($player->health > 0) {
				if($player->money >= 250) {
					if($player->health < 100) {
						$healed = 3;
					}
					$player->money -= 250;
					$player->health += 50;
				}				
				if($player->health >= 100) {
						$player->health = 100;
				}
				$player->update();
			}
		}
	}
	
	require('statbox.php');

	echo "<center style='margin-top: -20px;'><h2 style='color:#054c00; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>THE BAR</h2>
	<img src='./images/bartender.jpg' height='220px'></center><br>";
			
	//tree for dialog, player db update above
	if(!empty($_POST['bathroom'])) {
		if($player->incombat >= 1) {
			echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>I don't think you'll be able to sleep while being attacked...</center><br />";
		} else {
			if($healed == 1) {
				echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>That was surprisingly refreshing, you feel great! <br/>(<i>100/100 HP</i>) (<i>0 DRUNK</i>)</center><br/>";
			} elseif($healed == 2) {
				echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>You wake up feeling sober and refreshed. <br/>(<i>0 DRUNK</i>)</center><br />";
			} elseif($player->health >= 100) {
				echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>You don't need a nap right now.</center><br /><br />";	
			} else {
				echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>I know how this sounds, but you are too tired to take a nap.</center><br /><br />";	
			}
		}
	} elseif(!empty($_POST['liquor'])) {
		if($player->incombat >= 1) {
			echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>I don't think you'll be able to drink that while being attacked...</center><br />";
		} else {
			if($healed == 2) {
				echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''Try not to let any of that stuff touch your teeth. Spilled some on the bartop last week and it burned clean through to the basement.'' (<i>+10 DRUNK</i>)</center><br />";
			} elseif($player->drunk > 0) {	
				echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''I think you've had enough, pal.''</center><br /><br />";
			} else {
				$healed = 0;
				echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''No credit. Try coming back with some fucking money.''</center><br /><br />";
			}
		}
	} elseif(!empty($_POST['small'])) {
		if($player->health == 0) {
			echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>You're too dead to drink that.</center><br /><br />";
		} elseif($player->incombat >= 1) {
			echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>I don't think you'll be able to drink that while being attacked...</center><br />";
		} else {
			if($player->money >= 250) {
				$more_beer = 1;
				echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''Finally got that dead rat out of kegerator for ya', what a fuckin' mess. Bones and hair and blood everywhere... Christ, the smell... Well, bottoms up.''";
				if($healed == 3) {	
					echo " (<i>" . $player->health . "/100 HP</i>)</center><br/>";
				} else {
					echo " (<i>" . $player->health . "/100 HP</i>)</center><br/>";
				}
			} else {
				echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''No credit. Try coming back with some fucking money.''</center><br /><br />";
			}					
		}
	} elseif(!empty($_POST['sewer_quest1'])) {
		echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''Got a package needs picked up. <i>Sensitive</i> materials. Think you can handle it?''
		<form action='$self_link' method='POST'>
		<input type='submit' name='sewer_quest2' value='Just tell me where to go.' /></form></center>";
	} elseif(!empty($_POST['sewer_quest2'])) {
		echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''Guy works the door at a club downtown called <i>The Abattoir</i>. Give him this.''
		<form action='$self_link' method='POST'>
		<input type='submit' name='sewer_quest3' value='(Take Briefcase)' /></form></center>";
	} elseif(!empty($_POST['sewer_quest3'])) {
		echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''And don't try to rip me off, Mister Bathroom.''<br>";
		$description = str_replace("'", "&#39;", $inventory->item[24]['desc']);
		echo "(You got <span title='{$description}'><b>{$inventory->item[24]['name']}</b>!)</span></center><br>";
		$inventory->item[24]['qty'] = 1;
		$inventory->update();
		$player->sewer_quest = 1;
		$player->update();
	} elseif($player->sewer_quest == 1) {
		echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''You get my fucking package yet?''</center><br /><br />";
	} elseif($player->sewer_quest == 3 and !empty($_POST['sewer_quest4'])) {
		echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''You seem like the type who likes to hang out in the sewer.''<br>";
		$description = str_replace("'", "&#39;", $inventory->item[4]['desc']);
		echo "(You got <span title='{$description}'><b>{$inventory->item[4]['name']}</b>!)</span></center><br>";
		$inventory->item[4]['qty'] = 1;
		$inventory->item[25]['qty'] = 0;
		$inventory->update();
		$player->sewer_quest = 4;
		$player->update();
	} elseif($player->sewer_quest == 3) {
		echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''Not bad, kid. Color me impressed. Here, take this.''
		<form action='$self_link' method='POST'>
		<input type='submit' name='sewer_quest4' value='(Get Reward)' /></form></center>";
	} elseif(($player->level >= 5) and ($player->sewer_quest == 0)) {
		echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''Hey you, interested in making some quick Funcoin?''
		<form action='$self_link' method='POST'>
		<input type='submit' name='sewer_quest1' value='Go on.' /></form></center>";
	} else {
		echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>''Hey everybody, Mister Bathroom's here!<br/>Heh heh, don't have too much fun there.''</center><br />";
	}
	
	//display
	$label_width = 17;
	echo "
		<div class='centerDiv' style='padding: 15px; width: 400px; height: 110px; position: absolute; margin-top:0px; background-image: url(./images/skin.jpg);
		background-size: 600px 600px; font-family: MingLiU-ExtB, Microsoft Yi Baiti; box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
			<form action='?page=bar' method='POST'>
				<label style='width:{$label_width}em;' title='+HP'>One ";
				if($more_beer == 1) {
					echo "More ";
				}
				echo "Beer (250 ₵)</label>
					<input type='submit' name='small' value='Purchase' /><br /><br />
				<label style='width:{$label_width}em;' title='+DRUNK'>Shot of VIPER (1000 ₵)</label>
					<input type='submit' name='liquor' value='Purchase' /><br /><br />
				<label style='width:{$label_width}em;' title='+HP / -DRUNK / -TURN'>Take a nap in the bathroom (1)</label>
					<input type='submit' name='bathroom' value='Dont Mind If I Do' /><br />";
			//<center style='transform: translate(0px, 8px);'><a href='./?page=slots' style='color: BLACK; margin-top:10px;'>PLAY VIDEO SLOTS</a></center>
		echo "<br />
		<div style='transform: translate(0px, 24px); font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><center><a href='./?page=block' style='color: white; '>LEAVE</a></center></div>	
		</div>";
}