<?php
function this_monday() {	return this_day('monday');}
function this_tuesday() {	return this_day('tuesday');}
function this_wednesday(){return this_day('wednesday');}
function this_thursday() {	return this_day('thursday');}
function this_friday() {		return this_day('friday');}
function this_day($day) {
	return format_date(date( 'Y-m-d', strtotime( $day. ' this week' ) ), 'r') ;
}
function get_timestamp($date,$zone='UTC',$format='Y-m-d H:i:s') {
	$d = DateTime::createFromFormat(
		$format,
		$date.' 00:00:00',
		new DateTimeZone($zone)
	);
	if ($d === false) {
		return false;
	} else {
		return $d->getTimestamp();
	}
}
function alter($data) {
	return age($data);
}
function age($data) {
	if (strlen($data) < 5) {
		if ($data<(date("Y")-2000))	$data = $data+2000;
		elseif ($data<100)			$data = $data+1900;
		return (date("Y") - $data);
	} else {
		if (strpos($data,'-'))	list($Y,$m,$d) = explode('-',$data);
		if (strpos($data,'.'))	list($d,$m,$Y) = explode('.',$data);
		if ($Y<(date("Y")-2000))$Y = $Y+2000;
		elseif ($Y<100)			$Y = $Y+1900;
		$year_diff  = date("Y") - $Y;
		$month_diff = date("m") - $m;
		$day_diff   = date("d") - $d;
		if		($month_diff < 0) 						$year_diff--;
		elseif	(($month_diff==0) && ($day_diff < 0))	$year_diff--;
		return	$year_diff;
}	}
function gmt_offset($time='now') {
	$timezone = new DateTimeZone(date_default_timezone_get());	// Get default system timezone to create a new DateTimeZone object
	$offset = $timezone->getOffset(new DateTime($time)); 		// Offset in seconds to UTC
	$offsetHours = round(abs($offset)/3600);
	$offsetMinutes = round((abs($offset) - $offsetHours * 3600) / 60);
	$offsetString = ($offset < 0 ? '-' : '+')
			 . ($offsetHours < 10 ? '0' : '') . $offsetHours
			 . ':'
			 . ($offsetMinutes < 10 ? '0' : '') . $offsetMinutes;
	return $offsetString;
}
function is_future($date) {
	if (days_diff($date) > 0)	return true;
	else						return false;
}
function days_diff($endDate, $beginDate='') {
	if (empty($beginDate)) $beginDate = date('Y-m-d H:i:s');
	$date_b	= explode("-", startstr($beginDate,' '));   //explode the date by "-" and storing to array
	$date_e = explode("-", startstr($endDate,' '));
	//gregoriantojd() Converts a Gregorian date to Julian Day Count
	if (!empty($date_e[1])) return gregoriantojd($date_e[1], $date_e[2], $date_e[0]) - gregoriantojd($date_b[1], $date_b[2], $date_b[0]);
	else return 1;
}
function getday($data) {
	global $sub_tpl;
	if (!is_array($data)) {
		if (strpos($data,';')!==false) 	$params = explode(';',$data);
		else							$params[0] = $data;
		foreach ($params as $p) {
			$tmp = explode('=',$p);
			$data[$tmp[0]] = $tmp[1];
	}	}
	if (!empty($data['datetime'])) {
		if ($data['datetime'] == '%%HEUTE%%') {
			return '';
		}
		$mikrotime = strtotime($data['datetime']);
		list($day,$month,$year) = explode(' ',date('d n Y',$mikrotime));
	} else {
		list($day,$month,$year) = explode(' ',date('d n Y'));
		$mikrotime = mktime(0,0,0,$month,$day,$year);
	}
	if (isset($data['daynr']) && is_numeric($data['daynr'])) {
		if (!isset($data['n']))	$data['n'] = 1;
		extract(nth_weekday($month,$year,$data['daynr'],$data['n']),EXTR_OVERWRITE);
	}
	if (empty($data['tpl']) && !empty($sub_tpl['datum']))	$data['tpl'] = $sub_tpl['datum'];
	elseif (empty($data['tpl']))							$data['tpl'] = '#DD#.#MM#.#YYYY#';
	$tmday = date('j',mktime(0,0,0,$month,$day,$year));
	$ny = false;
	if (!empty($data['addm'])) {
	#	$madd = $data['addm'];
		$month = $month + $data['addm'];
		while ($month > 12) {
			$year++;
			$month = $month - 12;
			$ny = true;
		}
	}
	if (isset($data['skip']) && $month == $data['skip']) {
		$month++;
		while ($month > 12) {
			$year++;
			$month = $month - 12;
			$ny = true;
		}
	} else {
		$mday = date('j',mktime(0,0,0,$month,$day,$year));
		if ($day > $tmday) {
			$month++;
			if (isset($data['skip']) && $month == $data['skip']) {
				if (empty($madd))	$month++;
				else				$month += $madd+1;
			}
			while ($month > 12) {
				$year++;
				$month = $month - 12;
				$ny = true;
			}
			$mday = date('j',mktime(0,0,0,$month,$day,$year));
	}	}
	if (isset($data['skipshift']) && $month == $data['skipshift']) {
		$mday += $data['dshift'];
	}
	elseif (!isset($data['skipshift']) && isset($data['dshift'])) {
		$mday += $data['dshift'];
	}
	$mikrotime = mktime(0,0,0,$month,$mday,$year);
	if (empty($data['fill'])) 		$data['fill']=0;
	switch ($data['fill']) {
		case 1:	$out = tag($mikrotime).', den '.$mday.'. '.monat($mikrotime).' '.$year;	break;
		case 2:	$out = $mday.'. '.monat($mikrotime);									break;
		case 3:	$out = tag($mikrotime).', den '.$mday.'.'.date("n",$mikrotime).'. ';	break;
		default:
			if ($ny && !empty($data['nytpl']) && (empty($data['nym']) || $data['nym'] == $month))
				$tpl = $data['nytpl'];
			else
				$tpl = $data['tpl'];
			$out = str_replace(	array('#DD#','#DDD#','#DDDD#','#MM#','#MMMM#','#YYYY#','#YY#'),
								array($day,tag($mikrotime,2),tag($mikrotime),date("m",$mikrotime),monat($month),$year,date("y",$mikrotime)),
								$tpl);
		break;
	}
	return $out;
}
function day($data,$str='',$out='') {
	return tag($data,$str,$out);
}
function tag($data,$str='',$out='') {
	if (is_array($data)) {
		if (!empty($data['datetime']))	$wday = date("w",strtotime($data['datetime']));
		elseif (!empty($data['mktime']))$wday = today('wday');
		else 							$wday = date("w",$data['mktime']);
		if (!empty($data['add']))		$wday = $wday + $data['add'];
		if (!empty($data['skip']) && $wday == $datum['skip'])	$wday++;
	}
	elseif (empty($data))	$wday = today('wday');
	elseif ($data<=6)		$wday = $data;
	else 					$wday = date("w",$data);
	switch ($wday) {
		case 1:		$out = '%%MONTAG%%';	break;
		case 2:		$out = '%%DIENSTAG%%';	break;
		case 3:		$out = '%%MITTWOCH%%';	break;
		case 4:		$out = '%%DONNERSTAG%%';break;
		case 5:		$out = '%%FREITAG%%';	break;
		case 6:		$out = '%%SAMSTAG%%';	break;
		case 0:		$out = '%%SONNTAG%%';	break;
	}
	$out = gt($out);
	if (is_numeric($str)) 	$out = substr($out,0,$str);
	return $out;
}
function month($data) {
	return monat($data);
}
function monat($data) {
	if (is_array($data)) {
		if (!empty($data['days']))		$mon = date('n',mktime(0, 0, 0, date("m"),date("d")+$data['days'],date("Y")));
		elseif (empty($data['mktime']))	$mon = today('mon');
		else 							$mon = date("n",$data['mktime']);
		if (!empty($data['add']))		$mon = $mon + $data['add'];
		if (!empty($data['skip']) && $mon == $data['skip'])	$mon++;
	}
	elseif (empty($data))	$mon = today('mon');
	elseif ($data<=12)		$mon = $data;
	else 					$mon = date("n",$data);
	while ($mon>12) {$mon -= 12;}
	switch ($mon) {
		case 1:		$out = '%%JANUAR%%';	break;
		case 2:		$out = '%%FEBRUAR%%';	break;
		case 3:		$out = '%%MAERZ%%';		break;
		case 4:		$out = '%%APRIL%%';		break;
		case 5:		$out = '%%MAI%%';		break;
		case 6:		$out = '%%JUNI%%';		break;
		case 7:		$out = '%%JULI%%';		break;
		case 8:		$out = '%%AUGUST%%';	break;
		case 9:		$out = '%%SEPTEMBER%%';	break;
		case 10:	$out = '%%OKTOBER%%';	break;
		case 11:	$out = '%%NOVEMBER%%';	break;
		case 12:	$out = '%%DEZEMBER%%';	break;
	}
	return gt($out);
}
function get_week_of_month($date) {
 return date('W', $date) - date('W', strtotime(date("Y-m-01", $date))) + 1;
}
function year($data) {
	return date("Y");
}
function jahr($data) {
	if (is_array($data)) {
		if (empty($data['mktime']))	$y = today('year');
		else 						$y = date("Y",$data['mktime']);
		if (!empty($data['dshift']))$y = $y + $data['mshift'];
		if (!empty($data['skip']) && $y == $data['skip'])	$y++;
	}
	elseif (empty($data))	$y = today('y');
	else 					$y = date("Y",$data);
	return $y;
}
function today($data=array('split'=>'/')) {
	return offsetday($data);
}
function tomorrow($data=array('split'=>'/','offset'=>'+1')) {
	return offsetday($data);
}
function yesterday($data=array('split'=>'/','offset'=>'-1')) {
	return offsetday($data);
}
function offsetday($data=array('split'=>'/','offset'=>'','format'=>'dmY')) {
	if (empty($data['offset']))	$data['offset'] = 'today';
	else						$data['offset'] = $data['offset'].' day';
	return date($data['format'][0].$data['split'].$data['format'][1].$data['split'].$data['format'][2], strtotime($data['offset']));
}
function getDateFormat($short=false) {
	$date = new \DateTime();
	$date->setDate(1999, 11, 22);
	$datestring = strftime('%x', $date->getTimestamp());
	$in = array('1999','99','11','22');
	if (!$short)	$out = array('yyyy','yyyy','mm','dd');
	else			$out = array('yy','yy','mm','dd');
	return str_replace($in, $out, $datestring);
 #   return preg_replace($patterns, $replacements, $datestring);
}
function mydate($data, $format="de") {
	if(is_array($data)) {
		$date = $data['date'];
		if (!empty($data['format']))	$format = $data['format'];
	} else {
		$date = $data;
	}
	return format_date($date);
}
function validateDate($date, $format = 'Y-m-d') {
	$d = DateTime::createFromFormat($format, $date);
	// The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
	return $d && $d->format($format) === $date;
}
// The function finds the date of the given weekday on or preceding the given date
// The function returns the date (as array) for the nth weekday of a given month. Weekday is ISO, i.e. Monday = 1, Sunday = 7.
function nth_weekday( $the_month, $the_year, $iso_weekday, $n ) {
	$w_d = $iso_weekday - 1;
	// this works since day number 1 is a Tuesday. For traditional weekday counting (Sunday = 1) use:
	// $w_d = ( $iso_weekday + 5 ) % 7;
	// rename the argument in that case ;-)
	$d = cal_to_jd ( CAL_GREGORIAN, $the_month, 7, $the_year );
	$day = ( $d - $w_d ) % 7;
	$nth_day = $d - $day + ($n - 1) * 7;
	return cal_from_jd ( $nth_day, CAL_GREGORIAN );
}
function format_date($date, $format="de", $zero = '%%HEUTE%%') {
	global $sub_tpl;
	if (!empty($sub_tpl['heute']))												$zero = $sub_tpl['heute'];
	if (is_array($date))														extract($date);
	if (is_array($date) && !empty($date[0]))									$date = $date[0];
	if (!empty($date) && strpos($date,' ')===false && (strpos($date,'.')!==false || strpos($date,'-')!==false || strpos($date,'/')!==false)) {
		if (strpos($date,'.')!==false) $sep = '.';
		if (strpos($date,'-')!==false) $sep = '-';
		if (strpos($date,'/')!==false) $sep = '/';
		$d = explode($sep,$date);
		foreach ($d as $k => $x) {
			if (strlen($x)<2)	$d[$k] = str_pad($x, 2, "0", STR_PAD_LEFT);
			elseif ($x>31) {
				if ($x<(date("Y")-2000))$d[$k] = $x+2000;
				elseif ($x<100)			$d[$k] = $x+1900;
		}	}
		$date = implode($sep,$d);
	}
	switch($format) {
		case 'r': 			$format = "%a, %d %b %Y 01:00:00 %z";				break;
		case 'm.Y': 			$format = "%m.%Y";				break;
		case 'fr-dt':	case 'nl-dt':	case 'it-dt':	case 'es-dt':	case 'it-dt':	case 'tu-dt':	case 'ru-dt':
		case 'de-dt':			$format = "%d.%m.%Y %H:%M:%S";	break;
		case 'en-dt':			$format = "%d/%m/%Y %H:%M:%S";	break;
		case 'us-dt': 			$format = "%m/%d/%Y %H:%M:%S";	break;
		case 'fr':		case 'nl':		case 'it':		case 'es':		case 'it':		case 'tu':		case 'ru':
		case 'de': 				$format = "%d.%m.%Y";			break;
		case 'en': 				$format = "%d/%m/%Y";			break;
		case 'us': 				$format = "%m/%d/%Y";			break;
		case 'date': 			$format = "%d-%m-%Y";			break;
		case 'datetime':		$format = "%d-%m-%Y %H:%M:%S";	break;
		case 'mysql-date':		$format = "%Y-%m-%d";			break;
		case 'mysql-datetime':	$format = "%Y-%m-%d %H:%M:%S";	break;
		default: 				$format = str_replace('&','%',$format);	break;
	}
	/*if (strpos($date,'-')>0)	$out = $date;
	else*/if ($date != '0000-00-00' && $date != '0000-00-00 00:00:00')	$out =  strftime_81($format,strtotime($date));
	else						$out =  $zero;
	return $out;
}
#namespace PHP81_BC;
/**
 * Locale-formatted strftime using \IntlDateFormatter (PHP 8.1 compatible)
 * This provides a cross-platform alternative to strftime() for when it will be removed from PHP.
 * Note that output can be slightly different between libc sprintf and this function as it is using ICU.
 *
 * Usage:
 * use function \PHP81_BC\strftime;
 * echo strftime('%A %e %B %Y %X', new \DateTime('2021-09-28 00:00:00'), 'fr_FR');
 *
 * Original use:
 * \setlocale('fr_FR.UTF-8', LC_TIME);
 * echo \strftime('%A %e %B %Y %X', strtotime('2021-09-28 00:00:00'));
 *
 * @param  string $format Date format
 * @param  integer|string|DateTime $timestamp Timestamp
 * @return string
 * @author BohwaZ <https://bohwaz.net/>
 */
