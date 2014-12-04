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
	
	global $categorie;
	
	$categorie = array(
        0 => "Singolare Maschile A",
        1 =>"Singolare Femminile A",
        2 => "Singolare Maschile B",
        3 => "Singolare Femminile B",
        4 => "Singolare Maschile C",
        5 => "Staffetta Maschile A",
        6 => "Staffetta Femminile A",
        7 => "Staffetta Maschile B",
        8 => "Staffetta Femminile B",
        9 => "Staffetta Mista B",
        10 => "Staffetta Mista B",
        11 => "Staffetta Junior A",
        12 =>"Staffetta Junior B"
	);
    
    function toggleSort() {
        $tmpstr = strtolower(trim($_GET["sort"]));
        
        if(empty($tmpstr) || $tmpstr == "asc") {
            $tmpstr = "desc";
        } else {
            $tmpstr = "asc";
        }
        
        return $tmpstr;
    }
    
    function pagingURL($pag = 1, $count = 0, $limit = 20) {
        $tmpstr = "";
        
        if(!empty($_GET["page"])) {
            $tmpstr .= "admin.php?page=$_GET[page]";
            
            foreach($_GET as $key => $value) {
                if($key != "page" && $key != "pag") {
                    $tmpstr .= "&$key=$value";
                }
            }
            
            $tmpstr = admin_url($tmpstr);
        }
        
        $check = false;
        if($pag > 1) {
            $prev = $pag - 1;
            echo "<a href=\"$tmpstr&pag=$prev\" />Precedenti</a>";
            
            $check = true;
        }
        if(($pag) * $limit < $count) {
            $next = $pag + 1;
            
            if($check) {
                echo " | ";
            }
            
            echo "<a href=\"$tmpstr&pag=$next\" />Successivi</a>";
            
            $check = true;
        }
        
        if($check) {
            echo "<br /><br />";
        }
    }
    
    function toggleUpDown() {
        $tmpstr = strtolower(trim($_GET["sort"]));
        
        if(empty($tmpstr) || $tmpstr == "asc") {
            $tmpstr = "up";
        } else {
            $tmpstr = "down";
        }
        
        return $tmpstr;
    }
    
    function toggleSortURL($type = "") {
        $type = strtolower(trim($type));
        $tmpstr = "";
        
        if(!empty($_GET["page"])) {
            $tmpstr .= "admin.php?page=$_GET[page]";
            
            if(!empty($type) && empty($_GET["order"])) {
                $tmpstr .= "&order=$type";
            }
            
            if(empty($_GET["sort"])) {
                $tmpstr .= "&sort=asc";
            }
            
            foreach($_GET as $key => $value) {
                if($key != "page" && $key != "sort" && $key != 'order') {
                    $tmpstr .= "&$key=$value";
                } else if($key == "sort") {
                    $tmpstr .= "&sort=" . toggleSort();
                } else if($key == "order") {
                    $tmp = ($value === $type) ? $value : $type;
                    
                    $tmpstr .= "&order=$tmp";
                }
            }
            
            return admin_url($tmpstr);
        }
        
        return $tmpstr;
    }
    
    function sortURL($type = "") {
        $type = strtolower(trim($type));
        $tmpstr = "";
        
        if(!empty($_GET["page"])) {
            $tmpstr .= "admin.php?page=$_GET[page]";
            
            if(!empty($type) && empty($_GET["order"])) {
                $tmpstr .= "&order=$type";
            }
            
            if(empty($_GET["sort"])) {
                $tmpstr .= "&sort=asc";
            }
            
            foreach($_GET as $key => $value) {
                if($key != "page" && $key != "sort" && $key != 'order') {
                    $tmpstr .= "&$key=$value";
                } else if($key == "sort") {
                    $tmpstr .= "&sort=asc";
                } else if($key == "order") {
                    $tmp = ($value === $type) ? $value : $type;
                    
                    $tmpstr .= "&order=$tmp";
                }
            }
            
            return admin_url($tmpstr);
        }
        
        return $tmpstr;
    }
    
    function sortArrow($heading = "", $type = "") { ?>
        <th><a href="<?=sortURL($type)?>"><?=$heading?></a> <?php if($type === $_GET['order']) { ?><a class="sortarrow" href="<?=toggleSortURL($type)?>"><img src="<?=plugins_url('images/arrow_' . toggleUpDown() .'.gif', __FILE__ )?>" /></a><?php } ?></th>
    <?php }
    
    function findNumero($partecipanti, $id) {
        foreach($partecipanti as $partecipante) {
            if($id == $partecipante->ID) {
                return $partecipante->n;
            }
        }
    }
    
    function wintertour_risultatiSocioSingolo($id) {
        global $wpdb;
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM `wintertourtennis_risultati` WHERE (`giocatore1` = %d OR `giocatore2` = %d) AND (`giocatore3` IS NULL AND `giocatore4` IS NULL);",
            $id, $id, $id, $id
        ));
    }
    
    function wintertour_risultatiSocioDoppio($id) {
        global $wpdb;
        
        $sql = $wpdb->prepare(
            "SELECT * FROM `wintertourtennis_risultati` WHERE (`giocatore1` = %d OR `giocatore2` = %d OR `giocatore3` = %d OR `giocatore4` = %d) AND `giocatore3` IS NOT NULL AND `giocatore4` IS NOT NULL;",
            $id, $id, $id, $id
        );
        
        return $wpdb->get_results($sql);
    }
    
    function wintertour_getCompagno($giocatore = 0, $risultato = array()) {
        if($risultato->giocatore1 == $giocatore) {
            return wintertour_get_socio($risultato->giocatore3);
        } else {
            return wintertour_get_socio($risultato->giocatore4);
        }
    }
    
    function wintertour_getAvversario($giocatore = 0, $risultato = array()) {
        if($risultato->giocatore1 == $giocatore) {
            return wintertour_get_socio($risultato->giocatore2);
        } else {
            return wintertour_get_socio($risultato->giocatore1);
        }
    }
    
    function wintertour_getAvversari($giocatore = 0, $risultato = array()) {
        if($risultato->giocatore1 == $giocatore || $risultato->giocatore3 == $giocatore) {
            $avversario1 = wintertour_get_socio($risultato->giocatore2);
            $avversario2 = wintertour_get_socio($risultato->giocatore4);
            
            return $avversario1->nome . " " . $avversario1->cognome . " - " . $avversario2->nome . " " . $avversario2->cognome;
        } else {
            $avversario1 = wintertour_get_socio($risultato->giocatore1);
            $avversario2 = wintertour_get_socio($risultato->giocatore3);
            
            return $avversario1->nome . " " . $avversario1->cognome . " - " . $avversario2->nome . " " . $avversario2->cognome;
        }
    }
    
    function wintertourtennis_getRisultatoOrd($giocatore = 0, $risultato = array()) {
        if($risultato->giocatore1 == $giocatore || $risultato->giocatore3 == $giocatore) {
            return $risultato->puntigiocatori1e3 . " - " . $risultato->puntigiocatori2e4;
        } else {
            return $risultato->puntigiocatori2e4 . " - " . $risultato->puntigiocatori1e3;
        }
    }
    
    function wintertour_giocatoContro($partecipanti, $indice, $tappa) {
        global $wpdb;
        
        $risultato = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM `wintertourtennis_risultati` WHERE %d IN (`giocatore1`, `giocatore2`, `giocatore3`, `giocatore4`) AND `turno` = %d",
            $partecipanti[$indice]->ID, $tappa
        ));
        
        if($partecipanti[$indice]->ID == $risultato->giocatore1 || $partecipanti[$indice]->ID == $risultato->giocatore3) { // Primo team
            return findNumero($partecipanti, $risultato->giocatore2) . ((!empty($risultato->giocatore4)) ? "-" . findNumero($partecipanti, $risultato->giocatore4) : "");
        } else if($partecipanti[$indice]->ID == $risultato->giocatore2 || $partecipanti[$indice]->ID == $risultato->giocatore4) { // Secondo team
            return findNumero($partecipanti, $risultato->giocatore1) . ((!empty($risultato->giocatore3)) ? "-" . findNumero($partecipanti, $risultato->giocatore3) : "");
        }
        
        return "-";
    }
    
    function wintertour_tappeIncontri() {
        global $wpdb;
        
        return $wpdb->get_results("SELECT * FROM `wintertourtennis_turni` WHERE `ID` IN (SELECT `turno` FROM `wintertourtennis_risultati`);");
    }
    
    function wintertour_elencaPartecipanti() {
        global $wpdb;
        
        return $wpdb->get_results("SELECT `ID`, `cognome`, `nome`, @row := @row + 1 AS n FROM (SELECT `ID`, `nome`, `cognome` FROM `wintertourtennis_soci` WHERE `ID` IN (SELECT `giocatore1` FROM `wintertourtennis_risultati`) OR `ID` IN (SELECT `giocatore2` FROM `wintertourtennis_risultati`) OR `ID` IN (SELECT `giocatore3` FROM `wintertourtennis_risultati`) OR `ID` IN (SELECT `giocatore4` FROM `wintertourtennis_risultati`) ORDER BY `cognome`) AS t CROSS JOIN (SELECT @row := 0) AS row;");
    }
    
    function wintertour_getCategoria($turnoid) {
        global $wpdb;
        global $categorie;
        
        return $categorie[$wpdb->get_var($wpdb->prepare(
            "SELECT `categoria` FROM `wintertourtennis_turni` WHERE ID = %d",
            $turnoid
        ))];
    }
    
    function wintertour_selectCategorie($args = array(), $selected = -1) {
        global $categorie;
        $select = "<select";
        
        if(!empty($args)) {
            foreach($args as $key => $value) {
                if(!is_numeric($key) && !empty($value)) {
                    $select .= " $key=\"$value\"";
                }
            }
        }
        
        $select .= ">";
        
        $select .= "<option disabled=\"disabled\" selected=\"selected\" value=\"\">--Seleziona categoria--</option>";
        
        foreach($categorie as $index => $value) {
            if(is_numeric($index) && !empty($value)) {
                $select .= "<option value=\"$index\"";
                
                if(is_numeric($selected) && intval($selected, 10) === intval($index, 10)) {
                    $select .= " selected=\"selected\"";
                }
                
                $select .= ">" . $value;
                
                $select .= "</option>";
            }
        }
        
        return $select . "</select>";
    }
    
	function capital($string = "") {
	    return ucfirst(strtolower($string));
	}
	
	function capitalize($string = "") {
	    $string = trim($string);
        
	    if(!empty($string)) {
	        $string = strtolower($string);
	        
	        if(strpos($string, " ") === FALSE) {
                $string = ucfirst($string);
	        } else {
                $arr = explode(" ", $string);
                
                for($i = 0; $i < sizeof($arr); $i++) {
                    $arr[$i] = ucfirst($arr[$i]);
                }
                
                $string = implode(" ", $arr);
	        }
            
            $pos = strpos($string, "’");
            
            if($pos !== FALSE && $pos >= 0) {
                $string = str_replace("’", "'", $string);
            }
	        
            $pos = strpos($string, "'");
            
            if($pos !== FALSE && $pos >= 0) {
                $arr = explode("'", $string);
                
                foreach($arr as &$value) {
                    $value = ucfirst($value);
                }
                
                $string = implode("'", $arr);
            }
            
            $pos = strpos($string, ".");
            
            if($pos !== FALSE && $pos >= 0) {
                $arr = explode("'", $string);
                
                foreach($arr as &$value) {
                    $value = ucfirst($value);
                }
                
                $string = implode(".", $arr);
            }
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
	
    function wintertour_addPunteggio() {
        global $wpdb;
        
        $wpdb->insert(
            "wintertourtennis_punteggi",
            array(
                "punteggio" => trim($_POST['punteggio']),
                "socio" => $_POST['socio'],
                "turno" => $_POST['turno']
            ),
            array(
                "%d",
                "%d",
                "%d"
            )
        ) or die("Errore: Impossibile effettuare l\'operazione richiesta!<br /> Controllare i dati e riprovare.");
    }
    
	function format_date($date = "") {
	    
        if(strstr($date, "/") === FALSE) {
            $date = wintertour_localdate($date);
        }
	    
	    $dd = "";
        $mm = "";
        $aaaa = "";
        
	    sscanf($date, "%02s/%02s/%04s", $dd, $mm, $aaaa);
        
        if($aaaa < 1900) {
            return "Data invalida";
        }
        
        return $date;
	}
    
    function format_datetime($datetime = "") {
        
        if(strstr($datetime, "/") === FALSE) {
            $datetime = wintertour_localdatetime($datetime);
        }
        
        $dd = "";
        $mm = "";
        $aaaa = "";
        
        $hh = "";
        $MM = "";
        
        sscanf($datetime, "%02s/%02s/%04s - %02s:%02s", $dd, $mm, $aaaa, $hh, $MM);
        
        if($aaaa < 1900) {
            return "Data invalida";
        }
        
        return $datetime;
    }
	
	function format_phone($number = "") {
	    $number = str_replace(' ', "", $number);
        $number = str_replace('/', "", $number);
        $number = str_replace('\\', "", $number);
        $number = str_replace('-', "", $number);
        $number = str_replace('.', "", $number);
        $number = str_replace(':', "", $number);
        $number = str_replace(';', "", $number);
        $number = str_replace("'", "", $number);
        
        if(empty($number) || $number === FALSE || !is_numeric($number) || (is_numeric($number) && $number == 0) || strlen($number) < 6) {
            $number = "Numero telefonico invalido";
        }
        
        $pos = strpos($number, "+39");
        
        if($pos !== FALSE && $pos === 0) {
            $number = substr($number, 3);
        }
        
        return $number;
	}
    
    function wintertour_addTurno() {
        global $wpdb;
        
        $wpdb->insert(
            "wintertourtennis_turni",
            array(
                "data" => wintertour_serverdate($_POST['data']),
                "circolo" => $_POST['circolo'],
                "categoria" => $_POST['categoria']
            ), array(
                "%s",
                "%d",
                "%d"
            )
        ) or die();
    }
    
    function wintertour_addRisultato($values = array()) {
        global $wpdb;
        
        $sql = "INSERT INTO `wintertourtennis_risultati`(`giocatore1`, `giocatore2`" .
            ((isset($values['giocatore3']) && isset($values['giocatore4'])) ? ", `giocatore3`, `giocatore4`" : "") .
            ", `puntigiocatori1e3`, `puntigiocatori2e4`, `turno`) VALUES (" .
            $values['giocatore1'] ."," .
            $values['giocatore2'] . "," .
            ((isset($values['giocatore3']) && isset($values['giocatore4'])) ? $values['giocatore3'] . "," . $values['giocatore4'] . "," : "") .
            $values['puntigiocatori1e3'] . "," .
            $values['puntigiocatori2e4'] . "," .
            $values['turno'] . ");";
        
        $wpdb->query($sql);
    }
	
	function wintertour_addSocio() {
		global $wpdb;
		
		$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		if (!mysqli_connect_errno()) {
    		$sql = $wpdb->prepare(
    			"INSERT INTO `wintertourtennis_soci`(`nome`, `cognome`, `sesso`, `email`, `saldo`, `indirizzo`, `citta`, `cap`, `provincia`, `telefono`, `cellulare`, `statoattivo`, `datanascita`, `cittanascita`, `dataiscrizione`, `codicefiscale`, `dataimmissione`, `certificatomedico`, `domandaassociazione`, `tessera`) VALUES (%s, %s, %s, %s, %f, %s, %s, %s, %s, %s, %s, %d, %s, %s, %s, %s, %s, %d, %s, %d);",
                
    			capitalize(trim($_POST['nome'])),
    			capitalize(trim($_POST['cognome'])),
                strtoupper(trim($_POST['sesso'])),
    			strtolower(trim($_POST['email'])),
    			trim($_POST['saldo']),
    			capitalize(trim($_POST['indirizzo'])),
    			capitalize(trim($_POST['citta'])),
    			trim($_POST['cap']),
    			strtoupper(trim($_POST['provincia'])),
    			trim($_POST['telefono']),
    			trim($_POST['cellulare']),
    			$_POST['statoattivo'],
    			wintertour_serverdate(trim($_POST['datanascita'])),
    			capitalize(trim($_POST['cittanascita'])),
    			wintertour_serverdatetime(trim($_POST['dataiscrizione'])),
    			strtoupper(trim($_POST['codicefiscale'])),
    			wintertour_serverdatetime(trim($_POST['dataimmissione'])),
    			trim($_POST['certificatomedico']),
    			wintertour_serverdate(trim($_POST['domandaassociazione'])),
    			$_POST['tessera'],
    			trim($_POST['circolo'])
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
    
    function wintertour_get_turno($id) {
        global $wpdb;
        
        if(is_numeric($id)) {
            $sql = "SELECT * FROM `wintertourtennis_turni` WHERE `ID` = " . $id . ";";
            
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
    
    function wintertour_activate_socio($id) {
        global $wpdb;
        
        return $wpdb->update(
            'wintertourtennis_soci',
            array('statoattivo' => 1),
            array('ID' => $id),
            array('%d'),
            array('%d')
        );
    }
    
    function wintertour_activate_certificato($socio_id) {
        global $wpdb;
        
        return $wpdb->update(
            'wintertourtennis_soci',
            array('certificatomedico' => 1),
            array('ID' => $socio_id),
            array('%d'),
            array('%d')
        );
    }
    
    function wintertour_edit_punteggio($ID, $punteggio, $turno, $socio) {
        global $wpdb;
        
        return $wpdb->update(
            'wintertourtennis_punteggi',
            array(
                'punteggio' => $punteggio,
                'turno' => $turno,
                'socio'=> $socio
            ),
            array('ID' => $ID),
            array(
                '%d',
                '%d',
                '%d'
            ),
            array('%d')
        );
    }
    
    function wintertour_edit_risultatoSingolo() {
        global $wpdb;
        
        return $wpdb->update(
            'wintertourtennis_risultati',
            array(
                'giocatore1' => $_POST['socio21'],
                'giocatore2' => $_POST['socio22'],
                'puntigiocatori1e3' => $_POST['punteggio1'],
                'puntigiocatori2e4' => $_POST['punteggio2'],
                'turno' => $_POST['tappa']
            ),
            array('ID' => $_POST['ID']),
            array(
                '%d',
                '%d',
                '%d',
                '%d',
                '%d'
            ),
            array('%d')
        );
    }
    
    function wintertour_edit_risultatoDoppio() {
        global $wpdb;
        
        return $wpdb->update(
            'wintertourtennis_risultati',
            array(
                'giocatore1' => $_POST['socio21'],
                'giocatore2' => $_POST['socio22'],
                'giocatore3' => $_POST['socio23'],
                'giocatore4' => $_POST['socio24'],
                'puntigiocatori1e3' => $_POST['punteggio1'],
                'puntigiocatori2e4' => $_POST['punteggio2'],
                'turno' => $_POST['tappa']
            ),
            array('ID' => $_POST['ID']),
            array(
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d'
            ),
            array('%d')
        );
    }
    
    function wintertour_edit_turno($ID, $data, $circolo, $categoria) {
        global $wpdb;
        
        return $wpdb->update(
            'wintertourtennis_turni',
            array(
                'data' => wintertour_serverdate($data),
                'circolo' => $circolo,
                'categoria' => $categoria
            ),
            array('ID' => $ID),
            array('%s', '%d', '%d'),
            array('%d')
        ) or die($wpdb->last_query);
    }
    
    function wintertour_edit_circolo() {
        global $wpdb;
        
        return $wpdb->update(
            'wintertourtennis_circoli',
            array(
                "nome" => $_POST['nome'],
                "indirizzo" => $_POST['indirizzo'],
                "citta" => $_POST['citta'],
                "cap" => $_POST['cap'],
                "provincia" => $_POST['provincia'],
                "nomereferente" => $_POST['nomereferente'],
                "cognomereferente" => $_POST['cognomereferente'],
                "telefono" => $_POST['telefono'],
                "cellulare" => $_POST['cellulare'],
                "email" => $_POST['email']
            ),
            array('ID' => $_POST['ID']),
            array(
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
            ),
            array('%d')
        );
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
					'sesso' => $args['sesso'],
					'email' => $args['email'],
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
					'tessera' => $args['tessera'],
					'domandaassociazione' => $args['domandaassociazione']
				),
				array('ID' => $id),
				array(
					'%d',
					'%s',
                    '%s',
					'%s',
					'%s',
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
                    '%d',
					'%s',
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
    
    function wintertour_get_autogiocatore() {
        global $wpdb;
        
        wp_verify_nonce($_POST['wt_nonce'], 'wt_nonce') or die(0);
        
        if(empty($_POST['partial'])) {
            die(0);
        }
        
        $sql = "SELECT `ID`, `nome`, `cognome` FROM `wintertourtennis_soci` WHERE (`nome` LIKE '$_POST[partial]%' OR `cognome` LIKE '$_POST[partial]%') AND (`ID` IN (SELECT `giocatore1` FROM `wintertourtennis_risultati`) OR `ID` IN (SELECT `giocatore2` FROM `wintertourtennis_risultati`) OR `ID` IN (SELECT `giocatore3` FROM `wintertourtennis_risultati`) OR `ID` IN (SELECT `giocatore4` FROM `wintertourtennis_risultati`));";
        
        $res = $wpdb->get_results($sql);
        
        foreach ($res as &$row) {
            foreach($row as &$value) {
                $value = stripslashes($value);
            }
        }
        
        echo json_encode($res);
    }
	
	function wintertour_get_autocomplete() {
		global $wpdb;
		
		wp_verify_nonce($_POST['wt_nonce'], 'wt_nonce') or die(0);
		
		if(empty($_POST['partial']) || empty($_POST['type'])) {
			die(0);
		}
		
		if($_POST['type'] == 'soci') {
			$sql = "SELECT `ID`, `nome`, `cognome` FROM `wintertourtennis_soci` WHERE `nome` LIKE '" . $_POST['partial'] . "%' OR `cognome` LIKE '" . $_POST['partial'] . "%';";
            
            $res = $wpdb->get_results($sql);
            
            foreach ($res as &$row) {
                foreach($row as &$value) {
                    $value = stripslashes($value);
                }
            }
            
            echo json_encode($res);
		} else if($_POST['type'] == 'tipologie_soci') {
			$sql = "SELECT `ID`, `nome` FROM `wintertourtennis_tipologie_soci` WHERE `nome` LIKE '" . $_POST['partial'] . "%';";
			
            $res = $wpdb->get_results($sql);
            
            foreach ($res as &$row) {
                foreach($row as &$value) {
                    $value = stripslashes($value);
                }
            }
            
            echo json_encode($res);
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
				"nomereferente" => $_POST['nomereferente'],
                "cognomereferente" => $_POST['cognomereferente'],
                "telefono" => $_POST['telefono'],
                "cellulare" => $_POST['cellulare'],
                "email" => $_POST['email']
			)
		) or die('Errore: Impossibile effettuare l\'operazione richiesta!<br /> Controllare i dati e riprovare.');
	}
    
    function wintertour_elencaTurni_withCircolo($id) {
        global $wpdb;
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM `wintertourtennis_turni` WHERE `circolo` = %d",
            $id
        ));
    }
    
    function wintertour_elencaTurni_withCircoloAndCategoria($idcircolo, $categoria) {
        global $wpdb;
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM `wintertourtennis_turni` WHERE `circolo` = %d AND `categoria` = %d",
            $idcircolo, $categoria
        ));
    }
    
    function wintertour_elencaTurni_withTurnoAndSocio($turnoid, $socioid) {
        global $wpdb;
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM `wintertourtennis_punteggi` WHERE `turno` = %d AND `socio` = %d",
            $turnoid,
            $socioid
        ));
    }
    
	function wintertour_elencaSoci() {
		global $wpdb;
		
		$sql = "SELECT * FROM `wintertourtennis_soci` ORDER BY `cognome` DESC;";
		
		return $wpdb->get_results($sql);
	}
	
	function wintertour_elencaAttivi($certificatomedico = 0) {
	    global $wpdb;
        
        $sql = "SELECT * FROM `wintertourtennis_soci` WHERE `statoattivo` = 1" . (($certificatomedico) ? " AND `certificatomedico` = 1" : "") . " ORDER BY `cognome` ASC;";
        
        return $wpdb->get_results($sql);
	}
    
    function wintertour_countTappe() {
        global $wpdb;
        
        return $wpdb->get_var("SELECT COUNT(*) FROM `wintertourtennis_circoli` WHERE `ID` IN (SELECT `circolo` FROM `wintertourtennis_turni`);");
    }
    
    function wintertour_elencaTappe() {
        global $wpdb;
        
        $sql = "SELECT * FROM `wintertourtennis_circoli` WHERE `ID` IN (SELECT `circolo` FROM `wintertourtennis_turni` WHERE `ID` IN (SELECT `turno` FROM `wintertourtennis_punteggi`)) ORDER BY `nome` ASC;";
        
        return $wpdb->get_results($sql);
    }
    
    function wintertour_elencaGiocatori() {
        global $wpdb;
        
        $sql = "SELECT `wintertourtennis_soci`.`ID`, `nome`, `cognome`, `punteggi`.`punteggio` FROM `wintertourtennis_soci` LEFT JOIN (SELECT `socio` AS `ID`, SUM(`punteggio`) AS `punteggio` FROM `wintertourtennis_punteggi` GROUP BY `socio`) AS `punteggi` ON `wintertourtennis_soci`.`ID`=`punteggi`.`ID` WHERE `wintertourtennis_soci`.`ID` IN (SELECT `socio` FROM `wintertourtennis_punteggi`) ORDER BY `punteggio` DESC;";
        
        return $wpdb->get_results($sql);
    }
	
	function wintertour_elencapunteggi() {
	    global $wpdb;
        
        $sql = "SELECT `wintertourtennis_punteggi`.*, `wintertourtennis_turni`.`data` FROM `wintertourtennis_punteggi` LEFT JOIN `wintertourtennis_turni` ON `wintertourtennis_punteggi`.`turno` = `wintertourtennis_turni`.`ID` ORDER BY `data`;";
        
        return $wpdb->get_results($sql);
	}
    
	function wintertour_countSoci() {
	    global $wpdb;
        
        return $wpdb->get_var("SELECT COUNT(*) FROM `wintertourtennis_soci`" . (($_GET["sex"] === "M" || $_GET["sex"] === "F") ? " WHERE `sesso` = \"$_GET[sex]\"" : "") . ";");
	}
	
	function wintertour_showSoci($page = 1, $limit = 20) {
	    global $wpdb;
        
        $by = strtolower(trim($_GET["order"]));
        $order = strtoupper(trim($_GET["sort"]));
        
        if($by !== "nome" && $by !== "cognome" && $by !== "datanascita") {
            $by = "cognome";
        }
        
        if($order !== "ASC" && $order !== "DESC") {
            $order = "ASC";
        }
        
        if($page <= 0) {
            $page = 1;
        }
        
        $start = ($page - 1) * $limit;
        
        $sql = "SELECT * FROM `wintertourtennis_soci`" . (($_GET["sex"] === "M" || $_GET["sex"] === "F") ? " WHERE `sesso` = \"$_GET[sex]\"" : "") . " ORDER BY `$by` $order LIMIT $start, $limit;";
        
        return $wpdb->get_results($sql);
	}
    
    function wintertour_elencaTurni() {
        global $wpdb;
        
        $sql = "SELECT * FROM `wintertourtennis_turni` ORDER BY `data` ASC;";
        
        return $wpdb->get_results($sql);
    }
    
    function wintertour_searchTurni() {
        global $wpdb;
        
        $sql = "SELECT * FROM `wintertourtennis_turni`";
        $check = false;
        
        if(!empty($_POST['data'])) {
            if(!$check) {
                $sql .= " WHERE ";
                $check = true;
            } else {
                $sql .= " AND ";
            }
            
            $sql .= " `data` = \"" . wintertour_serverdate($_POST['data']) . "\"";
        }
        
        if(!empty($_POST['categoria'])) {
            if(!$check) {
                $sql .= " WHERE ";
                $check = true;
            } else {
                $sql .= " AND ";
            }
            
            $sql .= " `categoria` = $_POST[categoria]";
        }
        
        if(!empty($_POST['circolo'])) {
            if(!$check) {
                $sql .= " WHERE ";
                $check = true;
            } else {
                $sql .= " AND ";
            }
            
            $sql .= " `circolo` = $_POST[circolo]";
        }
        
        $sql .= " ORDER BY `data` ASC;";
        
        return $wpdb->get_results($sql);
    }
    
    function wintertour_searchPunteggi() {
        global $wpdb;
        
        $sql = "SELECT `wintertourtennis_punteggi`.*, `wintertourtennis_turni`.`data` FROM `wintertourtennis_punteggi` LEFT JOIN `wintertourtennis_turni` ON `wintertourtennis_punteggi`.`turno` = `wintertourtennis_turni`.`ID`";
        $check = false;
        
        if(!empty($_POST['turno'])) {
            if(!$check) {
                $sql .= " WHERE ";
                $check = true;
            } else {
                $sql .= " AND ";
            }
            
            $sql .= " `turno` = $_POST[turno]";
        }
        
        if(!empty($_POST['socio'])) {
            if(!$check) {
                $sql .= " WHERE ";
                $check = true;
            } else {
                $sql .= " AND ";
            }
            
            $sql .= " `socio` = $_POST[socio]";
        }
        
        $sql .= " ORDER BY `data`;";
        
        return $wpdb->get_results($sql);
    }
    
    function wintertour_cercaRisultatiSingolo() {
        global $wpdb;
        
        $sql = "SELECT `wintertourtennis_risultati`.*, `wintertourtennis_turni`.`data` FROM `wintertourtennis_risultati` LEFT JOIN `wintertourtennis_turni` ON `wintertourtennis_risultati`.`turno` = `wintertourtennis_turni`.`ID`";
        $check = false;
        
        if(!empty($_POST['tappa'])) {
            if(!$check) {
                $sql .= " WHERE ";
                $check = true;
            } else {
                $sql .= " AND ";
            }
            
            $sql .= " `turno` = $_POST[tappa]";
        }
        
        if(!empty($_POST['socio23']) && !empty($_POST['socio24'])) {
            return null;
        }
        
        if(!empty($_POST['socio11']) && !empty($_POST['socio12'])) {
            if(!$check) {
                $sql .= " WHERE ";
                $check = true;
            } else {
                $sql .= " AND ";
            }
            
            $sql .= "  `giocatore1` = $_POST[socio11] AND `giocatore2` = $_POST[socio12]";
        }
        
        $sql .= " AND `giocatore3` IS NULL && `giocatore4` IS NULL ORDER BY `data`;";
        
        return $wpdb->get_results($sql);
    }
    
    function wintertour_cercaRisultatiDoppio() {
        global $wpdb;
        
        $sql = "SELECT `wintertourtennis_risultati`.*, `wintertourtennis_turni`.`data` FROM `wintertourtennis_risultati` LEFT JOIN `wintertourtennis_turni` ON `wintertourtennis_risultati`.`turno` = `wintertourtennis_turni`.`ID`";
        $check = false;
        
        if(!empty($_POST['tappa'])) {
            if(!$check) {
                $sql .= " WHERE ";
                $check = true;
            } else {
                $sql .= " AND ";
            }
            
            $sql .= " `turno` = $_POST[tappa]";
        }
        
        if(!empty($_POST['socio21']) && !empty($_POST['socio22']) && !empty($_POST['socio23']) && !empty($_POST['socio24'])) {
            if(!$check) {
                $sql .= " WHERE ";
                $check = true;
            } else {
                $sql .= " AND ";
            }
            
            $sql .= " `giocatore1` = $_POST[socio21] AND  `giocatore2` = $_POST[socio22] AND `giocatore3` = $_POST[socio23] AND `giocatore4` = $_POST[socio24]";
        } else {
            return null;
        }
        
        $sql .= " ORDER BY `data`;";
        
        return $wpdb->get_results($sql);
    }
        
    function wintertour_elencaRisultatiSingolo() {
        global $wpdb;
        
        return $wpdb->get_results("SELECT `wintertourtennis_risultati`.*, `wintertourtennis_turni`.`data` FROM `wintertourtennis_risultati` LEFT JOIN `wintertourtennis_turni` ON `wintertourtennis_risultati`.`turno` = `wintertourtennis_turni`.`ID` WHERE `giocatore3` IS NULL OR `giocatore4` IS NULL ORDER BY `data`;");
    }
    
    function wintertour_elencaRisultatiDoppio() {
        global $wpdb;
        
        return $wpdb->get_results("SELECT `wintertourtennis_risultati`.*, `wintertourtennis_turni`.`data` FROM `wintertourtennis_risultati` LEFT JOIN `wintertourtennis_turni` ON `wintertourtennis_risultati`.`turno` = `wintertourtennis_turni`.`ID` WHERE `giocatore3` IS NOT NULL AND `giocatore4` IS NOT NULL ORDER BY `data`;");
    }
	
	function wintertour_elencatipi() {
		global $wpdb;
		
		$query = "SELECT * FROM `wintertourtennis_tipologie_soci` ORDER BY `nome` ASC;";
		return $wpdb->get_results($query);
	}
	
	function wintertour_elencacircoli() {
		global $wpdb;
		
		return $wpdb->get_results("SELECT * FROM `wintertourtennis_circoli` ORDER BY `nome` ASC;");
	}
    
    function wintertour_getcircolo($ID) {
        global $wpdb;
        
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM `wintertourtennis_circoli` WHERE ID = %d;", $ID));
    }
    
    function wintertour_getpunteggio($ID) {
        global $wpdb;
        
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM `wintertourtennis_punteggi` WHERE ID = %d;", $ID));
    }
    
    function wintertour_getrisultato($ID) {
        global $wpdb;
        
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM `wintertourtennis_risultati` WHERE ID = %d;", $ID));
    }
    
    function wintertour_serverdate($date) {
        
        $gg = "";
        $mm = "";
        $aaaa = "";
        
        sscanf($date, "%02s/%02s/%04s", $gg, $mm, $aaaa);
        
        return sprintf("%04s-%02s-%02s", $aaaa, $mm, $gg);
    }
    
    function wintertour_serverdatetime($datetime) {
        
        $gg = "";
        $mm = "";
        $aaaa = "";
        
        $hh = "";
        $MM = "";
        $ss = "00";
        
        sscanf($datetime, "%02s/%02s/%04s - %02s:%02s", $gg, $mm, $aaaa, $hh, $MM);
        
        return sprintf("%04s-%02s-%02s %02s:%02s:%02s", $aaaa, $mm, $gg, $hh, $MM, $ss);
    }
	
	function wintertour_localdate($date) {
	    
        $gg = "";
        $mm = "";
        $aaaa = "";
        
        sscanf($date, "%04s-%02s-%02s", $aaaa, $mm, $gg);
        
        return sprintf("%02s/%02s/%04s", $gg, $mm, $aaaa);
	}
	
	function wintertour_localdatetime($datetime) {
        
        $gg = "";
        $mm = "";
        $aaaa = "";
        
        $hh = "";
        $MM = "";
        $ss = "";
        
        sscanf($datetime, "%04s-%02s-%02s %02s:%02s:%02s", $aaaa, $mm, $gg, $hh, $MM, $ss);
        
        return sprintf("%02s/%02s/%04s - %02s:%02s", $gg, $mm, $aaaa, $hh, $MM);
	}
	
	function countObj($ogg) {
		$i = 0;
		
		foreach($ogg as $key => $value) {
			$i++;
		}
		
		return $i;
	}
    
    function winterMenu() { ?>
            <ul class="wintermenu">
                <li><a href="<?php echo admin_url('admin.php?page=wintertour'); ?>">Homepage</a></li>
                <li><a href="<?php echo admin_url('admin.php?page=wintertour_soci'); ?>">Soci</a></li>
                <li><a href="<?php echo admin_url('admin.php?page=wintertour_circoli'); ?>">Circoli</a></li>
                <li><a href="<?php echo admin_url('admin.php?page=wintertour_turni'); ?>">Tappe</a></li>
                <li><a href="<?php echo admin_url('admin.php?page=wintertour_punteggi'); ?>">Punteggi</a></li>
                <li><a href="<?php echo admin_url('admin.php?page=wintertour_carica_risultati'); ?>">Risultati</a></li>
                <li><a href="<?php echo admin_url('admin.php?page=wintertour_risultati'); ?>">Classifica</a></li>
                <li><a href="<?php echo admin_url('admin.php?page=wintertour_tabella_incontri'); ?>">Tabella Incontri</a></li>
            </ul>
    <?php }
    
	
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