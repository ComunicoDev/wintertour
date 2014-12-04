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
    
    function newToken() {
        return substr(base64_encode(openssl_random_pseudo_bytes(16)), 0, 22);
    }
    
    function getURL() {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        
        return $pageURL;
    }
    
    function get_baseURL() {
        $baseURL = "";
        $pageURL = getURL();
        
        $pos = strpos($pageURL, "?");
        
        if($pos !== FALSE && $pos >=0) {
            $baseURL = substr($pageURL, 0, $pos);
        } else {
            $baseURL = $pageURL;
        }
        
        return $baseURL;
    }
    
    function getQuerystring() {
        $querystring = "";
        $pageURL = getURL();
        
        $pos = strpos($pageURL, "?");
        
        if($pos !== FALSE && $pos >=0) {
            $querystring = substr($pageURL, $pos + 1);
        }
        
        return $querystring;
    }
    
    function getVerificationLink($id = "", $token) {
        $verificationURL = "";
        
        $baseURL = get_baseURL();
        $pageURL = getURL();
        $querystring = getQuerystring();
        
        if(!empty($querystring)) {
            $arr = explode("&", $querystring);
            
            for($i = 0; $i <= sizeof($arr); $i++) {
                $pos2 = strpos($arr[$i], "verifyemail");
                $pos3 = strpos($arr[$i], "token");
                
                if(($pos2 !== FALSE && $pos2 >=0) || ($pos3 !== FALSE && $pos3 >=0)) {
                    unset($arr[$i]);
                }
            }
            
            $querystring = implode("&", $arr);
            if($querystring[0] === '&') {
                $querystring = substr($querystring, 1);
            }
        }
        
        $verificationURL = $baseURL;
        
        if(empty($querystring)) {
            $verificationURL .= "?";
        } else {
            $verificationURL .= "?" . $querystring . "&";
        }
        
        $verificationURL .= "verifyemail=". urlencode($id) . "&token=" . urlencode($token);
        
        return $verificationURL;
    }
    
	wp_enqueue_style('wintertour_style');
    wp_enqueue_style('datetimepicker');
    wp_enqueue_script('datetimepicker');
    wp_enqueue_script('wintertourform');
    
    add_filter( 'wp_mail_content_type', 'set_html_content_type' );
    
    function set_html_content_type() {
        return 'text/html';
    }
	
?>
<?php
    if(isset($_POST['wintertour_upload'])) {
        if(isset($_FILES['file'])) {
            $dir = wp_upload_dir();
            $path = $dir['path'] . '/' . $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], $path);
            
            $socio = wintertour_get_socio($_POST['ID']);
            wintertour_activate_certificato($socio->ID);
            
            $headers = "Content-type: text/html" . "\r\n";
            $headers .= "From: SportHappenings <info@sporthappenings.it>" . "\r\n";
            $subject = "Un utente ha inviato il suo certificato medico";
            
            $message = "<!doctype html><html><head><title>$subject</title></head><body>";
            $message .= "Un utente ha inviato il suo certificato metico. Vedi allegato";
            
            $message .= "</body></html>";
            
            if(@wp_mail("SportHappenings <info@sporthappenings.it>", $subject, $message, $headers, $path)) {
                echo "Operazione eseguita con successo!";
            } else {
                echo "Operazione fallita";
            }
            
            $headers = "Content-type: text/html" . "\r\n";
            $headers .= "From: SportHappenings <info@sporthappenings.it>" . "\r\n";
            $subject = "Grazie per esserti iscritto a SportHappenings";
            
            $message = "<!doctype html><html><head><title>$subject</title></head><body>";
            $message .= "Gentile utente,<br /><br />grazie per aver sottoscritto l'associazione con l'ASD SportHappenings per l'anno 2014/15.<br />Siamo lieti di averti nel nostro team.<br /><br />Riceverai la nuova tessera associativa al più presto.Ti ricordiamo che dovrai versare la quota sociale di 18€ entro pochi giorni affinchè il tesseramento sia valido.<br />Di seguito gli estremi per effettuare il bonifico:<br /><br /><b>IT 55 J 02008 01117 000102693072UNICREDIT Agenzia di corso Moncalieri Torino</b><br />conto intestato all'ASD SPORT HAPPENINGS<br /><br />Grazie e buon divertimento con SportHappenings!<br /><br /><br />ADS  <a href=\"http://www.sporthappenings.it/\">Sport Happenings</a><br />Corso Moncalieri, 506/35, Torino, 10133<br />T: +39 366 415 4022<br />F: +39 011 070 1672<br />Email: <a href=\"mailto:info@sporthappenings.it\">info@sporthappenings.it</a>";
            
            $message .= "</body></html>";
            
            wp_mail($socio->email, $subject, $message, $headers);
            
            unlink($path);
        }
