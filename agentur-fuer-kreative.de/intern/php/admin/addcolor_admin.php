<?php
function prepare_addcolor_admin() {
	global $dbobj,$add,$add_admin,$plugin_functions,$vorgaben;
	if ($dbobj->table_exists(__file__,__line__,'#PREFIX#plugins__addcolor')) {
		$add_admin['plugins']['addcolor'] = array('titel' => '%%ADDCOLOR%%');
		$plugin_functions['everywhere'] = 'addcolor_plugin';
		if (!empty($_REQUEST['addcolor'])) {
			save_color();
}	}	}
function addcolor_plugin($elements) {
	global $dbobj,$tplobj;
	$tpls = addcolor_tpl();
	add_colorpicker();
	$out = array();
	if ($c = $dbobj->withkey(__FILE__,__LINE__,"SELECT PAGE_ID,color_ID,color FROM #PREFIX#plugins__addcolor WHERE PAGE_ID = ".$elements['PAGE_ID']." OR  PAGE_ID = 0;",'PAGE_ID',true,'color_ID')) {
		if (!empty($c[$elements['PAGE_ID']]))	$page_id = $elements['PAGE_ID'];
		else									$page_id = 0;
		foreach ($c[$page_id] as $color_ID => $color) {
			if (empty($color))	$color['color'] = '#000';
			$color['PAGE_ID'] = $elements['PAGE_ID'];
			$color['color_ID'] = $color_ID;
			$out[] = $tplobj->array2tpl($tpls['color'],$color);
		}
	}#	else {$out = '%%FARBIDS_FEHLEN%%';}
	return r_implode($out,"\n");
}
function save_color() {
	global $error,$dbobj;
	if (!empty($_REQUEST['addcolor'])) {
		$data['PAGE_ID'] = key($_REQUEST['addcolor']);
		foreach ($_REQUEST['addcolor'][$data['PAGE_ID']] as $data['color_ID'] => $data['color']) {
			$dbobj->array2db(__file__,__line__,$data,'#PREFIX#plugins__addcolor','INSERT INTO','WHERE PAGE_ID = '.$data['PAGE_ID'].' AND color_ID = "'.$data['color_ID'].'";');
}	}	}

function addcolor_tpl() {
	global $tplobj;
	$tpl['color'] = '<p><label for="color">%%FARBE%% (|COLOR_ID|): <input type="color" name="addcolor[|PAGE_ID|][|COLOR_ID|]" value="|COLOR|" /></label></p>';
	return $tplobj->read_tpls($tpl);
}
?>