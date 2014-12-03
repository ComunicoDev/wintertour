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
    
	wp_enqueue_style('wintertour_style');
    wp_enqueue_script('autogiocatore');
    wp_enqueue_script('wintertourschedagiocatore');
?>
<script type="text/javascript">
    var ajaxurl = "<?=admin_url('admin-ajax.php');?>";
</script>
<?php
    if(isset($_POST['giocatoreview'])) {
        $giocatore = wintertour_get_socio($_POST['giocatore']);
        
        if($giocatore != null) {
?>
        <h2>Scheda Giocatore: <?=$giocatore->nome?> <?=$giocatore->cognome?></h2>
    <?php } else { ?>
        <h2>Giocatore non trovato</h2>
    <?php } ?>
<?php } else { ?>
    <div class="wintertour_plugin wintertour_shortcode">
    	<h3>Schede Giocatori</h3>
    	<form method="post">
    	   <input name="wt_nonce" type="hidden" value="<?php echo wp_create_nonce(wt_nonce); ?>" />
    	   <table>
    	       <tbody>
                    <tr>
                        <td>
                            <label for="giocatore">Giocatore:</label>
                        </td>
                        <td>
                            <table cellpadding="0" cellspacing="0" border="0" style="min-width: 500px; width: 500px;">
                                <tr>
                                    <td width="40%" style="padding: 0; width: 45%;">
                                        <input data-autocompname="giocatore" type="text" placeholder="Cerca un giocatore" class="searchbox autogiocatore" />
                                    </td>
                                    <td width="60%" style="padding: 0; width: 55%;">
                                        <select name="giocatore" class="searchbox autogiocatore">
                                            <option disabled="disabled" selected="selected" value="">--Cercare un giocatore--</option>
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
                            <input data-autocompname="giocatore" class="autogiocatore" name="giocatoreview" type="submit" value="Visualizza" />
                        </td>
                    </tr>
                </tfoot>
    	   </table>
    	</form>
    </div>
<?php } ?>