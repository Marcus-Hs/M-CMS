<?php
function newsletter($data='') {
	global $dbobj,$tplobj,$error,$sub_tpl,$vorgaben;
	if (!empty($_REQUEST['kontakt']['newsletter']) && !empty($data['PAGE_ID'])) {
		if (!empty($_REQUEST['kontakt']['email'])) $_REQUEST['newsletter']['email'] = $_REQUEST['kontakt']['email'];
		$_REQUEST['submit']['newsletter']['ein'] = 1;
		get_vorlage(array('TPL_ID'=>$vorgaben['newsletter_tpl'],'set_sub_tpl'=>true));
		get_vorlage(array('TPL_ID'=>$vorgaben['nlemail_tpl']));
	}
	if ((!empty($_REQUEST['bestaetigung']) || !empty($_REQUEST['submit']))) {	# Prüfen, ob email eingetragen ist und das Formular gesendet wurde
		if (!empty($_REQUEST['whyout'])) {
			$txt = trim(r_implode("\n",$_REQUEST['whyout']));
			if (!empty($txt)) {
				if ($dbobj->table_exists(__FILE__,__LINE__,'#PREFIX#plugins__whyout')) {
					$dbobj->singlequery(__FILE__,__LINE__,"INSERT INTO #PREFIX#plugins__whyout SET reason = '".$dbobj->escape($txt)."'");
				}
				mail_send(array('subject'=>"Abmeldung Newsletter",'body'=>$txt));
				if (!empty($sub_tpl['nagthanks']))	$error['newsletter'] = &$sub_tpl['nagthanks'];
			} 														# 'Danke, Ihre Bestätigung ist registriert worden.';
		} elseif (!empty($_REQUEST['bestaetigung']) && $exists = $dbobj->exists(__FILE__,__LINE__,"SELECT Email,ID FROM #PREFIX#plugins__newsletter WHERE phrase='".$_REQUEST['bestaetigung']."'")) {
			$dbobj->singlequery(__FILE__,__LINE__,"UPDATE #PREFIX#plugins__newsletter SET status = 1 WHERE  ID = '".$exists[0]['ID']."'");
			$error['newsletter'] = &$sub_tpl['danke']; 														# 'Danke, Ihre Bestätigung ist registriert worden.';
		} elseif (!empty($_REQUEST['submit']['newsletter']) && !empty($_REQUEST['newsletter']['email']) && !daten_error('newsletter')) {	# Schauen, ob die email schon in der DB existiert
			$result = $dbobj->singlequery(__FILE__,__LINE__,"SELECT email,status FROM #PREFIX#plugins__newsletter WHERE Email='".$_REQUEST['newsletter']['email']."'");
			switch (key($_REQUEST['submit']['newsletter'])) {
				case 'ein':														# Wenn sie nicht existiert: Eintragen
					if (!isset($result[0]['email']) || empty($result[0]['status'])) {
						$set['phrase'] = md5($_SERVER['REMOTE_ADDR'].microtime());
						$set['Email']  = $dbobj->escape($_REQUEST['newsletter']['email']);
						if (!empty($_REQUEST['newsletter']['name']))	$set['name'] = $dbobj->escape($_REQUEST['newsletter']['name']);
						if (!empty($_REQUEST['newsletter']['extra']))	$set['extra']= $dbobj->escape($_REQUEST['newsletter']['extra']);
						$dbobj->array2db(__FILE__,__LINE__,$set,'#PREFIX#plugins__newsletter','INSERT INTO','WHERE Email = "'.$set['Email'].'"');
						newsletter_verify($set['phrase']);
					} else $error['newsletter'] = &$sub_tpl['schonvorhanden']; 	# 'Ihre Email-Adresse befindet sich bereits in unserem Verteiler.';
				break;
				case 'aus':														# Wenn sie existiert: Löschen
					if (!empty($result[0]['email'])) {
						$dbobj->singlequery(__FILE__,__LINE__,"DELETE FROM #PREFIX#plugins__newsletter WHERE Email ='".$_REQUEST['newsletter']['email']."'");
						$error['newsletter'] = $sub_tpl['geloescht']; 			# 'Ihre Email-Adresse wurde gelöscht';
						if (!empty($sub_tpl['nag'])) return $sub_tpl['nag'];
					} else $error['newsletter'] = &$sub_tpl['nichtgefunden']; 	# 'Ihre Email-Adresse konnte leider nicht gefunden werden.';
				break;
	}	}	}
	if (!empty($sub_tpl['form']))return $sub_tpl['form'];
}
function newsletter_save($user,$verimail=true) {
	global $dbobj,$vorgaben,$error,$sub_tpl;
	if (is_array($user)) {
		$user = array_change_key_case($user,CASE_LOWER);
		$exists = $dbobj->exists(__file__,__line__,"SELECT ID FROM #PREFIX#plugins__newsletter WHERE Email = '".$user['email']."';");
		if ($exists) {
			$user['news_chk'] = 'checked="checked"';
		}
		if ($exists && empty($_REQUEST['newsletter']) && !empty($_REQUEST['submit'])) {
			$dbobj->singlequery(__FILE__,__LINE__,"DELETE FROM #PREFIX#plugins__newsletter WHERE Email = '".$user['email']."';");
			$user['news_chk'] = '';
			if (!empty($sub_tpl['geloescht'])) $error['newsletter'] = $sub_tpl['geloescht']; 			# 'Ihre Email-Adresse wurde gelöscht';
		} elseif(!empty($_REQUEST['newsletter']['chk'])) {
			if ($verimail) {
				get_vorlage(array('TPL_ID'=>$vorgaben['newsletter_tpl'],'errors'=>false));
				$set['phrase'] = md5($_SERVER['REMOTE_ADDR'].microtime());
				newsletter_verify($set['phrase'],$user['email']);
			} else {
				$set['status'] = 1;
			}
			$set['Email'] = $dbobj->escape($user['email']);
			if (!empty($user['name']))		$set['Name'] = $dbobj->escape($user['name']);
			if (!empty($user['nachname']))	$set['Name'] .= ' '.$dbobj->escape($user['nachname']);
			if (!empty($user['extra']))		$set['extra'] = $dbobj->escape($user['extra']);
			$dbobj->array2db(__FILE__,__LINE__,$set,'#PREFIX#plugins__newsletter','INSERT INTO','WHERE Email = "'.$set['Email'].'"');
			$user['news_chk'] = 'checked="checked"';
		}
		return $user;
}	}
function chknl($data) {
	global $dbobj;
	if		(is_array($data) && !empty($data['KEY']) && !empty($data['FELD']) && !empty($_REQUEST[$data['KEY']][$data['FELD']]))	$data = $_REQUEST[$data['KEY']][$data['FELD']];
	elseif	(is_array($data) && !empty($data['KEY']) && !empty($_REQUEST[$data['KEY']]))											$data = $_REQUEST[$data['KEY']];
	if (is_string($data) && $exists = $dbobj->exists(__file__,__line__,"SELECT ID FROM #PREFIX#plugins__newsletter WHERE Email = '".$dbobj->escape($data)."';")) {
		return 'checked="checked"';
}	}
function newsletter_verify($phrase,$email='') {
	global $dbobj,$tplobj,$vorgaben,$error,$sub_tpl;
	if (!empty($sub_tpl['nl_betreff'])) {
		if (!empty($_REQUEST['newsletter']['email']))	$to[0]['Email'] = &$_REQUEST['newsletter']['email'];
		elseif (!empty($email))							$to[0]['Email'] = &$email;
		else											$to = '';
		parse($sub_tpl['nl_body']);
		$body['html'] = str_replace('#PHRASE#',$phrase,$sub_tpl['nl_body']);
		phpmail($sub_tpl['nl_betreff'],$body,$to);
		$error['newsletter'] = $sub_tpl['bestaetigung']; 	# 'Danke, Ihre Bestätigung ist registriert worden.';
}	}
?>