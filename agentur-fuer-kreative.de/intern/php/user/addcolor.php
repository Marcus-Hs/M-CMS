<?php
function colour($data) {
	global $sub_tpl;
	addcolor($data);
	if (empty($data['tpl']))	$data['tpl'] = 'menu_css';
	if (!empty($sub_tpl[$data['tpl']]) && !empty($sub_tpl['addcolor'])) {
		foreach ($sub_tpl['addcolor'] as $p => $colors) {
			$c = hex2rgb($colors[$data['color_ID']]['color']);
			if (!empty($colors[$data['color_ID']]))	$menucolor[$p] = str_replace(array('#P_ID#','#COLOR#'),array($p,$c),$sub_tpl[$data['tpl']]);
		}
		return implode("\n",$menucolor);
	}
}
function addcolor($data) {
	global $dbobj,$page_id,$sub_tpl;
	if		(empty($sub_tpl['addcolor'])) 											$sub_tpl['addcolor'] = $dbobj->withkey(__file__,__line__,"SELECT * FROM #PREFIX#plugins__addcolor;",'PAGE_ID',true,'color_ID');
	if		(!empty($data['page_id'][$data['color_ID']]))							$c = $sub_tpl['addcolor'][$data['page_id']][$data['color_ID']]['color'];
	elseif	(!empty($data['color_ID']) && !empty($sub_tpl['addcolor'][$page_id]))	$c = $sub_tpl['addcolor'][$page_id][$data['color_ID']]['color'];
	if (!empty($c))	return hex2rgba($data,$c);
#	else			return false;
}
?>