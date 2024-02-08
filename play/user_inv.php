<?php
//User Inventory

class Inventory {
	//members/properties
	public $id;
	public $num_items;
	public $item;
	public $user_id;
	private $database;

	//methods/functions
	public function __construct($user_id, $database) {
		$this->database = $database;
		$user_id = (int)$user_id;
		$result = $this->database->query("SELECT * FROM `inventory` WHERE `id`='$user_id' LIMIT 1");
		if($this->database->num_rows($result) < 1) {
			throw new Exception("User does not exist.");
		}
		$result2 = $database->query("SELECT * FROM `itemDB` ORDER BY `id`");
		$items = array();
		while($item = $database->fetch($result2)) {
			$items[$item['id']] = $item;
		}
		$col_count_result = $this->database->query("SELECT Count(*) FROM INFORMATION_SCHEMA.Columns where TABLE_NAME = 'inventory'");
		$inventory = $this->database->fetch($result);
		$num_cols = $this->database->fetch($col_count_result);
		$num_cols = $num_cols['Count(*)'];
		for ($i = 1; $i < $num_cols; $i ++) {
			$this->item[$i]['id'] = $items[$i]['id'];
			$this->item[$i]['qty'] = $inventory[$i];
			$this->item[$i]['name'] = $items[$i]['name'];
			$this->item[$i]['desc'] = $items[$i]['description'];
			$this->item[$i]['usetext'] = $items[$i]['usetext'];
			$this->item[$i]['type'] = $items[$i]['type'];
			$this->item[$i]['usable'] = $items[$i]['usable'];
			$this->item[$i]['effect1'] = $items[$i]['effect1'];
			$this->item[$i]['effect2'] = $items[$i]['effect2'];
		}
		$this->num_items = $num_cols;
		$this->user_id = $user_id;
		//examples
		//$this->item[1]['qty'] += 1;
		//$this->update();
		//print($this->item[1]['desc']);
	}

	public function update() {
		$query = "UPDATE `inventory` SET ";
		for ($x = 2; $x < $this->num_items; $x++) {
			$query .= "`{$x}` = {$this->item[$x]['qty']}, ";
		}
		$query .= "`1` = {$this->item[1]['qty']} ";
		$query .= "WHERE `id`={$this->user_id} LIMIT 1";
		//print($query);
		$this->database->query("{$query}");
	}

}