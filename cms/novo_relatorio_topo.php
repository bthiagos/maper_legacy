		<div id="cabecalho">

			<table height="100" class="tabela" border="0" style="margin-top: 5px; height: 80px;" >


				<tr>
					<td width="230" rowspan="3" align="center" valign="middle" style="text-align: center; font-size: 17.5px; text-transform: uppercase; color: #58479d;">
						<span style="color: #3fbeb2;">
						<?
						echo mb_strtoupper($nome_rel, $encoding); // retorna VIRÁ
						?>
						</span>
					</td>
				<? $encoding = mb_internal_encoding(); // ou UTF-8, ISO-8859-1... ?>
					<td width="250" nowrap="nowrap" valign="middle"><span style="text-transform: uppercase;  color: #58479d;"><?=mb_strtoupper($cabecalho[0], $encoding)?>: </span> <span style="color: #3fbeb2;"> <?php echo strtoupper(utf8_decode($dados_pessoa["nome"]));?></span></td>

					<td width="250" valign="middle"><span style=" color: #58479d;"><?=$cabecalho[2]?>: </span> <span style="color: #3fbeb2;"><?=mask($dados_pessoa["cpf"], '###.###.###-##'); ?></span></td>


				</tr>

				<tr>

					<td width="200" valign="middle"><span style="text-transform: uppercase;  color: #58479d;"><?=mb_strtoupper($cabecalho[1], $encoding)?>: </span> <span style="color: #3fbeb2;"> <?php echo strtoupper(utf8_decode($dados_pessoa["cargo"]));?></span></td>

					<td width="200" valign="middle"><span style=" color: #58479d;"><?=$cabecalho[3]?>: </span> <span style="color: #3fbeb2;"> <?=$dados_pessoa["nasc"]; ?> </span></td>

				</tr>

				<tr>

					<td width="200">&nbsp;</td>

					<td width="200"><span style=" color: #58479d;"><?=$cabecalho[4]?>: </span> <span style="color: #3fbeb2;"><?=$pdata_aplic; ?></span></td>

				</tr>

			</table>

		</div>