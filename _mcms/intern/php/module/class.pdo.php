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
	}
	function __destruct() {
        $this->con = null;
        $this->isConnected = false;
		return true;
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
		if ($this->num_rows!=0)	return true;
		else					return false;
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
			while($row = $this->res->fetch(PDO::FETCH_ASSOC)) {
				foreach ($row as $key => $element) {
					if (!empty($this->compress[$key]) && $this->compress[$key] && !$element = gzuncompress($element))	return false;
					$this->data[$i][$key] = $element;
				}
				$i++;
			}
		} else {
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
	function dbopen($db='',$user='',$pass='',$host='') {
		if (empty($driver))	$driver  = 'mysql';
		if (empty($db))		$db   = $this->db;
		if (empty($host))	$host = $this->host;
		$dsn = $driver.':dbname='.$db.';host='.$host;
		if (empty($user))	$user = $this->user;
		if (empty($pass))	$pass = $this->pass;
		try {
			$this->con = new PDO($dsn, $user, $pass);
			$this->con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch( PDOException $Exception ) {   
			 echo "Unable to connect to database.";
			 exit;
		}
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
		if ($stmt = $this->con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY))) {
			$stmt->execute();
			if (strpos(strtolower($sql),'select')!==false && strpos(strtolower($sql),'select')==0 && !empty($stmt))
				$this->num_rows =  $stmt->rowCount();
			if (isset($this->debug) && ($vorgaben['localhost'] || (!empty($_SESSION['status']) && $_SESSION['status'] == 'Admin'))) {
				if ($this->debug == 0)	info($sql,$this->output);
				elseif ($this->debug >= 1) {
					$sub_tpl['style']['pdo_debug'] ='
						.pdo_debug {border: 1px solid #ff0000;color:#000;background-color: #fff;}
						.pdo_debug td {font-size:.8em;vertical-align:top;padding-right:1em;}
						.pdo_debug b {display:block;width:25%;clear:left;}
						.pdo_debug .rows {display:block;width:100%;font: 10px verdana;}
						.pdo_debug .rows {background-color: #ff0000; color: #ffffff; font-weight: bold;}
						.pdo_debug .sql  {overflow: auto;}
						.pdo_debug .sql  {overflow: auto;white-space:pre-wrap;}';
					$msg = '<table class=\'pdo_debug\'><tr><td width="150px;">
								<b>Error:</b>'		.$this->errno().'<br />
								<b>Description:</b>'.$this->error().'<br />
								<b>Time:</b>'		.date("H:i:s, jS F, Y").'<br />
								<b>Script:</b>'		.$file.'<br />
								<b>Line:</b>'.$line.'<br />
								<b>Affected:</b>'.$stmt->rowCount().' rows<br />
								<b>Processes:</b>';
				#	$result = mysqli_thread_id($this->con);
					if (!is_bool($this->res)) {
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
							$msg .= $row["Id"].' '.$row["Command"].' '.$row["Time"];
						$this->res = null;
					}
					$msg .= "</td>\n<td>".'<span class="rows">'.$this->num_rows.' rows found ('.exec_time().').</span><span class="sql">'.my_htmlentities($sql).'</span></td></tr></table>';
				}
				if ($this->debug == 2)	$this->showres = 1;
				if ($this->debug == 3 || $this->debug == 4) {
					$tablescan	=	false;
					$explain = $this->con->prepare('EXPLAIN '.$sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
					while($row = $explain->fetch(PDO::FETCH_ASSOC)) {
						foreach ($row as $key => $element ) {
							if (empty($data[$key])) $data[$key]  = '<th>'.$key.'</th><td>'.$element.'</td>';
							else					$data[$key] .= '<td>'.$element.'</td>';
							if ($key == 'type' && strpos($element,'ALL')!==false) $tablescan=true;
					}	}
				#	mysqli_free_result($result);
					if ($this->debug == 3 || $tablescan) {
						$msg .= '<table class="pdo_debug">';
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
			return $stmt;
		} else {
			unset($vorgaben['skip_err']);
			$this->pdo_errno = $this->errno();
			if (empty($vorgaben['skip_err']) && !empty($this->pdo_errno))
				trigger_error($this->pdo_errno.' '.$this->error()."\n\nIn File \"$file\"<br />on Line: $line <br />with query:\n\n $sql\n\n", E_USER_ERROR);
			return false;
	}	}
	public static function errno()		{global $dbobj; return $dbobj->con->errorCode();}
	public function error()				{global $dbobj; return $dbobj->con->errorInfo();}
	public function last_id()			{global $dbobj; return $dbobj->con->lastInsertId();}
	public function escape($string) 	{return addslashes($string);}
}
?>