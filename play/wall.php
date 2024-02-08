<?php 

//profile.php



function wall() {

global $database;
global $player;

$wall = $database->clean($_POST['wall']);
$wall = htmlspecialchars($wall);
$name = $player->login;

date_default_timezone_set("America/New_York");

if(!empty($_POST['post'])) {
	
	//no blank msg
	if($wall != '') {
		//insert into db
		$wall = "(" . date("h:i") . ") " . $wall;
		
		//chat filter
		if($name == "XXXXXXXXXXXXXXXX") {
			$database->query("INSERT INTO `wall` (`name`, `msg`, `blocked`) VALUES ('$name', 'im gay', '$wall')");
		} else {
			$database->query("INSERT INTO `wall` (`name`, `msg`) VALUES ('$name', '$wall')");
		}
	}
	
	//dont think this helps
	unset($_POST['wall']);
	unset($_POST['post']);

}

//get from db
$result = $database->query("SELECT * FROM `wall`");
$messages = $result;
//$messages = $database->fetch($messages);

//display
//print_r($messages);

require('messagebox.php');

while ($row = $messages->fetch_assoc()) {
        echo "&lt;{$row['name']}&gt; {$row['msg']}<br />";
}

echo "</div>";

	echo "<div id='login' style='
	position:relative;
	margin-top:20px;
	margin-left: auto;
	margin-right: auto;'>
		<form action='?page=wall' method='POST'><br>
			<center><input type='Text' name='wall'  size='46' autocomplete='off' style='background-color: #3A3B3A; color: lime; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'/><br/>
			
			<div style='margin-top:6px; margin-bottom: -12px;'><input type='submit' name='post' value='Send'/> <input type='submit' name='refresh' value='Refresh' /></div></center />
		</form>
	</div></div>";
	
	
	require('leaderboard.php');
	echo "<BR><BR><div style='margin-left:-50px;'><a target='_blank' href='";
	echo "http://funcity-online.com";
	echo "'><img src='http://funcity-online.com/images/banner.gif'></a></div><br>
		<center style='top:500px; transform: translate(0px, 34px); font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='./?page=apartment' style='color: white;'>BACK</a>";
		
		if($player->id == 23) {
			echo "<br /><a href='./?page=billsgarage' style='color: white;'>ADMIN</a>";
		}
		
		echo "</center>";


}