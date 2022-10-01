<?php
function get_city_name($uid=0)		{return get_citydata_by_userID($uid,'Ort');}
function get_city_zip($uid=0)		{return get_citydata_by_userID($uid,'PLZ');}
function get_city_country($uid=0)	{return get_citydata_by_userID($uid,'Country');}
function get_city_lat($uid=0)		{return get_citydata_by_userID($uid,'lat');}
function get_city_lng($uid=0)		{return get_citydata_by_userID($uid,'lng');}
function get_citydata_by_userID($uid=0,$field=false) {
	global $dbobj, $citydata, $sub_tpl, $page_id;
	if (is_numeric($uid) && empty($sub_tpl['lat_lng']) && empty($citydata[$uid]))	{
		$sql ='SELECT	ID,PLZ,Ort,Land,Country,lat,lng
				FROM	#PREFIX#person
					LEFT JOIN (#PREFIX#plugins__city) ON (Ort = City)
				WHERE 	ID IN ('.r_implode($uid).');';
		$citydata = $dbobj->withkey(__file__,__line__,$sql,'ID',true);
	}
	if (!empty($sub_tpl['lat_lng'])) {
		list($citydata[$uid]['lat'],$citydata[$uid]['lng']) = explode(',',str_replace(', ',',',$sub_tpl['lat_lng'])) ;
		if (!empty($sub_tpl['cityzip'])) $citydata[$uid]['PLZ'] = $sub_tpl['cityzip'];
		$citydata[$uid]['Ort'] =getmenu($page_id);
		$citydata[$uid]['Country'] = 'Germany';
	}
	if ($field) {
		if (!empty($citydata[$uid][$field])) 	return $citydata[$uid][$field];
		else									return false;
	}
	else return $citydata;
}
class location {
	public function cities_in_range($location,$lat,$lng,$distance=50) {
		global $dbobj,$coords,$city_table_exists;	
		// Calculate distance and filter records by radius 
		$sql_distance = $having = ''; 
		if (!empty($distance) && !empty($lat) && !empty($lng)) { 
			$sql_distance = " ,(((acos(sin((".$lat."*pi()/180)) * sin((`lat`*pi()/180))+cos((".$lat."*pi()/180)) * cos((`lat`*pi()/180)) * cos(((".$lng."-`lng`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance "; 
			$having = " HAVING (distance <= $distance) "; 
			$order_by = ' distance ASC '; 
		} else { 
			$order_by = ' City DESC '; 
		} 
		$sql = "SELECT *".$sql_distance." FROM #PREFIX#plugins__city $having ORDER BY $order_by"; 
		if ($city_data = $dbobj->singlequery(__file__,__line__,$sql)) {
			$coords[$city] = current($city_data);
		}
	}
	public function city_distances($city1,$countryCode1='DE',$zip1=false,$cities=false) {
/*		if (!empty($sub_tpl['ids_bykn'][make_kn($city1)]))	{
			$latlng = get_first_bykn($sub_tpl['ids_bykn'][make_kn($city1)]);
		}
		if (!$latlng) {
			$latlng = lat_long_city($city,'DE');
		}
*/		foreach($cities as $countryCode2 => $city2) {
			$dist[$city1][$city2] = city_distance($city1,$countryCode1,$zip1,$city2,$countryCode2);
#			if (count($dist[$city1])>=10) break;
		}
		return $dist[$city1];
	}
	public function city_distance($city1,$countryCode1,$zip1,$city2,$countryCode2,$zip2=false) {
		 $coords1 = $this->lat_long_city($city1,$countryCode1,$zip1);
		 $coords2 = $this->lat_long_city($city2,$countryCode2,$zip2);
		 if ($coords1 && $coords2)	return ceil($this->get_distance($coords1,$coords2));
		 else return false;
	}
	public function get_distance($coords1,$coords2,$r=6378.137) { 
		// Kreiszahl Pi  
		$pi = pi();
		// Umrechnung der Gradzahl in RAD: 
		$breite1 = $coords1['lat']/180*$pi; 
		$länge1  = $coords1['lng']/180*$pi; 
		$breite2 = $coords2['lat']/180*$pi;
		$länge2  = $coords2['lng']/180*$pi;
		// Die Formel zur Entfernungsberechnung bedient sich einer Einheitskugel: 
		// e = ARCCOS[ SIN(Breite1)*SIN(Breite2) + COS(Breite1)*COS(Breite2)*COS(Länge2-Länge1) ] 
		$e = acos(sin($breite1)*sin($breite2) + cos($breite1)*cos($breite2)*cos($länge2 - $länge1)); 
		return  $e*$r;
	}
	/*
	 * Get cities based on city name and radius in KM
	 */
	public function nearest_cities($city,$countryCode,$radius = 30,$maxRows = 30,$username = '{YOUR USERNAME}') {
		$coords = $this->lat_long_city($city,$countryCode);
		// set request options
		$responseStyle = 'short'; // the length of the response
		$citySize = 'cities15000'; // the minimal number of citizens a city must have
#		$radius = 30; // the radius in KM
#		$maxRows = 30; // the maximum number of rows to retrieve
#		$username = '{YOUR USERNAME}'; // the username of your GeoNames account

		// get nearby cities based on range as array from The GeoNames API
		$nearbyCities = json_decode(file_get_contents('http://api.geonames.org/findNearbyPlaceNameJSON?lat='.$coords['lat'].'&lng='.$coords['lng'].'&style='.$responseStyle.'&cities='.$citySize.'&radius='.$radius.'&maxRows='.$maxRows.'&username='.$username, true));
		
		// return city details
		return $nearbyCities->geonames;
	}
	public static function suggest_cities($city) {
		global $dbobj,$coords,$city_table_exists;
		return self::lat_long_city($city,'DE',false,true);
	}
	public static function lat_long_city($city,$countryCode='DE',$zip=false,$all=false) {
		global $dbobj,$coords,$city_table_exists,$sub_tpl;
		if (empty($coords)) $coords = array();
		$city = trim($city);
		if (hasNumber($city) && strpos(' ',$city)>0)	{
			list($zip,$city) = explode(' ',$city);
		} elseif (is_numeric($city)) {
			$zip = $city;
			unset($city);
		}
		if ($dbobj->table_exists(__file__,__line__,'#PREFIX#plugins__city')) {
			$city_table_exists = true;
			if (!empty($city))			$where[] = 'City LIKE "%'.$dbobj->escape($city).'%"';
			if (!empty($zip))			$where[] = "zip = ".substr($zip,0,2);
			if (!empty($countryCode))	$where[] = "countryCode = '".$countryCode."'";
			$sql = 'SELECT City,lat,lng FROM #PREFIX#plugins__city WHERE '.r_implode($where,' AND ').';';
			$coords = $dbobj->withkey(__file__,__line__,$sql,'City',true);
		} else {
			$city_table_exists = false;
		}
		if (empty($coords)) {
			$here_api = 'Ty-VNqsJb5faZqyyxJuadSt5NKDuwDY7bqR4z9xtSQY';
			$here_url = 'https://geocoder.ls.hereapi.com/6.2/geocode.json?apiKey='.$here_api.'&city='.str_replace('_','%20',make_kn($city)).'&postalcode='.trim($zip).'&country='.$countryCode.'';
#			die($here_url);
			$geocodeObject = json_decode(file_get_contents($here_url), true);
#			$positiostack_api = 'd1d264f7eabca2e9f4c6976c70ee55c1';
#			$positiostack_url = 'http://api.positionstack.com/v1/forward?access_key='.$positiostack_api.'&query='.str_replace('_','%20',make_kn($city)).'&country='.$countryCode.'&limit=2';
			if (!empty($geocodeObject['Response']['View'][0]['Result'][0])) {
				foreach ($geocodeObject['Response']['View'][0]['Result'] as $obj) {
					if (empty($coords[$city])) {
						$obj 	= $obj['Location'];
						$city 	= iconv("UTF-8", $sub_tpl['codepage'], $obj['Address']['City']); #mb_convert_encoding($obj['Address']['City'], "WINDOWS-1255", "UTF-8");
						$zip 	= $obj['Address']['PostalCode'];
						$countryCode = substr($obj['Address']['Country'],0,2);
						$coords[$city]['lat'] = $obj['DisplayPosition']['Latitude'];
						$coords[$city]['lng'] = $obj['DisplayPosition']['Longitude'];
		#				$coords[$city]['lat'] = $geocodeObject['data'][0]['latitude'];
		#				$coords[$city]['lng'] = $geocodeObject['data'][0]['longitude'];
						if ($city_table_exists) {
							$insert = $coords[$city];
							$insert['kn'] = make_kn($city);
							$insert['City'] = trim($city);
							$insert['countrycode'] = $countryCode;
							$insert['zip'] = substr($zip,0,2);
							$dbobj->array2db(__file__,__line__,$insert,'#PREFIX#plugins__city');
				}	}	}
			} else {
				return false;
			}
		}
		if ($all)					return $coords;
		elseif (count($coords)==1)	return current($coords);
		else 						return false;
	}
	public function tld_by_ip() {
		$tld = false;
		$host = gethostbyaddr($_SERVER['REMOTE_ADRESS']);
		$hostTrans = array(
		  '.arcor-ip.net'=>'.de',  '.t-dialin.net'=>'.de',
		  '.sui-inter.net'=>'.ch', '.drei.com'=>'.at',
		  '.proxad.net'=>'.fr',	'.gaoland.net'=>'.fr',
		  '.mchsi.com'=>'.us',	 '.comcast.net'=>'.us',
		  );
		$host = strtr($host, $hostTrans);
		// Herkunftsland (TLD) ausschneiden
		$tld = (strpos($host, '.')===false) ? $host : substr(strrchr($host, '.'), 1);
		// Fehler bei gethostbyaddr()
		if($ip === $host) {$tld = false;}
		return $tld;
	}
}
/*
// Geodaten Hannover / 30669  
$B1	  =  9.71667 ; 
$L1	  =  52.3667 ; 
// Geodaten Hamburg	/ 20095 
$B2	 =  10 ; 
$L2	  =  53.55 ;
location::get_distance($B1,$L1,$B2,$L2)
*/
?>