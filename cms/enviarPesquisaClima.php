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
	}
	
}


if($_REQUEST["cadastra"]){
	
	$ok = 1;
	
	if($_POST["pesquisa"]){
		$pesquisa = $_POST["pesquisa"];
	}else{
		$ok = 0;		
	}
	
	if($_POST["newsletter"]){
		$newsletter = $_POST["newsletter"];
	}else{
		$ok = 0;		
	}
	
	
	if($_POST["grupo"]){
		$grupo = $_POST["grupo"];
	}else{
		$ok = 0;		
	}
	
	if(!$ok){
		alert("Erro!");
	}else {
		
		$data = date("Y:m:d");
		
		$gruponome = $grupo."|".nome_grupo($grupo);
		$pesquisanome = $pesquisa."|".nome_pesquisa($pesquisa);
		$perguntas = pegar_perguntas($pesquisa);
		$formato_alternativa = formato_alternativa($pesquisa);
		$alternativas = pegar_alternativas($pesquisa);
		$respostas = zerando_respostas($pesquisa);
		
        /*
        $sql = "SELECT pesquisa_alternativas.formato_perguntas, respostas_clima_ticket.resposta FROM
			respostas_clima_ticket
			Inner Join pesquisa_alternativas ON respostas_clima_ticket.id_alternativa = pesquisa_alternativas.id
            Inner Join pesquisa_perguntas ON respostas_clima_ticket.id_pergunta = pesquisa_perguntas.id
			WHERE respostas_clima_ticket.id_pesquisa = $pesquisa ORDER BY pesquisa_perguntas.id";
            
    	$result = mysql_query($sql);	
    	while($linha = mysql_fetch_assoc($result))
        {   

            if($linha["resposta"] != "")
            {
        		// QUESTAO 1 = ABERTA
        		if($linha["formato_perguntas"] == 1){
        			$respostas .= $linha["resposta"]."#";
        		}
        	   
        		// QUESTAO 2 = FECHADA
        		if($linha["formato_perguntas"] == 2){
        			
        			$total = count(explode("|",$linha["alternativas"]));
        			//alert($total);
        			for($i=1;$i<=$total;$i++){
        				$respostas .= $linha["resposta"]."|";
        			}
        			$respostas .= "#";
        		}
            }
    	}
        
        echo $respostas;
        */
		
		$sql = "INSERT INTO pesquisa_enviados (data_enviado,newsletter,codgrupo,codpesquisa,perguntas,formato_alternativa,alternativas,respostas,outra,jarespondidos) VALUES ('$data','$newsletter','$gruponome','$pesquisanome','$perguntas','$formato_alternativa','$alternativas','$respostas','$respostas','1')";	
		mysql_query($sql);
		
		$tituloNews = pegarTituloNews($newsletter);
		$imagemNews = pegarImagemNews($newsletter);
		
		$sql_2 = "SELECT * FROM pesquisa_enviados ORDER BY id desc";
		$result_2 = mysql_query($sql_2);
		$linha_2 = mysql_fetch_assoc($result_2); 
		$id_pesquisa_enviar = $linha_2["id"];
		$respostas2 = $linha_2["respostas"];
		
	
		$sql_pesquisa = "SELECT * FROM pesquisas WHERE id = $pesquisa";
		$result_pesquisa = mysql_query($sql_pesquisa);
		$linha_pesquisa = mysql_fetch_assoc($result_pesquisa); 
		
		$nomePesquisa = $linha_pesquisa["nome"];
		$idPesquisa = $id_pesquisa_enviar;
		
		
			
		$quant = 0;
		$sql_email = "SELECT
			clima_Email.id as idpessoa,
			clima_Email.nome,
			clima_Email.email,
			clima_Email.grupo,
			clima_GrupoEmail.nome as nomeGrupo,
			clima_GrupoEmail.id_organizacao
			FROM
			clima_Email
			Inner Join clima_GrupoEmail ON clima_GrupoEmail.id = clima_Email.grupo WHERE clima_Email.grupo = '$grupo'";
		$result_email = mysql_query($sql_email);
		while($linha_email = mysql_fetch_assoc($result_email)) { 
							
			$idpessoa = $linha_email["idpessoa"];
			salvar_pessoas_enviadas($idPesquisa,$idpessoa,$respostas2);
			
			$email = $linha_email["email"];
			$nome = $linha_email["nome"];
			$nomeGrupo = $linha_email["nomeGrupo"];
			
			
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
			<p>Estamos aplicando este questionário entre todos os funcionários da $nomeGrupo com o objetivo de conhecer a sua opinião sobre alguns aspectos do $nomePesquisa da nossa organização.</p>
			<p><a href=\"www.appweb.com.br/pesquisa_clima.php?cod=$id_pesquisa_enviar&pessoa=$idpessoa\">Clique aqui</a> e participe!</p>
			<p>Agradecemos sua colaboração.</p>		
			";*/
			
			$msg = "
			<p style=\"font-family:arial; font-weight:bold;\">Para visualizar essa mensagem, no Outlook – clique em “Exibir imagens” ou <a href=\"www.appweb.com.br/verEmail.php?aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&cod=$id_pesquisa_enviar&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&pessoa=$idpessoa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidn uihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&\">clique aqui</a> para visualizar.</p>
			<p align=\"center\" style=\"font-family:arial; font-weight:bold;\"><a href=\"www.appweb.com.br/pesquisa_clima.php?aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&cod=$id_pesquisa_enviar&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&pessoa=$idpessoa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidn uihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&\">$tituloNews</a></p>
			<p align=\"center\" style=\"font-family:arial; font-weight:bold;\"><a href=\"www.appweb.com.br/pesquisa_clima.php?aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&cod=$id_pesquisa_enviar&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidn uihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&pessoa=$idpessoa&aaas=fddsaiufdhiuahfuihsufiudisfhduisfhaiuhasndjidnuihahvfnhai9831hvjkr984190c4ujskdkladj8913u48udshmcjkasjhcd9y113y4jkfmhadjfhco8yn184ynhjdfakuc98575134y175y37cds&\"><img src=\"http://www.appweb.com.br/cms/news/$imagemNews\" border=\"0\"></a></p>			
			";			
			
			
			if (@mail($to, $subject, $msg, $headers)) {
				$quant++;
			}
			
		}
		
		alert("$quant E-mails enviados com Sucesso");
		
		
	}
	
}


