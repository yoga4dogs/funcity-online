<?php

//tv

function tv() {
	global $database;
	global $player;
	global $self_link; 
	
		$tv = $database->query("SELECT * FROM `tv` ORDER BY RAND() LIMIT 1");
		$video = $database->fetch($tv);
		
		echo "<center><div style='
			width:500px;
			height:500px;
			margin-left:auto;
			margin-right:auto;
			margin-top:10px;
			background-size:cover;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
			<img style='width:500px; height:500px;' src='./images/tv2.jpg'/><br />
			<div style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=apartment' style='color: white;'>BACK</a></div>
			</div></center/>";
			
		echo "<center><div style='float:top; margin-left:20px; margin-top:-405px;'><iframe width='280' height='180' src='https://www.youtube.com/embed/{$video['video']}?autoplay=1&mute=1&showinfo=0&modestbranding=0&autohide=1&controls=0' frameborder='0' allowfullscreen></iframe></div></center>";
		
		echo "<center><div style='
			width:120px;
			height:120px;
			float:top;
			margin-left:400px;
			margin-top:80px;
			background-size:cover;
			box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'>
			<a href='' title='CHANGE CHANNEL'><img style='width:120px; height:120px;' src='./images/remote.jpg'/></a><br />
			</div></center/>";
			

		//<a href='{$video['video']}' title='WATCH TV' target='_blank'><img src='./images/tv.jpg' width='200px'/></a><br /><center style='font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>TV<br/><a href=''>CHANGE CHANNEL</a></center></div>
		
}

?>