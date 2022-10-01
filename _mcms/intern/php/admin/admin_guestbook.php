<?php
function prepare_admin_guestbook() {
	global $dbobj,$add,$add_admin;
	if ($dbobj->table_exists(__file__,__line__,'#PREFIX#plugins__gbook')) {			// nur wenn die entsprechende Datenbank existiert
		$add_admin['plugins']['gbook'] = array('function' => 'gbook','titel' => '%%GAESTEBUCH%%','style'=>'style="background-image:url(/admin/icons/Comment.png)"');	// Gästebuchfunktion initialisieren (auch für Rechtevergabe)
		$add['%%GAESTEBUCH%%'] = array('gbook_seite'=>'%%GAESTEBUCHSEITE%%');
}	}
function gbook($out='') {
	global $tplobj,$dbobj,$sub_tpl,$vorgaben;
	$tpls = gbook_tpl();
#	$sub_tpl['CSS']['gbook'] = 'gbook.css';
	if (isset($_REQUEST['update']) || !empty($_REQUEST['action'])) save('gb');
	if (isset($_REQUEST['action']) && isset($_REQUEST['id'])) {
		switch ($_REQUEST['action']) {
			case "edit":	$out .= editieren($tpls);	break;
			case "comm":	$out .= kommentieren($tpls);break;
	}	}
	if (empty($out))		$out .= admin_auslesen($tpls);
	if (!empty($vorgaben['gbook_seite']))	$out = admin_pages(array('PAGE_ID'=>array($vorgaben['gbook_seite']))).$tpls['header'].$out;
	return $out;
}
function admin_auslesen($tpls,$out = '') {
	global $dbobj,$tplobj,$anzahl,$vorgaben;
	if (empty($_GET['start']) || !is_numeric($_GET['start'])) 	$_GET['start'] = 0;
	if ($data = $dbobj->exists(__FILE__,__LINE__,"SELECT * FROM #PREFIX#plugins__gbook ORDER by id DESC;")) {
		$anzahl = count($data);
		for($i = 0; $i < $anzahl; $i++)	{
			if ($data[$i]['timestamp']>0)			$data[$i]['time'] = date(' \(d.m.Y, H:i \U\h\r\)',$data[$i]['timestamp']);
			elseif (!empty($data[$i]['datetime']))	$data[$i]['time'] = str_replace('|DATE|','('.str_replace(' ',', ',$data[$i]['datetime']),$tpls['date']);
			else 									$data[$i]['time'] = '';
			if (empty($data[$i]['status'])) {
				$data[$i]['accept']	= 'style="border:1px solid red;"';		$tpl = str_replace('|ACCEPTLINK|',$tpls['acceptlink'],$tpls['table']);
			} else {
				$data[$i]['accept']	= 'style="border:1px solid green;"';	$tpl = str_replace('|ACCEPTLINK|',$tpls['unacceptlink'],$tpls['table']);
			}
			$data[$i]['nummer']		= ($anzahl-$i-$_GET['start']*10);
			if (empty($data[$i]['mailstatus']))	$style = 'style="color:red"';
			else								$style = '';
			$data[$i]['mail'] = '<a '.$style.' href="mailto:'.stripslashes($data[$i]['mail']).'">'.stripslashes($data[$i]['mail']).'</a>';
			$data[$i]['text'] = &$data[$i]['textfeld'];
			chk_parse($data[$i]['text'],true,true,false,true);
			if (!empty($data[$i]['url']))						$data[$i]['url']  = '(<a target="_blank" href="'.url_protocol(stripslashes($data[$i]['url'])).'">'.stripslashes($data[$i]['url']).'</a>)';
			$data[$i]['name'] = stripslashes($data[$i]['name']);
			$out .= $tplobj->array2tpl($tpl,$data[$i],'|');
		}
		return $out;
}	}
function save_gb($data=false) {
	global $dbobj,$sub_tpl,$vorgaben;
	if (isset($_REQUEST['id']) && isset($_REQUEST['action'])) {
		switch ($_REQUEST['action']) {
			case "del":		gb_remove();	break;
			case "accept":  gb_status(1);	break;
			case "hide":  	gb_status(0);	break;
	}	}
	elseif (isset($_REQUEST['update'])) {
		if (empty($sub_tpl['kommentat']))	$sub_tpl['kommentat'] = "<br /><br />-----<br /><em>%%KOMMENTAR%%:<br /></em> ";
		if (isset($_REQUEST['textfeld']))	$string['textfeld'] = $_REQUEST['textfeld'].$sub_tpl['kommentat'].$_REQUEST['update'];
		else								$string['textfeld'] = $_REQUEST['update'];
		if (isset($_REQUEST['name']))		$string['name'] = $_REQUEST['name'];
		if (isset($_REQUEST['mail']))		$string['mail'] = $_REQUEST['mail'];
		if (isset($_REQUEST['url']))		$string['url']  = $_REQUEST['url'];
		if (!empty($_REQUEST['mailstatus']))$string['mailstatus'] = 1;
		else								$string['mailstatus'] = 0;
		if (isset($_REQUEST['date']))		$string['timestamp'] = strtotime($_REQUEST['date'].' '.$_REQUEST['time']);
		$dbobj->array2db(__FILE__,__LINE__,$string,'#PREFIX#plugins__gbook','INSERT INTO','WHERE id = '.$_REQUEST['id']);
	}
	if (!empty($vorgaben['gbook_seite']))	cache::clean(array('page_id'=>$vorgaben['gbook_seite']));
}
function gb_remove() {
	global $dbobj;
	$dbobj->singlequery(__FILE__,__LINE__,"DELETE FROM #PREFIX#plugins__gbook WHERE id = ".$_REQUEST['id']);
}
function gb_status($s) {
	global $dbobj;
	$dbobj->singlequery(__FILE__,__LINE__,"UPDATE #PREFIX#plugins__gbook SET status = ".$s." WHERE id = '".$_REQUEST['id']."' LIMIT 1");
}
function editieren($tpls) {
	global $dbobj,$tplobj,$vorgaben;
	add_fck();
	$data = $dbobj->singlequery(__FILE__,__LINE__,"SELECT * FROM #PREFIX#plugins__gbook WHERE id = ".$_REQUEST['id'].";");
	if (isset($data[0]['name'])) {
		chk_parse($data[0]['textfeld'],true,true,false,true);
		$data[0]['date']	= date("Y-m-d",$data[0]['timestamp']);
		$data[0]['time']	= date("H:i",$data[0]['timestamp']);
		if (!empty($_REQUEST['nummer'])) $data[0]['nummer'] = $_REQUEST['nummer'];
		if (!empty($data[0]['mailstatus'])) $data[0]['mailstatus_chk'] = 'checked="checked"';
		return $tplobj->array2tpl($tpls['edit'],$data[0]);
}	}
function kommentieren($tpls) {
	global $dbobj,$tplobj,$vorgaben;
	add_fck();
	$data = $dbobj->singlequery(__FILE__,__LINE__,"SELECT * FROM #PREFIX#plugins__gbook WHERE id = ".$_REQUEST['id'].";");
	if (isset($data[0]['name'])) {
		$form = $tpls['comment'];
		if (!empty($_REQUEST['id'])) $data[0]['id'] = $_REQUEST['id'];
		$data[0]['raw']		= $dbobj->data[0]['textfeld'];
		chk_parse($data[0]['textfeld'],true,true,false,true);
		return $tplobj->array2tpl($form,$data[0]);
}	}
function gbook_tpl() {
	global $tplobj;
	$tpl['header'] = '<h1>%%GAESTEBUCH_BEARBEITEN%%</h1>';
	$tpl['comment'] = '<form action="|PHPSELF|?page=gbook" method="post">
		<input type="hidden" name="id" value="|ID|" />
		|PHPSESSID|
		<div style="display:none;"><textarea name="textfeld"  >|RAW|</textarea></div>
		<input type="hidden" name="mailstatus" value="|MAILSTATUS|" />
		<h1>%%EINTRAG_KOMMENTIEREN%%:</h1>
		<div class="eintrag">
			<div class="text">|TEXTFELD|</div>
		</div>
		<p style="width:500px"><label for="update">%%KOMMENTAR%%:</label>
		<textarea id="textarea" type="text" name="update" ></textarea></p>
		<p><input class="btn save" type="submit" name="send" value="%%EINTRAGEN%%" /><br /></p>
	</form>';
	$tpl['date'] = '(|DATE| %%Uhr%%)';
	$tpl['acceptlink'] = ' | <a class="link" href="|PHPSELF|?page=gbook&amp;id=|ID|&amp;action=accept|SID|" style="color:green">%%FREISCHALTEN%%</a>';
	$tpl['unacceptlink'] = ' | <a class="link" href="|PHPSELF|?page=gbook&amp;id=|ID|&amp;action=hide|SID|" style="color:red">%%VERSTECKEN%%</a>';
	$tpl['edit'] = '<form action="|PHPSELF|?page=gbook" method="post">
		<input type="hidden" name="page" value="gbook" />
		|PHPSESSID|
		<input type="hidden" name="id" value="|ID|" />
		<h1>%%EINTRAG_BEARBEITEN%%:</h1>
		<p><label for="name">%%NAME%%:</label>		<input type="text"		name="name"			id="name"	value="|NAME|" /><br />
		<label for="url">%%URL%%:</label>			<input type="text"		name="url" 			id="url"	value="|URL|" /><br />
		<label for="mail">%%EMAIL%%:</label>		<input type="email"		name="mail"			id="mail"	value="|MAIL|" /><br />
		<label for="date">%%DATUM%%: </label>		<input type="date"		name="date"			id="date"	value="|DATE|" /><input type="time" name="time" id="time" value="|TIME|" /><br />
		<label for="ms">%%EMAIL_ZEIGEN%%:</label>	<input type="checkbox"	name="mailstatus" 	id="ms"		value="1" |MAILSTATUS_CHK| />
		</p>
		<p style="width:500px"><textarea id="textarea" type="text" class="fck2" name="update">|TEXTFELD|</textarea></p>
		<p><input class="btn save" type="submit" name="send" value="%%EINTRAGEN%%" />
			<a class="btn back" href="|PHPSELF|?page=|REFERRER||SID|">%%ZURUECK%%</a></p>
	</form>';
	$tpl['form'] = '<form action="|PHPSELF|?page=gbook" method="post">
		<input type="hidden" name="nummer" VALUE="|ID|" />
		|PHPSESSID|
		<p><textarea name="update" cols="50" rows="10">|TEXTFELD|</textarea></p>
		<p><input type="submit" name="send" class="tooltip btn save" title="%%TOOLTIP_EINTRAGEN%%" value="%%EINTRAGEN%%" />
			<a class="btn back" href="|PHPSELF|?page=|REFERRER||SID|">%%ZURUECK%%</a></p>
	</form>';
	$tpl['table'] = '<p class="nummer">%%NR%%: |NUMMER| |TIME|</p>
<div class="eintrag" |ACCEPT|>
	<div class="name"><p>|NAME|, |MAIL| |URL|</p></div>
	<div class="text"><p>|TEXT|</p></div>
	<div>
		<p>
			<a class="link" href="|PHPSELF|?page=gbook&amp;id=|ID|&amp;action=edit|SID|">%%BEARBEITEN%%</a> |
			<a class="link" href="|PHPSELF|?page=gbook&amp;id=|ID|&amp;action=del|SID|">%%LOESCHEN%%</a> |
			<a class="link" href="|PHPSELF|?page=gbook&amp;id=|ID|&amp;action=comm|SID|">%%KOMMENTAR%%</a>
			|ACCEPTLINK|
		</p>
	</div>
</div>';
	return $tplobj->read_tpls($tpl);
}
?>