<?php
function admin_setlang() {
	global $first_lang_id,$lang,$lang_id,$languages_byid,$sub_tpl;
	get_languages(true);
	if (!empty($_REQUEST['lang_id'])) {
		$lang_id = $_REQUEST['lang_id'];
		$_SESSION['pref_lang'] = $lang_id;
	}
	if (!empty($_SESSION['pref_lang']))				$first_lang_id = $_SESSION['pref_lang'];
	if (!empty($_REQUEST['pages']['LANG_ID']))		$lang_id = $_REQUEST['pages']['LANG_ID'];
	elseif (!empty($_REQUEST['errors']['LANG_ID']))	$lang_id = $_REQUEST['errors']['LANG_ID'];
	elseif (!empty($first_lang_id))					$lang_id = $first_lang_id;
	$sub_tpl['short'] 	 = &$languages_byid[$lang_id]['short'];
	$sub_tpl['codepage'] = &$languages_byid[$lang_id]['codepage'];
}
function lang_id() {
	global $lang_id;
	return $lang_id;
}
function setlang() {
	global $lang,$lang_id,$languages,$languages_byid,$first_lang,$lang_tlds,$set_session,$sub_tpl,$vorgaben;
	get_languages();																		// Load all languages
	$host = str_remove($_SERVER['SERVER_NAME'],array('vorschau.','preview'));				// Get the host name
	if (!empty($_REQUEST['lang']) && !empty($languages[$_REQUEST['lang']])) {				// if language is requested and available
		$lang = &$_REQUEST['lang'];																// set it
		if(!empty($set_session))						$_SESSION['lang']	= $lang;			// in session too, if aplicable.
	} elseif (!empty($_REQUEST['lang_id']) && !empty($languages_byid[$_REQUEST['lang_id']])) {// Maybe the ID of the language is requested
		$lang = $languages_byid[$_REQUEST['lang_id']]['short'];									// set corresponding shortcut
		if(!empty($set_session))						$_SESSION['lang']	= $lang;			// and session variable
	} elseif (!empty($_SESSION['lang']))				$lang = $_SESSION['lang'];			// in case a session with language exists, use ist
	elseif (!empty($host) && !empty($lang_tlds[$host]))	$lang = $lang_tlds[$host]['short'];	// set language to corresponding domain
	work_path();																			// some magic on the path to determine if the language ist set there
	if (!empty($lang) && $lang=='uk' && !empty($languages['en']))	$lang = 'en';			// it may be uk, but the language is en :-P
	if (!$vorgaben['localhost'] && empty($vorgaben['is_preview'])) {						// only online
		if (!empty($languages[$lang]['domain']) && $languages[$lang]['domain'] != $host) {											// if domain an language don't fit
			header_location(url_protocol($languages[$lang]['domain']).str_replace('/'.$lang.'/','/',$_SERVER['REQUEST_URI']),301);	// redirect to proper domain
		} elseif (!empty($languages[$first_lang]['domain']) && $lang_tlds[$host]['short'] != $lang) {								// if language in URL is for main domain
			header_location(url_protocol($languages[$first_lang]['domain']).$_SERVER['REQUEST_URI'],301);							// redirect there
	}	}
	$sub_tpl['lang'] = $lang;																// I'll use this variable globally
	if (!empty($languages[$lang])) {														// finally check language parameters
		if ($languages[$lang]['direction']!='ltr')	$sub_tpl['classes'][] = &$languages[$lang]['direction'];	//  set direction of language (for CSS)
		$lang_id = current($languages[$lang]);																	// set ID
		$sub_tpl['codepage'] = &$languages[$lang]['codepage'];													// and codepage
	}
	if (empty($vorgaben['verwaltung_sprache']))	$vorgaben['verwaltung_sprache'] = &$first_lang;					// if admin language is not set use the first language available
}
function work_path() {
	global $page,$path,$languages,$lang,$vorgaben;
	if (!empty($path[0]) && !empty($languages[$path[0]]['short']) && $languages[$path[0]]['ppl'] > 0) {
		$lang = array_shift($path);
		if (!empty($languages[$lang]['domain']) && !$vorgaben['localhost'])
			header_location(url_protocol($languages[$lang]['domain']).str_replace('/'.$lang.'/','/',$_SERVER['REQUEST_URI']),301);
	}
	if (!empty($path[0])) $page = end($path);
}
function languages() {		// this is to build the language selection on page
	global $tplobj,$lang_id,$page_id,$lang,$first_lang,$languages_byid,$sub_tpl,$vorgaben;
	if (count($languages_byid) > 0) {
		if (empty($lang)) 						$lang = $first_lang;												// if no language is set
		if (empty($sub_tpl['languageblock']))	$sub_tpl['languageblock'] = '<ul class="sprachen">$ENTRIES$</ul>';	// template can be overriden in administration
		if(empty($sub_tpl['languageentry']))	$sub_tpl['languageentry'] = '<li><a href="$LINK$" class="lang_$LANG_ID$ $SHORT$ $ACTIVE$ $DIRECTION$">$LANG_LOCAL$</a></li>';
		$n = 0;
		foreach ($languages_byid as $key => $language) {															// go through evere language
			if ((!empty($vorgaben['alle_sprachen']) || $lang_id != $key) && !empty($language['LANG_ID'])) {				// skip if active laguage doesn't have to show
				if(!empty($language['link'])) {																				// and only if a link exists to this language
					$language['link'] = linkto(array('PAGE_ID'=>$page_id,'LANG_ID'=>$language['LANG_ID']));
					$language['L_ID'] = $language['LANG_ID'];
					$language['n'] = ++$n;																						// language count +1
					if ($language['LANG_ID'] == $lang_id)	$language['active'] = 'active';										// if it's the current language
					else									$language['active'] = '';											// or else ...
				#	$language['lang_local'] = my_htmlspecialchars($language['lang_local']);
					$languages_out[] = $tplobj->array2tpl($sub_tpl['languageentry'],$language,'$,*');								// fill teplate
		}	}	}
		if (!empty($languages_out)) {																				// if there are languages
			return str_replace('$ENTRIES$',"\n\t".implode("\n\t",$languages_out)."\n\t",$sub_tpl['languageblock']);	// fill and return the template.
}	}	}
function get_languages($all=false) {				// get all the languages, well not necessarily all
	global $dbobj,$languages,$languages_byid,$first_lang,$first_lang_id,$lang,$lang_id,$lang_tlds,$sub_tpl,$vorgaben;
	$sql = "SELECT 	#PREFIX#_languages.*,
					COUNT(#PREFIX#seiten.PAGE_ID) AS ppl,
					GROUP_CONCAT(DISTINCT #PREFIX#bilder.Dateiname) AS flags,
					GROUP_CONCAT(DISTINCT #PREFIX#bilder.PART_ID) AS PART_IDs
			FROM 	#PREFIX#_languages
						LEFT JOIN (#PREFIX#seiten)	ON (#PREFIX#seiten.LANG_ID = #PREFIX#_languages.LANG_ID AND #PREFIX#seiten.PAGE_ID = (SELECT PAGE_ID FROM #PREFIX#seiten_attr ORDER BY lft ASC LIMIT 1))
						LEFT JOIN #PREFIX#bilder	ON (#PREFIX#bilder.PAGE_ID = 0 AND PART_ID IN ('flag','flag_a','flag_h') AND #PREFIX#bilder.LANG_ID = #PREFIX#_languages.LANG_ID )\n";
	if (!$all)	$sql .= "WHERE 	#PREFIX#_languages.visibility = 1\n";				// only visible laguages (to public)
	else 		$sql .= "WHERE 	#PREFIX#_languages.visibility IN (0,1)\n";			// every single one
	$sql .= "GROUP BY #PREFIX#_languages.LANG_ID ORDER BY #PREFIX#_languages.position";
	if ($languages = $dbobj->withkey(__file__,__line__,$sql,'short',false)) {		// process SQL and return with shortcut as key
		$currentlanguage = current($languages);											// get the first language and set some variables
		$lang			= $currentlanguage['short'];
		$first_lang		= $lang;
		$lang_id		= $currentlanguage['LANG_ID'];
		$first_lang_id	= $lang_id;
		$sub_tpl['codepage'] = &$currentlanguage['codepage'];
		foreach ($languages as $key => $language) {								// then go through all the languages
			if($language['ppl'] > 0) {												// if there are pages available (ppl = pages per language)
				if (!empty($language['domain']) && !$vorgaben['localhost']) {			// maybe a domian is set for the language (but not local)
					$lang_tlds[$language['domain']]['short']   = $language['short'];		// then build an array with it.
					$lang_tlds[$language['domain']]['LANG_ID'] = $language['LANG_ID'];
					$language['link'] = $language['domain'].'/';							// set link to language specific domain
				}
				elseif (!empty($current['domain']) && !$vorgaben['localhost'])	$language['link'] = $current['domain'].'/'.$language['short'].'/';								// if current domain is set add shortcot here
				elseif ($lang != $language['short'])							$language['link'] = url_protocol(domain('*')).$vorgaben['sub_dir'].'/'.$language['short'].'/';	// or the actual path if language is not the first in the list
				if (!empty($language['PART_IDs'])) {					// this is for using flag images
					$PART_IDs = explode(',',$language['PART_IDs']);		// all the parts
					$flags	  = explode(',',$language['flags']);		// and all the flags
					foreach ($PART_IDs as $key => $PART_ID) {
						$sub_tpl['flag_imgs'][$language['LANG_ID']][$PART_ID] = '/'.$vorgaben['img_path'].'/0_'.$flags[$key];	// build image links
			}	}	}
			$languages_byid[$language['LANG_ID']] = $language;			// and put everything in an array
	}	}
	else $first_lang = 'de';											// if no languages are given default to german (I hope that this nver happens).
}
function lang_flag($l_id='',$PART_ID='flag') {
	global $sub_tpl,$lang_id;
	if (!empty($sub_tpl['flag_imgs'])) {
		if (!empty($l_id) && !empty($sub_tpl['flag_imgs'][$l_id]))	$out = $sub_tpl['flag_imgs'][$l_id];
		elseif (!empty($sub_tpl['flag_imgs'][$lang_id]))			$out = $sub_tpl['flag_imgs'][$lang_id];
		if (!empty($out)) {
			if (empty($PART_ID))	return $out[$PART_ID];
			else					return $out;
}	}   }	
function translate_tpl(&$string) {	
	mb_preg::match_all("/%%([A-Z_]{1,}.+)%%/Us",$string,$matches);
	while(list($key,$match) = myEach($matches[0])) {
		if (!empty($match)) {
			if (!isset($replaced[$matches[1][$key]]))	$replaced[$matches[1][$key]] = gt($matches[1][$key]);
			$string = str_replace($match,$replaced[$matches[1][$key]],$string);
			unset($matches[1][$key],$matches[0][$key]);
}	}	}
function gt($string,$entities=false) {						// That's short for "get translation"
	global $dbobj,$vorgaben,$trans_table,$sub_tpl,$lang_id;
	if (is_array($string))	$string = $string[1];
	else					$string = trim($string,'%');
	if (!empty($_SESSION['pref_lang']))	$l = &$_SESSION['pref_lang'];			// either there is a preferred language per user
	elseif (!empty($lang_id))			$l = &$lang_id;							// or something set by domain or selected alnguage
	else								$l = &$vorgaben['verwaltung_sprache'];	// or it is set in admininstration
	$sql = "SELECT DISTINCT name,value FROM #PREFIX#_translate WHERE LANG_ID = '".$l."';";
	if(empty($trans_table) && $data = $dbobj->withkey(__file__,__line__,$sql,'name',true)) 	$trans_table = $data;	// read from DB if data not available
	if(!empty($trans_table['%'.trim($string,'%').'%']))	$out = str_replace("'","\'",$trans_table['%'.$string.'%']['value']);
	else 												$out = str_replace('_',' ',ucfirst(strtolower($string)));
	if ($entities) {
		if (empty($sub_tpl['Content-type']) || $sub_tpl['Content-type'] != 'text/javascript')	$out = my_htmlentities($out);
	}
	return $out;
}
?>