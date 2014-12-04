<?php
    /**
     * Gestionale WinterTour - Pagina di amministrazione
     *
     * Plugin per gestire i tornei e l'anagrafica e le iscrizioni dei membri
     * @author Comunico S.r.l. <info@comunico.info>
     * @version 1.0
     * @package wintertour
     */
    
    global $categorie;
    
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
    <h2>Tabella Incontri</h2>
    
    <noscript>
        Per avere a disposizione tutte le funzionalità di questo sito è necessario abilitare Javascript. Qui ci sono tutte le <a href="http://www.enable-javascript.com/it/" target="_blank"> istruzioni su come abilitare JavaScript nel tuo browser</a>.
    </noscript>
    <?php if(isset($_REQUEST['categoria']) && intval($_REQUEST['categoria']) >= 0) { ?>
        <?php
            $partecipanti = wintertour_partecipantiCategoria($_REQUEST['categoria']);
            $tappe = wintertour_tappeCategoria($_REQUEST['categoria']);
        ?>
        <?php if (count($partecipanti) > 0 && count($tappe) > 0) { ?>
            <h3>Tabella Incontri - <?=$categorie[$_REQUEST['categoria']]?></h3>
            <table class="output-table">
                <thead>
                    <th>Giocatore</th>
                    <th>Nome</th>
                    <?php foreach($tappe as $tappa) { ?>
                        <?php
                            $circolo = wintertour_getcircolo($tappa->circolo);
                        ?>
                        <th><?=$circolo->nome?></th>
                    <?php } ?>
                </thead>
                <tbody>
                    <?php foreach($partecipanti as $index => $partecipante) { ?>
                        <tr>
                            <td><?=$partecipante->n?></td>
                            <td><?=$partecipante->cognome?> <?=$partecipante->nome?></td>
                            <?php foreach($tappe as $tappa) { ?>
                                <td><?=wintertour_giocatoContro($partecipanti, $index, $tappa->ID)?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <h3><?=$categorie[$_REQUEST['categoria']]?> - Nessun risultato</h3>
        <?php } ?>
    <?php } else { ?>
        <form action="<?=admin_url('admin.php?page=wintertour_tabella_incontri')?>" method="get">
            <input type="hidden" name="page" value="<?=$_REQUEST['page']?>" />
            <table>
                <thead>
                    <tr>
                        <th><label for="categoria"><h3>Seleziona una categoria: </h3></label></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=wintertour_selectCategorie(array('name' => 'categoria'));?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td><input type="submit" value="Visualizza tabella incontri" /></td>
                    </tr>
                </tfoot>
            </table>
        </form>
    <?php } ?>
</div>