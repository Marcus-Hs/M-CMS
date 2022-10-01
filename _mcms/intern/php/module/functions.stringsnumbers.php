<?php
function hexfromcolor($data) {
	global $sub_tpl;
	if (!empty($sub_tpl[$data]))	$data = $sub_tpl[$data];
	if (strpos('#',$data)!==false) return str_remove($data,'#');
	else return '000';
}
function hex2rgba($data,$color) {
	if (empty($data['opacity'])) $data['opacity'] = 1;
	return 'rgba('.hex2rgb($color).','.$data['opacity'].')';
}
function hex2rgb($Hex,$from='000000',$to='333333') {
	if (!empty($sub_tpl[strtolower($Hex)])) 		$Hex = $sub_tpl[strtolower($Hex)];
	if (preg_match('/#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})/',$Hex)) {
		if (substr($Hex,0,1) == "#")				$Hex = substr($Hex,1);
	#	if ($Hex == $from)							$Hex = $to;
		if (strlen($Hex)==6) {
			$RGB['R'] = hexdec(substr($Hex,0,2));
			$RGB['G'] = hexdec(substr($Hex,2,2));
			$RGB['B'] = hexdec(substr($Hex,4,2));
		} else {
			$RGB['R'] = hexdec(str_repeat(substr($Hex,0,1),2));
			$RGB['G'] = hexdec(str_repeat(substr($Hex,1,1),2));
			$RGB['B'] = hexdec(str_repeat(substr($Hex,2,1),2));
		}
		return r_implode($RGB);
	} else {
		return $Hex;
}	}
function rgb2hex($rgb){
	if (preg_match('/rgb\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})/',$rgb,$match)) {
		return rgb2hex2($match[1][0],$match[1][1],$match[1][2]);
	} else return $rgb;
}
function rgb2hex2($R,$G,$B){
	$R=dechex($R);
	If (strlen($R)<2)	$R='0'.$R;
	$G=dechex($G);
	If (strlen($G)<2)	$G='0'.$G;
	$B=dechex($B);
	If (strlen($B)<2)	$B='0'.$B;
	return '#'.$R.$G.$B;
}
function isValidIBAN ($iban='') {
	if (empty($iban) || strpos($iban,'%')!==false)	return false;
  $iban = strtolower($iban);
  $Countries = array(
	'al'=>28,'ad'=>24,'at'=>20,'az'=>28,'bh'=>22,'be'=>16,'ba'=>20,'br'=>29,'bg'=>22,'cr'=>21,'hr'=>21,'cy'=>28,'cz'=>24,
	'dk'=>18,'do'=>28,'ee'=>20,'fo'=>18,'fi'=>18,'fr'=>27,'ge'=>22,'de'=>22,'gi'=>23,'gr'=>27,'gl'=>18,'gt'=>28,'hu'=>28,
	'is'=>26,'ie'=>22,'il'=>23,'it'=>27,'jo'=>30,'kz'=>20,'kw'=>30,'lv'=>21,'lb'=>28,'li'=>21,'lt'=>20,'lu'=>20,'mk'=>19,
	'mt'=>31,'mr'=>27,'mu'=>30,'mc'=>27,'md'=>24,'me'=>22,'nl'=>18,'no'=>15,'pk'=>24,'ps'=>29,'pl'=>28,'pt'=>25,'qa'=>29,
	'ro'=>24,'sm'=>27,'sa'=>24,'rs'=>22,'sk'=>24,'si'=>19,'es'=>24,'se'=>24,'ch'=>21,'tn'=>24,'tr'=>26,'ae'=>23,'gb'=>22,'vg'=>24
  );
  $Chars = array(
	'a'=>10,'b'=>11,'c'=>12,'d'=>13,'e'=>14,'f'=>15,'g'=>16,'h'=>17,'i'=>18,'j'=>19,'k'=>20,'l'=>21,'m'=>22,
	'n'=>23,'o'=>24,'p'=>25,'q'=>26,'r'=>27,'s'=>28,'t'=>29,'u'=>30,'v'=>31,'w'=>32,'x'=>33,'y'=>34,'z'=>35
  );

  if (strlen($iban) != $Countries[ substr($iban,0,2) ]) { return false; }

  $MovedChar = substr($iban, 4) . substr($iban,0,4);
  $MovedCharArray = str_split($MovedChar);
  $NewString = "";

  foreach ($MovedCharArray as $k => $v) {

	if ( !is_numeric($MovedCharArray[$k]) ) {
	  $MovedCharArray[$k] = $Chars[$MovedCharArray[$k]];
	}
	$NewString .= $MovedCharArray[$k];
  }
  if (function_exists("bcmod")) { return bcmod($NewString, '97') == 1; }

  // http://au2.php.net/manual/en/function.bcmod.php#38474
  $x = $NewString; $y = "97";
  $take = 5; $mod = "";

  do {
	$a = (int)$mod . substr($x, 0, $take);
	$x = substr($x, $take);
	$mod = $a % $y;
  }
  while (strlen($x));

  return (int)$mod == 1;
}
function restructure_address(&$daten,$prefix='',$replace='',$splitname=true) {
	if ($splitname && !empty($daten[$prefix.'name']) && empty($daten[$prefix.'nachname'])) {
		if (strpos($daten[$prefix.'name'],',')>0)		list($daten[$prefix.'name'],$daten[$prefix.'nachname']) = explode(',',$daten[$prefix.'name'],2);
		elseif (strpos($daten[$prefix.'name'],'/')>0)	list($daten[$prefix.'name'],$daten[$prefix.'nachname']) = explode('/',$daten[$prefix.'name'],2);
		elseif (strpos($daten[$prefix.'name'],' ')>0)	list($daten[$prefix.'name'],$daten[$prefix.'nachname']) = explode(' ',$daten[$prefix.'name'],2);
	}
#	if (!empty($daten[$prefix.'packstation']) && empty($daten[$prefix.'postnummer'])) 	$daten[$prefix.'postnummer'] = filter_address($daten[$prefix.'packstation'],true,true,true);
#	if (!empty($daten[$prefix.'packstation']) && is_numeric($daten[$prefix.'packstation'])) $daten[$prefix.'packstation'] = 'packstation '.$daten[$prefix.'packstation'];
#	if (!empty($daten[$prefix.'strasse'])	  && empty($daten[$prefix.'hausnummer'])) 	$daten[$prefix.'hausnummer'] = filter_address($daten[$prefix.'strasse'],true,true,true);
	if (!empty($daten[$prefix.'ort'])		  && empty($daten[$prefix.'plz']))			$daten[$prefix.'plz']		 = filter_address($daten[$prefix.'ort'],false,false,true);
/*	if (!empty($replace)) {
		if (!empty($daten[$prefix.'name']))			$daten[$prefix.'name'] 		= str_replace(' ',$replace,$daten[$prefix.'name']);
		if (!empty($daten[$prefix.'nachname']))		$daten[$prefix.'nachname']	= str_replace(' ',$replace,$daten[$prefix.'nachname']);
		if (!empty($daten[$prefix.'strasse']))		$daten[$prefix.'strasse']	= str_replace(' ',$replace,$daten[$prefix.'strasse']);
		if (!empty($daten[$prefix.'nummer']))		$daten[$prefix.'nummer']	= str_replace(' ',$replace,$daten[$prefix.'nummer']);
		if (!empty($daten[$prefix.'ort']))			$daten[$prefix.'ort']		= str_replace(' ',$replace,$daten[$prefix.'ort']);
		if (!empty($daten[$prefix.'plz']))			$daten[$prefix.'plz']		= str_replace(' ',$replace,$daten[$prefix.'plz']);
	}
*/	if (!empty($daten[$prefix.'name']))			$daten[$prefix.'name'] 		= ucfirst($daten[$prefix.'name']);
	if (!empty($daten[$prefix.'nachname']))		$daten[$prefix.'nachname']	= ucfirst($daten[$prefix.'nachname']);
	if (!empty($daten[$prefix.'strasse']))		$daten[$prefix.'strasse']	= ucfirst($daten[$prefix.'strasse']);
	if (!empty($daten[$prefix.'ort']))			$daten[$prefix.'ort']		= ucfirst($daten[$prefix.'ort']);
}
function filter_address(&$data,$reverse=true,$startsWithNumber=true,$filter=false,$just_nbr=false) {
	if ($just_nbr && is_numeric($data))	return true;
	if ($reverse)	$tmp = array_reverse(explode(' ',$data));
	else			$tmp = explode(' ',$data);
	$end = array_pop($tmp);
	if (!empty($tmp[0])) {
		$nbr = array_shift($tmp);
		if (hasNumber($nbr))	$hasnbr = true;
		else					$hasnbr = false;
		foreach ($tmp as $part) {
			 if ($startsWithNumber && startsWithNumber($part)) {
				$hasnbr = true;
				if ($reverse)	$nbr = $part.' '.$nbr;
				else			$nbr .= ' '.$part;
				break;
			 } elseif (!$startsWithNumber && hasNumber($part)) {
				$hasnbr = true;
				if ($reverse)	$nbr = $part.' '.$nbr;
				else			$nbr .= ' '.$part;
			 } elseif (!$startsWithNumber && !hasNumber($part)) {
				break;
			 }
		}
		if ($filter) {
			$data = trim(str_replace($nbr,'',$data),' ');
			if($hasnbr && !empty($data))	return $nbr;
			return '';
		}
		else return $hasnbr;
	}
}
function explode_lines($string,$expl=';') {
	$string = trim($string,',');
	if (strpos($string,"\n")!==false)	$lines = explode("\n",str_replace(array("\r"),array("\n"),$string));
	else								$lines = explode($expl,$string);
	return cleanArray($lines);
}
function url_seri($data)		{return urlencode(serialize($data));}
function unseri_unurl($data)	{return unserialize(urldecode($data));}
function ascii_encode($string)  {
	for ($i=0; $i < strlen($string); $i++) $encoded[] = ord(substr($string,$i)).';';
	return implode('&amp;#',$encoded);
}
function unaccent($string) {
	$string = my_htmlentities($string);
	$string = str_replace('&szlig;','ss',$string);
	$string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $string), ENT_QUOTES, 'UTF-8');
	return $string;
}
function be_shy($string,$dashes=true) {
	if ($dashes) {
		preg_match_all('/([-]+)(?)([a-z]+)/',$string,$matches);
		foreach ($matches[0] as $nr => $match)	$string = str_replace($match,'&shy;'.$matches[2][$nr],$string);
	}
	$string = str_replace('#SHY#','&shy;',$string);
	return $string;
}
function exec_time($do='',$output='') {
	global $exec_time;
	if (empty($exec_time['start'])) {
		$exec_time['start'] = microtime(true);
	} else {
		$exec_time['end'] = FormatNumber(microtime(true) - $exec_time['start'],',','.','s',5);
		unset($exec_time['start']);
		return $exec_time['end'];
}	}
function calc_size($size=0,$precision=0,$base=1024) {		// computer readable format
	$unit = array('B','K','M','G','T','P','E');
	$power = array_search(substr($size,-1),$unit);
	$size = (int) substr($size,0,-1);
	return @round($size*pow($base,$power),$precision);
}
function bytesToSize($bytes,$precision=0,$base=1024) {	// human readable format
	$unit = array('B','KB','MB','GB','TB','PB','EB');
	return @round($bytes/pow($base,($i = floor(log($bytes,$base)))),$precision).' '.$unit[$i];
}
function startsWithNumber($string) {
	return preg_match('/^\d/', $string) === 1;
}
function endsWithNumber($string) {
	return preg_match('/\d$/', $string) === 1;
}
function hasNumber($string) {
	return preg_match('/\d/', $string) === 1;
}
function FormatPrice($price) {
	global $lang;
	if ($lang == 'en')	return FormatNumber($price,'.',',',false,2);
	else				return FormatNumber($price,',','.',false,2);
}
function FormatNumber($price,$decimal=',',$thousands='.',$curr='',$dec=2,$space=' '/*'&nbsp;'*/) {
	global $vorgaben;
	if ($curr || $curr=='*') {
		if (!empty($vorgaben['currency']))	$curr = $space.$vorgaben['currency'];
		else								$curr = $space.'&euro;';
	}
	if ($price < 0)	$sign =  '- ';
	else			$sign =  '';
	$price = preg_replace("/[^0-9\.]/", "", str_replace(',','.',$price));
	if 	(!empty($price) && is_numeric($price))  $out = number_format($price,$dec,$decimal,$thousands);
	else										$out = '0'.$decimal.'00';
	return $sign.$out.$curr;
}
// Original PHP code by Chirp Internet: www.chirp.com.au
// Please acknowledge use of this code by including this header.
function truncate($string, $limit=65, $break=" ", $pad=" ...") {
	$string = trim($string);
	if(strlen($string) <= $limit) {	// return with no change if string is shorter than $limit
		return $string;
	} elseif (!empty($break)) {
		$string = substr($string, 0, $limit);
		if(false !== ($breakpoint = strrpos($string, $break))) {
			$string = substr($string, 0, $breakpoint);
		}
		return trim($string).$pad;
	} else {
		return trim(substr($string,0,$limit)).$pad;
}	}
function betweenstr($string,$from,$to)	{
	if (strpos($string,$to)!==false)	$string = startstr($string,$to);
	if (strpos($string,$from)!==false)	$string = endstr($string,$from);
	return $string;
}
function startstr($string,$to) {
	$x = explode($to,$string);
	return array_shift($x);
}
function endstr($string,$from) {
	if(is_array($string))	$x = explode($from,current($string));
	else					$x = explode($from,$string);
	return array_pop($x);
}
function str_remove($string,$remove=',') {
	return str_replace($remove,'',$string);
}
function string_lead($value, $places, $lead = "0"){
	// Function written by Marcus L. Griswold (vujsa)
	// Can be found at http://www.handyphp.com
	// Do not remove this header!
	$leading = '';
	if(is_numeric($value)) {
		for($x = 1; $x <= $places; $x++) {
			$ceiling = pow(10, $x);
			if($value < $ceiling) {
				$zeros = $places - $x;
				for($y = 1; $y <= $zeros; $y++) $leading .= $lead;
				$x = $places + 1;
		}	}
		return $leading.$value;
	} else return $value;
}
?>