<?php include("conn.php"); ?>
<?php include("library.php"); ?>


<?

	if(!isset($_POST['email'])){
		alert("E-mail não inserido");
	   redireciona("index.php");
	}
	else if (isset($_POST['email'])) {
		
		// RECUPERA O NOME DE USUARIO
		
		$email = $_POST['email'];
		
		$select = "SELECT Login FROM ce_usuario WHERE Email='$email' LIMIT 1";
		$query = mysql_query($select) or die(mysql_error());
		
	}
	
	if (mysql_num_rows($query) > 0) {
		
		// GERA SENHA RANDOMICA
		$senha_aux = rand(100000, 999999);
		$senha_md5 = md5($senha_aux);
		
		$nome_usuario = mysql_result($query, 0, 'Login');
		
		// ENVIA EMAIL com a nova senha
		
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
		//$mail->AddAddress("contato@appweb.com.br","Contato App");
		$mail->AddAddress($email,"APPWEB - Esqueci minha senha");

		$men = "
		<table cellspacing='0' cellpadding='0' border='1'>
			<tr>
				<td style='padding: 7px' align='center' bgcolor='#E8E8E8'>Nova senha de usuário</td style='padding: 7px'>
			</tr>
			<tr>
				<td style='padding: 7px' align='center'>
				Seu usuário é: <strong>$nome_usuario</strong><br />
				Sua nova senha é: <strong>$senha_aux</strong><br />
				Quando você efetuar login novamente no sistema, poderá mudar a senha para a de sua escolha na tela inicial do sistema.</td style='padding: 7px'>
			</tr>
		</table>
		";
		
		$mail->Subject = "APP - Sugestão"; //define o assunto da mensagem
		$mail->MsgHTML($men); //configura o email como HTML
						
		if ($mail->Send()) {
			
			// TROCA A SENHA NO BANCO PARA A SENHA RANDOMICA
			$sql = "UPDATE ce_usuario SET Senha='$senha_md5', MudaSenha='1' WHERE Email='$email' LIMIT 1";
			$result = mysql_query($sql) or die(mysql_error());
			
		   alert("Sua sugestão foi enviada com sucesso!");
		   redireciona("index.php");
		} else {
			alert("Erro no envio do email!");
		   redireciona("index.php");
		}
		
	} else {
		alert("E-mail inexistente.");
		redireciona("index.php");
	}
	


// --- FIM    Efetuando o cadastro

?>