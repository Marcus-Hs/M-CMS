<?php

/* - - - - - - - - - - - - - - - - - - - - - - - - - - -

 Title : HTML Output for Php Quick Profiler
 Author : Created by Ryan Campbell
 URL : http://particletree.com/features/php-quick-profiler/

 Last Updated : April 22, 2009

 Description : This is a horribly ugly function used to output
 the PQP HTML. This is great because it will just work in your project,
 but it is hard to maintain and read. See the README file for how to use
 the Smarty file we provided with PQP.

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
start_pqp();

function start_pqp() {
	global $vorgaben,$profiler;
	if ((!empty($_SESSION['status']) && !is_numeric($_SESSION['status'])) || $vorgaben['localhost']) {
		if (!empty($_SERVER['REQUEST_TIME']))	$profiler = new PhpQuickProfiler($_SERVER['REQUEST_TIME']);
		else									$profiler = new PhpQuickProfiler(PhpQuickProfiler::getMicroTime());
}	}
function run_pqp() {
	global $vorgaben,$page_id,$error,$profiler;
	if (((!empty($_SESSION['status']) && !is_numeric($_SESSION['status'])) || $vorgaben['localhost'])
	   && (!empty($page_id) || $vorgaben['admin']) && empty($error)) {
		global $dbobj,$profiler;
		Console::logSpeed();
		Console::logMemory();
		return $profiler->display();
}	}

function displayPqp($output, $config) {
	global $vorgaben;

$cssUrl = $vorgaben['sub_dir'].'/admin/pQp.css';

$out = '<!-- JavaScript -->
<script type="text/javascript">
	var PQP_DETAILS = true;
	var PQP_HEIGHT = "short";

	addEvent(window, "load", loadCSS);

	function changeTab(tab) {
		var pQp = document.getElementById("pQp");
		hideAllTabs();
		addClassName(pQp, tab, true);
	}

	function hideAllTabs() {
		var pQp = document.getElementById("pQp");
		removeClassName(pQp, "console");
		removeClassName(pQp, "speed");
		removeClassName(pQp, "queries");
		removeClassName(pQp, "memory");
		removeClassName(pQp, "files");
	}

	function toggleDetails(){
		var container = document.getElementById("pqp-container");

		if(PQP_DETAILS){
			addClassName(container, "hideDetails", true);
			PQP_DETAILS = false;
		}
		else{
			removeClassName(container, "hideDetails");
			PQP_DETAILS = true;
	}	}
	function toggleHeight(){
		var container = document.getElementById("pqp-container");

		if(PQP_HEIGHT == "short"){
			addClassName(container, "tallDetails", true);
			PQP_HEIGHT = "tall";
		}
		else{
			removeClassName(container, "tallDetails");
			PQP_HEIGHT = "short";
	}	}

	function loadCSS() {
		var sheet = document.createElement("link");
		sheet.setAttribute("rel", "stylesheet");
		sheet.setAttribute("type", "text/css");
		sheet.setAttribute("href", "'.$cssUrl.'");
		document.getElementsByTagName("head")[0].appendChild(sheet);
		setTimeout(function(){document.getElementById("pqp-container").style.display = "block"}, 10);
	}

	//http://www.bigbold.com/snippets/posts/show/2630
	function addClassName(objElement, strClass, blnMayAlreadyExist){
	   if ( objElement.className ){
		  var arrList = objElement.className.split(" ");
		  if ( blnMayAlreadyExist ){
			 var strClassUpper = strClass.toUpperCase();
			 for ( var i = 0; i < arrList.length; i++ ){
				if ( arrList[i].toUpperCase() == strClassUpper ){
				   arrList.splice(i, 1);
				   i--;
				 }
			   }
		  }
		  arrList[arrList.length] = strClass;
		  objElement.className = arrList.join(" ");
	   }
	   else{
		  objElement.className = strClass;
		  }
	}

	//http://www.bigbold.com/snippets/posts/show/2630
	function removeClassName(objElement, strClass){
	   if ( objElement.className ){
		  var arrList = objElement.className.split(" ");
		  var strClassUpper = strClass.toUpperCase();
		  for ( var i = 0; i < arrList.length; i++ ){
			 if ( arrList[i].toUpperCase() == strClassUpper ){
				arrList.splice(i, 1);
				i--;
			 }
		  }
		  objElement.className = arrList.join(" ");
	   }
	}

	//http://ejohn.org/projects/flexible-javascript-events/
	function addEvent( obj, type, fn ) {
	  if ( obj.attachEvent ) {
		obj["e"+type+fn] = fn;
		obj[type+fn] = function() { obj["e"+type+fn]( window.event ) };
		obj.attachEvent( "on"+type, obj[type+fn] );
	  }
	  else{
		obj.addEventListener( type, fn, false );
	  }
	}
</script>
<div id="pqp-container" class="pQp" style="display:none">
<div id="pQp" class="console">
<table id="pqp-metrics" cellspacing="0">
<tr>
	<td class="green" onclick="changeTab(\'console\');">
		<var>'.count($output['logs']['console']).'</var>
		<h4>Console</h4>
	</td>
	<td class="blue" onclick="changeTab(\'speed\');">
		<var>'.$output['speedTotals']['total'].'</var>
		<h4>Load Time</h4>
	</td>
	<td class="purple" onclick="changeTab(\'queries\');">
		<var>'.$output['queryTotals']['count'].' Queries</var>
		<h4>Database</h4>
	</td>
	<td class="orange" onclick="changeTab(\'memory\');">
		<var>'.$output['memoryTotals']['used'].'</var>
		<h4>Memory Used</h4>
	</td>
	<td class="red" onclick="changeTab(\'files\');">
		<var>'.count($output['files']).' Files</var>
		<h4>Included</h4>
	</td>
</tr>
</table><div id="pqp-console" class="pqp-box">';

if(count($output['logs']['console']) ==  0) {
	$out .= '<h3>This panel has no log items.</h3>';
}
else {
	$out .= '<table class="side" cellspacing="0">
		<tr>
			<td class="alt1"><var>'.$output['logs']['logCount'].'</var><h4>Logs</h4></td>
			<td class="alt2"><var>'.$output['logs']['errorCount'].'</var> <h4>Errors</h4></td>
		</tr>
		<tr>
			<td class="alt3"><var>'.$output['logs']['memoryCount'].'</var> <h4>Memory</h4></td>
			<td class="alt4"><var>'.$output['logs']['speedCount'].'</var> <h4>Speed</h4></td>
		</tr>
		</table>
		<table class="main" cellspacing="0">';

		$class = '';
		foreach($output['logs']['console'] as $log) {
			$out .= '<tr class="log-'.$log['type'].'">
				<td class="type">'.$log['type'].'</td>
				<td class="'.$class.'">';
			if($log['type'] == 'log') {
				$out .= '<div><pre>'.$log['data'].'</pre></div>';
			}
			elseif($log['type'] == 'memory') {
				$out .= '<div><pre>'.$log['data'].'</pre> <em>'.$log['dataType'].'</em>: '.$log['name'].' </div>';
			}
			elseif($log['type'] == 'speed') {
				$out .= '<div><pre>'.$log['data'].'</pre> <em>'.$log['name'].'</em></div>';
			}
			elseif($log['type'] == 'error') {
				$out .= '<div><em>Line '.$log['line'].'</em> : '.$log['data'].' <pre>'.$log['file'].'</pre></div>';
			}

			$out .= '</td></tr>';
			if($class == '') $class = 'alt';
			else $class = '';
		}

		$out .= '</table>';
}

$out .= '</div><div id="pqp-speed" class="pqp-box">';

if($output['logs']['speedCount'] ==  0) {
	$out .= '<h3>This panel has no log items.</h3>';
}
else {
	$out .= '<table class="side" cellspacing="0">
		  <tr><td><var>'.$output['speedTotals']['total'].'</var><h4>Load Time</h4></td></tr>
		  <tr><td class="alt"><var>'.$output['speedTotals']['allowed'].'</var> <h4>Max Execution Time</h4></td></tr>
		 </table>
		<table class="main" cellspacing="0">';

		$class = '';
		foreach($output['logs']['console'] as $log) {
			if($log['type'] == 'speed') {
				$out .= '<tr class="log-'.$log['type'].'">
				<td class="'.$class.'">';
				$out .= '<div><pre>'.$log['data'].'</pre> <em>'.$log['name'].'</em></div>';
				$out .= '</td></tr>';
				if($class == '') $class = 'alt';
				else $class = '';
			}
		}

		$out .= '</table>';
}

$out .= '</div><div id="pqp-queries" class="pqp-box">';

if($output['queryTotals']['count'] ==  0) {
	$out .= '<h3>This panel has no log items.</h3>';
}
else {
	$out .= '<table class="side" cellspacing="0">
		  <tr><td><var>'.$output['queryTotals']['count'].'</var><h4>Total Queries</h4></td></tr>
		  <tr><td class="alt"><var>'.$output['queryTotals']['time'].'</var> <h4>Total Time</h4></td></tr>
		  <tr><td><var>0</var> <h4>Duplicates</h4></td></tr>
		 </table>
		<table class="main" cellspacing="0">';

		$class = '';
		foreach($output['queries'] as $query) {
			$out .= '<tr>
				<td class="'.$class.'">'.$query['sql'];
			if(!empty($query['explain'])) {
					$out .= '<em>
						Possible keys: <b>'.$query['explain']['possible_keys'].'</b> &middot;
						Key Used: <b>'.$query['explain']['key'].'</b> &middot;
						Type: <b>'.$query['explain']['type'].'</b> &middot;
						Rows: <b>'.$query['explain']['rows'].'</b> &middot;
					</em>';
			}
			$out .= '<em>
				Speed: <b>'.$query['time'].'</b>
				File: <b>'.$query['file'].'</b> &middot;
				Line: <b>'.$query['line'].'</b> &middot;
			</em>';
			$out .= '</td></tr>';
			if($class == '') $class = 'alt';
			else $class = '';
		}

		$out .= '</table>';
}

$out .= '</div><div id="pqp-memory" class="pqp-box">';

if($output['logs']['memoryCount'] ==  0) {
	$out .= '<h3>This panel has no log items.</h3>';
}
else {
	$out .= '<table class="side" cellspacing="0">
		  <tr><td><var>'.$output['memoryTotals']['used'].'</var><h4>Used Memory</h4></td></tr>
		  <tr><td class="alt"><var>'.$output['memoryTotals']['total'].'</var> <h4>Total Available</h4></td></tr>
		 </table>
		<table class="main" cellspacing="0">';

		$class = '';
		foreach($output['logs']['console'] as $log) {
			if($log['type'] == 'memory') {
				$out .= '<tr class="log-'.$log['type'].'">';
				$out .= '<td class="'.$class.'"><b>'.$log['data'].'</b> <em>'.$log['dataType'].'</em>: '.$log['name'].'</td>';
				$out .= '</tr>';
				if($class == '') $class = 'alt';
				else $class = '';
			}
		}

		$out .= '</table>';
}

$out .= '</div><div id="pqp-files" class="pqp-box">';

if($output['fileTotals']['count'] ==  0) {
	$out .= '<h3>This panel has no log items.</h3>';
}
else {
	$out .= '<table class="side" cellspacing="0">
			<tr><td><var>'.$output['fileTotals']['count'].'</var><h4>Total Files</h4></td></tr>
			<tr><td class="alt"><var>'.$output['fileTotals']['size'].'</var> <h4>Total Size</h4></td></tr>
			<tr><td><var>'.$output['fileTotals']['largest'].'</var> <h4>Largest</h4></td></tr>
		 </table>
		<table class="main" cellspacing="0">';

		$class ='';
		foreach($output['files'] as $file) {
			$out .= '<tr><td class="'.$class.'"><b>'.$file['size'].'</b> '.$file['name'].'</td></tr>';
			if($class == '') $class = 'alt';
			else $class = '';
		}

		$out .= '</table>';
}

$out .= '</div><table id="pqp-footer" cellspacing="0">
		<tr>
			<td class="credit">
				<a href="http://particletree.com" target="_blank">
				<strong>PHP</strong>
				<b class="green">Q</b><b class="blue">u</b><b class="purple">i</b><b class="orange">c</b><b class="red">k</b>
				Profiler</a></td>
			<td class="actions">
				<a href="#" onclick="toggleDetails();return false">Details</a>
				<a class="heightToggle" href="#" onclick="toggleHeight();return false">Height</a>
			</td>
		</tr>
	</table>
</div></div>';
return $out;
}

/* - - - - - - - - - - - - - - - - - - - - -

 Title : PHP Quick Profiler Console Class
 Author : Created by Ryan Campbell
 URL : http://particletree.com/features/php-quick-profiler/

 Last Updated : April 22, 2009

 Description : This class serves as a wrapper around a global
 php variable, debugger_logs, that we have created.

- - - - - - - - - - - - - - - - - - - - - */

