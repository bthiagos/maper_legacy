<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<?
if ($_REQUEST["edit"]) {
	
	
	$sql = "SELECT *, date_format(data_nasc, '%d/%m/%Y') AS data_convertida FROM empresaCadastra WHERE id=".$_REQUEST["cod"];
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);

	$razao_social = $linha["razao_social"];
	$cnpj = $linha["cnpj"];
	$inscricao_estadual = $linha["inscricao_estadual"];
	$inscricao_municipal = $linha["inscricao_municipal"];
	$nome_contato = $linha["nome_contato"];
	$cargo = $linha["cargo"];
	$email = $linha["email"];
	$sexo = $linha["sexo"];
	$cep = $linha["cep"];
	$endereco = $linha["endereco"];
	$numero = $linha["numero"];
	$complemento = $linha["complemento"];
	$bairro = $linha["bairro"];
	$cidade = $linha["cidade"];
	$estado = $linha["estado"];
	$pais = $linha["pais"];
	$data_nascimento = $linha["data_convertida"];

	$vetorData = explode("-", $data_nascimento);
	$dataCompleta = explode("/",$vetorData[0]);
	$ano_nasc = $dataCompleta[2];
	$mes_nasc = $dataCompleta[1];
	$dia_nasc = $dataCompleta[0];
}

