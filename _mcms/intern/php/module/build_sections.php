<?php
function get_daten($data) {
	return get_data($data);
}
function get_data($data) {
	global $all_data,$dbobj,$vorgaben;
	$default = array('PAGE_ID'=>'','LANG_ID'=>'','id'=>'','feld'=>'','pos_lt'=>'','pos_gt'=>'','key'=>'byid','visibility'=>'1','clear'=>false,'bypos'=>false,'as_array'=>false,'order_by'=>'');
	if (!empty($data) && is_string($data))										$data['PAGE_ID'] = $vorgaben[$data];
	elseif (!empty($data['PAGE_ID']) && !empty($vorgaben[$data['PAGE_ID']]))	$data['PAGE_ID'] = $vorgaben[$data['PAGE_ID']];
	extract(merge_defaults_user($default,$data,'PAGE_ID'),EXTR_SKIP);
	if (!empty($feld) && empty($key) && strpos($feld,',')===false)				$key='as_array';
	if (!empty($PAGE_ID) && !empty($vorgaben[$PAGE_ID]))						$PAGE_ID = &$vorgaben[$PAGE_ID];
	if (empty($all_data[$PAGE_ID]) || $clear)									$all_data[$PAGE_ID] = get_vorlage(array('PAGE_ID'=>$PAGE_ID,'lang_id'=>$LANG_ID,$key=>true,'pos_lt'=>$pos_lt,'pos_gt'=>$pos_gt,'bypos'=>$bypos,'field'=>$feld,'as_array'=>$as_array,'visibility'=>$visibility,'order_by'=>$order_by));
	if (isset($id) && !empty($feld) && isset($all_data[$PAGE_ID][$id][$feld]))	return $all_data[$PAGE_ID][$id][$feld];
	elseif (isset($id) && isset($all_data[$PAGE_ID][$id]))						return $all_data[$PAGE_ID][$id];
	else																		return $all_data[$PAGE_ID];
}
function get_sections($data) {
	global $dbobj,$tplobj,$lang_id,$sub_tpl,$vorgaben,$sections;
	$vorgaben['is_preview']=false;
	$default = array('PAGE_ID'=>'','LANG_ID'=>$lang_id,'KEY'=>'','nocache'=>false,'LIMIT'=>'','VISIBILITY'=>'1','ONCHANGE'=>'','FELD'=>'','SUBKEYS'=>'','anz'=>-1,'TEMPLATE'=>'','IFGT'=>'','CONCAT2'=>'§UND§','CONCAT1'=>', ');
	extract(merge_defaults_user($default,$data),EXTR_SKIP);
	if (is_numeric($IFGT) && is_numeric($KEY) && $IFGT >= $KEY) 	return '';
	if ($KEY !== '')	$keys = explode(',',$KEY);
	if (strpos($SUBKEYS,':')!==false) {
		$subkeys = explode(',',$SUBKEYS);
		foreach ($subkeys as $kv) {
			list($x,$y) = explode(':',$kv);
			if (isset($y))	$subselects[$x] = $y;
	}	}
/*	elseif (isset($keys) && !empty($subkeys[0])) {
			foreach ($keys as $k)	$subselects = array_combine(array_pad($keys,count($subkeys),0),array_pad($subkeys,count($keys),0));
	}	}
*/	if (!$nocache || empty($sections[$PAGE_ID])) {
		$sections[$PAGE_ID] = get_vorlage(array('PAGE_ID'=>$PAGE_ID,'byid'=>true,'anz'=>$anz,'field'=>$FELD,'visibility'=>$VISIBILITY,'template'=>$TEMPLATE));
	}
	if (!empty($sections[$PAGE_ID])) {
		if (!empty($keys)) {
			foreach ($keys as $k) {
				if (!empty($subselects) && !empty($subselects[$k])) $sections[$PAGE_ID][$k] = str_replace('SUBKEY',$subselects[$k],$sections[$PAGE_ID][$k]);
				if (!empty($sections[$PAGE_ID][$k]))				$s[$k] = $sections[$PAGE_ID][$k];
			}
			if (!empty($s))	return implode_ws($s,$CONCAT2,$CONCAT1);
		} elseif (!empty($sections[$PAGE_ID][$KEY])) {
			return $sections[$PAGE_ID][$KEY];
		} elseif ($KEY == '' && !empty($sections[$PAGE_ID])) {
			return implode_ws($sections[$PAGE_ID],$CONCAT2,$CONCAT1);
		}
}	}
function select_sections($p) {
	global $dbobj,$tplobj,$lang_id,$sub_tpl,$vorgaben;
	if (is_array($p))	$p = array_change_key_case($p,CASE_LOWER);
	else				$p['PAGE_ID'] = $p;
	$p['errors'] = false;
	if (empty($p['feld']) && !empty($p['field']))	$p['feld']	= $p['field'];
	if (!empty($p['page_id']))						$p['PAGE_ID'] = $p['page_id'];
	if (!empty($p['part_id']))						$p['PART_ID'] = $p['part_id'];
	if (!empty($p['tpl_id']))						$p['TPL_ID']  = $p['tpl_id'];
	if (!empty($p['type']))							$p['TYPE']	= $p['type'];
	else											$p['TYPE']	= 'checkbox';
	unset($p['page_id'],$p['part_id'],$p['tpl_id'],$p['type']);
	if (!empty($p['addselect']) && isset($_REQUEST[$p['addselect']])) {
		$p['first'] = trim($_REQUEST[$p['addselect']],"'");
		$p['byid']  = true;
		$tmp = get_vorlage($p);
		if ($tmp && is_array($tmp))$_REQUEST[$p['key']][$p['feld']] = key($tmp);
	}
	if (!empty($p['limitby'])) {
		if (!empty($p['usekey'])) {
			$p['PART_ID'] = explode(',',$p['usekey']);
		} elseif (!empty($p['feld']) && $extraids = $dbobj->exists(__file__,__line__,'SELECT DISTINCT '.$p['feld'].' FROM #PREFIX#'.$p['limitby'].' WHERE '.$p['feld'].' > 0;')) {
			$p['PART_ID'] = explode(',',r_implode($extraids));
		} else {
			return '<input disabled="disabled" value="%%AUSWAHL_NICHT_MOEGLICH%%" />';
	}	}
	$p['byid'] = true;
	$p['set_visibilities'] = true;
	$sections = get_vorlage($p);
	if ($sections) return switch_type($p,$sections);
}
function get_templates($data,$prefix=true,$suffix=true) {
	global $tplobj,$dbobj,$parent_id,$page_id;
	if  (!isset($data['visibility'])) $data['visibility']=1;
	$sql = "SELECT		PAGE_ID,TPL_ID FROM #PREFIX#seiten_attr,#PREFIX#kategorien
			WHERE		#PREFIX#seiten_attr.visibility IN (".$data['visibility'].")";
	if (!empty($data['TPL_ID']))	$sql .= "\nAND #PREFIX#seiten_attr.TPL_ID  IN (".r_implode($data['TPL_ID']).")";
	if (!empty($data['PAGE_ID'])) {
		if (is_numeric($data['PAGE_ID']))			$sql .= "\nAND #PREFIX#seiten_attr.PAGE_ID IN (".r_implode($data['PAGE_ID']).")";
		elseif ($data['PAGE_ID']=='page_ID')		$sql .= "\nAND #PREFIX#seiten_attr.PAGE_ID IN (".$page_id.")";
		elseif ($data['PAGE_ID']=='parent_ID')		$sql .= "\nAND #PREFIX#seiten_attr.PAGE_ID IN (".$parent_id.")";
#		elseif (!empty(...)							$sql .= "\nAND #PREFIX#seiten_attr.PAGE_ID IN (".$page_id.")";
	}
	if (!empty($data['PARENT_ID'])) {
		if (is_numeric($data['PARENT_ID']))			$sql .= "\nAND #PREFIX#seiten_attr.parent_ID IN (".r_implode($data['PARENT_ID']).")";
		elseif ($data['PARENT_ID']=='page_ID')		$sql .= "\nAND #PREFIX#seiten_attr.parent_ID IN (".$page_id.")";
		elseif ($data['PARENT_ID']=='parent_ID')	$sql .= "\nAND #PREFIX#seiten_attr.parent_ID IN (".$parent_id.")";
	}
	$sql .="\nAND		#PREFIX#seiten_attr.visibility IN (".$data['visibility'].")
			AND			#PREFIX#kategorien.visibility  IN (".$data['visibility'].")
			AND			#PREFIX#seiten_attr.KAT_ID  = #PREFIX#kategorien.KAT_ID";
	$sql .= sql_kat_status();
	$sql .= "\nGROUP BY PAGE_ID ORDER BY #PREFIX#kategorien.position,#PREFIX#kategorien.KAT_ID,#PREFIX#seiten_attr.lft ASC";
	unset($data['PARENT_ID'],$data['TPL_ID']);
	if ($pages = $dbobj->withkey(__file__,__line__,$sql.';','PAGE_ID')) {
		foreach ($pages as $data['PAGE_ID'] => $data['TPL_ID']) {
			$out[] = get_vorlage($data,$prefix,$suffix);
		}
		return implode("\n",$out);
}	}
function get_pos_by_partid($page_ID,$part_id=false) {
	global $dbobj;
	$sql = "SELECT PART_ID,position FROM #PREFIX#abschnitte WHERE PAGE_ID = ".$page_ID.";";
	if ($pos_array = $dbobj->withkey(__file__,__line__,$sql,'PART_ID',true)) {
		if ($part_id && $part_id == !empty($pos_array[$part_id]))
			return $pos_array[$part_id];
		else
			return $pos_array;
	}
	return  false;
}
function get_first_bykn($kn) {
	global $dbobj;
	$sql = "SELECT	#PREFIX#seiten_attr.first
					FROM 		#PREFIX#seiten,#PREFIX#abschnitte
					WHERE 		#PREFIX#seiten.Kurzname = ".$dbobj->escape($kn)."
					AND			#PREFIX#abschnitte.PAGE_ID 		= #PREFIX#seiten.PAGE_ID;";
	if ($first = $dbobj->tostring(__file__,__line__,$sql)) 
		return $string;
	return  false;
}
function get_vorlage($data,$prefix=true,$suffix=true) {
	global $tplobj,$dbobj,$page_id,$lang_id,$first_lang_id,$sub_tpl,$unterseite,$unterseite_id,$vorgaben,$parent_id,$error,$notfound;
	$default = array('TPL_ID'=>0,'PAGE_ID'=>'','PARENT_ID'=>'','PART_ID'=>'','lang_id'=>$first_lang_id,'pos'=>'','anz'=>'','limit'=>'','seperator' => '%',
					'field'=>'','first'=>'','template'=>'','range'=>'','sub_key'=>'','concat' => '','random'=>false,
					'byid'=>false,'bypos'=>false,'as_array'=>false,'visibility'=>1,'visi_parts'=>false,'visi_chk'=>false,'set_visibilities'=>false,
					'set_vg'=>true,'set_sub_tpl'=>false,'use_js'=>true,'use_css'=>true,'filter_fct'=>'',
					'pos_lt'=>'','pos_gt'=>'','order_by'=>'','bydate'=>'','pubdate'=>'','tf'=>'','add'=>'','nop'=>true,
					'errors'=>true,'ifuid'=>false,'paginate'=>false,'addextra'=>false,'showanyway'=>false,
					'filter_by_content'=>'','filter_content'=>true);
	extract(merge_defaults_user($default,$data,'TPL_ID'),EXTR_SKIP);
	if (isset($PART_ID) && $PART_ID=='REQUEST') {
		if (!empty($_REQUEST[$REQUEST]) && is_numeric($_REQUEST[$REQUEST]))	$PART_ID = $_REQUEST[$REQUEST];
		elseif (!empty($REQUEST) && !empty($sub_tpl['no_'.$REQUEST]))		return $sub_tpl['no_'.$REQUEST];
		else																return false;
	}
	if (!empty($PAGE_ID)){
		if (!is_numeric($PAGE_ID) && !empty($sub_tpl[$PAGE_ID]))		$PAGE_ID = trim($sub_tpl[$PAGE_ID]);
		elseif (!is_numeric($PAGE_ID) && !empty($vorgaben[$PAGE_ID]))	$PAGE_ID = trim($vorgaben[$PAGE_ID]);
		elseif ($PAGE_ID == 'page_ID')									$PAGE_ID = $page_id;
		elseif ($PAGE_ID == 'parent_ID')								$PAGE_ID = $parent_id;
		$sql = " ,#PREFIX#seiten,#PREFIX#seiten_attr WHERE #PREFIX#seiten.PAGE_ID = '".$PAGE_ID."' AND #PREFIX#seiten_attr.PAGE_ID = #PREFIX#seiten.PAGE_ID AND #PREFIX#vorlagen.TPL_ID = #PREFIX#seiten_attr.TPL_ID";
	} elseif (!empty($TPL_ID)) {
		if (!is_numeric($TPL_ID) && !empty($vorgaben[$TPL_ID]))		$TPL_ID  = $vorgaben[$TPL_ID];
		$sql = " LEFT JOIN (#PREFIX#seiten_attr) ON (#PREFIX#vorlagen.TPL_ID = #PREFIX#seiten_attr.TPL_ID) WHERE #PREFIX#vorlagen.TPL_ID > 0 AND #PREFIX#vorlagen.TPL_ID = ".$TPL_ID;
	} else {
		$sql = " ,#PREFIX#seiten,#PREFIX#seiten_attr WHERE #PREFIX#seiten.PAGE_ID = '".$page_id."' AND #PREFIX#seiten_attr.PAGE_ID = #PREFIX#seiten.PAGE_ID AND #PREFIX#vorlagen.TPL_ID = #PREFIX#seiten_attr.TPL_ID";
	}
	if (!empty($sql))				$vorlagen = $dbobj->withkey(__file__,__line__,"SELECT #PREFIX#vorlagen.*,#PREFIX#seiten_attr.PAGE_ID,#PREFIX#seiten_attr.order_by FROM #PREFIX#vorlagen".$sql.' LIMIT 1;','TPL_ID');
	elseif ($errors)				{$error[] = '%%VORLAGE_NICHT_GEFUNDEN%% (TPL: '.$TPL_ID.', PAGE: '.$PAGE_ID.')'; return false;}
	else							return false;
	if (empty($notfound) && !empty($vorlagen) && is_array($vorlagen)) {
		$current = current($vorlagen);
		if (!empty($template)) {
			if(!empty($sub_tpl[$template])) $current['Template'] = $sub_tpl[$template];
			else							$current['Template'] = $template;
			$current['Template'] = str_replace('$PAGE_ID$',$PAGE_ID,$current['Template']);
			$current['Titel']	= $template;
			$seperator = '$,*';
			$addextra = true;
		} elseif (!empty($field)) {
			$current['Titel']	= $field;
			$current['Template'] = $seperator.implode($seperator.'&&&'.$seperator,explode(',',strtoupper($field))).$seperator;
		}
		if (empty($TPL_ID))		$TPL_ID	 = $current['TPL_ID'];
		$vorlage_tpl			= trim($current['Template']);
		$sub_tpl['tpl_title']	= $current['Titel'];
		$sub_tpl['tpl_id']		= $TPL_ID;
		if (empty($PAGE_ID) && !empty($current['PAGE_ID']))		$PAGE_ID					= $current['PAGE_ID'];
		elseif (empty($PAGE_ID) && !empty($TPL_ID))				$PAGE_ID					= $dbobj->tostring(__file__,__line__,"SELECT PAGE_ID FROM #PREFIX#seiten_attr WHERE #PREFIX#seiten_attr.TPL_ID = ".$TPL_ID);
		elseif (isset($PAGE_ID) && !empty($vorgaben[$PAGE_ID]))	$PAGE_ID					= $vorgaben[$PAGE_ID];
		if ($current['TPL_ID'] == $vorgaben['seiten_tpl'])		$vorgaben['alle_Seiten']	= $current['PAGE_ID'];
		if (empty($order_by) && !empty($current['order_by']))	$order_by					= $current['order_by'];
		if (($set_vg==true && empty($vorgaben['VorschauY'])) || $set_vg=='overwrite') {
			if (!empty($current['VorschauY']))  				$vorgaben['vorschauy']		= &$current['VorschauY'];
			if (!empty($current['VorschauX']))  				$vorgaben['vorschaux']		= &$current['VorschauX'];
			if (!empty($current['vorschaufixed']))				$vorgaben['vorschaufixed']	= &$current['vorschaufixed'];
			if (!empty($current['BildY'])) 						$vorgaben['bildy']			= &$current['BildY'];
			if (!empty($current['BildX']))  					$vorgaben['bildx']			= &$current['BildX'];
			if (!empty($current['bildfixed']))				 	$vorgaben['bildfixed']		= &$current['bildfixed'];
		}
		if (!empty($current['bodyclass']))  					$vorgaben['bodyclass'] .= ' '.$current['bodyclass'];
		if ($use_css) {
			if (!empty($vorlagen[$lang_id]['styles']))			$sub_tpl['style'][] = $vorlagen[$lang_id]['styles'];
			elseif (!empty($current['styles']))					$sub_tpl['style'][] = $current['styles'];
			$current['CSS'] = trim($current['CSS']);
			if (!empty($current['CSS'])) {
				$add_CSS = explode_lines($current['CSS']);
				foreach($add_CSS as $css) 						$sub_tpl['CSS'][$css] = $css;
		}	}
		if ($use_js) {
			if (!empty($vorlagen[$lang_id]['script']))			$sub_tpl['addscript'][] = $vorlagen[$lang_id]['script'];
			elseif (!empty($current['script']))					$sub_tpl['addscript'][] = $current['script'];
			$current['JS'] = trim($current['JS']);
			if (!empty($current['JS'])) {
				$add_JS = explode_lines($current['JS']);
				foreach($add_JS as $js) 						$sub_tpl['JS'][$js] = $js;
		}	}
		if (!empty($sub_key)) {
			if (!empty($sub_tpl['style']))	{$sub_tpl['style'][$sub_key][]	= $sub_tpl['style'];}
			if (!empty($sub_tpl['CSS']))	{$sub_tpl['CSS'][$sub_key][]	= $sub_tpl['CSS'];}
		#	if (!empty($sub_tpl['script']))	{$sub_tpl[$sub_key]['script']	= $sub_tpl['script'];	unset($sub_tpl['script']);}
		#	if (!empty($sub_tpl['JS']))		{$sub_tpl[$sub_key]['JS']		= $sub_tpl['JS'];		unset($sub_tpl['JS']);	 }
		}
		preg_match_all("/".$seperator."([_a-z0-9- :\S\/\=\;]+)".$seperator."/Ui",$vorlage_tpl,$matches);
		$matches[0] = array_unique($matches[0]);
		$matches[1] = array_unique($matches[1]);
		foreach ($matches[1] as $k => $m) {
			if (strpos($m,':')!=false)	$vorlage_tpl = str_replace($seperator.$m.$seperator,$seperator.substr($m,0,strpos($m,':')).$seperator,$vorlage_tpl);
		}
		$out = '';
		if (!empty($PAGE_ID)) {
			if (!empty($bydate)) {
				if (!empty($startdate) && !empty($_REQUEST['startdate'])) {
					$date = $_REQUEST['startdate'];
					list($Y,$m,$d) = explode('-',$date);
				} else {
					if (empty($tf))	$tf= 'publish';
					$d = date("d");	$m = date("m");	$Y = date("Y");
					if (empty($add)) $add =0;
					switch($bydate) {
						case 'day':		$d = date("d")+$add;	break;
						case 'month':	$m = date("m")+$add; if ($m>12) {$m -=12; $Y += 1;}	break;
						case 'year':	$Y = date("Y")+$add;	break;
					}
					$date = date("Y-m-d",mktime(0,0,0,$m,$d,$Y));
				}
				if (!empty($range)) {
					$rm = $m+$range-1;
					$rY = $Y;
					if ($rm>12) {$rm -=12; $rY += 1;}
					$rm = str_pad($rm, 2, "0", STR_PAD_LEFT);
				}
			}
			if (!empty($PARENT_ID)){
				if (!is_numeric($PARENT_ID) && !empty($sub_tpl[$PARENT_ID]))		$PARENT_ID = trim($sub_tpl[$PAGE_ID]);
				elseif (!is_numeric($PARENT_ID) && !empty($vorgaben[$PARENT_ID]))	$PARENT_ID = trim($vorgaben[$PAGE_ID]);
				elseif ($PARENT_ID == 'page_ID')									$PARENT_ID = $page_id;
				elseif ($PARENT_ID == 'parent_ID')									$PARENT_ID = $parent_id;
			$sql = " ,#PREFIX#seiten,#PREFIX#seiten_attr WHERE #PREFIX#seiten_attr.parent_ID = '".$PARENT_ID."' AND #PREFIX#seiten_attr.PAGE_ID = #PREFIX#seiten.PAGE_ID AND #PREFIX#vorlagen.TPL_ID = #PREFIX#seiten_attr.TPL_ID";
	} 
			$sql = "SELECT	DISTINCT	#PREFIX#seiten_attr.parent_ID,#PREFIX#abschnitte.*,
										abschnitt.Content as Content_lang,abschnitt.first,
										#PREFIX#_languages.position AS lang_pos,
										#PREFIX#seiten_attr.person_ID,
								#PREFIX#seiten.AK,#PREFIX#seiten.Kurzname
					FROM 		#PREFIX#seiten,#PREFIX#seiten_attr,#PREFIX#_languages,#PREFIX#abschnitte
									LEFT JOIN (#PREFIX#abschnitte as abschnitt) ON (abschnitt.LANG_ID = '".$lang_id."' AND abschnitt.PART_ID = #PREFIX#abschnitte.PART_ID AND abschnitt.PAGE_ID = #PREFIX#abschnitte.PAGE_ID)
					WHERE ";
				if (!empty($PARENT_ID))	$sql .= "#PREFIX#seiten_attr.parent_ID IN ('".r_implode(explode(',',$PARENT_ID),"','")."')";
				else					$sql .= "#PREFIX#seiten_attr.PAGE_ID IN ('".r_implode(explode(',',$PAGE_ID),"','")."')";
				$sql .= "\n\t\t\t\tAND			#PREFIX#seiten_attr.PAGE_ID = #PREFIX#abschnitte.PAGE_ID
					AND			#PREFIX#seiten.PAGE_ID 		= #PREFIX#seiten_attr.PAGE_ID";
			if ($visi_parts)								$sql .= "\nAND  #PREFIX#abschnitte.visibility IN (".$visi_parts.")";
			if ($ifuid)										$sql .= "\nAND (#PREFIX#abschnitte.visibility IN (".$visibility.") OR #PREFIX#abschnitte.person_ID = '".uid()."')";
			else											$sql .= "\nAND	#PREFIX#abschnitte.visibility IN (".$visibility.")";
			if (!empty($lang_id) || !empty($first_lang_id))	$sql .= "\nAND	#PREFIX#abschnitte.LANG_ID 	  IN ('".$first_lang_id."','".$lang_id."')";
			if (!empty($first))								$sql .= "\nAND	#PREFIX#abschnitte.first	  IN ('".r_implode($first,"','")."')";
			if (isset($PART_ID) && !empty($PART_ID)) 		$sql .= "\nAND	#PREFIX#abschnitte.PART_ID	IN ('".r_implode($PART_ID,"','")."')";
			if (isset($pos) && $pos != '' && $pos != 'alle')$sql .= "\nAND	#PREFIX#abschnitte.position   IN (".$dbobj->escape($pos).")";
			if (isset($pos_lt) && is_numeric($pos_lt)) 		$sql .= "\nAND	#PREFIX#abschnitte.position	  < (".$pos_lt.")";
			if (isset($pos_gt) && is_numeric($pos_gt)) 		$sql .= "\nAND	#PREFIX#abschnitte.position	  > (".$pos_gt.")";
			$sql .= "\nAND #PREFIX#abschnitte.LANG_ID = #PREFIX#_languages.LANG_ID";
			if (!empty($date) && empty($startdate)) {
				if (!empty($range))	$sql .= "\nAND	#PREFIX#abschnitte.publish >= '".$Y."-".$m."-01' AND (#PREFIX#abschnitte.finish  <= '".$rY."-".$rm."-31' OR #PREFIX#abschnitte.finish <= '1970-01-01')";
				else				$sql .= "\nAND	#PREFIX#abschnitte.publish >= '".$date."' AND (#PREFIX#abschnitte.finish  <= '".$date."' OR #PREFIX#abschnitte.finish <= '1970-01-01')";
			} elseif (!empty($startdate)) {
				switch ($startdate) {
					case 'finish';	$sql .= "\nAND	#PREFIX#abschnitte.finish  >= '".$date."'";		break;
					case 'publish';	$sql .= "\nAND	#PREFIX#abschnitte.publish >= '".$date."'";		break;
					default:	$sql .= "\nAND	#PREFIX#abschnitte.publish >= '".$startdate."'";
							if (!empty($date)) $sql .= "\nAND	#PREFIX#abschnitte.publish >= '".$date."'";break;
				}
				if (!empty($enddate)) {
					if ($enddate = 'current')	$enddate = date("Y-m-d");
					if ($startdate != 'publish') $sql .= "\nAND	#PREFIX#abschnitte.publish <= '".$enddate."'";
				}
				if (!empty($range))	$sql .= "\nAND	#PREFIX#abschnitte.publish >= '".$Y."-".$m."-01' AND (#PREFIX#abschnitte.finish  <= '".$rY."-".$rm."-31' OR #PREFIX#abschnitte.finish = '1970-01-01')";
			} elseif (!empty($pubdate)) {
				$sql .= "\nAND	#PREFIX#abschnitte.publish <= '".$pubdate."' ";
			} else {
				$sql .= "\nAND	(#PREFIX#abschnitte.publish <= '1970-01-01' OR #PREFIX#abschnitte.publish = NULL OR #PREFIX#abschnitte.publish <= CURDATE())";
				$sql .= "\nAND	(#PREFIX#abschnitte.finish  <= '1970-01-01' OR #PREFIX#abschnitte.finish  = NULL OR #PREFIX#abschnitte.finish  >= CURDATE())";
			}
			if ($random)			$sql .= "\nORDER BY RAND()";
			elseif (!empty($order_by)) {
				switch($order_by) {
					case 'random';	$sql .= "\nORDER BY RAND()";	break;
					case 'P_ASC';	$sql .= "\nORDER BY	PART_ID,	 lang_pos";	break;
					case 'P_DESC';	$sql .= "\nORDER BY	PART_ID DESC,lang_pos";	break;
					case 'PO_ASC';	$sql .= "\nORDER BY	#PREFIX#abschnitte.position,	 abschnitt.first,#PREFIX#abschnitte.first,lang_pos,PART_ID";	break;
					case 'PO_DESC';	$sql .= "\nORDER BY	#PREFIX#abschnitte.position DESC,abschnitt.first,#PREFIX#abschnitte.first,lang_pos,PART_ID";	break;
					case 'AZ_ASC';	$sql .= "\nORDER BY	abschnitt.first,	 #PREFIX#abschnitte.first,	 #PREFIX#abschnitte.position,lang_pos,PART_ID";	break;
					case 'AZ_DESC';	$sql .= "\nORDER BY	abschnitt.first DESC,#PREFIX#abschnitte.first DESC,#PREFIX#abschnitte.position,lang_pos,PART_ID";	break;
					case 'PUB_ASC';	$sql .= "\nORDER BY	#PREFIX#abschnitte.publish,	 #PREFIX#abschnitte.position,abschnitt.first,#PREFIX#abschnitte.first,lang_pos,PART_ID";	break;
					case 'PUB_DESC';$sql .= "\nORDER BY	#PREFIX#abschnitte.publish DESC,#PREFIX#abschnitte.position,abschnitt.first,#PREFIX#abschnitte.first,lang_pos,PART_ID";	break;
					case 'FIN_ASC';	$sql .= "\nORDER BY	#PREFIX#abschnitte.finish,	  #PREFIX#abschnitte.position,abschnitt.first,#PREFIX#abschnitte.first,lang_pos,PART_ID";	break;
					case 'FIN_DESC';$sql .= "\nORDER BY	#PREFIX#abschnitte.finish DESC, #PREFIX#abschnitte.position,abschnitt.first,#PREFIX#abschnitte.first,lang_pos,PART_ID";	break;
			}	} else				$sql .= "\nORDER BY	#PREFIX#abschnitte.position,abschnitt.position,abschnitt.first,#PREFIX#abschnitte.first,lang_pos DESC";
			if (!empty($anz) && $anz > 0)			$sql .= "\nLIMIT ".$anz.";";
			elseif (!empty($limit) && $limit > 0)	$sql .= "\nLIMIT ".$limit.";";
			if ($parts_all = $dbobj->withkey(__file__,__line__,$sql,'PART_ID')) {
				if ($vorgaben['is_preview'] && !empty($_REQUEST['part_attr'])) {
			#	$x = array_diff_assoc($_REQUEST['part_attr'],$parts_all);   // Trows a 'Array to string in php 7.2
					foreach ($_REQUEST['part_attr'] as $k => $preview_data) {
						if (!empty($_REQUEST['abschnitt'][$k]) && cleanArray($_REQUEST['abschnitt'][$k])) {
							if (isset($preview_data['position']))										$parts_all[$k]['position']= $preview_data['position'];
							if (!empty($first['PAGE_ID']))												$parts_all[$k]['PAGE_ID']	= $first['PAGE_ID'];
							elseif	(!empty($_REQUEST['page_id']) && is_numeric($_REQUEST['page_id']))	$parts_all[$k]['PAGE_ID']	= $_REQUEST['page_id'];
							$parts_all[$k]['PART_ID']	= $k;
							if (isset($preview_data['rfirst']))		$parts_all[$k]['first']		= $preview_data['rfirst'];
							else									$parts_all[$k]['first'] 	= end($_REQUEST['abschnitt'][$k]);
							if (!empty($preview_data['position']))	$parts_all[$k]['position']	= $preview_data['position'];
							else									$parts_all[$k]['position']	= 99;
							if (isset($preview_data['publish']))	$parts_all[$k]['publish']	= $preview_data['publish'];
							elseif (isset($first['publish']))		$parts_all[$k]['publish']	= $first['publish'];
							if (isset($preview_data['finish']))		$parts_all[$k]['finish']	= $preview_data['finish'];
							elseif (isset($first['finish']))		$parts_all[$k]['finish']	= $first['finish'];
							else									$parts_all[$k]['finish']	= '';
							if (isset($preview_data['visibility']))	$parts_all[$k]['visibility']= $preview_data['visibility'];
							else									$parts_all[$k]['visibility']= 0;
					}	}
					foreach ($parts_all as $k => $data) {
						if (isset($_REQUEST['part_attr'][$k]['position']))	$parts_all[$k]['position'] = $_REQUEST['part_attr'][$k]['position'];
					}
				}
				$first = current($parts_all);
				$keys  = array_keys($parts_all);
				$count = count($keys);
				if (!empty($current['proseite']))	$sub_tpl['proseite'] = $current['proseite'];
				if ($paginate && empty($unterseite) && empty($anz) && !empty($current['proseite']) && $count>$current['proseite']) {
					paginate($parts_all,$current['proseite']);
				}	
		}	}
		if (!empty($parts_all) && is_array($parts_all)) {
			if (!empty($unterseite) && $unterseite_id>0 && isset($keys[$unterseite_id]) && !empty($parts_all[$keys[$unterseite_id-1]]) && empty($anz)) {
				$mykey  = &$keys[$unterseite_id-1];
				$mypart = &$parts_all[$mykey];
				$contents = work_contents($mypart,$nop);
				if ($img_exists = $dbobj->exists(__file__,__line__,"SELECT * FROM #PREFIX#bilder WHERE PAGE_ID = ".$PAGE_ID." AND Dateiname LIKE '%bild_%' AND PART_ID = ".$mykey)) {
					work_img($contents,$img_exists[0],$mypart['PAGE_ID'],$mykey);
				}
				$out = $vorlage_tpl;
				$tplobj->array2tpl2($out,$contents,$seperator);
			} elseif (!empty($unterseite) && !empty($unterseite_id) && !empty($parts_all[$unterseite_id]) && isset($first['PART_ID'])) {
				$mykey  = &$keys[$unterseite_id];
				$mypart = &$parts_all[$mykey];
				$contents = work_contents($mykey,$nop);
				if ($img_exists = $dbobj->exists(__file__,__line__,"SELECT #PREFIX#bilder.*,#PREFIX#abschnitte.PART_ID FROM #PREFIX#bilder,#PREFIX#abschnitte WHERE #PREFIX#bilder.PAGE_ID = ".$PAGE_ID." AND #PREFIX#abschnitte.LANG_ID = ".$lang_id." AND #PREFIX#bilder.PART_ID = #PREFIX#abschnitte.PART_ID;")) {
					work_img($contents,$img_exists[0],$mypart['PAGE_ID']);
				}
				$out = $vorlage_tpl;
				$tplobj->array2tpl2($out,$contents,$seperator);
			} elseif (isset($first['PART_ID'])) {
				$i = 1;
				$sql = 'SELECT *, FIELD(LANG_ID,'.$lang_id.") as SORTER  FROM #PREFIX#bilder  WHERE PAGE_ID IN ('".r_implode($PAGE_ID,"','")."') ORDER BY SORTER ASC;";
				if(!empty($lang_id))	$img_exists  = $dbobj->withkey(__file__,__line__,$sql,'PAGE_ID',true,'PART_ID','BILD_ID');
				$file_exists = $dbobj->withkey(__file__,__line__,"SELECT PAGE_ID,Dateiname,PART_ID,filekey FROM #PREFIX#dateien WHERE PAGE_ID IN ('".r_implode($PAGE_ID,"','")."');",'PAGE_ID',true,'PART_ID','filekey');
					if (!empty($_REQUEST['data_url'])) {
					foreach ($_REQUEST['data_url'] as $du_k => $du_v)	$img_exists[$du_k] = $du_v;
				}
				if ($random) shuffle($parts_all);
				elseif ($vorgaben['is_preview'] && !empty($_REQUEST['order_by'])) $parts_all = array_sort_by_column($parts_all,$_REQUEST['order_by']);
				$partcount = count($parts_all);
				foreach ($parts_all as &$abschnitt) {
					if ($vorgaben['is_preview'] && !empty($_REQUEST['data_url'][$abschnitt['PART_ID']])) {
						$img_exists[$abschnitt['PAGE_ID']][$abschnitt['PART_ID']]['data_url'] = current($_REQUEST['data_url'][$abschnitt['PART_ID']]);
						$img_exists[$abschnitt['PAGE_ID']][$abschnitt['PART_ID']]['data_url']['bildname'] = key($_REQUEST['data_url'][$abschnitt['PART_ID']]);
					}
					if ($set_visibilities) {
						if (!empty($abschnitt['visibility']))	$sub_tpl['set_visibilities'][$abschnitt['PART_ID']] = 1;
						else									$sub_tpl['set_visibilities'][$abschnitt['PART_ID']] = 0;
					}
					if (!$visi_chk || ($visi_chk && isset($_REQUEST['part_attr'])
									  && !empty($_REQUEST['part_attr'][$abschnitt['PART_ID']]['visibility'])
									  && $_REQUEST['part_attr'][$abschnitt['PART_ID']]['visibility'] == 1)) {
						$contents = work_contents($abschnitt,$nop);
						if (empty($filter_by_content) || !isset($contents[$filter_by_content]) || (empty($filter_content) && !empty($contents[$filter_by_content])) || (!empty($contents[$filter_by_content]) && $contents[$filter_by_content] == $filter_content)) {
							if (!empty($img_exists) && !empty($img_exists[$abschnitt['PAGE_ID']][$abschnitt['PART_ID']])) {
								foreach ($img_exists[$abschnitt['PAGE_ID']][$abschnitt['PART_ID']] as $img) {
									work_img($contents,$img,$abschnitt['PAGE_ID'],$abschnitt['PART_ID'],$dir='/thumbs/');
							}	}
							if (!empty($file_exists) && !empty($file_exists[$abschnitt['PAGE_ID']][$abschnitt['PART_ID']])) {
								foreach ($file_exists[$abschnitt['PAGE_ID']][$abschnitt['PART_ID']] as $filekey => $datei) {
									if (!empty($datei['Dateiname'])) {
										$fpath='/downloads/'.$datei['Dateiname'];
										if(is_file($vorgaben['base_dir'].$fpath)) {
											if (!$contents) unset($contents);
											$contents[$filekey] = $fpath;
										}
							}	}	}
							if (!empty($matches[1][0]) && !empty($abschnitt['pflicht'])) {
								$abschnitt['pflicht'] = explode(',',$abschnitt['pflicht']);
								foreach ($matches[1] as $feld) {
									if (in_array($feld,$abschnitt['pflicht'])) {
										if (empty($sub_tpl['pflichtfeld']))	{
											$vorlage_tpl = str_replace('="'.strtolower($feld).'"','="'.strtolower($feld).'" class="required"',$vorlage_tpl);
										#	$vorlage_tpl = str_replace('>'.$seperator.$feld.$seperator,' class="required">'.$seperator.$feld.$seperator,$vorlage_tpl);
										} else {
											$vorlage_tpl = str_replace($seperator.$feld.$seperator,$seperator.$feld.$seperator.$sub_tpl['pflichtfeld'],$vorlage_tpl);
										}
										$vorlage_tpl = str_replace(array('#'.$feld.'#"','>#'.$feld.'#'),array('#'.$feld.'#" required="required"',' required="required">#'.$feld.'#'),$vorlage_tpl);
										$sub_tpl['required_field'][] = strtolower($feld);
							}	}	}
							$abschnitt['unterseite_id'] = $unterseite_id;
							if (empty($contents['part_id'])) {
								if (!$contents)	unset($contents);
								$contents['part_id'] = $abschnitt['PART_ID'];
							}
							$contents['page_id'] = $abschnitt['PAGE_ID'];
							$contens_as_array[$abschnitt['PART_ID']] = $contents;
							if (empty($abschnitt['publish']))		$abschnitt['publish'] = format_date(date("Y-m-d H:i:s"),  "%a, %d %b %Y %H:%M:%S ".gmt_offset());
							$contens_as_array[$abschnitt['PART_ID']]['publish'] = $abschnitt['publish'];
							$contens_as_array[$abschnitt['PART_ID']]['finish']  = $abschnitt['finish'];
							if (!is_future($abschnitt['publish']))	$abschnitt['pubdate']	= format_date($abschnitt['publish'],"%a, %d %b %Y %H:%M:%S ".gmt_offset());
							else									$abschnitt['pubdate']	= format_date(date("Y-m-d H:i:s"),  "%a, %d %b %Y %H:%M:%S ".gmt_offset());
							if (!empty($abschnitt['pubdate'])) {
								$contents['pubdate']= $abschnitt['pubdate'];
								$contens_as_array[$abschnitt['PART_ID']]['pubdate'] = $abschnitt['pubdate'];
							}
							$abschnitt['publish']	= format_date($abschnitt['publish']);
							$abschnitt['finish']	= format_date($abschnitt['finish']);
							$abschnitt['count']		= $count;
							$abschnitt['n']			= $i-1;
							$abschnitt['nr']		= $i;
							$abschnitt['nnr']		= $i+1;
							if ($abschnitt['nnr']>$count)	$abschnitt['nnr']	= 1;
							$abschnitt['pnr']		= $i-1;
							if ($abschnitt['pnr']<=0)	$abschnitt['pnr']	= $count;
							$abschnitt['partcount']= $partcount;
							if ($i % 2 != 0) 	$abschnitt['mod'] = 'uneven';
							else			$abschnitt['mod'] = 'even';
							$i++;
							$extra['posdec'] 	= str_replace(array('.00','.'),array('','_'),$abschnitt['position']);
							$extra['page_id']	= $abschnitt['PAGE_ID'];
							if (!empty($abschnitt['person_ID']))	$extra['person_id']	= $abschnitt['person_ID'];
							if (!empty($abschnitt['AK']))			$extra['AK']= $abschnitt['AK'];
							elseif (!empty($abschnitt['Kurzname']))	$extra['AK']= strtolower($abschnitt['Kurzname'][0]);
							$extra['parent_id'] = $parent_id;
							$extra['lang_id']	= $lang_id;
							$extra['tpl_id']	= $TPL_ID;
							unset($abschnitt['lang_id'],$abschnitt['Content']);
							$parts_byid[$abschnitt['PART_ID']] = $vorlage_tpl;
							$tplobj->array2tpl2($parts_byid[$abschnitt['PART_ID']],$contents,$seperator);
							$tplobj->array2tpl2($parts_byid[$abschnitt['PART_ID']],$extra,'#');
							if ($addextra)	$tplobj->array2tpl2($parts_byid[$abschnitt['PART_ID']],$abschnitt,$seperator);
							unset($abschnitt['PAGE_ID']);
							$tplobj->array2tpl2($parts_byid[$abschnitt['PART_ID']],$abschnitt,'#,$');
							preg_match_all("/<!-- SUB=addcss -->(.*?)<!-- \/SUB -->/si",$parts_byid[$abschnitt['PART_ID']],$match);
							if (!empty($match[0][0])) {
								if (empty($sub_tpl['morecss']))	$sub_tpl['morecss'] ='';
								$sub_tpl['morecss'] .= $match[1][0];
								$parts_byid[$abschnitt['PART_ID']] = str_remove($parts_byid[$abschnitt['PART_ID']],$match[0][0]);
							}
							if (!empty($filter_fck) && function_exists($filter_fck)) {
								$parts_byid[$abschnitt['PART_ID']] = $filter_fck($parts_byid[$abschnitt['PART_ID']]);
							}
							$parts_bypos[$abschnitt['position']] = $parts_byid[$abschnitt['PART_ID']];
							if (!$byid && !$bypos)	$out .= $concat.$parts_byid[$abschnitt['PART_ID']];
							unset($contents);
				}	}	}
#				$sub_tpl['count_sections'] = $i;
			}
		} elseif ((empty($template) && empty($matches[0])) || !empty($current['showanyway']) || $showanyway) {
			if  (!empty($sub_tpl['empty_result']))					$out = $sub_tpl['empty_result'];
			elseif  (!empty($sub_tpl['empty_result_tpl'][$TPL_ID]))	$out = $sub_tpl['empty_result_tpl'][$TPL_ID];
			else													$out = $vorlage_tpl;
		}
		if	   ($byid  && !empty($parts_byid))						$out = $parts_byid;
		elseif ($bypos && !empty($parts_bypos))						$out = $parts_bypos;
		else {
			preg_match_all("/<!-- SUB=(.*?) -->(.*?)<!-- \/SUB -->/si",$out,$match);
			if (!empty($match[1])) {
				foreach($match[1] as $key => $sub) {
					if ((empty($sub_tpl[$sub]) || $set_sub_tpl==true) && isset($match[2][$key]))	$tmp = $match[2][$key];
					if (isset($tmp))								$tmp = preg_replace("/^\%[A-Z_0-9]+\%$/Us",'',$tmp);
					if (strpos($sub,'|')!==false) {
						list($xsub,$ssub) = explode('|',$sub);
						if (empty($sub_tpl[$xsub][$ssub]))	$sub_tpl[$xsub][$ssub]	 = $tmp;
					} elseif (!empty($tmp)) {
						if (!empty($sub_key))				$sub_tpl[$sub_key][$sub] = $tmp;
						else								$sub_tpl[$sub]			 = $tmp;
					}
					unset($tmp);
				#	$out = str_replace($match[0][$key],'#'.strtoupper($sub).'#',$out);
				#	$out = str_replace($match[0][$key],'*'.strtoupper($sub).'*',$out);
					$out = str_remove($out,$match[0][$key]);
			}	}
			if (isset($unterseite_id)) {
				if (!empty($sub_tpl['poptitle']))	$sub_tpl['pagetitle']	= $sub_tpl['poptitle'];
				if (!empty($sub_tpl['popdesc']))	$sub_tpl['description'] = strip_tags($sub_tpl['popdesc']);
			}
			if (!empty($sub_tpl['popup']) && isset($unterseite) && isset($unterseite_id) && empty($anz)) {
				$r_keys		= array_flip(array_filter($keys));
				if (!empty($r_keys[$unterseite_id])) {
					$vor		= $r_keys[$unterseite_id]+1;
					$zurueck	= $r_keys[$unterseite_id]-1;
					$out = $sub_tpl['popup'];
					if (!empty($sub_tpl['top'])) {
						$add['top'] = '<a href=\"./\">'.my_htmlentities($sub_tpl['top']).'</a>';
						if (isset($keys[$vor]))		$add['vor'] 	= subnavlink($keys[$vor],	  $sub_tpl['vor'],	  '<a href=".#TO#§SID§">#LINK#</a>');
						if (isset($keys[$zurueck]))	$add['zurueck'] = subnavlink($keys[$zurueck], $sub_tpl['zurueck'],'<a href=".#TO#§SID§">#LINK#</a>');
						$tplobj->array2tpl2($out,$add,'#');
			}	}	}
			if ($prefix && !empty($sub_tpl['prefix']))				{$out = $sub_tpl['prefix'].$out;	unset($sub_tpl['prefix']);}
			if ($suffix && !empty($sub_tpl['suffix'])) 				{$out = $out.$sub_tpl['suffix'];	unset($sub_tpl['suffix']);}
			if ($as_array && !empty($contens_as_array)) 			 $out = $contens_as_array;
			elseif (!empty($field) && strpos($out,'&&&')!==false) 	 $out = array_combine(explode(',',$field),explode('&&&',$out));
	}	}
	if (!empty($out))							return $out;
	elseif (!empty($sub_tpl['empty_result']))	return $sub_tpl['empty_result'];
	else										return false;
}
function array_sort_by_column($array,$order_by,$dir=SORT_ASC,$sort=SORT_NUMERIC) {
	switch($order_by) {
		case 'P_DESC';	$dir = SORT_DESC;	case 'P_ASC';	$col = "PART_ID";	break;
		case 'PO_DESC';	$dir = SORT_DESC;	case 'PO_ASC';	$col = "position";	break;
		case 'AZ_DESC';	$dir = SORT_DESC;	case 'AZ_ASC';	$col = "first";		break;
		case 'PUB_DESC';$dir = SORT_DESC;	case 'PUB_ASC';	$col = "publish";	break;
		case 'FIN_DESC';$dir = SORT_DESC;	case 'FIN_ASC';	$col = "finish";	break;
	}
	$sort_col = array();
	$f = current($array);
	if (!is_numeric($f[$col])) $sort = SORT_STRING;
	foreach ($array as $key => $row) {
		if ($sort == SORT_STRING) $sort_col[$key] = strtolower($row[$col]);
		else					  $sort_col[$key] = $row[$col];
	}
	array_multisort($sort_col, $dir, $sort, $array);
	foreach ($array as $key => $row) {
		$sorted[$row['PART_ID']] = $row;
	}
	return $sorted;
}
function work_img(&$contents,$images,$PAGE_ID,$PART_ID='',$dir='/') {
	global $vorgaben,$sub_tpl;
	if (!empty($contents['PART_ID'])) 	$PART_ID = $contents['PART_ID'];
	elseif (!empty($images['PART_ID'])) $PART_ID = $images['PART_ID'];
	if (!$contents) unset($contents);
	$contents['dateiname'] = $PAGE_ID.'_'.$PART_ID.'_'.$images['Dateiname'];
	if (strpos($images['Dateiname'],'_bild') > 0)		$images['bildname'] = startstr($images['Dateiname'],'_bild').'_bild';
	elseif (empty($images['bildname']))					$images['bildname'] = 'bild';
	if (!empty($images['Dateiname'])) {
		if (strpos('bild_',$images['Dateiname'])!==false) {
			list($pref,$o_name) = explode('bild_',$images['Dateiname'],2);
		} elseif (strpos('_',$images['Dateiname'])!==false) {
			list($pref,$o_name) = explode('_',$images['Dateiname'],2);
		} else {
			$o_name = $images['Dateiname'];
		}
		if ($vorgaben['is_preview'] && !empty($images['data_url'])) {
			decode2($images['data_url']);
			$contents['obild']		= str_replace(' ','+',urldecode($images['data_url']));
			$contents['bild']		= str_replace(' ','+',urldecode($images['data_url']));
		} else {
			$ipath = $vorgaben['img_path'].$dir.$contents['dateiname'];
			$bpath = $vorgaben['img_path'].'/'.$contents['dateiname'];
			$opath = $vorgaben['img_path'].'/originale/'.$o_name;
			if(is_file($vorgaben['base_dir'].'/'.$opath)) 		$contents['obild'] = '/'.$opath;
			else												$contents['obild'] = '/'.$bpath;
			if(is_file($vorgaben['base_dir'].'/'.$opath)) {
				$contents['obild'] = '/'.$opath;
			}
			if (is_file($vorgaben['base_dir'].'/'.$ipath)) {
				$contents['bild']				= '/'.$ipath;
				$contents[$images['bildname']]	= $contents['bild'];
			#	$contents['hauptbild'] = $contents['obild'];
				$sub_tpl['oldimg'][$contents['bild']] = $contents['bild'];
				if (!empty($images['altext'])) {
					$ext = pathinfo($contents['bild'], PATHINFO_EXTENSION);
					$altimg = str_replace($ext,$images['altext'],$contents['bild']);
					if (is_file($vorgaben['base_dir'].$altimg)) $sub_tpl['altimg'][$contents['bild']] = $altimg;
				}
			}
		}
	}
	if (isset($sub_tpl['firstimage']) && $sub_tpl['firstimage']===true){
		if (!empty($sub_tpl['getfirstimage']) && strpos($images['Dateiname'],$sub_tpl['getfirstimage'].'_')!==false)	$sub_tpl['firstimage'] = $contents['obild'];
		elseif (empty($sub_tpl['getfirstimage']))																		$sub_tpl['firstimage'] = $contents['obild'];
}	}
function work_contents($abschnitt,$nop) {
	global $vorgaben,$sub_tpl;
	if ($vorgaben['is_preview'] && !empty($_REQUEST['abschnitt'][$abschnitt['PART_ID']])) 	$contents = $_REQUEST['abschnitt'][$abschnitt['PART_ID']];
	elseif (!empty($abschnitt['Content_lang']))												$contents = unseri_unurl($abschnitt['Content_lang']);
	else																					$contents = unseri_unurl($abschnitt['Content']);
	if (!empty($contents) && is_array($contents)) {
		foreach ($contents as $key => $data) {
			unset($contents[$key]);
			lower($key);
			if ($vorgaben['is_preview'])								$data = urldecode($data);
			if (strpos(strtolower($key),	'_downloads')!==false
						|| strpos(strtolower($key),	'_datei')!==false
						|| strpos(strtolower($key),	'_files')!==false)	$data = '/downloads/'.$data;
			elseif (strpos(strtolower($key),'_bb')  !==false
						|| strpos(strtolower($key),'_text')!==false)	parse($data,$nop,true);
			elseif (strpos(strtolower($key),'_raw') !==false
						|| strpos(strtolower($key),'_fck') !==false) 	parse($data);
			elseif (strpos(strtolower($key),'_fck') !==false
						&& $nop == 2 && $nop !== true)					$data = preg_replace("/\<p\>/",'',$data,1);
			elseif (empty($vorgaben['no_fck'])
						&& strpos(strtolower($key),'_')===false
						&& empty($contents[$key.'_fck']))				$contents[$key.'_fck'] = '<p>'.$data.'</p>';
			$contents[$key] = $data;
	}	}
	return $contents;
}
?>