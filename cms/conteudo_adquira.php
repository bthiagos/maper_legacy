<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM adquira WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("Pessoa excluída do cadastro com sucesso!");
	}
	
}

// --- FIM    Efetuando a exlcusao

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

<body>

<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->
<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>
<br><br><br></div>

	<!-- INICIO - DIV global - Emgloba todo o site -->
	<div id="global">
	
		<?php include("topo.php"); ?>	
		
		
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		<?php include("menu.php"); ?>
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
		<div id="principal">
		
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				Adquira - Pessoas inscritas
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						
						<td align="center">Nome</td>
						<td align="center">Tipo de Pessoa</td>
						<td align="center">Sexo</td>
						<td align="center">CPF</td>
						<td align="center">E-mail</td>
						<td align="center">Endereço</td>
						<td align="center">Número</td>
						<td align="center">Bairro</td>
						<td align="center">Complemento</td>
						<td align="center">Cidade</td>
						<td align="center">Estado</td>
						<td align="center">CEP</td>
						<td align="center">Telefone</td>
						<td align="center">CNPJ</td>
						<td align="center">Razão</td>
						<td align="center">Texto</td>
                        <td align="center" width="50">Ações</td>
						
					</tr>
				
					
			<?
				$sql = "SELECT * FROM adquira ORDER BY nome ASC";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["nome"]?></td>
						<td align="center" ><?=$linha["tipoPessoa"]?></td>
						<td align="center" ><?=$linha["sexo"]?></td>
						<td align="center" ><?=$linha["cpf"]?></td>
						<td align="center" ><?=$linha["email"]?></td>
						<td align="center" ><?=$linha["endereco"]?></td>
						<td align="center" ><?=$linha["numero"]?></td>
						<td align="center" ><?=$linha["bairro"]?></td>
						<td align="center" ><?=$linha["complemento"]?></td>
						<td align="center" ><?=$linha["cidade"]?></td>
						
						<td align="center" ><?=$linha["estado"]?></td>
						<td align="center" ><?=$linha["cep"]?></td>
						<td align="center" ><?=$linha["telefone"]?></td>
						<td align="center" ><?=$linha["cnpj"]?></td>
						<td align="center" ><?=$linha["razao"]?></td>
						<td align="center" ><?=$linha["texto"]?></td>

					
						<td align="center" >
							
							<a href="?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir a mensagem?')" alt="Apagar" border="0"></a></td>
					</tr>
				<?
				}
				?>
				</table>


			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			

				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->				
				
		</div>
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
	
	</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>