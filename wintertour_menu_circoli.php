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
						<label for="cittacircolo">Citt&agrave; circolo:</label>
					</td>
					<td>
						<input name="cittacircolo" id="cittacircolo" type="text" placeholder="Citt&agrave; circolo" />
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
						<input name="referentecircolo_id" type="hidden" value="" />
						<table cellpadding="0" cellspacing="0" border="0" style="min-width: 250; width: 250;">
							<tr>
								<td style="padding: 0;">
									<input type="text" name="referentecircolo" id="referentecircolo" />
								</td>
							</tr>
							<tr>
								<td style="padding: 0;">
									<select id="mySelect">
										<option disabled="disabled" selected="selected" value="">--Nessun referente--</option>
									</select>
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
	<form action="javascript:void(0);" id="lolform" onsubmit="scriviSoci()">
		<input type="submit" value="Scrivi Soci" />
		<textarea id="asd" rows="10" cols="60"></textarea>
	</form>
	<script>
		function scriviSoci() {
			var data = {
				action: 'wintertour_autocomplete',
				select: 'soci',
				wt_nonce: '<?php echo wp_create_nonce(wt_nonce); ?>'
			};
			
			jQuery.post(ajaxurl, data, function(response) {
				jQuery('#asd').val(response);
				
				var obj = jQuery.parseJSON(response);
				var y = document.getElementById("mySelect");
				
				while(y.length > 0) {
					y.remove(y.length - 1);
				}
				
				for(var i = 0; i < obj.length; i++) {
					var x = obj[i];
					console.dir(x);
					var option = document.createElement('option');
					option.value = x.ID;
					option.text = x.nome + ' ' + x.cognome;
					
					y.add(option);
				}
			});
			
			return false;
		}
	</script>
</div>