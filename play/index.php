<?php

session_start();
ob_start();

require("DatabaseObject.php");
require("databaseVars.php");

$update = "COMBAT UPDATE";

$database = new DatabaseObject($host, $username, $password, $database);

if(!isset($_SESSION['user_id']) && $_POST['logon']) {
	$login = htmlspecialchars($login);
	$login = $database->clean($_POST['login']);
	$pswd = htmlspecialchars($pswd);
	$pswd = $database->clean($_POST['pswd']);
	
	$result = $database->query("SELECT `id`, `login`, `pswd` FROM `users` WHERE `login`='$login' LIMIT 1");
	
	try {
		
		if($database->num_rows($result) == 0) {
			throw new Exception('User does not exist.');
		}
		
		$user = $database->fetch($result);
		
		if(md5($pswd) != $user['pswd']) {
			throw new Exception('Invalid password.');
		}
		
		$_SESSION['user_id'] = $user['id'];
		
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	
}
//if logged in, load data and select page

if(isset($_SESSION['user_id'])) {
	require('user.php');
	$player = new User($_SESSION['user_id'], $database);
	require('user_inv.php');
	$inventory = new Inventory($_SESSION['user_id'], $database);
	require('user_fish.php');
	$fish = new Fish($_SESSION['user_id'], $database);
	//print($fish->fish[1]['name']);
	
	$default_page = 'city';
	$pages = array(
		'main' => array(
			'name' => 'Main',
			'file' => 'main.php',
			'function' => 'main',
		),
		'city' => array(
			'name' => 'City',
			'file' => 'city.php',
			'function' => 'city',
		),
		'uptown' => array(
			'name' => 'Uptown',
			'file' => 'arena.php',
			'function' => 'arena',
		),
		'downtown' => array(
			'name' => 'downtown',
			'file' => 'arena.php',
			'function' => 'arena',
		),
		'block' => array(
			'name' => 'block',
			'file' => 'block.php',
			'function' => 'block',
		),
		'alleys' => array(
			'name' => 'alleys',
			'file' => 'alleys.php',
			'function' => 'alleys',
		),
		'dealer' => array(
			'name' => 'dealer',
			'file' => 'dealer.php',
			'function' => 'dealer',
		),
		'weaponshop' => array(
			'name' => 'Weapon Shop',
			'file' => 'attackShop.php',
			'function' => 'attackShop',
		),
		'equipshop' => array(
			'name' => 'Equip Shop',
			'file' => 'equipShop.php',
			'function' => 'equipShop',
		),
		'bar' => array(
			'name' => 'Healing Shop',
			'file' => 'healingShop.php',
			'function' => 'healingShop',
		),
		'fightpit' => array(
			'name' => 'Fight Pit',
			'file' => 'fightpit.php',
			'function' => 'fightpit',
		),
		'slots' => array(
			'name' => 'slots',
			'file' => 'slots.php',
			'function' => 'slots',
		),
		'golddoubler' => array(
			'name' => 'golddoubler',
			'file' => 'golddoubler.php',
			'function' => 'golddoubler',
		),
		'apartment' => array(
			'name' => 'Apartment',
			'file' => 'apartment.php',
			'function' => 'apartment',
		),
		'profile' => array(
			'name' => 'Profile',
			'file' => 'profile.php',
			'function' => 'profile',
		),
		'inventory' => array(
			'name' => 'inventory',
			'file' => 'inventory.php',
			'function' => 'inventory',
		),
		'wall' => array(
			'name' => 'Wall',
			'file' => 'wall.php',
			'function' => 'wall',
		),
		'tv' => array(
			'name' => 'tv',
			'file' => 'tv.php',
			'function' => 'tv',
		),
		'supergun' => array(
			'name' => 'supergun',
			'file' => 'supergun.php',
			'function' => 'supergun',
		),
		'recycle' => array(
			'name' => 'Recycling Machine',
			'file' => 'recycle.php',
			'function' => 'recycle',
		),
		'radio' => array(
			'name' => 'radio',
			'file' => 'radio.php',
			'function' => 'radio',
		),
		'manhole' => array(
			'name' => 'manhole',
			'file' => 'manhole.php',
			'function' => 'manhole',
		),
		'billsgarage' => array(
			'name' => 'billsgarage',
			'file' => 'billsgarage.php',
			'function' => 'billsgarage',
		),
		'create_monster' => array(
			'name' => 'Create Monster',
			'file' => 'monsterPages.php',
			'function' => 'create_monster',
		),
		'create_attack' => array(
			'name' => 'Create Attack',
			'file' => 'attackPages.php',
			'function' => 'create_attack',
		),
		'create_equip' => array(
			'name' => 'Create Equip',
			'file' => 'equipPages.php',
			'function' => 'create_equip',
		),
	);
	
	if(!empty($_GET['page'])) {
		$page = strtolower(trim($_GET['page']));
		
		if($player->incombat == 1) {
			$page = 'uptown';
			require($pages[$page]['file']);
			$self_link = '?page=uptown';
			$pages[$page]['function']();
		} elseif(isset($pages[$page])) {
			require($pages[$page]['file']);
			$self_link = '?page=' . $page;
			$pages[$page]['function']();
		}
		else {
			require($pages[$default_page]['file']);
			$self_link = '?page=' . $deafult_page;
			$pages[$default_page]['function']();
		}
	}
	else {
		require($pages[$default_page]['file']);
		$self_link = '?/page=' . $page;
		$pages[$default_page]['function']();
	}
	
	
}

//display
$output = ob_get_clean();

if(isset($_SESSION['user_id'])) {
	require('templates/header.php');
	echo $output;
}
else {
	require('templates/header2.php');

	$label_width = 5;
	echo "
	<center><div><img src='./images/funcity/" . mt_rand(0,29) . ".jpg' style='box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'></img></div></center><br>
	<div id='login' style='top: 480px; z-index: 10;'>
	<div style='
	background-image: url(./images/skin.jpg);
	background-size: 600px 600px;
	padding-left: 40px;
	padding-right: 40px;
	padding-bottom: 10px;
	transform: translate(0px, -30px);
	box-shadow: 20px 20px 15px rgba(0,16,0,0.5);
	font-family: MingLiU-ExtB, Microsoft Yi Baiti;
	'>
	<center><h2 style='padding-top:10px;'>LOGIN</h2>
	<i>Now with 100% More Fish.</i><br><br>
	{$output}
	<form action='./' method='POST'>
		<label style='width:{$label_width}em;'>Username:</label><input type='text' name='login' autofocus /><br />
		<label style='width:{$label_width}em;'>Password:</label><input type='password' name='pswd' /><br />
		<input type='submit' name='logon' value='Logon' style='translate: 0 5px;'/>
	</form><a href='http://city.funtwitter.com/register.php' style='color: black'>REGISTER</a></center></div></div>";
	
	echo "<div style='
		translate: 600px -270px;'>
		<img src='./images/side1.jpg' width='200' style='box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'/>
		</div>";
	echo "<div style='
		translate: -100px -780px;'>
		<img src='./images/side2.jpg' width='200' style='box-shadow: 20px 20px 15px rgba(0,16,0,0.5);'/>
		</div>";
}

require('templates/footer.php');
?>