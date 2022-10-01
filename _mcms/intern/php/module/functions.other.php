<?php
function read_settings($get_this,$uid=false,$content_name=false) {
	global $error,$dbobj,$tplobj;
	$switch = false;
	if ($uid) {
		$sql='SELECT content_name,content_value	FROM #PREFIX#person__settings WHERE person_ID = '.$uid.';';
	} elseif (current($get_this) == 'person_ID') {
		$sql='SELECT content_name,person_ID		FROM #PREFIX#person__settings WHERE content_name = "'.$content_name.'";';
		$get_this =array($content_name);
		$switch = true;
	} elseif ($content_name) {
		$sql='SELECT content_name,content_value	FROM #PREFIX#person__settings WHERE content_name = "'.$content_name.'";';
	} else {
		$uid = uid();
		$sql='SELECT content_name,content_value	FROM #PREFIX#person__settings WHERE person_ID = '.uid().';';
	}
	if ($switch && $data = $dbobj->withkey(__file__,__line__,$sql,'person_ID',true)) {
		return array_keys($data);
	} elseif($uid && $data = $dbobj->withkey(__file__,__line__,$sql,'content_name',true)) {
		foreach ($get_this as $key) {
			if (!empty($data[$key])) {
				$setting[$key]		= current($data[$key]);
		}	}
		if (!empty($setting))	return $setting;
	}
	return false;
}
function save_settings($data,$set_this) {
	global $error,$dbobj,$tplobj;
	foreach ($set_this as $key) {
		if (!empty($data[$key])) {
			$setting['content_name'] = $key;
			$setting['content_value'] = $data[$key];
			$setting['person_ID'] = uid();
			$dbobj->array2db(__file__,__line__,$setting,'#PREFIX#person__settings','INSERT INTO');
		} else {
			$dbobj->singlequery(__file__,__line__,'DELETE FROM #PREFIX#person__settings WHERE content_name = "'.$key.'" AND person_ID = '.uid().';');
		}
	}
}
function read_storage($names = array(),$overwrite=false) {
	foreach ($names as $name) {
		if (isset($_REQUEST[$name])) {
			$_REQUEST[$name] = my_setcookies($_REQUEST[$name],$name,$overwrite);
			$_SESSION[$name] = $_REQUEST[$name];
		}
		elseif (!empty($_COOKIE[$name]))$_REQUEST[$name] = my_readcookies($name);
	}
}
function my_setcookies($value='',$name='',$overwrite=false,$days=1) {
	if ($prev = my_readcookies($name)){
		if (is_array($value) && is_array($prev))	$value = $value + $prev;
	}
	$arr_cookie_options = array (
				'expires' => time()+(60*60*24*$days),
				'path' => '/',
				'domain' => domain('*'), // leading dot for compatibility or use subdomain
				'samesite' => 'Strict' // None || Lax  || Strict
				);
	setcookie($name, serialize($value), $arr_cookie_options);
	return $value;
}
function my_readcookies($name='',$key='') {
/*	if (!empty($_SESSION[$name])) {
		if (empty($key))						return $_SESSION[$name];
		elseif (!empty($_SESSION[$name][$key]))	return $_SESSION[$name][$key];
	}
*/	if (!empty($_COOKIE[$name]) && is_string($_COOKIE[$name]) && $_COOKIE[$name] != 'deleted') {
		$data = unserialize($_COOKIE[$name]);
		replaceArray($data,'+',' ');
		if (empty($key))				return $data;
		elseif (!empty($data[$key]))	return $data[$key];
	} elseif (!empty($_COOKIE[$name])) {
		return $_COOKIE[$name];
	} 
	return false;
}
function my_unsetcookies($names='',$value=null,$time=-1) {
	if (is_array($names)) {
		foreach ($names as $name){
			my_unsetcookie($name,$value,$time);
		}
	}
	else my_unsetcookie($names,$value);
}
function my_unsetcookie($name='',$value=null,$time=-1) {
	unset($_COOKIE[$name],$_REQUEST[$name]); 
	setcookie($name,$value,$time,'/');
}
function generate_hash($hash_name='',$ID_name='client_ID',$ID_value=false) {
	global $dbobj;
	if (!$ID_value) $ID_value = uid();
	$hash_value = md5(uniqid().$hash_name.$ID_value);
	$insert = array('ID_name'=>$ID_name,'ID_value'=>$ID_value,'hash_name'=>$hash_name,'hash_value'=>$hash_value);
	$dbobj->array2db(__file__,__line__,$insert,'#PREFIX#person__hashes');
	return $hash_value;
}
function check_hash($hash_name,$hash_check,$ID_name='client_ID') {
	return read_hash($hash_name,$hash_check,$ID_name);
}
function remove_hash($hash_name='',$hash=false,$ID_name='client_ID',$ID_value=false) {
	global $dbobj;
	if ($hash)
		$sql = "DELETE	FROM #PREFIX#person__hashes WHERE hash_value = '".$hash."' AND hash_name = '".$hash_name."';";
	else
		$sql = "DELETE	FROM #PREFIX#person__hashes WHERE ID_name = '".$ID_name."' AND ID_value = '".$ID_value."' AND hash_name = '".$hash_name."';";
	if (!empty($sql))			return $dbobj->singlequery(__file__,__line__,$sql);
}
function read_hash($hash_name='',$hash=false,$ID_name='client_ID',$ID_value=false) {
	global $dbobj;
	if (!$hash && $ID_name && $ID_value)	{
		$sql = "SELECT	CONCAT(hash_name,'=',hash_value)
				FROM	#PREFIX#person__hashes
				WHERE 	ID_name LIKE '%".$ID_name."%'
				AND 	ID_value LIKE '%".$ID_value."%' 
				LIMIT 1;";
	}
	elseif (!$hash && $ID_value)$sql = "SELECT hash_value	AS '".$hash_name."'	FROM #PREFIX#person__hashes WHERE ID_name = '".$ID_name."' AND hash_name = '".$hash_name."' AND ID_value  = '".$ID_value."';";
	elseif (is_string($hash))	$sql = "SELECT ID_value		AS '".$ID_name."'	FROM #PREFIX#person__hashes WHERE ID_name = '".$ID_name."' AND hash_name = '".$hash_name."' AND hash_value = '".$dbobj->escape($hash)."';";	
	if (!empty($sql))			return $dbobj->tostring(__file__,__line__,$sql);
	else 						return false;
}
function subpage_of($data='',$add='') {	// Show subpages
	global $tplobj,$dbobj,$lang,$first_lang_id,$lang_id,$unterseite_intern,$display_tree,$vorgaben;
	$default = array('PAGE_ID'=>'','parent_ID'=>'','TPL_ID'=>'','KAT_ID'=>'','highlight'=>'','cache'=>true,'all'=>false,'VISIBILITY'=>'0,1');
	if (!empty($data) && is_string($data))	$data['parent_ID'] = $vorgaben[$data];
	extract(merge_defaults_user($default,$data,'parent_ID'),EXTR_SKIP);
	if (empty($display_tree))	display_tree();	// read tree-structure of pages.
	if ($cache===false)			unset($unterseite_intern);
	if (empty($unterseite_intern)) {	// only if not cached (faster because it's needed for every shown page)
		$unterseite_intern = array();
		$sql = "SELECT	#PREFIX#seiten.Ueberschrift,#PREFIX#seiten.Menu,/*#PREFIX#seiten.Beschreibung,*/#PREFIX#seiten_attr.*,#PREFIX#seiten_attr.KAT_ID,
						L_seiten.Menu  AS L_Menu,
						L_seiten.Titel AS L_Titel,
						FL_seiten.Menu  AS FL_Menu,
						FL_seiten.Titel AS FL_Titel,
						#PREFIX#person.Name
				FROM	#PREFIX#person,#PREFIX#kategorien,#PREFIX#seiten_attr,
						#PREFIX#seiten LEFT JOIN (#PREFIX#seiten as L_seiten) ON
									(L_seiten.LANG_ID = '".$lang_id."' AND #PREFIX#seiten.PAGE_ID = L_seiten.PAGE_ID)
										LEFT JOIN (#PREFIX#seiten as FL_seiten) ON
									(FL_seiten.LANG_ID = '".$first_lang_id."' AND #PREFIX#seiten.PAGE_ID = FL_seiten.PAGE_ID)
				WHERE	#PREFIX#seiten_attr.PAGE_ID = #PREFIX#seiten.PAGE_ID
				AND		#PREFIX#person.ID   = #PREFIX#seiten_attr.person_ID
				AND		#PREFIX#kategorien.KAT_ID   = #PREFIX#seiten_attr.KAT_ID
				AND		#PREFIX#kategorien.visibility IN (".$VISIBILITY.")
				AND		#PREFIX#seiten_attr.visibility IN (".$VISIBILITY.")";
		if (!empty($parent_ID))	$sql .= "\n	AND #PREFIX#seiten_attr.parent_ID IN (".$parent_ID.")";
		if (!empty($TPL_ID)) 	$sql .= "\n	AND #PREFIX#seiten_attr.TPL_ID	IN (".$TPL_ID.")";
		if (!empty($KAT_ID)) 	$sql .= "\n	AND #PREFIX#seiten_attr.KAT_ID	IN (".$KAT_ID.")";
		if (!empty($LANG_ID)) 	$sql .= "\n	AND #PREFIX#seiten.LANG_ID   	  IN (".$LANG_ID.")";
		$sql .= "\n	GROUP BY	#PREFIX#seiten.PAGE_ID
					ORDER BY 	#PREFIX#kategorien.position,#PREFIX#seiten_attr.position,parent_ID ASC";
		$pages			= $dbobj->withkey(__file__,__line__,$sql,'PAGE_ID',false,true);
		$subpage_tpl	= $tplobj->read_tpls('admin/unterseite_von.entry.html');
		foreach ($display_tree as $branch) {
			if (!empty($pages[$branch['PAGE_ID']]))	{
				$page				= $pages[$branch['PAGE_ID']][0];
				$page['PAGE_ID']	= $branch['PAGE_ID'];
				if (strpos($page['Name'],' ')!==false) {
					list($fn,$ln)	= explode(' ',$page['Name']);
					if (!empty($ln))	$page['i']		= $fn[0].$ln[0];
					else				$page['i']		= $fn[0];
				}
				if (empty($page['Menu'])) {
					if		(!empty($page['L_Menu']))	$page['Menu']  = $page['L_Menu'];
					elseif	(!empty($page['FL_Menu']))	$page['Menu']  = $page['FL_Menu'];
				}
				if (empty($page['Titel'])) {
					if 		(!empty($page['L_Titel']))	$page['Titel'] = $page['L_Titel'];
					elseif	(!empty($page['FL_Titel']))	$page['Titel'] = $page['FL_Titel'];
				}
				if (empty($page['Menu']))	$page['Menu']  = $branch['Menu'];
				if (empty($page['Titel'])) 	$page['Titel'] = $branch['Menu'];
				$page['Titel'] = str_remove($page['Titel'],array("\r","\n",'"'));
				$page['Titel'] = truncate($page['Titel'],35);
				$page['Menu']  = truncate($page['Menu'],35);
				$page['Menu2'] = str_repeat('&#160;&#160;',$branch['level']).$page['Menu'];
				$unterseite_intern[$branch['PAGE_ID']] = $tplobj->array2tpl($subpage_tpl,$page);
	}	}	}
	$unterseite_von = implode("\n",$unterseite_intern);
	if (!$all && !empty($PAGE_ID) &&  is_numeric($PAGE_ID) && empty($unterseite_intern[$PAGE_ID]) && !empty($subpage_tpl))
		$unterseite_von = $tplobj->array2tpl($subpage_tpl,array('PAGE_ID'=>$PAGE_ID,'Menu'=>get_page(array('PAGE_ID'=>$PAGE_ID,'feld'=>'Menu','visibility'=>'0,1','errors'=>false))));
	if (!empty($highlight)) {
		$ids = explode(',',r_implode($highlight));
		foreach ($ids as $id)		$unterseite_von = str_replace('|HIGHLIGHT_'.$id.'|','style="background-color:yellow;"',$unterseite_von);
	}
	if (!empty($PAGE_ID)) {
		$ids = explode(',',r_implode($PAGE_ID));
		foreach ($ids as $id)		$unterseite_von = str_replace('|SEL_'.$id.'|','selected="selected"',$unterseite_von);
	}
	elseif (!empty($_REQUEST['parent_ID']) && is_numeric($_REQUEST['parent_ID']))								$unterseite_von = str_replace('|SEL_'.$_REQUEST['parent_ID'].'|','selected="selected"',$unterseite_von);
	elseif (!empty($_REQUEST['pages_attr']['parent_ID'])  && is_numeric($_REQUEST['pages_attr']['parent_ID']))	$unterseite_von = str_replace('|SEL_'.$_REQUEST['pages_attr']['parent_ID'].'|','selected="selected"',$unterseite_von);
	return $unterseite_von;
}
function display_tree($root=0) {	// read tree-structure of pages.
	global $tplobj,$dbobj,$display_tree,$first_lang_id,$vorgaben;
	if (!$display_tree = cache::fetch('REBUILDTREE_'.$_SESSION['uid']))		$display_tree = array(); // this can be a lot, so we look if it's chached and save some trouble
	if (empty($display_tree) && $parents = $dbobj->withkey(__file__,__line__,'SELECT PAGE_ID,lft, rgt FROM #PREFIX#seiten_attr WHERE parent_ID="'.$root.'";','PAGE_ID')){   // retrieve the left and right value of the $root node
		foreach ($parents as $parent) {
			$right = array();																// start with an empty $right stack
			$sql = "SELECT	#PREFIX#seiten_attr.PAGE_ID,parent_ID,#PREFIX#seiten_attr.position,s2.Menu, lft, rgt,s1.Menu AS Menu_lang,
							floor((rgt - lft)/2) AS kids,
							#PREFIX#kategorien.position AS k_pos
					FROM 	#PREFIX#seiten_attr
								LEFT JOIN (#PREFIX#seiten as s1)	ON (#PREFIX#seiten_attr.PAGE_ID = s1.PAGE_ID AND s1.LANG_ID = '".$first_lang_id."')
								LEFT JOIN (#PREFIX#seiten as s2)	ON (#PREFIX#seiten_attr.PAGE_ID = s2.PAGE_ID AND s2.LANG_ID = '".$vorgaben['verwaltung_sprache']."')
								LEFT JOIN (#PREFIX#kategorien)		ON (#PREFIX#kategorien.KAT_ID = #PREFIX#seiten_attr.KAT_ID)";
			$sql .= "\nWHERE	lft BETWEEN ".$parent['lft']." AND ".$parent['rgt']."";
			$sql .= pages_sql();
			$sql .= "\nGROUP BY lft ORDER BY lft ASC;";
			if ($result = $dbobj->withkey(__file__,__line__,$sql,'PAGE_ID',false)) {			// now, retrieve all descendants of the $root node
				foreach ($result as $row) { 									// display each row
					$level = 0;
					if (!empty($row['parent_ID'])) {										// only check stack if there is one
						$p_old = $row['parent_ID'];
						while ($p_old != 0 && !empty($result[$p_old]) && $level<19) {									// check if we should remove a node from the stack
							$level++;
							$p_old = $result[$p_old]['parent_ID'];
					}	}
					$key = str_pad($row['lft'],5,'0',STR_PAD_LEFT).'_'.str_pad($row['PAGE_ID'],5,'0',STR_PAD_LEFT);
					$display_tree[$key]['rgt']		= $row['rgt'];
					$display_tree[$key]['PAGE_ID']	= $row['PAGE_ID'];
					$display_tree[$key]['kids']		= $row['kids'];
					$display_tree[$key]['pos']		= $row['position'];
					$display_tree[$key]['k_pos']	= $row['k_pos'];
					$display_tree[$key]['level']	= $level;
					if (!empty($row['Menu_lang'])) $row['Menu'] = $row['Menu_lang'];
					$display_tree[$key]['Menu'] = str_repeat('&#160;&#160;',$level).$row['Menu'];
					$right[] = $row['rgt']; 												// add this node to the stack
		}	}	}
		ksort($display_tree);
		cache::put(array('path'=>'REBUILDTREE_'.$_SESSION['uid'],'content'=>$display_tree));
}	}
function pages_scope($scope) {
	$sql = '';
	foreach ($scope as $key => $val) {
		$sql .= "\n AND (".$key." = ".$val.")";
	}
	return $sql;
}
function pages_sql($t='#PREFIX#seiten_attr',$sql='') { // some trickery on page requests
	if	(!empty($_SESSION['permissions']['KAT_ID'][0])  && !in_array('alles',$_SESSION['permissions']['KAT_ID'])) { // kategory choosen
		$sql .= "\n AND ".$t.".KAT_ID IN (".implode(',',$_SESSION['permissions']['KAT_ID']).")";
	}
	if (!empty($_SESSION['permissions']['PAGE_ID'][0]) && in_array('eigene',$_SESSION['permissions']['PAGE_ID']) && !in_array('alles',$_SESSION['permissions']['PAGE_ID'])) { // pages choosen
		$sql .= "\n AND (".$t.".person_ID = ".$_SESSION['uid']."";
		$tmp_ids = $_SESSION['permissions']['PAGE_ID'];
		unset($tmp_ids[array_search('eigene',$_SESSION['permissions']['PAGE_ID'])]);
	#	if (!empty($tmp_ids) && is_array($tmp_ids))	$sql .= " OR ".$t.".PAGE_ID IN (".implode(',',$tmp_ids).")";
		$sql .= ")";
		unset($tmp_ids);
	} elseif	(!empty($_SESSION['permissions']['PAGE_ID'][0]) && !in_array('alles',$_SESSION['permissions']['PAGE_ID'])) { // alles = everything
		$sql .= "\n AND ".$t.".PAGE_ID IN (".implode(',',$_SESSION['permissions']['PAGE_ID']).")";
	}
	return $sql;
}
function kats($first='',$selected=true,$out='',$rem=true,$tpl='') {
	global $tplobj,$dbobj,$lang,$kat_intern;
	if (empty($kat_intern) || !$rem) {
		$sql = "SELECT	#PREFIX#kategorien.*,
						COUNT(#PREFIX#seiten_attr.PAGE_ID)  AS anz,
						CONCAT(#PREFIX#seiten_attr.PAGE_ID) AS page_ids
				FROM	#PREFIX#kategorien
							LEFT JOIN (#PREFIX#seiten_attr) ON (#PREFIX#seiten_attr.KAT_ID = #PREFIX#kategorien.KAT_ID";
		if		(!empty($_SESSION['permissions']['PAGE_ID'][0]) && in_array('eigene',$_SESSION['permissions']['PAGE_ID']))	$sql .= " AND #PREFIX#seiten_attr.person_ID = ".$_SESSION['uid']."";
		elseif	(!empty($_SESSION['permissions']['PAGE_ID'][0]) && !in_array('alles',$_SESSION['permissions']['PAGE_ID']))	$sql .= " AND #PREFIX#seiten_attr.PAGE_ID IN (".implode(',',$_SESSION['permissions']['PAGE_ID']).")";
		$sql .= ")";
		if (!empty($_SESSION['permissions']['KAT_ID'][0]) && !in_array('alles',$_SESSION['permissions']['KAT_ID']))			$sql .= "\n WHERE #PREFIX#kategorien.KAT_ID IN (".implode(',',$_SESSION['permissions']['KAT_ID']).")";
		$sql .= "\n GROUP BY KAT_ID ORDER BY position;";
		$kat_intern = array();
		if ($kats = $dbobj->withkey(__file__,__line__,$sql,'KAT_ID')) {
			foreach ($kats as $kid => $kat) {
				$kat['Titel'] = my_htmlentities($kat['Titel']);
				if ($kat['anz']==1) $kat['ifsingle'] = '&amp;pages[PAGE_ID]='.$kat['page_ids'];
				$kat_intern[$kid] = $tplobj->array2tpl($tpl,$kat);
	}	}	}
	$kat_out = implode("\n",$kat_intern);
	if (is_numeric($selected) && empty($kat_intern[$selected]) && !empty($tpl))	$kat_out .= $tplobj->array2tpl($tpl,array('Titel'=>$dbobj->tostring(__file__,__line__,"SELECT #PREFIX#kategorien.Titel WHERE KAT_ID = ".$selected," LIMIT 1;")));
	if (!empty($selected) && is_numeric($selected)) 							$kat_out = str_replace('|KAT_'.$selected.'|','selected="selected"',$kat_out);
	elseif (!empty($_REQUEST['KAT_ID']) && $selected) 							$kat_out = str_replace('|KAT_'.$_REQUEST['KAT_ID'].'|','selected="selected"',$kat_out);
	if (!empty($first)) 														$kat_out = $tplobj->array2tpl($tpl,array('ID' => '','titel' => $first)).$kat_out;
	return str_remove($out.$kat_out,'KAT_ID||');
}
function speichern() {
	if (!empty($_SESSION['status']) && $_SESSION['logged'] && !empty($_SESSION['permissions'])) { // To save you have to be logged in as Admin or Editor and have the permissions
		if (empty($_SESSION['permissions']['nosave']) && (!empty($_SESSION['permissions']['admin']) || !empty($_SESSION['permissions']['editor'])) ) {
			if (!empty($_REQUEST['remove_file']) && is_array($_REQUEST['remove_file']))						remove_file();
			if (!empty($_REQUEST['remove_img'])  && is_array($_REQUEST['remove_img']))						remove_img();
			if (!empty($_REQUEST['move_file'])   && is_array($_REQUEST['move_file']))						move_file();
		}
		if (!empty($_SESSION['permissions']['tpl'])   && !empty($_REQUEST['tmpl']))							save('tmpl');
		if (!empty($_SESSION['permissions']['kats'])  && !empty($_REQUEST['kat']))							save('kat');
		if (!empty($_SESSION['permissions']['pages'])) {
			if (!empty($_REQUEST['pages_attr']['all_pages']) && is_array($_REQUEST['pages_attr']['all_pages']))	save('pages_attr');
			if (!empty($_REQUEST['pages']))	{
				save('pages');
			}
		#	if (function_exists('optimize_tables'))																optimize_tables('_cache,seiten,seiten_attr,vorlagen,abschnitte',false);
}	}	}
function save($function,$data=false) {
	global $error;
	$f = 'save_'.$function;
	if (empty($_SESSION['permissions']['nosave']) && function_exists($f)) { // If save is allowed for user and function exists.
		write_vorgaben(array('last_change'=>date("d.m.Y H:i")));
		return $f($data);
	} elseif (!empty($_SESSION['permissions']['nosave']))	$error['nosave'] = '%%SPEICHERN_NICHT_ERLAUBT%%';
}
function rebuild_tree($parent=0,$left=0) {
	global $dbobj,$rb_sql;
	do_rebuild_tree($parent,$left);
	$dbobj->multiquery(__file__,__line__,$rb_sql,true);
	if (!empty($_SESSION['uid'])) cache::clean(array('path' => 'REBUILDTREE_'.$_SESSION['uid']));
	unset($rb_sql);
}
function do_rebuild_tree($parent,$left) {
	global $tplobj,$dbobj,$rb_sql;
	$right = $left+1;									// the right value of this node is the left value + 1
	if ($result = $dbobj->withkey(__file__,__line__,'SELECT PAGE_ID FROM #PREFIX#seiten_attr,#PREFIX#kategorien WHERE parent_ID='.$parent.'	AND #PREFIX#kategorien.KAT_ID = #PREFIX#seiten_attr.KAT_ID ORDER BY #PREFIX#kategorien.position,parent_ID,#PREFIX#seiten_attr.position ASC;','PAGE_ID')) {	// get all children of this node
		foreach ($result as $page_id => $row) {			// recursive execution of this function for each child of this node
			$right = do_rebuild_tree($page_id, $right);	// $right is the current right value, which is incremented by the rebuild_tree function
	}	}												// we've got the left value, and now that we've processed the children of this node we also know the right value
	if (!empty($parent))	$rb_sql[$parent] = 'UPDATE #PREFIX#seiten_attr SET lft='.$left.', rgt='.$right.' WHERE PAGE_ID="'.$parent.'";';
	return $right+1;   									// return the right value of this node + 1
}
function add_lightbox() {
	global $sub_tpl;
	if (empty($sub_tpl['CSS']['magnific-popup'])) {
		$sub_tpl['JS']['magnific-popup'] = 'jquery/magnific-popup.min.js';	$sub_tpl['CSS']['magnific-popup'] = '/jquery/magnific-popup.css';
		$sub_tpl['addscript'][]	= 'if ($(".admin_bild .lb").length>0) {$(".admin_bild .lb").magnificPopup({type:\'image\',titleSrc:\'title\',gallery:{enabled:true}});};';
}	}
function add_colorpicker() {
	global $sub_tpl;
	if (empty($sub_tpl['CSS']['clrpcker'])) {
		$sub_tpl['JS']['clrpcker']  = 'jquery/spectrum.js';		$sub_tpl['CSS']['clrpcker'] = 'jquery/spectrum.css';
}	}
function add_datepicker($prescript='') {
	global $tplobj,$sub_tpl;
	if (empty($sub_tpl['CSS']['datePicker'])) {
		$sub_tpl['JS'][] = 'jquery/date.js'; $sub_tpl['JS'][] = 'jquery/date_de.js'; $sub_tpl['JS'][] = 'jquery/datePicker.js';
		$sub_tpl['CSS']['datePicker'] = 'jquery/datePicker.css';
		if (!empty($sub_tpl[$prescript]))	$sub_tpl['prescript'][] = $sub_tpl[$prescript];
		else 								$sub_tpl['prescript'][] = $tplobj->read_tpls("$.dpText = {TEXT_PREV_YEAR: '%%VORJAHR%%', TEXT_NEXT_YEAR: '%%FOLGEJAHR%%', TEXT_PREV_MONTH: '%%VORMONAT%%', TEXT_NEXT_MONTH: '%%FOLGEMONAT%%', TEXT_CLOSE: '%%SCHLIESSEN%%', TEXT_CHOOSE_DATE: '%%AUSWAHL%%'};");
}	}
function add_fck() {
	global $tplobj,$sub_tpl,$languages_byid,$vorgaben;
	if (!empty($_SESSION['pref_lang']) && !empty($languages_byid[$_SESSION['pref_lang']]))	$l = $languages_byid[$_SESSION['pref_lang']]['short'];
	else																					$l = 'en';
#	if (empty($vorgaben['imgtitlerpl']))  $vorgaben['imgtitlerpl']	= 'Titel';
	if (empty($vorgaben['showblocks']))	  $vorgaben['showblocks']	= 'false';
	else								  $vorgaben['showblocks']	= 'true';
	if (empty($vorgaben['forceplain']))	  $vorgaben['forceplain']	= 'false';
	else								  $vorgaben['forceplain']	= 'true';
	if (empty($vorgaben['cleanword']))	  $vorgaben['cleanword']	= 'false';
	else								  $vorgaben['cleanword']	= 'true';
	if (empty($vorgaben['FontFormats']))  $vorgaben['FontFormats']	= 'p;h3;h4;h5;div';
	if (empty($vorgaben['select_TBS_1'])) $vorgaben['select_TBS_1']	= 'basic';
	if (empty($vorgaben['select_TBS_2'])) $vorgaben['select_TBS_2']	= 'mini';
	if (empty($vorgaben['select_TBS_3'])) $vorgaben['select_TBS_3']	= 'micro';
	$sub_tpl['JS'][] 		= 'admin/ckeditor/ckeditor.js';
	$sub_tpl['JS'][] 		= 'admin/ckeditor/adapters/jquery.js';
	$colorButton_colors = array();
	if (!empty($sub_tpl['coloraccent']))	$colorButton_colors[] = $sub_tpl['coloraccent'];
	if (!empty($sub_tpl['colormain']))		$colorButton_colors[] = $sub_tpl['colormain'];
	if (!empty($sub_tpl['colorerror']))		$colorButton_colors[] = $sub_tpl['colorerror'];
	if (!empty($sub_tpl['colorinfo']))		$colorButton_colors[] = $sub_tpl['colorinfo'];
	if (!empty($sub_tpl['colorbg']))		$colorButton_colors[] = $sub_tpl['colorbg'];
	if (!empty($sub_tpl['colorred']))		$colorButton_colors[] = $sub_tpl['colorred'];
	if (!empty($sub_tpl['colororange']))	$colorButton_colors[] = $sub_tpl['colororange'];
#	print_r($sub_tpl);
#	die();
	$colorButton_colors = r_implode($colorButton_colors);
	if (empty($colorButton_colors))			$colorButton_colors = '#FF0000,#00FF00';
	$sub_tpl['prescript']['ck_config'] = $tplobj->array2tpl(
	"	\tvar imgtitlerpl = '|IMGTITLERPL|';
		var ck_config = new Array();
			ck_config['FontFormats'] = '|FONTFORMATS|';
			ck_config['colorButton_colors'] = '".$colorButton_colors."';
			ck_config['BodyId'] = '|BODYID|'; 					ck_config['BodyClass'] = '|BODYCLASS|';
			ck_config['DefaultLanguage'] = '".$l."';
			ck_config['ForcePasteAsPlainText']	= |FORCEPLAIN|; ck_config['StartupShowBlocks'] = |SHOWBLOCKS|;
			ck_config['CleanWordKeepsStructure'] = |CLEANWORD|;
			ck_config['ToolbarSet_1'] = '|SELECT_TBS_1|'; 		ck_config['ToolbarSet_2'] = '|SELECT_TBS_2|'; 		ck_config['ToolbarSet_3'] = '|SELECT_TBS_3|';
			ck_config['CSS'] = ".getcss().";",$vorgaben);
			$sub_tpl['prescript']['ck_config'] = $tplobj->array2tpl($sub_tpl['prescript']['ck_config'],$sub_tpl);
}
function getcss($PAGE_ID=true) {
	global $dbobj,$vorgaben;
	if ($PAGE_ID && !empty($_REQUEST['pages']['PAGE_ID']))		$PAGE_ID = $_REQUEST['pages']['PAGE_ID'];
	else														$PAGE_ID = $vorgaben['home']['PAGE_ID'];
	if (!is_numeric($PAGE_ID) && !empty($vorgaben[$PAGE_ID]))	$PAGE_ID = $vorgaben[$PAGE_ID];
	$sql = "SELECT		#PREFIX#vorlagen.CSS
			FROM		#PREFIX#vorlagen,#PREFIX#seiten_attr
			WHERE		(#PREFIX#seiten_attr.PAGE_ID = '".$PAGE_ID."' OR #PREFIX#seiten_attr.TPL_ID = '".$vorgaben['seiten_tpl']."')
			AND			#PREFIX#vorlagen.TPL_ID = #PREFIX#seiten_attr.TPL_ID";
	$css = explode_lines($dbobj->tostring(__file__,__line__,$sql),',');
	return '[\''.r_implode("','",$css).'\']';
}
function viewportmeta() {
	global $sub_tpl;
	if(is_mobile()) return $sub_tpl['viewmobile'];
	else return $sub_tpl['viewdesktop'];
}
function is_mobile() {
	if (!empty($_SERVER['HTTP_USER_AGENT'])) {
		$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
		$winphone = strpos($_SERVER['HTTP_USER_AGENT'],"Windows Phone");
		$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
		$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
		$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
		$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
		$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
	}
	if($iphone || $winphone || $android || $palmpre || $ipod || $berry)
	  return true;
	else
	  return false;
}
function convertToWindowsCharset($string) {
	$charset = mb_detect_encoding($string,"UTF-8, ISO-8859-1, ISO-8859-15",true);
	$string  = mb_convert_encoding($string,"Windows-1252",$charset);
	return $string;
}
function select_kat($data) {
	global $dbobj,$tplobj,$lang_id,$sub_tpl,$kats;
	if (empty($kats)) {
		$sql = "SELECT	#PREFIX#kategorien.*, COUNT(#PREFIX#seiten_attr.PAGE_ID) AS catcount
				FROM	#PREFIX#kategorien LEFT JOIN (#PREFIX#seiten_attr,#PREFIX#seiten)
							ON (#PREFIX#seiten_attr.KAT_ID = #PREFIX#kategorien.KAT_ID
								AND #PREFIX#seiten_attr.PAGE_ID 	= #PREFIX#seiten.PAGE_ID
								AND #PREFIX#seiten_attr.visibility	= 1
								AND #PREFIX#seiten.LANG_ID			= ".$lang_id.")
				WHERE	#PREFIX#kategorien.visibility = 1
				GROUP BY KAT_ID ORDER BY position;";
		$kats = $dbobj->withkey(__file__,__line__,$sql,'KAT_ID',true);
	}
	if (!empty($kats[$data['KAT_ID']])) {
		if (!empty($data['suffix']) && !empty($kats[$data['KAT_ID']]['catcount']))	$kats[$data['KAT_ID']]['suffix'] = str_replace('#',$kats[$data['KAT_ID']]['catcount'],$data['suffix']);
		else																		$kats[$data['KAT_ID']]['suffix'] = '';
		return $tplobj->array2tpl($data['TPL'],$kats[$data['KAT_ID']],'$');
}	}
function merge_defaults_user($out,$user='',$key='') {
	global $vorgaben;
	if (!empty($user) && is_array($user))	$out = array_merge($out,$user);
	elseif (!empty($user) && !empty($key)) {
		if (!empty($vorgaben[$user]))	$out[$key] = $vorgaben[$user];
		else							$out[$key] = $user;
	}
	return $out;
}
function read_vorgabe($name='') {
	global $dbobj;
	if ($out = $dbobj->tostring(__file__,__line__,"SELECT value FROM #PREFIX#vorgaben WHERE name = '".$name."';"))	return $out;
	else 																											return false;
}
function write_vorgaben($data) {
	global $error,$dbobj;
	foreach ($data as $k => $v) {
		$insert[$k]['name']	= $k;
		$insert[$k]['value']= $v;
		$dbobj->array2db(__file__,__line__,$insert[$k],'#PREFIX#vorgaben','INSERT INTO','WHERE name = "'.$k.'"');
	}
}
function add_vorgaben($data) {
	global $error,$dbobj;
	$sql = 'UPDATE #PREFIX#vorgaben SET value=value+1 WHERE name = "'.$data.'";';
	$dbobj->singlequery(__file__,__line__,$sql);
}
function rnd($data,$min = 0,$max = 10) {
	if (strpos($data,',')!==false)	list($min,$max) = explode(',',$data);
	elseif (!empty($data))			$max = $data;
	return rand($min,$max);
}
function Random_Password($len,$password='') {
	$salt = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789.:-)(_!,;";
	srand((double)microtime()*1000000);
	for ($i=0;$i<$len;$i++)	$password = $password.substr($salt,rand()%strlen($salt),1);
	return $password;
}
function make_kn($string,$pages='',$truncate=false) {
	global $dbobj,$sub_tpl;
	$string = unaccent($string);
	$string = str_replace('#SHY#','',$string);
	$string = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''),$string);
#	lower($string);
	$string = preg_replace( '/\_+/','_',trim($string,'_'));
	if ($truncate && is_numeric($truncate)) {
		$ext = '';
		if (strpos($string,'.')>0)
			$ext = endstr($string,'.');
		$string = substr(str_replace('.'.$ext,'',$string), 0, $truncate).'.'.$ext;
	}
	if (!empty($pages)) {
		while ($dbobj->exists(__file__,__line__,"SELECT #PREFIX#seiten.PAGE_ID FROM #PREFIX#seiten WHERE #PREFIX#seiten.PAGE_ID <> ".$pages['PAGE_ID']." AND LANG_ID = ".$pages['LANG_ID']." AND Kurzname = '".$string."';"))
			$string .= '_';
#		while (is_dir($string))
#			$string = '_'.$string;
		if ($ex = $dbobj->exists(__file__,__line__,"SELECT kurzname,PAGE_ID FROM #PREFIX#seiten WHERE PAGE_ID = ".$pages['PAGE_ID']." AND LANG_ID = ".$pages['LANG_ID'].";")) {
			if($ex[0]['kurzname'] != $string) {
				$sql_r[] = "DELETE FROM #PREFIX#seiten_redirects WHERE ex_kurzname = '".$ex[0]['kurzname']."' OR PAGE_ID = '".$ex[0]['PAGE_ID']."';";
				$sql_r[] = "INSERT INTO #PREFIX#seiten_redirects (ex_kurzname,PAGE_ID) VALUES ('".$ex[0]['kurzname']."',".$ex[0]['PAGE_ID'].");";
				$dbobj->multiquery(__file__,__line__,$sql_r);
	}	}	}
	else {
		$string = trim($string,'_');
	}
	return $string;
}
function process_dir($dir,$recursive = FALSE,$ext='') {
	if (is_dir($dir)) {
		for ($list = array(),$handle = opendir($dir); (FALSE !== ($file = readdir($handle)));) {
			if (($file != '.' && $file != '..') && (file_exists($dir.'/'.$file))) {
				if (is_dir($dir.'/'.$file) && ($recursive)) {
					$list = array_merge($list, process_dir($dir.'/'.$file, TRUE,$ext));
				} elseif (is_file($dir.'/'.$file) && (empty($ext) || is_array($ext) && in_array(endstr($file,'.'),$ext))) {
					$list[] = array('filename' => $file, 'path' => $dir.'/'.$file);
		}	}	}
		closedir($handle);
		return $list;
	} else return false;
}
function countTags($string,$htmlTag){
  $openTags  = preg_match_all('/<'.$htmlTag.'\b[^>]*>/',$string,$otags);
  $closeTags = preg_match_all('/<\/'.$htmlTag.'>/',$string,$ctags);
  return array($openTags, $closeTags);
}
function domain($k='',$check='') {
/*	if (function_exists('gethostname'))		$host = gethostname();
	elseif (function_exists('php_uname'))	$host = php_uname('n');*/
	if (!empty($_SERVER['HTTP_HOST']))		$host = $_SERVER['HTTP_HOST'];
	else									$host = $_SERVER['SERVER_NAME'];
	if (!empty($k) && $k=='*') {
		return	$host;
	} else {
		$domain = explode('.',$host);
		$tld  = end($domain);
		$name = prev($domain);
		if (!empty($check)) {
			if (is_array($check) && in_array($domain[$k],$check))	return true;
			elseif ($domain[$k]==$check)							return true;
			else													return false;
		}
		if (is_numeric($k))	return	$domain[$k];
		else 				return	$name.'.'.$tld;
}	}
/**
  * Transforms $_SERVER HTTP headers into a nice associative array. For example:
  *   array(
  *	   'Referer' => 'example.com',
  *	   'X-Requested-With' => 'XMLHttpRequest'
  *   )
  */
function get_request_headers() {
	$headers = array();
	foreach($_SERVER as $key => $value) {
		if(strpos($key, 'HTTP_') === 0) {
			$headers[str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
	}	}
	return $headers;
}
function sql_kat_status($status='') {
	if ($status=='' && !empty($_SESSION['status']))	$status = $_SESSION['status'];
	if		($status=='any') 			return '';
	elseif	(empty($status)) 			return "\nAND #PREFIX#kategorien.status = 0 ";
	elseif  (is_numeric($status))		return "\nAND ".'(#PREFIX#kategorien.status = 0
													OR #PREFIX#kategorien.status LIKE "%,'.$status.',%"
													OR #PREFIX#kategorien.status LIKE "%,'.$status.'"
													OR #PREFIX#kategorien.status LIKE "'.$status.',%"
													OR #PREFIX#kategorien.status = "'.$status.'")';
}
function url_protocol($data,$protocol=true) {
	global $vorgaben,$lang,$first_lang,$languages;
	if ($protocol=='https'  && !empty($vorgaben['https_domain'])
							&& !empty($vorgaben['https_domain'])
						#	&& !$vorgaben['localhost']
							&& $vorgaben['https_domain'] != $vorgaben['https_domain']) {
		if ($lang != $first_lang)	$data = str_replace($languages[$lang]['domain'],$vorgaben['https_domain'].'/'.$lang,$data);
		else						$data = str_replace($languages[$lang]['domain'],$vorgaben['https_domain'],$data);
	}
	$data = str_remove($data,array('http://','https://'));
#	if (!$vorgaben['localhost']) {
		if (is_string($protocol) && !$vorgaben['localhost'])							$data = $protocol.'://'.$data;
		elseif ($protocol && !empty($vorgaben['protocol']))	$data = $vorgaben['protocol'].$data;
#	}
	return $data;
}
function hasSSL($domain) {
	$ip = gethostbyname($domain);
	$url = "http://" . $domain;
	$orignal_parse = parse_url($url, PHP_URL_HOST);
	$get = stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));
	$read = @stream_socket_client("ssl://" . $orignal_parse . ":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
	if ($read) $cert = stream_context_get_params($read);
	else       return false;
 	$result = (!is_null($cert)) ? true : false;
 	return $result;
}
function isCrawler() {
	$crawlers = 'Google|bot|Rambler|Yahoo|BOT|accoona|Seek|Crawler|Bot|Scooter|AltaVista|eStyle|Scrub';
	return (preg_match("/$crawlers/",$_SERVER['HTTP_USER_AGENT']) > 0);
}
function array_utf8encode(&$arr) {array_walk_recursive($arr, function(&$val) { return utf8_encode($val);});};
function array_utf8decode(&$arr) {array_walk_recursive($arr, function(&$val) { return utf8_decode($val);});};
function array_htmlencode(&$arr) {array_walk_recursive($arr, function(&$val) { return str_replace("&","#AMP#",my_htmlentities($val));});};
function array_htmldecode(&$arr) {array_walk_recursive($arr, function(&$val) { return html_entity_decode(str_replace("#AMP#","&",$val));});};
function my_htmlentities($string,$encoding = null) {
	global $sub_tpl;
	if (empty($encoding) && !empty($sub_tpl['codepage']) && !is_numeric($sub_tpl['codepage'])) {
		$encoding = $sub_tpl['codepage'];
	}
	if (version_compare(phpversion(), '5.4', '<')) {
		return htmlentities($string);
	} else {
		return htmlentities($string,ENT_QUOTES | ENT_IGNORE,$encoding);
}	}
function my_htmlspecialchars($string,$encoding = null) {
	global $sub_tpl;
	if (empty($encoding) && !empty($sub_tpl['codepage']) && !is_numeric($sub_tpl['codepage'])) {
		$encoding = $sub_tpl['codepage'];
	}
	if (version_compare(phpversion(), '5.4', '<')) {
		return htmlspecialchars($string);
	} else {
		return htmlspecialchars($string,ENT_COMPAT,$encoding,true);
}	}
/**
 * xml2array() will convert the given XML text to an array in the XML structure.
 * Link: http://www.bin-co.com/php/scripts/xml2array/
 * Arguments : $contents - The XML text
 *				$get_attributes - 1 or 0. If this is 1 the function will get the attributes as well as the tag values - this results in a different array structure in the return value.
 *				$priority - Can be 'tag' or 'attribute'. This will change the way the resulting array sturcture. For 'tag', the tags are given more importance.
 * Return: The parsed XML in an array form. Use print_r() to see the resulting array structure.
 * Examples: $array =  xml2array(file_get_contents('feed.xml'));
 *			  $array =  xml2array(file_get_contents('feed.xml', 1, 'attribute'));
 */
function xml2array($contents, $get_attributes=1, $priority = 'tag') {
	if(!$contents) return array();
	if(!function_exists('xml_parser_create')) {
		//print "'xml_parser_create()' function not found!";
		return array();
	}
	//Get the XML parser of PHP - PHP must have this module for the parser to work
	$parser = xml_parser_create('');
	xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
	xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
	xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	xml_parse_into_struct($parser, trim($contents), $xml_values);
	xml_parser_free($parser);
	if(!$xml_values) return;//Hmm...
	//Initializations
	$xml_array = array();
	$parents = array();
	$opened_tags = array();
	$arr = array();
	$current = &$xml_array; //Refference
	//Go through the tags.
	$repeated_tag_index = array();//Multiple tags with same name will be turned into an array
	foreach($xml_values as $data) {
		unset($attributes,$value);//Remove existing values, or there will be trouble
		//This command will extract these variables into the foreach scope
		// tag(string), type(string), level(int), attributes(array).
		extract($data);//We could use the array by itself, but this cooler.
		$result = array();
		$attributes_data = array();
		if(isset($value)) {
			if($priority == 'tag') $result = $value;
			else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
		}
		//Set the attributes too.
		if(isset($attributes) and $get_attributes) {
			foreach($attributes as $attr => $val) {
				if($priority == 'tag') $attributes_data[$attr] = $val;
				else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
		}	}
		//See tag status and do the needed.
		if($type == "open") {//The starting of the tag '<tag>'
			$parent[$level-1] = &$current;
			if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
				$current[$tag] = $result;
				if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
				$repeated_tag_index[$tag.'_'.$level] = 1;
				$current = &$current[$tag];
			} else { //There was another element with the same tag name
				if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
					$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
					$repeated_tag_index[$tag.'_'.$level]++;
				} else {//This section will make the value an array if multiple tags with the same name appear together
					$current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
					$repeated_tag_index[$tag.'_'.$level] = 2;
					if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
						$current[$tag]['0_attr'] = $current[$tag.'_attr'];
						unset($current[$tag.'_attr']);
				}	}
				$last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
				$current = &$current[$tag][$last_item_index];
			}
		} elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
			//See if the key is already taken.
			if(!isset($current[$tag])) { //New Key
				$current[$tag] = $result;
				$repeated_tag_index[$tag.'_'.$level] = 1;
				if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;
			} else { //If taken, put all things inside a list(array)
				if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...
					// ...push the new element into that array.
					$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
					if($priority == 'tag' and $get_attributes and $attributes_data) {
						$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
					}
					$repeated_tag_index[$tag.'_'.$level]++;
				} else { //If it is not an array...
					$current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
					$repeated_tag_index[$tag.'_'.$level] = 1;
					if($priority == 'tag' and $get_attributes) {
						if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
					   #	$current[$tag]['0_attr'] = $current[$tag.'_attr'];
					   #	 unset($current[$tag.'_attr']);
						}
						if($attributes_data) {
							$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
					}	}
					$repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
			}	}
		} elseif($type == 'close') { //End of tag '</tag>'
			$current = &$parent[$level-1];
	}	}
	return($xml_array);
}
?>