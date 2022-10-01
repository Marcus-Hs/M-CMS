<?php
function showerror($errno) {
	global $error;
	$error['showerror'] = geterror($errno);
}
function geterror($errno,$page_id=false) {
	global $tplobj,$lang,$vorgaben;
	if (!$page_id)	$out = get_vorlage(array('PAGE_ID'=>$vorgaben['meldungen_seite'],'pos'=>$errno,'status'=>'any','anz'=>-1));
	else			$out = get_vorlage(array('PAGE_ID'=>$page_id,'pos'=>$errno,'status'=>'any','anz'=>-1));
	if (empty($out)) {
		switch($errno) {
			case 301:
			case 302:
			case 303:
			case 304: $out = $errno." Moved Permanently";					break;
			case 404: $out = "404 Not Found";							break;
			default:  $out = '%%UNIDENTIFIZIERTER_FEHLER%%: '.$errno;
					  trigger_error($out,E_USER_NOTICE);				break;
	}	}
	if (empty($_SESSION['name']))	$_SESSION['name'] = '';
	$out = preg_replace("/\%[A-Z_0-9]+\%/Us",'',$out);
	return $tplobj->array2tpl($out,$_SESSION,'#,$','');
}
function daten_error($feld='person',$data='',$input='') {
	global $error,$dbobj,$tplobj,$unterseite,$sub_tpl,$vorgaben,$active,$lang_id/*,$add_pflicht*/;
	if (empty($input) && !empty($_REQUEST[$feld])) 		$input = $_REQUEST[$feld];
	if (!empty($data) && !empty($sub_tpl[$data]))		$data = $sub_tpl[$data];
	elseif (!empty($data) && !empty($vorgaben[$data]))	$data = $vorgaben[$data];
	elseif (!empty($data) && !is_numeric($data)) {
		$fields = explode(',',$data);
		foreach ($fields as $f) {
			if (empty($input[strtolower($f)]) && empty($_REQUEST[strtolower($f)])) $e[strtolower($f)] = $f;
		}
		unset($data,$e);
	}
	if (empty($data) && !empty($active))	$data = end($active);
	if (!empty($data) && is_numeric($data)) {
		$sql = "SELECT pflicht,Content FROM #PREFIX#abschnitte WHERE PAGE_ID IN (".$data.") AND LANG_ID = ".$lang_id.";";
		if ($exists = $dbobj->exists(__file__,__line__,$sql)) {
			$arr_pflicht = array_change_key_case(unseri_unurl($exists[0]['Content']), CASE_LOWER);
			if (empty($sub_tpl['required_field'])) $sub_tpl['required_field'] = explode(',',strtolower($exists[0]['pflicht']));
	}	}
	if (is_array($input) && !empty($sub_tpl['required_field'])) {
		if (!empty($sub_tpl['required_extra']))	$sub_tpl['required_field'] = array_merge($sub_tpl['required_field'],explode(',',$sub_tpl['required_extra']));
		if (!empty($sub_tpl['error_'.$feld]) && !cleanArray($input[$feld])) {
			$e[] = $feld;
		}
		$input = array_change_key_case($input,CASE_LOWER);
		$sub_tpl['required_field'] = array_unique($sub_tpl['required_field']);
		foreach ($sub_tpl['required_field'] as $pflichtfeld) {
		#	if (strpos('|',$pflichtfeld)) {}
			if (!isset($input[$pflichtfeld]) || $input[$pflichtfeld]=='')	$input[$pflichtfeld] = false;
			if ((!empty($arr_pflicht[$pflichtfeld]) || isset($input[$pflichtfeld])) && (isset($input[$pflichtfeld]) && !cleanArray($input[$pflichtfeld])) || !$input[$pflichtfeld]) {
				if (!empty($arr_pflicht[$pflichtfeld]))	$e[$pflichtfeld] = $arr_pflicht[$pflichtfeld];
			#	$sub_tpl['style'][] = '#'.$feld.'_'.$pflichtfeld.',#'.$pflichtfeld.' {color:red;}';
				$sub_tpl['in_replace'][] = 'for="'.$pflichtfeld.'"';
				$sub_tpl['out_replace'][]= 'for="'.$pflichtfeld.'" class="errorcolor"';
				$sub_tpl['in_replace'][] = 'id="'.$pflichtfeld.'"';
				$sub_tpl['out_replace'][]= 'id="'.$pflichtfeld.'" class="errorcolor"';
				$sub_tpl['in_replace'][] = 'id="'.$feld.'_'.$pflichtfeld.'"';
				$sub_tpl['out_replace'][]= 'id="'.$feld.'_'.$pflichtfeld.'" class="errorcolor"';
	}	}	}
	if (!empty($e)) {
		$e_key = array_keys($e);
		if (!empty($sub_tpl['error_'.$feld]))	$error[$feld][] = str_replace($sub_tpl['pflichtfeld'],'',$sub_tpl['error_'.$feld]);
		else									$error[$feld][] = geterror(20)."<br />".' "'.implode_ws($e,'" <br />§UND§ <br />"','", <br />"').'".';
		if (empty($sub_tpl['colorerror']))		$sub_tpl['colorerror'] = '#fee';
		$sub_tpl['style'][] = 'label input[for='.implode('], label input[for=',$e_key).'] {background-color:'.$sub_tpl['colorerror'].';}';
	}
	if (empty($error[$feld])) {
		if (!empty($input['name'])		&& !syntax::name($input['name']))			$error[$feld][] = geterror(2);
		if (!empty($input['ort'])		&& !syntax::name($input['ort']))			$error[$feld][] = geterror(3);
		if (!empty($input['email'])		&& !syntax::email($input['email']))			$error[$feld][] = geterror(4);
		if (!empty($input['telefon'])	&& !syntax::number($input['telefon']))		$error[$feld][] = geterror(5);
		if (!empty($input['strasse'])	&& !syntax::name($input['strasse']))		$error[$feld][] = geterror(7);
		if (!empty($input['mobil'])		&& !syntax::number($input['mobil']))		$error[$feld][] = geterror(6);
		if (!empty($input['mitteilung'])&& !syntax::msg($input['mitteilung']))		$error[$feld][] = geterror(9);
	#	if (!empty($input['region']) 	&& !is_numeric($input['region']))			$error[$feld][] = geterror(9);
	}
	if (empty($error[$feld]))	return false;
	else						return true;
}
?>