<?php
function prepare_admin_newsletter() {			// this function gets executeed on startup
	global $dbobj,$add,$add_admin,$add_vorgaben,$plugin_functions,$vorgaben;
	if ($dbobj->table_exists(__file__,__line__,'#PREFIX#plugins__newsletter')) { // if table exists
		$add_admin['plugins']['newsletter'] = array('function' => 'newsletter_admin',	'titel' => '%%NEWSLETTER%%','style'=>'style="background-image:url(/admin/icons/Newspaper-32.png)"');
												//   set function call					 Title in Menu				 an icon
		$add['Newsletter'] = array('nlemail_tpl'=>'%%NLEMAILVORLAGE%%','newsletter_tpl'=>'%%NEWSLETTERVORLAGE%%');	// some presets are needed to execute
		if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#plugins__newsletter','Name'))
			$add_vorgaben['Newsletter']['nleach'] = '<label for="nleach">%%NEWSLETTER_EINZELN_SENDEN%%: </label>		<input id="nleach" type="checkbox" name="vorgaben[nleach]" |NLEACH_CHK| value="1" ><br />';
		if (!empty($vorgaben['nlemail_tpl']))
			$plugin_functions[$vorgaben['nlemail_tpl']][] = 'newsletter_plugin';	// function to execute on page edit
}	}
function startup_newsletter_admin() {			// this functions gets called on startup if rights are set
	cleanup_newsletter();							// cleanup old entries
	if (!empty($_REQUEST['newsletter_remove'])
				|| !empty($_REQUEST['newsletter_remove'])
				|| !empty($_REQUEST['newsletter']['preview'])
				|| !empty($_REQUEST['newsletter']['send'])
				|| !empty($_REQUEST['new_emails'])
				|| !empty($_REQUEST['nlemail'])) {
		save('newsletter');						// save changes, the save functions filters allowed calls
}	}
function newsletter_admin() {					// Aufruf über Menü
	global $vorgaben;
	return admin_pages(array('TPL_ID'=>array($vorgaben['nlemail_tpl'],$vorgaben['newsletter_tpl'])),newsletter_edit());		// show correspondig pages
}
function newsletter_edit() {					// provide NL functionallity to edit recipients
	global $dbobj,$tplobj,$error;
	if (!empty($_REQUEST['nlemail']) && is_array($_REQUEST['nlemail'])) save('nlemails');
	$tpl = '';
	$where = '';
	if (!empty($_REQUEST['nlsearch']) || isset($_REQUEST['nlstatus'])) {
		if (isset($_REQUEST['nlstatus']) && $_REQUEST['nlstatus'] != '')  $where['nlstatus'] = 'status = "'.$_REQUEST['nlstatus'].'"';
		if (!empty($_REQUEST['nlsearch'])) {
			$where['nlsearch'] = '(';
			$where['nlsearch'] .= 'name LIKE "%'.$_REQUEST['nlsearch'].'%" OR email LIKE "%'.$_REQUEST['nlsearch'].'%"';
			if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#plugins__newsletter','Extra'))
				$where['nlsearch'] .= ' OR Extra LIKE "%'.$_REQUEST['nlsearch'].'%"';
			$where['nlsearch'] .= ')';
		}
		if (!empty($where)) $where	= ' WHERE '.implode(' AND ',$where);
	}
	if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#plugins__newsletter','Timestamp'))$recipients = $dbobj->withkey(__FILE__,__LINE__,"SELECT * FROM #PREFIX#plugins__newsletter".$where." ORDER BY Status DESC,Timestamp DESC;",'ID',false);
	else																					$recipients = $dbobj->withkey(__FILE__,__LINE__,"SELECT * FROM #PREFIX#plugins__newsletter".$where." ORDER BY Status DESC,ID DESC;",'ID',false);
	if (!empty($_REQUEST['nlexport'])) {
		$tpl = '<h4>%%EXPORT%%</h4><textarea style="width:50%;min-height:3em">'.$dbobj->tostring(__FILE__,__LINE__,"SELECT Email FROM #PREFIX#plugins__newsletter WHERE ID in ('".implode('\',\'',$_REQUEST['nlexport'])."') ORDER BY Email ASC;",';').'</textarea>';
	}
	if (!empty($recipients) && is_array($recipients)) {
		$n = 1;
		$name1 = '';
		$name3 = '';
		$name4 = '';
		if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#plugins__newsletter','Name')) {
			$name1 = '<td><input type="name"	 name="nlemail[#ID#][Name]"  value="#NAME#" /></td>';
			$name2 = '<th>%%NR%%</th><th>%%NAME%%</th><th>%%EMAIL%%</th>';
			$name3 = '<td><input type="name"	 name="nlemail[neu][Name]"  value="" /></td>';
		} else {
			$name2 = '<th>%%NR%%</th><th>%%EMAIL%%</th>';
		}
		if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#plugins__newsletter','Timestamp')) {
			$name2 .= '<th>%%DATUM%%</th>';
			$name4 .= '<td>#TIMESTAMP#</td>';
		}
		if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#plugins__newsletter','extra')) {
			$name2 .= '<th>%%EXTRA%%</th>';
			$name4 .= '<td>#EXTRA#</td>';
		}
		foreach ($recipients as $id => $recipient) {
			if (empty($recipient['name']))		$recipient['name'] = '';
			if (empty($recipient['extra']))		$recipient['extra'] = '';
			if (!empty($recipient['status'])) {
				$recipient['status_chk'] = 'checked="checked"';
				$recipient['bg'] = 'class="zeile"';
			} else
				$recipient['bg'] = 'style="background-color: #d00"';
			if (!empty($recipient['Timestamp']) && $recipient['Timestamp']!= '0000-00-00 00:00:00')	{
				$recipient['Timestamp'] = format_date($recipient['Timestamp'],'%d.%m.%Y %H:%M');
			} else {
				$recipient['Timestamp'] = '';
			}
			$addr[$id] = $tplobj->array2tpl('<tr #BG#>
				<td>'.$n++.'</td>
				'.$name1.'
				<td><input type="email"	name="nlemail[#ID#][Email]" value="#EMAIL#" /></td>
				'.$name4.'
				<td><input type="checkbox" class="chky status" name="nlemail[#ID#][status]" value="1" #STATUS_CHK# /></td>
				<td><input type="checkbox" class="chkx nlremove" name="newsletter_remove[#EMAIL#]" value="#ID#" /></td>
				<td><input type="checkbox" class="chk mails" name="nlexport[]" title="%%FUER_EXPORT_AUSWAEHLEN%%" value="#ID#" /></td>
			</tr>',$recipient,'#');
		}
		if (!empty($_REQUEST['ps']) && is_numeric($_REQUEST['ps']))	$proseite = $_REQUEST['ps'];
		else														$proseite = 100;
		if (count($addr)>$proseite) {
			global $path_in,$unterseite_id,$sub_tpl;
			$sub_tpl['subnavlink'] = "\n<a href=\"".$path_in.formget(array('request'=>'page,nlsearch,nlstatus,uid')).'#TO#|SID|">#LINK#</a>';
			$sub_tpl['subnavpre']  = '&paginate=';
			$sub_tpl['subnavbox']  = '<p class="nav">#ANZAHL# %%EINTRAEGE%% (#VON# - #BIS#): #CONTENT# '.str_replace(array('#TO#','#LINK#'),array($sub_tpl['subnavpre'].'all','%%ALLE%%'),$sub_tpl['subnavlink']).'</p>';
			if (!empty($_REQUEST['paginate']) && is_numeric($_REQUEST['paginate']))	$unterseite_id = $_REQUEST['paginate'];
			elseif (!empty($_REQUEST['paginate']) && $_REQUEST['paginate']=='all')	$unterseite_id = $_REQUEST['paginate'];
			else																	$unterseite_id = 0;
			if (is_numeric($unterseite_id)) paginate($addr,$proseite);
		}
		$tpl .= '<p><input type="submit" name="send" class="tooltip btn save" title="%%TOOLTIP_EINTRAGEN%%" value="%%EINTRAGEN%%" /></p>
				<h2 class="cb">%%EMPFAENGER%% ('.count($recipients).'):</h2>
				|SUBNAV|
				<table><tr>
					'.$name2.'
					<th><a class="tog_chky status tooltip" title="%%ALLE_AUSWAEHLEN%%">%%STATUS%%</a></th>
					<th><a class="tog_chkx nlremove tooltip" title="%%ALLE_AUSWAEHLEN%%">%%LOESCHEN%%</a></th>
					<th><a class="tog_chk mails tooltip" title="%%ALLE_WAEHLEN%%" >%%EXPORTIEREN%%</a></th>
					</tr>
					<tr class="zeile"><td>(neu)</td>
						'.$name3.'
						<td><input type="email"	name="nlemail[neu][Email]" value="" /></td>
						'.$name4.'
						<td><input type="checkbox" class="chk show" name="nlemail[neu][status]" value="1" /></td>
						<td></td>
						<td></td>
					</tr>'
					.r_implode($addr,"\n").
				'</tr></table>
				|SUBNAV|';
		if (!empty($sub_tpl['subnav']))	$tpl = str_replace('|SUBNAV|',$sub_tpl['subnav'],$tpl);
	}
	$tpl = '<table class="cb"><tr><td>
		<label for="nlsearch">%%SUCHE%%:</label>
		<br /><input type="search" name="nlsearch" id="nlsearch" value="'.ifis(array('source'=>'request','if'=>'nlsearch')).'" />
	</td><td>
		<label>%%STATUS%%:</label><br />
		<input type="radio" name="nlstatus" value="" /> %%ALLE%%<br />
		<input type="radio" name="nlstatus" '.ifis(array('source'=>'request','if'=>'nlstatus','is'=>1,'then'=>'checked="checked"')).' value="1" /> %%BESTAETIGT%%<br />
		<input type="radio" name="nlstatus" '.ifis(array('source'=>'request','if'=>'nlstatus','is'=>0,'then'=>'checked="checked"')).' value="0" /> <span style="color:red;">%%INAKTIV%%</span>
	</td><td>
		<input type="submit" name="search" class="btn search" value="%%SUCHEN%%" />
	</td></tr></table>
	'.$tpl.'
	<p><input type="submit" name="send" class="tooltip btn save" title="%%TOOLTIP_EINTRAGEN%%" value="%%EINTRAGEN%%" /></p>';
	return str_replace(array('#TIMESTAMP#','#EXTRA#'),'',$tpl);
}
function newsletter_plugin($elements='') {			// provide NL functionallity to send
	global $dbobj,$tplobj,$sub_tpl;
	$newsletter = '<table class="cb"><tr><td><p><input type="submit" class="btn preview" name="newsletter[preview]" value="%%NEWSLETTERVORSCHAU%%" /></p>
				<p><input type="submit" class="btn email" name="newsletter[send]" onclick="return confirmSubmit();" value="%%NEWSLETTER_ABSCHICKEN%%" /></p></td>';
	$recipients = $dbobj->withkey(__FILE__,__LINE__,"SELECT ID,Email,status FROM #PREFIX#plugins__newsletter GROUP BY Email ORDER by status DESC;",'ID');
	if (!empty($recipients) && is_array($recipients)) {
		foreach ($recipients as $id => $recipient) {
			if (!empty($recipient['status']))	$addr[1][] = '<option value="'.$id.'" >'.$recipient['Email'].' (+)</option>';
			else								$addr[0][] = '<option value="'.$id.'" style="color:red">'.$recipient['Email'].' (-)</option>';
		}
		$newsletter .= '<td><p><strong>%%EMPFAENGER%% ('.count($addr[1]).'/'.count($recipients).'):</strong><br />
			<select name="newsletter_emails[]" id="nl_empf" size="7" style="width:auto"  multiple="multiple" onchange="$(\'#nlchk\').prop(\'checked\',true);">';
		$newsletter .= r_implode($addr,"\n");
		$newsletter .= '</select></p><p>
				<input type="checkbox" id="nlrem" name="newsletter_remove" value="1" onchange="$(\'#nlchk\').prop(\'checked\',false);" /> %%AUSWAHL_LOESCHEN%%<br />
				<input type="checkbox" id="nlchk" name="newsletter_select" value="1" onchange="$(\'#nlrem\').prop(\'checked\',false);" /> %%NUR_AN_DIESE_EMPFAENGER%%</p></td>';
	}
	$sub_tpl['addscript'][] = '$(\'#nl_empf\').filterByText($(\'#nlsearch\'))';
	$newsletter .= '<td>
				<p><label for="search">%%SUCHEN%%:</label><input id="nlsearch" type="text"></p>
				<p><strong>%%NEU%%:</strong><br /><textarea name="new_emails" id="new_emails" rows="4" cols="35"></textarea><br />(%%KOMMAGETRENNT%%)</tr></table>';
	return $newsletter;
}
function save_newsletter($data=false) {
	$_REQUEST['send'] = 1;
	save_pages($data=false);													// first save page
	newsletter_remove();// remove address
	newsletter_add();	// add addresses
	newsletter_send();	// send
}
function cleanup_newsletter() {								// remove old unverified emails
	global $error,$dbobj;
	if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#plugins__newsletter','Timestamp'))
		$dbobj->singlequery(__FILE__,__LINE__,"DELETE FROM #PREFIX#plugins__newsletter WHERE Status = 0 AND (Timestamp = '0000-00-00 00:00:00' OR DateDiff(NOW(),Timestamp) >= 30)");
}
function newsletter_remove() {								// remove entries
	global $error,$dbobj;
	if (!empty($_REQUEST['newsletter_remove'])) {
		if (!empty($_REQUEST['newsletter_remove']) && is_array($_REQUEST['newsletter_remove'])) $remails = &$_REQUEST['newsletter_remove'];
		elseif (!empty($_REQUEST['newsletter_emails']))											$remails = &$_REQUEST['newsletter_emails'];
		if (!empty($remails)) {
			$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#plugins__newsletter WHERE ID IN (".r_implode($remails).");");
			$emails = array_keys($remails);
			if (!empty($emails[0]) && !is_numeric($emails[0]))	$error['rnl'] = '%%ADRESSEN_GELOESCHT%%: '.implode_ws($emails,'%%UND%%',',');
			else												$error['rnl'] = '%%ADRESSEN_GELOESCHT%%.';
}	}	}
function newsletter_add() {									// add addresses
	global $error,$dbobj;
	if (!empty($_REQUEST['new_emails'])) {
		$new_emails = explode("\n",str_replace(',',"\n",$_REQUEST['new_emails']));
		if ($old = $dbobj->withkey(__FILE__,__LINE__,"SELECT * FROM #PREFIX#plugins__newsletter GROUP BY Email",'Email')) {
			$ok = array_keys($old);
			$c = current($old);
		}
		foreach ($new_emails as $ne) {
			$ne = trim($ne);
			if (!empty($ne) && (empty($ok) || !in_array($ne,$ok))) {
				$name = '';
				if (preg_match_all("!\"(.*)\" \<(.*)\>!Umsi", $ne, $matches)) {
					$name  = $matches[1][0];
					$email = $matches[2][0];
				} else $email = $ne;
				if (isset($c['Name']))	$sql_a[] = 'INSERT INTO #PREFIX#plugins__newsletter (Name,Email,status) VALUES ("'.$name.'","'.$email.'",1);';
				else					$sql_a[] = 'INSERT INTO #PREFIX#plugins__newsletter (Email,status)		VALUES ("'.$email.'",1);';
		}	}
		if (!empty($sql_a)) {
			$dbobj->multiquery(__file__,__line__,$sql_a);
			$error['ne'] = '%%ADRESSEN_HINZUGEFUEGT%%';
}	}	}
function newsletter_send() {								// send NL
	if (!empty($_REQUEST['newsletter']['send']) || !empty($_REQUEST['newsletter']['preview'])) {
		global $dbobj,$tplobj,$error,$sub_tpl,$vorgaben,$lang_id;
		get_vorlage(array('TPL_ID'=>$vorgaben['newsletter_tpl']));
		$sql = "SELECT * FROM #PREFIX#plugins__newsletter WHERE status = 1";	// fetch only verified recipients
		$attachments = get_files(array('PAGE_ID'=>$_REQUEST['pages']['PAGE_ID'],'tpl'=>'#FPATH#'));
		if  (!empty($_REQUEST['newsletter_emails']) && isset($_REQUEST['newsletter_select']))	$sql .= "\nAND ID IN (".implode(',',$_REQUEST['newsletter_emails']).")";
		$sql .= "\nGROUP BY Email;";
		if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#plugins__newsletter','LANG_ID')) {
			$reciver = $dbobj->withkey(__FILE__,__LINE__,$sql,'LANG_ID',true,'ID');		// read recipients from DB with language
		} else {
			$reciver[$lang_id] = $dbobj->withkey(__FILE__,__LINE__,$sql,'ID',true);	// read recipients from DB
		}
		$c = 0;
		if ($reciver) {
			foreach($reciver as $l_id => $to) {
				$c += count($to);
				$msg = get_page(array('PAGE_ID'=>$_REQUEST['pages']['PAGE_ID'],'LANG_ID'=>$l_id,'visibility'=>'0,1'));
				$tpl = get_vorlage(array('PAGE_ID'=>$_REQUEST['pages']['PAGE_ID'],'lang_id'=>$l_id,'nop'=>false));
				$msg['datum'] = date("d.m.Y");
				parse($msg['Text']);
				$body['html'] = $tplobj->array2tpl($sub_tpl['html'],$msg,'#');
				if (!empty($sub_tpl['plain'])) {
					$body['plain'] = $tplobj->array2tpl($sub_tpl['plain'],$msg,'#');
					$body['plain'] = strip_tags($body['plain']);
				}
				$mail_array = array('subject'=>$msg['Titel'],'body'=>$body,'attachments'=>$attachments);
				if (empty($vorgaben['nleach'])) {	// one for all
					$mail_array['bcc'] = $to;
					mail_send($mail_array);
				} else {
					foreach ($to as $to1) {			// everyone gets his/her own
						$mail_array['to'][0] = $to1;
						$mail_array['body']['html'] = $tplobj->array2tpl($body['html'],$to1,'#');
						mail_send($mail_array);
			}	}	}
			if (!empty($_REQUEST['newsletter']['preview']))	$error['newsletter'] = '%%NEWSLETTER_VORSCHAU%%: '.$c.'.';
			else											$error['newsletter'] = '%%NEWSLETTER_VERSANDT%%: '.$c.'.';
		} else 												$error['newsletter'] = '%%KEINE_ABONNENTEN_GEWAEHLT%%';
}	}
function save_nlemails($data=false) {
	global $error,$dbobj,$tplobj;
	if ($dbobj->coloumn_exists(__file__,__line__,'#PREFIX#plugins__newsletter','Name')) {
		$sql_upd = 'UPDATE #PREFIX#plugins__newsletter SET Name = "#NAME#", Email = "#EMAIL#", status = "#STATUS#" ';
		$sql_ins = 'INSERT INTO #PREFIX#plugins__newsletter (Name,Email,status) VALUES ("#NAME#","#EMAIL#",#STATUS#);';
	} else {
		$sql_upd = 'UPDATE #PREFIX#plugins__newsletter SET Email = "#EMAIL#", status = "#STATUS#" ';
		$sql_ins = 'INSERT INTO #PREFIX#plugins__newsletter (Email,status) VALUES ("#EMAIL#",#STATUS#);';
	}
	foreach ($_REQUEST['nlemail'] as $id => $nlemail) {
		if (is_numeric($id) && (empty($_REQUEST['newsletter_remove']) || !in_array($id,$_REQUEST['newsletter_remove']))) {
			$sql_a[] = $tplobj->array2tpl($sql_upd.'WHERE ID = "'.$id.'";',$nlemail,'#');
		} elseif(!is_numeric($id) && !empty($nlemail['Email'])) {
			$sql_a[] = $tplobj->array2tpl($sql_ins,$nlemail,'#');
	}	}
	if (!empty($sql_a))	{
		$dbobj->multiquery(__file__,__line__,$sql_a);
		$error['nl'] = '%%ADRESSEN_GEAENDERT%%';
}	}
?>