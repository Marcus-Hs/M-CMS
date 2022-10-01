<?php
$only_below = 1; // 0=you can brows all server; 1=you can brows only the $initial_folder and below

/***********************************/
// Protect against GLOBALS tricks
if (isset($_POST['GLOBALS']) || isset($_FILES['GLOBALS']) || isset($_GET['GLOBALS']) || isset($_COOKIE['GLOBALS'])){
	die("Hacking attempt");
}
if (isset($_SESSION) && !is_array($_SESSION)){
	die("Hacking attempt");
}
if (ini_get('register_globals') == '1' || strtolower(ini_get('register_globals')) == 'on'){
	$not_unset = array('_GET', '_POST', '_COOKIE', 'HTTP_SERVER_VARS', '_SESSION', 'HTTP_ENV_VARS', '_FILES');
	if (!isset($_SESSION) || !is_array($_SESSION)){
		$_SESSION = array();
	}
	$input = array_merge($_GET, $_POST, $_COOKIE, $HTTP_SERVER_VARS, $_SESSION, $HTTP_ENV_VARS, $_FILES);
	unset($input['input']);
	unset($input['not_unset']);
	while (list($var,) = each($input)){
		if (in_array($var, $not_unset)){
			die('Hacking attempt!');
		}
		unset($$var);
	}
	unset($input);
}
#if( !get_magic_quotes_gpc() ){
	if( is_array($_GET) ){
		foreach($_GET as $k => $v) {
			if( is_array($_GET[$k]) ) {
				while( list($k2, $v2) = each($_GET[$k]) ){
					$_GET[$k][$k2] = addslashes($v2);
				}
				reset($_GET[$k]);
			} else {
				$_GET[$k] = addslashes($v);
		}	}
		reset($_GET);
	}
	if( is_array($_POST) ){
		foreach($_POST as $k => $v) {
			if( is_array($_POST[$k]) )	{
				while( list($k2, $v2) = each($_POST[$k]) ){
					$_POST[$k][$k2] = addslashes($v2);
				}
				reset($_POST[$k]);
			} else {
				$_POST[$k] = addslashes($v);
		}	}
		reset($_POST);
	}
	if( is_array($_COOKIE) ){
		foreach($_COOKIE as $k => $v) {
			if( is_array($_COOKIE[$k]) ){
				while( list($k2, $v2) = each($_COOKIE[$k]) ){
					$_COOKIE[$k][$k2] = addslashes($v2);
				}
				reset($_COOKIE[$k]);
			} else {
				$_COOKIE[$k] = addslashes($v);
		}	}
		reset($_COOKIE);
}	#}
//END Protect against GLOBALS tricks
/***********************************/
?>