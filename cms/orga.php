<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM organizacoes WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		$frase = "Organização excluida com sucesso!";
	}
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// texto 
	if (!($_POST["texto"] == "")) {
		$texto  = trim($_POST["texto"]);
	} else {
		$ok = 0;
	}
	
	
	
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
	} else {
	
		
			
			// Gravando dados no banco
			$sql = "INSERT INTO organizacoes (nome) VALUES ('$texto')";
			
			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Organização cadastrada com sucesso!");
				redireciona("orga.php");
			}
	} 
}
	


// --- FIM    Efetuando o cadastro

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
				<img src="imagens/barra_organiza_add.gif" alt="Cadastro de Organizações" title="Cadastro de Organizações" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="orga.php?cadastra=1" method="post" name="cadastra" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Organizaçao: </span> </div><input type="text" size="50" name="texto" class="form_style">
			
			</div>
			

			
				
				
				
				
				<p align="center"><input type="submit" value="Cadastrar" class="form_style"></p>
				
				
			
				</div></form>
		
				<!-- INICIO - DIV info fim - Barra de informacao -->
				<div id="info_fim">
				&nbsp;
					</div>
				<!-- INICIO - DIV info fim - Barra de informacao -->			
					
			
			
				<!-- INICIO - DIV info - Barra de informacao -->
				<div id="info">
				<img src="imagens/barra_organiza_grencia.gif" alt="Gerenciamento de Organizações" title="Gerenciamento de Organizações" />
				</div>
		
		
		
					<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
					<div id="caixa_table">
			


				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">#</td>
						<td align="center">Organizacão</td>
						<td align="center" width="1%" nowrap>A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT * FROM organizacoes ORDER BY nome";
				$result = mysql_query($sql);
				$i = 0;
				while ($linha = mysql_fetch_assoc($result)) {
					$i++;
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>			
		
				<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center"  width="1%" nowrap><?=$i?></td>

						<td align="center" >
						<?=$linha["nome"]?>
						</td>	
						
						
						<td align="center" width="1%" nowrap>
							<!-- Icone de edicao -->
							<a href="orga_alt.php?alterar=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0">
							</a>
							
							<!-- Icone de Exclusao -->
							<a href="orga.php?apagar=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir a Organizacão?')" title="Apagar" alt="Apagar" border="0">
							</a>
						</td>
				</tr>
				<?
				}
				?>
				</table>


			</div> <!-- FIM CAIXA ENGLOBA GERENCIAMENTO -->
		
		
		
		
		
		
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->	
		
		</div> <!-- FIM DIV PRINCIPAL -->
		 
	</div> <!-- FIM DIV GLOBAL-->
	

</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
<?if ($frase) {
	alert($frase);
}?>
</html>