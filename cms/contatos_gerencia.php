<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM  ce_contatos WHERE codigo=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		$frase = "Contato excluida com sucesso!";
	}
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// contato 
	if (!($_POST["contato"] == "")) {
		$contato  = trim($_POST["contato"]);
	} else {
		$ok = 0;
	}
	
	// email 
	if (!($_POST["e-mail"] == "")) {
		$email  = trim($_POST["e-mail"]);
	} else {
		$ok = 0;
	}
	
	
	if (!($_POST["grupo"] == "")) {
		$grupo = trim($_POST["grupo"]);
	} else {
		$ok = 0;
	}
	
	$sql = "SELECT * FROM ce_contatos WHERE grupo=$grupo and email='$email'";
	$result = mysql_query($sql);
	if (mysql_num_rows($result) > 0) {
		$ok = 0;
		$msg = 1;
	}
	
	
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		if ($msg == 1) {
			alert("O E-mail $email já foi cadastrado no grupo!");
		}else{
			alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
		}

	} else {
				
			// Gravando dados no banco
			$sql = "INSERT INTO ce_contatos (contato,grupo,email) VALUES('$contato','$grupo','$email')";
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Contato cadastrado com sucesso!");
				redireciona("contatos_gerencia.php");
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
				<img src="imagens/gerenciamento_contatos.gif" alt="Gerenciamento de Contatos" title="Gerenciamento de Contatos" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="contatos_gerencia.php?slc_grupo=1" method="GET" >
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Visualizar o Grupo: </span> </div>
					
					<select name="slc_grupo" class="form_style" onchange="submit();">
					<option value="all">Todos</option>
					
					
					<?
				if (($_REQUEST["slc_grupo"] != "all") && ($_REQUEST["slc_grupo"] != "")) {
					$grup = $_REQUEST["slc_grupo"];
					$where = " WHERE grupo=$grup ";
				} else {
					$where = "";
					$grup = "all";
				}
					$sql = "SELECT * FROM ce_grupos_contatos ORDER BY grupo";
					$result = mysql_query($sql);
					
					while ($linha = mysql_fetch_assoc($result)) {
						if ($grup == $linha["codigo"]) {
							$select = " SELECTED ";
						}else{
							$select = "";
							
						}
					?>
						<option value="<?=$linha["codigo"]?>" <?=$select?>><?=$linha["grupo"]?></option>
					<?
						
						
						
					}
					
					?>
					</select>
				</div>
			
			<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Contato</td>
						<td align="center">Grupo</td>
						<td align="center">E-mail</td>
						<td align="center" width="10%" nowrap>A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?

				$sql = "SELECT * FROM ce_contatos $where ORDER BY contato";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["contato"]?></td>

						<td align="center" ><?
						$sql2 = "SELECT grupo FROM ce_grupos_contatos WHERE codigo=".$linha["grupo"];
						$result2 = mysql_query($sql2);
						$linha2 = mysql_fetch_assoc($result2);
						echo $linha2["grupo"];
						?></td>
						<td align="center" ><?=$linha["email"]?></td>
						<td align="center" >
							<!-- Icone de edicao -->
							<a href="contatos_gerencia_alt.php?alterar=1&cod=<?=$linha["codigo"]?>&slc_grupo=<?=$grup;?>">
								<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0">
							</a>
							
							<!-- Icone de Exclusao -->
							<a href="contatos_gerencia.php?apagar=1&cod=<?=$linha["codigo"]?>&slc_grupo=<?=$grup;?>">
								<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir o Contato?')" title="Apagar" alt="Apagar" border="0">
							</a>
						</td>
					</tr>
				<?
				}
				?>
				</table>


			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			
			</form>
				
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