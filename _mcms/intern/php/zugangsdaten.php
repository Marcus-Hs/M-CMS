<?php
$root = $_SERVER['DOCUMENT_ROOT'];
if (is_file($root.'/intern/php/zugangsdaten.php'))	require_once($root.'/intern/php/zugangsdaten.php');
else {
	if (!empty($_SERVER['HTTP_REFERER']) && (strpos($_SERVER['HTTP_REFERER'],'index.php')!==false || strpos($_SERVER['HTTP_REFERER'],'login.php')!==false)) {
		$tmp = explode('.php',str_replace(array('http://'.$_SERVER['SERVER_NAME'],'index','login'),'',$_SERVER['HTTP_REFERER']),2);
		if (!empty($tmp[0])) 								$root = str_replace('%20',' ',trim($_SERVER['DOCUMENT_ROOT'].$tmp[0],'/'));
	} elseif (!empty($_SERVER['PHP_SELF'])) {
		if (strpos($_SERVER['PHP_SELF'],'admin')!==false)	$tmp = explode('admin',$_SERVER['PHP_SELF'],2);
		elseif (strpos($_SERVER['PHP_SELF'],'.php')!==false)$tmp = explode('.php',str_replace(array('index','login'),'',$_SERVER['PHP_SELF']),2);
		if (!empty($tmp[0]))								$root = $_SERVER['DOCUMENT_ROOT'].$tmp[0];
	}
	if (is_file($root.'/intern/php/zugangsdaten.php')) require_once($root.'/intern/php/zugangsdaten.php');
	else {
		echo '<pre>';
		print_r($_SERVER);
		echo '</pre>';
}	}
?>