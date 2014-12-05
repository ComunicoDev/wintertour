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
    
    if(isset($_POST['socioadd'])) {
        wintertour_addTurno();
    } else if(isset($_POST['turnomodifica'])) {
        wintertour_edit_turno($_POST['ID'], $_POST['data'], $_POST['circolo'], $_POST['categoria']);
    }
?>
<div class="wgest_page wgest_opt">
    <a href="<?php echo admin_url('admin.php?page=wintertour'); ?>"><h1>Gestionale WinterTour</h1></a>
    <?=winterMenu()?>
    <h2>Gestione tappe</h2>
    
    <noscript>
        Per avere a disposizione tutte le funzionalità di questo sito è necessario abilitare Javascript. Qui ci sono tutte le <a href="http://www.enable-javascript.com/it/" target="_blank"> istruzioni su come abilitare JavaScript nel tuo browser</a>.
    </noscript>
    
    <p>
        <a href="<?php echo admin_url('admin.php?page=wintertour_turni&action=add'); ?>">Aggiungi tappa</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_turni&action=view'); ?>">Consulta e modifica tappe</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_turni&action=search'); ?>">Ricerca e modifica tappe</a>
    </p>
    
    <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'search') { ?>
        <form action="<?php echo admin_url('admin.php?page=wintertour_turni&action=view'); ?>" method="post">
            <table>
                <thead>
                    <tr>
                        <th colspan="2">
                            <h3>Cerca tappa</h3>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="data">Data: </label>
                        </td>
                        <td>
                            <input autocomplete="off" name="data" type="text" placeholder="gg/mm/aaaa" class="date" pattern="\d\d\/\d\d/\d{4}" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="circolo">Circolo:</label>
                        </td>
                        <td>
                            <select name="circolo" id="circolo">
                                <?php
                                    $res = wintertour_elencacircoli();
                                    
                                    if(!$res) {
                                ?>
                                    <option disabled="disabled" selected="selected" value="">--Non esiste nessun circolo--</option>
                                <?php } else { ?>
                                    <option disabled="disabled" selected="selected" value="">--Selezionare un circolo--</option>
                                <?php }
                                    
                                    foreach ($res as $x) {
                                        echo "<option value=\"$x->ID\">$x->nome</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="categoria">Categoria:</label>
                        </td>
                        <td>
                            <?=wintertour_selectCategorie(array('name' => 'categoria'))?>
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
        <form action="<?php echo admin_url('admin.php?page=wintertour_turni&action=add'); ?>" method="post">
            <table>
                <thead>
                    <tr>
                        <th colspan="2">
                            <h3>Aggiungi nuova tappa</h3>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="data">Data: </label>
                        </td>
                        <td>
                            <input autocomplete="off" name="data" type="text" placeholder="gg/mm/aaaa" class="date" pattern="\d\d\/\d\d/\d{4}" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="circolo">Circolo:</label>
                        </td>
                        <td>
                            <select name="circolo" id="circolo">
                                <?php
                                    $res = wintertour_elencacircoli();
                                    
                                    if(!$res) {
                                ?>
                                    <option disabled="disabled" selected="selected" value="">--Non esiste nessun circolo--</option>
                                <?php } else { ?>
                                    <option disabled="disabled" selected="selected" value="">--Selezionare un circolo--</option>
                                <?php }
                                    
                                    foreach ($res as $x) {
                                        echo "<option value=\"$x->ID\">$x->nome</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="categoria">Categoria:</label>
                        </td>
                        <td>
                            <?=wintertour_selectCategorie(array('name' => 'categoria'))?>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <input name="socioadd" type="submit" value="Aggiungi" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    <?php } else if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'view') {
        if(isset($_POST['ricerca'])) {
            $turni = wintertour_searchTurni();
        } else {
            $turni = wintertour_elencaturni();
        }
    ?>
        <?php if(count($turni) > 0) { ?>
            <h3><?=(isset($_POST['ricerca'])) ? "Risultati della ricerca" : "Elenco tappe"?></h3>
            <table class="output-table">
                <thead>
                    <tr>
                        <th>Azione</th>
                        <th>ID tappa</th>
                        <th>Data</th>
                        <th>Categoria</th>
                        <th>Circolo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($turni as $index => $riga) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=wintertour_turni&action=turniedit&turno=' . $riga->ID); ?>">Gestisci</a>
                            </td>
                            <td><?=$riga->ID?></td>
                            <td><?=wintertour_localdate($riga->data)?></td>
                            <td><?=wintertour_getCategoria($riga->ID)?></td>
                            <td><a href="<?php echo admin_url('admin.php?page=wintertour_circoli&action=circoliedit&circolo=' . $riga->circolo);?>"><?=wintertour_getcircolo($riga->circolo)->nome?></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php  } else { ?>
            <h3>Nessuna tappa</h3>
        <?php } ?>
    <?php } else if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'turniedit' && isset($_GET['turno'])) {
        $turno = wintertour_get_turno($_GET['turno']);
    ?>
        <form action="<?php echo admin_url('admin.php?page=wintertour_turni&action=turniedit&turno=' . $_GET['turno']); ?>" method="post">
            <input name="ID" type="hidden" value="<?=$turno->ID?>" />
            <table>
                <thead>
                    <tr>
                        <th colspan="2">
                            <h3>Modifica tappa</h3>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="data">Data: </label>
                        </td>
                        <td>    
                            <input name="data" type="text" class="date" placeholder="gg/mm/aaaa" value="<?=format_date($turno->data)?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="circolo">Circolo:</label>
                        </td>
                        <td>
                            <select name="circolo" id="circolo">
                                <?php
                                    $res = wintertour_elencacircoli();
                                    
                                    if(!$res) {
                                ?>
                                    <option disabled="disabled" selected="selected" value="">--Non esiste nessun circolo--</option>
                                <?php } else { ?>
                                    <option disabled="disabled" selected="selected" value="">--Selezionare un circolo--</option>
                                <?php }
                                    
                                    foreach ($res as $x) {
                                        echo "<option " . ((intval($x->ID) === intval($turno->circolo)) ? "selected=\"selected\"" : "" ) . " value=\"$x->ID\">$x->nome</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="categoria">Categoria:</label>
                        </td>
                        <td>
                            <?=wintertour_selectCategorie(array('name' => 'categoria'), $turno->categoria)?>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <input data-autocompname="socio" name="turnomodifica" type="submit" value="Modifica" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    <?php } ?>
</div>
