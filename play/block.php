<?php

//your block

function block() {
	global $database;
	global $player;
	global $self_link; 
	
	require('statbox.php');
	
	//TITLE
	echo "<center style='margin-top: -20px;'><h2 style='color:#054c00; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>YOUR BLOCK</h2>";
	
	//BACKGROUND
	echo "<center><div style='
			width:400px;
			height:400px;
			margin-left:auto;
			margin-right:auto;
			margin-top:20px;
			background-size:cover;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'><a href='./?page=apartment' title='ENTER'><img style='width:400px; height:400px;' src='./images/block2.jpg' /></a><br /><center><a href='./?page=apartment' title='ENTER' style='color:white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>YOUR APARTMENT</a></center>
			</div><br /><br /><div style='transform: translate(0px, 25px); font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=city' title='EXPLORE CITY' style='color:white;'>EXPLORE CITY</a></div></center/>";
			
	//CLOTHES
	echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left:-540px;
		margin-top:-220px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<a href='./?page=equipshop' title='EQUIPMENT'><img style='width:160px; height:160px; border: 10px outset #474747;' src='./images/clothes.jpg'/></a><br />
		<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=equipshop' title='EQUIPMENT' style='color:white;'>THRIFT STORE</center></div>";
	
	//PAWN
	echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left:-540px;
		margin-top:-380px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<a href='./?page=weaponshop' title='WEAPONS'><img style='width:160px; height:160px; border: 10px outset #474747;' src='./images/pawn1.jpg'/></a><br />
		<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=weaponshop' title='WEAPONS' style='color:white;'>PAWN SHOP</center></div>";
	
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
		<a href='./?page=alleys' title='...'><img style='width:160px; height:160px; border: 10px outset #474747;' src='./images/alleys.jpg'/></a><br />
		<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=alleys' title='BACK ALLEYS' style='color:white;'>BACK ALLEYS</a></center></div>";
		
}

?>