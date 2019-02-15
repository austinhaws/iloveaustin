<?php
	date_default_timezone_set('UTC');

	require_once('lib.inc');

	define('kIntegration_Isolated', 'Isolated');
	define('kIntegration_Mixed', 'Mixed');
	define('kIntegration_Integrated', 'Integrated');
	define('kIntegration_Custom', 'Custom');

	define('kRace_Human', 'Human');
	define('kRace_Halfling', 'Halfling');
	define('kRace_Elf', 'Elf');
	define('kRace_Dwarf', 'Dwarf');
	define('kRace_Gnome', 'Gnome');
	define('kRace_HalfElf', 'Half Elf');
	define('kRace_HalfOrc', 'Half Orc');
	define('kRace_Other', 'Other');

	define('kMin', 'min');
	define('kMax', 'max');

	define('kClass_Adept', 'Adept');
	define('kClass_Aristocrat', 'Aristocrat');
	define('kClass_Barbarian', 'Barbarian');
	define('kClass_Bard', 'Bard');
	define('kClass_Cleric', 'Cleric');
	define('kClass_Commoner', 'Commoner');
	define('kClass_Druid', 'Druid');
	define('kClass_Expert', 'Expert');
	define('kClass_Fighter', 'Fighter');
	define('kClass_Monk', 'Monk');
	define('kClass_Monster', 'Monster');
	define('kClass_Paladin', 'Paladin');
	define('kClass_Psionic', 'Psionic');
	define('kClass_Ranger', 'Ranger');
	define('kClass_Rogue', 'Rogue');
	define('kClass_Sorcerer', 'Sorcerer');
	define('kClass_Warrior', 'Warrior');
	define('kClass_Wizard', 'Wizard');

	define('kPopulationType_Thorp', 'Thorp');
	define('kPopulationType_Hamlet', 'Hamlet');
	define('kPopulationType_Village', 'Village');
	define('kPopulationType_SmallTown', 'SmallTown');
	define('kPopulationType_LargeTown', 'LargeTown');
	define('kPopulationType_SmallCity', 'SmallCity');
	define('kPopulationType_LargeCity', 'LargeCity');
	define('kPopulationType_Metropolis', 'Metropolis');

	define('kHas_Military', 'Military');
	define('kHas_Sea', 'Sea');
	define('kHas_River', 'River');

	define('kWard_Administration', "Administration");
	define('kWard_Craftsmen', "Craftsmen");
	define('kWard_Gate', "Gate");
	define('kWard_Market', "Market");
	define('kWard_Merchant', "Merchant");
	define('kWard_Military', "Military");
	define('kWard_Oderiforous', "Oderiforous");
	define('kWard_Patriciate', "Patriciate");
	define('kWard_River', "River");
	define('kWard_Sea', "Sea");
	define('kWard_Shanty', "Shanty");
	define('kWard_Slum', "Slum");
	define('kWard_Outskirt', 'Outskirt'); // for map generation, this is an empty ward use to define the shape of the outskirts of town

	define('kRandom', 'random');

	require_once('tables.inc');
	require_once('ward_class.inc');
	require_once('power_center_class.inc');
	require_once('city_class.inc');

	function is_random($field) {
		return $field == kRandom;
	}
	function make_seed()
	{
	  list($usec, $sec) = explode(' ', microtime());
	  return (float) $sec + ((float) $usec * 100000);
	}
	function rand_range($min, $max) {
		return mt_rand($min, $max);
	}
	function rand_ratio() {
	   return (float)mt_rand() / (float)getrandmax();
	}
	function rand_ratio_range($min, $max) {
		return rand_ratio() * ($max - $min) + $min;
	}

	function initialize_array_value(&$array, $index, $init_val) {
		if (!isset($array[$index])) {
			$array[$index] = $init_val;
		}
	}
	function output_integer($int) {
		return number_format($int, 0, '.', ',');
	}

	function output_double($dbl) {
		return number_format($dbl, 2, '.', ',');
	}


	function table_center_begin() {
		return '<table class="table_center"><thead /><tbody><tr><td>';
	}
	function table_center_end() {
		return '</td></tr></tbody></table>';
	}

	global $use_statement;
	$use_statement = '
		<div class="center">
		This uses content from the free pdf donwload, open gaming content, <a target="_blank" href="http://e23.sjgames.com/item.html?id=XRPFREE1">A Magical Medieval City Guide</a> which is chapters three and four out of <a href="http://www.rpgnow.com/product_info.php?products_id=711" target="_blank">A Magical Medieval Society: Western Europe</a> created by <a href="http://www.xrpshop.citymax.com" target="_blank">Expeditious Retreat</a>
		</div>
			<div style="clear: both; height: 40px;">&nbsp;</div>
		</div>
		';
