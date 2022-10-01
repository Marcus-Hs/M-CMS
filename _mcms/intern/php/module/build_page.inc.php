<?php
function getmenu($data) {return get_from_page($data,'Menu');}
function getkn($data)	{return get_from_page($data,'Kurzname');}
function getdesc($data) {return get_from_page($data,'Beschreibung');}
function gettitle($data){return str_remove(get_from_page($data,'Titel'),array('&shy','#SHY#'));}
function gethead($data) {return get_from_page($data,'Ueberschrift');}
function gettxt($data)	{return get_from_page($data,'Text');}
function getname($data) {return geteditor($data);}
function geteditor($data=false) {
	global $dbobj,$tplobj, $page_id;
	$sql = "SELECT Name FROM #PREFIX#person WHERE ID = '".$data."' LIMIT 1;";
	return  $dbobj->tostring(__file__,__line__,$sql);
}
function getowner($data=false) {
	global $dbobj,$tplobj, $sub_tpl, $page_id;
	if (!$data) $data=$page_id;
	if ($data = pageid_from_preset($data)) {
		$sql = "SELECT Name FROM #PREFIX#person AS p,#PREFIX#seiten_attr AS attr WHERE attr.PAGE_ID = '".$data."' AND p.ID = attr.person_ID LIMIT 1;";
		return  $dbobj->tostring(__file__,__line__,$sql);
	} else {
		return $sub_tpl['firma'];
	}
}
function getowner_data($data=false) {
	global $dbobj,$tplobj, $sub_tpl, $page_id;
	if (!$data) $data=$page_id;
	if ($data = pageid_from_preset($data)) {
		$sql = "SELECT Name,Strasse,CONCAT(PLZ,' ',Ort) AS Ort,Telefon,Mobil,www,Email FROM #PREFIX#person AS p,#PREFIX#seiten_attr AS attr WHERE attr.PAGE_ID = '".$data."' AND p.ID = attr.person_ID LIMIT 1;";
		unset($data);
		$out = array();
		if($data = $dbobj->singlequery(__file__,__line__,$sql)) {
			foreach($data[0] as $k => $v) {
				if (!empty($v) && $k == 'Email') 	$out[$k] = '<a href="mailto:'.$v.'">'.$v.'</a>';
				elseif (!empty($v) && $k == 'www') 	$out[$k] = '<a href="'.addHttp($v).'" target="_blank">'.$v.'</a>';
				elseif (!empty($v)) $out[$k] = $v;
			}
		}
		return r_implode($out,'<br />');
	} else {
		return $sub_tpl['firma'];
	}
}
function get_from_page($data,$feld='') {
	global $sub_tpl,$vorgaben;
	if ($data = pageid_from_preset($data)) {
		if (empty($sub_tpl['all_'.$feld][$data]))			$sub_tpl['all_'.$feld][$data] = get_page(array('PAGE_ID'=>prep_data($data),'feld'=>$feld,'visibility'=>'0,1','errors'=>false));
		if (is_string($sub_tpl['all_'.$feld][$data]))		return $sub_tpl['all_'.$feld][$data];
}	}
function pageIDs_by_user($TPL_ID='') {
	global $dbobj;
	$sql = "SELECT 	PAGE_ID
			FROM 	#PREFIX#seiten_attr
			WHERE	person_ID = ".uid();
	if (!empty($TPL_ID))
		$sql .= " AND TPL_ID = ".$TPL_ID;
	if($page_ids =  $dbobj->tostring(__file__,__line__,$sql.';'))	return $page_ids;
	else															return false;
}
function UID_by_pageID($page_ID=0) {
	global $dbobj;
	$sql = "SELECT 	person_ID
			FROM 	#PREFIX#seiten_attr
			WHERE	PAGE_ID = ".$page_ID;
	if($person_id =  $dbobj->tostring(__file__,__line__,$sql.';'))	return $person_id;
	else															return false;
}
function getpage($data)	{
	global $page_id,$lang_id,$vorgaben;
	read_vorgaben('email','impressum');
	$data['PAGE_ID'] = pageid_from_preset($data['PAGE_ID']);
	if (!empty($data['PAGE_ID']) && is_numeric($data['PAGE_ID'])) {
		if (empty($data['LANG_ID']) || !is_numeric($data['LANG_ID']))	$data['LANG_ID'] = $lang_id;
		$out = build_page($data);
		make_replacements($out);
		$out = str_replace('#SHY#','&shy;',$out);
		return ($out);
}	}
function build_page($data=false) {
	global $dbobj,$tplobj,$lang,$lang_id,$sub_tpl,$page_id,$vorgaben;
	if (!$data) {
		unset($data);
		$data['PAGE_ID'] = $page_id;
		$data['LANG_ID'] = $lang_id;
	}
	if (!empty($vorgaben['fallback'])) {
		$fallback_fck = $vorgaben['fallback'];
		$fallback_fck();
		return true;
	} elseif ($seite_data = get_page($data,false)) {							// Get the page contents
		if (empty($sub_tpl['seitenvorlage']))	$sub_tpl['seitenvorlage'] = '<h3>#UEBERSCHRIFT#</h3>\n$ERROR$\n#TEXT#\n#ABSCHNITT#'; // There should be a template, but if ther isn't use this
		if (!empty($data['PAGE_ID'])) {
			$sub_tpl['bilder']	 = get_images ($data);	// Get the images
			$sub_tpl['abschnitt']= get_vorlage(array('PAGE_ID'=>$data['PAGE_ID'],'set_sub_tpl'=>true,'paginate'=>true));			// and the Template specific contents
			$seite				 = work_page($seite_data);
			$seite['abschnitt']	 = &$sub_tpl['abschnitt'];
			if(!empty($seite['Ueberschrift'])) {
				$seite['Ueberschrift'] = stripslashes($seite['Ueberschrift']);
				parse($seite['Ueberschrift'],true);
			}
			if (!empty($seite['Text']) && strpos($seite['Text'],'#'.strtoupper($sub_tpl['tpl_title']).'#')!==false) {		// Replace Placeholder (Title of Template in #)
				$seite['Text'] = str_replace('#'.strtoupper($sub_tpl['tpl_title']).'#',$seite['abschnitt'],$seite['Text']);
				unset($seite['abschnitt']);
			}
			$sub_tpl['text'] = $tplobj->array2tpl($sub_tpl['seitenvorlage'],$seite,'#,§');	// put data into template
			if (!empty($seite['Text'])) {
				return $seite['Text'];
			}
			return true;
		}
	} else
		return false;
}
function favicon($data='') {
	global $vorgaben;
	if (is_file($vorgaben['base_dir'].'favicon.ico')) return '<link rel="shortcut icon" type="image/ico" href="/favicon.ico" />';
}
function meta($data='') {
	global $sub_tpl;
	if (!empty($data)) {
		if		(!empty($sub_tpl['meta'][$data]))	$out = $sub_tpl['meta'][$data];
		elseif	(!empty($sub_tpl['meta'.$data]))	$out = $sub_tpl['meta'.$data];
	} elseif (!empty($sub_tpl['meta'])) 			$out = r_implode("\n\t",$sub_tpl['meta']);
	make_replacements($out,false,true,1);
	return $out;
}
function pageid_from_preset($data,$visibility=1) {
	global $vorgaben,$dbobj,$lang_id,$page_id,$parent_id;
	if (is_numeric($data))											return $data;
	if (strpos($data,'page_id')!==false)							return $page_id;
	if (strpos($data,'parent_id')!==false) {
		if (!empty($parent_id))										return $parent_id;
		else														return $page_id;
	}
	if (strpos($data,'_seite')!==false && !empty($vorgaben[$data]))	return $vorgaben[$data];
	if (strpos($data,'_tpl')!==false   && !empty($vorgaben[$data])) {
		$sql = "SELECT 	#PREFIX#seiten.PAGE_ID
				FROM 	#PREFIX#seiten,#PREFIX#seiten_attr,
						#PREFIX#_languages,#PREFIX#kategorien
				WHERE	#PREFIX#seiten_attr.TPL_ID	= ".$vorgaben[$data]."
				AND		#PREFIX#seiten.LANG_ID	= ".$lang_id."
				AND		#PREFIX#seiten_attr.KAT_ID	= #PREFIX#kategorien.KAT_ID	AND	#PREFIX#kategorien.visibility	>= ".$visibility."
				AND 	#PREFIX#_languages.LANG_ID	= #PREFIX#seiten.LANG_ID	AND #PREFIX#_languages.visibility	>= ".$visibility."
				AND		#PREFIX#seiten_attr.PAGE_ID	= #PREFIX#seiten.PAGE_ID	AND	#PREFIX#seiten_attr.visibility	>= ".$visibility."
				LIMIT 1;";
		return  $dbobj->tostring(__file__,__line__,$sql);
	}
	return false;
}
function select_pages($user_params) {
	global $dbobj,$tplobj,$lang_id,$sub_tpl;
	$default_params = array('PAGE_ID'=>'','PARENT_ID'=>'','PERSON_ID'=>'','TPL_ID'=>'','KAT_ID'=>'','LANG_ID'=>$lang_id,'KEY'=>'','SUBKEY'=>'','FELD'=>'Menu','FKEY'=>'','TYPE'=>'checkbox','ONCHANGE'=>'','CLASS'=>'','ifuid'=>false,'VISIBILITY'=>'0,1');
	$p = array_merge($default_params,$user_params);
	$sql = "SELECT 	#PREFIX#seiten.PAGE_ID,#PREFIX#seiten_attr.visibility,#PREFIX#seiten.Menu AS ".$p['FELD']."
			FROM 	#PREFIX#_languages,#PREFIX#seiten,#PREFIX#seiten_attr,#PREFIX#kategorien";
	$sql .= "	WHERE 		#PREFIX#seiten.LANG_ID = '".$p['LANG_ID']."'
		AND 		#PREFIX#seiten.LANG_ID = #PREFIX#_languages.LANG_ID
		AND			#PREFIX#seiten_attr.PAGE_ID = #PREFIX#seiten.PAGE_ID";
	if (!empty($p['RESTRAINT']) && !empty($p['RESTRAINT2'])) {
		$sql .= "\nAND		#PREFIX#seiten_attr.PAGE_ID IN (SELECT 	".$p['RESTRAINT_ID']." FROM #PREFIX#".$p['RESTRAINT']."
								WHERE 	".$p['RESTRAINT2'].")";
	}
	if (!empty($p['PARENT_ID']) && is_numeric(str_remove($p['PARENT_ID'])))	$sql .= "\nAND	#PREFIX#seiten_attr.parent_ID IN (".$p['PARENT_ID'].")";
	if (!empty($p['PAGE_ID'])   && is_numeric(str_remove($p['PAGE_ID'])))	$sql .= "\nAND	#PREFIX#seiten_attr.PAGE_ID   IN (".$p['PAGE_ID'].")";
	if (!empty($p['PERSON_ID']) && is_numeric(str_remove($p['PERSON_ID'])))	$sql .= "\nAND	#PREFIX#seiten_attr.person_ID   IN (".$p['PERSON_ID'].")";
	elseif (!empty($p['PERSON_ID']) && $p['PERSON_ID']=='UID')				$sql .= "\nAND	#PREFIX#seiten_attr.person_ID   IN (".uid().")";
	if (!empty($p['TPL_ID'])	&& is_numeric(str_remove($p['TPL_ID'])))	$sql .= "\nAND	#PREFIX#seiten_attr.TPL_ID	IN (".$p['TPL_ID'].")";
	if (!empty($p['TPL_ID'])	&& is_numeric(str_remove($p['KAT_ID'])))	$sql .= "\nAND	#PREFIX#seiten_attr.KAT_ID	IN (".$p['KAT_ID'].")";
	if ($p['ifuid'])														$sql .= "\nAND (#PREFIX#seiten_attr.visibility IN (".$p['VISIBILITY'].") OR #PREFIX#seiten_attr.person_ID = '".uid()."')";
	else																	$sql .= "\nAND #PREFIX#seiten_attr.visibility  IN (".$p['VISIBILITY'].")";
	$sql .= "\nAND	#PREFIX#seiten_attr.KAT_ID = #PREFIX#kategorien.KAT_ID
		AND			#PREFIX#kategorien.visibility  IN (".$p['VISIBILITY'].")";
	if (!empty($p['ORDER_BY']))	$sql .= "\nORDER BY 	#PREFIX#seiten.".$p['ORDER_BY'].",#PREFIX#kategorien.position,#PREFIX#kategorien.KAT_ID,#PREFIX#seiten_attr.position ASC,Menu ASC";	
	else						$sql .= "\nORDER BY 	#PREFIX#kategorien.position,#PREFIX#kategorien.KAT_ID,#PREFIX#seiten_attr.position ASC,Menu ASC";
	if ($pages = $dbobj->withkey(__file__,__line__,$sql,'PAGE_ID',true)) {
		return switch_type($p,$pages);
	}
}
function prep_data($data) {
	global $sub_tpl,$page_id,$parent_id,$active;
	if ($data=='first' && !empty($active)) {
		reset($active);
		$data = current($active);
	} elseif ($data=='parent') {
		$data = $parent_id;
	} elseif (empty($data) && empty($active)) {
		$data = $page_id;
	}
	return $data;
}
function get_page($user='',$work_page=true) {
	global $dbobj,$tplobj,$error,$sub_tpl,$lang,$first_lang,$lang_id,$first_lang_id,$page_id,$vorgaben;
	$default = array('PAGE_ID'=>$page_id,'LANG_ID'=>$lang_id,'feld'=>'*','visibility'=>1,'status'=>'','errors'=>true);
	extract(merge_defaults_user($default,$user),EXTR_SKIP);
	$PAGE_ID = trim(r_implode($PAGE_ID),'/');
	if (!empty($PAGE_ID) && !is_numeric($PAGE_ID)) {
		if (!empty($sub_tpl[$PAGE_ID]))			$PAGE_ID = $sub_tpl[$PAGE_ID];
		elseif (!empty($vorgaben[$PAGE_ID]))	$PAGE_ID = $vorgaben[$PAGE_ID];
	}
	$sub_tpl['lang_id'] = &$lang_id;
	$sql = "SELECT		#PREFIX#seiten.".str_replace(',',',#PREFIX#seiten.',$feld).",
						#PREFIX#seiten_attr.TPL_ID, #PREFIX#seiten_attr.KAT_ID,
						#PREFIX#seiten.editor_ID,
						#PREFIX#seiten_attr.person_ID,
						#PREFIX#seiten_attr.parent_ID,
						#PREFIX#seiten_attr.position,
						#PREFIX#kategorien.Titel AS KTitle,
						#PREFIX#vorlagen.cache,	#PREFIX#vorlagen.stats,
						#PREFIX#_languages.short,	#PREFIX#seiten.lastmod,	#PREFIX#seiten.insdate";
	if (!empty($PAGE_ID) && is_numeric(str_remove($PAGE_ID,','))) {
	   $sql .= ",\n		class.Kurzname as class,
						next.PAGE_ID AS next_ID,
						prev.PAGE_ID AS prev_ID,
						next.parent_ID AS next_p_ID,
						prev.parent_ID AS prev_p_ID,
						prevneighbour.PAGE_ID AS prevneighbour_ID,
						nextneighbour.PAGE_ID AS nextneighbour_ID
			FROM 		#PREFIX#seiten, #PREFIX#vorlagen, #PREFIX#_languages, (#PREFIX#kategorien, #PREFIX#seiten_attr)
							LEFT JOIN (#PREFIX#seiten_attr as prevneighbour,#PREFIX#kategorien AS pnk)
								ON (prevneighbour.PAGE_ID = (SELECT prevneighbour.PAGE_ID
															FROM	#PREFIX#seiten_attr AS pp,#PREFIX#seiten_attr AS prevneighbour
															WHERE	prevneighbour.visibility = 1
															AND		pp.PAGE_ID IN (".$PAGE_ID.")
															AND		prevneighbour.PAGE_ID != pp.PAGE_ID
															AND 	prevneighbour.rgt < pp.lft
															ORDER BY prevneighbour.rgt DESC
															LIMIT 1)
								AND pnk.visibility = 1 AND prevneighbour.visibility = 1)
							LEFT JOIN (#PREFIX#seiten_attr as nextneighbour,#PREFIX#kategorien AS nnk)
								ON (nextneighbour.PAGE_ID = (SELECT nextneighbour.PAGE_ID
															FROM 	#PREFIX#seiten_attr AS pn,#PREFIX#seiten_attr AS nextneighbour
															WHERE	nextneighbour.visibility = 1
															AND		pn.PAGE_ID IN (".$PAGE_ID.")
															AND		nextneighbour.PAGE_ID != pn.PAGE_ID
															AND 	nextneighbour.rgt > pn.lft
															ORDER BY nextneighbour.rgt ASC
															LIMIT 1)
								AND nnk.visibility = 1 AND nextneighbour.visibility = 1)
							LEFT JOIN (#PREFIX#seiten_attr as next,#PREFIX#kategorien AS nk)
								ON (next.PAGE_ID = (SELECT next.PAGE_ID
													FROM #PREFIX#seiten_attr AS p,#PREFIX#seiten_attr AS next,#PREFIX#kategorien AS nk
													WHERE  next.visibility = 1
													AND p.PAGE_ID IN (".$PAGE_ID.")
													AND next.lft > p.lft
													ORDER BY next.lft ASC
													LIMIT 1)
								AND next.KAT_ID = nk.KAT_ID  AND nk.visibility = 1";
		if (empty($vorgaben['kategal']))	$sql .= " AND next.KAT_ID = #PREFIX#kategorien.KAT_ID";
		$sql .= ")
							LEFT JOIN (#PREFIX#seiten_attr as prev,#PREFIX#kategorien AS pk)
								ON (prev.PAGE_ID = (SELECT prev.PAGE_ID
													FROM #PREFIX#seiten_attr AS p,#PREFIX#seiten_attr AS prev,#PREFIX#kategorien AS pk
													WHERE  prev.visibility = 1
													AND p.PAGE_ID IN (".$PAGE_ID.")
													AND prev.lft < p.lft
													ORDER BY prev.lft DESC
													LIMIT 1)
								AND prev.KAT_ID = pk.KAT_ID AND pk.visibility = 1";
		if (empty($vorgaben['kategal']))	$sql .= " AND prev.KAT_ID = #PREFIX#kategorien.KAT_ID";
		$sql .= ")
							LEFT JOIN (#PREFIX#seiten as class,#PREFIX#_languages as first_lang)
								ON (class.LANG_ID = first_lang.LANG_ID AND class.PAGE_ID = #PREFIX#seiten_attr.PAGE_ID";
		if	 (is_numeric($first_lang_id))	$sql .= "\nAND first_lang.LANG_ID = ".$first_lang_id;
		elseif (is_numeric($first_lang))	$sql .= "\nAND first_lang.LANG_ID = ".$first_lang;
		elseif (!empty($first_lang))		$sql .= "\nAND first_lang.short   = '".$first_lang."'";
		$sql .= ")";
	} else {
		$sql .= "\nFROM 	#PREFIX#seiten_attr, #PREFIX#vorlagen, #PREFIX#seiten,	#PREFIX#kategorien,	#PREFIX#_languages";
	}
	$sql .=  "\nWHERE	#PREFIX#seiten.LANG_ID = #PREFIX#_languages.LANG_ID
				AND		#PREFIX#seiten_attr.PAGE_ID = #PREFIX#seiten.PAGE_ID
				AND		#PREFIX#seiten_attr.visibility IN (".$visibility.")
				AND		#PREFIX#kategorien.visibility  IN (".$visibility.")
				AND		#PREFIX#kategorien.KAT_ID = #PREFIX#seiten_attr.KAT_ID
				AND		#PREFIX#vorlagen.TPL_ID   = #PREFIX#seiten_attr.TPL_ID
				AND		#PREFIX#seiten.PAGE_ID	= #PREFIX#seiten_attr.PAGE_ID";
	if ($PAGE_ID == '#firstpage#')					$sql .= "\nAND #PREFIX#seiten_attr.PAGE_ID = (SELECT PAGE_ID FROM #PREFIX#seiten_attr WHERE lft > 0 AND visibility = 1 ORDER BY lft ASC LIMIT 1)";
	elseif(!empty($PAGE_ID) && is_numeric($PAGE_ID))$sql .= "\nAND #PREFIX#seiten_attr.PAGE_ID = ".$PAGE_ID;
	elseif(!empty($PAGE_ID))						$sql .= "\nAND #PREFIX#seiten.Kurzname = '".$PAGE_ID."'";
	else											$sql .= "\nAND #PREFIX#seiten_attr.parent_ID = 0";
	if	 (is_numeric($LANG_ID))					$sql .= "\nAND #PREFIX#_languages.LANG_ID = ".$LANG_ID;
	elseif (is_numeric($lang))						$sql .= "\nAND #PREFIX#_languages.LANG_ID = ".$lang."'";
	elseif (!empty($lang))							$sql .= "\nAND #PREFIX#_languages.short = '".$lang."'";
	elseif (!empty($first_lang_id))					$sql .= "\nAND #PREFIX#_languages.LANG_ID = ".$first_lang_id;
	$sql .= sql_kat_status($status);
	$sql .= "\nORDER BY	#PREFIX#kategorien.position,#PREFIX#seiten_attr.position,#PREFIX#_languages.position LIMIT 1;";
	if ($out = $dbobj->exists(__file__,__line__,$sql)) {
		if ($work_page)	return work_page($out,$feld,$errors);
		else			return $out;
	} else				return false;
}
function work_page($out,$feld='',$errors=true) {
	global $notfound,$error,$sub_tpl,$vorgaben,$parent_id,$page_id,$unterseite_id;
	if (!empty($feld) && $feld != '*') {	// In case you only need certain fields
		if(strpos($feld,',')!=false) {		// Is ist more than one (comma seperatates)
			$fs = explode(',',$feld);
			foreach ($fs as $f) {	// than loop through them.
				if (!empty($out[0][$f])) $fields[$f] = $out[0][$f];		// and arrange the content accordingly
			}
			if (!empty($fields)) return $fields;						// then give it back
		} else 					 return $out[0][$feld];					// otherwise just the content of the field
	} elseif (empty($notfound) && !empty($out[0]['insdate'])) {			// if no fields are specified there is more work to do ...
		if($vorgaben['is_preview']) {
			if(isset($_REQUEST['text']))		$out[0]['Text'] = urldecode($_REQUEST['text']);
			if(isset($_REQUEST['Ueberschrift']))$out[0]['Ueberschrift'] = urldecode($_REQUEST['Ueberschrift']);
			if(isset($_REQUEST['Beschreibung']))$out[0]['Beschreibung'] = urldecode($_REQUEST['Beschreibung']);
			if(isset($_REQUEST['Menu']))		$out[0]['Menu'] = urldecode($_REQUEST['Menu']);
			if(isset($_REQUEST['Titel']))		$out[0]['Titel'] = urldecode($_REQUEST['Titel']);
		}
		if (!empty($out[0]['Titel'])) {
			$sub_tpl['pagetitle'] 	= str_replace(array('"',"\n",'#SHY#'),array(''," ",''),str_remove($out[0]['Titel'],'"'));
			$sub_tpl['titel'] 	= &$sub_tpl['pagetitle'];	// ein Alias
		}
		if (!empty($out[0]['Beschreibung'])) {
			$sub_tpl['description'] = str_replace(array('"',"\n",'#SHY#'),array(''," ",''),$out[0]['Beschreibung']);
			$out[0]['Beschreibung'] = nl2br($out[0]['Beschreibung']);
#			do_links($out[0]['Beschreibung']);
		}
		if (empty($sub_tpl['metalink']))	$sub_tpl['metalink'] = '<link rel="#REL#" href="#LINKTO#" />';
		if (empty($sub_tpl['neighbour']['next_ID']) && !empty($out[0]['nextneighbour_ID'])) {
			$sub_tpl['neighbour']['next_ID'] = $out[0]['nextneighbour_ID'];
			$linkto = linkto($out[0]['nextneighbour_ID']);
			$sub_tpl['meta']['link']['next'] = str_replace(array('#REL#','#LINKTO#'),array('next',$linkto),$sub_tpl['metalink']);
		}
		elseif (empty($sub_tpl['neighbour']['next_ID']) && !empty($out[0]['next_ID'])) {
			$sub_tpl['neighbour']['next_ID'] = $out[0]['next_ID'];
			$linkto = linkto($out[0]['next_ID']);
			$sub_tpl['meta']['link']['next'] = str_replace(array('#REL#','#LINKTO#'),array('next',$linkto),$sub_tpl['metalink']);
			if ($out[0]['next_p_ID'] == $out[0]['parent_ID'] && !empty($sub_tpl['naechsteseite']))
				$sub_tpl['weiter'] = str_replace('$NPAGE$',$linkto,$sub_tpl['naechsteseite']);
		}
		if (empty($sub_tpl['neighbour']['prev_ID']) && !empty($out[0]['prevneighbour_ID'])) {
			$sub_tpl['neighbour']['prev_ID'] = $out[0]['prevneighbour_ID'];
			$linkto = linkto($out[0]['prevneighbour_ID']);
			$sub_tpl['meta']['link']['prev'] = str_replace(array('#REL#','#LINKTO#'),array('prev',$linkto),$sub_tpl['metalink']);
		}
		elseif (empty($sub_tpl['neighbour']['prev_ID']) && !empty($out[0]['prev_ID'])) {
			$sub_tpl['neighbour']['prev_ID'] = $out[0]['prev_ID'];
			$linkto = linkto($out[0]['prev_ID']);
			$sub_tpl['meta']['link']['prev'] = str_replace(array('#REL#','#LINKTO#'),array('prev',$linkto),$sub_tpl['metalink']);
			if ($out[0]['prev_p_ID'] == $out[0]['parent_ID'] && !empty($sub_tpl['vorigeseite']))
				$sub_tpl['zurueck'] = str_replace('$LPAGE$',$linkto,$sub_tpl['vorigeseite']);
		}
		if (!empty($out[0]['Ueberschrift'])) {
			bb2html($out[0]['Ueberschrift']);
			$sub_tpl['Ueberschrift']= $out[0]['Ueberschrift'];
		}
		if (!empty($out[0]['KTitle']))		$sub_tpl['KTitle']	 = $out[0]['KTitle'];
		if (!empty($out[0]['PAGE_ID']))		$sub_tpl['page_id']	 = $out[0]['PAGE_ID'];
		if (!empty($out[0]['class'])) 		$sub_tpl['class'][]	 = current(explode('.',strtolower($out[0]['class'])));
		if (!empty($out[0]['position']))	$sub_tpl['position'] = &$out[0]['position'];
		if (!empty($out[0]['person_ID']))	$sub_tpl['owner_id'] = &$out[0]['person_ID'];
		if (!empty($out[0]['lastmod'])) {
			$sub_tpl['shortdate']		= format_date($out[0]['lastmod'],"%Y-%m-%d");
		#	$sub_tpl['lastmod']			= format_date($out[0]['lastmod'],"%a, %d %b %Y %H:%M:%S GMT");
			$sub_tpl['metadate']		= format_date($out[0]['lastmod'],"%a, %d %b %Y %H:%M:%S %z"/*.gmt_offset()*/);
			$sub_tpl['lastmod']			= $out[0]['lastmod'];
			$sub_tpl['letzteaenderung'] = format_date($out[0]['lastmod'],"%d.%m.%Y %H:%M:%S");
			$out[0]['lastmod2'] = format_date($out[0]['lastmod'],"r"); 
		}
		if (!empty($out[0]['parent_ID'])) {
			$parent_id			 = $out[0]['parent_ID'];
			$sub_tpl['parent_id']= $out[0]['parent_ID'];
		}
		if (isset($unterseite_id) && is_numeric($unterseite_id))$out[0]['Text'] = '';
		else {
			parse($out[0]['Text']);
			$sub_tpl['insdate']		= format_date($out[0]['insdate'],"%a, %d %b %Y %H:%M:%S ".gmt_offset());
			$sub_tpl['shortins']	= format_date($out[0]['insdate'],"%Y-%m-%d");
			$i = array('#PAGE_ID#','#PARENT_ID#','#INSDATE#');
			$o = array($page_id,$parent_id,$out[0]['insdate']);
			$out[0]['Text'] = str_replace($i,$o,$out[0]['Text']);
		}
		return $out[0];
	}
	if ($errors) {
		$sub_tpl['pagetitle'] = '404 Not Found'; $sub_tpl['description'] = '404 Not Found'; $error[404] = geterror(404);
		if ($notfound == 404)		header_location('home',404);
}	}
function chk_parse(&$content,$nop=false,$bb=false,$click=false,$nl2br=false) {
	if (strpos($content,'<p>')===0 || strpos($content,'&lt;p&gt;')===0)	parse($content);
	else																parse($content,$nop,$bb,$click,$nl2br);
}
function parse(&$content,$nop=false,$bb=false,$click=false,$nl2br=false) {
	$content = trim($content,"\n");
	if(!empty($content)) {
		$content = stripslashes($content);
		if(strpos($content,'<')!==0)$content = html_entity_decode($content);
		if($bb!==false)				$content = nl2br($content);
		if($click!==false)			make_clickable($content,$nop);
		if($bb!==false)				bbcode($content,$nop);
		else						bb2html($content);
		$content = preg_replace_callback("'\<(a|iframe) (.*)\>(.*)\<\/(a|iframe)\>'Umsi","url",$content);
#		$content = preg_replace_callback("'\<iframe (.*)\>(.*)\<\/iframe\>'Umsi","url",$content);
		$content = preg_replace_callback('!\[([a-z]+?)\]!U',"smily",$content);
		$content = str_replace (" />\n<h"," /></p>\n<h",$content);
		$content = str_replace (' /><br />',' />',$content);
		$content = str_replace ('<p><hr /></p>','<hr />',$content);
}	}
function url($data) {
	global $tplobj,$url_ids,$vorgaben,$sub_tpl;
	if (empty($data[2]))	$data[2] = current($data);
	preg_match_all("#(\w+)=['\"]{1}([^'\"]*)#", $data[2], $matches2);
	foreach($matches2[1] as $key => $val) $link[$val] = $matches2[2][$key];
	if (!empty($link['href']) || !empty($link['src'])) {
		if (!empty($link['href']))	$src = $link['href'];
		else						$src = $link['src'];
		$src = str_replace(array('&','#AMP#'),array("&amp;","&amp;"),$src);
		if (strpos($src,"downloads")!==false || strpos($src,"http")===0 || strpos($src,"https")===0) {
			$link['target'] = '_blank';
			if (empty($link['rel']) && strpos($src,"http")===0) {
				$link['rel'] = 'external';
				if (!empty($link['title']))		$link['title'] = url_protocol($src,false).' - '.$link['title'];
				else							$link['title'] = url_protocol($src,false);
				if (!empty($sub_tpl['extern']))	$link['title'] .= ' - ['.$sub_tpl['extern'].']';
			}
			if (empty($link['rel']) && strpos($src,"downloads")!==false)	$link['rel'] = 'download';
		}
		if (empty($link['class']) || (strpos($link['class'],'nolink')===false && strpos($link['class'],'novid')===false)) {
			if (empty($vorgaben['videox']))	$link['videox'] = 400;
			else							$link['videox'] = $vorgaben['videox'];
			if (empty($vorgaben['videoy']))	$link['videoy'] = 300;
			else							$link['videoy'] = $vorgaben['videoy'];
			if (strpos($src,'search')===false && (strpos($src,'youtube.com')!==false || strpos($src,'youtube-nocookie.com')!==false || strpos($src,'youtu.be')!==false)) {	// Youtube videos
				if (strpos($src,"v=")!==false) {
					$link['code']  = betweenstr($src,'v=','&');
					$link['titel'] = $data[3];
				} elseif(strpos($src,"/embed/")!==false) {							// Youtube video with short link
					$link['code']  = betweenstr($src,'/embed/','?');
					$link['titel'] = $data[3];
				} elseif(strpos($src,".be/")!==false) {								// Youtube video with short link
					$link['code']  = betweenstr($src,'.be/','?');
					$link['titel'] = $data[3];
		/*		} elseif(strpos($src,"/channel/")!==false) {						// Youtube channel (new)
					$link = array_merge($link,youtubechannel(endstr($src,'/channel/')));
					$link['titel'] = $data[2];
				} elseif(strpos($src,"/user/")!==false) {							// Youtube channel (old or custom)
					$link = array_merge($link,youtubechannel(endstr($src,'/user/')));
					$link['titel'] = $data[2];
		*/		}
				if (!empty($link['code'])) return videourl($link);
			} elseif (strpos($src,"myvideo.de")!==false && !empty($sub_tpl['myvideo'])) {	// Myvideos
				$link['titel'] = $data[3];
				$link['code'] = betweenstr($src,'watch/','?');
				return $tplobj->array2tpl($sub_tpl['myvideo'],$link,'#');
			} elseif (strpos($src,".mp3")!==false) {										// MP3
				if (empty($sub_tpl['mp3']))	$sub_tpl['mp3'] = '<p><a href="#URL#">#TITEL#</a><br />
<audio controls>
  <source src="#URL#" type="audio/mpeg">
  <object type="application/x-shockwave-flash" data="http://flash-mp3-player.net/medias/player_mp3_maxi.swf" width="200" height="20">
	<param name="movie" value="http://flash-mp3-player.net/medias/player_mp3_maxi.swf" />
	<param name="bgcolor" value="#ffffff" />
	<param name="FlashVars" value="mp3=#URL#&showvolume=1" />
  </object>
</audio>
</p>
';
				$mp3_tpl = $sub_tpl['mp3'];
				$x = url_protocol(domain('*').$vorgaben['sub_dir']);
				$src = $x.$src;
				if (strpos($src,'|')!==false) {
					$mp3_tpl = $sub_tpl['mp3_multi'];
					$src = str_replace('|/','|'.$x.'/',$src);
				}
				if (empty($url_ids))		$url_ids['mp3'] = 0;
				else						$url_ids['mp3']++;
				return str_replace(array('#TITEL#','#URL#','#ID#'),array($data[2],$src,$url_ids['mp3']),$mp3_tpl);
		}	}
		unset($link['videox'],$link['videoy']);
		return '<a '.key_implode($link).'>'.$data[3].'</a>';
	}
	return '<a '.$data[1].'>'.$data[3].'</a>';
}
function youtubechannel($channel) {
	global $vorgaben,$tplobj,$sub_tpl;
	$content = file_get_contents('https://gdata.youtube.com/feeds/api/users/'.$channel.'/uploads?max-results=1');
	preg_match("#\<title type\='text'\>(.+)\<\/title\>#U",$content,$title);
	preg_match("#v\/(.+)\?#U",$content,$code);
	$data['title'] = $title[1];
	$data['code']  = $code[1];
	return $data;
}
function videourl($data='') {
	global $vorgaben,$tplobj,$sub_tpl;
	if (!empty($data)) {
		$data['src'] = false;
		$tpl = '';
		$data = videocode($data);
		if (!empty($data['code'])) {
		#	if (!empty($data['class']) && strpos($data['class'],'autoplay')!==false) $data['code']  .= '&autoplay=1';
			if (!empty($vorgaben['videox']))$data['videox'] = $vorgaben['videox'];
			else							$data['videox'] = 320;
			if (!empty($vorgaben['videoy']))$data['videoy'] = $vorgaben['videoy'];
			else							$data['videoy'] = 230;
			if ($data['src']) {
				if (empty($sub_tpl['youtube']))	$sub_tpl['youtube'] = '#STRIPP#<iframe src="https://www.youtube-nocookie.com/embed/#CODE#" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>#STRIPP#';
				if (empty($sub_tpl['vimeo']))	$sub_tpl['vimeo']	= '#STRIPP#<iframe src="https://player.vimeo.com/video/#CODE#?dnt=1" frameborder="0" allow="autoplay; gyroscope; picture-in-picture" allowfullscreen></iframe>#STRIPP#';
				if (!empty($sub_tpl[$data['src']]))	$tpl = $sub_tpl[$data['src']];
			}
			return $tplobj->array2tpl($tpl,$data,'#');
}   }	}
function videocode($data='') {
	if (!empty($data)) {
	#	if(is_array($data)) 								$data = key($data).'='.current($data);
		$data['raw'] = current($data);
		if (strpos($data['raw'],"vimeo")!==false) {
			$data['src']	= "vimeo";
			$data['code']	= endstr($data['raw'],'/');
		#	preg_match("/^(?:http(?:s)?:\/\/)?(?:player\.)?(?:vimeo\.com\/(?:(?:video)?\/))([^\?&\"'>]+)/", $data, $matches);
		#	if (!empty($matches[1])) return $matches[1];
		#	else return false;
		}
		if (strpos($data['raw'],"youtu")!==false) {
			$data['src']	= "youtube";
			preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $data['raw'], $matches);
			if (!empty($matches[1])) $data['code'] = $matches[1];
			else return false;
		}
		if (!empty($data['code']))	return $data;
	}
	return false;
}
function soundcloud($data) {
	if (!empty($data['url']) && strpos($data['url'],'%')===false) {
		//Get the JSON data of song details with embed code from SoundCloud oEmbed
		$getValues=@file_get_contents('http://soundcloud.com/oembed?format=json&url='.$data['url'].'&iframe=true');
		$jsonObj = json_decode($getValues);
		//Change the height of the embed player if you want else uncomment below line
		if (!empty($jsonObj->html)) {
			$jsonObj->html = str_replace(array('height="450"','width="100%"'),array('height="150"','width="300" style="float:left"'), $jsonObj->html);
			return $jsonObj->html;
	}	}
	return false;
}
function smily($string) {
	global $vorgaben;
	$file = strtolower($string[1]);
	if  (is_file($vorgaben['base_dir'].'/images/smilies/'.$file.'.gif')) $string[0] = str_replace('['.$string[1].']','<img src="/images/smilies/'.$file.'.gif" alt="'.$file.'" />', $string[0]);
	elseif (!empty($vorgaben['grp__cms']) && is_file($vorgaben['grp__cms'].'/images/smilies/'.$file.'.gif')) $string[0] = str_replace('['.$string[1].']','<img src="/images/smilies/'.$file.'.gif" alt="'.$file.'" />', $string[0]);
	elseif (!empty($vorgaben['base_cms']) && is_file($vorgaben['base_cms'].'/images/smilies/'.$file.'.gif')) $string[0] = str_replace('['.$string[1].']','<img src="/images/smilies/'.$file.'.gif" alt="'.$file.'" />', $string[0]);
	return $string[0];
}
function code($string) {
	return '<pre>'.str_replace("</p>","\n",str_replace("<p>","\n",str_replace("<br />","",$string[1]))).'</pre>';
}
function bbcode(&$string,$nop=false) {
	if ($nop)	$string = nl2br($string);
	else		autop($string);
	bb2html($string);
	$string = str_replace('&amp;#','&#',$string);
}
function bb2html(&$text) {
	$bbcode = array(
				'!\[Zitat\](.*)\[\/Zitat\]!isU',
				'!\[cite\](.*)\[\/cite\]!isU',
				'!\[big\](.*)\[\/big\]!isU', 			'!\[h\](.*)\[\/h\]!isU',		  '!\[b\](.*)\[\/b\]!isU',
				'!\[d\](.*)\[\/d\]!isU',				'!\[i\](.*)\[\/i\]!isU',		  '!\[u\](.*)\[\/u\]!isU',
				'!\[sup\](.*)\[\/sup\]!isU',			'!\[sub\](.*)\[\/sub\]!isU',	  '!\[(small|klein)\](.*)\[\/(small|klein)\]!isU',
				'!\[links\](.*)\[\/links\]!isU',		'!\[rechts\](.*)\[\/rechts\]!isU','!\[center\](.*)\[\/center\]!isU',
				'!\[color=(.*)\](.*)\[\/color\]!isU',	'!\[pre\](.*)\[\/pre\]!isU',	  '!\[url=(.*)\](.*)\[\/url\]!isU',
				'!\[br\/]!isU',							'!\[hr\/]!isU');
	$htmlcode = array(
				'<cite>$1</cite>',
				'<cite>$1</cite>',
				'<span class="big">$1</span>',			'<h3>$1</h3>',					 '<span class="bolder">$1</span>',
				'<span class="strikethrough">$1</span>','<span class="italic">$1</span>','<span class="underline">$1</span>',
				'<span class="hoch">$1</span>',			'<span class="tief">$1</span>',	 '<span class="small">$2</span>',
				'<span class="links">$1</span>',		'<span class="rechts">$1</span>','<span class="center">$1</span>',
				'<span style="color:$1">$2</span>',		'<pre>$1</pre>',				 '<a href="$1">$2</a>',
				"<br style=\"clear:both;\"/>",	 		"<hr style=\"clear:both;\"/>");
	$text = preg_replace($bbcode, $htmlcode, $text);
}
function table($string) {
	$string = str_replace("</p>","\n",str_replace("<p>","\n",str_replace("<br />","",$string)));
	if (strpos($string,"\t")!==false) {
		$x=1;
		$lines = explode("\n",$string);
		foreach ($lines as $line) {
			$tds = array_filter(explode("\t",$line));
			if (empty($tds[0])) $tds[0] = ' ';
			$tds = array_filter($tds);
			if (count($tds) > $x)  $x = count($tds);
			if (count($tds) == 1)
				$newline[] = "<td class=\"first_td\" colspan=\"|X|\">".$tds[0]."</td>";
			else
				$newline[] = "<td class=\"first_td\">".implode("</td><td>",$tds)."</td>";
	}	}
	if (!empty($newline[0])) {
		$string = str_replace('|X|',$x,"<table class=\"table\"><tr>".implode("</tr><tr>",$newline)."</tr></table>");
	}
	return $string;
}
function make_clickable(&$txt) {
   $txt = str_remove($txt,'§SID§');
   $txt = preg_replace('#([^\w=+;%?/]|^)(\w+[\w.-]*\w+@\w+[\w.-]*\w+\.[a-z]{2,4})#i', '$1<a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;$2">$2</a>', $txt);
   $txt = preg_replace_callback('#([^\w/@]|^)((?:www\.[\w-]+\.[\w-]+?\S*?)|(?:[a-z]{3,6}://\S+?))(?=[^a-z0-9/]*?(?:[\s<\][]|(?:&(?:quot|lt|gt);)|$))#i', 'create_link', $txt);
}
function create_link($m) {
	$pre = str_replace("\'", "'", $m[1]);	// these 2 lines fix any apostrophes that get messed up by being passed to the function
	$url = str_replace("\'", "'", $m[2]);
	$suf = '';
	if (preg_match('/&amp$/', $url)) {
		$suf = '&amp';
		$url = substr($url, 0, -4);
	}
	$html_url = $url;
	if (!preg_match('#^[a-z]{3,6}://#i', $html_url))		$html_url = "http://$url";
	if (preg_match('#(webp|gif|jpg|jpeg|png)$#i', $html_url))	$out = '<img class="bild" src="'.$html_url.'" alt="" /><a class="small cb" href="'.$html_url.'" rel="nofollow" target="_blank">'.$url.'</a>';
	else													$out = $pre.'<a href="'.$html_url.'" rel="nofollow" target="_blank">'.$url.'</a>'.$suf;
	return $out;
}
function autop(&$string, $nop = false) {
	if (strpos($string, '<nowpautop>') !== false) $string = preg_replace('!<nowpautop>(.*?)</nowpautop>!ise', "preserveP('$0')", $string);
	$string = $string . "\n"; 																// just to make things a little easier, pad the end
	$string = preg_replace('|<br />\s*<br />|', "\n\n", $string);							// Space things out a little
	$allblocks = '(?:table|thead|tfoot|caption|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|blockquote|address|math|style|script|input|p|h[1-6])';
	$string = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $string);
	$string = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $string);
	$string = str_replace(array("\r\n", "\r"), "\n", $string); 								// cross-platform newlines
	$string = preg_replace("/\n\n+/", "\n\n", $string); 									// take care of duplicates
	$string = preg_replace('/\n?(.+?)(?:\n\s*\n|\z)/s', "<p>$1</p>\n", $string); 			// make paragraphs, including one at the end
	$string = preg_replace('|<p>\s*?</p>|', '', $string); 									// under certain strange conditions it could create a P of entirely whitespace
	$string = preg_replace( '|<p>(<div[^>]*>\s*)|', "$1<p>", $string );
	$string = preg_replace('!<p>([^<]+)\s*?(</(?:div|address|form)[^>]*>)!', "<p>$1</p>$2", $string);
	$string = preg_replace( '|<p>|', "$1<p>", $string );
	$string = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $string); 	// don't pee all over a tag
	$string = preg_replace("|<p>(<li.+?)</p>|", "$1", $string); 							// problem with nested lists
	$string = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $string);
	$string = str_replace('</blockquote></p>', '</p></blockquote>', $string);
	$string = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $string);
	$string = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $string);
	if (!$nop) {
		$string = preg_replace_callback('/<(script|style).*?<\/\\1>/s', 'PreserveNewline', $string);
		$string = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $string); 					// optionally make line breaks
		$string = str_replace('<PreserveNewline />', "\n", $string);
	}
	$string = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $string);
	$string = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $string);
	if ( strstr( $string,'<pre' ))					$string = preg_replace('!(<pre.*?>)(.*?)</pre>!ise', " stripslashes('$1') .  stripslashes(clean_pre('$2'))  . '</pre>' ", $string);
	if (strpos($string,'<nowpautop>') !== false)	$string = preg_replace('!<nowpautop>(.*?)</nowpautop>!ise'," ".stripslashes(revertP(stripslashes(clean_pre('$1',0))))." ", $string);
	$string = preg_replace( "|\n</p>$|",'</p>',$string);
}
### Parameter $p_newline hinzugefügt
function PreserveNewline($text) {
	return str_replace("\n", "<PreserveNewline />", $text[0]);
}
function clean_pre($text,$p_newline = 1) {
	$text = str_replace('<br />', '', $text);
	if ($p_newline)	$text = str_replace('<p>', "\n", $text);
	else			$text = str_replace('<p>', "", $text);
	$text = str_replace('</p>', '', $text);
	return $text;
}
function preserveP($text) {
	return str_replace(array('<br />','<p>','</p>'),array('<WPpreservebr />','<WPpreservep>','</WPpreservep>'),$text);
}
function revertP($text) {
	return str_replace(array('<WPpreservebr />','<WPpreservep>','</WPpreservep>'),array('<br />','<p>','</p>'),$text);
}
function n_nl2li($string) {
	return nl2li($string,"ol");
}
function nl2li($string,$tag="ul") {
	$string = $string[1];
	$string = str_replace("\r","",$string);
	$string = "<$tag><li>".$string."</li></$tag>";
	$string = str_replace("\n[*]","</li><li>",$string);
	$string = str_replace("<li>[*]","<li>",$string);
	return $string;
}
?>