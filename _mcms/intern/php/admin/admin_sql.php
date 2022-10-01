<?php
function prepare_admin_sql() {
	global $add_admin,$plugin_functions,$add_vorgaben;
	$add_admin['admin2']['1_admin_mysql'] = array('function' => 'admin_sql','alias'=>'1_dump_mysql','titel' => '%%MYSQL%%','style'=>'style="background-image:url(/admin/icons/mysql-icon.png)"');
	$plugin_functions['logout'][] = 'logout_backup_sql';
	$add_vorgaben['%%HTTPSDOMAIN%%']['https_domain'] = '<label for="https_domain">%%HTTPSDOMAIN%%:</label><input id="https_domain" name="vorgaben[https_domain]" value="|HTTPS_DOMAIN|" /><br />';
}
function logout_backup_sql() {
	$last = read_vorgabe('mysql_backup');
	$now = date("Y-m-d");
	if (empty($last) || (strtotime($now) - strtotime($last) > 2629743)) { // every 4 weeks
		backup_tables('*','','','',true);
}	}
function startup_admin_sql() {
	if (!empty($_REQUEST['dump_tpl']) && is_array($_REQUEST['dump_tpl']))		{foreach ($_REQUEST['dump_tpl'] as $tpl_id)		backup_tables('#PREFIX#vorlagen,#PREFIX#seiten_attr',"-- IMPORT AS NEW--\n",$tpl_id,'TPL_ID');}	// Als neue Vorlage mit Seiten exportieren
	elseif (!empty($_REQUEST['dump_lang']) && is_array($_REQUEST['dump_lang']))	{foreach ($_REQUEST['dump_lang'] as $lang_id)	backup_tables('#PREFIX#_translate',"-- REPLACE--\n",$lang_id,'LANG_ID');}// Übersetzungen exportieren
	elseif (!empty($_REQUEST['dump_mysql'])) 																					backup_tables();														// Sonst alles Exporttiern
	elseif (!empty($_FILES['mysql']) && move_uploaded_file($_FILES['mysql']['tmp_name'],'intern/sql/'.$_FILES['mysql']['name']))import_tables($_FILES['mysql']['name']);								// Datei hochladen und importieren
	elseif (!empty($_REQUEST['mysqlexecute'])) 																					execute_sql($_REQUEST['mysqlexecute']);									// SQL-Eingabe ausführen
	elseif (!empty($_REQUEST['mysqldumps']) && is_array($_REQUEST['mysqldumps'])){foreach ($_REQUEST['mysqldumps'] as $file)	import_tables($file);}													// Tabellen importieren
	elseif (!empty($_REQUEST['mysqloptimize']))																					optimize_tables();														// Tabellen optimieren
	elseif (!empty($_REQUEST['mysqlcleanup']))																					cleanup_tables();														// Doppelungen entfernen
	elseif (!empty($_REQUEST['remotemysql']))																					remotemysql();														// Doppelungen entfernen
}
function remotemysql() {
	global $tplobj,$sub_tpl,$vorgaben,$error;
	if ($vorgaben['localhost']) {
		$file = $vorgaben['db_prefix'].'remote__'.date('Y-m-d_H-i-s').'.sql';
		$dir  = $vorgaben['base_dir'].'intern/sql/';
		if (!empty($vorgaben['https_domain']))	$www = $vorgaben['https_domain'];		// Check for https-domain
		else									$www = $sub_tpl['www'];
		$url  = 'https://'.md5(date('dmYH')).':'.md5(str_replace(array('.','www','-'),'',$www)).'@'.$www.'/mysqlbackup.php';
		if ($content = get_remote($url,$dir.$file)) {
			$error[] = '%%RUNTERGELADEN%%: '.$file;
		} else {
			$error[] = '%%SCHADE%%: '.$file;
		}
}	}
function get_remote($url,$file) {
	global $error;
	$opts	 = array('http'=>array('header'=>"User-Agent: Calling Home\r\n"));
	$context = stream_context_create($opts);
	$data	 = file_get_contents($url,false,$context);
	if(!empty($data) && $data != 'Bye') {
		$fp = fopen($file,'w+');	//This is the file where we save the information
		fwrite($fp, $data);			//write response to file
		fclose($fp);
		return true;
	}
	return false;
}
function admin_sql($dir='intern/sql/') {
	global $tplobj,$vorgaben,$sub_tpl;
	$tpl   = dump_tpl();												// load template
	$files['specific'] = do_rows($dir,$tpl);							// look for sql files
	if (!empty($vorgaben['base_cms']) && is_dir($vorgaben['base_cms'].'/'.$dir)) {							// there may be more on multi domain installations
		$path = $vorgaben['base_cms'].'/'.$dir;
	} elseif (!empty($vorgaben['grp__cms']) && is_dir($vorgaben['grp__cms'].'/'.$dir)) {							// there may be more on multi domain installations
		$path = $vorgaben['grp__cms'].'/'.$dir;
	}
	if (!empty($path)) {	
		$tpl['line'] = str_replace(array('chk import','chkx remove'),array('chk import2','chkx remove2'),$tpl['line']);
		$files['generic'] = do_rows($path,$tpl,false,$files['specific']);	// read and add to list
		if (!empty($files['generic']))	$tpl['page'] = str_replace('|GENERIC_TB|',$tpl['generic_tb'],$tpl['page']); // fill template
		if ($vorgaben['localhost'])		$tpl['page'] = str_replace('|DOWNLOADDB|',$tpl['downloaddb'],$tpl['page']); // fill template
	}
	$out_files = array();
	if (!empty($files)) {
		foreach ($files as $k => $f) {
			if (!empty($f))	$out_files[$k] = implode("\n",$f);	// merge file list
	}	}
	if (!empty($sub_tpl['subnav']))	$tpl['page'] = str_replace('|SUBNAV|',$sub_tpl['subnav'],$tpl['page']);
	return $tplobj->array2tpl($tpl['page'],$out_files);	// output results
}
function do_rows($path,$tpl,$paginate=true,$old='') {
	global $path_in,$sub_tpl,$unterseite_id;
	if (is_array($old)) $old_keys = array_keys($old);	// remember old keys
	$files = read_files($path,$tpl);
	if ($paginate) {
		$proseite = 10;
		$sub_tpl['subnavlink'] = "\n<a href=\"".$path_in.formget(array('all'=>'page')).'&#TO#|SID|">#LINK#</a>';
		$sub_tpl['subnavpre']   = 'paginate=';
		$sub_tpl['subnavbox']  = '<p class="nav">#ANZAHL# %%EINTRAEGE%% (#VON# - #BIS#): #CONTENT# '.str_replace(array('#TO#','#LINK#'),array($sub_tpl['subnavpre'].'all','%%ALLE%%'),$sub_tpl['subnavlink']).'</p>';
		if (!empty($_REQUEST['paginate']) && is_numeric($_REQUEST['paginate']))	$unterseite_id = $_REQUEST['paginate'];
		elseif (!empty($_REQUEST['paginate']) && $_REQUEST['paginate']=='all')	$unterseite_id = $_REQUEST['paginate'];
		else																	$unterseite_id = 0;
		if (!is_numeric($unterseite_id))										$proseite = count($files);
	}
	if (!empty($files)) {		// if file exists
		if(!empty($old_keys)) {
			foreach ($files as $k => $f) {
				if (!in_array($k,$old_keys)) $out_files[$k] = $f;
			}
		} else  $out_files = $files;
		if (!empty($out_files))	{
			krsort($out_files);	// sort
			if ($paginate) {
				paginate($out_files,$proseite,false);
			}
			return $out_files;	// and return.
}	}	}
function read_files($dir,$tpl) {// read files and order by date
	global $tplobj;
	$files = array();
	if($handle = @opendir($dir)) {
		while(false !== ($data['file'] = readdir($handle))) {
			$y = ''; $m = ''; $day = ''; $data['time'] = ''; $data['name'] = $data['file'];
			$pos = strpos($data['file'],'.sql');
			$data['dir'] = $dir;
			if ($pos && is_file($dir.$data['file'])) {
				$fn = str_remove($data['file'],'.sql');
				if (strpos($fn,'_')!==false && strpos($fn,'-')!==false) {
					$parts			= explode('_',$fn);
					$data['time']	= str_replace('-',':',array_pop($parts));
					list($day,$m,$y)= explode('-',array_pop($parts));
					if (strlen($day)==4) {
						$d2 = $y;
						$y = $day;
						$day = $d2;
						unset($d2);
					}
					$day			= str_pad($day,2,0,STR_PAD_LEFT);
					$data['date']	= "$day.$m.$y";
					$data['name']	= trim(implode('_',$parts),'_');
				}
				$files[$y.$m.$day.$data['time'].'--'.$data['name']] = $tplobj->array2tpl($tpl['line'],$data);
			}
			unset($data);
		}
		closedir($handle);
	}
	return $files;
}
function execute_sql($sql='') {	/* execute sql */
	global $dbobj,$vorgaben;
	if (!empty($sql)) {
		$vorgaben['skip_err']=1;
		debug();
		$dbobj->multiquery(__file__,__line__,explode(";\n",stripslashes($sql)));
		unset($vorgaben['skip_err']);
}	}
function import_tables($files,$tables='*',$dir='intern/sql') {		/* import DB or just a TABLE */
	global $dbobj,$error,$vorgaben;
	if (!is_array($files))	$files = explode(',',$files);
	foreach ($files as $file) {
		$filename = $file;
		$path = get_filepath($dir);
		if		(is_file($path.'/'.$file))	$file = file_get_contents($path.'/'.$file);
		else								return false;
		$file = str_replace(array('#PHPSESSID#','#REMOTE_ADDR#','#SUID#'),array(session_id(),$_SERVER['REMOTE_ADDR'],uid()),$file);
		preg_match_all("/-- # DUMP=(.*?) # --(.*?)-- # \/DUMP # --/si",$file,$match);
		if (strpos($file,'-- IMPORT AS NEW--')!==false && !empty($match[1])) {
			foreach($match[2] as $key => $content) {
				$page = '0';
				if (strpos($match[1][$key],':')!==false)	list($table,$page) = explode(':',$match[1][$key]);
				else										$table = $match[1][$key];
				$db[$page][$table] = $content;
			}
			ksort($db);
			foreach ($db as $page => $import) {
				$page_id = '';
				foreach ($import as $table => $sql) {
					if (!empty($page_id)) $sql = str_replace('PAGE_NEW',$page_id,$sql);
					if (!empty($tpl_id))  $sql = str_replace('TPL_NEW',$tpl_id,$sql);
					$dbobj->singlequery(__file__,__line__,$sql);
					if ($table == 'vorlagen') 		$tpl_id  = $dbobj->last_id();
					elseif ($table == 'seiten_attr')$page_id = $dbobj->last_id();
			}	}
			rebuild_tree();
			$error[] = '%%VORLAGE_IMPORTIERT%% ("'.$filename.'")';
		} else {
			if (strpos($file,'-- # Schnipp --')!==false) {
				$file = preg_replace("/-- # DUMP=(.*?) # --/si",'',$file);
				$file = str_remove($file,'-- # /DUMP # --');
				$sqls = explode('-- # Schnipp --',$file);
				foreach ($sqls as $n => $sql) {
					$sql = trim($sql);
					if (!empty($sql))	$sql2[$n] = $sql;
				}
				$vorgaben['show_err']=1;
				$dbobj->multiquery(__file__,__line__,$sql2);
			}
			else $dbobj->singlequery(__file__,__line__,$file);
			$error[] = '%%TABELLE_IMPORTIERT%% ("'.$filename.'")';
		}
		return true;
	}
	return false;
}
function backup_tables($tables='*',$return='',$attr_id='',$attr='',$silent=false) {
	global $dbobj,$vorgaben,$error;
	if($tables == '*') {
		$tables = $dbobj->exists(__file__,__line__,"SHOW TABLES LIKE '#PREFIX#%';");	//get all of the tables
		if (function_exists('write_vorgaben'))	write_vorgaben(array('mysql_backup'=>date("Y-m-d")));
	} else $tables = explode(',',$tables);
	foreach($tables as $table)	{																			//cycle through
		if (is_array($table) && !empty($table['Tables_in_'.$dbobj->db.' ('.$vorgaben['db_prefix'].'%)']))	$t = $table['Tables_in_'.$dbobj->db.' ('.$vorgaben['db_prefix'].'%)'];
		else																								$t = $table;
		if ((!empty($t) || $tables=='*') && strpos($t,'_stats')===false) {
			$t = str_remove($t,array($vorgaben['db_prefix'],'#PREFIX#'));
			if (!empty($attr) && !empty($attr_id)) {
				if ($t == 'vorlagen')		$sql = 'SELECT #PREFIX#'.$t.'.* FROM `#PREFIX#'.$t.'`							WHERE '.$attr.' = '.$attr_id.';';
				elseif ($attr == 'TPL_ID')	$sql = 'SELECT #PREFIX#'.$t.'.* FROM `#PREFIX#'.$t.'`							WHERE #PREFIX#seiten_attr.'.$attr.' = '.$attr_id.' AND #PREFIX#'.$t.'.PAGE_ID = #PREFIX#'.'seiten_attr.PAGE_ID;';
				elseif ($attr == 'LANG_ID')	$sql = 'SELECT #PREFIX#'.$t.'.*,short FROM `#PREFIX#'.$t.'`,#PREFIX#_languages	WHERE #PREFIX#'.$t.'.'.$attr.' = '.$attr_id.' AND #PREFIX#_languages.'.$attr.' = #PREFIX#'.$t.'.'.$attr.';';
			} else							$sql = 'SELECT * FROM `#PREFIX#'.$t.'`;';
			if ($result = $dbobj->exists(__file__,__line__,$sql)) {
				sort($result);
				if (!empty($attr) && !empty($attr_id)) {
					if (!empty($result[0]['short'])) {
						$return .= "DELETE FROM `#PREFIX#".$t."` WHERE ".$attr." = ".$attr_id.";\n-- # Schnipp --";
						$name = $t.'_'.$result[0]['short'];
					}
					elseif (!empty($result[0]['Titel'])) 	$name = $result[0]['Titel'];
				} else {
					$row2	 = $dbobj->singlequery(__file__,__line__,'SHOW CREATE TABLE `#PREFIX#'.$t.'`;');
					$row2[0]['Create Table'] = str_replace(array(' auto_increment',' default ',' collate ','PRIMARY KEY ('),
														   array(' AUTO_INCREMENT',' DEFAULT ',' COLLATE ','PRIMARY KEY  ('),
														$row2[0]['Create Table']);
					if (!empty($row2[0]['Create Table'])) {
						$return .= "DROP TABLE IF EXISTS `#PREFIX#".$t."`;\n-- # Schnipp --";
						$return .= "\n".str_replace('TABLE `'.$vorgaben['db_prefix'],'TABLE `#PREFIX#',$row2[0]['Create Table']).";\n-- # Schnipp --\n";
					} else {
						$return .= "TRUNCATE TABLE `#PREFIX#".$t."`;\n-- # Schnipp --";
					}
					$name = $vorgaben['db_prefix'].$dbobj->db;
				}
				if (!empty($attr) && $attr == 'TPL_ID' && $t == 'seiten_attr') { # and then pages images and files
					foreach ($result as $row) {
						if (!empty($row['PAGE_ID'])) {
							$return .= build_lines($row['PAGE_ID'],$t,array(0=>$row));
							$sql_a['seiten']	= 'SELECT *,\'PAGE_NEW\' AS PAGE_ID FROM #PREFIX#seiten		WHERE PAGE_ID = '.$row['PAGE_ID'].';';
							$sql_a['bilder']	= 'SELECT *,\'PAGE_NEW\' AS PAGE_ID FROM #PREFIX#bilder		WHERE PAGE_ID = '.$row['PAGE_ID'].';';
							$sql_a['abschnitte']= 'SELECT *,\'PAGE_NEW\' AS PAGE_ID FROM #PREFIX#abschnitte WHERE PAGE_ID = '.$row['PAGE_ID'].';';
							$more_tables = $dbobj->multiquery(__file__,__line__,$sql_a);
							foreach ($more_tables as $add_table => $add_rows) {
								if ($add_table=='bilder')		unset($add_rows[0]['BILD_ID']);
								$return .= build_lines($row['PAGE_ID'],$add_table,$add_rows);
					}	}	}
				} elseif ($t == '_session') {
					$return .= "\n-- # DUMP=$t # --\n".'INSERT INTO `#PREFIX#_session` (`ID`,`sessionID`,`IP`,`logindate`) VALUES ("#SUID#", "#PHPSESSID#", "#REMOTE_ADDR#", "2013-03-25 11:24:16");'."\n-- # /DUMP # --\n\n-- # Schnipp --";
				} elseif ($t != '_inuse' && $t != '_cache') {
					$return .= build_inserts($result,$t,$attr_id,$attr);
			}	}
			else {
				$row2	 = $dbobj->singlequery(__file__,__line__,'SHOW CREATE TABLE `#PREFIX#'.$t.'`;');
				if (!empty($row2[0]['Create Table'])) {
					$return .= "DROP TABLE IF EXISTS `#PREFIX#".$t."`;\n-- # Schnipp --";
					$return .= "FLUSH TABLES `#PREFIX#".$t."`;\n-- # Schnipp --";
					$return .= "\n".str_replace('TABLE `'.$vorgaben['db_prefix'],'TABLE `#PREFIX#',$row2[0]['Create Table']).";\n-- # Schnipp --\n";
				} else {
					$return .= "TRUNCATE TABLE `#PREFIX#".$t."`;\n-- # Schnipp --";
				}
				if ($t == '_session')
					$return .= "\n-- # DUMP=$t # --\n".'INSERT INTO `#PREFIX#_session` (`ID`,`sessionID`,`IP`,`logindate`) VALUES ("#SUID#", "#PHPSESSID#", "#REMOTE_ADDR#", "2013-03-25 11:24:16");'."\n-- # /DUMP # --\n\n-- # Schnipp --";
		}	}
		$return = str_replace(array("\r",",\n\nINSERT",					'Â§',session_id(),$_SERVER['REMOTE_ADDR']),
							  array('',	 ";\n\n-- # Schnipp --\nINSERT",'§', '#PHPSESSID#',			'#REMOTE_ADDR#',),
							  $return)."\n\n";
	}
	if (!empty($name)) {
		$file = $name.'__'.date('Y-m-d_H-i-s').'.sql';
		$dir = $vorgaben['base_dir'].'intern/sql/';
		if	   (!file_exists($dir) ) mkdir($dir,0777);
		elseif (!is_writable($dir))	 chmod($dir,0777);
		$handle = fopen($dir.$file,'w+');	//save file
		fwrite($handle,trim($return));
		fclose($handle);
		if (!$silent)					$error[] = '%%TABELLE_EXPORTIERT%%: <a href="/download.php&d=intern/sql&f='.$file.'§SID§">'.$file.'</a>';
		elseif ($silent == 'return')	return $file;
}	}
function build_inserts($result,$t,$attr_id,$attr) {
	global $dbobj,$vorgaben;
	$i = 1;$n = 1;
	$return = "\n-- # DUMP=".$t.' # --';
	if (!empty($result[0])) {
		if (!empty($attr) && $attr == 'TPL_ID'  && $t=='bilder')		unset($result[0]['BILD_ID']);
		if (!empty($attr) && $attr == 'TPL_ID'  && $t=='vorlagen')		unset($result[0]['TPL_ID']);
		if (!empty($attr) && $attr == 'LANG_ID' && $t=='_translate')	unset($result[0]['short']);
		$insert = "\nINSERT INTO `#PREFIX#".$t.'` (`'.implode('`,`',array_keys($result[0]))."`) VALUES\n";
		foreach ($result as $row) {
			if (!empty($attr) && $attr == 'TPL_ID'  && $t=='bilder')	unset($row['BILD_ID']);
			if (!empty($attr) && $attr == 'TPL_ID'  && $t=='vorlagen')	unset($row['TPL_ID']);
			if (!empty($attr) && $attr == 'LANG_ID' && $t=='_translate')unset($row['short']);
			if ($i>30000) $i = 1;
			$lines[$n] = build_line($row,$insert,$i);
			$i += strlen($lines[$n]);$n++;
		}
		$return .= implode(",\n",$lines).';';
		$return .= "\n-- # /DUMP # --\n\n-- # Schnipp --";
		return $return;
}	}
function build_lines($PAGE_ID,$add_table,$add_rows) {
	$i = 1;$n = 1;
	if (!empty($add_rows[0])) {
		$return = "\n-- # DUMP=".$add_table.':'.$PAGE_ID.' # --';
		if ($add_table=='seiten_attr')		unset($add_rows[0]['PAGE_ID']);
		$insert = "\nINSERT INTO `#PREFIX#".$add_table.'` (`'.implode('`,`',array_keys($add_rows[0]))."`) VALUES\n";
		foreach ($add_rows as $add_row) {
			if ($add_table=='seiten_attr') {
				unset($add_row['PAGE_ID']);
				$add_row['TPL_ID'] = 'TPL_NEW';
			}
			if ($i>30000) $i = 1;
			$lines[$n] = build_line($add_row,$insert,$i);
			$i += strlen($lines[$n]);$n++;
		}
		$return .= implode(",\n",$lines).";";
		return $return."\n-- # /DUMP # --\n\n-- # Schnipp --";
}	}
function build_line($row,$insert,$i,$lines='') {
	foreach ($row as $key => $data) $d[] = '"'.str_replace('\\\\','\\',addcslashes($data,'"')).'"';
	if (!empty($d[0])) {
		if ($i==1)	$lines .= $insert;
		return $lines.'('.implode(', ',$d).')';
}	}
function optimize_tables($tables='*',$info=true) {
	global $dbobj,$vorgaben,$error;
	if ($tables == '*')	$tables = $dbobj->exists(__file__,__line__,"SHOW TABLES LIKE '#PREFIX#%'");	//get all of the tables
	else				$tables = is_array($tables) ? $tables : explode(',',$tables);
	foreach($tables as $table)	{																				//cycle through
		if (is_array($table) && !empty($table['Tables_in_'.$dbobj->db.' ('.$vorgaben['db_prefix'].'%)']))	$t = $table['Tables_in_'.$dbobj->db.' ('.$vorgaben['db_prefix'].'%)'];
		else																								$t = '#PREFIX#'.$table;
		$ts[] = $t;
			$c_names = $dbobj->exists(__file__,__line__,'SELECT COLUMN_NAME
					  FROM INFORMATION_SCHEMA.COLUMNS
					 WHERE table_name = '.$t.'
					  [AND table_schema = '.$dbobj->db.']
					  [AND column_name LIKE "_ID"]');
/*			$dbobj->singlequery(__file__,__line__,'CREATE TABLE table_temp AS
					SELECT * FROM '.$t.' GROUP BY title, SID;
					DROP TABLE '.$t.';
					RENAME TABLE table_temp TO '.$t.';);');
*/	}
#	$dbobj->singlequery(__file__,__line__,'OPTIMIZE TABLE '.implode(', ',$ts));
	if ($info) $error[] = '%%TABELLEN_OPTIMIERT%%:</br>'.implode_ws($ts,' %%UND%%</br>',',</br>');
}
function cleanup_tables($tables='*',$info=true) {
	global $dbobj,$vorgaben,$error;
	if ($tables == '*')									$tables = $dbobj->exists(__file__,__line__,"SHOW TABLES LIKE '#PREFIX#%'");	//get all of the tables
	else												$tables = is_array($tables) ? $tables : explode(',',$tables);
	foreach($tables as $table)	{																			//cycle through
		if (is_array($table) && !empty($table['Tables_in_'.$dbobj->db.' ('.$vorgaben['db_prefix'].'%)']))	$t = $table['Tables_in_'.$dbobj->db.' ('.$vorgaben['db_prefix'].'%)'];
		else																								$t = '#PREFIX#'.$table;
		if ($t == $vorgaben['db_prefix'].'abschnitte') {
			$sql_a[] = "CREATE TABLE table_temp AS	SELECT DISTINCT * FROM ".$t.";";
			$sql_a[] = "DROP TABLE ".$t.";";
			$sql_a[] = "RENAME TABLE table_temp TO ".$t.";";
			$sql_a[] = "ALTER TABLE `".$t."` ADD PRIMARY KEY( LANG_ID, PAGE_ID, PART_ID);";
		} elseif ($t == $vorgaben['db_prefix'].'kategorien') {
			$sql_a[] = "CREATE TABLE table_temp AS	SELECT DISTINCT * FROM ".$t.";";
			$sql_a[] = "DROP TABLE ".$t.";";
			$sql_a[] = "RENAME TABLE table_temp TO ".$t.";";
			$sql_a[] = "ALTER TABLE `".$t."` ADD PRIMARY KEY(LANG_ID, KAT_ID);";
		} elseif ($t == $vorgaben['db_prefix'].'vorlagen') {
			$sql_a[] = "CREATE TABLE table_temp AS	SELECT DISTINCT * FROM ".$t.";";
			$sql_a[] = "DROP TABLE ".$t.";";
			$sql_a[] = "RENAME TABLE table_temp TO ".$t.";";
			$sql_a[] = "ALTER TABLE `".$t."` ADD PRIMARY KEY(TPL_ID);";
		} elseif ($t == $vorgaben['db_prefix'].'seiten_personen') {
			$sql_a[] = "CREATE TABLE table_temp AS	SELECT DISTINCT * FROM ".$t.";";
			$sql_a[] = "DROP TABLE ".$t.";";
			$sql_a[] = "RENAME TABLE table_temp TO ".$t.";";
			$sql_a[] = "ALTER TABLE `".$t."` ADD PRIMARY KEY(person_ID, attr_ID, attr);";
/*		} elseif ($t == $vorgaben['db_prefix'].'rights') {
			$sql_a[] = "CREATE TABLE table_temp AS	SELECT DISTINCT * FROM ".$t.";";
			$sql_a[] = "DROP TABLE ".$t.";";
			$sql_a[] = "RENAME TABLE table_temp TO ".$t.";";
			$sql_a[] = "ALTER TABLE `".$t."` ADD PRIMARY KEY( `person_ID, attr_ID, attr`);";
*/		} elseif ($t == $vorgaben['db_prefix'].'seiten') {
			$sql_a[] = "CREATE TABLE table_temp AS	SELECT DISTINCT * FROM ".$t.";";
			$sql_a[] = "DROP TABLE ".$t.";";
			$sql_a[] = "RENAME TABLE table_temp TO ".$t.";";
			$sql_a[] = "ALTER TABLE `".$t."` ADD PRIMARY KEY(LANG_ID, PAGE_ID);";
		} elseif ($t == $vorgaben['db_prefix'].'seiten_attr') {
			$sql_a[] = "CREATE TABLE table_temp AS	SELECT DISTINCT * FROM ".$t.";";
			$sql_a[] = "DROP TABLE ".$t.";";
			$sql_a[] = "RENAME TABLE table_temp TO ".$t.";";
			$sql_a[] = "ALTER TABLE `".$t."` ADD PRIMARY KEY(TPL_ID, KAT_ID, PAGE_ID);";
		} elseif ($t == $vorgaben['db_prefix'].'_translate') {
			$sql_a[] = "CREATE TABLE table_temp AS	SELECT DISTINCT * FROM ".$t.";";
			$sql_a[] = "DROP TABLE ".$t.";";
			$sql_a[] = "RENAME TABLE table_temp TO ".$t.";";
			$sql_a[] = "ALTER TABLE `".$t."` ADD PRIMARY KEY(LANG_ID, name);";
#		} else {
#			$sql_a[] = "CREATE TABLE tmp LIKE $t;";
#			$sql_a[] = "INSERT IGNORE INTO tmp SELECT * from $t;";
#			$sql_a[] = "RENAME table $t TO deleteme, tmp TO $t;";
#			$sql_a[] = "DROP TABLE deleteme;";
		}
	}
	if(!empty($sql_a))	$dbobj->multiquery(__file__,__line__,$sql_a);
#	if ($ids = $dbobj->tostring(__file__,__line__,'SELECT t1.PAGE_ID FROM #PREFIX#seiten_attr AS t1 LEFT JOIN #PREFIX#abschnitte AS t2 ON t1.PAGE_ID = t2.PAGE_ID WHERE t2.PAGE_ID IS NULL')) {	// Clean dangling sections
#		$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#abschnitte WHERE PAGE_ID IN ($ids);");
#	}
#	if ($ids = $dbobj->tostring(__file__,__line__,'SELECT t1.PAGE_ID FROM #PREFIX#seiten_attr AS t1 LEFT JOIN #PREFIX#seiten AS t2 ON t1.PAGE_ID = t2.PAGE_ID WHERE t2.PAGE_ID IS NULL')) {	// Clean dangling pages
#		$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#seiten_attr WHERE PAGE_ID IN ($ids);");
#	}
	if ($imgs = $dbobj->withkey(__file__,__line__,"SELECT * FROM #PREFIX#bilder",'BILD_ID',true)) {	// Clean images
		if ($tf = glob($vorgaben['img_path'].'/thumbs/*')) {	// find images
			foreach ($imgs as $bild_id => $img) {
				if (is_numeric($img['PART_ID']))	$filenames[$bild_id] = $vorgaben['img_path'].'/thumbs/'.$img['PAGE_ID'].'_'.$img['PART_ID'].'_'.$img['Dateiname'];
				else								$filenames[$bild_id] = $vorgaben['img_path'].'/thumbs/'.$img['PAGE_ID'].'_'.$img['Dateiname'];
				if (!in_array($filenames[$bild_id],$tf)) { // Images in DB but not in dir
					$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#bilder WHERE BILD_ID = $bild_id;");
			}	}
			$filenames = flattenArray($filenames);
			foreach ($tf as $filename) {
				if (!in_array($filename,$filenames)) { // Images in dir but not in db
					unlink($filename);									// and remove them
					$f = str_remove($filename,'/thumbs');
					if (is_file($f))	unlink($f);
	}	}	}	}
	if ($info) $error[] = '%%TABELLEN_AUFGERAEUMT%%:</br>'.implode_ws($tables,' %%UND%%</br>',',</br>');
}
function dump_tpl() {
	global $tplobj;
	$tpl['page'] = '<h1>%%MYSQL%%</h1>
	<form action="|PHPSELF|?page=|PAGE|" method="post">
		§PHPSESSID§
		<p><input class="btn next" type="submit" name="dump_mysql" value="%%DUMP%%" /><input class="btn save" type="submit" name="send" value="%%EINTRAGEN%%" /></p>
		<table style="clear:both;">
			<thead><tr>
				<th>%%DATUM%%</th>
				<th>%%ZEIT%%</th>
				<th>%%TABELLE%%</th>
				<th><a class="tog_chk import tooltip" title="%%ALLE_AUSWAEHLEN%%">%%IMPORT%%</a></th>
				<th><a class="tog_chkx remove tooltip" title="%%ALLE_AUSWAEHLEN%%">%%LOESCHEN%%</a></th>
			</tr></thead>
			<tbody class="specific">|SPECIFIC|</tbody>
			|GENERIC_TB|
		</table>
		|SUBNAV|
		<br /><input class="btn save" type="submit" name="send" value="%%EINTRAGEN%%" />
	</form>
	<h2 class="trigger mysqlfile cb" title="%%KLICK_TOGGLE%%" id="trigger_mysqlfile">%%IMPORTIEREN%%</h2>
	<form class="toggle_container" id="toggle_mysqlfile" action="|PHPSELF|?page=|PAGE|" method="post" enctype="multipart/form-data">
		§PHPSESSID§
		<input name="mysql" type="file" value="" size="30" />
		<p><input type="submit" name="send" class="tooltip btn save" value="%%UPLOAD%%" /></p>
	</form>
	<h2 class="trigger execmysql cb" title="%%KLICK_TOGGLE%%" id="trigger_execmysql">%%AUSFUEHREN%%</h2>
	<form class="toggle_container" id="toggle_execmysql" action="|PHPSELF|?page=|PAGE|" method="post">
		§PHPSESSID§
		<textarea id="mysqlexecute" cols="80" rows="3" name="mysqlexecute">|MYSQLEXECUTE|</textarea>
		<p><input type="submit" name="send" class="tooltip btn save" value="%%EINTRAGEN%%" /></p>
	</form>
	<h2 class="trigger moresql cb" title="%%KLICK_TOGGLE%%" id="trigger_moresql">%%MEHR%%</h2>
	<form class="toggle_container" id="toggle_moresql" action="|PHPSELF|?page=|PAGE|" method="post">
		§PHPSESSID§
		<p><input type="submit" name="mysqloptimize" class="tooltip btn" title="%%DATENBANK_OPTIMIEREN%%" style="background-image:url(/admin/icons/mysql-icon.png)" value="%%OPTIMIEREN%%" />
		<input type="submit" name="mysqlcleanup"  class="tooltip btn" title="%%DATENBANK_AUFRAEUMEN%%" style="background-image:url(/admin/icons/mysql-icon.png)" value="%%AUFRAEUMEN%%" />
		|DOWNLOADDB|
	</form>';
	$tpl['downloaddb'] ='<input type="submit" name="remotemysql" class="tooltip btn" title="%%DATENBANK_RUNTERLADEN%%" style="background-image:url(/admin/icons/mysql-icon.png)" value="%%RUNTERLADEN%%" /></p>';
	$tpl['generic_tb'] = '
			<thead><tr>
				<th colspan="3" class="trigger mysqlgeneric tooltip" title="%%KLICK_TOGGLE%%" id="trigger_mysqlgeneric"><h2>%%WEITERE_DATEIEN%%</h2></th>
			</tr></thead>
			<tbody class="toggle_container" id="toggle_mysqlgeneric">
				<th>%%DATUM%%</th>
				<th>%%ZEIT%%</th>
				<th>%%TABELLE%%</th>
				<th><a class="tog_chk import tooltip" title="%%ALLE_AUSWAEHLEN%%">%%IMPORT%%</a></th>
				<th><a class="tog_chkx remove tooltip" title="%%ALLE_AUSWAEHLEN%%">%%LOESCHEN%%</a></th>
			</tr>
				|GENERIC|</tbody><tr>';
	$tpl['line'] = '				<tr class="zeile">
					<td>|DATE|</td>
					<td>|TIME|</td>
					<td><a href="/download.php&d=intern/sql&f=|FILE|§SID§">|NAME|</a></td>
					<td><input class="chk import" type="checkbox" name="mysqldumps[]" value="|FILE|" /></td>
					<td><input class="chkx remove" type="checkbox" name="remove_file[]" value="|DIR||FILE|" /></td>
				</tr>';
	return $tplobj->read_tpls($tpl);
}
?>