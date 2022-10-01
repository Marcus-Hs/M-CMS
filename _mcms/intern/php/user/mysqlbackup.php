<?php
function prepare_mysqlbackup() {
	global $dbobj,$external_functions;
	$external_functions['mysqlbackup.php']= 'mysqlbackup';
}
function mysqlbackup() {
	global $dbob,$sub_tpl,$vorgaben;
	$realm = 'Restricted area';
	$vorgaben['stats'] = 0;
	if (!empty($vorgaben['https_domain']))	$www = $vorgaben['https_domain'];		// Check for https-domain
	else									$www = $sub_tpl['www'];
	$u = md5(str_replace(array('.','www','-'),'',$sub_tpl['www']));
	$users = array(md5(date('dmYH')) => $u);
	if (!empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION']))	$x = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
	elseif (!empty($_SERVER['HTTP_AUTHORIZATION'])) 		$x = $_SERVER['HTTP_AUTHORIZATION'];
	if (!empty($x) && preg_match('/Basic\s+(.*)$/i', $x, $matches)) {
		list($name, $password) = explode(':', base64_decode($matches[1]));
		$_SERVER['PHP_AUTH_USER'] = strip_tags($name);
		$_SERVER['PHP_AUTH_PW'] = strip_tags($password);
	}
	if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['HTTPS']) /* || $_SERVER['HTTP_USER_AGENT']!='Calling Home'*/) {
		header('HTTP/1.0 401 Unauthorized');
		header('WWW-Authenticate: Basic realm="'.$realm.'"');
		die('Bye');
	} else {
		if (!empty($users[$_SERVER['PHP_AUTH_USER']]) && $users[$_SERVER['PHP_AUTH_USER']] == $_SERVER['PHP_AUTH_PW']) {	// ok, valid username & password - > go on
			my_include('intern/php/admin/','admin_sql.php');
			$_REQUEST['d'] = 'intern/sql/';
			$_REQUEST['f'] = backup_tables('*','','','','return');
			return provide_downloads(true);
		}
		else die('Bye');
}	}
?>