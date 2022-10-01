<?php
include "config.php";
include "session.php";
if($user_login == 'ok'){
	include "functions.php";
	$_GET['file_name'] = urldecode(trim($_GET['file_name'],'/'));
	$_GET['p'] = urldecode(trim($_GET['p'],'/'));
	if(!empty($_GET['file_name']) && isset ($_GET['p'])){
		if(file_exists($vorgaben['base_dir'].$initial_folder.'/'.$_GET['p'].'/'.$_GET['file_name'])){
			$file = file_get_contents($vorgaben['base_dir'].$initial_folder.'/'.$_GET['p'].'/'.$_GET['file_name']);
			$type = wp_check_filetype($_GET['file_name']);
			header('Content-type: {$type[type]}');
			header('Content-Disposition: attachment; filename="'.$_GET['file_name'].'"');
			echo $file;
}	}	}
?>