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
    
    function wintertour_subpage($page) {
        $_POST      = array_map( 'stripslashes_deep', $_POST );
        $_GET       = array_map( 'stripslashes_deep', $_GET );
        $_COOKIE    = array_map( 'stripslashes_deep', $_COOKIE );
        $_REQUEST   = array_map( 'stripslashes_deep', $_REQUEST );
        
        include($page);
    }
	
	/**
	 * Admin options handler
	 */
	function wintertour_options() {
		wintertour_subpage('wintertour_options.php');
	}
	
	/**
	 * Admin menu handler
	 */
	function wintertour_menu() {
		wintertour_subpage('wintertour_menu.php');
	}
	
	/**
	 * Admin menu_soci handler
	 */
	function wintertour_menu_soci() {
		wintertour_subpage('wintertour_menu_soci.php');
	}
	
	/**
	 * Admin menu_circoli handler
	 */
	function wintertour_menu_circoli() {
		wintertour_subpage('wintertour_menu_circoli.php');
	}
    
    /**
     * Admin menu_turni handler
     */
    function wintertour_menu_turni() {
        wintertour_subpage('wintertour_menu_turni.php');
    }
    
    /**
     * Admin menu_punteggi handler
     */
    function wintertour_menu_punteggi() {
        wintertour_subpage('wintertour_menu_punteggi.php');
    }
    
    /**
     * Admin menu_risultati handler
     */
    function wintertour_carica_risultati() {
        wintertour_subpage('wintertour_carica_risultati.php');
    }
    
    /**
     * Admin menu_risultati handler
     */
    function wintertour_menu_risultati() {
        wintertour_subpage('wintertour_menu_risultati.php');
    }
    
    /**
     * Admin menu_incontri handler
     */
    function wintertour_menu_incontri() {
        wintertour_subpage('wintertour_menu_incontri.php');
    }
	
	/**
	 * Adds admin_menu handlers
	 */
	function wintertour_admin_actions() {
		add_options_page("Opzioni Gestionale", "Opzioni Gestionale", 1, "OpzioniGestionale", "wintertour_options");
		add_menu_page("wintertour", "Wintertour", 1, "wintertour", "wintertour_menu", plugins_url("images/logo.png", __FILE__));
		add_submenu_page("wintertour", "Gestionale", "Homepage", 1, "wintertour", "wintertour_menu");
		add_submenu_page("wintertour", "Gestionale Soci", "Soci", 1, "wintertour_soci", "wintertour_menu_soci");
		add_submenu_page("wintertour", "Gestionale Circoli", "Circoli", 1, "wintertour_circoli", "wintertour_menu_circoli");
        add_submenu_page("wintertour", "Gestionale Tappe", "Tappe", 1, "wintertour_turni", "wintertour_menu_turni");
        add_submenu_page("wintertour", "Gestionale Punteggi", "Punteggi", 1, "wintertour_punteggi", "wintertour_menu_punteggi");
        add_submenu_page("wintertour", "Gestionale Risultati", "Risultati", 1, "wintertour_carica_risultati", "wintertour_carica_risultati");
        add_submenu_page("wintertour", "Gestionale Classifica", "Classifica", 1, "wintertour_risultati", "wintertour_menu_risultati");
        add_submenu_page("wintertour", "Gestionale Tabella Incontri", "Tabella Incontri", 1, "wintertour_tabella_incontri", "wintertour_menu_incontri");
	}
	
	/**
	 * Adds admin_menu stylesheets
	 */
	function wintertour_admin_scripts() {
		wp_register_style('jscrollpane', plugins_url("css/jquery.jscrollpane.css", __FILE__ ));
		wp_register_style('datetimepicker', plugins_url("css/jquery.datetimepicker.css", __FILE__ ));
		wp_register_style('wintertour_adminStyle', plugins_url("css/wintertour_adminStyle.css", __FILE__ ));
		
		wp_register_script('mousewheel', plugins_url('js/jquery.mousewheel.js', __FILE__), array('jquery'), '3.1.9');
		wp_register_script('mwheelIntent', plugins_url('js/mwheelIntent.js', __FILE__), array('jquery'), '1.2');
		wp_register_script('jscrollpane', plugins_url('js/jquery.jscrollpane.js', __FILE__), array('jquery'), '2.0.19');
		wp_register_script('datetimepicker', plugins_url('js/jquery.datetimepicker.js', __FILE__), array('jquery'), '2.3.6');
		wp_register_script('typewatch', plugins_url('js/jquery.typewatch.js', __FILE__), array('jquery'), '2.2.1');
		
		wp_register_script('autocompletion', plugins_url('js/jquery.autocompletion.js', __FILE__), array('jquery', 'typewatch'), '1.0.0', true);
        wp_register_script('footready', plugins_url('js/footready.js', __FILE__), array('jquery', 'autocompletion'), '1.0.0', true);
		
		wp_enqueue_style('jscrollpane');
		wp_enqueue_style('datetimepicker');
		wp_enqueue_style('wintertour_adminStyle');
		
		wp_enqueue_script('mousewheel');
		wp_enqueue_script('mwheelIntent');
		wp_enqueue_script('jscrollpane');
		wp_enqueue_script('datetimepicker');
		wp_enqueue_script('typewatch');
		
		wp_enqueue_script('footready');
		wp_enqueue_script('autocompletion');
	}
	
	function wintertour_scripts() {
        wp_register_style('datetimepicker', plugins_url("css/jquery.datetimepicker.css", __FILE__ ));
        
        wp_register_script('datetimepicker', plugins_url('js/jquery.datetimepicker.js', __FILE__), array('jquery'), '2.3.6');
        wp_register_script('typewatch', plugins_url('js/jquery.typewatch.js', __FILE__), array('jquery'), '2.2.1');
        
		wp_register_style('wintertour_style', plugins_url("css/wintertour_style.css", __FILE__ ));
        
        wp_register_script('wintertourform', plugins_url('js/wintertourform.js', __FILE__), array('jquery'), '1.0.0', true);
        wp_register_script('autogiocatore', plugins_url('js/jquery.autogiocatore.js', __FILE__), array('jquery', 'typewatch'), '1.0.0', true);
        wp_register_script('wintertourschedagiocatore', plugins_url('js/wintertourschedagiocatore.js', __FILE__), array('jquery', 'autogiocatore'), '1.0.0', true);
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
    
    function wintertour_autogiocatore() {
        wintertour_get_autogiocatore();
        
        die();
    }
	
	function remove_footer_admin() {
		remove_filter( 'update_footer', 'core_update_footer' );
	}
	
	function myadmin_text() {
		return '';
	}
	
	add_action('admin_menu', 'wintertour_admin_actions');
	add_action( 'admin_enqueue_scripts', 'wintertour_admin_scripts' );
	add_action( 'admin_menu', 'remove_footer_admin' );
	add_filter( 'admin_footer_text', 'myadmin_text' );
	add_action( 'wp_enqueue_scripts', 'wintertour_scripts' );
	
	//[wintertour_register]
	function wintertour_registerForm($atts) {
		wintertour_subpage("wintertour_registerform.php");
	}
    //[wintertour_playercard
    function wintertour_playercard($atts) {
        wintertour_subpage("wintertour_playercard.php");
    }
	add_shortcode( 'wintertour_register', 'wintertour_registerForm' );
    add_shortcode( 'wintertour_playercard', 'wintertour_playercard' );
	
	if (is_admin()) {
		add_action('wp_ajax_wintertour_autocomplete', 'wintertour_autocomplete');
        add_action('wp_ajax_wintertour_autogiocatore', 'wintertour_autogiocatore');
	}
	register_activation_hook( __FILE__, 'wintertour_install' );
?>
