<?php
function prepare_forum() {
	global $add_breadc_fct,$external_functions;
	$add_breadc_fct['forum']			= 'forum_breadc';				// Name der Funktion, die für Unterseiten ausgeführt werden soll
	$external_functions['forum.js']		= 'forum_js';
	$external_functions['forum_all.php']= 'forum_all';
}
function forum_breadc($exists) {
	global $dbobj,$bc_path,$bc_fct,$page,$unterseite_id,$notfound,$sub_tpl,$active,$page_id,$vorgaben;
	if (!empty($active) && !empty($vorgaben['forum_tpl']) && empty($bc_fct) && !empty($unterseite_id) && $dbobj->exists(__file__,__line__,"SELECT PAGE_ID FROM #PREFIX#seiten_attr WHERE TPL_ID = '".$vorgaben['forum_tpl']."' AND PAGE_ID IN (".implode(',',$active).")")) { 								// ist die Aktuelle Seite eine Forumsseite?
		if ($seite = $dbobj->exists(__file__,__line__,"SELECT Titel FROM #PREFIX#plugins__forum WHERE threadID = '".$unterseite_id."'")) {	// Gibt es Einträge?
			$bc_fct = 1;
			$sub_tpl['breadcrumbs']['.'.$page_id] = array('link'=>$page_id,'Menu'=>$exists['Menu']);
			$sub_tpl['breadcrumbs'][$page_id] 	  = array('link'=>$bc_path,'Menu'=>$seite[0]['Titel']);					// Dann zu den Brotkrumen hinzufügen.
		} else {
			if (!empty($unterseite))	$page = $unterseite;
		#	$notfound=true;
}	}	}
function forum($data='') {
	global $dbobj,$kategories,$sub_tpl,$unterseite_id,$vorgaben;
	if		(!empty($_REQUEST['fremove']))	f_loeschen();	// Einträge Löschen.
	elseif  (!empty($_REQUEST['fverify']))	f_verify();		// Einträge bestätigen.
	elseif  (!empty($_REQUEST['nonotify']))	f_nonotify();	// Benachrichtigung abschalten.
	$sql = "SELECT   #PREFIX#seiten.PAGE_ID,#PREFIX#seiten.Titel,Kurzname,position
			FROM 	 #PREFIX#seiten,#PREFIX#seiten_attr LEFT JOIN (#PREFIX#plugins__forum) ON (#PREFIX#seiten_attr.PAGE_ID = #PREFIX#plugins__forum.PAGE_ID)
			WHERE	 #PREFIX#seiten_attr.TPL_ID = '".$vorgaben['forum_tpl']."'
			AND 	 #PREFIX#seiten.PAGE_ID = #PREFIX#seiten_attr.PAGE_ID
			GROUP BY #PREFIX#seiten.PAGE_ID
			ORDER BY #PREFIX#seiten_attr.position";
	$kategories = $dbobj->withkey(__file__,__line__,$sql,'PAGE_ID');
	if (!empty($kategories) && is_array($kategories)) {
		get_vorlage(array('PAGE_ID'=>$vorgaben['forum_seite']));
		$sub_tpl['class'][] = 'forum';
		if (!empty($unterseite_id) && is_numeric($unterseite_id))	$out =  eintrag();
		else {
			switch (strtolower($data)) {
				case 'threads':	$out = eintraege();		 break;
				case 'neu':		$out = forum_neu();		 break;
				case 'onlymsg':	$out = kategorien(false);break;
				default: 		$out = kategorien();	 break;
		}	}
		return $out;
}	}
function kategorien($all=true) {
	global $tplobj,$dbobj,$kategories,$sub_tpl,$vorgaben;
	$sql = "SELECT		#PREFIX#seiten.PAGE_ID,#PREFIX#seiten.Titel,Kurzname,
						#PREFIX#plugins__forum.ID,
						#PREFIX#plugins__forum.threadID AS threadID,
						#PREFIX#plugins__forum.titel AS Beitrag,
						#PREFIX#plugins__forum.Name AS Name,
						UNIX_TIMESTAMP(date) as date
			FROM		#PREFIX#seiten,#PREFIX#seiten_attr
							LEFT JOIN (#PREFIX#plugins__forum)
								ON (#PREFIX#seiten_attr.PAGE_ID = #PREFIX#plugins__forum.PAGE_ID AND #PREFIX#plugins__forum.verified = 1)
			WHERE		#PREFIX#seiten_attr.TPL_ID = ".$vorgaben['forum_tpl']."
			AND			#PREFIX#seiten_attr.PAGE_ID = #PREFIX#seiten.PAGE_ID
			GROUP BY	#PREFIX#seiten.PAGE_ID,#PREFIX#plugins__forum.threadID
			ORDER BY	#PREFIX#seiten_attr.position,#PREFIX#plugins__forum.ID ASC";
	$kats = $dbobj->withkey(__file__,__line__,$sql,'PAGE_ID');
	if (empty($sub_tpl['kat_frame']))	$sub_tpl['kat_frame'] = '<div class="eintraege">$ROWS$</div>';
	if (empty($sub_tpl['kat_row']))		$sub_tpl['kat_row']   = '<p><span class="small" style="float:right">[$COUNTER$]</span><a href="§LINKTO:$PAGE_ID$§">$TITEL$</a></p>';
	if (empty($sub_tpl['uhr']))			$sub_tpl['uhr'] = '';
	if (!empty($kats) && is_array($kats)) {
		foreach($kats as $key => $kat) {
			if ($all || !empty($kat['threadID'])) {
				$kat['counter'] = $dbobj->tostring(__file__,__line__,"SELECT COUNT(ID) FROM #PREFIX#plugins__forum WHERE PAGE_ID = '".$kat['PAGE_ID']."' AND ParentID = 0 AND #PREFIX#plugins__forum.verified = 1;");
				if (!empty($kat['date']))	$kat['datum']   = date("d.m.Y",$kat['date']);
				else						$kat['datum']   = '';
				$out[$key]= $tplobj->array2tpl($sub_tpl['kat_row'],$kat,'*,$');
		}   }
		return str_replace(array('§PFLICHTFELD§','$ROWS$'),array('',implode("\n\t\t",$out)),$sub_tpl['kat_frame']);
}	}
function forum_neu() {
	global $dbobj,$tplobj,$sub_tpl,$vorgaben;
	if (!empty($_REQUEST['k']) && is_numeric($_REQUEST['k'])) {
		$kat_id = $_REQUEST['k'];
		$sql = "SELECT   closed
				FROM 	 #PREFIX#plugins__forum
				WHERE	 PAGE_ID = '".$_REQUEST['k']."' LIMIT 1";
		$closed = $dbobj->tostring(__file__,__line__,$sql);
	} elseif (!empty($_REQUEST['parent']) && is_numeric($_REQUEST['parent'])) {
		$sql = "SELECT   ID,threadID,ParentID,PAGE_ID,msg,ebene,titel, UNIX_TIMESTAMP(date) as date, closed
				FROM 	 #PREFIX#plugins__forum
				WHERE	 #PREFIX#plugins__forum.ID = '".$_REQUEST['parent']."'";
		if ($eintrag = $dbobj->exists(__file__,__line__,$sql)) {
			$kat_id 	= $eintrag[0]['PAGE_ID'];
			$eintrag[0]['K_ID'] = $kat_id ;
			$threadID	= $eintrag[0]['threadID'];
			$ParentID	= $eintrag[0]['ParentID'];
			$closed		= $eintrag[0]['closed'];
	}	}
	if (!empty($closed)) {
		if (empty($sub_tpl['closed'])) 	$sub_tpl['closed'] = '<p>%%DISKUSSIONSSTRANG_GESCHLOSSEN%%</p>';
		return $sub_tpl['closed'];
	}
	if (empty($kat_id)) {
		$tpl =  $sub_tpl['keinekategorie'].str_replace('#BACKLINK#','../',$sub_tpl['backlink']);
	} else {
		$tpl = $sub_tpl['formular'];
		if (!empty($_REQUEST['submit']['forum']))		eintragen($kat_id);
		if (!empty($threadID) && !empty($ParentID))		$linkto = linkto(array('PAGE_ID'=>$kat_id,'suffix'=>'/'.$threadID.'§SID§#id'.$eintrag[0]['ID']));
		else											$linkto = linkto(array('PAGE_ID'=>$kat_id));
		$sub_tpl['backlink'] = str_replace('#BACKLINK#',$linkto,$sub_tpl['backlink']);
		if (isset($_REQUEST['forum']['titel'])) 		$tpl = $tplobj->array2tpl($tpl,$_REQUEST['forum'],'#');
		if (!empty($_REQUEST['forum']['publish']))		$tpl = str_replace('#CHECK_PUBLISH#','checked="checked"',$tpl);
		if (isset($_REQUEST['forum']['bedingungen']))	$tpl = str_replace('#CHECK_NB#','checked="checked"',$tpl);
		if (!empty($eintrag) && is_array($eintrag)) {
			$eintrag = $eintrag[0];
			if (!empty($eintrag['ID']))	$tpl =  str_replace('#MSG#',$eintrag['ID'],$tpl);
			if (!empty($eintrag['titel'])) {
				$eintrag['titel']	= 'Antwort: '.stripslashes($eintrag['titel']);
				$eintrag['zeit']	= date("d.m.Y H:i",$eintrag['date']);
				chk_parse($eintrag['msg'],false,true,true,true);
				$tpl =  str_replace('#ANTWORT#',$sub_tpl['eintrag'],$tpl);
				$tpl = $tplobj->array2tpl($tpl,$eintrag,'#');
#				$ipath = $vorgaben['img_path'].'/thumbs/'.$kat_id.'_'.$eintrag[0]['Dateiname'];
#				if (is_file($vorgaben['base_dir'].'/'.$ipath)) 	$tpl = str_replace('#BILD#','<img class="bild" src="/'.$ipath.'" alt="" \>',$tpl);
#				else											$tpl = str_remove($tpl,'#BILD#');
			}
		} elseif (!empty($_REQUEST['forum']['titel'])) {
			$tpl =  str_replace('#ANTWORT#','<h4>'.stripslashes(stripslashes($_REQUEST['forum']['titel'])).'</h4>',$tpl);
			$tpl =  str_replace('#TITEL#',stripslashes(stripslashes($_REQUEST['forum']['titel'])),$tpl);
		} else {
			$tpl =  str_replace('#ANTWORT#','<h4>'.$sub_tpl['neuereintrag'].'</h4>',$tpl);
			$tpl =  str_remove($tpl,'#TITEL#');
	}	}
	if (!empty($kat_id))	$tpl =  str_replace('#K_ID#',$kat_id,$tpl);
	form_prefill($tpl,'forum');
	return $tpl;
}
function eintrag($out='') {
	global $dbobj,$tplobj,$detail,$sub_tpl,$unterseite_id,$page_id,$vorgaben;
	$sql = "SELECT   *, UNIX_TIMESTAMP(date) as date
			FROM 	 #PREFIX#plugins__forum
			WHERE	 #PREFIX#plugins__forum.threadID = ".$unterseite_id."
			AND  	 #PREFIX#plugins__forum.PAGE_ID = ".$page_id."
			AND  	 #PREFIX#plugins__forum.verified = 1
			GROUP BY #PREFIX#plugins__forum.ID
			ORDER BY #PREFIX#plugins__forum.ID";
	$eintraege = $dbobj->singlequery(__file__,__line__,$sql);
	if (!empty($_REQUEST['suche'])) {
		$gesucht2 = urldecode($_REQUEST['suche']);
		$gesucht = explode(' ',$gesucht2);
		$sub_tpl['gesucht'] = '<p id="search">Folgende Begriffe wurden gesucht: '.highlight($gesucht2,$gesucht,true).'</p>';
	}
	if (!empty($eintraege[0]['PAGE_ID'])) {
		$out .= '<p style="margin-bottom:10px;"><a href="'.linkto(array('PAGE_ID'=>$vorgaben['forum_seite'],'suffix'=>'&amp;k='.$eintraege[0]['PAGE_ID'].'§SID§')).'#forum">'.$sub_tpl['neuereintrag'].'</a></p>';
		$out .= '<p style="margin-bottom:10px;">'."\n".'<a href="'.linkto($eintraege[0]['PAGE_ID']).'#forum">§VORIGES§</a></p>'."\n";
	}
	if (!empty($eintraege[0])) {
		$tpl = $sub_tpl['eintrag'];
		if (!empty($sub_tpl['antworten']) && empty($eintraege[0]['closed']))	$tpl .= $sub_tpl['antworten'];
		$sub_tpl['pagetitle'] .= my_htmlspecialchars($eintraege[0]['titel']);
		$detail = &$sub_tpl['pagetitle'];
		foreach ($eintraege as &$eintrag) {
			if (!empty($eintrag['email']) && $eintrag['publish'] == 1)	$eintrag['name'] = '<a href="mailto:'.str_replace('@','%40',$eintrag['email']).'">'.$eintrag['name'].'</a>';
			if (empty($sub_tpl['anzeigentitel']))						$sub_tpl['anzeigentitel'] = stripslashes($eintrag['titel']);
			$eintrag['margin'] = 0;
			$eintrag['titel']  = stripslashes($eintrag['titel']);
			$eintrag['zeit']   = date("d.m.Y H:i",$eintrag['date']);
			$eintrag['thread'] = $eintrag['threadID'];
			chk_parse($eintrag['msg'],false,true,true,true);
			$out .= $tplobj->array2tpl($tpl,$eintrag,'#');
		}
		if (!empty($gesucht))$out = highlight($out,$gesucht);
	} else {
		$out .= '<p style="margin-bottom:10px;">'."\n".'<a href="'.linkto($page_id).'">'.$sub_tpl['voriges'].'</a></p>'."\n";
		$out .= $sub_tpl['keineeintraege'];	# Leider keine Einträge
		$detail = &$sub_tpl['keineeintraegedetail'];
		$vorgaben['nofollow'] = 1;
	}
	return '§GESUCHT§'.$out;
}
function eintraege() {
	global $dbobj,$tplobj,$sub_tpl,$page_id,$vorgaben;
	global $detail;
	$out = '';
	$sql = "SELECT  #PREFIX#plugins__forum.ID,#PREFIX#plugins__forum.threadID,#PREFIX#plugins__forum.publish,#PREFIX#seiten_attr.parent_ID,
					GROUP_CONCAT(UNIX_TIMESTAMP(date) ORDER BY #PREFIX#plugins__forum.ID ASC SEPARATOR '||') as date,
					GROUP_CONCAT(#PREFIX#plugins__forum.name ORDER BY #PREFIX#plugins__forum.ID ASC SEPARATOR '||') as name,
					GROUP_CONCAT(#PREFIX#plugins__forum.titel ORDER BY #PREFIX#plugins__forum.ID ASC SEPARATOR '||') as titel,
					GROUP_CONCAT(#PREFIX#plugins__forum.ID ORDER BY #PREFIX#plugins__forum.ID ASC SEPARATOR '||') as ID
			FROM 	#PREFIX#seiten,#PREFIX#seiten_attr,#PREFIX#plugins__forum
			WHERE	#PREFIX#seiten.PAGE_ID = '".$page_id."'";
	if (!empty($_REQUEST['suche'])	&& 	strlen($_REQUEST['suche'])>3)		$sql .= " AND	 MATCH (#PREFIX#plugins__forum.Titel,msg,name) AGAINST ('".$_REQUEST['suche']."' IN BOOLEAN MODE)";
	elseif(!empty($_REQUEST['suche']))										$sql .= " AND	 CONCAT(#PREFIX#plugins__forum.Titel,' ',msg,' ',name) LIKE '%".$_REQUEST['suche']."%'";
	$sql .= "
			AND 	#PREFIX#seiten_attr.PAGE_ID = #PREFIX#seiten.PAGE_ID
			AND 	#PREFIX#plugins__forum.verified = 1
			AND		#PREFIX#plugins__forum.PAGE_ID = #PREFIX#seiten_attr.PAGE_ID
			GROUP BY #PREFIX#plugins__forum.threadID
			ORDER BY #PREFIX#plugins__forum.ID DESC;";
	$eintraege = $dbobj->withkey(__file__,__line__,$sql,'threadID');
	if (!empty($eintraege) && is_array($eintraege)) {
		$out .= '<p style="margin-bottom:10px;"><a href="'.linkto(array('PAGE_ID'=>$vorgaben['forum_seite'],'suffix'=>'&amp;k='.$page_id.'§SID§')).'">'.$sub_tpl['neuereintrag'].'</a></p>'."\n<div class=\"eintraege\">";
		if (!empty($eintraege[0]['parent_ID']))	$out .= '<p style="margin-bottom:10px;"><a href="'.linkto($eintraege[0]['parent_ID']).'">§VORIGES§</a></p>'."\n";
		else									$out .= '<p style="margin-bottom:10px;">'."\n".'<a href="./">§VORIGES§</a></p>'."\n";
		if (empty($sub_tpl['thread_frame']))	$sub_tpl['thread_frame'] = '<table class="forum">$ROWS$</table>';
		if (empty($sub_tpl['thread_row']))		$sub_tpl['thread_row']   = '<tr><td><a href="$LINK$">$TITLE$</a></td><td style="white-space:pre; padding-right:.5em">$NAME$<br />[$DATE$,  Antw.: $COUNT$]</td><td>$LAST$</td></tr>';
		$such = '';
		$suchid = '';
		if (!empty($_REQUEST['suche'])) {
			$gesucht2 = urldecode($_REQUEST['suche']);
			$gesucht = explode(' ',$gesucht2);
			$sub_tpl['gesucht'] = '<p>Folgende Begriffe wurden gesucht: '.highlight($gesucht2,$gesucht,true).'</p>';
			$such = '?suche='.$_REQUEST['suche'];
			$suchid = '#firstfound';
		}
		if (empty($sub_tpl['uhr']))	$sub_tpl['uhr'] = ' Uhr';
		$out .= $sub_tpl['thread_frame'];
		$thread = '';
		foreach ($eintraege as $thread_id => $eintrag) {
			if ($thread != $thread_id) {
				$thread = $thread_id;
				if (!empty($eintrag['email']) && $eintrag['publish'] == 1) $eintrag['name'] = '<a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;'.str_replace('@','%40',$eintrag['email']).'">'.$eintrag['name'].'</a>';
				$ids   = explode('||',$eintrag['ID']);
				$names = explode('||',$eintrag['name']);
				$dates = explode('||',$eintrag['date']);
				$titles= explode('||',$eintrag['titel']);
				$data['title'] = stripslashes(current($titles));
				$data['name'] = current($names);
				$data['count'] = count($ids)-1;
				$data['link'] = linkto(array('PAGE_ID'=>$page_id,'suffix'=>'/'.$thread_id.$such.'§SID§'.$suchid));
				$data['date'] = date("d.m.Y",current($dates)).'<br />'.date("H:i",current($dates)).$sub_tpl['uhr'];
				$data['laname'] = end($names);
				$data['ladate'] = date("d.m.Y",end($dates)).'<br />'.date("H:i",end($dates)).$sub_tpl['uhr'];
				if (count($ids)>1) {
					$data['last'] = '<span><a href="'.linkto(array('PAGE_ID'=>$page_id,'suffix'=>'/'.$thread_id.'§SID§#id'.array_pop($ids))).'">'.array_pop($titles).'</a> ('.array_pop($names).')<br />'.date("d.m.Y H:i",array_pop($dates)).$sub_tpl['uhr'].'</a></span>';
				} else {
					array_pop($ids);
					$data['last'] = '';
				}
				$rows[$thread_id] = $tplobj->array2tpl($sub_tpl['thread_row'],$data,'*,$');
		}	}
		$out = str_replace('$ROWS$',r_implode($rows,''),$out);
	} else {
		$out  = '<p style="margin-bottom:10px;"><a class="small" href="'.linkto(array('PAGE_ID'=>$vorgaben['forum_seite'],'suffix'=>'&amp;k='.$page_id.'§SID§')).'">'.$sub_tpl['neuereintrag'].'</a></p>'."\n<div class=\"eintraege\">";
		$out .= '<p style="margin-bottom:10px;">'."\n".'<a class="small" href="./">§VORIGES§</a></p>'."\n";
		$out .= $sub_tpl['keineeintraege'];
		$detail = $sub_tpl['nochkeintragdetail'];
		$vorgaben['nofollow'] = 1;
	}
	$out .= '</div>'."\n";
	return $out;
}
function eintragen($kat_id) {
	global $dbobj,$error,$thread,$mid,$danger,$sub_tpl,$lang_id,$vorgaben,$page_id;
	if (!daten_error('forum',$vorgaben['forum_seite'])) {
		$danger = 0;
		if (empty($_REQUEST['forum']['bedingungen']))	$error[] = $sub_tpl['fehlernutzungsbedingungen'];
		else {
			if (empty($_REQUEST['parent'])) 	$_REQUEST['parent'] = 0;
			$sql = "SELECT	#PREFIX#plugins__forum.ID,parents.ebene
					FROM	#PREFIX#plugins__forum LEFT JOIN (#PREFIX#plugins__forum AS parents) ON (parents.parentID = '".$_REQUEST['parent']."')
					WHERE	#PREFIX#plugins__forum.msg = '".$_REQUEST['forum']['nachricht']."'
					AND		#PREFIX#plugins__forum.titel = '".$_REQUEST['forum']['titel']."'";
			if (!$result = $dbobj->exists(__file__,__line__,$sql)) {
				if(!empty($result[0]['ebene'])) 	$ebene = $result[0]['ebene']+1;
				else 								$ebene = 0;
				$temp = $dbobj->singlequery(__file__,__line__,"SELECT MAX(ID) as ID FROM #PREFIX#plugins__forum");
				$mid = $temp[0]['ID']+1;
				if(!empty($_REQUEST['thread']) && is_numeric($_REQUEST['thread']))	$into_forum['threadID'] = $_REQUEST['thread'];
				else																$into_forum['threadID'] = $mid;
				if (!empty($_REQUEST['parent']) && is_numeric($_REQUEST['parent']))	$into_forum['parentID'] = $_REQUEST['parent'];
				if (!empty($_REQUEST['forum']['publish'])) 							$into_forum['publish'] = 1;
				if (!empty($_REQUEST['forum']['mailme'])) 							$into_forum['mailme']  = 1;
				$into_forum['ID']		= $mid;
				$into_forum['ebene']	= $ebene;
				$into_forum['PAGE_ID']	= $kat_id;
				$into_forum['name']		= $_REQUEST['forum']['Name'];
				$into_forum['email']	= $_REQUEST['forum']['Email'];
				$into_forum['msg']		= $_REQUEST['forum']['nachricht'];
				$into_forum['titel']	= $_REQUEST['forum']['titel'];
				$into_forum['date']		= date("Y-m-d H:i:s");
				$into_forum['phrase']	= md5($_SERVER['REMOTE_ADDR'].microtime());
				$into_forum['IP']		= $_SERVER['REMOTE_ADDR'];
				$dbobj->array2db(__file__,__line__,$into_forum,'#PREFIX#plugins__forum');
				forum_mail($into_forum['phrase'],$into_forum['threadID'],$kat_id);
				cache::clean(array('page_id'=>$kat_id));
			} else $error[] = $sub_tpl['eintragexistiert'];
	}	}
	if (!empty($thread))	$_REQUEST['msg'] = &$thread;
	if (!empty($error[0]))	$unterseite = 'neu';
}
function forum_mail($phrase,$thread,$kat_id) {
	global $dbobj,$tplobj,$mid,$error,$sub_tpl,$vorgaben;
	$forum['Name']	 = &$_REQUEST['forum']['Name'];
	$forum['Email']	 = &$_REQUEST['forum']['Email'];
	$forum['titel']  = html_entity_decode(stripslashes(stripslashes($_REQUEST['forum']['titel'])));
	$forum['text']	 = html_entity_decode(stripslashes(stripslashes($_REQUEST['forum']['nachricht'])));
	$linkto			 = linkto(array('PAGE_ID'=>$kat_id,'SET'=>'absolute','nosid'=>true));
	$forum['thread'] = $linkto.'/'.$thread.'#id'.$mid.'§SID§';
	$forum['remove'] = $linkto.'/'.$thread.'&fremove='.$phrase.'§SID§';
	$forum['verify'] = $linkto.'/'.$thread.'&fverify='.$phrase.'§SID§'.'#id'.$mid;
	$body['html']	 = $tplobj->array2tpl($sub_tpl['emaileintrag'],$forum,'#');
	make_clickable($body['html']);
	$bcc = $dbobj->exists(__file__,__line__,"SELECT Name,Email FROM #PREFIX#person,#PREFIX#seiten_attr WHERE PAGE_ID = '".$kat_id."' AND person_ID = ID;");
	if (!empty($vorgaben['instapub'])) {
		$to = $bcc;
		$bcc = '';
		f_verify($phrase);
	} else {
		$to[0]['Name']	 = $forum['Name'];
		$to[0]['Email']	 = $forum['Email'];
	}
	if (mail_send(array('subject'=>'Forum '.domain('*').': "'.$forum['titel'].'"','body'=>$body,'to'=>$to,'bcc'=>$bcc))) {
		unset($_REQUEST['forum']);
		$error[] = $sub_tpl['freischaltung']; #'Der Beitrag wird Freigeschaltet, wenn Sie die erhaltene E-mail bestätigen.';
	}
	return true;
}
function f_loeschen() {
	global $dbobj,$error,$tplobj,$sub_tpl,$vorgaben,$page_id;
	if (empty($sub_tpl['eintraggeloescht']))	get_vorlage(array('PAGE_ID'=>$vorgaben['forum_seite']));
	$sql = "SELECT   followup.ID,followup.threadID
			FROM 	 #PREFIX#plugins__forum as msg,#PREFIX#plugins__forum as followup
			WHERE	 msg.phrase = '".$dbobj->escape($_REQUEST['fremove'])."'
			  AND	 msg.parentID <> msg.ID
			  AND	 followup.parentID = msg.ID";
	$followup = $dbobj->singlequery(__file__,__line__,$sql);
	if (empty($followup[0]['ID'])) {
		$remove_ids = $dbobj->singlequery(__file__,__line__,"SELECT ID,threadID FROM #PREFIX#plugins__forum WHERE #PREFIX#plugins__forum.phrase = '".$dbobj->escape($_REQUEST['fremove'])."'");
		if (!empty($remove_ids[0]['ID'])) {
			$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#plugins__forum WHERE ID = '".$remove_ids[0]['ID']."'");
			cache::clean(array('page_id'=>$page_id));
			$error[]	= $sub_tpl['eintraggeloescht'];		#'Ihr Eintrag ist gelöscht worden.';
		} else $error[] = $sub_tpl['eintragnichtgefunden']; #'Ihr Eintrag konnte in der Datenbank nicht gefunden werden, vielleicht ist er schon gelöscht worden.';
	} else	   $error[] = $sub_tpl['eintragbeantwortet'];	#'Auf Ihren Eintrag ist schon geantwortet worden, er kann leider nicht mehr gelöscht werden.';
}
function f_verify($phrase='') {
	global $dbobj,$tplobj,$sub_tpl,$error,$vorgaben,$page_id;
	if (!empty($phrase))	$_REQUEST['fverify'] = $phrase;
	if (empty($sub_tpl['freigeschaltet']))	get_vorlage(array('PAGE_ID'=>$vorgaben['forum_seite']));
	$sql = "SELECT   *
			FROM 	 #PREFIX#plugins__forum
			WHERE	 #PREFIX#plugins__forum.phrase = '".$dbobj->escape($_REQUEST['fverify'])."';";
	$verified = $dbobj->singlequery(__file__,__line__,$sql);
	if (!empty($verified[0]['ID']) && $verified[0]['verified'] == 0)    {
		$domain = domain();
		cache::clean(array('page_id'=>$page_id));
		$forum['titel']  = $verified[0]['titel'];
		$forum['thread'] = linkto(array('PAGE_ID'=>$verified[0]['PAGE_ID'],'SET'=>'absolute','suffix'=>'/'.$verified[0]['threadID'].'#id'.$verified[0]['ID']));
		$sql = "UPDATE #PREFIX#plugins__forum SET verified = 1 WHERE #PREFIX#plugins__forum.phrase = '".$dbobj->escape($_REQUEST['fverify'])."'";
		$dbobj->singlequery(__file__,__line__,$sql);
		if (empty($phrase)) {	// not on instant activation
			mail_send(array('subject'=>"Forum ".$domain.": ".$sub_tpl['bestaetigt'],'body'=>$forum['thread']));
			$error[] = $sub_tpl['freigeschaltet']; #'Der Beitrag ist jetzt freigeschaltet.';
		}
		if (isset($verified[0]['threadID'])) {
			$linkto			 = linkto(array('PAGE_ID'=>$verified[0]['PAGE_ID'],'SET'=>'absolute'));
			$sql = "SELECT  Name,Email,titel,phrase FROM #PREFIX#plugins__forum WHERE threadID = '".$verified[0]['threadID']."' AND mailme = 1 AND email != '".$verified[0]['email']."'";
			if ($recipients = $dbobj->exists(__file__,__line__,$sql)) {
				$body['plain'] = $tplobj->array2tpl($sub_tpl['emailantwort'],$forum,'#');
				foreach ($recipients as $to) {
					$to['nomail'] = $linkto.'/'.$verified[0]['threadID'].'&nonotify='.$to['phrase'].'§SID§';
					$body['plain'] = $tplobj->array2tpl($body['plain'],$to,'#');
					$body['html'] = $body['plain'];
					make_clickable($body['html']);
					mail_send(array('subject'=>'Forum '.$domain.': "'.$sub_tpl['eineantwort'],'body'=>$body,'to'=>array(0=>$to)));
	}	}	}	}
	else $error[] = $sub_tpl['schonfreigeschaltet'];
}
function f_nonotify($phrase='') {
	global $dbobj,$sub_tpl,$error,$vorgaben;
	$sql = "SELECT   *
			FROM 	 #PREFIX#plugins__forum
			WHERE	 #PREFIX#plugins__forum.phrase = '".$dbobj->escape($_REQUEST['nonotify'])."';";
	$nonotify = $dbobj->singlequery(__file__,__line__,$sql);
	if (empty($sub_tpl['nonotify']))	get_vorlage(array('PAGE_ID'=>$vorgaben['forum_seite']));
	if (!empty($nonotify[0]['ID']) && $nonotify[0]['mailme'] == 1)    {
		$sql = "UPDATE #PREFIX#plugins__forum SET mailme = 0 WHERE #PREFIX#plugins__forum.phrase = '".$dbobj->escape($_REQUEST['nonotify'])."'";
		$dbobj->singlequery(__file__,__line__,$sql);
		$error[] = $sub_tpl['nonotify']; #'Keine Benachrichtigung';
}	}
function highlight($text,$gesucht,$target=false,$result ='') {
	if (!$gesucht) 										return $text;
	if (is_array($gesucht) && (count($gesucht) == 0))	return $text;
	$text = '<!--h-->'.$text;  // add a tag in front (is needed for preg_match_all to work correct)
	preg_match_all('/(<[^>]+>)([^<>]*)/', $text, $matches);
	foreach ($matches[2] as $key => $match) {
		if ($key!=0) $result .= $matches[1][$key];
			$result .= highlight2($gesucht,$matches[2][$key],$target);	// throw it all together again while applying the highlight to the text pieces
	}
	return $result;
}
function highlight2($gesucht,$subject,$target) {
	foreach ($gesucht as $key => $word) {
		$word = urldecode($word);
		$regex_chars = '\.+?(){}[]^$';
		for ($i=0; $i<strlen($regex_chars); $i++) {
			$char = substr($regex_chars, $i, 1);
			$word = str_replace($char, '\\'.$char, $word);
			if ($i==0)	$id ='firstfound_'.$i;
		}
		$word = '(.*)('.$word.')(.*)';
		$hx = $key%10;
		if ($target)	$subject = eregi_replace($word, '\1<a class="h'.$hx.'" href="#'.$id.'">\2</a>\3', $subject);
		else			$subject = eregi_replace($word, '\1<span class="h'.$hx.'" id="'.$id.'">\2</span>\3', $subject);
	}
	return $subject;
}
function forum_js() {
	global $sub_tpl;
	$sub_tpl['Content-type'] = 'text/javascript';
	$script = "function forum_all(id,p,c) {
	if ($('#tid_'+id).parent().find('tr.toggle_thread_'+p+'_'+id).length < c) {
		$.ajax({
			url: '/forum_all.php?id='+id+'&p='+p+'&PHPSESSID='+$('#PHPSESSID').val(),
			cache: false,
			success: function(html) {
				$('#tid_'+p+'_'+id).html(html);
				$('#tid_'+p+'_'+id+' .trigger').bind('click', function()	{mod_session(this.id);});
				$('#tid_'+p+'_'+id+' .tooltip').tooltip({track: true, delay: 0, showURL: false, showBody: ' - ', fade: 250,top:10 });
				init_togs();
			}
		});
	}
}";
	return final_output($script,true);
}
function forum_all($seite='') {
	global $tplobj,$dbobj,$vorgaben,$tpls;
	if (!empty($_SESSION['status']) && !is_numeric($_SESSION['status'])
				&& !empty($_REQUEST['p']) && is_numeric($_REQUEST['p'])
				&& !empty($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
		$_SESSION['forum_showing'][] = $_REQUEST['id'];
		my_include('intern/php/admin/','administration.php');
		my_include('intern/php/admin/','admin_forum.php');
		$tpls = forum_tpl();
		$tpls['eintrag'] = str_replace('|FPAGES|',subpage_of(array('TPL_ID'=>$vorgaben['forum_tpl'])),$tpls['eintrag']);
		$sql = "SELECT   #PREFIX#plugins__forum.*
				FROM 	 #PREFIX#plugins__forum
				WHERE	 #PREFIX#plugins__forum.threadID = ".$_REQUEST['id']." AND #PREFIX#plugins__forum.PAGE_ID = ".$_REQUEST['p']."
				GROUP BY #PREFIX#plugins__forum.ID
				ORDER BY #PREFIX#plugins__forum.threadID DESC,#PREFIX#plugins__forum.ID ASC,date DESC";
		if ($threads = $dbobj->withkey(__file__,__line__,$sql,'threadID',false,'ID')) {
			foreach ($threads as $tid => $eintraege) {
				$current = current($eintraege);
				$current['count'] = count($eintraege);
				$seite .= forum_answers($eintraege,$threads['PAGE_ID']);
				unset($eintraege);
		}	}
		return final_output($seite,true);
}	}
?>