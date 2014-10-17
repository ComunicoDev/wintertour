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
<div class="wintertour_plugin wintertour_shortcode">
	<h3>Registrati online compilando il form</h3>
	<form class="wintertour_register" method="post">
		<div><input name="nome" type="text" placeholder="Nome" /></div>
		<div><input name="cognome" type="text" placeholder="Cognome" /></div>
		<div><input name="email" type="email" placeholder="Email" /></div>
		<div><input name="indirizzo" type="text" placeholder="Indirizzo e numero civico" /></div>
		<div><input name="cap" type="text" placeholder="CAP" /></div>
		<div><input name="citta" type="text" placeholder="Citt&agrave;" /></div>
		<div><input name="provincia" type="text" placeholder="Provincia" /></div>
		<div><input name="telefono" type="tel" placeholder="Telefono" /></div>
		<div><input name="cellulare" type="tel" placeholder="Cellulare" /></div>
		<div><input name="datanascita" type="text" placeholder="Data di Nascita" /></div>
		<div><input name="cittanascita" type="text" placeholder="Citt&agrave; di Nascita" /></div>
		<div><input name="codicefiscale" type="text" placeholder="Codice Fiscale" /></div>
		<div><input name="wintertour_subscription" type="submit" value="Registrati" /></div>
	</form>
</div>
