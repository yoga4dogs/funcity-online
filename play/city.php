<?php

//funcity

function city() {
	global $database;
	global $player;
	global $self_link; 
	
	require('statbox.php');
	
	//TITLE
	echo "<center style='margin-top: -20px;'><h2 style='color:#054c00; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>FUNCITY</h2>";
	
	//BACKGROUND
	echo "<center><div style='
			width:400px;
			height:400px;
			margin-left:auto;
			margin-right:auto;
			margin-top:20px;
			background-size:cover;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'><img style='width:400px; height:400px;' src='./images/city11.jpg' />
			</div><br /><br /><div style='transform: translate(0px, 25px); font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=block' title='GO BACK TO YOUR BLOCK' style='color:white;'>GO BACK TO YOUR BLOCK</a></div></center/>";
			
	//DOWNTOWN
	echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left:-540px;
		margin-top:-220px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<a href='./?page=downtown' title='DOWNTOWN'><img style='width:160px; height:160px; border: 10px outset #474747;' src='./images/downtown.png'/></a><br />
		<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=downtown' title='DOWNTOWN' style='color:white;'>DOWNTOWN</center></div>";
	
	//SUBURBS
	echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left:-540px;
		margin-top:-380px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<a href='./?page=uptown' title='OUTSKIRTS'><img style='width:160px; height:160px; border: 10px outset #474747;' src='./images/suburbs.jpg'/></a><br />
		<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=uptown' title='OUTSKIRTS' style='color:white;'>OUTSKIRTS</center></div>";
	
	/**
	echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left: 500px;
		margin-top:-160px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<a href='./?page=block' title='YOUR BLOCK'><img style='width:160px; height:160px; border: 10px outset #474747;' src='./images/block4.jpg'/></a><br />
		<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=block' title='YOUR BLOCK' style='color:white;'>YOUR BLOCK</a></center></div>";
		
	
	echo "<div style='
		width:160px;
		height:160px;
		float:top;
		margin-left:500px;
		margin-top:60px;
		background-size:cover;
		box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
		<a href='./?page=apartment' title='APARTMENT'><img style='width:160px; height:160px; border: 10px outset #474747;' src='./images/block2.jpg'/></a><br />
		<center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=apartment' title='APARTMENT' style='color:white;'>APARTMENT</a></center></div>";
		
	**/
}

?>