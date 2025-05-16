<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?


// --- INICIO Efetuando o cadastro
if ($_REQUEST['edit']) {
	
	$codigo = $_REQUEST["cod"];
	
	$sql = "SELECT * FROM ce_usuario WHERE CodUsuario=$codigo";
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	
	$nome = $linha["Nome"];
	$sobrenome = $linha["Sobrenome"];
	$email = $linha["Email"];
	$login = $linha["Login"];
	$permisa = $linha["permisao"];
	$relatorio_operacional = $linha["relatorio_operacional"];
	
	if($permisa == '99991'){
		$appadm = " SELECTED ";
		$appnormal = "  ";
		$commit = " ";
		$psicologas = "  ";
		$orga = "";
		$pesquisa = "";
	}
	
	if($permisa == '99992'){
		$appadm = " ";
		$appnormal = " SELECTED ";
		$commit = " ";
		$psicologas = "  ";
		$orga = "";
		$pesquisa = "";
	}
	
	if($permisa == '1111'){
		$appadm = "  ";
		$appnormal = "  ";
		$commit = " ";
		$psicologas = " SELECTED ";
		$orga = "";
		$pesquisa = "";
	}
	
	if($permisa == '5555'){
		$appadm = "  ";
		$appnormal = "  ";
		$commit = " SELECTED ";
		$psicologas = " ";
		$orga = "";
		$pesquisa = "";
	}
	
	if($permisa == '3333'){
		$appadm = "  ";
		$appnormal = "  ";
		$commit = "  ";
		$psicologas = " ";
		$orga = " SELECTED ";
		$pesquisa = "";
	}
	
	if($permisa == '4444'){
		$appadm = "  ";
		$appnormal = "  ";
		$commit = "  ";
		$psicologas = " ";
		$orga = "  ";
		$orgacommit = " SELECTED ";
		$pesquisa = "";
	}
	
	if($permisa == '6666'){
		$appadm = "  ";
		$appnormal = "  ";
		$commit = "  ";
		$psicologas = " ";
		$orga = "  ";
		$orgacommit = "";
		$pesquisa = " SELECTED ";
	}
	if($permisa == '2222'){
		$appadm = "  ";
		$appnormal = "  ";
		$commit = "  ";
		$psicologas = " ";
		$orgasuper = "SELECTED";
		$orgacommit = "";
		$pesquisa = " ";
	}
	
	$onload = "verificaTipoPermissao($permisa);";
	
	$organizacao = $linha["organizacao"];

}


if ($_REQUEST['edita']) {

	// Varificacao de campos
	$ok = 1;
	
	// Cod
	$codigo = $_REQUEST["cod"];
	
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

	// Email
	if (!($_POST["email"] == "")) {
		$email = $_POST["email"];
	} else {
		$ok = 0;
	}
	
	// Email
	if (!($_POST["senha"] == "")) {
		$senha =",Senha='".md5($_POST["senha"])."'";
	} else {
		$senha = "";
	}


	// Relatório Operacional
	if (!($_POST["relatorio_operacional"] == "")) {
		$relatorio_operacional = $_POST["relatorio_operacional"];
	} else {

	}	
	
	if($permissao == '99991'){
		
			//tipo_permissao
			if (!($_POST["tipo_permissao"] == "")) {
				$tipo_permissao = $_POST["tipo_permissao"];
			} else {
				$ok = 0;
			}		
			
			
			// Login
			if (!($_POST["login"] == "")) {
				$login = $_POST["login"];
			} else {
				$ok = 0;
			}

			if ($tipo_permissao == 2222){
					if($_POST["orga_multiplo"] != "Selecione"){
						$orga_multiplo = $_POST["orga_multiplo"];
					}else{
						$ok = 0;			
					}
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
			
			$where = " ,permisao='$tipo_permissao',Login='$login',organizacao='$orga' ";
	}else{
		$where = ' ';
	}

	
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert("Algum campo foi preenchido incorretamente ou est em branco, tente novamente!");
		redireciona("usuario_cadastra_alt.php?edit=1&cod=$codigo");
	} else {
		
		$sql = "UPDATE ce_usuario SET mudaSenha = 1,relatorio_operacional = '$relatorio_operacional', Nome='$nome', Sobrenome='$sobrenome', Email='$email' $senha $where WHERE CodUsuario=".$codigo;

		
		if (mysql_query($sql)) {
			$id_user = $codigo;
			if ($orga_multiplo) {
				mysql_query("DELETE FROM organizacoes_superusuario WHERE id_usuario = '$id_user'");
				for ($i=0;$i<count($orga_multiplo);$i++)
				{
					$id_orga = $orga_multiplo[$i];
				    $sql = "INSERT INTO organizacoes_superusuario (id_usuario,id_organizacao) VALUES ('$id_user','$id_orga')";
					mysql_query($sql);
					//echo $sql;
				}
			}

			alert("Dados do usuário alterados com sucesso!");
			redireciona("usuario_gerencia.php");
		}

	}
	
}

