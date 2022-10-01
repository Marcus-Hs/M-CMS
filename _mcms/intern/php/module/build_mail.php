<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

my_include('intern/php/phpmailer/src/','Exception.php');
my_include('intern/php/phpmailer/src/','SMTP.php');
my_include('intern/php/phpmailer/src/','PHPMailer.php');
function mailfooter() {
	global $vorgaben;
	if (!empty($vorgaben['abbinder_seite'])) {
		$signature = get_page(array('PAGE_ID'=>'abbinder_seite','feld'=>'Text','visibility'=>'1,0','errors'=>false));
		get_vorlage(array('PAGE_ID'=>$vorgaben['abbinder_seite'],'set_sub_tpl'=>true,'use_css'=>false,'use_js'=>false, 'errors'=>false));
		return $signature;
	}
	return '';
}
function mail_send($data) {
	global $dbobj,$tplobj,$sub_tpl;
	$default = array('subject'=>'','body'=>'','from'=>'','to'=>'','cc'=>'','bcc'=>'','attachments'=>'');
	extract(merge_defaults_user($default,$data),EXTR_SKIP);
	if (phpmail($subject,$body,$to,$from,$attachments,$cc,$bcc))	return true;
	else															return false;
}
function phpmail($subject,$body,$to='',$from='',$attachments='',$cc='',$bcc='') {
	global $dbobj,$tplobj,$error,$sub_tpl,$vorgaben;
	$mail = new PHPMailer(true);
	$imprint =  $dbobj->exists(__file__,__line__,'SELECT Name,Email FROM #PREFIX#person WHERE impressum = 1;');
	if (is_numeric_array($to)) {
		$to		= $dbobj->exists(__file__,__line__,'SELECT Name,Email FROM #PREFIX#person WHERE ID IN ('.r_implode($to).');');
	}
	if (empty($to) || $to == false) {
		if (!empty($sub_tpl['mailto'])) {
			$to[0]['Email']	 = $sub_tpl['mailto'];
			if (!empty($sub_tpl['nameto']))			$to[0]['Name']   = make_replacements($sub_tpl['nameto'],true);
		}
		if (empty($to[0]['Email'])) 	  			$to		= $dbobj->exists(__file__,__line__,'SELECT Name,Email FROM #PREFIX#person WHERE kontakt = 1;');
		if (empty($to[0]['Email'])) 	  			$to		= $dbobj->exists(__file__,__line__,'SELECT Name,Email FROM #PREFIX#person WHERE impressum = 1;');
	}
	if (is_numeric($from)) {
		$from	= $dbobj->exists(__file__,__line__,'SELECT Name,Email FROM #PREFIX#person WHERE ID = '.$from.';');
	} elseif (empty($from) || $from == false) {
		if (!empty($sub_tpl['mailfrom'])) {
			$from[0]['Email']= $sub_tpl['mailfrom'];
			if (!empty($sub_tpl['namefrom']))		$from[0]['Name'] = make_replacements($sub_tpl['namefrom'],true);
		}
		else 	$from	= $imprint;
	}
	if ($bcc && !empty($bcc) && !is_array($bcc))	$bcc 	= $dbobj->singlequery(__file__,__line__,'SELECT Name,Email FROM #PREFIX#person WHERE kontakt = 1;');
	if (!empty($from) && !empty($from[0]['Email']))	$mail->From 	= &$from[0]['Email'];
	else											$mail->From 	= "noreply@".domain();
	if (!empty($from) && !empty($from[0]['Name']))	$mail->FromName = &$from[0]['Name'];
	elseif(!empty($sub_tpl['name']))				$mail->FromName = $sub_tpl['name'];
	else											$mail->FromName = domain();
 #   $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
 #   $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
 #   $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	$mail->Host		= "mail.".domain();
	$mail->Mailer   = "mail";#"smtp";
	$mail->SMTPAuth = true;
	$mail->Username = "";
	$mail->Password = "";
	$mail->Encoding = "quoted-printable";
	if (!empty($sub_tpl['codepage'])) {
		$mail->CharSet  = $sub_tpl['codepage'];
		if ($sub_tpl['codepage'] == 'utf-8') {
			$mail->Encoding  = 'base64';
			$mail->CharSet="UTF-8";
	}   }
	make_replacements($subject,true,true,3);
	$mail->Subject  = $subject;
	$mail->IsHTML(false);
	$mail->Sender=$imprint[0]['Email'];
	$mail->SetFrom($mail->From, $mail->FromName, FALSE);
	if (!empty($sub_tpl['attachements']))				{$attachments = $sub_tpl['attachements'];}
	if (!empty($attachments) && is_array($attachments)) {
		foreach ($attachments as $attachment) {
			$mail->AddAttachment($attachment);
	}	}
	if (!empty($body) && !is_array($body)) {
		$mail->IsHTML(true);
		make_clickable($body);
		mail_prepare($body);
		$mail->Body = nl2br($body);
		$mail->AltBody = strip_tags($body);
	} else {
		if (!empty($body['html'])) {
			$mail->IsHTML(true);
			filter_images($body['html'],true);
			if (!empty($sub_tpl['mailimg'])) {
				foreach ($sub_tpl['mailimg'] as $key => $bild) {
					if (is_file($bild)) {
						$mailimg = loc($bild);
						$mail->AddEmbeddedImage($mailimg['filename'],'myimg'.$key,$mailimg['name'],$mailimg['encode'],$mailimg['mimetype']);
					} else $body['html'] = str_remove($body['html'],'#BILD_'.$key.'#');
			}	}
			mail_prepare($body['html']);
			$mail->Body = $body['html'];
		}
		if (!empty($body['plain'])) {	// alternative ohne HTML
			mail_prepare($body['plain']);
			if (empty($body['html'])) {
				$mail->Body = nl2br($body['plain']);
				make_clickable($body['plain']);
			}
			$mail->AltBody = $body['plain'];
		} elseif (!empty($mail->Body)) {
			$mail->AltBody = strip_tags(str_replace('</p>',"\n",$mail->Body));
	}	}
	$sub_tpl['mailcount'] = 0;
	foreach ($to as $to_email) {
		if (empty($to_email['Name']))   	$to_email['Name'] = $to_email['Email'];
		$sendmails['to'][$to_email['Name']] = $to_email['Email'];
		$sub_tpl['mailcount']++;
	}
	if (!empty($cc)) {
		foreach ($cc as $cc_email) {
			if (empty($cc_email['Name']))	$cc_email['Name'] = $cc_email['Email'];
			if (!in_array($cc_email['Email'],$sendmails['to'])) {
				$mail->AddCC($cc_email['Email'],$cc_email['Name']);
				$sendmails['cc'][$cc_email['Name']] = $cc_email['Email'];
				$sub_tpl['mailcount']++;
	}	}	}
	if (!empty($bcc)) {
		foreach ($bcc as $bcc_email) {
			if (empty($bcc_email['Name']))	$bcc_email['Name'] = $bcc_email['Email'];
			if (!in_array($bcc_email['Email'],$sendmails['to'])) {
				$mail->AddBCC($bcc_email['Email'],$bcc_email['Name']);
				$sendmails['bcc'][$bcc_email['Name']] = $bcc_email['Email'];
			#	$sub_tpl['mailcount']++;
	}	}	}
	foreach ($to as $email) {
		if (empty($email['Name'])) $email['Name'] = '';
		$mail->AddAddress($email['Email'], $email['Name']);
		if (empty($body_tmp)) 		$body_tmp 	 = $mail->Body;
		if (empty($altbody_tmp)) 	$altbody_tmp = $mail->AltBody;
		$body_tmp		= str_replace('#NAMETO#',$email['Name'],$body_tmp);
		$altbody_tmp	= str_replace('#NAMETO#',$email['Name'],$altbody_tmp);
		$mail->Body		= str_replace('#NAMEFROM#',$mail->FromName,$body_tmp);
		$mail->AltBody	= str_replace('#NAMEFROM#',$mail->FromName,$altbody_tmp);
		clean_up_mail($mail->Body);
		clean_up_mail($mail->AltBody);
		if (empty($_REQUEST['newsletter']['preview']) && !$vorgaben['localhost']) {
			$mail->Send();
		}
		$mail->ClearAllRecipients();
	}
	$mail->ClearAttachments();
	if ((empty($_REQUEST['newsletter']['send']) && !empty($_REQUEST['newsletter']['preview'])) || $vorgaben['localhost']) {
		if(!empty($mail->Body)) {
			if (!empty($sub_tpl['mailimg'])) {
				foreach ($sub_tpl['mailimg'] as $key => $bild) {
					$mail->Body = str_replace("cid:myimg".$key,$vorgaben['sub_dir'].str_replace($vorgaben['base_dir'],'',$bild),$mail->Body);
			}	}
			$add = '<hr /><hr />';
			$add .= 'FROM: '.$mail->FromName.' &lt;'.$mail->From.'&gt;<br />';
			foreach ($sendmails as $ks => $es) {
				$add .= strtoupper($ks).': '.key_implode($es,' &lt;','&gt;',', ').'<br />';
			}
			if (!empty($attachments) && is_array($attachments)) {
				foreach ($attachments as &$file) {
					$file = str_replace('#FILE#',str_replace($vorgaben['base_dir'],'/',$file),'<a href="#FILE#">#FILE#</a>');
				}
				$add .= '<hr />%%ANHANG%%: '.implode_ws($attachments,'%%UND%%');
			}
			unset($vorgaben['compress']);
			$vorgaben['cache']=false;
			if(!empty($mail->Body)) 		popup_msg(final_output(addslashes($mail->Body).$add,false),$mail->Subject);
			elseif(!empty($mail->AltBody)) 	popup_msg(final_output('<pre>'.$mail->AltBody.'</pre>'.$add,false),$mail->Subject);
		}
		return true;
	} elseif (!empty($mail->ErrorInfo)) {
		if (empty($error['invalid_address'])) {
			$add = 'FROM: '.$mail->FromName.': '.$mail->From.'<br />';
			foreach ($sendmails as $ks => $es) {
				$add .= strtoupper($ks).': '.r_implode($es).'<br />';
			}
			trigger_error($mail->ErrorInfo.'<p>'.$add.'</p>', E_USER_ERROR);
		}
		return false;
	} else return true;
}
function mail_prepare(&$string) {
	make_replacements($string);
	$string = preg_replace_callback("/#LINKTO\:([a-zA-Z_0-9:\-]+?)#/Umsi","abslinktonosid",$string);
	return $string;
}
function attachments($files='') {
	if (!empty($_FILES['attachment']['name'])) {
		foreach ($_FILES['attachment']['name'] as $key => $filename) {
			if (move_uploaded_file($_FILES['attachment']['tmp_name'][$key],'downloads/'.$filename)) {
				$attachments[$key] = loc($filename);
		}	}
	} elseif (!empty($files)) {
		foreach ($files as $filename) {
			if (is_file('downloads/'.$filename)) {
				$attachments[$key] = loc($filename);
	}	}	}
	return $attachments ;
}
?>