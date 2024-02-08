<?php

//alleys

function alleys() {
	global $database;
	global $player;
	global $self_link; 
	
	$result1 = $database->query("SELECT * FROM `inventory` WHERE `id` = '{$player->id}'");
	$inv = $result1->fetch_assoc();	
	
	require('statbox.php');
	
	//TITLE
	echo "<center style='margin-top: -20px;'><h2 style='color:#054c00; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>BACK ALLEYS</h2>";
	
	//BACKGROUND
	echo "<center><div style='
			width:400px;
			height:400px;
			margin-left:auto;
			margin-right:auto;
			margin-top:20px;
			background-size:cover;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'><img style='width:400px; height:400px;' src='./images/alleys.jpg' /><br /><center></center>
			</div><br /><br /><div style='transform: translate(0px, 25px); font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=block' title='BACK' style='color:white;'>BACK</a></div></center/>";
			
	//MANHOLE
	echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left:-540px;
		margin-top:-220px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>";
		if($inv['4'] >=  1) {
			echo "<a href='./?page=manhole' title='MANHOLE'><img style='width:160px; height:160px; border: 10px outset #474747;' src='./images/openmanhole.png'/></a><br />
			<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti; color:white;'>
			<a href='./?page=manhole' title='MANHOLE' style='color: white;'>SEWER ENTRANCE</a>";
		} else {
			echo "<img style='width:160px; height:160px; border: 10px outset #474747;' title='MANHOLE' src='./images/manhole.jpg'/<br />
			<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti; color:white;'>
			(NEED KEY)";
		}
		echo "</center></div>";
	
	//DEALER
	echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left:-540px;
		margin-top:-380px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<a href='./?page=dealer' title='...'><img style='width:160px; height:160px; border: 10px outset #474747;' src='./images/dealer1.jpg'/></a><br />
		<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=dealer' title='...' style='color:white;'>...</a></center></div>";
	
	/**
	//BAR
	echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left: 500px;
		margin-top:-160px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<a href='./?page=bar' title='BAR'><img style='width:160px; height:160px; border: 10px outset #474747;' src='./images/bar.jpg'/></a><br />
		<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=bar' title='BAR' style='color:white;'>BAR</a></center></div>";
	
	//DEALER
	echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left:500px;
		margin-top:60px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<a href='./?page=dealer' title='...'><img style='width:160px; height:160px; border: 10px outset #474747;' src='./images/dealer1.jpg'/></a><br />
		<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=dealer' title='...' style='color:white;'>...</a></center></div>";
	**/
}

?>