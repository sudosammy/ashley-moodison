<?php
/************************************************************************************** GENERIC **************************************************************************************/
require_once('phpThumb/phpthumb.class.php');

/******************************************
	Show Stuff v2.0
******************************************/
function ss() {
	$values = func_get_args();
	echo '<pre>';

	foreach ($values as $value) {
		print_r($value);
		echo '<br/>';
	}

	echo '</pre>';
}
function show_stuff() {
	$values = func_get_args();
	echo '<pre>';

	foreach ($values as $value) {
		print_r($value);
		echo '<br/>';
	}

	echo '</pre>';
}

/******************************************
	Send Someone Somewhere
******************************************/
function gtfo($url = WEB_ROOT) {
	header('Location: ' . $url);
	exit();
}

/************************************************************************************** TIME MANIPULATION **************************************************************************************/

/******************************************
	Make a MySQL TIMESTAMP Pretty
******************************************/
function pretty_date($time, $rfc = false, $small = false) {
	if ($rfc) {
		return date(DATE_RFC2822, strtotime($time));
	} else if ($small) {
		return date('g:ia - jS \of M', strtotime($time));
	} else {
		return date('g:ia l jS \of F Y', strtotime($time));
	}
}

/******************************************
	MySQL Timestamp Generation
******************************************/
function mysql_timestamp() {
	return date('Y-m-d G:i:s');
}

/************************************************************************************** STRING MANIPULATION **************************************************************************************/

/******************************************
	Truncate Text
******************************************/
function truncate_text($text_to_truncate,$max_chars = 300, $letters = false) {
	if (strlen($text_to_truncate) > $max_chars) {
		$text_to_truncate = substr($text_to_truncate, 0, $max_chars);

		if (!$letters) {
			$text_to_truncate = substr($text_to_truncate, 0, strrpos($text_to_truncate, ' '));
		}

		$text_to_truncate .= '...';
	}

	return $text_to_truncate;
}

/******************************************
	Truncate Strings
******************************************/
function truncate_string($string, $length) {
    return (strlen($string) > $length) ? substr($string, 0, $length) : $string;
}

/******************************************
	Neat Strings
******************************************/
function neat_string($string) {
	$string = strtolower($string);
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	return preg_replace('/-+/', '-', $string); //Remove duplicate hyphens.
}

/******************************************
	Create Slugs (see neat_strings)
******************************************/
function slug($title) {
	// replace non letter or digits by -
	$title = preg_replace('~[^\\pL\d]+~u', '-', $title);
	// trim
	$title = trim($title, '-');
	// transliterate - hide warnings
	$title = @iconv('utf-8', 'us-ascii//TRANSLIT', $title);
	// lowercase
	$title = strtolower($title);
	// remove unwanted characters
	$title = preg_replace('~[^-\w]+~', '', $title);

	if (empty($title)) {
		return 'n-a-' . rand(10,99);
	}
	return $title;
}

/******************************************
	Strip Special Chars (Keeps Whitespaces)
******************************************/
function strip_chars($string) {
	return preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
}

/******************************************
	Strip non-printable characters + nl2br
******************************************/
function printable($var_array) {
	//htmlentities + trim + utf-8 array values
	if (is_array($var_array)) {
		foreach ($var_array as $key => $value) {
			// order is important
			$s = trim($value);
			$s = htmlentities($s); // htmlentities first
			$s = nl2br($s); // then nl2br
			$s = preg_replace( '/[^[:print:]]/', '', $s); // only return printable ASCII characters
			$var_array[$key] = $s;
		}
	} else {
		// order is important
		$s = trim($var_array);
		$s = htmlentities($s); // htmlentities first
		$s = nl2br($s); // then nl2br
		$s = preg_replace( '/[^[:print:]]/', '', $s); // only return printable ASCII characters
		$var_array = $s;
	}

	return $var_array;
}

/************************************************************************************** RANDOM RELATED FUNCTIONS **************************************************************************************/

/******************************************
	Random String Generator (Salt a Hash)
******************************************/
function rand_string($length) {
	$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$()';
	$salt = '';
	for ($i = 0; $i < $length; $i++) {
		$salt .= $chars[mt_rand(0, strlen($chars) - 1)];
	}
	return $salt;
}

/******************************************
	Hash Passwords
	BLURGH! It's not using PHP's built in bcrypt tool
	BAD
	BAD
	Fix it later
******************************************/
function new_hash($pass, $salt, $itterations = 500) {
	$i = 0;
	$beast = 0;
	while($i < $itterations) {
		$beast = hash('sha512', $beast . $pass . $salt);
		$i++;
	}
	return $beast;
}

/******************************************
	Create Crypto Random String
******************************************/
function crypto_random($length, $encode = false, $sample = 1000) {
	if($encode) {
		return substr(urlencode(base64_encode(openssl_random_pseudo_bytes($sample)), 0, $length));
	} else {
		return substr(base64_encode(openssl_random_pseudo_bytes($sample)), 0, $length);
	}
}

/******************************************
	PDO Sanitization Specific
******************************************/
// sql string
function sanitize_sql_string($string, $min = '', $max = '', $strip_semicolon = true) {
	$string = nice_addslashes($string);

	$string_length = (!is_array($string)) ? strlen($string) : 0;

	if ((($min != '') && ($string_length < $min)) || (($max != '') && ($string_length > $max))) {
		return false;
	}

	return ($strip_semicolon) ? preg_replace('/;/', '', $string) : $string;
}
// add slashes
function nice_addslashes($string) {
	if (!is_array($string)) {
		return addslashes($string);
	}

	foreach ($string as $key => $value) {
		$string[$key] = (is_array($value)) ? nice_addslashes($value) : addslashes($string[$key]);
	}

	return $string;
}

// int
function sanitize_int($integer, $min = '', $max = '') {
	$int = intval($integer);

	if ((($min != '') && ($int < $min)) || (($max != '') && ($int > $max))) {
		return false;
	}

	return $int;
}

// float
function sanitize_float($float, $min = '', $max = '') {
	$float = floatval($float);

	if ((($min != '') && ($float < $min)) || (($max != '') && ($float > $max))) {
		return false;
	}

	return $float;
}

//remove unwanted characters
function sanitize_filename($filename) {
	$disallowed_characters = '/[^a-zA-Z0-9\-_()\.]/';
	$filename = preg_replace($disallowed_characters, '', $filename);

	//what if filename is nothing but disallowed characters?
	if (substr($filename, 0, strrpos($filename, '.')) == ''){
		$filename = uniqid() . rand(100, 1000) . substr($filename, strrpos($filename, '.'));
	}

	return $filename;
}

/************************************************************************************** APPLICATION SPECIFIC **************************************************************************************/

function get_absolute_path($path) {
	// because I deved on a windows machine, we replace "DIRECTORY_SEPARATOR" with "/"
		$path = str_replace(array('/', '\\'), '/', $path);
		$parts = array_filter(explode('/', $path), 'strlen');
		$absolutes = array();
		foreach ($parts as $part) {
				if ('.' == $part) continue;
				if ('..' == $part) {
						array_pop($absolutes);
				} else {
						$absolutes[] = $part;
				}
		}
		return implode('/', $absolutes);
}
