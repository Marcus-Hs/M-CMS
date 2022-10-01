<?php
function prepare_contact() {
	global $external_functions;
	$external_functions['show_msg.php']		 = 'show_msg';
	$external_functions['quick_contact.php'] = 'quick_contact';
	$external_functions['quick_contact.js']	 = 'quick_contact_js';
}
function validateReferer() {
	if(isset($_SERVER['HTTPS'])) {
		$protocol = "https://";
	} else {
		$protocol = "http://";
	}
	$absurl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
	$absurlParsed = parse_url($absurl);
	$result= false;
	if(isset($_SERVER['HTTP_REFERER'])) {
		$httpReferer = $_SERVER['HTTP_REFERER'];
	    $refererParsed = parse_url($httpReferer);
	    if (isset($refererParsed['host'])) {
	        $absUrlRegex = '/'.strtolower($absurlParsed['host']).'/';
	        $isRefererValid = preg_match($absUrlRegex, strtolower($refererParsed['host']));
	        if($isRefererValid==1) {
	        	$result = true;
	    	}
	    } else {
	    	$result = false;	
	    }
	} else {
		$result = false;
	}
	return $result;
}

function pflichtfeld() {
	global $tplobj,$sub_tpl;
	$honeypot = '<span class="req" style="position:absolute;visibility:hidden;" >
    <label for="website" >Leave blank</label>
    <input type="text" name="website" >
</span>' ;
	return $honeypot.$sub_tpl['pflichtfeld'];
}
function show_msg() {
	global $dbobj,$tplobj,$sub_tpl;
	if (!empty($_SESSION['status']) && $_SESSION['status'] == 'Admin' || !empty($_SESSION['permissions']['kunden'])) {
		$msg = $dbobj->tostring(__file__,__line__,"SELECT Message FROM #PREFIX#person WHERE ID = '".$_REQUEST['uid']."';");
		return html_entity_decode($msg);
}	}
function contact($data=array()) {
	global $dbobj,$tplobj,$sub_tpl,$error,$page_id,$vorgaben;
	if(isset($_POST['website']) && $_POST['website'] != '' && !validateReferer()){
	    die("It appears you are a bot!") ;
	}
	$default = array('tpl'=>"mailform",'form'=>"kontakt",'error_nr'=>10,'to'=>false ,'from'=>false ,'bcc'=>false);
	extract(merge_defaults_user($default,$data),EXTR_SKIP);
	if (is_string($form)) {
		$f = explode(',',$form);
		$form = $f[0];
	}
	if 		(!empty($data) && is_string($data) && !empty($sub_tpl[$data])) 	$tpl = &$sub_tpl[$data];
	elseif  (!empty($tpl)  && is_string($tpl)  && !empty($sub_tpl[$tpl])) 	$tpl = &$sub_tpl[$tpl];
	if (isset($_REQUEST['reset']))		unset($_REQUEST[$form]);
	elseif (!empty($_REQUEST[$form]))	$input = &$_REQUEST[$form];
	if (!empty($_REQUEST['submit']) || !empty($_REQUEST['send']) || isset($_REQUEST['send_x']) || isset($_REQUEST['send_y'])) {
		if (!empty($_REQUEST['copy']))	$_REQUEST[$form]['chk_copy'] = 'checked="checked"';
		$e = false;
		foreach ($f as $f1) {
			$e = daten_error($f1);
		}
		if (!empty($input) && empty($error)) {
			if (!empty($input['betreff']))			$subject = &$input['betreff'];
			elseif (!empty($input['subject']))		$subject = &$input['subject'];
			elseif (!empty($input['kurs']))			$subject = &$input['kurs'];
			elseif (!empty($sub_tpl['subject']))	$subject = &$sub_tpl['subject'];
			else									$subject = 'Anfrage';
			if (isset($vorgaben['select_subject']))	{
				switch ($vorgaben['select_subject']) {
					case 1: $subject .= ' ['.domain('*').']';	break;
					case 2: $subject .= ' ['.domain().']';		break;
					case 3: $subject .= ' ['.domain(0).']';		break;
			}	}
			else 			$subject .= ' ['.domain().']';
			if (empty($input['mitteilung']))		$input['mitteilung'] = '';
			if (!empty($_SERVER['REMOTE_ADDR']))		$input['remote_ip'] = $_SERVER['REMOTE_ADDR'];
			if (!empty($sub_tpl['emailplain'])) {
				$body['plain']= $tplobj->array2tpl($sub_tpl['emailplain'],$input,'#',false,true);
			}
			if (!empty($sub_tpl['emailbody'])) {
				$input['mitteilung'] = nl2br($input['mitteilung']);
				$body['html'] = $tplobj->array2tpl($sub_tpl['emailbody'],$input,'#',false,true);
			}
			if		(empty($body['plain']) && !empty($body['html']))  $body['plain'] = strip_tags($body['html']);
			elseif	(empty($body['html'])  && !empty($body['plain'])) $body['html']  = nl2br($body['plain']);
			if (!empty($vorgaben['abbinder_seite'])) {
				$abbinder['abbinder'] = get_page(array('PAGE_ID'=>$vorgaben['abbinder_seite'],'feld'=>'Text','visibility'=>'0,1','status'=>'any','errors'=>false));
				get_vorlage(array('PAGE_ID'=>$vorgaben['abbinder_seite'],'set_sub_tpl'=>true,'use_css'=>false,'use_js'=>false));
				if (empty($sub_tpl['headhtml']))		$sub_tpl['headhtml'] = '';
				if (empty($sub_tpl['abbinderhtml']))	$sub_tpl['abbinderhtml'] = $abbinder['abbinder'];
				$body['html']  = preg_replace("/\#[A-Z_0-9]+\#/Us",'',$sub_tpl['headhtml'].$body['html'].$sub_tpl['abbinderhtml']);
				if (!empty($sub_tpl['abbinderplain']) && !empty($body['plain'])) {
					if (!empty($sub_tpl['headplain']))	$sub_tpl['headplain'] = '';
					$body['plain'] = preg_replace("/\#[A-Z_0-9]+\#/Us",'',$sub_tpl['headplain'].$body['plain'].$sub_tpl['abbinderplain']);
				}
			} else {
				if (!empty($sub_tpl['bodyhtml'])) {
					$body['html']  = preg_replace("/\#[A-Z_0-9]+\#/Us",'',str_replace('#MSG#',$body['html'],$sub_tpl['bodyhtml']));
				}
				if (!empty($sub_tpl['bodyplain']) && !empty($body['plain']))
					$body['plain'] = preg_replace("/\#[A-Z_0-9]+\#/Us",'',str_replace('#MSG#',$body['plain'],$sub_tpl['bodyplain']));
			}
			if (!empty($body['html']) && $dbobj->coloumn_exists(__file__,__line__,'#PREFIX#person','Message')) {
				if (!empty($input['email']))	$daten['Email']	  = $dbobj->escape($input['email']);
				$daten['Message'] = $body['html'];
				make_replacements($daten['Message']);
				if ($old_msg = $dbobj->tostring(__file__,__line__,"SELECT Message FROM #PREFIX#person WHERE email =  '".$daten['Email']."';")) {
					$daten['Message'] .= '<hr />'.html_entity_decode($old_msg);
				}
				if (!$dbobj->exists(__file__,__line__,"SELECT ID FROM #PREFIX#person WHERE email = '".$daten['Email']."';")) {
					$daten['status'] = 0;
					if (!empty($input['name']))		$daten['Name']	  = $input['name'];
					if (!empty($input['strasse']))	$daten['Strasse'] = $input['strasse'];
					if (!empty($input['ort']))		$daten['Ort']	  = $input['ort'];
					if (!empty($input['land']) && $dbobj->coloumn_exists(__file__,__line__,'#PREFIX#person','Land'))	$daten['Land']	  = $input['land'];
				}
#				$dbobj->array2db(__file__,__line__,$daten,'#PREFIX#person','INSERT INTO',"WHERE email = '".$daten['Email']."'");	# Daten speichern
			}
			if (empty($from) || !$from) {
				if (!empty($input['name']))		$from[0]['Name']  = &$input['name'];
				if (!empty($input['email']))	$from[0]['Email'] = &$input['email'];
			}
			if (mail_send(array('subject'=>$subject,'body'=>$body,'from'=>$from,'to'=>$to,'bcc'=>$bcc))) {
				if (!empty($_REQUEST['copy'])) {
					if (!empty($sub_tpl['copyprefix'])) $subject = $sub_tpl['copyprefix'].' '.$subject;
					else								$subject = 'COPY: '.$subject;
					mail_send(array('subject'=>$subject,'body'=>$body,'to'=>$from,'from'=>$to));
				}
				if (!empty($sub_tpl['automailer']) || !empty($vorgaben['automailer'])) {
					if ($autoresponse = get_vorlage(array('PAGE_ID'=>'automailer','limit'=>1,'order_by'=>'PUB_ASC','as_array'=>true))) {
						$autoresponse = current($autoresponse);
						$body = mailfooter($autoresponse['text_fck']);
						mail_send(array('subject'=>$autoresponse['betreff'],'body'=>$body,'to'=>$from,'from'=>$to));
				}	}
				$tpl = str_replace('#DISABLED#','disabled="disabled"',$tpl);
				if (!empty($sub_tpl['response']))	$response = $sub_tpl['response'];
				else								$response = geterror($error_nr);
				unset($input,$_REQUEST[$form]);
				if (!empty($to[0]['Name']))	$response = str_replace('#USER#',$to[0]['Name'],$response);
				$error['erfolg'] = $response;
			} else $error['nichtgefunden'] = geterror(201);
	}	}
	if (!empty($to)) $tpl = $tplobj->array2tpl($tpl,$to[0],'$',true);
	form_prefill($tpl,$form);
	return $tpl;
}
function postkarte() {
	global $error,$tplobj,$dbobj,$sub_tpl;
	if (!empty($_REQUEST['subpage']) && is_array($_REQUEST['subpage'])) {
		switch (key($_REQUEST['subpage'])) {
			case 2:		$tpl = &$sub_tpl['adresse'];			break;
			case 3:
				if (!daten_error('postkarte')) {
					$tpl = &$sub_tpl['gesendet'];
					$from[0]['Name'] 	= &$_REQUEST['postkarte']['absender'];
					$from[0]['Email']	= &$_REQUEST['postkarte']['email_von'];
					$to[0]['Name']		= &$_REQUEST['postkarte']['empfaenger'];
					$to[0]['Email']		= &$_REQUEST['postkarte']['email_an'];
					$data['from_name']	= &$from[0]['Name'];
					$data['from_email']	= &$from[0]['Email'];
					$data['to_name']	= &$to[0]['Name'];
					$data['betreff']	= &$_REQUEST['postkarte']['betreff'];
					$data['nachricht']	= &$_REQUEST['postkarte']['nachricht'];
					$body['html']		= preg_replace("/\#[A-Z_0-9]+\#/Us",'',$tplobj->array2tpl($sub_tpl['bodyhtml'],$data,'#'));
					$body['plain']		= preg_replace("/\#[A-Z_0-9]+\#/Us",'',$tplobj->array2tpl($sub_tpl['bodyplain'],$data,'#'));
					mail_send(array('subject'=>$data['betreff'],'body'=>$body,'from'=>$from,'to'=>$to));
				} else $tpl = &$sub_tpl['adresse'];
			break;
	}	}
	else	$tpl = &$sub_tpl['start'];
	if (empty($_REQUEST['postkarte']['betreff'])) $_REQUEST['postkarte']['betreff'] = $sub_tpl['betreffvorschlag'];
	if (!empty($_REQUEST['postkarte']))	$tpl = $tplobj->array2tpl($tpl,$_REQUEST['postkarte'],'#',$entities=true);
	return $tpl;
}
function quick_contact() {
	global $vorgaben;
	if (!empty($vorgaben['kontakt_seite'])) {
		get_vorlage(array('PAGE_ID'=>$vorgaben['kontakt_seite']));
		contact();
}	}
function quick_contact_js($data) {
	global $sub_tpl;
	$sub_tpl['Content-type'] = 'text/javascript';
	$js = '$("input[type=submit]").click(function() {
  var dataString = 	 "name="+$("#name")+"&email="+$("#email").val()+"&telefon="+$("#telefon").val()
					+"&strasse="+$("#strasse").val()+"&ort="+$("#ort").val()
					+"&betreff="+$("#betreff").val()
					+"&mitteilung="+$("#mitteilung").val();
  //alert (dataString);return false;
  $.ajax({
	type: "POST",
	url: \'/quick_contact.php\',
	data: dataString,
	success: function(html) {
	  $("form").parent().html(html);
	}
  });
  return false;
});';
	return final_output($js,true);
}
?>