// --- FIM    Efetuando o cadastro

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

<body onload="<?=$onload?>">

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
				<img src="imagens/barra_alt_cadastro_user.gif" alt="Alterao de Usu&aacute;rios" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="usuario_cadastra_alt.php?edita=1&cod=<?=$codigo?>" method="post"  name="cadastro">
			
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
					<div id="label"> <span class="label_fonte">Senha: </span> </div><input type="text" size="50" name="senha" value=""  class="form_style">
				</div>
				
				<? if($permissao == '99991'){ ?>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Login: </span> </div><input type="text" size="30" name="login" value="<?=$login?>" class="form_style">
				</div>			


				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Tipo de Usuario: </span> </div>
						<select name="tipo_permissao" onchange="verificaTipoPermissao(this.value);" class="form_style">
		

                            <option value="99991" <?=$appadm?>>APP ADM</option>
							<option value="99992" <?=$appnormal?>>APP NORMAL</option>
							<option value="5555" <?=$commit?>>Commit - Super Usuário</option>
							<option value="1111" <?=$psicologas?>>Psicólogas</option>
							<option value="2222" <?=$orgasuper?>>Organização - Super Usuário</option>
							<option value="3333" <?=$orga?>>Organização</option>
							<option value="4444" <?=$orgacommit?>>Organização Commit</option>
                            <option value="6666" <?=$pesquisa?>>Pesquisa de Clima</option>
						</select>
				</div>	

				<div id="organizacoes_super" <? if($orgasuper != "SELECTED") { ?>style="display:none;"<? } ?>>
					<div id="linha_form" style="height: auto;">
							<div id="label"> <span class="label_fonte">Organizações: </span> </div>
								<select name="orga_multiplo[]" class="form_style" style="height: 200px;"  multiple>
								<option value="Selecione">Selecione</option>
								<?
								$sql = "SELECT * FROM organizacoes ORDER BY nome";
								$result = mysql_query($sql);
								
								while ($linha = mysql_fetch_assoc($result)) {
									
									$check = mysql_query("SELECT * FROM organizacoes_superusuario WHERE id_usuario = '".$_GET["cod"]."' and id_organizacao = '".$linha["id"]."'");
									if(mysql_num_rows($check) > 0) {
										$select = "selected";
									} else {
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
							<div id="label"> <span class="label_fonte">Organização: </span> </div>
								<select name="orga" class="form_style">
								<option value="Selecione">Selecione</option>
								<?
								$sql = "SELECT * FROM organizacoes ORDER BY nome";
								$result = mysql_query($sql);
								
								while ($linha = mysql_fetch_assoc($result)) {
									if ($organizacao == $linha["id"]) {
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
								<div id="label"> <span class="label_fonte">Organização Commit: </span> </div>
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
										if ($organizacao == $linha["nome_cliente"]) {
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
				<?}?>

				<div>
					<div id="linha_form">
						<div id="label"> <span class="label_fonte">Acesso limitado ao Relatório Operacional: </span> </div>
						<input type="checkbox" name="relatorio_operacional" value="1" <? if($relatorio_operacional == 1) { echo "checked"; } ?> />
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