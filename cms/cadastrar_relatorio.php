<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?
$frase = "";
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM relatorios WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		$frase = "Relatorio excluido com sucesso!";
		redireciona("cadastrar_relatorio.php");
	}
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
		
	$n_relatorio  = trim($_POST["n_relatorio"]);
	
	
	$empresa = $_REQUEST["empresa"];
	
	$bloqueio=bloqueio_relatorio($n_relatorio,$empresa);
	
	if($bloqueio == '1'){
				alert("[Error] Relatório $n_relatorio já cadastrado!");
				redireciona("cadastrar_relatorio.php");
				$ok = 0;
	}
	
	if ($ok) {
			
			
		// Gravando dados no banco
			$sql = "INSERT INTO relatorios (relatorio,id_empresa) VALUES ('$n_relatorio','$empresa')";
				
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Relatorio cadastrado com sucesso!");
				redireciona("cadastrar_relatorio.php");
				
			} 	else {
				alert("Relatorio não cadastrado , Erro ao no cadastro!");
				redireciona("cadastrar_relatorio.php");
					}
			
			}
	
 	}
 	
 	
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
				<img src="imagens/barra_cadastra_relatorios.gif" alt="Cadastro dos Cargos" title="Cadastro dos Cargos" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="cadastrar_relatorio.php?cadastra=1" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nº do relatório: </span> </div>
					
					<select name="n_relatorio" class="form_style"> 
						<?						
						for($i=1;$i<=30;$i++){						
						?>
						<option value="<?=$i?>"><?=$i?></option>
						
						<?}?>
					</select>
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Empresa: </span> </div>
					
					<select name="empresa" class="form_style"> 
						<?						
						$sql = "SELECT
								empresa_cargos.empresa,						
								empresa_cargos.id						
								FROM
								empresa_cargos
								Inner Join cargos ON cargos.id_empresa = empresa_cargos.id ORDER BY empresa";
						$result = mysql_query($sql);
						
						while ($linha = mysql_fetch_assoc($result)) {						
						?>
						<option value="<?=$linha["id"]?>"><?=$linha["empresa"]?></option>
						
						<?}?>
					</select>
				</div>

					<p align="center"><input type="submit" value="Cadastrar" class="form_style"></p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->			
			
			
			
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<img src="imagens/barra_gerencia_relatorios.gif" alt="Gerenciamento dos Cargos" title="Gerenciamento dos Cargos" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

			<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center" >Relatorio</td>						
						<td align="center" >Empresa</td>						
						<td align="center" width="10%" nowrap>A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT
						empresa_cargos.empresa,
						relatorios.id,
						relatorios.relatorio
						FROM
						relatorios
						Inner Join empresa_cargos ON empresa_cargos.id = relatorios.id_empresa";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" >
						Relatorio - 
						<?  
							echo $linha["relatorio"];
						?>
						
						</td>
						<td align="center"><?=$linha["empresa"];?></td>
						
						
						<td align="center" width="1%" nowrap>					
								<!-- Icone de Exclusao -->
							<a href="cadastrar_relatorio.php?apagar=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir o relatorio <?=$linha["relatorio"];?>  da empresa <?=$linha["empresa"]?>?')" title="Apagar" alt="Apagar" border="0">
							</a>
						</td>
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
<?if ($frase) {
	alert($frase);
}?>
</html>