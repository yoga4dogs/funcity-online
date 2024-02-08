<?php
//User Fish

class Fish {
	//members/properties
	public $id;
	public $num_fish;
	public $fish;
	public $user_id;
	private $database;

	//methods/functions
	public function __construct($user_id, $database) {
		$this->database = $database;
		$user_id = (int)$user_id;
		$result = $this->database->query("SELECT * FROM `fishBucket` WHERE `id`='$user_id' LIMIT 1");
		if($this->database->num_rows($result) < 1) {
			throw new Exception("User does not exist.");
		}
		$result2 = $database->query("SELECT * FROM `fish` ORDER BY `id`");
		$fishes = array();
		while($fish = $database->fetch($result2)) {
			$fishes[$fish['id']] = $fish;
		}
		$col_count_result = $this->database->query("SELECT Count(*) FROM INFORMATION_SCHEMA.Columns where TABLE_NAME = 'fishBucket'");
		$inventory = $this->database->fetch($result);
		$num_cols = $this->database->fetch($col_count_result);
		$num_cols = $num_cols['Count(*)'];
		for ($i = 1; $i < $num_cols; $i ++) {
			$this->fish[$i]['id'] = $fishes[$i]['id'];
			$this->fish[$i]['qty'] = $inventory[$i];
			$this->fish[$i]['name'] = $fishes[$i]['name'];
			$this->fish[$i]['desc'] = $fishes[$i]['description'];
			$this->fish[$i]['value'] = $fishes[$i]['value'];
			$this->fish[$i]['tier'] = $fishes[$i]['tier'];
			$this->fish[$i]['combat'] = $fishes[$i]['combat'];
			$this->fish[$i]['combat_text'] = $fishes[$i]['combat_text'];
			$this->fish[$i]['combat_type'] = $fishes[$i]['combat_type'];
			$this->fish[$i]['combat_value'] = $fishes[$i]['combat_value'];
			$this->fish[$i]['equip'] = $fishes[$i]['equip'];
			$this->fish[$i]['equip_text'] = $fishes[$i]['equip_text'];
			$this->fish[$i]['equip_effect'] = $fishes[$i]['equip_effect'];
			$this->fish[$i]['equip_value'] = $fishes[$i]['equip_value'];
		}
		$this->num_fish = $num_cols;
		$this->user_id = $user_id;
		//examples
		//print_r($this->fish[13]['name']);
		//$this->fish[1]['qty'] += 1;
		//$this->update();
		//print($this->fish[1]['desc']);
	}

	public function update() {
		$query = "UPDATE `fishBucket` SET ";
		for ($x = 2; $x < $this->num_fish; $x++) {
			$query .= "`{$x}` = {$this->fish[$x]['qty']}, ";
		}
		$query .= "`1` = {$this->fish[1]['qty']} ";
		$query .= "WHERE `id`={$this->user_id} LIMIT 1";
		//print($query);
		$this->database->query("{$query}");
	}

}