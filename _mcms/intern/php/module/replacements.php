<?php
function prepare_replacements() {
	global $dbobj,$external_functions;
	$external_functions['searchresults.php']= 'searchresults';
}
function qrepl($string) {
	make_replacements($string);
	do_links($string);
	return $string;
}
function make_replacements(&$string,$return=false) {
	do_replacements($string);
	if ($return) return $string;
}
function replacements($replace,$skip=false,$empty=false,$reps=254){
	global $sub_tpl,$rep_count;
	$r1 = &$replace[1];
	$nocache = array('random','warenkorb','menu','nocache','rnd','select','zaehler');
	if (!$skip && is_array($r1) && count($r1)>3 && preg_grep("/".$r1."/i",$nocache) && $r1!='PHPSESSID' && $r1!='SID') {
		$r2 = $r1;
	}
	if (strpos($r1,':')!==false) {
		list($r1,$data) = explode(':',$r1,2);
#		if (strpos($data,';')!==false) 	$params = preg_split("/^;([a-zA-Z_0-9]{2,})=$/",$data, null, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
		if (strpos($data,'data:')===false) {
			if (strpos($data,';')!==false) 	$params = explode(';',$data);
			else							$params[0] = $data;
			unset($data); $data=array();
			if (is_array($params)) {
				foreach ($params as $d) {
					if (strpos($d,'=')!==false && is_array($data)) {
						list($a,$v) = explode('=',$d,2);
						$data[$a] = $v;
					} else {
						$data  = $d;
					}
				}
			} elseif (strpos($params,'=')!==false) {
				list($a,$v) = explode('=',$d,2);
				$data[$a] = $v;
			} else {
				$data = $params;
		}	}
	} else {
		$data = '';	
	}
	if (!empty($r2) && isset($sub_tpl[$r2])) 		$r = $sub_tpl[$r2];
	elseif (function_exists(strtolower(trim($r1)))) {
		$r1 = strtolower(trim($r1));
		$r = $r1($data);
	}
	elseif (isset($sub_tpl[strtolower($r1)])) 		$r = $sub_tpl[strtolower($r1)];
	elseif ($empty)									$r = '';
	if (!empty($r2) && !empty($r))					$sub_tpl[$r2] = $r;
	if (empty($r) && is_array($data) && isset($data['DEFAULT'])) $r = $data['DEFAULT'];
	if (isset($r)) {
		if (is_array($r))	$out = r_implode("\n",$r,false,true);
		else				$out = $r;
		if (empty($rep_count))	$rep_count=0;
		if ($rep_count<=$reps) {
			do_replacements($out);
			$rep_count++;
		}
		return $out;
}	}
function do_replacements(&$string,$pattern = "([A-Z]{2,}.+)") {
	global $replaced,$page_id;
	$string = str_replace(array('Â§'),'§',$string);
#	$string = preg_replace("!\<p\>#STRIPP#§".$pattern."§#STRIPP#<\/p\>!Dsi",'§$1§',$string);
	mb_preg::match_all("/§".$pattern."§/Us",$string,$matches);
	while(list($key,$match) = myEach($matches[0])) {
		if (!empty($match)) {
			if (!isset($replaced[$matches[1][$key]]))	$replaced[$matches[1][$key]] = replacements(array(1=>$matches[1][$key]));
			if (!empty($replaced[$matches[1][$key]]))	$string = str_replace($match,$replaced[$matches[1][$key]],$string);
			else										$string = str_replace($match,'',$string);
			unset($matches[1][$key],$matches[0][$key]);
}	}	}
function repeat($data) {
	global $sub_tpl;
	$out = '';
	list($n,$m) = explode(',',$data['n']);
	do {
		$out .= str_replace(array('*N*','*M*'),array($n,$m),$sub_tpl[$data['tpl']]);
	} while ($n++ <= $m);
	return $out;
}
function ifis($data) {
	global $sub_tpl,$vorgaben;
	if (!empty($data['preset']) && isset($vorgaben[$data['preset']]))		$data['if']		= $vorgaben[$data['preset']];
	if (is_string($data) || empty($data['if'])) 							return $data;
	if (is_array($data) && !isset($data['is'])) 							$data['is']		= true;
	if (!empty($data['function']) && function_exists($data['function']))	$data['is']		= $data['function']();
	if (empty($data['then']))                          						$data['then']	= $data['if'];
	if (!empty($sub_tpl[$data['then']]))									$data['then']	= $sub_tpl[$data['then']];
	if (!empty($data['else']) && !empty($sub_tpl[$data['else']]))			$data['else']	= $sub_tpl[$data['else']];
	if (!empty($data['source'])) {
		$ex = $data['if'];
#		if ($data['source'] == 'request')	$_REQUEST[$data['if']] = read_storage(array($data['if']));
		switch($data['source']) {
			case 'request': if(isset($_REQUEST[$data['if']]))	$data['if'] = $_REQUEST[$data['if']];	break;
			case 'post': 	if(isset($_POST[$data['if']]))		$data['if'] = $_POST[$data['if']];		break;
			case 'get': 	if(isset($_GET[$data['if']]))		$data['if'] = $_GET[$data['if']];		break;
			case 'sub_tpl': if(isset($sub_tpl[$data['if']]))	$data['if'] = $sub_tpl[$data['if']];	break;
		}
		if ($ex == $data['if']) {
			unset($data['if'],$ex);
			if (!empty($data['else']))	return $data['else'];
		}
	}
	if (isset($data['if']) && isset($data['not'])) {
		if (isset($data['if']) && $data['not'] != $data['if']) {
			return $data['then'];
		} else {
			return '';
		}
	}
	if (isset($data['if']) || isset($data['or'])) {
		if (isset($data['if']) && $data['if'] == $data['is']) {
			if (empty($data['then'])) 	return $data['if'];
			else						return $data['then'];
		} elseif (isset($data['or']) && $data['or'] == $data['is']) {
			if (empty($data['then'])) 	return $data['or'];
			else						return $data['then'];
		} elseif (!empty($data['else'])) {
			return $data['else'];
}	}	}
function ifkat($data) {
	global $kat_id;
	$k_chk = explode(',',$data['kat_id']);
	if (in_array($kat_id,$k_chk)){
		return $data['return'];
}	}
function ifuid($data) {
	global $sub_tpl;
	if ($data['uid'] == uid()) {
		if (!empty($data['part_id']))	return str_replace('*PART_ID*',$data['part_id'],$sub_tpl[$data['tpl']]);
		else							return $sub_tpl[$data['tpl']];
}	}
function ifstatus($data) {
	global $sub_tpl;
	if (!empty($data['status']) && ($_SESSION['status'] >= $data['status'] || !is_numeric($_SESSION['status'])))	return $sub_tpl[$data['tpl']];
}
function ifnotuid($data) {
	global $sub_tpl;
	if ($data['uid'] != uid()) {
		if (!empty($data['part_id']))	return str_replace('*PART_ID*',$data['part_id'],$sub_tpl[$data['tpl']]);
		else							return $sub_tpl[$data['tpl']];
}	}
function rangeto($data=10) {
	$x = range(1,$data);
	foreach ($x as $y) {
		$z[] = '<span class="r'.$y.'">'.$y.'</span>';
	}
	return implode('',$z);
}
function show($data='') {
	global $sub_tpl;
	if (empty($data['TPL']) && !empty($data['IF']))	$data['TPL'] = $data['IF'];
	if (!empty($sub_tpl[$data['TPL']]))	{
		if (!empty($data['part']) && !empty($sub_tpl[$data['TPL']][$data['part']]))
			$data['TPL'] = $sub_tpl[$data['TPL']][$data['part']];
		else
			$data['TPL'] = $sub_tpl[$data['TPL']];
	}
	if (empty($data['NOTPL']))						$data['NOTPL'] = '';
	if (!empty($sub_tpl[$data['NOTPL']]))			$data['NOTPL'] = $sub_tpl[$data['NOTPL']];
	return display($data['IF'],$data['TPL'],$data['NOTPL']);
}
function display($data='',$return2='',$return='style="display:none"') {
	if (is_array($data)) {
		if (!empty($data['FELD'])) {
			$fields = explode ('|',$data['FELD']);
			foreach ($fields as $f) {
				if (!empty($data['SUBKEY']) && !empty($_REQUEST[$data['KEY']][$data['SUBKEY']][$f][0])) return $return2;
		}	}
		elseif (!empty($_REQUEST[$data['KEY']]))		return $return2;
	} elseif (!empty($data)) {
		if (strpos($data,'|')!==false) {
			$keys= explode('|',$data);
			foreach ($keys as $k) {
				if (!empty($k))							return $return2;
		}	} else {
			$data = preg_replace("/\%(\S+)\%/", '',$data);
			if (!empty($data) && filterArray($data))	return $return2;
	}	}
	return $return;
}
function zufallsabschnitte($data=array()) {
	global $unterseite_id,$page_id;
	$default = array('PAGE_ID'=>$page_id,'anz'=>1,'random'=>true);
	$unterseite_id = false;
	return get_vorlage(merge_defaults_user($default,$data));
}
function googlemap($data) {
	global $sub_tpl;
	if (empty($data)) 					$data='§STRASSE§,§ORT§';
	elseif ($data=='firma')				$data='§FIRMA§,§STRASSE§,§ORT§';
	if (empty($sub_tpl['googlemap']))	$sub_tpl['googlemap'] = '<iframe width="100%" height="300px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.de/maps?&q=§STRASSE§,+§ORT§&iwloc=0&fb=1&hl=§LANG§&hnear=&output=embed"></iframe>';
	return str_replace('#DATA#',$data,$sub_tpl['googlemap']);
}
function map($data) {
	global $sub_tpl;
	if (empty($data)) 		$data='§STRASSE§,§ORT§';
	elseif ($data=='firma') $data='§FIRMA§,§STRASSE§,§ORT§';
	if (!empty($sub_tpl['map'])) 			return str_replace('#DATA#',$data,$sub_tpl['map']);
	elseif (!empty($sub_tpl['googlemap']))	return str_replace('#DATA#',$data,$sub_tpl['googlemap']);
}
function bgcolor($data) {
	global $sub_tpl;
	if (empty($sub_tpl['bg_color']) && !empty($sub_tpl['bg_default']))	$sub_tpl['bg_color'] = $sub_tpl['bg_default'];
	if (!empty($sub_tpl['bg_color'])) {
		if ($data != 'CSS')	return 'style="background-color:'.$sub_tpl['bg_color'].';"';
		else				return 'background-color:'.$sub_tpl['bg_color'].';';
}	}
function essentialcss($data) {
	global $sub_tpl,$vorgaben;
	$dir	= "templates/css";
	$path = get_filepath($dir);
	$dh		= opendir($path);
	$essentialcss = array();
	while(false !== ($file = readdir($dh))) {
		if (is_file($path.'/'.$file) && strpos($file,'-.')===false) {
			$essentialcss[] = file_get_contents($path.'/'.$file);
	}	}
	closedir($dh);
	return implode("\n",$essentialcss);
}
function smilies($data) {
	global $sub_tpl,$vorgaben;
	$dir = "images/smilies";
	$path = get_filepath($dir);
	$dh		= opendir($path);
	while(false !== ($file = readdir($dh))) {
		if (is_file($path.'/'.$file) && strpos($file,'-.')===false) {
			$filenames[] = str_remove($file,'.gif');
	}	}
	closedir($dh);
	if (!empty($data))	$filelist = array_intersect(explode(',',$data),$filenames);
	else				$filelist = $filenames;
	foreach ($filelist as $smiley) {
		$smilies[] =  "<span onclick =\"addSmiley(this.id);\" id=\"".$smiley."\"><img src=\"/".$dir.'/'.$smiley.".gif\" alt=\"".$smiley."\" /></span>";
	}
	if (!empty($smilies))	return implode("\n",$smilies);
}
function addhttp($data) {
	return url_protocol($data);
}
function title() { 
  return call_user_func_array("pagetitle", func_get_args());
}
function pagetitle() {
	global $vorgaben,$unterseite,$unterseite_id,$sub_tpl;
	if	   (isset($unterseite))		$sub_tpl['titlesuffix'] = ' '.$unterseite.'';
	elseif (!empty($unterseite_id) && is_numeric($unterseite_id))	$sub_tpl['titlesuffix'] = ' ('.($unterseite_id+1).')';
	$title = implode(' - ',process_data('pagetitle'));
	if ($vorgaben['localhost'])	$title = '[L] '.$title;
	make_replacements($title);
	return str_remove($title,'#SHY#');
}
function beschreibung()	{
	$desc = str_replace('--','<br />',r_implode(process_data('description')));
	make_replacements($desc);
	return $desc;
}
function description()	{
	$desc = implode(' - ',process_data('description'));
	make_replacements($desc);
	return strip_tags($desc);
}
function bb($text) {
   bb2html($text);
   return $text;
}
function process_data($string,$switch=0) {
	global $sub_tpl;
	$out = array();
	switch ($switch) {
		case 1:	break;
		case 2:	if (!empty($sub_tpl[$string]))			$sub_tpl[$string] = str_replace(' - ','<br />',$sub_tpl[$string]);	break;
		case 0:	if (!empty($sub_tpl[$string.'prefix']))	$out[] = $sub_tpl[$string.'prefix'];								break;
	}
	if (!empty($sub_tpl[$string]))			$out[] = $sub_tpl[$string];
	if (!empty($sub_tpl[$string.'suffix']))	$out[] = $sub_tpl[$string.'suffix'];
	return $out;
}
function robots() {
	global $vorgaben;
	if (!empty($vorgaben['nofollow']) || $vorgaben['preview'])	return 'noindex,nofollow';
	else														return 'index,follow';
}
function toc($data) {
	global $sub_tpl;
	$sub_tpl['JS']['jquery/toc.js']		= 'jquery/toc.js';
	$sub_tpl['JS']['jquery/jquery.js']	= 'jquery/jquery.js';
	$sub_tpl['addscript'][]				= '$.toc(\''.$data.'\').prependTo(\'#toc\');';
	if (empty($sub_tpl['toc']))	$sub_tpl['toc'] = '<div id="toc"></div>';
	return $sub_tpl['toc'];
}
function nline()		{return "<br />\n";}
function shy()			{return '&shy;';}
function telephone()	{return get_subtpl('telefon');}
function street()		{return get_subtpl('strasse');}
function place()		{return get_subtpl('ort');}
function city()			{return get_subtpl('stadt');}
function zipcode()		{return get_subtpl('plz');}
function lastmod()		{return get_subtpl('lastmod');}
function insdate()		{return get_subtpl('insdate');}
function metadate()		{return get_subtpl('metadate');}
function addclass()		{return r_implode(' ',get_subtpl('class'));}
function getform ($get) {
	global $tplobj;
	$form = get_subtpl($get);
	if (!empty($_REQUEST[$get])) {
		daten_error($get,$get);
		$tplobj->array2tpl2($form,$_REQUEST[$get],'#');
	}
	return $form;
}
function get_subtpl($get) {
	global $sub_tpl;
	if (!empty($sub_tpl[$get]))
		return $sub_tpl[$get];
}
function vorgaben($data){global $vorgaben;	if (!empty($vorgaben[$data]))	return $vorgaben[$data];}
function calc($data) {
	global $sub_tpl;
	if (!empty($sub_tpl['count_sections'])) $data = str_replace('COUNT',$sub_tpl['count_sections'],$data);
	return Math::calc($data);
}
function iframe($data) {
	global $tplobj,$sub_tpl;
	if (!empty($sub_tpl['iframe']))	return $tplobj->array2tpl($sub_tpl['iframe'],$data,'#');
}
?>