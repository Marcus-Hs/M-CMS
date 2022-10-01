<?php
function kaufen($mail=false) {
	global $sub_tpl;
	if ($mail && !empty($_REQUEST['basket'])) {
		$out = kaufmail();
		return $out;
	}
	return $sub_tpl['orderform'];
}
function kaufmail() {
	global $tplobj,$sub_tpl,$gsum,$vorgaben;
	$data['PAGE_ID']=377;
	get_vorlage($data);
#	$out = $sub_tpl['kaufen'];
	$result['gsum'] = 0;
	$result['ganz'] = 0;
    $basketout = '';
    $shipping = false;
	foreach ($_REQUEST['basket'] as $articlenr => $amount) {
		$result['amount'] = $amount;
		if (!empty($result['amount']) && is_numeric($result['amount']) && $result['amount']>0) {
			if (!$vorgaben['is_preview']) {
				$result['sum'] = floatval(str_replace(',','',$sub_tpl['price'][$articlenr]))*$result['amount']/100;
				$result['ganz'] += $result['amount'];
				if (!empty($sub_tpl['shipping'][$articlenr]) && $sub_tpl['shipping'][$articlenr]>0) $shipping = true;
				$result['gsum'] += $result['sum'];
                $result['sum'] = FormatNumber($result['sum'],',','.','',2);
				$basketout.= $tplobj->array2tpl($sub_tpl['articletpl'][$articlenr],$result,'#',$entities=true);
	}	}	}
	if ($shipping == true) {
		$result['amount'] = 1;
    	$result['sum'] =floatval(str_replace(',','',$sub_tpl['price_versandkosten']))*$result['amount']/100;
		$result['gsum'] += $result['sum'];
        $result['sum'] = FormatNumber($result['sum'],',','.','',2);
		$basketout.= $tplobj->array2tpl($sub_tpl['articletpl_versandkosten'],$result,'#',$entities=true);

	}
	$result['gsum'] = FormatNumber($result['gsum'],',','.','',2);
	$out = str_replace('#BASKETOUT#',$basketout,$sub_tpl['ordermail']);
	$out = $tplobj->array2tpl($out,$result,'#',$entities=true);
	unset($_REQUEST['basket']);
	make_replacements($out);
	return $out;
}
?>