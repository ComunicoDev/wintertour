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
	 
	include_once('wintertour_functions.php');
	
	// Make sure we don't expose any info if called directly
	if (!function_exists( 'add_action' )) {
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
	 * Admin menu_soci handler
	 */
	function wintertour_menu_soci() {
		include ('wintertour_menu_soci.php');
	}
	
	/**
	 * Admin menu_soci handler
	 */
	function wintertour_menu_circoli() {
		include ('wintertour_menu_circoli.php');
	}
	
	/**
	 * Adds admin_menu handlers
	 */
	function wintertour_admin_actions() {
		add_options_page("Opzioni Gestionale", "Opzioni Gestionale", 1, "OpzioniGestionale", "wintertour_options");
		add_menu_page("gestionale", "Gestionale", 1, "gestionale", "wintertour_menu", plugins_url("images/logo.png", __FILE__), 26);
		add_submenu_page("gestionale", "Gestionale", "Homepage", 1, "gestionale", "wintertour_menu");
		add_submenu_page("gestionale", "Gestionale Soci", "Soci", 1, "gestionale_soci", "wintertour_menu_soci");
		add_submenu_page("gestionale", "Gestionale Circoli", "Circoli", 1, "gestionale_circoli", "wintertour_menu_circoli");
	}
	
	/**
	 * Adds admin_menu stylesheets
	 */
	function wintertour_admin_scripts() {
		wp_register_style('jscrollpane', plugins_url("css/jquery.jscrollpane.css", __FILE__ ));
		wp_register_style('datetimepicker', plugins_url("css/jquery.datetimepicker.css", __FILE__ ));
		wp_register_style('wintertour_style', plugins_url("css/wintertour_style.css", __FILE__ ));
		
		wp_register_script('mousewheel', plugins_url('js/jquery.mousewheel.js', __FILE__), array('jquery'), '3.1.9');
		wp_register_script('mwheelIntent', plugins_url('js/mwheelIntent.js', __FILE__), array('jquery'), '1.2');
		wp_register_script('jscrollpane', plugins_url('js/jquery.jscrollpane.js', __FILE__), array('jquery'), '2.0.19');
		wp_register_script('datetimepicker', plugins_url('js/jquery.datetimepicker.js', __FILE__), array('jquery'), '2.3.6');
		
		wp_register_script('footready', plugins_url('js/footready.js', __FILE__), array('jquery'), '1.0.0', true);
		
		wp_enqueue_style('jscrollpane');
		wp_enqueue_style('datetimepicker');
		wp_enqueue_style('wintertour_style');
		
		wp_enqueue_script('mousewheel');
		wp_enqueue_script('mwheelIntent');
		wp_enqueue_script('jscrollpane');
		wp_enqueue_script('datetimepicker');
		
		wp_enqueue_script('footready');
	}
	
	/**
	 * Create the tables if they do not exist already
	 */
	function wintertour_install() {
		$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		if (!mysqli_connect_errno()) {
			$check = mysqli_multi_query($con, file_get_contents(plugins_url("CREATE_DATABASE.sql", __FILE__ )));
			
			if(!$check) {
				mysqli_close($con);
				die('Query error: ' . mysqli_error($con));
			}
		} else {
			mysqli_close($con);
			die("Connection error: " . mysqli_connect_error());
		}
		
		mysqli_close($con);
	}
	
	function wintertour_autocomplete() {
		wintertour_get_autocomplete();
		
		die();
	}
	
	
	add_action('admin_menu', 'wintertour_admin_actions');
	add_action( 'admin_enqueue_scripts', 'wintertour_admin_scripts' );
	if (is_admin()) {
		add_action('wp_ajax_wintertour_autocomplete', 'wintertour_autocomplete');
	}
	register_activation_hook( __FILE__, 'wintertour_install' );
?>
