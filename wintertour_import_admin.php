<?php
	function wintertour_admin() {
		include ('wintertour_import_admin.php');
	}
	
	function wintertour_admin_actions() {
		add_options_page("Gestionale WinterTour", "Gestionale WinterTour", 1, "Gestionale WinterTour", "wintertour_admin");
	}
	
	add_action('admin_menu', 'wintertour_admin_actions');
?>