<?PHP
function append_files() {
	global $dbobj,$sub_tpl,$vorgaben;
	if (!empty($sub_tpl['oldimg'])) {
		foreach ($sub_tpl['oldimg'] as $src) {
			if (empty($sub_tpl['altimg'][$src])) {
				$ext = pathinfo($src, PATHINFO_EXTENSION);
				$src = get_file($src);
				$dst = str_replace('.'.$ext,'.webp',$src);
				if (!is_file($dst) && is_file($src)) {
					$file = save_webp($src,$dst);
				}
				list($page_id,$part_id,$lang_id,$rest) = explode('_',endstr($src,'/'));
				$sql_a[$src] = "UPDATE	#PREFIX#bilder SET altext = 'webp'
							WHERE	PAGE_ID = ".$page_id." 	  AND 	PART_ID = '".$part_id."'";
				if (is_numeric($lang_id))	$sql_a[$src] .= " AND 	LANG_ID = ".$lang_id;
				$sql_a[$src] .= 	";";
	}	}	}
	if (!empty($sql_a)) {
			$dbobj->multiquery(__file__,__line__,$sql_a);
	}
}
function prepare_files() {
	global $external_functions;
	$external_functions['download.php'] = 'provide_downloads';
	$external_functions['upload.php']	= 'upload_php';
}
function oldimage($bild) {
	global $sub_tpl,$vorgaben;
	if (!empty($sub_tpl['oldimg'][$bild['img']])) {
		return $sub_tpl['oldimg'][$bild['img']];
	}
}
function altimage($bild) {
	global $sub_tpl,$vorgaben;
#	if (empty($bild['altext']))	$bild['altext'] = 'webp';
	if (!empty($sub_tpl['altimg'][$bild['img']])) {
		return $sub_tpl['altimg'][$bild['img']];
	}
}
function ifaltimg($data) {
	global $sub_tpl,$vorgaben;
	$default = array('img'=>'', 'tpl'=>'', 'size'=>'', 'altext'=>'webp');
	$file = false;
	$data['altimg'] = trim(str_replace(array('gif','.png','.jpg','.jpeg'),'.'.$data['altext'],$data['img']),'/');
	if (empty($data['size'])) $data['altimg'] = str_replace('/thumbs/','/',$data['altimg']);
	if (get_file($data['altimg'])) {
		return str_replace($data['img'],'/'.$data['altimg'],$data['tpl']);
	} else {
		unset($sub_tpl['altimg'][$data['img']]);
		$sub_tpl['oldimg'][$data['img']] = $data['img'];
		return false;
	}
}
function bgimg($data) {
	global $sub_tpl,$active,$page_id,$lang_id,$active,$vorgaben;
	if (empty($data)) $data = 'hintergrund';
	if (!empty($sub_tpl[$data]))		$tpl = $sub_tpl[$data];
	elseif (!empty($sub_tpl['bgimg']))	$tpl = $sub_tpl['bgimg'];
	if (!empty($tpl)) {
		$bild = '';$bg = '';
		if (!empty($sub_tpl['bilder'][$data])) {
			$bilder = $sub_tpl['bilder'][$data];
		} elseif ($bg = get_images(array('PAGE_ID'=>$active,'LANG_ID'=>$lang_id,'PART_ID'=>$data,'parents'=>true))) {
			if (!empty($bg[$data]))	$bilder = $bg[$data];
		}
		if (!empty($bilder)) {
			if (!empty($active) && is_array($active)) {
				$l = end($active);
				while (!empty($l) && empty($bild)) {
					if (!empty($bilder[$l]))$bild = current($bilder[$l]);
					$l = prev($active);
			}	}
			if (empty($bild))	$bild = current(current($bilder));
		}
		if (!empty($bild))		$out = str_replace(array('$IMG$','#BGIMG#'),$bild,$tpl);
	}
	if (!empty($out))			return $out;
}
function mimg($data) {return extra_img($data,'menu');}
function mimg2($data) {return extra_img($data,'menu2');}
function himg($data) {return extra_img($data,'header');}
function extra_img($data,$PART_ID='') {
	global $tplobj,$sub_tpl,$page_id,$lang_id,$vorgaben;
	$sub_tpl['raw'] = '$IMG$'; $tpl = 'raw';
	if (!empty($data) && is_string($data))	{
		$d = $data;
		unset($data);
		if (!empty($vorgaben[$d])) {
			$data['PAGE_ID'] = $vorgaben[$d];
		} else {
			$data['PAGE_ID'] = $d;
		}
	}
	if (empty($data['tpl'])) {
		if ($PART_ID=='menu' && !empty($sub_tpl['mimg']))		$tpl = 'mimg';
		elseif ($PART_ID=='header' && !empty($sub_tpl['himg']))	$tpl = 'himg';
		elseif (!empty($sub_tpl['bgimg']))						$tpl = 'bgimg';
	}
	$default = array('PAGE_ID'=>$page_id,'PART_ID'=>$PART_ID,'tpl'=>$tpl,'LANG_ID'=>$lang_id,'limit'=>1,'size'=>'');
	if (is_array($data))	$data = array_merge($default,$data);
	else					$data = $default;
	if (!empty($sub_tpl[$tpl]) && $img = get_images($data)) {
		$data['img'] = r_implode($img[$PART_ID],'');
		return $tplobj->array2tpl($sub_tpl[$tpl],$data,'$');
}	}
function fetchimage($d,$out='') {
	global $tplobj,$page_id,$unterseite_id,$sub_tpl,$vorgaben;
	$default = array('PAGE_ID'=>'', 'PART_ID'=>'', 'parents'=>'', 'limit'=>1, 'raw'=>true, 'tpl'=>'', 'size'=>'thumbs', 'order'=>'Dateiname', 'asc'=>1, 'pos'=>0, 'base' =>false, 'implode'=>',','path'=>'','set'=>'');
	if	(!empty($d['PART_ID']) && $d['PART_ID'] == 'unterseite_id')					$data['PART_ID'] = $unterseite_id;
	if	(empty($d) || empty($d['PAGE_ID']))											$data['PAGE_ID'] = $page_id;
	if	(!is_array($d))																$data['PAGE_ID'] = $d;
	else {
		if (empty($data))	$data = $d;
		else				$data = array_merge($d,$data);
	}
	if		(!is_numeric($data['PAGE_ID']) && !empty($sub_tpl[$data['PAGE_ID']]))	$data['PAGE_ID'] = $sub_tpl[$data['PAGE_ID']];
	elseif	(!is_numeric($data['PAGE_ID']) && !empty($vorgaben[$data['PAGE_ID']]))	$data['PAGE_ID'] = $vorgaben[$data['PAGE_ID']];
	$data = array_merge($default,$data);
	if (!empty($data['tpl']) && !empty($sub_tpl[$data['tpl']]))	$tpl = $sub_tpl[$data['tpl']];
	elseif (!empty($sub_tpl['img']))							$tpl = $sub_tpl['img'];
	else														$tpl = '$SRC$';
	unset($data['tpl']);
	if ($images = get_images($data)) {
		$data['src'] = r_implode($data['implode'],$images);
		$data['srcs'] = explode(',',$data['src']);
		foreach ($data['srcs'] as $src) {
			if ($data['base']) $src = base($src) ;
			elseif ($data['set'] == 'absolute')	$src = linkto(array('PAGE_ID'=>$vorgaben['home']['PAGE_ID'],'suffix'=>ltrim($src,'/'),'SET'=>$data['set']));
			$out .= str_replace('$SRC$',$src,$tpl);
		}
		return $tplobj->array2tpl($out,$data,'$');
}	}
function bilder($data) {
	global $sub_tpl;
	if (!empty($sub_tpl['bilder'][$data]))	return $sub_tpl['bilder'][$data];
	else									return false;
}
function bigimg($data) {
	global $vorgaben;
	if (strpos('data:',$data)===0) 	return $data;
	else							return str_replace($vorgaben['img_path'].'/thumbs/',$vorgaben['img_path'].'/',$data);
}
function provide_stream($path=false,$mime=false) {
	global $vorgaben;
	if (is_file($path)) {
    ob_clean();    // Clears the cache and prevent unwanted output
		$finfo = new finfo(FILEINFO_MIME);
		$mime = $finfo->file($path);					// Determine file mimetype
		header("Content-Type: " . $mime);	// Set response content-type
		$size = filesize($path);						// File size
		if (isset($_SERVER['HTTP_RANGE'])) {			// Check if we have a Range header
			list($specifier, $value) = explode('=', $_SERVER['HTTP_RANGE']);	// Parse field value
			if ($specifier != 'bytes') {										// Can only handle bytes range specifier
				header('HTTP/1.1 400 Bad Request');
				return;
			}
			list($from, $to) = explode('-', $value);		// Set start/finish bytes
			if (!$to) {
				$to = $size - 1;
			}
			header('HTTP/1.1 206 Partial Content');					// Response header
			header('Accept-Ranges: bytes');
			header('Content-Length: ' . ($to - $from));				// Response size
			header("Content-Range: bytes {$from}-{$to}/{$size}");	// Range being sent in the response
			$fp = fopen($path, 'rb');								// Open file in binary mode
			$chunkSize = 8192;										// Read in 8kb blocks
			fseek($fp, $from);										// Advance to start byte
			while(true){											// Send the data
				if(ftell($fp) >= $to){								// Check if all bytes have been sent
					break;
				}
				echo fread($fp, $chunkSize);						// Send data
				ob_flush();											// Flush buffer
				flush();
			}
		} else {
			header('Content-Length: ' . $size);						// If no Range header specified, send everything
			readfile($path);										// Send file to client
		}
	} else {
		header("HTTP/1.0 404 Not Found");
		return geterror(404);
	}
}
function provide_downloads($internal=false) {
	global $vorgaben;
	$d = 'downloads';
	if (!empty($_REQUEST['d']) && (!is_numeric($_SESSION['status']) || $internal))		$d = urldecode($_REQUEST['d']);
	if (!empty($_REQUEST['f']) || (!empty($_REQUEST['p']) && is_numeric($_REQUEST['p']) && !empty($_REQUEST['s']))) {
		if (empty($_REQUEST['u']) || !is_numeric($_REQUEST['u'])) 						$_REQUEST['u'] = $_REQUEST['p'];
		if (!empty($_REQUEST['f']))	{
			if		(is_file($vorgaben['base_dir'].$d.'/'.$_REQUEST['f']))										$file = $vorgaben['base_dir'].$d.'/'.$_REQUEST['f'];
			elseif	(!empty($vorgaben['grp__cms']) && is_file($vorgaben['grp__cms'].'/'.$d.'/'.$_REQUEST['f']))	$file = $vorgaben['grp__cms'].'/'.$d.'/'.$_REQUEST['f'];
			elseif	(!empty($vorgaben['base_cms']) && is_file($vorgaben['base_cms'].'/'.$d.'/'.$_REQUEST['f']))	$file = $vorgaben['base_cms'].'/'.$d.'/'.$_REQUEST['f'];
			else																								$file = $_REQUEST['f'];
		} elseif (!empty($_REQUEST['a']) && is_numeric($_REQUEST['a'])) {
			$x = get_vorlage(array('PAGE_ID'=>$_REQUEST['p'],'PART_ID'=>$_REQUEST['s'],'field'=>'nutzer_select'));
			if ($x == '%NUTZER_SELECT%' || (!empty($x) && (!is_numeric($_SESSION['status']) || strpos($x,$_SESSION['status'])!==false))) {
				$files = get_files(array('PAGE_ID'=>$_REQUEST['p'],'PART_ID'=>$_REQUEST['s'],'tpl'=>''));
				$file = $files[$_REQUEST['s']]['fpath'];
			}
		} else {
			$files = get_files(array('PAGE_ID'=>$_REQUEST['p'],'PART_ID'=>$_REQUEST['s'],'uid'=>$_REQUEST['u'],'tpl'=>''));
			$file = $files[$_REQUEST['s']]['fpath'];
	}	}
	if (!empty($file)) {
		$loc = loc($file);
#		header("Pragma: public");							// Prepare headers
		header('Expires: '.gmdate('D, d m Y H:i:s', time() + 60*60*24*21).' GMT');
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public", false);
		header("Accept-Ranges: bytes");
		header("Content-Description: File Transfer");
		header("Content-Type: " . $loc['mimetype']);
		header("Content-Disposition: attachment;filename=\"".$loc['name']."\";");
		header("Content-Transfer-Encoding: ".$loc['encode']);
		header("Content-Length: " . filesize($file));
		if ($stream = fopen($file, 'rb')) {					// Send file for download
			while(!feof($stream) && connection_status() == 0){
				set_time_limit(0);							//reset time limit for big files
				print(fread($stream,1024*8));
				flush();
			}
			fclose($stream);
		}
		return true;
	} else {
		header("HTTP/1.0 404 Not Found");
		return geterror(404);
}	}
function show_files($data) {
	global $page_id;
	if (empty($data['PAGE_ID']))	$data['PAGE_ID'] = $page_id;
	if ((empty($data['a']) || !is_numeric($data['a']))
			|| (!empty($_SESSION['status']) && (!is_numeric($_SESSION['status']) || (strpos($data['a'],$_SESSION['status'])!==false))
			|| (!empty($data['uid']) && $_SESSION['uid']==$data['uid']))) {
		return get_files($data);
}	}
function get_filepath($dir,$file='') {
	global $sub_tpl,$vorgaben;
	if (empty($file)) {
		if (is_dir($vorgaben['base_dir'].$dir))											$path = $vorgaben['base_dir'].$dir;
		elseif (!empty($vorgaben['grp__cms']) && is_dir($vorgaben['grp__cms'].$dir))	$path = $vorgaben['grp__cms'].$dir;
		elseif (!empty($vorgaben['base_cms']) && is_dir($vorgaben['base_cms'].$dir))	$path = $vorgaben['base_cms'].$dir;
		else $path = false;
	} else {
		$path = get_file($dir.'/'.$file);
	}
	return $path;
}
function get_file($file) {
	global $sub_tpl,$vorgaben,$return_file;
	if (empty($return_file[$file])) {
		$f = str_remove($file,array($vorgaben['sub_dir'],'../'));
		if 		(!empty($vorgaben['base_dir']) && is_file($vorgaben['base_dir'].$f)) $return_file[$file] = $vorgaben['base_dir'].$f;
		elseif	(!empty($vorgaben['grp__cms']) && is_file($vorgaben['grp__cms'].$f)) $return_file[$file] = $vorgaben['grp__cms'].$f;
		elseif	(!empty($vorgaben['base_cms']) && is_file($vorgaben['base_cms'].$f)) $return_file[$file] = $vorgaben['base_cms'].$f;
	}
	if (!empty($return_file[$file]))	return $return_file[$file];
	else								return false;
}
function get_files($data) {
	global $tplobj,$dbobj,$vorgaben,$sub_tpl;
	$default = array('PAGE_ID'=>0,'PART_ID'=>0,'TPL_ID'=>'','FILE'=>'','uid'=>'','prefix'=>'','tpl'=>'admin/dateien.inc.html');
	extract(merge_defaults_user($default,$data),EXTR_SKIP);
	if (is_array($PAGE_ID)) 										$PAGE_ID = '0,'.implode(',',$PAGE_ID);
	elseif (empty($PAGE_ID) && !empty($vorgaben['alle_Seiten']))	$PAGE_ID = &$vorgaben['alle_Seiten'];
	if (!empty($sub_tpl[$tpl]))										$tpl = $sub_tpl[$tpl];
	elseif (!empty($tpl))											$tpl = $tplobj->read_tpls($tpl);
	if (is_numeric($PAGE_ID)) {
		$sql = "SELECT * FROM #PREFIX#dateien";
		if (is_numeric($TPL_ID) || is_numeric($PART_ID))	$sql .= ",#PREFIX#seiten_attr";
		if (is_numeric($PART_ID))	$sql .= ",#PREFIX#kategorien"; // $PART_ID is used for status (i.e. access rights).
		if (is_numeric($TPL_ID))	$sql .= "\nWHERE		#PREFIX#dateien.PAGE_ID = #PREFIX#seiten_attr.PAGE_ID AND #PREFIX#seiten_attr.TPL_ID = '".$dbobj->escape($TPL_ID)."'";
		else						$sql .= "\nWHERE		#PREFIX#dateien.PAGE_ID = '".$dbobj->escape($PAGE_ID)."'";
		if (is_numeric($PART_ID)) {
									$sql .= "\nAND			#PREFIX#seiten_attr.PAGE_ID = #PREFIX#dateien.PAGE_ID AND #PREFIX#seiten_attr.KAT_ID = #PREFIX#kategorien.KAT_ID";
									$sql .= sql_kat_status();
		}
	} else							$sql = "SELECT * FROM #PREFIX#dateien WHERE	PAGE_ID = '".$dbobj->escape($PAGE_ID)."'";
	if (!empty($PART_ID))			$sql .= "\nAND 	PART_ID		IN ('".$dbobj->escape($PART_ID)."')";
#	if (!empty($FILE))				$sql .= "\nAND 	Dateiname	=  '".$FILE."'";
	$sql .= "\nORDER BY 	#PREFIX#dateien.Position";
	if ($dateien = $dbobj->withkey(__file__,__line__,$sql,'PART_ID',false,'filekey')) {
		foreach ($dateien as $part_id => $d) {
			foreach ($d as $filekey => $datei) {
				if (is_file($vorgaben['base_dir'].'downloads/'.$prefix.$datei['Dateiname']))						$datei['fpath']='downloads/'.$prefix.$datei['Dateiname'];
				elseif (is_file($vorgaben['base_dir'].'downloads/'.$part_id.'_'.$PAGE_ID.'_'.$datei['Dateiname']))	$datei['fpath']='downloads/'.$part_id.'_'.$PAGE_ID.'_'.$datei['Dateiname'];
				if (isset($datei['fpath'])) {
					$datei['uid'] = $uid;
					$datei['page_id'] = $PAGE_ID;
					$datei['part_id'] = $part_id;
					$datei['size'] = bytesToSize(filesize($datei['fpath']));
					if ($tpl != '')	$datei_out[$part_id][$filekey] = $tplobj->array2tpl($tpl,$datei,'|,#,$,§');
					else			$datei_out[$part_id][$filekey] = $datei;
	}	}	}	}
	if (!empty($datei_out))	return $datei_out;
	else					return false;
}
function get_images($data) {
	global $dbobj,$tplobj,$first_lang_id,$lang_id,$vorgaben,$sub_tpl;
	$default = array('PAGE_ID'=>0,'LANG_ID'=>'','folder'=>'bilder','PART_ID'=>'','size'=>'','out'=>'','path'=>'','fn'=>'','not'=>'','only'=>'',
					 'order'=>'','limit'=>'','avisi'=>false,'aexcl'=>false,'parents'=>false,'siblings'=>false,'tree'=>false,
					 'tpl'=>'','visibility'=>1,'pos'=>false,'altext'=>'','fix_lang'=>false,'imginfo'=>false);
	extract(merge_defaults_user($default,$data),EXTR_SKIP);
	if (is_array($PAGE_ID)) 									$PAGE_ID = '0,'.r_implode($PAGE_ID);
	elseif (empty($PAGE_ID) && !empty($vorgaben['alle_Seiten']))$PAGE_ID = &$vorgaben['alle_Seiten'];
	elseif (strpos($PAGE_ID,'#')!==false) 						$PAGE_ID = '0';
	if (!empty($tpl) && !empty($sub_tpl[$tpl]))	$tpl = &$sub_tpl[$tpl];
	elseif (!empty($tpl))						$tpl = $tplobj->read_tpls($tpl);
	if (!empty($LANG_ID) && $LANG_ID=='lang_id')$tl  = $lang_id;
	elseif (!empty($LANG_ID))					$tl  = $LANG_ID;
	else										$tl  = $first_lang_id;
	$sql = "SELECT	#PREFIX#bilder.* FROM #PREFIX#bilder";
	if ($parents || $siblings)					$sql .= ",\n		#PREFIX#seiten_attr, #PREFIX#seiten_attr AS parents";
	if (!empty($avisi) || !empty($aexcl))		$sql .= ",\n		#PREFIX#abschnitte";
	$sql .= "\nWHERE 	#PREFIX#bilder.visibility IN (".$visibility.")\n";
	if ($parents)			$sql .= "AND		#PREFIX#seiten_attr.PAGE_ID IN (".$PAGE_ID.")
									 AND		#PREFIX#bilder.PAGE_ID = parents.PAGE_ID
									 AND		(parents.lft <= #PREFIX#seiten_attr.lft AND parents.rgt >= #PREFIX#seiten_attr.rgt OR parents.PAGE_ID = ".$vorgaben['alle_Seiten'].")\n";
	elseif ($siblings)		$sql .= "AND		#PREFIX#seiten_attr.PAGE_ID IN (".$PAGE_ID.")
									 AND		#PREFIX#bilder.PAGE_ID = parents.PAGE_ID
									 AND		(parents.lft >= #PREFIX#seiten_attr.lft AND parents.rgt <= #PREFIX#seiten_attr.rgt)\n";
	elseif ($tree)			$sql .= "AND		#PREFIX#seiten_attr.PAGE_ID IN (".$PAGE_ID.")
									 AND		#PREFIX#bilder.PAGE_ID = parents.PAGE_ID
									 AND		(parents.lft <= #PREFIX#seiten_attr.lft AND parents.rgt >= #PREFIX#seiten_attr.rgt)\n";
	elseif ($PAGE_ID != 0)	$sql .= "AND		#PREFIX#bilder.PAGE_ID  IN ('".implode("','",explode(',',$PAGE_ID))."')\n";
	if ($LANG_ID != '')		$sql .= "AND		#PREFIX#bilder.LANG_ID IN ('".implode("','",explode(',',$tl))."','".$first_lang_id."',0)\n";
	if ($pos)			 	$sql .= "AND		#PREFIX#bilder.position IN (".$pos.")\n";
	if ($PART_ID != '')	 	$sql .= "AND		#PREFIX#bilder.PART_ID  IN ('".implode("','",explode(',',$PART_ID))."')\n";
	if ($not != '')	 		$sql .= "AND		#PREFIX#bilder.PART_ID  NOT IN ('".implode("','",explode(',',$not))."')\n";
	if ($fn != '')	 		$sql .= "AND		#PREFIX#bilder.Dateiname 	LIKE '%".$fn."%' AND #PREFIX#bilder.PAGE_ID IN (".$PAGE_ID.") \n";
	if ($only != '')	 	$sql .= "AND		#PREFIX#bilder.PART_ID  	LIKE '".$only."'  AND #PREFIX#bilder.PAGE_ID IN (".$PAGE_ID.") \n";
	if (!empty($aexcl))		$sql .= "AND		#PREFIX#abschnitte.PAGE_ID = #PREFIX#bilder.PAGE_ID
									 AND		#PREFIX#abschnitte.PART_ID NOT IN (".$aexcl.")\n";
	if (!empty($avisi))		$sql .= "AND		#PREFIX#abschnitte.PAGE_ID = #PREFIX#bilder.PAGE_ID
									 AND		#PREFIX#abschnitte.PART_ID = #PREFIX#bilder.PART_ID
									 AND		#PREFIX#abschnitte.visibility IN (".$avisi.")\n";
	if (!empty($order)) {
		if ($order == 'random')						$order = "RAND()";
		elseif (!empty($avisi) || !empty($aexcl))	$order = '#PREFIX#abschnitte.'.$order;
		$sql .= "ORDER BY	".$order;
	} else					$sql .= "ORDER BY	Position";
	if (empty($asc))		$sql .= " DESC";
	if (!empty($limit))		$sql .= "\nLIMIT ".$limit;
	if ($bilder = $dbobj->withkey(__file__,__line__,$sql,'LANG_ID',false,'BILD_ID')) {
		if (!empty($bilder[$LANG_ID]))							$out = prep_images($bilder[$LANG_ID],		$folder,$tpl,$size,$path,$imginfo);
		if (!empty($bilder[0]))									$out = prep_images($bilder[0],				$folder,$tpl,$size,$path,$imginfo,$out);
		if (!$fix_lang)	{
			if (empty($out) && !empty($bilder[$lang_id]))		$out = prep_images($bilder[$lang_id],		$folder,$tpl,$size,$path,$imginfo);
			if (empty($out) && !empty($bilder[$first_lang_id]))	$out = prep_images($bilder[$first_lang_id],	$folder,$tpl,$size,$path,$imginfo);
			if (empty($out))									$out = prep_images(current($bilder),		$folder,$tpl,$size,$path,$imginfo);
		}
		return $out;
	}
	else return false;
}
function prep_images($bilder,$folder,$tpl,$size,$path,$imginfo,$out=array()) {
	global $dbobj,$tplobj,$vorgaben,$sub_tpl,$lang_id;
	$f = $folder; $pn = 'bild';
	if (!empty($size)) $folder .= '/'.$size;
	foreach ($bilder as $bild_id => $bild) {
		$is_data = false;
		if (strpos($bild['Dateiname'],'_bild_')!==false) {
			list($pn,$bild['name']) = explode('_bild_',$bild['Dateiname']);
			$part_id = $pn.'_bild_'.$bild['PART_ID'];
		} elseif (strpos($bild['Dateiname'],'bild_')!==false){
			list($pn,$bild['name']) = explode('bild_',$bild['Dateiname']);
			$part_id = 'bild_'.$bild['PART_ID'];
		} else {
			$part_id = $bild['PART_ID'];
			if (strpos($bild['Dateiname'],$bild['PART_ID'].'_'.$bild['LANG_ID'].'_')!==false)	list($pn,$bild['name']) = explode($bild['PART_ID'].'_'.$bild['LANG_ID'].'_',$bild['Dateiname'],2);
			else 																				$bild['name'] = $bild['Dateiname'];
		}
		if (!empty($_REQUEST['data_url']) && !empty($_REQUEST['data_url'][$bild['PART_ID']][$pn.'_bild'])) {
			$is_data = true;
			$bild['ipath'] 		= $_REQUEST['data_url'][$bild['PART_ID']][$pn.'_bild']['data_url'];
			$bild['bpath'] 		= '"'.$bild['ipath'].'"';
			$bild['Dateiname']	= $_REQUEST['data_url'][$bild['PART_ID']][$pn.'_bild']['Dateiname'];
			$bild['name'] = $bild['Dateiname'];
			$bild['extra'] = '<input type="hidden" class="data_url" name="data_url['.$bild['PART_ID'].']['.$pn.'_bild][data_url]" value="'.$bild['bpath'].'" />
							  <input type="hidden" class="data_url" name="data_url['.$bild['PART_ID'].']['.$pn.'_bild][Dateiname]" value="'.$bild['name'].'" />';
		} else {
			$p  = '/images/'.$folder.'/'.$bild['PAGE_ID'];
			$p2 = '/images/'.$f.'/'.$bild['PAGE_ID'];
			if (is_numeric($bild['PART_ID'])) {
				$bild['ipath'] = $p .'_'.$bild['PART_ID'].'_'.$bild['Dateiname'];
				$bild['bpath'] = $p2.'_'.$bild['PART_ID'].'_'.$bild['Dateiname'];
			} else {
				$bild['ipath'] = $p .'_'.$bild['Dateiname'];
				$bild['bpath'] = $p2.'_'.$bild['Dateiname'];
			}
			if ((!empty($bild['ipath']) && is_file($vorgaben['base_dir'].$bild['ipath'])) /*&& (empty($visi) || (!empty($visi[$id]) && $visi[$id]['visibility'] == 1))*/) {
				if ($imginfo===true && is_file($vorgaben['base_dir'].$bild['bpath'])) {
					list($bild['width'],$bild['height'],$bild['type'],$bild['attr']) = getimagesize($vorgaben['base_dir'].$bild['bpath'], $info);
	#				if ($bild['type']==2 && function_exists('exif_read_data') && $exif = exif_read_data($vorgaben['base_dir'].$bild['bpath'], 0, true)) {
	#					foreach ($exif as $key => $section) $bild[$key]= r_implode($section);
	#				}
					if (substr_count($bild['Dateiname'],'_')>=2)	list(,,$bild['oname']) = explode('_',$bild['Dateiname'],3);
					else											$bild['oname'] = $bild['Dateiname'];
					$bild['size'] = bytesToSize(filesize($vorgaben['base_dir'].$bild['bpath']));
				}
				if ($path == 'absolute'){
					$bild['ipath'] = $vorgaben['sub_dir'].$bild['ipath'];
					$bild['bpath'] = $vorgaben['sub_dir'].$bild['bpath'];
		}	}	}
		$bild['img'] = $bild['bpath'];
		if (empty($out) || !is_array($out))	$out = array();
		if (!empty($tpl) && $tpl!='raw')	$out[$part_id][$bild['PAGE_ID']][$bild['BILD_ID']] = $tplobj->array2tpl($tpl,$bild,'$,|,#');
		else								$out[$part_id][$bild['PAGE_ID']][$bild['BILD_ID']] = $bild['ipath'];
		if (!empty($bild['altext'])) {
			$altext = explode(',',$bild['altext']);
			$old_ext = pathinfo($bild['img'], PATHINFO_EXTENSION);
			foreach($altext as $new_ext) {
				$sub_tpl['altimg'][$bild['img']]   = str_replace($old_ext,$new_ext,$bild['img']);
				$sub_tpl['altimg'][$bild['ipath']] = str_replace($old_ext,$new_ext,$bild['ipath']);
			}
		}
		$sub_tpl['oldimg'][$bild['ipath']]  = $bild['ipath'];
		$sub_tpl['oldimg_big'][$bild['img']]  = $bild['img'];
	}
	if (!empty($out))	return $out;
	else 				return false;
}
function save_extra_files($user_params) {
	global $dbobj,$error,$vorgaben;
	$default_params = array('PAGE_ID'=>0);
	extract(merge_defaults_user($default_params,$user_params),EXTR_SKIP);
	foreach($_FILES['extra_files']['name'] as $PART_ID => $file) {
		$datei['Dateiname'] = make_kn($file);
		if (move_uploaded_file($_FILES['extra_files']['tmp_name'][$PART_ID],'downloads/'.$PART_ID.'_'.$PAGE_ID.'_'.$datei['Dateiname'])) {
			$datei['PART_ID']	= $PART_ID;
			$datei['PAGE_ID']	= $PAGE_ID;
			$dbobj->array2db(__file__,__line__,$datei,'#PREFIX#dateien','INSERT INTO',"WHERE PAGE_ID = ".$PAGE_ID." AND PART_ID = '".$PART_ID."';");
			chmod('downloads/'.$PART_ID.'_'.$PAGE_ID.'_'.$datei['Dateiname'], 0644);
			$error[$file.'_'.$PART_ID] = '%%HOCHGELADEN%%: "'.$file.'"';
}	}	}
function save_extra_img($data) {
	$default = array('PAGE_ID'=>0,'LANG_ID'=>0,'add'=>'','remove_img'=>true,'use_page'=>'','use_prefix'=>true,'only'=>'');
	extract(merge_defaults_user($default,$data),EXTR_SKIP);
	foreach($_FILES['extra_img']['name'] as $PART_ID => $file) {
	#	if (empty($vg) && !is_numeric($PART_ID))	$vg = $PART_ID;
		if (empty($only) || $only == $PART_ID)	bildspeichern(array('PAGE_ID'=>$PAGE_ID,'LANG_ID'=>$LANG_ID,'PART_ID'=>$PART_ID,'field'=>'extra_img','add'=>$add,'remove_img'=>$remove_img,'use_page'=>$use_page,'use_prefix'=>$use_prefix));
}	}
function bildspeichern($data) {
	global $dbobj,$error,$vorgaben;
	$default = array('PAGE_ID'=>'','LANG_ID'=>0,'PART_ID'=>'','BILD_ID'=>'','location'=>'bilder','remove_img'=>true,'field'=>'name','add'=>'','filename'=>'','use_page'=>'','use_prefix'=>false);
	extract(merge_defaults_user($default,$data),EXTR_SKIP);
	if (is_array($_FILES[$field]['name'][$PART_ID]))	{
		$position = key($_FILES[$field]['name'][$PART_ID]);
		$_FILES[$field]['name'][$PART_ID] = current($_FILES[$field]['name'][$PART_ID]);
		$_FILES[$field]['tmp_name'][$PART_ID] = current($_FILES[$field]['tmp_name'][$PART_ID]);
	}
	if (isset($_FILES[$field]['name'][$PART_ID]))							$orig_name = &$_FILES[$field]['name'][$PART_ID];
	if (!empty($orig_name) &&  !empty($_FILES[$field]['error'][$PART_ID]))	$error[$orig_name] = image_error($_FILES[$field]['error'][$PART_ID],$_FILES[$field]['name'][$PART_ID]);
	if (!empty($orig_name) &&  empty($error[$orig_name.'_'.$PART_ID])) {
		$_REQUEST['bild'][$PART_ID]['Dateiname'] = $_FILES[$field]['name'][$PART_ID];
		if (!empty($filename)) {
			$kn = make_kn($filename,'',30);
		} else {
			$kn = make_kn($_FILES[$field]['name'][$PART_ID],'',30);
			if (!empty($add))		$kn = $add.'_'.$kn;
			if (!empty($LANG_ID))	$kn = $LANG_ID.'_'.$kn;
			if ($field!='name')		$kn = $PART_ID.'_'.$kn;
		}
		$path = $vorgaben['img_path'].'/originale/'.$kn;
		if (move_uploaded_file($_FILES[$field]['tmp_name'][$PART_ID],$path)) {
			chmod($path,0644);
			if($remove_img) {
				if ($BILD_ID != '')		$sql = "SELECT BILD_ID,PAGE_ID,LANG_ID FROM #PREFIX#bilder WHERE BILD_ID = '".$BILD_ID."' AND PAGE_ID = '".$PAGE_ID."' AND LANG_ID = '".$LANG_ID."';";
				elseif ($PART_ID != '')	$sql = "SELECT BILD_ID,PAGE_ID,LANG_ID FROM #PREFIX#bilder WHERE PART_ID = '".$PART_ID."' AND PAGE_ID = '".$PAGE_ID."' AND LANG_ID = '".$LANG_ID."';";
				if ($exists = $dbobj->withkey(__file__,__line__,$sql,'BILD_ID')) {
					$r_ids = deletefiles(array('BILD_ID'=>implode(',',array_keys($exists)),'LANG_ID'=>$LANG_ID));
			}	}
			if (!empty($r_ids['BILD_IDs'][0]) && is_numeric($r_ids['BILD_IDs'][0]))	$bild['BILD_ID'] = $r_ids['BILD_IDs'][0];
			if ($PART_ID != '') 													$bild['PART_ID'] = $PART_ID;
			if (!empty($vorgaben[$field]['Position'])) 								$bild['Position'] = $vorgaben[$field]['Position'];
			$bild['PAGE_ID'] = $PAGE_ID;
			$bild['LANG_ID'] = $LANG_ID;
			$bild['Dateiname'] = $kn;
			if (!empty($position))	$bild['Position'] = $position;
			$new_id =  $dbobj->next_free_id('bilder','BILD_ID');
			$bild['BILD_ID'] = $new_id;
			unset($vorgaben['altext']);
			make_images($path,$vorgaben['img_path'].'/'.$PAGE_ID."_".$kn,$vorgaben['img_path'].'/thumbs/'.$PAGE_ID."_".$kn,$PAGE_ID,$PART_ID,$use_page,$use_prefix);
			if (!empty($vorgaben['altext']))	$bild['altext'] = $vorgaben['altext'];
			$dbobj->array2db(__file__,__line__,$bild,'#PREFIX#bilder');
			$error[$orig_name.'_'.$PART_ID] = '%%HOCHGELADEN%%: "'.$orig_name.'"';
			unlink($path);
	}	}
	elseif (!empty($orig_name) && empty($error[$orig_name.'_'.$PART_ID])) $error[$orig_name.'_'.$PART_ID] = image_error(99,$orig_name);
	if (!empty($new_id))return $new_id;
	else				return false;
}
function image_error($err_flag,$bild_name = '',$allowed_files=array('webp','jpg','jpeg','png','gif','webp')) {
	$img_err = '';
	$ext  = strtolower(endstr($bild_name,'.'));
	if (is_array($err_flag)) $err_flag = current($err_flag);
	switch ($err_flag) {
		case 0:	break;
		case 1:	case 4:	case 2:	$img_err = '%%BILD_ZU_GROSS%% '.$bild_name;				break;
		case 3:					$img_err = '%%BILD_NUR_TEILWEISE%%: '.$bild_name;		break;
		default:				$img_err = '%%HOCHLADEN_FEHLGESCHLAGEN%%: '.$bild_name;	break;
	}
	if (empty($img_err) && isset($ext) && !in_array($ext,$allowed_files))
		 $img_err = '"'.$bild_name.'": %%ERLAUBTE_DATEIENDUNGEN%%: '.implode_ws($allowed_files).'.';
	if (!empty($img_err)) 	return $img_err;
}
function make_images($src,$dst1='',$dst2='',$PAGE_ID='',$prefix='',$use_page='',$use_prefix=true) {
	global $dbobj,$vorgaben,$tpl_data;
	if(!empty($vorgaben['override'])) {	// any special wishes on the size for that image?
		if (!empty($vorgaben['override']['width']))	{
			$tpl_data['BildX']		= $vorgaben['override']['width'];
			$tpl_data['VorschauX']	= $vorgaben['override']['width'];
		}
		if (!empty($vorgaben['override']['height'])) {
			$tpl_data['BildY']		= $vorgaben['override']['height'];
			$tpl_data['VorschauY']	= $vorgaben['override']['height'];
	}	}
	elseif(empty($tpl_data) && !empty($prefix)) {	// otherwise check if prefixes are set
		if (!empty($use_page) && is_numeric($use_page)) $PAGE_ID = $use_page;	// are the sizes given somewher else?
		$sql = "SELECT	BildX,BildY,VorschauX,VorschauY,bildfixed,vorschaufixed
				FROM	#PREFIX#vorlagen,#PREFIX#seiten_attr
				WHERE 	#PREFIX#seiten_attr.PAGE_ID = ".$PAGE_ID."
				AND		#PREFIX#vorlagen.TPL_ID = #PREFIX#seiten_attr.TPL_ID;";
		$tpl_data = $dbobj->exists(__file__,__line__,$sql);
		if(!$tpl_data && !empty($_REQUEST['pages_attr']['TPL_ID'])) {			// if nothing is given check the defaults
			$sql = "SELECT	BildX,BildY,VorschauX,VorschauY,bildfixed,vorschaufixed
					FROM	#PREFIX#vorlagen
					WHERE 	TPL_ID = ".current($_REQUEST['pages_attr']['TPL_ID']).";";
			$tpl_data = $dbobj->exists(__file__,__line__,$sql);
		}
		if(!empty($tpl_data[0])) $tpl_data = $tpl_data[0];
	}
	if (!empty($prefix) && $use_prefix) {
	   unset($tpl_data);
	   if (isset($vorgaben[$prefix.'bildx']) && empty($vorgaben[$prefix.'vorschaux']))	$vorgaben[$prefix.'vorschaux'] = $vorgaben[$prefix.'bildx'];
	   if (isset($vorgaben[$prefix.'bildy']) && empty($vorgaben[$prefix.'vorschauy']))	$vorgaben[$prefix.'vorschauy'] = $vorgaben[$prefix.'bildy'];
	}
	$bx = 800;$by = 800;$bf ='';$vx = 300;$vy = 300;$vf =''; // some failsafes
	if		(!empty($tpl_data['BildX']))				$bx = &$tpl_data['BildX'];
	elseif	(isset($vorgaben[$prefix.'bildx']))			$bx = &$vorgaben[$prefix.'bildx'];
	if		(!empty($tpl_data['BildY']))				$by = &$tpl_data['BildY'];
	elseif	(isset($vorgaben[$prefix.'bildy']))			$by = &$vorgaben[$prefix.'bildy'];
	if		(isset($tpl_data['bildfixed']))				$bf = &$tpl_data['bildfixed'];
	elseif	(isset($vorgaben[$prefix.'fixed']))			$bf = &$vorgaben[$prefix.'fixed'];
	if		(!empty($tpl_data['VorschauX']))			$vx = &$tpl_data['VorschauX'];
	elseif	(isset($vorgaben[$prefix.'vorschaux']))		$vx = &$vorgaben[$prefix.'vorschaux'];
	if		(!empty($tpl_data['VorschauY']))			$vy = &$tpl_data['VorschauY'];
	elseif	(isset($vorgaben[$prefix.'vorschauy']))		$vy = &$vorgaben[$prefix.'vorschauy'];
	if		(!empty($tpl_data['vorschaufixed']))		$vf = &$tpl_data['vorschaufixed'];
	elseif	(!empty($vorgaben[$prefix.'vorschaufixed']))$vf = &$vorgaben[$prefix.'vorschaufixed'];
	if (!empty($dst1))	imageresize($src,$dst1,$by,$bx,$bf);
	if (!empty($dst2))	imageresize($src,$dst2,$vy,$vx,$vf);
}
function imageresize($src,$dst,$maxheight=0,$maxwidth=0,$fixed='') {
	global $error,$vorgaben;
	if (empty($maxheight)) $maxheight=800;
	if (empty($maxwidth))  $maxwidth =800;
	$orig = $src; // lets remember that, cause we'll be working on $src
	if($got_src = get_any_type($orig)) {	// does what ist says
		$src = current($got_src);				// there you see.
		if(empty($error[basename($dst)])) {		 // continue if nor errors occured.
			$width	= imagesx($src);
			$height	= imagesy($src);
			if ($width <= $maxwidth && $height <= $maxheight) { // smaller images just get copied to new destination.
				copy($orig,$dst);
			} else {											// otherwise the fun begins.
				if ($width < $maxwidth)		$new_w = $width;
				else						$new_w = $maxwidth;
				if ($height < $maxheight)	$new_h = $height;
				else						$new_h = $maxheight;
				$old_ratio = $width / $height;			// > 0 for landscape, < 0 for portrait
				$new_ratio = $maxwidth / $maxheight;	// > 0 for landscape, < 0 for portrait
				switch ($fixed) {
					case 'height':
						$new_w = $width;
						if ($height > $maxheight){
							$new_w = (int)($maxheight * $old_ratio);
							$new_h = $maxheight;
						}
					break;
					case 'width':
						$new_h = $height;
						if ($width > $maxwidth){
							$new_h = (int)($maxwidth / $old_ratio);
							$new_w = $maxwidth;
						}
					break;
					case 'cover':
						if (($old_ratio > 0 && $new_ratio > 0) || ($old_ratio < 0 && $new_ratio < 0)) {
							if ($old_ratio > $new_ratio)			$new_w = (int)($new_h * $old_ratio);
							else									$new_h = (int)($new_w / $old_ratio);
						}
						elseif ($old_ratio < 0 && $new_ratio > 0)	$new_h = (int)($new_w / $old_ratio);
						elseif ($old_ratio > 0 && $new_ratio < 0)	$new_w = (int)($new_h * $old_ratio);
					break;
					default:
						if ($width > $maxwidth || $height > $maxheight){
							if ($height > $maxheight) {
								$new_h = $maxheight;
								$new_w = (int)($maxheight * $old_ratio);
								 if ($new_w > $maxwidth) {
									$new_w = $maxwidth;
									$new_h = (int)($maxwidth / $old_ratio);
							}	}
							elseif ($width > $maxwidth) {
								$new_w = $maxwidth;
								$new_h = (int)($maxwidth / $old_ratio);
								if ($new_h > $maxheight){
									$new_h = $maxheight;
									$new_w = (int)($maxheight * $old_ratio);
						}	}	}
					break;
				}
				switch (key($got_src)) {
					case 'gif':  $out = save_gif($src,$dst,$new_w,$new_h,$width,$height);  break;	// Bild abspeichern
					case 'png':  $out = save_png($src,$dst,$new_w,$new_h,$width,$height);  break;
				#	case 'webp': $out = save_webp($src,$dst,$new_w,$new_h,$width,$height); break;
				#	case 'avif': $out = save_avif($src,$dst,$new_w,$new_h,$width,$height); break;
					default:	 $out = save_jpg($src,$dst,$new_w,$new_h,$width,$height);  break;
				}
			}
			$ext = pathinfo($dst, PATHINFO_EXTENSION);
			if (function_exists('imagewebp')) {
				save_webp($dst,str_replace('.'.$ext,'.webp',$dst));
				$vorgaben['altext'][$dst] = 'webp';
			}
			if (function_exists('imageavif')) {
				save_avif($dst,str_replace('.'.$ext,'.avif',$dst));
				$vorgaben['altext'][$dst] = 'avif';
			}
			if (!empty($out))return $out;
		}
	}
}
function get_any_type($src) {
	global $error,$vorgaben;
	$img = false;
	$src = $vorgaben['base_dir'].str_remove($src,$vorgaben['base_dir']);
	if (is_file($src)) {
		$ext = strtolower(pathinfo(str_replace('jpeg','jpg',strtolower($src)), PATHINFO_EXTENSION));
		switch ($ext) {
			case ('gif'):  $img[$ext] = @imagecreatefromgif($src);		break;
			case ('jpg'):  $img[$ext] = @imagecreatefromjpegexif($src);	break;
			case ('png'):  $img[$ext] = @imagecreatefrompng($src);		break;
			case ('webp'): $img[$ext] = @imagecreatefromwebp($src);		break;
			case ('avif'): $img[$ext] = @imagecreatefromavif($src);		break;
			default: $error[basename($src)] =  '"'.basename($src).'": %%ERLAUBTE_DATEIENDUNGEN%%: avif, webp, jpg, png, gif.';	break;
	}	}
#	$mem = MemoryForImage($path);
#	if ($mem['memoryLimit'] > $mem['memoryNeeded']) {
#		$error['info'] =  'Memory usage: '.ceil($mem['memoryNeeded']/1048576).' Mb, available: '.ceil($mem['memoryLimit']/1048576).' Mb.';
#	}
#	else $error['upload'] =  'Bitte verringern Sie die Abmessungen des Bildes. Speicherbedarf: '.ceil($mem['memoryNeeded']/1048576).' Mb, Verfügbar: '.ceil($mem['memoryLimit']/1048576).' Mb';
	if ($img[$ext]) return $img;
	else {
		$error[] = image_error(99,basename($src));
		return false;
}	}
function imagecreatefromjpegexif($filename) {
	$img = imagecreatefromjpeg($filename);
	$exif = exif_read_data($filename);
	if ($img && $exif && isset($exif['Orientation'])) {
		$ort = $exif['Orientation'];
		if ($ort == 6 || $ort == 5)
			$img = imagerotate($img, 270, null);
		if ($ort == 3 || $ort == 4)
			$img = imagerotate($img, 180, null);
		if ($ort == 8 || $ort == 7)
			$img = imagerotate($img, 90, null);
		if ($ort == 5 || $ort == 4 || $ort == 7)
			imageflip($img, IMG_FLIP_HORIZONTAL);
	}
	return $img;
}
function save_jpg($src,$dst,$new_w,$new_h,$width,$height) {
	$new_img = imagecreatetruecolor($new_w,$new_h);
	imagecopyresampled($new_img, $src, 0, 0, 0, 0, $new_w, $new_h,$width,$height);
	$out = imagejpeg($new_img,$dst);
	imagedestroy($new_img);
	return $out;
}
function save_png($src,$dst,$new_w,$new_h,$width,$height) {
	$new_img = imagecreatetruecolor($new_w,$new_h);
	imagealphablending($new_img, false);
	$color = imagecolortransparent($new_img, imagecolorallocatealpha($src, 0, 0, 0, 127));
	imagefill($new_img, 0, 0, $color);
	imagesavealpha($new_img, true);
	imagecopyresampled($new_img, $src, 0, 0, 0, 0, $new_w, $new_h,$width,$height);
	$out = imagepng($new_img,$dst);
	imagedestroy($new_img);
	return $out;
}
function save_webp($src,$dst,$new_w=false,$new_h=false,$width=false,$height=false) {
	if($new_w)	{
		$new_img = imagecreatetruecolor($new_w,$new_h);
		imagealphablending($new_img, false);
		$color = imagecolortransparent($new_img, imagecolorallocatealpha($src, 0, 0, 0, 127));
		imagefill($new_img, 0, 0, $color);
		imagesavealpha($new_img, true);
		imagecopyresampled($new_img, $src, 0, 0, 0, 0, $new_w, $new_h,$width,$height);
	} else {
		$extension = strtolower(pathinfo($src, PATHINFO_EXTENSION));
		if ($extension == 'jpeg' || $extension == 'jpg') 
			$new_img = imagecreatefromjpeg($src);
		elseif ($extension == 'gif') 
			$new_img = imagecreatefromgif($src);
		elseif ($extension == 'png') 
			$new_img = imagecreatefrompng($src);
	}
	$out = imagewebp($new_img,$dst);
	imagedestroy($new_img);
	return $out;
}
function save_avif($src,$dst,$new_w=false,$new_h=false,$width=false,$height=false) {
	if($new_w)	{
		$new_img = imagecreatetruecolor($new_w,$new_h);
		imagealphablending($new_img, false);
		$color = imagecolortransparent($new_img, imagecolorallocatealpha($src, 0, 0, 0, 127));
		imagefill($new_img, 0, 0, $color);
		imagesavealpha($new_img, true);
		imagecopyresampled($new_img, $src, 0, 0, 0, 0, $new_w, $new_h,$width,$height);
	} else {
		$extension = strtolower(pathinfo($src, PATHINFO_EXTENSION));
		if ($extension == 'jpeg' || $extension == 'jpg') 
			$new_img = imagecreatefromjpeg($src);
		elseif ($extension == 'gif') 
			$new_img = imagecreatefromgif($src);
		elseif ($extension == 'png') 
			$new_img = imagecreatefrompng($src);
	}
	$out = imageavif($new_img,$dst);
	imagedestroy($new_img);
	return $out;
}
function save_gif($src,$dst,$new_w,$new_h,$width,$height) {
	$new_img = imagecreatetruecolor($new_w,$new_h);	// load/create images
	imagealphablending($new_img, false);
	$transindex = imagecolortransparent($src);	// get and reallocate transparency-color
	if($transindex >= 0) {
		$transcol = imagecolorsforindex($src, $transindex);
		$transindex = imagecolorallocatealpha($new_img, $transcol['red'], $transcol['green'], $transcol['blue'], 127);
		imagefill($new_img, 0, 0, $transindex);
	}
	imagecopyresampled($new_img, $src, 0, 0, 0, 0, $new_w, $new_h, $width, $height);	// resample
	if($transindex >= 0) {	// restore transparency
	  imagecolortransparent($new_img, $transindex);
	  for($y=0; $y<$new_h; ++$y)
		for($x=0; $x<$new_w; ++$x)
		  if(((imagecolorat($new_img, $x, $y)>>24) & 0x7F) >= 100) imagesetpixel($new_img, $x, $y, $transindex);
	}
	imagetruecolortopalette($new_img, true, 255);	// save GIF
	imagesavealpha($new_img, true);
	$out = imagegif($new_img, $dst);
	imagedestroy($new_img);
	return $out;
}
function MemoryForImage($filename) {
	$imageInfo	= getimagesize($filename);
	$memoryNeeded = round(($imageInfo[0] * $imageInfo[1] * $imageInfo['bits'] * $imageInfo['channels'] / 8 + Pow(2, 16)) * 1.65);
	$memoryLimit = ini_get('memory_limit')?ini_get('memory_limit')*1048576:40*1048576;
	return array('memoryNeeded'=>ceil($memoryNeeded+getMemUsage()),'memoryLimit'=>$memoryLimit);
}
function meminfo($r='') {
	info(getMemUsage(),$r);
}
function getMemUsage() {
	global $error;
	if (function_exists('memory_get_usage'))	$mem = memory_get_usage();
	else {
	   $output = array();	   // Windows workaround
	   exec('tasklist /FI "PID eq ' . getmypid() . '" /FO LIST', $output);
	   if (!empty($output[5]))	$mem = substr($output[5], strpos($output[5], ':') + 1);
	   else						$mem = 0;
	}
	return $mem;
}
function move_file() {
	global $vorgaben;
	foreach ($_REQUEST['move_file'] as $from => $files) {
		foreach ($files as $to => $files2) {
			foreach ($files2 as $file ) {
				if(is_file($vorgaben['base_dir'].'/'.$to.$file))	unlink($vorgaben['base_dir'].'/'.$to.$file);
				if (is_file($vorgaben['base_dir'].'/'.$from.$file)) rename($vorgaben['base_dir'].'/'.$from.$file, $to.$file);
}	}	}	}
function remove_file() {
	global $vorgaben,$error;
	if (is_numeric(str_remove($_REQUEST['remove_file']))) {
		deletefiles(array('DATEI_ID'=>$_REQUEST['remove_file']),'files');
	} else {
		$f = current($_REQUEST['remove_file']);
		if (is_numeric($f)) deletefiles(array('DATEI_ID'=>$_REQUEST['remove_file']),'files');
		else				deletefiles(array('Dateiname'=>$_REQUEST['remove_file']),'files');
}	}
function remove_img() {
	foreach ($_REQUEST['remove_img'] as $id) {if (is_numeric($id)) deletefiles(array('BILD_ID'=>$id));}
}
function deletefiles($data,$only='all') {
	global $error,$dbobj,$tplobj,$vorgaben;
	if (($only == 'all' || $only == 'images') && empty($data['DATEI_ID'])) {
		if ($exists = $dbobj->exists(__file__,__line__,"SELECT PAGE_ID,PART_ID,BILD_ID,Dateiname FROM #PREFIX#bilder WHERE\n".del_sql_where($data))) {
			foreach ($exists as $re_img) {
				$ids['BILD_IDs'][] = $re_img['BILD_ID'];
				$del_sql[]	= "DELETE FROM #PREFIX#bilder WHERE BILD_ID = ".$re_img['BILD_ID'];
				if (!is_numeric($re_img['PART_ID']))$ipaths['b_'.$re_img['BILD_ID']] = $re_img['PAGE_ID'].'_'.$re_img['Dateiname'];
				else								$ipaths['b_'.$re_img['BILD_ID']] = $re_img['PAGE_ID'].'_'.$re_img['PART_ID'].'_'.$re_img['Dateiname'];
				$ipaths['t_'.$re_img['BILD_ID']] = 'thumbs/'.$ipaths['b_'.$re_img['BILD_ID']];
			#	$ipaths['o_'.$re_img['BILD_ID']] = 'originale/'.$ipaths['b_'.$re_img['BILD_ID']];
				foreach ($ipaths as $ipath) {
					if (is_file($vorgaben['base_dir'].'/'.$vorgaben['img_path'].'/'.$ipath)) unlink($vorgaben['base_dir'].'/'.$vorgaben['img_path'].'/'.$ipath);
				}
				$error[$re_img['Dateiname']] = "%%GELOESCHT%%: '".$re_img['Dateiname']."'";	#Image removed.
	}	}	}
	if (($only == 'all' || $only == 'files') && empty($data['BILD_ID'])) {
		if ($exists = $dbobj->exists(__file__,__line__,"SELECT DATEI_ID,Dateiname FROM #PREFIX#dateien WHERE\n".del_sql_where($data))) {
			foreach ($exists as $re_file) {
				$ids['DATEI_IDs'][] = $re_file['DATEI_ID'];
				$del_sql[]	= "DELETE FROM #PREFIX#dateien WHERE DATEI_ID = '".$re_file['DATEI_ID']."';";
				$fpath = $vorgaben['base_dir'].'/downloads/'.$re_file['Dateiname'];
				if(is_file($fpath))	unlink($fpath);
				$error[$re_file['Dateiname']] = '%%GELOESCHT%%: "'.$re_file['Dateiname'].'"';	#Image removed.
		}	}
		elseif(!empty($data['Dateiname'])) {
			if (is_array($data['Dateiname']))	$f_array  = $data['Dateiname'];
			else								$f_array[]= $data['Dateiname'];
			foreach ($f_array as $f) {
				if (is_file($f)) {
					unlink($f);
					$error[$f] = '%%GELOESCHT%%: "'.$f.'"';	#Datei ist gel&ouml;scht worden.
	}	}	}	}
	if (!empty($del_sql))	$dbobj->multiquery(__file__,__line__,$del_sql);
	if (!empty($ids))	return $ids;
	else				return false;
}
function del_sql_where($data) {
	global $lang_id;
	if (!empty($data['PART_ID']) && !empty($data['Dateiname']) && !empty($_REQUEST['override'][$data['PART_ID']][ucfirst($data['Dateiname'])]['uselang']))		$where['LANG_ID'] = '(LANG_ID = 0 OR LANG_ID = '.$lang_id.')';
	foreach ($data as $k => $v) {
		if ($k == 'Dateiname')				$where[$k] = $k.' LIKE "%'.r_implode($v,'% OR '.$k.' LIKE "%').'%"';
		elseif (!empty($v) && $k!='LANG_ID')$where[$k] = $k.' IN ("'.r_implode($v,'","').'")';
	}
	if (!empty($where)) return implode("\nAND ",$where).';';
}
function dwordize($str) {return ord($str[2])*256*256+ord($str[1])*256+ord($str[0]);}
function byte3($n)		{return chr($n&255).chr(($n>>8)&255).chr(($n>>16)&255);}
function dword($n)		{return pack("V",$n);}
function word($n)		{return pack("v",$n);}
function save_dataurl_to_file($data_url,$filepath) {
	global $vorgaben;
	$fp = fopen($vorgaben['base_dir'].'/'.$filepath, 'w');
	fwrite($fp,base64_decode(endstr($data_url,';base64,')));
	fclose($fp);
}
function chmod_f($path='./', $filePerm=0664, $dirPerm=0775)  { // chmod all files in a directory
	$path = preg_replace('/\/\//', '/', $path) ;
	if(is_dir($path)) {							// If this is a directory...
		$foldersAndFiles = scandir($path);				// get array of the contents
		$entries = array_slice($foldersAndFiles, 2);	  // Remove "." and ".." from the list
		foreach($entries as $entry) {					 // Parse every result...
			if (is_file($path."/".$entry)) chmod($path."/".$entry, $filePerm); // set chmod
		}
		chmod($path, $dirPerm);						   // When done with dir contents, chmod the dir
	}
	return true;									   // Everything seemed to work, return TRUE
}
function chmod_r($path='./', $filePerm=0664, $dirPerm=0775)  { // chmod everythin recursivly
	$path = preg_replace('/\/\//', '/', $path) ;
	if(is_file($path)) {								// If this is a file
		chmod($path, $filePerm);							 // set chmod
	} elseif(is_dir($path)) {							// If this is a directory...
		$foldersAndFiles = scandir($path);					// get array of the contents
		$entries = array_slice($foldersAndFiles, 2); 		// Remove "." and ".." from the list
		foreach($entries as $entry) {						// Parse every result...
			chmod_r($path."/".$entry, $filePerm, $dirPerm); 	// recursively, with the same permissions
		}
		chmod($path, $dirPerm);						   // When done with dir contents, chmod the dir
	}
	return true;									   // Everything seemed to work, return TRUE
}
function loc($filename) {
	$loc = loc_mimetype($filename);			// determine type of attachment
	return data($filename,$loc);
}
function base($src) {
	global $vorgaben;
	if (!is_file($src)) $src  = $vorgaben['base_dir'].'/'.$src;
	if (is_file($src)) return 'data:'.type($src) .';base64,'. base64_encode(file_get_contents($src));
	else return $src;
}
function data($filename,$loc) {
	$fd  = fopen($filename,"r");
	$loc['filesize'] = filesize($filename);
	$dataread = fread($fd,$loc['filesize']);
	fclose($fd);
	if (!empty($loc['encode']) && $loc['encode']=='base64')	$loc['data'] = base64_encode($dataread);
	else 													$loc['data'] = $dataread;
	return $loc;
}
function type($filename) {
	return loc_mimetype($filename,'mimetype');
}
function loc_mimetype($filename,$key='') {
	$loc['ext'] = endstr($filename,'.');
	if (is_array($filename))	$filename = current($filename);
	$loc['filename']= $filename;
	$loc['name']	= basename($loc['filename']);
	switch ('.'.strtolower($loc['ext'])) {
		case '.jpg' : case '.jpe' : case '.jpeg':
					  $loc['mimetype'] = 'image/jpeg'; 			$loc['encode']='base64';break;
		case '.gif' : $loc['mimetype'] = 'image/gif'; 			$loc['encode']="base64";break;
		case '.webp': $loc['mimetype'] = 'image/webp'; 			$loc['encode']="base64";break;
		case '.png' : $loc['mimetype'] = 'image/png'; 			$loc['encode']="base64";break;
		case '.svg' : $loc['mimetype'] = 'image/svg+xml'; 		$loc['encode']="base64";break;
		case '.ico' : $loc['mimetype'] = 'image/x-icon'; 		$loc['encode']="base64";break;
		case '.tif' : case '.tiff':
					  $loc['mimetype'] = 'image/tiff'; 			$loc['encode']="base64";break;
		case '.html': case '.htm':
					  $loc['mimetype'] = 'text/html'; 			$loc['encode']="quoted-printable";	break;
		case '.ai'  : case '.eps' :
		case '.ps'  : $loc['mimetype'] = 'application/postscript';$loc['encode']="7bit";break;
		case '.pdf' : $loc['mimetype'] = 'application/pdf'; 	$loc['encode']="base64";break;
		case '.rtf' : $loc['mimetype'] = 'application/rtf'; 	$loc['encode']="7bit";	break;
		case '.wav' : $loc['mimetype'] = 'audio/x-wav'; 		$loc['encode']="base64";break;
		case '.mpeg': case '.mpe' : case '.mpg' :
					  $loc['mimetype'] = 'video/mpeg'; 			$loc['encode']="base64";break;
		case '.mov' : $loc['mimetype'] = 'video/quicktime'; 	$loc['encode']="base64";break;
		case '.avi' : $loc['mimetype'] = 'video/x-msvideo'; 	$loc['encode']="base64";break;
		case '.docx': $loc['mimetype'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'; $loc['encode']="base64";break;
		case '.doc' : $loc['mimetype'] = 'application/msword'; 	$loc['encode']="base64";break;
		case '.xls' : $loc['mimetype'] = 'application/msexcel';	$loc['encode']="base64";break;
		case '.xlsx': $loc['mimetype'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';	$loc['encode']="base64";break;
		case '.xml'	: $loc['mimetype'] = 'text/xml';									break;
		case '.css'	: $loc['mimetype'] = 'text/css';									break;
		case '.js'	: $loc['mimetype'] = 'text/javascript';								break;
		case '.json': $loc['mimetype'] = 'application/json';							break;
		case '.jsonld':$loc['mimetype'] = 'application/ld+json';						break;
		case '.woff': $loc['mimetype'] = 'application/octet-stream';					break;
		case '.aac'	: $loc['mimetype'] = 'audio/aac';									break;
		case '.mp3'	: $loc['mimetype'] = 'audio/mpeg';									break;
		case '.wav'	: $loc['mimetype'] = 'audio/wav';									break;
		case '.ogg'	: $loc['mimetype'] = 'audio/ogg';									break;
		case '.weba': $loc['mimetype'] = 'audio/webm';									break;
		case '.ogv'	: $loc['mimetype'] = 'video/ogg';									break;
		case '.mp4'	: case '.mpeg': case '.m4v'	:
					  $loc['mimetype'] = 'video/mp4';									break;
		case '.webm': $loc['mimetype'] = 'video/webm';									break;
		case '.zip' : $loc['mimetype'] = 'application/zip';								break;
		case '.sql' : case '.bak' :
					  $loc['mimetype'] = 'application/octet-stream.';					break;
		default	 : $loc['mimetype'] = 'text/plain'; 			$loc['encode']="7bit";  break;
	}
	if (!empty($key) && !empty($loc[$key]))	return $loc[$key];
	else									return $loc;
}
/**
 * This is the implementation of the server side part of
 * Resumable.js client script, which sends/uploads files
 * to a server in several chunks.
 *
 * The script receives the files in a standard way as if
 * the files were uploaded using standard HTML form (multipart).
 *
 * This PHP script stores all the chunks of a file in a temporary
 * directory (`temp`) with the extension `_part<#ChunkN>`. Once all
 * the parts have been uploaded, a final destination file is
 * being created from all the stored parts (appending one by one).
 *
 * @author Gregory Chris (http://online-php.com)
 * @email www.online.php@gmail.com
 */

////////////////////////////////////////////////////////////////////
// THE SCRIPT
////////////////////////////////////////////////////////////////////

function upload_php($str) {
	if (!empty($_POST['resumableFilename']))	$_POST['resumableFilename'] = make_kn($_POST['resumableFilename']);
	if (!empty($_FILES)) foreach ($_FILES as $file) {											// loop through files and move the chunks to a temporarily created directory
		$initial_folder = "/downloads/";
		$current_folder = rtrim($vorgaben['base_dir'],'/').$initial_folder;
		if ($file['error'] != 0) {																	// check the error status
			_log('error '.$file['error'].' in file '.$_POST['resumableFilename']);
			continue;
		}
		$temp_dir = $current_folder.'temp/'.$_POST['resumableIdentifier'];								// the file is stored in a temporary directory
		$dest_file = $temp_dir.'/'.$_POST['resumableFilename'].'.part'.$_POST['resumableChunkNumber'];	// init the destination file (format <filename.ext>.part<#chunk>

		if (!is_dir($temp_dir)) {																		// create the temporary directory
			mkdir($temp_dir, 0777, true);
		}
		if (!move_uploaded_file($file['tmp_name'], $dest_file)) {										// move the temporary file
			_log('Error saving (move_uploaded_file) chunk '.$_POST['resumableChunkNumber'].' for file '.$_POST['resumableFilename']);
		} else {																						// check if all the parts present, and create the final destination file
			createFileFromChunks($temp_dir, $_POST['resumableFilename'],$_POST['resumableChunkSize'], $_POST['resumableTotalSize']);
}	}	}
////////////////////////////////////////////////////////////////////
// THE FUNCTIONS
////////////////////////////////////////////////////////////////////

/**
 *
 * Logging operation - to a file (upload_log.txt) and to the stdout
 * @param string $str - the logging string
 */
function _log($str) {
	$log_str = date('d.m.Y').": {$str}\r\n";			// log to the output
	echo $log_str;
	if (($fp = fopen('upload_log.txt', 'a+')) !== false) {	// log to file
		fputs($fp, $log_str);
		fclose($fp);
}   }
/**
 *
 * Delete a directory RECURSIVELY
 * @param string $dir - directory path
 * @link http://php.net/manual/en/function.rmdir.php
 */
function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir . "/" . $object) == "dir") {
					rrmdir($dir . "/" . $object);
				} else {
					unlink($dir . "/" . $object);
		}   }   }
		reset($objects);
		rmdir($dir);
}   }
/**
 *
 * Check if all the parts exist, and
 * gather all the parts of the file together
 * @param string $dir - the temporary directory holding all the parts of the file
 * @param string $fileName - the original file name
 * @param string $chunkSize - each chunk size (in bytes)
 * @param string $totalSize - original file size (in bytes)
 */
function createFileFromChunks($temp_dir, $fileName, $chunkSize, $totalSize) {
	$total_files = 0;
	foreach(scandir($temp_dir) as $file) {									// count all the parts of this file
		if (stripos($file, $fileName) !== false) {
			$total_files++;
	}   }
	if ($total_files * $chunkSize >=  ($totalSize - $chunkSize + 1)) {		// check that all the parts are present and the size of the last part is between chunkSize and 2*$chunkSize
		if (($fp = fopen('temp/'.$fileName, 'w')) !== false) {					// create the final destination file
			for ($i=1; $i<=$total_files; $i++) {
				fwrite($fp, file_get_contents($temp_dir.'/'.$fileName.'.part'.$i));
				_log('writing chunk '.$i);
			}
			fclose($fp);
		} else {
			_log('cannot create the destination file');
			return false;
		}
		if (rename($temp_dir, $temp_dir.'_UNUSED')) {						// rename the temporary directory (to avoid access from other concurrent chunks uploads) and than delete it
			rrmdir($temp_dir.'_UNUSED');
		} else {
			rrmdir($temp_dir);
}   }   }
?>