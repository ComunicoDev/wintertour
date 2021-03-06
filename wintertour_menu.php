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
    <a href="<?php echo admin_url('admin.php?page=wintertour'); ?>"><h1>Gestionale WinterTour</h1></a>
    <?=winterMenu()?>
	<h2>Homepage</h2>
	
    <a href="<?php echo admin_url('admin.php?page=wintertour'); ?>">Homepage</a><br />
	<a href="<?php echo admin_url('admin.php?page=wintertour_soci'); ?>">Soci</a><br />
	<a href="<?php echo admin_url('admin.php?page=wintertour_circoli'); ?>">Circoli</a><br />
    <a href="<?php echo admin_url('admin.php?page=wintertour_turni'); ?>">Turni</a><br />
    <a href="<?php echo admin_url('admin.php?page=wintertour_punteggi'); ?>">Punteggi</a><br />
    <a href="<?php echo admin_url('admin.php?page=wintertour_risultati'); ?>">Classifica</a><br />
    <a href="<?php echo admin_url('admin.php?page=wintertour_carica_risultati'); ?>">Risultati</a><br />
    <a href="<?php echo admin_url('admin.php?page=wintertour_tabella_incontri'); ?>">Tabella Incontri</a>
</div>
