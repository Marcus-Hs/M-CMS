<?php
function login($redirect = '') {
	global $lang,$sub_tpl,$vorgaben,$login_function;
	if (empty($sub_tpl['logoutseite']))	get_vorlage(array('TPL_ID'=>$vorgaben['seiten_tpl'],'set_vg'=>false));
	if (!empty($sub_tpl['logoutseite']) && !empty($_SERVER['HTTP_REFERER']) && preg_match("/logout/i",$_SERVER['HTTP_REFERER'])) {
															$redirect = $sub_tpl['logoutseite'];
	} elseif (!empty($_SESSION['status']) && is_numeric($_SESSION['status'])) {						// Nach dem Einloggen
		if (!empty($login_function))						$login_function();
		if (!empty($sub_tpl['landeseite']))  				$redirect = $sub_tpl['landeseite'];		// Weiterleitung hierher (von Vorlage)
		elseif (!empty($vorgaben['redirect_seite']))		$redirect = $vorgaben['redirect_seite'];// oder hierhin (gemäß Vorgaben)
		elseif (!empty($vorgaben['kunden_seite']))			$redirect = $vorgaben['kunden_seite'];	// oder hierhin (gemäß Vorgaben)
		else												$redirect = $vorgaben['home']['PAGE_ID'];// sonst zur Startseite
	} elseif (isset($_SERVER['HTTP_REFERER'])
				&& url_protocol(domain('*')) != trim($_SERVER['HTTP_REFERER'],'/')
				&& !preg_match("/login.php/",$_SERVER['HTTP_REFERER'])
				&& !preg_match("/login/Ui",$_SERVER['HTTP_REFERER'])
				&& !preg_match("/logout/Ui",$_SERVER['HTTP_REFERER'])) {
		if (strpos($_SERVER['HTTP_REFERER'],'?')!==false) 	$redirect = startstr($_SERVER['HTTP_REFERER'],'?');
		elseif(strpos($_SERVER['HTTP_REFERER'],'&')!==false)$redirect = startstr($_SERVER['HTTP_REFERER'],'&');
		else												$redirect = &$_SERVER['HTTP_REFERER'];
	}
#	elseif (!empty($_SESSION['paths']['now']))				$redirect = &$_SESSION['paths']['now'];	 // Umleitung zur aktuellen Seite
#	elseif (!empty($_SESSION['paths']['last']))				$redirect = &$_SESSION['paths']['last']; // Umleitung zur letzten Seite
	elseif (empty($redirect) && !empty($vorgaben['home']))	$redirect = $vorgaben['home']['PAGE_ID'];// und wenn alles nichts hilft zur Startseites
	header_location($redirect);
}
function logout($lo=false,$silent=false) {
	global $vorgaben,$sub_tpl,$page_id,$plugin_functions;
	if ($lo) {
		if (!empty($plugin_functions['logout'])) {
			foreach ($plugin_functions['logout'] as $lofct) $lofct();
		}
		$session = new session($lo);
	}
	if (!$silent) {
		if (!empty($_REQUEST['msg_nr']) && ($_REQUEST['msg_nr'] == 101 || $_REQUEST['msg_nr'] == 102))	$r = $vorgaben['logout_seite'];
		elseif (!empty($sub_tpl['logoutseite']))														$r = $sub_tpl['logoutseite'];
		elseif (!empty($vorgaben['logout_seite']) && $vorgaben['logout_seite'] != $page_id)				$r = $vorgaben['logout_seite'];
		if (empty($r))																					$r = 'Login'.formget(array('get'=>'page'));
		header_location($r,0,'https');
}	}
function redirect($data) {
	if (is_string($data))	$data = url_protocol($data,0,true,false);
	header_location($data);
}
function header_location($redirect,$header_response=0,$protocol=true,$lt=true) {
	global $vorgaben,$lang_id;
	if($redirect=='Login')	return login_fallback();
	if ($lt)				$redirect = linkto(array('PAGE_ID'=>$redirect,'SET'=>'absolute','LANG_ID'=>$lang_id,'protocol'=>$protocol,'nosid'=>true));
	if(strpos($redirect,'/')!==0 && strpos($redirect,'http')!==0) $redirect = '/'.$redirect;
	if (!empty($redirect) && $redirect != url_protocol(domain('*'),$protocol).$_SERVER['REQUEST_URI']) {
		switch ($header_response) {
		#	case 301:	$_REQUEST['msg_nr'] = 301;	break;
			case 404:	$_REQUEST['msg_nr'] = 404;	break;
		}
		if ((empty($header_response) || is_numeric($header_response))) {
			if (!empty($_REQUEST['PHPSESSID']))					$vorgaben['redirect']['suffix']['PHPSESSID'] = $_REQUEST['PHPSESSID'];
			if (empty($vorgaben['redirect']['suffix']['PHPSESSID']) && !empty($_SESSION['status']) && empty($_COOKIE['PHPSESSID']))	$vorgaben['redirect']['suffix']['PHPSESSID'] = session_id();
			if (empty($vorgaben['nohanddownmsgs'])) {
				if (!empty($_REQUEST['msg_nr'])) 																					$vorgaben['redirect']['suffix']['msg_nr'] = $_REQUEST['msg_nr'];
				elseif (!empty($_SESSION['msg_nr'])) {
					$vorgaben['redirect']['suffix']['msg_nr'] = $_SESSION['msg_nr'];
					unset($_SESSION['msg_nr']);
			}	}
			if (!empty($vorgaben['redirect']['suffix'])) 		$redirect .= '?'.key_implode($vorgaben['redirect']['suffix'],'=','','&');
			if (!empty($redirect) && url_protocol(domain('*'),$protocol).$_SERVER['REQUEST_URI'] != $redirect)	header("Location: ".$redirect);
		#	return final_output(main_tpl('',$_SERVER['REQUEST_URI'].'<br />redirect: <a href="'.$redirect.'">'.$redirect.'</a><br /><br />|ERROR|',true));
		#   echo('<pre>') ;print_r($_SERVER); print_r($_SESSION) ; print_r($_COOKIE) ; print_r($REQUEST) ; echo('</pre>') ; die('<br />redirect: <a href="'.$redirect.'">'.$redirect.'</a>') ;
}	}	}
function login_fallback() {
	global $tplobj;
	$tpl = '<form action="/login.php" method="post">
	<p><label for="benutzername">Login:</label>
	<input value="|BENUTZERNAME|" type="text" name="login" id="login" /><br />
	<label for="passwort">Passwort:</label>
	<input value="" type="password" name="password" id="password" /></p>
	<p><input type="submit" class="btn next" value="Log in" /></p>
</form>';
	return final_output(main_tpl('',$tplobj->read_tpls($tpl)));
}
?>