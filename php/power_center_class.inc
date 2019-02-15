<?php
class power_center_class {
	public static $next_id;
	public $id;
	public $type = '';
	public $alignment = '';
	public $wealth = 0;
	public $npcs = array();
	public $influence_points;
	public $npcs_total = 0;

	public function __construct($type, $influence, $wealth, $num_centers, $city) {
		$this->id = ++power_center_class::$next_id;
		$this->type = $type;
		$this->wealth = $wealth;
		$this->influence_points = $influence;

		$this->random_alignment();

		$this->random_npcs($num_centers, $city);
	}

	private function random_alignment() {
		global $table_power_center_alignment;

		$this->alignment = get_table_result_range($table_power_center_alignment, rand_range(1, 100));
	}

	private function random_npcs($num_centers, $city) {
		/*
		• do class / level looping/rund own for each power center
		• each class/level slot only has a 1 in # power centers chance of generating npcs of the given level

		• this will divide the total number of npcs across the # of power centers and will give each
		power center a differing splatter of npcs yet could allow multiple power centers to have the
		same spattering

		• it will also make sure that all the possible influence points for the center are used for the center
		*/
		global $table_npc_level_modifiers;
		global $table_npc_classes_max_level;
		global $table_class_influence;
		global $table_class_random_class;

		$modifier = get_table_result_index($table_npc_level_modifiers, $city->population_type);

		$influence_left = $this->influence_points;
		$not_used_count = 0; // how many times it failed to add (usually because it picked something too expensive)

		// represents a row of npc levels all set to 0; each new npc class gets one of these rows
		$levels_prefilled = array();
		for ($i = 1; $i <= 20; $i++) {
			$levels_prefilled[] = array('level' => $i, 'count' => 0);
		}
		while ($influence_left && $not_used_count < 5) {
			// randomly pick a class
			$class = get_table_result_range($table_class_random_class, rand_range(1, 1000));
			// randomly pick level
			$max_level = get_table_result_index($table_npc_classes_max_level, $class) + $modifier;
			$max_level = max(0, min(20, $max_level + rand_range(0, 1)));

			$num = 1;
			$not_used_for = true;
			for ($level = rand_range(1, $max_level); $level > 0; ) {
				$influence_cost = get_table_result_index($table_class_influence, $class);

				$not_used = true;
				while ($num >= 1 && $not_used) {
					if (0 > $influence_left - ($influence_cost * $level * $num)) {
						--$num;
					} else {
						$influence_left -= get_table_result_index($table_class_influence, $class) * $level * $num;
						$found = false;
						foreach ($this->npcs as $key => $npc) {
							if ($npc['class'] == $class) {
								$found = $key;
								break;
							}
						}
						if ($found === false) {
							$this->npcs[] = array(
								'class' => $class,
								'levels' => $levels_prefilled,
							);
							$found = count($this->npcs) - 1;
						}
						$found_level = false;
						foreach ($this->npcs[$found]['levels'] as $key_level_loop => $level_loop) {
							if ($level_loop['level'] == $level) {
								$found_level = $key_level_loop;
								break;
							}
						}
						$this->npcs[$found]['levels'][$found_level]['count'] += $num;
						$this->npcs_total += $num;
						$not_used = false;
						$not_used_for = false;
					}
				}
				$num = max($num * 2, 1);

				if ($level == 1) {
					$level = 0;
				} else {
					$level = intval($level / 2) + ($level % 2) + (rand_range(1, 10) == 1 ? 1 : 0);
				}
			}
			if ($not_used_for) {
				++$not_used_count;
			}
		}

//pprint_r($this->npcs, 'npcs', true);
		usort($this->npcs, function($a, $b) {
			return strcmp($a['class'], $b['class']);
		});
	}

	public function number_npcs() {
		return $this->npcs_total;
	}
}
