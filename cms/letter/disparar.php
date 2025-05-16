<?php
    require('../class.phpmailer.php');
        
    $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>App - Perfil Profissional</title>
</head>

<body>
<img src="http://appweb.com.br/cms/letter/newsletter_app2.jpg" alt="appweb" width="691" height="1230" border="0" usemap="#Map" />
<map name="Map" id="Map">
  <area shape="rect" coords="100,1091,300,1115" href="http://www.youtube.com/watch?v=cWhkPTchKi4&amp;list=PL50739A4A187A44D4&amp;feature=plpp_play_all" target="_blank" alt="inicio_automatico" />
  <area shape="rect" coords="450,1090,639,1115" href="http://www.youtube.com/playlist?list=PL50739A4A187A44D4&amp;feature=mh_lolz" target="_blank" alt="sem_inicio" />
  <area shape="rect" coords="450,777,639,800" href="http://www.youtube.com/watch?v=5curkTkdb7c&amp;feature=plcp" target="_blank" alt="assistir" />
  <area shape="rect" coords="86,1143,173,1157" href="http://www.appweb.com.br" target="_blank" alt="appweb" />
  <area shape="rect" coords="528,1140,588,1155" href="http://www.youtube.com/user/PerfilAPP" target="_blank" alt="canal" />
  <area shape="rect" coords="498,9,544,21" href="http://www.appweb.com.br/cms/letter/appweb2.html" target="_blank" alt="browser" />
</map>
</body>
</html>
';
    $mail = new PHPMailer(); //instancia a classe PHPMailer
    $mail->IsSMTP(); //define que o email será enviado por SMTP
    $mail->SMTPAuth = true; //define que tem autenticação smtp
    $mail->Port = 587;   //define a porta do servidor smtp - altere para a porta que seu servidor usa
    $mail->Host = 'smtp.decorativabh.com.br'; //define o servidor smtp - altere para o seu servidor smtp
    $mail->Username = 'thales@decorativabh.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
    $mail->Password = 'agpenta1'; //define a senha do servidor smtp, altere para a sua   
    $mail->SetFrom('contato@marialuciarodrigues.com', 'APPWEB'); //define o remetente da mensagem, altere para o real
    $mail->AddAddress("thalesu@gmail.com", 'Contato'); 
    $mail->Subject = 'APPWEB - Perfil Profissional'; //define o assunto da mensagem
    $mail->MsgHTML($body); //configura o email como HTML
    $mail->Send();
?>