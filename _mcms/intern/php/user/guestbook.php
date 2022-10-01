<?php
function gaestebuch($out='') {
	global $sub_tpl,$dbobj,$vorgaben;
	if		(!empty($_REQUEST['gbremove']))	gb_loeschen();
	elseif  (!empty($_REQUEST['gbverify']))	gb_verify();
	if (isset($_REQUEST['gb_submit']))		gb_speichern();
	$anzahl = 0;
	if (!empty($_REQUEST['gb_accept']) && $_REQUEST['gb_accept'] == 1) {
		$dbobj->singlequery(__file__,__line__,"UPDATE #PREFIX#plugins__gbook SET status = 1 WHERE timestamp = '".$_REQUEST['datum']."' LIMIT 1 ");
		$error['fehler'] = $sub_tpl['freigeschaltet'];
	}
	if (!empty($_REQUEST['gb_remove']) && $_REQUEST['gb_remove'] == 1) {
		$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#plugins__gbook WHERE timestamp = '".$_REQUEST['datum']."' LIMIT 1 ");
		$error['fehler'] = $sub_tpl['geloescht'];
	}
	if (!empty($sub_tpl['gbform']))			$out = $sub_tpl['gbform'];
	elseif (!empty($sub_tpl['eintraege'])) 	$out .= ausgabe();
	return $out;
}
function gb_speichern() {
   global $tplobj,$userid,$dbobj,$sub_tpl,$error,$page_id;
	if (!empty($_POST['gb']['name']))	$eintrag['name']	= my_htmlspecialchars($_POST['gb']['name']);
	if (!empty($_POST['gb']['email']))	$eintrag['email']	= my_htmlspecialchars($_POST['gb']['email']);
	if (!empty($_POST['gb']['eintrag']))$eintrag['eintrag']	= str_replace('"','&quot;',addslashes(my_htmlentities($_POST['gb']['eintrag'])));
	if (!empty($_POST['gb']['url']))	$eintrag['url']		= addslashes(my_htmlspecialchars(url_protocol($_POST['gb']['url'],false)));
	else								$eintrag['url']		= '';
	if (!empty($_REQUEST['verify'])) 	$sub_tpl['gbform']	= str_replace('#GBV#','<input type="hidden" name="verify" value="'.$_REQUEST['verify'].'" />',$sub_tpl['gbform']);
	$sub_tpl['gbform'] = $tplobj->array2tpl($sub_tpl['gbform'],$eintrag,'#',false,true);
	if (!daten_error('gb') && !function_exists('check_captcha') ||  check_captcha()) {
		if (strstr($eintrag['eintrag'], '<a ') || strstr($eintrag['eintrag'], 'href') || strstr($eintrag['eintrag'], 'http'))											$error['info']  = $sub_tpl['keineurls'];
		elseif ($dbobj->exists(__file__,__line__,"SELECT * FROM #PREFIX#plugins__gbook WHERE mail ='".$eintrag['email']."' AND textfeld ='".$eintrag['eintrag']."';"))	$error['info']  = $sub_tpl['existiertschon'];
		elseif (empty($_REQUEST['verify'])) 																															$error['info']  = $sub_tpl['javascript'];
		else {
			$error['info'] = $sub_tpl['danke'];
			if (isset($_POST['zeigen']))	$status = 1;
			else							$status = 0;
			$eintrag['timestamp'] = strtotime('now');
			$sql  = "INSERT INTO #PREFIX#plugins__gbook (name,mail,textfeld,url,mailstatus,timestamp) values ('".$eintrag['name']."','".$eintrag['email']."','".$eintrag['eintrag']."','".$eintrag['url']."',$status,".$eintrag['timestamp'].");";
			$dbobj->singlequery(__FILE__,__LINE__,$sql);
			$id = $dbobj->last_id();
			$eintrag['eintrag'] = str_replace('&quot;','"',$eintrag['eintrag']);
			$eintrag['server'] = domain('*');
			$body['html'] = nl2br($tplobj->array2tpl($sub_tpl['eintragsmail'],$eintrag,'#'));
			parse($body['html']);
			$to = $dbobj->exists(__file__,__line__,"SELECT Name,Email FROM #PREFIX#person WHERE ID = '".$sub_tpl['owner_id']."' AND status > 0;");
			if (!$to) $to = $dbobj->singlequery(__file__,__line__,'SELECT Name,Email FROM #PREFIX#person WHERE kontakt = 1');
			mail_send(array('subject'=>'Eintrag im Gästebuch ['.domain().']','body'=>$body,'to'=>$to));
			cache::clean(array('page_id'=>$page_id));
			unset($_REQUEST);
}	}	}
function ausgabe() {
	global $tplobj,$unterseite_id,$sub_tpl,$gbanzahl;
	$data = auslesen();
	if (isset($unterseite_id))	$start = $unterseite_id;
	else 						$start = 0;
	if (empty($sub_tpl['url']))	$sub_tpl['url'] = '<br /><a rel="nofollow" href="http://#URL#">#URL#</a>';
	if (!empty($data[0]) && is_array($data[0])) {
		for($i = 0; $max = count($data), $i < $max; $i++) {
			$data[$i]['nummer']	= ($gbanzahl-$i-$start*$sub_tpl['proseite']);
			$data[$i]['name']	= stripslashes($data[$i]['name']);
			$data[$i]['text']	= &$data[$i]['textfeld'];
			chk_parse($data[$i]['text'],false,true,true,true);
			if ($data[$i]['timestamp']>0)			$data[$i]['time']			= date('d.m.Y',$data[$i]['timestamp']);
			elseif (!empty($arr[$i]['datetime']))	list($data[$i]['time'],$t)	= explode(' ', $data[$i]['datetime']);
		#	if ($data[$i]['mailstatus']==1)			$data[$i]['name']			= '<a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;'.str_replace('@','%40',$data[$i]['mail']).'">'.$data[$i]['name'].'</a>';
			if (!empty($data[$i]['url']))			$data[$i]['url']			= str_replace('#URL#',stripslashes($data[$i]['url']),$sub_tpl['url']);
			$out[] = $tplobj->array2tpl($sub_tpl['eintraege'],$data[$i],'#');
		}
		return r_implode($out,"\n");
}	}
function auslesen(){
	global $dbobj,$unterseite_id,$sub_tpl,$gbanzahl;
	if (isset($unterseite_id))	$start = $unterseite_id;
	else						$start = 0;
	if (empty($sub_tpl['proseite']))	$sub_tpl['proseite'] = 10;
	$sqla['count']  = "SELECT COUNT(id) as count FROM #PREFIX#plugins__gbook WHERE status = 1;";
	$sqla['select']  = "SELECT * FROM #PREFIX#plugins__gbook WHERE status = 1 ORDER BY id DESC LIMIT ".($start*$sub_tpl['proseite']).",".$sub_tpl['proseite'].";";
	$arr = $dbobj->multiquery(__FILE__,__LINE__,$sqla);
	$gbanzahl = $arr['count']['0']['count'];
	build_subnav($gbanzahl);
	return $arr['select'];
}
function emailvorhanden($email,$text) {
   global $dbobj;
   $sql  = 'SELECT * FROM #PREFIX#plugins__gbook WHERE mail ="'.$dbobj->escape($email).'" AND textfeld ="'.$dbobj->escape($text).'"';
   if (!$dbobj->exists(__FILE__,__LINE__,$sql))  return true;
   else										     return false;
}
function gb_loeschen() {
	global $dbobj,$error,$sub_tpl;
	if (empty($_REQUEST['gbremove'])) {
		$dbobj->singlequery(__file__,__line__,"DELETE FROM #PREFIX#plugins__gbook WHERE phrase = '".$dbobj->escape($_REQUEST['gbremove'])."'");
}	}
function gb_verify() {
	global $dbobj,$tplobj,$sub_tpl,$error,$vorgaben;
	if (!empty($_REQUEST['gbverify']))    {
		$sql = "UPDATE #PREFIX#plugins__forum SET status = 1 WHERE phrase = '".$dbobj->escape($_REQUEST['gbverify'])."' AND status = 0";
		$dbobj->singlequery(__file__,__line__,$sql);
}	}
?>