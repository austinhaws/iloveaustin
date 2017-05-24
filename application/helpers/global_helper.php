<?
	date_default_timezone_set('UTC');

	// convert a variable to an object; useful for mimicing db results
	function to_object ($x) {
		return (is_object($x) || is_array($x)) ? json_decode(json_encode($x)) : (object) $x;
	}

	function to_array($x) {
		return is_object($x) ? get_object_vars($x) : $x;
	}

	// debugging helper
	function pprint_r($var, $title = '', $exit = false) {
		echo '<br/>';

		if ($title) {
			echo "<h3>$title</h3>";
		}

		echo '<pre>';

		if (!$var && $var !== 0) {
			echo 'pprint_r => blank';
		} elseif (is_array($var) || is_object($var) || ($var === 0)) {
			print_r($var);
		} else {
			echo($var);
		}

		echo '</pre><br/>';

		if ($exit) {
			exit();
		}
	}

	// just checks that the session_player_account is set
	function is_logged_in() {
		$CI =& get_instance();
		return $CI->session->userdata(SESSION_ACCOUNT) !== false;
	}

	// ---- PERIODS ---- //
	function current_period() {
		date_default_timezone_set('America/Denver');
		return explode('/', date('m/Y', time()));
	}

	function load_period($month = false, $year = false) {
		if ($month <= 0
			|| $month >= 13
			|| strlen($year) != 4) {
			list($month, $year) = current_period();
		}
		return array('month' => sprintf("%02d", $month), 'year' => $year, 'combined' => sprintf("%02d", $month) . '/' . $year);
	}

	function last_period($period) {
		if (--$period['month'] < 1) {
			$period['month'] = 12;
			--$period['year'];
		}
		$period['month'] = sprintf("%02d", $period['month']);
		$period['combined'] = sprintf("%02d", $period['month']) . '/' . $period['year'];
		return $period;
	}
	function next_period($period) {
		if (++$period['month'] > 12) {
			$period['month'] = 1;
			++$period['year'];
		}
		$period['month'] = sprintf("%02d", $period['month']);
		$period['combined'] = sprintf("%02d", $period['month']) . '/' . $period['year'];
		return $period;
	}

	function load_period_into_data(&$data) {
		$data['current_period'] = load_period(false, false);
		if (!isset($data['month'])) {
			$data['month'] = $data['current_period']['month'];
		}
		if (!isset($data['year'])) {
			$data['year'] = $data['current_period']['year'];
		}
		$data['period'] = load_period($data['month'], $data['year']);
		$data['next_period'] = next_period($data['period']);
		$data['last_period'] = last_period($data['period']);
	}
	// ---- END PERIODS ---- //

	// ---- MONEY ---- //
	function format_currency($currency) {
		while (($length = strlen($currency)) < 3) {
			$currency = '0' . $currency;
		}
		return '$' . substr($currency, 0, $length - 2) . '.' . substr($currency, $length - 2);
	}

/**
 * convert a money string to a money amount
 *
 * @param $money_str
 * @return string
 */
	function string_to_money($money_str) {
		if (0 === strpos($money_str, '$')) {
			$money_str = substr($money_str, 1);
		}
		$decimal_pos = strpos($money_str, '.');
		if ($decimal_pos === false) {
			$money_str .= '00';
		} else {
//echo 'decimalpos = ' . $decimal_pos . '<br />';
//echo 'money_str = ' . strlen($money_str) . '<br />';
			while ($decimal_pos + 2 >= strlen($money_str)) {
				$money_str .= '0';
			}
			if ($decimal_pos + 3 < strlen($money_str)) {
				$money_str = substr($money_str, 0, $decimal_pos + 3);
			}
			$money_str = implode('', explode('.', $money_str));
		}
		return $money_str;
	}
	// ---- END MONEY ---- //

	function checkbox_on($checkbox) {
		return $checkbox && $checkbox == 'on';
	}
