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
	wp_enqueue_style('wintertour_style');
    wp_enqueue_style('datetimepicker');
    wp_enqueue_script('datetimepicker');
    wp_enqueue_script('wintertourform');
	
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
				'saldo' => 0,
				'indirizzo' => $indirizzo,
				'citta' => $citta,
				'cap' => $cap,
				'provincia' => $provincia,
				'telefono' => $telefono,
				'cellulare' => $cellulare,
				'statoattivo' => 0,
				'datanascita' => date('Y-m-d', strtotime($datanascita)),
				'codicefiscale' => $codicefiscale,
				'certificatomedico' => 0
			), array(
				'%s',
				'%s',
				'%s',
				'%d',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%d',
				'%s',
				'%s',
				'%d'
			)
		)) {
			echo "Operazione eseguita con successo!" . "\n";
			$headers = "Content-type: text/html" . "\r\n";
			$headers .= "From: SportHappenings <info@sporthappenings.it>" . "\r\n";
			$subject = "La tua iscrizione a SportHappenings";
			
			$message = "<!doctype html><html><head><title>$subject</title></head><body>";
			$message .= "Gentile utente,<br /><br />grazie per aver sottoscritto l'associazione con l'ASD SportHappenings per l'anno 2014/15.<br />Siamo lieti di averti nel nostro team.<br /><br />Riceverai la nuova tessera associativa al pi�� presto.Ti ricordiamo che dovrai versare la quota sociale di 18��� entro pochi giorni affinch�� il tesseramento sia valido.<br />Di seguito gli estremi per effettuare il bonifico:<br /><br /><b>IT 55 J 02008 01117 000102693072UNICREDIT Agenzia di corso Moncalieri Torino</b><br />conto intestato all'ASD SPORT HAPPENINGS<br /><br />Grazie e buon divertimento con SportHappenings!<br /><br /><br />ADS  <a href=\"http://www.sporthappenings.it/\">Sport Happenings</a><br />Corso Moncalieri, 506/35, Torino, 10133<br />T: +39 366 415 4022<br />F: +39 011 070 1672<br />Email: <a href=\"mailto:info@sporthappenings.it\">info@sporthappenings.it</a>";
			$message .= "</body></html>";
			
			wp_mail($email, $subject, $message, $headers);
			
			$headers = "Content-type: text/html" . "\r\n";
			$headers .= "From: $nome $cognome <$email>" . "\r\n";
			$subject = "Iscrizione di $nome $cognome a SportHappenings";
			
			$message = "<!doctype html><html><head><title>$subject</title></head><body>";
			$message .= "�� pervenuta una nuova iscrizione sul sito <a href=\"http://www.sporthappenings.it/wintertourtennis/\">WinterTour Tennis</a><p><b>Il sottoscritto</b></p><p>Nome: $nome</p><p>Cognome: $cognome</p><p>Nato a: $cittanascita</p><p>Nato il: $datanascita</p><p>Codice fiscale: $codicefiscale</p><p>Residente in: $citta</p><p>CAP: $cap</p><p>Indirizzo: $indirizzo</p><p>Numero di Telefono: $telefono</p><p>Numero di Cellulare: $cellulare</p><p>La tua email: $email</p><p><b>Richiede la tessera socio all'A.S.D. Sport Happenings</b></p><p><b>Informativa ai sensi art. 13 D.lgs.196/03</b><br /><br />La presente per informarvi che presso la nostra societ�� viene effettuato il trattamento dei Vs. dati personali nel pieno rispetto del DecretoLegislativo196/03.<br />I dati sono inseriti nelle banche dati della nostra societ�� in seguito all���acquisizione del Vs. consenso salvo i casi in cui all���art.24 D. Lgs. 196/03. In base a<br />tale normativa il trattamento sar�� improntato ai principi di correttezza, liceit��,e trasparenza e di tutela della Sua riservatezza e dei Suoi diritti. Ai sensi<br />dell���art. 13 la informiamo che i dati sono raccolti al fine di obblighi contrattuali, adempimenti contabili e fiscali ed il trattamento avviene con le modalit��<br />manuale e informatizzata.<br />-Il conferimento dei dati ha natura obbligatoria. In caso di rifiuto di conferire i dati le conseguenze saranno di mancata o parziale esecuzione del contratto<br />-I suoi dati non saranno comunicati ad altri soggetti, n�� saranno oggetto di diffusione fatta eccezione per gli studi professionali preposti alla consulenza<br />contabile e finanziaria della nostra societ�� in quanto trattasi di soggetti responsabili ed incaricati del trattamento<br />-Al titolare ed al responsabile del trattamento Lei potr�� rivolgersi per far valere i suoi diritti cos�� come previsti dall���art. 7 del D.Lgs. 196/03,cio�� l conferma<br />dell���esistenza o meno dei dati che la riguardano; la cancellazione , la trasformazione in forma anonima ed il blocco dei dati trattati in violazione di legge;<br />l���aggiornamento, la rettificazione ovvero l���integrazione dei dati; l���attestazione che le operazioni descritte sono state portate a conoscenza di coloro ai quali i<br />dati sono stati comunicati o diffusi<br />-Il Responsabile del trattamento anche ai sensi dell���art.7 D.Lgs: 196/03 �� la sig.ra Margherita Vigliano</p>";
			$message .= "</body></html>";
			
			wp_mail("mvigliano@libero.it, info@sporthappenings.it", $subject, $message, $headers);
		} else {
			echo "<pre>Query error: ";
			$wpdb->print_error();
			print_r($wpdb->last_error);
			echo "</pre>";
		}
	}
