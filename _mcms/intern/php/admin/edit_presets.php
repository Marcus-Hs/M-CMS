<?php
function prepare_edit_presets() {
	global $add_admin,$add,$add_vorgaben;
	$add['Vorgaben'] = array('seiten_tpl'=>'%%SEITENVORLAGE%%',
							 'meldungen_seite'=>'%%MELDUNGEN%%',
							 'kontakt_seite'=>'%%KONTAKTSEITE%%',
							 'abbinder_seite'=>'%%ABBINDERSEITE%%');
	$add_admin['editor']['2_messages']		= array('function' => 'edit_msgs',	 'titel' => '%%MELDUNGEN%%');
	$add_admin['admin']['4_presets']		= array('function' => 'edit_presets','titel' => '%%VORGABEN%%','style'=>'style="background-image:url(/admin/icons/Advancedsettings.png)"');
#	$add_admin['admin2']['sonderseiten']	= array('function' => 'sonderseiten',	'titel' => '%%SONDERSEITEN%%',	'style'=>'style="background-image:url(/admin/icons/Advancedsettings.png)"');
#	$add_admin['admin2']['sondervorlagen']	= array('function' => 'sondervorlagen',	'titel' => '%%SONDERVORLAGEN%%','style'=>'style="background-image:url(/admin/icons/Advancedsettings.png)"');
	$add_vorgaben['Pfade']['abspaths']		= '<label for="abspaths">%%PFADE_ABSOLUT_SETZEN%%: </label>		<input id="abspaths" type="checkbox" name="vorgaben[abspaths]" |ABSPATHS_CHK| value="1" ><br />';
	$add_vorgaben['Pfade']['excludepaths']	= '<label for="exclude_paths">%%PFADE_AUSSCHLIESSEN%%: </label>		<input id="exclude_paths" type="text" name="vorgaben[exclude_paths]" value="|EXCLUDE_PATHS|" ><br />';
	$add_vorgaben['Kontakt']['select_subject'] = '<label for="select_subject">%%BETREFFANHANG%%: </label>	<select name="vorgaben[select_subject]" id="select_subject">
		<option value="0" |SELECT_SUBJECT_0|>%%OHNE%%</option>
		<option value="1" |SELECT_SUBJECT_1|>['.domain('*').']</option>
		<option value="2" |SELECT_SUBJECT_2|>['.domain().']</option>
		<option value="3" |SELECT_SUBJECT_3|>['.domain(0).']</option></select><br />';
}
function startup_edit_presets() {
	$out = '';
	$array = array('vgsize'=>'%%GROESSENVORGABEN%%','vgsys'=>'%%SYSTEM%%','vgspecial'=>'%%BESONDERE_SEITEN%%','vgo'=>'%%VERWALTUNGSSPRACHE%%');
	foreach($array as $s => $name) {
		$out .= "\n".'<li><a href="|PHPSELF|?page=4_presets&amp;show='.$s.'|SID|">'.$name.'</a></li>';
		if (!empty($_REQUEST['show']) && $_REQUEST['show']== $s) {
			$_SESSION['addstyles']['#toggle_'.$s]['display'] = 'table';
			$_SESSION['addstyles']['#toggle_'.$s]['show'] = 'true';
		} elseif (!empty($_REQUEST['show'])) {
			unset($_SESSION['addstyles']['#toggle_'.$s]);
	}	}
	return '<ul>'.$out.'</ul>';
}
function edit_msgs() {
	global $vorgaben;
	return admin_pages($vorgaben['meldungen_seite']);
}
function edit_presets($seiten = '',$sprachen = '',$addvorgaben = '') {
	global $tplobj,$dbobj,$vorgaben,$display_tree,$add,$add_vorgaben,$sub_tpl;
	add_fck();
	$vorgaben_edit	= read_vorgaben('*','vorgaben');
	$tpls			= $tplobj->read_tpls('admin/vorgaben.inc.html');
	$eintrag_tpl	= $tplobj->read_tpls('admin/unterseite_von.entry.html');
	foreach ($vorgaben_edit as $key => $value) {
		if ($value == 1)																						$vorgaben_edit[$key.'_chk'] 					= 'checked="checked"';
		if (!empty($vorgaben_edit[$key]) && (strpos($key,'select_')!==false || strpos($key,'fixed')!==false))	$vorgaben_edit[$key.'_'.$vorgaben_edit[$key]]	= 'selected="selected"';
	}
	if (empty($vorgaben_edit['template']))	$vorgaben_edit['template'] = '<p><br /><p>';
	if (empty($display_tree))				display_tree();
	foreach ($display_tree as $p) 			$seiten .= "\n".$tplobj->array2tpl($eintrag_tpl,$p);
	$vls = vls('',false,'',false);
	if (!empty($add) && is_array($add)) {
		foreach ($add as $rubrik => $addit) {
			foreach ($addit as $a => $title) {
				if (strpos($a,'_multi_') !==false)	$name = 'name="vorgaben['.$a.'][]" multiple="multiple" size="3"';
				else								$name = 'name="vorgaben['.$a.']"';
				$add_vorgaben[$rubrik][$a] = '<label for="'.$a.'">'.$title.':</label>
				<select id="'.$a.'" '.$name.' onChange="changelink(\''.$a.'\')" style="width:auto;">
				<option value="">- %%KEINE%% -</option>|'.strtoupper(str_replace('_','',$a)).'|</select>
				|ADDLINK_'.strtoupper(str_replace('_','',$a)).'|<br class="cb" />';
	}	}	}
	if (!empty($add_vorgaben) && is_array($add_vorgaben)) {
		foreach ($add_vorgaben as $function => $add_tpl) {
			$tpls['addvg_top'] .= "<tr><td><h4>".$function."</h4></td><td><hr />";
			if (is_array($add_tpl))	$tpls['addvg_top'] .= implode("\n",$add_tpl);
			else					$tpls['addvg_top'] .= "\n".$add_tpl;
			$tpls['addvg_top'] .= "</td></tr>";
			$mod_vorgaben = 'mod_vorgaben_'.strtolower($function);
			if (function_exists($mod_vorgaben))		$tpls['addvg_top'] = $mod_vorgaben($tpls['addvg_top']);
			foreach ($add_tpl as $key => $a) {
				$a1 = str_remove($key,'_');
				if (!is_numeric($key) && empty($vorgaben_edit[$key])) {
					$vorgaben_edit[$key] = 0;
					$sub_tpl['style'][] = '#'.$key.' {background-color:#fdd;} label[for='.$key.'] {color:red}';
				}
				if (strpos($key,'_multi_') !==false)	$more = $tplobj->array2tpl($eintrag_tpl,array('PAGE_ID'=>-1,'Menu'=>'- %%ALLE%% -'));
				else									$more = '';
				if	   (strpos($key,'_tpl')  !==false)	{$vorgaben_edit[$a1] = $more.$vls; 		$replace = '|TPL_';}
				elseif (strpos($key,'_seite')!==false)	{$vorgaben_edit[$a1] = $more.$seiten;	$replace = '|SEL_';}
				if (!empty($replace) && !empty($vorgaben_edit[$key]) && !empty($vorgaben_edit[$a1])) {
					$selected = explode(',',$vorgaben_edit[$key]);
					foreach ($selected as $sel) {
						if		(strpos($key,'_seite')!==false && !empty($sel))	$vorgaben_edit['addlink_'.$a1] = ' <a id="link_'.$key.'" href="|PHPSELF|?page=1_pages&amp;pages[PAGE_ID]='.$sel.'|SID|"   class="tooltip" title="%%SEITE%% - %%BEARBEITEN%% (PAGE_ID = '.$sel.')"><small>'.get_page(array('PAGE_ID'=>$sel,'feld'=>'Menu','visibility'=>'0,1','errors'=>false)).'</small></a>';
						elseif	(strpos($key,'_tpl')!==false   && !empty($sel))	$vorgaben_edit['addlink_'.$a1] = ' <a id="link_'.$key.'" href="|PHPSELF|?page=2_templates&amp;tmpl[TPL_ID]='.$sel.'|SID|" class="tooltip" title="%%VORLAGE%% - %%BEARBEITEN%% (TPL_ID = '.$sel.')"><small>'.template_title($sel).'</small></a>';
						else													$vorgaben_edit['addlink_'.$a1] = '';
						$vorgaben_edit[$a1] = str_replace($replace.$sel.'|','selected="selected"',$vorgaben_edit[$a1]);
					}
					unset($replace,$selected);
		}	}	}
		$tpls['addvg_top'] .=  $tpls['addvg_bottom'];
	}
	$tpls['vorgaben'] = str_replace('|ADDVORGABEN|',$tpls['addvg_top'],$tpls['vorgaben']);
	foreach ($dbobj->singlequery(__file__,__line__,"SELECT LANG_ID AS PAGE_ID, lang_local AS title, lang_local AS menu FROM #PREFIX#_languages ORDER BY position;") as $l) {
		$sprachen .= "\n".$tplobj->array2tpl($eintrag_tpl,$l);
	}
	$vorgaben_edit['verwaltungssprache']	= str_replace('|SEL_'.$vorgaben['verwaltung_sprache'].'|','selected="selected"',$sprachen);
	return $tplobj->array2tpl($tpls['vorgaben'],$vorgaben_edit);
}
function save_vorgaben($data) {
	global $error,$dbobj,$add_vorgaben;
	if (empty($_REQUEST['vorgaben']['directlogin']))$_REQUEST['vorgaben']['directlogin']  = 0;
	if (empty($_REQUEST['vorgaben']['nonumsubp']))	$_REQUEST['vorgaben']['nonumsubp']  = 0;
	if (empty($_REQUEST['vorgaben']['nohtmlsubp']))	$_REQUEST['vorgaben']['nohtmlsubp'] = 0;
	if (empty($_REQUEST['vorgaben']['kategal']))	$_REQUEST['vorgaben']['kategal'] = 0;
	if (empty($_REQUEST['vorgaben']['checkdate']))	$_REQUEST['vorgaben']['checkdate'] = 0;
	if (empty($_REQUEST['vorgaben']['forceplain']))	$_REQUEST['vorgaben']['forceplain'] = 0;
	if (empty($_REQUEST['vorgaben']['showblocks']))	$_REQUEST['vorgaben']['showblocks'] = 0;
	if (empty($_REQUEST['vorgaben']['cleanword']))	$_REQUEST['vorgaben']['cleanword'] = 0;
	if (empty($_REQUEST['vorgaben']['imgtitlerpl']))$_REQUEST['vorgaben']['imgtitlerpl'] = '0';
	if (empty($_REQUEST['vorgaben']['deluserpages']))$_REQUEST['vorgaben']['deluserpages'] = '0';
	if (empty($_REQUEST['vorgaben']['set_session']))$_REQUEST['vorgaben']['set_session'] = '0';
	if (!empty($add_vorgaben)) {
		foreach ($add_vorgaben as $k1) {
			foreach ($k1 as $k2 => $a) {
				if (!isset($_REQUEST['vorgaben'][$k2]))	$_REQUEST['vorgaben'][$k2] = 0;
			}
	}	}
	foreach ($_REQUEST['vorgaben'] as $key => $value) {
		$sqls[] = 'REPLACE INTO #PREFIX#vorgaben (name,value) VALUES ("'.strtolower($key).'","'.addcslashes(trim(r_implode($value),'/'),'"').'") ;';
	}
	$dbobj->multiquery(__file__,__line__,$sqls);
	$error['info'] = '%%AENDERUNGEN_SIND_EINGETRAGEN%%';
}
function sonderseiten() {
	global $tplobj,$dbobj,$vorgaben,$add;
	$out = '<h2>%%SONDERSEITEN%%</h2>';
	foreach ($add as $x) {
		foreach ($x as $key => $a) {
			if (strpos($key,'_seite')!==false && !empty($vorgaben[$key])) 	$ids['PAGE_ID'][] = $vorgaben[$key];
			if (strpos($key,'_tpl')  !==false && !empty($vorgaben[$key])) 	$ids['TPL_ID'][]  = $vorgaben[$key];
	}	}
	return admin_pages($ids);
}
function sondervorlagen() {
	global $tplobj,$dbobj,$vorgaben,$add;
	$out = '<h2>%%SONDERVORLAGEN%%</h2>';
	foreach ($add as $x) {
		foreach ($x as $key => $a) {
			if (strpos($key,'_tpl')!==false && !empty($vorgaben[$key])) 	$ids[] = $vorgaben[$key];
	}	}
	return edit_templates(implode(',',$ids));
}
?>