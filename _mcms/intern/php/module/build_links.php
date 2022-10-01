<?php
function searchresults($restraints=array()) {
	global $sub_tpl;
	if (!empty($_REQUEST['search']) || !empty($restraints)) {
		$out = bridge($restraints);
		if	 (!empty($out))						return $out;
		elseif (!empty($sub_tpl['nothingfound']))	return $sub_tpl['nothingfound'];
		else 										return false;
	}
}
function referer() {
	if (!empty($_SERVER['HTTP_REFERER']))	return $_SERVER['HTTP_REFERER'];
	else									return 'javascript:history.back();';
}
function breadcrumbs($data='') {
	global $tplobj,$sub_tpl,$vorgaben,$page_id;
	if (!isset($sub_tpl['bclink']))			$sub_tpl['bclink']   = '<a href="$LINK$">$MENU$</a>';	// Für die Brotkrumennavigation
	if (!isset($sub_tpl['bchome']))			$sub_tpl['bchome']   = &$sub_tpl['bclink'];					// Wenn nichts besonderes für die 1. Seite gewünscht ist
	if (!isset($sub_tpl['bc_title']))		$sub_tpl['bc_title'] = '<b>$MENU$</b>';			// Titel der aufgerufenen Seite
	if (!isset($sub_tpl['bchometitle']))	$sub_tpl['bchometitle'] = &$sub_tpl['bc_title'];			// Titel der aufgerufenen Seite
	if (!isset($sub_tpl['bc_cc']))			$sub_tpl['bc_cc']	 = ' &lt; ';
	if (!isset($sub_tpl['bc_end']))			$sub_tpl['bc_end']	 = '';
	if ($sub_tpl['bchome'] != 'skip') {																// Die Stratseite kann auch übersprungen werden
		if (empty($sub_tpl['breadcrumbs']))	$sub_tpl['breadcrumbs'] = array();
		if (!empty($vorgaben['home'])) {
			$home_array[$vorgaben['home']['PAGE_ID']] = array('link'=>$vorgaben['home']['PAGE_ID'],'Menu'=>$vorgaben['home']['Menu']);	// Bei anderen Sprachen
			$sub_tpl['breadcrumbs'] = $home_array+$sub_tpl['breadcrumbs'];
	}	}
	if (!empty($sub_tpl['breadcrumbs'])) {
		$n = 1;
		foreach ($sub_tpl['breadcrumbs'] as $p => $bc) {
			$bc['link'] = linkto($bc['link']);
			$bc['pos'] = $n++;
			if ($p == $vorgaben['home']['PAGE_ID'])	$bcs[] = $tplobj->array2tpl($sub_tpl['bchome'],$bc,'$');
			elseif ($p == $page_id)					$bcs[] = $tplobj->array2tpl($sub_tpl['bc_title'],$bc,'$');
			else									$bcs[] = $tplobj->array2tpl($sub_tpl['bclink'],$bc,'$');
		}
		return r_implode($sub_tpl['bc_cc'],$bcs).$sub_tpl['bc_end'];
}	}
function dolink($data) {
	global $tplobj;
	if (empty($sub_tpl['dolink']))		$sub_tpl['dolink']	= '<a href="#LINK#" title="#TITLE#" >#MENU#</a>';
	if (empty($data['tpl']))			$data['tpl']		= $sub_tpl['dolink'];
	if (!is_numeric($data['PAGE_ID']))	$data['PAGE_ID']	= pageid_from_preset($data['PAGE_ID']);
	$out['link'] = linkto($data['PAGE_ID']);
	$out['menu'] = getmenu($data['PAGE_ID']);
	$out['desc'] = getdesc($data['PAGE_ID']);
	$out['title']= gettitle($data['PAGE_ID']);
	return $tplobj->array2tpl($data['tpl'],$out,'#');
}
function canonical(){
	global $page_id;
	return linktonosid($page_id);
}
function abslinks($data)		   {return preg_replace_callback("/#LINKTO\:([a-zA-Z_0-9;:\-]+?)#/Umsi","abslinkto",$data);}
function urlencodelink($kn='')		{return urlencode(httpslinkto($kn));}
function httpslinkto($kn='')		{return linkto(array('PAGE_ID'=>$kn,'SET'=>'absolute','protocol'=>'https'));}
function abslinkto($kn='')			{return linkto(array('PAGE_ID'=>$kn,'SET'=>'absolute'));}
function abslinktonosid($kn='')		{return linkto(array('PAGE_ID'=>$kn,'SET'=>'absolute','nosid'=>true));}
function linktonosid($kn='')		{return linkto(array('PAGE_ID'=>$kn,'nosid'=>true));}
function linkto($kn='',$suffix='§SID§',$prefix='',$set='',$must=false,$visibility=1,$protocol=true) {
	global $dbobj,$lang_id,$first_lang_id,$page_id,$parent_id,$languages_byid,$vorgaben,$sub_tpl;
	if (empty($lang_id))					$l  = $first_lang_id;
	else									$l  = $lang_id;
	if (empty($kn))						 $kn = $page_id;
	if (is_array($kn)) {	// $kn can be an array to specify the link to be build.
		if (!empty($kn[1]) && strpos($kn[1],';')!==false) {
			$params = explode(';',$kn[1]);
			unset($kn);
			foreach ($params as $d) {
				if (strpos($d,'=')!==false) {
					list($a,$v) = explode('=',$d,2);
					$kn[$a] = $v;
				} else $kn  = $d;
		}	}
		if (!empty($kn['LANG_ID']))			$l = $kn['LANG_ID'];
		if (isset($kn['visibility']))		$visibility = $kn['visibility'];
		if (!empty($kn['prefix']))			$prefix = $kn['prefix'];
		if (!empty($kn['suffix']))			$suffix = $kn['suffix'];
		elseif(!empty($kn['nosid']))		$suffix = '';
		if (!empty($kn['must']))			$must	= true;
		if (!empty($kn['SET']))				$set	= $kn['SET'];
		if (!empty($kn['protocol']))		$protocol = $kn['protocol'];
		if (!empty($kn['file']))			$linkto = $kn['file'];
		if (!empty($kn['PAGE_ID']) && is_array($kn['PAGE_ID'])) {
			if (!empty($kn['PAGE_ID'][1]))	$kn = $kn['PAGE_ID'][1];
			else							$kn = r_implode($kn);
		} elseif (!empty($kn['PAGE_ID']))	$kn = $kn['PAGE_ID'];
		elseif (!empty($kn[1]))				$kn = $kn[1];
		else								$kn = current($kn);
	}
	if (!empty($vorgaben['abspaths']) && !isset($set))	$set = 'absolute';
	if (empty($linkto)) {
		if (strpos($kn,'|')!==false) {
			list($kn,$kn2) = explode('|',$kn);
			if ($kn2 == 'home' && !empty($vorgaben[$kn2]))	$kn2 = $vorgaben[$kn2]['PAGE_ID'];
		}
		if (strpos($kn,';')!==false) 						list($kn,$set) = explode(';',$kn);
		if (strpos($kn,':')!==false) 						list($kn,$pn)  = explode(':',$kn);
		if (is_string($kn)) {		// Some special keys
			if (strtolower($kn) == 'page_id')				$kn = $page_id;
			elseif (strtolower($kn) == 'parent_id')			$kn = $parent_id;
			elseif ($kn == 'home' && !empty($vorgaben[$kn]))$kn = $vorgaben[$kn]['PAGE_ID'];
			elseif (!empty($vorgaben[$kn]))					$kn = pageid_from_preset($kn);
			elseif (is_string($kn) && !empty($sub_tpl[$kn]))$kn = $sub_tpl[$kn];
		}
		$sql1 = "SELECT	#PREFIX#seiten.PAGE_ID,#PREFIX#seiten.LANG_ID,#PREFIX#seiten_attr.parent_ID,kurzname,Menu,#PREFIX#seiten.Titel,
						#PREFIX#seiten_attr.lft,(SELECT lft FROM #PREFIX#seiten_attr ORDER BY lft ASC LIMIT 1) AS min_lft
				FROM	#PREFIX#seiten,#PREFIX#seiten_attr,#PREFIX#kategorien
				WHERE	#PREFIX#seiten.LANG_ID IN (".$l.") AND #PREFIX#seiten.PAGE_ID = #KN#
				AND		#PREFIX#seiten.PAGE_ID = #PREFIX#seiten_attr.PAGE_ID
				AND		#PREFIX#kategorien.KAT_ID = #PREFIX#seiten_attr.KAT_ID
				AND		#PREFIX#seiten_attr.visibility >= ".$visibility;
		$sql1 .= sql_kat_status();
		$sql1 .= "\nLIMIT 1";
		if (is_numeric($kn) && isset($sub_tpl['paths_byid'][$l][$kn])) 																		{$linkto = $sub_tpl['paths_byid'][$l][$kn];	$exists = true;}
		elseif (is_numeric($kn) && $exists = $dbobj->withkey(__file__,__line__,str_replace('#KN#',$kn,$sql1),'LANG_ID')) 					{$linkto = get_linkto($exists,$l);}
		elseif (!empty($kn2) && is_numeric($kn2) && isset($sub_tpl['paths_byid'][$l][$kn2])) 												{$linkto = $sub_tpl['paths_byid'][$l][$kn2];$exists = true;}
		elseif (!empty($kn2) && is_numeric($kn2) && $exists = $dbobj->withkey(__file__,__line__,str_replace('#KN#',$kn2,$sql1),'LANG_ID'))	{$linkto = get_linkto($exists,$l);}
		elseif (!empty($sub_tpl['all_paths'][$kn]))						$linkto = $sub_tpl['all_paths'][$kn];
		elseif (!empty($kn2) && !empty($sub_tpl['all_paths'][$kn2]))	$linkto = $sub_tpl['all_paths'][$kn2];
		elseif (!is_numeric($kn))										$linkto = $kn;
		elseif (!empty($kn2) && !is_numeric($kn2))						$linkto = $kn2;
		else															$linkto = '';
		if (!empty($languages_byid[$l]) && !empty($languages_byid[$l]['link'])) {				// Wenn eine Domain dazu gehört
			$linkto = url_protocol($languages_byid[$l]['link'],$protocol).$linkto;				//  	Prefix bauen
			$set = 'asis';																		//   	und dafür sorgen, dass absolut verllinkt wird.
	}	}
	if ((!$must && isset($linkto)) || ($must && !empty($exists) && $exists)) {					// Entweder ist die Variable gefüllt, oder es existiert auf jeden Fall eine Seite.
	#	$linkto = trim($linkto,'/');
		switch ($set) {
			case 'asis':
			case 'relative':																		break;
			case 'absolute':  $linkto = $vorgaben['sub_dir'].'/'.$linkto;							
							  if (!empty($http))	$linkto = $http.$linkto;
							  else					$linkto = url_protocol(domain('*'),$protocol).$linkto;	break;
			default: 		  if (strpos($linkto,'/')!==0)	$linkto = '/'.$linkto;						break;
		}
		if (!empty($languages_byid[$l]) && strpos($linkto,'/'.$languages_byid[$l]['short'].'/'.$languages_byid[$l]['short'].'/')!==false) {
			$linkto = str_replace('/'.$languages_byid[$l]['short'].'/','/',$linkto);
		}
		$linkto .= $suffix;
		make_replacements($linkto);
		return $linkto;
	} else return false;
#	} else return 'javascript:;" onclick="alert(\'%%DIESE_SEITE_GIBT_ES_NICHT%%\');return false;';
}
function get_linkto($exists,$l) {
	global $dbobj,$first_lang_id,$sub_tpl;
	$page = current($exists);
	$PAGE_ID = $page['PAGE_ID'];
	$linkto = '';
	if ($page['lft'] != $page['min_lft']) {
		if (!empty($exists[$l])) {
			$linkto = $exists[$l]['kurzname'];
		} else {
			$linkto = $page['kurzname'];
			$l = $first_lang_id;
	}	}
	if (!empty($exists[$l]['parent_ID'])) {
		$sql2 = "SELECT #PREFIX#seiten.PAGE_ID,parent_ID,kurzname,#PREFIX#seiten_attr.lft,(SELECT lft FROM #PREFIX#seiten_attr ORDER BY lft ASC LIMIT 1) AS min_lft
				FROM	#PREFIX#seiten,#PREFIX#seiten_attr
				WHERE	#PREFIX#seiten_attr.PAGE_ID = |PARENT_ID|
				AND		#PREFIX#seiten.PAGE_ID = #PREFIX#seiten_attr.PAGE_ID AND LANG_ID = '|LANG_ID|';";
		$n=0;
		do {$exists = $dbobj->exists(__file__,__line__,str_replace(array('|PARENT_ID|','|LANG_ID|'),array($page['parent_ID'],$l),$sql2));
			if (!empty($sub_tpl['paths_byid'][$l][$exists[0]['parent_ID']])) 	$linkto = $sub_tpl['paths_byid'][$l][$exists[0]['parent_ID']].'/'.$exists[0]['kurzname'].'/'.$linkto;
			elseif ($exists[0]['lft'] != $exists[0]['min_lft'])					$linkto = $exists[0]['kurzname'].'/'.$linkto;
			$page['parent_ID'] = $exists[0]['parent_ID'];
			$n++;
		} while (!empty($exists[0]['parent_ID']) && empty($sub_tpl['paths_byid'][$l][$exists[0]['parent_ID']]) && $n<999);
		$sub_tpl['paths_byid'][$l][$PAGE_ID] = $linkto;
	}
	return $linkto;
}
function bridgeeach($data='') {
	global $dbobj;
	$where = array();
	if (!empty($data) && is_array($data))	{
		foreach ($data as $select => $p) {
			if (is_string($p)) {
				if (strpos($p,'%')===0)					return false;
				elseif ($p=='page_id')		$p = $page_id;
				elseif ($p=='parent_id')	$p = $parent_id;
				elseif (strpos($p,'#PAGE_ID#')===0)		$p = $page_id;
				elseif (strpos($p,'#PARENT_ID#')===0)	$p = $parent_id;
			}
			$select = strtolower($select);
			if ($p = bridge_where($where,$p,$select)) {
				$$select = $p;
	}	}	}
	$sql = "SELECT DISTINCT ".$data['EACH']." FROM #PREFIX#seiten_attr";
	if (!empty($where[0]))	$sql .= " WHERE	".implode("\n AND	",$where);
	bridge_order($sql,$order);
	if (!empty($data['EACH']) && $all = $dbobj->singlequery(__file__,__line__,$sql.";")) {
		$data['asarray'] = true;
		foreach ($all as $each) {
			$data[$data['EACH']] = $each[$data['EACH']];
			$data['asarray'] = true;
			$x[] = bridge($data);
		}
		$x =flattenArray($x);
		return bridge_out($x,true);
}	}
function bridge($data=array()) {
	global $dbobj,$tplobj,$sub_tpl,$lang,$lang_id,$active,$sub_tpl,$page_id,$parent_id,$unterseite_id,$vorgaben,$prefix;
	$tpl = '';			$suffix = '';	$prefix = '';	
	$order = '';		$suborder = '';	$limit = '';	$visibility = 0;
	$paginate = '';		$reverse = 0;	$ncount = 0;
	$join = "\n";		$lastjoin = '';
	$where = array();	$asarray = false;$abc_array = false;	$id_array = false;
	$map = '';			$random = '';
	$onlyids=false;
	$keep_page_id = $page_id;
	if(!is_array($data))	$data=array();
	else 					extract(array_change_key_case($data));
	if (!array_key_exists('visibility',$data))	$data['visibility'] = 1;
	if (!array_key_exists('kat_vis',$data))		$data['kat_vis']	= $data['visibility'];
	if (!array_key_exists('lang_vis',$data))	$data['lang_vis']	= $data['visibility'];
	if (!empty($data) && is_array($data)) {
		foreach ($data as $select => $p) {
			if (is_string($p)) {
				if (strpos($p,'%')===0)					return false;
				elseif ($p=='page_id')					$p = $page_id;
				elseif ($p=='parent_id')				$p = $parent_id;
				elseif (strpos($p,'#PAGE_ID#')===0)		$p = $page_id;
				elseif (strpos($p,'#PARENT_ID#')===0)	$p = $parent_id;
			}
			$select = strtolower($select);
			if ($p = bridge_where($where,$p,$select)) {
			#	$$select = $p;
	}	}	}
	if (empty($where[0]) && !empty($data) && is_numeric($data))	$where[] = "#PREFIX#seiten_attr.parent_ID = '".$data."' ";
	elseif (empty($where[0]) && !empty($page_id))				$where[] = "#PREFIX#seiten_attr.parent_ID = '".$page_id."' ";
	elseif (empty($where[0]) && !empty($active) && is_array($active)) {
		$where[] = "#PREFIX#seiten_attr.parent_ID = '".end($active)."' ";
		reset($active);
	}
	if (!empty($where[0])) {
		$sql = "SELECT 	#PREFIX#seiten.PAGE_ID,			#PREFIX#seiten_attr.parent_ID,	#PREFIX#seiten_attr.TPL_ID,	#PREFIX#seiten_attr.position,
						#PREFIX#person.ID AS person_id,	#PREFIX#seiten.Menu,		COUNT(DISTINCT kids.PAGE_ID) AS count,
						#PREFIX#seiten.insdate,			#PREFIX#seiten.lastmod,		#PREFIX#seiten.Ueberschrift,	#PREFIX#seiten.AK,		#PREFIX#person.Name AS owner,
						#PREFIX#seiten.Text,			#PREFIX#seiten.Titel,		#PREFIX#seiten.Beschreibung,	#PREFIX#seiten.Kurzname AS kn
				FROM 	#PREFIX#seiten,#PREFIX#seiten_attr
							LEFT JOIN (#PREFIX#seiten_attr as kids) ON (kids.parent_ID = #PREFIX#seiten_attr.PAGE_ID AND kids.visibility >= ".$data['visibility'].")
							LEFT JOIN (#PREFIX#person) ON (#PREFIX#person.ID = #PREFIX#seiten_attr.person_ID),
						#PREFIX#_languages,#PREFIX#kategorien,#PREFIX#vorlagen
				WHERE	".implode("\n AND	",$where)."
				AND		#PREFIX#seiten_attr.KAT_ID	= #PREFIX#kategorien.KAT_ID	AND	#PREFIX#kategorien.visibility	>= ".$data['kat_vis']."
				AND 	#PREFIX#_languages.LANG_ID	= #PREFIX#seiten.LANG_ID	AND #PREFIX#_languages.visibility	>= ".$data['lang_vis']."
				AND		#PREFIX#seiten_attr.PAGE_ID	= #PREFIX#seiten.PAGE_ID	AND	#PREFIX#seiten_attr.visibility	>= ".$data['visibility']."
				AND		#PREFIX#seiten_attr.TPL_ID	= #PREFIX#vorlagen.TPL_ID
				AND 	#PREFIX#seiten.LANG_ID		= '".$lang_id."'";
		if (!empty($vorgaben['checkdate']))			$sql .= "\nAND	(#PREFIX#seiten.insdate <= '1970-01-01' OR #PREFIX#seiten.insdate = NULL OR #PREFIX#seiten.insdate <= CURDATE())";
		if (!empty($order) && $order == 'future')	$sql .= "\nAND #PREFIX#seiten.insdate >= '".date('Y-n')."-01 00:00:00'";
		if (!empty($date))							$sql .= "\nAND #PREFIX#seiten.insdate >= '".$date."-01 00:00:00'";
		$sql .= sql_kat_status();
		$sql .= "\nGROUP BY	#PREFIX#seiten.PAGE_ID";
		bridge_order($sql,$order,$suborder);
		if (!empty($anz))						$limit = $anz;
		if (!empty($start) && !empty($limit))	$sql .= "\nLIMIT ".$start.",".$limit;
		elseif (!empty($limit) && $limit > 0)	$sql .= "\nLIMIT ".$limit;
		$page_id = $keep_page_id;
		if ($subpgs = $dbobj->withkey(__file__,__line__,$sql.";",'PAGE_ID')) {
			if (!empty($ncount))	$subpg_meta['count'] = $ncount;
			else					$subpg_meta['count'] = count($subpgs);
			if ($onlyids == true) 
				return array_keys($subpgs);
			if (!empty($iffct)) {
				foreach ($subpgs as $p => $subpg) {
					if (function_exists($iffct) && !$iffct(array('PAGE_ID'=>$p)))	unset($subpgs[$p]);
			}	}
			if (!empty($addfct)) {
				foreach ($subpgs as $p => $subpg) {
					if (function_exists($addfct))			$subpgs[$p] = $addfct(array('PAGE_ID'=>$p),$subpg);
			}	}
			if (!empty($template))							$tpl = &$template;
			if (!empty($tpl) && !empty($sub_tpl[$tpl]))		$tpl = $sub_tpl[$tpl];
			if (empty($tpl) && !empty($sub_tpl['bridge']))	$tpl = $sub_tpl['bridge'];
			if (!empty($paginate)) 							paginate($subpgs,$paginate);
			if ($order=='future' || $order=='reverse')		$subpgs = array_reverse($subpgs);
			elseif (!empty($random))						shuffle($subpgs);
			$i=0;
			$lastmod='0000-00-00 00:00';
		#	$subpgs_count = count($subpgs);
			$tpl = $tplobj->array2tpl($tpl,$subpg_meta,'&');
			if (!empty($prefix) && !empty($sub_tpl[$prefix])) 		$prefix = $tplobj->array2tpl($sub_tpl[$prefix],$subpg_meta,'&');
			if (!empty($suffix) && !empty($sub_tpl[$suffix])) 		$suffix = $tplobj->array2tpl($sub_tpl[$suffix],$subpg_meta,'&');
			foreach ($subpgs as &$subpg) {
				if (empty($subpg['AK'])) {
					if (!empty($subpg['Kurzname']))	$subpg['AK'] = $subpg['Kurzname'][0];
					elseif (!empty($subpg['kn']))	$subpg['AK'] = $subpg['kn'][0];
					elseif (!empty($subpg['Menu']))	$subpg['AK'] = $subpg['Menu'][0];
				}
				if (!empty($subpg['position'])) 	$subpg['pos'] = $subpg['position'];
				if (!empty($subpg['Text'])) 		parse($subpg['Text']);
				if (!empty($subpg['Beschreibung']))	parse($subpg['Beschreibung']);
				if (!empty($subpg['Ueberschrift']))	bb2html($subpg['Ueberschrift']);
				if (!empty($subpg['insdate'])) {
					$subpg['datum']		= format_date($subpg['insdate']);
					$subpg['pagedate']	= format_date($subpg['insdate'],"%a, %d %b %Y %H:%M:%S %z");
				}
				if (!is_future($subpg['insdate']))	$subpg['insdate']	= format_date($subpg['insdate'],"%a, %d %b %Y %H:%M:%S %z");
				else								$subpg['insdate']	= date(DATE_RFC2822);
				if (!empty($subpg['lastmod']))		$subpg['mdate']		= format_date($subpg['lastmod']);
				if ($lastmod < $subpg['lastmod'])	$lastmod			= $subpg['lastmod'];
			#	if (!empty($suffix)&&!empty($subpg['count']))	$subpg['suffix']	= str_replace('#',$subpg['count'],$suffix);
			#	else											$subpg['suffix']	= '';
				$i++;
				$subpg['nlast'] = $i-1;
				$subpg['nbr'] = $i;
				if ($subpg['nbr']>1)					$subpg['nprev'] = $subpg['nlast'];
				else									$subpg['nprev'] = $subpg_meta['count'];
				if ($subpg['nbr']<$subpg_meta['count'])	$subpg['nnext'] = $subpg['nbr']+1;
				else									$subpg['nnext'] = 1;
		#		info($subpg['nbr']);
				if($abc_array) {
					$asarray = true;
					if (isset($subpg[$abc_array][0])) {
						$key = strtolower($subpg[$abc_array][0]); // get the first letter.
						if(!empty($map)) {
							if (!empty($map[$key]))	$key = $map[$key];
							else					$key = end($map);
						}
						$out[$key][] = $tplobj->array2tpl($tpl,$subpg,'$');
					} else
						$out[] = $tplobj->array2tpl($tpl,$subpg,'$');
				}
				elseif($id_array) {
					$asarray = true;
					foreach ($id_array as $id) {
						if (!empty($subpg[$id]))	$out[$subpg['PAGE_ID']][$id] = $subpg[$id];
					}
				}
				else	$out[] = $tplobj->array2tpl($tpl,$subpg,'$');
			}
			if(!empty($lastmod))	$sub_tpl['lastmod']	= format_date($lastmod,"%Y-%m-%dT%H:%M:%S %z");
			if (!empty($out))		return bridge_out($out,$random,$asarray,$join,$map,$lastjoin);
}	}	}
function bridge_order(&$sql,$order,$suborder='') {
	$order_array = array('abisz'=>"#PREFIX#seiten.Titel",
						 'random'=>"RAND()",
						 'pageid'=>"PAGE_ID DESC",
						 'future'=>"insdate DESC",
						 'pos'=>"#PREFIX#seiten_attr.position DESC",
						 'apos'=>"#PREFIX#seiten_attr.position ASC",
						 'date'=>"insdate DESC",
						 'adate'=>"insdate ASC",
						 'lastmod'=>"lastmod DESC",
						 'rlastmod'=>"lastmod ASC",
						 'tpl'=>"#PREFIX#vorlagen.position ASC",
						 'desc'=>"#PREFIX#kategorien.position ASC,#PREFIX#seiten_attr.position ASC,#PREFIX#seiten.Menu");
	if (!empty($order_array[$order]))		$order_sql[] = $order_array[$order];
	else									$order_sql[] = "#PREFIX#kategorien.position,#PREFIX#seiten_attr.position,#PREFIX#seiten.Menu";
	if (!empty($order_array[$suborder]))	$order_sql[] = $order_array[$suborder];
	if (!empty($order_sql))					$sql .= "\nORDER BY ".implode(',',$order_sql);
}
function bridge_where(&$where,$p,$select) {
	global $sub_tpl,$vorgaben;
	if (is_string($p) && strpos($p,'fct:')!==false) {
		$fct = str_remove($p,'fct:');
		if (function_exists($fct)) $p = $fct();
	}
	if (!is_array($p) && strpos($p,'!')===0) {
		$p = substr($p, 1);
		$in_out = 'NOT IN';
	} else {
		$in_out = 'IN';
	}
	if (is_string($p)) {
		if (!empty($sub_tpl[$p]))		$p = $sub_tpl[$p];
		elseif (!empty($vorgaben[$p]))	$p = $vorgaben[$p];
	}
	if (isset($p)) {
		switch ($select) {
			case 'person_id':	$where[] = "#PREFIX#seiten_attr.person_ID ".$in_out." (".$p.")";break;
			case 'tpl_id':		$where[] = "#PREFIX#seiten_attr.TPl_ID ".$in_out." (".$p.")";	break;
			case 'kat_id':		$where[] = "#PREFIX#seiten_attr.KAT_ID ".$in_out." (".$p.")";	break;
			case 'skip':		$where[] = "#PREFIX#seiten_attr.PAGE_ID NOT IN (".$p.")";		break;
			case 'page_id':		$where[] = "#PREFIX#seiten_attr.PAGE_ID ".$in_out." (".$p.")";	break;
			case 'parent_id':	$where[] = "#PREFIX#seiten_attr.parent_ID ".$in_out." (".$p.")";break;
			case 'lastmod':		$where[] = "#PREFIX#seiten.lastmod >= '".$p." 00:00:00'";		break;
			case 'rlastmod':	$where[] = "#PREFIX#seiten.lastmod <= '".$p." 23:59:59'";		break;
			case 'insdate':		$where[] = "#PREFIX#seiten.insdate >= '".$p." 00:00:00'";		break;
			case 'rinsdate':	$where[] = "#PREFIX#seiten.insdate <= '".$p." 23:59:59'";		break;
			case 'find':
				if (!empty($p)) {
					$p = str_replace('*','%',$p);
					$ps = explode(' ',$p);
					foreach ($ps as $p) {
						if (empty($where_find))	$where_find = array();
						$where_find[] .= " (#PREFIX#seiten.Titel LIKE '%".$p."%' OR
										#PREFIX#seiten.Ueberschrift  LIKE '%".$p."%' OR
										#PREFIX#seiten.Menu  LIKE '%".$p."%' OR
										#PREFIX#seiten.Text LIKE '%".$p."%')";
					}
					$where[$select] = '('.implode(' OR ',$where_find).')';
				}
			break;
			default: return $p; break;
	}	}
	return false;
}
function bridge_out($out,$random='',$asarray=false,$join='',$map='',$lastjoin='') {
	global $tplobj,$sub_tpl,$prefix,$suffix;
	if (!empty($random))	shuffle($out);
	if($asarray) {
		if(!empty($map))	$out = sortArrayByArray($out,$map);
		return $out;
	} else {
		if (!empty($lastjoin) && count($out)>1) $l = array_pop($out);
		$out = r_implode($join,$out);
		if (!empty($l)) $out .= $tplobj->array2tpl($lastjoin,$sub_tpl,'#').$l;
	}
	if (empty($prefix) && !empty($sub_tpl['bridgeprefix']))		$prefix = $sub_tpl['bridgeprefix'];
	if (!empty($prefix)) 										$out = $prefix.$out;
	if (empty($suffix) && !empty($sub_tpl['bridgesuffix']))		$suffix = $sub_tpl['bridgesuffix'];
	if (!empty($suffix)) 										$out .= $suffix;
	return $out;
}
?>