<?
// takes an array of fields and an array of active abdodb objects and creates
// a basic associative array out of them
function adodb_to_array($adodb_base_obj, $objs) {
	$ret_array = array();
	foreach ($objs as $obj) {
		$ret_array[] = adodb_to_assoc($adodb_base_obj, $obj);
	}
	return $ret_array;
}
// for converting a single object to associative array
function adodb_to_assoc($adodb_base_obj, $obj) {
	$obj_array = array();
	foreach ($adodb_base_obj->getAttributeNames() as $field) {
		$obj_array[$field] = $obj->$field;
	}
	return $obj_array;
}

function convert_array_to_xmlarray(&$array) {
// this converst a php array to be ready for simplexml to convert it to cb xml dictionary objects
	$copy = $array;
	$array = array(
		'Object' => array(
			'@attributes' => array(
				'Type' => 'DictionaryClass',
			),
		),
	);
	foreach ($copy as $key => $value) {
		if ($key != '@attributes' && is_array($value)) {
			convert_array_to_xmlarray($value);
		}
		$array['Object'][$key] = $value;
	}
}

function generate_guid() {
// TAKEN FROM: http://www.somacon.com/p113.php
	// The field names refer to RFC 4122 section 4.1.2
	return sprintf('%04x%04x-%04x-%03x4-%04x-%04x%04x%04x',
		mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
		mt_rand(0, 65535), // 16 bits for "time_mid"
		mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
		bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
			// 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
			// (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
			// 8 bits for "clk_seq_low"
		mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node"
	);
}

function pprint_r($var, $title = '', $exit = false) {
	echo '<br/>';
	if ($title) {
		echo "<h3>$title</h3>";
	}
	echo '<pre>';
	if (!$var && $var !== 0) {
		echo 'pprint_r => blank';
	} elseif (is_array($var) || is_object($var) || ($var === 0)) {
		var_dump($var);
	} else {
		echo($var);
	}
	echo '</pre><br/>';
	if ($exit) {
		exit();
	}
}

/**
* TAKEN FROM: http://snipplr.com/view/3491/convert-php-array-to-xml-or-simple-xml-object-if-you-wish/
* MODIFIED: for attributes
*
* The main function for converting to an XML document.
* Pass in a multi dimensional array and this recrusively loops through and builds up an XML document.
*
* @param array $data
* @param string $rootNodeName - what you want the root node to be - defaultsto data.
* @param SimpleXMLElement $xml - should only be used recursively
* @return string XML
*/
function toXml($data, $rootNodeName = 'data', $xml=null)
{
	// turn off compatibility mode as simple xml throws a wobbly if you don't.
	if (ini_get('zend.ze1_compatibility_mode') == 1) {
		ini_set ('zend.ze1_compatibility_mode', 0);
	}

	if ($xml == null) {
		$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
	}

	// loop through the data passed in.
	foreach($data as $key => $value) {
		if ($key !== '@attributes' && substr($key, 0, 1) !== '_') {
			// no numeric keys in our xml please!
			if (is_numeric($key)) {
				// make string key...
				$key = 'key' . $key;
				//$key = "unknownNode_". (string) $key;
			}
			// replace anything not alpha numeric
			//$key = preg_replace('/[^a-z]/i', '', $key);

			// if there is another array found recrusively call this function
			if (is_array($value) || is_object($value)) {
				if (isset($value['value'])) {
					$node = $xml->addChild($key, $value['value']);
					unset($value['value']);
				} else {
					$node = $xml->addChild($key);
				}
				$node->addAttribute('Type', 'DictionaryClass'); // all arrays are dictionaryclasses
				// recrusive call.
				toXml($value, $rootNodeName, $node);
			} else {
				// add single node.
				$value = htmlentities($value);
				$node = $xml->addChild($key,$value);
				$node->addAttribute('Type', 'String');// everyting is a string!
			}
		}
	}
	// pass back as string. or simple xml object if you want!
	return $xml->asXML();
}

function implode_and($array, $blank = '') {
	if (!$array) {
		$ret_str = $blank;
	} else {
		$count = count($array);
		if ($count == 1) {
			$ret_str = $array[0];
		} else {
			$ret_str = '';
			for ($i = 0; $i < $count; ++$i) {
				if ($i == $count - 1) {
					$ret_str .= ' and ';
				} else if ($i) {
					$ret_str .= ', ';
				}
				$ret_str .= $array[$i];
			}
		}
	}
	return $ret_str;
}