class Console {
	
	/*-----------------------------------
		 LOG A VARIABLE TO CONSOLE
	------------------------------------*/
	
	public static function log($data) {
		$logItem = array(
			"data" => $data,
			"type" => 'log'
		);
		if (empty($GLOBALS['debugger_logs']['logCount']))	$GLOBALS['debugger_logs']['logCount'] = 0;
		$GLOBALS['debugger_logs']['console'][] = $logItem;
		$GLOBALS['debugger_logs']['logCount'] += 1;
	}
	
	/*---------------------------------------------------
		 LOG MEMORY USAGE OF VARIABLE OR ENTIRE SCRIPT
	-----------------------------------------------------*/
	
	public static function logMemory($object = false, $name = 'PHP') {
		$memory = memory_get_usage();
		if($object) $memory = strlen(serialize($object));
		$logItem = array(
			"data" => $memory,
			"type" => 'memory',
			"name" => $name,
			"dataType" => gettype($object)
		);
		$GLOBALS['debugger_logs']['console'][] = $logItem;
		if (empty($GLOBALS['debugger_logs']['memoryCount']))	$GLOBALS['debugger_logs']['memoryCount'] = 0;
		$GLOBALS['debugger_logs']['memoryCount'] += 1;
	}
	
	/*-----------------------------------
		 LOG A PHP EXCEPTION OBJECT
	------------------------------------*/
	
