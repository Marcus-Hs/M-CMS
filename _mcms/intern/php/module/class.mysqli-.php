<?php
function debug($level=1,$output='htmlpop') {
	global $dbobj;
	$dbobj->debug  = &$level;
	$dbobj->output = &$output;
}
class dbclass extends zugangsdaten {
	var $con;
	var $as_real;
	var $withkey;
	function __construct() {
		$this->zugangsdaten();
		$this->as_real = false;
		$this->withkey = false;
		$this->dbopen();
		mysqli_report(MYSQLI_REPORT_ERROR);
	}
	function __destruct() {
		if(!empty($this->con) && mysqli_close($this->con))	return true;
		else												return false;
	}
	function array2db($file,$line,$array,$table,$action='INSERT INTO',$where='') {
		$db = array();
		if (empty($array) || !is_array($array))	trigger_error($this->error()."\n No array given in File \"$file\"\non Line: $line\n\n", E_USER_ERROR);
		if (is_array($array)) {
			foreach ($array as $key => $data) {
				if (is_array($data) && $this->withkey == $key)				$db[$key] = r_implode(withkeyArray($data));
				elseif (is_array($data))									$db[$key] = r_implode($data);
				else														$db[$key] = $data;
			/*	if (!get_magic_quotes_gpc())	*/							$db[$key] = addcslashes($db[$key],'"');
				if (!empty($this->compress[$key]) && $this->compress[$key])	$db[$key] = '"'.addslashes(gzcompress($db[$key])).'"';
				elseif (empty($this->as_real) || !$this->as_real)			$db[$key] = '"'.my_htmlspecialchars($db[$key]).'"';
				elseif (!is_numeric($db[$key]))								$db[$key] = '"'.$db[$key].'"';
			}
			if ($action=='UPDATE') {
				foreach($db as $key => $data) 	$update[] = '`'.$key.'` = '.$data;
				$sql  = $action." ".$table." ".' SET '.implode(',',$update);
				if (!empty($where)) 			$sql  .= ' '.$where;
				elseif (!empty($array['ID'])) 	$sql  .= ' WHERE ID = '.$array['ID'];
/*				else {
					$primary_keys = $this->singlequery($file,$line,'SHOW INDEX FROM '.$table.' WHERE Key_name = \'PRIMARY\';');
				}
*/				else 							trigger_error($this->error()."\n Missing WHERE-clause in SQL. File \"$file\"\non Line: $line\n\n", E_USER_ERROR);
			} else {
				foreach($db as $key => $data) 	$update[] = '`'.$key.'` = '.$data;
				if (!empty($where) && $this->singlequery($file,$line,"UPDATE ".$table.' SET '.implode(', ',$update).' '.$where)) {
					return true;
				}
				$sql = $action." ".$table.' ( `'.implode('`,`',array_keys($db)).'` ) VALUES ('.implode(', ',$db).' ) ON DUPLICATE KEY UPDATE '.implode(', ',$update).';';
			}
			if (!empty($sql))	return $this->singlequery($file,$line,$sql);
			$this->withkey = false;
			$this->as_real = false;
	}	}
	function db2tpl($tpl_path,$table) {
		$tpl = file_get_contents($tpl_path);
		$sql = "SELECT * FROM ".$table;
		$this->singlequery(__file__,__line__,$sql);
		if (isset($this->data[0]))	{
			foreach ($this->data as $key => $data)	$tpl = str_replace("|".strtoupper($key)."|", $data, $tpl);
		}
		return $tpl;
	}
	function dbfields($file,$line,$table,$asarray=false) {
		unset($this->data);
		$this->dbquery('SHOW COLUMNS FROM '.$table.';',$file,$line);
		$this->dbfetch($file,$line);
		if (!empty($this->data)) {
			foreach ($this->data as $row) $out[$row['Field']] = $row;
			if ($asarray)	return $out;
			else			return array_keys($out);
	}	}
	function withkey($file,$line,$sql,$key='',$strip=false,$multi='',$multi2='',$unique=false) {
		if (empty($key))													list($x,$key,$tmp) = explode(' ',str_replace(array('	',','),' ',$sql),3);
		elseif (strpos($sql,$key) === false && strpos($sql,'*') === false)	$sql = str_replace('SELECT','SELECT '.$key.', ',$sql);
		$result = $this->singlequery($file,$line,$sql);
		if(!empty($result[0]) && is_array($result)) {
			foreach ($result as $n => $data) {
				if ($multi!='') {
					if ($multi2!='' && isset($data[$multi2])) {
						$withkey[$data[$key]][$data[$multi]][$data[$multi2]] = $data;
						if ($strip)	unset($withkey[$data[$key]][$data[$multi]][$data[$multi2]][$multi],$withkey[$data[$key]][$data[$multi]][$data[$multi2]][$multi2],$withkey[$data[$key]][$data[$multi]][$data[$multi2]][$key]);
					}
					elseif ($multi!='' && isset($data[$multi])) {
						if (empty($withkey[$data[$key]][$data[$multi]]))	$withkey[$data[$key]][$data[$multi]] = $data;
						else {
							$tmp = $data;
							if ($strip) 		unset($tmp[$key],$tmp[$multi]);
							if (count($tmp)==1) $withkey[$data[$key]][$data[$multi]][key($tmp)] .= ','.current($tmp);
							elseif (!$unique)	$withkey[$data[$key]][$data[$multi]][] = $tmp;
							unset($tmp);
						}
						if ($strip)	unset($withkey[$data[$key]][$data[$multi]][$key],$withkey[$data[$key]][$data[$multi]][$multi]);
					} elseif (!$unique)	 $withkey[$data[$key]][] = $data;
				} elseif (isset($data[$key])) {
					$withkey[$data[$key]] = $data;
					if ($strip)	unset($withkey[$data[$key]][$key]);
			}	}
			if (!empty($withkey))	return $withkey;
			else {
				trigger_error("No KEY given for withkey in File \"$file\"\non Line: $line with\n\n$sql\n\n", E_USER_ERROR);
				return false;
			}
		} else return false;
	}
	function count($file,$line,$sql,$return=false) {
		if ($exists = $this->exists($file,$line,$sql))	return count($exists);
		else											return false;
	}
	function max_free_id($table,$key='ID') {
		$sql = "SELECT MAX(".$key.")+1 from #PREFIX#".$table.";";
		return $this->tostring(__file__,__line__,$sql);
	}
	function next_free_id($table,$key='ID') {
		$sql = "SELECT CASE WHEN MIN(".$key.") IS NULL OR MIN(".$key.")>1
				THEN
					1
				ELSE
					(SELECT t1.".$key." + 1 FROM #PREFIX#".$table." AS t1
							WHERE NOT EXISTS (SELECT * FROM #PREFIX#".$table." AS t2
													 WHERE t2.".$key." = t1.".$key." + 1) LIMIT 1)
				END AS NextID
				FROM #PREFIX#".$table.";";
		return $this->tostring(__file__,__line__,$sql);
	}
	function toarray($file,$line,$sql,$return=false) {
		if ($exists = $this->exists($file,$line,$sql))	return flattenArray($exists);
		else											return false;
	}
	function tostring($file,$line,$sql,$sep=',') {
		if ($exists = $this->exists($file,$line,$sql))	return r_implode($sep,$exists);
		else											return false;
	}
	function coloumn_exists($file,$line,$table,$coloumn) {
		if ($this->exists($file,$line, "SHOW COLUMNS FROM `".$table."` LIKE '".$coloumn."';"))	return true;
		else																					return false;
	}
	function table_exists($file,$line,$table) {
		if ($this->exists($file,$line, "SHOW TABLES LIKE '".$table."';"))	return true;
		else																return false;
	}
	function exists($file,$line,$sql,$return=false) {
		unset($this->data,$exists);
		$exists = $this->singlequery($file,$line,$sql);
		if (!empty($exists[0])) return $exists;
		else					return false;
	}
	function multiquery($file,$line,$sql_array,$lock=false) {
		unset($this->data,$this->multi);
		if ($lock!==false && is_array($lock)) {
			$this->lock_tables($lock);
		}
		foreach($sql_array as $key => $sql) {
			$this->dbquery($sql,$file,$line);
			if (strpos(strtolower($sql),'select')!==false && strpos(strtolower($sql),'select')==0) {
				$this->dbfetch($file,$line,0,$sql);
				if (!empty($this->data)) $this->multi[$key] = $this->data;
				unset($this->data);
		}	}
		if ($lock!==false){
			$this->unlock_tables($file,$line);
		}
		if (!empty($this->multi))	return $this->multi;
	}
	function count_rows($file,$line,$sql='',$lock=false) {
		unset($this->data);
		$this->res = mysqli_query($this->con,$sql);
		return mysqli_num_rows($this->res);
	}
	function singlequery($file,$line,$sql='',$lock=false) {
		unset($this->data);
		if ($lock!==false && is_array($lock)) {
			$this->lock_tables($lock);
		}
		if (!empty($sql) && $this->dbquery($sql,$file,$line)) {
			if ((strpos(strtolower($sql),'select')!==false && strpos(strtolower($sql),'select')==0 && strpos(strtolower($sql),'update')==0) ||
				(strpos(strtolower($sql),'show')  !==false && strpos(strtolower($sql),'show')==0)) {
				$this->dbfetch($file,$line,0,$sql);
		}	}
		if ($lock=='end'){
			$this->unlock_tables($file,$line);
		}
		if (!empty($this->data)) {
			if (!empty($this->showres)) {
				info($this->data,$this->output);
				$this->showres = 0;
			}
			return $this->data;
		}
		if ($this->mysqli_mod_rows()!=0)	return true;
		else								return false;
	}
	function lock_tables($file,$line,$lock) {
		foreach ($lock as $rw => $tables) {
			foreach ($tables as $table) {
				$lock_sql[] = '#PREFIX#'.$table.' '.$rw;
		}	}
		$this->dbquery('SET autocommit=0;\n-LOCK TABLES '.r_implode($lock_sql,',').';',$file,$line);
		$this->tables_locked=$lock;
	}
	function unlock_tables($file,$line) {
		$this->dbquery("COMMIT;",$file,$line);
	#	$this->dbquery("UNLOCK TABLES;",$file,$line);
		unset($this->tables_locked);
	}
	function dbquery($sql='',$file='',$line='') {
		global $vorgaben;
		$sql = str_replace('#PREFIX#',$vorgaben['db_prefix'],$sql);
		if ($this->res = $this->do_query($sql,$file,$line))	return true;
		else 												return false;
	}
	function dbfetch($file,$line,$i=0,$sql='') {
		if ($this->res) {
			while($row = mysqli_fetch_assoc($this->res)) {
				foreach ($row as $key => $element) {
					if (!empty($this->compress[$key]) && $this->compress[$key] && !$element = gzuncompress($element))	return false;
					$this->data[$i][$key] = $element;
				}
				$i++;
			}
			mysqli_free_result($this->res);
		}
		else {
			info($file.': '.$line);
			info($this->res);
			info($sql);
		}
		if (empty($this->data[0])) {
			$this->data[0] = array();
			return false;
		} elseif (!empty($this->res)) {
			return true;
	}	}
	function dbopen($db='',$user='',$pass='') {
		if (empty($db))		$db   = $this->db;
		if (empty($user))	$user = $this->user;
		if (empty($pass))	$pass = $this->pass;
#		$mysqli = mysqli_init();
		if ($this->con = mysqli_connect($this->host,$user,$pass,$db/*,false,mysqli_CLIENT_COMPRESS*/)) {
			if (mysqli_select_db($this->con,$db))	return true;
			else 									return false;
		} else 										return false;
	}
	function do_query($sql,$file,$line) {
		global $error,$vorgaben,$sub_tpl;
		$this->num_rows = 0;
		$vorgaben['skip_err'] = 1;
		if (isset($_REQUEST['pqp'])) $start = microtime(true);
		$output = '';
		if (!empty($this->debug)) exec_time();
		if (!empty($this->fake) && $this->fake==true) {
			info($sql,$dbobj->output);
			return false;
		}
		if ($stmt = mysqli_prepare($this->con,$sql)) {
			if(!$this->res = mysqli_query($this->con,$sql)) {
				trigger_error($this->error()."\n\nIn File \"$file\" on Line: $line with query:\n\n $sql\n\n", E_USER_ERROR);
	 	}
  #	mysqli_stmt_execute($stmt);
		#	mysqli_stmt_store_result($stmt);
			if (strpos(strtolower($sql),'select')!==false && strpos(strtolower($sql),'select')==0 && !empty($this->res))
				$this->num_rows =  mysqli_stmt_num_rows($stmt);
			if (isset($this->debug) && ($vorgaben['localhost'] || (!empty($_SESSION['status']) && $_SESSION['status'] == 'Admin'))) {
				if ($this->debug == 0)	info($sql,$this->output);
				elseif ($this->debug >= 1) {
					$sub_tpl['style']['mysqli_debug'] ='						.mysqli_debug {border: 1px solid #ff0000;color:#000;background-color: #fff;}
						.mysqli_debug td {font-size:.8em;vertical-align:top;padding-right:1em;}
						.mysqli_debug b {display:block;width:25%;clear:left;}
						.mysqli_debug .rows {display:block;width:100%;font: 10px verdana;}
						.mysqli_debug .rows {background-color: #ff0000; color: #ffffff; font-weight: bold;}
						.mysqli_debug .sql  {overflow: auto;}
						.mysqli_debug .sql  {overflow: auto;white-space:pre-wrap;}';
					$msg = '<table class=\'mysqli_debug\'><tr><td width="150px;">
								<b>Error:</b>'		.$this->errno().'<br />
								<b>Description:</b>'.$this->error().'<br />
								<b>Time:</b>'		.date("H:i:s, jS F, Y").'<br />
								<b>Script:</b>'		.$file.'<br />
								<b>Line:</b>'.$line.'<br />
								<b>Affected:</b>'.mysqli_affected_rows($this->con).' rows<br />
								<b>Processes:</b>';
				#	$result = mysqli_thread_id($this->con);
					if (!is_bool($this->res)) {
						while ($row = mysqli_fetch_assoc($this->res))  $msg .= $row["Id"].' '.$row["Command"].' '.$row["Time"];
						mysqli_free_result($this->res);
					}
					$msg .= "</td>\n<td>".'<span class="rows">'.$this->num_rows.' rows found ('.exec_time().').</span><span class="sql">'.my_htmlentities($sql).'</span></td></tr></table>';
				}
				if ($this->debug == 2)	$this->showres = 1;
				if ($this->debug == 3 || $this->debug == 4) {
					$tablescan	=	false;
					$explain = mysqli_multi_query('EXPLAIN '.$sql);
					while($row = mysqli_fetch_assoc($explain)) {
						foreach ($row as $key => $element ) {
							if (empty($data[$key])) $data[$key]  = '<th>'.$key.'</th><td>'.$element.'</td>';
							else					$data[$key] .= '<td>'.$element.'</td>';
							if ($key == 'type' && strpos($element,'ALL')!==false) $tablescan=true;
					}	}
					mysqli_free_result($result);
					if ($this->debug == 3 || $tablescan) {
						$msg .= '<table class="mysqli_debug">';
						foreach ($data as $element)  $msg .= '<tr>'.$element.'</tr>';
						$msg .= '</table>';
				}	}
				if (!empty($msg)) info($msg,$this->output);
				if ($this->debug<99) unset($this->debug);
			}
			unset($vorgaben['skip_err']);
			if (isset($_REQUEST['pqp'])) {
				$this->queries[] = array('sql'=>$sql,'time'=>(microtime(true)-$start)*1000,'file'=>$file,'line'=>$line);
			}
			mysqli_stmt_free_result($stmt);
			mysqli_stmt_close($stmt);
			return $this->res;
		} else {
			unset($vorgaben['skip_err']);
			$this->mysqli_errno = $this->errno();
			if (empty($vorgaben['skip_err']) && !empty($this->mysqli_errno))
				trigger_error($this->mysqli_errno.' '.$this->error()."\n\nIn File \"$file\" on Line: $line with query:\n\n $sql\n\n", E_USER_ERROR);
			return false;
	}	}
	public static function errno()		{return mysqli_connect_errno();}
	public function error()				{return mysqli_connect_error();}
	public function last_id()			{return mysqli_insert_id($this->con);}
	public function escape($string) 	{return mysqli_real_escape_string($this->con,$string);}
	public function mysqli_mod_rows() {
		if (isset($this->num_rows))	return $this->num_rows;
		$info_str = mysqli_info($this->con);
		$a_rows = mysqli_affected_rows($this->con);
		mb_ereg("Rows matched: ([0-9]*)", $info_str, $r_matched);
		if (isset($r_matched[1]))	return $r_matched[1];
		else						return $a_rows;
}	}
?>