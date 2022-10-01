<?php
function array_change_key_case_recursive($arr,$recursive=false) {
	if ($recursive) {
		return array_map(function($item) {
			if(is_array($item))
				return array_change_key_case_recursive($item);
		},array_change_key_case($arr));
	} else {
		return array_change_key_case($arr);
	}
}
function utf8ize($d) {
	if (is_array($d)) {
		foreach ($d as $k => $v) {
			$d[$k] = utf8ize($v);
		}
	} else if (is_string ($d)) {
		return utf8_encode($d);
	}
	return $d;
}
function arrayget($data,$glue = ': ',$glue2 = '',$sep="\n<br />",$empty=true) {
	if (!empty($_REQUEST[$data])) {
		return key_implode($_REQUEST[$data],$glue,$glue2,$sep,$empty);
}	}
function key_implode($array,$glue = '="',$glue2 = '"',$sep=' ',$empty=true) {
	if (!empty($array)) {
		foreach ($array as $key => $value) {
			if (is_array($value)) 	$value = current($value);
			if(!$empty || ($empty && !empty($value))) {
				if ($glue)	$out[$key] = $key.$glue.r_implode($value).$glue2;
				else		$out[$key] = r_implode($value).$glue2;
		}	}
		if (!empty($out))	return r_implode($sep,$out,true);
}	}
function r_implode($glue,$pieces=',',$unique=false,$nonempty=false) {
	if (is_string($pieces))  {	// only one parameter [Array] given, or mixed up with glue.
		if (is_array($glue)) {	// This shouldn't be an array. Never mind. -> ecxhange with pieces.
			$g = $pieces; $pieces = $glue; $glue = $g;
		} else return $glue;	// Only string value given, return it.
	}
	if (!is_array($pieces)) return $pieces;
	$pieces = flattenArray($pieces);
	if ($unique)		$pieces = array_unique($pieces);
	if ($nonempty)	$pieces = remove_empty($pieces);
	return implode($glue,$pieces);
}
function remove_empty($array) {
	foreach($array as $key => $link) {
	if(trim($link) === '') {
		unset($array[$key]);
	} }
	return $array;
}
function implode_ws($array,$glue2=' §ODER§ ',$glue=', ') {
	$array = flattenArray($array);
	$last_abschnitt = array_pop($array);
	if (count($array)>0)return implode($glue,$array).$glue2.$last_abschnitt;
	else				return $last_abschnitt;
}
function myEach(&$arr) {
	$key = key($arr);
	$result = ($key === null) ? false : [$key, current($arr), 'key' => $key, 'value' => current($arr)];
	next($arr);
	return $result;
}
function move_to_top(&$array,$key) {
	if (!empty($array[$key])) {
		$temp = array($key => $array[$key]);
		unset($array[$key]);
		$array = $temp + $array;
}	}
function move_to_bottom(&$array,$key) {
	if (!empty($array[$key])) {
		$value = $array[$key];
		unset($array[$key]);
		$array[$key] = $value;
}	}
function lower(&$string){
	$string = strtolower($string);
}
function is_numeric_array($array) {
	if (!is_array($array) && is_numeric($array)) return true;
	elseif(is_array($array)) {
		foreach ($array as $a => $b) {
			if (!is_numeric($b)) {
				return false;
			} elseif(is_array($b)) {
				 return is_numeric_array($b);
			}
		}
		return true;
	}
	return false;
}
function array_remove_by_value($array,$value) {
	return array_values(array_diff($array, array($value)));
}
function recursiveRemoval(&$array, $val) {
	if(is_array($array)) {
		foreach($array as $key=>&$arrayElement) {
			if(is_array($arrayElement)) {
				recursiveRemoval($arrayElement, $val);
			} else {
				if($arrayElement == $val) {
					unset($array[$key]);
				}
			}
		}
	}
}
function recursive_array_search($needle,$haystack) {
	if (is_string($needle) && is_array($haystack)) {
		foreach($haystack as $key=>$value) {
			if($needle===$value || (is_array($value) && $value = recursive_array_search($needle,$value))) {
				return $value;
			}
	}	}
	return false;
}
function filterArray($value){
	global $vorgaben;
	$replace = array('&nbsp;','&amp;nbsp;','&#194;','&amp;#194;','&#160;','&amp;#160;','<p></p>','<p><br/></p>',' ',"\r","\n");
	$t1 = str_remove($vorgaben['template'],$replace);
	if (!empty($_REQUEST['saveignore'])) {
		$value = str_remove($value,flattenArray($_REQUEST['saveignore']));
	}
	$t2 = str_remove($value,$replace);
	if (!empty($t2) && $t2 != '<p><br/></p>' && $t1 != $t2)	return true;
	else													return false;
}
function flattenArray($array,$unique=true) {
	if (!is_array($array))	return array($array);	// nothing to do if it's not an array
	$result = array();
	foreach ($array as $value)	$result = array_merge($result, flattenArray($value));	// explode the sub-array, and add the parts
	if ($unique) $result = array_unique($result);
	return $result;
}
function withkeyArray($array,$glue=':') {
	foreach ($array as $key => $value) {
		if		(is_array($value))		$out[$key] = cleanArray($value);
		elseif	(!empty($value))		$out[$key] = $key.$glue.$value;
	}
	if (!empty($out))	return $out;
	else				return false;
}
function cleanArray($array) {
	if (is_array($array)) {
		foreach ($array as $index => $value) {
			if		(is_array($value))	$out[$index] = cleanArray($value);
			elseif	(!empty($value))	$out[$index] = $value;
	}	}
	else $out = $array;
	if (!empty($out))	return $out;
	else				return false;
}
function replaceArray($array,$in,$repl) {
	if (is_array($array)) {
		foreach ($array as $index => $value) {
			if		(is_array($value))	$out[$index] = replaceArray($value,$in,$repl);
			elseif	(!empty($value))	$out[$index] = str_replace($in,$repl,$value);
	}	}
	else $out = str_replace($in,$repl,$array);
	if (!empty($out))	return $out;
	else				return false;
}
function fromArray($array,$key='',$value='') {
	if (is_array($array)) {
		foreach ($array as $k => $v) {
			if (is_array($v)) {
				$out[$k] = fromArray($v,$key,$value);
				if ($out[$k]==false)	unset($out[$k]);
			} else {
				if		(!empty($value) && $v == $value && $k == $key)	$out[$k] = $v;
				elseif	(empty($value)  && !empty($v)   && $k == $key)	$out[$k] = $v;
	}	}	}
	if (!empty($out))	return $out;
	else				return false;
}
function ArrayDepth($Array,$DepthCount=-1) {		// Find maximum depth of an array  Usage: int ArrayDepth( array $array )
	$DepthArray=array(0);$DepthCount++;$Depth = 0;	// returns integer with max depth  if Array is a string or an empty array it will return 0
	global $vorgaben;
	if (is_array($Array)) {
		foreach ($Array as $Key => $Value) {
			$DepthArray[] = ArrayDepth($Value,$DepthCount);
	}	}
	else return $DepthCount;
	return max($DepthCount,max($DepthArray));
}
function sortArrayByArray($array,$orderArray) {
	$ordered = array();
	foreach($orderArray as $key) {
		if(array_key_exists($key,$array)) {
			$ordered[$key] = $array[$key];
			unset($array[$key]);
	}	}
	return $ordered + $array;
}
function array2txt($array,$baseName='ARRAY',$skip = '',$eq=' = ',$quot1="'",$quot2="'; \n",$quots="'") {					// Infos wenn es ein Array ist.
	if (empty($array)) 		return false; 
	if (is_string($array))	return $array; 
	reset ($array);
	$out='';
	while (list($key, $value) = myEach($array)) {
		if (empty($skip) || !in_array($key,$skip)) {
			if (is_numeric($key))	$outKey = "[".$key."]";
			else					$outKey = "[".$quots.$key.$quots."]";
			if (is_array($value)) 	$out .= array2txt($value,$baseName.$outKey,$skip,$eq,$quot1,$quot2,$quots);
			else {
				$out .= $baseName . $outKey . $eq;
				if (is_string($value))		$out .= $quot1.$value.$quot2;
				elseif ($value === false) 	$out .= "false; \n";
				elseif ($value === NULL) 	$out .= "null; \n";
				elseif ($value === true) 	$out .= "true; \n";
				elseif (gettype($value)=='object')	$out .= array2txt($value) . "; \n";
				else					 	$out .= $value . "; \n";
	}	}	}
	return $out;
}
function strpos_arr($haystack, $needle) {
	if(!is_array($needle)) $needle = array($needle);
	foreach($needle as $what) {
		if(($pos = strpos($haystack, $what))!==false) return $pos;
	}
	return false;
}
?>