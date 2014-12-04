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
    
    global $categorie;
    
    if(isset($_POST['punteggioadd'])) {
        wintertour_addPunteggio();
    } else if(isset($_POST['punteggiomodifica'])) {
        wintertour_edit_punteggio($_POST['punteggioid'], $_POST['punteggio'], $_POST['turno'], $_POST['socio']);
    }
?>
<div class="wgest_page wgest_opt">
    <a href="<?php echo admin_url('admin.php?page=wintertour'); ?>"><h1>Gestionale WinterTour</h1></a>
    <?=winterMenu()?>
    <h2>Visualizzazione Classifica</h2>
    
    <noscript>
        Per avere a disposizione tutte le funzionalità di questo sito è necessario abilitare Javascript. Qui ci sono tutte le <a href="http://www.enable-javascript.com/it/" target="_blank"> istruzioni su come abilitare JavaScript nel tuo browser</a>.
    </noscript>
    <?php if(isset($_REQUEST['categoria']) && intval($_REQUEST['categoria']) >= 0) { ?>
        <?php
            $count = 1;
            $giocatori = wintertour_giocatoriCategoria($_REQUEST['categoria']);
            
            if($giocatori != null && count($giocatori) > 0) {
        ?>
            <h3>Classifica - <?=$categorie[$_REQUEST['categoria']]?></h3>
            <table class="output-table">
                <thead>
                    <tr>
                        <th style="border: 0 !important;"></th>
                        <th style="border: 0 !important;"></th>
                        <th style="border: 0 !important;"></th>
                        <th colspan="<?=wintertour_countTappe()?>" style="text-align: left; padding-left: 8px !important;">
                            Punti delle Tappe
                        </th>
                    </tr>
                    <tr>
                        <th>Posizione</th>
                        <th>Giocatori</th>
                        <th>Totale punti</th>
                        <?php
                            $tappe = wintertour_elencaTappe();
                            
                            foreach($tappe as $tappa) {
                        ?>
                            <th><?=$tappa->nome?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($giocatori as $giocatore) {  ?>
                        <tr>
                            <th><?=$count++?></th>
                            <th><?=$giocatore->cognome?> <?=$giocatore->nome?></th>
                            <td><?=$giocatore->punteggio?></td>
                            <?php
                                foreach($tappe as $circolo) {
                                    $punti = 0;
                                    $turni = wintertour_elencaTurni_withCircoloAndCategoria($circolo->ID, $_REQUEST['categoria']);
                                    foreach($turni as $turno) {
                                        $punteggi = wintertour_elencaTurni_withTurnoAndSocio($turno->ID, $giocatore->ID);
                                        foreach($punteggi as $punteggio) {
                                            $punti += $punteggio->punteggio;
                                        }
                                    }
                            ?>
                                <td><?=$punti?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <h3><?=$categorie[$_REQUEST['categoria']]?> - Nessun punteggio</h3>
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