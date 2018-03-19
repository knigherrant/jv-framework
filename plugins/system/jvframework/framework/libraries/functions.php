<?php
/**
 # com_jvframwork - JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

if (! function_exists ( 'json_decode' )) {
	function json_decode($json, $assoc = false) {
		$comment = false;
		$out = '$x=';
		
		for($i = 0; $i < strlen ( $json ); $i ++) {
			if (! $comment) {
				if (($json [$i] == '{') || ($json [$i] == '['))
					$out .= ' array(';
				else if (($json [$i] == '}') || ($json [$i] == ']'))
					$out .= ')';
				else if ($json [$i] == ':')
					$out .= '=>';
				else
					$out .= $json [$i];
			} else
				$out .= $json [$i];
			if ($json [$i] == '"' && $json [($i - 1)] != "\\")
				$comment = ! $comment;
		}
		eval ( $out . ';' );
		
		if ($assoc == false) {
			$obj = new stdClass ();
			if (count ( $x )) {
				foreach ( $x as $key => $val ) {
					$obj->$key = $val;
				}
			}
			
			return $obj;
		
		} else {
			return $x;
		}
	
	}
}
if (! function_exists ( 'json_encode' )) {
	function json_encode($array) {
		
		if (! is_array ( $array )) {
			return false;
		}
		
		$associative = count ( array_diff ( array_keys ( $array ), array_keys ( array_keys ( $array ) ) ) );
		if ($associative) {
			
			$construct = array ();
			foreach ( $array as $key => $value ) {
				
				// We first copy each key/value pair into a staging array,
				// formatting each key and value properly as we go.
				

				// Format the key:
				if (is_numeric ( $key )) {
					$key = "key_$key";
				}
				$key = "'" . addslashes ( $key ) . "'";
				
				// Format the value:
				if (is_array ( $value )) {
					$value = json_encode ( $value );
				} else if (! is_numeric ( $value ) || is_string ( $value )) {
					$value = "'" . addslashes ( $value ) . "'";
				}
				
				// Add to staging array:
				$construct [] = "$key: $value";
			}
			
			// Then we collapse the staging array into the JSON form:
			$result = "{ " . implode ( ", ", $construct ) . " }";
		
		} else { // If the array is a vector (not associative):
			

			$construct = array ();
			foreach ( $array as $value ) {
				
				// Format the value:
				if (is_array ( $value )) {
					$value = json_encode ( $value );
				} else if (! is_numeric ( $value ) || is_string ( $value )) {
					$value = "'" . addslashes ( $value ) . "'";
				}
				
				// Add to staging array:
				$construct [] = $value;
			}
			
			// Then we collapse the staging array into the JSON form:
			$result = "[ " . implode ( ", ", $construct ) . " ]";
		}
		
		return $result;
	}
}

if (! function_exists ( 'calculate_string' )) {
	function calculate_string($mathString) {
		$mathString = trim ( $mathString ); // trim white spaces
		$mathString = preg_replace ( '/^0-9\+-\*\/\(\)/', '', $mathString ); // remove any non-numbers chars; exception for math operators
		

		$compute = create_function ( "", "return (" . $mathString . ");" );
		return 0 + $compute ();
	}
}