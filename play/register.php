<?php 

require("DatabaseObject.php");
require("databaseVars.php");

$database = new DatabaseObject($host, $username, $password, $database);

require('templates/header2.php');

if(!empty($_POST['register'])) {
	$login = htmlspecialchars($login);
	$login = $database->clean($_POST['login']);
	$pswd = htmlspecialchars($pswd);
	$pswd = $database->clean($_POST['pswd']);
	$pswd2 = htmlspecialchars($pswd2);
	$pswd2 = $database->clean($_POST['pswd2']);
	
	try {
		
		//Username
		if(strlen($login) < 4) {
			throw new Exception('Username must be more than 3 characters.');
		}
		if(strlen($login) >  50) {
			throw new Exception('Username must be less than 50 characters.');
		}
		if(!ctype_alnum($login)) {
			throw new Exception('Username must consist of only letters and numbers.');
		}
		//Password
		if(strlen($pswd) < 6) {
			throw new Exception('Password must be more than 5 characters.');
		}
		if($pswd != $pswd2) {
			throw new Exception('Password must match.');
		}
		
		//Submit to db
		$pswd = md5($pswd);
		$database->query("BEGIN");
		$database->query("INSERT INTO `users` (
			`login`,
			`pswd`,
			`level`,
			`photo`,
			`exp`,
			`exp_spend`,
			`health`,
			`max_health`,
			`money`,
			`strength`,
			`dexterity`,
			`endurance`,
			`attacks`,
			`equip`,
			`equipment`,
			`incombat`,
			`round_damage`,
			`turns`,
			`turns_played`,
			`robocop_count`,
			`killfucker_count`,
			`drug_price`,
			`drugs_bought`,
			`target_bool`,
			`target_id`,
			`target_count`,
			`target_total`,
			`resets`,
			`can_bag`,
			`cans`,
			`lastadv`,
			`drunk`,
			`full`,
			`head`,
			`torso`,
			`legs`,
			`hands`,
			`feet`,
			`acc`
		)
		VALUES (
			'$login',
			'$pswd',
			'1',
			'1',
			'0',
			'0',
			'100',
			'100',
			'10',
			'1',
			'1',
			'1',
			'',
			'',
			'',
			'0',
			'0',
			'50',
			'0',
			'0',
			'0',
			'1',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0'
			)");
		$database->query("INSERT INTO `inventory` VALUES ()");
		$database->query("INSERT INTO `fishBucket` VALUES ()");
		$database->query("COMMIT");
		
		echo "Account created. <a href='./'>Login</a><br />";
				
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}

?>
<center><div style="width: 500px; transform: translate(0px, 0px); box-shadow: 20px 20px 15px rgba(0,16,0,0.5);"><img src="./images/dealer2.jpg" width="500px"/></div></center>
<div id="login" style="
margin-top: 170px;
width: 300px;
height: 190px;
background-image: url(./images/skin.jpg);
font-family: MingLiU-ExtB, Microsoft Yi Baiti;
box-shadow: 20px 20px 15px rgba(0,16,0,0.5);">
<div style="margin-left: 20px;">
<center><h2>REGISTER</h2></center>
<form action='./register.php' method='POST'>
	Username: <input type='text' name='login' /><br />
	Password: <input type='password' name='pswd' /><br />
	Password: <input type='password' name='pswd2' /><br /><br />
	<center><input type='submit' name='register' value='Register' /></center>
</form>
</div>

<center><div style='transform: translate(10px, 15px); font-family: MingLiU-ExtB, Microsoft Yi Baiti;'><a href='http://funcity-online.com/' style='color: white; '>BACK</a></div></center>

<?php

require('templates/footer.php');

?>
