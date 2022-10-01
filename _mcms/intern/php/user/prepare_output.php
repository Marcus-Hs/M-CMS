<?php
function prepare_prepare_output() {
	global $external_functions,$fallback;
	$external_functions['phpinfo.php']		= 'php_info';
	$external_functions['popup.php']		= 'popup';
	$external_functions['vorschau.php']		= 'preview_page';
	$external_functions['preview.php']		= 'preview_saved';
	$external_functions['process_preview.php']= 'process_preview';
	$external_functions['alleseiten.php']	= 'pageselect';
	$external_functions['submit.php']		= 'form_submit';
	$external_functions['cp2.html']			= 'color_table';
	$fallback['ck_styles']					= 'ck_styles';
}
function php_info() {
	if (!empty($_SESSION['status']) && !is_numeric($_SESSION['status'])) {
		phpinfo ();
}	}
function form_submit() {
	global $dbobj,$tplobj,$error;
	$response = array( 
		'status' => 0, 
		'message' => 'Form submission failed, please try again.' 
	);
	if (!empty($_SESSION['logged'])) {
		if (!function_exists('save_pages')) {
			my_include('intern/php/admin/','administration.php');
			my_include('intern/php/admin/','edit_pages.php');
			my_include('intern/php/admin/','edit_sections.php');
		}
		speichern(); 
		unset($_REQUEST['pages'],$_FILES);
		$response['status'] = 1; 
		$response['message'] = '%%GESPEICHERT%%';
	}
	// Return response 
	return final_output(json_encode($response),true);
}
function preview_page() {
	global $dbobj,$tplobj,$active,$vorgaben,$sub_tpl,$page_id,$lang_id,$first_lang_id,$decode;
	$vorgaben['is_preview'] = true;
#	$sub_tpl['titlesuffix'] = gt('(%%PREVIEW%%)');
#	$vorgaben['home'] = get_page(array('PAGE_ID'=>'#firstpage#','feld'=>'Menu,PAGE_ID','errors'=>false));	// Startseite für Brotkrumen-Navigation setzen
	if (((empty($_REQUEST['page_id']) || $_REQUEST['page_id']=='undefined') && $_REQUEST['page_id'] = pageIDs_by_user(85)) ||
			(!empty($_REQUEST['page_id']) && is_numeric($_REQUEST['page_id']) && !empty($_SESSION['logged']))) {
/*		if (!empty($_REQUEST['pages']) && !empty($_REQUEST['send'])) {
			if (!function_exists('save_pages')) {
				my_include('intern/php/admin/','administration.php');
				my_include('intern/php/admin/','edit_pages.php');
				my_include('intern/php/admin/','edit_sections.php');
			}
		#	speichern();
			unset($_REQUEST['pages'],$_FILES);
		}
*/		$page_id=$_REQUEST['page_id'];
		$out = getpage($data=array('PAGE_ID'=>$page_id,'LANG_ID'=>$lang_id,'visibility'=>'0,1'));
		build_menu($page_id);
	} else {
		$sub_tpl['text'] = '<p>404 Not Found</p>';
		header("HTTP/1.0 404 Not Found");
	}
	return final_output(main_tpl($out),true);
}
function process_preview() {
	global $dbobj;
	$db['data'] = url_seri($_REQUEST);
	$db['page_id'] = $_REQUEST['pages']['PAGE_ID'];
	$db['lang_id'] = $_REQUEST['pages']['LANG_ID'];
	$db['Titel']   = $_REQUEST['pages']['Titel'];
	$dbobj->array2db(__file__,__line__,$db,'#PREFIX#_preview','INSERT INTO','WHERE PAGE_ID = "'.$db['page_id'].'" LANG_ID = "'.$db['lang_id'].'"');
}
function preview_saved() {
	global $dbobj,$tplobj,$active,$vorgaben,$sub_tpl,$page_id,$lang_id,$first_lang_id,$decode;
	$vorgaben['is_preview'] = true;
	$decode = true;
	if (!empty($_REQUEST['page_id']) && !empty($_SESSION['logged'])) {
		if (!empty($_GET['page_id']) && $dbobj->table_exists(__file__,__line__,'#PREFIX#_preview')
									 && $data = $dbobj->exists(__file__,__line__,'SELECT * FROM #PREFIX#_preview WHERE PAGE_ID = "'.$_GET['page_id'].'"')) {
			$_REQUEST = array_merge($_REQUEST,unseri_unurl($data[0]['data']));
			$decode = false;
		}
#		if (!empty($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'Gecko')!==false)	$sub_tpl['body'] = 'onblur="window.close()"';
		$page = '';
		$sub_tpl['titlesuffix'] = gt('(%%PREVIEW%%)');
		$seite[0] = array();
		$vorgaben['home'] = get_page(array('PAGE_ID'=>'#firstpage#','feld'=>'Menu,PAGE_ID','errors'=>false));	// Startseite für Brotkrumen-Navigation setzen
		$page_id   = $_REQUEST['page_id'];
		if (isset($_REQUEST['pages_attr']['parent_ID'][$page_id]))	$parent_id = $_REQUEST['pages_attr']['parent_ID'][$page_id];
		elseif (isset($_REQUEST['parent_id2']))						$parent_id = $_REQUEST['parent_id2'];
		else														$parent_id = 0;
		if (!empty($_REQUEST['lang_id'])) 	$lang_id = $_REQUEST['lang_id'];
		else								$lang_id = $first_lang_id;
		get_vorlage(array('TPL_ID' =>$vorgaben['seiten_tpl'],'set_vg'=>false,'paginate'=>true));
		$seite[0]['abschnitt'] = get_vorlage(array('PAGE_ID'=>$page_id,'set_sub_tpl'=>true,'visibility'=>'1,0','visi_chk'=>true,'paginate'=>true));
		$seite[0]['PAGE_ID']   = $page_id;
		if($a = $dbobj->singlequery(__file__,__line__,"SELECT parents.PAGE_ID,#PREFIX#seiten.Menu FROM #PREFIX#seiten,#PREFIX#seiten_attr,#PREFIX#seiten_attr AS parents WHERE #PREFIX#seiten.PAGE_ID = parents.PAGE_ID AND #PREFIX#seiten_attr.PAGE_ID = '".$parent_id."' AND #PREFIX#seiten.LANG_ID = ".$lang_id." AND parents.lft <= #PREFIX#seiten_attr.lft AND parents.rgt >= #PREFIX#seiten_attr.rgt ORDER BY parents.lft")) {
			foreach ($a as $b) {
				if (!empty($b['PAGE_ID'])) {
					$active[$b['Menu']] = $b['PAGE_ID'];
					$sub_tpl['breadcrumbs'][$b['PAGE_ID']] = array('link'=>$b['PAGE_ID'],'Menu'=>$b['Menu']);
		}	}	}
		$sub_tpl['style'][] = '§MORECSS§';
		if (empty($sub_tpl['seitenvorlage']))	$sub_tpl['seitenvorlage'] = 'KEINE SEITENVORLAGE GEFUNDEN!!!';
		$sub_tpl['bilder']	= get_images(array('PAGE_ID'=>$page_id,'LANG_ID'=>$lang_id));
		prepare_elements($seite[0],$_REQUEST);
		if (!empty($vorgaben['template']) && str_remove($seite[0]['Text'],array('\\','"',"'"," ","&nbsp;","\r","\n")) == str_remove($vorgaben['template'],array('\\','"',"'"," ","&nbsp;","\r","\n"))) {
			$seite[0]['Text'] = '';
		} else {
			parse($seite[0]['Text']);
			decode2($seite[0]['Text']);
		}
		if (strpos($seite[0]['Text'],'#'.strtoupper($sub_tpl['tpl_title']).'#')!==false && !empty($seite[0]['abschnitt'])) {
			$seite[0]['Text'] = str_replace('#'.strtoupper($sub_tpl['tpl_title']).'#',$seite[0]['abschnitt'],$seite[0]['Text']);
			unset($seite[0]['abschnitt']);
		}
		if (!empty($seite[0]['Beschreibung']))	{
			decode2($seite[0]['Beschreibung']);
			$sub_tpl['description'] = stripslashes($seite[0]['Beschreibung']);
		}
		if (!empty($seite[0]['Titel']))	{
			decode2($seite[0]['Titel']);
			$sub_tpl['pagetitle'] = $seite[0]['Titel'];
		}
		if (!empty($seite[0]['Menu']))			decode2($seite[0]['Menu']);
		elseif (!empty($sub_tpl['pagetitle'])) {
			$sub_tpl['menu_'.$page_id] = $sub_tpl['pagetitle'];
			$seite[0]['Menu'] = $sub_tpl['pagetitle'];
		}
		if (!empty($seite[0]['Ueberschrift'])) {
			decode2($seite[0]['Ueberschrift']);
			bb2html($seite[0]['Ueberschrift']);
		}
		if (!empty($seite[0]['Menu'])) {
			$sub_tpl['breadcrumbs'][$page_id] = array('link'=>$page_id,'Menu'=>$seite[0]['Menu']);
			$active[$seite[0]['Menu']] = $page_id;
		}
		$sub_tpl['text'] = stripslashes($tplobj->array2tpl($sub_tpl['seitenvorlage'],$seite[0],'#'));
		build_menu($page_id);
	} else {
		$sub_tpl['text'] = '<p>404 Not Found</p>';
		header("HTTP/1.0 404 Not Found");
	}
	$x = array('%u20AC','%u201E','%u201C', '&amp;nbsp;');
	$y = array('&euro;','&bdquo;','&ldquo;', '&nbsp;');
	return final_output(str_replace($x,$y,main_tpl()),true);
}
function tpl($output=false) {
	global $path_in,$page,$external_functions,$vorgaben;
	get_vorlage(array('TPL_ID'=>$vorgaben['seiten_tpl'],'set_vg'=>false));
	if	(!empty($path_in) && strpos($path_in,'google') !== false && strpos($path_in,'.html') !== false)	{
		$output = google();									// for google verification
	} elseif	(!empty($page) && !empty($external_functions[$page]) && function_exists($external_functions[$page]))	{	// some function are available for ajax
		$vorgaben['stats'] = 0;
		$output = $external_functions[$page](); 			// output of external function
	} elseif	((!empty($path_in) && check_paths())
				|| (!empty($page) && preg_match("/(?:\.css|\.js|\.ico|\.swf|\.woff|\.eot)/i", $page))) {
		$vorgaben['stats'] = 0; $vorgaben['cache'] = false;
		$output = fetch_file();								// get the requested file
	} else {
		$output = cache::read();							// Read from cache or build page.
	}
	if (is_string($output)) {								// Output everything!
		if (!$vorgaben['cache_read']) {
			cache::write();									// and cache for the next time
		}
		final_output($output);
	} elseif (!$output) header_location('/'.$vorgaben['sub_dir']);	// Or got to root directory.
}
function check_paths() {
	global $path_in,$vorgaben;
	if (!empty($vorgaben['exclude_paths'])) {
		$vorgaben['exclude_paths'] = explode(';',$vorgaben['exclude_paths']);
		$vorgaben['exclude_paths'] = array_fill_keys($vorgaben['exclude_paths'],false);
	} else {
		$vorgaben['exclude_paths'] = array();
	}
	$vorgaben['exclude_paths'] = array_merge($vorgaben['exclude_paths'],array('jquery/'=>0,'admin/'=>0,'images/'=>false,'downloads/'=>0));
	foreach ($vorgaben['exclude_paths'] as $k => $v) {
		if (!$v) $bool = strpos($path_in,$k)!==false;
		else	 $bool = strpos($path_in,$k)===0;
		if ($bool)	return $bool;
	}
}
function fetch_file($get_file='',$do_urlencode=true) {
	global $page,$path_in,$vorgaben,$sub_tpl;
	if (!empty($get_file)) {
		$path_in = $get_file;
		$page    = $get_file;
	}
	$ext = endstr($path_in,'.');
	if (!empty($vorgaben['base_dir']))		$fpath[] = $vorgaben['base_dir'].$path_in;
	if (!empty($vorgaben['grp__cms']))		$fpath[] = $vorgaben['grp__cms'].$path_in;
	if (!empty($vorgaben['base_cms']))		$fpath[] = $vorgaben['base_cms'].$path_in;
	if (!empty($vorgaben[$ext.'_path']))	$fpath[] = $vorgaben['base_dir'].$vorgaben[$ext.'_path'].'/'.$page;
	if (!empty($vorgaben[$ext.'_path']))	$fpath[] = $vorgaben['grp__cms'].$vorgaben[$ext.'_path'].'/'.$page;
	if (!empty($vorgaben[$ext.'_path']))	$fpath[] = $vorgaben['base_cms'].$vorgaben[$ext.'_path'].'/'.$page;
	if (!empty($vorgaben['base_dir']))	$fpath[] = $vorgaben['base_dir'].'admin/'.$page;
	if (!empty($vorgaben['grp__cms']))	$fpath[] = $vorgaben['grp__cms'].'admin/'.$page;
	$fpath[] = $vorgaben['base_cms'].'admin/'.$page;
	foreach ($fpath as &$p) {
		$p = parse_url($p);
		$p['path'] = str_replace('%20',' ',rtrim($p['path'],'/?&'));
		if (is_file($p['path'])) {
			$loc = loc_mimetype($p['path']);
			if (empty($get_file)) {
				$sub_tpl['Content-type'] = $loc['mimetype'];
				$vorgaben['expires'] = 3600*24*7;
			}
			if ($loc['ext'] != 'php') {
				if (strpos($loc['mimetype'],'video')!==false) {
					provide_stream($p['path'],$loc['mimetype']);
					return true;
				} elseif (strpos($loc['mimetype'],'image')!==false
						|| ($loc['ext'] != 'css' && strpos($path_in,'jquery')!==false)
						|| strpos($path_in,'downloads')!==false
						|| strpos($path_in,'fonts')!==false
						|| strpos($path_in,'editor')!==false) {
					$vorgaben['noclean'] = 1;
					if (strpos($path_in,'ckeditor')!==false)	$sub_tpl['codepage'] = '';
					content_type();
					if (strpos($loc['mimetype'],'image')!==false || strpos($path_in,'downloads')!==false || strpos($path_in,'ckeditor')!==false) {
						$handle = @fopen($p['path'], "r");
						if ($handle) {
							while (!feof($handle)) {
							   $line = fgets($handle);
							   echo $line;
							}
							fclose($handle);
						}
						return true;
					} else {
						$output = file_get_contents($p['path']);
						zipout($output);
						echo $output;
						return true;
					}
				} else {
					$loc = data($p['path'],$loc);
					if (empty($get_file)) {
						$vorgaben['ext'] = $loc['ext'];
						$sub_tpl['Content-type'] = $loc['mimetype'];
					}
					switch($loc['ext']) {
						case 'css':
						#	$loc['data'] = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $loc['data']);	// Remove comments
						#	if (!$vorgaben['localhost'] && !$vorgaben['preview'])
						#		$loc['data'] = str_replace(array("\r\n", "\r", "\n", "\t"), '', $loc['data']);	// Remove whitespace
							if ($do_urlencode && preg_match_all('/url\((?!data\:image)(\/.*?)\)/i',$loc['data'], $matches)) {
								foreach ($matches[1] as $match) {
									$p = false;
									if (is_file($vorgaben['base_dir'].$match))		$p = $vorgaben['base_dir'].$match;
									elseif (is_file($vorgaben['base_cms'].$match))		$p = $vorgaben['base_cms'].$match;
									if ($p)	{
										$f = loc($p);
										if ($f['ext']!='svg')	$loc['data'] = str_replace($match,'data:image/'.$f['ext'].';base64,'.base64_encode(file_get_contents($p)),$loc['data']);
									#	else					$loc['data'] = str_replace($match,'data:image/svg+xml;utf8,'.file_get_contents($p),$loc['data']);
									}
							}	}
						break;
						case 'js':	$vorgaben['expires'] = 3600*24*14;
						#	if (!$vorgaben['localhost'] && !$vorgaben['preview']) {
						#		$loc['data'] = preg_replace("/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/", "", $loc['data']);	/* remove comments */
						#		$loc['data'] = str_replace(array("\r\n","\r","\t","\n",'  ','    ','     '), '', $loc['data']);			/* remove tabs, spaces, newlines, etc. */
						#		$loc['data'] = preg_replace(array('(( )+\))','(\)( )+)'), ')', $loc['data']);							/* remove other spaces before/after ) */
						#	}
						break;
						case 'xml':	$vorgaben['expires'] = 3600*24;
						default:	$vorgaben['noclean'] = 1;			break;
					}
					if ($vorgaben['localhost'] || $vorgaben['preview']) $vorgaben['expires'] = 1;
					make_replacements($loc['data']);
					return $loc['data'];
				}
			} else {
				include($p['path']);
				return true;
}	}	}	}
function google() {
	global $path_in;
	return 'google-site-verification: '.str_remove($path_in,'.html').'.html';
}
function sitemapurls($l) {
	global $tplobj,$dbobj,$sub_tpl,$lang_id,$vorgaben;
	$sql = "SELECT 		DISTINCT #PREFIX#seiten.PAGE_ID,
						#PREFIX#_languages.LANG_ID,
						SUBSTRING_INDEX(#PREFIX#seiten.lastmod,' ',1) AS lastmod
			FROM 		#PREFIX#_languages,#PREFIX#kategorien,#PREFIX#seiten,#PREFIX#seiten_attr
			WHERE 		#PREFIX#seiten.PAGE_ID		= #PREFIX#seiten_attr.PAGE_ID
			AND			#PREFIX#seiten.LANG_ID		= #PREFIX#_languages.LANG_ID
			AND			#PREFIX#seiten_attr.KAT_ID	= #PREFIX#kategorien.KAT_ID";
	if (!empty($l) && is_numeric($l))
	$sql .= "\nAND			#PREFIX#_languages.LANG_ID	= ".$l;
	$sql .= "\nAND			#PREFIX#_languages.visibility	= 1
			AND			#PREFIX#kategorien.follow		= 1
			AND			#PREFIX#kategorien.visibility	= 1
			AND			#PREFIX#seiten_attr.visibility	= 1
			ORDER BY 	#PREFIX#_languages.position ASC, #PREFIX#seiten_attr.parent_ID,#PREFIX#kategorien.position,#PREFIX#seiten_attr.position,#PREFIX#kategorien.KAT_ID";
	$menu = $dbobj->withkey(__file__,__line__,$sql,'LANG_ID',true,'PAGE_ID');
	if (!empty($menu) && is_array($menu)) {
		foreach ($menu as $LANG_ID => $per_lang) {
			foreach ($per_lang as $PAGE_ID => $link) {
				if (!empty($PAGE_ID)) {
					$link['lastmod'] = $link['lastmod'];
					$link['PAGE_ID'] = $PAGE_ID;
					$link['path'] = linkto(array('PAGE_ID'=>$PAGE_ID,'SET'=>'absolute','LANG_ID'=>$LANG_ID,'nosid'=>true));
					$out[$LANG_ID.'_'.$PAGE_ID] = $tplobj->array2tpl($sub_tpl['sitemapurls'],$link,'#');
		}	}	}
		return implode("\n",$out);
}	}
function popup() {		// Prepare content of page for modal window (jquery/simplomodal.js)
	global $page_id,$lang_id,$vorgaben;
	$referer = url_protocol($_SERVER['HTTP_REFERER'],false);
	$fromURL = array(domain('*'));
	if(!in_array($referer,$fromURL)) {
		read_vorgaben('email','impressum');
		if (!empty($_REQUEST['page_id']) && is_numeric($_REQUEST['page_id'])) {
			if (empty($_REQUEST['lang_id']) || !is_numeric($_REQUEST['lang_id']))	$_REQUEST['lang_id'] = $lang_id;
			$out = get_page(array('PAGE_ID'=>$_REQUEST['page_id'],'LANG_ID'=>$_REQUEST['lang_id'],'feld'=>'Text'));
			make_replacements($out);
			do_links($out);
			return html_entity_decode($out);
}	}	}
function decode2(&$text) {
	global $decode;
	if ($decode) {
		$text = urldecode($text);
		if (!mb_check_encoding($text, 'UTF-8')) {
		#	$text = utf8_encode($text);
	}	}
}
function pageselect() {
	global $dbobj,$tplobj,$lang_id;
	if (!empty($_SESSION['status']) && !is_numeric($_SESSION['status'])) {
		if (empty($_REQUEST['txtUrl'])) $_REQUEST['txtUrl']='';
		my_include('intern/php/admin/', 'administration.php');
		$out = '<html><head>
			<title>%%ALLE_SEITEN%%</title>
	       <meta name="viewport" content="width=device-width, minimum-scale=0.75, initial-scale=1">
			<link rel="stylesheet" type="text/css" href="/admin.css" />
		</head>
		<body>
		$ERROR$
		<form action="" method="post">
			<p style="font-size:1em">
				<label for="search">%%SUCHEN%%:</label><input id="search" type="text">
				<label for="linkto">%%ALLE_SEITEN%%:<select name="linkto" id="linkto" style="width:auto;" size="5" onchange="returnverweis()">'.str_replace('&amp;amp;','&amp;',subpage_of()).'</select></label></p>
			<p><input type="Button" value="%%EINFUEGEN%%" onClick="returnverweis();"></p>
		</form>
		</body>
			<script type="text/javascript" src="/jquery/jquery.js"></script>
			<script type="text/javascript" src="/admin.js"></script>
			<script language="JavaScript">
				window.resizeTo(350,250);
				var refw	= window.opener.CKEDITOR.dialog.getCurrent();
				if (!refw) {
					var refw2	= window.opener.document;
					var url = refw2.getElementById(\''.$_REQUEST['txtUrl'].'\');
				} else {
					var url		= refw.getContentElement(\'info\',\'url\');
					var lnktxt	= refw.getContentElement(\'info\',\'contents\');
				//	var txtAttTitle	= refw.getElementById(\'txtAttTitle\');
				//	var protocol= refw.getElementById(\'cmbLinkProtocol\');
					var text	= \'\';
				}
				function returnverweis() {
					if (refw && document.getElementById(\'linkto\').value != \'\' && document.getElementById(\'linkto\').value != undefined) {
						refw.setValueOf(\'info\',\'url\',	  \'#LINKTO:\' + document.getElementById(\'linkto\').value + \'#\');
						refw.setValueOf(\'info\',\'contents\',document.getElementById(\'linkto\').options[document.getElementById(\'linkto\').selectedIndex].text);
					//	if (txtAttTitle.value == \'\')	txtAttTitle.value	= document.getElementById(\'linkto\').options[document.getElementById(\'linkto\').selectedIndex].title.split(\': \')[1];
						refw.setValueOf(\'info\',\'protocol\',\'\');
						self.close();
					} else if (refw2 && document.getElementById(\'linkto\').value != \'\' && document.getElementById(\'linkto\').value != undefined) {
						url.value = \'#LINKTO:\' + document.getElementById(\'linkto\').value + \'#\';
						self.close();
					}
				}
				$(function() {
					$(\'select\').filterByText($(\'input\'));
				});
			</script>
		</html>';
	$out = preg_replace("/\|[A-Z_0-9]+\|/Us",'',$out);
	$out = $tplobj->read_tpls(str_replace('$ERROR$',error(),$out));
	return final_output($out,true);
}	}
function ck_styles($seite='') {
	global $tplobj,$dbobj,$vorgaben,$tpls;
	$seite = "/**
 * Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
*/

// This file contains style definitions that can be used by CKEditor plugins.

CKEDITOR.stylesSet.add( 'styles', [
	  /* Inline Styles */
	{ name: 'Gro&szlig;',	 element: 'span', attributes: { 'class': 'gross' } },
	{ name: 'Klein', element: 'span', attributes: { 'class': 'klein'} },
	{ name: 'Links', element: 'div',  attributes: { 'class': 'left' } },
	{ name: 'Rechts',element: 'div',  attributes: { 'class': 'right'} },

	  /* Object Styles */
	{ name: 'Bild links',  element: 'img', attributes: { 'class': 'left' } },
	{ name: 'Bild rechts', element: 'img', attributes: { 'class': 'right'} }
]);";
	die(final_output($seite,true));
}
?>