<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso
	
$codigo = $_REQUEST['cod'];

	$sql = "SELECT * FROM gerador_tickets_pedidos WHERE id=".$_REQUEST['cod'];
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	$email = $linha["email"];
	


// --- FIM    Efetuando a exlcusao


// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
		$ok =1;
	
			
	$codigo = $_REQUEST['cod'];
				// Validando o E-mail
	if (addslashes(trim($_POST["email"])) == "") {
		$ok = 0;
		$email = addslashes(trim($_POST["email"]));
		$msg_erro= "Preencha o campo E-mail corretamente!";
//	redireciona("gerar_tickets.php");
	} elseif (!validar_email(addslashes(trim($_POST["email"]))))  {
		$ok = 0;
		$msg_erro= "E-mail Inválido!";
	//	redireciona("gerar_tickets.php");
		$email = addslashes(trim($_POST["email"]));
	} else {
		$email = addslashes(trim($_POST["email"]));
	}
	
	
		if(!$ok){
			alert($msg_erro);
			
		}else{
			

$sql = "SELECT
gerador_tickets_pedidos.cnpj,
gerador_tickets_pedidos.nome_cliente,
gerador_tickets_pedidos.email,
gerador_tickets_pedidos.nome_responsavel,
gerador_tickets_pedidos.data_gerado,
date_format(gerador_tickets_pedidos.data_gerado,'%d/%m/%Y - %H:%m' ) AS data_convertida2,
gerador_tickets.num_pedido,
gerador_tickets.numero_ticket
FROM
gerador_tickets
Inner Join gerador_tickets_pedidos ON gerador_tickets_pedidos.id = gerador_tickets.num_pedido WHERE num_pedido = $codigo";
$result = mysql_query($sql);
$linha = mysql_fetch_assoc($result);
$num_rows = mysql_num_rows($result);

if($num_rows > 1){
	$ticktss = "Tickets";
	$s = "s";
}else{
	$ticktss = "Ticket";
	$s = "";
}			
		$num_pedido = $linha["num_pedido"];
		$nome_cliente = $linha["nome_cliente"];
		$nome_cliente = str_ireplace("é","&eacute;",$nome_cliente);
		$nome_cliente = str_ireplace("á","&aacute;",$nome_cliente);
		$nome_cliente = str_ireplace("í","&iacute;",$nome_cliente);
		$nome_cliente = str_ireplace("ú","&uacute;",$nome_cliente);
		$nome_cliente = str_ireplace("ó","&oacute;",$nome_cliente);
		
		$nome_cliente = str_ireplace("ê","&ecirc;",$nome_cliente);
		$nome_cliente = str_ireplace("â","&acirc;",$nome_cliente);
		
		$nome_cliente = str_ireplace("ã","&atilde;",$nome_cliente);
		$nome_cliente = str_ireplace("õ","&otilde;",$nome_cliente);
		$cnpj = $linha["cnpj"];
		$data = $linha["data_convertida2"];
		$nome_responsavel = $linha["nome_responsavel"];
		$email2 = $linha["email"];
		
		$todos_tickets .= "	<table width=\"100%\">
		<tr>";
		
		$sql3 = "
					SELECT
					gerador_tickets.numero_ticket
					FROM
					gerador_tickets
					WHERE num_pedido = $num_pedido order by numero_ticket
				";
				$result3 = mysql_query($sql3);
				
		while ($linha = mysql_fetch_assoc($result3)) {
					$i++;
			$ne_ti =$linha["numero_ticket"];
			$todos_tickets .= "<td width=\"20%\">$ne_ti</td>";
					
				
				
					if ($i == 5) {
						$todos_tickets .= "</tr><tr>";
						$i = 0;
					}
					
					
				}
	$todos_tickets .= "</tr>
		</table>";
	
	
			// Destinario
			$to = "$email";
			// Assunto
			$subject = "APPWeb Commit - Tickets";
			
			// Cabecalho
			$headers = "From: AppWeb Commit <commit@appweb.com.br>\n";
			$headers .= "Reply-To: AppWeb Commit <commit@appweb.com.br>\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=utf-8";
			
			
$msg = "

<table width=\"90%\" border=\"0\" align=\"center\" style=\"font-family: arial; font-size: 12px\">
	<tr>
		<td width=\"177px\"><img src=\"http://www.appweb.com.br/cms/logo_appweb2.jpg\" alt=\"AppWeb\" border=\"0\" /></td>
		<td>&nbsp;&nbsp;</td>
		<td width=\"240px\" align=\"right\"><img src=\"http://www.appweb.com.br/cms/logo_comit.jpg\" alt=\"Comit\" border=\"0\" style=\"float: right\" /></td>
	</tr>

	<tr>
		<td colspan=\"3\">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=\"3\">&nbsp;</td>
	</tr>

	
	<tr>
		<td colspan=\"3\">
		<p><font size=\"2\">Prezado Cliente,</font></p>

 
		<p><font size=\"2\">Conforme o seu pedido, estamos lhe encaminhando $num_rows $ticktss de Acesso ao APP Web - Sistema on-line de Avalia&ccedil;&atilde;o de Potencial e Perfil.</font></p>
		
			
		<p>
		<font size=\"3\" face=\"Arial\"><b>Pedido nº: $num_pedido</b></font><br />
		<font size=\"2\">Cliente: <b>$nome_cliente</b></font><br />
		<font size=\"2\">Respons&aacute;vel: <b>$nome_responsavel</b></font><br />
		<font size=\"2\">E-mail: <b>$email2</b></font><br />
		<font size=\"2\">CNPJ/CPF: <b>$cnpj</b></font><br />
		<font size=\"2\">Data: <b>$data</b>		
		</font></p>

		 <p><font size=\"2\">Para utiliz&aacute;-lo$s basta acessar o site </font><font color=\"Red\" size=\"2\">www.commit.com.br/appweb</font>, <font size=\"2\">preencher o Formul&aacute;rio de Aplica&ccedil;&atilde;o e digitar no campo \"Ticket\" o$s n&uacute;mero$s abaixo:</font>
		</p>
	
		
		
		<p>
		<font color=\"Red\" size=\"4\">Quantidade de tickets: <b>$num_rows</b></font>
		</p>
		
		
		<p><font size=\"2\">
		<b>Número$s do$s Ticket$s:</b></font>
		</p>
		
		
		<p style=\"margin-left: 30px\"><font size=\"2\">
		
		$todos_tickets
				
		</font>
		</p>
		
		
		<p>
		<font color=\"Red\" size=\"2\"><b><i>Importante:</i></b></font> <font size=\"2\">cada numera&ccedil;&atilde;o do Ticket corresponde a uma Avalia&ccedil;&atilde;o.</font>
		</p>
		
		<p>	<font size=\"2\">	
	<b>	A cada avalia&ccedil;&atilde;o efetuada, o sistema APP Web Commit enviar&aacute; um o relat&oacute;rio de an&aacute;lise de potencial para a caixa de e-mails do respons&aacute;vel acima destacado.</b>
		</font></p>
		
		<p>	<font size=\"2\">	
		N&atilde;o hesite em nos contatar para quaisquer outros esclarecimentos atrav&eacute;s da nossa central de atendimento: 0800.17.9988, – em SP (11) 3067.1414.
		</font></p>
		<p>&nbsp;</p>
		
		<p><font size=\"2\">Atenciosamente,</font></p>
		<p>&nbsp;</p>
			
		<p><font size=\"2\">
		<b>Commit Produtos Motivacionais Ltda</b><br />
		appweb@commit.com.br<br />
		www.commit.com.br<br />
		</font>
		</p>
		
		
		</td>
	</tr>


</table>";

if (@mail($to, $subject, $msg, $headers)) {
	//echo ($to."<br>". $subject."<br>". $msg."<br>". $headers);
	alert("Carta Enviada com Sucesso");
	//redireciona("gerar_tickets.php");
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
				<img src="imagens/barr_enviar_email.gif" alt="Enviar E-mail" title="Gerar Ticket" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<form action="enviar_email.php?cadastra=1&cod=<?=$codigo?>" method="post" name="cadastra" enctype="multipart/form-data" onSubmit="return Validar();">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">E-mail: </span> </div><input type="text" size="40" name="email" value="<?=$email;?>" class="form_style" onBlur="is_email();">
			
			</div>	
		

				<p align="center"><input type="submit" value="Enviar Email" class="form_style"></p>
				
				
			
				</div></form>
		
				<!-- INICIO - DIV info fim - Barra de informacao -->
				<div id="info_fim">
				&nbsp;
					</div>
				<!-- INICIO - DIV info fim - Barra de informacao -->	
			
			
			
		
		</div> <!-- FIM DIV PRINCIPAL -->
		 
	</div> <!-- FIM DIV GLOBAL-->
	

</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
<?if ($frase) {
	alert($frase);
}?>
</html>