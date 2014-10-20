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
	
	if (isset($_POST) && !empty($_POST['nome']) && !empty($_POST['cognome']) && !empty($_POST['email']) &&
		!empty($_POST['indirizzo']) && !empty($_POST['cap']) && !empty($_POST['citta']) && !empty($_POST['provincia']) &&
		!empty($_POST['telefono']) && !empty($_POST['cellulare']) && !empty($_POST['datanascita']) &&
		!empty($_POST['cittanascita']) && !empty($_POST['codicefiscale'])) {
		$nome = trim($_POST['nome']);
		$cognome = trim($_POST['cognome']);
		$email = trim($_POST['email']);
		$indirizzo = trim($_POST['indirizzo']);
		$cap = trim($_POST['cap']);
		$citta = trim($_POST['citta']);
		$provincia = trim($_POST['provincia']);
		$telefono = trim($_POST['telefono']);
		$cellulare = trim($_POST['cellulare']);
		$datanascita = trim($_POST['datanascita']);
		$cittanascita = trim($_POST['cittanascita']);
		$codicefiscale = trim($_POST['codicefiscale']);
		
		global $wpdb;
		
		if($wpdb->insert(
			'wintertourtennis_soci',
			array(
				'nome' => $nome,
				'cognome' => $cognome,
				'email' => $email,
				'indirizzo' => $indirizzo,
				'cap' => $cap,
				'citta' => $citta,
				'provincia' => $provincia,
				'telefono' => $telefono,
				'cellulare' => $cellulare,
				'datanascita' => $datanascita,
				'codicefiscale' => $codicefiscale
			), array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s'
			)
		)) {
			echo "Operazione eseguita con successo!";
		} else {
			echo "<pre>Query error: ";
			$wpdb->print_error();
			echo "</pre>";
		}
	}
?>
<div class="wintertour_plugin wintertour_shortcode">
	<h3>Registrati online compilando il form</h3>
	<form class="wintertour_register" method="post">
		<div><input autocomplete="off" required="required" name="nome" type="text" placeholder="Nome" pattern="\s*(?:\s*[^\s]\s*){2}[\w\s]{0,33}\s*" /></div>
		<div><input autocomplete="off" required="required" name="cognome" type="text" placeholder="Cognome" pattern="\s*(?:\s*[^\s]\s*){2}[\w\s]{0,33}\s*" /></div>
		<div><input autocomplete="off" required="required" name="email" type="email" placeholder="Email" pattern="(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|&quot;(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*&quot;)@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])" /></div>
		<div><input autocomplete="off" required="required" name="indirizzo" type="text" placeholder="Indirizzo e numero civico" pattern="\s*(?=.*\d).{8,63}\s*" /></div>
		<div><input autocomplete="off" required="required" name="cap" type="text" placeholder="CAP" pattern="\d{5}" /></div>
		<div><input autocomplete="off" required="required" name="citta" type="text" placeholder="Citt&agrave;" pattern="\s*(?:\s*[^\s]\s*){3}[\w\s]{0,61}\s*" /></div>
		<div><input autocomplete="off" required="required" name="provincia" type="text" placeholder="Provincia" pattern="\s*(?:\s*[^\s]\s*){3}[\w\s]{0,61}\s*" /></div>
		<div><input autocomplete="off" required="required" name="telefono" type="tel" placeholder="Telefono" pattern="\s*[.+()/-\s\d]{3,25}\s*" /></div>
		<div><input autocomplete="off" required="required" name="cellulare" type="tel" placeholder="Cellulare" pattern="\s*[.+()/-\s\d]{3,25}\s*" /></div>
		<div><input autocomplete="off" required="required" name="datanascita" type="text" placeholder="gg/mm/aaaa" pattern="\d\d\/\d\d/\d{4}" /></div>
		<div><input autocomplete="off" required="required" name="cittanascita" type="text" placeholder="Citt&agrave; di Nascita" pattern="\s*(?:\s*[^\s]\s*){3}[\w\s]{0,61}\s*" /></div>
		<div><input autocomplete="off" required="required" name="codicefiscale" type="text" placeholder="Codice Fiscale" pattern="[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]" /></div>
		<div><input autocomplete="off" name="wintertour_subscription" type="submit" value="Registrati" /></div>
	</form>
</div>
