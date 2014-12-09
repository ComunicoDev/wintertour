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
    
    if(isset($_POST['singolo'])) {
        wintertour_addRisultato(array(
            'giocatore1' => $_POST['socio11'],
            'giocatore2' => $_POST['socio12'],
            'turno' => $_POST['tappa'],
            'set1sq1' => $_POST['set1sq1'],
            'set1sq2' => $_POST['set1sq2'],
            'set2sq1' => $_POST['set2sq1'],
            'set2sq2' => $_POST['set2sq2'],
            'set3sq1' => $_POST['set3sq1'],
            'set3sq2' => $_POST['set3sq2']
        ));
    } else if(isset($_POST['doppio'])) {
        wintertour_addRisultato(array(
            'giocatore1' => $_POST['socio21'],
            'giocatore2' => $_POST['socio22'],
            'giocatore3' => $_POST['socio23'],
            'giocatore4' => $_POST['socio24'],
            'turno' => $_POST['tappa'],
            'set1sq1' => $_POST['set1sq1'],
            'set1sq2' => $_POST['set1sq2'],
            'set2sq1' => $_POST['set2sq1'],
            'set2sq2' => $_POST['set2sq2'],
            'set3sq1' => $_POST['set3sq1'],
            'set3sq2' => $_POST['set3sq2']
        ));
    } else if(isset($_POST['edit'])) {
        if(isset($_POST['socio23']) && isset($_POST['socio24'])) {
            wintertour_edit_risultatoDoppio();
        } else {
            wintertour_edit_risultatoSingolo();
        }
    } else if(isset($_POST['delete'])) {
        wintertour_deleteRisultato($_POST['ID']);
    }
