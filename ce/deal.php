<?php

session_start();

require('./monsters.php');

# generate two squads (1-4 necromunks)
$_SESSION['squadI'] = array();
$_SESSION['squadI_stats'] = array();
	# squad 1
array_push($_SESSION['squadI'], $monsterArray[mt_rand(1, sizeof($monsterArray))]);
if(mt_rand(0, 1) == 1) {
	array_push($_SESSION['squadI'], $monsterArray[mt_rand(1, sizeof($monsterArray))]);
}
if(mt_rand(0, 1) == 1) {
	array_push($_SESSION['squadI'], $monsterArray[mt_rand(1, sizeof($monsterArray))]);
}
if(mt_rand(0, 2) == 1) {
	array_push($_SESSION['squadI'], $monsterArray[mt_rand(1, sizeof($monsterArray))]);
}
	# squad 2
$_SESSION['squadII_stats'] = array();
$_SESSION['squadII'] = array();
array_push($_SESSION['squadII'], $monsterArray[mt_rand(1, sizeof($monsterArray))]);
if(mt_rand(0, 1) == 1) {
	array_push($_SESSION['squadII'], $monsterArray[mt_rand(1, sizeof($monsterArray))]);
}
if(mt_rand(0, 1) == 1) {
	array_push($_SESSION['squadII'], $monsterArray[mt_rand(1, sizeof($monsterArray))]);
}
if(mt_rand(0, 2) == 1) {
	array_push($_SESSION['squadII'], $monsterArray[mt_rand(1, sizeof($monsterArray))]);
}

#sum stats
foreach($_SESSION['squadI'] as $id => $monster) {
	$_SESSION['squadI_stats']['stength'] += $monster['strength'];
	$_SESSION['squadI_stats']['special'] += $monster['special'];
	$_SESSION['squadI_stats']['dodge'] += $monster['dodge'];
	$_SESSION['squadI_stats']['bloodThirst'] += $monster['bloodThirst'];
	$_SESSION['squadI_stats']['armor'] += $monster['armor'];
	$_SESSION['squadI_stats']['weapon'] += $monster['weapon'];
}
foreach($_SESSION['squadII'] as $id => $monster) {
	$_SESSION['squadII_stats']['stength'] += $monster['strength'];
	$_SESSION['squadII_stats']['special'] += $monster['special'];
	$_SESSION['squadII_stats']['dodge'] += $monster['dodge'];
	$_SESSION['squadII_stats']['bloodThirst'] += $monster['bloodThirst'];
	$_SESSION['squadII_stats']['armor'] += $monster['armor'];
	$_SESSION['squadII_stats']['weapon'] += $monster['weapon'];
}

# dice rolls for combat - move later
$_SESSION['squadI_stats']['d12'] = mt_rand(1, 12);
$_SESSION['squadII_stats']['d12'] = mt_rand(1, 12);

# display
# style setup - move later
echo "<style>
		body {
			color: white;
			background-image: url('../play/images/marbledark.jpg');
			background-size: cover;
			font-family: MingLiU-ExtB, Microsoft Yi Baiti;
		}
		table, td, th {
			border: 1px solid white;
		}
		div.inline {
			float:left; 
		}
	</style>
	<body>";
# container
echo "<div style='
		position: absolute;
		width: 1400px;
		height: 800px;
		top: 45%;
		left: 50%;
		-ms-transform: translate(-50%, -50%);
		transform: translate(-50%, -50%);'>";
		
# squad cards
echo "<div class='inline'>
	<table style='
		background-color: black;
		width: 1200px;'>
		<tr>
			<td style='border-style: none;' width='25%'><h4 style='margin-bottom: 0;'>SQUAD I</h4></td>
			<td style='border-style: none;' width='25%'></td>
			<td style='border-style: none;' width='25%'></td>
			<td style='border-style: none;' width='25%'></td>
		</tr>
		<tr>";
		foreach($_SESSION['squadI'] as $monster) {
			echo "<td><img src='./monsters/{$monster['id']}.jpg' /></td>";
		}
		echo "</tr>
		</tr>
		<tr style='border-top: 1px solid white;'>
			<td style='border-style: none;'><h4 style='margin-bottom: 0;'>SQUAD II</h4></td>
			<td style='border-style: none;' width='25%'></td>
			<td style='border-style: none;' width='25%'></td>
			<td style='border-style: none;' width='25%'></td>
		</tr>
		<tr>";
		foreach($_SESSION['squadII'] as $monster) {
			echo "<td><img src='./monsters/{$monster['id']}.jpg' /></td>";
		}
		echo "</tr>
	</table>
</div>";

# summed stat tables
echo "<div class='inline' style='
		padding: 20px;'>
	<table style='text-align:center;'>
		<tr>
			<th></th>
			<th>SQ.I</th>
			<th>SQ.II</th>
		</tr>
		<tr>
			<td>ST</td><td>{$_SESSION['squadI_stats']['stength']}</td><td>{$_SESSION['squadII_stats']['stength']}</td>
		</tr>
		<tr>
			<td>SP</td><td>{$_SESSION['squadI_stats']['special']}</td><td>{$_SESSION['squadII_stats']['special']}</td>
		</tr>
		<tr>
			<td>DD</td><td>{$_SESSION['squadI_stats']['dodge']}</td><td>{$_SESSION['squadII_stats']['dodge']}</td>
		</tr>
		<tr>
			<td>BT</td><td>{$_SESSION['squadI_stats']['bloodThirst']}</td><td>{$_SESSION['squadII_stats']['bloodThirst']}</td>
		</tr>
		<tr>
			<td>AR</td><td>{$_SESSION['squadI_stats']['armor']}</td><td>{$_SESSION['squadII_stats']['armor']}</td>
		</tr>
		<tr>
			<td>WP</td><td>{$_SESSION['squadI_stats']['weapon']}</td><td>{$_SESSION['squadII_stats']['weapon']}</td>
		</tr>";
		//	dice roll		
		//	<tr>
		//		<td>D12</td><td>{$_SESSION['squadI_stats']['d12']}</td><td>{$_SESSION['squadII_stats']['d12']}</td>
		//	</tr>
	echo "</table>
	</br>
	Reload
	<form action='{$_GET['page']}' style='display: inline;'>
		<input type='submit' value='>>'/>
	</form>
</div>
</div>";