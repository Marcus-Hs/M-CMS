<?php
prepare_cms();					// Prepare for launch
class zugangsdaten {
	function __construct() {}
	function zugangsdaten() {	// Set mySQL cennection data
		global $vorgaben;
		$vorgaben['db_prefix'] = 'afk__';  	// a prefix if you use one DB for multiple instances of M-CMS
		if ($vorgaben['localhost']===false) {		// this is for remote DB
			$this->host = 'localhost';		// or IP, or Hostname
			$this->user = 'Database User';		// Enter the Database Username here
			$this->pass = 'Database Password';	// Enter the Database Password here
			$this->db   = 'Database Name';		// Enter the Database Name here
		} else {
			$this->host = 'localhost';		// this is for your local DB
			$this->user = 'root';
			$this->db   = 'yourLocalDB';
			$this->pass = 'yourLocalPassword';
}	}	}
function prepare_cms() {	// Preparing some essential constants
	global $vorgaben;
	$vorgaben['base_dir'] = str_replace('\\','/',realpath(dirname(__FILE__).'/../../').'/');
	ini_set('session.use_trans_sid', false);
	if (function_exists('date_default_timezone_set')) date_default_timezone_set('Europe/Berlin');
	if	((!empty($_SERVER['SERVER_ADDR'])	&& strpos($_SERVER['SERVER_ADDR'],'127.0.0')!==false)
		|| (!empty($_SERVER['HTTP_HOST'])	&& strpos($_SERVER['HTTP_HOST'],'127.0.0')!==false)
		|| (!empty($_SERVER['SERVER_NAME'])	&& (strpos($_SERVER['SERVER_NAME'],'localhost') !== false || strpos($_SERVER['SERVER_NAME'],'local.') === 0)))
											$vorgaben['localhost'] = true;											// We are probably on a localhost
	else										$vorgaben['localhost'] = false;											// It's a Server onthe web
	if (!empty($_SERVER['SUB_DIR'])) 						$vorgaben['sub_dir'] = $_SERVER['SUB_DIR'];									// You canset the directory where the cms resides (I've never used this though)
	elseif (strpos($vorgaben['base_dir'],$_SERVER['DOCUMENT_ROOT'])==0)		$vorgaben['sub_dir'] = trim(str_replace(array($_SERVER['DOCUMENT_ROOT'],' '),array('','%20'),$vorgaben['base_dir']),'/');	// Better to determine this automatically
	if (!empty($vorgaben['sub_dir']))						$vorgaben['sub_dir'] = '/'.$vorgaben['sub_dir'];								// Add a missing slash
	else										$vorgaben['sub_dir'] = '';												// Or not if its already the base dir
	$inc_paths = explode(';',get_include_path());		// this might not wor on every system. Comment out if needed														// read include paths (used later)
	if (is_dir($vorgaben['base_dir'].'../_mcms'))		$vorgaben['base_cms'] = $vorgaben['base_dir'].'../_mcms/';		// for multidomain installations there can be subfolders with their own config or different functions or files with a base installation
	elseif (is_dir($vorgaben['base_dir'].'../../_mcms'))	$vorgaben['base_cms'] = $vorgaben['base_dir'].'../../_mcms/';		// for multidomain installations there may by such a dir with a base installation
	elseif ($vorgaben['localhost']===false)			$vorgaben['base_cms'] = $vorgaben['base_dir'].'/';			// On the server this is the base path
	elseif (!empty($inc_paths))				$vorgaben['base_cms'] = str_replace('\\','/',end($inc_paths)).'/';	// Localy we have a look at the System paths (on win).
	my_include('intern/php/module/');
	startup();	// There we go start up the CMS (see module/startup.php)
}
function my_include($dir,$file='') {	// Include all files in given dir ore a given file based on system path
	global $vorgaben,$extra_functions;
	$base = $vorgaben['base_cms'];
	if (empty($file)) {
		if($handle = opendir($base.$dir)) {
			while(false !== ($file = readdir($handle))) {
				if (is_file($base.$dir.$file) && strpos($file,'-.')===false) {
					$filenames[$dir.$file] = $base.$dir.$file;
			}	}
			closedir($handle);
		}
		if($vorgaben['base_dir'] != $base && is_dir($vorgaben['base_dir'].$dir) && $handle = opendir($vorgaben['base_dir'].$dir)) {
			while(false !== ($file = readdir($handle))) {
				if (is_file($vorgaben['base_dir'].$dir.$file) && strpos($file,'-.')===false) {
					$filenames[$dir.$file] = $vorgaben['base_dir'].'/'.$dir.$file;
			}	}
			closedir($handle);
	}	}
	elseif (is_file($base.$dir.$file)) 					$filenames[$dir.$file] = $base.$dir.$file;
	elseif (is_file($vorgaben['base_dir'].$dir.$file)) 	$filenames[$dir.$file] = $vorgaben['base_dir'].$dir.$file;
	if (!empty($filenames)) {
		sort($filenames);
		foreach($filenames as $filename) {
			require_once($filename);
			$function = 'prepare_'.str_replace('.php','',basename($filename));						// Build function name from file name (these function are supposed to execute an script start)
			if (function_exists($function)) $extra_functions['startup'][$function] = $function;		// Look if the function exists and remember
			$function = 'append_'.str_replace('.php','',basename($filename));						// Dito for functions to append at and of execution
			if (function_exists($function)) $extra_functions['append'][$function] = $function;
			unset($function);
}	}	}
?>
