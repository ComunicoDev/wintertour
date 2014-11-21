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
    <h1>Gestionale WinterTour</h1>
    <h2>Visualizzazione Risultati</h2>
    
    <noscript>
        Per avere a disposizione tutte le funzionalità di questo sito è necessario abilitare Javascript. Qui ci sono tutte le <a href="http://www.enable-javascript.com/it/" target="_blank"> istruzioni su come abilitare JavaScript nel tuo browser</a>.
    </noscript>
    
    <!--<p>
        <a href="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=add'); ?>">Aggiungi punteggio</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=view'); ?>">Consulta e modifica punteggi</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=search'); ?>">Ricerca e modifica punteggi</a>
    </p>-->
    <table class="output-table">
        <thead>
            <tr>
                <th>Giocatori | Tappe</th>
                <?php
                    $tappe = wintertour_elencaTappe();
                    
                    foreach($tappe as $tappa) {
                ?>
                    <th><?=$tappa->nome?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
                $giocatori = wintertour_elencaGiocatori();
                
                foreach($giocatori as $giocatore) {
            ?>
                <tr>
                    <th><?=$giocatore->cognome?> <?=$giocatore->nome?></th>
                    <?php
                        $punti = 0;
                        foreach($tappe as $circolo) {
                            $turni = wintertour_elencaTurni_withCircolo($circolo->ID);
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
</div>