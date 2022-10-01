<?php
function prepare_elements(&$elements,$page='') {	// prepare the contents
	global $tplobj,$first_lang_id,$languages_byid,$vorgaben,$sub_tpl;
	if (empty($page) || !empty($_REQUEST['pages']))	$page = &$_REQUEST['pages'];	//we'll use an alias here it's for the users input (i.e. preview).
	if (!empty($_REQUEST['pages_attr'])) {
		$attr = &$_REQUEST['pages_attr'];
		if (!empty($attr['KAT_ID'][$elements['PAGE_ID']])   &&	empty($elements['KAT_ID']))		$elements['KAT_ID'] 	= $attr['KAT_ID'][$elements['PAGE_ID']];
		if (!empty($attr['TPL_ID'][$elements['PAGE_ID']])   &&	empty($elements['TPL_ID']))		$elements['TPL_ID'] 	= $attr['TPL_ID'][$elements['PAGE_ID']];
		if (!empty($attr['parent_ID'][$elements['PAGE_ID']])&&	empty($elements['parent_ID']))	$elements['parent_ID']	= $attr['parent_ID'][$elements['PAGE_ID']];
	}
	if (!empty($elements['visibility']))		$elements['visible'] = 'checked="checked"';
	if (!empty($elements['FL_Menu'])) 			$elements['FL_Menu'] = my_htmlspecialchars($elements['FL_Menu']);
	if (empty($elements['LANG_ID'])) {
		if		(!empty($page['LANG_ID']))		$elements['LANG_ID'] = $page['LANG_ID'];
		elseif	(!empty($elements['FL_ID']))	$elements['LANG_ID'] = $elements['FL_ID'];
		else									$elements['LANG_ID'] = $first_lang_id;
	}
	if	(isset($languages_byid[$elements['LANG_ID']]))	$elements['short']= $languages_byid[$elements['LANG_ID']]['short'];
	if (!empty($languages_byid[$elements['LANG_ID']]['direction']) && $languages_byid[$elements['LANG_ID']]['direction']!='ltr') {
		$vorgaben['direction'] = &$languages_byid[$elements['LANG_ID']]['direction'];
	}
	if	  (isset($page['Titel']))			$elements['Titel'] = my_htmlspecialchars($page['Titel']);
	elseif(isset($elements['Titel'])) 		$elements['Titel'] = my_htmlspecialchars($elements['Titel']);
	elseif(!empty($elements['FL_Titel'])) 	$elements['Titel'] = my_htmlspecialchars($elements['FL_Titel']);
	if	  (!empty($page['Menu'])) 			$elements['Menu']  = my_htmlspecialchars($page['Menu']);
	elseif(!empty($elements['Menu']))		$elements['Menu']  = my_htmlspecialchars($elements['Menu']);
	elseif(!empty($elements['FL_Menu']))	$elements['Menu']  = $elements['FL_Menu'];
	elseif(!empty($elements['Titel']))		$elements['Menu']  = $elements['Titel'];
	if(!empty($elements['FL_Menu']))		$elements['FL_Menu'] = str_replace('#SHY#','&shy;',$elements['FL_Menu']);
	if	  (isset($page['Ueberschrift'])) 	$elements['Ueberschrift'] = my_htmlspecialchars($page['Ueberschrift']);
	elseif(isset($elements['Ueberschrift']))	$elements['Ueberschrift'] = my_htmlspecialchars($elements['Ueberschrift']);
	elseif(!empty($elements['FL_Ueberschrift']))$elements['Ueberschrift'] = my_htmlspecialchars($elements['FL_Ueberschrift']);
	if	  (!empty($page['beschreibung']))		$elements['Beschreibung'] = my_htmlspecialchars($page['beschreibung']);
	elseif(!empty($elements['Beschreibung']))	$elements['Beschreibung'] = my_htmlspecialchars($elements['Beschreibung']);
	elseif(!empty($elements['FL_Beschreibung']))$elements['Beschreibung'] = my_htmlspecialchars($elements['FL_Beschreibung']);
	if	  (!empty($elements['fix_kn']) && !empty($page['Kurzname'])) 		$elements['Kurzname'] = $page['Kurzname'];
	elseif(empty($elements['Kurzname'])&& !empty($elements['FL_Kurzname']))	$elements['Kurzname'] = $elements['FL_Kurzname'];
	if	  (empty($elements['AK']) && !empty($elements['Kurzname']))			$elements['AK2']	= strtolower($elements['Kurzname'][0]);
	if	  (!empty($elements['fix_kn']))										$elements['fix_kn']   = 'checked="checked"';
	else																	$elements['fix_kn']   = '';
	if	  (!empty($page['text'])) 				$elements['Text']	= $page['text'];
	elseif(!empty($elements['Text'])) 			$elements['Text']	= $elements['Text'];
	elseif(!empty($elements['FL_Text']))	 	$elements['Text']	= $elements['FL_Text'];
	elseif(!empty($sub_tpl['template']))		$elements['Text']	= $sub_tpl['template'];
	elseif(!empty($vorgaben['template']))		$elements['Text']	= $vorgaben['template'];
	if	  (strpos($elements['Text'],'<')===0)	$elements['Text']	= str_replace(array('&','#SHY#'),array('&amp;','&shy;'),$elements['Text']);
	if	  (!empty($elements['status']))			$elements['isstatus']= 'checked="checked"';
	else										$elements['isstatus']= '';
	if	  (!empty($elements['insdate']) && $elements['insdate']!= '0000-00-00 00:00:00')	$elements['insdate'] = format_date($elements['insdate'],"mysql-date");
	elseif(!empty($elements['lastmod']) && $elements['lastmod']!= '0000-00-00 00:00:00')	$elements['insdate'] = format_date($elements['lastmod'],"mysql-date");
	else																					$elements['insdate'] = date("Y-m-d");
	if (!empty($elements['Menu']))	$sub_tpl['pagetitle']  = '%%PAGE%%: '.$elements['Menu'].' ('.$elements['short'].')';
	if (!empty($vorgaben['texth']))	$elements['ta_height'] = $vorgaben['texth'];
	else							$elements['ta_height'] = '800';
	if (!empty($elements['TPL_ID']) /*&& !$vorgaben['is_preview']*/) {
		$elements['vlframe'] = edit_vorlage($elements['TPL_ID']);					// get the template data (see edit_sections.php)
		$elements['vlframe'] = $tplobj->array2tpl($elements['vlframe'],$elements);	// and add it to the existing elemenst (ist not really a frame)
		if (!empty($elements['vlframe'])) {														// if we get some
			if (!empty($vorgaben['redtexth']))	$elements['ta_height'] = $vorgaben['redtexth'];	// reduce te height of the text window
			else								$elements['ta_height'] = '400';
	}	}
	page_plugins($elements);	// check for plugins
}
function page_plugins(&$elements) {	// check for plugins
	global $plugin_functions,$vorgaben;
	if (!empty($plugin_functions)) {										# Plugins can insert functions here.
		if (!empty($elements['TPL_ID']) && !empty($plugin_functions[$elements['TPL_ID']]))	$func_name[] = $plugin_functions[$elements['TPL_ID']];	# if the plugin-function exists only for given template
		if (!empty($plugin_functions['everywhere']))										$func_name[] = $plugin_functions['everywhere'];			# if the plugin-function exists for every page
		if (!empty($func_name)) {
			foreach ($func_name as $functions) {
				foreach ($functions as $fn) {
					if (!empty($_SESSION['permissions'][str_remove($fn,'_plugin')]) && $_SESSION['permissions'][str_remove($fn,'_plugin')][0]==1) {
						if(function_exists($fn)) 	$elements['plugin'][$fn] = $fn($elements);					# its resuts are inserted here.
			}	}	}
			if (empty($elements['plugin']))		$elements['plugin'] = '';
			else {
				if (!empty($vorgaben['redtexth']))	$elements['ta_height'] = $vorgaben['redtexth'];
				else								$elements['ta_height'] = '400';
			}	
}	}	}
class save_page {
	public static function save_pages_attr($attr='') {
		global $error,$userid,$dbobj,$vorgaben;
		if (!empty($_REQUEST['pages_attr'])) {
			$attr = &$_REQUEST['pages_attr'];
			$cache['page_id'] = $attr['all_pages'];
			foreach ($attr['all_pages'] as $PAGE_ID) {
				if (is_numeric($PAGE_ID) || $PAGE_ID == 'new') {
					if (isset($attr['parent_ID'][$PAGE_ID]))	$seiten['parent_ID'] = $attr['parent_ID'][$PAGE_ID];
					elseif (isset($_REQUEST['parent_id2']))		$seiten['parent_ID'] = $_REQUEST['parent_id2'];
					$seiten['PAGE_ID'] = $PAGE_ID;
					$count = 0;
					$l = 0;
					if (isset($seiten['parent_ID'])) {
						$parentID = $seiten['parent_ID']; $l = 0;
						if ($parentID == $PAGE_ID) {
							$error['fehler'][$PAGE_ID] = get_page(array('PAGE_ID'=>$PAGE_ID,'feld'=>'Menu','visibility'=>'0,1','errors'=>false)).' -> '.get_page(array('PAGE_ID'=>$seiten['parent_ID'],'feld'=>'Menu','visibility'=>'0,1','errors'=>false)).': %%SEITE_ALS_EIGENE_UNTERSEITE%%';
						} else {
							$parentID = $dbobj->tostring(__file__,__line__,"SELECT parent_ID FROM #PREFIX#seiten_attr WHERE PAGE_ID = '".$parentID."';");
							while ($parentID != 0 && empty($error['fehler'])) { // check if the page is it's own sub page
								if ($PAGE_ID == $parentID)
									$error['fehler'][$PAGE_ID] = get_page(array('PAGE_ID'=>$PAGE_ID,'feld'=>'Menu','visibility'=>'0,1','errors'=>false)).' -> '.get_page(array('PAGE_ID'=>$seiten['parent_ID'],'feld'=>'Menu','visibility'=>'0,1','errors'=>false)).': %%SEITE_ALS_EIGENE_UNTERSEITE%%';
								$parentID = $dbobj->tostring(__file__,__line__,"SELECT parent_ID FROM #PREFIX#seiten_attr WHERE PAGE_ID = '".$parentID."';");
					}	}	}
					if (empty($error['fehler'][$PAGE_ID])) {
						if 		(isset($attr['order_by'][$PAGE_ID]))		$seiten['order_by']	  = $attr['order_by'][$PAGE_ID];
						if		(isset($attr['status'][$PAGE_ID]))			$seiten['status']	  = $attr['status'][$PAGE_ID];
						if		(!empty($attr['owner_ID'][$PAGE_ID]) && ($_SESSION['status'] == 'Admin' || $_SESSION['status'] == 'EDITOR')) {
							$seiten['person_ID'] = $attr['owner_ID'][$PAGE_ID];
						} else {
							$seiten['person_ID'] = uid();
						}
						if		(!empty($attr['TPL_ID'][$PAGE_ID])) 		$seiten['TPL_ID']	  = $attr['TPL_ID'][$PAGE_ID];
						elseif	(!empty($_REQUEST['tpl_id2']))				$seiten['TPL_ID']	  = $_REQUEST['tpl_id2'];
						if		(!empty($attr['KAT_ID'][$PAGE_ID]))			$seiten['KAT_ID']	  = $attr['KAT_ID'][$PAGE_ID];
						elseif	(!empty($_REQUEST['kat_id2']))				$seiten['KAT_ID']	  = $_REQUEST['kat_id2'];
						if		(!empty($attr['position'][$PAGE_ID]))		$seiten['position']	  = $attr['position'][$PAGE_ID];
						if		(!empty($attr['visibility'][$PAGE_ID]))		$seiten['visibility'] = $attr['visibility'][$PAGE_ID];
						elseif	(!empty($_SESSION['permissions']['vis']))	$seiten['visibility'] = 0;
						if		(!empty($attr['parent_ID'][$PAGE_ID]))		$seiten['parent_ID']  = $attr['parent_ID'][$PAGE_ID];
						if (!is_numeric($PAGE_ID)){
							$seiten['PAGE_ID'] = $dbobj->next_free_id('seiten_attr','PAGE_ID');
							$PAGE_ID = $seiten['PAGE_ID'];
							$_SESSION['page_ids'][] = $PAGE_ID;
						}
						$dbobj->array2db(__file__,__line__,$seiten,'#PREFIX#seiten_attr','INSERT INTO','WHERE PAGE_ID = "'.$PAGE_ID.'"');
						$error['info'] = '%%AENDERUNGEN_SIND_EINGETRAGEN%%';
					}
				}
			}
			if (!empty($cache)) {										// some cleanup
				cache::clean($cache);										// empty cache
				if ($tf = glob($vorgaben['img_path'].'/thumbs/TMP_*')) {	// find temp images (prefix: TMP_)
					foreach ($tf as $filename) {
						unlink($filename);									// and remove them
						unlink(str_remove($filename,'/thumbs'));
				}	}
				if ($dbobj->table_exists(__file__,__line__,'#PREFIX#_preview')) {	// empty preview table
					$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#_preview WHERE PAGE_ID IN (".r_implode($cache['page_id']).");");
			}	}
			rebuild_tree();												// the binary tree of pages has to be rebuild
		}
		if (!empty($PAGE_ID))	return $PAGE_ID;
	}
	public static function save_pages($pages='') {
		global $error,$userid,$dbobj,$first_lang_id,$vorgaben;
		if (!empty($_REQUEST['pages']))	$pages = &$_REQUEST['pages'];
		if (!empty($_REQUEST['pages']['remove']))	save_page::remove_page($_REQUEST['pages']['remove']);
		elseif (!empty($_REQUEST['send']) && $_REQUEST['send']!='copy' && !empty($pages)) {
			if (!empty($pages['PAGE_ID'])) {
				$page_id = $pages['PAGE_ID'];
				if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#vorlagen','prefix')) {
					$sql = "SELECT		#PREFIX#seiten_attr.PAGE_ID, #PREFIX#vorlagen.prefix
							FROM		#PREFIX#vorlagen,#PREFIX#seiten_attr
							WHERE		#PREFIX#seiten_attr.PAGE_ID = ".$page_id."
							AND 		#PREFIX#vorlagen.TPL_ID = #PREFIX#seiten_attr.TPL_ID";
				} else {
					$sql = "SELECT		#PREFIX#seiten_attr.PAGE_ID
							FROM		#PREFIX#seiten_attr
							WHERE		#PREFIX#seiten_attr.PAGE_ID = ".$page_id."";
				}
				$page_check = $dbobj->withkey(__file__,__line__,$sql,'PAGE_ID',true);
			}
			else							$page_id = 'new';
			if(empty($pages['Titel'])) 		$error['fehler'] = '%%SEITE_OHNE_TITEL%%'; 	// Can't save page without title.
			else {
				$pages['lastmod'] = date("Y-m-d H:i:s");
				if (empty($pages['insdate']))		$pages['insdate']   = $pages['lastmod'];
				else								$pages['insdate']   = format_date($pages['insdate'],"%Y-%m-%d 00:00:00");
				if (empty($pages['LANG_ID'])) 		$pages['LANG_ID']   = &$first_lang_id;
				if (!empty($pages['editor_ID'])) 	$pages['editor_ID'] = &$pages['editor_ID'];
				else								$pages['editor_ID'] = uid();
				foreach ($pages as $key =>$value) {
					if	(!empty($pages[$key])) {
						$pages[$key] = str_replace(array('\"',"\'"),array('"',"'"),$value);
					}
				}
				if	(!empty($pages['text'])) {
					if (!empty($vorgaben['template']) && str_remove($pages['text'],array('\\','"',"'"," ","&nbsp;","&#160;","\r","\n")) == str_remove($vorgaben['template'],array('\\','"',"'"," ","&nbsp;","&#160;","\r","\n")))
						$pages['text'] = '';
					elseif (!empty($vorgaben['sub_dir'])) {
						if (!empty($vorgaben['abspaths']))	$path = url_protocol(domain('*')).$vorgaben['sub_dir'];
						else								$path = $vorgaben['sub_dir'];
						$in  = array('="'.$path.'/','=&quot;'.$path.'/');
						$out = array('="/',			'=&quot;/');
						$pages['text'] = str_replace($in,$out,$pages['text']);
					}
					$pages['text'] = str_remove($pages['text'],array(' class="MsoNormal"','<p></p>','<o:p>','</o:p>','&#194;'));
					$pages['text'] = str_replace(array('style="color:#FF0000;"'),array('class="red"'),$pages['text']);
					$pages['text'] = preg_replace('/(<font[^>]*>)|(<\/font>)/is', '',$pages['text']);
					$pages['text'] = str_replace('&nbsp;', ' ', $pages['text']);
					$pages['text'] = preg_replace('/\s+/',' ', $pages['text']);
					if (!empty($vorgaben['disallowedattr'])) {
						$disallowedattr = explode(',',$vorgaben['disallowedattr']);
						foreach($disallowedattr as $das) {
							$pages['text'] = preg_replace('/(<[^>]+) '.$das.'=".*?"/i', '$1', $pages['text']);
						}
					}
					if (!empty($vorgaben['disallowedtags'])) {
						$disallowedtags = explode(',',$vorgaben['disallowedtags']);
						foreach($disallowedattr as $dat) {
							$pages['text'] = str_remove($pages['text'],array('<'.$dat.'>','</'.$dat.'>'));
						}
					}
					$pages['text'] = str_replace('<p> </p>', '', $pages['text']);
					$pages['text'] = str_replace("<p>\n<p",  '<p', $pages['text']);
					$pages['text'] = str_replace("</p>\n</p",'</p',$pages['text']);
				}
		#		$pages['Ueberschrift'] = be_shy($pages['Ueberschrift']);
				if(!empty($pages['Titel']))	$pages['Titel'] = trim($pages['Titel']);
				if(!empty($pages['Menu']))	$pages['Menu']  = trim($pages['Menu']);
				else						$pages['Menu']  = $pages['Titel'];
				if(empty($pages['fix_kn']))	$pages['fix_kn'] = 0;
				if		(!empty($pages['Kurzname']) && (strpos($pages['Kurzname'],'http://')===0  || strpos($pages['Kurzname'],'#')===0))	$pages['Kurzname'] = $pages['Kurzname'];
				elseif	(!empty($pages['Kurzname']) && !empty($pages['fix_kn']))	$pages['Kurzname'] = make_kn($pages['Kurzname'],$pages);
				elseif	(!empty($pages['Menu']))									$pages['Kurzname'] = make_kn($pages['Menu'],$pages);
				elseif	(!empty($pages['Titel']))									$pages['Kurzname'] = make_kn($pages['Titel'],$pages);
				if (!empty($page_check) && !empty($page_check[$page_id]['prefix'])) $pages['Kurzname'] = $page_check[$page_id]['prefix'].'_'.$pages['Kurzname'];
				$dbobj->as_real = true;
				$dbobj->array2db(__file__,__line__,$pages,'#PREFIX#seiten','INSERT INTO');
				if (!empty($_REQUEST['pages_attr']) || !empty($_FILES['abschnitt']))	save_page::sections();
				if (!empty($_FILES['extra_img'])) 										save_extra_img(array('PAGE_ID'=>$page_id,'LANG_ID'=>$pages['LANG_ID']));
				if ((!empty($_REQUEST['pages_attr']['TPL_ID'][$page_id]) && $_REQUEST['pages_attr']['TPL_ID'][$page_id] == $vorgaben['seiten_tpl'])
						|| (!empty($_REQUEST['tpl_id2']) && $_REQUEST['tpl_id2'] == $vorgaben['seiten_tpl'])) {
					$cache['truncate']	= true;
				} else {
					$cache['tree']	= true;
		}	}	}
		if (!empty($cache)) cache::clean($cache);
	}
	public static function remove_page($remove='',$LANG_ID='') {
		global $error,$dbobj,$cache;
		if		(!empty($_REQUEST['pages']['PAGE_ID']) && empty($remove))	$remove[0] = $_REQUEST['pages']['PAGE_ID'];
		if		(!empty($_REQUEST['pages']['LANG_ID']) && empty($LANG_ID))	$LANG_ID   = $_REQUEST['pages']['LANG_ID'];
		if (!empty($remove)) {
			if (is_string($remove))	$remove = explode(',',$remove);
			foreach ($remove as $page_id) {
				$cache['page_id'][] = $page_id;
				$parent_ID = $dbobj->tostring(__file__,__line__,"SELECT parent_ID FROM #PREFIX#seiten_attr WHERE #PREFIX#seiten_attr.PAGE_ID = ".$page_id." LIMIT 1;");
				if (empty($parent_ID)) $parent_ID = 0;
				if (!empty($LANG_ID) && is_numeric($LANG_ID)) {
					$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#seiten 	  WHERE PAGE_ID = ".$page_id." AND LANG_ID = ".$LANG_ID.";");
					$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#abschnitte WHERE PAGE_ID = ".$page_id." AND LANG_ID = ".$LANG_ID.";");
					if (!$dbobj->exists(__file__,__line__,"SELECT PAGE_ID FROM #PREFIX#seiten WHERE PAGE_ID = ".$page_id.";")) { // no more pages -> remove everything
						$re_all = 1;
					} else {
						$sql_a[] = "DELETE FROM #PREFIX#abschnitte WHERE PAGE_ID = ".$page_id." AND LANG_ID = ".$LANG_ID.";";
				#		deletefiles(array('PAGE_ID'=>$page_id,'LANG_ID'=>$LANG_ID));
						$_REQUEST['pages']['PAGE_ID'] = $page_id;
					}
					unset($_REQUEST['pages']['LANG_ID']);
				}
				else $re_all = 1;
				if (!empty($re_all)){
					$sql_a[] = "DELETE FROM #PREFIX#seiten 		WHERE PAGE_ID = ".$page_id.";";
					$sql_a[] = "DELETE FROM #PREFIX#seiten_attr	WHERE PAGE_ID = ".$page_id.";";
					$sql_a[] = "DELETE FROM #PREFIX#abschnitte	WHERE PAGE_ID = ".$page_id.";";
					$sql_a[] = "UPDATE #PREFIX#seiten_attr SET parent_ID = ".$parent_ID." WHERE parent_ID = ".$page_id.";";
					deletefiles(array('PAGE_ID'=>$page_id));
					unset($_REQUEST['pages'],$_REQUEST['pages_attr']);
		}	}	}
		if (!empty($sql_a)) {
			$dbobj->multiquery(__file__,__line__,$sql_a);
		}
		rebuild_tree();
		$error['removed'] = '%%SEITE_GELOESCHT%%';
	}
	public static function sections() {
		global $error,$dbobj,$vorgaben,$first_lang_id;
		if (!empty($_REQUEST['import'])) {
			$n = 1;
			$import = cleanArray(explode("\r",strip_tags(str_remove($_REQUEST['import'],array("\n")))));
			foreach($import as $k => $i) {
				$i = trim($i);
				if (!empty($i)) {
					$_REQUEST['part_attr'][$n]['visibility'] = 1;
					$_REQUEST['part_attr'][$n]['position'] = $n;
					if (strpos($i,"\t")!==false) {
						$j = explode("\t",$i);
						foreach ($j as $k => $m) 
							$l_abschnitte[($k+1)][$n]['Feld'] = $m;
#						list($country,$iso2,$iso3,$num) = explode("\t",$i);
#							$l_abschnitte[$_REQUEST['pages']['LANG_ID']][($k+1)]['Country'] = $country;
#							$l_abschnitte[$_REQUEST['pages']['LANG_ID']][($k+1)]['Iso2'] = $iso2;
#							$l_abschnitte[$_REQUEST['pages']['LANG_ID']][($k+1)]['Iso3'] = $iso3;
#							$l_abschnitte[$_REQUEST['pages']['LANG_ID']][($k+1)]['Num'] = $num;
					} else
						$l_abschnitte[$_REQUEST['pages']['LANG_ID']][$n]['Feld'] = $i;
					$n++;
			}	}
			foreach ($l_abschnitte as $l => $la) save_page::each_section($la,$l);
			return true;
		} elseif (!empty($_REQUEST['abschnitt']) || !empty($_FILES['abschnitt']['name']) || !empty($_FILES['abschnitt']['name'])) {
			if (empty($_REQUEST['abschnitt']) && !empty($_FILES['abschnitt']['name'])) {
				foreach ($_FILES['abschnitt']['name'] as $key => $name) {
					$n = key($name);
					if (!empty($n) && !empty($_FILES['abschnitt']['size'][$key][$n]))	$_REQUEST['abschnitt'][$key][$n] = $name[$n];
		}	}	}
		save_page::each_section();
	}
	static function each_section($sections='',$lang_id='') {
		global $error,$dbobj,$vorgaben,$first_lang_id,$sections_done;
		if (empty($sections_done)) $sections_done = false;
		if (!$sections_done) {
			if (!empty($_REQUEST['remove']))	save_page::remove_section();
			save_page::save_sections($sections,$lang_id);
			$sections_done = true;
		}
	}
	static function save_sections($sections='',$lang_id='',$uid='') {
		global $error,$dbobj,$vorgaben,$first_lang_id;
		if 	   (empty($sections) && !empty($_REQUEST['abschnitt'])) $sections = cleanArray($_REQUEST['abschnitt']);
		elseif (empty($sections) && !empty($_REQUEST['part_attr'])) $sections = fromArray($_REQUEST['part_attr'],'filled',1);
		if (!empty($sections)) {
			if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#abschnitte','person_ID')) $uid = uid();
			foreach ($sections as $key => $section) {
				save_page::save_section($section,$key,$uid,$lang_id);
	}	}	}
	static function save_section($section,$key,$uid='',$lang_id='') {
		global $error,$dbobj,$vorgaben,$first_lang_id;
		$data['PAGE_ID'] = $_REQUEST['pages']['PAGE_ID'];
		if (!empty($uid))								$data['person_ID'] = $uid;
		if (!empty($lang_id))							$data['LANG_ID'] = $lang_id;
		elseif (!empty($_REQUEST['pages']['LANG_ID']))	$data['LANG_ID'] = $_REQUEST['pages']['LANG_ID'];
		else											$data['LANG_ID'] = $first_lang_id;
		if (!empty($_FILES['abschnitt']['name'][$key]) && is_array($_FILES['abschnitt']['name'][$key]))	$bn = current($_FILES['abschnitt']['name'][$key]);
		if (empty($bn) && is_array($section))															$bn = ArrayDepth(array_filter($section,"filterArray"));
		if ((!empty($bn) || !empty($_REQUEST['part_attr'][$key]['filled']))) {
			if (!empty($_REQUEST['default'][$key])) {
				foreach ($_REQUEST['default'][$key] as $dkey => $dval) {
					if (empty($section[$dkey])) $section[$dkey] = $dval;
			}	}
			$data['Content'] = '';
			if (is_array($section)) {
				foreach ($section as $akey => $adata) {
					if ($akey != 'data_url') {
						if (is_array($adata))	$section[$akey] = implode(',',$adata);
						$in  = array("#SHY#",	"#NB#",		'<p></p>',	'="http://'.domain('*').'/');
						$out = array('&shy;',	'&nbsp;',	'',			'="/');
						$section[$akey] = str_replace($in,$out,$section[$akey]);
						$section[$akey] = preg_replace('/<font[^>]*>/','',$section[$akey]);
						$section[$akey] = str_remove($section[$akey],array(' class="MsoNormal"','<p></p>','<o:p>','</o:p>','&#194;'));
						if (str_remove($section[$akey],array('&npsp;','&#160;')) == $vorgaben['template']) $section[$akey] = '';
						if (!empty($vorgaben['sub_dir'])) {
							if (!empty($vorgaben['abspaths']))	$path = url_protocol(domain('*')).$vorgaben['sub_dir'];
							else								$path = $vorgaben['sub_dir'];
							$in  = array('="'.$path.'/','=&quot;'.$path.'/');
							$out = array('="/',			'=&quot;/');
							$section[$akey] = str_replace($in,$out,$section[$akey]);
						}
						$section[$akey] = trim($section[$akey]);
					}
					else unset($section[$akey]);
				}
				reset($section);
				$k = key($section);
				if ($k != 'filled')	$data['first'] = truncate(str_remove(strip_tags(current($section)),array('<','>')),61);
				if (empty($data['first'])) {
					if (!empty($bn) && !is_numeric($bn))					$data['first'] = truncate($bn,61);
					elseif (!empty($_REQUEST['part_attr'][$key]['rfirst']))	$data['first'] = $_REQUEST['part_attr'][$key]['rfirst'];
					else													$data['first'] = '-- '.$key.' --';
				}
				$data['Content'] = url_seri($section);
			}
			if(isset($_REQUEST['part_attr'][$key]['visibility'])) 	$data['visibility'] = $_REQUEST['part_attr'][$key]['visibility'];
			else													$data['visibility'] = 0;
			if(isset($_REQUEST['part_attr'][$key]['position']) && $_REQUEST['part_attr'][$key]['position'] != '') 	$data['position'] = $_REQUEST['part_attr'][$key]['position'];
			if(!empty($_REQUEST['part_attr'][$key]['finish']))		$data['finish']  = format_date($_REQUEST['part_attr'][$key]['finish'],"%Y-%m-%d");
			else 													$data['finish']  = '1970-01-01';
			if	(!empty($_REQUEST['part_attr'][$key]['publish'])) 	$data['publish'] = format_date($_REQUEST['part_attr'][$key]['publish'],"%Y-%m-%d");
			else 													$data['publish'] = date('Y-m-d');
			if(!empty($_REQUEST['pflicht'][0]))	$data['pflicht'] = implode(',',$_REQUEST['pflicht']);
			else								$data['pflicht'] = '';
			$data['PART_ID'] = $key;
			if (!is_numeric($key))	{
				$newkey = $dbobj->tostring(__file__,__line__,"SELECT (PART_ID + 1) AS new_id FROM #PREFIX#abschnitte WHERE PAGE_ID = ".$data['PAGE_ID']." ORDER BY PART_ID desc LIMIT 1;");
				if (empty($newkey))	$newkey = 1;
				$data['PART_ID']  = $newkey;
			} else $newkey = '';
			$dbobj->as_real = true;
			if (!empty($data['LANG_ID']))	$dbobj->array2db(__file__,__line__,$data,'#PREFIX#abschnitte','INSERT INTO','WHERE PART_ID ="'.$data['PART_ID'].'" AND PAGE_ID = '.$data['PAGE_ID'].' AND LANG_ID = '.$data['LANG_ID'].';');
			else							$dbobj->array2db(__file__,__line__,$data,'#PREFIX#abschnitte','INSERT INTO','WHERE PART_ID ="'.$data['PART_ID'].'" AND PAGE_ID = '.$data['PAGE_ID'].';');
			save_page::all_files($data,$key,$newkey);
			if (!empty($newkey)) $key = $newkey;
			if (!empty($_REQUEST['part_attr'][$key]['move'])) save_page::move_section($key);
			unset($data,$data2,$bn);
			return $key;
	}	}
	static function move_section($key) {	// Move section to other page
		global $error,$dbobj,$vorgaben;
		if ($_REQUEST['part_attr'][$key]['move'] == $_REQUEST['pages']['PAGE_ID'] && $copy = $dbobj->singlequery(__file__,__line__,"SELECT #PREFIX#abschnitte.PAGE_ID,(#PREFIX#abschnitte.PART_ID + 1) AS PART_ID,Dateiname FROM #PREFIX#abschnitte LEFT JOIN #PREFIX#bilder ON (#PREFIX#bilder.PAGE_ID = ".$_REQUEST['pages']['PAGE_ID']." AND #PREFIX#bilder.PART_ID = ".$key.") WHERE #PREFIX#abschnitte.PAGE_ID = ".$_REQUEST['part_attr'][$key]['move']." ORDER BY #PREFIX#abschnitte.PART_ID desc LIMIT 1;")) {
  			if (empty($copy[0]['PART_ID'])) $copy[0]['PART_ID'] = 1;
			$data_section   = $dbobj->singlequery(__file__,__line__,"SELECT * FROM #PREFIX#abschnitte WHERE PAGE_ID = ".$_REQUEST['pages']['PAGE_ID']." AND PART_ID = ".$key.";");
			$data_image	 = $dbobj->singlequery(__file__,__line__,"SELECT * FROM #PREFIX#bilder WHERE PAGE_ID = ".$_REQUEST['pages']['PAGE_ID']." AND PART_ID = ".$key.";");
			$data_section[0]['PAGE_ID']  = $copy[0]['PAGE_ID'];
			$data_section[0]['PART_ID']  = $copy[0]['PART_ID'];
			$data_image[0]['PAGE_ID']	= $copy[0]['PAGE_ID'];
			$data_image[0]['PART_ID']	= $copy[0]['PART_ID'];
			$data_image[0]['BILD_ID'] = $dbobj->next_free_id('bilder','BILD_ID');
			$dbobj->array2db(__file__,__line__,$data_section[0],'#PREFIX#abschnitte');
			$dbobj->array2db(__file__,__line__,$data_image[0],  '#PREFIX#bilder');
			if (!empty($copy[0]['Dateiname'])) {
				$file_old = $vorgaben['base_dir'].$vorgaben['img_path'].'/'.$_REQUEST['pages']['PAGE_ID'].'_'.$key.'_'.$copy[0]['Dateiname'];
				$file_new = $vorgaben['base_dir'].$vorgaben['img_path'].'/'.$copy[0]['PAGE_ID'].'_'.$copy[0]['PART_ID'].'_'.$copy[0]['Dateiname'];
				if (is_file($file_old))
					copy($file_old,$file_new);
				$file_old = $vorgaben['base_dir'].$vorgaben['img_path'].'/thumbs/'.$_REQUEST['pages']['PAGE_ID'].'_'.$key.'_'.$copy[0]['Dateiname'];
				$file_new = $vorgaben['base_dir'].$vorgaben['img_path'].'/thumbs/'.$copy[0]['PAGE_ID'].'_'.$copy[0]['PART_ID'].'_'.$copy[0]['Dateiname'];
				if (is_file($file_old))
					copy($file_old,$file_new);
			}
			$error[$key] = '%%ABSCHNITT_KOPIERT%% ('.$key.')';
		}
		elseif ($move = $dbobj->singlequery(__file__,__line__,"SELECT #PREFIX#abschnitte.PAGE_ID,(#PREFIX#abschnitte.PART_ID + 1) AS PART_ID,Dateiname FROM #PREFIX#abschnitte LEFT JOIN #PREFIX#bilder ON (#PREFIX#bilder.PAGE_ID = ".$_REQUEST['pages']['PAGE_ID']." AND #PREFIX#bilder.PART_ID = ".$key.") WHERE #PREFIX#abschnitte.PAGE_ID = ".$_REQUEST['part_attr'][$key]['move']." ORDER BY #PREFIX#abschnitte.PART_ID desc LIMIT 1;")) {
			if (empty($move[0]['PART_ID'])) $move[0]['PART_ID'] = 1;
			$dbobj->singlequery(__file__,__line__,"UPDATE #PREFIX#abschnitte SET PAGE_ID = ".$_REQUEST['part_attr'][$key]['move'].", PART_ID = ".$move[0]['PART_ID']." WHERE PAGE_ID = ".$_REQUEST['pages']['PAGE_ID']." AND PART_ID = ".$key.";");
			$dbobj->singlequery(__file__,__line__,"UPDATE #PREFIX#bilder 	 SET PAGE_ID = ".$_REQUEST['part_attr'][$key]['move'].", PART_ID = ".$move[0]['PART_ID']." WHERE PAGE_ID = ".$_REQUEST['pages']['PAGE_ID']." AND PART_ID = ".$key.";");
			if (!empty($move[0]['Dateiname'])) {
				$file_old = $vorgaben['base_dir'].$vorgaben['img_path'].'/'.$_REQUEST['pages']['PAGE_ID'].'_'.$key.'_'.$move[0]['Dateiname'];
				$file_new = $vorgaben['base_dir'].$vorgaben['img_path'].'/'.$move[0]['PAGE_ID'].'_'.$move[0]['PART_ID'].'_'.$move[0]['Dateiname'];
				if (is_file($file_old))
					rename($file_old,$file_new);
				$file_old = $vorgaben['base_dir'].$vorgaben['img_path'].'/thumbs/'.$_REQUEST['pages']['PAGE_ID'].'_'.$key.'_'.$move[0]['Dateiname'];
				$file_new = $vorgaben['base_dir'].$vorgaben['img_path'].'/thumbs/'.$move[0]['PAGE_ID'].'_'.$move[0]['PART_ID'].'_'.$move[0]['Dateiname'];
				if (is_file($file_old))
					rename($file_old,$file_new);
			}
			$error[$key] = '%%ABSCHNITT_VERSCHOBEN%% ('.$key.')';
	}	}
	static function remove_section() {	// delete section
		global $error,$dbobj;
		if (!empty($_REQUEST['remove'])) {
			foreach ($_REQUEST['remove'] as $key) {
				if ($first = $dbobj->withkey(__file__,__line__,"SELECT PAGE_ID,first FROM #PREFIX#abschnitte WHERE PAGE_ID = ".$_REQUEST['pages']['PAGE_ID']." AND PART_ID = ".$key.";",'PAGE_ID',true)) {
					$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#abschnitte WHERE PAGE_ID = ".$_REQUEST['pages']['PAGE_ID']." AND PART_ID = ".$key.";");
					$error[$key] = '%%ABSCHNITT_GELOESCHT%% ('.$key.')';
					deletefiles(array('PAGE_ID'=>$_REQUEST['pages']['PAGE_ID'],'PART_ID'=>$key));
				}
				unset($_REQUEST['abschnitt'][$key],$_REQUEST['part_attr'][$key]);
	}	}	}
	public static function all_files($data,$key,$newkey='') {
		global $error,$dbobj,$vorgaben,$first_lang_id;
		if (!empty($_FILES['abschnitt']['name'][$key]) && is_array($_FILES['abschnitt']['name'][$key])) {
			foreach ($_FILES['abschnitt']['name'][$key] as $filekey => $filename) {
				if (empty($_FILES['abschnitt']['error'][$key][$filekey])) {
					$datei['Dateiname'] = make_kn($filename,'',30);
					$datei['PART_ID'] = $key;
					$datei['PAGE_ID'] = $data['PAGE_ID'];
					if (stripos($filekey,'datei')!==false || stripos($filekey,'file')!==false)
						save_page::files ($key,$filekey,$filename,$datei,$newkey);
					else
						save_page::images($key,$filekey,$filename,$datei,$newkey);
				}
				elseif (!empty($filename)) {
					$error[$filename] = image_error($_FILES['abschnitt']['error'][$key][$filekey],$filename);
	}	}	}	}
	static function files($key,$filekey,$filename,$datei,$newkey='') {
		global $error,$dbobj,$vorgaben;
		if (move_uploaded_file($_FILES['abschnitt']['tmp_name'][$key][$filekey],'downloads/'.$datei['Dateiname'])) {
			chmod($vorgaben['base_dir'].'/downloads/'.$datei['Dateiname'], 0644);
			if (!empty($newkey))	$key = $newkey;
			$datei['filekey'] = $filekey;
			$dbobj->array2db(__file__,__line__,$datei,'#PREFIX#dateien','INSERT INTO');
		} else $error[$filename] = image_error(99,$filename);
	}
	static function images($key,$filekey,$filename,$datei,$newkey='') {
		global $error,$dbobj,$vorgaben,$lang_id;
		unset($vorgaben['altext']);
		$r_ids = deletefiles(array('PAGE_ID'=>$datei['PAGE_ID'],'PART_ID'=>$key,'Dateiname'=>strtolower($filekey)),'images');
		$path0 = $vorgaben['img_path'].'/originale/'.$datei['Dateiname'];
		if (!empty($newkey))		$file_prefix = $datei['PAGE_ID'].'_'.$newkey.'_';
		else						$file_prefix = $datei['PAGE_ID'].'_'.$key.'_';
		if (!empty($_REQUEST['override'][$key][$filekey])) {
			$vorgaben['override'] = $_REQUEST['override'][$key][$filekey];				// sometimes the size presets have to be overruled
			if (!empty($vorgaben['override']['uselang'])) $datei['LANG_ID'] = $lang_id; // if needed the language too
		}
		if ($filekey != 'BILD')	$datei['Dateiname'] = strtolower($filekey).'_'.$datei['Dateiname'];
		$path2 = $vorgaben['img_path'].'/thumbs/'.$file_prefix.$datei['Dateiname'];
		$path1 = $vorgaben['img_path'].'/'.$file_prefix.$datei['Dateiname'];
		$error[$filename] = image_error($_FILES['abschnitt']['error'][$key][$filekey],$filename);
		if (empty($error[$filename]) && move_uploaded_file($_FILES['abschnitt']['tmp_name'][$key][$filekey],$path0)) {
			make_images($path0,$path1,$path2,$datei['PAGE_ID'],'galerie','',false);
			$error[$filename] = "%%HOCHGELADEN%%: ".$filename;
			unlink($path0);
		}
		unset($vorgaben['override']);
		if ($r_ids && is_numeric($r_ids['BILD_IDs'][0])) $datei['BILD_ID'] = &$r_ids['BILD_IDs'][0];
		if (!empty($newkey)) {
			$datei['PART_ID'] = $newkey;
		}
		$datei['LANG_ID'] = $lang_id;
		$datei['BILD_ID'] = $dbobj->next_free_id('bilder','BILD_ID');
		if (!empty($vorgaben['altext']))	$datei['altext'] = r_implode($vorgaben['altext']);
		if ($filekey != 'BILD') $dbobj->array2db(__file__,__line__,$datei,'#PREFIX#bilder','INSERT INTO',"WHERE Dateiname LIKE '".strtolower($filename)."%' AND PAGE_ID = ".$datei['PAGE_ID']." AND PART_ID =".$datei['PART_ID'].' AND (LANG_ID = 0 OR LANG_ID = '.$lang_id.');');
		else 					$dbobj->array2db(__file__,__line__,$datei,'#PREFIX#bilder','INSERT INTO',"WHERE PAGE_ID = ".$datei['PAGE_ID']." AND PART_ID =".$datei['PART_ID'].' AND (LANG_ID = 0 OR LANG_ID = '.$lang_id.');');
}	}
?>