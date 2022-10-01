<?php
function prepare_edit_pages() {																		// Wird ausgeführt nachdem alle Dateien eingebunden (include) sind, bevor alles weitere passiert.
	global $add_admin;
	$add_admin['editor']['1_pages'] = array('function' => 'admin_pages','titel' => '%%SEITEN%%');	// Array, um Funktionsaufruf in Admin-Menü einzubinden (Funktion und Titel).
}
function startup_admin_pages($tpl) {																// Wird zur Vorbereitung des Administrationsbereichs ausgeführt.
	return '<ul class="alleseiten">'.alleseiten($tpl).'</ul>';										// Seitenauswahl in Admin-Menü einbinden
}
function admin_pages($page='',$add='',$scope=false,$page_tpl='') {
	global $tplobj,$sub_tpl,$vorgaben;
	if (empty($vorgaben['seperator']))	$vorgaben['seperator']='|';
	if (!empty($page)) {
		if (is_numeric($page))										$_REQUEST['pages']['PAGE_ID'] = $page;
		if (is_string($page))										$_REQUEST['PAGE_ID'] = $page;
		if (!empty($page['PAGE_ID']) && is_array($page['PAGE_ID']))	$_REQUEST['PAGE_ID'] = implode(',',$page['PAGE_ID']);
		if (!empty($page['TPL_ID']) && is_array($page['TPL_ID']))	$_REQUEST['TPL_ID']  = implode(',',$page['TPL_ID']);
	}
	if (!$vorgaben['admin'] && !empty($sub_tpl['useredit_tpls']))	$tpls = &$sub_tpl['useredit_tpls'];
	else															$tpls = $tplobj->read_tpls('admin/seiten.inc.html');
	if (!empty($tpls['seitentitel']))								$sub_tpl['pagetitle'] = $tpls['seitentitel'];
	if (!empty($page_tpl) && !empty($tpls[$page_tpl]))				$tpls['seite'] = $tpls[$page_tpl];
	result_kv();
	$values = edit_single_page($tpls,$scope);
	if (empty($values)) {						// overview
		unset($_SESSION['page_ids'],$_SESSION['lastget']);
		get_pages($tpls,$scope);				// Fill overview of pages
		$values = values_overview();	// prepare forms
	}
	$tplobj->build_form($tpls['seite'],$values); // generate forms
	unset($values,$elements);
	if (!empty($vorgaben['sub_dir']))	$tpls['seite'] = str_replace('src=&quot;/','src=&quot;'.$vorgaben['sub_dir'].'/',$tpls['seite']); // some cleanup
	if (empty($_SESSION['lastget']))	$_SESSION['lastget'] = '';
	$_SESSION['formget'] = formget(array('get'=>'PAGE_ID,page,parent_ID,TPL_ID,KAT_ID,suche,paginate,uid'));
	$out = str_replace(array($vorgaben['seperator'].'ADD'.$vorgaben['seperator'],$vorgaben['seperator'].'FORMGET'.$vorgaben['seperator'],$vorgaben['seperator'].'LASTGET'.$vorgaben['seperator']),array($add,$_SESSION['formget'],$_SESSION['lastget']),$tpls['seite']);
	unset($tpls,$add);
	$out = str_replace('#SHY#','&shy;',$out);
	$out = str_replace("|MENU|", '',$out);
	return $out;
}
function edit_single_page(&$tpls,$scope,$values='') {
	global $tplobj,$sub_tpl,$vorgaben;
	result_kv();
	if (!empty($_REQUEST['pages']['PAGE_ID']) && empty($_REQUEST['search'])) {
		if (empty($_SESSION['lastget']) && !empty($_SESSION['formget']))	$_SESSION['lastget'] = $_SESSION['formget'];
		if (is_numeric(str_remove($_REQUEST['pages']['PAGE_ID'],','))) {
			if (!empty($tpls['reload']))	$tpls['seite'] = str_replace('|RELAOD|',str_replace('|PAGE_ID|',$_REQUEST['pages']['PAGE_ID'],$tpls['reload']),$tpls['seite']);
			$elements = fetch_page($_REQUEST['pages']['PAGE_ID'],$tpls,$scope);		// Edit page
		} else $elements = new_page();					// new page (like this)
		if ($elements) {
			$tpls['seite'] = str_replace('|ENTRIES|',subpage_of(array('PAGE_ID'=>$elements['parent_ID'],'cache'=>false)),$tpls['seite']);	// generate selection for sub pages
			$tplobj->array2tpl2($tpls['seite'],$elements,$vorgaben['seperator']);		// fill template
			$values = values_pages($elements,$tpls);			// prepare forms
			get_vorlage(array('TPL_ID'=>$vorgaben['seiten_tpl']));
			add_fck();
			$sub_tpl['JS'][] = 'jquery/dynacloud-5.js';
			$sub_tpl['JS'][] = 'jquery/caret.min.js';
			$sub_tpl['JS'][] = 'jquery/textarea.min.js';
			if (!empty($_SESSION['page_ids'])) 	$tpls['seite'] = str_replace('|PAGE_IDS|',r_implode(array_unique($_SESSION['page_ids'])),$tpls['seite']);
	}	}
	return $values;
}
function get_pages(&$tpls,$scope,$values='') {
	global $dbobj,$tplobj,$first_lang_id,$first_lang,$languages_byid,$display_tree,$result_kv,$vorgaben;
	if (empty( $vorgaben['seperator']))  $vorgaben['seperator'] = '|';
	if (!empty($_REQUEST['suche'])) 									$tpls['seiten'] = str_replace($vorgaben['seperator'].'SUCHE'.$vorgaben['seperator'],$_REQUEST['suche'],$tpls['seiten']);
	if (!isset($_REQUEST['KAT_ID']) && isset($_REQUEST['parent_ID'])) 	$tpls['seiten'] = str_replace($vorgaben['seperator'].'PARENT_ID'.$vorgaben['seperator'],$_REQUEST['parent_ID'],$tpls['seiten']);
	$tpls['zeile'] = str_replace($vorgaben['seperator'].'ENTRIES'.$vorgaben['seperator'],subpage_of(),$tpls['zeile']);
	$sql = get_pages_sql($scope);
#	$dbobj->singlequery(__file__,__line__,'SET SQL_BIG_SELECTS=1;');
	if ($seiten = $dbobj->withkey(__file__,__line__,$sql,'PAGE_ID')) {
		if (count($seiten)==1)	{
			$_REQUEST['pages']['PAGE_ID'] = key($seiten);
			return edit_single_page($tpls,$scope,$values);	#admin_pages(key());
		}
		$zeile_out = array();
		$lang_ex = $dbobj->withkey(__file__,__line__,"SELECT LANG_ID,GROUP_CONCAT(PAGE_ID) AS PAGE_IDs FROM #PREFIX#seiten WHERE LANG_ID IN (".implode(',',array_keys($languages_byid)).") GROUP BY LANG_ID;","LANG_ID",true);
		reset($display_tree);
		$branch   = current($display_tree);
		$counter  = 0;
		if (!empty($_REQUEST['ps']) && is_numeric($_REQUEST['ps']))	$proseite = $_REQUEST['ps'];
		else														$proseite = 30;
		if (count($seiten)>$proseite) {
			global $path_in,$unterseite_id,$sub_tpl;
			$sub_tpl['subnavlink'] = "\n<a href=\"".$path_in.formget(array('get'=>'PAGE_ID,page,parent_ID,TPL_ID,KAT_ID,suche,uid')).'#TO#|SID|">#LINK#</a>';
			$sub_tpl['subnavpre']  = '&paginate=';
			$sub_tpl['subnavbox']  = '<p class="nav">#ANZAHL# %%SEITEN%% (#VON# - #BIS#): #CONTENT# '.str_replace(array('#TO#','#LINK#'),array($sub_tpl['subnavpre'].'all','%%ALLE%%'),$sub_tpl['subnavlink']).'</p>';
			if (!empty($_REQUEST['paginate']) && is_numeric($_REQUEST['paginate']))	$unterseite_id = $_REQUEST['paginate'];
			elseif (!empty($_REQUEST['paginate']) && $_REQUEST['paginate']=='all')	$unterseite_id = $_REQUEST['paginate'];
			else																	$unterseite_id = 0;
			if (is_numeric($unterseite_id)) paginate($seiten,$proseite);
		}
		$kats = str_replace($vorgaben['seperator'].'KATS'.$vorgaben['seperator'],kats('',false,'',false,'<option value="|KAT_ID|" |KAT_|KAT_ID||>|TITEL|</option>'),$tpls['kategorie']);
		$out = '';
		while($branch = array_shift($display_tree)) {
			$counter++;
			if (!empty($seiten[$branch['PAGE_ID']])) {
				if (!empty($_REQUEST['PAGE_ID']) || !empty($_REQUEST['TPL_ID']) || !empty($_REQUEST['KAT_ID']) || !empty($_REQUEST['parent_ID']))
					$_SESSION['page_ids'][] = $branch['PAGE_ID'];
				work_pages($seiten[$branch['PAGE_ID']],$kats);
				if (empty($_REQUEST['person_ID']) && !empty($seiten[$branch['PAGE_ID']]['person_ID']))	$_REQUEST['person_ID']	= &$seiten[$branch['PAGE_ID']]['person_ID'];
				if (empty($_REQUEST['KAT_ID'])	&& !empty($seiten[$branch['PAGE_ID']]['KAT_ID']))		$_REQUEST['KAT_ID'] 	= &$seiten[$branch['PAGE_ID']]['KAT_ID'];
				if (empty($_REQUEST['TPL_ID'])	&& !empty($seiten[$branch['PAGE_ID']]['TPL_ID']))		$_REQUEST['TPL_ID'] 	= &$seiten[$branch['PAGE_ID']]['TPL_ID'];
				if (empty($_REQUEST['parent_ID']) && !empty($seiten[$branch['PAGE_ID']]['parent_ID']))	$_REQUEST['parent_ID'] 	= &$seiten[$branch['PAGE_ID']]['parent_ID'];
				$seiten[$branch['PAGE_ID']]['BESITZER']					= sel_array($result_kv['personen'],$seiten[$branch['PAGE_ID']]['person_ID'],'personen');	// generate select for user selection (Personenauswahl)
				$seiten[$branch['PAGE_ID']]['VLAUSWAHL']				= sel_array($result_kv['vorlagen'],$seiten[$branch['PAGE_ID']]['TPL_ID'],'vorlagen');	// and for page templates.
				$seiten[$branch['PAGE_ID']]['edit_'.$branch['PAGE_ID']]	= languages_to_edit($branch['PAGE_ID'],$tpls['edit'],$lang_ex);		// show languages
				$out								.= "\n".str_replace($vorgaben['seperator'].'PAGE_ID'.$vorgaben['seperator'],$branch['PAGE_ID'],$tplobj->array2tpl("\n".$tpls['zeile'],$seiten[$branch['PAGE_ID']],$vorgaben['seperator']));
				unset($seiten[$branch['PAGE_ID']]);
		}	}
		$out = str_replace('#SHY#','&shy;',$out);
		if (empty($sub_tpl['subnav']))		$sub_tpl['subnav'] = '';
		$tpls['seiten'] = str_replace(	array($vorgaben['seperator'].'SEITEN'.$vorgaben['seperator'],$vorgaben['seperator'].'FIRST_LANG'.$vorgaben['seperator'],$vorgaben['seperator'].'SUBNAV'.$vorgaben['seperator']),
										array(str_replace($vorgaben['seperator'].'SEITEN_ZEILEN'.$vorgaben['seperator'],$out,$tpls['tabelle']),$first_lang,$sub_tpl['subnav']),
										$tpls['seiten']);
		unset($out);
	}
	if (!empty($_REQUEST['parent_ID']))		$parent_ID = &$_REQUEST['parent_ID'];
	else									$parent_ID = 0;
	$tpls['seite'] = str_replace($vorgaben['seperator'].'ENTRIES'.$vorgaben['seperator'],subpage_of(array('PAGE_ID'=>$parent_ID)),$tpls['seiten']); // selection of parent page
	unset($branch,$seiten,$tpls['seiten'],$result_kv);
}
function get_pages_sql($scope) {
	global $dbobj,$first_lang_id;
		$sql = "SELECT 	#PREFIX#seiten.Menu,#PREFIX#seiten_attr.*,
					FL_seiten.Menu  AS FL_Menu,			FL_seiten.Ueberschrift AS FL_Ueberschrift,
					FL_seiten.Titel AS FL_Titel,		FL_seiten.Beschreibung AS FL_Beschreibung,
					kids_attr.KAT_ID AS kids_KAT_ID,	parent_attr.parent_ID  AS parent_parent_ID,
					kids_attr.TPL_ID AS kids_TPL_ID,	parent_attr.TPL_ID	 AS parent_TPL_ID,
					count(DISTINCT kids_attr.PAGE_ID) AS kids_count
			FROM 	#PREFIX#_languages,#PREFIX#seiten
						LEFT JOIN (#PREFIX#seiten as FL_seiten)			ON (FL_seiten.LANG_ID = ".$first_lang_id." AND #PREFIX#seiten.PAGE_ID = FL_seiten.PAGE_ID),
					#PREFIX#seiten_attr
						LEFT JOIN (#PREFIX#seiten as parent)			ON (parent.PAGE_ID = #PREFIX#seiten_attr.parent_ID)
						LEFT JOIN (#PREFIX#seiten_attr as parent_attr)	ON (parent_attr.PAGE_ID = parent.PAGE_ID)
						LEFT JOIN (#PREFIX#seiten_attr as kids_attr)	ON (kids_attr.parent_ID = #PREFIX#seiten_attr.PAGE_ID ".pages_sql('kids_attr').")
						LEFT JOIN (#PREFIX#kategorien)					ON (#PREFIX#kategorien.KAT_ID = #PREFIX#seiten_attr.KAT_ID)
			WHERE 	#PREFIX#seiten.LANG_ID		= #PREFIX#_languages.LANG_ID
			AND		#PREFIX#seiten_attr.PAGE_ID = #PREFIX#seiten.PAGE_ID";
	if (!empty($_REQUEST['PAGE_ID']) && !empty($_REQUEST['TPL_ID']))			$sql .= "\n	AND	(#PREFIX#seiten_attr.PAGE_ID IN (".$_REQUEST['PAGE_ID'].") OR #PREFIX#seiten_attr.TPL_ID IN (".$_REQUEST['TPL_ID']."))";
	elseif (!empty($_REQUEST['PAGE_ID']))										$sql .= "\n	AND	 #PREFIX#seiten_attr.PAGE_ID IN (".$_REQUEST['PAGE_ID'].")";
	elseif (!empty($_REQUEST['TPL_ID']))										$sql .= "\n	AND	 #PREFIX#seiten_attr.TPL_ID IN (".$_REQUEST['TPL_ID'].")";
	$sql .= pages_sql();
	if (is_array($scope))	$sql .= pages_scope($scope);
	if (isset($_REQUEST['parent_ID']) && $_REQUEST['parent_ID'] != '')			$sql .= "\n	AND	 #PREFIX#seiten_attr.parent_ID = '".$_REQUEST['parent_ID']."'";
	if (isset($_REQUEST['person_id']) && $_REQUEST['person_id'] != '')			$sql .= "\n	AND	 #PREFIX#seiten_attr.person_ID = '".$_REQUEST['person_id']."'";
	elseif ((in_array('alles',$_SESSION['permissions']['PAGE_ID']) || in_array('eigene',$_SESSION['permissions']['PAGE_ID'])) && !isset($_REQUEST['PAGE_ID']) && !isset($_REQUEST['parent_ID']) && empty($_REQUEST['KAT_ID']) && empty($_REQUEST['TPL_ID']) && empty($_REQUEST['suche'])) {
		if (!$scope && $x=$dbobj->tostring(__file__,__line__,"SELECT PAGE_ID FROM #PREFIX#seiten_attr WHERE parent_ID = 0 AND person_ID = ".uid().";")) {
																				$sql .= "\n	AND	 #PREFIX#seiten_attr.parent_ID = 0";
	}	}
	if (!empty($_REQUEST['KAT_ID']))											$sql .= "\n	AND	 #PREFIX#seiten_attr.KAT_ID = '".$_REQUEST['KAT_ID']."'";
	if (!empty($_SESSION['permissions']['KAT_ID'][0]) && !in_array('alles',$_SESSION['permissions']['KAT_ID']))			$sql .= "\n	AND	 #PREFIX#seiten_attr.KAT_ID IN (".implode(',',$_SESSION['permissions']['KAT_ID']).")";
	if (!empty($_REQUEST['suche']))												$sql .= "\n	AND	 CONCAT(#PREFIX#seiten.Menu,' ',#PREFIX#seiten.Ueberschrift,' ',#PREFIX#seiten.Beschreibung) LIKE '%".$_REQUEST['suche']."%'";
	$sql .= "\n			GROUP BY	#PREFIX#seiten.PAGE_ID";
	$sql .= "\n			ORDER BY	
									position ASC,
									Menu ASC;";
	return $sql;
}
function fetch_page($PAGE_ID,$tpls,$scope=false) {
	global $dbobj,$lang_id,$vorgaben;
	if ($tf = glob($vorgaben['img_path'].'/thumbs/TMP_*')) {	// find temp images (prefix: TMP_)
		foreach ($tf as $filename) {
			unlink($filename);									// and remove them
			unlink(str_remove($filename,'/thumbs'));
	}	}
	if (!empty($_REQUEST['pages']['LANG_ID']))	$LANG_ID = $_REQUEST['pages']['LANG_ID'];	// language requested
	else										$LANG_ID = $lang_id;						// otherwise fall back to default
	$sql = "SELECT 		#PREFIX#seiten_attr.*,seite.*,					owner.Name AS owner, editor.Name AS editor,
						#PREFIX#seiten.LANG_ID		AS FL_ID,			#PREFIX#seiten.Kurzname				AS FL_Kurzname,
						#PREFIX#seiten.Ueberschrift AS FL_Ueberschrift,	#PREFIX#seiten.Beschreibung			AS FL_Beschreibung,
						#PREFIX#seiten.Menu			AS FL_Menu,			#PREFIX#seiten.Titel				AS FL_Titel,
						#PREFIX#seiten.Text			AS FL_Text,			#PREFIX#seiten_attr.person_ID		AS owner_ID,
						#PREFIX#vorlagen.styles		AS tpl_styles,		count(DISTINCT kids_attr.PAGE_ID)	AS kids_count,
						next.PAGE_ID AS next_ID, prev.PAGE_ID AS prev_ID
			FROM 		#PREFIX#_languages,(#PREFIX#seiten,#PREFIX#seiten_attr)
							LEFT JOIN (#PREFIX#seiten_attr as kids_attr)ON (kids_attr.parent_ID = #PREFIX#seiten_attr.PAGE_ID ".pages_sql('kids_attr').")
							LEFT JOIN (#PREFIX#seiten as seite)			ON (seite.PAGE_ID = ".$PAGE_ID." AND seite.LANG_ID = ".$LANG_ID.")
							LEFT JOIN (#PREFIX#seiten_attr as next)		ON (next.PAGE_ID = (SELECT next.PAGE_ID FROM #PREFIX#seiten_attr AS p,#PREFIX#seiten_attr AS next WHERE p.PAGE_ID = '".$PAGE_ID."' AND next.lft > p.lft ORDER BY next.lft ASC  LIMIT 1))
							LEFT JOIN (#PREFIX#seiten_attr as prev)		ON (prev.PAGE_ID = (SELECT prev.PAGE_ID FROM #PREFIX#seiten_attr AS p,#PREFIX#seiten_attr AS prev WHERE p.PAGE_ID = '".$PAGE_ID."' AND prev.lft < p.lft ORDER BY prev.lft DESC LIMIT 1))
							LEFT JOIN (#PREFIX#person AS owner)			ON (owner.ID = #PREFIX#seiten_attr.person_ID)
							LEFT JOIN (#PREFIX#person AS editor)		ON (editor.ID = #PREFIX#seiten.editor_ID)
							LEFT JOIN (#PREFIX#vorlagen)				ON (#PREFIX#vorlagen.TPL_ID = #PREFIX#seiten_attr.TPL_ID)
			WHERE 		#PREFIX#seiten.PAGE_ID = ".$PAGE_ID."
			AND			(#PREFIX#seiten.LANG_ID = #PREFIX#_languages.LANG_ID OR #PREFIX#_languages.LANG_ID > 0)
			AND			#PREFIX#seiten_attr.PAGE_ID = #PREFIX#seiten.PAGE_ID";
	$sql .= pages_sql();
	if (is_array($scope))	$sql .= pages_scope($scope);
	$sql .= "\nGROUP BY	#PREFIX#seiten_attr.PAGE_ID";
	$sql .= "\nLIMIT 1;";
	$dbobj->singlequery(__file__,__line__,'SET SQL_BIG_SELECTS=1');
	if ($result = $dbobj->exists(__file__,__line__,$sql))	return work_elements($result[0],$PAGE_ID,$tpls);	// let's start building the page
	else													return false;									// or make a new one
}
function work_elements($elements,$page_id,$tpls) {	// let's start building the page
	global $tplobj,$dbobj,$sub_tpl,$languages_byid,$add_functions,$lang_id;
	if (empty($add_functions['1_pages']['title']))	$add_functions['1_pages']['title'] ='';
	if (empty($elements['LANG_ID']) && !empty($_REQUEST['pages']['LANG_ID']))			$elements['LANG_ID'] = $_REQUEST['pages']['LANG_ID'];
	else																				$elements['LANG_ID'] = $lang_id;
	$add_functions['1_pages']['title'] .= ': \''.$elements['FL_Titel'].'\' ('.$languages_byid[$elements['LANG_ID']]['short'].')';
	$elements['PAGE_ID'] = $page_id;
	if (!empty($_REQUEST['send']) && $_REQUEST['send'] == 'copy') {	// copy an existing page
		copy_page($elements,$page_id);
		$PAGE_ID = $elements['PAGE_ID'];
	}
	if ($bilder = get_images(array('PAGE_ID'=>$elements['PAGE_ID'],'LANG_ID'=>$elements['LANG_ID'],'size'=>'thumbs','visibility'=>'1,0','tpl'=>'admin/bilder.inc.html','imginfo'=>true))) {
		foreach ($bilder as $part_id => $bild) {
			if (!empty($part_id) && !empty($bild[$elements['PAGE_ID']])) {
				$elements['bild_'.$part_id] = current($bild[$elements['PAGE_ID']]);
	}	}	}
	if ($all_files = get_files(array('PAGE_ID'=>$elements['PAGE_ID']))) {
		foreach ($all_files as $part_id => $files) {
			foreach ($files as $filekey => $file) {
				$elements['datei_'.$filekey.'_'.$part_id] = $file;
	}	}	}
	$sql = "SELECT TPL_ID,PAGE_ID,parent_ID,person_ID FROM #PREFIX#seiten_attr WHERE PAGE_ID = ".$elements['PAGE_ID']."";
	$sql .= pages_sql();		// tricky little function to show only pages that the user is alllowed to see and edit.
	$sql .= "\nLIMIT 1;";		// there can be only one
	if (empty($elements['TPL_ID']) && $result = $dbobj->exists(__file__,__line__,$sql)) {
		$elements['TPL_ID'] 	= $result[0]['TPL_ID'];
		$elements['parent_ID'] 	= $result[0]['parent_ID'];
		$elements['owner_ID'] 	= $result[0]['person_ID'];
		if (!empty($result[0]['editor_ID']))$elements['editor_ID'] 	= $result[0]['editor_ID'];
		if (!empty($result[0]['owner']))	$elements['owner'] 		= $result[0]['owner'];
		if (!empty($result[0]['editor']))	$elements['editor'] 	= $result[0]['editor'];
	}
	get_vorlage(array('PAGE_ID'=>$elements['PAGE_ID'],'sub_key'=>'pretpl','use_js'=>false));		// because it can be overwritten when loading the template.
	if (!empty($elements['tpl_styles']) && strpos($elements['tpl_styles'],'§')!==false) {
		$tmp = $sub_tpl; 							// remember sub templates,
		if (!empty($sub_tpl['pretpl']))	$sub_tpl = $sub_tpl['pretpl'];
		make_replacements($elements['tpl_styles']);			// Lets do some replacements on styles.
		$sub_tpl = $tmp; unset($tmp,$sub_tpl['pretpl']);	// und write back the original sub templates.
	}
	$elements['edit'] = languages_to_edit($page_id,$tpls['edit']);	// insert links for languages to edit.
	prepare_elements($elements);									// prepare the contents
	prepare_meta_links($elements,$tpls);							// and some meta stuff (previous and next pages)
	return $elements;
}
function languages_to_edit($page_id,$tpl,$lang_ex='') {				// fetsch the languages an check wether a page exists
	global $tplobj,$dbobj,$languages_byid;
	if (empty($lang_ex))	$lang_ex = $dbobj->withkey(__file__,__line__,"SELECT LANG_ID,PAGE_ID AS PAGE_IDs FROM #PREFIX#seiten WHERE LANG_ID IN (".implode(',',array_keys($languages_byid)).") AND PAGE_ID = ".$page_id." GROUP BY LANG_ID;","LANG_ID",true);
	foreach ($languages_byid as $id => $language) {
		$language['PAGE_ID'] = $page_id;
		$language['LANG_ID'] = $id;
		if (!empty($lang_ex[$id]['PAGE_IDs'])) 		$lp = explode(',',$lang_ex[$id]['PAGE_IDs']);
		if (empty($lp) || !in_array($page_id,$lp))	$language['exists'] = 'no_exists';	// no page found (red link)
		else										$language['exists'] = 'exists';		// page found (green link)
		$out[$id] = $tpl;
		$tplobj->array2tpl2($out[$id],$language);									// put it together
		unset($lp);
	}
	if (!empty($out)) return $out;
}
function new_page() {	// start from scratch
	global $dbobj,$tplobj,$vorgaben,$first_lang_id,$languages_byid;
	$elements = array();
	if (!empty($_REQUEST['OLD_ID'])) {
		$sql = "SELECT	LANG_ID,TPL_ID,parent_ID,KAT_ID,TPL_ID,editor_ID,person_ID as owner_ID,position,visibility
				FROM	#PREFIX#seiten,#PREFIX#seiten_attr
				WHERE	#PREFIX#seiten.PAGE_ID = #PREFIX#seiten_attr.PAGE_ID
				AND		#PREFIX#seiten.PAGE_ID = '".$_REQUEST['OLD_ID']."'
				AND 	#PREFIX#seiten.LANG_ID = ".$_REQUEST['pages']['LANG_ID'].";";
		if ($result = $dbobj->exists(__file__,__line__,$sql))	$elements = $result[0];
	} else {
		if (!empty($_REQUEST['pages']['LANG_ID']))		 $elements['LANG_ID']	= $_REQUEST['pages']['LANG_ID'];
		if (!empty($_REQUEST['pages_attr']['TPL_ID']))	 $elements['TPL_ID']	= $_REQUEST['pages_attr']['TPL_ID'];
		if (!empty($_REQUEST['pages_attr']['KAT_ID']))	 $elements['KAT_ID']	= $_REQUEST['pages_attr']['KAT_ID'];
		if (!empty($_REQUEST['pages_attr']['parent_ID']))$elements['parent_ID']	= $_REQUEST['pages_attr']['parent_ID'];
	}
	$elements['PAGE_ID'] = $dbobj->next_free_id('seiten_attr','PAGE_ID');
	if (empty($elements['LANG_ID']))	 $elements['LANG_ID']	= &$first_lang_id;
	if (!empty($elements['visibility'])) $elements['visible']	= 'checked="checked"';
	if (!empty($vorgaben['template']))	 $elements['Text']		= &$vorgaben['template'];
	if (!empty($elements['TPL_ID']))	 $elements['vlframe']	= edit_vorlage($elements['TPL_ID'],$elements['PAGE_ID']); // see edit_sections.php
	if (empty($elements['parent_ID']))	 $elements['parent_ID']	= 0;
	$elements['Menu']  = '';
	$elements['ROWS']  = '10';
	$elements['short'] = &$languages_byid[$elements['LANG_ID']]['short'];
	page_plugins($elements);
	return $elements;
}
function prepare_meta_links(&$elements,$tpls) {
	global $tplobj,$sub_tpl;
	$green_next = '';	$green_prev = '';
	if (!empty($_SESSION['page_ids'])) {										// if there are page_ids saved from the last selction
		$sites = flattenArray($_SESSION['page_ids']);								// put them here
		$flipped = array_flip(array_values($sites));								// and invert
		if (isset($flipped[$elements['PAGE_ID']])) {								// do we have an entry for the current page?
			$next_pages = array_slice($sites,$flipped[$elements['PAGE_ID']]+1);			// then split there to get the following pages
			$prev_pages = array_diff($sites,$next_pages);								// and whats left are the previous pages
			if (!empty($next_pages[0])) {
				reset($next_pages);
				$next['page_ID'] = current($next_pages);							// If everything is sorted correctly the pointer is on the next page
				$next['color']   = 'style="color:#0d0;"';
				$next['count']   = count($next_pages);
			}
			if (!empty($prev_pages)) {
				array_pop($prev_pages);												// let's drop the last (because thats the current page)
				$prev['page_ID'] = end($prev_pages);								// and the new last element is what we want
				$prev['color']   = 'style="color:#0d0;"';
				$prev['count']   = count($prev_pages);
	}	}	}
	$prev['lang_id'] = $elements['LANG_ID'];
	$next['lang_id'] = $elements['LANG_ID'];
	if (!empty($tpls['link_next'])	&&	!empty($elements['next_ID'])) {
		if (empty($next['page_ID'])) $next['page_ID'] = $elements['next_ID'];		// If there is no next page in our selection, than we take the next page within our tree
		$elements['next']			= $tplobj->array2tpl($tpls['link_next'],$next);
		$sub_tpl['admmeta']['link'][]	= $tplobj->array2tpl($tpls['meta_next'],$next);
	}
	if (!empty($tpls['link_prev'])	&&	!empty($elements['prev_ID'])) {
		if (empty($prev['page_ID'])) $prev['page_ID'] = $elements['prev_ID'];		// If there is no previous page in our selection, than we take the next page within our tree
		$elements['prev']			= $tplobj->array2tpl($tpls['link_prev'],$prev);
		$sub_tpl['admmeta']['link'][]	= $tplobj->array2tpl($tpls['meta_prev'],$prev);
	}
	if (!empty($tpls['link_likethis']))	$elements['likethis'] = $tplobj->array2tpl($tpls['link_likethis'],$elements);
}
function copy_page(&$elements,$PAGE_ID) {
	global $dbobj,$vorgaben,$error;
	$elements['PAGE_ID'] = $dbobj->next_free_id('seiten_attr','PAGE_ID');
	$_SESSION['page_ids'][] = $elements['PAGE_ID'];
	$elements['Kurzname']= make_kn($elements['Menu']);
	$elements['FL_Text'] = str_replace('/'.$PAGE_ID.'_','/'.$elements['PAGE_ID'].'_',$elements['FL_Text']);
	$elements['Text']	 = str_replace('/'.$PAGE_ID.'_','/'.$elements['PAGE_ID'].'_',$elements['Text']);
	$_REQUEST['pages']['Menu']									= $elements['Menu'];
	$_REQUEST['pages']['Titel']									= $elements['Titel'];
	$error[] = '%%KOPIE_VON%%: "'.$_REQUEST['pages']['Menu'].' ('.$PAGE_ID.')"';
	$_REQUEST['pages']['Kurzname']								= $elements['Kurzname'];
	$_REQUEST['pages_attr']['parent_ID'][$elements['PAGE_ID']]	= $elements['parent_ID'];
	$elements['visibility'] = 0;
	$sql_c['seiten'] 		= "SELECT * FROM #PREFIX#seiten			WHERE PAGE_ID = ".$PAGE_ID.";";
	$sql_c['seiten_attr']	= "SELECT * FROM #PREFIX#seiten_attr	WHERE PAGE_ID = ".$PAGE_ID.";";
	$sql_c['bilder'] 		= "SELECT * FROM #PREFIX#bilder			WHERE PAGE_ID = ".$PAGE_ID.";";
	$sql_c['abschnitte'] 	= "SELECT * FROM #PREFIX#abschnitte		WHERE PAGE_ID = ".$PAGE_ID.";";
	$sql_c['dateien'] 		= "SELECT * FROM #PREFIX#dateien		WHERE PAGE_ID = ".$PAGE_ID.";";
	foreach ($dbobj->multiquery(__file__,__line__,$sql_c) as $table => $data) {
		if(!empty($data[0])) {
			foreach ($data as $key => $row) {
				$row['PAGE_ID'] = $elements['PAGE_ID'];
				if (!empty($row['ID']))								unset($row['ID']);
				if (!empty($row['PAGE_ID']))						$row['PAGE_ID']	= $elements['PAGE_ID'];
				if ($table == 'seiten_attr') 						$row['visibility'] = $elements['visibility'];
				if ($table == 'bilder' && !empty($row['BILD_ID'])) 	unset($row['BILD_ID']);
				if (!empty($row['Text'])) {
					$row['Text']	 = str_replace('/'.$PAGE_ID.'_','/'.$elements['PAGE_ID'].'_',$row['Text']);
					$row['Menu']	 = $elements['Menu'];
					$row['Titel']	 = $elements['Titel'];
					$row['Kurzname'] = $elements['Kurzname'];
				}
				if (!empty($row['Dateiname'])) {
					if (is_numeric($row['PART_ID']))	$fnpart = $row['PART_ID'].'_'.$row['Dateiname'];
					else								$fnpart = $row['Dateiname'];
					$base = $vorgaben['base_dir'].$vorgaben['img_path'].'/';
					$file = $base.$PAGE_ID.'_'.$fnpart;
					if (is_file($file))	copy($file,$base.$elements['PAGE_ID'].'_'.$fnpart);
					$file = $base.'thumbs/'.$PAGE_ID.'_'.$fnpart;
					if (is_file($file))	copy($file,$base.'thumbs/'.$elements['PAGE_ID'].'_'.$fnpart);
				}
				$dbobj->array2db(__file__,__line__,$row,'#PREFIX#'.$table,'INSERT INTO');
				unset($row,$_REQUEST['part_attr']);
	}	}	}
	rebuild_tree();
}
function work_pages(&$seite,$kats) {
	$seite['kats'] = &$kats;
	if		(!empty($seite['parent_ID']))		$seite['sel_'.$seite['parent_ID']]	= 'selected="selected"';
	if		(!empty($seite['KAT_ID']))			$seite['kat_'.$seite['KAT_ID']]		= 'selected="selected"';
	if		(!empty($seite['visibility']))		$seite['visible']	= 'checked="checked"';
	if		(!empty($seite['status']))			$seite['isstatus']	= 'checked="checked"';
	if		(!empty($seite['FL_Titel'])) 		$seite['Titel']	= str_remove($seite['FL_Titel'],array("\r","\n",'"'));
	elseif	(!empty($seite['Titel'])) 			$seite['Titel']	= str_remove($seite['Titel'],array("\r","\n",'"'));
	if		(!empty($seite['FL_Menu'])) 		$seite['Menu']	= $seite['FL_Menu'];
	elseif	(!empty($seite['Menu']))			$seite['Menu']	= $seite['Menu'];
	elseif	(!empty($seite['Titel'])) 			$seite['Menu']	= $seite['Titel'];
	elseif	(!empty($seite['Ueberschrift']))	$seite['Menu']	= $seite['Ueberschrift'];
	if		(!empty($seite['FL_Beschreibung'])) $seite['Beschreibung']	= str_remove($seite['FL_Beschreibung'],array("\r","\n",'"'));
	elseif	(!empty($seite['Beschreibung']))	$seite['Beschreibung']	= str_remove($seite['Beschreibung'],array("\r","\n",'"'));
	if		(!empty($seite['FL_Ueberschrift'])) $seite['Ueberschrift']	= $seite['FL_Ueberschrift'];
	elseif	(!empty($seite['Ueberschrift']))	$seite['Ueberschrift']	= $seite['Ueberschrift'];
}
function values_pages($elements,$tpls) {	// lets prepare some values to use in the forms
	global $result_kv;
	if (!empty($elements['editor_ID']))			$preset = $elements['editor_ID'];
	else										$preset = $_SESSION['uid'];
	$values_editor = '';
	$values_owner = '';
	if (!empty($tpls['vllink']))	$tpls['vllink'] = str_replace('|TPL_ID|',$elements['TPL_ID'],$tpls['vllink']);
	if (!empty($tpls['katlink']))	$tpls['katlink']= str_replace('|KAT_ID|',$elements['KAT_ID'],$tpls['katlink']);
	select_form($values_editor,$preset,'%%AUTOR%%', $result_kv['personen'],'pages[editor_ID]',false,'editor_ID');
	if (!empty($elements['owner_ID']))			$preset = $elements['owner_ID'];
	else										$preset = $_SESSION['uid'];
	select_form($values_owner,$preset,'%%BESITZER%%',$result_kv['personen'],'pages_attr[owner_ID]['.$elements['PAGE_ID'].']',false,'owner_ID');
	$values = array_merge($values_owner,$values_editor);
	if (!empty($tpls['vllink'])) {
		if (empty($_SESSION['permissions']['KAT_ID']) || empty($elements['KAT_ID']) || (in_array('alles',$_SESSION['permissions']['KAT_ID']) || in_array($elements['KAT_ID'],$_SESSION['permissions']['KAT_ID']))) {
			$data = array('preset'=>set_preset('KAT_ID',$elements),
						  'label'=>'%%KATEGORIEN%%',
						  'result'=>$result_kv['kategorien'],
						  'name'=>'pages_attr[KAT_ID]['.$elements['PAGE_ID'].']',
						  'empty'=>false,
						  'id'=>'kat_id',
						  'append'=>$tpls['vllink']);
			$values_kat = build_select($data);
			$values = array_merge($values,$values_kat);
	}	}
	if (!empty($tpls['katlink'])) {
		if (empty($_SESSION['permissions']['TPL_ID']) || empty($elements['TPL_ID']) || (in_array('alles',$_SESSION['permissions']['TPL_ID']) || in_array($elements['TPL_ID'],$_SESSION['permissions']['TPL_ID']))) {
			$data = array('preset'=>set_preset('TPL_ID',$elements),
						  'label'=>'%%VORLAGEN%%',
						  'result'=>$result_kv['vorlagen'],
						  'name'=>'pages_attr[TPL_ID]['.$elements['PAGE_ID'].']',
						  'empty'=>false,
						  'id'=>'tpl_id',
						  'append'=>$tpls['katlink']);
			$values_tpl = build_select($data);
			$values = array_merge($values,$values_tpl);
	}	}
	return $values;
}
function values_overview() {	//	prepare form data
	global $result_kv;
	$values_adr  = array();
	$values_lang = array();
	$values_kat  = array();
	$values_tpl  = array();
	select_form($values_kat, set_preset('KAT_ID'),'%%KATEGORIEN%%',$result_kv['kategorien'],'pages_attr[KAT_ID]',   false,'kat_id');
	select_form($values_tpl, set_preset('TPL_ID'),'%%VORLAGEN%%',  $result_kv['vorlagen'],  'pages_attr[TPL_ID]',   false,'tpl_id');
	select_form($values_lang,'','%%SPRACHEN%%',   $result_kv['sprachen'],  'pages[LANG_ID]',	   false,'lang_id');
	select_form($values_adr, '','%%ADRESSEN%%',   $result_kv['personen'],  'pages_attr[person_ID]',true, 'adress_id');
	if (!empty($_REQUEST['KAT_ID'])) $values_kat['KATEGORIEN']['default']['pages_attr[KAT_ID]'] = &$_REQUEST['KAT_ID'];
	if (!empty($_REQUEST['TPL_ID'])) $values_tpl['VORLAGEN']['default']['pages_attr[TPL_ID]'] 	= &$_REQUEST['TPL_ID'];
	return array_merge($values_adr,$values_kat,$values_tpl,$values_lang);
}
function result_kv() {
	global $dbobj,$result_kv;
	if (empty($result_kv)) {
		$sql_arr['vorlagen']	= "SELECT TPL_ID,TPL_ID as ID,titel FROM #PREFIX#vorlagen";
		if (!empty($_SESSION['permissions']['TPL_ID'][0]) && !in_array('alles',$_SESSION['permissions']['TPL_ID']))		$sql_arr['vorlagen'] .= "\n WHERE TPL_ID IN (".implode(',',$_SESSION['permissions']['TPL_ID']).")";
		$sql_arr['vorlagen']   .= "\nORDER BY position,titel,ID;";
		$sql_arr['kategorien']  = "SELECT KAT_ID,KAT_ID as ID,titel FROM #PREFIX#kategorien";
		if (!empty($_SESSION['permissions']['KAT_ID'][0]) && !in_array('alles',$_SESSION['permissions']['KAT_ID']))		$sql_arr['kategorien'] .= "\n WHERE KAT_ID IN (".implode(',',$_SESSION['permissions']['KAT_ID']).")";
		$sql_arr['kategorien'] .= "\nORDER BY position,titel,ID;";
		$sql_arr['personen']	= 'SELECT ID,Name as titel,Status FROM #PREFIX#person WHERE status >= 3 ORDER BY Name';
		$sql_arr['sprachen']	= 'SELECT LANG_ID AS ID,lang_local as titel FROM #PREFIX#_languages WHERE visibility = 1 ORDER BY position,short';
		$result_kv = $dbobj->multiquery(__file__,__line__,$sql_arr);
}	}
function alleseiten($menu) {
	global $tplobj,$dbobj,$lang,$first_lang_id,$display_tree;
	if (!empty($_SESSION['pref_lang']))	 			$first_lang_id = $_SESSION['pref_lang'];
	if (empty($display_tree))	display_tree();
	$sql = "SELECT	DISTINCT #PREFIX#seiten.Ueberschrift,#PREFIX#seiten.Titel,#PREFIX#seiten.Menu,#PREFIX#seiten.Beschreibung,#PREFIX#seiten.LANG_ID,
					#PREFIX#seiten_attr.*,
					FL_seiten.Menu  AS FL_Menu,
					FL_seiten.Titel AS FL_Titel
			FROM	#PREFIX#_languages,#PREFIX#seiten_attr,#PREFIX#kategorien,
					#PREFIX#seiten LEFT JOIN (#PREFIX#seiten as FL_seiten) ON
									(FL_seiten.LANG_ID = '".$first_lang_id."' AND #PREFIX#seiten.PAGE_ID = FL_seiten.PAGE_ID)
			WHERE	#PREFIX#seiten_attr.PAGE_ID = #PREFIX#seiten.PAGE_ID
			AND		#PREFIX#_languages.LANG_ID  = #PREFIX#seiten.LANG_ID
			AND		#PREFIX#kategorien.KAT_ID   = #PREFIX#seiten_attr.KAT_ID
			".pages_sql()."
			ORDER BY 	#PREFIX#_languages.position,#PREFIX#kategorien.position,#PREFIX#seiten_attr.position,parent_ID ASC";
	$seiten = $dbobj->withkey(__file__,__line__,$sql,'PAGE_ID',false,'LANG_ID');
	$old_level  = 0;
	$alleseiten = '';
	reset($display_tree);
	$branch = current($display_tree);
	while (!empty($branch) && is_array($branch)) {
		if (!empty($seiten[$branch['PAGE_ID']])) {
			$seite = current($seiten[$branch['PAGE_ID']]);
			$seite['PAGE_ID'] = &$branch['PAGE_ID'];
			if (!empty($seite['FL_Titel'])) {
				$seite['Menu']   = &$seite['FL_Menu'];
				$seite['Titel']  = &$seite['FL_Titel'];
				$seite['LANG_ID']= &$first_lang_id;
			}
			$seite['Menu'] = my_htmlspecialchars(ltrim($seite['Menu'],'-'));
			if ($branch['level'] > $old_level)	$alleseiten .= "\n	".str_repeat('	',$branch['level'])."<ul>";
			if (!empty($menu['pages']))			$alleseiten .= "\n	".str_repeat('	',$branch['level']).$tplobj->array2tpl($menu['pages'],$seite);
			if (!empty($branch['kids']))		$alleseiten .= "\n	".str_repeat('	',$branch['level']).$tplobj->array2tpl($menu['kids'],$seite);
			$old_level = $branch['level'];
			$branch = next($display_tree);
			if($branch) 						$new_level = $branch['level'];
			else								$new_level = 0;
			if ($old_level > $new_level)		$alleseiten .= '</li>'.str_repeat('</ul></li>',($old_level - $new_level));
		} else $branch = next($display_tree);
	}
	$numberOfTags = countTags($alleseiten,'ul');
	if ($numberOfTags[0] == $numberOfTags[1])	return be_shy($alleseiten);
}
function update2fck() {
	global $dbobj;
	foreach ($dbobj->withkey(__file__,__line__,"SELECT PAGE_ID,Text FROM #PREFIX#seiten;",'PAGE_ID') as $id => $page) {
		parse($page['Text'],false,true);
		$page['Text'] = preg_replace('!\[\*\](.*)\<br \/\>!isU','<li>$1</li>',$page['Text']);
		$page['Text'] = str_replace(array('[list][*]','[/list]'),array('<ul><li>','</li></ul>'),$page['Text']);
		$dbobj->singlequery(__file__,__line__,"UPDATE #PREFIX#seiten SET Text = '".$dbobj->escape($page['Text'])."' WHERE PAGE_ID = ".$id.";");
}	}
function save_pages($data=false) {
	save_page::save_pages($data);
}
function save_pages_attr($data=false) {
	save_page::save_pages_attr($data);
}
function save_preview($data) {
	global $dbobj,$sub_tpl;
	if (!empty($_SESSION['logged']) && $dbobj->table_exists(__file__,__line__,'#PREFIX#_preview')) {
		$dbobj->as_real = true;
		$data['data'] = url_seri($_REQUEST);
		$data['PAGE_ID'] = $_REQUEST['pages']['PAGE_ID'];
		$dbobj->array2db(__file__,__line__,$data,'#PREFIX#_preview','INSERT INTO','WHERE PAGE_ID = "'.$data['PAGE_ID'].'"');
	}
	$sub_tpl['addscript'][] = "preview_window = window.open('vorschau.php?PHPSESSID='+$('#PHPSESSID').val()+'&page_id='+$('#page_id').val(),\"Vorschau\",\"toolbar=no,width=1000,height=750,directories=no,scrollbars,status=no,menubar=no,resizable=yes\");";
}
?>