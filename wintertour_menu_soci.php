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
		wintertour_addTipologiaSoci();
	} else if(isset($_POST['submit1'])) {
		wintertour_addSocio();
	}
?>
<div class="wgest_page wgest_soci">
	<h1>Gestionale WinterTour</h1>
	<h2>Gestione Soci</h2>
	
	
	<p>
		<a href="<?php echo admin_url('admin.php?page=gestionale_soci&addsocio=1'); ?>">Aggiungi Socio o tipologia socio</a><br />
		<a href="<?php echo admin_url('admin.php?page=gestionale_soci&addsocio=0'); ?>">Consulta o modifica tipologie o anagrafica dei soci</a>
	</p>
	
	<?php if(isset($_REQUEST['addsocio']) && $_REQUEST['addsocio'] === '1') { ?>
		<form action="<?php echo admin_url('admin.php?page=gestionale_soci'); ?>" method="post">
			<table cellpadding="2" cellspacing="0" border="0">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Aggiungi nuova tipologia</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<label for="nometipologia">Nome tipologia:</label>
						</td>
						<td>
							<input name="nometipologia" id="nometipologia" type="text" placeholder="Nome tipologia" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="descrizionetipologia">Descrizione tipologia:</label>
						</td>
						<td>
							<input name="descrizionetipologia" id="descrizionetipologia" type="text" placeholder="Descrizione tipologia" />
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
		
		<form action="<?php echo admin_url('admin.php?page=gestionale_soci'); ?>" method="post">
			<table cellpadding="2" cellspacing="0" border="0">
				<thead>
					<tr>
						<th colspan="2">
							<h3>Aggiungi nuovo socio</h3>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<label for="nome">Nome:</label>
						</td>
						<td>
							<input name="nome" id="nome" type="text" placeholder="Nome" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="cognome">Cognome:</label>
						</td>
						<td>
							<input name="cognome" id="cognome" type="text" placeholder="Cognome" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="email">Email:</label>
						</td>
						<td>
							<input name="email" id="email" type="email" placeholder="Email" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="tipologia">Tipologia:</label>
						</td>
						<td>
							<select name="tipologia" id="tipologia">
								<?php
									global $wpdb;
									
									$query = "SELECT `ID`, `nome` FROM `wintertourtennis_tipologie_soci`;";
									$res = $wpdb->get_results($query);
									
									if(!$res) {
								?>
									<option disabled="disabled" selected="selected" value="">--Non esiste nessuna tipologia--</option>
								<?php
									} else {
								?>
									<option disabled="disabled" selected="selected" value="">--Selezionare una tipologia--</option>
								<?php	
									}
									
									foreach ($res as $x) {
										echo "<option value=\"$x->ID\">$x->nome</option>";
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<label for="saldo">Saldo:</label>
						</td>
						<td>
							<input name="saldo" id="saldo" type="number" placeholder="Saldo" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="indirizzo">Indirizzo:</label>
						</td>
						<td>
							<input name="indirizzo" id="indirizzo" type="text" placeholder="Indirizzo" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="citta">Città:</label>
						</td>
						<td>
							<input name="citta" id="citta" type="text" placeholder="Città" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="cap">CAP:</label>
						</td>
						<td>
							<input name="cap" id="cap" type="text" placeholder="CAP" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="provincia">Provincia:</label>
						</td>
						<td>
							<input name="provincia" id="provincia" type="text" placeholder="Provincia" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="telefono">Telefono:</label>
						</td>
						<td>
							<input name="telefono" id="telefono" type="tel" placeholder="Telefono" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="cellulare">Cellulare:</label>
						</td>
						<td>
							<input name="cellulare" id="cellulare" type="tel" placeholder="Cellulare" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="attivo">Stato Attivo:</label>
						</td>
						<td>
							<table>
								<tr>
									<td>
										<input name="attivo" id="attivo1" type="radio" value="1" checked="checked" />Attivo
									</td>
									<td>
										<input name="attivo" id="attivo0" type="radio" value="0" />Inattivo
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<label for="datanascita">Data di Nascita:</label>
						</td>
						<td>
							<input name="datanascita" id="datanascita" type="date" placeholder="gg/mm/aaaa" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="cittanascita">Citt&agrave; di Nascita:</label>
						</td>
						<td>
							<input name="cittanascita" id="cittanascita" type="text" placeholder="Citt&agrave; di Nascita" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="dataiscrizione">Data di Iscrizione:</label>
						</td>
						<td>
							<input name="dataiscrizione" id="dataiscrizione" type="date" placeholder="gg/mm/aaaa" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="codicefiscale">Codice Fiscale:</label>
						</td>
						<td>
							<input name="codicefiscale" id="codicefiscale" type="text" placeholder="Codice Fiscale" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="dataimmissione">Data Immissione:</label>
						</td>
						<td>
							<input name="dataimmissione" id="dataimmissione" type="text" placeholder="gg/mm/aaaa - hh:mm" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="numerotessera">Numero Tessera:</label>
						</td>
						<td>
							<input name="numerotessera" id="numerotessera" type="text" placeholder="Numero Tessera" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="certificatomedico">Certificato Medico:</label>
						</td>
						<td>
							<table style="min-width: 246px; width: 246px;">
								<tr>
									<td>
										<input name="certificatomedico" id="certificatomedico1" type="radio" value="1" checked="checked" />Pervenuto
									</td>
									<td>
										<input name="certificatomedico" id="certificatomedico0" type="radio" value="0" />Non Pervenuto
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<label for="domandaassociazione">Domanda di Associazione:</label>
						</td>
						<td>
							<input name="domandaassociazione" id="domandaassociazione" type="date" placeholder="gg/mm/aaaa" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="circolo">Circolo:</label>
						</td>
						<td>
							<select name="circolo" id="circolo">
								<option>Esempio 1</option>
								<option>Esempio 2</option>
								<option>Esempio 3</option>
							</select>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<td colspan="2" align="center">
						<input name="submit1" id="submit1"  type="submit" value="Aggiungi" />
					</td>
				</tfoot>
			</table>
		</form>
	<?php } else if(isset($_REQUEST['addsocio']) && $_REQUEST['addsocio'] === '0') {
		$soci = wintertour_elencaSoci();
	} ?>
	<?php if(count($soci) > 0) { ?>
		<form class="editor" action="<?php echo admin_url('admin.php?page=gestionale_soci&addsocio=0'); ?>" method="post">
			<h3>Elenco soci</h3>
			<div class="scrolling">
				<table class="output-table">
					<thead>
						<tr>
							<?php foreach($soci[0] as $colonna => $valore) {?>
								<th style="padding:3px"><?=ucfirst($colonna)?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach($soci as $index => $riga) { ?>
							<tr>
								<?php foreach($riga as $colonna => $valore) { ?>
									<td>
										<?=$valore?>
									</td>
								<?php } ?>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<div class="scrollbar"></div>
			</div>
		</form>
	<?php } ?>
</div>