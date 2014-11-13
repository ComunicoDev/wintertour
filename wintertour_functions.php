<?php
	/**
	 * Gestionale WinterTour - Pagina di amministrazione
	 *
	 * Plugin per gestire i tornei e l'anagrafica e le iscrizioni dei membri
	 * @author Comunico S.r.l. <info@comunico.info>
	 * @version 1.0
	 * @package wintertour
	 */
	error_reporting(0);
	ini_set('display_errors', 0);
	
	global $provincie;
	
	$provincie = array(
		"AG" => "Agrigento",
		"AL" => "Alessandria",
		"AN" => "Ancona",
		"AO" => "Aosta",
		"AP" => "Ascoli Piceno",
		"AQ" => "L'Aquila",
		"AR" => "Arezzo",
		"AT" => "Asti",
		"AV" => "Avellino",
		"BA" => "Bari",
		"BG" => "Bergamo",
		"BI" => "Biella",
		"BL" => "Belluno",
		"BN" => "Benevento",
		"BO" => "Bologna",
		"BR" => "Brindisi",
		"BS" => "Brescia",
		"BT" => "Barletta-Andria-Trani",
		"BZ" => "Bolzano",
		"CA" => "Cagliari",
		"CB" => "Campobasso",
		"CE" => "Caserta",
		"CH" => "Chieti",
		"CI" => "Carbonia-Iglesias",
		"CL" => "Caltanissetta",
		"CN" => "Cuneo",
		"CO" => "Como",
		"CR" => "Cremona",
		"CS" => "Cosenza",
		"CT" => "Catania",
		"CZ" => "Catanzaro",
		"EN" => "Enna",
		"FC" => "Forlì-Cesena",
		"FE" => "Ferrara",
		"FG" => "Foggia",
		"FI" => "Firenze",
		"FM" => "Fermo",
		"FR" => "Frosinone",
		"GE" => "Genova",
		"GO" => "Gorizia",
		"GR" => "Grosseto",
		"IM" => "Imperia",
		"IS" => "Isernia",
		"KR" => "Crotone",
		"LC" => "Lecco",
		"LE" => "Lecce",
		"LI" => "Livorno",
		"LO" => "Lodi",
		"LT" => "Latina",
		"LU" => "Lucca",
		"MB" => "Monza e Brianza",
		"MC" => "Macerata",
		"ME" => "Messina",
		"MI" => "Milano",
		"MN" => "Mantova",
		"MO" => "Modena",
		"MS" => "Massa e Carrara",
		"MT" => "Matera",
		"NA" => "Napoli",
		"NO" => "Novara",
		"NU" => "Nuoro",
		"OG" => "Ogliastra",
		"OR" => "Oristano",
		"OT" => "Olbia-Tempio",
		"PA" => "Palermo",
		"PC" => "Piacenza",
		"PD" => "Padova",
		"PE" => "Pescara",
		"PG" => "Perugia",
		"PI" => "Pisa",
		"PN" => "Pordenone",
		"PO" => "Prato",
		"PR" => "Parma",
		"PT" => "Pistoia",
		"PU" => "Pesaro e Urbino",
		"PV" => "Pavia",
		"PZ" => "Potenza",
		"RA" => "Ravenna",
		"RC" => "Reggio Calabria",
		"RE" => "Reggio Emilia",
		"RG" => "Ragusa",
		"RI" => "Rieti",
		"RM" => "Roma",
		"RN" => "Rimini",
		"RO" => "Rovigo",
		"SA" => "Salerno",
		"SI" => "Siena",
		"SO" => "Sondrio",
		"SP" => "La Spezia",
		"SR" => "Siracusa",
		"SS" => "Sassari",
		"SV" => "Savona",
		"TA" => "Taranto",
		"TE" => "Teramo",
		"TN" => "Trento",
		"TO" => "Torino",
		"TP" => "Trapani",
		"TR" => "Terni",
		"TS" => "Trieste",
		"TV" => "Treviso",
		"UD" => "Udine",
		"VA" => "Varese",
		"VB" => "Verbano-Cusio-Ossola",
		"VC" => "Vercelli",
		"VE" => "Venezia",
		"VI" => "Vicenza",
		"VR" => "Verona",
		"VS" => "Medio Campidano",
		"VT" => "Viterbo",
		"VV" => "Vibo Valentia"
	);
	
	function capital($string = "") {
	    return ucfirst(strtolower($string));
	}
	
	function capitalize($string = "") {
	    if(!empty($string)) {
	        $arr = explode($string, " ");
	        
	        foreach($arr as $s) {
	            $s = ucfirst(strtolower($s));
	        }
            
            $string = implode(" ", $arr);
	    }
	    
        return $string;
	}
	
	function wintertour_addTipologiaSoci() {
		global $wpdb;
		
		$wpdb->insert(
			"wintertourtennis_tipologie_soci", 
			array( 
				"nome" => capital($_POST['nometipologia']),
				"descrizione" => capital($_POST['descrizionetipologia'])
			)
		) or die('Errore: Impossibile effettuare l\'operazione richiesta!<br /> Controllare i dati e riprovare.');
	}
	
	function wintertour_addSocio() {
		global $wpdb;
		
		$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		if (!mysqli_connect_errno()) {
			$sql = $wpdb->prepare(
				"INSERT INTO `wintertourtennis_soci`(`nome`, `cognome`, `email`, `tipologia`, `saldo`, `indirizzo`, `citta`, `cap`, `provincia`, `telefono`, `cellulare`, `statoattivo`, `datanascita`, `cittanascita`, `dataiscrizione`, `codicefiscale`, `dataimmissione`, `certificatomedico`, `domandaassociazione`" .
					((intval($_POST['circolo']) > 0) ? ", `circolo`" : "") .
					") VALUES (%s, %s, %s, %d, %f, %s, %s, %s, %s, %s, %s, %d, %s, %s, %s, %s, %s, %d, %s" .
					((intval($_POST['circolo']) > 0) ? ", %d" : "") .
					");",
				
				capitalize(trim($_POST['nome'])),
				capitalize(trim($_POST['cognome'])),
				strtolower(trim($_POST['email'])),
				capital(trim($_POST['tipologia'])),
				trim($_POST['saldo']),
				capitalize(trim($_POST['indirizzo'])),
				capitalize(trim($_POST['citta'])),
				trim($_POST['cap']),
				capitalize(trim($_POST['provincia'])),
				trim($_POST['telefono']),
				trim($_POST['cellulare']),
				trim($_POST['statoattivo']),
				wintertour_serverdate(trim($_POST['datanascita'])),
				capitalize(trim($_POST['cittanascita'])),
				wintertour_serverdatetime(trim($_POST['dataiscrizione'])),
				strtoupper(trim($_POST['codicefiscale'])),
				wintertour_serverdatetime(trim($_POST['dataimmissione'])),
				trim($_POST['certificatomedico']),
				trim($_POST['domandaassociazione']),
				trim($_POST['circolo'])
			);
			
			$sql .= $wpdb->prepare(
				"\nINSERT IGNORE INTO `wintertourtennis_tessere`(`numerotessera`, `socio`) VALUES (%s, LAST_INSERT_ID());",
				$_POST['numerotessera']
			);
			
			$check = mysqli_multi_query($con, $sql);
			
			if(!$check) {
				echo "<pre>Query error: " . mysqli_error($con) . "</pre>";
			}
		} else {
			echo "<pre>Connection error: " . mysqli_connect_error($con) ."</pre>";
		}
		
		mysqli_close($con);
	}
	
	function wintertour_get_tipologia_soci($id) {
		global $wpdb;
		
		if(is_numeric($id)) {
			$sql = "SELECT * FROM `wintertourtennis_tipologie_soci` WHERE `ID` = " . $id . ";";
			
			return $wpdb->get_row($sql);
		}
	}
	
	function wintertour_get_socio($id) {
		global $wpdb;
		
		if(is_numeric($id)) {
			$sql = "SELECT * FROM `wintertourtennis_soci` WHERE `ID` = $id;";
			
			return $wpdb->get_row($sql);
		}
	}
	
	function wintertour_edit_socio($id, $args) {
		global $wpdb;
		
		if(wp_verify_nonce($_POST['wt_nonce'], 'wt_nonce')) {
			return $wpdb->update(
				'wintertourtennis_soci',
				array(
					'ID' => $args['ID'],
					'nome' => $args['nome'],
					'cognome' => $args['cognome'],
					'email' => $args['email'],
					'tipologia' => $args['tipologia'],
					'saldo' => $args['saldo'],
					'indirizzo' => $args['indirizzo'],
					'citta' => $args['citta'],
					'cap' => $args['cap'],
					'provincia' => $args['provincia'],
					'telefono' => $args['telefono'],
					'cellulare' => $args['cellulare'],
					'statoattivo' => $args['statoattivo'],
					'datanascita' => wintertour_serverdate($args['datanascita']),
					'cittanascita' => $args['cittanascita'],
					'dataiscrizione' => wintertour_serverdatetime($args['dataiscrizione']),
					'codicefiscale' => $args['codicefiscale'],
					'dataimmissione' => wintertour_serverdatetime($args['dataimmissione']),
					'certificatomedico' => $args['certificatomedico'],
					'domandaassociazione' => $args['domandaassociazione'],
					'circolo' => $args['circolo']
				),
				array('ID' => $id),
				array(
					'%d',
					'%s',
					'%s',
					'%s',
					'%d',
					'%f',
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
					'%s',
					'%s',
					'%d',
					'%s',
					'%d'
				),
				array('%d')
			);
		}
	}
	
	function wintertour_edit_tipologia_soci($id, $new_id, $nome, $descrizione) {
		if(is_numeric($id) && is_numeric($new_id) && is_string($nome) && is_string($descrizione) && !empty($nome) && !empty($descrizione)) {
			global $wpdb;
			
			if(wp_verify_nonce($_POST['wt_nonce'], 'wt_nonce')) {
				return $wpdb->update(
					'wintertourtennis_tipologie_soci',
					array(
						'ID' => $new_id,
						'nome' => $nome,
						'descrizione' => $descrizione
					),
					array('ID' => $id),
					array(
						'%d',
						'%s',
						'%s'
					),
					array('%d')
				);
			}
		}
	}
	
	function wintertour_get_autocomplete() {
		global $wpdb;
		
		wp_verify_nonce($_POST['wt_nonce'], 'wt_nonce') or die(0);
		
		if(empty($_POST['partial']) || empty($_POST['type'])) {
			die(0);
		}
		
		if($_POST['type'] == 'soci') {
			$sql = "SELECT `ID`, `nome`, `cognome` FROM `wintertourtennis_soci` WHERE `nome` LIKE '" . $_POST['partial'] . "%' OR `cognome` LIKE '" . $_POST['partial'] . "%';";
			
			echo json_encode($wpdb->get_results($sql));
		} else if($_POST['type'] == 'tipologie_soci') {
			$sql = "SELECT `ID`, `nome` FROM `wintertourtennis_tipologie_soci` WHERE `nome` LIKE '" . $_POST['partial'] . "%';";
			
			echo json_encode($wpdb->get_results($sql));
		} else {
			die(0);
		}
	}
	
	function wintertour_addCircolo() {
		global $wpdb;
		
		$wpdb->insert(
			"wintertourtennis_circoli",
			array(
				"nome" => $_POST['nomecircolo'],
				"indirizzo" => $_POST['indirizzocircolo'],
				"citta" => $_POST['cittacircolo'],
				"cap" => $_POST['capcircolo'],
				"provincia" => $_POST['provinciacircolo'],
				"referente" => $_POST['referentecircolo']
			)
		) or die('Errore: Impossibile effettuare l\'operazione richiesta!<br /> Controllare i dati e riprovare.');
	}
	
	function wintertour_elencaSoci() {
		global $wpdb;
		
		$sql = "SELECT * FROM `wintertourtennis_soci`;";
		
		return $wpdb->get_results($sql);
	}
	
	function wintertour_elencatipi() {
		global $wpdb;
		
		$query = "SELECT * FROM `wintertourtennis_tipologie_soci`;";
		return $wpdb->get_results($query);
	}
	
	function wintertour_elencacircoli() {
		global $wpdb;
		
		return $wpdb->get_results("SELECT * FROM `wintertourtennis_circoli`;");
	}
    
    function wintertour_serverdate($date) {
        
        $gg = "";
        $mm = "";
        $aaaa = "";
        
        sscanf($date, "%02d/%02d/%04d", $gg, $mm, $aaaa);
        
        return sprintf("%04d-%02d-%02d", $aaaa, $mm, $gg);
        
        /*
        
        $arr = explode('/', $date);
        
        $stamp = mktime(0, 0, 0, $arr[1], $arr[0], $arr[2]);
        
        return date($stamp, "Y-m-d");
        
        */
    }
    
    function wintertour_serverdatetime($datetime) {
        
        $gg = "";
        $mm = "";
        $aaaa = "";
        
        $hh = "";
        $mm = "";
        
        sscanf($date, "%02d/%02d/%04d - %02s:%04s", $gg, $mm, $aaaa, $hh, $mm);
        
        return sprintf("%04d-%02d-%02d %02s:%02s:00", $aaaa, $mm, $gg, $hh, $mm);
        
        /*
        
        $div = explode(' - ', $datetime);
        
        $arr1 = explode('/', $div[0]);
        $arr2 = explode(':', $div[1]);
        
        $stamp = mktime($arr2[0], $arr2[1], 0, $arr1[1], $arr1[0], $arr1[2]);
        
        return date($stamp, "Y-m-d H:i:s");
        
        */
    }
	
	function wintertour_localdate($date) {
	    
        $gg = "";
        $mm = "";
        $aaaa = "";
        
        sscanf($date, "%04d-%02d-%02d", $aaaa, $mm, $gg);
        
        return sprintf("%02d/%02d/%04d", $gg, $mm, $aaaa);
	    
        /*
        
		$arr = explode('-', $date);
        
        $stamp = mktime(0, 0, 0, $date[2], $date[1], $date[0]);
        
        return date($stamp, "d/m/Y");
        
        */
	}
	
	function wintertour_localdatetime($datetime) {
        
        $gg = "";
        $mm = "";
        $aaaa = "";
        
        $hh = "";
        $mm = "";
        
        sscanf($date, "%04d-%02d-%02d %02s:%02s:00", $aaaa, $mm, $gg, $hh, $mm);
        
        return sprintf("%02d/%02d/%04d - %02s:%04s", $gg, $mm, $aaaa, $hh, $mm);
	    
        /*
        
        $div = explode(' ', $datetime);
        
        $arr1 = explode('-', $div[0]);
        $arr2 = explode(':', $div[1]);
        
        $stamp = mktime($arr2[0], $arr2[1], 0, $arr1[2], $arr1[1], $arr1[0]);
        
        return date($stamp, "d/m/Y - H:i");
        
        */
	}
	
	function countObj($ogg) {
		$i = 0;
		
		foreach($ogg as $key => $value) {
			$i++;
		}
		
		return $i;
	}
	
	function selectProvincia($attr, $selected) {
		global $provincie;
		
		$sel = "<select required=\"required\" name=\"$attr\" id=\"$attr\">";
		$sel .= "<option disabled=\"disabled\"" . (empty($selected) ? " selected=\"selected\"" : "") . ">--Selezionare una provincia--</option>";
		foreach ($provincie as $code => $name) {
			$sel .= "<option " . ((strtolower($code) == strtolower($selected)) ? 'selected="selected"' : "") . " value=\"$code\">";
			$sel .= "$name ($code)";
			$sel .= "</option>";
		}
		$sel .= "</select>";
		
		return $sel;
	}
?>