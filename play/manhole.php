<?php

//manhole

function manhole() {
	global $database;
	global $player;
	global $fish;
	global $inventory;
	global $self_link; 
		
	$fisher_message = "Could't resist the call of the sea, could you?";
	$fish_convo = 0;
	$pod_get = 0;
	
	//keycheck
	if($inventory->item[4]['qty'] == 0) {
		echo "fuck off";
	} else {
		//get pod
		if(!isset($player->equipment[22]) and $player->fish_caught >= 50) {
			$pod_get = 1;
			$player->equipment[22] = array();
			$player->update();
			$fisher_message = "You're a natural fisherman, kid. I want you to have this.";
		//welcome
		} elseif ($inventory->item[8]['qty'] == 0) {
			$fish_convo = 1;
			$fisher_message = "Well hey, don't get many visitors down here anymore.";

			if(!empty($_POST['what'])) {
				$fisher_message = "Its my home! And the best damn fishing spot in all of Funcity.";
				$fish_convo = 2;
			}
			if(!empty($_POST['rod'])) {
				$fisher_message = "You ain't never fished before? Take these and give it a try.";
				$inventory->item[8]['qty'] = 1;
				$inventory->item[22]['qty'] = 1;
				$inventory->update();
				$fish_convo = 3;
			}
		}
		//have rod and had conversation
		if ($inventory->item[8]['qty'] != 0 or $inventory->item[19]['qty'] != 0 or $fish_convo == 3) {
			if(!empty($_POST['fish'])) {
				if($_POST['bait'] == 1) {
					$fish_rare = mt_rand(10,59);
				} elseif($_POST['bait'] == 2) {
					$fish_rare = mt_rand(40,89);
				} elseif($_POST['bait'] == 23) {
					$fish_rare = mt_rand(75,100);
				}
				//rod break chance
				if($_POST['rod'] == 8) {
					$rod_chance = 3;
				}
				if($_POST['rod'] == 19) {
					$rod_chance = 4;
				}
				//fish rare tier bait
				if(mt_rand(0,200 == 1) and $fish->fish[34]['qty'] > 0) {
					$resultFish = $database->query("SELECT * FROM `fish` WHERE `id` = '34' ORDER BY RAND() LIMIT 1");
					$fisher_message = "That's an evil creature, I will not abide it in my home.";
				} elseif($fish_rare <= 50) {
					$resultFish = $database->query("SELECT * FROM `fish` WHERE `tier` = '1' ORDER BY RAND() LIMIT 1");
					$fisher_message = "Nice catch there, kiddo.";
				} elseif($fish_rare <= 75) {
					$resultFish = $database->query("SELECT * FROM `fish` WHERE `tier` = '2' ORDER BY RAND() LIMIT 1");
					$fisher_message = "Nice catch there, kiddo.";
				} elseif($fish_rare <= 90) {
					$resultFish = $database->query("SELECT * FROM `fish` WHERE `tier` = '3' ORDER BY RAND() LIMIT 1");
					$fisher_message = "Nice catch there, kiddo.";
				} elseif($fish_rare <= 99) {
					$resultFish = $database->query("SELECT * FROM `fish` WHERE `tier` = '4' ORDER BY RAND() LIMIT 1");
					$fisher_message = "Nice catch there, kiddo.";
				} else {
					$resultFish = $database->query("SELECT * FROM `fish` WHERE `tier` = '5' ORDER BY RAND() LIMIT 1");
					$fisher_message = "Holy moley, sprout, you caught the big one!";
				}
				$caught_fish = $resultFish->fetch_assoc();	
				
				if($inventory->item[$_POST['bait']['qty']] > 0) {
					$inventory->item[$_POST['bait']]['qty'] -= 1;
					$inventory->update();
					$player->update();
					if(mt_rand(1,$rod_chance) == 1) {
						$fish_box_message = "<img src='./images/fish/bobber.jpg' width='200px'></img><br><br>
						<div style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>Damn...<br>
						Your line snapped.<br></div>";
						$fisher_message = "Don't let it get you down, sport.";
						$disappointed = 1;
					} else {
						$player->fish_caught += 1;
						$player->fish_caught_total += 1;
						//FIX ME
						$fish->fish[$caught_fish['id']]['qty'] += 1;
						$fish->update();
						//escape single quote
						$description = str_replace("'", "&#39;", $caught_fish['description']);
						$fish_box_message = "<img src='./images/fish/{$caught_fish['id']}.jpg' width='200px'></img><br><br>
						<div style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;' title='{$description}'>You caught:<br><b>{$caught_fish['name']}</b>!</div>";
					}
				} else {
					$fish_box_message = "<img src='./images/fish/bobber.jpg' width='200px'></img><br><br>
					<div style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>You need bait.</div>";
					$fisher_message = "The sea, she requires an offering...";
					$disappointed = 1;
				}
				
				$player->update();
				$inventory->update();
			}	
		} 
			//DISPLAY
			require('statbox.php');
			echo "<center style='margin-top: -20px;'><h2 style='color:#054c00; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>SEWERS</h2>";
		if ($inventory->item[8]['qty'] != 0 or $inventory->item[19]['qty'] != 0 or $fish_convo == 3) {			
			//fish box
			echo "<div style='
					padding: 20px; 
					width: 240px;
					height: 350px;
					position: absolute;
					transform: translate(40px, 10px);
					background-image: url(./images/skin.jpg);
					background-size: 600px 600px;
					font-family: MingLiU-ExtB, Microsoft Yi Baiti;
					box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>";
			echo $fish_box_message;			
			echo "<br>";
			if($fish_convo == 3) {
				echo "<center><img src='./images/fish/rod.jpg' width='200px'></img></center><br>";
			}
			//select rod and bait
			echo "<form action='?page=manhole' method='POST'>";
			echo "Rod: <select name = 'rod'>";
			if($inventory->item[8]['qty']  > 0 or $fish_convo == 3) {
			 echo "<option value = '8' selected>Beginner's Rod</option>";
			}
			if($inventory->item[19]['qty']  > 0) {
			 echo "<option value = '19' selected>Sportsman's Rod</option>";
			}
			echo "</select><br>";
			echo "Bait: <select name = 'bait'>";
			if($inventory->item[1]['qty']  > 0) {
			 echo "<option value = '1' selected>Cheap Bait ({$inv['1']})</option>";
			}
			if($inventory->item[2]['qty']  > 0) {
			 echo "<option value = '2' selected>Regular Bait ({$inv['2']})</option>";
			}
			if($inventory->item[23]['qty']  > 0) {
			 echo "<option value = '23' selected>Spectacular Bait ({$inv['23']})</option>";
			}
			echo "</select><br>
			<input type='submit' name='fish' value='Fish' /></div><br>";
		}
		//fisherman box
		echo "<div style='
		width: 300px;
		translate: 180px -30px;
		'><center><img src='./images/";
		if($disappointed == 1) {
			echo "fisherman_disappointed.jpg";
		} else {
			echo "fisherman.jpg";
		}
		echo "' width='250px'></img><br><br>
		<div style='
				padding: 10px; 
				width: 280px;
				height: 80px;
				transform: translate(00px, -10px);
				background-image: url(./images/skin.jpg);
				background-size: 600px 600px;
				font-family: MingLiU-ExtB, Microsoft Yi Baiti;
				box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
				<div style='
				height: 60px;'>
				''{$fisher_message}''</div>";
				if ($inventory->item[8]['qty']  == 0 or $inventory->item[19]['qty']  == 0) {
					echo "<form action='?page=manhole' method='POST'>";
					if($fish_convo == 1) {
						echo "<input type='submit' name='what' value='What is this place?' />";
					} elseif($fish_convo == 2) {
						echo "<input type='submit' name='rod' value='Fishing?' />";
					} elseif($fish_convo == 3) {
						echo "<div style='transform: translate(0px, -10px);'>(Got <b>Beginner's Rod</b> & <b> Fish Bucket</b>!)</div>";
					} elseif($pod_get == 1) {
						echo "<div style='transform: translate(0px, -10px);'>(Got <b>Chiral Aquarium Pod</b>!)</div>";
					}
					else {
						echo "<div style='transform: translate(0px, 0px); font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><center><a href='./?page=alleys' style='color: white; '>LEAVE</a></center></div>	";
					}
				}
				echo "</form></div></center>";
	}
}

?>