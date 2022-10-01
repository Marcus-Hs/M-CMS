<?php
function prepare_edit_bgimg() {
	global $add_admin,$error;
	$add_admin['admin2']['3_bgimg'] = array('function' => 'edit_bgimg','titel' => '%%HINTERGRUENDE%%','style'=>'style="background-image:url(/admin/icons/Picture.png)"');
}
function edit_bgimg() {
	global $tplobj;
	add_lightbox();
	$tpls = bg_tpl();
	$data = array('size'=>'thumbs','visibility'=>'1,0','tpl'=>'admin/bilder.inc.html','imginfo'=>true);
	if (empty($_REQUEST['PART_ID']))	$data['PART_ID'] = 'hintergrund,hintergrund2';
	if (!empty($_REQUEST['LANG_ID']))	$data['LANG_ID'] = $_REQUEST['LANG_ID'];
	if($imgs = get_images($data)) {
		$part_alt = '';
		foreach ($imgs as $part_id => $page) {
			if ($part_alt != $part_id)	$zeilen[] = '<h2 class="cb">'.$part_id.'</h2>';
			$part_alt = $part_id;
			foreach ($page as $page_id => $bg) {
				$elements['bild'] = current($bg);
				$elements['page_id'] = $page_id;
				$elements['M'] = get_page(array('PAGE_ID'=>$page_id,'feld'=>'Menu','visibility'=>'1,0','errors'=>false));
				$zeilen[] = $tplobj->array2tpl($tpls['line'],$elements);			// Template füllen
		}	}
		return str_replace('|BGS|',implode("\n",$zeilen),$tpls['page']);
}	}
function bg_tpl() {
	global $tplobj;
	$tpl['page'] = '<h1>%%HINTERGRUENDE%%</h1>
	<form action="|PHPSELF|?page=|PAGE|" method="post">
		|PHPSESSID|
		<p><input class="btn save" type="submit" name="send" value="%%EINTRAGEN%%" /></p>
		<div class="cb">|BGS|</div>
		<p><input class="btn save cb" type="submit" name="send" value="%%EINTRAGEN%%" /></p>
	</form>';
	$tpl['line'] = '<div style="padding:20px;float:left;height:180px">
		<a style="display:block;margin-top:0px;" href="|PHPSELF|?page=pages&amp;pages[PAGE_ID]=|PAGE_ID||SID|">|M|</a><br style="clear:both;" />
		|BILD|</div>';
	return $tplobj->read_tpls($tpl);
}
?>