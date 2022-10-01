<?php
function prepare_statistics() {
	global $page_id,$notfound,$vorgaben,$sub_tpl;
	if (!$vorgaben['preview'] && !$vorgaben['localhost'] && empty($notfound) && !empty($page_id) && !empty($vorgaben['stats']) && empty($_REQUEST['pqp']) && empty($_REQUEST['msg_nr']) && (empty($_SESSION['status']) || is_numeric($_SESSION['status']))) {
		if (!empty($vorgaben['seitenzaehler_multi_seite']) && function_exists('add_vorgaben')) {
			if ($vorgaben['seitenzaehler_multi_seite']<0 || in_array($page_id,explode(',',$vorgaben['seitenzaehler_multi_seite']))) {
				$add = 1;
				add_vorgaben('seitenzaehler',$add);
		}	}
		if (!empty($vorgaben['statistics_id'])) {
			$sub_tpl['JS']['ga']		= 'https://www.googletagmanager.com/gtag/js?id='.$vorgaben['statistics_id'];
			$sub_tpl['addscript']['ga']	= "window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '".$vorgaben['statistics_id']."', {
	'anonymizeIp': true,
	'storage': 'none',
	'cookie_expires': 0
  }); ";
}	}	}
function visitcounter() {
	$sz = read_vorgabe('seitenzaehler');
	if (empty($sz)) {
		write_vorgaben(array('seitenzaehler'=>1));
		return '0';
	}
	return $sz;
}
?>