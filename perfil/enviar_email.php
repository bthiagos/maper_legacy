<?php
function enviar_email($para,$assunto,$mensagem) {
    $para = str_replace(";",",",$para);
    require('../cms/class.phpmailer.php'); //carrega a classe phpmailer, altere para a pasta onde se encontra o arquivo "class.phpmailer.php"
    $mail = new PHPMailer(); //instancia a classe PHPMailer
	$mail->IsSMTP(); //define que o email será enviado por SMTP
    $mail->CharSet = "UTF-8";
	$mail->SMTPAuth = true;
	//$mail->SMTPSecure = "tls";
    $mail->SMTPSecure = "ssl";
	$mail->Port = 465; //define a porta do servidor smtp - altere para a porta que seu servidor usa
    //$mail->Host = 'comlinux3.citis.com.br'; //define o servidor smtp - altere para o seu servidor smtp
    //$mail->Host = 'smtp.gmail.com';
    //$mail->Username = 'autenticacao@agenciapenta.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
    //$mail->Password = 'penta2030'; //define a senha do servidor smtp, altere para a sua    
    //$mail->Username = 'noreply@mapertest.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
    //$mail->Password = 'App2205Ate'; //define a senha do servidor smtp, altere para a sua    
	$mail->SetFrom('naorespondapublix@yahoo.com', 'MAPER'); //define o remetente da mensagem, altere para o real


    $mail->Host       = "smtp.mail.yahoo.com";
    $mail->Username =   "naorespondapublix@yahoo.com";
    $mail->Password =   "eyxagqxhuvjsbaxj";
    
    $para = explode(',',$para); 
    for($i = 0; $i < sizeof($para); $i++) {
        $mail->AddAddress($para[$i]);
    }
    //$mail->AddAddress("sergio@sergiomonteiro.com.br","Contato App");

    
    $mail->Subject = utf8_decode($assunto); //define o assunto da mensagem
    $mail->MsgHTML($mensagem); //configura o email como HTML
					
	if ($mail->Send()) {
	   return true;
    } else {
       return false;
    }
}
?>