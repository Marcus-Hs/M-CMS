<?php
function main_tpl($out='',$tpl='') {
	global	$tplobj,$vorgaben;
	$main_tpl = get_maintpl($tpl);
	if (!empty($out) && is_array($out))	$tplobj->array2tpl2($main_tpl,$out);
	if (!empty($tpl) && is_array($tpl)) $tplobj->array2tpl2($main_tpl,$tpl,'|');
	if (!$vorgaben['admin']) {
		make_replacements($main_tpl);
		do_links($main_tpl);
	}
	internal_functions($main_tpl);
	if (!$vorgaben['admin']) {
		clean_up($main_tpl,'text');
		$main_tpl = $tplobj->read_tpls($main_tpl);
		internal_functions($main_tpl,'\$');
	}
	$tplobj->array2tpl2($main_tpl,$vorgaben);
	return $main_tpl;
}
function prep_out(&$string) {
	internal_functions($string);
	do_replacements($string);
	$string = str_replace('#SHY#','&shy',$string);
	return final_output($string,true);
}
function do_links(&$string) {
	$string = preg_replace_callback("/#LINKTO\:([a-zA-Z_0-9\|=;:\-]+?)#/Umsi",	   "linkto",	 $string);
	$string = preg_replace_callback("/#LINKTONOSID\:([a-zA-Z_0-9\|=;:\-]+?)#/Umsi","linktonosid",$string);
}
function final_output($output,$echo=true) {
	content_type();
	cleanout($output);
#	sanitize_output($output);
	subdir_replacements($output);
	$output = str_replace('/downloads//downloads/','/downloads/',$output);
	$output = str_replace('http://www.'.domain().'/http://www.'.domain(),'http://www.'.domain(),$output);
	$output = str_replace('https://www.'.domain().'/https://www.'.domain(),'https://www.'.domain(),$output);
	filter_images($output);
	if (isset($_REQUEST['pqp'])) $output .= run_pqp();	// include Profiling on request
	zipout($output);
	if ($echo) {echo r_implode($output); return true;}
	else 		return $output;
}
function sanitize_output(&$output) {
	$search = array(
		'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
		'/[^\S ]+\</s',  // strip whitespaces before tags, except space
		'/(\s)+/s',	  // shorten multiple whitespace sequences
		'/ {2,}/',		// strip whitespaces
		'/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'		// strip comments
	);
	$replace = array(
		'>',
		'<',
		'\\1',
		' ',
		''
	);
	$output = preg_replace($search, $replace, $output);
}
function get_maintpl($tpl) {
	global	$tplobj,$error,$vorgaben,$sub_tpl;
	if	   (!empty($tpl) && is_array($tpl) && !empty($tpl['admin_body']))	$main_tpl = &$tpl['admin_body'];
	elseif (!empty($tpl))													$main_tpl = &$tpl;
	elseif (!empty($sub_tpl['main_tpl']))									$main_tpl = &$sub_tpl['main_tpl'];
	elseif (!empty($vorgaben['tpl_path']))									$main_tpl = $tplobj->read_tpls('/main.tpl.html',$vorgaben['tpl_path'],false);
	else																	exit('No Templates. Please check database connection');
	return $main_tpl;
}
function internal_functions(&$main_tpl,$sep='\|') {
	mb_preg::match_all("/".$sep."([A-Z_]{2,}+)".$sep."/",$main_tpl,$matches);
	if (!empty($matches[1])) {
		array_walk($matches[1],'lower');
		$f = get_defined_functions();				// only my own functions!
		move_to_bottom($f,'error');
		move_to_bottom($f,'addscripts');
		foreach (array_intersect($matches[1],$f['user']) as $n => $fct)	{
			$res = $fct();
			if (!empty($res))	$main_tpl = str_replace($matches[0][$n],$res,$main_tpl);
			else				$main_tpl = str_replace($matches[0][$n],'',$main_tpl);
		}
		unset($matches,$f);
}	}
function admmeta() {
	global $sub_tpl;
	if (!empty($sub_tpl['admmeta']))	return r_implode("\n\t",$sub_tpl['admmeta']);
}
function cleanout(&$output) {
	if (empty($vorgaben['noclean'])) {
		if (!empty($path) && is_array($path)) {
			$output = str_replace('#SELF#',implode('/',$path),$output);
		}
		clean_up($output,'admin');
		$output = preg_replace("/\|([A-Z]{2,}(\S*))\|/", '',$output);
		$output = preg_replace_callback("/%%([0-9a-z_äöüß]+)%%/Ui","gt",$output);	// Sprachmodul einbinden.
}	}
function zipout(&$output) {
	global $vorgaben;
	if(!empty($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'],'gzip')!==false && !empty($vorgaben['compress'])) {// check if browser supports gzip encoding
		$output = gzencode($output,9);		// crunch content & compress data with gzip
		header('Content-Encoding: gzip');	// send http header
}	}
function error() {							// output error messages.
	global $error,$syserror,$page,$vorgaben,$sub_tpl;
	if (!empty($syserror)) {
		$msg = implode("<hr />\n",array_unique($syserror['errorhandler']));
		$msg = preg_replace_callback("/%%([0-9a-z_äöüß]+)%%/Ui","gt",str_replace('#PAGE#',$page,$msg));
		$title = "Fehler bei ".domain('*');
		if (!$vorgaben['localhost']) {
			$to[0]['Name']	= "ErrorHandler";
			$to[0]['Email']	= "errorhandler@webdesign-haas.de";
			mail_send(array('subject'=>$title,'body'=>$msg,'to'=>$to));
	#		unset($error['errorhandler']);
		} else {
			modal_msg($msg,$title);
		}
	}
	if (!empty($_REQUEST['msg_nr'])  && is_numeric($_REQUEST['msg_nr']))	$error[$_REQUEST['msg_nr']]  = geterror($_REQUEST['msg_nr']);
	if (!empty($_REQUEST['mpay_nr']) && is_numeric($_REQUEST['mpay_nr']))	$error[$_REQUEST['mpay_nr']] = geterror($_REQUEST['mpay_nr'],132);
	if (!empty($error)) {
		if (is_array($error))	$error_out = r_implode("<br />\n",$error);
		make_replacements($error_out);
		$error_out = preg_replace_callback("/%%([0-9a-z_äöüß]+)%%/Ui","gt",str_replace('#PAGE#',$page,$error_out));
		if (empty($sub_tpl['error_dialog'])) {
			$sub_tpl['error_dialog'] = '<dialog open class="error">#ERROROUT#<form method="dialog"><button>X</button></form></dialog>';
		}
		if (!empty($error_out)) return str_replace('#ERROROUT#',htmlspecialchars_decode($error_out,ENT_NOQUOTES),$sub_tpl['error_dialog']);
}	}
function content_type() {
	global $sub_tpl,$vorgaben;
	if (empty($sub_tpl['Content-type']))			$sub_tpl['Content-type'] = 'text/html';
	if (!isset($sub_tpl['codepage']))				$sub_tpl['codepage']	 = 'utf-8';
	if (!empty($sub_tpl['Content-disposition']))	header("Content-disposition: ".$sub_tpl['Content-disposition']);
	header("Strict-Transport-Security: max-age=31536000; includeSubDomains") ;
	header("X-Frame-Options: SAMEORIGIN");
	header("X-Content-Type-Options: nosniff ");
	header("Referrer-Policy: no-referrer");
	header("Permissions-Policy: interest-cohort=()");
//	header("Content-Security-Policy: default-src https") ;
//	if (!empty($sub_tpl['Pragma']))					header("Pragma: ".$sub_tpl['Pragma']);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Authorization, Origin');
header('Access-Control-Allow-Methods:  POST, PUT, GET');
	if (!empty($sub_tpl['Accept-Ranges']))			header("Accept-Ranges: ".$sub_tpl['Accept-Ranges']);
	if (!empty($sub_tpl['lastmod']))				header("Last-Modified: ".$sub_tpl['lastmod']);
	if (!empty($vorgaben['expires'])) {
#		header("Pragma: cache");
		header('Cache-Control: max-age='.$vorgaben['expires']);
		header('Expires: '.gmdate('D, d m Y H:i:s',time()+$vorgaben['expires']).' GMT');
	} else {
#		header("Pragma: no-cache");
		header("Cache-Control: no-cache, no-store, must-revalidate");
		header('Expires: '.gmdate('D, d m Y H:i:s', time() + 60*60*24*21).' GMT');
	}
	if (!empty($_REQUEST['msg_nr']) && is_numeric($_REQUEST['msg_nr'])) {
		switch ($_REQUEST['msg_nr']) {
			case 301:	header("HTTP/1.1 301 Moved Permanently");	break;
			case 404:	header("HTTP/1.0 404 Not Found");			break;
	}	}
	if (!empty($sub_tpl['header']) && is_array($sub_tpl['header'])) {
		foreach ($sub_tpl['header'] as $directive) {
			header($directive);
		}
	}
	if (!empty($sub_tpl['codepage'])) 	$sub_tpl['charset'] = ";charset=".$sub_tpl['codepage'];
	else								$sub_tpl['charset'] = '';
	header("Content-type: ".$sub_tpl['Content-type'].$sub_tpl['charset']);
}
function addscripts() {
	global $tplobj,$sub_tpl,$vorgaben;
	if ($vorgaben['admin']) {				// These scripts are neccessary for the admin section
		$sub_tpl['JS']['admin.js'] = 'admin.js';
		$sub_tpl['JS'] = array_merge (array('jquery/jquery.js','jquery/tooltip.min.js','jquery/autogrow.js','jquery/tablednd.js'),$sub_tpl['JS']);
	}
	if (empty($sub_tpl['nojs'])) {
		if (!empty($sub_tpl['JS'])) {
			$sub_tpl['JS'] = array_unique($sub_tpl['JS']);
			if (in_array('jquery/jquery.js',$sub_tpl['JS'])) {
				if (!empty($sub_tpl['addscript']))		$tpl = "<script type=\"text/javascript\">|PRESCRIPT|\n\t\t$(document).ready(function() {\n\t\t\t|ADDSCRIPT|\n\t\t});\n\t</script>";
				elseif(!empty($sub_tpl['prescript']))	$tpl = "<script type=\"text/javascript\">|PRESCRIPT|\n\t</script>";
				else									$tpl = '';
				move_to_top($sub_tpl['JS'],'jquery/jquery.js');
			} else {
				if (!empty($sub_tpl['addscript']))		$tpl = "<script type=\"text/javascript\">|PRESCRIPT|\n|ADDSCRIPT|</script>";
				elseif(!empty($sub_tpl['prescript']))	$tpl = "<script type=\"text/javascript\">|PRESCRIPT|\n\t</script>";
			}
			foreach ($sub_tpl['JS'] as &$s) {
				if (!empty($s)) {
					$defer = '';
					$s = trim($s);
					if (strpos($s,'defer:')!==false) {
						$s = str_remove($s, 'defer:') ;
						$defer ='async';
					} 
					if (strpos($s,'http')!==0) {
						$s = '/'.$s;
						if (file_exists('/'.$vorgaben['base_dir'].'/'.$vorgaben['js_path'].$s)) {
							$s.='?ts='.filemtime('/'.$vorgaben['base_dir'].'/'.$vorgaben['js_path'].$s);
						} 
					}
#					if (!empty($vorgaben['localhost']) || !empty($vorgaben['preview']))	$s .= '?ts='.time();
					$scripts[] = str_replace(array('|JS|','|DEFER|') ,array($s, $defer) ,'<script |DEFER| src="|JS|" type="text/javascript"></script>');
	}	}	}	}
	if (!empty($sub_tpl['addscript']) || !empty($sub_tpl['prescript'])) {
		if (!empty($sub_tpl['addscript']['errcontent'])) {
			$sub_tpl['addscript']['errcontent'] = "\n\t\t\t$(\"body\").append('<dialog open class=\"info\"><div>".r_implode($sub_tpl['addscript']['errcontent'],'<br /><br /><hr /><br />')."</div><form method=\"dialog\"><button>X</button></form></dialog>');";
		}
		if (empty($tpl))	$tpl = "<script type=\"text/javascript\">|PRESCRIPT|\n\t|ADDSCRIPT|\n</script>";
		$scripts[] = $tplobj->array2tpl($tpl,$sub_tpl,'|',false,false,"\n","\t");
	}
	if (!empty($scripts)) {
		$out = preg_replace_callback("/%%([0-9a-z_äöüß]+)%%/Ui","gt",implode("\n	",$scripts));
		make_replacements($out);
		return $out;
}	}
function addstyles() {
	global $tplobj,$sub_tpl,$vorgaben;
	if (!empty($_SESSION['addstyles'])) {
		foreach($_SESSION['addstyles'] as $k => $v) {
			if (!empty($k) && !empty($v['display']) && $v['show'] == 'true')$sub_tpl['style'][] = $k.' {display:'.$v['display'].';}';
			elseif (!empty($k) && $v['show'] == 'false')					$sub_tpl['style'][] = $k.' {display:none;}';
			else															unset($_SESSION['addstyles'][$k]);
	}	}
	if (empty($sub_tpl['nocss'])) {
		if(empty($sub_tpl['CSS']))	$sub_tpl['CSS'] = array();
		if ($vorgaben['admin'])	{
			array_unshift($sub_tpl['CSS'],'admin.css');		// CSS for the admin section
			unset($sub_tpl['CSS']['pretpl'],$sub_tpl['CSS']['styles.css']);
		}
		elseif (!empty($_REQUEST['design']) && is_numeric($_REQUEST['design']))	array_unshift($sub_tpl['CSS'],'styles_'.$_REQUEST['design'].'.css');	// or every other page on request.
	#	elseif (!in_array('styles.css',$sub_tpl['CSS']))						array_unshift($sub_tpl['CSS'],'styles.css');	// or every other page.
		$sub_tpl['CSS'] = flattenArray($sub_tpl['CSS']);
	#	$sub_tpl['CSS'] = array_unique($sub_tpl['CSS']);
		foreach ($sub_tpl['CSS'] as &$s) {
			if (!empty($s)) {
				$defer = '';
				if (!empty($sub_tpl['allincl'])) {
					if (strpos($s,'http')===false) {
						$sx = fetch_file($s,false);
						if (!empty($sx)) {
							make_replacements($sx);
							array_unshift($sub_tpl['style'],$sx);
							unset($sx);
						}
					} else {
						$s = trim($s);
						if (strpos($s,'http')!==0) {
							$s = '/'.$s;
							if (file_exists('/'.$vorgaben['base_dir'].'/'.$vorgaben['css_path'].$s)) {
								$s.='?ts='.filemtime('/'.$vorgaben['base_dir'].'/'.$vorgaben['css_path'].$s);
							} 
						}
					#	if (!empty($vorgaben['localhost']) || !empty($vorgaben['preview']))	$s .= '?ts='.time();
						$styles[] = str_replace(array('|STYLES|','|DEFER|') ,array($s, $defer),'<link |DEFER| rel="stylesheet" type="text/css" href="|STYLES|" />');
					}
				} else {
						$defer = '';
						$s = trim($s);
						if (strpos($s,'defer:')==0) {
							$s = str_remove($s, 'defer:') ;
							$defer ='async defer';
						} 
						if (strpos($s,'http')!==0) {
							$s = '/'.$s;
							if (file_exists('/'.$vorgaben['base_dir'].'/'.$vorgaben['css_path'].$s)) {
								$s.='?ts='.filemtime('/'.$vorgaben['base_dir'].'/'.$vorgaben['css_path'].$s);
							} 
						}
					if (!empty($vorgaben['localhost']) || !empty($vorgaben['preview']))	$s .= '?ts='.time();
					$styles[] = str_replace(array('|STYLES|','|DEFER|') ,array($s, $defer),'<link |DEFER| rel="stylesheet" type="text/css" href="|STYLES|" />');
	}	}	}	}
	if (!empty($sub_tpl['style']))	$styles[] = $tplobj->array2tpl("<style type=\"text/css\">\n\t\t|STYLE|\n\t</style>",$sub_tpl,'|',false,false,"\n","\t\t");
	if (!empty($styles)) {
		$out = implode("\n\t",$styles);
		make_replacements($out);
		return $out;
}	}
function clean_up(&$string,$switch='all') {
	$function = 'clean_up_'.$switch;
	$function($string);
}
function clean_up_all(&$string) {
	clean_up_text($string);
	clean_up_admin($string);
}
function clean_up_mail(&$string) {
	$string = str_replace(
			array('class="bolder"',	'class="italic"',	'class="underline"',
				'class="hoch"',		'class="tief"',		'class="small"',
				'class="links"',	'class="rechts"',	'class="center"',
				'class="left"',		'class="farleft"',
				'class="right"',	'class="farright"',
				'class="tar"',
				'class="flr"',		'class="fll"',
				'&euro;','&amp;amp;','§SID§'),
			array('style="font-weight:bolder;"',						'style="font-style:italic"',						'style="text-decoration:underline"',
				'style="position:relative;font-size:10px;bottom:3px;"',	'style="position:relative;font-size:10px;top:3px;"','style="font-size:12px"',
				'style="float:left"',									'style="float:right"',								'style="text-align:center;"',
				'style="float:left;margin:0 5px 5px 0;"',				'style="float:left;margin:0 5px 5px 0;"',
				'style="float:right;margin:0 0 5px 5px;"',				'style="float:right;margin:0 0 5px 5px;"',
				'style="text-align:right;"',
				'style="float:right;"',									'style="float:left;"',
				'Euro','&',''),
			$string);
	$string = preg_replace("/\#[A-Z_0-9]+\#/Us",'',$string);
	$string = preg_replace("/\$[a-z_0-9]+\$/Uis",'',$string);
	$string = str_replace('&nbsp',' ',$string);
	$string = str_replace('Â','',$string);
	$string = stripslashes($string);
}
function clean_up_admin(&$string) {
#	$string =	preg_replace("/#(\S+)#/", '',$string);
	$string = str_replace(
				array('&#194;','&sect;FIRMA&sect; - ','&amp;amp;',' &amp; ',' & '	 ,'&amp;#','http://http://','https://http://','href="//','href="mailto:'),
				array('',	   '',					  '&amp;',	  ' &amp; ',' &amp; ',	'&#',	 'http://',		  'https://',		'href="/', 'href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;'),
			  $string);
}
function clean_up_text(&$string) {
	global $first_lang_id,$lang_id,$vorgaben,$sub_tpl;
	if (!empty($sub_tpl['in_replace'])) {
		if (empty($sub_tpl['out_replace'])) $sub_tpl['out_replace'] = '';
		$string = str_replace($sub_tpl['in_replace'],$sub_tpl['out_replace'],$string);
	}
#	$string=preg_replace('/&(?!#?[a-z0-9]+;)/', '#AMP#', $string);
	$string = str_remove($string,array('Ã','#STRIPP#<p>','#STRIPP#</p>','</p>#STRIPP#','<p>#STRIPP#'));
	$string = str_remove($string,array('#STRIPUL#<ul>','#STRIPUL#</ul>','</ul>#STRIPUL#','<ul>#STRIPUL#'));
	$string = str_remove($string,array('#STRIPLI#<li>','#STRIPLI#</li>','</li>#STRIPLO#','<li>#STRIPLI#'));
	$string = str_replace(array('&nbsp; ','&nbsp;&nbsp;',"#AMP#","#SHY#","#NB#",  '#LT#','#GT#','<p></p>',	  '<p><p>','</p></p>'),
						  array(' ',' ','&amp;','&shy;','&nbsp;','&lt;','&gt;','<p>&nbsp;</p>','<p>',   '</p>'),$string);
	if (!$vorgaben['localhost'] && hasSSL(domain('*'))) 								$string = str_replace('"/login.php"','"https://'.domain('*').$vorgaben['sub_dir'].'/login.php"',$string);
	if ($first_lang_id!=$lang_id)														$string = str_replace('login.php','login.php?lang_id='.$lang_id,$string);
	$string = preg_replace("/\#[A-Z_0-9]+\#/Us",'',$string);
#	$string = preg_replace("/\§[A-Z0-9\:]+\§/Us",'',$string);
	$string = preg_replace("/\%[A-Z_0-9]{3,}+\%/Us",'',$string);
	$in		= array("#SECT#","</p>#ENDE#\r\n<p>","\n\t<style type=\"text/css\">\n\t\t\n\t</style>",
					'&ldquo;&rdquo;','&quot;&quot;',' class=" "','class=""','id=""',
					'<h1></h1>','<h2></h2>','<h3></h3>','<h4></h4>','<h5></h5>','</p></p>','<p><h4>');
	if (!empty($sub_tpl['strip'])) $in = array_merge($in,explode('|',$sub_tpl['strip']));
	$string = str_remove($string,$in);
#	filter_links($string);
	if (!empty($sub_tpl['Content-type']) && $sub_tpl['Content-type'] == 'text/xml') $string = html_entity_decode($string);
}
function phpself() {
	global $path_in;
	return '/'.$path_in;
}
function subdir_replacements(&$output) {		// We need to do some replacements if the cms resides in a subdirectory.
	global $vorgaben;
	if (empty($vorgaben['noclean'])) {
		if (!empty($vorgaben['abspaths']))	$path = url_protocol(domain('*')).$vorgaben['sub_dir'];
		else								$path = $vorgaben['sub_dir'];
		$x = array('href="/',
				   'src="/',	'srcset="/',   'poster="/',
				   'url(/',					   "url: '/",
				   "= '/",					   ": '/",
				   "open('/",				   'action="/');
		$y = array('href="'.$path.'/',
				   'src="'.$path.'/', 'srcset="'.$path.'/',		  	'poster="'.$path.'/',
				   'url('.$path.'/',		  	"url: '".$path.'/',
				   "= '".$path.'/',				": '".$path.'/',
				   "open('".$path.'/',			'action="'.$path.'/');
		$output = str_replace($x,$y,$output);
		$output = str_replace('href="'.$path.'/http','href="http',$output);
		$output = str_replace('href="/http','href="http',$output);
}	}
function filter_iframes(&$html) {
	preg_match_all("#<iframe(.*?)\>\<\/iframe\>#sm", $html, $matches);
	$iframes = array();
	foreach ($matches[1] as $mkey => $m) {
		preg_match_all("#(\w+)=['\"]{1}([^'\"]*)#", $m, $matches2);
		foreach($matches2[1] as $key => $val) $iframes[$mkey][$val] = $matches2[2][$key];
	}
	if (!empty($iframes[0]['src'])) {
		foreach ($iframes as $ikey => $iframe) {
			list($file,$data) = explode('::',$iframe['src']);
			$html = str_replace($data,urlencode(str_remove($data,array("\r","\n"))),$html);
}	}	}
function filter_images(&$html,$mail=false) {
	global $sub_tpl,$vorgaben;
	preg_match_all('/<img[^>]+>/i', $html, $matches);
	$images = array();
	foreach ($matches[0] as $mkey => $m) {
		preg_match_all("#(\w+)=['\"]{1}([^'\"]*)#", r_implode($m), $matches2);
		foreach($matches2[1] as $key => $val) $images[$mkey][$val] = $matches2[2][$key];
	}
	if (!empty($images[0])) {
		foreach ($images as $ikey => $image) {
			$file = get_file($image['src']);
			if ($mail && $file != false) {
				$sub_tpl['mailimg'][$ikey] = $file;
			/*	if ($mail=='embed')	$image['src'] = 'data:image/'.strtolower(endstr($image['src'],'.')).';base64,'. base64_encode(file_get_contents($file));
				else*/				$image['src'] = 'cid:myimg'.$ikey;
			} elseif (!empty($sub_tpl['Content-type']) && $sub_tpl['Content-type'] == 'text/xml') {
				$image['src'] = linkto(array('PAGE_ID'=>$vorgaben['home']['PAGE_ID'],'suffix'=>ltrim($image['src'],'/'),'SET'=>'absolute'));
			}
			if (!empty($image['align']) || !empty($image['classname'])) {
				if (!empty($image['classname']))$image['align'] = $image['classname'];
				if (empty($image['class']))		$image['class'] = $image['align'];
				else							$image['class'] .= ' '.$image['align'];
				unset($image['align'],$image['classname']);
			}
			if ($image['src'] !='/'
					&& ($mail || !empty($image['src'])
					&& (strpos($image['src'],'data:image')==0 || !empty($file))
				))	{
				if (!empty($sub_tpl['imgtpl']) && (empty($image['class']) || $image['class']!='nf')) {
					global $tplobj;
					$imgrpl = $tplobj->array2tpl($sub_tpl['imgtpl'],$image,'#');
				#	$imgrpl = preg_replace("/\#[A-Z_0-9]+\#/Us",'',$imgrpl);
				} else {
					$i = '';
					$altfile = false;
					foreach ($image as $attrName => $attrValue) {
						$i .= ' '.$attrName.'="'.$attrValue.'"';
						if ($attrName == 'src') {
							if (!empty($sub_tpl['altimg'][$attrValue]) && is_file($vorgaben['base_dir'].$sub_tpl['altimg'][$attrValue])) {
								$altfile = $sub_tpl['altimg'][$attrValue];
							} else {
								unset($sub_tpl['altimg'][$attrValue]);
								$sub_tpl['oldimg'][$attrValue] = $attrValue;
							}
						}
					}
					if (!$altfile) {
						$imgrpl = '<img'.$i.' />';
					} else {
						$imgrpl = '<picture>
						<source type="image/webp" srcset="'.$altfile.'">
						<img'.$i.' />
					</picture>';
					}
				}
				$html = str_replace($matches[0][$ikey],$imgrpl,$html);
			} else {
				$html = str_remove($html,$matches[0][$ikey]);
	}	}	}
	return $html;
}
?>