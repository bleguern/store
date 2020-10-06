<?php

define('EURO_NUMBER_NB', 5);
define('EURO_NUMBER_MAX', 50);
define('EURO_STAR_NB', 2);
define('EURO_STAR_MAX', 11);

define('LOTO_NUMBER_NB', 5);
define('LOTO_NUMBER_MAX', 49);
define('LOTO_STAR_NB', 1);
define('LOTO_STAR_MAX', 10);

define('DEFAULT_GRID_NB', 1);
define('DEFAULT_TYPE', 'loto');

define('DEFAULT_STRING', 'test');

$grid_nb = DEFAULT_GRID_NB;
$type = DEFAULT_TYPE;
$string = DEFAULT_STRING;

if (isset($_REQUEST['grid_nb']) && ($_REQUEST['grid_nb'] != '')) {
	$grid_nb = $_REQUEST['grid_nb'];
}

if (isset($_REQUEST['type']) && ($_REQUEST['type'] != '')) {
	$type = $_REQUEST['type'];
}

if (isset($_REQUEST['string']) && ($_REQUEST['string'] != '')) {
	$string = $_REQUEST['string'];
}


$temp_numbers = Array();
$temp_stars = Array();
$numbers_count = 0;
$stars_count = 0;

for ($i = 0; $i < $grid_nb; $i++) {
	
	if ($type == 'loto') {
		for ($j = 0; $j < LOTO_NUMBER_NB; $j++) {
			if ($j > 0) {
				echo ' - ';
			}
			
			$current = 0;
			
			do {
				$found = false;
				$current = get_rand_with_string($string, 1, LOTO_NUMBER_MAX);
				
				if ($numbers_count < LOTO_NUMBER_MAX) {
					for ($k = 0; $k < $numbers_count; $k++) {
						if ($current == $temp_numbers[$k]) {
							$found = true;
							break;
						}
					}
				}
			} while ($found == true);
			
			$temp_numbers[$numbers_count] = $current;
			echo $temp_numbers[$numbers_count];
			$numbers_count++;
		}
		
		echo ' * ';
		
		for ($j = 0; $j < LOTO_STAR_NB; $j++) {
			if ($j > 0) {
				echo ' - ';
			}
			
			$current = 0;
				
			do {
				$found = false;
				$current = get_rand_with_string($string, 1, LOTO_STAR_MAX);
			
				if ($stars_count < LOTO_STAR_MAX) {
					for ($k = 0; $k < $stars_count; $k++) {
						if ($current == $temp_stars[$k]) {
							$found = true;
							break;
						}
					}
				}
			} while ($found == true);
				
			$temp_stars[$stars_count] = $current;
			echo $temp_stars[$stars_count];
			$stars_count++;
		}
		
		echo '<BR>';
		
	} else if ($type == 'euro') {
		for ($j = 0; $j < EURO_NUMBER_NB; $j++) {
			if ($j > 0) {
				echo ' - ';
			}
			
			$current = 0;
				
			do {
				$found = false;
				$current = get_rand_with_string($string, 1, EURO_NUMBER_MAX);
			
				if ($numbers_count < EURO_NUMBER_MAX) {
					for ($k = 0; $k < $numbers_count; $k++) {
						if ($current == $temp_numbers[$k]) {
							$found = true;
							break;
						}
					}
				}
			} while ($found == true);
				
			$temp_numbers[$numbers_count] = $current;
			echo $temp_numbers[$numbers_count];
			$numbers_count++;
		}
		
		echo ' * ';
		
		for ($j = 0; $j < EURO_STAR_NB; $j++) {
			if ($j > 0) {
				echo ' - ';
			}
			
			$current = 0;
			
			do {
				$found = false;
				$current = get_rand_with_string($string, 1, EURO_STAR_MAX);
					
				if ($stars_count < EURO_STAR_MAX) {
					for ($k = 0; $k < $stars_count; $k++) {
						if ($current == $temp_stars[$k]) {
							$found = true;
							break;
						}
					}
				}
			} while ($found == true);
			
			$temp_stars[$stars_count] = $current;
			echo $temp_stars[$stars_count];
			$stars_count++;
		}
		
		echo '<BR>';
	}
}


function get_rand_with_string($string, $min, $max) {
	$random_value = 0;
	$random_string_value = 0;
	$string_length = strlen($string);
	
	if ($string_length > 0) {
		$char_pos = mt_rand(0, $string_length - 1);
		$char_at = substr($string, $char_pos, 1);
		$random_string_value = ord($char_at);
	}
	
	$random_value = mt_rand($min, $max);
	$random_value = ($random_value + $random_string_value) % ($max + 1);
	
	if ($random_value == 0) {
		$random_value = 1;
	}
		
	return $random_value;
}

?>