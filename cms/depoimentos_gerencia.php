<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {		

				$sql = "DELETE FROM depoimentos WHERE id=".$_REQUEST['cod'];
				if (mysql_query($sql)) {
					alert("Excluido com sucesso!");
				}
	
}
// --- FIM    Efetuando a exlcusao



// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// Nome
	if (!($_POST["titulo"] == "")) {
		$titulo = addslashes($_POST["titulo"]);
	} else {
		$ok = 0;
	}
	
	// Texto
	if (!($_POST["texto"] == "")) {
		$texto = $_POST["texto"];
	} else {
		$ok = 0;
	}
	
		
	if ($ok) {

		$data = date("Y-m-d");
					
		    //salvando dados no banco
		    $sql = "INSERT INTO aempresa (titulo,texto) values ('$titulo','$texto')";
		    if (mysql_query($sql)) {
		    	alert("Conteúdo cadastrada com sucesso!");
		    	redireciona("aempresa.php");
		    } else {
		    	// QUERY
		    	
		    	alert("Erro ao cadastra!");
		    	redireciona("aempresa.php");
		    }
		    


	} // OK
	
} // REQUEST

// --- FIM    Efetuando o cadastro

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

<body>

<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->
<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>
<br><br><br></div>

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
				<img src="imagens/barra_depoimentos_gerencia.gif" alt="Gerenciamento de AEmpresa" title="Gerenciamento de AEmpresa" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Nome</td>
						<td align="center">Tipo</td>
						<td align="center">Depoimento</td>
						<td align="center" width="10%" nowrap>A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT * FROM depoimentos ORDER BY id DESC";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					$data = $linha["data"];
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["nome"]?></td>
						<td align="center" >
							<?
								if($linha["tipo"] == 1){
									echo "Organizações";
								}
								if($linha["tipo"] == 2){
									echo "Profissionais";
								}
							?>			
						</td>
						<td align="center" ><?=$linha["depoimento"]?></td>
						<td align="center" ><a href="depoimentos_alt.php?edit=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_editar.gif" alt="Editar" border="0"></a> 
						
						<a href="depoimentos_gerencia.php?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir ?')" alt="Apagar" border="0"></a></td>
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