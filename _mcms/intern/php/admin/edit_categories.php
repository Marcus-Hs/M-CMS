<?php
function prepare_edit_categories() {
	global $add_admin;
	$add_admin['admin']['1_categories'] = array('function' => 'admin_categories','titel' => '%%KATEGORIEN%%');
}
function startup_admin_categories($tpl) {
	return '<ul>'.kats('',false,'',false,$tpl['kategorie']).'</ul>';
}
function admin_categories() {
	global $tplobj,$dbobj,$sub_tpl,$error,$add_functions;
	$tpls = $tplobj->read_tpls('admin/kategorien.inc.html');
	if (!empty($_REQUEST['kat']['KAT_ID']) && (empty($_REQUEST['kat']['remove']) || !in_array($_REQUEST['kat']['KAT_ID'],$_REQUEST['kat']['remove']))
				&& (empty($_SESSION['permissions']['KAT_ID']) || (in_array('alles',$_SESSION['permissions']['KAT_ID']) || in_array($_REQUEST['kat']['KAT_ID'],$_SESSION['permissions']['KAT_ID'])))) {
		if (is_numeric($_REQUEST['kat']['KAT_ID'])) {
			$KAT_ID = &$_REQUEST['kat']['KAT_ID'];
			$sql = "SELECT	#PREFIX#kategorien.*,
							COUNT(DISTINCT #PREFIX#seiten_attr.PAGE_ID) AS anz,
							next.KAT_ID as next_ID,
							last.KAT_ID as last_ID
					FROM	#PREFIX#kategorien
								LEFT JOIN (#PREFIX#seiten_attr) ON (#PREFIX#seiten_attr.KAT_ID = #PREFIX#kategorien.KAT_ID)
								LEFT JOIN (#PREFIX#kategorien as next) ON (#PREFIX#kategorien.KAT_ID = ".$KAT_ID." AND next.KAT_ID != #PREFIX#kategorien.KAT_ID AND next.Position = (SELECT MIN(next.Position) FROM #PREFIX#kategorien,#PREFIX#kategorien AS next WHERE next.KAT_ID <> #PREFIX#kategorien.KAT_ID AND #PREFIX#kategorien.KAT_ID = ".$KAT_ID." AND next.Position >= #PREFIX#kategorien.Position))
								LEFT JOIN (#PREFIX#kategorien as last) ON (#PREFIX#kategorien.KAT_ID = ".$KAT_ID." AND last.KAT_ID != #PREFIX#kategorien.KAT_ID AND last.Position = (SELECT MAX(last.Position) FROM #PREFIX#kategorien,#PREFIX#kategorien AS last WHERE last.KAT_ID <> #PREFIX#kategorien.KAT_ID AND #PREFIX#kategorien.KAT_ID = ".$KAT_ID." AND last.Position < #PREFIX#kategorien.Position))
					WHERE	#PREFIX#kategorien.KAT_ID = ".$KAT_ID;
			if (!empty($_SESSION['permissions']['KAT_ID'][0]) && !in_array('alles',$_SESSION['permissions']['KAT_ID']))
				$sql .= "\nAND #PREFIX#kategorien.KAT_ID IN (".implode(',',$_SESSION['permissions']['KAT_ID']).")";
			$sql .= "\nGROUP BY #PREFIX#kategorien.KAT_ID ORDER BY #PREFIX#kategorien.position";
			if ($elements = $dbobj->exists(__file__,__line__,$sql)) {
				$element = $elements[0];
				$add_functions['1_categories']['title'] .= ': \''.$element['Titel'].'\'';
				if (!empty($element['visibility']))	$element['visible'] = 'checked="checked"';
				else								$element['visible'] = '';
				if (!empty($element['follow']))		$element['follow']	= 'checked="checked"';
				else								$element['follow']	= '';
				$element['status'] = sel_status($element['status'],true);
				if (!empty($_REQUEST['copy'])) {
					$element['KAT_ID'] = $dbobj->next_free_id('kategorien','KAT_ID');
					$error['info'] = '%%KOPIE%%: '.$element['Titel'];
					unset($element['anz']);
				}
				if (!empty($element['last_ID'])) {
					$tpls['edit'] = str_replace('|PREV|',$tplobj->array2tpl($tpls['link_prev'], $element),$tpls['edit']);
					$sub_tpl['admmeta']['link'][] = $tplobj->array2tpl($tpls['meta_prev'], $element);
				}
				if (!empty($element['next_ID'])) {
					$tpls['edit'] = str_replace('|NEXT|',$tplobj->array2tpl($tpls['link_next'], $element),$tpls['edit']);
					$sub_tpl['admmeta']['link'][] = $tplobj->array2tpl($tpls['meta_next'], $element);
			}	}
		} else {
			$element = array('KAT_ID'=>'neu','visible'=>'','position'=>'99','status'=>sel_status('',true));
		}
		return "\n".$tplobj->array2tpl($tpls['edit'],$element);
	} else {
		$sql = "SELECT	#PREFIX#kategorien.*,
						COUNT(#PREFIX#seiten_attr.PAGE_ID)  AS anz,
						CONCAT(#PREFIX#seiten_attr.PAGE_ID) AS page_ids
				FROM	#PREFIX#kategorien
							LEFT JOIN (#PREFIX#seiten_attr) ON (#PREFIX#seiten_attr.KAT_ID = #PREFIX#kategorien.KAT_ID)";
					if (!empty($_SESSION['permissions']['KAT_ID'][0]) && !in_array('alles',$_SESSION['permissions']['KAT_ID']))
			$sql .= "\nWHERE #PREFIX#kategorien.KAT_ID IN (".implode(',',$_SESSION['permissions']['KAT_ID']).")";
		$sql .= "\nGROUP BY KAT_ID ORDER BY position";
		$zeile_out = '';
		if ($elements = $dbobj->exists(__file__,__line__,$sql)) {
			foreach ($elements as &$element) {			# Template für die einzelnen Zeilen füllen
				if ($element['anz'] == 1)		$element['ifsingle']= '&amp;pages[PAGE_ID]='.$element['page_ids'];
				if ($element['visibility'] == 1)$element['visible']	= 'checked="checked"';
				else							$element['visible']	= '';
				if (!empty($element['follow']))	$element['follow']	= 'checked="checked"';
				else							$element['follow']	= '';
				$element['status'] = sel_status($element['status'],true);
				$zeile_out .= "\n".$tplobj->array2tpl($tpls['zeilen'],$element);
		}	}
		return str_replace('|KATEGORIEN|',$zeile_out,$tpls['kategorien']);	# Template füllen
}	}
function save_kat($data=false) {
	global $error,$dbobj;
	if (!empty($_REQUEST['kat']['KAT_ID'])) {
		if(empty($_REQUEST['kat']['Titel']))$error['fehler'] = '%%KATEGORIE_OHNE_TITEL%%'; #	'Ohne Titel kann die Kategorie nicht gespeichert werden.';
		else {
			$kat = &$_REQUEST['kat'];
			if (!empty($kat['visibility']))	$kat['visibility'] = 1;
			else							$kat['visibility'] = 0;
			if (empty($kat['status']))		$kat['status'] = 0;
			if(!empty($kat['follow']))		$kat['follow'] = 1;
			else							$kat['follow'] = 0;
			if ($kat['KAT_ID'] == 'neu') {
				if (!is_numeric($kat['KAT_ID'])) 		$kat['KAT_ID'] = $dbobj->next_free_id('kategorien','KAT_ID');
				$_REQUEST['kat']['KAT_ID'] = $kat['KAT_ID'];
				$error['info'] = '%%KATEGORIE_IST_ANGELEGT%%';
			} elseif($dbobj->exists(__file__,__line__,"SELECT KAT_ID FROM #PREFIX#kategorien WHERE KAT_ID = ".$kat['KAT_ID'].";")) {
				$error['info'] = '%%AENDERUNGEN_SIND_EINGETRAGEN%%';
			}
			$dbobj->array2db(__file__,__line__,$kat,'#PREFIX#kategorien','INSERT INTO','WHERE KAT_ID ='.$kat['KAT_ID']);
			$cache['kat_id'] = $kat['KAT_ID'];
		}
	} elseif (!empty($_REQUEST['kat']['all_kats'])) {
		$cache['truncate'] = true;
		foreach ($_REQUEST['kat']['all_kats'] as $KAT_ID) {
			if (!empty($_REQUEST['kat']['remove'][$KAT_ID])) {
				$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#kategorien WHERE KAT_ID = ".$KAT_ID.";");
				$sites = $dbobj->withkey(__file__,__line__,"SELECT PAGE_ID FROM #PREFIX#seiten_attr WHERE KAT_ID = ".$KAT_ID.";",'PAGE_ID');
				if (!empty($sites) && is_array($sites)) {
					$page_ids = implode(' OR PAGE_ID = ',array_keys($sites));
					$sql['abschnitt_'.$page_ids] 	= "DELETE FROM #PREFIX#abschnitte WHERE PAGE_ID = ".$page_ids.";";
					$sql['seite_'.$page_ids] 		= "DELETE FROM #PREFIX#seiten	 WHERE PAGE_ID = ".$page_ids.";";
					deletefiles(array('PAGE_ID'=>$page_ids));
				}
				$sql['seiten_attr'] = "DELETE FROM #PREFIX#seiten_attr WHERE KAT_ID = ".$KAT_ID.";";
			} else {
				if(!empty($_REQUEST['kat']['position'][$KAT_ID]))	$kat['position'] = $_REQUEST['kat']['position'][$KAT_ID];
				if(!empty($_REQUEST['kat']['follow'][$KAT_ID]))		$kat['follow'] = 1;
				else												$kat['follow'] = 0;
				if(!empty($_REQUEST['kat']['visibility'][$KAT_ID]))	$kat['visibility'] = 1;
				else												$kat['visibility'] = 0;
				if (!empty($_REQUEST['kat']['status'][$KAT_ID]))	$kat['status'] = $_REQUEST['kat']['status'][$KAT_ID];
				else												$kat['status'] = 0;
				$dbobj->array2db(__file__,__line__,$kat,'#PREFIX#kategorien','UPDATE','WHERE KAT_ID ='.$KAT_ID);
		}	}
		if (!empty($sql))	$dbobj->multiquery(__file__,__line__,$sql);
		if (empty($error['fehler'])) $error['info'] = '%%AENDERUNGEN_SIND_EINGETRAGEN%%';
	}
	if (!empty($cache))	cache::clean($cache);
}
?>