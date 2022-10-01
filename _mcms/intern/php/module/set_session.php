<?php
function prepare_set_session() {
	global $external_functions;
	$external_functions['mod_session.php'] = 'mod_session';
	$external_functions['set_user_availability.php'] = 'set_user_availability';
}
function get_user_availability() {
	if	(isset($_REQUEST['uid']) && is_numeric(str_remove($_REQUEST['uid'])))	$uid = $_REQUEST['uid'];
	return read_settings(array('is_online'),$uid);
}
function set_user_availability($status=0) {
	global $dbobj;
	if(isset($_REQUEST['status']) && is_numeric($_REQUEST['status']))	$status = $_REQUEST['status'];
	if ($uid = uid() && isset($status))	{
		$insert = array('person_ID'=>$uid,'content_value'=>$status,'content_name'=>'is_online');
		$dbobj->array2db(__file__,__line__,$insert,'#PREFIX#person__settings','INSERT INTO','WHERE person_ID= '.uid().' AND content_name = "is_online"');
		return json_encode($insert);
	}
	return false;
}
function mod_session() {
	test_session();
	if (!empty($_SESSION['status']) && !is_numeric($_SESSION['status'])) {
		if (!empty($_REQUEST['field']) && $_REQUEST['field'] == 'addstyles')	{
			if (strpos($_REQUEST['id'],'.')===false) $_REQUEST['id'] = '#'.$_REQUEST['id'];
			if ($_REQUEST['display'] != '')		$_SESSION['addstyles'][$_REQUEST['id']]['display'] = $_REQUEST['display'];
			$_SESSION['addstyles'][$_REQUEST['id']]['show'] = $_REQUEST['show'];
		}
		else unset($_SESSION['addstyles'][$_REQUEST['id']]);
	}
	return true;
}
function userlogout($logout=true) {
	set_session($logout);
}
function test_session($set=false) {
	global $vorgaben,$path_in;
	if ($set || $vorgaben['admin'] || !empty($_REQUEST['set_session']) || !empty($_SESSION['PHPSESSID']) || !empty($_REQUEST['PHPSESSID']) || !empty($_COOKIE['PHPSESSID'])) {
		set_session();
	}
	if ($set && !empty($_SESSION['PHPSESSID']))	return $_SESSION['PHPSESSID'];
}
function set_session($logout=false) {
	global $vorgaben,$sub_tpl;
#	if (is_dir($vorgaben['grp__cms'].'../tmp'))	session_save_path($vorgaben['grp__cms'].'../tmp');
#	elseif (is_dir($vorgaben['base_cms'].'../tmp'))	session_save_path($vorgaben['base_cms'].'../tmp');
#	if (!is_writable(session_save_path())) {
#		die('Session path "'.session_save_path().'" is not writable for PHP!');
#	}
	$maxlifetime = 7200;
	$secure = true; // if you only want to receive the cookie over HTTPS
	$httponly = true; // prevent JavaScript access to session cookie
	$samesite = 'lax';

	if(PHP_VERSION_ID < 70300) {
		session_set_cookie_params($maxlifetime, '/; samesite='.$samesite, $_SERVER['HTTP_HOST'], $secure, $httponly);
	} elseif (!session_id()) {
		session_set_cookie_params([
			'lifetime' => $maxlifetime,
			'path' => '/',
			'domain' => $_SERVER['HTTP_HOST'],
			'secure' => $secure,
			'httponly' => $httponly,
			'samesite' => $samesite
		]);
	}
	$session = new session($logout);													// session handling
#	if (empty($_SESSION['PHPSESSID'])) {
		session_start();
		if (!preg_match("/^[0-9a-z]*$/i", session_id())) {	// Catch bogus session-id's.
			 trigger_error("Trouble with Session.");	// Output a warning about the messed up session-id.
			 session_regenerate_id();						// Generate a fresh session-id.
		}
		$_SESSION['PHPSESSID'] = session_id();
#	}
	if (!empty($_REQUEST['set_session'])   && is_string($_REQUEST['set_session']))
		$_SESSION['set_session'][$_REQUEST['set_session']] = 1;
	if (!empty($_REQUEST['unset_session']) && is_string($_REQUEST['unset_session']))
		unset($_SESSION['set_session'][$_REQUEST['unset_session']]);
	if (!empty($_SESSION['set_session'])) {
		foreach ($_SESSION['set_session'] as $k => $v)	$_REQUEST[$k] = 1;
	}
}
function finalize_session($main_tpl='') {
	global $vorgaben,$sub_tpl;
	$sub_tpl['sid'] = '';
	$sub_tpl['phpsessid'] = '';
	if (!empty($_SESSION['PHPSESSID']) || !empty($_COOKIE['PHPSESSID'])) {
		$sub_tpl['phpsessid2']	= '<input type="hidden" name="PHPSESSID" id="PHPSESSID" value="'.session_id().'" />';
		$sub_tpl['sid2']	= '&PHPSESSID='.session_id();
		if (empty($_COOKIE['PHPSESSID'])) {
			$sub_tpl['phpsessid'] = str_remove($sub_tpl['phpsessid2'],' id="PHPSESSID"');
			$sub_tpl['sid']		  = &$sub_tpl['sid2'];
}	}	}
function session_started(){
	if(!empty($_SESSION['logged']) && $_SESSION['logged'])	return true;
	else													return false;
}
function sid() {
	global $sub_tpl;
	if (!empty($sub_tpl['sid']))		return $sub_tpl['sid'];
}
function phpsessid() {
	global $sub_tpl;
	if (!empty($sub_tpl['phpsessid']))	return $sub_tpl['phpsessid'];
}
function uid($id='uid') {
	if ((!empty($_SESSION['status']) && (!is_numeric($_SESSION['status']) || !empty($_SESSION['permissions']['kunden'])) && !empty($_REQUEST[$id]) && is_numeric($_REQUEST[$id])))	return $_REQUEST[$id];
	elseif (!empty($_SESSION[$id]) && is_numeric($_SESSION[$id]))															return $_SESSION[$id];
	elseif (!empty($_SESSION['uid']))																						return $_SESSION['uid'];
	else																													return false;
}
function strip_sid($data) {
	return str_replace(array('&amp;PHPSESSID='.session_id(),'&PHPSESSID='.session_id(),'<input type="hidden" name="PHPSESSID" value="'.session_id().'" />'),array('§SID§','§SID§','§PHPSESSID§'),$data);
}
function passwortvergessen($uid='') {
	global $dbobj,$tplobj,$error,$unterseite,$sub_tpl,$vorgaben;
	if (!empty($_REQUEST['zugang']) && (syntax::name($_REQUEST['zugang']) || syntax::email($_REQUEST['zugang']))) {
		if (!empty($uid))					$to = $dbobj->exists(__file__,__line__,"SELECT ID,Login,Name,Email FROM #PREFIX#person WHERE ID = '".$uid."';");
		elseif (!empty($_REQUEST['zugang']))$to = $dbobj->exists(__file__,__line__,"SELECT ID,Login,Name,Email FROM #PREFIX#person WHERE Login = '".$_REQUEST['zugang']."' OR Email = '".$_REQUEST['zugang']."' AND status > 0;");
		if (!empty($to[0]['ID'])) {
			if (empty($sub_tpl['emailbody']) && !empty($vorgaben['passwortvergessen_seite']))	get_vorlage(array('PAGE_ID'=>'passwortvergessen_seite','showanyway'=>true,'use_js'=>false,'use_css'=>false,'visibility'=>'0,1'));
			$to[0]['passwort'] = Random_Password(8);
			$dbobj->singlequery(__file__,__line__,"UPDATE #PREFIX#person SET Passwort = '".do_password($to[0]['passwort'])."' WHERE ID = ".$to[0]['ID']);
			if (empty($sub_tpl['emailbody']))	$sub_tpl['emailbody']= "Hallo #NAME#,\n\ndas neue Passwort lautet: #PASSWORT#";
			if (empty($sub_tpl['subject']))		$sub_tpl['subject']  = "Neues Passwort für ".domain();
			$body = mailfooter($tplobj->array2tpl($sub_tpl['emailbody'],$to[0],'#'));
			mail_send(array('subject'=>$sub_tpl['subject'],'body'=>$body,'to'=>$to));
			$error['info2'] = geterror(62);	# 'Ihre neuen Zugangsdaten sind verschickt worden.'
			unset($_REQUEST['zugang']);
		} else {
			$error['info'] = geterror(63);	# 'Zur angegebenen Email oder dem Benutzernamen konnten leider keine Zugangsdaten gefunden werden.'
}	}	}
class session {
	var $failed = false;	// failed login attempt
	var $date;				// current date GMT
	var $id = 0;			// the current user's id

