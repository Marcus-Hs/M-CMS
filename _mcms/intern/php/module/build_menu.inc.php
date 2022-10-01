<?php
function path2db() {
	global $dbobj,$path,$path2db,$page_id,$page,$lang_id,$tpl_id,$kat_id,$vorgaben;
	extract_page();
	$sql = "SELECT	#PREFIX#seiten.PAGE_ID,
				#PREFIX#seiten_attr.parent_ID,
				GROUP_CONCAT(parents_attr.PAGE_ID) AS parent,
				#PREFIX#seiten.LANG_ID,
				#PREFIX#seiten.kurzname,	#PREFIX#seiten.Menu,	#PREFIX#seiten.Titel,
				#PREFIX#vorlagen.cache,		#PREFIX#vorlagen.stats,	#PREFIX#kategorien.follow,
				#PREFIX#seiten_attr.lft,
				#PREFIX#seiten_attr.TPL_ID,	#PREFIX#seiten_attr.KAT_ID
		FROM	#PREFIX#seiten
				INNER JOIN (#PREFIX#seiten AS p2),
				#PREFIX#seiten_attr
				INNER JOIN (#PREFIX#seiten_attr AS p2_attr)
				LEFT JOIN (#PREFIX#seiten_attr AS parents_attr) ON (parents_attr.lft < #PREFIX#seiten_attr.lft AND parents_attr.rgt > #PREFIX#seiten_attr.rgt)
				LEFT JOIN (#PREFIX#vorlagen)			ON (#PREFIX#vorlagen.TPL_ID = #PREFIX#seiten_attr.TPL_ID),
				#PREFIX#kategorien
		WHERE	(#PREFIX#seiten_attr.parent_ID		= 0 OR #PREFIX#seiten_attr.parent_ID = p2_attr.PAGE_ID)
		AND	p2_attr.PAGE_ID = p2.PAGE_ID
		AND	#PREFIX#seiten_attr.KAT_ID		= #PREFIX#kategorien.KAT_ID
		AND	#PREFIX#seiten_attr.PAGE_ID		= #PREFIX#seiten.PAGE_ID
		AND	#PREFIX#seiten_attr.visibility	= 1";
	if (!empty($path[0])) {
		$sql .= "\nAND	(p2.kurzname		 IN ('".implode("','",$path)."') AND (p2_attr.PAGE_ID = p2.PAGE_ID) OR (p2.PAGE_ID = ".$vorgaben['home']['PAGE_ID']."))";
		$sql .= "\nAND	(#PREFIX#seiten.kurzname IN ('".implode("','",$path)."') OR #PREFIX#seiten.PAGE_ID = ".$vorgaben['home']['PAGE_ID'].")";
	} else {
		$sql .= "\nAND	(p2.PAGE_ID		= ".$vorgaben['home']['PAGE_ID'].")";
		$sql .= "\nAND	(#PREFIX#seiten.PAGE_ID = ".$vorgaben['home']['PAGE_ID'].")";
	}
	if (!empty($vorgaben['checkdate']))
		$sql .= "\nAND	(#PREFIX#seiten.insdate <= '1970-01-01' OR #PREFIX#seiten.insdate = NULL OR #PREFIX#seiten.insdate <= CURDATE())";
	$sql .= sql_kat_status();
	$sql .= "\nGROUP BY	#PREFIX#seiten_attr.PAGE_ID,#PREFIX#seiten.LANG_ID";
	$sql .= "\nORDER BY	#PREFIX#seiten_attr.lft;";
#	$dbobj->singlequery(__file__,__line__,'SET SQL_BIG_SELECTS=1;');
	if ($path2db = $dbobj->withkey(__file__,__line__,$sql,'kurzname',false,'LANG_ID','PAGE_ID',true)) {
		if (!empty($path2db[$page][$lang_id])) {		// Page exists in this language
			$x = current($path2db[$page][$lang_id]);
		} elseif (!empty($path2db[$page])) {			// Page exists but not in this language
			$x = current(current($path2db[$page]));
		} else {										// Whatever, just get something
			$x = end($path2db); $x = current(current($x));
		}
		$page_id= $x['PAGE_ID']; $tpl_id = $x['TPL_ID']; $kat_id = $x['KAT_ID'];
		if (!empty($x['cache']) && $vorgaben['cache']!=false)	$vorgaben['cache'] = $x['cache'];
		if (!empty($x['stats'])) 				$vorgaben['stats'] = $x['stats'];
}	}
function path() {
	global	$dbobj,$lang_id,$lang,$first_lang,$add_breadc_fct,$bc_path,$sub_tpl,$path,$path2db,
			$vorgaben,$set_session,$notfound,$active,$page_id,$unterseite,$unterseite_id,$tpl_id,$kat_id,
			$fallback;
	if (!empty($path[0]) && !empty($vorgaben['home'])) {		// Check if there is a requested path
		$last_ID = 0; $bc_path = '/'; $last = end($path); reset($path);			// a little prepping
		foreach ($path as $c => $kn) {							// there we go for each element of the requested path
			if (!empty($path2db[$kn])) { 							// Check if it exists in DB (see path2db function)
				$exists = &$path2db[$kn];								// just an alias
				if (!empty($path2db[$kn][$lang_id]))	$l = $lang_id;
				else									$l = key($exists);
				if ($l == $lang_id) {							// Check language (see module/set_lang)
					$exists = $exists[$lang_id];						// get the first element
					if (is_array($exists)) {
						$key = key($exists);
						$current = current($exists);
						if (!empty($current['parent']))	$current['parent'] = explode(',',$current['parent']);
						if ($current['parent_ID'] == $last_ID || $current['parent_ID'] == $vorgaben['home']['PAGE_ID']) {
							$last_ID = $current['PAGE_ID'];
							$page_id = $current['PAGE_ID'];
							$tpl_id = $current['TPL_ID'];
							$kat_id = $current['KAT_ID'];
							if (empty($current['follow']) || $vorgaben['preview'])								$vorgaben['nofollow'] = 1;					// for Robots
							if (isset($current['cache']) && $vorgaben['cache']!=false)	$vorgaben['cache'] = $current['cache'];		// Cache nutzen
							if (isset($current['stats']))								$vorgaben['stats'] = $current['stats'];		// Statistiken erstellen
							if (empty($active[$current['kurzname']]))					$active[$current['kurzname']] = $current['PAGE_ID'];		// Aktive Seiten merken
							if ($vorgaben['home']['PAGE_ID'] == $current['parent'])		$active[$vorgaben['home']['Menu']] = $vorgaben['home']['PAGE_ID'];			// Aktive Seiten merken
							if (empty($current['Menu']))								$current['Menu'] = $current['Titel'];		// Irgendwas muss ja im Menü stehen.
							if	(strpos($current['kurzname'],'http://')===false) 		$bc_path .= $current['kurzname'].'/';
						} else {
							$page_id = key($exists);	// There is a page with that name, just somewhere else.
							$notfound = 301;
						}
						if (strtolower($kn) == strtolower($last)) {
							extract_subpages($current);
						} elseif (!empty($current['Menu']))		$sub_tpl['breadcrumbs'][$current['PAGE_ID']] = array('link'=>$bc_path,'Menu'=>$current['Menu']);
					}
				} elseif (!empty($page_id) && empty($_REQUEST['lang_id']) && $exists = $dbobj->exists(__file__,__line__,"SELECT #PREFIX#seiten.PAGE_ID,#PREFIX#seiten.LANG_ID FROM #PREFIX#seiten WHERE PAGE_ID = ".$page_id." AND LANG_ID=".$lang_id." LIMIT 1;")) {
					$notfound = 301;	// Page exists but language doesn't match
				}
			} elseif ($exists = $dbobj->exists(__file__,__line__,"SELECT #PREFIX#seiten.kurzname,#PREFIX#seiten.PAGE_ID FROM #PREFIX#seiten_redirects,#PREFIX#seiten WHERE ex_kurzname = '".$dbobj->escape($kn)."' AND #PREFIX#seiten.PAGE_ID = #PREFIX#seiten_redirects.PAGE_ID LIMIT 1")) {
				$page_id = $exists[0]['PAGE_ID'];	// There was a page with that name once, but is no more
				$notfound = 302;					//  -> prepare redirect
			} elseif ($exists = $dbobj->exists(__file__,__line__,"SELECT #PREFIX#seiten.kurzname,#PREFIX#seiten.PAGE_ID FROM #PREFIX#seiten_redirects,#PREFIX#seiten WHERE ex_kurzname = '".$dbobj->escape(trim(str_remove($_SERVER['REQUEST_URI']),'/'))."' AND #PREFIX#seiten.PAGE_ID = #PREFIX#seiten_redirects.PAGE_ID LIMIT 1")) {
				$page_id = $exists[0]['PAGE_ID'];	// There was a page with that name once, but is no more (other cms)
				$notfound = 303;					//  -> prepare redirect
			} elseif ($exists = $dbobj->exists(__file__,__line__,"SELECT kurzname,PAGE_ID FROM #PREFIX#seiten WHERE kurzname = '".$dbobj->escape($kn)."' LIMIT 1;")) {
				if ($kn=='Login') {
					$page_id = $kn;						// Some Moron removed the Login page. Prepare for fallback
					$notfound = true;					//  -> prepare redirect
				} else {
					$page_id = $exists[0]['PAGE_ID'];	// The page exists, but the path has changed
					$notfound = 304;					//  -> prepare redirect
				}
			} elseif (!empty($fallback[$kn])) {
				$vorgaben['fallback'] = $kn;
			} else {
				if (!empty($page_id))	$notfound = 301;
				else					$notfound = 404;					// Otherwise: not found
		}	}
	} else {
		extract_subpages();
	}
	if (!empty($notfound) && !empty($page_id)) {
		$vorgaben['redirect']['suffix'] = $_GET;						// redirect there
		header_location($page_id,$notfound);
	} elseif ($set_session && is_array($active)) {
		if (!empty($_SESSION['paths']['last'])) $_SESSION['paths']['before']= $_SESSION['paths']['last'];	// and finally remember
		if (!empty($_SESSION['paths']['now']))  $_SESSION['paths']['last']	= $_SESSION['paths']['now'];	// the last visited page
		$_SESSION['paths']['now'] = $bc_path;																// and the current.
	}
	unset($path2db,$exists,$add_breadc_fct,$bc_path);
}
function extract_subpages($current='') {
	global $dbobj,$add_breadc_fct,$bc_fct,$bc_path,$unterseite,$unterseite_id,$notfound,$sub_tpl;
	if (isset($unterseite) || isset($unterseite_id)) {
		$bc_fct = 0;$page_generated = 0;					// no breadcrumb function (bcf) executed yet
		if (!empty($add_breadc_fct)) {						// Check if bcf exists
			foreach ($add_breadc_fct as $fct) {					// go through every bcf
				if (function_exists($fct)) $fct($current);		// and execute
		}	}
		if (empty($bc_fct) && isset($unterseite) && !is_numeric($unterseite)) {			// if it's not a bcf it's probably a sub-page, let's have a look at its parents.
			if ($seite = $dbobj->exists(__file__,__line__,"SELECT Menu,kurzname,#PREFIX#seiten.PAGE_ID FROM #PREFIX#seiten,#PREFIX#seiten_attr,#PREFIX#kategorien WHERE #PREFIX#seiten.PAGE_ID = #PREFIX#seiten_attr.PAGE_ID AND #PREFIX#kategorien.KAT_ID = #PREFIX#seiten_attr.KAT_ID AND #PREFIX#seiten.Kurzname = '".$unterseite."' AND #PREFIX#seiten_attr.visibility = 1 AND #PREFIX#kategorien.visibility = 1")) {
				$sub_tpl['breadcrumbs'][$seite[0]['PAGE_ID']] = array('link'=>$bc_path,'Menu'=>$seite[0]['Menu']);
			} elseif (empty($page_generated)) {
				$notfound = true;
		}	}
		elseif (empty($bc_fct) && !empty($exists[0]['Menu']))	$sub_tpl['breadcrumbs'][$exists[0]['PAGE_ID']] = array('link'=>$bc_path,'Menu'=>$exists[0]['Menu']);
	}	elseif (!empty($current['Menu']))	$sub_tpl['breadcrumbs'][$current['PAGE_ID']] = array('link'=>$bc_path,'Menu'=>$current['Menu']);
}
function extract_page() {
	global $page,$path,$sub_tpl,$unterseite,$unterseite_id,$vorgaben;
	if (!empty($path[0]) && strtolower($path[0]) == 'logout')	logout(true);	// Check for Logout
	if (!empty($path[0])) 										$page = end($path);
	if (empty($vorgaben['nonumsubp']) && isset($page) && is_numeric($page)) {	// If numeric subpages can exists check for numbers
		$unterseite_id = $page;
		$sub_tpl['unterseite'] = $unterseite_id;
		array_pop($path);
		$page = end($path);														// set new path end
	}
	if (empty($vorgaben['nohtmlsubp']) && isset($page) && strpos($page,'.html')!==false) {	// If html-subpages are allowed check them,
		$sub_tpl['unterseite'] = $page;
		$unterseite = str_remove(array_pop($path),'.html');
		if (is_numeric($unterseite)) {
			$unterseite_id = $unterseite;
			if (empty($sub_tpl['unterseite']))	$sub_tpl['unterseite'] = $unterseite_id;
		}
		$page = end($path);
}	}
function build_menu($preview='') {
	global $tplobj,$dbobj,$lang,$lang_id,$first_lang,$vorgaben,$sub_tpl,$first_lang_id,$languages;
	unset($sub_tpl['menu'],$sub_tpl['submenus']);
	if(empty($lang)) $lang = &$first_lang;
	if (empty($sub_tpl['menulink']))	$sub_tpl['menulink']  = '<a href="$PATH$§SID§" title="$TITEL$">$MENU$</a>';
	if (empty($sub_tpl['menuentry']))	$sub_tpl['menuentry'] = '<li class="§ACTIVE:$PAGE_ID$§" id="$KN$" tabindex="$TI$"><a class="$CLASS$" id="id_$PAGE_ID$" href="$PATH$§SID§" title="$TITEL$" accesskey="$AK$" tabindex="$TI$">$MENU$</a>§SUBMENU:$PAGE_ID$§</li>';
	$sql = "SELECT 		#PREFIX#seiten_attr.PAGE_ID,#PREFIX#seiten_attr.parent_ID,	#PREFIX#seiten_attr.position,#PREFIX#seiten_attr.KAT_ID,#PREFIX#seiten_attr.TPL_ID,
						#PREFIX#seiten.Menu,		#PREFIX#seiten.Titel, 			#PREFIX#seiten.Beschreibung, #PREFIX#seiten.Kurzname,	#PREFIX#seiten.Ueberschrift,	#PREFIX#seiten.AK,
						#PREFIX#kategorien.titel AS kat,			parent_attr.KAT_ID AS parent_KAT_ID,	class.Kurzname as kn,
						GROUP_CONCAT(normal.Dateiname) AS normal,	GROUP_CONCAT(active.Dateiname) AS active
			FROM 		#PREFIX#kategorien,#PREFIX#seiten_attr
							LEFT JOIN (#PREFIX#seiten_attr AS parent_attr) ON (parent_attr.PAGE_ID = #PREFIX#seiten_attr.parent_ID)
							LEFT JOIN (#PREFIX#seiten AS class)			   ON (class.PAGE_ID = #PREFIX#seiten_attr.PAGE_ID AND class.LANG_ID = ".$first_lang_id."),
						#PREFIX#seiten
							LEFT JOIN (#PREFIX#bilder AS normal) ON (normal.PART_ID = 'menu'  AND normal.PAGE_ID = #PREFIX#seiten.PAGE_ID)
							LEFT JOIN (#PREFIX#bilder AS active) ON (active.PART_ID = 'menu2' AND active.PAGE_ID = #PREFIX#seiten.PAGE_ID)
			WHERE 		#PREFIX#seiten.LANG_ID = ".$lang_id."
			AND			#PREFIX#seiten_attr.PAGE_ID = #PREFIX#seiten.PAGE_ID
			AND			#PREFIX#seiten_attr.KAT_ID  = #PREFIX#kategorien.KAT_ID
			AND			#PREFIX#kategorien.visibility = 1";
	if ($vorgaben['is_preview'] && !empty($_REQUEST['page_id']) && is_numeric($_REQUEST['page_id'])) {
		$sql .= "\nAND	   (#PREFIX#seiten_attr.visibility	= 1 OR #PREFIX#seiten.PAGE_ID = ".$_REQUEST['page_id'].")";
	} else {
		$sql .= "\nAND		#PREFIX#seiten_attr.visibility	= 1";
	}
	if (!empty($vorgaben['checkdate']))
		$sql .= "\nAND	(#PREFIX#seiten.insdate <= '1970-01-01' OR #PREFIX#seiten.insdate = NULL OR #PREFIX#seiten.insdate <= CURDATE())";
	$sql .= sql_kat_status();
	$sql .= "\nGROUP BY PAGE_ID ORDER BY #PREFIX#kategorien.position,KAT_ID,#PREFIX#seiten_attr.lft ASC";
	if ($menu = $dbobj->withkey(__file__,__line__,$sql,'PAGE_ID')) {
		$tmp = current($menu);
		if (!empty($tmp) && is_array($tmp))	$menu[$tmp['PAGE_ID']]['Kurzname'] = '';
		if ($lang != $first_lang && ($vorgaben['localhost'] || empty($languages[$lang]['domain'])))	$l_path = '/'.$lang.'/';
		else 																						$l_path = '/';
		$n = 1;
		foreach ($menu as $page_id => $entry) {
			if (!empty($preview) && $preview == $page_id) {
				if (isset($sub_tpl['description']))					$entry['Beschreibung']	= str_replace(array("\r","\n"),array('',"  "),$sub_tpl['description']);
				if (isset($sub_tpl['breadcrumbs'][$page_id]))		$entry['Menu']			= $sub_tpl['breadcrumbs'][$page_id]['Menu'];
				if (isset($sub_tpl['titel']))						$entry['Titel']			= $sub_tpl['titel'];
			} elseif (!empty($entry['Beschreibung'])) 				$entry['Beschreibung']	= str_replace(array("\r","\n"),array('',"  "),$entry['Beschreibung']);
			$sub_tpl['all_Titel'][$page_id] 		= $entry['Titel'];
			$sub_tpl['all_Menu'][$page_id]	 		= $entry['Menu'];
			$sub_tpl['all_Kurzname'][$page_id]		= $entry['Kurzname'];
			$sub_tpl['all_Beschreibung'][$page_id]	= $entry['Beschreibung'];
			if (empty($entry['Menu']) && !empty($entry['Titel'])) 	$entry['Menu'] = $entry['Titel'];
			if (empty($entry['AK'])) {
				if (!empty($entry['Menu']))			$entry['AK'] = $entry['Menu'][0];
				elseif (!empty($entry['Kurzname']))	$entry['AK'] = $entry['Kurzname'][0];
				elseif (!empty($entry['kn']))		$entry['AK'] = $entry['kn'][0];
			}
			$entry['TI'] = $n++;
			if (!empty($entry['normal']) && strpos($entry['normal'],'_')!==false) 	get_menuimgs($entry['normal'],$page_id,'normal',$entry['position']);
			if (!empty($entry['active']) && strpos($entry['active'],'_')!==false)	get_menuimgs($entry['active'],$page_id,'active',$entry['position']);
			$menu2[$entry['kat']][$entry['parent_ID']][$page_id] = $entry;
		}
		$m=1; $k = 0;
		foreach ($menu2 as $kat => $k_menu) {
			$k++;
			foreach ($k_menu as $parent_ID => $page) {
				foreach ($page as $PAGE_ID => $entry) {
					$parentID = $entry['parent_ID'];
					lower($entry['kat']);
					$menu2[$kat][$parent_ID][$PAGE_ID]['position'] = $entry['position'];
					$menu2[$kat][$parent_ID][$PAGE_ID]['path']	 = $entry['Kurzname'];
					$menu2[$kat][$parent_ID][$PAGE_ID]['ACCK']	 = $entry['AK'];
				#	$menu2[$kat][$parent_ID][$PAGE_ID]['n']		   = $n++;
					$l = 0;
					if	(strpos($entry['Kurzname'],'http://')===false) {
						while ($parentID != 0 && !empty($menu[$parentID]) && $l<19) {
							if (!empty($menu[$parentID]['Kurzname']))	$menu2[$kat][$parent_ID][$PAGE_ID]['path'] = $menu[$parentID]['Kurzname'].'/'.$menu2[$kat][$parent_ID][$PAGE_ID]['path'];
							$parentID = $menu[$parentID]['parent_ID'];
							$l++;
					}	}
					if (empty($sub_tpl['menu'][$entry['kat']])) $m=1;
					if ($m==1 && $k==1) $class[] = 'first';
					elseif ($m==1)		$class[] = 'f2';
					$class[] = 'm'.$m++;
					$menu2[$kat][$parent_ID][$PAGE_ID]['class'] = implode(' ',$class);
					unset($class);
					$sub_tpl['all_paths'][$entry['Kurzname']]	= $menu2[$kat][$parent_ID][$PAGE_ID]['path'];
					$sub_tpl['paths_byid'][$lang_id][$PAGE_ID]	= $menu2[$kat][$parent_ID][$PAGE_ID]['path'];
					if	(strpos($entry['Kurzname'],'http://')===false)	$menu2[$kat][$parent_ID][$PAGE_ID]['path']	= $l_path.ltrim($menu2[$kat][$parent_ID][$PAGE_ID]['path'],'/');
					$x = $tplobj->array2tpl(array('menuentry','menulink'),$menu2[$kat][$parent_ID][$PAGE_ID],'$');
					$sub_tpl['menu_byid'][$PAGE_ID]				= $x['menuentry'];
					$sub_tpl['menu_link'][$PAGE_ID]				= $x['menulink'];
					$sub_tpl['ids_bykn'][$entry['Kurzname']]	= $PAGE_ID;
					$sub_tpl['kn_byid'][$PAGE_ID]				= $entry['Kurzname'];
					if (!empty($vorgaben['kategal']) || (empty($vorgaben['kategal']) && (empty($entry['parent_KAT_ID']) || $entry['KAT_ID'] == $entry['parent_KAT_ID']))) {
						if ($parent_ID == 0) {
							if (empty($sub_tpl['menu'][$entry['kat']] ))	$sub_tpl['menu'][$entry['kat']]  = '';
							$m_eintrag = "\t\t\t\t".str_replace('$PAGE_ID$',$PAGE_ID,$sub_tpl['menuentry']);
							$sub_tpl['menu'][$entry['kat']] .= "\n".str_repeat("\t\t",$l).$tplobj->array2tpl($m_eintrag,$menu2[$kat][$parent_ID][$PAGE_ID],'$',false,false,"\n",str_repeat("\t\t",$l));
						}
						$sub_tpl['submenus'][$parent_ID][] = "\n".str_repeat("\t\t\t",$l).preg_replace("/^\n/", "\n".str_repeat("\t\t\t",$l),$sub_tpl['menu_byid'][$PAGE_ID]);
	}	}	}	}	}
	unset($menu,$menu2);
}
function get_menuimgs($data,$page_id,$status,$position) {
	global $lang_id,$first_lang_id,$vorgaben,$sub_tpl;
	$menuimgs = explode(',',$data);
	foreach ($menuimgs as $menuimg) {
		$x = explode('_',$menuimg);			// Position 0: PAGE_ID; Position 1: LANG_ID ... everything else - never mind
		if (!empty($x[1]) )$bild[$x[1]] = $menuimg;			// Only LANG_ID is neccesary
	}
	$path = '/images/bilder/'.$page_id.'_';	// Path to image
	$base = $vorgaben['base_dir'].$path;	// Add base if CMS runs in sub directory.
	$sub_tpl['menu_imgs'][$page_id]['position'] = &$position;
	$sub_tpl['menu_imgs'][$page_id]['PAGE_ID']  = &$page_id;
	if		(isset($bild[$lang_id]) 	 && is_file($base.$bild[$lang_id])) 	 	$sub_tpl['menu_imgs'][$page_id][$status] = $path.$bild[$lang_id];
	elseif	(isset($bild[$first_lang_id])&& is_file($base.$bild[$first_lang_id]))	$sub_tpl['menu_imgs'][$page_id][$status] = $path.$bild[$first_lang_id];
	elseif	(								is_file($base.current($bild)))			$sub_tpl['menu_imgs'][$page_id][$status] = $path.current($bild);
}
function menu($data) {
	global $sub_tpl;
	$k = strtolower($data);
	if (strpos($k,'+')!==false || strpos($k,'|')!==false) {
		if (strpos($k,'|')!==false) {$ks = explode('|',$k);	$or = true;}
		else						{$ks = explode('+',$k);	$or = false;}
		foreach ($ks as $k) {
			if ($or && empty($sub_menu[0]) && !empty($sub_tpl['menu'][$k]))	$sub_menu[0]= $sub_tpl['menu'][$k];
			elseif (!$or && !empty($sub_tpl['menu'][$k]))					$sub_menu[] = $sub_tpl['menu'][$k];
	}	}
	if (!empty($sub_menu)) 					return implode("\n",$sub_menu);
	elseif (!empty($sub_tpl['menu'][$k]))	return $sub_tpl['menu'][$k];
}
function lastactive($data) {
	global $page_id;
	if ($data==$page_id)	return  ' active';
}
function isparent($data) {
	global $parent_id;
	if ($data==$parent_id)	return  ' parent';
}
function active($data) {
	global $page_id,$active;
	if  (is_array($data)) {
		if (!empty($data['usefct']) && function_exists($data['usefct'])) $data['condition'] = $data['usefct']($data);
			if (!empty($data['condition']) && !empty($data['request'])
				&& !empty($_REQUEST[$data['request']])
				&& $data['condition'] == $_REQUEST[$data['request']]) 				return ' active';
	} elseif ($data == $page_id || (!empty($active) && in_array($data,$active)))	return ' active';
}
function firstelement($class) {
	global $fe;
	if (empty($fe[$class]))	{
		$fe[$class] = 1;
		return 'class="'.$class.'"';
}	}
function menucss($data) {
	global $tplobj,$sub_tpl;
	if (!empty($sub_tpl['menu_imgs']) && !empty($sub_tpl['menu_css'])) {
		foreach ($sub_tpl['menu_imgs'] as $page_id => $menu_imgs) {
			$menu_imgs['p_id'] = $page_id;
			$menucss[] = $tplobj->array2tpl($sub_tpl['menu_css'],$menu_imgs,'#,$');
	}	}
	if (!empty($menucss))	 return implode("\n",$menucss);
}
function flagscss($data) {
	global $tplobj,$sub_tpl;
	if (!empty($sub_tpl['flag_imgs']) && !empty($sub_tpl['flag_css'])) {
		foreach ($sub_tpl['flag_imgs'] as $lang_id => $flag_imgs) {
			$flag_imgs['l_id'] = $lang_id;
			$style['l_'.$lang_id] = $tplobj->array2tpl($sub_tpl['flag_css'],$flag_imgs,'#,*');
	}	}
	if (!empty($style))	 return implode("\n",$style);
}
function siblings() {
	global $parent_id;
	return submenu($parent_id);
}
function submenu($data,$submenu='') {
	global $sub_tpl,$active,$parent_id,$page_id;
	if (!empty($sub_tpl['submenu']))	$tpl = $sub_tpl['submenu'];
	else								$tpl = "<ul>#SUBMENUS#</ul>";
	if (is_array($data)) {
		extract($data);
	}
	$matches = explode(',',$data);
	foreach ($matches as $match) {
		if (!empty($match) && !is_numeric($match) && !empty($$match)) {
			$match = $$match;
		} elseif (empty($match) && !empty($active) && is_array($active)) {
			reset($active);
			$match = current($active);
		}
		if (!empty($sub_tpl['submenus'][$match])) {
			$submenu .= preg_replace("/\n/", "\n\t\t",r_implode($sub_tpl['submenus'][$match],"\n"));
			$submenu = preg_replace_callback("'\|SUB_(.+?)\|'msi","submenu",$submenu);
	}	}
	if (!empty($add)) {
		$submenu .= $add;
	}
	if (!empty($submenu))return	preg_replace("/\n[\t]+\n/","\n",str_replace('#SUBMENUS#',$submenu,$tpl));
}
function menulink($data) {
	global $sub_tpl;
	$data = prep_data($data);
	if (!empty($sub_tpl['menu_link'][$data])) 	return preg_replace("/\§[A-Z0-9\:]+\§/Us",'',$sub_tpl['menu_link'][$data]);
}
function paginate(&$pages,$proseite='',$cache=true,$reverse=false) {
	global $unterseite_id,$sub_tpl;
	if (empty($proseite) && !empty($sub_tpl['proseite']))		$proseite  = $sub_tpl['proseite'];
	if (!empty($unterseite_id) && is_numeric($unterseite_id))	$start = $proseite*$unterseite_id;
	else														$start = 0;
	if (!$cache || empty($sub_tpl['subnav']))	build_subnav(count($pages),$proseite);
	if ($reverse) $pages = array_reverse($pages);
	$pages = array_slice($pages,$start,$proseite,true);
}
function build_subnav($anzahl,$proseite='',$linkto='',$start=0) {
	global $unterseite_id,$page_id,$sub_tpl;
	if (empty($proseite) && !empty($sub_tpl['proseite']))		$proseite  = $sub_tpl['proseite'];
	if (isset($unterseite_id))				$start  = $unterseite_id;
	if (empty($linkto) && !empty($page_id))	$linkto = linktonosid($page_id);
	else									$linkto = '';
	$nav = array();
	if ($anzahl > $proseite) {
		if (!isset($sub_tpl['voriges']))	$sub_tpl['voriges']		= '&lt;';
		if (!isset($sub_tpl['ersteseite']))	$sub_tpl['ersteseite']	= '&lt;&lt;';
		if (!isset($sub_tpl['folgendes']))	$sub_tpl['folgendes']	= '&gt;';
		if (!isset($sub_tpl['letzteseite']))$sub_tpl['letzteseite']	= '&gt;&gt;';
		if (!isset($sub_tpl['subnavspace']))$sub_tpl['subnavspace']	= '&nbsp;... ';
		if (!isset($sub_tpl['subnavsep']))	$sub_tpl['subnavsep']	= '&nbsp;&middot; ';
		if (!isset($sub_tpl['subnavlink']))	$sub_tpl['subnavlink']	= "\n<a href=\"".$linkto.'#TO#§SID§">#LINK#</a>';
		if (!isset($sub_tpl['subnavbox']))	$sub_tpl['subnavbox']	= '<p class="nav"><!-- (#ANZAHL#) -->#CONTENT#</p>';
		$sub_tpl['subnavlink'] = str_replace('$LINKTO$',$linkto,$sub_tpl['subnavlink']);
		$seiten = ceil($anzahl/$proseite);
		if ($start>0 && !empty($sub_tpl['ersteseite'])) {
			$nav[1] = subnavlink('',$sub_tpl['ersteseite']);
			if ($start-1 > 0)	$nav[2] = subnavlink(($start-1),$sub_tpl['voriges']);
			else				$nav[2] = subnavlink('',		$sub_tpl['voriges']);
		}
		switch ($start) {
			case 0: $range = 0; break;			// first three pages - to modify range
			case 1: $range = 1; break;
			case 2: $range = 2; break;
			default:
				switch ($seiten-$start) {
					case 0: $range = 0; break; // last three pages - to modify range
					case 1: $range = 1; break;
					case 2: $range = 2; break;
					default:$range = 3; break;
				}
			break;
		}
		$x=3;
		for($i=0;$i < $seiten; $i++) {
			if ($start - (6-$range) < $i && $start + (6-$range) > $i) {		// 6 items are shown, ... otherwise (2x $range in every direction)
				if (!empty($nav[$x]) && $nav[$x]==$sub_tpl['subnavspace'])	$x++;
				if ($start == $i) {
					$nav[$x]=  "\n".($i+1);
					if ($i-1 != 0)		$to = $i-1;
					else				$to = '';
					if ($i > 0) 		$sub_tpl['meta']['link']['prev'] = subnavlink($to,	 '','	<link rel="prev" href="'.$linkto.'#TO#§SID§" />');
					if ($i+1 < $seiten)	$sub_tpl['meta']['link']['next'] = subnavlink(($i+1),'','	<link rel="next" href="'.$linkto.'#TO#§SID§" />');
				} elseif ($i == 0)		$nav[$x] = subnavlink('',$i+1);
				else					$nav[$x] = subnavlink($i,$i+1);
				$x++;
			} else $nav[$x] = $sub_tpl['subnavspace'];
		}
		if($start<$seiten-1 && !empty($sub_tpl['letzteseite'])) {
			$nav[] = subnavlink(($start+1), $sub_tpl['folgendes']);
			$nav[] = subnavlink(($i-1),		$sub_tpl['letzteseite']);
		}
		$nav = implode($sub_tpl['subnavsep'],$nav);
		$von = $start*$proseite+1;
		$bis = ($start+1)*$proseite;
		if ($bis > $anzahl)	$bis = $anzahl;
		$sub_tpl['subnav'] = str_replace(array('#CONTENT#','#ANZAHL#','#VON#','#BIS#'),array($nav,$anzahl,$von,$bis),$sub_tpl['subnavbox']);
}	}
function subnavlink($to,$link='',$tpl='') {
	global $sub_tpl;
	if ($to != '') {
		if (!isset($sub_tpl['subnavpre']))	$sub_tpl['subnavpre'] = '/';
		if (!empty($sub_tpl['subnavext']))	$to .= '.'.$sub_tpl['subnavext'];
		$to = $sub_tpl['subnavpre'].$to;
	}
	if (empty($tpl))	$tpl = $sub_tpl['subnavlink'];
	return str_replace(array('#TO#','#LINK#'),array($to,$link),$tpl);
}
?>