<?php
function prepare_edit_addr() {
	global $dbobj,$add_admin,$add,$add_vorgaben,$addr_functions;
	$add_admin['plugin']['Benutzer'] = array('function' => 'benutzer_admin','titel' => '%%BENUTZER%%','style'=>'style="background-image:url(/admin/icons/people.png)"');
	if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#person','Message')) { // optional if Column exists offert to save messages
		$addr_functions[] = 'show_addr_msg';									// that's the funtion to call on each user
		$add_vorgaben['Adressen']['savecontacts'] = '<label for="savecontacts">%%KONTAKTE_SPEICHERN%%: </label>		<input id="savecontacts" type="checkbox" name="vorgaben[savecontacts]" |SAVECONTACTS_CHK| value="1" ><br />';
	}
	$add['Adressverwaltung'] = array('status_seite'=>'%%STATUSSEITE%%',
									 'passwortvergessen_seite'=>'%%PASSWORTVERGESSENSEITE%%','passwort_seite'=>'%%PASSWORTSEITE%%',
									 'statusaenderung_seite'=>'%%STATUSAENDERUNGSEITE%%',
									 'logout_seite'=>'%%LOGOUTSEITE%%',		'login_seite'=>'%%LOGINSEITE%%',
									 'gesperrt_seite'=>'%%GESPERRTSEITE%%',	'freigabe_seite'=>'%%FREIGABESEITE%%');
