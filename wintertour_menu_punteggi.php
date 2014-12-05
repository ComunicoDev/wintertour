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
    }
?>
<div class="wgest_page wgest_opt">
    <a href="<?php echo admin_url('admin.php?page=wintertour'); ?>"><h1>Gestionale WinterTour</h1></a>
    <?=winterMenu()?>
    <h2>Gestione punteggi</h2>
    
    <noscript>
        Per avere a disposizione tutte le funzionalità di questo sito è necessario abilitare Javascript. Qui ci sono tutte le <a href="http://www.enable-javascript.com/it/" target="_blank"> istruzioni su come abilitare JavaScript nel tuo browser</a>.
    </noscript>
    
    <p>
        <a href="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=add'); ?>">Aggiungi punteggio</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=view'); ?>">Gestisci punteggi</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=search'); ?>">Ricerca punteggi</a>
    </p>
    
    <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'search') { ?>
        <form action="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=view'); ?>" method="post">
            <input name="wt_nonce" type="hidden" value="<?php echo wp_create_nonce(wt_nonce); ?>" />
            <table>
                <thead>
                    <tr>
                        <th colspan="2">
                            <h3>Ricerca punteggio</h3>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="turno">Tappa:</label>
                        </td>
                        <td>
                            <select name="turno" id="turno">
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
                                        echo "<option value=\"$x->ID\">" . wintertour_localdate($x->data) . " - $circolo->nome - " . wintertour_getCategoria($x->ID) . "</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="socio">Socio:</label>
                        </td>
                        <td>
                            <table cellpadding="0" cellspacing="0" border="0" style="min-width: 500px; width: 500px;">
                                <tr>
                                    <td width="40%" style="padding: 0; width: 45%;">
                                        <input data-autocompname="socio" type="text" placeholder="Cerca un socio" class="searchbox autocompletion" />
                                    </td>
                                    <td width="60%" style="padding: 0; width: 55%;">
                                        <select data-autocomptype="soci" name="socio" class="searchbox autocompletion">
                                        
                                            <option disabled="disabled" selected="selected" value="">--Cercare un socio--</option>
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
                            <input name="ricerca" type="submit" value="Cerca" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    <?php } else if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'add') { ?>
        <form action="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=add'); ?>" method="post">
            <input name="wt_nonce" type="hidden" value="<?php echo wp_create_nonce(wt_nonce); ?>" />
            <table>
                <thead>
                    <tr>
                        <th colspan="2">
                            <h3>Aggiungi nuovo punteggio</h3>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="punteggio">Punteggio: </label>
                        </td>
                        <td>    
                            <input name="punteggio" type="text" placeholder="Punteggio" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="turno">Tappa:</label>
                        </td>
                        <td>
                            <select name="turno" id="turno">
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
                                        echo "<option value=\"$x->ID\">" . wintertour_localdate($x->data) . " - $circolo->nome - " . wintertour_getCategoria($x->ID) . "</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="socio">Socio:</label>
                        </td>
                        <td>
                            <table cellpadding="0" cellspacing="0" border="0" style="min-width: 500px; width: 500px;">
                                <tr>
                                    <td width="40%" style="padding: 0; width: 45%;">
                                        <input data-autocompname="socio" type="text" placeholder="Cerca un socio" class="searchbox autocompletion" />
                                    </td>
                                    <td width="60%" style="padding: 0; width: 55%;">
                                        <select data-autocomptype="soci" name="socio" class="searchbox autocompletion">
                                            <option disabled="disabled" selected="selected" value="">--Cercare un socio--</option>
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
                            <input data-autocompname="socio" class="autocompletion" name="punteggioadd" type="submit" value="Aggiungi" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    <?php } else if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'view') {
        if(isset($_POST['ricerca'])) {
            $punteggi = wintertour_searchPunteggi();
        } else {
            $punteggi = wintertour_elencapunteggi();
        }
    ?>
        <?php if(count($punteggi) > 0) { ?>
            <h3><?=(isset($_POST['ricerca'])) ? "Risultati della ricerca" : "Elenco punteggi"?></h3>
            <table class="output-table">
                <thead>
                    <tr>
                        <th>Azione</th>
                        <th>Socio</th>
                        <th>Tappa</th>
                        <th>Categoria</th>
                        <th>Punteggio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($punteggi as $index => $riga) {
                        $socio = wintertour_get_socio($riga->socio);
                        $turno = wintertour_get_turno($riga->turno);
                        $circolo = wintertour_getcircolo($turno->circolo)
                    ?>
                        <tr>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=punteggiedit&punteggio=' . $riga->ID); ?>">Gestisci</a>
                            </td>
                            <td><a href="<?php echo admin_url('admin.php?page=wintertour_soci&action=sociedit&socio=' . $socio->ID); ?>"><?=$socio->cognome?> <?=$socio->nome?></a></td>
                            <td><a href="<?php echo admin_url('admin.php?page=wintertour_turni&action=turniedit&turno=' . $turno->ID); ?>"><?=$circolo->nome?> <?=wintertour_localdate($turno->data)?></a></td>
                            <td><?=wintertour_getCategoria($turno->ID)?></td>
                            <td><?=$riga->punteggio?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <h3>Nessun punteggio</h3>
        <?php } ?>
    <?php } else if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'punteggiedit' && isset($_GET['punteggio'])) {
        $punteggio = wintertour_getpunteggio($_GET['punteggio']);
    ?>
        <form action="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=punteggiedit&punteggio=' . $_GET['punteggio']); ?>" method="post">
            <input name="wt_nonce" type="hidden" value="<?php echo wp_create_nonce(wt_nonce); ?>" />
            <input name="punteggioid" type="hidden" value="<?=$punteggio->ID?>" />
            <table>
                <thead>
                    <tr>
                        <th colspan="2">
                            <h3>Modifica punteggio</h3>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="punteggio">Punteggio: </label>
                        </td>
                        <td>    
                            <input name="punteggio" type="text" placeholder="Punteggio" value="<?=$punteggio->punteggio?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="turno">Tappa:</label>
                        </td>
                        <td>
                            <select name="turno" id="turno">
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
                                        echo "<option value=\"$x->ID\"". (($x->ID === $punteggio->turno) ? " selected=\"selected\"" : "") . ">" . wintertour_localdate($x->data) . " - $circolo->nome - " . wintertour_getCategoria($x->ID) . "</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="socio">Socio:</label>
                        </td>
                        <td>
                            <table cellpadding="0" cellspacing="0" border="0" style="min-width: 500px; width: 500px;">
                                <tr>
                                    <td width="40%" style="padding: 0; width: 45%;">
                                        <input data-autocompname="socio" type="text" placeholder="Cerca un socio" class="searchbox autocompletion" />
                                    </td>
                                    <td width="60%" style="padding: 0; width: 55%;">
                                        <select data-autocomptype="soci" name="socio" class="searchbox autocompletion">
                                            <?php
                                                $socio = wintertour_get_socio($punteggio->socio);
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
                            <input data-autocompname="socio" name="punteggiomodifica" type="submit" value="Modifica" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    <?php } ?>
</div>