<?php
session_start();

require('./playing_cards.php');
$terrain_images = array("tile1.png", "tile2.png", "gd_sds.png");

$map_width = 10;
$map_height = 7;
$grid_size = 64;
$card_limit = 9;

$range = 1;

?>

<!DOCTYPE html>
<html>
<style>
	body {
		color: white;
		background-image: url('../images/marbledark.jpg');
		background-size: cover;
		font-family: MingLiU-ExtB, Microsoft Yi Baiti;
	}
	div.inline {
		float:left; 
	}
	table, tr, td {
		padding-left: 2px;
		padding-right: 2px;
		padding-top: 0px;
		padding-bottom: 0px;
	}
    li {
		list-style-type: none;
    }
	li:hover .card {
		z-index: 9999;
    }
	.card {
		top:50%;
	}
	.card , .active_card {
		filter: drop-shadow(10px 10px 10px rgb(0 0 0 / 0.5));
	}
	.card_popup {
		float: left;
		background-image: url('../images/tile2.jpg');
		background-size: cover;
		position: absolute;
		padding: 20px;
		height: 800px;
		width: 420px;
		top: 50%;
		right: -11%;
		-ms-transform: translate(0, -50%);
		transform: translate(0, -50%);
		filter: drop-shadow(10px 10px 10px rgb(0 0 0 / 0.5));
	}
	.discard_pile {
		position: absolute;
		background-color: black;
		width: 200px;
		height: 310px;
		right: 108%;
		margin-left: 20px;
		box-shadow: 10px 10px 10px rgb(0 0 0 / 0.5);
	}
	.main_area {
		float: left;
		position: absolute;
		background-color: black;
		width: auto;
		height: " .$grid_size * 1.95 * $map_height . "px;
		top: 50%;
		left: 50%;
		-ms-transform: translate(-50%, -50%);
		transform: translate(-50%, -50%);
		box-shadow: 10px 10px 10px rgb(0 0 0 / 0.5);
	}
</style>
<script>
	// all this does right now is accept inputs, change image, and unhide div
	function select_card(card, hand_id) {
		document.getElementById('active_card').src = card;
		var card_popup = document.getElementById('card_popup');
		if (card_popup.style.visibility === 'hidden') {
			card_popup.style.visibility = 'visible';
		}
		document.getElementById('selected_card').value = hand_id;
	}
	function toggle_card_popup() {
		var card_popup = document.getElementById('card_popup');
		if (card_popup.style.visibility === 'hidden') {
			card_popup.style.visibility = 'visible';
		} else {
			card_popup.style.visibility = 'hidden';
		}
	}
</script>
<body>
<div style='background-color: rgb(0 0 0 / 0.5); 
	position: absolute; 
	width: 1400px;
	height: 900px;
	top: 50%;
	left: 50%;
	-ms-transform: translate(-50%, -50%);
	transform: translate(-50%, -50%);'>

<?php
function generate_map_data() {
	// -------------------------------------------------------------
	// --- Fill the $map array with values identifying the terrain
	// --- type in each hex.  This example simply randomizes the
	// --- contents of each hex.  Your code could actually load the
	// --- values from a file or from a database.
	// -------------------------------------------------------------
	global $map_width, $map_height;
	global $map, $terrain_images;
	for ($x=0; $x<$map_width; $x++) {
		for ($y=0; $y<$map_height; $y++) {
			$map[$y][$x] = 0;
		}
	}
	#assign to session array so we dont have to run this every reload
	$_SESSION['map'] = $map;
}

# init map pos and empty discard
if(!isset($_SESSION['mapX'])) {
	$_SESSION['mapX'] = 1;
	$_SESSION['mapY'] = 1;
}
if(!isset($_SESSION['discard'])) {
	$_SESSION['discard'] = array();
}
# setup hand array if doesnt exist
if(!isset($_SESSION['hand'])) {
	$_SESSION['hand'] = array();
}
# setup map
if(!isset($_SESSION['map'])) {
	generate_map_data();	
}
// generate_map_data();	
// uncomment to reset map array

# update tiles
# not doing this anymore
// for ($x=0; $x<$map_width; $x++) {
	// for ($y=0; $y<$map_height; $y++) {
		// $_SESSION['map'][$y][$x] = 0;
	// }
// }

# click map 
if(!empty($_POST['map_selectX']) OR !empty($_POST['map_selectY'])) {
	if(abs($_POST['map_selectX'] - $_SESSION['mapX']) <= $range AND abs($_POST['map_selectY'] - $_SESSION['mapY']) <= $range) {
		$_SESSION['mapX'] = $_POST['map_selectX'];
		$_SESSION['mapY'] = $_POST['map_selectY'];
	}
}
# draw card
if(!empty($_POST['draw_card']) AND sizeof($_SESSION['hand']) < $card_limit) {
		# roll for playing card or weird card
		if(mt_rand(1,5) == 1) {
			$drawn_card = str_pad(mt_rand(0, 18), 3, 0, STR_PAD_LEFT) . ".png";
		} else {
			$drawn_card = $playing_cards[array_rand($playing_cards)]['file'];
		}
		# no repeats, hacky solution that doesnt account for duplicates in deck
		while(in_array($drawn_card, $_SESSION['hand'])) {
			if(mt_rand(1,5) == 1) {
				$drawn_card = str_pad(mt_rand(0, 18), 3, 0, STR_PAD_LEFT) . ".png";
			} else {
				$drawn_card = $playing_cards[array_rand($playing_cards)]['file'];
			}
		}
	array_push($_SESSION['hand'], $drawn_card);
} elseif(!empty($_POST['discard_hand'])) {
	# discard hand	
	foreach($_SESSION['hand'] as $card) {
		array_push($_SESSION['discard'], $card);
		unset($_SESSION['hand'][array_search($card, $_SESSION['hand'])]);
	}
} elseif(!empty($_POST['discard_card'])) {
	# discard single
	array_push($_SESSION['discard'], $_SESSION['hand'][$_POST['selected_card']]);
	unset($_SESSION['hand'][$_POST['selected_card']]);
}

