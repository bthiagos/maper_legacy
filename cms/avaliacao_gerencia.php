<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

if($_REQUEST["enviar"] != "")
{
	$enviar = $_REQUEST["enviar"];
	
	$subject = "IPGB";

	$news = mysql_query("SELECT * FROM newsletter");
	while($new = mysql_fetch_array($news))
	{
		$to .= $new["email"].";";
	}
	
	
	$headers = "From: APPWEB - Avaliação de Potencial e Perfil<appweb@appweb.com.br>\n";
	$headers .= "Reply-To: $nome <$email>\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1";
	
	
	$message = mysql_query("SELECT * FROM newsletter_email WHERE id = '$enviar'");
	$message = mysql_fetch_array($message);
	$message = $message["mensagem"];
	   		

	if (@mail($to, $subject, $message, $headers)) {
		echo "<script>alert ('E-mail enviado com sucesso!')</script>";
		redireciona("newsletter_email_gerencia.php");
	}  else{
		echo "<script>alert ('Erro ao Enviar! Por favor tente novamente!')</script>";
		//redireciona("index.php");
	}
}
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM avaliacao WHERE id=".$_REQUEST['cod'];
	$sql2 = "DELETE FROM avaliacao_atividade WHERE id_avaliacao=".$_REQUEST['cod'];
	if (mysql_query($sql) AND mysql_query($sql2)) {
		alert("Avaliação excluída com sucesso!");
	}
	
}

// --- FIM    Efetuando a exlcusao


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
				Gerenciamento de Avaliações
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						
						<td align="center">Título</td>
						<td align="center">Objetivo</td>
						<td align="center">Qtde. de Afirmações</td>
						<td align="center">Criado por</td>
						 <td align="center" width="50">Gerenciar Alternativas</td>
                        <td align="center" width="50">Ações</td>
						
					</tr>
				
					
			<?
				$sql = "SELECT * FROM avaliacao ORDER BY nome ASC";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["nome"]?></td>
						<td align="center" ><?=$linha["objetivo"]?></td>
						<td align="center" ><?=$linha["qtde"]?></td>
						<td align="center" ><?=$linha["criador"]?></td>
						<td align="center" ><a href="avaliacao_alternativas.php?id=<?=$linha["id"]?>">Gerenciar Alternativas</a></td>
						<td align="center" >
							<a href="avaliacao_gerencia_alt.php?p=1&id=<?=$linha["id"]?>"><img src="imagens/icon_editar.gif" alt="Editar" border="0"></a>
							<a href="?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir a mensagem?')" alt="Apagar" border="0"></a></td>
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