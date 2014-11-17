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
    }
?>
<div class="wgest_page wgest_opt">
    <h1>Gestionale WinterTour</h1>
    <h2>Gestione punteggi</h2>
    
    <noscript>
        Per avere a disposizione tutte le funzionalità di questo sito è necessario abilitare Javascript. Qui ci sono tutte le <a href="http://www.enable-javascript.com/it/" target="_blank"> istruzioni su come abilitare JavaScript nel tuo browser</a>.
    </noscript>
    
    <p>
        <a href="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=add'); ?>">Aggiungi punteggio</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=view'); ?>">Consulta e modifica punteggi</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=search'); ?>">Ricerca e modifica punteggi</a>
    </p>
    
    <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'add') { ?>
        <form action="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=add'); ?>" method="post">
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
                            <label for="dataeora">Punteggio: </label>
                        </td>
                        <td>
                            <input name="dataeora" type="text" placeholder="Punteggio" />
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <input name="punteggioadd" type="submit" value="Aggiungi" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    <?php } else if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'view') {
        $punteggi = wintertour_elencapunteggi();
    ?>
        <form action="<?php echo admin_url('admin.php?page=wintertour_punteggi&action=add'); ?>" method="post">
            <?php if(count($punteggi) > 0) { ?>
                <h3>Elenco punteggi</h3>
                <table class="output-table">
                    <thead>
                        <tr>
                            <th>Azione</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            <?php  } else { ?>
                <h3>Nessun punteggio</h3>
            <?php } ?>
        </form>
    <?php } ?>
</div>