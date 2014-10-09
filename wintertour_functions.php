<?php
	/**
	 * Gestionale WinterTour - Pagina di amministrazione
	 *
	 * Plugin per gestire i tornei e l'anagrafica e le iscrizioni dei membri
	 * @author Comunico S.r.l. <info@comunico.info>
	 * @version 1.0
	 * @package wintertour
	 */
	
	global $provincie;
	
	$provincie = array(
		"AG" => "Agrigento",
		"AL" => "Alessandria",
		"AN" => "Ancona",
		"AO" => "Aosta",
		"AR" => "Arezzo",
		"AP" => "Ascoli Piceno",
		"AT" => "Asti",
		"AV" => "Avellino",
		"BA" => "Bari",
		"BT" => "Barletta-Andria-Trani",
		"BL" => "Belluno",
		"BN" => "Benevento",
		"BG" => "Bergamo",
		"BI" => "Biella",
		"BO" => "Bologna",
		"BZ" => "Bolzano",
		"BS" => "Brescia",
		"BR" => "Brindisi",
		"CA" => "Cagliari",
		"CL" => "Caltanissetta",
		"CB" => "Campobasso",
		"CI" => "Carbonia-Iglesias",
		"CE" => "Caserta",
		"CT" => "Catania",
		"CZ" => "Catanzaro",
		"CH" => "Chieti",
		"CO" => "Como",
		"CS" => "Cosenza",
		"CR" => "Cremona",
		"KR" => "Crotone",
		"CN" => "Cuneo",
		"EN" => "Enna",
		"FM" => "Fermo",
		"FE" => "Ferrara",
		"FI" => "Firenze",
		"FG" => "Foggia",
		"FC" => "Forlì-Cesena",
		"FR" => "Frosinone",
		"GE" => "Genova",
		"GO" => "Gorizia",
		"GR" => "Grosseto",
		"IM" => "Imperia",
		"IS" => "Isernia",
		"SP" => "La Spezia",
		"AQ" => "L'Aquila",
		"LT" => "Latina",
		"LE" => "Lecce",
		"LC" => "Lecco",
		"LI" => "Livorno",
		"LO" => "Lodi",
		"LU" => "Lucca",
		"MC" => "Macerata",
		"MN" => "Mantova",
		"MS" => "Massa e Carrara",
		"MT" => "Matera",
		"VS" => "",
		"ME" => "Messina",
		"MI" => "Milano",
		"MO" => "Modena",
		"MB" => "Monza e Brianza",
		"NA" => "Napoli",
		"NO" => "Novara",
		"NU" => "Nuoro",
		"OG" => "Ogliastra",
		"OT" => "Olbia-Tempio",
		"OR" => "Oristano",
		"PD" => "Padova",
		"PA" => "Palermo",
		"PR" => "Parma",
		"PV" => "Pavia",
		"PG" => "Perugia",
		"PU" => "Pesaro e Urbino",
		"PE" => "Pescara",
		"PC" => "Piacenza",
		"PI" => "Pisa",
		"PT" => "Pistoia",
		"PN" => "Pordenone",
		"PZ" => "Potenza",
		"PO" => "Prato",
		"RG" => "Ragusa",
		"RA" => "Ravenna",
		"RC" => "Reggio Calabria",
		"RE" => "Reggio Emilia",
		"RI" => "Rieti",
		"RN" => "Rimini",
		"RM" => "Roma",
		"RO" => "Rovigo",
		"SA" => "Salerno",
		"SS" => "Sassari",
		"SV" => "Savona",
		"SI" => "Siena",
		"SR" => "Siracusa",
		"SO" => "Sondrio",
		"TA" => "Taranto",
		"TE" => "Teramo",
		"TR" => "Terni",
		"TO" => "Torino",
		"TP" => "Trapani",
		"TN" => "Trento",
		"TV" => "Treviso",
		"TS" => "Trieste",
		"UD" => "Udine",
		"VA" => "Varese",
		"VE" => "Venezia",
		"VB" => "Verbano-Cusio-Ossola",
		"VC" => "Vercelli",
		"VR" => "Verona",
		"VV" => "Vibo Valentia",
		"VI" => "Vicenza",
		"VT" => "Viterbo"
	);
	
	function wintertour_addTipologiaSoci() {
		global $wpdb;
		
		$wpdb->insert(
			"wintertourtennis_tipologie_soci", 
			array( 
				"nome" => $_POST['nometipologia'],
				"descrizione" => $_POST['descrizionetipologia']
			)
		) or die('Errore: Impossibile effettuare l\'operazione richiesta!<br /> Controllare i dati e riprovare.');
	}
	
	function wintertour_addSocio() {
		global $wpdb;
		
		$wpdb->insert(
			"wintertourtennis_soci", 
			array( 
				"nome" => $_POST['nome'],
				"cognome" => $_POST['cognome'],
				"email" => $_POST['email'],
				"tipologia" => $_POST['tipologia'],
				"saldo" => $_POST['saldo'],
				"indirizzo" => $_POST['indirizzo'],
				"citta" => $_POST['citta'],
				"cap" => $_POST['cap'],
				"provincia" => $_POST['provincia'],
				"telefono" => $_POST['telefono'],
				"cellulare" => $_POST['cellulare'],
				"statoattivo" => $_POST['statoattivo'],
				"datanascita" => $_POST['datanascita'],
				"cittanascita" => $_POST['cittanascita'],
				"dataiscrizione" => $_POST['dataiscrizione'],
				"codicefiscale" => $_POST['codicefiscale'],
				"dataimmissione" => $_POST['dataimmissione'],
				"numerotessera" => $_POST['numerotessera'],
				"certificatomedico" => $_POST['certificatomedico'],
				"domandaassociazione" => $_POST['domandaassociazione'],
				//"circolo" => $_POST['circolo']
			)
		) or die('Errore: Impossibile effettuare l\'operazione richiesta!<br /> Controllare i dati e riprovare.');
	}
	
	function wintertour_get_tipologia_soci($id) {
		global $wpdb;
		
		if(is_numeric($id)) {
			$sql = "SELECT * FROM `wintertourtennis_tipologie_soci` WHERE `ID` = " . $id . ";";
			
			return $wpdb->get_row($sql);
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
					array( '%d' )
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
	
	function countObj($ogg) {
		$i = 0;
		
		foreach($ogg as $key => $value) {
			$i++;
		}
		
		return $i;
	}
	
	function selectProvincia($attr) {
		global $provincie;
		
		$sel = "<select name=\"$attr\" id=\"$attr\">";
		$sel .= "<option disabled=\"disabled\" selected=\"selected\">--Selezionare una provincia--</option>";
		foreach ($provincie as $code => $name) {
			$sel .= "<option value=\"$code\">";
			$sel .= "$name ($code)";
			$sel .= "</option>";
		}
		$sel .= "</select>";
		
		return $sel;
	}
?>