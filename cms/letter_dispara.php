<?php
// Inicia sessões
require("conn.php");
$letter = $_REQUEST['cod'];
$grupo = $_POST['grupo'];

?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?
// --- INICIO Efetuando o cadastro
if ($_REQUEST['cod']) {

			$sql = "SELECT * FROM ce_letter WHERE codigo=".$letter;
			//echo $sql;
			$result = mysql_query($sql);
			$newsletter = mysql_fetch_assoc($result);

			// Assunto
			$subject = $newsletter["titulo"];

			$texto_br = $newsletter["msg"];
			$tipo = $newsletter["tipo"];
			$arq = $newsletter["arq"];
			$link = $newsletter["link"];	
            
			$nome = "x";
			$email = "y";
            $headers = "From: IPGB - Inscrição <contato@ipgb.com.br>\n";
			$headers .= "Reply-To: $nome <$email>\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1";
			
			if ($tipo == 1) {	
				
			// Corpo do E-mail
			$message = "
			<html>
				<head>
					<title>APPWEB - ".$newsletter["titulo"]."</title>
				</head>
				
				<body>
					$texto_br
				</body>
			</html>
			";
			
			}
			
			if ($tipo == 3) {
						
    			// Corpo do E-mail
    			$caminho_arquivo = "letter/html/".$arq;
    			$arquivo = fopen("$caminho_arquivo","r");
    			$message = fread($arquivo, filesize("$caminho_arquivo"));
    			fclose($arquivo);		
			}
			
			if ($tipo == 2) {
						
				if ($link == "#") {
					$message = "
					<html>
						<head>
							<title>APPWEB- ".$newsletter["titulo"]."</title>
						</head>
						
						<body>
							<p align='center'><img src='http://www.appweb.com.br/cms/letter/img/$arq' border=0></p>
						</body>
					</html>
					";
				} else {
					
				// Corpo do E-mail
					$message = "
					<html>
						<head>
							<title>APPWEB - ".$newsletter["titulo"]."</title>
						</head>
						
						<body>
							<p align='center'><a href='http://$link'><img src='http://www.appweb.com.br/cms/letter/img/$arq' border=0></a></p>
						</body>
					</html>
					";
				}
			
			}
            
          
			 $cont = 0;
			 $tot = 0;
			 
            require('class.phpmailer.php'); //carrega a classe phpmailer, altere para a pasta onde se encontra o arquivo "class.phpmailer.php"
            $mail = new PHPMailer(); //instancia a classe PHPMailer
            $mail->IsSMTP(); //define que o email será enviado por SMTP
            $mail->SMTPAuth = true;
            //$mail->SMTPSecure = "tls";
            $mail->Port = 587; //define a porta do servidor smtp - altere para a porta que seu servidor usa
            $mail->Host = '216.59.16.52'; //define o servidor smtp - altere para o seu servidor smtp
            //$mail->Host = 'smtp.gmail.com';
            //$mail->Username = 'autenticacao@agenciapenta.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
            //$mail->Password = 'penta2030'; //define a senha do servidor smtp, altere para a sua    
            $mail->Username = 'atendimento@appweb.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
            $mail->Password = 'App2205Ate'; //define a senha do servidor smtp, altere para a sua    
            $mail->SetFrom('app@appweb.com.br', 'APPWEB'); //define o remetente da mensagem, altere para o real
            
            //$mail->AddAddress("thalesu@gmail.com","Thales");
            
            //$mail->AddAddress("leandroliberio@gmail.com","Webmaster");
            
            $contatos = mysql_query("SELECT * FROM ce_contatos WHERE grupo = '$grupo'");
            while($cont = mysql_fetch_array($contatos)) {
                $mail->AddAddress($cont["email"]);
            }
                
            $mail->Subject = $subject; //define o assunto da mensagem
            $mail->MsgHTML($message); //configura o email como HTML
            				
            if ($mail->Send()) {
             
			//echo "<script language=\"javascript\">alert('A sua mensagem foi enviada com sucesso! Obrigado pelo seu contato!');</script>";		
		}
		 
			 
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title><?=titulo_janela();?></title>
<link href="css/css.css" rel="stylesheet" type="text/css" />
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">  

<!-- *** QuickMenu copyright (c) 2007, OpenCube Inc. All Rights Reserved.

	-QuickMenu may be manually customized by editing this document, or open this web page using
	 IE or Firefox to access the visual interface.

-->


<!-- QuickMenu Noscript Support [Keep in head for full validation!] -->
<noscript><style type="text/css">.qmmc {width:200px !important;height:200px !important;overflow:scroll;}.qmmc div {position:relative !important;visibility:visible !important;}.qmmc a {float:none !important;white-space:normal !important;}</style></noscript>


<!--%%%%%%%%%%%% QuickMenu Styles [Keep in head for full validation!] %%%%%%%%%%%-->
<style type="text/css">


/*!!!!!!!!!!! QuickMenu Core CSS [Do Not Modify!] !!!!!!!!!!!!!*/
.qmclear {font-size:1px;height:0px;width:0px;clear:left;line-height:0px;display:block;}.qmmc {position:relative;}.qmmc a {float:left;display:block;white-space:nowrap;}.qmmc div a {float:none;}.qmsh div a{float:left;}.qmmc div {visibility:hidden;position:absolute;}

/*!!!!!!!!!!! QuickMenu Styles [Please Modify!] !!!!!!!!!!!*/



	/* QuickMenu 0 */

	/*"""""""" (MAIN) Container""""""""*/	
	#qm0	
	{	
		background-color:transparent;
	}


	/*"""""""" (MAIN) Items""""""""*/	
	#qm0 a	
	{	
		padding:5px 40px 5px 8px;
		background-color:#FFFFFF;
		color:#000000;
		font-family:Arial;
		font-size:0.8em;
		text-decoration:none;
		border-width:1px;
		border-style:solid;
		border-color:#A6A6A6;
	}


	/*"""""""" (MAIN) Hover State""""""""*/	
	#qm0 a:hover	
	{	
		background-color:#FFFFFF;
	}


	/*"""""""" (MAIN) Parent items""""""""*/	
	#qm0 .qmparent	
	{	
	}


	/*"""""""" (MAIN) Active State""""""""*/	
	body #qm0 .qmactive, body #qm0 .qmactive:hover	
	{	
		background-color:#E6E6E6;
		text-decoration:underline;
	}


	/*"""""""" (SUB) Container""""""""*/	
	#qm0 div	
	{	
		padding:5px;
		margin:-1px 0px 0px 0px;
		background-color:#E6E6E6;
		border-width:1px;
		border-style:solid;
		border-color:#A6A6A6;
	}


	/*"""""""" (SUB) Items""""""""*/	
	#qm0 div a	
	{	
		padding:2px 40px 2px 5px;
		background-color:transparent;
		border-width:0px;
		border-style:none;
		border-color:#000000;
	}


	/*"""""""" (SUB) Hover State""""""""*/	
	#qm0 div a:hover	
	{	
		text-decoration:underline;
	}


	/*"""""""" (SUB) Parent items""""""""*/	
	#qm0 div .qmparent	
	{	
	}


	/*"""""""" (SUB) Active State""""""""*/	
	body #qm0 div .qmactive, body #qm0 div .qmactive:hover	
	{	
		background-color:#FFFFFF;
	}


</style>
<style type="text/css">.qmfv{visibility:visible !important;}.qmfh{visibility:hidden !important;}</style>
<script type="text/javascript" src="codigo.js"></script>


</head>

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
				<img src="imagens/barra_letter_gerencia.gif" alt="Newsletter" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
				
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form">
					<span class="label_fonte">
					<?
						echo "Todos os <strong>$total_todos</strong> e-mails foram enviados com sucesso!";
					
					?>
					</span>
				</div>
	
				
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			

				
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