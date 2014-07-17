<?php
	/**
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
	
	function wintertour_admin_actions() {
		add_options_page("Gestionale WinterTour", "Gestionale WinterTour", 1, "Gestionale WinterTour", "wintertour_admin");
	}
	
	add_action('admin_menu', 'wintertour_admin_actions');
?>