	public static function logError($exception, $message) {
		$logItem = array(
			"data" => $message,
			"type" => 'error',
			"file" => $exception->getFile(),
			"line" => $exception->getLine()
		);
		$GLOBALS['debugger_logs']['console'][] = $logItem;
		if (empty($GLOBALS['debugger_logs']['errorCount']))	$GLOBALS['debugger_logs']['errorCount'] = 0;
		$GLOBALS['debugger_logs']['errorCount'] += 1;
	}
	
	/*------------------------------------
		 POINT IN TIME SPEED SNAPSHOT
	-------------------------------------*/
	
	public static function logSpeed($name = 'Point in Time') {
		$logItem = array(
			"data" => PhpQuickProfiler::getMicroTime(),
			"type" => 'speed',
			"name" => $name
		);
		$GLOBALS['debugger_logs']['console'][] = $logItem;
		if (empty($GLOBALS['debugger_logs']['speedCount']))	$GLOBALS['debugger_logs']['speedCount'] = 0;
		$GLOBALS['debugger_logs']['speedCount'] += 1;
	}
	
	/*-----------------------------------
		 SET DEFAULTS & RETURN LOGS
	------------------------------------*/
	
	public static function getLogs() {
		if(empty($GLOBALS['debugger_logs']['memoryCount'])) $GLOBALS['debugger_logs']['memoryCount'] = 0;
		if(empty($GLOBALS['debugger_logs']['logCount'])) $GLOBALS['debugger_logs']['logCount'] = 0;
		if(empty($GLOBALS['debugger_logs']['speedCount'])) $GLOBALS['debugger_logs']['speedCount'] = 0;
		if(empty($GLOBALS['debugger_logs']['errorCount'])) $GLOBALS['debugger_logs']['errorCount'] = 0;
		return $GLOBALS['debugger_logs'];
	}
}

