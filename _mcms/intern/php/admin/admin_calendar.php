<?php
function prepare_admin_calendar() {
	global $dbobj,$add,$add_admin,$vorgaben,$plugin_functions;
	if ($dbobj->table_exists(__file__,__line__,'#PREFIX#plugins__calendar')) {
		$add_admin['plugins']['calendar'] = array('function' => 'calendar','titel' => '%%TERMINE%%','style'=>'style="background-image:url(/admin/icons/calendar-32.png)"');
		$add['Kalender'] = array('kalenderseiten_multi_tpl'=>'%%KALENDERSEITEN%%','kalender_tpl'=>'%%KALENDERVORLAGE%%');
		if (!empty($vorgaben['kalenderseiten_multi_tpl'])) {
			$ks = explode(',',$vorgaben['kalenderseiten_multi_tpl']);
			foreach ($ks as $k)		$plugin_functions[$k][] = 'calendar_plugin';	// Diese Funktion wird in der Seitenverwaltung eingebunden.
}	}	}
function calendar_plugin($elements) {
	global $tplobj,$dbobj,$sub_tpl,$vorgaben,$lang_id;
	my_include('intern/php/user/','user_calendar.php');
	$sub_tpl['JS']['qc'] = 'qc.js';
	$sub_tpl['CSS']['qc']= 'qc.css';
	if (!empty($_FILES['icalfile'])) {
		if ($_FILES['icalfile']['error'] == UPLOAD_ERR_OK  && is_uploaded_file($_FILES['icalfile']['tmp_name'])) { //checks that file is uploaded
			$file = file_get_contents($_FILES['icalfile']['tmp_name']);
			$iCal = new iCal($file);
			$icalevents = $iCal->eventsByDateBetween('today', '+90 days');
			$array_events = json_decode(json_encode($icalevents), true);
			foreach ($array_events as $day => $data) {
				$d = current($data);
				list($e['anfang'],$e['anfangszeit']) = explode(' ',$d['dateStart']);
				list($e['ende'],$e['endzeit']) = explode(' ',$d['dateEnd']);
				$e['Summary'] = $d['summary'];
				$events[$day] = $e;
				$e['status'] = 1;
				$e['PAGE_ID'] = $_REQUEST['pages']['PAGE_ID'];
				$e['person_ID'] = uid();
				$dbobj->array2db(__file__,__line__,$e,'#PREFIX#plugins__calendar');
			}
		#	info($events );
			if ($_FILES['icalfile']['error']) info($_FILES['icalfile']['error']);
		}
	}
	return kalender(array('multiple'=>1,'page_id'=>$elements['PAGE_ID'],'tpl'=>'end'));
	
	
#	return admin_calendar($elements['PAGE_ID']);
}
function calsynclink($page_id) {
	global $dbobj;
	$hash = read_hash('calendar_hash',$page_id);
	if (!$hash && $page_id) {
		#generate_hash('calendar_hash',$uid);
		$hash = md5(uniqid().'_calendar_hash_'.$page_id);
		$insert = array('page_ID'=>$page_id,'client_ID'=>0,'hash_name'=>'calendar_hash','hash_value'=>$hash);
		$dbobj->array2db(__file__,__line__,$insert,'#PREFIX#person__hashes');
		
	}
	$filename = "event_calendar.ics?hash=".$hash;
	return abslinktonosid($filename);
}
function admin_calendar($page_id='',$tpl='admin_tpl') {
	global $tplobj,$dbobj,$sub_tpl,$vorgaben,$lang_id;
	my_include('intern/php/user/','user_calendar.php');
	save('reservierungen');
	$sub_tpl['JS']['qc'] = 'qc.js';
	$sub_tpl['CSS']['qc']= 'qc.css';
	kalender_tpl($lang_id);
	$out = '';
	$tpl =  $tplobj->read_tpls($sub_tpl[$tpl]);
	$sql = "SELECT   #PREFIX#seiten.PAGE_ID,#PREFIX#seiten.Titel,Kurzname,position
			FROM 	 #PREFIX#seiten,#PREFIX#seiten_attr
			WHERE	 TPL_ID IN (".$vorgaben['kalenderseiten_multi_tpl'].")";
	$sql .= pages_sql();
	if (!empty($page_id))$sql .= "\n	AND 	 #PREFIX#seiten_attr.PAGE_ID = ".$page_id;
	$sql .= "\n	AND 	 #PREFIX#seiten_attr.PAGE_ID = #PREFIX#seiten.PAGE_ID
			GROUP BY #PREFIX#seiten.PAGE_ID
			ORDER BY #PREFIX#seiten_attr.position";
	if ($kats = $dbobj->withkey(__file__,__line__,$sql,'PAGE_ID')) {
		foreach ($kats as $PAGE_ID => $kategorie) {
			$out .= calendar_entries($PAGE_ID,$kategorie);
	}	}
	make_replacements($out);
	return str_replace('#EINTRAEGE#',$out,$tpl);
}
function calendar_entries($PAGE_ID,$kategorie) {
	global $tplobj,$dbobj,$sub_tpl;
	$sql = "SELECT #PREFIX#plugins__calendar.*,#PREFIX#person.name FROM #PREFIX#plugins__calendar,#PREFIX#person WHERE PAGE_ID IN (".$PAGE_ID.") AND #PREFIX#person.ID = #PREFIX#plugins__calendar.person_ID ORDER BY anfang;";
	$eintraege = $dbobj->singlequery(__file__,__line__,$sql);
	if (!empty($eintraege[0]['anfang'])) {
		$kategorie['kalender'] = kalender(array('page_id'=>$PAGE_ID),'</div>');
		$kategorie['rows'] = count($eintraege)+1;
		$out = $tplobj->array2tpl($sub_tpl['header_tpl'],$kategorie,'#');
		foreach ($eintraege as &$eintrag) {
			list($y,$m,$d) = explode('-',str_replace('.','-',startstr($eintrag['anfang'],' ')));
			$anfang = "$d.$m.$y";
			if (!empty($eintrag['ende'])) {
				list($y,$m,$d) = explode('-',str_replace('.','-',startstr($eintrag['ende'],' ')));
				$ende = "$d.$m.$y";
			} else {
				$ende = $anfang;
			}
			if ($anfang == $ende)	$eintrag['daten'] = $anfang;
			else					$eintrag['daten'] = $anfang." - ".$ende;
			$eintrag['mitteilung'] = nl2br($eintrag['mitteilung']);
			$eintrag['month'] = $m;
			$eintrag['year'] = $y;
			if (empty($eintrag['status']))											$eintrag['color'] = ' style="border:2px solid red"';
	#		elseif (!empty($eintrag['anfangszeit']) && !empty($eintrag['endzeit']))	$eintrag['color'] = ' style="border:2px solid orange"';
			else																	$eintrag['color'] = ' style="border:2px solid green"';
			if ($anfang == $ende && !empty($eintrag['anfangszeit']) && !empty($eintrag['endzeit']))	$eintrag['status'] = 2;
			if (empty($eintrag['status']))															$eintrag['status'] = 1;
			$out .= $tplobj->array2tpl($sub_tpl['zeile_tpl'],$eintrag,'#');
		}
		$out = str_replace('*PAGE_ID*',$PAGE_ID,$out);
		return $out;
}	}
function save_reservierungen($data=false) {
	global $error,$userid,$dbobj;
	if (!empty($_REQUEST['reservierungen'])) {
		$resv = &$_REQUEST['reservierungen'];
		if (!empty($resv['save']) && is_array($resv['save'])) {
			foreach ($resv['save'] as $id => $v)
				$sql_del[] = "UPDATE #PREFIX#plugins__calendar SET status = 1 WHERE ID = ".$id." ;";
			$dbobj->multiquery(__file__,__line__,$sql_del);
			$error['info'] = '%%TERMINE_GESPEICHERT%%';
		}
		if (!empty($resv['remove']) && is_array($resv['remove'])) {
			foreach ($resv['remove'] as $id)
				$sql_del[] = "DELETE FROM #PREFIX#plugins__calendar WHERE ID = ".$id." ;";
			$dbobj->multiquery(__file__,__line__,$sql_del);
			$error['info'] = '%%TERMINE_GELOESCHT%%';
}	}	}
?>