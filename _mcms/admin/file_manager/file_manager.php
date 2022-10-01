<?php
include "rbfminc/config.php";
include "rbfminc/session.php";

if(!empty($user_login) && $user_login == 'ok'){
	global $sub_tpl,$vorgaben;
	if (!empty($_REQUEST['f']) && $_REQUEST['f']=='i')		$_SESSION['initial_folder'] = "/images/weitere"; //initial folder
	elseif (!empty($_REQUEST['f']) && $_REQUEST['f']=='d')	$_SESSION['initial_folder'] = "/downloads"; //initial folder
	if (!empty($_SESSION['initial_folder']))				$initial_folder = $_SESSION['initial_folder'];
	else													$initial_folder = "/downloads"; //initial folder
	$IMConfig['maxWidth'][1]  = $vorgaben['vorschaux'];
	$IMConfig['maxHeight'][1] = $vorgaben['vorschauy'];
	$IMConfig['maxWidth'][2]  = $vorgaben['bildx'];
	$IMConfig['maxHeight'][2] = $vorgaben['bildy'];
//	set_time_limit(1800); //30 min
//	header("Content-type: text/html;charset=utf-8");
	include "rbfminc/functions.php";
	clearstatcache ();
	if(!empty($_GET['p'])) $_GET['p'] = urldecode($_GET['p']);

	if(!empty($_GET['url_field']) && $_GET['url_field']){
		setcookie('url_field', $_GET['url_field']);
		$url_field = $_GET['url_field'];
	} elseif (!empty($_COOKIE['url_field'])) {
		$url_field = $_COOKIE['url_field'];
	}

	if(!empty($_GET['p'])){
		$_GET['p'] = trim($_GET['p'],'/');
		$current_folder = rtrim($vorgaben['base_dir'],'/').$initial_folder.'/'.$_GET['p'];
		$my_folder = '/'.$_GET['p'].'/';
	} else {
		$current_folder = rtrim($vorgaben['base_dir'],'/').$initial_folder;
		$my_folder = '/';
	}

	setcookie('current_folder', $my_folder);

	if(substr($current_folder, 0, strlen($vorgaben['base_dir'])) == $vorgaben['base_dir']){
		$url_path = url_protocol(domain('*')).'/'.substr($current_folder, strlen($vorgaben['base_dir']));
	}

	$alert_info = '';
	if(!empty($_POST['save_file']) && $_POST['save_file'] == 'save_file' && !empty($_GET['f'])){
		if($handle = fopen($current_folder.'/'.$_GET['f'] , 'w')){
			if (fwrite($handle, stripslashes($_POST['file_content'])) === FALSE) {
				$alert_info .=  gt('%%DATEI_NICHT_GESPEICHERT%%')." ({$current_folder}{$_GET['f']})";
			} else {
				$alert_info .= gt('%%DATEI_GESPEICHERT%%')." ({$current_folder}{$_GET['f']})";
				$redirect = "file_manager.php?p=".urlencode($my_folder);
			}
		} else {
			$alert_info .= gt('%%DATEI_UNGUELTIG%%');#"Ung&uuml;ltige Datei!!!";
		}
	}

	if(!empty($_POST['upload_file'])){
		if($_FILES['file']['error'] == 8){
			$alert_info .= gt('%%DATEIENDUNG_NICHT_ERLAUBT%%');#"Dateierweiterung ist nicht erlaubt!!!";
		}
		if($_FILES['file']['error'] == 7){
			$alert_info .= gt('%%SCHREIBFEHLER%%');#"Schreibfehler!!!";
		}
		if($_FILES['file']['error'] == 6){
			$alert_info .= gt('%%TEMP_ORDNER FEHLT%%');#"Tempor&auml;rer Ordener nicht vorhanden!!!";
		}
		if($_FILES['file']['error'] == 4){
			$alert_info .= gt('%%HOCHLADEN_FEHLGESCHLAGEN%%');#"Es wurde kein Bild hochgeladen!!!";
		}
		if($_FILES['file']['error'] == 3){
			$alert_info .= gt('%%HOCHLADEN_FEHLGESCHLAGEN%%');#"Die Datei wurde unvollständig hochgeladen!!!";
		}
		if($_FILES['file']['error'] == 2){
			$alert_info .= gt('%%DATEI_ZU_GROSS%%');#"Die Datei ist zu groß!!!";
		}
		if($_FILES['file']['error'] == 1){
			$alert_info .= gt('%%DATEI_ZU_GROSS%%');#"Die Datei ist zu groß!!!";
		}
		if(empty($alert_info)){
			if(file_exists($current_folder.'/'.$_FILES['file']['name']) and !$_POST['replace_file']){
				$alert_info .= gt('%%DATEI_EXISTIERT_BEREITS%%');#"Eine Datei mit diesem Namen existiert bereits\\nBitte bei \"Existierende Datei\" einen Haken setzen!";
				$redirect = "file_manager.php".do_url("p=".urlencode($my_folder));
			} else {
				$fn = make_kn($_FILES['file']['name']);
				if(!move_uploaded_file($_FILES["file"]["tmp_name"], $current_folder.'/'.$fn)){
					$alert_info .= gt('%%HOCHLADEN_FEHLGESCHLAGEN%%');#"Die Datei konnt nicht hochgeladen werden!!!";
				} else {
					if ($_REQUEST['uploadSize'] && !empty($IMConfig['maxHeight'][$_REQUEST['uploadSize']])) {
						$ext = strtolower(pathinfo(str_replace('jpeg','jpg',strtolower($fn)), PATHINFO_EXTENSION));
						if (in_array($ext,array('jpg','gif','png')))	imageresize($current_folder.'/'.$fn,$current_folder.'/'.$fn,$IMConfig['maxHeight'][$_REQUEST['uploadSize']],$IMConfig['maxWidth'][$_REQUEST['uploadSize']]);
					}
					$alert_info .= gt('%%HOCHGELADEN%%').': "'.$fn.'"';#'Die Datei "'.$fn.'" wurde hochgeladen!';
					chmod($current_folder.'/'.$fn, 0644);
				#	$redirect = "file_manager.php".do_url("p=".urlencode($my_folder));
	}	}	}	}
	if(!empty($_GET['do']) && $_GET['do'] == 'delete' and $_GET['file'] and $_GET['type'] == 'file'){
		if(file_exists($current_folder.'/'.$_GET['file'])){
			if(!unlink($current_folder.'/'.$_GET['file'])){
				$alert_info = gt('%%HOCHLADEN_FEHLGESCHLAGEN%% (%%BERECHTIGUNGEN%%)');#"Diese Datei kann nicht gel&ouml;scht werden\\nFehlende Berechtigungen.";
			} else {
				$alert_info = gt('%%DATEI_GELOESCHT%%');
				$redirect = "file_manager.php".do_url("p=".urlencode($my_folder));
			}
		} else {
			$alert_info =  gt('%%LOESCHEN_FEHLGESCHLAGEN%%');#Diese Datei kann nicht gel&ouml;scht werden\\nUng&uuml;ltige Datei";
	}	}
	if(!empty($_GET['do']) && $_GET['do'] == 'delete' and $_GET['file'] and $_GET['type'] == 'directory'){
		if(file_exists($current_folder.'/'.$_GET['file'])){
			if(!RecursiveFolderDelete($current_folder.'/'.$_GET['file'])){
				$alert_info = gt('%%ORDNER_LOESCHEN_FEHLGESCHLAGEN%% (%%BERECHTIGUNGEN%%)');#"Dieser Ordner kann nicht gel&ouml;scht werden\\nFehlende Berechtigungen.";
			} else {
				$alert_info = gt('%%ORDNER_GELOESCHT%%');#"Der Ordner wurde entfernt";
				$redirect = "file_manager.php".do_url("p=".urlencode($my_folder));
			}
		} else {
			$alert_info = gt('%%ORDNER_LOESCHEN_FEHLGESCHLAGEN%%');#"Dieser Ordner kann nicht gel&ouml;scht werden\nUng&uuml;ltiger Ordner";
	}	}
	if(!empty($_POST['create_folder'])){
		if(mkdir($current_folder.'/'.$_POST['folder_name'])){
			$alert_info = gt('%%ORDNER_ANGELEGT%%');#"Order wurde angelegt!";
		}else{
			$alert_info = gt('%%FEHLER%%');#"Ein Fehler ist aufgetreten!";
	}	}
	preg_match_all("/\//", $current_folder, $m);
	if(count($m[0]) > 1){
		$up_one_level = " ondblclick=\"document.location='".do_url("p=".urlencode(substr($my_folder, 0, strrpos(substr($my_folder, 0, -1), "/"))."/"))."'\"";
	}
	if ($handle = opendir($current_folder)) {
		while (false !== ($folder_content = readdir($handle))) {
			if (is_dir($current_folder.'/'.$folder_content) and $folder_content!='.' and $folder_content!='..') {
				$folders[] = $folder_content;
			} elseif(!is_dir($current_folder.'/'.$folder_content) and $folder_content!='.' and $folder_content!='..') {
				$files[] = $folder_content;
		}	}
		closedir($handle);
	} else {
		$error = "<h1 style='color:red' align='center'>Invalid directory</h1>";
	}
	$container = "
<table border=\"0\" cellspacing=\"1\" cellpadding=\"1\" class=\"list\" width=\"100%\">
	<tr>
		<th style='padding:0;width:18px'>&nbsp;</th>
		<th>Name</th>
		<!--<th>&nbsp;</th>-->
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>Ext.</th>
		<th>".gt('%%SIZE%%')."</th>
		<th>".gt('%%DATUM%%')."</th>
		<!--<th>Attribute</th>-->
	</tr>
	<tr>
		<td style='padding:0;width:18px' title=\"UP one level\"><img width='16' height='16' src='rbfmimg/folder.png' alt='F'{$up_one_level} /></td>
		<td colspan=\"11\"><b title=\"UP one level\"{$up_one_level}>[..]</b></td>
	</tr>
";
	$id = 1;
	if(!empty($folders) && is_array($folders)){
		array_multisort($folders, SORT_ASC, SORT_REGULAR);
		foreach($folders as $v){
			if($v){
				$vf = $v.'/';
				$last_updated_time = date("Y.m.d H:i:s", filemtime($current_folder.'/'.$v));
				$fileperms = GetFilePerms($current_folder.'/'.$v);
				if($url_path){
					$browser = "<a href='".$url_path.$v."' target='_blank'><img src='rbfmimg/ico_open_as_web.png' border='0' width='16' height='16' alt='".gt('%%OEFFNEN%%')."' title='".gt('%%OEFFNEN%%')."' /></a>";
					if(!empty($url_field)){
						$use_url = "<img src='rbfmimg/ico_use_file.png' border='0' width='16' height='16' alt='U' title='Use URL (".$url_path.$v.")' onclick=\"window.opener.document.getElementById('{$url_field}').value='".$url_path.$v."'; window.close()\" style='cursor: pointer' />";
					} else {
						$use_url = "<img src='rbfmimg/ico_use_file_inactive.png' border='0' width='16' height='16' alt='U' title='Use URL (Inactive!!!)' />";
					}
				} else {
					$browser = "&nbsp;";
					$use_url = "<img src='rbfmimg/ico_use_file_inactive.png' border='0' width='16' height='16' alt='U' title='Use URL (Inactive!!!)' />";
				}
				$container .= "
			<tr>
				<td style='padding:0;width:18px'>
					<img width='16' height='16' src='rbfmimg/folder.png' alt='Folder'
						ondblclick=\"document.location='".do_url("p=".urlencode($my_folder.$vf))."'\" />
				</td>
				<td>
					<div style='padding-top:2px;' id='f{$id}'
						ondblclick=\"document.location='".do_url("p=".urlencode($my_folder.$vf))."'\">
						{$v}
					</div>

					<form class='rename_field' id='r{$id}' name=\"form{$id}\" method=\"post\" action=\"rbfminc/rename.php".do_url()."\" target=\"results\" onsubmit=\"this.n.blur();return false\">
						<input class='input_name rename_input' name=\"n\" type='text' value='{$v}' id='rf{$id}'
							onblur=\"
								document.form{$id}.submit();
								document.getElementById('f{$id}').style.display = 'block';
								document.getElementById('r{$id}').style.display = 'none';
								document.getElementById('f{$id}').innerHTML = this.value;
								document.form{$id}.o.value = this.value;
							\" />
						<input name=\"cf\" type=\"hidden\" value=\"{$current_folder}\" />
						<input name=\"o\" type=\"hidden\" value=\"{$v}\" />
						<input name=\"t\" type=\"hidden\" value=\"d\" />
						<input name=\"submitS\" type=\"submit\" value=\"submitS\" style='display: none;' />
					</form>
				</td>
				<!--<td>{$use_url}</td>-->
				<td><!--{$browser}--></td>
				<td>&nbsp;</td>
				<td>
					<img width='16' height='16' src='rbfmimg/ico_rename.png' alt='".gt('%%UMBENENNEN%%')."' title='".gt('%%UMBENENNEN%%')."'
						onclick=\"
							document.getElementById('r{$id}').style.display = 'block';
							document.getElementById('f{$id}').style.display = 'none';
							document.getElementById('rf{$id}').focus();
							document.getElementById('rf{$id}').select()
						\" />
				</td>
				<td>&nbsp;</td>
				<td>
					<img width='16' height='16' src='rbfmimg/ico_delete.png' alt='D' title='Delete'
						onclick=\"
							if(confirm('".gt('%%LOESCHEN_ODER_ABBRECHEN%%')."')){
								document.location = 'file_manager.php".do_url("p=".urlencode($my_folder)."&do=delete&file=".urlencode($v)."&type=directory")."'}
						\" />
				</td>
				<td class='srow'>&nbsp;</td>
				<td><b>&lt;DIR&gt;</b></td>
				<td class='srow'>{$last_updated_time}</td>
			<!--	<td class='fileperms'>{$fileperms}</td>-->
			</tr>
			";
				$id++;
			}
		}
	}
	if(!empty($files) && is_array($files)){
		array_multisort($files, SORT_ASC, SORT_REGULAR);
		foreach($files as $v) {
			if ($v) {
				$extension = substr(strrchr($v, "."), 1);
				$file_image = "rbfmimg/ico_file.png";
				if ($extension == 'php' or $extension == 'php3'){$file_image = "rbfmimg/ico_php.png";}
				if ($extension == 'htm' or $extension == 'HTM' or $extension == 'html' or $extension == 'HTML')	{
					$file_image = "rbfmimg/ico_html.png";
				}
				$is_img = false;
				if ($extension == 'jpg' or $extension == 'JPG' or $extension == 'jpeg' or $extension == 'JPEG' or $extension == 'gif' or $extension == 'GIF' or $extension == 'png' or $extension == 'PNG') {
					$file_image = $vorgaben['sub_dir'].$initial_folder.$my_folder.$v;
					$is_img = true;
				//	$file_image = "rbfmimg/ico_picture.png";
				}
				$last_updated_time = date("Y.m.d H:i:s", filemtime($current_folder.'/'.$v));
				$file_size = roundsize(filesize($current_folder.'/'.$v));
				if ($extension == 'txt' or $extension == 'php' or $extension == 'php3' or $extension == 'htm' or $extension == 'HTM' or $extension == 'html' or $extension == 'HTML' or $extension == 'css' or $extension == 'CSS') {
					$edit_file_content = "<a href='file_manager.php".do_url("p=".urlencode($my_folder)."&f=".urlencode($v)."&do=edit#file_edit")."'><img width='16' height='16' src='rbfmimg/ico_script_edit.png' alt='".gt('%%ANSEHEN_BEARBEITEN%%')."' title='".gt('%%ANSEHEN_BEARBEITEN%%')."' border='0' /></a>";
				} else {
					$edit_file_content = "&nbsp;";
				}

				$fileperms = GetFilePerms($current_folder.'/'.$v);

				if ($url_path) {
				#	$browser = "<a href='".rtrim($initial_folder.trim($my_folder,'/'),'/').'/'.$v."' target='_blank'><img src='rbfmimg/ico_open_as_web.png' border='0' width='16' height='16' alt='W' title='Open as web page' /></a>";
					$browser = "<a href='#' onclick=\"returnverweis('".rtrim($initial_folder.'/'.trim($my_folder,'/'),'/').'/'."','".$v."');return false;\" ><img src=\"rbfmimg/ico_open_as_web.png\" border=\"0\" width=\"16\" height=\"16\" alt=\"W\" title=\"".gt('%%LINK_EINFUEGEN%%')."\" /></a>";
					if (!empty($url_field)){
						$use_url = "<img src='rbfmimg/ico_use_file.png' border='0' width='16' height='16' alt='U' title='Use URL ({$url_path}{$v})' onclick=\"window.opener.document.getElementById('{$url_field}').value='{$url_path}{$v}'; window.close()\" style='cursor: pointer' />";
					} else{
						$use_url = "<img src='rbfmimg/ico_use_file_inactive.png' border='0' width='16' height='16' alt='U' title='Use URL (Inactive!!!)' />";
					}
				 } else {
					$browser = "&nbsp;";
					$use_url = "<img src='rbfmimg/ico_use_file_inactive.png' border='0' width='16' height='16' alt='U' title='Use URL (Inactive!!!)' />";
				}

				if ($is_img) {
					list($bild['width'],$bild['height'],$bild['type'],$bild['attr']) = getimagesize($current_folder.'/'.$v,$info);
					$container .= "\n<tr>
					<td style='padding:0 5p 0 0;'>
						<img style=\"max-width:100px;max-height:100px;\" src='{$file_image}' alt='Datei' ondblclick=\"returnverweis('".rtrim($initial_folder.'/'.trim($my_folder,'/'),'/').'/'."','".$v."');return false;\" />
					</td><td style='padding:0;width:300px'>
						<div style='padding-top:2px;' id='f{$id}' ondblclick=\"returnverweis('".rtrim($initial_folder.'/'.trim($my_folder,'/'),'/').'/'."','".$v."');return false;\">
							{$v}<br />(".$bild['width']." x ".$bild['height']." px)</div>";
				} else {
					$container .= "\n<tr>
					<td style='padding:0;'>
						<img style=\"width:16px;height:16px;\" src='{$file_image}' alt='Datei' ondblclick=\"returnverweis('".rtrim($initial_folder.'/'.trim($my_folder,'/'),'/').'/'."','".$v."');return false;\" />
					</td><td style='padding:0;width:300px'>
						<div style='padding-top:2px;' id='f{$id}' ondblclick=\"returnverweis('".rtrim($initial_folder.'/'.trim($my_folder,'/'),'/').'/'."','".$v."');return false;\">
							{$v}</div>";
				}
				$container .= "
					<form class='rename_field' id='r{$id}' name=\"form{$id}\" method=\"post\" action=\"rbfminc/rename.php".do_url()."\" target=\"results\" onsubmit=\"this.n.blur(); return false\">
						<input name=\"cf\" type=\"hidden\" value=\"{$current_folder}\" />
						<input name=\"o\" type=\"hidden\" value=\"{$v}\" />
						<input name=\"t\" type=\"hidden\" value=\"f\" />
						<input class='input_name' name=\"n\" type='text' value='{$v}' id='rf{$id}'
							onblur=\"
								document.form{$id}.submit();
								document.getElementById('f{$id}').style.display = 'block';
								document.getElementById('r{$id}').style.display = 'none';
								document.getElementById('f{$id}').innerHTML = this.value;
								document.form{$id}.o.value = this.value;
							\" />
						<input name=\"submitS\" type=\"submit\" value=\"submitS\" style='display: none;' onsubmit=\"alert(document.getElementById('f{$id}').innerHTML);this.n.blur(); return false\" />
					</form>
				</td>
				<!--<td>{$use_url}</td>-->
				<td>{$browser}</td>
				<td>
					<a href='".$vorgaben['sub_dir'].$initial_folder.$my_folder.$v."' target=\"_blank\"><img width='16' height='16'
						src='rbfmimg/ico_download.png' alt='Download' title='Download' border='0' /></a>
				</td>
				<td>
					<img width='16' height='16' src='rbfmimg/ico_rename.png' alt='".gt('%%UMBENENNEN%%')."' title='".gt('%%UMBENENNEN%%')."'
						onclick=\"
							document.getElementById('f{$id}').style.display = 'none';
							document.getElementById('r{$id}').style.display = 'block';
							document.getElementById('rf{$id}').focus();
							document.getElementById('rf{$id}').select();
						\" />
				</td>
				<td>{$edit_file_content}</td>
				<td>
					<img width='16' height='16'
						src='rbfmimg/ico_delete.png' alt='".gt('%%LOESCHEN%%')."' title='".gt('%%LOESCHEN%%')."'
						onclick=\"
							if(confirm('".gt('%%LOESCHEN_ODER_ABBRECHEN%%')."')) {
								document.location = 'file_manager.php".do_url("p=".urlencode($my_folder)."&do=delete&file=".urlencode($v)."&type=file")."'
							}
						\" />
				</td>
				<td class='srow'>{$extension}</td>
				<td>{$file_size}</td>
				<td class='srow'>{$last_updated_time}</td>
			<!--	<td class='fileperms'>{$fileperms}</td>-->
			</tr>
			";
				$id++;
			}
		}
	}

	$container .= "</table>";

	$container = preg_replace("/\s+/m", " ", $container);

?>
<!DOCTYPE html>
<html lang="<?php echo $sub_tpl['lang'];?>">
<head>
	<meta name="viewport" content="width=device-width, minimum-scale=0.75, initial-scale=1">
	<meta charset="<?php echo $sub_tpl['codepage'];?>" />
<title><?php echo gt('%%DATEIMANAGER%%');?> (RogioBiz PHP File Manager V1.2)</title>
<link href="rbfminc/file_editor_style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="file_editor">
	<div class="header">
		<div class="logout"><!--<a href='file_manager.php?logout=logout'>--><a href="#" onclick="window.close();"><?php echo gt('%%FENSTER_SCHLIESSEN%%');?> <img src="rbfmimg/ico_delete.png" width="16" height="16" align="middle" /></a></div>
	</div>
	<form id="path" name="path" method="get" action="" class="path">
		<input type="text" name="p" id="location" value="<?php echo $my_folder; ?>" />
		<img src="rbfmimg/go.png" name="go" width="35" height="18" id="go" alt="go" title="go" />
	</form>
<!--	<div class="url_path">URL path: <a href='<?php echo $url_path; ?>' target="_blank"><?php echo $url_path; ?></a></div>-->
	<div class="container"> <?php echo $container; ?> <?php if (!empty($error)) echo $error; ?> </div>
	<form action="" method="post" enctype="multipart/form-data" name="form_upload" id="form_upload" class="form_upload">
		<?php echo gt('%%NEUE_DATEI%%');?>
		<input type="file" name="file" id="file" />
		&nbsp;  &nbsp;
		<input name="replace_file" type="checkbox" value="1" /><?php echo gt('%%UEBERSCHREIBEN%%');?>
		<input type="submit" name="upload" id="upload" value="<?php echo gt('%%HOCHLADEN%%');?>" />
		<input name="upload_file" type="hidden" id="upload_file" value="upload_file" />
<?php
if (count($IMConfig['maxWidth']) > 1){ ?>
		<br /><table cellpadding="0" cellspacing="0">
			<tr>
				<td><?php echo gt('%%BILDERGROESSE%%');?>
					<select name="uploadSize" id="uploadSize">
					<?php
						$out ='';
						for ($i = 1; $i <= count($IMConfig['maxWidth']); $i++){ echo $i;
							$out .='<option value="'.$i.'">'.$IMConfig['maxWidth'][$i] . ' x ' . $IMConfig['maxHeight'][$i].'</option>';
						}
						echo $out.'<option value="0">Original</option>';
					?>
					</select>
				</td>
				<td style="padding-left: 5px;"><?php echo gt('%%BREITEHOEHE%%');?></td>
			</tr>
			</table>
<?php } ?>
	</form>
	<form action="" method="post" enctype="multipart/form-data" name="form_upload" id="form_upload" class="form_upload">
		<?php echo gt('%%NEUER_ORDNER%%');?>:
		<input name="folder_name" type="text" style="width:290px" />
		<input type="submit" name="create_folder" id="create_folder" value="<?php echo gt('%%ERSTELLEN%%');?>" />
	</form>
	<iframe name="results", frameborder="0" scrolling="auto" class='results'></iframe>
	<div align="center" style="margin-top:5px"> [ <img src="rbfmimg/ico_open_as_web.png" width="16" height="16" align="middle" /> <?php echo gt('%%LINK_EINFUEGEN%%');?> ] &nbsp; &nbsp;
		[ <img src="rbfmimg/ico_download.png" width="16" height="16" align="middle" /> <?php echo gt('%%DOWNLOAD%%');?> ] &nbsp; &nbsp;
		[ <img src="rbfmimg/ico_rename.png" width="16" height="16" align="middle" /> <?php echo gt('%%UMBENENNEN%%');?> ] &nbsp; &nbsp;
		[ <img src="rbfmimg/ico_script_edit.png" width="16" height="16" align="middle" /> <?php echo gt('%%BEARBEITEN%%');?> ] &nbsp; &nbsp;
		[ <img src="rbfmimg/ico_delete.png" width="16" height="16" align="middle" /> <?php echo gt('%%LOESCHEN%%');?> ] </div>
	<?php
	if(!empty($_GET['do']) && $_GET['do'] == 'edit'){
		$file_content = file_get_contents($current_folder.'/'.$_GET['f']);
		echo "
<form id=\"form_edit\" name=\"form_edit\" method=\"post\" action=\"\" style='width: 670px;margin: 10px auto 0;border-top: 1px #999999 solid'>
	<a name='file_edit'></a>
	File: <b>{$current_folder}{$_GET['f']}</b><br />
	<textarea name=\"file_content\" id=\"file_content\" cols=\"\" rows=\"\" style='width: 99%; height: 400px'>".htmlentities ($file_content)."</textarea><br />
	<input name=\"save\" type=\"submit\" value=\"Save\" />
	<input name=\"close\" type=\"button\" value=\"Close file editor\" onclick=\"document.location = 'file_manager.php?f=".urlencode($my_folder)."'\" />
	<input name=\"save_file\" type=\"hidden\" value=\"save_file\" />
</form>
";
	}

?>
	<div class="footer"></div>
</div>
<?php
if(!empty($alert_info)){
	echo "
<script language=\"javascript\">
	alert('{$alert_info}');
</script>
	";
}
if(!empty($redirect)){
	echo "
<script language=\"javascript\">
	document.location = '{$redirect}';
</script>
	";
}
?>
<script type="text/javascript" src="<?php echo $vorgaben['sub_dir'] ?>/jquery/jquery.js"></script>
<script language="JavaScript">
		window.resizeTo(750,550);
		var refw	= window.opener.CKEDITOR.dialog.getCurrent();
		if (!refw) {
			var refw2	= window.opener.document;
		<?php
			if (!empty($_REQUEST['txtUrl'])) {
				echo "var url = refw2.getElementById('".$_REQUEST['txtUrl']."');";
				if (empty($_REQUEST['lnktxt'])) {
					$_REQUEST['lnktxt'] = str_replace('_downloads','titel',$_REQUEST['txtUrl']);
				}
			} else										echo "var url		= refw2.getElementById('txtUrl');";
			if (!empty($_REQUEST['lnktxt']))			echo "var lnktxt	= refw2.getElementById('".$_REQUEST['lnktxt']."');";
			else										echo "var lnktxt	= refw2.getElementById('lnktxt');";
			if (!empty($_REQUEST['cmbLinkProtocol']))	echo "var protocol	= refw2.getElementById('".$_REQUEST['cmbLinkProtocol']."');";
			else										echo "var protocol	= refw2.getElementById('cmbLinkProtocol');";
		?>
		} else var text = '';
		function returnverweis(linkto,filename) {
			if(refw) {
		<?php	if ($_SESSION['initial_folder'] == '/downloads') {	?>
						refw.setValueOf('info','protocol','');
						refw.setValueOf('info','url','<?php echo rtrim($vorgaben['sub_dir'],'/') ?>' + linkto + filename.replace(/ /,'%20'));
						refw.setValueOf('info','contents',filename.replace(/(.*)\.(.*)$/, "$1 ($2)"));
		<?php	} else {	?>
						refw.setValueOf('info','txtUrl','<?php echo rtrim($vorgaben['sub_dir'],'/') ?>' + '/'+linkto.replace('/','') + filename.replace(/ /,'%20'));
						refw.setValueOf('info','txtAlt',filename.replace(/(.*)\.(.*)$/, "$1"));
		<?php	}	?>
			} else {
				if (url != undefined)									url.value = linkto + filename.replace(/ /,'%20');
				if (lnktxt	 != undefined && lnktxt.value == '')		lnktxt.value = filename.replace(/(.*)\.(.*)$/, "$1 ($2)").replace('_',' ');
				if (protocol != undefined)								protocol.value = '';
			}
			self.close();
		}
		$(document).ready(function() {
			var mfs = "<?php echo (min(calc_size(ini_get('upload_max_filesize')),calc_size(ini_get('post_max_size')),calc_size(ini_get('memory_limit'))));?>"
			$(document).on('change', 'input[type=file]', function() {
				var id = $(this).attr('id');
				if (window.File && window.FileReader && window.FileList && this.files[0] != undefined) {
					var file = this.files[0];
					if	(file.size > mfs) {
						alert('<?php echo gt('%%UPLOAD_ZU_GROSS%%');?>' .replace('#SIZE#',bytesToSize(file.size)).replace('#ALLOWED#','#MFS#').replace('#MFS#',bytesToSize(mfs)));
						$('#'+id).replaceWith("<input type='file' id='"+id+"' name='"+$('#'+id).attr('name')+"' />");
				}	}
			});
		});
		function bytesToSize(bytes,dec) {
			var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
			if (bytes == 0) return 'n/a';
			if (dec==undefined) dec = 100;
			else				dec = 10^dec
			var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
			return Math.round(bytes*dec / Math.pow(1024, i))/dec + ' ' + sizes[[i]];
		};
	</script>
</body>
</html>
<?php
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, minimum-scale=0.75, initial-scale=1">
<title>Login</title>
<style type="text/css">
<!--
body,td,th,input {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
body {
	background-color: #EEEEEE;
}
-->
</style>
<?php
if(isset($_GET['logout']))	echo "<script language=\"javascript\">self.close();</script>";
else						echo "<script language=\"javascript\">window.resizeTo(750,550);</script>";
?>
</head>
<body><br /><br /><br /><br />
<div class="login">
	<div style="color:red" align="center"><?php if (!empty($error_message)) echo $error_message; ?></div>
	<form id="login_form" name="login_form" method="post" action="">
		<table border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF" style="border:1px solid #999999; padding:10px">
			<tr>
				<td align="right"><?php echo gt('%%LOGIN%%');?>:</td>
				<td><input type="text" name="username" id="username" class="login_input" style="width:230px" /></td>
			</tr>
			<tr>
				<td align="right"><?php echo gt('%%PASSWORT%%');?>:</td>
				<td><input type="password" name="password" id="password" class="login_input" style="width:100px" />
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right"><input type="submit" name="button" id="button" value="<?php echo gt('%%LOGIN%%');?>" /></td>
			</tr>
		</table>
		<input name="login" type="hidden" value="login" />
	</form>
</div>
</body>
</html>
<?php
}
function do_url($orig_url='') {
	$url[] = "PHPSESSID=".$_SESSION['PHPSESSID'];
	if (!empty($_REQUEST['txtUrl'])) {
		$url[] = "txtUrl=".$_REQUEST['txtUrl'];
		if (empty($_REQUEST['lnktxt']))	$_REQUEST['lnktxt'] = str_replace('_downloads','titel');
	}
	if (!empty($_REQUEST['lnktxt']))			$url[] = "lnktxt=".$_REQUEST['lnktxt'];
	if (!empty($_REQUEST['cmbLinkProtocol']))	$url[] = "cmbLinkProtocol=".$_REQUEST['cmbLinkProtocol'];
	$addurl = implode('&',$url);
	if (empty($orig_url))	return '?'.$addurl;
	else					return '?'.$orig_url.'&'.$addurl;
}
?>