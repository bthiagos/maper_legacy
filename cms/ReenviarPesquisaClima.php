<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<?
if($_REQUEST["cadastra"]){
	
	
	$id_grupo = $_POST["id_grupo"];
	$id_pesquisa = $_POST["id_pesquisa"];
	
	if($_POST["todos"] == "1"){
		
		$sql_email = "SELECT
			clima_Email.id as idpessoa,
			clima_Email.nome,
			clima_Email.email,
			clima_Email.grupo,
			clima_GrupoEmail.nome as nomeGrupo,
			clima_GrupoEmail.id_organizacao
			FROM
			clima_Email
			Inner Join clima_GrupoEmail ON clima_GrupoEmail.id = clima_Email.grupo WHERE clima_Email.grupo = '$id_grupo'";
		$result_email = mysql_query($sql_email);
		while($linha_email = mysql_fetch_assoc($result_email)) { 
				
			$email = $linha_email["email"];
			$nome = $linha_email["nome"];
			$idpessoa = $linha_email["idpessoa"];
			$nomeGrupo = $linha_email["nomeGrupo"];
			
			
			$idapesquisa = pegando_id_pesquisa($id_pesquisa);
			$respostas2 = zerando_respostas($idapesquisa);		
			
			
			salvar_pessoas_enviadas($id_pesquisa,$idpessoa,$respostas2);
		
			
			$nomePesquisa = nome_pesquisa_enviados($id_pesquisa);
			
			$to = "$email";
			// Assunto
			$subject = "$nomePesquisa - $nomeGrupo";
			
			// Cabecalho
			$headers = "From: Pequisa $nomePesquisa <app@appweb.com.br>\n";
			$headers .= "Reply-To: Pequisa $nomePesquisa <app@appweb.com.br>\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=ISO-8859-1";
			
			
			/*$msg = "
			<p><b>Pequisa $nomePesquisa</b></p> 
			<p>Estamos aplicando este question�rio entre todos os funcion�rios da $nomeGrupo com o objetivo de conhecer a sua opini�o sobre alguns aspectos do $nomePesquisa da nossa organiza��o.</p>
			<p><a href=\"www.appweb.com.br/pesquisa_clima.php?cod=$id_pesquisa_enviar&pessoa=$idpessoa\">Clique aqui</a> e participe!</p>
			<p>Agradecemos sua colabora��o.</p>		
			";*/
			
			$msg = "
			<p style=\"font-family:arial; font-weight:bold;\">Para visualizar essa mensagem, no Outlook � clique em �Exibir imagens� ou <a href=\"www.appweb.com.br/verEmail.php?aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&cod=$id_pesquisa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&pessoa=$idpessoa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidn uihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&\">clique aqui</a> para visualizar.</p>
			<p align=\"center\" style=\"font-family:arial; font-weight:bold;\"><a href=\"www.appweb.com.br/pesquisa_clima.php?aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&cod=$id_pesquisa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&pessoa=$idpessoa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidn uihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&\">Clique aqui</a> e responda</p>
			<p align=\"center\" style=\"font-family:arial; font-weight:bold;\"><a href=\"www.appweb.com.br/pesquisa_clima.php?aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&cod=$id_pesquisa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidn uihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&pessoa=$idpessoa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&\"><img src=\"http://www.appweb.com.br/cms/imagens/friero.jpg\" border=\"0\"></a></p>			
			";
			
			
			if (@mail($to, $subject, $msg, $headers)) {
				$quant++;
			}
			
			
		}
		alert("$quant E-mails enviados com Sucesso");
		
	}else{
		
		if($_POST["id_email"]) {
			
			$depart_relac = $_POST["id_email"];
			
				for ($i=0;$i<=count($depart_relac)-1;$i++) {
						
						
					$email = pegar_email($depart_relac[$i]);
					$idpessoa = $depart_relac[$i];
					$nomeGrupo = nome_grupo($id_grupo);
					
					
					$idapesquisa = pegando_id_pesquisa($id_pesquisa);
					$respostas2 = zerando_respostas($idapesquisa);		
					
					
					salvar_pessoas_enviadas($id_pesquisa,$idpessoa,$respostas2);
				
					
					$nomePesquisa = nome_pesquisa_enviados($id_pesquisa);
					
					$to = "$email";
					// Assunto
					$subject = "$nomePesquisa - $nomeGrupo";
					
					// Cabecalho
					$headers = "From: Pequisa $nomePesquisa <app@appweb.com.br>\n";
					$headers .= "Reply-To: Pequisa $nomePesquisa <app@appweb.com.br>\n";
					$headers .= "MIME-Version: 1.0\n";
					$headers .= "Content-type: text/html; charset=ISO-8859-1";
					
					
					/*$msg = "
					<p><b>Pequisa $nomePesquisa</b></p> 
					<p>Estamos aplicando este question�rio entre todos os funcion�rios da $nomeGrupo com o objetivo de conhecer a sua opini�o sobre alguns aspectos do $nomePesquisa da nossa organiza��o.</p>
					<p><a href=\"www.appweb.com.br/pesquisa_clima.php?cod=$id_pesquisa_enviar&pessoa=$idpessoa\">Clique aqui</a> e participe!</p>
					<p>Agradecemos sua colabora��o.</p>		
					";*/
					
					$msg = "
					<p style=\"font-family:arial; font-weight:bold;\">Para visualizar essa mensagem, no Outlook � clique em �Exibir imagens� ou <a href=\"www.appweb.com.br/verEmail.php?aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&cod=$id_pesquisa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&pessoa=$idpessoa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidn uihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&\">clique aqui</a> para visualizar.</p>
					<p align=\"center\" style=\"font-family:arial; font-weight:bold;\"><a href=\"www.appweb.com.br/pesquisa_clima.php?aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&cod=$id_pesquisa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&pessoa=$idpessoa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidn uihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&\">Clique aqui</a> e responda</p>
					<p align=\"center\" style=\"font-family:arial; font-weight:bold;\"><a href=\"www.appweb.com.br/pesquisa_clima.php?aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&cod=$id_pesquisa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidn uihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&pessoa=$idpessoa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&\"><img src=\"http://www.appweb.com.br/cms/imagens/friero.jpg\" border=\"0\"></a></p>			
					";
					
					
					if (@mail($to, $subject, $msg, $headers)) {
						$quant++;
					}
					
					
				}
				
			alert("$quant E-mails enviados com Sucesso");		
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
				<b>Reenviar Pesquisa de Clima</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="ReenviarPesquisaClima.php?cadastra=1" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
								
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Grupo: </span> </div>
					<select name="id_grupo" id="id_grupo" class="form_style" onchange="buscar_emails(1,this.value)">
						<option value="">Selecione</option>
						<? 	$sql = "SELECT * FROM clima_GrupoEmail ORDER BY nome";
							$result = mysql_query($sql);
							while ($linha = mysql_fetch_assoc($result)) {
						?>
						
						<option value="<?=$linha["id"]?>"><?=$linha["nome"]?></option>
						
						<?}?>
					</select>
				</div>
				
				
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Enviar para todos os emails?: </span> </div>
					<input type="radio" value="1" name="todos" onclick="mostrarEmail(1);"> <span class="label_fonte">Sim</span> <input type="radio" value="2" name="todos" onclick="mostrarEmail(2);"> <span class="label_fonte">Nao</span>
				</div>
				
				<div id="mostrarEmail" style="display:none;">
				
					<div id="linha_form_auto">
						<div id="label"> <span class="label_fonte">Emails: </span> </div>
							<select name="id_email[]" id="id_email" class="form_style" multiple size="20">
							
						</select>
					</div> 
				</div>
				
				
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Pesquisas: </span> </div>
					<select name="id_pesquisa" class="form_style">
						<option value="">Selecione</option>
						<? 	$sql = "SELECT *,date_format(data_enviado, '%d/%m/%Y') as data_formatada FROM pesquisa_enviados ORDER BY data_enviado";
							$result = mysql_query($sql);
							while ($linha = mysql_fetch_assoc($result)) {
								$explode_grupo = explode('|',$linha["codpesquisa"]);
						?>
						
						<option value="<?=$linha["id"]?>"><? echo $linha["data_formatada"]." - ";  $explode_grupo = explode('|',$linha["codgrupo"]); echo $explode_grupo[1]."   -   ";    echo $explode_grupo[1]; ?></option>
						
						<?}?>
					</select>
				</div>
				
				
				<p align="center"><input type="submit" value="Pesquisar" class="form_style"></p>
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
<?if ($frase) {
	alert($frase);
}?>
</html>