?>
<?
if ($_REQUEST["cadastra"]){
	
	$ok = 1;
	$codigo = $_REQUEST["cod"];


	if ($_POST["razao_social"]){
			$razao_social = $_POST["razao_social"];			
		}else {
			$ok = 0;
			alert("Preencha o campo Razão Social corretamente!");
			//redireciona("empresaCadastra.php");
		}
		
			//CNPJ
			if (addslashes(trim($_POST["cnpj"])) == "") {
				$ok = 0;
				alert("Preencha o campo CNPJ corretamente!");
				$cnpj = addslashes(trim($_POST["cnpj"]));
				//redireciona("empresaCadastra.php");
			}	
			// Validando CNPJ OU CPF
			if (addslashes(trim($_POST["cnpj"])) == "") {
				$ok = 0;
				alert("Preencha o campo CNPJ corretamente!");
				$cnpj = addslashes(trim($_POST["cnpj"]));
			//	redireciona("gerar_tickets.php");
			}	
			//CNPJ
			
			if ((strlen($_POST["cnpj"]) != 14) AND (strlen($_POST["cnpj"]) != 11)){
				$ok =0;
			}
			if (strlen($_POST["cnpj"]) == 14){
				
			if (!CalculaCNPJ($_POST["cnpj"]))  {
				$ok = 0;
				alert ("CNPJ Inválido!");
				$cnpj = addslashes(trim($_POST["cnpj"]));
			//	redireciona("gerar_tickets.php");
			} else {
				$cnpj = $_POST["cnpj"];
			}
			}
			
			//cpf
			if (strlen($_POST["cnpj"]) == 11){
				if (!valida_cpf(addslashes(trim($_POST["cnpj"]))))  {
					$ok = 0;
					alert ("CPF Inválido!");
					$cnpj = addslashes(trim($_POST["cnpj"]));
					//redireciona("gerar_tickets.php");
				} else {
					$cnpj = addslashes(trim($_POST["cnpj"]));
					
					} 
			}
		
		

		
	
		
		
		//Inscrição Estadual
		if ($_POST["inscricao_estadual"]){
			$inscricao_estadual = $_POST["inscricao_estadual"];
		}
		
		//Inscrição Municipal
		if ($_POST["inscricao_municipal"]){
			$inscricao_municipal = $_POST["inscricao_municipal"];
		}
		
		
		// Pegando Dados do Contato		
		//Nome Contato
		if ($_POST["nome_contato"]){
			$nome_contato = $_POST["nome_contato"];			
		}else {
			$ok = 0;
			alert("Preencha o campo Nome do Contato corretamente!");
			//redireciona("empresaCadastra.php");
		}
		
		$dia_nasc = $_POST["dia_nasc"];
		$mes_nasc = $_POST["mes_nasc"];
		$ano_nasc = $_POST["ano_nasc"];
		
		$data_nasc = $ano_nasc."-".$mes_nasc."-".$dia_nasc;
		
		
		//Cargo
		if ($_POST["cargo"]){
			$cargo = $_POST["cargo"];
		}
		
		
		//Ocupação
		if ($_POST["sexo"]){
			$sexo = $_POST["sexo"];
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
		

		
		//E-mail
		if ($_POST["cep"]){
			$cep = $_POST["cep"];
		}
		
		//E-mail
		if ($_POST["endereco"]){
			$endereco = $_POST["endereco"];
		}
		
		//E-mail
		if ($_POST["numero"]){
			$numero = $_POST["numero"];
		}
		
		//E-mail
		if ($_POST["complemento"]){
			$complemento = $_POST["complemento"];
		}
		
		//E-mail
		if ($_POST["bairro"]){
			$bairro = $_POST["bairro"];
		}
		
		//E-mail
		if ($_POST["cidade"]){
			$cidade = $_POST["cidade"];
		}
		
		//E-mail
		if ($_POST["estado"]){
			$estado = $_POST["estado"];
		}
		
		//E-mail
		if ($_POST["pais"]){
			$pais = $_POST["pais"];
		}
	
	
	if (!$ok) {
		// Alert de ERRO!
		alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
	} else {
				
			// Gravando dados no banco
			//$sql = "UPDATE empresaCadastra SET nome_evento = '$nome_evento', solicitado_por = '$solicitado_por', descricao = '$descricao', data_evento = '$data_marcada', observacao = '$observacao', id_sala = '$id_sala', lanche = '$lanche', n_pessoas = '$n_pessoas', ate_hora = '$ate_hora' WHERE id = $codigo";
			$sql = "UPDATE empresaCadastra SET razao_social = '$razao_social', cnpj = '$cnpj', inscricao_estadual = '$inscricao_estadual', inscricao_municipal = '$inscricao_municipal', nome_contato = '$nome_contato', data_nasc = '$data_nasc', cargo = '$cargo', sexo = '$sexo', email = '$email', cep = '$email', endereco = '$endereco', numero = '$numero', complemento = '$complemento', bairro = '$bairro', cidade = '$cidade', estado = '$estado', pais = '$pais' WHERE id = $codigo";
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Empresa alterada com sucesso!");
				redireciona("prospectsEmpresas.php");
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
				<img src="imagens/prospectsEmpresas.gif" alt="Prospects - Empresas" title="Prospects - Empresas" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV info - Barra de informacao -->
			<? $codigo_post = $_REQUEST["cod"];

			?>
			<form action="prospectsEmpresas_alt.php?cadastra=1&cod=<?=$codigo_post?>" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
			
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte"><b>Dados da Empresa</b></span> </div>
				</div>			
			
				<div id="linha_form" style="margin-left: 60px">
					<div id="label"> <span class="label_fonte">Razão Social: </span> </div><input type="text" name="razao_social" class="form_style" size="50" value="<?=$razao_social?>"/>
				</div>
			
				<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">CNPJ: </span> </div><input type="text" name="cnpj" class="form_style" size="20" value="<?=$cnpj?>" onKeyUp="javascript:somente_numero(this);"/>
				</div>
			
				<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">Inscrição Estadual: </span> </div><input type="text" name="inscricao_estadual" class="form_style" size="50" value="<?=$inscricao_estadual?>"/>
				</div>
				
				<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">Inscrição Municipal: </span> </div><input type="text" name="inscricao_municipal" class="form_style" size="50" value="<?=$inscricao_municipal?>"/>
				</div>
				
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte"><b>Contato</b></span> </div>
				</div>			
			
				<div id="linha_form" style="margin-left: 60px">
					<div id="label"> <span class="label_fonte">Nome Contato: </span> </div><input type="text" name="nome_contato" class="form_style" size="50" value="<?=$nome_contato?>"/>
				</div>
			
				<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">Data Nasc.: </span> </div>
					<input type="text" name="dia_nasc" class="form_style" maxlength="2" size="2" value="<?=$dia_nasc?>" onKeyUp="javascript:somente_numero(this);"/> / <input type="text" name="mes_nasc" class="form_style" maxlength="2" size="2" value="<?=$mes_nasc?>" onKeyUp="javascript:somente_numero(this);"/> / <input type="text" name="ano_nasc" class="form_style" maxlength="4" size="4" value="<?=$ano_nasc?>" onKeyUp="javascript:somente_numero(this);"/>
				</div>
			
				<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">Cargo/Ocupação: </span> </div><input type="text" name="cargo" class="form_style" size="50" value="<?=$cargo?>"/>
				</div>
				
				<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">E-mail: </span> </div><input type="text" name="email" class="form_style" size="50" value="<?=$email?>"/>
				</div>
				
				
				<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">Sexo: </span> </div>
					<? 
					if($sexo == "Masculino"){
						$masculino = "selected";
					}
					
					if($sexo == "Feminino"){
						$feminino = "selected";
					}
					?>

					
					<select name="sexo" class="form_style">
						<option value="">Selecione</option>
						<option value="Masculino" <?=$masculino?> >Masculino</option>
						<option value="Feminino" <?=$feminino?> >Feminino</option>
					</select>
				</div>
			
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte"><b>Dados para contato</b></span> </div>
				</div>	
				
				<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">CEP: </span> </div><input type="text" name="cep" class="form_style" size="20" value="<?=$cep?>"/>
				</div>
			
				<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">Endereço: </span> </div><input type="text" name="endereco" class="form_style" size="50" value="<?=$endereco?>"/>
				</div>
			
				<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">Número: </span> </div><input type="text" name="numero" class="form_style" size="50" value="<?=$numero?>"/>
				</div>
			
				<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">Complemento: </span> </div><input type="text" name="complemento" class="form_style" size="15" value="<?=$complemento?>"/>
				</div>
			
				<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">Bairro: </span> </div><input type="text" name="bairro" class="form_style" size="50" value="<?=$bairro?>"/>
				</div>
			
				<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">Cidade: </span> </div><input type="text" name="cidade" class="form_style" size="50" value="<?=$cidade?>"/>
				</div>
			
					<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">Estado: </span> </div><input type="text" name="estado" class="form_style" size="30" value="<?=$estado?>"/>
				</div>
			
					<div id="linha_form" style="margin-left: 60px; margin-top: -10px">
					<div id="label"> <span class="label_fonte">País: </span> </div><input type="text" name="pais" class="form_style" size="30" value="<?=$pais?>"/>
				</div>
			
							
				
	

					<p align="center"><input type="submit" value="Cadastrar" class="form_style"></p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			
			
					
				
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