?>
<?php
    } else if(isset($_REQUEST['verifyemail']) && isset($_REQUEST['token'])) {
        $socio = wintertour_get_socio($_REQUEST['verifyemail']);
        
        if($socio != null) {
            $token = md5($_REQUEST['token']);
            
            if($socio->token === $token) {
                wintertour_activate_socio($socio->ID);
                echo "Operazione eseguita con successo. L'utente è stato verificato<br /><br />Carica ora il tuo certificato medico, oppure inviacelo più tardi tramite email a <a href=\"mailto:info@sporthappenings.it\">info@sporthappenings.it</a>";
                
                $nome = $socio->nome;
                $cognome = $socio->cognome;
                $email = $socio->email;
                $cittanascita = $socio->cittanascita;
                $datanascita = wintertour_localdate($socio->datanascita);
                $codicefiscale = $socio->codicefiscale;
                $citta = $socio->citta;
                $cap = $socio->cap;
                $indirizzo = $socio->indirizzo;
                $telefono = $socio->telefono;
                $cellulare = $socio->cellulare;
                
                $headers = "Content-type: text/html" . "\r\n";
                $headers .= "From: $nome $cognome <$email>" . "\r\n";
                $subject = "Iscrizione di $nome $cognome a SportHappenings";
                
                $message = "<!doctype html><html><head><title>$subject</title></head><body>";
                $message .= "È pervenuta una nuova iscrizione sul sito <a href=\"http://www.sporthappenings.it/wintertourtennis/\">WinterTour Tennis</a><p><b>Il sottoscritto</b></p><p>Nome: $nome</p><p>Cognome: $cognome</p><p>Nato a: $cittanascita</p><p>Nato il: $datanascita</p><p>Codice fiscale: $codicefiscale</p><p>Residente in: $citta</p><p>CAP: $cap</p><p>Indirizzo: $indirizzo</p><p>Numero di Telefono: $telefono</p><p>Numero di Cellulare: $cellulare</p><p>La tua email: $email</p><p><b>Richiede la tessera socio all'A.S.D. Sport Happenings</b></p><p><b>Informativa ai sensi art. 13 D.lgs.196/03</b><br /><br />La presente per informarvi che presso la nostra società viene effettuato il trattamento dei Vs. dati personali nel pieno rispetto del DecretoLegislativo196/03.<br />I dati sono inseriti nelle banche dati della nostra società in seguito all'acquisizione del Vs. consenso salvo i casi in cui all'art.24 D. Lgs. 196/03. In base a<br />tale normativa il trattamento sarà improntato ai principi di correttezza, liceità,e trasparenza e di tutela della Sua riservatezza e dei Suoi diritti. Ai sensi<br />dell'art. 13 la informiamo che i dati sono raccolti al fine di obblighi contrattuali, adempimenti contabili e fiscali ed il trattamento avviene con le modalità<br />manuale e informatizzata.<br />-Il conferimento dei dati ha natura obbligatoria. In caso di rifiuto di conferire i dati le conseguenze saranno di mancata o parziale esecuzione del contratto<br />-I suoi dati non saranno comunicati ad altri soggetti, né saranno oggetto di diffusione fatta eccezione per gli studi professionali preposti alla consulenza<br />contabile e finanziaria della nostra società in quanto trattasi di soggetti responsabili ed incaricati del trattamento<br />-Al titolare ed al responsabile del trattamento Lei potrà rivolgersi per far valere i suoi diritti così come previsti dall'art. 7 del D.Lgs. 196/03, cioè la conferma<br />dell'esistenza o meno dei dati che la riguardano; la cancellazione , la trasformazione in forma anonima ed il blocco dei dati trattati in violazione di legge;<br />l'aggiornamento, la rettificazione ovvero l'integrazione dei dati; l'attestazione che le operazioni descritte sono state portate a conoscenza di coloro ai quali i<br />dati sono stati comunicati o diffusi<br />-Il Responsabile del trattamento anche ai sensi dell'art.7 D.Lgs: 196/03 è la sig.ra Margherita Vigliano</p>";
                $message .= "</body></html>";
                
                wp_mail(array("info@sporthappenings.it"), $subject, $message, $headers);
?>
    <div class="wintertour_plugin wintertour_shortcode">
        <h3>Carica certificato</h3>
        <form class="wintertour_register" method="post" enctype="multipart/form-data">
            <input type="hidden" name="wt_nonce" value="<?=wp_create_nonce(wt_nonce)?>" />
            <input type="hidden" name="ID" value="<?=$socio->ID?>" />
            <table style="width:100%;">
                <tbody>
                    <tr>
                        <td style="min-width: 370px !important;">
                            <label for="file">Scegli il file (PNG, JPEG, PDF, BMP, GIF) max 4MB:</label>
                        </td>
                        <td>
                            <input name="file" type="file" accept=".gif,.jpg,.jpeg,.png,.bmp,.pdf,.bm" />
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr><td colspan="2"><input autocomplete="off" name="wintertour_upload" type="submit" value="Upload" /></td/></tr>
                </tfoot>
            </table>
        </form>
    </div>
<?php
            } else {
                echo "Errore. Impossibile completare l'operazione";
            }
        }
    } else {
?>
<?php
    if (isset($_POST) && !empty($_POST['nome']) && !empty($_POST['cognome']) && !empty($_POST['email']) &&
        !empty($_POST['indirizzo']) && !empty($_POST['cap']) && !empty($_POST['citta']) && !empty($_POST['provincia']) &&
        !empty($_POST['telefono']) && !empty($_POST['cellulare']) && !empty($_POST['datanascita']) &&
        !empty($_POST['cittanascita']) && !empty($_POST['codicefiscale'])) {
        
        $nome = capitalize(trim($_POST['nome']));
        $cognome = capitalize(trim($_POST['cognome']));
        $email = strtolower(trim($_POST['email']));
        $indirizzo = capitalize(trim($_POST['indirizzo']));
        $cap = trim($_POST['cap']);
        $citta = capitalize(trim($_POST['citta']));
        $provincia = strtoupper(trim($_POST['provincia']));
        $telefono = trim($_POST['telefono']);
        $cellulare = trim($_POST['cellulare']);
        $datanascita = wintertour_serverdate(trim($_POST['datanascita']));
        $cittanascita = capitalize(trim($_POST['cittanascita']));
        $codicefiscale = strtoupper(trim($_POST['codicefiscale']));
        $sesso = strtoupper(trim($_POST['sesso']));
        
        $token = newToken();
        
        global $wpdb;
        
        $check = $wpdb->insert(
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
                'datanascita' => $datanascita,
                'cittanascita' => $cittanascita,
                'codicefiscale' => $codicefiscale,
                'certificatomedico' => 0,
                'sesso' => $sesso,
                'token' => md5($token)
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
                '%s',
                '%d',
                '%s'
            )
        );
        $lastid = $wpdb->insert_id;
        
        if($check) {
            
            $verificationURL = getVerificationLink($lastid, $token);
            
            $headers = "Content-type: text/html" . "\r\n";
            $headers .= "From: SportHappenings <info@sporthappenings.it>" . "\r\n";
            $subject = "La tua iscrizione a SportHappenings è quasi completa";
            
            $message = "<!doctype html><html><head><title>$subject</title></head><body>";
            $message = "Gentile utente,<br /><br />";
            $message .= "La sua registrazione è quasi completa. Per verificare il suo indirizzo email clicchi il seguente link, oppure copi e incolli l'indirizzo nel suo browser e prema invio per confermare:<br />";
            $message .= "<a href=\"$verificationURL\" target=\"_blank\">$verificationURL</a>";
            
            //$message .= "Gentile utente,<br /><br />grazie per aver sottoscritto l'associazione con l'ASD SportHappenings per l'anno 2014/15.<br />Siamo lieti di averti nel nostro team.<br /><br />Riceverai la nuova tessera associativa al più presto.Ti ricordiamo che dovrai versare la quota sociale di 18€ entro pochi giorni affinchè il tesseramento sia valido.<br />Di seguito gli estremi per effettuare il bonifico:<br /><br /><b>IT 55 J 02008 01117 000102693072UNICREDIT Agenzia di corso Moncalieri Torino</b><br />conto intestato all'ASD SPORT HAPPENINGS<br /><br />Grazie e buon divertimento con SportHappenings!<br /><br /><br />ADS  <a href=\"http://www.sporthappenings.it/\">Sport Happenings</a><br />Corso Moncalieri, 506/35, Torino, 10133<br />T: +39 366 415 4022<br />F: +39 011 070 1672<br />Email: <a href=\"mailto:info@sporthappenings.it\">info@sporthappenings.it</a>";
            
            $message .= "</body></html>";
            
            if(@wp_mail($email, $subject, $message, $headers)) {
                echo "Operazione eseguita con successo! <br />Per verificare l'email clicchi il link che riceverà a breve al suo indirizzo di posta.";
            } else {
                echo "Operazione fallita";
            }
            
            /*
            $headers = "Content-type: text/html" . "\r\n";
            $headers .= "From: $nome $cognome <$email>" . "\r\n";
            $subject = "Iscrizione di $nome $cognome a SportHappenings";
            
            $message = "<!doctype html><html><head><title>$subject</title></head><body>";
            $message .= "È pervenuta una nuova iscrizione sul sito <a href=\"http://www.sporthappenings.it/wintertourtennis/\">WinterTour Tennis</a><p><b>Il sottoscritto</b></p><p>Nome: $nome</p><p>Cognome: $cognome</p><p>Nato a: $cittanascita</p><p>Nato il: $datanascita</p><p>Codice fiscale: $codicefiscale</p><p>Residente in: $citta</p><p>CAP: $cap</p><p>Indirizzo: $indirizzo</p><p>Numero di Telefono: $telefono</p><p>Numero di Cellulare: $cellulare</p><p>La tua email: $email</p><p><b>Richiede la tessera socio all'A.S.D. Sport Happenings</b></p><p><b>Informativa ai sensi art. 13 D.lgs.196/03</b><br /><br />La presente per informarvi che presso la nostra società viene effettuato il trattamento dei Vs. dati personali nel pieno rispetto del DecretoLegislativo196/03.<br />I dati sono inseriti nelle banche dati della nostra società in seguito all'acquisizione del Vs. consenso salvo i casi in cui all'art.24 D. Lgs. 196/03. In base a<br />tale normativa il trattamento sarà improntato ai principi di correttezza, liceità,e trasparenza e di tutela della Sua riservatezza e dei Suoi diritti. Ai sensi<br />dell'art. 13 la informiamo che i dati sono raccolti al fine di obblighi contrattuali, adempimenti contabili e fiscali ed il trattamento avviene con le modalità<br />manuale e informatizzata.<br />-Il conferimento dei dati ha natura obbligatoria. In caso di rifiuto di conferire i dati le conseguenze saranno di mancata o parziale esecuzione del contratto<br />-I suoi dati non saranno comunicati ad altri soggetti, né saranno oggetto di diffusione fatta eccezione per gli studi professionali preposti alla consulenza<br />contabile e finanziaria della nostra società in quanto trattasi di soggetti responsabili ed incaricati del trattamento<br />-Al titolare ed al responsabile del trattamento Lei potrà rivolgersi per far valere i suoi diritti così come previsti dall'art. 7 del D.Lgs. 196/03, cioè la conferma<br />dell'esistenza o meno dei dati che la riguardano; la cancellazione , la trasformazione in forma anonima ed il blocco dei dati trattati in violazione di legge;<br />l'aggiornamento, la rettificazione ovvero l'integrazione dei dati; l'attestazione che le operazioni descritte sono state portate a conoscenza di coloro ai quali i<br />dati sono stati comunicati o diffusi<br />-Il Responsabile del trattamento anche ai sensi dell'art.7 D.Lgs: 196/03 è la sig.ra Margherita Vigliano</p>";
            $message .= "</body></html>";
            
            wp_mail(array("mvigliano@libero.it", "info@sporthappenings.it"), $subject, $message, $headers);
            */
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
                <tr>
                    <td>
                        <label for="sesso">Sesso:</label>
                    </td>
                    <td>
                        <span class="choice"><input autocomplete="off" name="sesso" id="sessoM" type="radio" value="M" class="myradio" />Maschile</span><span class="choice"><input autocomplete="off" name="sesso" id="sessoF" type="radio" value="F" class="myradio" />Femminile</span>
                    </td>
                </tr>
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
<?php }
    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
 ?>