// --- FIM    Efetuando a exlcusao


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>
<script>
function mostra_valor(){
	
 	var valor = document.getElementById("idpesquisa").value;
 	if(valor != ""){
 		window.open("http://www.appweb.com.br/pesquisa_exemplo.php?cod="+valor);
 	}
	
}

</script>
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
				<b>Enviar Pesquisa de Clima</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="enviarPesquisaClima.php?cadastra=1" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
			<!--<p>
			<div id="linha_form"><span class="label_fonte"><b>ATENÇÃO</b>.Pesquisas com perguntas sem definição ou alternativas não apareceram para o envio.</span></div>
			</p>
			-->
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Pesquisa: </span> </div>
					<select name="pesquisa" class="form_style" id="idpesquisa">
						<option value="">Selecione</option>
						<? 	$sql = "SELECT * FROM pesquisas ORDER BY nome";
							$result = mysql_query($sql);
							while ($linha = mysql_fetch_assoc($result)) {
								
							//$verifica =	verificar_pesquisas($linha["id"]);
							$verifica = 0;
							if($verifica != 1){
						?>						
						<option value="<?=$linha["id"]?>"><?=$linha["nome"]?></option>
							<?}?>
						
						<?}?>
					</select>
				</div>
			
							
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
							
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Newsletter: </span> </div>
					<select name="newsletter" class="form_style">
						<option value="">Selecione</option>
						<? 	$sql = "SELECT * FROM pesquisa_newsletter ORDER BY titulo";
							$result = mysql_query($sql);
							while ($linha = mysql_fetch_assoc($result)) {
						?>
						
						<option value="<?=$linha["id"]?>"><?=$linha["titulo"]?></option>
						
						<?}?>
					</select>
				</div>
				
				<p align="center"><input type="button" onclick="mostra_valor();" value="Ver Pesquisa" class="form_style"> &nbsp; &nbsp;<input type="submit" value="Enviar" class="form_style"></p>
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