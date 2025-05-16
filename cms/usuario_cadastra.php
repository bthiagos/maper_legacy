<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// Nome
	if (!($_POST["nome"] == "")) {
		$nome = $_POST["nome"];
	} else {
		$ok = 0;
	}
	
	// Sobrenome
	if (!($_POST["sobrenome"] == "")) {
		$sobrenome = $_POST["sobrenome"];
	} else {
		$ok = 0;
	}

		//tipo_permissao
	if (!($_POST["tipo_permissao"] == "")) {
		$tipo_permissao = $_POST["tipo_permissao"];
	} else {
		$ok = 0;
	}
		
	if(($tipo_permissao == 3333) or ($tipo_permissao == 4444)){
			
		
		if($tipo_permissao == 3333){
			if($_POST["orga"] != "Selecione"){
				$orga = $_POST["orga"];
			}else{
				$ok = 0;			
			}
		}
		if($tipo_permissao == 4444){
			if($_POST["orgacommit"] != "Selecione"){
				$orga = $_POST["orgacommit"];
			}else{
				$ok = 0;			
			}
		}
	}else{
				$orga = " ";
			}
	
	if ($tipo_permissao == 2222){
		if($_POST["orga_multiplo"] != "Selecione"){
			$orga_multiplo = $_POST["orga_multiplo"];
		}else{
			$ok = 0;			
		}
	}
	
	// Email
	if (!($_POST["email"] == "")) {
		$email = $_POST["email"];
	} else {
		$ok = 0;
	}
	
	// Login
	if (!($_POST["login"] == "")) {
		$login = $_POST["login"];
	} else {
		$ok = 0;
	}	

	// Senha
	if (!($_POST["senha"] == "")) {
		$senha = $_POST["senha"];
	} else {
		$ok = 0;
	}

	// Confirmacao de Senha
	if (!($_POST["senha2"] == "")) {
		$senha2 = $_POST["senha2"];
	} else {
		$ok = 0;
	}	

	// Relat�rio Operacional
	if (!($_POST["relatorio_operacional"] == "")) {
		$relatorio_operacional = $_POST["relatorio_operacional"];
	} else {
		$relatorio_operacional = 0;
	}	
	
	
	
	// Verificando campos de senha
	if (!($senha == $senha2)) {
		$ok = 0;
	}
	
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert("Algum campo foi preenchido incorretamente ou est em branco, tente novamente!");
	} else {
		//break;
		// Verificando se ja existe login
		$sql = "SELECT * FROM ce_usuario WHERE login='$login'";
		$result = mysql_query($sql);
		
		if (mysql_num_rows($result) > 0) {
			alert("Login ja existente, tente novamente!");
		}else{
			// Capiturando a data
			$data = "0000-00-00 00:00:00";
			
			// Codificando Senha
			$senha = md5($senha);
			
			// Gravando dados no banco
			$sql = "INSERT INTO ce_usuario (Nome,Sobrenome,Email,Login,Senha,MudaSenha,UltimoLogon,permisao,organizacao,relatorio_operacional) VALUES('$nome','$sobrenome','$email','$login','$senha','1','$data','$tipo_permissao','$orga','$relatorio_operacional')";
					

						
			// Confirmacao de insert
			if (mysql_query($sql)) {
				
				//Pegando dados usu�rio recen cadastrado
				$id_user = mysql_insert_id();
				
				if ($orga_multiplo) {
					for ($i=0;$i<count($orga_multiplo);$i++)
					{
						$id_orga = $orga_multiplo[$i];
					    $sql = "INSERT INTO organizacoes_superusuario (id_usuario,id_organizacao) VALUES ('$id_user','$id_orga')";
						mysql_query($sql);
					}
				}
				
				alert("Usu�rio cadastrado com sucesso!");
				email($nome,$sobrenome,$email,$login,$senha2);
				$nome = $sobrenome = $login = $email = $senha = $senha2 = null;
				redireciona("usuario_gerencia.php");
			}
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
				<img src="imagens/barra_cadastro_uder.gif" alt="Cadastro de Usu&aacute;rios" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="usuario_cadastra.php?cadastra=1" method="post"  name="cadastro">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome: </span> </div><input type="text" size="50" name="nome" value="<?=$nome?>" class="form_style">
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Sobrenome: </span> </div><input type="text" size="50" name="sobrenome" value="<?=$sobrenome?>" class="form_style">
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">E-mail: </span> </div><input type="text" size="50" name="email" value="<?=$email?>"  class="form_style">
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Login: </span> </div><input type="text" size="30" name="login" value="<?=$_POST["login"]?>" class="form_style">
				</div>			

				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Tipo de Usuario: </span> </div>
						<select name="tipo_permissao" onchange="verificaTipoPermissao(this.value);" class="form_style">
							<option value="99991">APP ADM</option>
							<option value="99992">APP NORMAL</option>
							<option value="5555">Commit - Super Usuário</option>
							<option value="1111">Psicólogas</option>
							<option value="2222">Organização - Super Usuário</option>
							<option value="3333">Organização</option>
							<option value="4444">Organização Commit</option>
                            <option value="6666">Pesquisa de Clima</option>
						</select>
				</div>		
				
			<div id="organizacoes_super" style="display:none;">
				<div id="linha_form" style="height: auto;">
						<div id="label"> <span class="label_fonte">Organiza��es: </span> </div>
							<select name="orga_multiplo[]" class="form_style" style="height: 200px;"  multiple>
							<option value="Selecione">Selecione</option>
							<?
							$sql = "SELECT * FROM organizacoes ORDER BY nome";
							$result = mysql_query($sql);
							
							while ($linha = mysql_fetch_assoc($result)) {
								if ($fabricante == $linha["id"]) {
									$select = "SELECTED";
								}else{
									$select = "";
								}
							?>
								<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
							<?
								
								
								
							}
							
							?>
							</select>
				</div>
			</div>							
				
			<div id="organizacoes" style="display:none;">
				<div id="linha_form">
						<div id="label"> <span class="label_fonte">Organiza��o: </span> </div>
							<select name="orga" class="form_style">
							<option value="Selecione">Selecione</option>
							<?
							$sql = "SELECT * FROM organizacoes ORDER BY nome";
							$result = mysql_query($sql);
							
							while ($linha = mysql_fetch_assoc($result)) {
								if ($fabricante == $linha["id"]) {
									$select = "SELECTED";
								}else{
									$select = "";
								}
							?>
								<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
							<?
								
								
								
							}
							
							?>
							</select>
				</div>
			</div>
				
			<div id="organizacoescommit" style="display:none;">
				<div id="linha_form">
						<div id="label"> <span class="label_fonte">Organiza��o Commit: </span> </div>
							<select name="orgacommit" class="form_style">
							<option value="Selecione">Selecione</option>
							<?
							$sql = "SELECT
									gerador_tickets_pedidos.nome_cliente,
									gerador_tickets_pedidos.id
									FROM
									gerador_tickets_pedidos
									GROUP BY
									gerador_tickets_pedidos.nome_cliente
									HAVING
									gerador_tickets_pedidos.nome_cliente = gerador_tickets_pedidos.nome_cliente

 ORDER BY nome_cliente";
							$result = mysql_query($sql);
							
							while ($linha = mysql_fetch_assoc($result)) {
								if ($fabricante == $linha["id"]) {
									$select = "SELECTED";
								}else{
									$select = "";
								}
							?>
								<option value="<?=$linha["nome_cliente"]?>" <?=$select?> ><?=$linha["nome_cliente"]?></option>
							<?
								
								
								
							}
							
							?>
							</select>
				</div>
			</div>	
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Senha: </span> </div><input type="password" size="20" name="senha" class="form_style">
				</div>	
				
	
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Confirma&ccedil;&atilde;o Senha: </span> </div><input type="password" size="20" name="senha2" class="form_style">
				</div>		

				<div>
					<div id="linha_form">
						<div id="label"> <span class="label_fonte">Acesso limitado ao Relat�rio Operacional: </span> </div>
						<input type="checkbox" name="relatorio_operacional" value="1" />
					</div>
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
				
		</div>
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
	
	</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>