<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?
$frase = "";
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	$cod = $_REQUEST['cod'];
	$sql = "DELETE FROM pesquisas WHERE id=".$_REQUEST['cod'];
	$sql2 = "DELETE FROM pesquisa_perguntas WHERE id_pesquisa=".$_REQUEST['cod'];
	$sql_alternativas ="SELECT  pesquisa_perguntas.id as idperguntas FROM pesquisa_perguntas Inner Join pesquisa_alternativas ON pesquisa_alternativas.id_perguntas = pesquisa_perguntas.id WHERE id_pesquisa = $cod ORDER BY pesquisa_perguntas.id";
	$result_alternativas = mysql_query($sql_alternativas);
	while($linha_alternativas = mysql_fetch_assoc($result_alternativas)){
		$idperguntas = $linha_alternativas["idperguntas"];
		$sql3 = "DELETE FROM pesquisa_alternativas WHERE id_perguntas=$idperguntas";
			mysql_query($sql3);
	}
	
	
	
	if (mysql_query($sql)) {
		mysql_query($sql2);
	
		$frase = "Pergunta excluido com sucesso!";
		alert($frase);
		redireciona("cadastrar_pesquisas.php");
	}
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
		
	// NOME 
	if (!($_POST["nome"] == "")) {
		$nome  = trim($_POST["nome"]);
	} else {
		$ok = 0;
	}
	
	$texto = addslashes(nl2br($_REQUEST["texto"]));
	
	
	if ($ok) {

		// Gravando dados no banco
			$sql = "INSERT INTO pesquisas (texto,nome) VALUES ('$texto','$nome')";
				
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Pergunta cadastrado com sucesso!");
				redireciona("cadastrar_pesquisas.php?cod=$codigo_empresa");
				
			} 	else {
				alert("Pergunta n�o cadastrado , Erro ao no cadastro!");
				redireciona("cadastrar_pesquisas.php?cod=$codigo_empresa");
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
			<div id="info" style="font-family: arial; font-size: 12px; color: #666666">
				<b>Cadastro das Pesquisas</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="cadastrar_pesquisas.php?cadastra=1" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Texto : </span> </div><textarea rows="3" cols="80" name="texto" class="form_style"></textarea>
				</div>
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome da pesquisa: </span> </div><input type="text" name="nome" size="50" class="form_style" />
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
			<div id="info" style="font-family: arial; font-size: 12px; color: #666666">
				<b>Gerenciamento das Pesquisas</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

			<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center" >Codigo</td>						
						<td align="center" >Pesquisa</td>						
						<td align="center" >Texto</td>						
						<td align="center" width="10%" nowrap>A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT * FROM pesquisas ORDER BY id";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						
						<td align="center"><?=$linha["id"];?></td>
						<td align="center"><?=$linha["nome"];?></td>
						<td align="center"><?=$linha["texto"];?></td>
						
						
						<td align="center" width="1%" nowrap>
							<!-- Icone de Duplicacao -->
							<a href="duplicar_pesquisa.php?cod=<?=$linha["id"]?>">
								<img src="imagens/icon_sorteio.gif" title="Duplicar Pesquisa" alt="Duplicar Pesquisa" border="0">
							</a>
							
							<!-- Icone de edicao -->
							<a href="cadastrar_pesquisas_alt.php?edit=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0">
							</a>
							
							<!-- Icone de Exclusao -->
							<a href="cadastrar_pesquisas.php?apagar=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir a Pesquisa <?=$linha["nome"];?> ?')" title="Apagar" alt="Apagar" border="0">
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