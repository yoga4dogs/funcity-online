<?php

//monster.php
//object for holding and managing mosnter data

class Monster {
	//members/properties
		public $id;
		public $name;
		public $description;


		public $level;
		
		public $health;
		public $max_health;
				
		public $strength;
		public $dexterity;
		public $endurance;
				
		public $attacks;
		
		public $item_drop;
		public $item_drop_type;
		public $item_drop_rate;
	
		private $database;
		
	//methods/functions
		public function __construct($monster_id, $database) {
			$this->database = $database;
			$monster_id = (int)$monster_id;
			
			$result = $this->database->query("SELECT * FROM `monsters` WHERE `id`='$monster_id' LIMIT 1");
			if($this->database->num_rows($result) == 0) {
				throw new Exception("Monster does not exist.");
			}
			
			$monster = $this->database->fetch($result);
			
			$this->id = $monster['id'];
			$this->name = $monster['name'];
			$this->description = $monster['description'];
			
			$this->level = $monster['level'];
			
			$this->max_health = $monster['max_health'];
			
			if(!isset($_SESSION['monster_health'])) {
				$_SESSION['monster_health'] = $this->max_health;
			}
			$this->health = $_SESSION['monster_health'];
			
			$this->strength = $monster['strength'];
			$this->dexterity = $monster['dexterity'];
			$this->endurance = $monster['endurance'];
			
			$this->attacks = $monster['attacks'];
		
			$this->attacks = array();
			if($monster['attacks']) {
				$this->attacks = json_decode($monster['attacks'], true);
			}	

			$this->item_drop = $monster['item_drop'];			
			$this->item_drop_type = $monster['item_drop_type'];			
			$this->item_drop_rate = $monster['item_drop_rate'];			
		
		}
		
		public function update() {
			$_SESSION['monster_health'] = $this->health;
		}
	
	
	
}