/* - - - - - - - - - - - - - - - - - - - - -

 Title : PHP Quick Profiler Class
 Author : Created by Ryan Campbell
 URL : http://particletree.com/features/php-quick-profiler/

 Last Updated : April 22, 2009

 Description : This class processes the logs and organizes the data
 for output to the browser. Initialize this class with a start time at
 the beginning of your code, and then call the display method when your code
 is terminating.

- - - - - - - - - - - - - - - - - - - - - */

class PhpQuickProfiler {

	public $output = array();
	public $config = '';

	public function __construct($startTime, $config = '/admin/') {
		$this->startTime = $startTime;
		$this->config = $config;
	}

	/*-------------------------------------------
		 FORMAT THE DIFFERENT TYPES OF LOGS
	-------------------------------------------*/

	public function gatherConsoleData() {
		$logs = Console::getLogs();
		if($logs['console']) {
			foreach($logs['console'] as $key => $log) {
				if($log['type'] == 'log') {
					$logs['console'][$key]['data'] = print_r($log['data'], true);
				}
				elseif($log['type'] == 'memory') {
					$logs['console'][$key]['data'] = $this->getReadableFileSize($log['data']);
				}
				elseif($log['type'] == 'speed') {
					$logs['console'][$key]['data'] = $this->getReadableTime(($log['data'] - $this->startTime)*1000);
				}
			}
		}
		$this->output['logs'] = $logs;
	}

	/*-------------------------------------------
		AGGREGATE DATA ON THE FILES INCLUDED
	-------------------------------------------*/

