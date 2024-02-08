<?php

//downtown select display

global $self_link;
global $monster5;
global $monster6;
global $monster7;
global $monster8;

//rare monster check
$roll = mt_rand(1,200);
if($player->level >= 55 && $roll >= 195) {
	$result5 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result6 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result7 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result8 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
} elseif($player->level >= 45 && $roll >= 199) {
	$result5 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result6 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result7 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result8 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
} else if($player->level >= 25 && $roll <= 1) {
	$result5 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
	$result6 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
	$result7 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
	$result8 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
} else {
	$result5 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=5 ORDER BY RAND()");
	$result6 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=6 ORDER BY RAND()");
	$result7 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=7 ORDER BY RAND()");
	$result8 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=8 ORDER BY RAND()");
}
if($player->level >= 55 && $roll >= 195) {
	$result1 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result2 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result3 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result4 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
} elseif($player->level >= 45 && $roll >= 199) {
	$result1 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result2 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result3 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result4 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
} else if($player->level >= 25 && $roll <= 1) {
	$result1 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
	$result2 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
	$result3 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
	$result4 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=26 ORDER BY RAND()");
} else {
	$result1 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=1 ORDER BY RAND()");
	$result2 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=2 ORDER BY RAND()");
	$result3 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=3 ORDER BY RAND()");
	$result4 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `loc`=4 ORDER BY RAND()");
}

echo "<form action='$self_link' method='POST'>";

$monster4 = $database->fetch($result4);
$monster5 = $database->fetch($result5);
$monster6 = $database->fetch($result6);
$monster7 = $database->fetch($result7);
$monster8 = $database->fetch($result8);

echo "<center style='margin-top: -20px;'><h2 style='color:#054c00; font-family: MingLiU-ExtB, Microsoft Yi Baiti; margin-bottom: -20px;'>DOWNTOWN</h2>
<div style='
	width:350px;
	height:350px;
	margin-left:auto;
	margin-right:auto;
	margin-top:60px;
	background-size:cover;
	box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'><img style='width:350px; height:350px;' src='./images/downtown.png' />
	</div><br /><br />
	<div style='transform: translate(0px, 54px);'><a href='./?page=city' style='color:white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>BACK</a></div></center/>";

echo "<div style='margin-top:15px;'><center>";

echo "<div style='float:left; margin-top: -434px; margin-left:5px; box-shadow: -20px -20px 15px rgba(0,16,0,0.5);'><img src='./images/abandonedsubway.jpg' width='160px'/><br/><input type='hidden' name='monster_id4' value='{$monster4['id']}' /><input type='submit' name='fight4' value='Abandoned Subway (1)' /></div><br />";
echo "<div style='float:left; margin-top: -204px; margin-left:5px; box-shadow: -20px -20px 15px rgba(0,16,0,0.5);'><img src='./images/casino.jpg' width='160px'/><br/><input type='hidden' name='monster_id5' value='{$monster5['id']}' /><input type='submit' name='fight5' value='The Casino (1)' /></div><br />";
echo "<div style='float:right; margin-top: -470px; margin-right: 5px; box-shadow: 20px -20px 15px rgba(0,16,0,0.5);'><img src='./images/arena.jpg' width='160px'/><br/><input type='hidden' name='monster_id6' value='{$monster6['id']}' /><input type='hidden' name='monster_id6' value='{$monster3['id']}' /><input type='submit' name='fight6' value='Abattoir' /></div><br />";




echo "</center></div></form>";
		
?>