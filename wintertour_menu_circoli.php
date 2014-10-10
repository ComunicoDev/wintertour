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
		<input name="wt_nonce" type="hidden" value="<?php echo wp_create_nonce(wt_nonce); ?>" />
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
						<?=selectProvincia('provinciacircolo')?>
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
									<input data-autocompname="referentecircolo" type="text" placeholder="Cerca un socio" class="searchbox autocompletion" />
								</td>
								<td width="60%" style="padding: 0; width: 55%;">
									<select data-autocomptype="soci" name="referentecircolo" class="searchbox autocompletion" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
										<option disabled="disabled" selected="selected" value="">--Cercare un socio--</option>
									</select>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<td colspan="2" align="center">
					<input data-autocompname="referentecircolo" class="autocompletion" name="submit0" id="submit0" type="submit" value="Aggiungi" />
				</td>
			</tfoot>
		</table>
	</form>
</div>