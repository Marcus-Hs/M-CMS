<?php
function prepare_edit_languages() {
	global $add_admin,$error;
	$add_admin['admin']['3_languages'] = array('function' => 'admin_languages','titel' => '%%SPRACHEN%%','style'=>'style="background-image:url(/admin/icons/language.png)"');
	$add_admin['admin']['3_translate'] = array('function' => 'translate','titel' => '%%UEBERSETZEN%%','nomenu'=>'true');
}
function startup_admin_languages($tpl) {
	if (!empty($_REQUEST['languages']['position']))	save('languages');
	return '<ul>'.langs('',	 false,'',false,$tpl['sprachen']).'</ul>';
}
function admin_languages() {
	global $tplobj,$dbobj,$vorgaben,$vorgaben,$add_functions;
	$tpls  = $tplobj->read_tpls('admin/sprache.inc.html');
	if (!empty($_REQUEST['trans']['LANG_ID'])) {
		return translate();
	} elseif (!empty($_REQUEST['languages']['LANG_ID']) && !isset($_REQUEST['languages']['remove'])) {
		if (is_numeric($_REQUEST['languages']['LANG_ID'])) {
			$sprache = $dbobj->singlequery(__file__,__line__,"SELECT * FROM #PREFIX#_languages WHERE LANG_ID = ".$_REQUEST['languages']['LANG_ID'].";");
			$add_functions['3_languages']['title'] .= ': \''.$sprache[0]['lang_intl'].'\'';
			if (!empty($sprache[0]['visibility']) && $sprache[0]['visibility'] == 1)	$sprache[0]['visible']	= 'checked="checked"';
			if (!empty($sprache[0]['direction'])  && $sprache[0]['direction'] == 'rtl')	$sprache[0]['rtl']		= 'checked="checked"';
			else																		$sprache[0]['ltr']		= 'checked="checked"';
			if (!empty($sprache[0]['domain']))											$sprache[0]['domain']	= url_protocol($sprache[0]['domain'],false);
			if ($bilder = get_images(array('LANG_ID'=>$sprache[0]['LANG_ID'],'PART_ID'=>'flag,flag_a,flag_h','size'=>'thumbs','visibility'=>'1,0','fix_lang'=>true,'tpl'=>'admin/bilder.inc.html'))) {
				foreach ($bilder as $bild_id => $bild)									$sprache[0]['bild_'.$bild_id] = $bild;
		}	} else																		$sprache[0]['LANG_ID']	= 'neu';
		if ($arr_contacts = $dbobj->withkey(__file__,__line__,"SELECT ID,Login,Name FROM #PREFIX#person WHERE Status IN (88,99) ORDER BY ID,Name",'ID')) {
			$sel_daten = '';
			$default_contact = current($arr_contacts);
			foreach ($arr_contacts as $id => $data)								$sel_daten .= "\n".'<option value="'.$id.'" #SEL_'.$id.'#>'.$data['Name'].'</option>';
			if (isset($sprache[0]['UID']) && is_numeric($sprache[0]['UID']))	$selected   = $sprache[0]['UID'];
			else																$selected   = $default_contact['ID'];
			if (isset($selected) && is_numeric($selected))						$sel_daten  = str_replace('#SEL_'.$selected.'#','selected="selected"',$sel_daten);
			$tpls['sprache'] = str_replace('$ANSPRECHPARTNER$',$sel_daten,$tpls['sprache']);
		}
		return "\n".$tplobj->array2tpl($tpls['sprache'],$sprache[0]);
	} else {
		$languages = $dbobj->singlequery(__file__,__line__,'SELECT LANG_ID,lang_intl,lang_local,visibility,position FROM #PREFIX#_languages ORDER BY position,short');
		$zeile_out = '';
		if (!empty($languages[0])) {
			foreach ($languages as &$language) {
				if ($language['visibility'] == 1)	$language['visible'] = 'checked="checked"';
				$edit_out[$language['LANG_ID']] = '';
				$zeile_out .= "\n".$tplobj->array2tpl($tpls['zeilen'],$language);
				$zeile_out = str_replace('|EDIT_'.$language['LANG_ID'].'|',$edit_out[$language['LANG_ID']],$zeile_out);
				$zeile_out = str_replace('|LANG_ID|',$language['LANG_ID'],$zeile_out);
		}	}
		$tpls['sprachen'] = str_replace('|LANGUAGES|',$zeile_out,$tpls['sprachen']);
		return $tplobj->array2tpl($tpls['sprachen'],$vorgaben);
}	}
function translate() {
	global $tplobj,$dbobj,$error,$first_lang_id,$vorgaben,$sub_tpl;
	$sub_tpl['JS'][] = 'jquery/translate.js';
	$tpls = $tplobj->read_tpls('admin/translate.form.html');
	if (!empty($_REQUEST['transl'])) save('translate');
	if (!empty($_REQUEST['trans']['LANG_ID']) && is_numeric($_REQUEST['trans']['LANG_ID']))	$where = "WHERE LANG_ID = ".$_REQUEST['trans']['LANG_ID'];
	elseif (!empty($vorgaben['verwaltung_sprache']))										$where = "WHERE LANG_ID = ".$vorgaben['verwaltung_sprache'];
	else																					$where = "WHERE LANG_ID = ".$first_lang_id;
	$sprache = $dbobj->singlequery(__file__,__line__,"SELECT DISTINCT * FROM #PREFIX#_languages ".$where.";");
	$files = process_dir($vorgaben['base_dir'].'intern',true,array('php','html'));																					# recursiv durch alle Verzeichnisse.
	if (!empty($vorgaben['grp__cms'])) {
		$files = array_merge($files,process_dir($vorgaben['grp__cms'].'/',true));
		if (is_dir($vorgaben['grp__cms'].'admin'))				$files = array_merge($files,process_dir($vorgaben['grp__cms'].'admin'));					# und dieses Verzeichnis.
		if (is_dir($vorgaben['grp__cms'].'admin/file_manager'))	$files = array_merge($files,process_dir($vorgaben['grp__cms'].'admin/file_manager'));		# und dieses Verzeichnis.
	}
	if (!empty($vorgaben['base_cms'])) {
		$files = array_merge($files,process_dir($vorgaben['base_cms'].'/',true));
		if (is_dir($vorgaben['base_cms'].'admin'))				$files = array_merge($files,process_dir($vorgaben['base_cms'].'admin'));					# und dieses Verzeichnis.
		if (is_dir($vorgaben['base_cms'].'admin/file_manager'))	$files = array_merge($files,process_dir($vorgaben['base_cms'].'admin/file_manager'));		# und dieses Verzeichnis.
	}
	if (!empty($vorgaben['base_dir'])) {
		$files = array_merge($files,process_dir($vorgaben['base_cms'].'/',true));
		if (is_dir($vorgaben['base_dir'].'admin'))				$files = array_merge($files,process_dir($vorgaben['base_dir'].'admin'));					# und dieses Verzeichnis.
		if (is_dir($vorgaben['base_dir'].'admin/file_manager'))	$files = array_merge($files,process_dir($vorgaben['base_dir'].'admin/file_manager'));		# und dieses Verzeichnis.
	}
	sort($files);
	foreach ($files as $file) {																		# Durch das Ergebnis-Array gehen
		$handle = @fopen($file['path'], "r");
		if ($handle) {
			while (($line = fgets($handle)) !== false) {
				if (preg_match_all("/%%([0-9a-z_]+)%%/Ui",$line,$matches)) {						# Übersetzungsfelder raussuchen
					foreach ($matches[0] as $k => $v) {
						$match = str_replace('%%','%',$v);
						$trans[$file['filename']][$match] = str_replace('_',' ',ucfirst(strtolower($matches[1][$k])));
					}
					unset($matches,$match);
				}
				unset($line);
			}
			fclose($handle);
	}	}
	if (!$elements = $dbobj->withkey(__file__,__line__,"SELECT name,value FROM #PREFIX#_translate ".$where.";",'name',true)) {
		$elements = $dbobj->withkey(__file__,__line__,"SELECT name,value FROM #PREFIX#_translate WHERE LANG_ID = ".$first_lang_id.";",'name',true);
	}
	$i=0;
	$out = array();
	foreach ($trans as $fn => $tr_data) {
		foreach ($tr_data as $key => $value) {
			$i++;
			$style= '';
			if (!empty($elements[$key]) /*&& $elements[$key]['value'] != str_replace('_',' ',ucfirst(strtolower(str_replace('%','',$key))))*/)	$tr_data[$key] = $elements[$key]['value'];
			else 							$style= 'style="background-color:#fcc"';
			if (empty($tmp[$key]))	{
				$tmp[$key] = $tplobj->array2tpl($tpls['tl_row'],array('i'=>$i,'value'=>$value,'style'=>$style,'key'=>$key,'rowdata'=>$tr_data[$key]));
				$out[$fn][$key] = $tmp[$key];
		}	}
		if (!empty($out[$fn]))	{
			$data = array('outrows'=>implode("<br class='cb' />\n",$out[$fn]),'fn'=>$fn,'i'=>$i);
			$out[$fn] = $tplobj->array2tpl($tpls['tl_file'],$data);
		}
		unset($data);
	}
	$tpl = str_replace('|TLDATA|',implode("<br />\n",$out),$tpls['translate']);
	$tplobj->array2tpl2($tpl,$sprache[0]);
	return $tpl;
}
function save_languages($data=false) {
	global $error,$userid,$dbobj;
	foreach ($_REQUEST['languages']['all_langs'] as $LANG_ID) {
		if (is_numeric($LANG_ID) && !empty($_REQUEST['languages']['remove'][$LANG_ID])) {
			$remove = $dbobj->toarray(__file__,__line__,"SELECT PAGE_ID FROM #PREFIX#seiten WHERE LANG_ID = ".$LANG_ID.";");
			save_page::remove_page($remove,$LANG_ID);
			$sql_a['languages_'.$LANG_ID]	= "DELETE FROM #PREFIX#_languages WHERE LANG_ID = ".$LANG_ID.";";
			$sql_a['seiten_attr_'.$LANG_ID]	= "DELETE #PREFIX#seiten_attr FROM #PREFIX#seiten_attr,#PREFIX#seiten WHERE #PREFIX#seiten.LANG_ID = ".$LANG_ID." AND #PREFIX#seiten_attr.PAGE_ID =#PREFIX#seiten.PAGE_ID;";
			$sql_a['seiten_'.$LANG_ID]		= "DELETE FROM #PREFIX#seiten WHERE LANG_ID = ".$LANG_ID.";";
			$sql_a['abschnitte_'.$LANG_ID] 	= "DELETE FROM #PREFIX#abschnitte WHERE LANG_ID = ".$LANG_ID.";";
			$error['info'] = '%%SPRACHE_GELOESCHT%%'; # Die Sprache ist gelöscht worden.'
		} else {
			if (!empty($_REQUEST['languages']['position'][$LANG_ID]))	$language['position'] = $_REQUEST['languages']['position'][$LANG_ID];
			if (!empty($_REQUEST['languages']['visibility'][$LANG_ID]))	$language['visibility'] = 1;
			else														$language['visibility'] = 0;
			if (!empty($_REQUEST['languages']['short'])) {
				if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#_languages','UID') && !empty($_REQUEST['languages']['UID'][$LANG_ID]))
					$language['UID'] = $_REQUEST['languages']['UID'][$LANG_ID];
				if (!empty($_REQUEST['languages']['direction'][$LANG_ID]))	$language['direction'] = $_REQUEST['languages']['direction'][$LANG_ID];
				else														$language['direction'] = 'ltr';
				if (!empty($_REQUEST['languages']['short']) && !empty($_REQUEST['languages']['lang_intl'])
					&& !empty($_REQUEST['languages']['lang_local']) && !empty($_REQUEST['languages']['codepage'])) {
					$language['short']		= $_REQUEST['languages']['short'];
					$language['lang_intl']	= $_REQUEST['languages']['lang_intl'];
					$language['lang_local'] = $_REQUEST['languages']['lang_local'];
					if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#_languages','lang_de'))
						$language['lang_de']= $_REQUEST['languages']['lang_de'];
					$language['codepage']	= $_REQUEST['languages']['codepage'];
					$language['domain']		= url_protocol(trim($_REQUEST['languages']['domain'],'/'),false);
					if (!empty($language['domain']) && !syntax::http($language['domain']))	$error['err_'.$LANG_ID] = '%%DOMAIN_NICHT_ERREICHBAR%%';
				} else																		$error['err_'.$LANG_ID] = '%%ANGABEN_UNVOLLSTAENDIG%%';
			}
			if (empty($_REQUEST['languages']['remove'][$LANG_ID]) && empty($error['err_'.$LANG_ID])) {
				$dbobj->as_real = true;
				if (!is_numeric($LANG_ID)) 			$LANG_ID = $dbobj->next_free_id('_languages','LANG_ID');
				$language['LANG_ID'] = $LANG_ID;
				$dbobj->array2db(__file__,__line__,$language,'#PREFIX#_languages','INSERT INTO','WHERE LANG_ID ="'.$language['LANG_ID'].'"');
				$error['info']  = '%%ANGABEN_GESPEICHERT%%'; # Die Änderungen sind eingtragen worden.
				if (!empty($_FILES['extra_img']))	save_extra_img(array('PAGE_ID'=>0,'LANG_ID'=>$LANG_ID));
				if (!empty($_REQUEST['languages']['LANG_ID']) && !is_numeric($_REQUEST['languages']['LANG_ID']))	$_REQUEST['languages']['LANG_ID'] = $language['LANG_ID'];
	}	}	}
	cache::clean();
	if(!empty($sql_a))	$dbobj->multiquery(__file__,__line__,$sql_a);
}
function save_translate($data=false) {
	global $dbobj,$error;
	foreach ($_REQUEST['transl'] as $l_id => $transl_data) {
		$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#_translate WHERE LANG_ID = ".$l_id.";");
		$tl_data['LANG_ID'] = $l_id;
		foreach ($transl_data as $tl_key => $tl_value) {
			$tl_data['name'] = $tl_key;
			$tl_data['value'] = $tl_value;
			$dbobj->array2db(__file__,__line__,$tl_data,'#PREFIX#_translate','INSERT INTO');
	}	}
	$error['info'] = '%%DATEN_WURDEN_GESPEICHERT%%';
}
function langs($first='',$selected=true,$l_out='',$rem=true,$tpl='') {
	global $tplobj,$dbobj,$langs_intern;
	if (empty($tpl))		$tpl = '<option value="|LANG_ID|" |LANG_|LANG_ID||>|TITEL|</option>';
	if (empty($langs_intern) || !$rem) {
		$sql = "SELECT #PREFIX#_languages.LANG_ID,lang_intl AS Beschreibung,lang_local AS titel,direction,Dateiname FROM #PREFIX#_languages LEFT JOIN (#PREFIX#bilder) ON (#PREFIX#bilder.PART_ID = 'flag' AND #PREFIX#bilder.LANG_ID = #PREFIX#_languages.LANG_ID) ORDER BY #PREFIX#_languages.position;";
		$langs = $dbobj->withkey(__file__,__line__,$sql,"LANG_ID");
		$l_out = '';
		if (!empty($langs) && is_array($langs)) {
			foreach ($langs as $key => $l) {
				if (!empty($l['Dateiname'])) $l['ls'] = 'style="background-image:url(/images/bilder/0_'.$l['Dateiname'].')"';
				$l_out .= "\n".$tplobj->array2tpl($tpl,$l);
	}	}	}
	if (!empty($selected))	$l_out = str_replace('|LANG_'.$selected.'|','selected="selected"',$l_out);
	if (!$rem)				unset($langs_intern);
	return $l_out;
}
?>