?>
<div class="wintertour_plugin wintertour_shortcode">
	<h3>Registrati online compilando il form</h3>
	<form class="wintertour_register" method="post">
		<input type="hidden" name="wt_nonce" value="<?=wp_create_nonce(wt_nonce)?>" />
		<table style="width:100%;">
			<tbody>
				<tr><td><label for="nome">Nome: </label></td><td><input autocomplete="off" required="required" name="nome" type="text" placeholder="Nome" pattern="\s*(\s*[^\s]\s*){2}[\w\s]{0,33}\s*" /></td></tr>
				<tr><td><label for="cognome">Cognome: </label></td><td><input autocomplete="off" required="required" name="cognome" type="text" placeholder="Cognome" pattern="\s*(\s*[^\s]\s*){2}[\w\s]{0,33}\s*" /></td></tr>
				<tr><td><label for="email">Email: </label></td><td><input autocomplete="off" required="required" name="email" type="email" placeholder="Email" pattern="([a-z0-9!#$%&'*+/=?^_`{|}~-]+(\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|&quot;([\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*&quot;)@(([a-z0-9]([a-z0-9-]*[a-z0-9])?\.)+[a-z0-9]([a-z0-9-]*[a-z0-9])?|\[((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:([\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])" /></td></tr>
				<tr><td><label for="indirizzo">Indirizzo: </label></td><td><input autocomplete="off" required="required" name="indirizzo" type="text" placeholder="Indirizzo e numero civico" pattern="\s*(?=.*\d).{8,63}\s*" /></td></tr>
				<tr><td><label for="cap">CAP: </label></td><td><input autocomplete="off" required="required" name="cap" type="text" placeholder="CAP" pattern="\d{5}" /></td></tr>
				<tr><td><label for="citta">Citt&agrave;: </label></td><td><input autocomplete="off" required="required" name="citta" type="text" placeholder="Citt&agrave;" pattern="\s*(\s*[^\s]\s*){3}[\w\s]{0,61}\s*" /></td></tr>
				<!--<div><input autocomplete="off" required="required" name="provincia" type="text" placeholder="Provincia" pattern="\s*(\s*[^\s]\s*){3}[\w\s]{0,61}\s*" /></div>-->
				<tr><td><label for="provincia">Provincia: </label></td><td><?php
					echo selectProvincia('provincia');
				?></td></tr>
				<tr><td><label for="telefono">Telefono: </label></td><td><input autocomplete="off" required="required" name="telefono" type="tel" placeholder="Telefono" pattern="\s*[.+()/-\s\d]{3,25}\s*" /></td></tr>
				<tr><td><label for="cellulare">Cellulare: </label></td><td><input autocomplete="off" required="required" name="cellulare" type="tel" placeholder="Cellulare" pattern="\s*[.+()/-\s\d]{3,25}\s*" /></td></tr>
				<tr><td><label for="datanascita">Data di Nascita: </label></td><td><input autocomplete="off" required="required" name="datanascita" type="text" placeholder="gg/mm/aaaa" class="date" pattern="\d\d\/\d\d/\d{4}" /></td></tr>
				<tr><td><label for="cittanascita">Citt&agrave; di Nascita: </label></td><td><input autocomplete="off" required="required" name="cittanascita" type="text" placeholder="Citt&agrave; di Nascita" pattern="\s*(\s*[^\s]\s*){2}[\w\s]{0,62}\s*" /></td></tr>
				<tr><td><label for="codicefiscale">Codice Fiscale: </label></td><td><input autocomplete="off" required="required" name="codicefiscale" type="text" placeholder="Codice Fiscale" pattern="[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]" /></td></tr>
			</tbody>
			<tfoot>
				<tr><td colspan="2"><input autocomplete="off" name="wintertour_subscription" type="submit" value="Registrati" /></td/></tr>
			</tfoot>
		</table>
	</form>
</div>
