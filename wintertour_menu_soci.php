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
	
	if(isset($_POST['submit1'])) {
		wintertour_addSocio();
	} else if(isset($_POST['savesocio'])) {
        wintertour_edit_socio($_REQUEST['socio'], $_POST);
    }
?>
<div class="wgest_page wgest_soci">
    <a href="<?php echo admin_url('admin.php?page=wintertour'); ?>"><h1>Gestionale WinterTour</h1></a>
    <?=winterMenu()?>
	<h2>Gestione Soci</h2>
	
	<noscript>
		Per avere a disposizione tutte le funzionalità di questo sito è necessario abilitare Javascript. Qui ci sono tutte le <a href="http://www.enable-javascript.com/it/" target="_blank"> istruzioni su come abilitare JavaScript nel tuo browser</a>.
	</noscript>
    
	<p>
		<a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=add'); ?>">Aggiungi Socio</a><br />
		<a href="<?php echo admin_url('admin.php?page=wintertour_soci&order=cognome&sort=asc&action=view&pag=1&limit=20&sex=all'); ?>">Gestisci soci</a><br />
		<a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=search'); ?>">Ricerca soci</a>
	</p>
	
	<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'add') { ?>
		<form action="<?php echo admin_url('admin.php?page=wintertour_soci&action=add'); ?>" method="post">
			<table cellpadding="2" cellspacing="0" border="0">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Aggiungi nuovo socio</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<label for="cognome">Cognome:</label>
						</td>
						<td>
							<input autocomplete="off" name="cognome" id="cognome" type="text" placeholder="Cognome" />
						</td>
					</tr>
                    <tr>
                        <td>
                            <label for="nome">Nome:</label>
                        </td>
                        <td>
                            <input autocomplete="off" name="nome" id="nome" type="text" placeholder="Nome" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="sesso">Sesso:</label>
                        </td>
                        <td>
                            <table style="min-width: 246px; width: 246px;">
                                <tr>
                                    <td>
                                        <input autocomplete="off" name="sesso" id="sessoM" type="radio" value="M" />Maschile
                                    </td>
                                    <td>
                                        <input autocomplete="off" name="sesso" id="sessoF" type="radio" value="F" />Femminile
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
					<tr>
						<td>
							<label for="email">Email:</label>
						</td>
						<td>
							<input autocomplete="off" name="email" id="email" type="email" placeholder="Email" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="saldo">Saldo (&euro;):</label>
						</td>
						<td>
							<input autocomplete="off" name="saldo" id="saldo" type="text" pattern="([+-]?[0-9]+)?([.,][0-9]+)?" placeholder="Saldo" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="indirizzo">Indirizzo:</label>
						</td>
						<td>
							<input autocomplete="off" name="indirizzo" id="indirizzo" type="text" placeholder="Indirizzo" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="citta">Città:</label>
						</td>
						<td>
							<input autocomplete="off" name="citta" id="citta" type="text" placeholder="Città" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="cap">CAP:</label>
						</td>
						<td>
							<input autocomplete="off" name="cap" id="cap" type="text" pattern="^[0-9]{5}$" placeholder="CAP" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="provincia">Provincia:</label>
						</td>
						<td>
							<?=selectProvincia('provincia')?>
						</td>
					</tr>
					<tr>
						<td>
							<label for="telefono">Telefono:</label>
						</td>
						<td>
							<input autocomplete="off" name="telefono" id="telefono" type="tel" pattern="^[0-9]{10}$" placeholder="Telefono" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="cellulare">Cellulare:</label>
						</td>
						<td>
							<input autocomplete="off" name="cellulare" id="cellulare" type="tel" pattern="^[0-9]{10}$" placeholder="Cellulare" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="statoattivo">Stato Attivo:</label>
						</td>
						<td>
							<table>
								<tr>
									<td>
										<input autocomplete="off" name="statoattivo" id="statoattivo1" type="radio" value="1" />Attivo
									</td>
									<td>
										<input autocomplete="off" name="statoattivo" id="statoattivo0" type="radio" value="0" />Inattivo
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<label for="datanascita">Data di Nascita:</label>
						</td>
						<td>
							<input autocomplete="off" name="datanascita" id="datanascita" type="text" class="date" placeholder="gg/mm/aaaa" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="cittanascita">Citt&agrave; di Nascita:</label>
						</td>
						<td>
							<input autocomplete="off" name="cittanascita" id="cittanascita" type="text" placeholder="Citt&agrave; di Nascita" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="dataiscrizione">Data di Iscrizione:</label>
						</td>
						<td>
							<input autocomplete="off" name="dataiscrizione" id="dataiscrizione" type="text" class="date" placeholder="gg/mm/aaaa" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="codicefiscale">Codice Fiscale:</label>
						</td>
						<td>
							<input autocomplete="off" name="codicefiscale" id="codicefiscale" type="text" placeholder="Codice Fiscale" pattern="[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="dataimmissione">Data Immissione:</label>
						</td>
						<td>
							<input autocomplete="off" name="dataimmissione" id="dataimmissione" type="text" class="datetime" placeholder="gg/mm/aaaa - hh:mm" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="certificatomedico">Certificato Medico:</label>
						</td>
						<td>
							<table style="min-width: 246px; width: 246px;">
								<tr>
									<td>
										<input autocomplete="off" name="certificatomedico" id="certificatomedico1" type="radio" value="1" />Pervenuto
									</td>
									<td>
										<input autocomplete="off" name="certificatomedico" id="certificatomedico0" type="radio" value="0" />Non Pervenuto
									</td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
                        <td>
                            <label for="tessera">Tessera:</label>
                        </td>
                        <td>
                            <table style="min-width: 246px; width: 246px;">
                                <tr>
                                    <td>
                                        <input autocomplete="off" name="tessera" id="tessera1" type="radio" value="1" />Rilasciata
                                    </td>
                                    <td>
                                        <input autocomplete="off" name="tessera" id="tessera0" type="radio" value="0" />Non rilasciata
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
					<tr>
						<td>
							<label for="domandaassociazione">Domanda di Associazione:</label>
						</td>
						<td>
							<input autocomplete="off" name="domandaassociazione" id="domandaassociazione" type="text" class="date" placeholder="gg/mm/aaaa" />
						</td>
					</tr>
				</tbody>
				<tfoot>
					<td colspan="2" align="center">
						<input name="submit1" id="submit1"  type="submit" value="Aggiungi" />
					</td>
				</tfoot>
			</table>
		</form>
	<?php } else if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'view') {
		$tipologie = wintertour_elencatipi();
        $count = wintertour_countSoci();
        $limit = (isset($_REQUEST['limit'])) ? intval($_REQUEST['limit']) : 20;
        
        $pag = (isset($_REQUEST['pag'])) ? intval($_REQUEST['pag']) : 1;
        
        if($pag <= 0) {
            $pag = 1;
        }
        
        if($pag > ceil((double)$count / (double)$limit)) {
            $pag = ceil((double)$count / (double)$limit);
        }
        
		$soci = wintertour_showSoci($pag, $limit);
	?>
    <form id="selectsex">
        <label for="sesso"><strong>Seleziona sesso</strong>:</label> <input name="sesso" type="radio" value="M"<?php if($_GET['sex'] === 'M') { ?> checked="checked"<?php } ?> />Maschile <input name="sesso" type="radio" value="F"<?php if($_GET['sex'] === 'F') { ?> checked="checked"<?php } ?> />Femminile <input name="sesso" type="radio" value="all"<?php if($_GET['sex'] === 'all') { ?> checked="checked"<?php } ?> />Tutti <br />
    </form>
    <script type="text/javascript">
        if(jQuery()) {
            (function($) {
                var newURL = function(checked) {
                    var tmp = "";
                    var checked = checked || "";
                    
                    if(checked === "M" || checked === "F" || checked === "all") {
                        if(location.href.indexOf('?') >= 0) {
                            var arr = location.href.split('?');
                            
                            if(arr.length === 2 && arr[1].length > 0) {
                                var dict = {};
                                
                                var arr2 = arr[1].split('&');
                                for(v in arr2) {
                                    var tmp2 = arr2[v].split('=');
                                    if(tmp2[0] !== 'sex') {
                                        dict[tmp2[0]] = tmp2[1];
                                    }
                                }
                                dict['sex'] = checked;
                                
                                tmp += arr[0];
                                
                                if(dict['page']) {
                                    tmp += '?page=' + dict['page'];
                                    delete dict['page'];
                                }
                                
                                for(key in dict) {
                                    tmp += '&' + key + '=' + dict[key];
                                }
                            }
                        }
                    }
                    
                    return tmp;
                }
                
                $('form#selectsex input[name=sesso]:radio').change(function(){
                    if($(this).prop('checked')) {
                        document.location.href = newURL($(this).val());
                    }
                });
            }(jQuery));
        }
    </script>
	<?php if(count($soci) > 0) { ?>
    	<div class="scrollable-view">
    		<h3>Elenco soci</h3>
    		<h4><?="Soci " . (($pag - 1) * $limit + 1) . " - " . (($pag * $limit <= $count) ? $pag * $limit : $count) . " di " . $count . " (pagina $pag di " . ceil((double)$count / (double)$limit) . ")"?></h4>
    		<?php pagingURL($pag, $count, $limit) ?>
    		<table class="output-table sortable">
    			<thead>
    				<tr>
    				    <th>Azione</th>
                        <?=sortArrow('Cognome', 'cognome')?>
                        <?=sortArrow('Nome', 'nome')?>
                        <th>Sesso</th>
                        <th>Email</th>
                        <?=sortArrow('Data di Nascita', 'datanascita')?>
    					<th>Saldo</th>
                        <th>Certificato Medico</th>
                        <th>Tessera</th>
                        <th>Cellulare</th>
    					<th>Città</th>
                        <th>Stato Attivo</th>
    				</tr>
    			</thead>
    			<tbody>
    				<?php foreach($soci as $index => $riga) { ?>
    					<tr>
    						<td>
    							<a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $riga->ID); ?>">Gestisci</a>
    						</td>
                            <td>
                                <?=capitalize(stripslashes($riga->cognome))?>
                            </td>
                            <td>
                                <?=capitalize(stripslashes($riga->nome))?>
                            </td>
                            <td>
                                <?=($riga->sesso === 'M') ? "Maschile" : (($riga->sesso === 'F') ? "Femminile" : "Non specificato")?>
                            </td>
                            <td>
                                <?=!empty($riga->email) ? "<a href=\"mailto:" . strtolower($riga->email) . "\">" . strtolower($riga->email) . "</a>" : "Nessun email"?>
                            </td>
                            <td>
                                <?=wintertour_localdate($riga->datanascita)?>
                            </td>
                            <td>
                                <?=!empty($riga->saldo) ? $riga->saldo . " &euro;" : "0 &euro;"?>
                            </td>
                            <td>
                                <?=($riga->certificatomedico === "1") ? "Inviato" : "Non inviato"?>
                            </td>
                            <td>
                                <?=($riga->tessera == 1) ? "Rilasciata" : "Non rilasciata"?>
                            </td>
                            <td>
                                <?=format_phone($riga->cellulare)?>
                            </td>
                            <td>
                                <?=capitalize($riga->citta)?>
                            </td>
                            <td>
                                <?=($riga->statoattivo === "1") ? "Attivo" : "Inattivo"?>
                            </td>
    					</tr>
    				<?php } ?>
    			</tbody>
    		</table>
    	</div>
	<?php } else { ?>
		<h3>Nessun Socio</h3>
	<?php } ?>
	<?php } else if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'search') { ?>
        <h3>Ricerca Soci</h3>
        <form action="<?php echo admin_url('admin.php'); ?>" method="get">
            <?php foreach ($_GET as $key => $value) { ?>
                <input name="<?=$key?>" type="hidden" value="<?=$value?>" />
            <?php } ?>
            <input name="wt_nonce" type="hidden" value="<?php echo wp_create_nonce(wt_nonce); ?>" />
            <table>
                <tbody>
                    <tr>
                        <td>
                            <input data-autocompname="socio" type="text" placeholder="Cerca un socio" class="searchbox autocompletion" />
                        </td>
                        <td>
                            <select data-autocomptype="soci" name="socio" class="searchbox autocompletion">
                                <option disabled="disabled" selected="selected" value="">--Cerca un socio--</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <input data-autocompname="socio" class="autocompletion" type="submit" value="Modifica" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
	<?php } else if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'sociedit' && isset($_REQUEST['socio'])) { ?>
		<?php
			$obj_socio = wintertour_get_socio($_REQUEST['socio']);
		?>
		<h3>Modifica Socio</h3>
		<form class="editor" action="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $_REQUEST['socio']); ?>" method="post">
			<input name="wt_nonce" type="hidden" value="<?php echo wp_create_nonce(wt_nonce); ?>" />
			<input name="ID" type="hidden" value="<?=$obj_socio->ID?>" />
			<table>
				<tbody>
                    <tr>
                        <td>
                            <label for="cognome">Cognome:</label>
                        </td>
                        <td>
                            <input autocomplete="off" name="cognome" id="cognome" type="text" placeholder="Cognome" value="<?=capitalize($obj_socio->cognome)?>" />
                        </td>
                    </tr>
					<tr>
						<td>
							<label for="nome">Nome:</label>
						</td>
						<td>
							<input autocomplete="off" name="nome" id="nome" type="text" placeholder="Nome" value="<?=capitalize($obj_socio->nome)?>" />
						</td>
					</tr>
                    <tr>
                        <td>
                            <label for="sesso">Sesso:</label>
                        </td>
                        <td>
                            <table style="min-width: 246px; width: 246px;">
                                <tr>
                                    <td>
                                        <input autocomplete="off" name="sesso" id="sessoM" type="radio" value="M" <?php if($obj_socio->sesso == 'M') { ?>checked="checked" <?php } ?>/>Maschile
                                    </td>
                                    <td>
                                        <input autocomplete="off" name="sesso" id="sessoF" type="radio" value="F" <?php if($obj_socio->sesso == 'F') { ?>checked="checked" <?php } ?>/>Femminile
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
					<tr>
						<td>
							<label for="email">Email:</label>
						</td>
						<td>
							<input autocomplete="off" name="email" id="email" type="email" placeholder="Email" value="<?=strtolower($obj_socio->email)?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="saldo">Saldo (&euro;):</label>
						</td>
						<td>
							<input autocomplete="off" name="saldo" id="saldo" type="text" pattern="([+-]?[0-9]+)?([.,][0-9]+)?" placeholder="Saldo" value="<?=$obj_socio->saldo?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="indirizzo">Indirizzo:</label>
						</td>
						<td>
							<input autocomplete="off" name="indirizzo" id="indirizzo" type="text" placeholder="Indirizzo" value="<?=$obj_socio->indirizzo?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="citta">Città:</label>
						</td>
						<td>
							<input autocomplete="off" name="citta" id="citta" type="text" placeholder="Città" value="<?=$obj_socio->citta?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="cap">CAP:</label>
						</td>
						<td>
							<input autocomplete="off" name="cap" id="cap" type="text" pattern="^[0-9]{5}$" placeholder="CAP" value="<?=$obj_socio->cap?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="provincia">Provincia:</label>
						</td>
						<td>
							<?=selectProvincia('provincia', $obj_socio->provincia)?>
						</td>
					</tr>
					<tr>
						<td>
							<label for="telefono">Telefono:</label>
						</td>
						<td>
							<input autocomplete="off" name="telefono" id="telefono" type="tel" placeholder="Telefono" value="<?=$obj_socio->telefono?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="cellulare">Cellulare:</label>
						</td>
						<td>
							<input autocomplete="off" name="cellulare" id="cellulare" type="tel" placeholder="Cellulare" value="<?=$obj_socio->cellulare?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="statoattivo">Stato Attivo:</label>
						</td>
						<td>
							<table>
								<tr>
									<td>
										<input autocomplete="off" name="statoattivo" id="statoattivo1" type="radio" value="1"<?php if($obj_socio->statoattivo) { ?> checked="checked"<?php } ?> />Attivo
									</td>
									<td>
										<input autocomplete="off" name="statoattivo" id="statoattivo0" type="radio" value="0"<?php if(!$obj_socio->statoattivo) { ?> checked="checked"<?php } ?> />Inattivo
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<label for="datanascita">Data di Nascita:</label>
						</td>
						<td>
							<input autocomplete="off" name="datanascita" id="datanascita" type="text" class="date" placeholder="gg/mm/aaaa" value="<?=wintertour_localdate($obj_socio->datanascita)?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="cittanascita">Citt&agrave; di Nascita:</label>
						</td>
						<td>
							<input name="cittanascita" id="cittanascita" type="text" placeholder="Citt&agrave; di Nascita" value="<?=$obj_socio->cittanascita?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="dataiscrizione">Data di Iscrizione:</label>
						</td>
						<td>
							<input name="dataiscrizione" id="dataiscrizione" type="text" class="date" placeholder="gg/mm/aaaa" value="<?=(wintertour_localdate($obj_socio->dataiscrizione) !== "00/00/0000") ? wintertour_localdate($obj_socio->dataiscrizione) : "" ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="codicefiscale">Codice Fiscale:</label>
						</td>
						<td>
							<input name="codicefiscale" id="codicefiscale" type="text" placeholder="Codice Fiscale" value="<?=$obj_socio->codicefiscale?>" pattern="[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="dataimmissione">Data Immissione:</label>
						</td>
						<td>
							<input name="dataimmissione" id="dataimmissione" type="text" readonly="readonly" placeholder="gg/mm/aaaa - hh:mm" value="<?=wintertour_localdatetime($obj_socio->dataimmissione)?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="certificatomedico">Certificato Medico:</label>
						</td>
						<td>
							<table style="min-width: 246px; width: 246px;">
								<tr>
									<td>
										<input name="certificatomedico" id="certificatomedico1" type="radio" value="1"<?php if($obj_socio->certificatomedico) { ?> checked="checked"<?php } ?> />Pervenuto
									</td>
									<td>
										<input name="certificatomedico" id="certificatomedico0" type="radio" value="0"<?php if(!$obj_socio->certificatomedico) { ?> checked="checked"<?php } ?> />Non Pervenuto
									</td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
                        <td>
                            <label for="tessera">Tessera:</label>
                        </td>
                        <td>
                            <table style="min-width: 246px; width: 246px;">
                                <tr>
                                    <td>
                                        <input autocomplete="off" name="tessera" id="tessera1" type="radio" value="1"<?php if($obj_socio->tessera) { ?> checked="checked"<?php } ?> />Rilasciata
                                    </td>
                                    <td>
                                        <input autocomplete="off" name="tessera" id="tessera0" type="radio" value="0"<?php if(!$obj_socio->tessera) { ?> checked="checked"<?php } ?> />Non rilasciata
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
					<tr>
						<td>
							<label for="domandaassociazione">Domanda di Associazione:</label>
						</td>
						<td>
							<input name="domandaassociazione" id="domandaassociazione" type="text" class="date" placeholder="gg/mm/aaaa" value="<?=(wintertour_localdate($obj_socio->domandaassociazione) !== '00/00/0000') ? wintertour_localdate($obj_socio->domandaassociazione) : ""?>" />
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td>
							<input name="savesocio" type="submit" value="Salva" />
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	<?php } ?>
</div>
