<?php
function edit_vorlage($TPL_ID,$page_id=0,$limit=0) {
	global $tplobj,$dbobj,$first_lang,$first_lang_id,$vorgaben,$sub_tpl,$path_in,$unterseite_id;
	if (!empty($TPL_ID) && is_numeric($TPL_ID)) {
		if (empty($vorgaben['seperator']))	$vorgaben['seperator']='|';
		if (!$vorgaben['admin'] && !empty($sub_tpl['useredit_tpls']))	$tpls = $sub_tpl['useredit_tpls'];
	else																$tpls = $tplobj->read_tpls('admin/abschnitt.inc.html');
#		add_datepicker();
		add_lightbox();
		if (!empty($_REQUEST['pages']['LANG_ID']))	$LANG_ID = &$_REQUEST['pages']['LANG_ID'];
		else										$LANG_ID = &$first_lang_id;
		if (!empty($_REQUEST['pages']['PAGE_ID']) && is_numeric($_REQUEST['pages']['PAGE_ID'])) {
			$page_id = $_REQUEST['pages']['PAGE_ID'];
			$sql = "SELECT	#PREFIX#vorlagen.*,#PREFIX#seiten_attr.order_by
					FROM	#PREFIX#vorlagen,#PREFIX#seiten_attr
					WHERE	#PREFIX#vorlagen.TPL_ID		= ".$TPL_ID."
					AND		#PREFIX#vorlagen.TPL_ID		= #PREFIX#seiten_attr.TPL_ID
					AND		#PREFIX#seiten_attr.PAGE_ID = ".$page_id.";";
		} else $sql = "SELECT * FROM #PREFIX#vorlagen WHERE TPL_ID = ".$TPL_ID;
		if($vorlage_data = $dbobj->exists(__file__,__line__,$sql)) {
			if (isset($vorlage_data[0]['showta']) && empty($vorlage_data[0]['showta']))	$sub_tpl['style'][] = '#fck_textarea,.intext {display:none;}';
			$vorlage_tpl = $vorlage_data[0]['Template'];
			if (preg_match_all("/\%([A-Z]{1,}.+)\%/Umsi",$vorlage_tpl,$matches)) {
				preg_match_all("/<!-- SUB=(.*?) -->(.*?)<!-- \/SUB -->/si",$vorlage_tpl,$match2);
				if (!empty($match2[0])) {
					foreach($match2[1] as $key => $sub) {
						if (empty($first) && $match2[1][$key]=='first') {
							$first = $match2[2][$key];
						} elseif (strpos($sub,':')!==false) {
							$sub_tpl[$key] = explode(':',$sub);
							$c = $sub_tpl[$key][1];
							$string = preg_replace("/\%([a-z0-9-_]+)\%/Ui","%$1|$c%",$match2[2][$key]);
							$vorlage_tpl = str_replace($match2[2][$key],$string,$vorlage_tpl);
				}	}	}
				preg_match_all("/\%([A-Z]{1,}.+)\%/Umsi",$vorlage_tpl,$match1);
				$match1[0] = array_unique($match1[0]);
				$match1[1] = array_unique($match1[1]);
				$vorlage_fields = &$match1[0];
				$order_by = '';
				$start = 0;
				$parts_all = get_allparts($page_id,$LANG_ID,$tpls,$start,$limit,$order_by,$vorlage_data);
				$count = 0;
				if (($vorlage_data[0]['anzahl'] != 0 || empty($parts_all) || (!empty($parts_all)) && (count($parts_all) < $vorlage_data[0]['anzahl'] || $vorlage_data[0]['anzahl'] < 0))) {
					if (!empty($vorlage_data[0]['neu'])) {
						if($parts_all)				$count = count($parts_all);
						if (is_array($parts_all))	$last_part_id = max(array_keys($parts_all));
						else						$last_part_id = 0;
						if ($vorlage_data[0]['anzahl'] < 0 || (($count+$vorlage_data[0]['neu']) <= $vorlage_data[0]['anzahl']))	$neu_vl = $vorlage_data[0]['neu'];
						else																									$neu_vl = $vorlage_data[0]['anzahl'] - $count;
						$new_part_id = $last_part_id + $neu_vl;
						while  ($new_part_id > $last_part_id) {
							$parts_all[$new_part_id]['content'] = '';
							$parts_all[$new_part_id]['visibility'] = 1;
							$parts_all[$new_part_id]['first']	= '(%%NEU%%)';
							$sub_tpl['style'][] = '#toggle_'.$page_id.'_'.$new_part_id.' {display:block;}';
							$new_part_id--;
				}	}	}
				$abschnitt_tpl = str_replace($vorgaben['seperator'].'TITEL'.$vorgaben['seperator'],$vorlage_data[0]['Titel'],$tpls['abschnitt']);
				if (!empty($parts_all) && is_array($parts_all)) {
					$min_part_id = min(array_keys($parts_all));
					$n=1;
					foreach ($parts_all as $part_id => $abschnitt)  {
						if (!empty($abschnitt['Content_lang']))	$content = unseri_unurl($abschnitt['Content_lang']);
						elseif (!empty($abschnitt['Content']))	$content = unseri_unurl($abschnitt['Content']);
						else									unset($content);
						if (!empty($first) && !empty($content))		$abschnitt['first'] = preg_replace("/%(\S)%/Umsi", '',$tplobj->array2tpl($first,$content,'%'));
						elseif (!empty($abschnitt['first_lang']))	$abschnitt['first'] = $abschnitt['first_lang'];
						foreach ($vorlage_fields as $key => $field) {
							$seperate = $match1[1][$key];
							$set = array();
							if (strpos($seperate,':')!==false) {
								list($seperate,$param) = explode(':',$seperate,2);
								if (strpos($param,';')!==false) 	{
									$params = explode(';',$param);
									foreach ($params as &$tmp) {
										if (strpos($tmp,'=')!==false) {
											 $tmp = explode('=',$tmp,2);
											 $set[strtoupper($tmp[0])] = $tmp[1];
										} else $set['GET'] = $tmp;
									}
								} elseif (strpos($param,'=')!==false) {
									 $tmp = explode('=',$param,2);
									 $set[strtoupper($tmp[0])] = $tmp[1];
							}	}
							lower($seperate);
							$x=$seperate;
							if (empty($neu) || empty($neu[$x])) {
								$name	  = ucfirst($seperate);
								if (strpos($seperate,'|')!==false) 	list($seperate,$repeat) = explode('|',$seperate,2);
								else								$repeat = 1;
								$seperate2 = explode('_',$seperate);
								if (!empty($seperate2[1]))		$field = strtolower($seperate2[1]);
								else							$field = strtolower($seperate2[0]);
								$place = $matches[0][$key];
								if (!empty($content[$name]) && is_array($content[$name])) {
									foreach ($content[$name] as $key => $entry) $data[$key] = my_htmlspecialchars($entry);
								}
								elseif (isset($content[$name]))	$data[$x] = my_htmlspecialchars($content[$name]);
								else							$data[$x] = '';
								if ($repeat == 1) 				$form_name = 'abschnitt['.$vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'].']['.$name.']';
								else {
									$form_name = 'abschnitt['.$vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'].']['.$name.'][#N#]';
									$label .= ' (#N#)';
								}
								if(!empty($set['LABEL']))  {$label = $set['LABEL']; unset($set['LABEL']);}
								else						$label = ucfirst($seperate2[0]);
								if(!empty($set['PLACEHOLDER']))  {$placeholder = $set['PLACEHOLDER']; unset($set['PLACEHOLDER']);}
								else						$placeholder = $label;
								if(!empty($set['COMMENT']))  {$comment = $set['COMMENT']; unset($set['COMMENT']);}
								if(!empty($set['IGNORE']))  {
									$neu[$x] .= "\n".'<input type="hidden" name="saveignore[]" 	value="'.$set['IGNORE'].'" />'."\n";
									unset($set['IGNORE']);
								}
								if ($label == 'Email')		$label = 'E-Mail';
								if(!empty($set['MULTIPLE']))$multiple = 'multiple="multiple" size="'.$set['MULTIPLE'].'"';
								else						$multiple = '';
								if(!empty($set['SIZE']))	$size = 'size="'.$set['SIZE'].'"';
								else						$size = 'size="40"';
								if(!empty($set['MAXLENGTH']))$maxlength = ' maxlength="'.$set['MAXLENGTH'].'"';
								else						$maxlength = '';
								if(!empty($set['ROWS']))	$rows = $set['ROWS'];
								else						$rows = 3;
								if(!empty($set['COLS']))	$cols = $set['COLS'];
								else						$cols = 20;
								if(!empty($set['WIDTH']))	$width = 'style="width:'.$set['WIDTH'].'"';
								else						$width = 'style="width:100%"';
								if(!empty($set['ONLY']) && $_SESSION['status'] != $set['ONLY'])	$onlyadmin = ' style="display:none"';
								else															$onlyadmin = '';
								if (isset($_REQUEST['abschnitt'][$part_id][$name]))	$data[$x] = $_REQUEST['abschnitt'][$part_id][$name];
								elseif (!isset($data[$x]) && isset($set['DEFAULT']))	$data[$x] = $set['DEFAULT'];
								if (empty($set['LIMIT']) || (!empty($set['LIMIT']) && $n <= $set['LIMIT'])) {
									$element_id = $name.'_'.$page_id.'_'.$page_id.'_'.$x.'_'.$vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'];
									if (!isset($neu[$x]))	$neu[$x]  ='';
									if (!isset($data[$x]))	$data[$x] ='';
									if ($field!='kommentar') {
										$neu[$x] .= '<fieldset id="fieldset_'.$element_id.'"'.$onlyadmin.'>'."\n";
										$neu[$x] .= "\t".'<label for="'.$element_id.'">'.$label.':</label>'."\n";
									}
									$class = '';
									$add_class = '';
									if(!empty($set['STRIPCONTENT']) && empty($data[$x]) && !empty($content[ucfirst($set['STRIPCONTENT'])]))	$data[$x] = strip_tags(html_entity_decode($content[ucfirst($set['STRIPCONTENT'])]));
									elseif(!empty($set['CONTENT'])	&& empty($data[$x]) && !empty($content[ucfirst($set['CONTENT'])]))		$data[$x] = $content[ucfirst($set['CONTENT'])];
									switch ($field) {
										case 'fck':		if ($field=='fck') {
															if(!empty($set['CLASS']))	$class = $set['CLASS'];
															else						$class = 'fck2';
															if (empty($data[$x]) && !empty($set['TPL'])) 	$data[$x] = $set['TPL'];
															elseif (empty($data[$x])) 						$data[$x] = $vorgaben['template'];
														}
										case 'code':	#$data = html_entity_decode($data);
										case 'raw':
										case 'text':	$type = 'textarea';
														if(!empty($set['CLASS'])) {
															if (!empty($content[ucfirst($set['CLASS'])]))	$add_class = $seperate2[0].' '.$content[ucfirst($set['CLASS'])];
															else											$add_class = $seperate2[0].' '.$set['CLASS'];
														} else												$add_class = $seperate2[0];
														if(!empty($set['BODYCLASS']))	$add_class .= ' '.$set['BODYCLASS'];
														if (!empty($set['HEIGHT']))	$neu[$x] .= "\t\t".'<input type="hidden" id="height_'.$name.'_'.$x.'_'.$vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'].'" value="'.$set['HEIGHT'].'" />'."\n";
														$neu[$x] .= "\t".'<input type="hidden" id="id_'.$element_id.'" 	value="part_'.$vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'].'" />'."\n";
														$neu[$x] .= "\t".'<input type="hidden" id="class_'.$element_id.'" value="'.$add_class.'" />'."\n";
														$neu[$x] .= "\t".'<br style="clear:both" /><textarea class="'.$class.'" id="'.$element_id.'" cols="'.$cols.'" rows="'.$rows.'" '.$width.' name="'.$form_name.'" '.$maxlength.'>'.$data[$x].'</textarea><br />'."\n";
										break;
										case 'downloads':
														$neu[$x] .= '<input id="'.$element_id.'" type="input" name="'.$form_name.'" value="'.$data[$x].'" /> <a href=\"javascript:" onClick="BrowseServer(\''.$element_id.'\');\"><img src="admin/file_manager/rbfmimg/ico_download.png" class="tooltip" title="%%SERVER_DURCHSUCHEN%%"/></a>'."\n";
										break;
										case 'link':
										case 'www':
														$neu[$x] .= '<input id="'.$element_id.'" type="input" name="'.$form_name.'" value="'.$data[$x].'" /> <a href=\"javascript:" onClick="BrowseLinks(\''.$element_id.'\');\"><img src="admin/file_manager/rbfmimg/ico_open_as_web.png" class="tooltip" title="%%LINKS_DURCHSUCHEN%%"/></a>'."\n";
										break;
										case 'image':
										case 'bild':
										case 'file':
										case 'datei':	$type = 'file';
														if (!empty($set['USELANG']))$neu[$x] .= "\t".'<input type="hidden" name="override['.$vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'].']['.$name.'][uselang]" value="1" />'."\n";
														if (!empty($set['WIDTH']))	$neu[$x] .= "\t".'<input type="hidden" name="override['.$vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'].']['.$name.'][width]"   value="'.$set['WIDTH'].'" />'."\n";
														if (!empty($set['HEIGHT']))	$neu[$x] .= "\t".'<input type="hidden" name="override['.$vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'].']['.$name.'][height]"  value="'.$set['HEIGHT'].'" />'."\n";
														if	   ($field == 'bild')	$neu[$x] .= "\t".'|BILD_'.strtoupper($seperate).'_'.$vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'].'|';
														else						$neu[$x] .= "\t|".'DATEI_'.strtoupper($seperate).'_'.$vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'].'|';
														$neu[$x] .= "\t".'<input id="'.$element_id.'" type="file" name="'.$form_name.'" value="" />'."\n";
													#	if (!empty($param)) $neu[$x] .= ' ('.$param.')';
										break;
										case 'select':
											if (!empty($multiple))		$form_name .= '[]" '.$multiple.'';
											if (!empty($set['GET']))	$param = $set['GET'];
											if (!empty($param)) {
												$neu[$x] .= "\t".'<select onChange="changelink(\''.$element_id.'\')" id="'.$name.'_'.$x.'_'.$vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'].'" name="'.$form_name.'"><option value=""></option>'."\n\t";
												switch ($param) {
													case 'status':		$neu[$x] .= sel_status($data[$x],false);break;
													case 'person':		$neu[$x] .= persons('',$data[$x],'');	break;
													case 'templates':
													case 'vorlagen':	$neu[$x] .= vls('',$data[$x],'');		break;
													case 'categories':
													case 'kategorien':	$neu[$x] .= kats('',$data[$x],'');		break;
													case 'languages':
													case 'sprachen':	$neu[$x] .= langs('',$data[$x]);		break;
													case 'subpages':
													case 'unterseiten':	if (empty($set['parent_ID']))	$set['parent_ID'] = $_REQUEST['pages']['PAGE_ID'];
													case 'pages':
													case 'seiten':		if (empty($set['PAGE_ID']))		$set['PAGE_ID'] = $data[$x];
																		$set['cache'] = false;
																		$neu[$x] .= subpage_of($set);
																		if (is_numeric($data[$x])) $set['addlink']	= $tplobj->read_tpls(' <a id="link_'.$element_id.'" href="'.$vorgaben['seperator'].'PHPSELF'.$vorgaben['seperator'].'?page=pages&amp;pages[PAGE_ID]='.$data[$x].'§SID§" class="tooltip" title="%%BEARBEITEN%%">'.get_page(array('PAGE_ID'=>$data[$x],'feld'=>'Menu','visibility'=>'0,1','errors'=>false)).'</a>');
																		else {
																			if (!is_array($data[$x]))	$data[$x] = explode(',',$data[$x]);
																			else						$data[$x] = $data[$x];
																			$set['addlink']	= '';
																			foreach ($data[$x] as $link_id) {
																				if (!empty($set['addlink'])) $set['addlink']	.= '|';
																				$set['addlink']	.= $tplobj->read_tpls(' <a id="link_'.$element_id.'_'.$link_id.'" href="'.$vorgaben['seperator'].'PHPSELF'.$vorgaben['seperator'].'?page=pages&amp;pages[PAGE_ID]='.$link_id.'§SID§" class="tooltip" title="%%BEARBEITEN%%">'.get_page(array('PAGE_ID'=>$link_id,'feld'=>'Menu','visibility'=>'0,1','errors'=>false)).'</a>');
																			}
																		}
														break;
													default:			if (!is_array($data[$x]))	$set['selected'] = explode(',',$data[$x]);
																		else						$set['selected'] = $data[$x];
																		if (empty($set['FELD']))	$set['feld'] = 'feld';
																		else						$set['feld'] = $set['FELD'];
																		$neu[$x] .= sel_daten($set);
																		if (!empty($set['PAGE_ID']))	$set['addlink'] = $tplobj->read_tpls(' <a href="'.$vorgaben['seperator'].'PHPSELF'.$vorgaben['seperator'].'?page=pages&amp;pages[PAGE_ID]='.$set['PAGE_ID'].'§SID§" class="tooltip" title="%%BEARBEITEN%%">'.get_page(array('PAGE_ID'=>$set['PAGE_ID'],'feld'=>'Menu','visibility'=>'0,1','errors'=>false)).'</a>');
	
														break;
												}
												$neu[$x] .= '</select>'."\n";
												if (!empty($set['addlink']))	$neu[$x] .= $set['addlink'];
											}
										break;
										case 'range':	$neu[$x] .= "\t".'<input type="'.$field.'" id="'.$element_id.'" name="'.$form_name.'" value="'.$data[$x].'" min="0" max="1" step="0.05"/>';
														$neu[$x] .= "\t".'<output onforminput="value=$(\'#'.$element_id.'\').val()" for="'.$name.'_'.$x.'_'.$vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'].'">'.$data[$x].'</output>';
										break;
										case 'checkbox':
										case 'radio':
											if (!empty($param)) {
												if (isset($set['VALUES']) && strpos($set['VALUES'],',')!==false) {
													$v_tmp = explode(',',$set['VALUES']);
													unset($set);
													foreach ($v_tmp as $k) {
														$set[$k] = $k;
													}
												}
												if (isset($set['DEFAULT']))								$neu[$x] .= "\t".'<input type="hidden" name="default['.$vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'].']['.$name.']" value="'.$set['DEFAULT'].'" \>'."\n";
												if (isset($_REQUEST['abschnitt'][$part_id][$name]))		$selection = $_REQUEST['abschnitt'][$part_id][$name];
												elseif (isset($data[$x]))								$selection = $data[$x];
												else													unset($selection);
												foreach ($set as $s => $v) {
													if (isset($selection) && $selection == $v)	$selected = 'checked="checked"';
													else										$selected = '';
									#				$neu[$x] .= "\t".'<input type="hidden" name="'.$form_name.'" value="0"  \>';
													$neu[$x] .= "\t".'<input type="'.$field.'" id="'.$element_id.'_'.$v.'" name="'.$form_name.'" value="'.$v.'" '.$selected.' \>&nbsp;'.ucfirst(strtolower($s))."\n";
											}	}
										break;
										case 'comment':
										case 'kommentar': make_replacements($match1[1][$key]);
														  $neu[$x] .= "\t<p class=\"comment\">".str_replace(strtoupper($field).':','',$tplobj->read_tpls($match1[1][$key]))."<br /><br /></p>\n";
										break;
										case 'farbe':
										case 'color':	if (!empty($data[$x]))			$input_style = 'style="background-color:'.$data[$x].';"';
														else							$input_style = '';
														add_colorpicker();
														$neu[$x] .= "\t".'<input type="color" '.$input_style.' id="'.$name.'_'.$page_id.'_'.$page_id.'_'.$x.'_'.$vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'].'" name="'.$form_name.'" value="'.$data[$x].'" '.$size.' />'."\n";
										break;
										case 'function':if (function_exists($set[strtoupper($name)])) {
															$fct = $set[strtoupper($name)];
															$neu[$x] .= "\t".$fct($page_id,$part_id);
														}
										break;
										case 'number':
										case 'datetime':
										case 'date':	$neu[$x] .= "\t".'<input type="'.$field.'" id="'.$element_id.'" name="'.$form_name.'" value="'.$data[$x].'" '.$size.' '.$maxlength.' />'."\n";
										break;
										default:		$type = 'input';
														#if (empty($data[$x])) $data[$x] = $label;
														$neu[$x] .= "\t\t".'<input '.$class.' id="'.$element_id.'" name="'.$form_name.'" placeholder="'.$placeholder.'" value="'.$data[$x].'" '.$size.' '.$maxlength.' />'."\n";
														#if (!empty($param) && !is_numeric($param)) $neu[$x] .= ' ('.$param.')';
										break;
									}
									if (!empty($param)) unset($param);
									if (!empty($matches[1][$key]) && (strpos($vorlage_tpl,'#'.$matches[1][$key].'#') != false || strpos($vorlage_tpl,'#'.$matches[1][$key].'_') != false)) {
										if (!empty($abschnitt['pflicht']) && in_array($matches[1][$key],explode(',',$abschnitt['pflicht'])))	$p_chk = 'checked="checked"';
										else 																									$p_chk = '';
										$neu[$x] .= "\t".	'<input '.$p_chk.' class="tooltip" title="%%PFLICHTFELD%%: '.$label.'" type="checkbox" name="pflicht[]" value="'.$matches[1][$key].'" />';
									}
									$neu[$x] = str_replace('#N#',$x,$neu[$x]);
									if (!empty($comment)) {
										$neu[$x] .= "\t<p class=\"info\">".$comment.'<\p>';
										unset($comment);
									}
									if ($field!='kommentar') 	$neu[$x] .= '</fieldset>'."\n";
						}	}	}
						$vorlage_neu = $abschnitt_tpl;#.$vorlage_neu;
						$vorlage_neu = str_replace($vorgaben['seperator'].'CONTENT'.$vorgaben['seperator'],"<div>".implode("\n",$neu)."</div>\n",$vorlage_neu);
						$vorlage_neu = str_replace($vorgaben['seperator'].'N'.$vorgaben['seperator'],$n++,$vorlage_neu);
						$vorlage_neu = str_replace($vorgaben['seperator'].'PART_ID'.$vorgaben['seperator'],$part_id,$vorlage_neu);
						$vorlage_neu = str_replace($vorgaben['seperator'].'ABSCHNITT'.$vorgaben['seperator'],$part_id+1-$min_part_id,$vorlage_neu);
						$abschnitt['first'] = str_remove(strip_tags($abschnitt['first']),array('<','>'));
						if (!empty($abschnitt['position']) || (isset($abschnitt['position']) && $abschnitt['position']==0))					$abschnitt['filled'] = 1;
						if (empty($abschnitt['finish'])  || $abschnitt['finish']  <= '1970-01-01')	$abschnitt['finish']  = '';
						if (empty($abschnitt['publish']) || $abschnitt['publish'] <= '1970-01-01')	$abschnitt['publish'] = '';
						if ($abschnitt['first']=='(%%NEU%%)')$abschnitt['color']	 = 'style="color:grey"';
						if ($abschnitt['visibility']==1)	{$abschnitt['a_visible'] = 'checked="checked"';	$abschnitt['a_hidden'] = '';					$abschnitt['color'] = '';}
						else								{$abschnitt['a_visible'] = '';					$abschnitt['a_hidden']  = 'checked="checked"';	$abschnitt['color'] = 'style="color:red"';}
						$vorlage_out[] = $tplobj->array2tpl($vorlage_neu,$abschnitt,$vorgaben['seperator']);
						unset($abschnitt,$data,$neu);
				}	}
				unset($vorlage_neu);
				if (!empty($vorlage_out)) {
					$vorlage_out = array_reverse($vorlage_out);
					$counter = 0;
					$proseite = 20;
					if (count($vorlage_out)>$proseite) {
						$sub_tpl['subnavlink'] = "\n<a href=\"".$path_in.'?page=|PAGE|&amp;pages[PAGE_ID]=|PAGE_ID|&amp;pages[LANG_ID]=|LANG_ID|&#TO#|SID|">#LINK#</a>';
						$sub_tpl['subnavpre']   = 'paginate=';
						$sub_tpl['subnavbox']  = '<p class="nav">#ANZAHL# %%ABSCHNITTE%% (#VON# - #BIS#): #CONTENT# '.str_replace(array('#TO#','#LINK#'),array($sub_tpl['subnavpre'].'all','%%ALLE%%'),$sub_tpl['subnavlink']).'</p>';
						if (!empty($_REQUEST['paginate']) && is_numeric($_REQUEST['paginate']))	$unterseite_id = $_REQUEST['paginate'];
						elseif (!empty($_REQUEST['paginate']) && $_REQUEST['paginate']=='all')	$unterseite_id = $_REQUEST['paginate'];
						else																	$unterseite_id = 0;
						if (is_numeric($unterseite_id)) paginate($vorlage_out,$proseite,false);
					}
					$vorlage_neu = implode("\n",$vorlage_out);
					$vorlage_neu = str_remove($vorlage_neu,$vorgaben['seperator'].'POSITION'.$vorgaben['seperator']);
				/*	if (empty($_REQUEST['send']) || $_REQUEST['send'] != 'copy')	$spo = array('PAGE_ID'=>$page_id,'cache'=>false);
					else	*/														$spo = array('cache'=>false, 'highlight'=>$page_id);
					$vorlage_neu = str_replace($vorgaben['seperator'].'ENTRIES'.$vorgaben['seperator'],subpage_of($spo),$vorlage_neu);	// Auswahl Unterseiten erstellen
					$vl_out = $order_by.str_replace(array($vorgaben['seperator'].'VORLAGE'.$vorgaben['seperator'],$vorgaben['seperator'].'START'.$vorgaben['seperator'],$vorgaben['seperator'].'ANZABSCHNITTE'.$vorgaben['seperator']),array($vorlage_neu,($start+$limit),$count),$tpls['vlframe']);
					if (!empty($sub_tpl['subnav'])) {
						$sub_tpl['subnav'] = str_replace('&pages=','&',$sub_tpl['subnav']);
						$sub_tpl['subnav'] = $tplobj->read_tpls($sub_tpl['subnav']);
						$vl_out =  $sub_tpl['subnav'].$vl_out.$sub_tpl['subnav'];
						unset($sub_tpl['subnav']);
					}
					return $vl_out;
	}	}	}	}
	else return '';
}
function get_allparts($page_id,$LANG_ID,$tpls,&$start,$limit,&$order_by,$vorlage_data) {
	global $dbobj,$vorgaben;
	if (!empty($page_id) && is_numeric($page_id)) {
		if (isset($vorlage_data[0]['order_by']) && $vorlage_data[0]['anzahl'] !=0 && $vorlage_data[0]['anzahl'] !=1)	$order_by = str_replace($vorgaben['seperator'].'PAGE_ID'.$vorgaben['seperator'],$page_id,$tpls['sortierung']);
		$sql_order = "ORDER BY	#PREFIX#abschnitte.position,#PREFIX#abschnitte.first,#PREFIX#_languages.position DESC,PART_ID";
		if (!empty($order_by) && !empty($vorlage_data[0]['order_by'])) {
			$order_by = str_replace('#ORDER_'.$vorlage_data[0]['order_by'].'#','selected="selected"',$order_by);
			switch($vorlage_data[0]['order_by']) {
				case 'P_ASC';	$sql_order = "ORDER BY	PART_ID DESC,#PREFIX#_languages.position DESC";	break;
				case 'P_DESC';	$sql_order = "ORDER BY	PART_ID,	 #PREFIX#_languages.position DESC";	break;
				case 'PO_ASC';	$sql_order = "ORDER BY	#PREFIX#abschnitte.position DESC,abschnitt.first DESC,#PREFIX#abschnitte.first DESC,#PREFIX#_languages.position DESC,PART_ID DESC";	break;
				case 'PO_DESC';	$sql_order = "ORDER BY	#PREFIX#abschnitte.position,	 abschnitt.first DESC,#PREFIX#abschnitte.first DESC,#PREFIX#_languages.position DESC,PART_ID DESC";	break;
				case 'AZ_ASC';	$sql_order = "ORDER BY	abschnitt.first DESC,#PREFIX#abschnitte.first DESC,#PREFIX#abschnitte.position DESC,#PREFIX#_languages.position DESC,PART_ID DESC";	break;
				case 'AZ_DESC';	$sql_order = "ORDER BY	abschnitt.first,	 #PREFIX#abschnitte.first,	 #PREFIX#abschnitte.position DESC,#PREFIX#_languages.position DESC,PART_ID DESC";	break;
				case 'PUB_ASC';	$sql_order = "ORDER BY	#PREFIX#abschnitte.publish DESC,#PREFIX#abschnitte.position DESC,abschnitt.first DESC,#PREFIX#abschnitte.first DESC,#PREFIX#_languages.position DESC,PART_ID DESC";	break;
				case 'PUB_DESC';$sql_order = "ORDER BY	#PREFIX#abschnitte.publish,	 #PREFIX#abschnitte.position DESC,abschnitt.first DESC,#PREFIX#abschnitte.first DESC,#PREFIX#_languages.position DESC,PART_ID DESC";	break;
				case 'FIN_ASC';	$sql_order = "ORDER BY	#PREFIX#abschnitte.finish DESC, #PREFIX#abschnitte.position DESC,abschnitt.first DESC,#PREFIX#abschnitte.first DESC,#PREFIX#_languages.position DESC,PART_ID DESC";	break;
				case 'FIN_DESC';$sql_order = "ORDER BY	#PREFIX#abschnitte.finish,	  #PREFIX#abschnitte.position DESC,abschnitt.first DESC,#PREFIX#abschnitte.first DESC,#PREFIX#_languages.position DESC,PART_ID DESC";	break;
		}	}
		$sql = "SELECT		#PREFIX#abschnitte.*,abschnitt.first AS first_lang,abschnitt.Content as Content_lang
				FROM 		#PREFIX#_languages,#PREFIX#seiten,#PREFIX#seiten_attr,#PREFIX#abschnitte
								LEFT JOIN (#PREFIX#abschnitte as abschnitt) ON (abschnitt.LANG_ID = ".$LANG_ID." AND abschnitt.PART_ID = #PREFIX#abschnitte.PART_ID AND abschnitt.PAGE_ID = #PREFIX#abschnitte.PAGE_ID)
				WHERE 		#PREFIX#seiten_attr.PAGE_ID = ".$page_id."
				AND			#PREFIX#abschnitte.PAGE_ID	= #PREFIX#seiten_attr.PAGE_ID
				AND			#PREFIX#seiten.PAGE_ID		= #PREFIX#seiten_attr.PAGE_ID
				AND			#PREFIX#seiten.LANG_ID		= #PREFIX#abschnitte.LANG_ID
				AND			#PREFIX#_languages.LANG_ID	= #PREFIX#abschnitte.LANG_ID
				GROUP BY PART_ID ".$sql_order."";
		if (!empty($_REQUEST['vlpage']) && !empty($limit)) {
			$start = $_REQUEST['vlpage']*$limit;
			$sql .= " LIMIT ".$start.",".($limit+1);
		}
		return $dbobj->withkey(__file__,__line__,$sql.";",'PART_ID');
}	}
?>