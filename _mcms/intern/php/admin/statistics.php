<?php
function prepare_statistics() {			// Statistikfunktion einbinden
	global $add_admin,$add,$add_vorgaben;
	$add_admin['admin2']['2_statistik'] = array('popup' => 'statistics_domain', 'suffix' => '','titel' => '%%STATISTIK%%','style'=>'style="background-image:url(/admin/icons/stats.png)"');
										//	Domain in neuenm Fenster öffnen, mit diesem Anhängsel (+ SID)
	$add_vorgaben['Statistik']['statistics_id']		= '<label for="statistics_id">%%STATISTIKID%%:</label>	 		<input id="statistics_id"	  name="vorgaben[statistics_id]"	 value="|STATISTICS_ID|" /><br />';
	$add_vorgaben['Statistik']['statistics_domain'] = '<label for="statistics_domain">%%STATISTIKDOMAIN%%:</label>	<input id="statistics_domain" name="vorgaben[statistics_domain]" value="|STATISTICS_DOMAIN|" /><br />';
	$add_vorgaben['Statistik']['seitenzaehler']		= '<label for="seitenzaehler">%%SEITENZAEHLER%%: </label>		<input id="seitenzaehler" 	  name="vorgaben[seitenzaehler]"	 value="|SEITENZAEHLER|" size="5" type="number" ><br />';
	$add['Statistik'] = array('seitenzaehler_multi_seite'=>'%%SEITEN_ZAEHLEN%%');		
}
?>