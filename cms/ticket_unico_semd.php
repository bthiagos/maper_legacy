<?

include("conn.php");

include("library.php");







$email = htmlspecialchars(strip_tags($_POST['email']));

$ticket = htmlspecialchars(strip_tags($_POST['ticket']));



$sql = "

SELECT

gerador_tickets.id,

gerador_tickets.numero_ticket,

gerador_tickets.organizacao,

organizacoes.id,

organizacoes.nome

FROM

gerador_tickets

INNER JOIN organizacoes ON gerador_tickets.organizacao = organizacoes.id

WHERE

gerador_tickets.id='$ticket'

";



$mails = array();



// verifica quantos emails tem na string

if (strpos($email, ";") > 0) {

	$mails = explode(";", $email);

} else {

	$mails[] = $email;	

}



$result = mysql_query($sql);

$linha = mysql_fetch_assoc($result);

$organizacao = utf8_encode($linha["nome"]);

$num_ticket = $linha["numero_ticket"];



		if ($organizacao == "APPWEB") {

		// Corpo do E-mail

		$mensagem = "

			<!DOCTYPE html>

			<html lang=\"en\">

			<head>

				<meta charset=\"UTF-8\">

				<title>Document</title>

				<style type=\"text/css\">

					body {

						margin: 0 0 0 0;

						padding: 0 0 0 0;

						background-color: #e8e9eb;

						font-family: arial;

						font-size: 14px;

						text-align: justify;

						color: #363636;

					}

			

					p {

						margin-top: 25px;

						margin-bottom: 25px;

					}

			

					#box_branco {

						background-color: #ffffff;

						width: 650px;

						height: auto;

						padding: 15px 20px;

						margin-top: 15px;

						margin-bottom: 15px;

						margin: 0 auto;

					}

			

				</style>

			</head>

			<body>

			

				<br/>

				<div id=\"box_branco\">

			

					<img src=\"http://www.mapertest.com.br/img/logo.png\" height=\"60px;\" />

					<hr/>

			

					<p>

						Prezado(a) Participante,

					</p>

			

					<p>

						A Empresa <strong>#NOME-EMPRESA#</strong> gostaria que você completasse uma breve avaliação comportamental.

					</p>

			

					<p>

						Clique no link abaixo ou copie e cole-o na barra do seu navegador:<br/>

						<a href=\"http://perfil.mapertest.com.br/\">http://perfil.mapertest.com.br/</a>

					</p>

			

					<p>

						É recomendável utilizar os navegadores Mozila, Google Chrome ou Safari.

					</p>

			

					<p>

						Você deverá então inserir os dados abaixo:<br/>

						<strong>

						Em \"organização\" escolha \"<strong>#NOME-EMPRESA#</strong>\";<br/>

						Em \"grupo\" favor colocar em \"GRUPO\": ÚNICO;<br/>

						Em \"ticket\" preencha <strong>#NUMTICKET#</strong>

						</strong>

					</p>

			

					<p>

						Não há respostas certas ou erradas. Em momentos de indecisão favor marcar a questão \"menos pior\"

					</p>

			

					<p>

						Visite o site  <a href=\"http://www.mapertest.com.br/\">http://www.mapertest.com.br</a>  para obter mais informações sobre o relatório.

					</p>

			

					<p>

						Cordialmente.

					</p>

			

					<p>

						<strong>#NOME-EMPRESA#</strong>

					</p>

			

					<p>

						Este é um email automático e não é possível respondê-lo. Caso tenha dúvidas relacionadas a ele, por favor, entre em contato com a empresa que lhe enviou o convite. Esta mensagem é direcionada somente ao destinatário. Portanto, cópia, divulgação, distribuição e uso dela pode constituir ilícito civil ou criminal.

					</p>

				

					<hr/>

					<img src=\"http://appweb.com.br/img/logo.png\"  height=\"40px;\"  />

			

				</div>

				<br/>

			

			</body>

			</html>

		";

		} else {



		// Corpo do E-mail

		$mensagem = "

			<!DOCTYPE html>

			<html lang=\"en\">

			<head>

				<meta charset=\"UTF-8\">

				<title>Document</title>

				<style type=\"text/css\">

					body {

						margin: 0 0 0 0;

						padding: 0 0 0 0;

						background-color: #e8e9eb;

						font-family: arial;

						font-size: 14px;

						text-align: justify;

						color: #363636;

					}

			

					p {

						margin-top: 25px;

						margin-bottom: 25px;

					}

			

					#box_branco {

						background-color: #ffffff;

						width: 650px;

						height: auto;

						padding: 15px 20px;

						margin-top: 15px;

						margin-bottom: 15px;

						margin: 0 auto;

					}

			

				</style>

			</head>

			<body>

			

				<br/>

				<div id=\"box_branco\">

			

					<img src=\"https://perfil.mapertest.com.br/aplicacao_img/logo.png\" height=\"60px;\" />

					<hr/>

			

					<p>

						Prezado(a) Participante,

					</p>

			

					<p>

						A Empresa <strong>#NOME-EMPRESA#</strong> gostaria que você completasse uma breve avaliação comportamental.

					</p>

			

					<p>

						Clique no link abaixo ou copie e cole-o na barra do seu navegador:<br/>

						<a href=\"http://perfil.mapertest.com.br/\">http://perfil.mapertest.com.br/
						</a>

					</p>

			

					<p>

						É recomendável utilizar os navegadores Mozila, Google Chrome ou Safari.

					</p>

			

					<p>

						Você deverá então inserir os dados abaixo:<br/>

						<strong>

						Em \"organização\" escolha \"<strong>#NOME-EMPRESA#</strong>\";<br/>

						Em \"grupo\" escolha o GRUPO conforme à sua função;<br/>

						Se for candidato para alguma vaga em \"grupo\" escolha: PROCESSO SELETIVO;<br/>

						Em \"ticket\" preencha <strong>#NUMTICKET#</strong>

						</strong>

					</p>

			

					<p>

						Não há respostas certas ou erradas. Em momentos de indecisão favor marcar a questão \"menos pior\"

					</p>

			

					<p>

						Visite o site  <a href=\"http://www.mapertest.com.br/\">http://www.mapertest.com.br</a>  para obter mais informações sobre o relatório.

					</p>

			

					<p>

						Cordialmente.

					</p>

			

					<p>

						<strong>#NOME-EMPRESA#</strong>

					</p>

			

					<p>

						Este é um email automático e não é possível respondê-lo. Caso tenha dúvidas relacionadas a ele, por favor, entre em contato com a empresa que lhe enviou o convite. Esta mensagem é direcionada somente ao destinatário. Portanto, cópia, divulgação, distribuição e uso dela pode constituir ilícito civil ou criminal.

					</p>

				

					<hr/>

					<img src=\"https://perfil.mapertest.com.br/aplicacao_img/logo.png\"  height=\"40px;\"  />

			

				</div>

				<br/>

			

			</body>

			</html>

		";

		

		}

		

//Replace Tags

include("../perfil/enviar_email.php");

$mensagem = str_replace("#NOME-EMPRESA#", $organizacao, $mensagem);

$mensagem = str_replace("#NUMTICKET#", $num_ticket, $mensagem);


//$mensagem = utf8_decode($mensagem);
	if ($_POST['email']) {
		$para = $_POST['email'];
		$assunto = "MAPER - Perfil Profissional";
		if(enviar_email($para,$assunto,$mensagem,"", "")) {
		//if (sendMail($mails,$mensagem,$nome)) {

			return 1;

		} else {

			return false;

		}

	

	}



?> 