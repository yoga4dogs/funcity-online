<?php

//uptown select display

global $self_link;
global $monster1;
global $monster2;
global $monster3;
global $monster4;

//rare monster check
$roll = mt_rand(1,200);
if($player->level >= 50 && $roll >= 195) {
	$result1 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result2 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result3 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
	$result4 = $database->query("SELECT `id`, `name`, `level`, `loc` FROM `monsters` WHERE `id`=39 ORDER BY RAND()");
} elseif($player->level >= 40 && $roll >= 199) {
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
	
$monster1 = $database->fetch($result1);
$monster2 = $database->fetch($result2);
$monster3 = $database->fetch($result3);
$monster4 = $database->fetch($result4);

echo "<center style='margin-top: -20px;'><h2 style='color:#054c00; font-family: MingLiU-ExtB, Microsoft Yi Baiti; margin-bottom: -20px;'>OUTSKIRTS</h2>
<div style='
	width:350px;
	height:350px;
	margin-left:auto;
	margin-right:auto;
	margin-top:60px;
	background-size:cover;
	box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'><img style='width:350px; height:350px;' src='./images/suburbs.jpg' />
	</div><br /><br />
	<div style='transform: translate(0px, 54px);'><a href='./?page=city' style='color:white; font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>BACK</a></div></center/>";
	
echo "<div style='margin-top:-20px;'><center>";
echo "<div style='float:left; margin-top: -400px; margin-left:5px; box-shadow: -20px -20px 15px rgba(0,16,0,0.5);'><img src='./images/vacantlot.jpg' width='160px'/><br/><input type='hidden' name='monster_id1' value='{$monster1['id']}' /><input type='submit' name='fight1' value='Vacant Lot (1)' /></div><br />";
echo "<div style='float:left; margin-top: -170px; margin-left:5px; box-shadow: -20px -20px 15px rgba(0,16,0,0.5);'><img src='./images/mallfoodcourt.jpg' width='160px'/><br/><input type='hidden' name='monster_id2' value='{$monster1['id']}' /><input type='hidden' name='monster_id2' value='{$monster2['id']}' /><input type='submit' name='fight2' value='Mall Foodcourt (1)' /></div><br />";
echo "<div style='float:right; margin-top: -440px; margin-right: 5px; box-shadow: 20px -20px 15px rgba(0,16,0,0.5);'><img src='./images/policestation.jpg' width='160px'/><br/><input type='hidden' name='monster_id3' value='{$monster1['id']}' /><input type='hidden' name='monster_id3' value='{$monster3['id']}' /><input type='submit' name='fight3' value='Police Station (1)' /></div><br />";
//echo "<div style='float:right; margin-top: -210px; margin-right: 5px; box-shadow: 20px -20px 15px rgba(0,16,0,0.5);'><img src='./images/abandonedsubway.jpg' width='160px'/><br/><input type='hidden' name='monster_id4' value='{$monster1['id']}' /><input type='hidden' name='monster_id4' value='{$monster4['id']}' /><input type='submit' name='fight4' value='Abandoned Subway (1)' /></div><br /></center></div>";

echo "</form>";
		
?>