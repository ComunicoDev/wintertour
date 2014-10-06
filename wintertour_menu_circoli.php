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
	
	if(isset($_POST['submit0'])) {
		wintertour_addCircolo();
	}
?>
<div class="wgest_page wgest_soci">
	<h1>Gestionale WinterTour</h1>
	<h2>Gestione Circoli</h2>
	
	<form action="" method="post">
		<table cellpadding="2" cellspacing="0" border="0">
			<thead>
				<tr>
					<th colspan="2">
						<h3>Aggiungi nuovo circolo</h3>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<label for="nomecircolo">Nome circolo:</label>
					</td>
					<td>
						<input name="nomecircolo" id="nomecircolo" type="text" placeholder="Nome circolo" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="indirizzocircolo">Indirizzo circolo:</label>
					</td>
					<td>
						<input name="indirizzocircolo" id="indirizzocircolo" type="text" placeholder="Indirizzo circolo" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="capcircolo">CAP circolo:</label>
					</td>
					<td>
						<input name="capcircolo" id="capcircolo" type="text" placeholder="CAP circolo" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="cittacircolo">Citt&agrave; circolo:</label>
					</td>
					<td>
						<input name="cittacircolo" id="cittacircolo" type="text" placeholder="Citt&agrave; circolo" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="provinciacircolo">Provincia circolo:</label>
					</td>
					<td>
						<input name="provinciacircolo" id="provinciacircolo" type="text" placeholder="Provincia circolo" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="referentecircolo">Referente circolo:</label>
					</td>
					<td>
						<table cellpadding="0" cellspacing="0" border="0" style="min-width: 500px; width: 500px;">
							<tr>
								<td width="40%" style="padding: 0; width: 45%;">
									<input type="text" id="referentecircolo" placeholder="Cerca un socio" />
								</td>
								<td width="60%" style="padding: 0; width: 55%;">
									<select name="referentecircolo" id="mySelect" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
										<option disabled="disabled" selected="selected" value=""><?php
											global $wpdb;
											
											$count = $wpdb->get_var("SELECT COUNT(*) FROM `wintertourtennis_soci`;");
											
											echo ($count == NULL || $count <= 0) ? '--Non esistono soci--' : '--Cercare un socio--';
										?></option>
									</select>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<label for="certificatomedico">Sovrascrivi circolo referente:</label>
					</td>
					<td>
						<table style="min-width: 500px; width: 500px;">
							<tr>
								<td width="40%" style="width: 40%;">
									<input name="certificatomedico" id="certificatomedico1" type="radio" value="1" checked="checked" />S&igrave;
								</td>
								<td width="60%" style="width: 60%;">
									<input name="certificatomedico" id="certificatomedico0" type="radio" value="0" />No
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<td colspan="2" align="center">
					<input name="submit0" id="submit0" type="submit" value="Aggiungi" />
				</td>
			</tfoot>
		</table>
	</form>
	<script>
		jQuery(document).ready(function() {
			var esistonoUtenti = false;
			var current = null;
			
			if(jQuery('select option').text() === '--Cercare un socio--') {
				esistonoUtenti = true;
			}
			
			jQuery('#referentecircolo').val('');
			
			jQuery('#referentecircolo').bind("input", function() {
				if(current != null && typeof(current) === 'object' && current.abort) {
					current.abort();
				}
				
				var data = {
					action: 'wintertour_autocomplete',
					select: 'soci',
					partial: jQuery('#referentecircolo').val(),
					wt_nonce: '<?php echo wp_create_nonce(wt_nonce); ?>'
				};
				
				if(data.partial.length > 0) {
					current = jQuery.ajax({
						type : 'POST',
						url: ajaxurl,
						data: data,
						success: function(response) {
							var obj = jQuery.parseJSON(response);
							var y = jQuery('#mySelect')[0];
							
							while(y.length > 0) {
								y.remove(y.length - 1);
							}
							
							if(obj != null && obj.length > 0) {
								for(var i = 0; i < obj.length; i++) {
									var x = obj[i];
									var option = document.createElement('option');
									option.value = x.ID;
									option.text = x.nome + ' ' + x.cognome;
									
									y.add(option);
								}
							} else {
								var option = document.createElement('option');
								option.value = '';
								option.text = (esistonoUtenti) ? '--Nessun risultato--' : '--Non esistono soci--';
								option.disabled = true;
								y.add(option);
								y.selectedIndex = 0;
							}
						}
					});
				} else {
					var y = jQuery('#mySelect')[0];
					
					while(y.length > 0) {
						y.remove(y.length - 1);
					}
					
					var option = document.createElement('option');
					option.value = '';
					option.text = (esistonoUtenti) ? '--Cercare un socio--' : '--Non esistono soci--';
					option.disabled = true;
					y.add(option);
					y.selectedIndex = 0;
				}
			});
		});
	</script>
</div>