# card detail popup
echo "<div id='card_popup' class='card_popup'>
	<div class='inline' style='height: 580px; width: auto;'>
		<center>
			<img src='./cards/" . $_SESSION['hand'][0] . "' height='580px' id='active_card' class='active_card'/>
		</center>
	</div>
	<div class='inline' style='width: 420px;'>
		<div style='margin-top: 10px;'><H3>LOREM IPSUM</H3></div>
		<div style='background-color: rgba(0, 0, 0, 0.2); margin-top: 10px; height: 130px; overflow-y: auto;'>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
		</div>
		<div style='height: 24px; margin-top: 10px;'>
			<form action='./grid.php' method='POST'>
				<input type='hidden' id='selected_card' name='selected_card' value='x' />
				<input type='submit' name='play_card' value='PLAY'/>
				<input type='submit' name='discard_card' value='DISCARD'/>
			</form>
			<p onclick='toggle_card_popup()' style='position: absolute; right: 5%; bottom: 0%;'>
			<u>CLOSE</u></p>
		</div>
	</div>
</div>";

# main display area
echo "<div class='main_area'>
	<div class='discard_pile'>
		<center><b>DISCARD PILE - " . sizeof($_SESSION['discard']) . "</b></center>
		<img src='./cards/";
			if(sizeof($_SESSION['discard']) == 0) {
				echo "discard.png"; 
			} else { 
				echo $_SESSION['discard'][sizeof($_SESSION['discard']) - 1];
			}
			echo "' width='200px' />
	</div>
	<div class='inline'>
		<table>
			<tr>
				<td></td>";
			for ($y2=0; $y2<sizeof($_SESSION['map'][0]); $y2++) {
				echo "<td><center>{$y2}</center></td>";
			}
			echo "</tr>";
			for ($x2=0; $x2<sizeof($_SESSION['map']); $x2++) {
				echo "<tr>
					<td>{$x2}</td>";
				for ($y2=0; $y2<sizeof($_SESSION['map'][$x2]); $y2++) {
					echo "<td>";
					# player tile
					if($x2 == $_SESSION['mapX'] - 1 and $y2 == $_SESSION['mapY'] - 1) {
						echo "<img src='./gridtile/gd_sds.png' width='{$grid_size}' height='{$grid_size}'/>";
					} elseif(abs($x2 - $_SESSION['mapX'] + 1) <= $range AND abs($y2 - $_SESSION['mapY'] + 1) <= $range) {
						# clickable tiles in move range
						echo "<form action='./grid.php' method='POST'>
							<input type='hidden' value=" . ($x2 + 1) . " name='map_selectX' />
							<input type='hidden' value=" . ($y2 + 1) . " name='map_selectY' />
							<input type='image' src='./gridtile/tile2.png' alt='select' name='map_select' width='{$grid_size}' height='{$grid_size}'>
						</form>";
					} else {
						# regular map tiles
						echo "<img src='./gridtile/" . $terrain_images[$_SESSION['map'][$x2][$y2]] . "' width='{$grid_size}' height='{$grid_size}'/>";
					}
					echo "</td>";
				}
				echo "</tr>";
			}
		echo "</table>
		<form action='./grid.php' method='POST' style='position: absolute; margin-top: 8px;  margin-left: 16px; '>
			<input type='submit' name='draw_card' value='DRAW'/>
			<input type='submit' name='discard_hand' value='DISCARD HAND'/>
		</form>
	</div>
	<br>
	<div class='inline' style='width: auto; height: 325px; margin-left: -20px; transform: translate(0, -260px);'>
		<ul>";
		# display cards in hand
		$i = 0;
		foreach($_SESSION['hand'] as $card) {
			echo "<li>
				<img src='./cards/{$card}' width='200px' class='card' style=' 
					translate: " . $i * 30 . "% 50%;
					position: absolute;
					top: 50%;
					-ms-transform: translateY(-50%);
					transform: translateY(-50%);
					transform: rotate(" . (mt_rand(0,100) / 25 - 2) . "deg);
				'
				onclick='select_card(&#39;./cards/" . $card . "&#39;, " . array_search($card, $_SESSION['hand']) . ")'/>
			</li>";
			$i += 1;
		}
		echo "</ul>
	</div>
</div>
</body>";

?>

<script>
	document.getElementById('card_popup').style.visibility = 'hidden';
</script>