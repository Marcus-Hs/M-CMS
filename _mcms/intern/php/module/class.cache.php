<?php
class cache {
	public static function read() {
		global $dbobj,$sub_tpl,$path_in,$page_id,$lang_id,$vorgaben;
		path();
		$vorgaben['page_cached'] = false;
		$vorgaben['menu_cached'] = false;
		$vorgaben['cache_read']  = false;
		$p = false;
		if ($vorgaben['cache'] && empty($_REQUEST)) $p = cache::fetch($path_in,$lang_id);
		if ($p) { // Inhalte aus Cache holen, wenn die Seit enicht aktuell aufgebaut werden muss
			$sub_tpl = array_merge($sub_tpl,$p);
			$vorgaben['page_cached'] = true;
			if ($m = cache::fetch(cache::menu_cpath(),$lang_id)) {					// Menü aus Cache fischen
				$vorgaben['menu_cached'] = true;										// Merken, dass Menü schon abgerufen wurde
				if(!empty($m['menu'])) 		$sub_tpl['menu']	= $m['menu'];			// Wenn was da ist die passenden Variblen füllen
				if(!empty($m['submenus']))	$sub_tpl['submenus']= $m['submenus'];
				$vorgaben['cache_read'] = true; 
			}
			if (empty($sub_tpl['menu']) || empty($sub_tpl['submenus'])) build_menu();	// Sonst muss das Menü neu erstellt werden
			unset($m,$p);																// Und löschen, was nicht gebraucht wird.
		} else {			// Seite neu erstelen.
			build_page();	// Erst die Inhalte,
			build_menu();	// dann das Menu
		}
		return main_tpl();
	}
	public static function write() {
		global $dbobj,$sub_tpl,$path_in,$page_id,$lang_id,$notfound,$vorgaben,$error;
		if (!empty($page_id) && $vorgaben['cache'] && empty($notfound)) {
			unset($sub_tpl['sid'],$sub_tpl['phpsessid']);
			if (!$vorgaben['menu_cached']) {
				$m['menu'] = $sub_tpl['menu']; $m['submenus'] = $sub_tpl['submenus'];
				cache::put(array('LANG_ID'=> $lang_id,'path'=>cache::menu_cpath(),'content'=>$m));				// Seiteninhalte in Cache speichern
			}
			if (!$vorgaben['page_cached']) {
				unset($sub_tpl['menu'],$sub_tpl['submenus']);
				cache::put(array('PAGE_ID'=>$page_id,'LANG_ID'=>$lang_id,'path'=>$path_in,'content'=>$sub_tpl)); // Menuinhalte in Cache speichern
	}	}	}
	public static function fetch($path='',$lang_id=0) {
		global $dbobj,$sub_tpl,$vorgaben;
		$sql = "SELECT content FROM #PREFIX#_cache WHERE path = '".$path."' AND content != ''";
		if (!empty($lang_id)) $sql .= " AND LANG_ID = '".$lang_id."'";
		$sql .= ' LIMIT 1';
		$dbobj->compress['content'] = true;																// Die Daten sind gepackt.
		if ($data = $dbobj->exists(__file__,__line__,$sql)) return unseri_unurl($data[0]['content']);	// Wenn vorhanden: Daten aus DB holen und dekodieren.
		else												return false;								// Sonst: Das war wohl nix.
	}
	public static function put($data) {
		global $dbobj,$lang_id;
		$data['content'] = url_seri($data['content']);
		if (empty($data['LANG_ID']))$data['LANG_ID']=$lang_id;
		$dbobj->compress['content'] = true;						// Die Daten sollen gepackt werden, dann ab in die DB.
		$dbobj->array2db(__file__,__line__,$data,'#PREFIX#_cache',"INSERT INTO","WHERE path = '".$data['path']."' AND LANG_ID = '".$data['LANG_ID']."'");
	}
	public static function clean($data='') {
		global $dbobj,$vorgaben;
		if (empty($data)) {unset($data); $data['truncate'] = 1;}
		else {
			foreach($data as $action => $id) {
				switch ($action) {
					case 'truncate':$sql_a['truncate_cache'] = "TRUNCATE #PREFIX#_cache;";											break;
					case 'tree':	$sql_a['tree_cache']	 = "DELETE FROM #PREFIX#_cache WHERE path LIKE 'REBUILDTREE_%';";		break;
					case 'path': 	$sql_a['cache_path']	 = "DELETE FROM #PREFIX#_cache WHERE path = '".$id."' OR path = '';";	break;
					default:
						if (is_numeric(str_remove(r_implode($id)))) // Das wird jetzt etwas aufwendiger, weil auch alle Unterseiten aus dem Cache gelöscht werden sollen.
							$ids[] = $dbobj->tostring(__file__,__line__,"SELECT GROUP_CONCAT(DISTINCT parent.PAGE_ID) AS IDs FROM #PREFIX#seiten_attr AS child, #PREFIX#seiten_attr AS parent WHERE parent.lft <= child.lft AND parent.rgt >= child.rgt AND child.".strtoupper($action)." IN (".r_implode($id).");");	break;
		}	}	}
		if (empty($data['truncate'])){
			if (!empty($vorgaben['always_clear']))	$ids[] = $vorgaben['always_clear'];
			$sql_a['cache_menu'] = "DELETE FROM #PREFIX#_cache WHERE path LIKE '##MENU%' OR path = '';";
			if (!empty($ids[0]))					$sql_a[] = "DELETE FROM #PREFIX#_cache WHERE PAGE_ID IN (".r_implode($ids).");";
		}
		if (!empty($sql_a)) $dbobj->multiquery(__file__,__line__,$sql_a);
	}
	public static function menu_cpath() {
		if (!empty($_SESSION['status']))	return '##MENU_'.$_SESSION['status'].'##';
		else								return '##MENU##';
}	}
?>