#	$add['Login'] 			 = array('login_seite'=>'%%LOGINSEITE%%');
	$add['Logout'] 			 = array('logout_seite'=>'%%LOGOUTSEITE%%');
	if (!empty($_REQUEST['send'])) {
		if (!empty($_REQUEST['release']))		release_pages();
		if (!empty($_REQUEST['person']))		save('person');
		if (!empty($_REQUEST['passwort_neu1'])) save('passwort');
}	}
function benutzer_admin() {			// show user, not admins
	return adress_db($rights=88);
}
function show_addr_msg($uid='') {	// called on eac user. If msg exists insert link to show msg.
	global $dbobj;
	if ($dbobj->exists(__file__,__line__,"SELECT ID FROM #PREFIX#person WHERE ID = '".$uid."' AND Message != '';")) {
		return '<a href="show_msg.php?person_id='.$uid.'|SID|" target="_blank">%%NACHRICHT_ANZEIGEN%%</a>';
}	}
function menustatus($out='') { // Status of users an Count
	global $dbobj;
	$cs = $dbobj->withkey(__file__,__line__,'SELECT status,COUNT(*) as count FROM #PREFIX#person GROUP BY status;','status',true);
	foreach(status_array(true) as $s => $status) {
		if (!empty($cs[$s]))	$c = $cs[$s]['count'];
		else					$c = 0;
		$out .= "\n".'<li><a href="|PHPSELF|?page=adressen&amp;search[status][]='.$s.'&amp;subpage[search]=search&amp;suche=|SID|">'.$status.' ('.$c.')</a></li>';
	}
	internal_functions($out);
	return '<ul>'.$out.'</ul>';
}
function adress_db($rights=true,$subpage='',$cache=true) { // show users, editors and admins with adress and additional data
	global $dbobj,$tplobj,$script,$error,$vorgaben,$sub_tpl,$plugin_functions;
	$sub_tpl['pagetitle'] = '%%VERWALTUNG%%';
	if (!empty($plugin_functions['adress_db'])) {							// look for plugin funtions
		foreach($plugin_functions['adress_db'] as $fct) $fct();					// execute plugin functions (see above)
	}
	if($rights===true)	$_SESSION['permissions']['rights']=1;
	if($rights)			$_SESSION['permissions']['status']=1;
	$tpls = $tplobj->read_tpls('admin/addr.inc.html');							// load template
	if (isset($_POST['send']) && isset($_REQUEST['mails'])) user_mails($tpls);	// check mails to send
	$status_array = status_array($rights,$cache);										// get status info as array
	if (!empty($subpage))									$main_tpl = '|ADRESSEN|';
	if (empty($subpage) && !empty($_REQUEST['subpage']))	$subpage = key($_REQUEST['subpage']);
	elseif (empty($subpage))								$subpage = 'search';
	$selection['select'] = '';
	switch($subpage) {	// switch for available functions
		case 'new':	case 'change': case 'person':	$out = entry($tpls,$rights);break;
		case 'passwort':							$out = passwort($tpls);		break;
		case 'sendmails':							$out = writemail($tpls);	break;
		case 'listmails':							$out = listmail($tpls);		break;
		case 'email':								$selection['select'] = 'Name,Email';
		case 'search':								$out = showaddr(selection($selection,$rights),$tpls,$rights);	break;
	}
	if (isset($out)) 				$tpls['main'] = str_replace('|ADRESSEN|',$out,$tpls['main']);
	if (isset($sub_tpl['subnav'])) 	$tpls['main'] = str_replace('|SUBNAV|',$sub_tpl['subnav'],$tpls['main']);
	if ($rights)					$tpls['main'] = str_replace('|INHALT|',  such_tpl($tpls,$rights),$tpls['main']);
	return preg_replace("/\#[A-Z0-9_]+\#/Us",'',$tpls['main']);
}
function user_mails($tpls) {				// send mails
	global $dbobj,$tplobj,$error,$vorgaben,$sub_tpl;
	if (!empty($_FILES['attachment']['name'][0])) {						// check for attachements
		foreach ($_FILES['attachment']['error'] as $key => $fileerror) {// check for errors,
			if ($fileerror > 0 && $fileerror !=4)						// something wrong?
				$error['dateifehler'] = str_replace('#SIZE#',$_FILES['attachment'][$key]['size'],'%%DATEI_ZU_GROSS%%');
	}	}
	if (empty($error['dateifehler']) && !empty($_REQUEST['mails'])) {									// when without error send mail
		$recipients = $dbobj->singlequery(__file__,__line__,"SELECT Name,Email FROM #PREFIX#person WHERE ID IN (".r_implode($_REQUEST['mails'],',').");");
		$data['abbinder'] = mailfooter();
		if (!empty($_REQUEST['text'])) $data['text'] = stripslashes($_REQUEST['text']);
		$body['html'] = $tplobj->array2tpl($sub_tpl['html'],$data,'#');
		if (isset($recipients[0])
				&& !empty($_REQUEST['ueberschrift']) && !empty($_REQUEST['text'])
				&& mail_send(array('subject'=>stripslashes($_REQUEST['ueberschrift']),'body'=>$body,'to'=>$recipients,'bcc'=>true)))
			$error['msg'] = '%%EMAILS_SIND_VERSANDT_WORDEN%% ('.$sub_tpl['mailcount'].').';
	} else {
		$_REQUEST['subpage']['sendmails'] = 1;							// otherwise return
}	}
function such_tpl($tpls,$rights) { // prepare search
	global $dbobj,$tplobj,$vorgaben,$languages_byid,$sub_tpl;
	if	(empty($_REQUEST['search']) && isset($_SESSION['search']))				$_REQUEST['search'] = $_SESSION['search'];
	if  (empty($_REQUEST['search']['suche']))		$_REQUEST['search']['suche'] = '';
	if  (empty($_REQUEST['search']['status']))		$_REQUEST['search']['status'] = array();
	if  (empty($_REQUEST['search']['sprachen']))	$_REQUEST['search']['sprachen'] = array();
	$out['auswahl'] = sel_status($_REQUEST['search']['status'],$rights);
	$out['suchbegriff'] = $_REQUEST['search']['suche'];
	$out['sprachen'] = sel_array($languages_byid,$_REQUEST['search']['sprachen'],$key='',$id='LANG_ID',$value='lang_local');
	if (!empty($sub_tpl['add_search']))	$out['add_search'] = implode("\n",$sub_tpl['add_search']);
	return $tplobj->array2tpl($tpls['auswahl'],$out,'|');
}
function passwort($tpls='') { // change password
	global $error,$dbobj,$vorgaben;
	$tpl = $tpls['passwort'];
	if (!empty($_SESSION['status']) && $_SESSION['status'] == 'Admin' || !empty($_SESSION['permissions']['kunden']) || !empty($_SESSION['permissions']['benutzer'])) {
		if (isset($_REQUEST['sendto']) && is_numeric($_REQUEST['uid'])) {
			$_REQUEST['zugang'] = $dbobj->tostring(__file__,__line__,"SELECT Email FROM #PREFIX#person WHERE id = '".$_REQUEST['uid']."'");
			get_vorlage(array('PAGE_ID'=>$vorgaben['passwortvergessen_seite'],'set_vg'=>false,'use_css'=>false,'errors'=>false));
			passwortvergessen($_REQUEST['uid']);
			$error['info'] = '%%PASSWORTGESPEICHERT%%';
		}
		if (isset($_REQUEST['uid'])) {
			$name = $dbobj->singlequery(__file__,__line__,"SELECT Name FROM #PREFIX#person WHERE  id = '".$_REQUEST['uid']."'");
			if (empty($_REQUEST['passwort_neu1'])) $error['info'] = '%%PASSWORT_AENDERN%%: '.$name[0]['Name'];
			$tpl = str_replace('|ADMIN|','<input type="hidden" name="uid" value="|UID|" />',$tpl);
			return str_replace('|UID|',$_REQUEST['uid'],$tpl);
		}
	} else return str_remove($tpl,'|ADMIN|');
}
function selection($selection='',$rights) { // get selected users
	global $dbobj,$add_search;
	if(!empty($_REQUEST['uid']))	$show['uid'] = $_REQUEST['uid'];
	$selection['where'] = '';
	if (!empty($_REQUEST['subpage']['search'])) {
		if (isset($_REQUEST['search']))  $_SESSION['search'] = $_REQUEST['search'];
	} elseif (empty($_REQUEST['suche']) && (!empty($_REQUEST['subpage']) || !empty($_REQUEST['send']))) {
		if (isset($_SESSION['search']))  $_REQUEST['search']		= $_SESSION['search'];
	} else  unset($_SESSION['search']);
	if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#person','Kunden_NR')) {
		$m1 = 'Login,Kunden_NR,Name,Strasse,Email';
		$m2 = "Login,' ',Name,' ',Kunden_NR,' ',Strasse,' ',Email";
	} else {
		$m1 = 'Login,Name,Strasse,Email';
		$m2 = "Login,' ',Name,' ',Strasse,' ',Email";
	}
	if (!empty($_REQUEST['search']['suche']) && is_numeric($_REQUEST['search']['suche']))	$selection['where'] .= "\nWHERE ID = ".$_REQUEST['search']['suche'];
	elseif (!empty($_REQUEST['search']['suche']) && strlen($_REQUEST['search']['suche'])>3)	$selection['where'] .= "\n".'WHERE MATCH ('.$m1.') AGAINST (\''.$_REQUEST['search']['suche'].'\' IN BOOLEAN MODE)';
	elseif ( isset($_REQUEST['search']['suche']))											$selection['where'] .= "\nWHERE CONCAT(".$m2.") LIKE '%".$_REQUEST['search']['suche']."%'";
	elseif (!empty($_REQUEST['search']['subpage']['search']) && $_REQUEST['subpage']['search']!='all' && !empty($_SESSION['person_ID']) && is_array($_SESSION['person_ID']))
																							$selection['where'] .= "\nWHERE #PREFIX#person.ID IN (".r_implode($_SESSION['person_ID']).')';
	elseif (empty($_REQUEST['search']['suche']) && is_numeric($rights))						$selection['where'] .= "\nWHERE #PREFIX#person.status <= ".$rights;
	elseif (empty($_REQUEST['search']['suche']) && !$rights)								$selection['where'] .= "\nWHERE #PREFIX#person.status < 88";
	else																					$selection['where'] .= "\nWHERE #PREFIX#person.status >= 0";
	if (isset($_REQUEST['search']['status'][0]) && $_REQUEST['search']['status'][0] != '' )	$selection['where'] .= "\nAND (#PREFIX#person.status IN (".r_implode($_REQUEST['search']['status']).'))';
	if (!empty($_REQUEST['search']['sprachen'][0]))											$selection['where'] .= "\nAND (#PREFIX#person.LANG_ID IN (".r_implode($_REQUEST['search']['sprachen']).'))';
	if (!empty($add_search))																$selection['where'] .= implode("\n AND",$add_search);
	$sql = "SELECT	#PREFIX#person.*,#PREFIX#person.ID as person_ID,
					GROUP_CONCAT(DISTINCT #PREFIX#seiten.PAGE_ID) AS PAGE_IDs,
					GROUP_CONCAT(DISTINCT #PREFIX#_inuse.attr_ID) AS used_IDs
			FROM	#PREFIX#person	LEFT JOIN (#PREFIX#seiten,#PREFIX#seiten_attr)
										ON (#PREFIX#seiten.PAGE_ID = #PREFIX#seiten_attr.PAGE_ID AND #PREFIX#seiten_attr.person_ID = #PREFIX#person.ID)
									LEFT JOIN (#PREFIX#_inuse)
										ON (#PREFIX#_inuse.attr = 'PAGE_ID' AND #PREFIX#_inuse.person_ID = #PREFIX#person.ID)";
	if (!empty($selection['where']))	$sql .= $selection['where'];
	$sql .=  "\nGROUP BY #PREFIX#person.ID
				ORDER BY #PREFIX#person.status,#PREFIX#person.ID DESC";
	if ($data = $dbobj->withkey(__file__,__line__,$sql,'person_ID')) {
		$counter = 0;
		if (!empty($_REQUEST['$proseite']))	$proseite = $_REQUEST['proseite'];
		else																$proseite = 30;
		if (count($data)>$proseite) {
			global $path_in,$sub_tpl,$unterseite_id;
			$sub_tpl['subnavlink'] = "\n<a href=\"".$path_in.formget(array('all'=>'page,search,subpage,suche,uid')).'&#TO#|SID|">#LINK#</a>';
			$sub_tpl['subnavpre']   = 'paginate=';
			$sub_tpl['subnavbox']  = '<p class="nav">#ANZAHL# %%SEITEN%% (#VON# - #BIS#): #CONTENT# '.str_replace(array('#TO#','#LINK#'),array($sub_tpl['subnavpre'].'all','%%ALLE%%'),$sub_tpl['subnavlink']).'</p>';
			if (!empty($_REQUEST['paginate']) && is_numeric($_REQUEST['paginate']))	$unterseite_id = $_REQUEST['paginate'];
			elseif (!empty($_REQUEST['paginate']) && $_REQUEST['paginate']=='all')	$unterseite_id = $_REQUEST['paginate'];
			else																	$unterseite_id = 0;
			if (!is_numeric($unterseite_id))	$proseite = count($data);
			paginate($data,$proseite,false);
		}
		return $data;
	}
	else return false;
}
function entry($tpls,$rights) { // get single entry
	global $dbobj,$tplobj,$vorgaben,$addr_functions;
	$uid = uid();
	if ($_SESSION['status'] == 'Admin' || !empty($_SESSION['permissions']['kunden']) || !empty($_SESSION['permissions']['benutzer'])) { // only for admins and owners of rights to view
		if(!empty($_REQUEST['ID']))												$uid = $_REQUEST['ID'];
		elseif(!empty($_REQUEST['uid']))										$uid = $_REQUEST['uid'];
		elseif(!empty($_REQUEST['subpage']) && key($_REQUEST['subpage'])=='new')$uid = 'neu';
	}
	$tpl = $tpls['daten_start'];
	if (!empty($uid)) {	// Identification given
		$daten = $dbobj->singlequery(__file__,__line__,"SELECT * FROM #PREFIX#person WHERE ID = '".$uid."';");
		$daten = $daten[0];
	} else {			// or not
		unset($_REQUEST['ID']);
	}
	if (empty($daten['status']) && !empty($_REQUEST['search']['status'][0]) && is_numeric($_REQUEST['search']['status'][0]))	$daten['status'] = &$_REQUEST['search']['status'][0];
	elseif (empty($daten['status']))																							$daten['status'] = 0;
	if ($daten['status']>=88 && $rights===true) 					$tpl .= str_replace('|RECHTE|',set_rights($uid,$daten['status'],$tpls),$tpls['daten_rights']);
	else															$tpl .= $tpls['daten_rights'];
	if (empty($daten['status']) || !is_numeric($daten['status']))	$daten['status'] = 0;
	if ($rights)													$tpl = str_replace('|SHOWSTATUS|',set_user_status($uid,$daten,$tpls,$rights),$tpl);
	$values['DATEN'] = array('type' => 'input','name' => 'person[|key|]','size' => 30);
	$values['DATEN']['other']['suffix'] = ': ';
	$values['DATEN']['other']['spacer'] = '<br />';
	if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#person','plz')) { // some DBs can have extra fields
		$keys   = array('Firma'=>'%%FIRMA%%','Name'=>'%%NAME%%',/*'Nachname'=>'%%NACHNAME%%',*/'Login'=>'%%LOGIN%%','Strasse'=>'%%STRASSE%%',/*'Hausnummer'=>'%%HAUSNUMMER%%',*/'PLZ'=>'%%PLZ%%','Ort'=>'%%ORT%%','Telefon'=>'%%TELEFON%%','Fax'=>'%%FAX%%','Mobil'=>'%%MOBIL%%','Email'=>'%%EMAIL%%','www'=>'%%WWW%%');
		restructure_address($daten);
	} else {
		$keys   = array('Firma'=>'%%FIRMA%%','Name'=>'%%NAME%%','Login'=>'%%LOGIN%%','Strasse'=>'%%STRASSE%%','Ort'=>'%%ORT%%','Telefon'=>'%%TELEFON%%','Fax'=>'%%FAX%%','Mobil'=>'%%MOBIL%%','Email'=>'%%EMAIL%%','www'=>'%%WWW%%');
	}
	if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#person','Land'))		$keys['Land'] = '%%LAND%%';
	foreach ($keys as $k => $label) {
		$values['DATEN']['label'][$k] = $label;
		if (!empty($daten[$k]))					$values['DATEN']['keys'][$k] = $daten[$k];
		elseif(!empty($_REQUEST['person'][$k]))	$values['DATEN']['keys'][$k] = $_REQUEST['person'][$k];
		else									$values['DATEN']['keys'][$k] = '';
	}
	$tpl = str_replace(array('|ID|','|UID|'),$uid,$tpl);
	if (isset($daten['LANG_ID'])) {
		$l = $dbobj->singlequery(__file__,__line__,'SELECT LANG_ID AS ID,lang_local as titel FROM #PREFIX#_languages WHERE visibility = 1 ORDER BY position,short');
		if (!empty($daten['LANG_ID']))					$preset = $daten['LANG_ID'];
		elseif(!empty($_REQUEST['person']['LANG_ID']))	$preset = $_REQUEST['person']['LANG_ID'];
		else											$preset = 0;
		$values_lang = '';
		select_form($values_lang,$preset,'%%SPRACHE%%',$l,'person[LANG_ID]',false,'lang_id');
		$values = array_merge($values,$values_lang);
	}
	$data['extra'] = '';
	if (!empty($addr_functions)) {
		$data['extra'] = array();
		foreach ($addr_functions as $af) {
			if (function_exists($af))			$data['extra'][$af.'-'.$uid] = $af($uid);
		}
		$data['extra'] = cleanArray($data['extra']);
		if (!empty($data['extra']))				$data['extra'] = implode("\n<hr />\n",$data['extra']);
	}
	$tplobj->build_form($tpl,$values);
	$tpl .= $tpls['daten_ende'];
	return str_replace(array('Name:','|PAGE|','|UID|','|EXTRA|'),array('Name *:',$_REQUEST['page'],$uid,$data['extra']),$tpl);
}
function showaddr($addr,$tpls,$rights=true) {	// show data
	global $dbobj,$tplobj,$vorgaben,$addr_functions;
	$out = '';
	if ($dbobj->table_exists(__file__,__line__,'#PREFIX#person__settings')) {
			$nl = read_settings(array('person_ID'),false,'newsletter');
	}
	if (!empty($addr) && is_array($addr)) {
		unset($_SESSION['person_ID']);
		foreach($addr as $key => $data) {
			if ($rights && isset($data['status'])) 		$data['showstatus'] = set_user_status($key,$data,$tpls,$rights);				// select for status
			if ($rights===true && $data['status']>=3)	$data['sonstiges']  = set_user_rights($key,$data['status'],$tpls);	// select for rights/plugins
			if ($rights===true)							$data['extra'][]	= set_user_verification($key,$data['verified'],$tpls);	// select for rights/plugins
			if (!empty($addr_functions)) {
				$data['extra'] = array();
				foreach ($addr_functions as $af) {
					if (function_exists($af))			$data['extra'][$af.'-'.$data['person_ID']] = $af($data['person_ID']);	// and extra (plugin-)funtions
				}
				$data['extra'] = cleanArray($data['extra']);
			}
			if (!empty($data['extra']))		$data['extra'] = implode("\n<hr />\n",$data['extra']);
			if (!empty($nl) && in_array($key,$nl))	$data['chk_mail'] = "checked";
			if (!empty($data['verified']))		$data['color'] = "green";
			elseif (!empty($data['status']))	$data['color'] = "blue";
			else					$data['color'] = "red";
			if (!empty($data['PAGE_IDs']))		$data['pages'] = str_replace(array('|PERSON_ID|','|PAGES|'),array($key,count(explode(',',$data['PAGE_IDs']))),$tpls['addr_row_pages']);
			else					$data['pages'] = '';
			if (!empty($data['used_IDs']))		$data['inuse'] = str_replace(array('|USED_IDS|','|USED_TITLES|'),array($data['used_IDs'],get_page(array('PAGE_ID'=>$data['used_IDs'],'feld'=>'Menu','visibility'=>'0,1','errors'=>false))),$tpls['addr_row_inuse']);
			$a_out[] = $tplobj->array2tpl($tpls['addr_row_rights'],$data);
			$_SESSION['person_ID'][] = $key;
		}
		$out = str_replace('|ADDRCONTENTS|',implode("\n",$a_out),$tpls['addr_table']);
	} else $out= "\n<p>%%KEINE_EINTRAEGE_GEFUNDEN%%</p>";
	return $out;
}
function set_user_rights($key,$status='Gast',$tpls) { // set rights for editing and plugins
	global $dbobj,$tplobj,$rechte_default,$vorgaben,$add_admin,$radio;
	$tpl = str_replace('#KEY#',$key,$tpls['rights']);
	$out['1'] = '<h3 class="cb trigger tooltip" id="trigger_pages_'.$key.'" title="%%TOOLTIP_BERECHTIGUNGEN%%"><a>%%SEITEN%% / %%KATEGORIEN%% / %%VORLAGEN%%</a></h3><div class="toggle_container" id="toggle_pages_'.$key.'">';
	$radio = 1;
	add_rights_select($out,$key,'%%SEITEN%%',			'PAGE_ID','<option value="eigene" |SEL_eigene| |KAT_ID_eigene| >--- %%EIGENE%% ---</option>'.subpage_of(array('all'=>true)));
	add_rights_select($out,$key,'%%SEITEN_ANLEGEN%%',	'neu');
	add_rights_select($out,$key,'%%KATEGORIEN%%',		'KAT_ID',kats('',false,'',false,$tpls['kategorie']));
	add_rights_select($out,$key,'%%VORLAGEN%%',			'TPL_ID', vls('',false,'',false,$tpls['vorlage']));
	$out['2'] = '</div><br /><h3 class="cb trigger tooltip" id="trigger_pages2_'.$key.'" title="%%TOOLTIP_RECHTE%%"><a>%%SEITENDETAILS%%</a></h3><div class="toggle_container" id="toggle_pages2_'.$key.'">';
	$radio = 0;
	add_rights_select($out,$key,'%%SEITEN_BEARBEITEN%%','pages');
	add_rights_select($out,$key,'%%SPEICHERVERBOT%%',	'nosave','','style="color:red"');
	add_rights_select($out,$key,'%%SPRACHEN%%',			'lang');
	add_rights_select($out,$key,'%%VERSCHIEBEN%%',		'move');
	add_rights_select($out,$key,'%%KATEGORIEN%%',		'kats');
	add_rights_select($out,$key,'%%VORLAGEN%%',			'tpl');
	add_rights_select($out,$key,'%%UNTERSEITEN%%',		'subp');
	add_rights_select($out,$key,'%%ANZEIGEN%%',			'vis');
	add_rights_select($out,$key,'%%ABSCHNITTIMPORT%%',	'importsections');
	add_rights_select($out,$key,'%%LOESCHEN%%',			'rem');
	add_rights_select($out,$key,'%%SUCHEN%%',			'such');
	add_rights_select($out,$key,'%%MENUEBILDER%%',		'mimg');
	add_rights_select($out,$key,'%%HINTERGRUND%%',		'bgimg');
	add_rights_select($out,$key,'%%HINTERGRUND2%%',		'bgimg2');
	$radio = 1;
	if (!empty($add_admin)) {		// Check available plug-ins to set user rights
		$out['3'] = '</div><br /><h3 class="cb trigger tooltip" id="trigger_plugins_'.$key.'" title="%%TOOLTIP_PLUGINSRECHTE%%"><a>%%PLUGINS%%</a></h3><div class="toggle_container" id="toggle_plugins_'.$key.'">';
		ksort($add_admin,SORT_STRING);
		$n_old = '';
		foreach ($add_admin as $plugin_name => $pi_m) {
			if (!empty($n_old) && $n_old != $plugin_name) $out[$plugin_name] = '<br class="cb" /><hr />';
			$n_old = $plugin_name;
			foreach ($pi_m as $attr => $plugin) $out = add_rights_select($out,$key,$plugin['titel'],$attr);
	}	}
	$out['5'] = '</div>';
	if (!$rights = $dbobj->exists(__file__,__line__,'SELECT attr,attr_ID FROM #PREFIX#person,#PREFIX#seiten_personen WHERE #PREFIX#person.ID = person_ID AND #PREFIX#person.ID = "'.$key.'";')) { // no rights set for this user -> read defaults
		if (empty($rights_default[$status]) &&	$rights_default[$status] = $dbobj->exists(__file__,__line__,'SELECT attr,attr_ID FROM #PREFIX#seiten_personen,#PREFIX#person WHERE person_ID = #PREFIX#person.ID AND #PREFIX#person.status = '.$status.';')) {
			$rights = $rights_default[$status]; // if no rights are found get defaults from other user
	}	}
	if ($rights) { // a little more work is needed
		foreach ($rights as $x => $attr) {	// set rights
			if(!empty($attr['attr']))	$user_rights[$attr['attr']][] = $attr['attr_ID'];
		}
		if (!empty($user_rights)) {							// set options in admin view for each set of rights
			foreach ($user_rights as $attr => $v) {
				switch ($attr) {
					case 'PAGE_ID':	foreach ($v as $p)					$out['PAGE_ID'] = str_replace('|SEL_'.$p.'|',	'selected="selected"',$out['PAGE_ID']);	break;
					case 'KAT_ID':	foreach ($v as $p)					$out['KAT_ID']  = str_replace('|KAT_ID_'.$p.'|','selected="selected"',$out['KAT_ID']);	break;
					case 'TPL_ID':	foreach ($v as $p)					$out['TPL_ID']  = str_replace('|TPL_ID_'.$p.'|','selected="selected"',$out['TPL_ID']);	break;
#					case 'firstplugin':									break;
					default: if (!empty($out[$attr]) && isset($v[0]))	$out[$attr]	 = str_replace('|CHK_'.$attr.'|','checked="checked"',  $out[$attr]);		break;
	}	}	}	}
	$out = implode("\n<br />",$out);
	if (!empty($_SESSION['permissions']['firstplugin'][0])) { // set wich plugin is shown after log-in
		$out = str_replace('value="'.$_SESSION['permissions']['firstplugin'][0].'"','checked="checked" value="'.$_SESSION['permissions']['firstplugin'][0].'"',  $out);
	}
	return $out;
}
function add_rights_select(&$out,$key,$titel,$attr,$selection='',$style='') { // build admin view
	global $dbobj,$tplobj,$radio;
	$tpl_ckk = '<label for="rights_#KEY#_#ATTR#" #STYLE#>#TITEL#</label>';
	if (!empty($selection))	{
		$v['selection'] = '<option value="alles"  |SEL_alles| |'.strtoupper($attr).'_alles| >--- %%ALLES%% ---</option>'.$selection;
		$tpl_ckk .='<select class="checkbox" name="rights[#KEY#][#ATTR#][]" multiple="multiple" size="5" id="rights_#KEY#_#ATTR#">#SELECTION#</select>';
	} else {
		$tpl_ckk .= '<input type="checkbox" class="checkbox" name="rights[#KEY#][#ATTR#][]"	id="rights_#KEY#_#ATTR#"|CHK_#ATTR#| value="1" />';
		if (!empty($radio)) $tpl_ckk .= '<input type="radio"	class="checkbox" name="rights[#KEY#][firstplugin][]"							   value="#ATTR#" />';
	}
	$v['titel'] = &$titel;
	$v['key']   = &$key;
	$v['attr']  = &$attr;
	$v['style'] = &$style;
	$out[$v['attr']] = $tplobj->array2tpl($tpl_ckk,$v,'#');
	return $out;
}
function save_rights($data=false) { // save rights
	global $dbobj;
	if ($data===false && !empty($_REQUEST['rights']))	$data=$_REQUEST['rights'];
	if ($data) {
		foreach ($data as $uid => $data) {
			if (is_numeric($uid))	$sqls[] = "DELETE FROM #PREFIX#seiten_personen WHERE person_ID = ".$uid." ;";
			foreach ($data as $attr => $n) {
				foreach ($n as $attr_ID) {
					if (!empty($attr_ID))	$sqls[] = 'INSERT INTO #PREFIX#seiten_personen (person_ID,attr,attr_ID) VALUES ("'.$uid.'","'.$attr.'","'.$attr_ID.'");';
		}	}	}
		if (!empty($sqls[0])) $dbobj->multiquery(__file__,__line__,$sqls);
	}
	set_rights();
}
function set_user_verification($key,$verified,$tpls) {
	global $dbobj,$tplobj,$vorgaben,$status_array;
	$out = $tpls['status_verification'];
	if (!empty($verified))	$out = str_replace('#VERIFIED#','checked="checked"',$out);
	else					$out = str_remove($out,'#VERIFIED#');
	return str_replace('|ID|',$key,$out);
}
function set_user_status($key,$data,$tpls,$rights) {
	global $dbobj,$tplobj,$vorgaben,$status_array;
	$out = '';
	if (!isset($data['status']) || !is_numeric($data['status']))	$data['status'] = 0;
	if ($rights && $data['status'] >= 88) {
		$out .= $tpls['status_ki'];
		if (!empty($data['kontakt']))	$out = str_replace('#EMAIL#','checked="checked"',$out);
		else							$out = str_remove($out,'#EMAIL#');
		if (!empty($data['impressum']))	$out = str_replace('#IMPRESSUM#','checked="checked"',$out);
		else							$out = str_remove($out,'#IMPRESSUM#');
	}
	foreach (status_array() as $status_id => $status) {
		$status_tmp = str_replace('#KEY#',$status,$tpls['status']);
		if ($data['status'] == $status_id) 	$status_tmp = str_replace('#CHK_VALUE#','checked="checked"',$status_tmp);
		$status_tmp = str_replace('#VALUE#',$status_id,$status_tmp);
		$out .= $status_tmp;
		unset($status_tmp);
	}
	if (!empty($data['sessionID']) && $key != $_SESSION['uid'])	$out .= $tpls['status_logout'];
	return str_replace('|ID|',$key,$out);
}
function sel_status($selected='',$rights=true) {
	return sel_array(status_array($rights),$selected,'status');
}
function status_array($rights=true,$cache=true) {
	global $status_array;
	if (is_numeric($rights))	$pos_lt = $rights+1;
	elseif (!$rights) 			$pos_lt = 88;
	else		 				$pos_lt = 100;
	if (!$cache || !empty($status_array) || $status_array = get_vorlage(array('PAGE_ID'=>'status_seite','pos_lt'=>$pos_lt,'bypos'=>true))) {
		return $status_array;
	} else {
		$s[0] = 'Gesperrt'; 
		$s[1] = 'Gast';
		$s[88] = 'Editor'; 
		$s[99] = 'Admin';
		return $s;
	}
}
function writemail($tpls) {
	global $tplobj,$vorgaben;
	add_fck();
	if ($mails = get_mails()) {
		$mail_out = str_replace('|MAILS|',implode(',',array_keys($mails)),$tpls['mail']);
		if (!empty($vorgaben['email_seite'])) {
			$mailtext = get_page(array('PAGE_ID'=>$vorgaben['email_seite'],'visibility'=>'0,1'));
			$tplobj->array2tpl2($mail_out,$mailtext[0],'#');
		} elseif (!isset($_REQUEST)) {
			$tplobj->array2tpl2($mail_out,$_REQUEST,'#');
		}
		return str_replace('|ANZ|',count($mails),$mail_out);
}	}
function listmail($tpls) {
	global $dbobj,$vorgaben;
	if ($mails = get_mails()) {
		return str_replace(array('|MAILS|','|ANZ|'),array(implode(', ',$mails),count($mails)),$tpls['list']);
}	}
function get_mails() {
	global $error,$dbobj;
	if (!empty($_REQUEST['mails']))			$mails = $_REQUEST['mails'];
	if (!empty($mails) && !is_array($mails))$mails = explode(",",$mails);
	if (!empty($mails) && is_array($mails)) {
		$sql  = 'SELECT ID,CONCAT("\"",Name,"\" <",Email, ">") AS addr FROM #PREFIX#person WHERE Email != "" AND ID IN ('.implode(',',$mails).')';
		if ($mail_db = $dbobj->withkey(__file__,__line__,$sql)) {
			foreach ($mail_db as $key => $mail)	$out_mails[$key] = $mail['addr'];
			return $out_mails;
	}	} else {
		$error[]= '%%KEIN_EMPFAENGER_GEWAEHLT%%';
		return false;
}	}
function save_passwort($data=false) {
	global $error,$dbobj;
	if (!empty($_REQUEST['passwort_neu2']) && $_REQUEST['passwort_neu1'] == $_REQUEST['passwort_neu2']) {
#		if (!preg_match("/^[A-ZßÀ-Öø-ÿ0-9\.\,\:\;\-\_\!]{6,64}$/Ui" ,$_REQUEST['passwort_neu2'])) {
#			$error['fehler'] = '%%PASSWORTZEICHENFEHLER%%';
#		} else {
			$dbobj->singlequery(__file__,__line__,"UPDATE #PREFIX#person SET Passwort = '".do_password($_REQUEST['passwort_neu2'])."' WHERE ID = ".uid());
			$error['info'] = '%%PASSWORTGESPEICHERT%%';
#		}
	}
	else	$error['info'] = '%%PASSWORTGLEICHEIT%%';
}
function save_person($data=false) {
	global $error,$dbobj,$vorgaben;
	if (!empty($_REQUEST['person']['remove']) && ($_SESSION['status'] == 'Admin' || !empty($_SESSION['permissions']['kunden']) || !empty($_SESSION['permissions']['benutzer']))) {
		foreach ($_REQUEST['person']['remove'] as $key) {
			if (is_numeric($key)) {
				$sql_a[] = "DELETE FROM #PREFIX#person WHERE ID = ".$key.";";
				if (!empty($vorgaben['deluserpages'])) {
					$sql_a[] = "DELETE FROM #PREFIX#seiten,#PREFIX#seiten_attr WHERE #PREFIX#seiten.page_ID = #PREFIX#seiten_attr.page_ID AND #PREFIX#seiten_attr.person_ID = ".$key.";";
					if($remove = $dbobj->tostring(__file__,__line__,"SELECT PAGE_ID FROM #PREFIX#seiten_attr WHERE person_ID = ".$key.";")) {
						save_page::remove_page($remove);
				}	}
				$error['remove'] = '%%PERSONENDATEN_WURDEN_GELOESCHT%%';
				$_REQUEST['ID']='neu';
		}	}
		if (!empty($sql_a) && is_array($sql_a)) $dbobj->multiquery(__file__,__line__,$sql_a);
	}
	elseif (!empty($_REQUEST['person']['Name'])) {
		if (!empty($_REQUEST['uid']) && is_numeric($_REQUEST['uid'])) {
			$uid = uid();
			if ($dbobj->exists(__file__,__line__,"SELECT ID FROM #PREFIX#person WHERE ID = ".$uid.";")) {
				$p = $_REQUEST['person'];
				unset($p['status']);
				$dbobj->array2db(__file__,__line__,$p,'#PREFIX#person','UPDATE','WHERE ID = '.$uid);
				if (!empty($_REQUEST['person']['Login']) && $uid == $_SESSION['uid']) // changes login name (shouldn't cause logout)
					$_SESSION['login'] = $_REQUEST['person']['Login'];
				$_REQUEST['person']['id'][0] = $uid;
		}	} else {
			$_REQUEST['person']['ID'] = $dbobj->next_free_id('person');
			$dbobj->array2db(__file__,__line__,$_REQUEST['person'],'#PREFIX#person');
			$uid = $_REQUEST['person']['ID'];
			$_REQUEST['uid'] = $uid;
			$_REQUEST['ID']  = $uid;
			$_REQUEST['person']['id'][] = $uid;
			$dbobj->singlequery(__file__,__line__,"UPDATE #PREFIX#person SET status = '".$_REQUEST['person']['status']['neu']."' WHERE ID = '".$uid."'");
			$error['info'] = '%%DATEN_WURDEN_GESPEICHERT%%';
			$cache['truncate']	= true;
	}	}
	if (!empty($_REQUEST['person']['id']) && !empty($_SESSION['status']) && !is_numeric($_SESSION['status'])) {
		foreach ($_REQUEST['person']['id'] as $id) {
			if (isset($_REQUEST['person']['status'][$id])) {
				$person['status'] = $_REQUEST['person']['status'][$id];
				if ($exists = $dbobj->exists(__file__,__line__,'SELECT status,Name,Email,Passwort FROM #PREFIX#person WHERE ID = '.$id.';')) {
					if ($person['status'] != $exists[0]['status']) {
						if (empty($exists[0]['Passwort']) && $person['status'] != 0) {
							$exists[0]['Passwort'] = Random_Password(8);
							$person['Passwort'] = do_password($exists[0]['Passwort']);
						} else {
							unset($exists[0]['Passwort']);
						}
						$error['info'] = statusmeldung($person,$exists[0]);
			}	}	}
			if ($_SESSION['status']=='Admin') {
				if (!empty($_REQUEST['person']['kontakt'][$id])) $person['kontakt'] = 1;
				else											 $person['kontakt'] = 0;
				if (isset($_REQUEST['person']['verified'][$id]))$person['verified'] = $_REQUEST['person']['verified'][$id] ;
#				else											 $person['verified'] = 0;
				if (!empty($_REQUEST['person']['impressum']) && $_REQUEST['person']['impressum'] == $id) {
					$dbobj->singlequery(__file__,__line__,"UPDATE #PREFIX#person SET impressum = IF(ID=".$id.",1,0);");
			}	}
			if (!empty($person)) $dbobj->array2db(__file__,__line__,$person,'#PREFIX#person','UPDATE',"WHERE ID = ".$id);
		}
		$error['info'] = '%%DATEN_WURDEN_GESPEICHERT%%';
		$cache['truncate'] = true;
	}
	if (!empty($_REQUEST['person']['logout']) && ($_SESSION['status'] == 'Admin' || !empty($_SESSION['permissions']['kunden']) || !empty($_SESSION['permissions']['benutzer']))) {
		foreach ($_REQUEST['person']['logout'] as $key) {
			if (is_numeric($key) && $key != $_SESSION['uid']) {
				$sql_a[] = "UPDATE #PREFIX#person SET sessionID = '' WHERE ID = ".$key.";";
			} else $error[] = '%%LOGOUT_IM_MENUE%%';
		}
		if (!empty($sql_a) && is_array($sql_a)) $dbobj->multiquery(__file__,__line__,$sql_a);
	}
	if (!empty($cache)) cache::clean($cache);
}
function release_pages() {
	global $dbobj,$vorgaben;
	if (is_numeric(str_remove(implode(',',$_REQUEST['release'])))) {
		$sql = "DELETE FROM #PREFIX#_inuse WHERE attr_ID IN (".implode(',',$_REQUEST['release']).");";
		$dbobj->singlequery(__file__,__line__,$sql);
}	}
function statusmeldung($person,$data) { // send emails to people whos status has changed
	global $tplobj,$dbobj,$lang,$sub_tpl,$vorgaben;
	if (isset($data['status']))		$data['status_alt'] = get_daten(array('PAGE_ID'=>'status_seite','id'=>$data['status'],  'key'=>'bypos'));
	if (isset($person['status']))	$data['status_neu'] = get_daten(array('PAGE_ID'=>'status_seite','id'=>$person['status'],'key'=>'bypos'));
	if (!empty($vorgaben['gesperrt_seite']) && !empty($vorgaben['freigabe_seite'])) {
		switch ($person['status']) {
			case 0:		$msg = get_page(array('PAGE_ID'=>$vorgaben['gesperrt_seite'],'visibility'=>'1,0','status'=>'any','errors'=>false));	break;
			default:	$msg = get_page(array('PAGE_ID'=>$vorgaben['freigabe_seite'],'visibility'=>'1,0','status'=>'any','errors'=>false));	break;
		#	default:	$msg = get_page(array('PAGE_ID'=>$vorgaben['statusaenderung_seite'],'visibility'=>'1,0','status'=>'any','errors'=>false));	break;
		}
		if (!empty($data['Passwort'])) {
			if (empty($sub_tpl['pass']))	$sub_tpl['pass'] = gt('%%PASSWORT%%').': ';
			$data['Passwort'] = $sub_tpl['pass'].$data['Passwort'];
		}
		$to[0]['Email']= &$data['Email'];
		$to[0]['Name'] = &$data['Name'];
		$tplobj->array2tpl2($msg['Text'],$data,'#');
		$body = mailfooter($msg['Text']);
		mail_send(array('subject'=>$msg['Titel'],'body'=>$body,'to'=>$to));
		if (!empty($sub_tpl['copyprefix'])) $msg['Titel'] = $sub_tpl['copyprefix'].' '.$msg['Titel'];
		else								$msg['Titel'] = 'COPY: '.$msg['Titel'];
		mail_send(array('subject'=>$msg['Titel'],'body'=>$body,'from'=>$to));
}	}
function persons($first='',$selected=true,$p_out='',$rem=true,$tpl='<option value="|PERSON_ID|" |PERSON_|PERSON_ID||>|NAME| |NACHNAME|</option>') {
	global $tplobj,$dbobj,$lang,$p_intern;
	if (empty($p_intern) || !$rem) {
		$sql = "SELECT	#PREFIX#person.Name,#PREFIX#person.ID as person_ID FROM	#PREFIX#person ORDER BY status ";
		$p_intern = '';
		if ($ps = $dbobj->exists(__file__,__line__,$sql)) {
			foreach ($ps as $id => $p) {
				$p['Name'] = my_htmlentities($p['Name']);
				$p_intern .= "\n".$tplobj->array2tpl($tpl,$p);
	}	}	}
	if (!empty($selected) && is_numeric($selected)) 		$p_out = str_replace('|PERSON_'.$selected.'|','selected="selected"',$p_intern);
	elseif (strpos($selected,',')!==false) {
		$sels = explode(',',$selected); $p_out = $p_intern;
		foreach ($sels as $sel)								$p_out = str_replace('|PERSON_'.$sel.'|','selected="selected"',$p_out);
	} elseif (!empty($_REQUEST['person_ID']) && $selected)	$p_out = str_replace('|PERSON_'.$_REQUEST['PERSON_ID'].'|','selected="selected"',$p_intern);
	else													$p_out = $p_intern;
	if (!empty($first)) {
		$p_out = $tplobj->array2tpl($tpl,array('ID' => '','name' => $first)).$p_out;
	}
	$p_out = str_remove($p_out,'PERSON_ID||');
	return $p_out;
}
?>