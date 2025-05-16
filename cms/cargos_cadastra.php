<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<?

if(!$_REQUEST["cod"]){
	echo "<script>history.go(-1);</script>";
}else{
	$codigo_empresa = $_REQUEST["cod"];
}

?>

<?
$frase = "";
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	$codigo_empresa = $_REQUEST["empresa"];
	$sql = "DELETE FROM cargos WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		$frase = "Cargo excluido com sucesso!";
		redireciona("cargos_cadastra.php?cod=$codigo_empresa");
	}
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
		
	// EMPRESA 
	if (!($_POST["cargo"] == "")) {
		$cargo  = trim($_POST["cargo"]);
	} else {
		$ok = 0;
	}
	
	$codigo_empresa = $_REQUEST["cod"];
	
	
	if ($ok) {


		
	
		
											
			
		// Gravando dados no banco
			$sql = "INSERT INTO cargos (cargo,id_empresa) VALUES ('$cargo','$codigo_empresa')";
				
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Cargo cadastrado com sucesso!");
				redireciona("cargos_cadastra.php?cod=$codigo_empresa");
				
			} 	else {
				alert("Cargo não cadastrado , Erro ao no cadastro!");
				redireciona("cargos_cadastra.php?cod=$codigo_empresa");
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
				<img src="imagens/barra_cargos.gif" alt="Cadastro dos Cargos" title="Cadastro dos Cargos" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="cargos_cadastra.php?cadastra=1&cod=<?=$codigo_empresa?>" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Cargo: </span> </div><input type="text" size="50" name="cargo" value="<?=$cargo?>" class="form_style">
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
				<img src="imagens/barra_cargos_gerencia.gif" alt="Gerenciamento dos Cargos" title="Gerenciamento dos Cargos" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

			<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center" >Empresa</td>						
						<td align="center" >Cargo</td>						
						<td align="center" width="10%" nowrap>A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT * FROM cargos WHERE id_empresa = '$codigo_empresa' ORDER BY cargo";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" >
						
						<?  
							$sql_empresa = "SELECT * FROM empresa_cargos WHERE id = $codigo_empresa";
							
							$result_empresa = mysql_query($sql_empresa);
							$linha_empresa = mysql_fetch_assoc($result_empresa);
							echo $linha_empresa["empresa"];
						?>
						
						</td>
						<td align="center"><?=$linha["cargo"];?></td>
						
						
						<td align="center" width="1%" nowrap>
							<!-- Icone de edicao -->
							<a href="cargos_cadastra_alt.php?edit=1&cod=<?=$linha["id"]?>&empresa=<?=$codigo_empresa?>">
								<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0">
							</a>
							
							<!-- Icone de Exclusao -->
							<a href="cargos_cadastra.php?apagar=1&cod=<?=$linha["id"]?>&empresa=<?=$codigo_empresa?>">
								<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir a Empresa <?=$linha["empresa"];?> ?')" title="Apagar" alt="Apagar" border="0">
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