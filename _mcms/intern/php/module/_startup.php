<?php
function startup() {														// There we go...
	global $dbobj,$tplobj,$vorgaben,$extra_functions;
#	if (!empty($_SERVER['HTTP_USER_AGENT']) && stripos($_SERVER['HTTP_USER_AGENT'],"java/")!==false){header("HTTP/1.0 403");die();} // java is evil
	error_startup();														// call error handling
	work_inpath();															// read request path
	load_files();
	$dbobj  = new dbclass();													// start DB class
	$tplobj = new tplclass();													// start template class
	test_session();															// test if a session exists or start one if necessary
	read_vorgaben();															// load system wide presets
	if ($vorgaben['admin']) {													// Do some admin stuff
		admin_setlang();															// set languages
	} else {																	// or every other page
		setlang();																	// languages
		path2db();																	// Compare request path to pages in DB
	}
	finalize_session();															// Set Session parameters for forms if nescessary
	extra_functions();															// Callin main TPL, additional function runs, cache & output
}
function extra_functions() {													// run extra functions for plugins at begin or end of script
	global $extra_functions,$vorgaben;
	if ($vorgaben['tpl']) {														// we need another check on templates here
		if (!empty($extra_functions['startup'])) {									// 	and eventually get functions to be executed on startup
			foreach($extra_functions['startup'] as $fct)	$fct();						//	and execute them
		}
		if ($vorgaben['admin'])	admin_tpl();										// 	Main function (admin/administration.php)
		else					tpl();												//	Main function (user/prepare_output.php)
		if (!empty($extra_functions['append'])) {									// 	and finally get the functions to be executed after everyting else.
			foreach($extra_functions['append'] as $fct)	$fct();						//	do it.
	}	}
}
function error_startup() {													// initialize error handling
	error_reporting(E_ERROR | E_WARNING | E_STRICT | E_PARSE | E_NOTICE);		// we catch every error and message
	set_error_handler("getErrorHandler");										// set the function for error handling
	register_shutdown_function('shutDownFunction');								// and regster a function to execute when all else fails
}
function work_inpath() {													// work input path
	global $path,$path_in,$vorgaben;
	$path_in = str_remove($_SERVER['REQUEST_URI'],"'");						// read REQUEST - no need for '.
	if (!empty($vorgaben['sub_dir']))											// if cms resides in a sub directory we remove that part here
		$path_in = str_remove($path_in,$vorgaben['sub_dir']);
	$path = explode('&',str_replace('?','&',rtrim($path_in,'/$&')),2);						// we dont care if it's ? od & for url parameters
	if (!empty($path[1])) {
		if (strpos($path[1],'/')!==false && strpos($path[1],'.html')!==false)list($path[1],$unterseite) = explode('/',$path[1]);
		parse_str($path[1],$get);											// lets put the url parameters in $_REQUEST
		if (isset($_GET))		$_GET = array_merge($get, $_GET);
		else					$_GET = &$get;
		if (isset($_REQUEST))	$_REQUEST = array_merge($get, $_REQUEST);
		else					$_REQUEST = &$get;
		if (!empty($unterseite)) $path[0] .= '/'.$unterseite;
	}
	$path_in = trim($path[0],'/');												// 1st part = requested path.
	$path = explode('/',$path_in);												// explode into virtual dierectorien and files
}
function load_files() {													// load all files
	global $vorgaben;
	if (isset($_REQUEST['pqp'])) 	my_include('intern/php/','pqp.php');		// start profiling if requested
	if (strpos(basename($_SERVER['SCRIPT_NAME']),'index.php')===0)	$vorgaben['tpl'] = true;
	else															$vorgaben['tpl'] = false;
	if (strpos($_SERVER['REQUEST_URI'],'login.php')!==false) 		$vorgaben['admin'] = true;
	else															$vorgaben['admin'] = false;
	if ($vorgaben['tpl']) {													// check if templates are available
		if ($vorgaben['admin'])	 {												//	either in admin section
			my_include('intern/php/admin/');										//	and load admin includes
		} else {																//	or everything else
			$_REQUEST = disarm($_REQUEST);											//	filter input
			my_include('intern/php/user/');									//	include user files
	}	}
}
function shutDownFunction() {												// catch fatal errors
	global $vorgaben,$dbobj;
#	if ($vorgaben['localhost'] || $vorgaben['preview'] || $vorgaben['admin']==true) {										// only on local host (in production these errors get dismissed)
		$sql_errno = $dbobj->errno();
		if (!empty($sql_errno) && $sql_errno!='00000')				{
			echo '<pre>';	info($dbobj->error(),'print');	echo '</pre>';
		}
		$last_error = error_get_last();
		if (!empty($last_error['type']) && $last_error['message'] != '__clean_error_info')	{
			echo '<pre>';	info($last_error,'print');	echo '</pre>';
		}
}#	}
function read_vorgaben($select='*',$return='') {								// Set presets and defaults for cms
	global $dbobj,$first_lang_id,$vorgaben,$sub_tpl,$path_in;
	if ($vorgaben['admin'] && !empty($_REQUEST['vorgaben'])) 		save('vorgaben');
	if (empty($return)) {														// first call: Set some defaults.
		if ($vorgaben['localhost'] || domain(0,array('vorschau','test','preview','np')))		$vorgaben['preview'] = true;
		else																					$vorgaben['preview'] = false;
		$vorgaben['is_preview'] = false;
		$vorgaben['verwaltung_sprache'] = $first_lang_id;
		$vorgaben['img_path'] = 'images/bilder';
		if (($vorgaben['preview'] || $vorgaben['admin'] || !empty($_REQUEST)))	$vorgaben['cache'] = false;
		else																	$vorgaben['cache'] = true;
		$sub_tpl['max_file_size']	 = (min(calc_size(ini_get('upload_max_filesize')),calc_size(ini_get('post_max_size')),calc_size(ini_get('memory_limit'))));
		$sub_tpl['max_file_uploads'] = ini_get('max_file_uploads');
		if (!empty($_SERVER['HTTPS']))		$vorgaben['protocol'] = 'https://';
		else								$vorgaben['protocol'] = 'http://';
	}
	if (empty($return) || $return==='impressum'){
		if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#person','plz'))
			$sql_a['impressum'] = "SELECT firma,name,strasse,plz,ort,www,email,telefon,fax,mobil FROM #PREFIX#person WHERE impressum > 0;";
		else
			$sql_a['impressum'] = "SELECT firma,name,strasse,ort,www,email,telefon,fax,mobil FROM #PREFIX#person WHERE impressum > 0;";
	}
	if (empty($return) || $return==='vorgaben')		$sql_a['vorgaben']  = "SELECT ".$select." FROM #PREFIX#vorgaben;";
	$data = $dbobj->multiquery(__file__,__line__,$sql_a);
	if (!empty($data['vorgaben'][0]['name'])) {
		foreach ($data['vorgaben'] as $v) {
			$vorgaben[$v['name']] = $v['value'];
		}
	} elseif ($select=='*' && empty($data['vorgaben'][0]['name'])) {										// no DB yet: Try to create it
		my_include('intern/php/admin/','admin_sql.php');
		if (import_tables('startup.sql')) {
			$need_dirs = array('downloads','images/','images/weitere','images/weitere/.thumbs',$vorgaben['img_path'],$vorgaben['img_path'].'/thumbs',$vorgaben['img_path'].'/originale');
			foreach ($need_dirs as $dir) {										// some dirs are needed to be writable: try to force it.
				if		(!is_dir($vorgaben['base_dir'].$dir)) 		mkdir($vorgaben['base_dir'].$dir, 0775);
				elseif	(!is_writable($vorgaben['base_dir'].$dir))	chmod_r($vorgaben['base_dir'].$dir);
			}
			exit('Datatabase created. Please reload.');
		} else {
			exit('startup.sql not Found! Or DB access not correct.');
		}
	} elseif ($dbobj->errno() == 2002) {
		exit('Can\'t connect to Datatabase!');
	}
	if (!empty($data['impressum'][0])) {										// for the imprint set some default variables.
		$sub_tpl['www2']		= '<a href="'.url_protocol($data['impressum'][0]['www']).'">'.url_protocol($data['impressum'][0]['www'],false).'</a>';
		$sub_tpl['email2']		= '<a class="email" href="mailto:'.str_replace('@','%40',$data['impressum'][0]['email']).'">'.$data['impressum'][0]['email'].'</a>';
		$sub_tpl['mobil2']		= '<a class="mobiel" href="tel:'.$data['impressum'][0]['mobil'].'">'.$data['impressum'][0]['mobil'].'</a>';
		$sub_tpl['telefon2']	= '<a class="phone" href="tel:'.$data['impressum'][0]['telefon'].'">'.$data['impressum'][0]['telefon'].'</a>';
		$sub_tpl['diesesjahr']	= date('Y');
		foreach ($data['impressum'][0] as $k=> $d) {
			if (!empty($d))	$sub_tpl[$k] = $d;
		}
		if (!empty($sub_tpl['ort']) && strpos(' ',$sub_tpl['ort'])!==false) list($sub_tpl['plz'],$sub_tpl['stadt']) = explode(' ',$sub_tpl['ort']);
	}
	$vorgaben['home'] = get_page(array('PAGE_ID'=>'#firstpage#','feld'=>'Menu,PAGE_ID','errors'=>false));	// fetch first page data for breadcrumb navigation and reference
	if		(!empty($return) && !empty($$return))		return $$return;
	elseif	(!empty($return) && !empty($data[$return]))	return $data[$return][0];
}
function disarm($array) {														// lets filter user input
	foreach ($array as $key => $value)	{
		if (is_array($value))	$value = disarm($value);
		elseif (!empty($_SESSION['status']) && !is_numeric($_SESSION['status'])) 	$value = addslashes($value);
		else																		$value = addslashes(preg_replace("/§(\S+)§/Ui",'',$value));
		$array[$key] = $value;
	}
	return $array;
}
function getErrorHandler($errno, $errmsg, $filename, $linenum) {				// Error handling
	global $codepage,$error,$syserror,$vorgaben;
	if (error_reporting() != 0 && $_SERVER['HTTP_USER_AGENT'] != 'OpenNMS HttpMonitor') {
		if ($vorgaben['localhost']/* || $vorgaben['preview']*/ || $vorgaben['admin']) {
			$err_info = date("Y-m-d H:i:s"). "\n\n";
			$err_info .= preg_replace('~\\+~', '/',$errmsg). "\n\n";
			if (!auto_update($errmsg) && empty($vorgaben['show_err'])) {
				$err_info .= "File: ".preg_replace('~\\+~', '/',$filename). ": " .$linenum. "\n\n";
				$err_info .= "Call: ".url_protocol(domain('*')).$_SERVER['REQUEST_URI']. "\n";
				if(!empty($_SERVER['HTTP_REFERER'])) 	$err_info .= "Referer: ".$_SERVER['HTTP_REFERER']. "\n\n";
				$err_info .= "IP: ".$_SERVER['REMOTE_ADDR']. "\n";
				if (!empty($_SERVER['HTTP_USER_AGENT']))	$err_info .= "User Agent: ".$_SERVER['HTTP_USER_AGENT']. "\n\n";
				if(!empty($_REQUEST)) 						$err_info .= info_type($_REQUEST,'$_REQUEST'). "\n\n";
				if(!empty($_SESSION)) 						$err_info .= info_type($_SESSION,'$_SESSION',array('rights','page_ids','login','name','PHPSESSID','logged','uid','addstyles')). "\n\n";
				if(!empty($_COOKIE))					 	$err_info .= info_type($_COOKIE, '$_COOKIE'). "\n\n";
				if(!empty($_FILES))						 	$err_info .= info_type($_FILES,  '$_FILES'). "\n\n";
				if (!empty($_REQUEST['bt'])) backtrace();
				$syserror['errorhandler'][] = $err_info;
			#	$error['errorhandler'] = '%%SYSTEMFEHLER%%';
		}	}
		elseif (!empty($err_info)) $error[] = nl2br($err_info);
}	}
function auto_update($errmsg) {												// some DB errors canbe caught.
	$e["cache' doesn't exist"]		= 'blobcache.sql';
	$e["inuse' doesn't exist"]		= 'inuse.sql';
	$e["seiten.AK' in 'field list'"]= 'ak.sql';
	$e["showta' in 'field list'"]	= 'showta.sql';
	$e["closed' in 'field list'"]	= 'forum_closed.sql';
	$e["proseite' in 'field list'"]	= 'vl_proseite.sql,vl_pos99.sql,vl_script.sql,vl_stats.sql';
	$e["prefix' in 'field list'"]	= 'page_prefix.sql';
	while(empty($x) && list($key, $value) = myEach($e)) {
		if (strpos($errmsg,$key)!==false) $x = $value;
	}
	if (!empty($x)) {
		my_include('intern/php/admin/','admin_sql.php');
		return import_tables($x);
	}
	return false;
}
function backtrace($output='error',$args=true) {								// trace function calls
	global $error;
	$out = '<table><tr><th>FUNCTION</th><th>FILE</th><th>LINE</th></tr>';
	$backtrace = debug_backtrace();
	foreach ($backtrace as $bt) {
		$args = array();
		if($args) {	foreach ($bt['args'] as $a) $args[] = info_type($a); }
		$args_out = implode(', ',$args);
		$out .= "\n".'<tr><td>'.$bt['function'].$args_out;
		if (!empty($bt['file']))		$out .= '</td><td>'.str_replace('\\','/',$bt['file']).'</td><td>'.$bt['line'];
		$out .= "</td></tr>";
	}
	info($out,$output);
}
function info($var,$output='htmlpop') {											// output infos about variables
	global $codepage,$error,$vorgaben;
	if (is_array($var) && !empty($var['permissions']))	unset($var['permissions']);
	if (!empty($vorgaben['db_prefix']))					$info = str_replace('#PREFIX#',$vorgaben['db_prefix'],info_type($var));													// collect data
	$vorgaben['cache']=false;
	if (isset($info)) {
		switch($output) {
			case 'htmlpop':	modal_msg(html_entity_decode($info));	break;
			case 'popup':	popup_msg('<span style="width:100%;font-family:monospace;white-space: pre;overflow:auto;">'.str_replace('	','&nbsp;&nbsp;&nbsp;&nbsp;',my_htmlentities($info)).'</span>');	break;
			case 'error':	$error[] = '<span style="width:100%;font-family:monospace;white-space: pre;overflow:auto;">'.str_replace('	','&nbsp;&nbsp;&nbsp;&nbsp;',$info).'</span>';	break;
			case 'echo':	echo '<span style="width:100%;font-family:monospace;white-space: pre;overflow:auto;">'.str_replace('	','&nbsp;&nbsp;&nbsp;&nbsp;',html_entity_decode($info)).'</span><br />';break;
			case 'print':	print_r(strip_tags($info)); unset($vorgaben['compress']);	break;
			case 'return':	return	$info;	break;
}	}	}
function modal_msg($msg,$title='') {											// show modal window
	global $sub_tpl;
	$sub_tpl['addscript']['errcontent'][] = str_replace(array('\\','"',"'","\r","\n","&amp;"),array('/','&quot;',"&quot;",'','<br />','&'),trim($msg));
}
function popup_msg($msg,$title='') {											// show popup window
	global $sub_tpl;
	if (!empty($style[0])) 	$add_css = '<style type="text/css">html {font-family:sans-serif}\n'.str_replace(array("\n","\r"),' ',r_implode(" ",$sub_tpl['style'])).'</style>';
	else					$add_css = '<style type="text/css">html {font-family:sans-serif}</style>';
	$lines = str_replace(array("'","\r"),array('"',''),trim($msg));
	$lines = str_replace("\n\n","\n",$lines);
	$title = str_replace(array("\n\n","\r\n"),"\n",$title);
	if (strpos($lines,'<br')===false) $lines = nl2br($lines);
	$sub_tpl['prescript'][] = "
	m_window = window.open('','x".rand()."','toolbar=no,width=1000,height=600,directories=no,scrollbars,status=no,menubar=no,resizable=yes');
	m_window.document.writeln('<html><head><title>".implode("');\n\t\tm_window.document.writeln('",explode("\n",$title))."</title>".$add_css."</head><body>');
	m_window.document.writeln('".implode("');\n\t\tm_window.document.writeln('",explode("\n",$lines))."');
	m_window.document.writeln('</body></html>');
	m_window.document.close();
	m_window.focus();";
}
function info_type($a,$name='',$skip='') {								// collect data
	switch (gettype($a)) {
		case 'integer':
		case 'double':	$arg = $a;								break;
		case 'string':	$arg = my_htmlspecialchars($a);			break;
		case 'array':	$arg = array2txt($a,$name,$skip);		break;
		case 'object':	$arg = 'Object('.get_class($a).')</br>'.array2txt($a,$name,$skip);		break;
		case 'resource':$arg = 'Resource('.strstr($a, '#').')';	break;
		case 'boolean':	$arg = $a ? 'True' : 'False';			break;
		case 'NULL':	$arg = 'Null';							break;
		default:		$arg = 'Unknown';
	}
	return $arg;
}
?>