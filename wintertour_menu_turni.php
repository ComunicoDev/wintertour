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
?>
<div class="wgest_page wgest_opt">
    <h1>Gestionale WinterTour</h1>
    <h2>Gestione turni</h2>
    
    <noscript>
        Per avere a disposizione tutte le funzionalità di questo sito è necessario abilitare Javascript. Qui ci sono tutte le <a href="http://www.enable-javascript.com/it/" target="_blank"> istruzioni su come abilitare JavaScript nel tuo browser</a>.
    </noscript>
    
    <p>
        <a href="<?php echo admin_url('admin.php?page=wintertour_turni&action=add'); ?>">Aggiungi turno</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_turni&action=view'); ?>">Consulta e modifica turni</a><br />
        <a href="<?php echo admin_url('admin.php?page=wintertour_turni&action=search'); ?>">Ricerca e modifica turni</a>
    </p>
    
    <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'add') { ?>
        <form action="<?php echo admin_url('admin.php?page=wintertour_soci&action=add'); ?>" method="post">
            <table>
                <thead>
                    <tr>
                        <th colspan="2">
                            <h3>Aggiungi nuovo turno</h3>
                        </th>
                    </tr>
                </thead>
                <tbody>
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
                            <label for="dataeora">Data: </label>
                        </td>
                        <td>
                            <input autocomplete="off" name="dataeora" type="text" placeholder="gg/mm/aaaa - hh:mm" class="datetime" pattern="\d\d\/\d\d/\d{4} - \d\d:\d\d" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    <?php } ?>
</div>