	function __construct($lo=false) {
		global $error;
		if (!empty($_COOKIE['PHPSESSID']))		$sid = $_COOKIE['PHPSESSID'];
		elseif (!empty($_REQUEST['PHPSESSID']))	$sid = $_REQUEST['PHPSESSID'];
		elseif (!empty($_SESSION['PHPSESSID']))	$sid = $_SESSION['PHPSESSID'];
		if (!empty($sid) && $sid!='undefined' && $lo==false) {
			session_id($sid);
			$_SESSION['PHPSESSID'] = $sid;
		}
		if($lo==false)	session_start();
		if ($lo || !empty($_REQUEST['logout'])) $this->_logout(true);
		elseif ($this->user()) {
			if (!isset($_SESSION['logged']) ) {
				$this->session_defaults();						# es existiert keine Session -> Voreinstellungen setzen.
				if ((!empty($_POST['login']) && !empty($_POST['password'])) || !empty($vorgaben['logmein'])) {
					if($this->failed)	$this->login = false;	# Es wurde versucht sichmit den falschen Daten einzuloggen
					else 				$this->login = true;
				} else 					$this->login = false;	# Das ist der erste Aufruf der Seite
			} else {											# es existiert eine Session -> auf Gültigkeit püfen
				if($this->failed)		$this->login = false;	# $this->error = "Die Session ist nicht mehr Gültig, bitte neu Einlogggen"
				else					$this->login = true;
			}
			if (!empty($this->error)) $error['session'] = $this->error;
			if (!$this->login) $vorgaben['admin'] = false;
		}
		session_write_close();
	}
	function user() {
		global $vorgaben;
		$this->logindate = date("Y-m-d H:i:s");
		if (!empty($_POST['login']) || !empty($vorgaben['logmein']))		return $this->checkLogin();
		elseif (!empty($_SESSION['logged']) && $_SESSION['logged']==true)	return $this->_checkSession();
		else																return false;
	}
	function checkLogin() {
		global $vorgaben,$dbobj;
#		if (!$dbobj->table_exists(__file__,__line__,'#PREFIX#_session'))	import_tables('session_table.sql');
		if (!empty($vorgaben['logmein'])) {
			$login	= $vorgaben['logmein']['login'];
			$pwd	= $vorgaben['logmein']['password'];
		} else {
			$login	= $_POST['login'];
			$pwd	= $_POST['password'];
		}
		if (!empty($login) && is_string($login) && !empty($pwd) && is_string($pwd)) {
			$values = get_pwd_hash($login);
			if ($values && verify_password($values[0]['Passwort'],$values[0]['ID'],$pwd)) {
				unset($_POST['password'],$values[0]['Passwort']);
				get_vorlage(array('PAGE_ID'=>'status_seite','pos'=>$values[0]['status'],'visibility'=>'0,1'));
				switch ($values[0]['status']) {
					case 0:		$_REQUEST['msg_nr'] = 101;	$this->failed = true;	$this->_logout();		break;		# Nicht freigeschaltet.
					case 88:	$_SESSION['status'] = 'Editor';												break;		# Es handelt sich um einen Editor -> Session setzen.
					case 99:	if (!empty($values[0]['online'])) $this->error = '%%PERSONEN_ONLINE%%: '.$this->tostring(__file__,__line__,"SELECT DISTINCT #PREFIX#person.Name FROM #PREFIX#person,#PREFIX#_session WHERE #PREFIX#person.ID = #PREFIX#_session.ID AND #PREFIX#_session.sessionID != '' AND #PREFIX#person.Login != '".$values[0]['Login']."' AND #PREFIX#_session.logindate > DATE_ADD(NOW(), INTERVAL -2 DAY)");
								$_SESSION['status'] = 'Admin';												break;		# Es handelt sich um den Admin -> Session setzen.
					default:	$_SESSION['status'] = $values[0]['status'];	$_REQUEST['msg_nr'] = 103;		break;		# Es handelt sich um einen Kunden -> Session setzen.
				}
				$this->_setSession($values[0]);
				return true;
			} else {
				$_REQUEST['msg_nr'] = 102;	# 'Das hat nicht geklappt.'
		}	}
		$this->failed = true;				# Login Fehlgeschlagen oder ausgeloggt -> Session löschen.
		if (!empty($_REQUEST['msg_nr']))$vorgaben['redirect']['suffix']['msg_nr'] = $_REQUEST['msg_nr'];
		$this->_logout();
		unset($vorgaben['nohanddownmsgs']);
		return false;
	}
	function _checkSession() {
		global $dbobj;
		$sql = "SELECT	#PREFIX#person.*,#PREFIX#_session.sessionID
				FROM	#PREFIX#person,#PREFIX#_session
				WHERE	#PREFIX#_session.ID = '".$_SESSION['uid']."'
				AND 	#PREFIX#_session.ID = #PREFIX#person.ID
				AND		status > 0
				AND		#PREFIX#_session.sessionID = '".session_id()."'
				GROUP BY #PREFIX#person.ID;"; #				AND		#PREFIX#_session.IP = '".$_SERVER['REMOTE_ADDR']."'
		$values = $dbobj->exists(__file__,__line__,$sql);
		if ($values) {
			$this->_setSession($values[0], true);
			return true;
		} else {
			$this->_logout();
			return false;
		}
	}
	function _setSession($values, $init = true) {
		global $dbobj;
		$_SESSION['uid']	= $values['ID'];
		$_SESSION['login']	= $values['Login'];
		$_SESSION['name']	= $values['Name'];
		if (empty($_SESSION['pref_lang']) && !empty($values['LANG_ID']))	$_SESSION['pref_lang'] = $values['LANG_ID'];
		$_SESSION['logged'] = true;
		set_rights();
		if ($init) {
			$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#_session WHERE (ID = ".$_SESSION['uid']." OR sessionID = '".session_id()."')");
			$session = array('ID'=>$_SESSION['uid'],'sessionID'=>session_id(),'logindate'=>$this->logindate,'IP'=>$_SERVER['REMOTE_ADDR']);
			$dbobj->array2db(__file__,__line__,$session,'#PREFIX#_session','INSERT INTO');
		} elseif (empty($_COOKIE['PHPSESSID'])) {
			$prev_sess_id = session_id();
			session_regenerate_id();
			$dbobj->array2db(__file__,__line__,array('sessionID'=>session_id()),'#PREFIX#_session','UPDATE','WHERE ID = '.$values['ID'].' AND sessionID = "'.$prev_sess_id.'" AND IP = "'.$_SERVER['REMOTE_ADDR'].'"');
			$_SESSION['PHPSESSID'] = session_id();
			$_REQUEST['PHPSESSID'] = $_SESSION['PHPSESSID'];
	}	}
	function _logout() {
		$this->session_defaults(true);
	}
	function session_defaults($lo=false) {
		global $dbobj,$vorgaben;
		if (!empty($_SESSION['status']) && !empty($_SESSION['uid'])) {
			$_REQUEST['msg_nr'] = 100;
			if (is_numeric($_SESSION['status']))	get_vorlage(array('PAGE_ID'=>'status_seite','pos'=>$_SESSION['status'],'visibility'=>'0,1'));
			$sqls[] = "DELETE FROM #PREFIX#_session WHERE (ID = ".$_SESSION['uid']." OR sessionID = '".session_id()."') OR logindate < DATE_ADD(NOW(), INTERVAL -2 DAY) OR sessionID = '#PHPSESSID#' OR IP = '#REMOTE_ADDR#'";
			$sqls[] = "DELETE FROM #PREFIX#_inuse   WHERE person_ID = ".$_SESSION['uid'].";";
			$dbobj->multiquery(__file__,__line__,$sqls);
		}
		if (session_started() && $lo) {
			$_SESSION = array();																	// Löschen aller Session-Variablen.	Achtung: Damit wird die Session gelöscht, nicht nur die Session-Daten!
			if (isset($_COOKIE[session_name()]))	setcookie(session_name(),'',time()-42000,'/');	// Falls die Session gelöscht werden soll, löschen Sie auch das Session-Cookie.
			if (isset($_SESSION[session_name()]))	session_destroy();								// Zum Schluß, löschen der Session.
			$_SERVER['HTTP_REFERER'] = 'logout';
			$_REQUEST['msg_nr'] = 100;
			unset($_SESSION,$_COOKIE,$_REQUEST['PHPSESSID']);
			if (!empty($_REQUEST['msg_nr']))	$vorgaben['redirect']['suffix']['msg_nr'] = $_REQUEST['msg_nr'];
		}
		if (empty($_SESSION)) {
			$_SESSION['uid']	= 0;
			$_SESSION['login']	= '';
			$_SESSION['status'] = '';
			$_SESSION['logged'] = false;
		}
	#	unset(/*$_SESSION['msg_nr'],*/$_SESSION['warenkorb']);
}	}
function set_rights() {
	global $dbobj;
	if (!empty($_SESSION['status']) && $_SESSION['permissions'] = $dbobj->withkey(__file__,__line__,'SELECT attr,attr_ID FROM #PREFIX#person LEFT JOIN (#PREFIX#seiten_personen) ON (#PREFIX#person.ID = person_ID) WHERE #PREFIX#person.ID = '.uid().';','attr',false,true)) {
		switch ($_SESSION['status']) {
			case 'Admin':	$_SESSION['permissions']['admin'][0]['attr_ID']	= 1;	break;
			case 'Editor':	$_SESSION['permissions']['editor'][0]['attr_ID'] = 1;	break;
		#	case 'Gast':	$_SESSION['permissions']['gast'][0]['attr_ID']	= 1;	break;
		}
		#$_SESSION['permissions'] = array();
		if (!empty($_SESSION['permissions'])) {
			if (array_intersect(array('admin','mimg','bgimg','tpl','tpl2','kats','kats2','subp'),array_keys($_SESSION['permissions'])))	// Cross section for "Additional settings".
				$_SESSION['permissions']['wa'] = 1;									// if nescessary, option to show.
		}
		foreach ($_SESSION['permissions'] as $attr => $n) {
			if (is_array($n)) foreach ($n as $c => $d) 		$_SESSION['permissions'][$attr][$c] = $d['attr_ID'];
}	}	}
function get_pwd_hash($login=false) {
	global $dbobj;
	$sql = "SELECT * FROM #PREFIX#person";
	if ($login) {
		$sql .= " WHERE (#PREFIX#person.Login = '".$dbobj->escape($login)."' OR #PREFIX#person.Email = '".$dbobj->escape($login)."');";
	} else {
		$sql .= " WHERE (#PREFIX#person.ID = '".uid()."');";
	}
	return $dbobj->exists(__file__,__line__,$sql);	
}
function verify_password($pwd,$uid,$chk) {
	if (strpos($pwd,':1000')!==false)			$v = Password_Hash::verify($chk,$pwd);
	elseif ($pwd == simple_password($chk)) {	$v = true;	// found an old Password, thats OK.
		global $dbobj;										// But we're going to update.
		$dbobj->singlequery(__file__,__line__,"UPDATE #PREFIX#person SET Passwort = '".do_password($chk)."' WHERE ID = '".$uid."';");
#	} elseif ($pwd == $chk) {	$v = true;					// found unencoded Password, thats OK.
#		global $dbobj;										// But we're going to update.
#		$dbobj->singlequery(__file__,__line__,"UPDATE #PREFIX#person SET Passwort = '".do_password($chk)."' WHERE ID = '".$uid."';");
	} else										$v = false;	// Try again, sucker.
	return $v;
}
function do_password($password)		{return hash_password($password);}
function simple_password($password) {return sha1($password);}
function hash_password($password)	{return Password_Hash::generate($password);}
?>