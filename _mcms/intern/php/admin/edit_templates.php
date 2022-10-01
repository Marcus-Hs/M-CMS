<?php
function prepare_edit_templates() {
	global $add_admin;
	$add_admin['admin']['2_templates'] = array('function' => 'edit_templates','titel' => '%%VORLAGEN%%');
}
function startup_edit_templates($tpl) {
	return '<ul>'.vls('',false,'',false,$tpl['vorlage']).'</ul>';
}
function template_title($tpl_id) {
	global $dbobj;
	return  $dbobj->tostring(__file__,__line__,"SELECT Titel FROM #PREFIX#vorlagen WHERE TPL_ID = ".$tpl_id);
}
function edit_templates($tpl_ids='') {
	global $tplobj,$dbobj,$error,$first_lang_id,$sub_tpl,$vorgaben,$add_functions;
	add_fck();
	$tpls = $tplobj->read_tpls('admin/vorlagen.inc.html');
	if (!empty($_REQUEST['tmpl']['TPL_ID'])
			&& (empty($_REQUEST['tmpl']['remove']) || !in_array($_REQUEST['tmpl']['TPL_ID'],$_REQUEST['tmpl']['remove']))
			&& (empty($_SESSION['permissions']['TPL_ID']) || (in_array('alles',$_SESSION['permissions']['TPL_ID']) || in_array($_REQUEST['tmpl']['TPL_ID'],$_SESSION['permissions']['TPL_ID'])))) {
		if (is_numeric($_REQUEST['tmpl']['TPL_ID'])) {
			$TPL_ID = $_REQUEST['tmpl']['TPL_ID'];
			if (!empty($_REQUEST['tmpl']['LANG_ID']))	$LANG_ID = &$_REQUEST['tmpl']['LANG_ID'];
			else										$LANG_ID = &$first_lang_id;
			$sql = "SELECT  #PREFIX#vorlagen.*,
							COUNT(DISTINCT #PREFIX#seiten_attr.PAGE_ID) AS anz,
							CONCAT(#PREFIX#seiten_attr.PAGE_ID)			AS page_ids,
							next.TPL_ID as next_ID,last.TPL_ID			AS last_ID
					FROM	#PREFIX#vorlagen
							LEFT JOIN (#PREFIX#seiten_attr) ON (#PREFIX#seiten_attr.TPL_ID = #PREFIX#vorlagen.TPL_ID)
							LEFT JOIN (#PREFIX#vorlagen as next) ON (#PREFIX#vorlagen.TPL_ID = ".$TPL_ID." AND next.TPL_ID != #PREFIX#vorlagen.TPL_ID AND next.Position = (SELECT MIN(next.Position) FROM #PREFIX#vorlagen,#PREFIX#vorlagen AS next WHERE next.TPL_ID <> #PREFIX#vorlagen.TPL_ID AND #PREFIX#vorlagen.TPL_ID = ".$TPL_ID." AND next.Position >= #PREFIX#vorlagen.Position))
							LEFT JOIN (#PREFIX#vorlagen as last) ON (#PREFIX#vorlagen.TPL_ID = ".$TPL_ID." AND last.TPL_ID != #PREFIX#vorlagen.TPL_ID AND last.Position = (SELECT MAX(last.Position) FROM #PREFIX#vorlagen,#PREFIX#vorlagen AS last WHERE last.TPL_ID <> #PREFIX#vorlagen.TPL_ID AND #PREFIX#vorlagen.TPL_ID = ".$TPL_ID." AND last.Position < #PREFIX#vorlagen.Position))
					WHERE	#PREFIX#vorlagen.TPL_ID = ".$TPL_ID;
			if (!empty($_SESSION['permissions']['$TPL_ID'][0]) && !in_array('alles',$_SESSION['permissions']['$TPL_ID']))
				$sql .= "\nAND #PREFIX#vorlagen.KAT_ID IN (".implode(',',$_SESSION['permissions']['$TPL_ID']).")";
			$sql .= "\nGROUP BY #PREFIX#vorlagen.TPL_ID;";
			$tpl = $dbobj->singlequery(__file__,__line__,$sql);
			if (!empty($tpl[0]['Titel'])) {
				if (!empty($tpl[0]['Template'])) $tpl[0]['Template'] = my_htmlspecialchars($tpl[0]['Template']);
				$add_functions['2_templates']['title'] .= ': \''.$tpl[0]['Titel'].'\'';
				$tpl = $tpl[0];
				if (!empty($tpl['vorschaufixed']))	$tpl['vorschaufixed_'.$tpl['vorschaufixed']]= 'selected="selected"';
				if (!empty($tpl['bildfixed']))		$tpl['bildfixed_'.$tpl['bildfixed']]		= 'selected="selected"';
				if (!empty($tpl['cache']))			$tpl['chk_cache']		= 'checked="checked"';
				if (!empty($tpl['stats']))			$tpl['chk_stats']		= 'checked="checked"';
				if (!empty($tpl['showta']))			$tpl['chk_showta']		= 'checked="checked"';
				if (!empty($tpl['showanyway']))		$tpl['chk_showanyway']	= 'checked="checked"';
				$edit = '';
				if (!empty($tpl['last_ID'])) {
					$tpls['edit']			   = str_replace('|PREV|',$tplobj->array2tpl($tpls['link_prev'], $tpl),$tpls['edit']);
					$sub_tpl['admmeta']['link'][] = $tplobj->array2tpl($tpls['meta_prev'], $tpl);
				}
				if (!empty($tpl['next_ID'])) {
					$tpls['edit']			   = str_replace('|NEXT|',$tplobj->array2tpl($tpls['link_next'], $tpl),$tpls['edit']);
					$sub_tpl['admmeta']['link'][] = $tplobj->array2tpl($tpls['meta_next'], $tpl);
				}
				if (!empty($_REQUEST['copy']))	{
					$tpl['TPL_ID'] = 'neu';
					$error[] = '%%KOPIE_VON%%: '.$tpl['Titel'];
				}
				if ($tpl['anz']==1)			$tpl['ifsingle']  = '&amp;pages[PAGE_ID]='.$tpl['page_ids'];
			#	$tpl['Template'] = my_htmlspecialchars($tpl['Template']);
				$sub_tpl['pagetitle'] = "%%VORLAGE%%: ".$tpl['Titel'];
				if (isset($tpl['prefix'])) 										$tpls['edit'] = str_replace('|TPLPREFIX|',$tpls['tplprefix'],$tpls['edit']);
				else															$tpls['edit'] = str_remove($tpls['edit'],'|TPLPREFIX|');
				if (isset($tpl['bodyclass']) && !empty($tpls['bdyclss'])) 		$tpls['edit'] = str_replace('|BDYCLSS|',$tpls['bdyclss'],$tpls['edit']);
				if (isset($tpl['showanyway']) && !empty($tpls['showanyway']))	$tpls['edit'] = str_replace('|SHOWANYWAY|',$tpls['showanyway'],$tpls['edit']);
				else															$tpls['edit'] = str_remove($tpls['edit'],'|BDYCLSS|');
				if (!isset($tpl['proseite']) || !is_numeric($tpl['proseite'])) $tpl['proseite']=0;
				return $tplobj->array2tpl($tpls['edit'],$tpl);
		}	} else {
			$new['TPL_ID']	  = 'neu';
			$add_functions['2_templates']['title'] .= ' - %%NEU%%';
			return $tplobj->array2tpl($tpls['edit'],$new);
	}	} else {
		$sql = "SELECT	#PREFIX#vorlagen.*,
						COUNT(#PREFIX#seiten_attr.PAGE_ID) AS anz,
						CONCAT(#PREFIX#seiten_attr.PAGE_ID) AS page_ids
				FROM	#PREFIX#vorlagen LEFT JOIN (#PREFIX#seiten_attr) ON (#PREFIX#seiten_attr.TPL_ID = #PREFIX#vorlagen.TPL_ID)";
		if (!empty($_SESSION['permissions']['TPL_ID'][0]) && !in_array('alles',$_SESSION['permissions']['TPL_ID']))	$sql .= "\nWHERE #PREFIX#vorlagen.TPL_ID IN (".implode(',',$_SESSION['permissions']['TPL_ID']).")";
		elseif (!empty($tpl_ids))											$sql .= "\nWHERE #PREFIX#vorlagen.TPL_ID IN (".$tpl_ids.")";
		$sql  .= "\nGROUP BY 	TPL_ID ORDER BY position,titel,TPL_ID;";
		$tmpls = $dbobj->singlequery(__file__,__line__,$sql);
		$zeile_out = '';
		if (!empty($tmpls[0])) {
			foreach ($tmpls as &$tmpl) {			# fill template for each row
				if (!empty($tmpl['cache']))		$tmpl['chk_cache'] = 'checked="checked"';
				if (!empty($tmpl['stats']))		$tmpl['chk_stats'] = 'checked="checked"';
				if (!empty($tmpl['showta']))	$tmpl['chk_showta']= 'checked="checked"';
				if (!empty($tmpl['showanyway']))$tmpl['chk_showanyway']= 'checked="checked"';
				if ($tmpl['anz']==1)			$tmpl['ifsingle']  = '&amp;pages[PAGE_ID]='.$tmpl['page_ids'];
				$edit_out[$tmpl['TPL_ID']] = 0;
				$zeile_out .= "\n".$tplobj->array2tpl($tpls['zeilen'],$tmpl);
				$zeile_out = str_replace('|TPL_ID|',$tmpl['TPL_ID'],$zeile_out);
		}	}
		$sub_tpl['pagetitle'] = "%%VORLAGEN%%";
		return  str_replace('|VORLAGEN|',$zeile_out,$tpls['vorlagen']);	# fill template
}	}
function save_tmpl($data) {
	global $error,$dbobj,$vorgaben;
	$tmpl = &$_REQUEST['tmpl'];
	if (!empty($tmpl['TPL_ID'])) {
		if(empty($tmpl['Titel']))	$error['fehler'] = '%%VORLAGE_OHNE_TITEL%%'; #	Can't save template without title
		else {
			$dbobj->as_real = true;
			if (!empty($tmpl['styles']))	$tmpl['styles'] = trim($tmpl['styles']);
			else							$tmpl['styles'] = '';
			$in  = array('url(http://'.domain('*').'/','="http://'.domain('*').'/');
			$out = array('url(/',					   '="/');
			$tmpl['styles']	  = str_replace($in,$out,$tmpl['styles']);
			$tmpl['script']   = str_replace($in,$out,$tmpl['script']);
			$tmpl['Template'] = str_replace($in,$out,$tmpl['Template']);
			$tmpl['position'] = current($tmpl['position']);
			if (!empty($vorgaben['sub_dir'])) {
				$in  = array('url('.$vorgaben['sub_dir'].'/',	'="'.$vorgaben['sub_dir'].'/',	'=&quot;'.$vorgaben['sub_dir'].'/');
				$out = array('url(/',							'="/',							'=&quot;/');
				$tmpl['styles']	  = str_replace($in,$out,$tmpl['styles']);
				$tmpl['script']	  = str_replace($in,$out,$tmpl['script']);
				$tmpl['Template'] = str_replace($in,$out,$tmpl['Template']);
			}
			$tmpl['Template'] = html_entity_decode($tmpl['Template'], ENT_NOQUOTES);
			if (!is_numeric($tmpl['TPL_ID'])) 				$tmpl['TPL_ID'] = $dbobj->next_free_id('vorlagen','TPL_ID');
			if ($tmpl['TPL_ID'] == $vorgaben['seiten_tpl'])	$cache['truncate'] = true;
			else											$cache['tpl_id']   = $tmpl['TPL_ID'];
			if (empty($tmpl['cache']))						$tmpl['cache'] = 0;
			if (empty($tmpl['stats']))						$tmpl['stats'] = 0;
			if (empty($tmpl['showta']))						$tmpl['showta']= 0;
			if (empty($tmpl['showanyway']))					$tmpl['showanyway']= 0;
			if (!isset($tmpl['proseite']) || !is_numeric($tmpl['proseite'])) $tmpl['proseite']=0;
			$dbobj->array2db(__file__,__line__, $tmpl,'#PREFIX#vorlagen','INSERT INTO',"WHERE TPL_ID ='".$tmpl['TPL_ID']."'");
			$error['info'] = '%%AENDERUNGEN_SIND_EINGETRAGEN%%';
			$_REQUEST['tmpl']['TPL_ID'] = $tmpl['TPL_ID'];
	}	}
	elseif(!empty($tmpl['all_tpls'])) {
		if(in_array($vorgaben['seiten_tpl'],$tmpl['all_tpls']))	$cache['truncate'] = true;
		else													$cache['tpl_id'] = $tmpl['all_tpls'];
		foreach ($tmpl['all_tpls'] as $TPL_ID) {
			if (is_numeric($TPL_ID)) {
				if (!empty($tmpl['cache'][$TPL_ID])) 	$vorlage['cache'] = 1;
				else									$vorlage['cache'] = 0;
				if (!empty($tmpl['stats'][$TPL_ID])) 	$vorlage['stats'] = 1;
				else									$vorlage['stats'] = 0;
				if (!empty($tmpl['showta'][$TPL_ID])) 	$vorlage['showta'] = 1;
				else									$vorlage['showta'] = 0;
			#	if (!empty($tmpl['showanyway'][$TPL_ID]))$vorlage['showanyway'] = 1;
			#	else									$vorlage['showanyway'] = 0;
				if (!empty($tmpl['position'][$TPL_ID]))	$vorlage['position'] = $tmpl['position'][$TPL_ID];
				$dbobj->array2db(__file__,__line__,$vorlage,'#PREFIX#vorlagen','UPDATE','WHERE TPL_ID = "'.$TPL_ID.'"');
		}	}
		$error['info'] = '%%AENDERUNGEN_SIND_EINGETRAGEN%%';
	}
	if (!empty($tmpl['remove'])) {
		$error['removed'] = '%%VORLAGE_GELOESCHT%% (TPL_IDs = '.implode_ws(array_keys($tmpl['remove']),' %%UND%% ',', ').')'; # Die Vorlage ist Gel&ouml;scht worden.
		foreach ($tmpl['remove'] as $id => $value) {
			$pages = $dbobj->withkey(__file__,__line__,"SELECT PAGE_ID FROM #PREFIX#seiten_attr WHERE TPL_ID = ".$id.";",'PAGE_ID');
			if (!empty($pages) && is_array($pages)) {
				$page_ids = implode(',',array_keys($pages));
				$cache['page_ID']  = array_keys($pages);
				$sql['abschnitte'] 	= "DELETE FROM #PREFIX#abschnitte WHERE PAGE_ID IN  (".$page_ids.");";
				$sql['seiten'] 		= "DELETE FROM #PREFIX#seiten	  WHERE PAGE_ID IN (".$page_ids.");";
				deletefiles(array('PAGE_ID'=>$page_ids));
				cache::clean($cache);
			}
			if (is_numeric($id) && $id != $vorgaben['seiten_tpl']) {
				$sql['seiten_attr_'.$id]= "DELETE FROM #PREFIX#seiten_attr WHERE TPL_ID = ".$id.";";
				$sql['vorlagen_'.$id] 	= "DELETE FROM #PREFIX#vorlagen	   WHERE TPL_ID = ".$id.";";
			} else {
				$error['seiten_tpl'] = '%%NICHT_GELOESCHT%% (TPL_ID = '.$id.')';
			}
			if(!empty($page_ids) && is_array($page_ids))	deletefiles(array('PAGE_ID'=>implode(',',$page_id)));
	}	}
	if(!empty($sql))	$dbobj->multiquery(__file__,__line__,$sql);
	unset($cache);
}
function vls($first='',$selected=true,$vl_out='',$rem=true,$tpl='') {
	global $tplobj,$dbobj,$lang,$vls_intern;
	if (empty($tpl))		$tpl = '<option value="|TPL_ID|" |TPL_|TPL_ID||>|TITEL|</option>';
	if (empty($vls_intern) || !$rem) {
		$sql = "SELECT		#PREFIX#vorlagen.*, COUNT(#PREFIX#seiten_attr.PAGE_ID) AS anz, CONCAT(#PREFIX#seiten_attr.PAGE_ID) AS page_ids
				FROM		#PREFIX#vorlagen LEFT JOIN (#PREFIX#seiten_attr) ON (#PREFIX#seiten_attr.TPL_ID = #PREFIX#vorlagen.TPL_ID";
		if	 (!empty($_SESSION['permissions']['PAGE_ID'][0]) && in_array('eigene',$_SESSION['permissions']['PAGE_ID']))	$sql .= " AND #PREFIX#seiten_attr.person_ID = ".$_SESSION['uid']."";
		elseif (!empty($_SESSION['permissions']['PAGE_ID'][0]) && !in_array('alles',$_SESSION['permissions']['PAGE_ID']))	$sql .= " AND #PREFIX#seiten_attr.PAGE_ID IN (".implode(',',$_SESSION['permissions']['PAGE_ID']).")";
		$sql .= ")";
		if (!empty($_SESSION['permissions']['TPL_ID'][0]) && !in_array('alles',$_SESSION['permissions']['TPL_ID']))		$sql .= "\n WHERE #PREFIX#vorlagen.TPL_ID IN (".implode(',',$_SESSION['permissions']['TPL_ID']).")";
		$sql .= "\n GROUP BY TPL_ID ORDER BY position;";
		$vls_intern = $dbobj->withkey(__file__,__line__,$sql,'TPL_ID');
	}
	if (!empty($vls_intern) && is_array($vls_intern)) {
		if (!empty($first)) {
			array_unshift($vls_intern,$first);
			$rem = false;
		}
		foreach ($vls_intern as $tplid => $vl) {
			if (!empty($vl['Titel']))					$vl['Titel'] = $vl['Titel'];
			if (!empty($vl['anz']) && $vl['anz']==1) 	$vl['ifsingle'] = '&amp;pages[PAGE_ID]='.$vl['page_ids'];
			$vl_out .= "\n".$tplobj->array2tpl($tpl,$vl);
	}	}
	if (!$rem) unset($vls_intern);
	if (is_numeric($selected) && empty($vls_intern[$selected]) && !empty($tpl))	$vl_out .= $tplobj->array2tpl($tpl,array('Titel'=>$dbobj->tostring(__file__,__line__,"SELECT #PREFIX#vorlagen.Titel FROM #PREFIX#vorlagen WHERE TPL_ID = ".$selected," LIMIT 1;")));
	if (!empty($selected) && is_numeric($selected)) 							$vl_out = str_replace('|TPL_'.$selected.'|','selected="selected"',$vl_out);
	elseif (!empty($_REQUEST['TPL_ID']) && $selected) 							$vl_out = str_replace('|TPL_'.$_REQUEST['TPL_ID'].'|','selected="selected"',$vl_out);
	return $vl_out;
}
?>