<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?
// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// senha
	if (!($_POST["senha"] == "")) {
		$senhaveia = $_POST["senha"];
		$senhaveia = md5($senhaveia);
	} else {
		$ok = 0;
	}
	
	// senha
	if (!($_POST["senhan"] == "")) {
		$senha2 = $_POST["senhan"];
	} else {
		$ok = 0;
	}

	// senha
	if (!($_POST["senhan2"] == "")) {
		$senha2conf = $_POST["senhan2"];
	} else {
		$ok = 0;
	}
	
	
	// Verificando campos de senha
	if (!($senha2 == $senha2conf)) {
		$ok = 0;
	}
	
	if ($ok) {
		
		$login = $_SESSION["login_adm"];
		$sql = "SELECT Senha, CodUsuario FROM ce_usuario WHERE login='$login'";
		$result = mysql_query($sql);
		$linha = mysql_fetch_assoc($result);
		$senha_banco = $linha["Senha"];
		$cod_user = $linha["CodUsuario"];
		
		if ($senha_banco == $senhaveia) {
			$senha2conf = md5($senha2conf);
			$sql = "UPDATE ce_usuario SET Senha='$senha2conf', MudaSenha='0' WHERE CodUsuario='$cod_user'";
			//echo "oa";
			if (mysql_query($sql)) {
				alert("Senha Alterada com sucesso!");
				echo "<script language=\"javascript\">location.href = \"home.php\";</script>";
			}
			
		}
		
		
	} else {
		alert("Falha, Todos os campos devem ser preenchidos");
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
				<img src="imagens/barra_mudasenha_user.gif" alt="Mudanca obrigatoria de senha" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="usuario_mudasenha.php?cadastra=1" method="post" onSubmit="return validaForm()" name="cadastro">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Senha atual: </span> </div><input type="password" size="50" name="senha" value="<?=$nome?>" class="form_style">
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nova senha: </span> </div><input type="password" size="50" name="senhan" value="<?=$sobrenome?>" class="form_style">
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Confirma&ccedil;&atilde;o de senha: </span> </div><input type="password" size="50" name="senhan2" value="<?=$email?>"  class="form_style">
				</div>
				

					<p align="center"><input type="submit" value="Mudar Senha" class="form_style"></p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
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
</html>