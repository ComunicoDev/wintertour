<?php
	/**
	 * Gestionale WinterTour - Pagina di amministrazione
	 *
	 * Plugin per gestire i tornei e l'anagrafica e le iscrizioni dei membri
	 * @author Comunico S.r.l. <info@comunico.info>
	 * @version 1.0
	 * @package wintertour
	 */
	 
	function wintertour_addTipologiaSoci() {
		global $wpdb;
		
		$wpdb->insert(
			"wintertourtennis_tipologie_soci", 
			array( 
				"nome" => $_POST['nometipologia'],
				"descrizione" => $_POST['descrizionetipologia']
			)
		);
	}
	
	function wintertour_addSocio() {
		
	}
	
	function wintertour_get_autocomplete() {
		global $wpdb;
		
		wp_verify_nonce($_POST['wt_nonce'], 'wt_nonce') or die('Fuck off');
		
		$res = $wpdb->get_results("SELECT `ID`, `nome`, `cognome` FROM `wintertourtennis_soci`;");
		
		echo json_encode($res);
	}
?>