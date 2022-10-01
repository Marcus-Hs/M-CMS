<?php
if (empty($_SESSION['logged']) && is_file('../../intern/php/zugangsdaten.php')) {
	if (function_exists('date_default_timezone_set')) date_default_timezone_set('Europe/Berlin');
	require_once('../../intern/php/zugangsdaten.php');
	my_include('intern/php/module/');
	$session = new session();
}

/*************************************************************************************************/
//create session
if (!empty($_POST['login']) && $_POST['login'] == 'login' && !empty($_POST['username']) && !empty($_POST['password'])){
	$_SESSION = array();
	$_SESSION['username']=$_POST['username'];
	$_SESSION['password']=$_POST['password'];
}

if (!empty($_GET['logout']) && $_GET['logout'] == "logout"){
	setcookie('url_field', '', time()-3600);
	setcookie('current_folder', '', time()-3600);
#	$_SESSION = array();
#	session_destroy();
#	session_unset();
	header("Location: file_manager.php?logout");
}
if (!empty($_SESSION['logged']))  {
	$user_login = 'ok';
} elseif(!empty($_SESSION['username']) && $_SESSION['username'] && $_SESSION['password']) {
	$sql = "SELECT person.Login,person.ID,person.status,person.Name, GROUP_CONCAT(online.Name) AS online FROM person LEFT JOIN (person AS online) ON (online.sessionID != '' AND online.ID != person.ID)
			 WHERE person.Login = '".$_SESSION['username']."'
			   AND person.Passwort = '".sha1($_SESSION['password'])."'
		  GROUP BY person.ID;";
	if ($dbobj->exists(__file__,__line__,$sql)) {
		$user_login = 'ok';
	} else {
		$error_message = "Incorect username or password!";
}	}
?>