<?php
function set_preset($key,$data='') {
		if (!empty($data) && !empty($data[$key]))	return $data[$key];
		elseif (!empty($_REQUEST[$key]))			return $_REQUEST[$key];
		else										return '';
}
function getrequest($key) {
	if (empty($key['sources']))	$sources = array('R','S','C');
	else						$sources = explode(',',$key['sources']);
	foreach ($sources as $src) {
		switch ($src) {
			case 'R': if (!empty($_REQUEST))		$data = $_REQUEST; break;
			case 'P': if (!empty($_POST))			$data = $_POST; break;
			case 'G': if (!empty($_GET))			$data = $_GET; break;
			case 'S': if (!empty($_SESSION))		$data = $_SESSION; break;
			case 'C': if (!empty($_COOKIE[$key[1]]))$data[$key[1]] = my_readcookies($key[1]); break;
		}
		if (is_string($key) && !empty($data[$key])) return $data[$key];
		elseif(is_array($key)) {
			if (!empty($key[1]) && isset($key[1]))
				if (!empty($key[2]) && isset($key[2])) {
					if (!empty($key[3]) && isset($key[3]) && isset($data[$key[1]][$key[2]][$key[3]])) {
						return $data[$key[1]][$key[2]][$key[3]];
				}	}
				if (isset($key[2]) && isset($data[$key[1]][$key[2]])) {
					return $data[$key[1]][$key[2]];
				}
			if (isset($data[$key[1]]) & empty($key[2])) {
				return $data[$key[1]];
	}	}	}
	if (isset($key['else']))					return $key['else'];
	else										return '';
}
function getrequest_all($key) {
	if (is_string($key) && !empty($_REQUEST[$key])) return $_REQUEST[$key];
	elseif(is_array($key)) {
		if (!empty($key['SOURCE'])) {
			$sources = explode(',',$key['SOURCE']);
		} else {
			$sources[0] = 'REQUEST';
		}
		foreach ($sources as $source) {
			$src = ${'_'.$source};
			if (!empty($key[1]) && is_string($key[1]))
				if (!empty($key[2]) && is_string($key[2])) 
					if (!empty($key[3]) && is_string($key[3]) && isset($src[$key[1]][$key[2]][$key[3]]))	return $src[$key[1]][$key[2]][$key[3]];
				if (isset($src[$key[1]][$key[2]])) 															return $src[$key[1]][$key[2]];
			if (isset($src[$key[1]])) 																		return $src[$key[1]];
	}	}
	if (isset($key['else']))					return $key['else'];
	else										return '';
}
function showget($data,$out='') {
	global $sub_tpl;
	$d['get'] = $data['key'];
	$tpl = $sub_tpl[$data['tpl']];
	$out = formpost($d,$out,$tpl);
	if (!empty($out))								return $out;
	elseif(!empty($sub_tpl[$data['tpl'].'_empty']))	return $sub_tpl[$data['tpl'].'_empty'];
}
function showpost($data,$out='') {
	global $sub_tpl;
	$d['post'] = $data['key'];
	$tpl = $sub_tpl[$data['tpl']];
	$out = formpost($d,$out,$tpl);
	if (!empty($out))								return $out;
	elseif(!empty($sub_tpl[$data['tpl'].'_empty']))	return $sub_tpl[$data['tpl'].'_empty'];
}
function formpost($data,$out='',$tpl='<input type="hidden" name="#K#" value="#V#" />') {
	foreach ($data as $request => $keys) {
		$ks = explode(',',$keys);
		if	  ($request=='post')$var = &$_POST;
		elseif($request=='get')	$var = &$_GET;
		foreach ($ks as $k) {
			if(isset($var[$k])) $out .= str_replace(array('#K#','#V#'),array($k,$var[$k]),$tpl);
	}	}
	return $out;
}
function formget($data=array()) {
	if (is_string($data))	$d['string'] = &$data;
	else					$d = &$data;
	if (empty($d['get']) && !empty($_GET)) $d['get'] = implode(',',array_keys($_GET));
	foreach ($d as $request => $keys) {
		$ks = explode(',',$keys);
		if	  ($request=='post')$var = &$_POST;
		elseif($request=='get')	$var = &$_GET;
		else					$var = &$_REQUEST;
		foreach ($ks as $k) {
			if(isset($var[$k])) {
				if (is_array($var[$k])) $out[] = array2txt($var[$k],$k,'','','=','&','');
				else					$out[] = $k.'='.urlencode($var[$k]);
	}	}	}
	if(isset($out))	return '?'.str_replace('&&','&',implode('&',$out));
}
function sel_daten($data) {
	global $dbobj,$tplobj,$vorgaben;
	$default = array('PAGE_ID'=>'','name'=>'','field'=>'','selected'=>'','tpl'=>'','feld'=>'feld','pos_lt'=>'','key'=>'byid','VISIBILITY'=>'1');
	if (!empty($data) && is_string($data))							$data['PAGE_ID'] = $vorgaben[$data];
	extract(merge_defaults_user($default,$data,'PAGE_ID'),EXTR_SKIP);
	if (!empty($PAGE_ID) && !empty($vorgaben[$PAGE_ID]))			$PAGE_ID = &$vorgaben[$PAGE_ID];
	if (empty($VISIBILITY))											$VISIBILITY = '0,1';
	$daten = get_daten(array('PAGE_ID'=>$PAGE_ID,'pos_lt'=>$pos_lt,'key'=>$key,'feld'=>$feld,'visibility'=>$VISIBILITY));
	if (!empty($daten) && is_array($daten)) {
		if (empty($selected) && isset($_REQUEST[$name][$field]))	$selected = array($_REQUEST[$name][$field]);
		return sel_array($daten,$selected,$name,'','',$tpl,$feld);
}	}
function sel_contacts($data) {
	global $dbobj,$tplobj,$sub_tpl,$vorgaben;
	if ($to = $dbobj->withkey(__file__,__line__,'SELECT ID,Name,Firma,Email FROM #PREFIX#person WHERE kontakt = 1 ORDER BY ID','ID')) {
		if (!empty($_REQUEST['to']) && is_numeric($_REQUEST['to']))	$selected = $_REQUEST['to'];
		else														$selected = '';
		$tpl = '|NAME| (|FIRMA|)';
		return sel_array($to,$selected,'','ID','titel',$tpl);
}	}
function form_prefill(&$tpl,$input='') {
	global $dbobj,$tplobj,$sub_tpl,$vorgaben;
	if (!empty($input) && !empty($_REQUEST[$input])) $input = $_REQUEST[$input];
	else											 unset($input);
	if (empty($input) && !empty($_SESSION['logged']) && $_SESSION['logged']) {
		if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#person','Land'))	$sql = 'SELECT Login,Name,Email,Strasse,Ort,Telefon,Mobil,Land FROM #PREFIX#person WHERE ID = '.uid().' LIMIT 1;';
		else																	$sql = 'SELECT Login,Name,Email,Strasse,Ort,Telefon,Mobil FROM #PREFIX#person WHERE ID = '.uid().' LIMIT 1;';
		if ($input = $dbobj->exists(__file__,__line__,$sql)) {
			$input = $input[0];
			if (!empty($input['Name']) && strpos(' ',$input['Name'])!==false)	list($input['Vorname'],$input['Nachname'])	= explode(' ',$input['Name'],2);
			if (!empty($input['Ort'])  && strpos(' ',$input['Ort'])!==false)	list($input['PLZ'],$input['Stadt'])			= explode(' ',$input['Ort'],2);
			if (!empty($input['Login']))										$input['Benutzername'] = $input['Login'];
	}	}
	if (!empty($input))
		$tplobj->array2tpl2($tpl,$input,'#',true);
}
function build_select($data) {
	$values='';$preset='';$label='';$result='';$name='';$empty=true;$id='';$append='';
	extract($data);
	select_form($values,$preset,$label,$result,$name,$empty,$id,$append);
	return $values;
}
function select_form(&$values,$preset,$label,$result,$name,$empty=true,$id='',$append='') {
	# $values 	- das Array wird ergänzt, falls schon andere Vorlagen erstellt wurde.
	# $preset 	- setzt die Auswahl. Entweder nach einem Submit oder als Vorgabe.
	# $label 	- Bezeichnung des Auswalfelds
	# $result	- aus diesem Array wird die Auswahl aufgebaut.
	# $name		- id und name im Formular
	# $empty	- true wenn am Anfang der Auswahl ein leeres Feld gezeigt werden soll.
	# $append	- html-code wird angehängt.
	global $tplobj,$dbobj;
	$field = str_remove(strtolower($label),'%%');
	$place = $field;
	$values = array($place=>array('type' => 'select', 'name' => $name, 'label' => $label.': '));
	if (!empty($id))	array_merge($values[$place],array('id' => &$id));
	if (!empty($append))	array_merge($values[$place],array('append' => &$append));
	foreach($result as $key => $data) {
		if (isset($data['ID'])) {
			$values[$place]['keys'][$data['ID']] = $data['titel'];
			if ((is_array($preset) && in_array($data['ID'],$preset) || (!empty($preset) && $data['ID']==$preset)))	$values[$place]['default'][] = $data['ID'];
	}	}
	if ($empty && empty($data['ID']))		array_merge($values[$place],array('keys' => array('' => '')));
	$values[$place.'_NEU'] = array(
							'type' => 'input',
							'name' => $field.'[neu]',
							'size' => 20,
							'other'=> array('suffix' => ''),
							'keys' => array($label.' (neu)' => ''));
}
function fieldset($fieldset,$glue="\n",$n=0) {
	global $dbobj,$tplobj,$error,$sub_tpl;
	if (!empty($sub_tpl[$fieldset])) {
		if (!empty($_REQUEST[$fieldset])) {
			if (!empty($sub_tpl[$fieldset.'_top'])) $out['top'] = $sub_tpl[$fieldset.'_top'];
			foreach ($_REQUEST[$fieldset] as $k => $d) {
				$d['n'] = $n;
				$out[$k] = $tplobj->array2tpl($sub_tpl[$fieldset],$d,'#');
				$n++;
		}	}
		else	$out[] = $tplobj->array2tpl($sub_tpl[$fieldset],array('n'=>$n),'#');
		return implode($glue,$out);
}	}
function sel_array($daten,$selected='',$key='',$id='ID',$value='titel',$tpl='',$feld='') {
	global $dbobj,$tplobj,$sub_tpl,$vorgaben;
	$sub_tpl['sel_data_'.$key] = '';
	if (!empty($daten) && is_array($daten)) {
		if (empty($key) || empty($sub_tpl['sel_data_'.$key])) {
			if (is_array($daten)) {
				foreach ($daten as $k => $v) {
					if (is_array($v)) {
						if (!empty($tpl))	 		$v[$value] = $tplobj->array2tpl($tpl,$v);
						if (!empty($v[$feld]))		$name = $v[$feld];
						elseif (!empty($v[$value])) $name = $v[$value];
						else						$name = r_implode($v);
						if (!empty($v[$id]))		$sub_tpl['sel_data_'.$key] .= '<option value="'.$v[$id].'" #SEL_'.$v[$id].'#>'.$name.'</option>';
				#		elseif (!empty($v[$value])) $sub_tpl['sel_data_'.$key] .= '<option value="'.$k.'" #SEL_'.$k.'#>'.$name.'</option>';
						else						$sub_tpl['sel_data_'.$key] .= '<option value="'.$k.'" #SEL_'.$k.'#>'.$name.'</option>';
					} else							$sub_tpl['sel_data_'.$key] .= '<option value="'.$k.'" #SEL_'.$k.'#>'.$v.'</option>';
		}	}	}
		$sel_daten = $sub_tpl['sel_data_'.$key];
		if ($feld!='' && !empty($_REQUEST[$key][$feld]))				$selected = $_REQUEST[$key][$feld];
		elseif (!empty($_REQUEST[$key][$feld]))							$selected = $_REQUEST[$key];
		if (isset($selected) && $selected != '') {
			if (is_string($selected) && strpos($selected,',')!==false)	$selected = explode(',',$selected);
			if(is_numeric($selected))									$sel_daten = str_replace('#SEL_'.$selected.'#','selected="selected"',$sel_daten);
			elseif(is_array($selected)) {foreach ($selected as $select)	$sel_daten = str_replace('#SEL_'.$select.'#',  'selected="selected"',$sel_daten);}
	}	}
	if (!empty($sel_daten))	return $sel_daten;
}
function switch_type($user,$abschnitte) {
	global $lang_id,$sub_tpl;
	$default = array('PAGE_ID'=>'','PARENT_ID'=>'','TPL_ID'=>'','LANG_ID'=>$lang_id,'NAME'=>'data',
					 'KEY'=>'','SUBKEY'=>'','FELD'=>'','FKEY'=>'','ADDID'=>'',
					 'TYPE'=>'checkbox','ONCHANGE'=>'','CLASS'=>'','MULTIPLE'=>'',
					 'DATA'=>'','LABEL'=>true,'PREFIX'=>true,'VISIBILITY'=>'0,1',' '=>'',
					 'TPL_OPTION_SELECT'	=>'<option value="|A_ID|" #SEL_|A_ID|#|HIDDEN||SELECTED|>|T|</option>',
					 'TPL_OPTION_SELTITLE'	=>'<option value="|T|" #SEL_|A_ID|#|HIDDEN||SELECTED|>|T|</option>',
					 'TPL_OPTION_LABEL'		=>'<label for="|ID|_|A_ID|"|CLASS|><input |ONCHANGE||REQUIRED| type="|TYPE|" name="|NAME|" id="|ID|_|A_ID|" value="|A_ID|" #SEL_|A_ID|# /><span>|T|</span></label>',
					 'TPL_OPTION_NOLABEL'	=>'<span class="label"><input |ONCHANGE||REQUIRED| type="|TYPE|" name="|NAME|" id="|ID|_|A_ID|" value="|A_ID|" #SEL_|A_ID|# />|T|</span>',
					 );
	extract(merge_defaults_user($default,array_change_key_case($user,CASE_UPPER)),EXTR_SKIP);
	if ($FELD!='') {
		if ($KEY!='') {
			if (empty($_REQUEST[$KEY][$FELD]) && $cookie_data = my_readcookies($KEY,$FELD)) {
				$_REQUEST[$KEY][$FELD] = $cookie_data;
			}
			if ($FKEY!='' && $SUBKEY=='') {
				if (empty($DATA) && !empty($_REQUEST[$KEY][$FELD][$FKEY])) {
					if (!is_array($_REQUEST[$KEY][$FELD][$FKEY]))	$DATA[] = $_REQUEST[$KEY][$FELD][$FKEY];
					else											$DATA   = $_REQUEST[$KEY][$FELD][$FKEY];
				}
				$name = $KEY.'['.$FELD.']['.$FKEY.']';
				$id = $KEY.'_'.$FELD.'_'.$FKEY;
			} elseif ($SUBKEY!='') {
				if ($FKEY!='') {
					if (empty($DATA) && !empty($_REQUEST[$KEY][$SUBKEY][$FELD][$FKEY])) {
						if (!is_array($_REQUEST[$KEY][$SUBKEY][$FELD][$FKEY]))	$DATA[] = $_REQUEST[$KEY][$SUBKEY][$FELD][$FKEY];
						else													$DATA   = $_REQUEST[$KEY][$SUBKEY][$FELD][$FKEY];
					}
					$name = $KEY.'['.$SUBKEY.']['.$FELD.']['.$FKEY.']';
					$id = $KEY.'_'.$SUBKEY.'_'.$FELD.'_'.$FKEY;
				} else {
					if (empty($DATA) && !empty($_REQUEST[$KEY][$SUBKEY][$FELD])) {
						if (!is_array($_REQUEST[$KEY][$SUBKEY][$FELD]))	$DATA[] = $_REQUEST[$KEY][$SUBKEY][$FELD];
						else									$DATA   = $_REQUEST[$KEY][$SUBKEY][$FELD];
					}
					$name = $KEY.'['.$SUBKEY.']['.$FELD.']';
					$id = $KEY.'_'.$SUBKEY.'_'.$FELD;
				}
			} else {
				if (empty($DATA) && !empty($_REQUEST[$KEY][$FELD])) {
					if (!is_array($_REQUEST[$KEY][$FELD]))	$DATA = array($_REQUEST[$KEY][$FELD]);
					else									$DATA   = $_REQUEST[$KEY][$FELD];
				}
				$name = $KEY.'['.$FELD.']';
				$id = $KEY.'_'.$FELD;
			}
		} else {
			if (empty($_REQUEST[$FELD]) && $cookie_data = my_readcookies($FELD)) {
				$_REQUEST[$FELD] = $cookie_data;
			}
			if (empty($DATA) && !empty($_REQUEST[$FELD])) {
				if (!is_array($_REQUEST[$FELD]))	$DATA[] = $_REQUEST[$FELD];
				else								$DATA   = $_REQUEST[$FELD];
			}
			$name = $FELD;
			$id = $FELD;
	}	}
	if (empty($name))	$name = $NAME;
	if (empty($id))		$id = $NAME;
	$name .= '[X]';
#	if (!empty($id))	$id = str_replace(array("[","]"),'_',$id);
	if (!empty($ONCHANGE))							$ONCHANGE = ' onChange="change(this.id,\''.$ONCHANGE.'\');"';
	if (!empty($HIDDEN))							$HIDDEN	  = ' hidden';
	else											$HIDDEN	  = '';
	if (!empty($SELECTED))							$SELECTED = ' selected';
	else											$SELECTED	  = '';
	if (!empty($REQUIRED))							$REQUIRED = ' required';
	else											$REQUIRED	  = '';
	if (!empty($CLASS))								$CLASS	  = ' class="'.$CLASS.'"';
	else											$CLASS	  = '';
	if (!empty($MULTIPLE) && is_numeric($MULTIPLE))	$MULTIPLE = ' multiple="multiple" size="'.$MULTIPLE.'"';
	switch ($TYPE) {
		case 'select':	$chk = 'selected="selected"'; $tpl = $TPL_OPTION_SELECT;	break;
		case 'seltitle':$chk = 'selected="selected"'; $tpl = $TPL_OPTION_SELTITLE;	break;
		default:		$chk = 'checked="checked"';
			if ($LABEL===true) {
				if (!empty($sub_tpl[$TPL_OPTION_LABEL])) $TPL_OPTION_LABEL = str_replace(array('#ID#','#A_ID#','#ONCHANGE#','#REQUIRED#','#TYPE#','#T#','#NAME#','#SELECTED#'),array('|ID|','|A_ID|','|ONCHANGE|','|REQUIRED|','|TYPE|','|T|','|NAME|','#SEL_|A_ID|#'),$sub_tpl[$TPL_OPTION_LABEL]);
				$tpl = "\t".$TPL_OPTION_LABEL;
			}
			else				$tpl = $TPL_OPTION_NOLABEL;
			$tpl = str_replace(array('|CLASS|','|TYPE|'),array($CLASS,$TYPE),$tpl);
			break;
	}
	if (!empty($ADDID)) 	$id .= '_'.$ADDID;
	if (!empty($abschnitte) && is_array($abschnitte)) {
		$sub_tpl['count_sections']=0;
		$count_sections = count($abschnitte);
	#	$sub_tpl['count_sections'] = count($abschnitte);
		if (!empty($VALUE)) $values = get_daten(array('PAGE_ID'=>$PAGE_ID,'feld'=>$VALUE));
		foreach ($abschnitte as $a_id => $abschnitt) {
			$sub_tpl['count_sections']++;
			if (is_array($abschnitt) && !empty($abschnitt[$FELD]))											$t = $abschnitt[$FELD];
			elseif (is_array($abschnitt))																	$t = current($abschnitt);
			else																							$t = $abschnitt;
			if (!empty($sub_tpl['title_tpl']))																$t = str_replace(array('#A_ID#','#T#'),array($a_id,$t),$sub_tpl['title_tpl']);
			if (isset($sub_tpl['set_visibilities'][$a_id]) && $sub_tpl['set_visibilities'][$a_id]==0)		$sub_tpl['style'][] = '#'.$id.'_'.$a_id.' + * {color:red}';
			if (!empty($values[$a_id])) 																	$out = str_replace(array('value="|A_ID|"','#SEL_|A_ID|#'),array('value="'.$values[$a_id].'"','#SEL_'.$values[$a_id].'#'),$tpl);
			else																							$out = $tpl;
			switch ($TYPE) {
				case 'select':
				case 'seltitle':
				case 'radio':	if (empty($MULTIPLE))	$name = str_replace('[X]','[0]',$name);
				default:
					if (!empty($a_id))														$sel_abschnitte[$a_id] = str_replace(array("|ID|","|A_ID|","|T|","|NAME|"),array($id,$a_id,$t,$name),$out);
					
					if (empty($CLASS) && $sub_tpl['count_sections']==1)						$sel_abschnitte[$a_id] = str_replace("|CLASS|",' class="first"',$sel_abschnitte[$a_id]);
					elseif (empty($CLASS) && $sub_tpl['count_sections']==$count_sections)	$sel_abschnitte[$a_id] = str_replace("|CLASS|",' class="last"',$sel_abschnitte[$a_id]);
				break;
	}	}	}
	unset($sub_tpl['set_visibilities']);
	if (!empty($sel_abschnitte) && is_array($sel_abschnitte)) {
		if (!isset($sub_tpl['bitteauswaehlen']))	$sub_tpl['bitteauswaehlen'] = gt('%%BITTE_AUSWAEHLEN%%');
		if ($TYPE == 'select' || $TYPE == 'seltitle') {
			$add = '<select id="'.$id.'" name="'.$name.'"|ONCHANGE||CLASS||MULTIPLE||REQUIRED|>';
			if ($PREFIX)	$add .= str_replace(array("|ID|","|A_ID|","|T|","|NAME|","|HIDDEN|","|SELECTED|"),array('','',$sub_tpl['bitteauswaehlen'],'',$HIDDEN,$SELECTED),$tpl);
			array_unshift($sel_abschnitte,$add);
			array_push($sel_abschnitte,'</select>');
		}
		$out = implode("\n",$sel_abschnitte);
		if (!empty($DATA)) {
			if ($DATA == 'all')			$out = preg_replace('/#SEL_(\d)#/',$chk,$out);
			else {
				if (is_string($DATA))	$DATA = explode(',',$DATA);
				foreach ($DATA as $d) {
					if (!is_array($d)) 	$d = explode(',',$d);
					foreach ($d as $d2)	if ($d2!='') $out = str_replace('#SEL_'.$d2.'#',$chk,$out);
		}	}	}
	#	if (empty($REQUIRED)) $REQUIRED='';
		$out = str_replace(array('|ONCHANGE|','|CLASS|','|MULTIPLE|','|REQUIRED|','[X]'),array($ONCHANGE,$CLASS,$MULTIPLE,$REQUIRED,'[]'),$out);
		return $out;
}	}
function chkselected($data,$return='') {
	if 	   (!empty($data['rv']))		$data['VALUE'] = $data['rv'];
	elseif ($data['VALUE'] == 'TRUE')	$data['VALUE'] = true;
	if	   (!empty($data['FELD']) && !empty($_REQUEST[$data['KEY']][$data['FELD']]) && $_REQUEST[$data['KEY']][$data['FELD']] == $data['VALUE'])	$return = 'checked="checked"';
	elseif (!empty($data['FIELD'])&& !empty($_REQUEST[$data['KEY']][$data['FIELD']])&& $_REQUEST[$data['KEY']][$data['FIELD']]== $data['VALUE'])	$return = 'checked="checked"';
	elseif (!empty($data['KEY'])  && !empty($_REQUEST[$data['KEY']]) && $_REQUEST[$data['KEY']] == $data['VALUE'])									$return = 'checked="checked"';
	elseif (!empty($data) && $data == 1)																											$return = 'checked="checked"';
	if (!empty($data['rv']))	$return = $data['VALUE'].'" '.rtrim($return,'"');
	return $return;
}
class tplclass {
	function __construct() {
		$this->autofill=false;
		$this->replacements=false;
	}
	function read_tpls($tpl,$path='intern/tpl/',$subs=true) {
		global $vorgaben,$sub_tpl;
		$file_contents = $tpl;
		if (!is_array($file_contents)) {
			if (strpos($tpl,"\n")===false && $file = get_file($path.$tpl)) {
				$file_contents = file_get_contents($file);
			}
			preg_match_all("/<!-- TPL=(.*?) -->(.*?)<!-- \/TPL -->/si",$file_contents,$match2);
			if (!empty($match2[0])) {
				foreach($match2[1] as $key => $sub) {
					if ($sub != 'css') 		$tpls[$sub]			= $this->read_tpls_sub($match2[2][$key],$subs);
					else 					$sub_tpl['style'][]	= $match2[2][$key];
			}	}	else 					$tpls				= $this->read_tpls_sub($file_contents,$subs);
		} else {
			foreach($file_contents as $sub => $tpl) $tpls[$sub] = $this->read_tpls_sub($tpl,$subs);
		}
		return $tpls;
	}
	function read_tpls_sub($tpl,$subs) {
		global $vorgaben,$sub_tpl;
		if (!empty($_SESSION['permissions'])) $tpl = $this->match_rights($tpl);
		if ($subs) {
			$tpl = str_replace('Â§','§',$tpl);
			$tpl = $this->array2tpl($tpl,$sub_tpl,'§');
			$tpl = $this->array2tpl($tpl,$vorgaben,'§');
			$tpl = str_remove($tpl,array('§SID§','§PHPSESSID§'));
		}
		if ($this->replacements)	make_replacements($tpl);
		return $tpl;
	}
	function match_rights($tpl) {
		preg_match_all("/<!-- (XSUB|SUB)=(.*?) -->(.*?)<!-- \/(XSUB|SUB) -->/Dsi",$tpl,$match1); // SUB für gewöhnliche Subtemplates, XSUB für Extras, z.B. im Admin-Bereich
		if (!empty($match1[2])) {
			foreach($match1[2] as $key => $sub) {
				if (empty($_SESSION['permissions'][$sub])) $re_arr[] = $match1[0][$key];
				preg_match_all("/<!-- SSUB=(.*?) -->(.*?)<!-- \/SSUB -->/Dsi",$tpl,$match2);
				if (!empty($match2[1])) {
					foreach($match2[1] as $key => $sub) {
						if (empty($_SESSION['permissions'][$sub]))	$re_arr[] = $match2[0][$key];
		}	}	}	}
		if (!empty($re_arr)) $tpl = str_remove($tpl,$re_arr);
		return $tpl;
	}
	function array2tpl($tpl,$array,$delimiter='|',$onempty=false,$entities=false,$ri="\n",$prenl='') {
		$this->array2tpl2($tpl,$array,$delimiter,$onempty,$entities,$ri,$prenl);
		return $tpl;
	}
	function array2tpl2(&$tpl,$array,$delimiter='|',$onempty=false,$entities=false,$ri="\n",$prenl='') {	// Füllt ein Template mit den Daten aus einem Array.
		global $sub_tpl;
		if (is_array($tpl)) {
			foreach ($tpl as $t) {
				if (isset($sub_tpl[$t]))	$t2 = $sub_tpl[$t];
				else						$t2 = $t;
				$this->do_replace($t2,$array,$delimiter,$onempty,$entities,$ri,$prenl);
				$out[$t] = $t2;
			}
			if (!empty($out))	$tpl = $out;
		} else {
			$this->do_replace($tpl,$array,$delimiter,$onempty,$entities,$ri,$prenl);
		}
	}
	function do_replace(&$tpl,$array,$delimiter,$onempty,$entities,$ri,$prenl) {
		if (strpos($delimiter,',')!==false)	$delimiters = explode(',',$delimiter);
		if (is_array($array)) {
			while(list($key,$a_data) = myEach($array)) {
				if (!empty($delimiters[0]))	{
					foreach ($delimiters as $delimiter) $replace[] = $delimiter.strtoupper($key).$delimiter;
				} else {
					$replace = $delimiter.strtoupper($key).$delimiter;
				}
				if ($onempty===true && empty($a_data)) 		$a_data = '';
				elseif (is_string($onempty)&&empty($a_data))$a_data = $onempty;
				if (!empty($a_data) && is_array($a_data))	$a_data = r_implode($ri,$a_data,true);
				if ($entities)								$a_data = my_htmlentities($a_data);
				if (!empty($prenl))							$a_data = preg_replace("/\n/", "\n".$prenl, $a_data);
				if (!empty($a_data) && !empty($tpl))	{
					if (is_array($tpl)) {
						foreach($tpl as $k => $v) {
							$tpl[$k] = str_replace($replace,stripslashes(r_implode($a_data)),$v);
						}
					} else {
						$tpl = str_replace($replace,stripslashes(r_implode($a_data)),$tpl);
				}	}
	}	}	}
	function build_options($daten,$selected=array(),$options = '') {
		if (!empty($daten) && is_array($daten)) {
			$sels = explode(',',implode(',',$selected));
			$first = current($daten);
			if (!empty($first['separate'])) $separate = $first['separate'];
			while(list($key,$value) = myEach($daten)) {
				if (is_array($value))	$value = trim(current($value));
				else					$value = trim($value);
				$value = str_replace('&amp;','&',$value);
				if (!empty($daten[$key]['separate']) && $separate != $daten[$key]['separate']) {
					$options .= '<option value="">---</option>'."\n";
					$separate = $daten[$key]['separate'];
				}
				$keys = explode(',',$key);
				if (!empty($selected) && array_intersect($keys,$sels))	$options .= '<option value="'.$key.'" selected="selected">'.$value.'</option>'."\n";
				else													$options .= '<option value="'.$key.'">'.$value.'</option>'."\n";
		}	}
		return $options;
	}
	function build_values($daten,$key,$label,$first,$name,$value_key,$values=array()) {
		if (!empty($this -> id)) 				$id = $this -> id;
		else									$id = '';
		if (!empty($first) && !empty($daten))	$daten = array(0=>array($key=>$first))+$daten;
		if (!is_array($daten))					$daten[0][$key] = 'Noch keine Auswahl möglich';
		foreach($daten as $keys => $data) $ids[$keys] = $data[$key];
		$values[$value_key] = array('type' => 'select','id' => $id,'name' => $name,'label' => $label.': ','size' => 1);
		$values[$value_key]['keys'] = $ids;
		unset($this -> id);
		return $values;
	}
	function build_form(&$tpl,$values,$delimiter='|') {	# Erstellt ein Formular. Das sieht jetzt etwas kompliziert aus, aber so lassen sich sogar dynamische Formulare erstellen.
		foreach ($values as $platzhalter => $data) {
			if (!isset($data['keys']))		unset($data['keys']);
			if (!isset($data['range']))		unset($data['range']);
			if (!isset($data['prefix']))	$prefix[$platzhalter]='';
			if (empty($data['append']))		$data['append'] = '';
			if (!isset($data['label']))		unset($data['label']);
			if (empty($data['type']))		$type = 'text';
			else							$type = $data['type'];
			if  (isset($data['range']) && is_array($data['range'])) {
				$start = $data['range']['start'];
				$stop = $data['range']['stop'];
				if (empty($data['range']['incr']))	$incr = ($stop - $start)/abs($stop - $start);
				else								$incr = $data['range']['incr'];
			}
			if (isset($data['other']) && is_array($data['other'])) {
				foreach ($data['other'] as $other => $okey)	${$other}[$platzhalter] = $okey;
			}
			if (empty($style))			$style = '';
			if (empty($data['size']))	$size = 1;
			else 						$size = $data['size'];
			if (empty($data['check']))	$check = '';
			else 						$check = $data['check'];
			if (!empty($data['name']))	$name = $data['name'];
			else						$name = $platzhalter;
			if (!empty($data['id']))	$id = $data['id'];
			else						$id = trim(str_replace('[','_',str_remove($name,']')),'_');
			if ($this -> defaults($platzhalter,$data,$name,$check,$data))	$data['default'] = $this -> defaults;
			if (empty($script[$platzhalter]))	$script[$platzhalter] = '';
			if (empty($suffix[$platzhalter]))	$suffix[$platzhalter] = '';
			if (!isset($spacer[$platzhalter]))	$spacer[$platzhalter] = '&nbsp;';
			switch ($type) {
				case 'select':
					if (isset($data['label']))	$form = '<label for="'.$id.'">'.$data['label'].'</label>'."\n";
					else						$form = '';
					if (empty($multiple[$platzhalter]))		$multiple[$platzhalter] = '';
					else $multiple[$platzhalter] = 'multiple="multiple"';
					if (isset($size)) $size = 'size="'.$size.'"';
					else $size='';
					$form .= '<select name="'.$name.'" id="'.$id.'" '.$size.' '.$script[$platzhalter].' '.$this ->style($style,$platzhalter).' '.$multiple[$platzhalter].'>'."\n";
					if (isset($data['prefix']['key'])) {
						$key = $data['prefix']['key'];
						$form .= '	<option value="'.$key.'" '.$this -> selected($data,$key,'selected="selected"').'>'.$suffix[$platzhalter].$data['prefix']['value'].'</option>'."\n";
						$form = str_replace('|key|',$key,$form);
					}
					if (isset($data['keys']) && is_array($data['keys'])) {
						foreach ($data['keys'] as $key => $value) {
							$form .= '	<option value="'.$key.'" '.$this -> selected($data,$key,'selected="selected"').'>'.$suffix[$platzhalter].$this -> value($data,$key,$type).'</option>'."\n";
							$form = str_replace('|key|',$key,$form);
					}	}
					elseif(isset($incr)) {
						$key = $start;
						for ($i = 0; $i <= abs($stop - $start); $i++) {
							$form .= '	<option value="'.$key.'" '.$this -> selected($data,$key,'selected="selected"').'>'.$suffix[$platzhalter].$this -> value($data,$key,$type).'</option>'."\n";
							$form = str_replace('|key|',$key,$form);
							$key += $incr;
					}	}
					$form .= '</select>'."\n";
				break;
				case 'textarea':
					if (empty($rows[$platzhalter]))	$rows[$platzhalter] = '';
					if (empty($cols[$platzhalter]))	$cols[$platzhalter] = '';
					if (isset($data['label']))		$form = '<label for="'.$id.'">'.$data['label'].'</label>'."\n";
					else							$form = '';
					if (is_array($data['keys'])) {
						foreach ($data['keys'] as $key => $value) {
							$form .= '<textarea id="'.$id.'" name="'.$name.'" '.$rows[$platzhalter].' '.$cols[$platzhalter].' '.$script[$platzhalter].' '.$this ->style($platzhalter,$style,$key).'>'.$this -> value($data,$key,$type).'</textarea>';
							$form = str_replace('|key|',$key,$form);
					}	}
					elseif(isset($incr)) {
						$key = $start;
						for ($i = 0; $i <= abs($stop - $start); $i++) {
							$form .= '<textarea id="'.$id.'" name="'.$name.'" '.$rows[$platzhalter].' '.$cols[$platzhalter].' '.$script[$platzhalter].' '.$this ->style($platzhalter,$style,$key).'>'.$this -> value($data,$key,$type).'</textarea>';
							$form = str_replace('|key|',$key,$form);
							$key += $incr;
					}	}
				break;
				case 'hidden':
					$form = '';
					if (isset($data['keys'])) {
						foreach ($data['keys'] as $key => $value) {
							$form .= '<input type="'.$type.'" id="'.$id.'" name="'.$name.'" value="'.$value.'" />'."\n";
							$form = str_replace('|key|',$key,$form);
					}	}
					elseif(isset($incr)) {
						$key = $start;
						for ($i = 0; $i <= abs($stop - $start); $i++) {
							$form .= '<input type="'.$type.'" id="'.$id.'" name="'.$name.'" value="'.$key.'" />'."\n";
							$form = str_replace('|key|',$key,$form);
							$key += $incr;
					}	}
				break;
				case 'radio':
				case 'checkbox':
					$form = '';
					if (isset($data['keys'])) {
						foreach ($data['keys'] as $key => $value) {
							if (!isset($data['label']))											$label = $key;
							elseif (is_array($data['label']) && !empty($data['label'][$key]))	$label = $data['label'][$key];
							else 																$label = $data['label'];
							$form .= '<input type="'.$type.'" id="'.$id.'" name="'.$name.'" size="'.$size.'" value="'.$this -> value($data,$key,$type).'" '.$this -> selected($data,$key,'checked="checked"').' '.$script[$platzhalter].' '.$this ->style($platzhalter,$style,$key).' />'.$spacer[$platzhalter].'
										<span>'.$prefix[$platzhalter].$label.$suffix[$platzhalter].'</span>'."\n";
							$form = str_replace('|key|',$key,$form);
					}	}
					elseif (isset($start)) {
						$key = $start;
						for ($i = 0; $i <= abs($stop - $start); $i++) {
							if (!isset($data['label']))											$label = $key;
							elseif (is_array($data['label']) && !empty($data['label'][$key]))	$label = $data['label'][$key];
							else 																$label = $data['label'];
							$form .= '<input type="'.$type.'" id="'.$id.'" name="'.$name.'" size="'.$size.'" value="'.$this -> value($data,$key,$type).'" '.$this -> selected($data,$key,'checked="checked"').' '.$script[$platzhalter].' '.$this ->style($platzhalter,$style,$key).' />'.$spacer[$platzhalter].'
										<span>'.$prefix[$platzhalter].$label.$suffix[$platzhalter].'</span>'."\n";
							$form = str_replace('|key|',$key,$form);
							$key += $incr;
					}	}
					else $form .= $key.$suffix[$platzhalter].'<input type="'.$type.'" id="'.$id.'" name="'.$name.'" size="'.$size.'" value="'.$this -> value($data,$key,$type).'" '.$script[$platzhalter].' '.$this ->style($platzhalter,$style,$key).' />'.$spacer[$platzhalter]."\n";
				break;
				default:
					$form = '';
					if (isset($data['keys'])) {
						foreach ($data['keys'] as $key => $value) {
							if (!isset($data['label']))											$label = $key;
							elseif (is_array($data['label']) && !empty($data['label'][$key]))	$label = $data['label'][$key];
							else 																$label = $data['label'];
							$form .= '<label for="'.$id.'">'.$prefix[$platzhalter].$label.$suffix[$platzhalter].'</label>
								<input type="'.$type.'" id="'.$id.'" name="'.$name.'" size="'.$size.'" value="'.$this -> value($data,$key,$type).'" '.$this -> selected($data,$key,'checked="checked"').' '.$script[$platzhalter].' '.$this ->style($platzhalter,$style,$key).' />'.$spacer[$platzhalter]."\n";
							$form = str_replace('|key|',$key,$form);
					}	}
					elseif (isset($start)) {
						$key = $start;
						for ($i = 0; $i <= abs($stop - $start); $i++) {
							if (!isset($data['label']))											$label = $key;
							elseif (is_array($data['label']) && !empty($data['label'][$key]))	$label = $data['label'][$key];
							else 																$label = $data['label'];
							$form .= '<label for="'.$id.'">'.$prefix[$platzhalter].$label.$suffix[$platzhalter].'</label>
								<input type="'.$type.'" id="'.$id.'" name="'.$name.'" size="'.$size.'" value="'.$this -> value($data,$key,$type).'" '.$this -> selected($data,$key,'checked').' '.$script[$platzhalter].' '.$this ->style($platzhalter,$style,$key).' />'.$spacer[$platzhalter]."\n";
							$form = str_replace('|key|',$key,$form);
							$key += $incr;
					}	}
					else $form .= $key.$suffix[$platzhalter].'<input type="'.$type.'" id="'.$id.'" name="'.$name.'" size="'.$size.'" value="'.$this -> value($data,$key,$type).'" '.$script[$platzhalter].' '.$this ->style($platzhalter,$style,$key).' />'.$spacer[$platzhalter]."\n";
				break;
			}
			$tpl = str_replace($delimiter.strtoupper($platzhalter).$delimiter,$form.$data['append'],$tpl);
			unset($data);
	}	}
	function selected($data,$key,$type) {
		if (!empty($data['default']))	$check = $data['default'];
		if (isset($check) && is_array($check)) {
			if (in_array($key,$check))		$selected = $type;
			elseif	(!empty($data['id']))	$selected = '|'.strtoupper($data['id']).'_'.$key.'|';
			else							$selected = '';
		} else {
			if (!empty($check) && $key == $check)	$selected = $type;
			elseif	(!empty($data['id']))			$selected = '|'.strtoupper($data['id']).'_'.$key.'|';
			else									$selected = '';
		}
		return $selected;
	}
	function value($data,$key,$type) {
		$value = '';
		if (!empty($data['default'][$key]) && ($type == 'input' || $type == 'textarea'))$value = $data['default'][$key];
		elseif (!empty($data['default']) && !is_array($data['default'])) 				$value = $data['default'];
		elseif (!empty($data['default'][$key]) && is_array($data['default'][$key]))		$value = $data['default'][$key];
		elseif (!empty($data['keys'][$key]))											$value = $data['keys'][$key];
		elseif (!empty($data['range'])) 												$value = $key ;
		if (is_array($value))															$value = '';
		return $value;
	}
	function style($platzhalter,$style='',$key='') {
		if 		(!empty($key) && !empty($style) && isset($platzhalter[$style][$key]))	return 'style="'.$platzhalter[$style][$key].'"';
		elseif 	(!empty($style) && isset($platzhalter[$style]))							return 'style="'.$platzhalter[$style].'"';
		else																			return false;
	}
	function defaults($platzhalter,$data,$name,$check='') {
		if (isset($data['label']))	$label = $data['label'];
		else 						$label = '';
		$name = str_remove($name,array('[|key|]',']'));
		$name = explode('[',$name);
		if (isset($_REQUEST[$name[0]]) && $this->autofill) {
			$arr = $_REQUEST[$name[0]];
			for ($i=1;$i<count($name);$i++) {
				if (isset($arr[$name[$i]]) && is_array($arr[$name[$i]])) $arr = $arr[$name[$i]];
			}
			$this -> defaults = $arr;
			return true;
		} else return false;
}	}
?>
