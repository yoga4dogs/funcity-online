<?php

function fightpit() {

	global $database;
	global $player;
	global $self_link;
	
	if(empty($_POST['bet'])){
		$fighter1db = $database->query("SELECT `id`, `login`, `photo`, `level` FROM `users` ORDER BY RAND()");
		$fighter1 = $database->fetch($fighter1db);
		
		$fighter2db = $database->query("SELECT `id`, `login`, `photo`, `level` FROM `users` ORDER BY RAND()");
		$fighter2 = $database->fetch($fighter2db);
	}


	if(!empty($_POST['bet'])) {
		$_SESSION['fighter1'] = $fighter1;
		$_SESSION['fighter2'] = $fighter2;
		$_SESSION['pick'] = $_POST['bet'];
		print_r($_SESSION['pick']);
	}
	
	if(!empty($_POST['clear'])) {
		unset($_SESSION['pick']);
	}

	if(isset($_SESSION['pick'])) {
		echo "<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
		{$_SESSION['fighter1']['login']}<br/>
		
		<form action='$self_link' method='POST'><input type='submit' name='clear' value='Clear'/></form>";
	} else {

		echo "<center><form action='$self_link' method='POST'>";

		echo "<div style='
			width: 180px;
			float: left;
			translate: 100px 40px;
			font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
			<center><img src='./images/users/{$fighter1['photo']}.jpg' width='180px'><br /><br />
			<input type='submit' name='bet' value='{$fighter1['login']}'/></center></div>";
				
		echo "<div style='
			width: 180px;
			display: block;
			float: right;
			translate: -100px 40px;
			font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
			<center><img src='./images/users/{$fighter2['photo']}.jpg' width='180px'><br /><br />
			<input type='submit' name='bet' value='{$fighter2['login']}'/></center></div>";

	echo "</form>";
	}
	
	
	
}