	public function gatherFileData() {
		$files = get_included_files();
		$fileList = array();
		$fileTotals = array(
			"count" => count($files),
			"size" => 0,
			"largest" => 0,
		);

		foreach($files as $key => $file) {
			$size = filesize($file);
			$fileList[] = array(
					'name' => $file,
					'size' => $this->getReadableFileSize($size)
				);
			$fileTotals['size'] += $size;
			if($size > $fileTotals['largest']) $fileTotals['largest'] = $size;
		}

		$fileTotals['size'] = $this->getReadableFileSize($fileTotals['size']);
		$fileTotals['largest'] = $this->getReadableFileSize($fileTotals['largest']);
		$this->output['files'] = $fileList;
		$this->output['fileTotals'] = $fileTotals;
	}

	/*-------------------------------------------
		 MEMORY USAGE AND MEMORY AVAILABLE
	-------------------------------------------*/

	public function gatherMemoryData() {
		$memoryTotals = array();
		$memoryTotals['used'] = $this->getReadableFileSize(memory_get_peak_usage());
		$memoryTotals['total'] = ini_get("memory_limit");
		$this->output['memoryTotals'] = $memoryTotals;
	}

	/*--------------------------------------------------------
		 QUERY DATA -- DATABASE OBJECT WITH LOGGING REQUIRED
	----------------------------------------------------------*/

	public function gatherQueryData() {
		global $dbobj;
		$queryTotals = array();
		$queryTotals['count'] = 0;
		$queryTotals['time'] = 0;
		$queries = array();

		if(!empty($dbobj->queries)) {
			$queryTotals['count'] = count($dbobj->queries);
			foreach($dbobj->queries as $key => $query) {
				$query = $this->attemptToExplainQuery($query);
				$queryTotals['time'] += $query['time'];
				$query['time'] = $this->getReadableTime($query['time']);
				$queries[] = $query;
			}
		}

		$queryTotals['time'] = $this->getReadableTime($queryTotals['time']);
		$this->output['queries'] = $queries;
		$this->output['queryTotals'] = $queryTotals;
	}

	/*--------------------------------------------------------
		 CALL SQL EXPLAIN ON THE QUERY TO FIND MORE INFO
	----------------------------------------------------------*/

	function attemptToExplainQuery($query) {
		global $dbobj;
		try {
			$rs = $dbobj->singlequery(__file__,__line__,'EXPLAIN '.$query['sql']);
		}
		catch(Exception $e) {}
		if($rs) {
			$row = $dbobj->singlequery(__file__,__line__,$rs);
			$query['explain'] = $row;
		}
		return $query;
	}

	/*-------------------------------------------
		 SPEED DATA FOR ENTIRE PAGE LOAD
	-------------------------------------------*/

	public function gatherSpeedData() {
		$speedTotals = array();
		$speedTotals['total'] = $this->getReadableTime(($this->getMicroTime() - $this->startTime)*1000);
		$speedTotals['allowed'] = ini_get("max_execution_time");
		$this->output['speedTotals'] = $speedTotals;
	}

	/*-------------------------------------------
		 HELPER FUNCTIONS TO FORMAT DATA
	-------------------------------------------*/

	static function getMicroTime() {
		$time = microtime();
		$time = explode(' ', $time);
		return $time[1] + $time[0];
	}

	public function getReadableFileSize($size, $retstring = null) {
			// adapted from code at http://aidanlister.com/repos/v/function.size_readable.php
		   $sizes = array('bytes', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

		   if ($retstring === null) { $retstring = '%01.2f %s'; }

		$lastsizestring = end($sizes);

		foreach ($sizes as $sizestring) {
		   	if ($size < 1024) { break; }
			   if ($sizestring != $lastsizestring) { $size /= 1024; }
		   }
		   if ($sizestring == $sizes[0]) { $retstring = '%01d %s'; } // Bytes aren't normally fractional
		   return sprintf($retstring, $size, $sizestring);
	}

	public function getReadableTime($time) {
		$ret = $time;
		$formatter = 0;
		$formats = array('ms', 's', 'm');
		if($time >= 1000 && $time < 60000) {
			$formatter = 1;
			$ret = ($time / 1000);
		}
		if($time >= 60000) {
			$formatter = 2;
			$ret = ($time / 1000) / 60;
		}
		$ret = number_format($ret,3,'.','') . ' ' . $formats[$formatter];
		return $ret;
	}

	/*---------------------------------------------------------
		 DISPLAY TO THE SCREEN -- CALL WHEN CODE TERMINATING
	-----------------------------------------------------------*/

	public function display($db = '', $master_db = '') {
		$this->db = $db;
		$this->master_db = $master_db;
		$this->gatherConsoleData();
		$this->gatherFileData();
		$this->gatherMemoryData();
		$this->gatherQueryData();
		$this->gatherSpeedData();
		return displayPqp($this->output, $this->config);
	}

}

?>