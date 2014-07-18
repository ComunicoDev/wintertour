<?php
	/**
	 * Gestionale WinterTour
	 *
	 * Plugin per gestire i tornei e l'anagrafica e le iscrizioni dei membri
	 * @author Comunico S.r.l. <info@comunico.info>
	 * @version 1.0
	 * @package wintertour
	 *
	 * Plugin Name: Gestionale WinterTour
	 * Plugin URI: http://www.sporthappenings.it/gestionale/
	 * Description: Plugin per gestire i tornei e l'anagrafica e le iscrizioni dei membri
	 * Version: 1.0
	 * Author: Comunico S.r.l.
	 * Author URI: http://www.comunico.info/
	 * License: GNU General Public License v2 or later
	 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
	 *
	 * This plugin, like WordPress, is licensed under the GPL.
	 */
	
	// Make sure we don't expose any info if called directly
	if ( !function_exists( 'add_action' ) ) {
		exit;
	}
	
	/**
	 * Admin options handler
	 */
	function wintertour_options() {
		include ('wintertour_options.php');
	}
	
	/**
	 * Admin menu handler
	 */
	function wintertour_menu() {
		include ('wintertour_menu.php');
	}
	
	/**
	 * Adds admin_menu handlers
	 */
	function wintertour_admin_actions() {
		add_options_page("Opzioni Gestionale", "Opzioni Gestionale", 1, "OpzioniGestionale", "wintertour_options");
		add_menu_page("Gestionale", "Gestionale", 1, "Gestionale", "wintertour_menu", plugins_url("images/logo.png", __FILE__ ), 5);
	}
	
	add_action('admin_menu', 'wintertour_admin_actions');
?>