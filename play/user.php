<?php

//User


class User {
	//members/properties
		public $id;
		
		public $login;
		public $pswd;
		
		public $photo;
		
		public $level;
		public $exp;
		public $exp_spend;
		
		public $health;
		public $max_health;
				
		public $strength;
		public $dexterity;
		public $endurance;
		
		public $money;
		
		public $attacks;
		public $equip;
		public $equipment;
		
		public $incombat;
		public $round_damage;
		
		public $turns;
		public $turns_played;
		
		public $robocop_count;
		public $killfucker_count;
				
		public $drug_price;
		public $drugs_bought;

		public $target_bool;
		public $target_id;
		public $target_count;
		public $target_total;
		
		public $resets;
		
		public $can_bag;
		
		public $lastadv;
		
		public $drunk;
		public $full;
		
		public $head;
		public $torso;
		public $legs;
		public $hands;
		public $feet;
		public $acc;
		
		public $sewer_quest;
		public $sewer_key;
		public $fish_caught;
		public $pod_fish;

	
		private $database;
		
	//methods/functions
		public function __construct($user_id, $database) {
			$this->database = $database;
			$user_id = (int)$user_id;
			
			$result = $this->database->query("SELECT * FROM `users` WHERE `id`='$user_id' LIMIT 1");
			if($this->database->num_rows($result) < 1) {
				throw new Exception("User does not exist.");
			}
			
			$user = $this->database->fetch($result);
			
			$this->id = $user['id'];
			
			$this->login = $user['login'];
			$this->pswd = $user['pswd'];
			
			$this->photo = $user['photo'];
			
			$this->level = $user['level'];
			$this->exp = $user['exp'];
			$this->exp_spend = $user['exp_spend'];
						
			$this->health = $user['health'];
			$this->max_health = $user['max_health'];
						
			$this->strength = $user['strength'];
			$this->dexterity = $user['dexterity'];
			$this->endurance = $user['endurance'];
			
			$this->money = $user['money'];

			$this->attacks = array();
			if($user['attacks']) {
				$this->attacks = json_decode($user['attacks'], true);
			}
			$this->equip = array();
			if($user['equip']) {
				$this->equip = json_decode($user['equip'], true);
			}
			
			$this->equipment = array();
			if($user['equipment']) {
				$this->equipment = json_decode($user['equipment'], true);
			}
			
			$this->incombat = $user['incombat'];
			$this->round_damage = $user['round_damage'];
			$this->turns= $user['turns'];
			$this->turns_played= $user['turns_played'];
			
			$this->robocop_count= $user['robocop_count'];
			$this->killfucker_count= $user['killfucker_count'];;
			
			$this->drug_price= $user['drug_price'];
			$this->drugs_bought= $user['drugs_bought'];

			$this->target_bool= $user['target_bool'];
			$this->target_id= $user['target_id'];
			$this->target_count= $user['target_count'];
			$this->target_total= $user['target_total'];
			
			$this->resets= $user['resets'];
			
			$this->can_bag= $user['can_bag'];
			
			$this->lastadv= $user['lastadv'];
			
			$this->drunk= $user['drunk'];
			$this->full= $user['full'];
			
			$this->head= $user['head'];
			$this->torso= $user['torso'];
			$this->legs= $user['legs'];
			$this->hands= $user['hands'];
			$this->feet= $user['feet'];
			$this->acc= $user['acc'];
			
			$this->sewer_quest= $user['sewer_quest'];
			$this->sewerkey= $user['sewerkey'];
			$this->fish_caught= $user['fish_caught'];
			$this->pod_fish= $user['pod_fish'];
			
		}
		
		public function update() {
			$attacks = json_encode($this->attacks);
			$equip = json_encode($this->equip);
			$equipment = json_encode($this->equipment);
						
			$this->database->query("UPDATE `users` SET
					`level` = '{$this->level}',
					`photo` = '{$this->photo}',
					`exp` = '{$this->exp}',
					`exp_spend` = '{$this->exp_spend}',
					`health` = '{$this->health}',
					`max_health` = '{$this->max_health}',
					`money` = '{$this->money}',
					`strength` = '{$this->strength}',
					`dexterity` = '{$this->dexterity}',
					`endurance` = '{$this->endurance}',
					`attacks` = '{$attacks}',
					`equip` = '{$equip}',
					`equipment` = '{$equipment}',
					`incombat` = '{$this->incombat}',
					`round_damage` = '{$this->round_damage}',
					`turns` = '{$this->turns}',
					`turns_played` = '{$this->turns_played}',
					`robocop_count` = '{$this->robocop_count}',
					`killfucker_count` = '{$this->killfucker_count}',
					`drug_price` = '{$this->drug_price}',
					`drugs_bought` = '{$this->drugs_bought}',
					`target_bool` = '{$this->target_bool}',
					`target_id` = '{$this->target_id}',
					`target_count` = '{$this->target_count}',
					`target_total` = '{$this->target_total}',
					`resets` = '{$this->resets}',
					`can_bag` = '{$this->can_bag}',
					`lastadv` = '{$this->lastadv}',
					`drunk` = '{$this->drunk}',
					`full` = '{$this->full}',
					`head` = '{$this->head}',
					`torso` = '{$this->torso}',
					`legs` = '{$this->legs}',
					`hands` = '{$this->hands}',
					`feet` = '{$this->feet}',
					`acc` = '{$this->acc}',
					`sewer_quest` = '{$this->sewer_quest}',
					`sewerkey` = '{$this->sewerkey}',
					`fish_caught` = '{$this->fish_caught}',
					`pod_fish` = '{$this->pod_fish}'
				WHERE `id`='{$this->id}' LIMIT 1");
		}
	
}