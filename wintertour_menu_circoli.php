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
	
	if(isset($_POST['submit0'])) {
		wintertour_addCircolo();
	} else if($_POST['circolomodifica']) {
	    wintertour_edit_circolo(
	       $_POST['ID'],
	       $_POST['nome'],
	       $_POST['indirizzo'],
	       $_POST['citta'],
	       $_POST['cap'],
	       $_POST['provincia'],
	       $_POST['referente']
        );
	}
?>
<div class="wgest_page wgest_soci">
	<h1>Gestionale WinterTour</h1>
	<h2>Gestione Circoli</h2>
	
	<noscript>
		Per avere a disposizione tutte le funzionalità di questo sito è necessario abilitare Javascript. Qui ci sono tutte le <a href="http://www.enable-javascript.com/it/" target="_blank"> istruzioni su come abilitare JavaScript nel tuo browser</a>.
	</noscript>
    
    <p>
        <a href="<?php echo admin_url('admin.php?page=wintertour_circoli&action=add'); ?>">Aggiungi circolo</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_circoli&action=view'); ?>">Consulta e modifica circoli</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_circoli&action=search'); ?>">Ricerca e modifica circoli</a>
    </p>
	
	<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'add') { ?>
    	<form action="" method="post">
    		<input name="wt_nonce" type="hidden" value="<?php echo wp_create_nonce(wt_nonce); ?>" />
    		<table cellpadding="2" cellspacing="0" border="0">
    			<thead>
    				<tr>
    					<th colspan="2">
    						<h3>Aggiungi nuovo circolo</h3>
    					</th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr>
    					<td>
    						<label for="nomecircolo">Nome circolo:</label>
    					</td>
    					<td>
    						<input autocomplete="off" name="nomecircolo" id="nomecircolo" type="text" placeholder="Nome circolo" />
    					</td>
    				</tr>
    				<tr>
    					<td>
    						<label for="indirizzocircolo">Indirizzo circolo:</label>
    					</td>
    					<td>
    						<input autocomplete="off" name="indirizzocircolo" id="indirizzocircolo" type="text" placeholder="Indirizzo circolo" />
    					</td>
    				</tr>
    				<tr>
    					<td>
    						<label for="capcircolo">CAP circolo:</label>
    					</td>
    					<td>
    						<input autocomplete="off" name="capcircolo" id="capcircolo" type="text" placeholder="CAP circolo" />
    					</td>
    				</tr>
    				<tr>
    					<td>
    						<label for="cittacircolo">Citt&agrave; circolo:</label>
    					</td>
    					<td>
    						<input autocomplete="off" name="cittacircolo" id="cittacircolo" type="text" placeholder="Citt&agrave; circolo" />
    					</td>
    				</tr>
    				<tr>
    					<td>
    						<label for="provinciacircolo">Provincia circolo:</label>
    					</td>
    					<td>
    						<?=selectProvincia('provinciacircolo')?>
    					</td>
    				</tr>
    				<tr>
    					<td>
    						<label for="referentecircolo">Referente circolo:</label>
    					</td>
    					<td>
    						<table cellpadding="0" cellspacing="0" border="0" style="min-width: 500px; width: 500px;">
    							<tr>
    								<td width="40%" style="padding: 0; width: 45%;">
    									<input autocomplete="off" data-autocompname="referentecircolo" type="text" placeholder="Cerca un socio" class="searchbox autocompletion" />
    								</td>
    								<td width="60%" style="padding: 0; width: 55%;">
    									<select data-autocomptype="soci" name="referentecircolo" class="searchbox autocompletion" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
    										<option disabled="disabled" selected="selected" value="">--Cercare un socio--</option>
    									</select>
    								</td>
    							</tr>
    						</table>
    					</td>
    				</tr>
    			</tbody>
    			<tfoot>
    				<td colspan="2" align="center">
    					<input autocomplete="off" data-autocompname="referentecircolo" class="autocompletion" name="submit0" id="submit0" type="submit" value="Aggiungi" />
    				</td>
    			</tfoot>
    		</table>
    	</form>
    <?php } else if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'view') {
        $circoli = wintertour_elencacircoli();
    ?>
        <?php if(count($circoli) > 0) { ?>
            <h3>Elenco punteggi</h3>
            <table class="output-table">
                <thead>
                    <tr>
                        <th>Azione</th>
                        <th>Nome</th>
                        <th>Indirizzo</th>
                        <th>Citt&agrave;</th>
                        <th>Provincia</th>
                        <th>Referente</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($circoli as $index => $riga) {
                        $referente = wintertour_get_socio($riga->referente);
                    ?>
                        <tr>
                            <td><a href="<?=admin_url('admin.php?page=wintertour_circoli&action=circoliedit&circolo=') . $riga->ID?>">Gestisci</a></td>
                            <td><?=$riga->nome?></td>
                            <td><?=$riga->indirizzo?></td>
                            <td><?=$riga->citta?></td>
                            <td><?=$riga->provincia?></td>
                            <?php if($referente !== null) { ?>
                                <td><a href="<?=admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=') . $referente->ID?>"><?=$referente->cognome?> <?=$referente->nome?></a></td>
                            <?php } else { ?>
                                <td>Nessun Referente</td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <h3>Nessun circolo</h3>
        <?php } ?>
    <?php } else if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'circoliedit' && isset($_REQUEST['circolo'])) {
        $circolo = wintertour_getcircolo($_REQUEST['circolo']);
    ?>
        <form action="<?php echo admin_url('admin.php?page=wintertour_circoli&action=circoliedit&circolo=' . $_REQUEST['circolo']); ?>" method="post">
            <input name="wt_nonce" type="hidden" value="<?php echo wp_create_nonce(wt_nonce); ?>" />
            <table>
                <thead>
                    <tr>
                        <th colspan="2">
                            <h3>Modifica circolo</h3>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="ID">ID</label>
                        </td>
                        <td>
                            <input autocomplete="off" name="ID" readonly="readonly" type="text" value="<?=$circolo->ID?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="nome">Nome: </label>
                        </td>
                        <td>    
                            <input autocomplete="off" name="nome" type="text" placeholder="Nome" value="<?=$circolo->nome?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="indirizzo">Indirizzo: </label>
                        </td>
                        <td>    
                            <input autocomplete="off" name="indirizzo" type="text" placeholder="Indirizzo" value="<?=$circolo->indirizzo?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="citta">Citt&agrave;: </label>
                        </td>
                        <td>    
                            <input autocomplete="off" name="citta" type="text" placeholder="Citt&agrave;" value="<?=$circolo->indirizzo?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="cap">CAP: </label>
                        </td>
                        <td>    
                            <input autocomplete="off" name="cap" type="text" placeholder="CAP" value="<?=$circolo->cap?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="provincia">Provincia:</label>
                        </td>
                        <td>
                            <?=selectProvincia('provincia', $circolo->provincia)?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="socio">Referente:</label>
                        </td>
                        <td>
                            <table cellpadding="0" cellspacing="0" border="0" style="min-width: 500px; width: 500px;">
                                <tr>
                                    <td width="40%" style="padding: 0; width: 45%;">
                                        <input autocomplete="off" data-autocompname="referente" type="text" placeholder="Cerca un socio" class="searchbox autocompletion" />
                                    </td>
                                    <td width="60%" style="padding: 0; width: 55%;">
                                        <select data-autocomptype="referente" name="referente" class="searchbox autocompletion">
                                            <?php
                                                $socio = wintertour_get_socio($circolo->referente);
                                            ?>
                                            <option disabled="disabled" value="">--Selezionare un socio--</option>
                                            <option selected="selected" value="<?=$socio->ID?>"><?=$socio->cognome?> <?=$socio->nome?></option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <input data-autocompname="referente" name="circolomodifica" type="submit" value="Modifica" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    <?php } ?>
</div>