<?php
	/**
	 * Gestionale WinterTour - Pagina di amministrazione
	 *
	 * Plugin per gestire i tornei e l'anagrafica e le iscrizioni dei membri
	 * @author Comunico S.r.l. <info@comunico.info>
	 * @version 1.0
	 * @package wintertour
	 */
	
	// Make sure we don't expose any info if called directly
	if ( !function_exists( 'plugins_url' ) ) {
		exit;
	}
?>
<div class="wgest_page wgest_opt">
	<h1>Gestionale WinterTour</h1>
	<h2>Homepage</h2>
	<a href="<?php echo admin_url('admin.php?page=gestionale_soci'); ?>">Soci</a>
</div>