?>
<div class="wgest_page wgest_opt">
    <a href="<?php echo admin_url('admin.php?page=wintertour'); ?>"><h1>Gestionale WinterTour</h1></a>
    <?=winterMenu()?>
    <h2>Gestione risultati</h2>
    
    <noscript>
        Per avere a disposizione tutte le funzionalità di questo sito è necessario abilitare Javascript. Qui ci sono tutte le <a href="http://www.enable-javascript.com/it/" target="_blank"> istruzioni su come abilitare JavaScript nel tuo browser</a>.
    </noscript>
    
    <p>
        <a href="<?php echo admin_url('admin.php?page=wintertour_carica_risultati&action=add'); ?>">Carica risultati</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_carica_risultati&action=view'); ?>">Gestisci risultati</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_carica_risultati&action=search'); ?>">Ricerca risultati</a>
    </p>
    
    <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'search') { ?>
        <h3>Cerca risultati</h3>
        <select class="showone">
            <option value="singolo"<?php if(isset($_POST['singolo'])) { ?> selected="selected"<?php } ?>>Singolo</option>
            <option value="doppio"<?php if(isset($_POST['doppio'])) { ?> selected="selected"<?php } ?>>Doppio</option>
        </select><br /><br />
        <form id="singolo"<?php if(isset($_POST['doppio'])) { ?> style="display:none;"<?php } ?> action="<?php echo admin_url('admin.php?page=wintertour_carica_risultati&action=view'); ?>" method="post">
            <input name="wt_nonce" type="hidden" value="<?php echo wp_create_nonce(wt_nonce); ?>" />
            <table>
                <thead>
                    <tr>
                        <th>Cerca risultato Singolo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="tappa">Seleziona tappa</label>
                        </td>
                        <td>
                            <select name="tappa">
                                <?php
                                    $res = wintertour_elencaTurni();
                                    
                                    if(!$res) {
                                ?>
                                    <option disabled="disabled" selected="selected" value="">--Non esiste nessuna tappa--</option>
                                <?php } else { ?>
                                    <option disabled="disabled" selected="selected" value="">--Selezionare una tappa--</option>
                                <?php }
                                    
                                    foreach ($res as $x) {
                                        $circolo = wintertour_getcircolo($x->circolo);
                                    ?>
                                        <option value="<?=$x->ID?>"<?php if($x->ID === $_POST['tappa']) { ?> selected="selected"<?php } ?>><?=wintertour_localdate($x->data)?> - <?=$circolo->nome?> - <?=wintertour_getCategoria($x->ID)?></option>
                                    <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio11" type="text" placeholder="Cerca giocatore 1" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio11" class="searchbox autocompletion">
                                <option disabled="disabled" selected="selected" value="">--Cercare giocatore 1--</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio12" type="text" placeholder="Cerca giocatore 2" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio12" class="searchbox autocompletion">
                                <option disabled="disabled" selected="selected" value="">--Cercare giocatore 2--</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <input type="hidden" name="singolo" value="singolo" />
                            <input type="submit" name="ricerca" value="Cerca" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
        <form id="doppio"<?php if(!isset($_POST['doppio'])) { ?> style="display:none;"<?php } ?> action="<?php echo admin_url('admin.php?page=wintertour_carica_risultati&action=view'); ?>" method="post">
            <input name="wt_nonce" type="hidden" value="<?php echo wp_create_nonce(wt_nonce); ?>" />
            <table>
                <thead>
                    <tr>
                        <th>Cerca risultato Doppio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="tappa">Seleziona tappa</label>
                        </td>
                        <td>
                            <select name="tappa">
                                <?php
                                    $res = wintertour_elencaTurni();
                                    
                                    if(!$res) {
                                ?>
                                    <option disabled="disabled" selected="selected" value="">--Non esiste nessuna tappa--</option>
                                <?php } else { ?>
                                    <option disabled="disabled" selected="selected" value="">--Selezionare una tappa--</option>
                                <?php }
                                    
                                    foreach ($res as $x) {
                                        $circolo = wintertour_getcircolo($x->circolo);
                                    ?>
                                        <option value="<?=$x->ID?>"<?php if($x->ID === $_POST['tappa']) { ?> selected="selected"<?php } ?>><?=wintertour_localdate($x->data)?> - <?=$circolo->nome?> - <?=wintertour_getCategoria($x->ID)?></option>
                                    <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio21" type="text" placeholder="Cerca giocatore 1" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio21" class="searchbox autocompletion">
                                <option disabled="disabled" selected="selected" value="">--Cercare giocatore 1--</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio22" type="text" placeholder="Cerca giocatore 2" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio22" class="searchbox autocompletion">
                                <option disabled="disabled" selected="selected" value="">--Cercare giocatore 2--</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio23" type="text" placeholder="Cerca giocatore 3" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio23" class="searchbox autocompletion">
                                <option disabled="disabled" selected="selected" value="">--Cercare giocatore 3--</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio24" type="text" placeholder="Cerca giocatore 4" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio24" class="searchbox autocompletion">
                                <option disabled="disabled" selected="selected" value="">--Cercare giocatore 4--</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <input type="hidden" name="doppio" value="doppio" />
                            <input type="submit" name="ricerca" value="Cerca" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    <?php } else if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'add') { ?>
        <h3>Carica risultati</h3>
        <select class="showone">
            <option value="singolo"<?php if(isset($_POST['singolo'])) { ?> selected="selected"<?php } ?>>Singolo</option>
            <option value="doppio"<?php if(isset($_POST['doppio'])) { ?> selected="selected"<?php } ?>>Doppio</option>
        </select><br /><br />
        <form id="singolo"<?php if(isset($_POST['doppio'])) { ?> style="display:none;"<?php } ?> action="<?php echo admin_url('admin.php?page=wintertour_carica_risultati&action=add'); ?>" method="post">
            <input name="wt_nonce" type="hidden" value="<?php echo wp_create_nonce(wt_nonce); ?>" />
            <table>
                <thead>
                    <tr>
                        <th>Carica risultato Singolo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="tappa">Seleziona tappa</label>
                        </td>
                        <td>
                            <select name="tappa">
                                <?php
                                    $res = wintertour_elencaTurni();
                                    
                                    if(!$res) {
                                ?>
                                    <option disabled="disabled" selected="selected" value="">--Non esiste nessuna tappa--</option>
                                <?php } else { ?>
                                    <option disabled="disabled" selected="selected" value="">--Selezionare una tappa--</option>
                                <?php }
                                    
                                    foreach ($res as $x) {
                                        $circolo = wintertour_getcircolo($x->circolo);
                                    ?>
                                        <option value="<?=$x->ID?>"<?php if($x->ID === $_POST['tappa']) { ?> selected="selected"<?php } ?>><?=wintertour_localdate($x->data)?> - <?=$circolo->nome?> - <?=wintertour_getCategoria($x->ID)?></option>
                                    <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio11" type="text" placeholder="Cerca giocatore 1" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio11" class="searchbox autocompletion">
                                <option disabled="disabled" selected="selected" value="">--Cercare giocatore 1--</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio12" type="text" placeholder="Cerca giocatore 2" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio12" class="searchbox autocompletion">
                                <option disabled="disabled" selected="selected" value="">--Cercare giocatore 2--</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="set1sq1">Primo set squadra 1</label> <input name="set1sq1" type="text" placeholder="Primo set squadra 1" />
                        </td>
                        <td>
                            <label for="set1sq2">Primo set squadra 2</label> <input name="set1sq2" type="text" placeholder="Primo set squadra 2" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="set2sq1">Secondo set squadra 1</label> <input name="set2sq1" type="text" placeholder="Secondo set squadra 1" />
                        </td>
                        <td>
                            <label for="set2sq2">Secondo set squadra 2</label> <input name="set2sq2" type="text" placeholder="Secondo set squadra 2" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="set3sq1">Terzo set squadra 1</label> <input name="set3sq1" type="text" placeholder="Terzo set squadra 1" />
                        </td>
                        <td>
                            <label for="set3sq2">Terzo set squadra 2</label> <input name="set3sq2" type="text" placeholder="Terzo set squadra 2" />
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <input type="submit" name="singolo" value="Aggiungi" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
        <form id="doppio"<?php if(!isset($_POST['doppio'])) { ?> style="display:none;"<?php } ?> action="<?php echo admin_url('admin.php?page=wintertour_carica_risultati&action=add'); ?>" method="post">
            <input name="wt_nonce" type="hidden" value="<?php echo wp_create_nonce(wt_nonce); ?>" />
            <table>
                <thead>
                    <tr>
                        <th>Carica risultato Doppio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="tappa">Seleziona tappa</label>
                        </td>
                        <td>
                            <select name="tappa">
                                <?php
                                    $res = wintertour_elencaTurni();
                                    
                                    if(!$res) {
                                ?>
                                    <option disabled="disabled" selected="selected" value="">--Non esiste nessuna tappa--</option>
                                <?php } else { ?>
                                    <option disabled="disabled" selected="selected" value="">--Selezionare una tappa--</option>
                                <?php }
                                    
                                    foreach ($res as $x) {
                                        $circolo = wintertour_getcircolo($x->circolo);
                                    ?>
                                        <option value="<?=$x->ID?>"<?php if($x->ID === $_POST['tappa']) { ?> selected="selected"<?php } ?>><?=wintertour_localdate($x->data)?> - <?=$circolo->nome?> - <?=wintertour_getCategoria($x->ID)?></option>
                                    <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio21" type="text" placeholder="Cerca giocatore 1" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio21" class="searchbox autocompletion">
                                <option disabled="disabled" selected="selected" value="">--Cercare giocatore 1--</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio22" type="text" placeholder="Cerca giocatore 2" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio22" class="searchbox autocompletion">
                                <option disabled="disabled" selected="selected" value="">--Cercare giocatore 2--</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio23" type="text" placeholder="Cerca giocatore 3" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio23" class="searchbox autocompletion">
                                <option disabled="disabled" selected="selected" value="">--Cercare giocatore 3--</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio24" type="text" placeholder="Cerca giocatore 4" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio24" class="searchbox autocompletion">
                                <option disabled="disabled" selected="selected" value="">--Cercare giocatore 4--</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="set1sq1">Primo set squadra 1</label> <input name="set1sq1" type="text" placeholder="Primo set squadra 1" />
                        </td>
                        <td>
                            <label for="set1sq2">Primo set squadra 2</label> <input name="set1sq2" type="text" placeholder="Primo set squadra 2" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="set2sq1">Secondo set squadra 1</label> <input name="set2sq1" type="text" placeholder="Secondo set squadra 1" />
                        </td>
                        <td>
                            <label for="set2sq2">Secondo set squadra 2</label> <input name="set2sq2" type="text" placeholder="Secondo set squadra 2" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="set3sq1">Terzo set squadra 1</label> <input name="set3sq1" type="text" placeholder="Terzo set squadra 1" />
                        </td>
                        <td>
                            <label for="set3sq2">Terzo set squadra 2</label> <input name="set3sq2" type="text" placeholder="Terzo set squadra 2" />
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <input type="submit" name="doppio" value="Aggiungi" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    <?php } else if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'view') {
        if($_POST['ricerca']) {
            $risultati = wintertour_cercaRisultatiSingolo();
        } else {
            $risultati = wintertour_elencaRisultatiSingolo();
        }
    ?>
        <select class="showone">
            <option value="singolo"<?php if(isset($_REQUEST['singolo'])) { ?> selected="selected"<?php } ?>>Singolo</option>
            <option value="doppio"<?php if(isset($_REQUEST['doppio'])) { ?> selected="selected"<?php } ?>>Doppio</option>
        </select><br /><br />
        <?php if(count($risultati) > 0) { ?>
            <div id="singolo"<?php if(isset($_REQUEST['doppio'])) { ?> style="display:none;"<?php } ?>>
            <h3><?=(isset($_POST['ricerca'])) ? "Risultati della ricerca" : "Elenco risultati singolo"?></h3>
            <table class="output-table">
                <thead>
                    <tr>
                        <th style="border:0;"></th>
                        <th>Squadra 1</th>
                        <th>Squadra 2</th>
                        <th colspan="5" style="border:0;"></th>
                    </tr>
                    <tr>
                        <th>Azione</th>
                        <th>Giocatore 1</th>
                        <th>Giocatore 2</th>
                        <th>Tappa</th>
                        <th>Set 1</th>
                        <th>Set 2</th>
                        <th>Set 3</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($risultati as $index => $riga) {
                        $giocatore1 = wintertour_get_socio($riga->giocatore1);
                        $giocatore2 = wintertour_get_socio($riga->giocatore2);
                        $turno = wintertour_get_turno($riga->turno);
                        $circolo = wintertour_getcircolo($turno->circolo);
                        
                        $set1 = wintertour_get_set($riga->set1);
                        $set2 = wintertour_get_set($riga->set2);
                        $set3 = ($riga->set3 !== NULL) ? wintertour_get_set($riga->set3) : NULL;
                    ?>
                        <tr>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_carica_risultati&action=edit&risultato=' . $riga->ID); ?>">Gestisci</a>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $giocatore1->ID); ?>"><?=$giocatore1->cognome?> <?=$giocatore1->nome?></a>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $giocatore2->ID); ?>"><?=$giocatore2->cognome?> <?=$giocatore2->nome?></a>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_turni&action=turniedit&turno=' . $turno->ID); ?>"><?=wintertour_localdate($turno->data)?> <?=$circolo->nome?> - <?=wintertour_getCategoria($turno->ID)?></a>
                            </td>
                            <td><?=$set1->partitesquadra1?>-<?=$set1->partitesquadra2?></td>
                            <td><?=$set2->partitesquadra1?>-<?=$set2->partitesquadra2?></td>
                            <td><?=($set3 !== NULL) ? ($set3->partitesquadra1 . "-" . $set3->partitesquadra2) : "No"?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        <?php } else { ?>
            <div id="singolo"<?php if(isset($_REQUEST['doppio'])) { ?> style="display:none;"<?php } ?>><h3>Nessun risultato singolo</h3></div>
        <?php
            
            }
            
            if($_POST['ricerca']) {
                $risultati = wintertour_cercaRisultatiDoppio();
            } else {
                $risultati = wintertour_elencaRisultatiDoppio();
            }
        ?>
        <?php if(count($risultati) > 0) { ?>
            <div id="doppio"<?php if(!isset($_REQUEST['doppio'])) { ?> style="display:none;"<?php } ?>>
            <h3><?=(isset($_POST['ricerca'])) ? "Risultati della ricerca" : "Elenco risultati doppio"?></h3>
            <table class="output-table">
                <thead>
                    <tr>
                        <th style="border:0;"></th>
                        <th colspan="2">Squadra 1</th>
                        <th colspan="2">Squadra 2</th>
                        <th colspan="5" style="border:0;"></th>
                    </tr>
                    <tr>
                        <th>Azione</th>
                        <th>Giocatore 1</th>
                        <th>Giocatore 2</th>
                        <th>Giocatore 1</th>
                        <th>Giocatore 2</th>
                        <th>Tappa</th>
                        <th>Set 1</th>
                        <th>Set 2</th>
                        <th>Set 3</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($risultati as $index => $riga) {
                        $giocatore1 = wintertour_get_socio($riga->giocatore1);
                        $giocatore2 = wintertour_get_socio($riga->giocatore2);
                        $giocatore3 = wintertour_get_socio($riga->giocatore3);
                        $giocatore4 = wintertour_get_socio($riga->giocatore4);
                        $turno = wintertour_get_turno($riga->turno);
                        $circolo = wintertour_getcircolo($turno->circolo);
                        
                        $set1 = wintertour_get_set($riga->set1);
                        $set2 = wintertour_get_set($riga->set2);
                        $set3 = ($riga->set3 !== NULL) ? wintertour_get_set($riga->set3) : NULL;
                    ?>
                        <tr>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_carica_risultati&action=edit&risultato=' . $riga->ID); ?>">Gestisci</a>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $giocatore1->ID); ?>"><?=$giocatore1->cognome?> <?=$giocatore1->nome?></a>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $giocatore3->ID); ?>"><?=$giocatore3->cognome?> <?=$giocatore3->nome?></a>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $giocatore2->ID); ?>"><?=$giocatore2->cognome?> <?=$giocatore2->nome?></a>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $giocatore4->ID); ?>"><?=$giocatore4->cognome?> <?=$giocatore4->nome?></a>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_turni&action=turniedit&turno=' . $turno->ID); ?>"><?=wintertour_localdate($turno->data)?> <?=$circolo->nome?> - <?=wintertour_getCategoria($turno->ID)?></a>
                            </td>
                            <td><?=$set1->partitesquadra1?>-<?=$set1->partitesquadra2?></td>
                            <td><?=$set2->partitesquadra1?>-<?=$set2->partitesquadra2?></td>
                            <td><?=($set3 !== NULL) ? ($set3->partitesquadra1 . "-" . $set3->partitesquadra2) : "No"?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        <?php } else { ?>
            <div id="doppio"<?php if(!isset($_REQUEST['doppio'])) { ?> style="display:none;"<?php } ?>><h3>Nessun risultato doppio</h3></div>
        <?php } ?>
    <?php } else if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'edit') {
            $risultato = wintertour_getrisultato($_REQUEST['risultato']);
    ?>
        <form method="post">
            <input name="ID" type="hidden" value="<?=$_REQUEST['risultato']?>" />
            <input name="wt_nonce" type="hidden" value="<?php echo wp_create_nonce(wt_nonce); ?>" />
            <table>
                <thead>
                    <tr>
                        <th>Modifica risultato</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="tappa">Seleziona tappa</label>
                        </td>
                        <td>
                            <select name="tappa">
                                <?php
                                    $res = wintertour_elencaTurni();
                                    
                                    if(!$res) {
                                ?>
                                    <option disabled="disabled" selected="selected" value="">--Non esiste nessuna tappa--</option>
                                <?php } else { ?>
                                    <option disabled="disabled" selected="selected" value="">--Selezionare una tappa--</option>
                                <?php }
                                    
                                    foreach ($res as $x) {
                                        $circolo = wintertour_getcircolo($x->circolo);
                                    ?>
                                        <option value="<?=$x->ID?>"<?php if($x->ID === $risultato->turno) { ?> selected="selected"<?php } ?>><?=wintertour_localdate($x->data)?> - <?=$circolo->nome?> - <?=wintertour_getCategoria($x->ID)?></option>
                                    <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio21" type="text" placeholder="Cerca giocatore 1" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio21" class="searchbox autocompletion">
                                <?php
                                    $giocatore1 = wintertour_get_socio($risultato->giocatore1);
                                ?>
                                <option disabled="disabled" selected="selected" value="">--Selezionare giocatore 1--</option>
                                <option selected="selected" value="<?=$giocatore1->ID?>"><?=$giocatore1->cognome?> <?=$giocatore1->nome?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio22" type="text" placeholder="Cerca giocatore 2" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio22" class="searchbox autocompletion">
                                <?php
                                    $giocatore2 = wintertour_get_socio($risultato->giocatore2);
                                ?>
                                <option disabled="disabled" selected="selected" value="">--Selezionare giocatore 2--</option>
                                <option selected="selected" value="<?=$giocatore2->ID?>"><?=$giocatore2->cognome?> <?=$giocatore2->nome?></option>
                            </select>
                        </td>
                    </tr>
                    <?php if($risultato->giocatore3 != NULL && $risultato->giocatore4 != NULL) { ?>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio23" type="text" placeholder="Cerca giocatore 3" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio23" class="searchbox autocompletion">
                                <?php
                                    $giocatore3 = wintertour_get_socio($risultato->giocatore3);
                                ?>
                                <option disabled="disabled" selected="selected" value="">--Selezionare giocatore 3--</option>
                                <option selected="selected" value="<?=$giocatore3->ID?>"><?=$giocatore3->cognome?> <?=$giocatore3->nome?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 0; width: 45%;">
                            <input data-autocompname="socio24" type="text" placeholder="Cerca giocatore 4" class="searchbox autocompletion" />
                        </td>
                        <td width="60%" style="padding: 0; width: 55%;">
                            <select data-autocomptype="soci" name="socio24" class="searchbox autocompletion">
                                <?php
                                    $giocatore4 = wintertour_get_socio($risultato->giocatore4);
                                ?>
                                <option disabled="disabled" selected="selected" value="">--Selezionare giocatore 4--</option>
                                <option selected="selected" value="<?=$giocatore4->ID?>"><?=$giocatore4->cognome?> <?=$giocatore4->nome?></option>
                            </select>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php
                        $set1 = wintertour_get_set($risultato->set1);
                        $set2 = wintertour_get_set($risultato->set2);
                        $set3 = ($risultato->set3 !== NULL) ? wintertour_get_set($risultato->set3) : NULL;
                    ?>
                    <tr>
                        <td>
                            <label for="set1sq1">Primo set squadra 1</label> <input name="set1sq1" type="text" placeholder="Primo set squadra 1" value="<?=$set1->partitesquadra1?>" />
                        </td>
                        <td>
                            <label for="set1sq2">Primo set squadra 2</label> <input name="set1sq2" type="text" placeholder="Primo set squadra 2" value="<?=$set1->partitesquadra2?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="set2sq1">Secondo set squadra 1</label> <input name="set2sq1" type="text" placeholder="Secondo set squadra 1" value="<?=$set2->partitesquadra1?>" />
                        </td>
                        <td>
                            <label for="set2sq2">Secondo set squadra 2</label> <input name="set2sq2" type="text" placeholder="Secondo set squadra 2" value="<?=$set2->partitesquadra2?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="set3sq1">Terzo set squadra 1</label> <input name="set3sq1" type="text" placeholder="Terzo set squadra 1" value="<?=$set3->partitesquadra1?>" />
                        </td>
                        <td>
                            <label for="set3sq2">Terzo set squadra 2</label> <input name="set3sq2" type="text" placeholder="Terzo set squadra 2" value="<?=$set3->partitesquadra2?>" />
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td align="center">
                            <input style="width:200px;" class="confirm" name="delete" type="submit" value="Elimina" />
                        </td>
                        <td align="center">
                            <input style="width:200px;" name="edit" type="submit" value="Modifica" />
                        </td>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    <?php } ?>
</div>