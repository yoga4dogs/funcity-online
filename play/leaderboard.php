<?php

//leaderboard
		
	//Highest Level
		$result_level = $database->query("SELECT * FROM `users` WHERE `id` >= 25 ORDER BY `level` DESC LIMIT 5");
		$levels = array();
		
		while($level = $database->fetch($result_level)) {
			$levels[$level['id']] = $level;
		}
		
		echo "<style>
		
		.zoom {
			float: left;
			z-index:3;
		}
		.zoom:hover {
			transform: scale(5);
		}
		</style>";
		
		echo "<div style='
		position: absolute;
		background-image: url(./images/tile1.jpg);
		background-size: 310px 260px;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
		font-family: MingLiU-ExtB, Microsoft Yi Baiti;
		width: 300px;
		height: 250px;
		float: left;
		padding: 3px;
		margin-left: -390px;
		margin-top: -370px;
		overflow-x: hidden;
		overflow-y: hidden;
		display: flex;'>
		<table class='center' style='width:280px; height:210px; transform: translate(26px, 20px);'>
		<tr>
			<th style='width:50%;'>Name</th>
			<th style='width:40%;'>Level</th>
		</tr>";
		
		foreach($levels as $id => $level) {
			
			echo "<tr align='center'>
			<td style='text-align:left;'><img class='zoom' src='./images/users/" . $level['photo'] . ".jpg' height='25px'>&nbsp;{$level['login']}</td>
			<td>{$level['level']}</td>
			</tr>";
		
		}
		
	//resets
	
		$result_reset = $database->query("SELECT * FROM `users` WHERE `id` >= 25 ORDER BY `resets` DESC LIMIT 5");
		$resets = array();
		
		while($reset = $database->fetch($result_reset)) {
			$resets[$reset['id']] = $reset;
		}
		
		echo "</table></div>";
		
		echo "<div style='
		position: absolute;
		background-image: url(./images/tile1.jpg);
		background-size: 310px 260px;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
		font-family: MingLiU-ExtB, Microsoft Yi Baiti;
		width: 300px;
		height: 250px;
		float: bottom;
		padding: 3px;
		margin-left: -390px;
		margin-top: -90px;
		overflow-x: hidden;
		overflow-y: hidden;
		display: flex;'>
		<table class='center' style='width:270px; height:210px; transform: translate(26px, 20px);'>
		<tr>
			<th style='width:50%;'>Name</th>
			<th style='width:40%;'>Blackouts</th>
		</tr>";
		
		foreach($resets as $id => $reset) {
			
			echo "<tr align='center'>
			<td style='text-align:left;'><img class='zoom' src='./images/users/" . $reset['photo'] . ".jpg' height='25px'>&nbsp;{$reset['login']}</td>
			<td>{$reset['resets']}</td>
			</tr>";
		
		}
		
		echo "</table></div>";
		
	//Richest Players
	
		$result_money = $database->query("SELECT * FROM `users` WHERE `id` >= 25  ORDER BY `money` DESC LIMIT 5");
		$moneys = array();
		
		while($money = $database->fetch($result_money)) {
			$moneys[$money['id']] = $money;
		}
		
		echo "<div style='
		position: absolute;
		background-image: url(./images/tile1.jpg);
		background-size: 310px 260px;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
		font-family: MingLiU-ExtB, Microsoft Yi Baiti;
		width: 300px;
		height: 250px;
		float: left;
		padding: 3px;
		margin-left: 470px;
		margin-top: -370px;
		overflow-x: hidden;
		overflow-y: hidden;
		display: flex;'>
		<table class='center' style='width:280px; height:210px; transform: translate(26px, 20px);'>
		<tr>
			<th style='width:40%;'>Name</th>
			<th style='width:40%;'>FUN₵</th>
		</tr>";
		
		foreach($moneys as $id => $money) {
			
			echo "<tr align='center'>
			<td style='text-align:left;'><img class='zoom' src='./images/users/" . $money['photo'] . ".jpg' height='25px'>&nbsp;{$money['login']}</td>
			<td>" . number_format($money['money']) . "</td>
			</tr>";
		
		}
		
		echo "</table></div>";
	/**
	//Robocop Count

		$result_robocop = $database->query("SELECT * FROM `users` WHERE `id` >= 25  ORDER BY `robocop_count` DESC LIMIT 5");
		$robocops = array();
		
		while($robocop = $database->fetch($result_robocop)) {
			$robocops[$robocop['id']] = $robocop;
		}
		
		echo "<div style='
		position: absolute;
		background-image: url(./images/tile1.jpg);
		background-size: 310px 260px;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
		font-family: MingLiU-ExtB, Microsoft Yi Baiti;
		width: 300px;
		height: 250px;
		float: bottom;
		padding: 3px;
		margin-left: 470px;
		margin-top: -90px;
		overflow-x: hidden;
		overflow-y: hidden;
		display: flex;'>
		<table class='center' style='width:270px; height:210px; transform: translate(26px, 20px);'>
		<tr>
			<th style='width:60%;'>Name</th>
			<th style='width:20px;'>Robocops</th>
		</tr>";
		
		foreach($robocops as $id => $robocop) {
			
			echo "<tr align='center'>
			<td style='text-align:left;'><img class='zoom' src='./images/users/{$robocop['photo']}.jpg' height='25px'>&nbsp;{$robocop['login']}</td>
			<td>" . number_format($robocop['robocop_count']) . "</td>
			</tr>";
		
		}
		
		echo "</table></div>";
		**/
		
	//fish_caught Count

		$result_fish_caught = $database->query("SELECT * FROM `users` WHERE `id` >= 25  ORDER BY `fish_caught` DESC LIMIT 5");
		$fish_caughts = array();
		
		while($fish_caught = $database->fetch($result_fish_caught)) {
			$fish_caughts[$fish_caught['id']] = $fish_caught;
		}
		
		echo "<div style='
		position: absolute;
		background-image: url(./images/tile1.jpg);
		background-size: 310px 260px;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
		font-family: MingLiU-ExtB, Microsoft Yi Baiti;
		width: 300px;
		height: 250px;
		float: bottom;
		padding: 3px;
		margin-left: 470px;
		margin-top: -90px;
		overflow-x: hidden;
		overflow-y: hidden;
		display: flex;'>
		<table class='center' style='width:270px; height:210px; transform: translate(26px, 20px);'>
		<tr>
			<th style='width:60%;'>Name</th>
			<th style='width:20px;'>Fish</th>
		</tr>";
		
		foreach($fish_caughts as $id => $fish_caught) {
			
			echo "<tr align='center'>
			<td style='text-align:left;'><img class='zoom' src='./images/users/{$fish_caught['photo']}.jpg' height='25px'>&nbsp;{$fish_caught['login']}</td>
			<td>" . number_format($fish_caught['fish_caught']) . "</td>
			</tr>";
		
		}
		
		echo "</table></div>";
	
	
	/**killfucker Count

		$result_killfucker = $database->query("SELECT * FROM `users` WHERE `id` >= 25  ORDER BY `killfucker_count` DESC LIMIT 5");
		$robocops = array();
		
		while($killfucker = $database->fetch($result_killfucker)) {
			$killfuckers[$killfucker['id']] = $killfucker;
		}
		
		echo "<div style='
		position: absolute;
		background-image: url(./images/tile1.jpg);
		background-size: 310px 260px;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
		font-family: MingLiU-ExtB, Microsoft Yi Baiti;
		width: 300px;
		height: 250px;
		float: bottom;
		padding: 3px;
		margin-left: 470px;
		margin-top: -90px;
		overflow-x: hidden;
		overflow-y: auto;
		display: flex;'>
		<table class='center' style='width:270px; height:210px; transform: translate(20px, 8%);'>
		<tr>
			<th style='width:60%;'>Name</th>
			<th style='width:20px;'>Killfuckers</th>
		</tr>";
		
		foreach($killfuckers as $id => $killfucker) {
			
			echo "<tr align='center'>
			<td style='text-align:left;'><img src='./images/users/{$killfucker['photo']}.jpg' width='25px' height='25px'> {$killfucker['login']}</td>
			<td>" . number_format($killfucker['killfucker_count']) . "</td>
			</tr>";
		
		}
		
		echo "</table></div>";
	*/
	
?>