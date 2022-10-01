<?php
function admin_tpl() {
	global $tplobj,$vorgaben;
	$sub_tpl['pagetitle'] = 'Admin';
	if (!empty($_SESSION['status']) && $_SESSION['status'] == 'Admin') {
		if (!empty($_REQUEST['rights']))		save('rights');
		if (!empty($_REQUEST['update2fck']))	update2fck();
	}
	page();
	if (!empty($_SESSION['logged'])) {	 // only for admin or editor.
		if (!empty($_REQUEST['send']))		 speichern();
		elseif (!empty($_REQUEST['preview']))save_preview($data=false);
		$tpl = $tplobj->read_tpls('admin/main.tpl.html');
		do_admin_menu($tpl);
		$out['text'] = verwaltung();
	} else {							// everbody else
		$tpl['menu'] = '';				// shouldn't even come thus far
		$out['text'] = verwaltung();	// they'll just see the logout button.
	}
	final_output(main_tpl($out,$tpl));
}
function do_admin_menu(&$tpl) {
	global $tplobj,$add_admin,$page;
	if (!empty($add_admin)) {										// Plugins-Menu ...
		$n_old = ''; ksort($add_admin,SORT_STRING);
		$plugins = array();
		krsort($add_admin,SORT_STRING);
		while (list($plugin_name, $pi_m) = myEach($add_admin)) {					// Loop through add-ons
			$plugin_name .= '_menu';
			ksort($pi_m,SORT_STRING);
			if (empty($plugins[$plugin_name]))				$plugins[$plugin_name] = '';
			if (!empty($n_old) && $n_old != $plugin_name)	$plugins[$plugin_name] .= '#SEPERATOR#';
			$n_old = $plugin_name;
			do_plugin($plugins,$plugin_name,$pi_m,$tpl);
		}
		$tplobj->array2tpl2($tpl['menu'],$plugins,'|');									// fill special menus first
		unset($plugins['editor_menu'],$plugins['admin_menu'],$plugins['admin2_menu']);	// clear them
		$tpl['menu'] = str_replace('|USER_MENU|',implode("\n",$plugins),$tpl['menu']);	// and everything else goes here
		unset($plugins);
		make_replacements($tpl['menu']);
	}
	$tpl['menu'] = str_replace('#ACTIVE_'.strtoupper($page).'#','class="active"',$tpl['menu']);		// set active page in admin menu
	$tpl['menu'] = str_replace('|KATS|',kats('',true,'',false,'<option value="|KAT_ID|" |KAT_|KAT_ID||>|TITEL|</option>'),$tpl['menu']);
	$tpl['menu'] = str_replace('#SEPERATOR#','<li style="background-color:#eee;">&nbsp;&nbsp;</li>',$tpl['menu']);
	$tpl['menu'] = preg_replace("/\#[A-Z_0-9]+\#/Us",'',$tpl['menu']);
	unset($add_admin);
}
function do_plugin(&$plugins,$plugin_name,$pi_m,$tpl) {
	global $tplobj,$add_functions,$vorgaben;
	while($attr = key($pi_m)){
		$plugin = array_shift($pi_m);							// Within add-on loop throug singular plugins
		if (!empty($_SESSION['permissions'][$attr]) || (!empty($plugin['alias']) && !empty($_SESSION['permissions'][$plugin['alias']]))) {	// User has to have the rights to use
			if (!empty($plugin['alias']) && !empty($_SESSION['permissions'][$plugin['alias']])) { // allow some legacy for old plugin names
				$_SESSION['permissions'][$attr] =  $_SESSION['permissions'][$plugin['alias']];							// and set rights accordingly
				unset($_SESSION['permissions'][$plugin['alias']]);									// discard old stuff.
			}
			if (empty($plugin['titel']))	$plugin['titel'] = &$attr;
			if (empty($plugin['page']))		$plugin['page']  = &$attr;
			if (empty($plugin['suffix'])) 	$plugin['suffix']= '';
			if (!empty($plugin['function']))$add_functions[$attr]['function'] = &$plugin['function'];	// set function to call
			else							$add_functions[$attr]['function'] = &$attr;
			$add_functions[$attr]['title'] = &$plugin['titel'];
			$plugin['attr']	 = &$attr;
			$plugin['attr2'] = strtoupper($attr);
			if (!empty($add_functions[$attr])) {
				$startup_function = 'startup_'.$add_functions[$attr]['function'];	// if this function exists: execute and use.
				if (function_exists($startup_function)) $plugin['extra'] = $tplobj->array2tpl($startup_function($tpl),$plugin);
			}
			if (!empty($plugin['popup']) && !empty($vorgaben[$plugin['popup']])) {		// may be it's a popup window
				if (!empty($plugin['protocol']))$plugin['page']  = url_protocol($vorgaben[$plugin['popup']],$plugin['protocol']);
				else							$plugin['page']  = url_protocol($vorgaben[$plugin['popup']]);
				if (!empty($plugin['suffix']))	$plugin['page'] .= $plugin['suffix'];
				$plugins[$plugin_name] .= $tplobj->array2tpl($tpl['popupzeile'],$plugin);
				unset($add_functions[$attr]);
			} elseif (!empty($plugin['function']) && empty($plugin['nomenu'])) {		// may be we need the menu entry
				$plugins[$plugin_name] .= $tplobj->array2tpl($tpl['zeile'],$plugin);
}	}	}	}
function verwaltung() {
	global $dbobj,$sub_tpl,$vorgaben,$add_functions,$page;
	if (!empty($page)) $sub_tpl['pagetitle'] = $page;
	$out = '';
	if (!empty($_SESSION['logged']) && !empty($_SESSION['status']) && !is_numeric($_SESSION['status'])) {
		if (!empty($add_functions[$page])) {												// get plugin functions
			if(!empty($_SESSION['permissions'][$page]) && function_exists($add_functions[$page]['function'])) {	// exeute if user has rights to do so
				$out = $add_functions[$page]['function']();
				$sub_tpl['pagetitle'] = $add_functions[$page]['title'];
		}	} else {
			switch($page) {
				case 'passwort':																	// new password
				case 'person':	if(!empty($_SESSION['permissions']['editor']))	$out = adress_db(false,$page);	break;	// or personal data
				case 'adressen':if(!empty($_SESSION['permissions']['admin']))	$out = adress_db();				break;	// and admins get an overview of all people
				default:														$out = switch_pages($out);		break;
		}	}
		check_in_use();
	}
	elseif (!empty($_SESSION['logged']) && !empty($_SESSION['status']) && is_numeric($_SESSION['status']))	login();
	elseif (!empty($vorgaben['seiten_tpl']) && empty($out)) 						logout(true);
	if (!empty($sub_tpl['pagetitle'])) $sub_tpl['pagetitle'] = 'Admin - '.$sub_tpl['pagetitle'];
	unset($add_functions);
	return str_replace('|PAGE|',$page,$out);
}
function switch_pages($out='',$scope=array()) {
	global $dbobj,$sub_tpl,$vorgaben,$add_functions,$page;
	if(!empty($_SESSION['permissions']['1_pages']))	$out = admin_pages('','',$scope);					// default o page overview
	elseif (!empty($add_functions) && $k = key(array_intersect_key($add_functions,$_SESSION['permissions']))) {	// or the first allowed plugin,
		if (function_exists($add_functions[$k]['function'])) {
			if (!empty($plugin_functions[$add_functions[$k]['function']])) {			// if plugin function exists (plugins can modify standard functions)
				foreach($plugin_functions[$add_functions[$k]['function']] as $fct) $fct();	// execute plugin functions
			}
			$out = $add_functions[$k]['function']();				// if a fitting function is available.
			$sub_tpl['pagetitle'] = $add_functions[$k]['title'];
	}	}
	return $out;
}
function check_in_use() {	// Show whether there is someone working (on pages, templates ...) -> as msg above page.
	if (!empty($_REQUEST['pages']['PAGE_ID']) && is_numeric($_REQUEST['pages']['PAGE_ID'])) 		{$inuse['attr'] = 'PAGE_ID'; $inuse['attr_ID'] = &$_REQUEST['pages']['PAGE_ID'];}
	if (!empty($_REQUEST['kat']['KAT_ID']) && is_numeric($_REQUEST['kat']['KAT_ID']))				{$inuse['attr'] = 'KAT_ID';	 $inuse['attr_ID'] = &$_REQUEST['kat']['KAT_ID'];}
	if (!empty($_REQUEST['tmpl']['TPL_ID']) && is_numeric($_REQUEST['tmpl']['TPL_ID']))				{$inuse['attr'] = 'TPL_ID';  $inuse['attr_ID'] = &$_REQUEST['tmpl']['TPL_ID'];}
	if (!empty($_REQUEST['languages']['LANG_ID']) && is_numeric($_REQUEST['languages']['LANG_ID'])) {$inuse['attr'] = 'LANG_ID'; $inuse['attr_ID'] = &$_REQUEST['languages']['LANG_ID'];}
	if (!empty($inuse)) {
		global $dbobj,$error;
		if ($used = $dbobj->exists(__file__,__line__,"SELECT person_ID,Name FROM #PREFIX#_inuse,#PREFIX#person WHERE #PREFIX#_inuse.person_ID = #PREFIX#person.ID AND #PREFIX#person.ID <> ".$_SESSION['uid']." AND attr = '".$inuse['attr']."' AND attr_ID = '".$inuse['attr_ID']."';")) {
			$error[] = '%%WIRD_BEARBEITET_VON%%: '.$used[0]['Name'];
		} else {
			$inuse['person_ID'] = &$_SESSION['uid'];
			$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#_inuse WHERE person_ID = ".$_SESSION['uid']." AND attr = '".$inuse['attr']."';");
		}
		$dbobj->array2db(__file__,__line__, $inuse,'#PREFIX#_inuse','INSERT INTO',"WHERE person_ID = ".$_SESSION['uid']." AND attr = '".$inuse['attr']."'");
}	}
function referrer($ref='',$page='') {	// Where did you come from - we can bring you back there
	if (!empty($_GET['ref'])) {
		$_SESSION['ref'] = &$_GET['ref'];
		$_SESSION['permissions']['ifref'] = 1;
		if (!empty($_GET['addref']) && is_array($_GET['addref'])) 	$_SESSION['addref'] = $_GET['addref'];
		else 														unset($_SESSION['addref']);
	}
	if (!empty($_SESSION['ref'])) {
		$_SESSION['permissions']['ifref'] = 1;
		$ref = $_SESSION['ref'];
		if (!empty($_SESSION['addref']) && is_array($_SESSION['addref'])) {
				while (list($k,$v) = myEach($_SESSION['addref'] )) {
				if (is_array($v)) {
					while (list($n,$m) = myEach($v))	$ref .= '&amp;'.$k.'['.$n.']='.$m;
				} else {
					$ref .= '&amp;'.$k.'='.$v;
		}	}	}
	} else {
		$ref = page();
		unset($_SESSION['ref'],$_SESSION['permissions']['ifref']);
	}
	return $ref;
}
function page() {	// get the first admin page to show
	global $add_functions,$page;
	if (!empty($_REQUEST['page']))			$page = $_REQUEST['page'];		// on request
	elseif (!empty($_SESSION['permissions']['firstplugin'][0]))	$page = $_SESSION['permissions']['firstplugin'][0];	// if it is choosen as first plugin
	else									$page = 'pages';				// otherwise show pages
}
?>