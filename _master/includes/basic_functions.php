<?
/**
 * Perform a simple text replace
 * This should be used when the string does not contain HTML
 * (off by default)
 */
define('STR_HIGHLIGHT_SIMPLE', 1);
 
/**
 * Only match whole words in the string
 * (off by default)
 */
define('STR_HIGHLIGHT_WHOLEWD', 2);
 
/**
 * Case sensitive matching
 * (off by default)
 */
define('STR_HIGHLIGHT_CASESENS', 4);
 
/**
 * Overwrite links if matched
 * This should be used when the replacement string is a link
 * (off by default)
 */
define('STR_HIGHLIGHT_STRIPLINKS', 8);

function errorTextBoxHighlighter( $is_error ){
	if( $is_error ){
		return ' style="border: 1px red solid;" ';
	}
}

define("LATIN1_UC_CHARS", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝ");
define("LATIN1_LC_CHARS", "àáâãäåæçèéêëìíîïðñòóôõöøùúûüý");

function uc_latin1 ($str) {
    $str = strtoupper(strtr($str, LATIN1_LC_CHARS, LATIN1_UC_CHARS));
    return strtr($str, array("ß" => "SS"));
}

/**
 * dropdown give you a bunch of option tags. Make sure to make the select tag yourself!
 * NUMBERS added at type - takes array value 0 and 1 from the arr_key_value as start and finish
 *
 * @param unknown_type $type
 * @param unknown_type $default_value
 * @param unknown_type $arr_key_values
 * @return unknown
 */
function dropdown($type = NULL, $default_value = NULL, $arr_key_values = NULL ){
	$cal = cal_info(0);
	$str_return = NULL;
	$count = 1;
	switch ($type){
		case 'MONTH':
			foreach( $cal['months'] as $month ) {
				$str_return .= 	'<option value="'.$count.'"';
				$str_return .= ($default_value==$count)? ' selected' : NULL;
				$str_return .= '>'.$month.'</option>'."\n";
				$count++;
			}
		break;
		case 'MON':
			foreach( $cal['abbrevmonths'] as $mon ) {
				$str_return .= 	'<option value="'.$count.'"';
				$str_return .= ($default_value==$count)? ' selected' : NULL;
				$str_return .= 	'>'.$mon.'</option>'."\n";
				$count++;
			}
		break;
		case 'DAY':
			for( $count=1;$count<=$cal['maxdaysinmonth'];$count++ ) {
				$str_return .= 	'<option value="'.$count.'"';
				$str_return .= ($default_value==$count)? ' selected' : NULL;
				$str_return .= 	'>'.$count.'</option>'."\n";
			}
		break;
		case 'YEAR':
			// Currently gives you this year and next
			$str_return .= '<option value="'.date('Y').'">'.date('Y').'</option>';
			$str_return .= '<option value="'. date('Y', strtotime('next year')).'">'.date('Y', strtotime('next year')).'</option>';	
		break;
		case 'NUMBERS':
			// Will give you the numbers between value 0 and 1 of arr_key_values
			if( is_array($arr_key_values) ) {
				for( $count=$arr_key_values[0];$count<=$arr_key_values[1];$count++ ) {
					$str_return .= 	'<option value="'.$count.'"';
					$str_return .= ($default_value==$count)? ' selected' : NULL;
					$str_return .= 	'>'.$count.'</option>'."\n";
				}
			}
		break;
		default:
			if( is_array( $arr_key_values ) ){
				foreach( $arr_key_values as $key=>$val ) {
				$str_return .= 	'<option value="'.$key.'"';
				$str_return .= $default_value && ($default_value==$key)? ' selected' : NULL;
				$str_return .= 	'>'.$val.'</option>'."\n";
				}
			}
		break;
	}
	
	return $str_return;
}

function is_selected($checked_or_selected, $value, $value_to_match, $default_if_none = NULL) {
	if( $value == $value_to_match || $default_if_none ){
		if( !$value && $default_if_none ) {
			return $checked_or_selected;
		}
		if( $value ){
			return $checked_or_selected;
		}
	}
}

function str_highlight($text, $needle, $options = null, $highlight = null)
{
    // Default highlighting
    if ($highlight === null) {
        $highlight = '<strong>\1</strong>';
    }
 
    // Select pattern to use
    if ($options & STR_HIGHLIGHT_SIMPLE) {
        $pattern = '#(%s)#';
        $sl_pattern = '#(%s)#';
    } else {
        $pattern = '#(?!<.*?)(%s)(?![^<>]*?>)#';
        $sl_pattern = '#<a\s(?:.*?)>(%s)</a>#';
    }
 
    // Case sensitivity
    if (!($options & STR_HIGHLIGHT_CASESENS)) {
        $pattern .= 'i';
        $sl_pattern .= 'i';
    }
 
    $needle = (array) $needle;
    foreach ($needle as $needle_s) {
        $needle_s = preg_quote($needle_s);
 
        // Escape needle with optional whole word check
        if ($options & STR_HIGHLIGHT_WHOLEWD) {
            $needle_s = '\b' . $needle_s . '\b';
        }
 
        // Strip links
        if ($options & STR_HIGHLIGHT_STRIPLINKS) {
            $sl_regex = sprintf($sl_pattern, $needle_s);
            $text = preg_replace($sl_regex, '\1', $text);
        }
 
        $regex = sprintf($pattern, $needle_s);
        $text = preg_replace($regex, $highlight, $text);
    }
 
    return $text;
}
 
?>