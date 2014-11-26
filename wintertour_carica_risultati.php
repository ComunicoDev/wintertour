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
    
    if(isset($_POST['punteggioadd'])) {
        wintertour_addPunteggio();
    } else if(isset($_POST['punteggiomodifica'])) {
        wintertour_edit_punteggio($_POST['punteggioid'], $_POST['punteggio'], $_POST['turno'], $_POST['socio']);
    } else if(isset($_POST['singolo'])) {
        wintertour_addRisultato(array(
            'giocatore1' => $_POST['socio11'],
            'giocatore2' => $_POST['socio12'],
            'puntigiocatori1e3' => $_POST['punteggio1'],
            'puntigiocatori2e4' => $_POST['punteggio2'],
            'turno' => $_POST['tappa']
        ));
    } else if(isset($_POST['doppio'])) {
        wintertour_addRisultato(array(
            'giocatore1' => $_POST['socio21'],
            'giocatore2' => $_POST['socio22'],
            'giocatore3' => $_POST['socio23'],
            'giocatore4' => $_POST['socio24'],
            'puntigiocatori1e3' => $_POST['punteggio1'],
            'puntigiocatori2e4' => $_POST['punteggio2'],
            'turno' => $_POST['tappa']
        ));
    }
?>
<div class="wgest_page wgest_opt">
    <h1>Gestionale WinterTour</h1>
    <h2>Gestione risultati</h2>
    
    <noscript>
        Per avere a disposizione tutte le funzionalità di questo sito è necessario abilitare Javascript. Qui ci sono tutte le <a href="http://www.enable-javascript.com/it/" target="_blank"> istruzioni su come abilitare JavaScript nel tuo browser</a>.
    </noscript>
    
    <p>
        <a href="<?php echo admin_url('admin.php?page=wintertour_carica_risultati&action=add'); ?>">Carica risultati</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_carica_risultati&action=view'); ?>">Consulta e modifica risultati</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_carica_risultati&action=search'); ?>">Ricerca e modifica risultati</a>
    </p>
    
    <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'add') { ?>
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
                                        <option value="<?=$x->ID?>"<?php if($x->ID === $_POST['tappa']) { ?> selected="selected"<?php } ?>><?=$x->dataeora?> - <?=$circolo->nome?></option>
                                    <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="categoria">Seleziona categoria</label></td>
                        <td>
                            <?php
                                echo wintertour_selectCategorie(array(
                                    'name' => 'categoria'
                                ), $_POST['categoria']);
                            ?>
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
                            <label for="punteggio1">Punteggio squadra 1</label>
                        </td>
                        <td>
                            <input name="punteggio1" type="text" placeholder="Punteggio squadra 1" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="punteggio2">Punteggio squadra 2</label>
                        </td>
                        <td>
                            <input name="punteggio2" type="text" placeholder="Punteggio squadra 2" />
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
                                        <option value="<?=$x->ID?>"<?php if($x->ID === $_POST['tappa']) { ?> selected="selected"<?php } ?>><?=$x->dataeora?> - <?=$circolo->nome?></option>
                                    <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="categoria">Seleziona categoria</label></td>
                        <td>
                            <?php
                                echo wintertour_selectCategorie(array(
                                    'name' => 'categoria'
                                ), $_POST['categoria']);
                            ?>
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
                            <label for="punteggio1">Punteggio squadra 1</label>
                        </td>
                        <td>
                            <input name="punteggio1" type="text" placeholder="Punteggio squadra 1" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="punteggio2">Punteggio squadra 2</label>
                        </td>
                        <td>
                            <input name="punteggio2" type="text" placeholder="Punteggio squadra 2" />
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
        $risultati = wintertour_elencaRisultatiSingolo();
    ?>
        <select class="showone">
            <option value="singolo"<?php if(isset($_REQUEST['singolo'])) { ?> selected="selected"<?php } ?>>Singolo</option>
            <option value="doppio"<?php if(isset($_REQUEST['doppio'])) { ?> selected="selected"<?php } ?>>Doppio</option>
        </select><br /><br />
        <?php if(count($risultati) > 0) { ?>
            <div id="singolo">
            <h3>Elenco risultati singolo</h3>
            <table class="output-table">
                <thead>
                    <tr>
                        <th>Azione</th>
                        <th>Giocatore 1</th>
                        <th>Giocatore 2</th>
                        <th>Punti squadra 1</th>
                        <th>Punti squadra 2</th>
                        <th>Categoria</th>
                        <th>Tappa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($risultati as $index => $riga) {
                        $giocatore1 = wintertour_get_socio($riga->giocatore1);
                        $giocatore2 = wintertour_get_socio($riga->giocatore2);
                        $turno = wintertour_get_turno($riga->turno);
                        $circolo = wintertour_getcircolo($turno->circolo);
                        $categoria = wintertour_getCategoria($turno->ID);
                    ?>
                        <tr>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=edit&punteggio=' . $riga->ID); ?>">Gestisci</a>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $giocatore1->ID); ?>"><?=$giocatore1->cognome?> <?=$giocatore1->nome?></a>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $giocatore2->ID); ?>"><?=$giocatore2->cognome?> <?=$giocatore2->nome?></a>
                            </td>
                            <td><?=$riga->puntigiocatori1e3?></td>
                            <td><?=$riga->puntigiocatori2e4?></td>
                            <td><?=$categoria?></td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_turni&action=turniedit&turno=' . $turno->ID); ?>"><?=$turno->dataeora?> <?=$circolo->nome?></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        <?php } else { ?>
            <h3>Nessun risultato singolo</h3>
        <?php } $risultati = wintertour_elencaRisultatiDoppio(); ?>
        <?php if(count($risultati) > 0) { ?>
            <div id="doppio" style="display:none;">
            <h3>Elenco risultati doppio</h3>
            <table class="output-table">
                <thead>
                    <tr>
                        <th>Azione</th>
                        <th>Giocatore 1</th>
                        <th>Giocatore 2</th>
                        <th>Giocatore 3</th>
                        <th>Giocatore 4</th>
                        <th>Punti squadra 1</th>
                        <th>Punti squadra 2</th>
                        <th>Tappa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($risultati as $index => $riga) {
                        $giocatore1 = wintertour_get_socio($riga->giocatore1);
                        $giocatore2 = wintertour_get_socio($riga->giocatore2);
                        $giocatore3 = wintertour_get_socio($riga->giocatore3);
                        $giocatore4 = wintertour_get_socio($riga->giocatore4);
                        $turno = wintertour_get_turno($riga->turno);
                    ?>
                        <tr>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=edit&punteggio=' . $riga->ID); ?>">Gestisci</a>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $giocatore1->ID); ?>"><?=$giocatore1->cognome?> <?=$giocatore1->nome?></a>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $giocatore2->ID); ?>"><?=$giocatore2->cognome?> <?=$giocatore2->nome?></a>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $giocatore3->ID); ?>"><?=$giocatore3->cognome?> <?=$giocatore3->nome?></a>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $giocatore4->ID); ?>"><?=$giocatore4->cognome?> <?=$giocatore4->nome?></a>
                            </td>
                            <td><?=$riga->puntigiocatori1e3?></td>
                            <td><?=$riga->puntigiocatori2e4?></td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_turni&action=turniedit&turno=' . $turno->ID); ?>"><?=$turno->dataeora?> <?=$circolo->nome?></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        <?php } else { ?>
            <h3>Nessun risultato doppio</h3>
        <?php } ?>
    <?php } else if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'edit') { ?>
    <?php } ?>
</div>