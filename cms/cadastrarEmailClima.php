<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<?
$frase = "";
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM clima_Email WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		$frase = "Grupo excluido com sucesso!";
		alert($frase);
	}
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
		
	// cliente 
	if ($_POST["grupo"] != "") {
		$grupo = $_POST["grupo"];
	} else {
		alert("Campo Grupo Obrigatório!");
		$ok = 0;
	}
	
	if (!($_POST["nome"] == "")) {
		$nome  = trim($_POST["nome"]);
	} else {
		alert("Campo Nome Obrigatório!");
		$ok = 0;
	}
	
	if (addslashes(trim($_POST["email"])) == "") {
		$ok = 0;
		$email = addslashes(trim($_POST["email"]));
		alert("Preencha o campo E-mail corretamente!");
		//redireciona("gerar_tickets.php");
		} elseif (!validar_email(addslashes(trim($_POST["email"]))))  {
			$ok = 0;
			alert("E-mail Inválido!");
			//redireciona("gerar_tickets.php");
			$email = addslashes(trim($_POST["email"]));
		} else {
			$email = addslashes(trim($_POST["email"]));
		}
	
	
	
	
			if(!$ok){
				alert("Erro ao cadastrar,algum campo incorreto!");
			} else {
				// Gravando dados no banco
				$sql = "INSERT INTO clima_Email (nome, email, grupo) VALUES ('$nome', '$email', '$grupo')";				
				// Confirmacao de insert
				if (mysql_query($sql)) {					
					alert("E-mail cadastrado com sucesso!");
					redireciona("cadastrarEmailClima.php?grupo=$grupo");
				} else {
					alert("Erro ao cadastrar,algum campo incorreto!");
					redireciona("cadastrarEmailClima.php ");
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
				<b>Cadastro de E-mail</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="cadastrarEmailClima.php?cadastra=1" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
							
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Grupo: </span> </div>
					<select name="grupo" class="form_style">
						<option value="">Selecione</option>
						<? 	$sql = "SELECT * FROM clima_GrupoEmail ORDER BY nome";
							$result = mysql_query($sql);
							while ($linha = mysql_fetch_assoc($result)) {
								if ($grupo == $linha["id"]) {
									$select = "SELECTED";
								}else{
									$select = "";
								}
						?>
						
						<option value="<?=$linha["id"]?>" <?=$select?>><?=$linha["nome"]?></option>
						
						<?}?>
					</select>
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome:</span> </div><input type="text" size="50" name="nome" value="<?=$nome?>" class="form_style">
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">E-mail: </span> </div><input type="text" size="50" name="email" value="<?=$email?>" class="form_style">
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
				<b>Gerenciamento de E-mail's</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="cadastrarEmailClima.php?localizar=1" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
							
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Grupo: </span> </div>
					<select name="grupo" class="form_style">
						<option value="">Selecione</option>
						<? 	$sql = "SELECT * FROM clima_GrupoEmail ORDER BY nome";
							$result = mysql_query($sql);
							while ($linha = mysql_fetch_assoc($result)) {
						?>
						
						<option value="<?=$linha["id"]?>"><?=$linha["nome"]?></option>
						
						<?}?>
					</select>
				</div>
				
				<p align="center"><input type="submit" value="Exibir" class="form_style"></p>
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
				<b>Gerenciamento de E-mail's</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<? if($_POST["grupo"]){
				$grupo = $_POST["grupo"];
				}
				
				if($_REQUEST["grupo"] != ""){
				$grupo = $_REQUEST["grupo"];
				}
			
				if($grupo){
			
			?>

			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

			<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Nome</td>
						<td align="center">E-mail</td>
						<td align="center">Grupo</td>
						<td align="center" width="10%" nowrap>A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
			
				
				//$sql = "SELECT * FROM clima_Email WHERE grupo = $grupo ORDER BY nome";
				$sql = "SELECT
						clima_Email.id,
						clima_Email.nome,
						clima_Email.email,
						clima_Email.grupo,
						clima_GrupoEmail.nome AS grupo_nome
						FROM
						clima_Email
						Inner Join clima_GrupoEmail ON clima_GrupoEmail.id = clima_Email.grupo
						WHERE
						clima_Email.grupo = $grupo";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["nome"];?></td>						
						<td align="center" ><?=$linha["email"];?></td>						
						<td align="center" ><?=$linha["grupo_nome"];?></td>						
						<td align="center" width="1%" nowrap>
							<!-- Icone de edicao -->
							<a href="editarEmailClima.php?edit=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0">
							</a>
							
							<!-- Icone de Exclusao -->
							<a href="cadastrarEmailClima.php?apagar=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir o E-mail <?=$linha["nome"];?> ?')" title="Apagar" alt="Apagar" border="0">
							</a>
						</td>
					</tr>
				<?
				}
				?>
				</table>


			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			
				
			<?}?>
			
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