function strftime_81(string $format, $timestamp = null, ?string $locale = null): string
{
	if (null === $timestamp) {
		$timestamp = new \DateTime;
	}
	elseif (is_numeric($timestamp)) {
		$timestamp = date_create('@' . $timestamp);

		if ($timestamp) {
			$timestamp->setTimezone(new \DateTimezone(date_default_timezone_get()));
		}
	}
	elseif (is_string($timestamp)) {
		$timestamp = date_create($timestamp);
	}

	if (!($timestamp instanceof \DateTimeInterface)) {
		throw new \InvalidArgumentException('$timestamp argument is neither a valid UNIX timestamp, a valid date-time string or a DateTime object.');
	}

	$locale = substr((string) $locale, 0, 5);

	$intl_formats = [
		'%a' => 'EEE',	// An abbreviated textual representation of the day	Sun through Sat
		'%A' => 'EEEE',	// A full textual representation of the day	Sunday through Saturday
		'%b' => 'MMM',	// Abbreviated month name, based on the locale	Jan through Dec
		'%B' => 'MMMM',	// Full month name, based on the locale	January through December
		'%h' => 'MMM',	// Abbreviated month name, based on the locale (an alias of %b)	Jan through Dec
	];

	$intl_formatter = function (\DateTimeInterface $timestamp, string $format) use ($intl_formats, $locale) {
		$tz = $timestamp->getTimezone();
		$date_type = \IntlDateFormatter::FULL;
		$time_type = \IntlDateFormatter::FULL;
		$pattern = '';

		// %c = Preferred date and time stamp based on locale
		// Example: Tue Feb 5 00:45:10 2009 for February 5, 2009 at 12:45:10 AM
		if ($format == '%c') {
			$date_type = \IntlDateFormatter::LONG;
			$time_type = \IntlDateFormatter::SHORT;
		}
		// %x = Preferred date representation based on locale, without the time
		// Example: 02/05/09 for February 5, 2009
		elseif ($format == '%x') {
			$date_type = \IntlDateFormatter::SHORT;
			$time_type = \IntlDateFormatter::NONE;
		}
		// Localized time format
		elseif ($format == '%X') {
			$date_type = \IntlDateFormatter::NONE;
			$time_type = \IntlDateFormatter::MEDIUM;
		}
		else {
			$pattern = $intl_formats[$format];
		}

		return (new \IntlDateFormatter($locale, $date_type, $time_type, $tz, null, $pattern))->format($timestamp);
	};

	// Same order as https://www.php.net/manual/en/function.strftime.php
	$translation_table = [
		// Day
		'%a' => $intl_formatter,
		'%A' => $intl_formatter,
		'%d' => 'd',
		'%e' => function ($timestamp) {
			return sprintf('% 2u', $timestamp->format('j'));
		},
		'%j' => function ($timestamp) {
			// Day number in year, 001 to 366
			return sprintf('%03d', $timestamp->format('z')+1);
		},
		'%u' => 'N',
		'%w' => 'w',

		// Week
		'%U' => function ($timestamp) {
			// Number of weeks between date and first Sunday of year
			$day = new \DateTime(sprintf('%d-01 Sunday', $timestamp->format('Y')));
			return sprintf('%02u', 1 + ($timestamp->format('z') - $day->format('z')) / 7);
		},
		'%V' => 'W',
		'%W' => function ($timestamp) {
			// Number of weeks between date and first Monday of year
			$day = new \DateTime(sprintf('%d-01 Monday', $timestamp->format('Y')));
			return sprintf('%02u', 1 + ($timestamp->format('z') - $day->format('z')) / 7);
		},

		// Month
		'%b' => $intl_formatter,
		'%B' => $intl_formatter,
		'%h' => $intl_formatter,
		'%m' => 'm',

		// Year
		'%C' => function ($timestamp) {
			// Century (-1): 19 for 20th century
			return floor($timestamp->format('Y') / 100);
		},
		'%g' => function ($timestamp) {
			return substr($timestamp->format('o'), -2);
		},
		'%G' => 'o',
		'%y' => 'y',
		'%Y' => 'Y',

		// Time
		'%H' => 'H',
		'%k' => function ($timestamp) {
			return sprintf('% 2u', $timestamp->format('G'));
		},
		'%I' => 'h',
		'%l' => function ($timestamp) {
			return sprintf('% 2u', $timestamp->format('g'));
		},
		'%M' => 'i',
		'%p' => 'A', // AM PM (this is reversed on purpose!)
		'%P' => 'a', // am pm
		'%r' => 'h:i:s A', // %I:%M:%S %p
		'%R' => 'H:i', // %H:%M
		'%S' => 's',
		'%T' => 'H:i:s', // %H:%M:%S
		'%X' => $intl_formatter, // Preferred time representation based on locale, without the date

		// Timezone
		'%z' => 'O',
		'%Z' => 'T',

		// Time and Date Stamps
		'%c' => $intl_formatter,
		'%D' => 'm/d/Y',
		'%F' => 'Y-m-d',
		'%s' => 'U',
		'%x' => $intl_formatter,
	];

	$out = preg_replace_callback('/(?<!%)(%[a-zA-Z])/', function ($match) use ($translation_table, $timestamp) {
		if ($match[1] == '%n') {
			return "\n";
		}
		elseif ($match[1] == '%t') {
			return "\t";
		}

		if (!isset($translation_table[$match[1]])) {
			throw new \InvalidArgumentException(sprintf('Format "%s" is unknown in time format', $match[1]));
		}

		$replace = $translation_table[$match[1]];

		if (is_string($replace)) {
			return $timestamp->format($replace);
		}
		else {
			return $replace($timestamp, $match[1]);
		}
	}, $format);

	$out = str_replace('%%', '%', $out);
	return $out;
}
?>