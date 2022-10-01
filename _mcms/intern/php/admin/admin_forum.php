<?php
function prepare_admin_forum() {
	global $dbobj,$add,$add_admin,$add_vorgaben,$vorgaben,$plugin_functions;
	if ($dbobj->table_exists(__file__,__line__,'#PREFIX#plugins__forum')) {
		$add_admin['plugins']['forum'] = array('function' => 'admin_forum',	'titel' => '%%FORUM%%','style'=>'style="background-image:url(/admin/icons/author-24.png)"');
		$add_vorgaben['Forum']['instapub'] = '<label for="instapub">%%SOFORT_VEROEFFENTLICHEN%%: </label>		<input id="instapub" type="checkbox" name="vorgaben[instapub]" |INSTAPUB_CHK| value="1" ><br />';
		$add['Forum'] = array('forum_seite'=>'%%FORUMEINTRAG%%','forum_tpl'=>'%%FORUMVORLAGE%%');		// Bei Vorgaben Vorlage festlegen lassen, damit sie global zur Verfügung steht
		if (!empty($vorgaben['forum_tpl'])) $plugin_functions[$vorgaben['forum_tpl']][] = 'forum_plugin';	// Diese Funktion wird in der Seitenverwaltung eingebunden.
}	}
function forum_plugin($elements) {
	return admin_forum($elements['PAGE_ID'],'seite','page');
}
function admin_forum($PAGE_ID=0,$tpl='seiten',$frame='forum') {
	global $tplobj,$dbobj,$error,$vorgaben,$tpls,$sub_tpl;
	$sub_tpl['JS']['forum'] = 'forum.js';
	$sub_tpl['CSS']['forum'] = 'gbook.css';
	get_vorlage(array('TPL_ID'=>$vorgaben['seiten_tpl'],'use_js'=>false,'use_css'=>false));
	if (!empty($_REQUEST['forum']) || !empty($_REQUEST['forum_IDs'])) save('forum');
	$tpls = forum_tpl();
	$sql = "SELECT   #PREFIX#seiten.PAGE_ID,#PREFIX#seiten.Titel,Kurzname,position
			FROM 	 #PREFIX#seiten,#PREFIX#seiten_attr,#PREFIX#plugins__forum
			WHERE	 #PREFIX#seiten_attr.TPL_ID = '".$vorgaben['forum_tpl']."'
			AND		 #PREFIX#seiten_attr.PAGE_ID = #PREFIX#plugins__forum.PAGE_ID";
	if (!empty($PAGE_ID)) $sql .= "\nAND 	 #PREFIX#seiten.PAGE_ID = '".$PAGE_ID."'";
	$sql .= pages_sql();
	$sql .= "\nAND 	 #PREFIX#seiten.PAGE_ID = #PREFIX#seiten_attr.PAGE_ID
			GROUP BY #PREFIX#seiten.PAGE_ID
			ORDER BY #PREFIX#seiten_attr.position";
	if ($seiten  = $dbobj->withkey(__file__,__line__,$sql,'PAGE_ID')) {
		$tpls['eintrag'] = str_replace('|FPAGES|',subpage_of(array('TPL_ID'=>$vorgaben['forum_tpl'])),$tpls['eintrag']);
		foreach ($seiten as $seite) {
			$out[]= $tplobj->array2tpl($tpls[$tpl],forum_eintraege($seite));
		}
		return $tplobj->read_tpls(str_replace('|SEITEN|',r_implode($out,"\n"),$tpls[$frame]));
	} else return '%%KEINE_EINTRAEGE%%';
}
function forum_eintraege($seite) {
	global $tplobj,$dbobj,$vorgaben,$tpls;
	$sql = "SELECT   #PREFIX#plugins__forum.*, COUNT(ID) AS count
			FROM 	 #PREFIX#plugins__forum
			WHERE	 #PREFIX#plugins__forum.PAGE_ID = ".$seite['PAGE_ID']."
			GROUP BY #PREFIX#plugins__forum.threadID
			ORDER BY #PREFIX#plugins__forum.threadID DESC,#PREFIX#plugins__forum.ID ASC,date DESC";
	$threads = $dbobj->withkey(__file__,__line__,$sql,'threadID',false,'ID');
	$seite['eintraege'] = '';
	if (!empty($threads) && is_array($threads)) {
		foreach ($threads as $tid => $eintraege) {
			$current = current($eintraege);
			if (!empty($_SESSION['forum_showing']) && in_array($tid,$_SESSION['forum_showing'])) {
			$sql = "SELECT   #PREFIX#plugins__forum.*
					FROM 	 #PREFIX#plugins__forum
					WHERE	 #PREFIX#plugins__forum.threadID = ".$tid." AND #PREFIX#plugins__forum.PAGE_ID = ".$seite['PAGE_ID']."
					ORDER BY #PREFIX#plugins__forum.threadID DESC,#PREFIX#plugins__forum.ID ASC,date DESC";
			$eintraege = $dbobj->withkey(__file__,__line__,$sql,'ID');
			}
			$current['rows'] = forum_answers($eintraege,$seite['PAGE_ID']);
			$seite['eintraege'] .= $tplobj->array2tpl($tpls['thread'],$current);
	}	}
	return $seite;
}
function forum_answers($eintraege,$PAGE_ID) {
	global $tplobj,$dbobj,$vorgaben,$tpls;
	$out = array();
	foreach ($eintraege as $eid => $eintrag) {
		$eintrag['sel_'.$eintrag['PAGE_ID']] = 'selected="selected"';
		$eintrag['titel'] = stripslashes($eintrag['titel']);
		$eintrag['datum'] = format_date($eintrag['date'],'%d.%m.%Y %H:%M');
		$eintrag['date']  = format_date($eintrag['date'],'%Y-%m-%d %H:%M');
		list($eintrag['date'],$eintrag['time']) = explode(' ',$eintrag['date']);
		chk_parse($eintrag['msg'],false,true,true,true);
		if (!empty($eintrag['verified'])) 	$eintrag['visible'] = 'checked="checked"';
		else 								$eintrag['color']   = 'style="color:red"';
		if (!empty($_REQUEST['edit']) && $eid == key($_REQUEST['edit'])) {
			$tpl_msg = $tpls['edit'];	add_fck();
		} else {
			$tpl_msg = $tpls['forum_msg'];
		}
		$eintrag['msg'] = $tplobj->array2tpl($tpl_msg,$eintrag);
		$out[] = str_replace('|PAGE_ID|',$PAGE_ID,$tplobj->array2tpl($tpls['eintrag'],$eintrag));
		unset($eintrag);
	}
	return str_remove(implode("\n",$out),array('#STRIPP#','#STRIPP#')).'<hr />';
}
function save_forum($data=false) {
	global $dbobj,$error;
	if (!empty($_REQUEST['forum']['remove'])) {
		$sql_f[] = "DELETE FROM #PREFIX#plugins__forum WHERE ID IN (".r_implode($_REQUEST['forum']['remove']).");";
	}
	if (!empty($_REQUEST['forum']['page_id'])) {
		foreach ($_REQUEST['forum']['page_id'] as $id => $p) {
			$k = key($p);	$c = current($p);
			if ($k != $c)	$sql_f[] = 'UPDATE #PREFIX#plugins__forum SET PAGE_ID = '.$c.' WHERE ID = '.$id;
	}	}
	if (!empty($_REQUEST['forum_IDs'])) {
		if (!empty($_REQUEST['forum']['visibility'])) {
			$sql_f[] = "UPDATE #PREFIX#plugins__forum SET verified = 0 WHERE ID IN (".r_implode($_REQUEST['forum_IDs']).") && ID NOT IN (".r_implode($_REQUEST['forum']['visibility']).");";
			$sql_f[] = "UPDATE #PREFIX#plugins__forum SET verified = 1 WHERE ID IN (".r_implode($_REQUEST['forum']['visibility']).");";
		} else
			$sql_f[] = "UPDATE #PREFIX#plugins__forum SET verified = 0 WHERE ID IN (".r_implode($_REQUEST['forum_IDs']).");";
	}
	if (!empty($_REQUEST['forum']['update'])) {
		$_REQUEST['forum']['update']['date'] .= ' '.$_REQUEST['forum']['update']['time'];
		unset($_REQUEST['forum']['update']['time']);
		$dbobj->array2db(__FILE__,__LINE__,$_REQUEST['forum']['update'],'#PREFIX#plugins__forum','UPDATE','WHERE ID = '.$_REQUEST['forum']['update']['id']);
	}
	if (!empty($sql_f)) {
		$dbobj->multiquery(__file__,__line__,$sql_f);
		$error['info'] = ' %%EINTRAEGE_BEARBEITET%%';
}	}
function forum_tpl() {
	global $tplobj,$sub_tpl;
	$tpl['forum'] = '<h1>%%FORUM%%</h1>
<form class="forum" action="" method="post">
	<input type="hidden" name="page" value="|PAGE|" />
	|PHPSESSID|
	<p ><input type="submit" name="send" id="submit" class="tooltip btn save" title="%%TOOLTIP_EINTRAGEN%%" value="%%EINTRAGEN%%" /></p>
	|SEITEN|
	<p><input type="submit" name="send" class="tooltip btn save" title="%%TOOLTIP_EINTRAGEN%%" value="%%EINTRAGEN%%" /></p>
</form>';
	$tpl['page'] = '<h1>%%FORUM%%</h1>
  <div class="forum">
	<p><input type="submit" name="send" id="submit" class="tooltip btn save" title="%%TOOLTIP_EINTRAGEN%%" value="%%EINTRAGEN%%" /></p>
	|SEITEN|
	<p><input type="submit" name="send" class="tooltip btn save" title="%%TOOLTIP_EINTRAGEN%%" value="%%EINTRAGEN%%" /></p>
  </div>';
	$tpl['seite'] = '<div class="pages"><table class="entries">|EINTRAEGE|</table></div>';
	$tpl['seiten'] = '<div class="pages cb"><h3><a href="|PHPSELF|?page=pages&amp;pages[PAGE_ID]=|PAGE_ID||SID|">|TITEL|</a></h3><table class="entries" >|EINTRAEGE|</table></div>';
	$tpl['thread'] = '<tr id="thread_|PAGE_ID|_|THREADID|">
	<td><h2 class="trigger tooltip" id="toggle_thread_|PAGE_ID|_|THREADID|" onclick="forum_all(|THREADID|,|PAGE_ID|,|COUNT|);">|TITEL| [|COUNT|]</h2></td>
</tr><tr>
	<td id="tid_|PAGE_ID|_|THREADID|" class="toggle_container toggle_hidden toggle_thread_|PAGE_ID|_|THREADID|">|ROWS|</td>
</tr>';
	$tpl['eintrag'] = '<table><tr class="entry" id="id_|ID|">
	<td style="width:500px"><span class="trigger tooltip small" id="toggle_allmsg_|PAGE_ID|_|THREADID|" title="%%KLICK_TOGGLE%%">(%%ALLE_THREADS%%)</span>
		<h4 |COLOR|><span class="trigger tooltip" id="toggle_msg_|ID|" title="%%KLICK_TOGGLE%%">|TITEL|</span><span class="flr"><a href="mailto:|EMAIL|">|NAME|</a> [|DATUM|]</h4></span>
		<input type="hidden" name="forum_IDs[]" value="|ID|" />
		<div class="toggle_container toggle_hidden toggle_allmsg_|PAGE_ID|_|THREADID| toggle_msg_|ID|">|MSG|</div>
	</td>
	<td style="width:100px"><input type="checkbox"   class="chk show_|PAGE_ID|_|THREADID|" name="forum[visibility][]"  value="|ID|" |VISIBLE| />	<a class="tog_chk show_|PAGE_ID|_|THREADID| tooltip" title="%%ALLE_AUSWAEHLEN%%" >%%ANZEIGEN%%</a></td>
	<td style="width:100px"><select 				 class="sel page_|PAGE_ID|_|THREADID|" name="forum[page_id][|ID|][|PAGE_ID|]">|FPAGES|</select> <a class="tog_sel page_|PAGE_ID|_|THREADID| tooltip" title="%%ALLE_AUSWAEHLEN%%" >%%ALLE_AENDERN%%</a></td>
	<td style="width:100px"><input type="checkbox"   class="chkx del_|PAGE_ID|_|THREADID|" name="forum[remove][]"	  value="|ID|" />			  <a class="tog_chkx del_|PAGE_ID|_|THREADID| tooltip" title="%%ALLE_AUSWAEHLEN%%" >%%LOESCHEN%%</a></td>
</td></tr></table>';
	$tpl['forum_msg'] = '<div class="eintrag">|MSG|</div>
	<p class="cb fll"><input type="submit" name="edit[|ID|]" class="tooltip btn edit" title="%%TOOLTIP_EINTRAGEN%%" value="%%BEARBEITEN%%" /></p>';
	$tpl['edit'] = '<input type="hidden" name="threadID" value="|THREADID|" />
	<input type="hidden" name="forum[update][id]"	value="|ID|" />
	<input type="text"   name="forum[update][name]"  value="|NAME|" />
	<input type="email"  name="forum[update][email]" value="|EMAIL|" />
	<input type="date"   name="forum[update][date]"  value="|DATE|" />
	<input type="time"   name="forum[update][time]"  value="|TIME|" /><br />
	%%TITEL%%: <input name="forum[update][titel]"  value="|TITEL|" />
	<textarea class="fck2" id="update_|ID|" style="width:100%;" name="forum[update][msg]">|MSG|</textarea>
	<p><input type="submit" name="send" class="tooltip btn save" title="%%TOOLTIP_EINTRAGEN%%" value="%%EINTRAGEN%%" /></p>';
	$sub_tpl['style'][] = '.forum p,.forum {clear:both;}
.forum .pages {clear:both;border-bottom:2px solid red;padding-top:1em;max-width:700px}
.forum h2 {padding-top:0em;margin:0;}
.forum .pages h3 {padding-bottom:.5em;}
.forum .pages .entries {width:100%;}

.forum .thread {padding-top:1em;border-top:2px solid #888;clear:both;}
.forum .thread h2 {padding:0;margin:0;}

.forum .entry {border-bottom:1px solid #ccc;margin-bottom:2em;clear:both;}
.forum .entry h3 {float:left;}
.forum .entry td>div {width:100%;clear:both;border:1px solid; padding:5px; margin:5px 0 15px;}';
	return $tplobj->read_tpls($tpl);
}
?>